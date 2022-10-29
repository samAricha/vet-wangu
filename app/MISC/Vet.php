<?php
namespace App\MISC;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

require ('../vendor/autoload.php');

class Vet{

    private $text;
    private $level;
    private $ussd_string_exploded;
    

    private $response = 'Sorry the app is not working currently, our engineers are working 
    on the problem. We sincerely apologize';

    public function __construct($text, $level, $ussd_string_exploded){
        $this->text = $text;
        $this->level = $level;
        $this->ussd_string_exploded = $ussd_string_exploded;
    }
  
    public function display(){
        if ($this->text == "") {
            // first response when a user dials ussd code
            $this->response  = "CON Welcome to VetWangu/Mkulima Mjanja\n";
            $this->response .= "1. Personal Vet \n";
            $this->response .= "2. Request Vet \n";
            $this->response .= "3. Buy Products \n";
            $this->response .= "4. About VetWangu \n";
        }elseif ($this->level == 1) {
            $this->personalVet();
        }elseif ($this->text == "2") {
            $this->requestVet();
        }elseif ($this->text == "3") {
            $this->vetShop();
        }elseif ($this->text == "4") {
            $this->response = "END Tunahakikisha wewe kama Mkulima Mjanja unaendeleza Kilimo Biashara bila Noma.";
        }elseif ($this->text == "22") {
            $variable = $this->ussd_string_exploded[0];
            $this->response = "testing:$variable";
        }else{
        $this->response = "END please select a viable number";
        }

        // send your response back to the API
        header('Content-type: text/plain');
        return $this->response;
    }

    function personalVet(){
        $this->response = "CON Please select a service... \n";
        $this->response .= "1. Urgent Service \n";
        $this->response .= "2. Book Appointment \n\n";
        $this->response .= "98. Back \n";
        $this->response .= "00. Main \n";
         
    }

    function requestVet(){
        $this->response = "CON Please select a service... \n";
        $this->response .= "1. Body Check \n";
        $this->response .= "2. Specific Request \n\n";
        $this->response .= "98. Back \n";
        $this->response .= "00. Main \n";
         
    }

    function vetShop(){
        $this->response = "CON Please select a service... \n";
        $this->response .= "1. Buy Medication \n";
        $this->response .= "2. Call Vet Shop \n\n";
        $this->response .= "98. Back \n";
        $this->response .= "00. Main \n";       
    }


}