<?php

declare(strict_types=1);

namespace App\Consumer;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;


class NewEntriesNotifierConsumerCallback implements ConsumerInterface
{
    /**
     * @return int|bool One of ConsumerInterface::MSG_* constants according to callback outcome, or false otherwise.
     */

    /** $email varialble is ready to be sent by e-mail */
    public function execute(AMQPMessage $msg)
    {
        $email = "New entity was created:" . "\r\n" . json_encode($msg->getBody()) . "\r\n";
        return ConsumerInterface::MSG_ACK;
    }
}
