<?php


namespace Laramqp;


class Parser
{
    /**
     * parse key value
     * @param $key
     * @return array
     * @throws \Exception
     * @author wangju 19-5-23 上午11:31
     */
    public static function parseKey($key)
    {
        $keyArr = explode('.', $key);
        if (count($keyArr) != 3) {
            throw new \Exception("parsed error by key: " . $key);
        }
        return $keyArr;
    }

    /**
     * get key value by config
     * @param $config
     * @param $key
     * @return mixed|null
     * @author wangju 19-5-23 上午11:31
     */
    public static function getKeyValue($config, $key)
    {
        $mqKeys = $config['mq_keys'];
        if (empty($mqKeys)) {
            return null;
        }
        return $mqKeys[$key];
    }

}