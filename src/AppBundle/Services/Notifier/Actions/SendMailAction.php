<?php
declare(strict_types=1);


namespace AppBundle\Services\Notifier\Actions;


use AppBundle\Services\Comparison\TotalTimeComparisonResponse;
use AppBundle\Services\Notifier\Actions\Contracts\ActionInterface;

/**
 * Class SendMailAction
 * @package AppBundle\Services\Notifier\Actions
 */
class SendMailAction implements ActionInterface
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * TODO: future improvements: move to config
     */
    private const EMAIL = 'marcin@mbosweb.pl';

    /**
     * SendMailAction constructor.
     * @param \Swift_Mailer $mailer
     */
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param TotalTimeComparisonResponse $response
     * @throws \Exception
     */
    public function run(TotalTimeComparisonResponse $response): void
    {
        $message = new \Swift_Message('WWW Benchmark notification');
        $message->setFrom('example@example.com');
        $message->setTo(self::EMAIL);
        $message->setBody($response->getArrayResponse()['message']);

        //For testing
        var_dump('EMAIL WAS SENT');

        if (!$this->mailer->send($message)) {
            //TODO: Too general...
            throw new \Exception('Send mail action problem.');
        }
    }

}