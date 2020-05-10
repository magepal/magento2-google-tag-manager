<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\DataLayer\QuoteData;

class QuoteItemProvider extends QuoteItemAbstract
{
    /**
     * @param array $quoteItemProviders
     * @codeCoverageIgnore
     */
    public function __construct(
        array $quoteItemProviders = []
    ) {
        $this->quoteItemProviders = $quoteItemProviders;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $data =  $this->getItemData();
        $arraysToMerge = [];

        /** @var QuoteItemAbstract $quoteItemProvider */
        foreach ($this->getQuoteItemProviders() as $quoteItemProvider) {
            $quoteItemProvider->setItem($this->getItem())->setItemData($data);
            $arraysToMerge[] = $quoteItemProvider->getData();
        }

        return empty($arraysToMerge) ? $data : array_merge($data, ...$arraysToMerge);
    }
}
