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

    /**
     * @var resource
     */
    private $handle;

    /**
     * Requests constructor.
     */
    public function __construct()
    {
        $this->handle = curl_multi_init();
    }

    /**
     * @param Url[] $urls
     * @param callable $callback
     */
    public function process(array $urls, Callable $callback)
    {

        /**
         * @var $competitorUrl Url
         */
        foreach ($urls as $url) {
            $this->initCurl($url);
        }

        do {
            $mrc = curl_multi_exec($this->handle, $active);

            if ($state = curl_multi_info_read($this->handle))  {
                $info = curl_getinfo($state['handle']);
                $callback(curl_multi_getcontent($state['handle']), $info);
                curl_multi_remove_handle($this->handle, $state['handle']);
            }
            usleep(10000);
        } while ($mrc === CURLM_CALL_MULTI_PERFORM || $active);
    }

    /**
     * @param Url $url
     */
    private function initCurl(Url $url): void
    {
        $ci = curl_init($url->getUrl());

        curl_setopt_array($ci, [CURLOPT_RETURNTRANSFER => true]);
        curl_multi_add_handle($this->handle, $ci);
    }

    public function __destruct()
    {
        curl_multi_close($this->handle);
    }

}