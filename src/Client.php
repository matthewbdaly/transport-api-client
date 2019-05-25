<?php

namespace Matthewbdaly\TransportApi;

use Matthewbdaly\TransportApi\Contracts\Client as ClientInterface;
use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Psr\Http\Message\ResponseInterface;

/**
 * Client for the Transport API
 */
final class Client implements ClientInterface
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
    public function __construct(string $appId, string $key, HttpClient $client = null, MessageFactory $messageFactory = null)
    {
        $this->appId = $appId;
        $this->key = $key;
        $this->client = $client ?: HttpClientDiscovery::find();
        $this->messageFactory = $messageFactory ?: MessageFactoryDiscovery::find();
    }

    /**
     * Get live train departures
     *
     * @param string $from Departure station.
     * @param string $to   Destination station.
     * @return ResponseInterface
     */
    public function getTrainDepartures(string $from, string $to = null): ResponseInterface
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
