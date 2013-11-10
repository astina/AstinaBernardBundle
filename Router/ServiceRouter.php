<?php

namespace Astina\Bundle\BernardBundle\Router;

use Bernard\Envelope;
use Bernard\Exception\ReceiverNotFoundException;
use Bernard\Router;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ServiceRouter implements Router
{
    /**
     * @var ContainerInterface
     */
    private $container;

    private $receivers;

    function __construct($container)
    {
        $this->container = $container;
    }

    public function addReceiver($name, $serviceId, $method)
    {
        $this->receivers[$name] = array($serviceId, $method);
    }

    /**
     * Returns the right Receiver (callable) based on the Envelope.
     *
     * @param  Envelope $envelope
     * @throws ReceiverNotFoundException
     * @return array
     */
    public function map(Envelope $envelope)
    {
        $name = $envelope->getName();

        if (!isset($this->receivers[$name])) {
            throw new ReceiverNotFoundException(sprintf('No receiver "%s" defined', $name));
        }

        $receiver = $this->receivers[$name];

        $service = $this->container->get($receiver[0]);
        $method = $receiver[1];

        return array($service, $method);
    }
}