<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetCrud\Ui\DataProvider\Listing;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\ReportingInterface;
use Magento\Framework\Api\Search\SearchCriteriaBuilder as SearchSearchCriteriaBuilder;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;

/**
 * @codeCoverageIgnore
 */
class PetDataProvider extends DataProvider
{
    /**
     * @var PoolInterface
     */
    private $modifiersPool;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param ReportingInterface $reporting
     * @param SearchSearchCriteriaBuilder $searchSearchCriteriaBuilder
     * @param RequestInterface $request
     * @param FilterBuilder $filterBuilder
     * @param PoolInterface|null $modifiersPool
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        ReportingInterface $reporting,
        SearchSearchCriteriaBuilder $searchSearchCriteriaBuilder,
        RequestInterface $request,
        FilterBuilder $filterBuilder,
        PoolInterface $modifiersPool = null,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $reporting,
            $searchSearchCriteriaBuilder,
            $request,
            $filterBuilder,
            $meta,
            $data
        );
        $this->modifiersPool = $modifiersPool;
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): array
    {
        $data = parent::getData();
        if ($this->modifiersPool !== null) {
            /** @var ModifierInterface $modifier */
            foreach ($this->modifiersPool->getModifiersInstances() as $modifier) {
                $data = $modifier->modifyData($data);
            }
        }
        return $data;
    }

    /**
     * @inheritdoc
     */
    public function getMeta(): array
    {
        $meta = parent::getMeta();
        if ($this->modifiersPool !== null) {
            /** @var ModifierInterface $modifier */
            foreach ($this->modifiersPool->getModifiersInstances() as $modifier) {
                $meta = $modifier->modifyMeta($meta);
            }
        }
        return $meta;
    }
}
