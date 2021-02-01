<?php

namespace MetaverseSystems\ClarionPHPBackend\Controllers;

use MetaverseSystems\ClarionPHPBackend\Models\StoreApp;
use MetaverseSystems\ClarionPHPBackend\Models\StoreAppPackage;
use Illuminate\Http\Request;

class StoreAppController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apps = StoreApp::get();
        return $apps;
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
    }

    /**
     * Display the specified resource.
     *
     * @param  StoreApp  $storeApp
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $storeApp = StoreApp::find($id)->with('packages')->get();
        return $storeApp;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  StoreApp  $storeApp
     * @return \Illuminate\Http\Response
     */
    public function edit(StoreApp $storeApp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  StoreApp  $storeApp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StoreApp $storeApp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  StoreApp  $storeApp
     * @return \Illuminate\Http\Response
     */
    public function destroy(StoreApp $storeApp)
    {
        //
    }
}
