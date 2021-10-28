<?php

declare(strict_types=1);

namespace App\Consumer;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;

class LoggerConsumerCallback implements ConsumerInterface
{
    /** @var LoggerInterface */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return int|bool One of ConsumerInterface::MSG_* constants according to callback outcome, or false otherwise.
     */
    public function execute(AMQPMessage $msg)
    {
        if (mb_strstr($msg->getRoutingKey(), 'debug') !== false) {
            $this->logger->debug(
                'Received message',
                [
                    'message_body_raw' => $msg->getBody(),
                    'routing_key' => $msg->getRoutingKey(),
                ]
            );
            return ConsumerInterface::MSG_ACK;
        }
        if (mb_strstr($msg->getRoutingKey(), 'info') !== false) {
            $this->logger->info(
                'Received message',
                [
                    'message_body_raw' => $msg->getBody(),
                    'routing_key' => $msg->getRoutingKey(),
                ]
            );
            return ConsumerInterface::MSG_ACK;
        }
        if (mb_strstr($msg->getRoutingKey(), 'error') !== false) {
            $this->logger->error(
                'Received message',
                [
                    'message_body_raw' => $msg->getBody(),
                    'routing_key' => $msg->getRoutingKey(),
                ]
            );
            return ConsumerInterface::MSG_ACK;
        }
    }

}
