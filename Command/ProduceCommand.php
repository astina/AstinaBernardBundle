<?php

namespace Astina\Bundle\BernardBundle\Command;

use Bernard\Producer;
use Bernard\Message\DefaultMessage;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Mostly copy&pasta from Bernard\Command\ProduceCommand
 */
class ProduceCommand extends ContainerAwareCommand
{
    /**
     * {@inheritDoc}
     */
    public function configure()
    {
        $this
            ->setName('bernard:produce')
            ->addArgument('name', InputArgument::REQUIRED, 'Name for the message eg. "ImportUsers".')
            ->addArgument('message', InputArgument::OPTIONAL, 'JSON encoded string that is used for message properties.')
            ->addArgument('queue', InputArgument::OPTIONAL, 'Queue name')
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $name    = $input->getArgument('name');
        $message = json_decode($input->getArgument('message'), true) ?: array();
        $queue   = $input->getArgument('queue');

        if (json_last_error()) {
            throw new \RuntimeException('Could not decode invalid JSON [' . json_last_error() . ']');
        }

        /** @var Producer $producer */
        $producer = $this->getContainer()->get('astina_bernard.producer');
        $producer->produce(new DefaultMessage($name, $message), $queue);
    }
}
