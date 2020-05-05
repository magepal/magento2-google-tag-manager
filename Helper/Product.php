<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\UrlInterface;

class Product extends AbstractHelper
{

    public function getImageUrl($product)
    {
        /** @var $product ProductInterface */
        return $this->_urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA])
            . 'catalog/product' . ($product->getData('image') ?: $product->getData('small_image'));
    }
}
