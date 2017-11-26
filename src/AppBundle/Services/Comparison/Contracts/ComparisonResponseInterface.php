<?php
declare(strict_types=1);


namespace AppBundle\Services\Comparison\Contracts;


interface ComparisonResponseInterface
{
    public function getArrayResponse(): array;
}