<?php
namespace App\MISC;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Twilio\Rest\Client;

class MessageNotification{
    public function _construct(){}

    public function sendMessage($receiver, $message, $merchant_phone){
        /*$this->validate($request, [
            'receiver' => 'required|max:15',
            'message' => 'required|min:5|max:155',
        ]);*/
 
        try {
            $accountSid = getenv("TWILIO_SID");
            $authToken = getenv("TWILIO_TOKEN");
            $twilioNumber = getenv("TWILIO_FROM");
 
            $client = new Client($accountSid, $authToken);
 
            $client->messages->create($receiver, [
                'from' => $twilioNumber,
                'body' => $message
            ]);
 
            return back()
            ->with('success','Sms has been successfully sent.');
 
        } catch (\Exception $e) {
            dd($e->getMessage());
            return back()
            ->with('error', $e->getMessage());
        }
    }
}
