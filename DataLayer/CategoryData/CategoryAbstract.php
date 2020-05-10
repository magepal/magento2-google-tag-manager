<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\DataLayer\CategoryData;

use Magento\Catalog\Model\Category;

abstract class CategoryAbstract
{
    /**
     * @var CategoryProvider[]
     */
    protected $categoryProviders;

    /**
     * @var array
     */
    private $categoryData = [];

    /**
     * @var Category
     */
    private $category;

    /**
     * @return array
     */
    abstract public function getData();

    /**
     * @return array
     */
    public function getCategoryData()
    {
        return (array) $this->categoryData;
    }

    /**
     * @param array $categoryData
     * @return CategoryAbstract
     */
    public function setCategoryData(array $categoryData)
    {
        $this->categoryData = $categoryData;
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
