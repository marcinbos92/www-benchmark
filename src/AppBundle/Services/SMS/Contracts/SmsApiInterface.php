<?php
declare(strict_types=1);


namespace AppBundle\Services\SMS\Contracts;


interface SmsApiInterface
{
    public function sendMessage(array $data): void;
}