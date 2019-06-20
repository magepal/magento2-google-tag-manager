<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\DataLayer\QuoteData;

/**
 * Class QuoteProvider
 * @package MagePal\GoogleTagManager\DataLayer\QuoteData
 */
class QuoteProvider extends QuoteAbstract
{
    /**
     * @return array
     */
    public function getData()
    {
        $data =  $this->getTransactionData();
        /** @var QuoteAbstract $quoteProvider */
        foreach ($this->getQuoteProviders() as $quoteProvider) {
            $quoteProvider->setQuote($this->getQuote())->setTransactionData($data);

            $data = array_merge_recursive($data, $quoteProvider->getData());
        }

        return $data;
    }
}
