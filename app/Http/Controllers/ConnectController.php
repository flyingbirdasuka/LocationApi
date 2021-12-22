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
        // $user_ip = getenv('REMOTE_ADDR');
        // $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));
        // $country = $geo["geoplugin_countryName"];
        // $city = $geo["geoplugin_city"];


        $client = new Client();
        $key = '91e0f66d8b0564cb1cca47d0f4e9c19b';
        $city= 'Malta';
        $response = $client->get('api.openweathermap.org/data/2.5/weather?q='.$city.'&appid='.$key);
        $items = json_decode($response->getBody()->getContents());


        // dd($item);
        // $items = $item->weather[0];
        // dd($items);
        // dd($items->main);
        
        $tripInfo = $this->getTripInfo($city);

        $items->tripInfo = $tripInfo;
      
        return view('index')->with('items', $items);
     
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
        $client = new Client();
        $key = '91e0f66d8b0564cb1cca47d0f4e9c19b';
        $city= $request->input('location');
        $response = $client->get('api.openweathermap.org/data/2.5/weather?q='.$city.'&appid='.$key);
        $items = json_decode($response->getBody()->getContents());
        // $items = $item->weather[0];

        $tripInfo = $this->getTripInfo($city);

        $items->tripInfo = $tripInfo;


         
        return view('index')->with('items', $items);
    }

    private function getTripInfo($city)
    {
        $client = new Client();
        $key = '5ae2e3f221c38a28845f05b69899600061604e9fe0ca12954424880e';

        // https://api.opentripmap.com/0.1/en/places/geoname?name=london&apikey=

        $response = $client->get('https://api.opentripmap.com/0.1/en/places/geoname?name='.$city.'&apikey='.$key);
        $location = json_decode($response->getBody()->getContents(), true);

        // var_dump($location["lon"]);
        // var_dump($location->lon);
        // var_dump($location["lon"]);
        // $location["lat"];
        // $location["lon"];
        
        $limit = 5;

        //https://api.opentripmap.com/0.1/en/places/radius?radius=1000&lon=-0.12574&lat=51.50853&apikey=5ae2e3f221c38a28845f05b69899600061604e9fe0ca12954424880e

        $response = $client->get('https://api.opentripmap.com/0.1/en/places/radius?radius=1000&lon='.$location["lon"].'&lat='.$location["lat"].'&apikey='.$key . '&limit=' . $limit);

       // dd($response->getBody()->getContents());

        return json_decode($response->getBody()->getContents());

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
