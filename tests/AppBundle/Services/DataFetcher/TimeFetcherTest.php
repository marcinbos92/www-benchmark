<?php
declare(strict_types=1);


namespace Tests\AppBundle\Services\DataFetcher;


use AppBundle\Services\DataFetcher\Contracts\DataFetcherInterface;
use AppBundle\Services\DataFetcher\Contracts\DataFetcherResultInterface;
use AppBundle\Services\DataFetcher\Response;
use AppBundle\Services\DataFetcher\TimeFetcher;
use AppBundle\Services\Helpers\HtmlInteface;
use AppBundle\Services\RequestProcessing\Requests;
use AppBundle\Services\Schema\Input;
use AppBundle\Services\Schema\Url;
use PHPUnit\Framework\TestCase;
use \Mockery;
class TimeFetcherTest extends TestCase
{
    /**
     * @var string
     */
    private $src_url;

    /**
     * @var string
     */
    private $url_c1;

    /**
     * @var string
     */
    private $url_c2;

    /**
     * @var TimeFetcher
     */
    private $timeFetcher;

    protected function setUp()
    {
        $this->src_url = 'http://interia.pl';
        $this->url_c1 = 'http://onet.pl';
        $this->url_c2 = 'http://mbosweb.pl';

        $this->timeFetcher = new TimeFetcher(Mockery::mock(Requests::class),
            $this->src_url,
            [$this->url_c1, $this->url_c2]
        );
    }

    public function testTimeConstructor(): void
    {
        $this->assertInstanceOf(Input::class, $this->timeFetcher->getInput());
    }

    public function testProcessMethod(): void
    {
        $requests = new Requests();

        $timeFetcher = new TimeFetcher(
            $requests,
            $this->src_url,
            [$this->url_c1, $this->url_c2]
        );

        $result = $timeFetcher->fetch();

        $this->assertInstanceOf(DataFetcherResultInterface::class, $result);
        $this->assertInternalType('array', $result->getCompetitorsResponses());
        $this->assertSame(2, \count($result->getCompetitorsResponses()));
        $this->assertInstanceOf(Response::class, $result->getSourceResponse());

        $firstResult = $result->getCompetitorsResponses()[0];
        $this->assertInstanceOf(Response::class , $firstResult);
        $this->assertInstanceOf(HtmlInteface::class , $firstResult->getHTML());
        $this->assertInstanceOf(\DOMDocument::class , $firstResult->getHTML()->asObject());
        $this->assertInternalType('string', $firstResult->getHTML()->asString());

    }
}