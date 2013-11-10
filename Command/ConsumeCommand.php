<?php

namespace Astina\Bundle\BernardBundle\Command;

use Bernard\Consumer;
use Bernard\QueueFactory;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Mostly copy&pasta from Bernard\Command\ConsumeCommand
 */
class ConsumeCommand extends ContainerAwareCommand
{
    /**
     * {@inheritDoc}
     */
    public function configure()
    {
        $this
            ->setName('bernard:consume')
            ->addOption('max-runtime', null, InputOption::VALUE_OPTIONAL, 'Maximum time in seconds the consumer will run.', null)
            ->addArgument('queue', InputArgument::REQUIRED, 'Name of queue that will be consumed.')
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var QueueFactory $queues */
        $queues = $this->getContainer()->get('astina_bernard.queue_factory');
        $queue = $queues->create($input->getArgument('queue'));

        /** @var Consumer $consumer */
        $consumer = $this->getContainer()->get('astina_bernard.consumer');
        $consumer->consume($queue, $input->getOptions());
    }
}
