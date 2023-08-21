<?php
namespace App\Helpers\Classes;

class FcmNotification
{
    public $fcm_topic = '';
    public $fcm_title = '';
    public $fcm_body = '';
    public $fcm_type = 'general'; // 'general' or 'chat'

    public function topic($topic){
        $this->fcm_topic = $topic;
    }
    public function title($title){
        $this->fcm_title = $title;
    }
    public function body($body){
        $this->fcm_body = $body;
    }
    public function type($type){
        $this->fcm_type = $type;
    }

    public function send(){
        $topic = $this->fcm_topic;
        $title = $this->fcm_title;
        $body = $this->fcm_body;
        $retn = 'failed..!';
        if(!empty($topic) and !empty($title) and !empty($body)){
            $url = 'https://fcm.googleapis.com/fcm/send';
            $fields = array(
                "to"=>"/topics/".$topic,
                "notification" => array(
                    "body" => $body,
                    "title" => $title,
                    "icon" => 'notify_icon',
                    "color" => '#EC1B26',
                ),
                "data" => array(
                    "notification_type" => $this->fcm_type
                )
            );
            $fields = json_encode ( $fields );
            $headers = array (
                    'Authorization: key=' . "AAAAxvoebEo:APA91bHeRF-2AcX3c6hqoBvPsQgFqyZUkPmY21yfsXyfDLh92RrmYg6_YYtTJ_oDtFXk8-sZnpdRnuO5MWo3xg8NrExNhTCaoIoHK5xmgYz_uWzsNWZhdcqcyeFW2712Px2M1GMSSmsJ",
                    'Content-Type: application/json'
            );
            $ch = curl_init ();
            curl_setopt ( $ch, CURLOPT_URL, $url );
            curl_setopt ( $ch, CURLOPT_POST, true );
            curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
            curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
            $result = curl_exec ($ch);
            curl_close ($ch);
            $retn = true;
        }else{
            $retn = 'Something is missing..!';
        }
        return $retn;
    }
}
