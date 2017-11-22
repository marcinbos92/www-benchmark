<?php
declare(strict_types=1);


namespace AppBundle\Services\DataFetcher;


use AppBundle\Services\DataFetcher\Contracts\DataFetcherInterface;
use AppBundle\Services\DataFetcher\Contracts\DataFetcherResultInterface;
use AppBundle\Services\RequestProcessing\Requests;
use AppBundle\Services\Schema\Input;
use AppBundle\Services\Schema\Url;

class TimeFetcher implements DataFetcherInterface
{

    /**
     * @var Input
     */
    private $input;
    /**
     * @var Requests
     */
    private $requests;

    /**
     * TimeFetcher constructor.
     *
     * @param Requests $requests
     * @param string $src_url
     * @param array $url_competitors
     */
    public function __construct(Requests $requests, string $src_url, ...$url_competitors)
    {
        //TODO move to factory maybe... [S]olid
        $input = new Input(new Url($src_url));

        array_map(function ($url) use ($input) {
            $input->addCompetitorUrl($url);
        }, $url_competitors);

        $this->input = $input;
        $this->requests = $requests;
    }

    public function fetch(): DataFetcherResultInterface
    {
        $this->requests->process($this->input, function ($data, $info) {
            sprintf("Processing");
            print_r($data);
            print_r($info);
        });
    }

}