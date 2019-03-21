<?php

declare(strict_types=1);

namespace App\Service;


interface IpStorageInterface
{
    /**
     * IP address can be added to the storage with this call, returning value,
     * the counter, how many times have been added to the storage
     *
     * @param string $ip
     * @return int
     */
    public function add(string $ip): int;


    /**
     * This call indicates how many times a valid IP address was added to the storage.
     *
     * @param string $ip
     * @return int
     */
    public function query(string $ip): int;
}