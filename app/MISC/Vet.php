<?php
namespace App\MISC;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\MISC\MessageNotification;

require ('../vendor/autoload.php');

class Vet{

    private $text;
    private $level;
    private $ussd_string_exploded;
    private $phone_number;
    

    private $response = 'Sorry the app is not working currently, our engineers are working 
    on the problem. We sincerely apologize';

    public function __construct($text, $level, $ussd_string_exploded, $phone_number){
        $this->text = $text;
        $this->level = $level;
        $this->phone_number = $phone_number;
        $this->ussd_string_exploded = $ussd_string_exploded;
    }
  
    public function display(){
        if ($this->text == "") {
           $this->opening();
        }elseif ($this->ussd_string_exploded[0] == 1) {
            $this->personalVet();
        }elseif ($this->ussd_string_exploded[0] == 2) {
            $this->requestVet();
        }elseif ($this->ussd_string_exploded[0] == 3) {
            $this->vetShop();
        }elseif ($this->text == "4") {
            $this->response = "END Tunahakikisha wewe kama Mkulima Mjanja unaendeleza Kilimo Biashara bila Noma.";
        }elseif ($this->text == "98") {
            $this->opening();
        }elseif ($this->text == "00") {
            $this->opening();
        }elseif ($this->text == "22") {
            $this->displayWards(2, 1);
        }elseif ($this->text == "44") {
            $message = new MessageNotification();
            $message->sendMessage("+254708392326", "hii");
        }else{
        $this->response = "END please select a viable number";
        }

        // send your response back to the API
        header('Content-type: text/plain');
        return $this->response;
    }

    function opening(){
        // first response when a user dials ussd code
        $this->response  = "CON Welcome to VetCare/Mkulima Mjanja\n";
        $this->response .= "1. Personal Vet \n";
        $this->response .= "2. Request Vet \n";
        $this->response .= "3. Buy Products \n";
        $this->response .= "4. About VetCare \n";
    }

    function personalVet(){
        if($this->level == 1){
            $this->response = "CON Personal Vet Services... \n";
            $this->response .= "1. Urgent Service \n";
            $this->response .= "2. Book Appointment \n";
            $this->response .= "3. Consultation from Vet \n\n";
            $this->response .= "98. Back \n";
            $this->response .= "00. Main \n";
        }elseif($this->level == 2){
            $this->displayCounties();
        }elseif($this->level == 3){
            $this->displayConstituencies($this->ussd_string_exploded[2]);
        }elseif($this->level == 4){
            $this->displayWards($this->ussd_string_exploded[2], $this->ussd_string_exploded[3]);
        }elseif($this->level == 5){
            $this->availableVets();
        }elseif($this->level = 6){
            $this->response = "END You will be contacted by your Vet... \n";
            $message = new MessageNotification();
            $message->sendMessage("+254708392326", "$this->phone_number requests your services");
        }        
    }

    function requestVet(){
        if($this->level == 1){
            $this->response = "CON Please select a service... \n";
            $this->response .= "1. Urgent Service \n";
            $this->response .= "2. Book Appointment \n";
            $this->response .= "3. Consultation from Vet \n\n";
            $this->response .= "98. Back \n";
            $this->response .= "00. Main \n";
        }elseif($this->level == 2){
            $this->displayCounties();
        }elseif($this->level == 3){
            $this->displayConstituencies($this->ussd_string_exploded[2]);
        }elseif($this->level == 4){
            $this->displayWards($this->ussd_string_exploded[2], $this->ussd_string_exploded[3]);
        }elseif($this->level == 5){
            $this->response = "END You will be contacted by the nearest Vetenary... \n";
            $message = new MessageNotification();
            $message->sendMessage("+254708392326", "$this->phone_number requests your services");
            $this->availableVets();
        }elseif($this->level == 6){
            $this->response = "END You will be contacted by the nearest Vetenary... \n";
            $message = new MessageNotification();
            $message->sendMessage("+254708392326", "$this->phone_number requests your services");
        }
         
    }

    function vetShop(){
        if($this->level == 1){
            $this->response = "CON Please select a product... \n";
            $this->response .= "1. Fertiliser \n";
            $this->response .= "1. Seeds \n";
            $this->response .= "2. Medicine \n\n";
            $this->response .= "98. Back \n";
            $this->response .= "00. Main \n";
        }elseif($this->level == 2){
            $this->displayCounties();
        }elseif($this->level == 3){
            $this->displayConstituencies($this->ussd_string_exploded[2]);
        }elseif($this->level == 4){
            $this->displayWards($this->ussd_string_exploded[2], $this->ussd_string_exploded[3]);
        }elseif($this->level == 5){
            $this->availableVetShops();
        }elseif($this->level == 6){
            $this->response = "END You will be contacted by the nearest VetShop... \n";
            $message = new MessageNotification();
            $message->sendMessage("+254708392326", "$this->phone_number requests your services");
        }
    }

    function availableVetShops(){
        $this->response = "END Available Vet Shops will contact you... \n";
        $county = $this->ussd_string_exploded[2];
        $constituency = $this->ussd_string_exploded[3];
        $ward = $this->ussd_string_exploded[4];
        $results = DB::select("SELECT * FROM vet_shops WHERE county= $county and constituency=$constituency )");
        
        $i = 0;
        foreach($results as $result){
            $i++; 
            $this->response .= $i.". ".$result -> name. "\n";
        }
        $message = new MessageNotification();
        $message->sendMessage("+254708392326", "$this->phone_number requests your services");

    }

    function availableVets(){
        $this->response = "END Available Vet will contact you... \n";
        $county = $this->ussd_string_exploded[2];
        $constituency = $this->ussd_string_exploded[3];
        $ward = $this->ussd_string_exploded[4];
        $results = DB::select("SELECT * FROM vets WHERE county= $county AND constituency=$constituency");
        
        $i = 0;
        foreach($results as $result){
            $i++; 
            $this->response .= $i.". ".$result -> name. "\n";
        }
        $message = new MessageNotification();
        $message->sendMessage("+254708392326", "$this->phone_number requests your services");
    }



    function displayCounties(){
        $this->response = "CON Please choose your county... \n";
        $results = DB::select("SELECT * FROM counties");
        
        $i = 0;
        foreach($results as $result){
            $i++; 
            $this->response .= $i.". ".$result -> name. "\n";
        }  

    }
    function displayConstituencies($countyId){
        $this->response = "CON Please choose your Constituency? \n";
        $results = DB::select("SELECT * FROM constituencies WHERE county = $countyId");

        $i = 0;
        foreach($results as $result){
            $i++; 
            $this->response .= $i.". ".$result -> name. "\n";
        }   
    }
    function displayWards($countyId, $constituencyId){
        $this->response = "CON Please choose your Ward? \n";
        $results = DB::select("SELECT * FROM wards WHERE  county_no = $countyId and constituency_no = $constituencyId");

        $i = 0;
        foreach($results as $result){
            $i++; 
            $this->response .= $i.". ".$result -> name. "\n";
        }    

    }


}