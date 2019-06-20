<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\DataLayer\CategoryData;

use Magento\Sales\Model\Category;

/**
 * Class CategoryProvider
 * @package MagePal\GoogleTagManager\Model\DataLayer
 */
abstract class CategoryAbstract
{
    /**
     * @var CategoryProvider[]
     */
    private $categoryProviders;

    /**
     * @var array
     */
    private $transactionData = [];

    /**
     * @var Category
     */
    private $category;

    /**
     * @param array $categoryProviders
     * @codeCoverageIgnore
     */
    public function __construct(
        array $categoryProviders = []
    ) {
        $this->categoryProviders = $categoryProviders;
    }

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
     * @return CategoryAbstract
     */
    public function setTransactionData(array $transactionData)
    {
        $this->transactionData = $transactionData;
        return $this;
    }

    /**
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     * @return CategoryAbstract
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return array|CategoryProvider[]
     */
    public function getCategoryProviders()
    {
        return $this->categoryProviders;
    }
}
