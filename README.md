<a href="http://www.magepal.com" title="Magento2 Custom Developer" ><img src="https://image.ibb.co/dHBkYH/Magepal_logo.png" width="100" align="right" alt="MagePal Extensions" /></a>

## Google Tag Manager for Magento2 with Data Layer

[![Total Downloads](https://poser.pugx.org/magepal/magento2-googletagmanager/downloads)](https://packagist.org/packages/magepal/magento2-googletagmanager)
[![Latest Stable Version](https://poser.pugx.org/magepal/magento2-googletagmanager/v/stable)](https://packagist.org/packages/magepal/magento2-googletagmanager)

Google Tag Manager (GTM) is a user-friendly solution which simplifies the process of adding, edit and manage JavaScript tags and other snippets of code on your Magento site. You can quickly and easily add Facebook tags, AdWords Conversion Tracking, Remarketing, DoubleClick code, Google Analytics and many more in a breeze without the need for a developer to make changes to your Magento code base. GTM makes running your digital marketing campaigns much easier when calibrating with multiple department and agencies by making available the right set of tools so that everyone can get their job done quickly.

Our extension provide a vast array of data to make integrating your Magento store with Google Tag Manager a breeze, and easily customize to add your own customization or data.

Want to track more? Upgrade to our new [Enhanced E-commerce for Google Tag Manager v1.2.0](https://www.magepal.com/enhanced-ecommerce-for-google-tag-manager.html?utm_source=Enhanced%20Ecommerce%20for%20Google%20Tag%20Manager&utm_medium=github) to take full advantage of Google Analytics most powerful e-commerce features. Gain valuable insight and increase your conversion rate by leveraging Google Enhanced Ecommerce to understand the value of each user actions and behaviors.


Learn more about our [Google Enhanced Ecommerce](https://www.magepal.com/enhanced-ecommerce-for-google-tag-manager.html?utm_source=Enhanced%20Ecommerce%20for%20Google%20Tag%20Manager&utm_medium=github) extension. A small increase in your store’s conversion rate can make a giant impact on your revenue.

![Google Tag Manager for Magento](https://image.ibb.co/dhmoLx/Google_Tag_Manager_for_Magento2_by_Magepal.png)

### Features
* Quick and easy setup
* Add tag via XML layout and/or observer
* Advance Data layer
* Customizable to add any data to the data layer 

## Installation

#### Step 1
##### Using Composer (recommended)
```
composer require magepal/magento2-googletagmanager
```

##### Manually  (not recommended)
 * Download the extension
 * Unzip the file
 * Create a folder {Magento 2 root}/app/code/MagePal/GoogleTagManager
 * Copy the content from the unzip folder


#### Step 2 - Enable GTM ("cd" to {Magento root} folder)
```
  php -f bin/magento module:enable --clear-static-content MagePal_GoogleTagManager
  php -f bin/magento setup:upgrade
```

#### Step 3 - How to Configure Google Tag Manager

Log into your Magento 2 Admin, then goto Stores -> Configuration -> MagePal -> Google Tag Manager and enter your GTM account credentials

## Data layer attributes

* Trigger: event equals gtm.dom
  * pageType (i.e catalog_category_view)
  * list (cart, category, detail, other)


#### Customer
* Trigger: event equals mpCustomerSession
  * customer.isLoggedIn
  * customer.id
  * customer.groupId


#### Category
* Trigger: event equals categoryPage
  * category.id
  * category.name
  * category.path

#### Product
* Trigger: event equals productPage
  * product.id
  * product.name
  * product.sku
  * product.parent_sku
  * product.path

#### Cart
* Trigger: event equals cartPage
  * cart.hasItems
  * cart.items[].sku
  * cart.items[].parent_sku
  * cart.items[].product_type
  * cart.items[].name
  * cart.items[].price
  * cart.items[].quantity
  * cart.total
  * cart.itemCount
  * cart.itemQty
  * cart.hasCoupons
  * cart.couponCode

#### Order
* Trigger: event equals gtm.orderComplete (Google Analytics)
  * transactionId
  * transactionAffiliation
  * transactionTotal
  * transactionShipping
  * transactionTax
  * transactionCouponCode
  * transactionDiscount
  * transactionSubTotal
  * transactionProducts[].sku
  * transactionProducts[].parent_sku
  * transactionProducts[].product_type
  * transactionProducts[].name
  * transactionProducts[].price
  * transactionProducts[].quantity
  
* Additional Order Date (Generic)
  * order.order_id
  * order.store_name
  * order.total
  * order.subtotal
  * order.shipping
  * order.tax
  * order.coupon_code
  * order.coupon_name
  * order.discount
  * order.payment_method.title
  * order.payment_method.code
  * order.shipping_method.title
  * order.shipping_method.code
  * order.is_virtual
  * order.is_guest_checkout
  * order.items[].sku
  * order.items[].parent_sku
  * order.items[].name
  * order.items[].price
  * order.items[].quantity
  * order.items[].variant
  * order.items[].categories
  
  
#### Need to add more content to the data layer or change existing values?
Add more information to the data layer to meet your client needs is as simple as adding few lines of php and di.xml code in your custom extension.

##### API Class Name
MagePal\GoogleTagManager\DataLayer\CategoryData\CategoryAbstract

MagePal\GoogleTagManager\DataLayer\ProductData\ProductAbstract

MagePal\GoogleTagManager\DataLayer\QuoteData\QuoteItemAbstract

MagePal\GoogleTagManager\DataLayer\QuoteData\QuoteAbstract

MagePal\GoogleTagManager\DataLayer\OrderData\OrderItemAbstract

MagePal\GoogleTagManager\DataLayer\OrderData\OrderAbstract

##### di.xml DataProvider name
MagePal\GoogleTagManager\DataLayer\CategoryData\CategoryProvider

MagePal\GoogleTagManager\DataLayer\ProductData\ProductProvider

MagePal\GoogleTagManager\DataLayer\QuoteData\QuoteItemProvider

MagePal\GoogleTagManager\DataLayer\QuoteData\QuoteProvider

MagePal\GoogleTagManager\DataLayer\OrderData\OrderItemProvider

MagePal\GoogleTagManager\DataLayer\OrderData\OrderProvider



##### Sample Extension
  
```
namespace MagePal\GoogleTagManagerAddons\DataLayer\OrderData;
    
/**
 * Class OrderProvider
 * @package MagePal\GoogleTagManager\DataLayer
 * @method getItem()
 * @method getOrder()
 * @method getListType()
 */
class ItemBrandProvider extends MagePal\GoogleTagManager\DataLayer\OrderData\OrderItemAbstract
{
    /**
     * @return array
     */
    public function getData()
    {
        $data =  [
            'brand' => $this->getItem()->getProduct()->getManufacturer()
        ];

        return $data;
    }
}
```

di.xml
```
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:ObjectManager/etc/config.xsd">
    <type name="MagePal\GoogleTagManager\DataLayer\OrderData\OrderItemProvider">
        <arguments>
            <argument name="orderItemProviders" xsi:type="array">
                <item name="order-item-provider-brand" xsi:type="object">MagePal\GoogleTagManagerAddons\DataLayer\OrderData\ItemBrandProvider</item>
            </argument>
        </arguments>
    </type>
</config>
```
  

Contribution
---
Want to contribute to this extension? The quickest way is to open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).


Support
---
If you encounter any problems or bugs, please open an issue on [GitHub](https://github.com/magepal/magento2-googletagmanager/issues). For fast Premium Support visit our [Google Tag Manager](https://www.magepal.com/magento2/extensions/google-tag-manager.html?utm_source=GTM&utm_medium=Premium%20Support) product page for detail.

Need help setting up or want to customize this extension to meet your business needs? Please email support@magepal.com and if we like your idea we will add this feature for free or at a discounted rate.

Other Extensions
---
[Custom SMTP](https://www.magepal.com/magento2/extensions/custom-smtp.html) | [Google Tag Manager](https://www.magepal.com/magento2/extensions/google-tag-manager.html) | [Enhanced E-commerce](https://www.magepal.com/magento2/extensions/enhanced-ecommerce-for-google-tag-manager.html) | [Reindex](https://www.magepal.com/magento2/extensions/reindex.html) | [Custom Shipping Method](https://www.magepal.com/magento2/extensions/custom-shipping-rates-for-magento-2.html) | [Preview Order Confirmation](https://www.magepal.com/magento2/extensions/preview-order-confirmation-page-for-magento-2.html) | [Guest to Customer](https://www.magepal.com/magento2/extensions/guest-to-customer.html) | [Admin Form Fields Manager](https://www.magepal.com/magento2/extensions/admin-form-fields-manager-for-magento-2.html) | [Customer Dashboard Links Manager](https://www.magepal.com/magento2/extensions/customer-dashboard-links-manager-for-magento-2.html) | [Lazy Loader](https://www.magepal.com/magento2/extensions/lazy-load.html) | [Order Confirmation Page Miscellaneous Scripts](https://www.magepal.com/magento2/extensions/order-confirmation-miscellaneous-scripts-for-magento-2.html)

© MagePal LLC. | [www.magepal.com](http:/www.magepal.com)
