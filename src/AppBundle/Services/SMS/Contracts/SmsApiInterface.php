<?php
declare(strict_types=1);


namespace AppBundle\Services\SMS\Contracts;


/**
 * Interface SmsApiInterface
 * @package AppBundle\Services\SMS\Contracts
 */
interface SmsApiInterface
{
    /**
     * @param array $data
     */
    public function sendMessage(array $data): void;
}