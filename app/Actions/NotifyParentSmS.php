<?php
namespace App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;

class NotifyParentSmS
{
    use AsAction;

    public function handle($tel, $content){
        $curl = curl_init();
        curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.ycloud.com/v1/sms/send_messages",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{\"mobile\":\"".$profile['contacttel']."\",\"text\":\"".$data['content']."\"}",
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "X-API-Key: 486d00ff7405ba996754289c1b40a755"
        ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
        echo $response;
        }
    }

}
