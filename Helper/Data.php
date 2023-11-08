<?php
/**
 * Copyright © MagePal LLC. All rights reserved.
 * See COPYING.txt for license details.
 * http://www.magepal.com | support@magepal.com
 */

namespace MagePal\GoogleTagManager\Helper;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Pricing\Price\FinalPrice;
use Magento\Catalog\Model\Product\Type;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    /**
     * Active flag
     */
    const XML_PATH_ACTIVE = 'googletagmanager/general/active';

    /**
     * Account number
     */
    const XML_PATH_ACCOUNT = 'googletagmanager/general/account';

    /**
     * Datalayer name
     */
    const XML_PATH_DATALAYER_NAME = 'googletagmanager/general/datalayer_name';

    /**
     * Path to configuration, check is enable cookie restriction mode
     */
    const XML_PATH_COOKIE_RESTRICTION = 'web/cookie/cookie_restriction';

    /**
     * @var string
     */
    protected $_dataLayerName = 'dataLayer';

    /**
     * Whether Tag Manager is ready to use
     *
     * @param null $store_id
     * @return bool
     */
    public function isEnabled($store_id = null)
    {
        $accountId = $this->scopeConfig->getValue(
            self::XML_PATH_ACCOUNT,
            ScopeInterface::SCOPE_STORE,
            $store_id
        );

        $active = $this->scopeConfig->isSetFlag(
            self::XML_PATH_ACTIVE,
            ScopeInterface::SCOPE_STORE,
            $store_id
        );

        return $accountId && $active;
    }

    /**
     * Whether Tag Manager should be loaded
     * by an external third party app
     *
     * @param null $store_id
     * @return bool
     */
    public function isExternal($store_id = null)
    {
        return $this->scopeConfig->getValue(
            'googletagmanager/general/external',
            ScopeInterface::SCOPE_STORE,
            $store_id
        );
    }    

    /**
     * @param null $store_id
     * @return string
     */
    public function getCookieRestrictionName($store_id = null)
    {
        return $this->scopeConfig->getValue(
            'googletagmanager/gdpr/restriction_cookie_name',
            ScopeInterface::SCOPE_STORE,
            $store_id
        );
    }

    /**
     * @param null $store_id
     * @return bool
     */
    public function isGdprEnabled($store_id = null)
    {
        return $this->scopeConfig->isSetFlag(
            'googletagmanager/gdpr/enabled',
            ScopeInterface::SCOPE_STORE,
            $store_id
        );
    }

    /**
     * @param null $store_id
     * @return int
     */
    public function getGdprOption($store_id = null)
    {
        return (int) $this->scopeConfig->getValue(
            'googletagmanager/gdpr/option',
            ScopeInterface::SCOPE_STORE,
            $store_id
        );
    }

    /**
     * @param null $store_id
     * @return int
     */
    public function addJsInHead($store_id = null)
    {
        return (int) $this->scopeConfig->isSetFlag(
            'googletagmanager/gdpr/add_js_in_header',
            ScopeInterface::SCOPE_STORE,
            $store_id
        );
    }

    /**
     * @param null $store_id
     * @return int
     */
    public function isMultiContainerEnabled($store_id = null)
    {
        return (int) $this->scopeConfig->isSetFlag(
            'googletagmanager/gtm_container/enabled',
            ScopeInterface::SCOPE_STORE,
            $store_id
        );
    }

    /**
     * @param null $store_id
     * @return string
     */
    public function getMultiContainerCode($store_id = null)
    {
        return trim($this->scopeConfig->getValue(
            'googletagmanager/gtm_container/code',
            ScopeInterface::SCOPE_STORE,
            $store_id
        ));
    }

    /**
     * Check if cookie restriction mode is enabled for this store
     * Fix issue in 2.1.9
     * @return bool
     */
    public function isCookieRestrictionModeEnabled()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_COOKIE_RESTRICTION,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Tag Manager Account ID
     *
     * @param null $store_id
     * @return null | string
     */
    public function getAccountId($store_id = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_ACCOUNT,
            ScopeInterface::SCOPE_STORE,
            $store_id
        );
    }

    /**
     * Format Price
     *
     * @param $price
     * @return float
     */
    public function formatPrice($price)
    {
        return (float)sprintf('%.2F', $price);
    }

    /**
     * @param null $store_id
     * @return string
     */
    public function getDataLayerName($store_id = null)
    {
        if (!$this->_dataLayerName) {
            $this->_dataLayerName = $this->scopeConfig->getValue(
                self::XML_PATH_DATALAYER_NAME,
                ScopeInterface::SCOPE_STORE,
                $store_id
            );
        }
        return $this->_dataLayerName;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setDataLayerName($name)
    {
        $this->_dataLayerName = $name;
        return $this;
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
     * @param ProductInterface $product
     * @param array $viewItem
     */
    public function addCategoryElements($product, &$viewItem)
    {
        if (!$this->isCategoryLayerEnabled() || !$product) {
            return;
        }

        $categoryList = [];
        $index = 1;
        $categoryCollection = $product->getCategoryCollection();
        $categories = $categoryCollection->addAttributeToSelect('name');

        if (array_key_exists('item_category', $viewItem)) {
            $index = 2;
            $categoryList[] = $viewItem['item_category'];
        }

        foreach ($categories as $category) {
            if (!in_array($category->getName(), $categoryList)) {
                $categoryList[] = $category->getName();

                if ($index == 1) {
                    $viewItem['item_category'] = $category->getName();
                    $index++;
                } else {
                    $viewItem['item_category' . $index] = $category->getName();
                    $index++;
                }

                if ($index >= 5) {
                    break;
                }
            }
        }
    }

    /**
     * @param $product
     * @return float
     */
    public function getProductPrice($product)
    {
        $price = 0;

        /** @var $product ProductInterface */
        if ($product) {
            $price = $product
                ->getPriceInfo()
                ->getPrice(FinalPrice::PRICE_CODE)
                ->getAmount()
                ->getBaseAmount() ?: 0;
        }

        if (!$price) {
            if ($product->getTypeId() == Type::TYPE_SIMPLE) {
                $price = $product->getPrice();
            } else {
                $price = $product->getFinalPrice();
            }
        }

        return $this->formatPrice($price);
    }
}
