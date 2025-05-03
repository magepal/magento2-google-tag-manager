<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * https://www.magepal.com | support@magepal.com
 */
namespace MagePal\GoogleTagManager\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class GdprOption implements ArrayInterface
{
    const USE_COOKIE_RESTRICTION_MODE = 1;
    const IF_COOKIE_EXIST = 2;
    const IF_COOKIE_NOT_EXIST = 3;
    const IF_COOKIE_VALUE_EXIST = 4;

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::USE_COOKIE_RESTRICTION_MODE, 'label' => __('Use Magento Cookie Restriction Mode')],
            ['value' => self::IF_COOKIE_EXIST, 'label' => __('Enable Google Analytics Tracking if Cookie Exist')],
            ['value' => self::IF_COOKIE_NOT_EXIST, 'label' => __('Disable Google Analytics Tracking if Cookie Exist')],
            ['value' => self::IF_COOKIE_VALUE_EXIST, 'label' => __('Enable Google Analytics Tracking based on Cookie Values')]
        ];
    }
}
