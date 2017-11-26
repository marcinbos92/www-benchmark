<?php
declare(strict_types=1);


namespace Tests\AppBundle\Services\RequestProcessing;


use AppBundle\Services\RequestProcessing\Requests;
use AppBundle\Services\Schema\Input;
use AppBundle\Services\Schema\Url;
use PHPUnit\Framework\TestCase;

class RequestsTest extends TestCase
{

    private $result;

    public function testRequestsProcessing(): void
    {
        $requests = new Requests();

        $callback = function($data, $info)
        {
            $this->result[] = $info;
        };

        $input = new Input(new Url('http://mbosweb.pl'));
        $input->addCompetitorUrl(new Url('dsads'))->addCompetitorUrl(new Url('mbosweb.pl'));

        $requests->process($input->getCompetitorUrls(), $callback);
        $this->assertInternalType('array', $this->result);
        $this->assertSame(2, \count($this->result));

        unset($this->result);

        $requests->process([$input->getSourceUrl()], $callback);
        $this->assertInternalType('array', $this->result);
        $this->assertSame(1, \count($this->result));
    }
}