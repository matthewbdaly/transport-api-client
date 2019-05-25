<?php

namespace Matthewbdaly\TransportApi\Contracts;

use Psr\Http\Message\ResponseInterface;

interface Client
{
    /**
     * Get live train departures
     *
     * @param string      $from Departure station.
     * @param string|null $to   Destination station.
     * @return ResponseInterface
     */
    public function getTrainDepartures(string $from, string $to = null): ResponseInterface;
}
