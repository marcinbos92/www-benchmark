<?php
declare(strict_types=1);


namespace AppBundle\Services\SMS;


use AppBundle\Services\SMS\Contracts\SmsApiInterface;

class SmsApi implements SmsApiInterface
{
    public function sendMessage(array $data): void
    {
        /**
         * Dummy class for sending SMS message
         */
        var_dump("SMS WAS SENT at " . date('Y-m-d H:i:s'));
    }

}