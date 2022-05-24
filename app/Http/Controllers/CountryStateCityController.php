<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

class CountryStateCityController extends Controller
{
    public function countryIndex(){
        $countries = Country::all();
        return response()->json($countries);
    }

    public function stateIndex(){
        $state = State::all();
        return response()->json($state);
    }
    public function country(Request $request){
        $data = $request->all();
        $country = new Country();
        $country->country = $data['country'];
        $country->save();
        return response()->json('Country Added');
    }

    public function state(Request $request){
        $data = $request->all();
        $state = new State();
        $state->state = $data['state'];
        $state->countryid = $data['countryid'];
        $state->save();
        return response()->json('State Added');
    }

    public function city(Request $request){
        $data = $request->all();
        $city = new City();
        $city->stateid = $data['stateid'];
        $city->city = $data['city'];
        $city->save();
        return response()->json('City Added');
    }

    public function deleteCountry($id){
        Country::findOrFail($id)->delete();
        return response()->json('country deleted');
    }

    public function deleteState($id){
        State::findOrFail($id)->delete();
        return response()->json('state deleted');
    }

    public function deleteCity($id){
        City::findOrFail($id)->delete();
        return response()->json('state deleted');
    }
}
