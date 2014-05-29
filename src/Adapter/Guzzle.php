<?php

/*
* This file is part of the concise project.
*
* (c) Antoine Corcy <contact@sbin.dk>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Concise\Adapter;

use Concise\Exception\RuntimeException;
use Guzzle\Http\Client;

/**
 * @author Antoine Corcy <contact@sbin.dk>
 */
class Guzzle implements \Concise\Adapter
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @param Client $client (optional).
     */
    public function __construct(Client $client = null)
    {
        $this->client = $client ?: new Client;
    }

    /**
     * {@inheritdoc}
     */
    public function get($path, array $headers = array())
    {
        $request = $this->client->get($path, $headers);

        try {
            return $request->send()->getBody(true);
        } catch (\Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function post($path, $body = null, array $headers = array())
    {
        $request = $this->client->post($path, $headers, $body);

        try {
            return $request->send()->getBody(true);
        } catch (\Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }
}
