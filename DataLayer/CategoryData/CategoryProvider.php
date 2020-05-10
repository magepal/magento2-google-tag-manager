<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\DataLayer\CategoryData;

class CategoryProvider extends CategoryAbstract
{
    /**
     * @param array $categoryProviders
     */
    public function __construct(
        array $categoryProviders = []
    ) {
        $this->categoryProviders = $categoryProviders;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $data =  $this->getcategoryData();
        $arraysToMerge = [];

        /** @var CategoryProvider $categoryProvider */
        foreach ($this->getCategoryProviders() as $categoryProvider) {
            $categoryProvider->setCategory($this->getCategory())->setCategoryData($data);
            $arraysToMerge[] = $categoryProvider->getData();
        }

        return empty($arraysToMerge) ? $data : array_merge($data, ...$arraysToMerge);
    }
}
