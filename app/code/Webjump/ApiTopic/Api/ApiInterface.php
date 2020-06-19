<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\ApiTopic\Api;

/**
 * Interface ApiInterface
 * @package Webjump\ApiTopic\Api
 */
interface ApiInterface
{
    /**
     * @param string $value
     * @return string
     */
    public function post(string $value): string;

    /**
     * @param string $value
     * @return string
     */
    public function get(string $value): string;
}
