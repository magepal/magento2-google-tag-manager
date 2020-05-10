<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\DataLayer\QuoteData;

use Magento\Quote\Model\Quote;

abstract class QuoteAbstract
{
    /**
     * @var QuoteProvider[]
     */
    protected $quoteProviders;

    /**
     * @var array
     */
    private $transactionData = [];

    /**
     * @var Quote
     */
    private $quote;

    /**
     * @return array
     */
    abstract public function getData();

    /**
     * @return array
     */
    public function getTransactionData()
    {
        return (array) $this->transactionData;
    }

    /**
     * @param array $transactionData
     * @return QuoteAbstract
     */
    public function setTransactionData(array $transactionData)
    {
        $this->transactionData = $transactionData;
        return $this;
    }

    /**
     * @return Quote
     */
    public function getQuote()
    {
        return $this->quote;
    }

    /**
     * @param Quote $quote
     * @return QuoteAbstract
     */
    public function setQuote(Quote $quote)
    {
        $this->quote = $quote;
        return $this;
    }

    /**
     * @return QuoteProvider[]
     */
    public function getQuoteProviders()
    {
        return $this->quoteProviders;
    }
}
