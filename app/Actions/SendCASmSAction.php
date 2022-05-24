<?php
namespace App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Http;

class SendCASmSAction{
    use AsAction;

    public function handle($message, $phone)
    {
        
    }
}
