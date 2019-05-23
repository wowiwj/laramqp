<?php


namespace Laramqp;


use Closure;
use PhpAmqpLib\Message\AMQPMessage;

class Listener extends Optionable
{
    protected $connection;

    public function __construct($config, $key, $options = [])
    {
        parent::__construct($config, $key);
        $this->connection = Connection::connect($config, $key, $options);
    }

    public function listen(Closure $callback)
    {
        $channel = $this->connection->getChannel();
        $channel->basic_consume(
            $this->queueName,
            $this->getOptions('consumer_tag', ''),
            $this->getOptions('consumer_no_local', false),
            $this->getOptions('consumer_no_ack', false),
            $this->getOptions('consumer_exclusive', false),
            $this->getOptions('consumer_nowait', false),
            function (AMQPMessage $message) use ($callback) {
                $this->messageHandle($message, $callback);
            }
        );

        while ($channel->is_consuming()) {
            $channel->wait();
        }
    }

    /**
     * handle message
     * @param AMQPMessage $message
     * @param Closure $callback
     * @author wangju 19-5-23 下午3:43
     */
    protected function messageHandle(AMQPMessage $message, Closure $callback)
    {
        $processed = $callback($message->getBody(), $message);
        if ($processed) {
            $message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
        }

        // Send a message with the string "quit" to cancel the consumer.
        if ($message->body === 'quit') {
            $message->delivery_info['channel']->basic_cancel($message->delivery_info['consumer_tag']);
        }
    }

}