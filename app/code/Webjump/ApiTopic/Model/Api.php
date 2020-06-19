<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\ApiTopic\Model;

use Magento\Framework\Serialize\SerializerInterface;

/**
 * Class Api
 * @package Webjump\ApiTopic\Model
 */
class Api implements \Webjump\ApiTopic\Api\ApiInterface
{

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * Api constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }


    /**
     * @inheritDoc
     */
    public function post(string $value): string
    {
        $result = ["message" => "success", "webapi" => [$value]];
        return $this->serializer->serialize($result);
    }

    /**
     * @inheritDoc
     */
    public function get(string $value): string
    {
        $result = ["message" => "success", "webapi" => [$value]];
        return $this->serializer->serialize($result);
    }
}
