<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDonationRequest;
use App\Models\Category;
use App\Models\Donatur;
use App\Models\Fundraising;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    //
    public function index(){
        $categories = Category::all();
        $fundraisings = Fundraising::with(['category', 'fundraiser'])
        ->where('is_active', 1)
        ->orderByDesc('id')
        ->get();

        return view('front.views.index', compact('categories', 'fundraisings'));
    }   

    public function category(Category $category){
        return view('front.views.category', compact('category'));
    }

    public function details(Fundraising $fundraising){

        $goalReached = $fundraising->totalReachedAmount() >= $fundraising->target_amount;
        return view('front.views.details', compact('fundraising', 'goalReached'));
    }

    public function support(Fundraising $fundraising){
        return view('front.views.donation', compact('fundraising'));
    }
    
    public function checkout(StoreDonationRequest $request, Fundraising $fundraising, Donatur $donatur){
        $data = $request->only('name', 'phone_number', 'notes', 'amount');

        $donatur = null;

        DB::transaction(function() use ($request, $fundraising, &$donatur) {

            $validated = $request->validated();

            $validated['fundraising_id'] = $fundraising->id;
            $validated['proof'] = $validated['name'];
            $validated['total_amount'] = $validated['amount'];
            $validated['is_paid'] = false;
            
            $donatur = Donatur::create($validated);

        });
        
        if (!$donatur) {
            // Handle the error, e.g., by redirecting back with an error message
            return redirect()->back()->with('error', 'There was an error processing your donation.');
        }
    

        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $donatur->id,
                'gross_amount' => $donatur->total_amount,
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $donatur->update(['proof' => $snapToken]);
        return view('front.views.checkout', compact('fundraising', 'snapToken', 'donatur'));
    }

    public function callback(Request $request){
        $serverKey = config('midtrans.serverKey');
        $hashed = hash('sha512', $request->order_id.$request->status_code.$request->gross_amount.$serverKey);
        if($hashed == $request->signature_key){
            if($request->transaction_status == 'capture' || $request->transaction_status == 'settlement'){
                $donatur = Donatur::find($request->order_id);
                $donatur->update(['is_paid' => true]);
            }
        }
    }

    public function invoice(Donatur $donatur){
        return view('front.views.invoice', compact('donatur'));
    }


    // public function store(StoreDonationRequest $request, Fundraising $fundraising, $totalAmountDonation){

    //     DB::transaction(function() use ($request, $fundraising,$totalAmountDonation) {

    //         $validated = $request->validated();

    //         if($request->hasFile('proof')){
    //             $proofPath = $request->file('proof')->store('proofs', 'public');
    //             $validated['proof'] = $proofPath;
    //         }

    //         $validated['fundraising_id'] = $fundraising->id;
    //         $validated['total_amount'] = $totalAmountDonation;
    //         $validated['is_paid'] = false;
            
    //         $donatur = Donatur::create($validated);

    //     });

    //     return redirect()->route('front.details', $fundraising->slug);
    // }
    
}
