<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\Helper;

use Magento\Quote\Model\Quote\Item as QuoteItem;
use Magento\Sales\Model\Order\Item as OrderItem;
use Magento\Store\Model\ScopeInterface;
use MagePal\GoogleTagManager\Block\Adminhtml\System\Config\Form\Field\ItemVariantFormat;

/**
 * Class Item
 * @package MagePal\GoogleTagManager\Helper
 */
class DataLayerItem extends Data
{
    /**
     * @var array
     */
    protected $categories = [];

    /**
     * @var array
     */
    protected $variants = [];

    /**
     * @param null $store_id
     * @return bool
     */
    public function isItemVariantLayerEnabled($store_id = null)
    {
        return $this->scopeConfig->isSetFlag(
            'googletagmanager/general/item_variant_layer',
            ScopeInterface::SCOPE_STORE,
            $store_id
        );
    }
    /**
     * @param null $store_id
     * @return string
     */
    public function getItemVariantFormat($store_id = null)
    {
        $formatId = $this->scopeConfig->getValue(
            'googletagmanager/general/item_variant_format',
            ScopeInterface::SCOPE_STORE,
            $store_id
        );

        if (in_array($formatId, ItemVariantFormat::FORMAT)) {
            return $formatId;
        } else {
            return ItemVariantFormat::DEFAULT_FORMAT;
        }
    }

    /**
     * @param null $store_id
     * @return bool
     */
    public function isCategoryLayerEnabled($store_id = null)
    {
        return $this->scopeConfig->isSetFlag(
            'googletagmanager/general/category_layer',
            ScopeInterface::SCOPE_STORE,
            $store_id
        );
    }

    /**
     * @param OrderItem $item
     * @return array
     */
    public function getCategories($item)
    {
        if (!$this->isCategoryLayerEnabled()) {
            return [];
        }

        if (!array_key_exists($item->getItemId(), $this->categories)) {
            $collection = $item->getProduct()->getCategoryCollection()->addAttributeToSelect('name');
            $categories = [];

            if ($collection->getSize()) {
                foreach ($collection as $category) {
                    if (!in_array($category->getName(), $categories)) {
                        $categories[] = $category->getName();
                    }
                }
            }

            $this->categories[$item->getItemId()] = $categories;
        }

        return $this->categories[$item->getItemId()];
    }

    /**
     * @param OrderItem|QuoteItem $item
     * @return string
     */
    public function getFirstCategory($item)
    {
        if ($item instanceof OrderItem || $item instanceof QuoteItem) {
            $categories = $this->getCategories($item);

            if (count($categories)) {
                return $categories[0];
            }
        }

        return '';
    }

    /**
     * @param array $options
     * @return array
     */
    public function getItemOptions($options)
    {
        $result = [];

        if ($options && is_array($options)) {
            if (isset($options['options'])) {
                $result = array_merge($result, $options['options']);
            }
            if (isset($options['additional_options'])) {
                $result = array_merge($result, $options['additional_options']);
            }
            if (isset($options['attributes_info'])) {
                $result = array_merge($result, $options['attributes_info']);
            }
        }

        return (array) $result;
    }

    /**
     * @param $item
     * @return mixed|string
     */
    public function getItemVariant($item)
    {
        if (!$this->isItemVariantLayerEnabled()) {
            return '';
        }

        if (!array_key_exists($item->getItemId(), $this->variants)) {
            $productOptions = [];

            if ($item instanceof OrderItem) {
                $productOptions = $this->getItemOptions($item->getProductOptions());
            } elseif ($item instanceof QuoteItem) {
                $itemOptionInstance = $item->getProduct()->getTypeInstance(true)->getOrderOptions($item->getProduct());
                $productOptions = $this->getItemOptions($itemOptionInstance);
            }

            $this->variants[$item->getItemId()] = $this->getItemVariantOption($productOptions);
        }

        return $this->variants[$item->getItemId()];
    }

    /**
     * @param $productOptions
     * @return string
     */
    public function getItemVariantOption($productOptions)
    {
        $result = [];
        $format = ItemVariantFormat::FORMAT;
        $title = '';

        if (is_array($productOptions)) {
            foreach ($productOptions as $productOption) {
                $template = [];

                if (is_array($productOption) && array_key_exists('value', $productOption)) {
                    $template['{{value}}'] = $productOption['value'];
                }

                if (is_array($productOption) && array_key_exists('label', $productOption)) {
                    $template['{{label}}'] = $productOption['label'];
                }

                if (!empty($template)) {
                    $result[] = str_replace(
                        array_keys($template),
                        array_values($template),
                        $format[$this->getItemVariantFormat()]
                    );
                }
            }
        }

        if (!empty($result)) {
            $title =  implode(' / ', $result);
        }

        return $title;
    }

    /**
     * @param $item
     * @param $qty
     * @return array
     */
    public function getProductObject($item, $qty)
    {
        $product = [
            'name' => $item->getName(),
            'id' => $item->getSku(),
            'price' => $this->formatPrice($item->getPrice() ?: $item->getProduct()->getPrice()),
            'quantity' => $qty * 1,
            'parent_sku' => $item->getProduct()->getData('sku'),
        ];

        if ($variant = $this->getItemVariant($item)) {
            $product['variant'] = $variant;
        }

        if (!empty($category = $this->getFirstCategory($item))) {
            $product['category'] = $category;
        }

        return $product;
    }
}
