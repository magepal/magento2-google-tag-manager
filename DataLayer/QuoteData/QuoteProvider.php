<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\DataLayer\QuoteData;

class QuoteProvider extends QuoteAbstract
{
    /**
     * @param array $quoteProviders
     * @codeCoverageIgnore
     */
    public function __construct(
        array $quoteProviders = []
    ) {
        $this->quoteProviders = $quoteProviders;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $data =  $this->getTransactionData();
        $arraysToMerge = [];

        /** @var QuoteAbstract $quoteProvider */
        foreach ($this->getQuoteProviders() as $quoteProvider) {
            $quoteProvider->setQuote($this->getQuote())->setTransactionData($data);
            $arraysToMerge[] = $quoteProvider->getData();
        }

        return empty($arraysToMerge) ? $data : array_merge($data, ...$arraysToMerge);
    }
}
