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

        'auto_bind', // auto bind queue and exchange
        'consumer_tag',

        'queue_passive',
        'queue_durable',
        'queue_exclusive',
        'queue_auto_delete',

        'exchange_type',
        'exchange_passive',
        'exchange_durable',
        'exchange_auto_delete',

        'consumer_no_local',
        'consumer_no_ack',
        'consumer_exclusive',
        'consumer_nowait',

        'content_type',
        'delivery_mode',
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
     * @var $options array all options
     */
    protected $options;

    public function __construct($config, $key, $options = [])
    {
        $this->config = $config;
        $this->key = $key;
        $this->keyValue = Parser::getKeyValue($config, $key);
        list($this->connectionName, $this->exchangeName, $this->queueName) = Parser::parseKey($this->keyValue);
        $this->initOpts($options);
    }

    /**
     * init options with user config
     * @param $options
     * @throws \Exception
     * @author wangju 19-5-23 下午2:41
     */
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

    /**
     * get user options
     * @param null $key
     * @param string $default
     * @return array|mixed|string
     * @author wangju 19-5-23 下午2:42
     */
    protected function getOptions($key = null, $default = '')
    {
        if (empty($key)) {
            return $this->options;
        }
        return $this->options[$key] ?? $default;
    }
}