<?php

namespace App\Http\Controllers;

use App\Models\BusTransport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
class BusTransportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('bus_list');
        
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
    public function show($id='')
    {
        return view('bus');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BusTransport $busTransport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BusTransport $busTransport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BusTransport $busTransport)
    {
        //
    }
}
