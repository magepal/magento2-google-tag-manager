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
     * @return array
     */
    public function getData()
    {
        $data =  $this->getTransactionData();
        /** @var CategoryProvider $categoryProvider */
        foreach ($this->getCategoryProviders() as $categoryProvider) {
            $categoryProvider->setCategory($this->getCategory())->setTransactionData($data);
            $data = array_merge_recursive($data, $categoryProvider->getData());
        }

        return $data;
    }
}
