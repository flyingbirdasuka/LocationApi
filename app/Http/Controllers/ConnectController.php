<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ConnectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $client = new Client();
        $key = '91e0f66d8b0564cb1cca47d0f4e9c19b';
        $city= 'Malta';
        $response = $client->get('api.openweathermap.org/data/2.5/weather?q='.$city.'&appid='.$key);
        $items = json_decode($response->getBody()->getContents());

        $tripInfo = $this->getTripInfo($city);

        $items->tripInfo = $tripInfo;
      
        return view('index')->with('items', $items);
     
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client = new Client();
        $key = '91e0f66d8b0564cb1cca47d0f4e9c19b';
        $city= $request->input('location');
        $response = $client->get('api.openweathermap.org/data/2.5/weather?q='.$city.'&appid='.$key);
        $items = json_decode($response->getBody()->getContents());
        $tripInfo = $this->getTripInfo($city);

        $items->tripInfo = $tripInfo;

        return view('index')->with('items', $items);
    }

    private function getTripInfo($city)
    {
        $client = new Client();
        $key = '5ae2e3f221c38a28845f05b69899600061604e9fe0ca12954424880e';
        $response = $client->get('https://api.opentripmap.com/0.1/en/places/geoname?name='.$city.'&apikey='.$key);
        $location = json_decode($response->getBody()->getContents(), true);

        $limit = 5;

        $response = $client->get('https://api.opentripmap.com/0.1/en/places/radius?radius=1000&lon='.$location["lon"].'&lat='.$location["lat"].'&apikey='.$key . '&limit=' . $limit);
        return json_decode($response->getBody()->getContents());

    }

}
