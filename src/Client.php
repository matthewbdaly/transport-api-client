<?php

namespace Matthewbdaly\TransportApi;

use Matthewbdaly\TransportApi\Contracts\Client as ClientInterface;
use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;

/**
 * Client for the Transport API
 */
class Client implements ClientInterface
{

    /**
     * HTTPlug client
     *
     * @var $client
     */
    protected $client;

    /**
     * HTTPlug message factory
     *
     * @var $messageFactory
     */
    protected $messageFactory;

    /**
     * App ID
     *
     * @var $appId
     */
    protected $appId;

    /**
     * App key
     *
     * @var $key
     */
    protected $key;

    /**
     * Constructor
     *
     * @param string         $appId          Application ID.
     * @param string         $key            Application key.
     * @param HttpClient     $client         HTTPlug client instance.
     * @param MessageFactory $messageFactory HTTPlug message factory instance.
     * @return void
     */
    public function __construct($appId, $key, HttpClient $client = null, MessageFactory $messageFactory = null)
    {
        $this->appId = $appId;
        $this->key = $key;
        $this->client = $client ?: HttpClientDiscovery::find();
        $this->messageFactory = $messageFactory ?: MessageFactoryDiscovery::find();
    }

    public function getDepartures($from, $to = null)
    {
        $query = http_build_query([
            'app_id' => $this->appId,
            'app_key' => $this->key,
            'destination' => $to,
            'train_status' => 'passenger'
        ]);
        $url = "http://transportapi.com/v3/uk/train/station/$from/live.json?$query";
        $request = $this->messageFactory->createRequest('GET', $url);
        return $this->client->sendRequest($request);
    }
}
