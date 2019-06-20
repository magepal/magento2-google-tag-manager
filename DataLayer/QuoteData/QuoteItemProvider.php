<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\DataLayer\QuoteData;

/**
 * Class QuoteItemProvider
 * @package MagePal\GoogleTagManager\DataLayer\QuoteData
 */
class QuoteItemProvider extends QuoteItemAbstract
{
    /**
     * @return array
     */
    public function getData()
    {
        $data =  $this->getItemData();
        /** @var QuoteItemAbstract $quoteItemProvider */
        foreach ($this->getQuoteItemProviders() as $quoteItemProvider) {
            $quoteItemProvider->setItem($this->getItem())->setItemData($data);

            $data = array_merge_recursive($data, $quoteItemProvider->getData());
        }

        return $data;
    }
}
