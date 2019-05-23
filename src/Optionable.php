<?php


namespace Laramqp;


class Optionable
{
    protected $allowOptions = [
        'host',
        'port',
        'username',
        'password',
        'vhost',
        'queue_passive',
        'queue_durable',
        'queue_exclusive',
        'queue_auto_delete',
        'exchange_type',
        'exchange_passive',
        'exchange_durable',
        'exchange_auto_delete'
    ];

    /**
     * @var $config array connect configs
     */
    protected $config;

    /**
     * @var $key string connect key
     */
    protected $key;

    /**
     * @var $keyValue string mq keys key value
     */
    protected $keyValue;

    /**
     * @var string $connectionName
     */
    protected $connectionName;

    /**
     * @var string $exchangeName
     */
    protected $exchangeName;

    /**
     * @var string $queueName
     */
    protected $queueName;


    /**
     * @var $options array set options with user want
     */
    protected $options;

    public function __construct($config, $key)
    {
        $this->config = $config;
        $this->key = $key;
        $this->keyValue = Parser::getKeyValue($config, $key);
        list($this->connectionName, $this->exchangeName, $this->queueName) = Parser::parseKey($this->keyValue);
    }

    protected function initOpts($options)
    {
        $connectConfig = $this->config['connections'];
        if (empty($connectConfig)) {
            throw new \Exception("empty connection set,please check you config");
        }
        $this->options = $connectConfig[$this->connectionName];

        foreach ($this->allowOptions as $key) {
            if (array_key_exists($key, $options)) {
                $this->options[$key] = $options['key'];
            }
        }
    }

    protected function getOptions($key = null, $default = '')
    {
        if (empty($key)) {
            return $this->options;
        }
        return $this->options[$key] ?? $default;
    }
}