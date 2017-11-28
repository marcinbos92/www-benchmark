<?php
declare(strict_types=1);


namespace AppBundle\Services\Notifier\Actions;


use AppBundle\Services\Comparison\TotalTimeComparisonResponse;
use AppBundle\Services\DataFetcher\Response;
use AppBundle\Services\Notifier\Actions\Contracts\ActionInterface;
use AppBundle\Services\SMS\Contracts\SmsApiInterface;

/**
 * Class SendSmsAction
 * @package AppBundle\Services\Notifier\Actions
 */
class SendSmsAction implements ActionInterface
{
    /**
     * @var SmsApiInterface
     */
    private $smsApi;

    /**
     * Business logic
     */
    private const NUMBER = 2;

    /**
     * SendSmsAction constructor.
     * @param SmsApiInterface $smsApi
     */
    public function __construct(SmsApiInterface $smsApi)
    {
        $this->smsApi = $smsApi;
    }

    public function run(TotalTimeComparisonResponse $response): void
    {
        $benchmarkedWebTime = $response->getArrayResponse()['source']->getInfo()->getTotalTime();

        $smsFlag = null;

        /**
         * @var $fasterWeb Response
         */
        foreach ($response->getArrayResponse()['faster'] as $fasterWeb) {
            if ($benchmarkedWebTime >= $fasterWeb->getInfo()->getTotalTime() * self::NUMBER) {
                $smsFlag = true;
            }
        }

        if (null !== $smsFlag) {
            $this->smsApi->sendMessage(
                ['response' => $response]
            );
        }
    }


}