<?php


namespace Laramqp;


use PhpAmqpLib\Message\AMQPMessage;

class Publisher extends Optionable
{
    protected $connection;

    public function __construct($config, $key, $options = [])
    {
        parent::__construct($config, $key, $options);
        $this->connection = Connection::connect($config, $key, $options);
    }

    /**
     * add message to exchange
     * @param $message
     * @return bool
     * @throws \Exception
     * @author wangju 19-5-23 下午1:38
     */
    public function add($message)
    {
        $channel = $this->connection->getChannel();
        $message = $this->convertMessage($message);
        $amqpMessage = new AMQPMessage($message, [
            'content_type'  => $this->getOptions('content_type', 'text/plain'),
            'delivery_mode' => $this->getOptions('delivery_mode', AMQPMessage::DELIVERY_MODE_PERSISTENT),
        ]);
        $channel->basic_publish($amqpMessage, $this->exchangeName);
        $channel->close();
        $this->connection->close();
        return true;
    }

    /**
     * convert message with string
     * @param $message
     * @return false|string
     * @author wangju 19-5-23 下午1:41
     */
    public function convertMessage($message)
    {
        if (is_array($message)) {
            return json_encode($message, true);
        }
        return $message;
    }
}