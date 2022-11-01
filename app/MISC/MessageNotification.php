<?php
namespace App\MISC;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Twilio\Rest\Client;

class MessageNotification{
    public function _construct(){}

    public function sendMessage($receiver, $message){
       /* $this->validate($request, [
            'receiver' => 'required|max:15',
            'message' => 'required|min:5|max:155',
        ]);*/
 
        try {
            $accountSid = "AC36ea970d2097c40faaf519ebca5cf08f";
            $authToken = "9d17834848107992ddf84981f1cc7376";
            $twilioNumber = "+19257095410";
            
 
            $client = new Client($accountSid, $authToken);
 
            $client->messages->create($receiver, [
                'from' => $twilioNumber,
                'body' => $message
            ]);
 
            return back()
            ->with('success','Sms has been successfully sent.');
 
        } catch (Exception $e) {
            dd($e->getMessage());
            return back()
            ->with('error', $e->getMessage());
        }
    }
}
