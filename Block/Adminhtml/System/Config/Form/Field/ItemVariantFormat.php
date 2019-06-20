<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See license.txt for license details.
 * https://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\Block\Adminhtml\System\Config\Form\Field;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class ItemVariantFormat
 * @package MagePal\GoogleTagManager\Block\Adminhtml\System\Config\Form\Field
 */
class ItemVariantFormat implements ArrayInterface
{
    /**
     * Short format
     */
    const SHORT_FORMAT = 1;

    /**
     * long format
     */
    const LONG_FORMAT = 2;

    const DEFAULT_FORMAT = self::SHORT_FORMAT;

    const FORMAT = [
        self::SHORT_FORMAT => '{{value}}',
        self::LONG_FORMAT => '{{label}} / {{value}}'
    ];

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['label' => __('Option Value (XS/Black)'), 'value' => self::SHORT_FORMAT],
            ['label' => __('Option Name : Option Value (Size : XS / Color : Black)'), 'value' => self::LONG_FORMAT]
        ];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return [
            [self::SHORT_FORMAT => __('Option Value (XS/Black)')],
            [self::LONG_FORMAT => __('Option Name : Option Value (Size : XS / Color : Black)')]
        ];
    }
}
