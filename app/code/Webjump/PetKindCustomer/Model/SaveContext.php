<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetKindCustomer\Model;

use Magento\Framework\App\RequestInterface;
use Webjump\PetKindCustomer\Api\SaveStrategyInterface;

class SaveContext implements SaveStrategyInterface
{
    /**
     * @var SaveStrategyInterface[]
     */
    private $strategies;

    /**
     * SaveContext constructor.
     * @param SaveStrategyInterface[] $strategies
     */
    public function __construct(array $strategies = null)
    {
        $this->strategies = $strategies;
    }

    /**
     * @inheritDoc
     */
    public function execute(RequestInterface $request): void
    {
        foreach ($this->strategies as $strategy) {
            $strategy->execute($request);
        }
    }
}
