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
     * @param string $srcUrl
     * @param array $urlCompetitors
     */
    public function __construct(Requests $requests, string $srcUrl, array $urlCompetitors)
    {
        //TODO move to factory maybe... [S]olid
        $input = new Input(new Url($srcUrl));

        foreach ($urlCompetitors as $urlCompetitor) {
            $input->addCompetitorUrl(new Url($urlCompetitor));
        }

        $this->result = new DataFetcherResult();
        $this->input = $input;
        $this->requests = $requests;
    }

    /**
     * @return DataFetcherResultInterface
     */
    public function fetch(): DataFetcherResultInterface
    {
        //To add HTML content to response: new Html($data)

        $this->requests->process([$this->input->getSourceUrl()], function ($data, $info) {
            $this->result->addSourceResponse(new Response(new ResponseHeaders($info), new Html('<html></html>')));
        });

        $this->requests->process($this->input->getCompetitorUrls(), function ($data, $info) {
                $this->result->addCompetitorResponse(new Response(new ResponseHeaders($info), new Html('<html></html>')));
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