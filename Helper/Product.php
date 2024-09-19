<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * https://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\Helper;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\UrlInterface;

class Product extends Data
{
    public function getImageUrl($product)
    {
        /** @var $product ProductInterface */
        return $this->_urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA])
            . 'catalog/product' . ($product->getData('image') ?: $product->getData('small_image'));
    }
}
