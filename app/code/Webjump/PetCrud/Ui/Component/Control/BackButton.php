<?php
/*
 * Copyright (c) 2020. Victor Barcellos Lopes
 */

declare(strict_types=1);

namespace Webjump\PetCrud\Ui\Component\Control;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class BackButton implements ButtonProviderInterface
{
    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * BackButton constructor.
     * @param UrlInterface $urlBuilder
     */
    public function __construct(UrlInterface $urlBuilder)
    {
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @inheritDoc
     */
    public function getButtonData(): array
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->urlBuilder->getUrl('*/*/index')),
            'class' => 'back',
            'sort_order' => 10
        ];
    }
}
