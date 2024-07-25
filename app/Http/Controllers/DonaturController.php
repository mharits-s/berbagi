<?php

namespace App\Http\Controllers;

use App\Models\Donatur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DonaturController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $donaturs = Donatur::with(['fundraising'])->orderByDesc('id')->paginate(100);

        return view('admin.donaturs.index', compact('donaturs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(donatur $donatur)
    {
        //
        return view('admin.donaturs.show', compact('donatur'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(donatur $donatur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, donatur $donatur)
    {
        //
        DB::transaction(function() use ($donatur){
            $donatur->update([
                'is_paid' => true,
            ]);
        });

        return redirect()->route('admin.donaturs.show', $donatur); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(donatur $donatur)
    {
        //
    }
}
