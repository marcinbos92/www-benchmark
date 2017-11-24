<?php
declare(strict_types=1);


namespace Tests\AppBundle\Services\RequestProcessing;


use AppBundle\Services\RequestProcessing\Requests;
use AppBundle\Services\Schema\Input;
use AppBundle\Services\Schema\Url;
use PHPUnit\Framework\TestCase;

class RequestsTest extends TestCase
{
    public function testRequestsProcessing(): void
    {
        $requests = new Requests();

        $callback = function($data, $info)
        {
//            var_dump($data, $info);
        };

        $input = new Input(new Url('http://mbosweb.pl'));
        $input->addCompetitorUrl(new Url('dsads'))->addCompetitorUrl(new Url('mbosweb.pl'));

        $requests->process($input->getCompetitorUrls(), $callback);
        $requests->process([$input->getSourceUrl()], $callback);
    }
}