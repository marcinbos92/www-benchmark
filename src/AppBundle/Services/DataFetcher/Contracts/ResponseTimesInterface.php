<?php
declare(strict_types=1);


namespace AppBundle\Services\DataFetcher\Contracts;


interface ResponseTimesInterface
{
    public function getTotalTime(): float;
}