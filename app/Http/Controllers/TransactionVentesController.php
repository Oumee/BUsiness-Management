<?php

namespace App\Http\Controllers;

use App\Models\transaction_ventes;
use Illuminate\Http\Request;

class TransactionVentesController extends Controller
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
     * @param  \App\Models\transaction_ventes  $transaction_ventes
     * @return \Illuminate\Http\Response
     */
    public function show(transaction_ventes $transaction_ventes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\transaction_ventes  $transaction_ventes
     * @return \Illuminate\Http\Response
     */
    public function edit(transaction_ventes $transaction_ventes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\transaction_ventes  $transaction_ventes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, transaction_ventes $transaction_ventes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\transaction_ventes  $transaction_ventes
     * @return \Illuminate\Http\Response
     */
    public function destroy(transaction_ventes $transaction_ventes)
    {
        //
    }
}
