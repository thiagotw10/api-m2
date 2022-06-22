<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class CityController extends Controller
{


    public function __construct()
    {
        // $this->user = JWTAuth::parseToken()->authenticate();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return City::paginate();
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Models\City  $city
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show(City $city)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Models\City  $city
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit(City $city)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Models\City  $city
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, City $city)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Models\City  $city
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(City $city)
    // {
    //     //
    // }
}
