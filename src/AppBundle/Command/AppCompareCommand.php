<?php

namespace AppBundle\Command;

use AppBundle\Services\Comparison\TotalTimeComparison;
use AppBundle\Services\DataFetcher\Response;
use AppBundle\Services\DataFetcher\TimeFetcher;
use AppBundle\Services\RequestProcessing\Requests;
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

        $totalTimeComparison = new TotalTimeComparison($timeFetcher->fetch());

//        $totalTimeComparison->compare();
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
            }
        }

        $table->render();
    }

}
