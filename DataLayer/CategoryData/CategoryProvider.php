<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\DataLayer\CategoryData;

/**
 * Class CategoryProvider
 * @package MagePal\GoogleTagManager\DataLayer
 */
class CategoryProvider extends CategoryAbstract
{
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
    public function getData()
    {
        $data =  $this->getcategoryData();
        /** @var CategoryProvider $categoryProvider */
        foreach ($this->getCategoryProviders() as $categoryProvider) {
            $categoryProvider->setCategory($this->getCategory())->setCategoryData($data);
            $data = array_merge($data, $categoryProvider->getData());
        }

        return $data;
    }
}
