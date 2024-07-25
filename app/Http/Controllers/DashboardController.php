<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Donatur;
use App\Models\Fundraiser;
use App\Models\Fundraising;
use App\Models\FundraisingPhase;
use App\Models\FundraisingWithdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 

class DashboardController extends Controller
{
    //
    public function apply_fundraiser(){

        $user = Auth::user();
        
        DB::transaction(function() use ($user){

            $validated['user_id'] = $user->id;
            $validated['is_active'] = false;

            Fundraiser::create($validated);
        });

        return redirect()->route('admin.fundraisers.index');
    }

    public function my_withdrawals(){
        $user = Auth::user();
        $fundraiserId = $user->fundraiser->id;

        $withdrawals = FundraisingWithdrawal::where('fundraiser_id', $fundraiserId)->orderByDesc('id')->get();

        return view('admin.my_withdrawals.index', compact('withdrawals'));
    }

    public function my_withdrawals_details(FundraisingWithdrawal $fundraisingWithdrawal, FundraisingPhase $fundraisingPhase){

        return view('admin.my_withdrawals.details', compact('fundraisingWithdrawal', 'fundraisingPhase'));
    }

    public function index(){
        $user = Auth::user();

        $fundraisingsQuery = Fundraising::query(); 
        $withdrawalsQuery = FundraisingWithdrawal::query(); 

        if($user->hasRole('fundraiser')){
            $fundraiserId = $user->fundraiser->id;

            $fundraisingsQuery->where('fundraiser_id', $fundraiserId);
            $withdrawalsQuery->where('fundraiser_id', $fundraiserId);

            $fundraiserIds = $fundraisingsQuery->pluck('id');

            $donaturs = Donatur::whereIn('fundraising_id', $fundraiserIds)
            ->where('is_paid', true)
            ->count();

        }else{
            $donaturs = Donatur::where('is_paid', true)
            ->count();
        }

        $fundraisings = $fundraisingsQuery->count();
        $withdrawals = $withdrawalsQuery->count();
        $categories = Category::count();
        $fundraisers = Fundraiser::count();

        return view('dashboard', compact('donaturs', 'fundraisings', 'categories', 'withdrawals', 'fundraisers'));


    


    }
}
