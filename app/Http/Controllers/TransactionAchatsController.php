<?php

namespace App\Http\Controllers;

use App\Models\transaction_achats;
use Illuminate\Http\Request;

class TransactionAchatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\transaction_achats  $transaction_achats
     * @return \Illuminate\Http\Response
     */
    public function show(transaction_achats $transaction_achats)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\transaction_achats  $transaction_achats
     * @return \Illuminate\Http\Response
     */
    public function edit(transaction_achats $transaction_achats)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\transaction_achats  $transaction_achats
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, transaction_achats $transaction_achats)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\transaction_achats  $transaction_achats
     * @return \Illuminate\Http\Response
     */
    public function destroy(transaction_achats $transaction_achats)
    {
        //
    }
}
