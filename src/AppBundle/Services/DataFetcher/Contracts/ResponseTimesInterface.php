<?php
declare(strict_types=1);


namespace AppBundle\Services\DataFetcher\Contracts;


interface ResponseTimesInterface
{
    public function getTotalTime(): float;
//    public function getNameLookUp(): float;
//    public function getConnect(): float;
//    public function getAppConnect(): float;
//    public function getPreTransfer(): float;
//    public function getRedirect(): float;
//    public function getStartTransfer(): float;
}