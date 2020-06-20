<?php
/**
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\ApiTopic\Model;

use Magento\Framework\Serialize\SerializerInterface;
use Webjump\ApiTopic\Api\ApiInterface;

class Api implements ApiInterface
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
     * @return int
     */
    public function test(): int
    {
        $top = 1;
        $top = $top * 2;
        return $top;
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
