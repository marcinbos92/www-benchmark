<?php
declare(strict_types=1);


namespace AppBundle\Services\RequestProcessing;


use AppBundle\Services\Schema\Input;
use AppBundle\Services\Schema\Url;

/**
 * Class Requests
 * @package AppBundle\Services\RequestProcessing
 */
class Requests
{

    private $handle;

    /**
     * Requests constructor.
     */
    public function __construct()
    {
        $this->handle = curl_multi_init();
    }

    /**
     * @param Input $incommingData
     */
    public function process(Input $incommingData)
    {
        //TODO add process for source url

        /**
         * @var $competitorUrl Url
         */
        foreach ($incommingData->getCompetitorUrls() as $competitorUrl) {
            $ci = curl_init($competitorUrl->getUrl());

            curl_setopt_array($ci, [CURLOPT_RETURNTRANSFER => true]);
            curl_multi_add_handle($this->handle, $ci);
        }

        do {
            $mrc = curl_multi_exec($this->handle, $active);

            if ($state = curl_multi_info_read($this->handle))  {
                //print_r($state);
                $info = curl_getinfo($state['handle']);
                //print_r($info);
                $callback(curl_multi_getcontent($state['handle']), $info);
                curl_multi_remove_handle($this->handle, $state['handle']);
            }

            usleep(10000);
        } while ($mrc === CURLM_CALL_MULTI_PERFORM || $active);
    }

    public function __destruct()
    {
        curl_multi_close($this->handle);
    }

}