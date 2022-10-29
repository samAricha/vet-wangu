<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MISC\Vet;


class MyVetController extends Controller
{
    public function index(Request $request){
        $sessionId   = $request->get('session_id');
        $serviceCode = $request->get('serviceCode');
        $phoneNumber = $request->get('phoneNumber');
        $text        = $request->get('text');
        $ussd_string_exploded = explode("*", $text);// use explode to split the string text response from Africa's talking gateway into an array.
        $level = count($ussd_string_exploded);// Get ussd menu level number from the gateway

        $vet = new Vet($text,$level, $ussd_string_exploded, $phoneNumber);
        $response = $vet->display();
        echo $response;
    }
}
