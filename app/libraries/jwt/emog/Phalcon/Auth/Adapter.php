<?php

namespace EmoG\Phalcon\Auth;

use EmoG\Phalcon\Auth\AdapterInterface;
use Firebase\JWT\JWT;
use EmoG\Phalcon\Auth\TokenGetter\AdapterInterface as TokenGetter;

/**
 * EmoG\Phalcon\Auth\Adapter.
 */
abstract class Adapter implements AdapterInterface
{
    // payload for JWT
    protected $payload = [];

    // window time for jwt to expire
    protected $leeway;

    // supported algs are on JWT::$supported_algs
    protected $algo = 'HS256';

    protected $errorMsgs = [];

    /**
     * Converts mins to seconds.
     *
     * @param int $mins
     *
     * @return int
     */
    public function minToSec($mins)
    {
        return (60 * $mins);
    }

    /**
     * Sets leeway after JWT has expired.
     *
     * @param int $mins
     *
     */
    public function setLeeway($mins)
    {
        $this->leeway = $this->minToSec($mins);
    }

    /**
     * Sets algorith for hashing JWT.
     * See available Algos on JWT::$supported_algs
     *
     * @param $alg
     *
     */
    public function setAlgo($alg)
    {
        $this->algo = $alg;
    }

    /**
     * Decodes JWT.
     *
     * @param string $token
     * @param string $key
     *
     * @return array
     */
    protected function decode($token, $key)
    {
        try {
            if ($this->leeway) {
                JWT::$leeway = $this->leeway;
            }

            $payload = (array)JWT::decode($token, $key, [$this->algo]);

            return $payload;

        } catch (\Exception $e) {
            $this->appendMessage($e->getMessage());

            return false;

        }
    }

    /**
     * Encodes array into JWT.
     *
     * @param array $payload
     * @param string $key
     *
     * @return string
     */
    protected function encode($payload, $key)
    {
        if (isset($payload['exp'])) {
            $payload['exp'] = time() + $this->minToSec($payload['exp']);
        }

        return JWT::encode($payload, $key, $this->algo);
    }

    /**
     * Adds string to error messages.
     *
     * @param string $msg
     *
     */
    public function appendMessage($msg)
    {
        $this->errorMsgs[] = $msg;
    }

    /**
     * Returns error messages
     *
     * @return array
     */
    public function getMessages()
    {
        return $this->errorMsgs;
    }

    /**
     * Returns JWT payload sub or payload id.
     *
     * @return string
     */
    public function id()
    {
        return isset($this->payload['sub']) ? $this->payload['sub'] : $this->payload['id'];
    }

    /**
     * Returns payload or value of payload key.
     *
     * @param array $payload
     * @param string $key
     *
     * @return array|string
     */
    public function data($field = null)
    {
        return (!$field ? $this->payload : $this->payload[$field]);
    }
}