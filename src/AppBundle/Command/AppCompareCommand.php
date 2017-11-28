<?php

namespace AppBundle\Command;

use AppBundle\Services\Comparison\TotalTimeComparison;
use AppBundle\Services\DataFetcher\Response;
use AppBundle\Services\DataFetcher\TimeFetcher;
use AppBundle\Services\Notifier\Actions\SendMailAction;
use AppBundle\Services\Notifier\Actions\SendSmsAction;
use AppBundle\Services\Notifier\Notifier;
use AppBundle\Services\RequestProcessing\Requests;
use AppBundle\Services\SMS\Contracts\SmsApiInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AppCompareCommand extends ContainerAwareCommand
{
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var SmsApiInterface
     */
    private $smsApi;

    /**
     * AppCompareCommand constructor.
     * @param LoggerInterface $logger
     * @param \Swift_Mailer $mailer
     * @param SmsApiInterface $smsApi
     */
    public function __construct(LoggerInterface $logger, \Swift_Mailer $mailer, SmsApiInterface $smsApi)
    {
        parent::__construct();
        $this->logger = $logger;
        $this->mailer = $mailer;
        $this->smsApi = $smsApi;
    }

    protected function configure()
    {
        $this
            ->setName('app:compare')
            ->setDescription('Benchmark loading time of the websites.')
            ->addArgument('source', InputArgument::REQUIRED, 'Source Page Link')
            ->addArgument('competitors', InputArgument::IS_ARRAY | InputArgument::REQUIRED, 'Pages links which will be compared with source')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $table = new Table($output);
        $competitors = $input->getArgument('competitors');

        if (!\count($competitors)) {
            $output->writeln('Required at least 1 url page');
            exit;
        }

        $timeFetcher = new TimeFetcher(new Requests(),
            $input->getArgument('source'),
            $competitors
        );

        $notifierService = new Notifier();
        /**
         * TODO: Future improvement: register notifier and other classes as services in container
         * and inject dependencies (like Logger)
         */
        $notifierService->addAction(new SendMailAction($this->mailer));
        $notifierService->addAction(new SendSmsAction($this->smsApi));

        $totalTimeComparison = new TotalTimeComparison($timeFetcher->fetch(), $notifierService);

        $responseArray = $totalTimeComparison->compare()->getArrayResponse();

        $table->setColumnWidths([30,20]);
        $table->setHeaders(['url', 'total_time']);

        $table->addRow([
            $responseArray['source']->getInfo()->getUrl(),
            $responseArray['source']->getInfo()->getTotalTime(),
        ]);


        if (array_key_exists('slower', $responseArray)) {
            $table->addRow(new TableSeparator());
            $table->addRow([new TableCell('Slower', ['colspan' => 2])]);
            $table->addRow(new TableSeparator());
            /**
             * @var Response $response
             */
            foreach ($responseArray['slower'] as $response) {
                $table->addRow([$response->getInfo()->getUrl(), $response->getInfo()->getTotalTime()]);
                $this->logger->info($response->getInfo()->getUrl() . ' ' . $response->getInfo()->getTotalTime());
            }

        }


        if (array_key_exists('faster', $responseArray)) {
            $table->addRow(new TableSeparator());
            $table->addRow([new TableCell('Faster', ['colspan' => 2])]);
            $table->addRow(new TableSeparator());
            /**
             * @var Response $response
             */
            foreach ($responseArray['faster'] as $response) {
                $table->addRow([$response->getInfo()->getUrl(), $response->getInfo()->getTotalTime()]);
                $this->logger->info($response->getInfo()->getUrl() . ' ' . $response->getInfo()->getTotalTime());
            }
        }

        $this->logToFile($responseArray);
        $table->render();
    }

    private function logToFile(array $responseArray): void
    {
        $this->logger->info(
            sprintf("Page [%s] loaded in [%f]",
                $responseArray['source']->getInfo()->getUrl(),
                $responseArray['source']->getInfo()->getTotalTime()
            )
        );

        $this->logger->info(
            sprintf("Page [%s] loaded in [%f]",
                $responseArray['source']->getInfo()->getUrl(),
                $responseArray['source']->getInfo()->getTotalTime()
            )
        );

    }



}
