<?php
declare(strict_types=1);


namespace Tests\AppBundle\Services\Schema;


use AppBundle\Services\Schema\Url;
use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{
    public function testUrlObject(): void
    {
        $url = new Url('http://interia.pl');

        $this->assertInternalType('string', $url->getUrl());
    }
}