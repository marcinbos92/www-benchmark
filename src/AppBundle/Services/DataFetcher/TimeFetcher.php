<?php
declare(strict_types=1);


namespace AppBundle\Services\DataFetcher;


use AppBundle\Services\DataFetcher\Contracts\DataFetcherInterface;
use AppBundle\Services\DataFetcher\Contracts\DataFetcherResultInterface;
use AppBundle\Services\DataFetcher\Exceptions\UnsetInputObject;
use AppBundle\Services\Helpers\Html;
use AppBundle\Services\RequestProcessing\Requests;
use AppBundle\Services\Schema\Input;
use AppBundle\Services\Schema\Url;

/**
 * Class TimeFetcher
 * @package AppBundle\Services\DataFetcher
 */
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
     * @var DataFetcherResultInterface
     */
    private $result;

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
            $input->addCompetitorUrl(new Url($url));
        }, $url_competitors);

        //TODO inject
        $this->result = new DataFetcherResult();

        $this->input = $input;
        $this->requests = $requests;
    }

    /**
     * @return DataFetcherResultInterface
     */
    public function fetch(): DataFetcherResultInterface
    {
        $this->requests->process([$this->input->getSourceUrl()], function ($data, $info) {
            $this->result->addSourceResponse(new Response(new ResponseHeaders($info), new Html($data)));
        });

        $this->requests->process($this->input->getCompetitorUrls(), function ($data, $info) {
                $this->result->addCompetitorResponse(new Response(new ResponseHeaders($info), new Html($data)));
        });

        return $this->result;
    }

    /**
     * @return Input
     * @throws UnsetInputObject
     */
    public function getInput(): Input
    {
        if ($this->input instanceof Input) {
            return $this->input;
        }

        throw new UnsetInputObject('Input field not set');
    }

}