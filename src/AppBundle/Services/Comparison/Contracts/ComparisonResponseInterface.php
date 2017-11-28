<?php
declare(strict_types=1);


namespace AppBundle\Services\Comparison\Contracts;


/**
 * Interface ComparisonResponseInterface
 * @package AppBundle\Services\Comparison\Contracts
 */
interface ComparisonResponseInterface
{
    /**
     * @return array
     */
    public function getArrayResponse(): array;
}