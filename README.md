<a href="http://www.magepal.com" title="Magento2 Custom Developer" ><img src="https://image.ibb.co/dHBkYH/Magepal_logo.png" width="100" align="right" alt="MagePal Extensions" /></a>

# Google Tag Manager for Magento 2 with Advance Data Layer

[![Total Downloads](https://poser.okvpn.org/magepal/magento2-googletagmanager/downloads)](https://packagist.org/packages/magepal/magento2-googletagmanager)
[![Latest Stable Version](https://poser.okvpn.org/magepal/magento2-googletagmanager/v/stable)](https://packagist.org/packages/magepal/magento2-googletagmanager)

##### For Magento 2.0.x, 2.1.x, 2.2.x and 2.3.x

### What is Google Tag Manager
Google Tag Manager (GTM) is a user-friendly, powerful and essential integration for every Magento store. It simplifies the process of adding, edit and manage third-party JavaScript tags and other snippets of code on your Magento site. 
With GTM, you can quickly and easily add Facebook tags, AdWords Conversion Tracking, Re-marketing, Bing UET, SnapChat, DoubleClick code, Google Analytics and many more in a breeze without the need for a developer to make changes to your Magento code providing the data is available to Google Tag Manager. 

Google Tag Manager makes running your digital marketing campaigns much easier when calibrating with multiple department and Ad agencies by making available the right set of tools so that everyone can get their job done quickly without relying on developers. 

Without having the all data you need at your finger tips your integration will become a difficult, time consuming and messy since each developer will only focus on the current task at hand instead of focusing on writing reusable components for future integration.

Our extension provide a vast array of over 60 preconfigure data layer elements to make integrating your Magento store with any other third-party service a breeze using Google Tag Manager. 
Extracting, customizing and adding your own custom data from your Magento store to Google Tag Manager is as easy as 10 lines of code using our easy to customize APIs.

>:warning: Google Tag Manager 2.3.0 has some breaking changes to Enhanced Ecommerce. Please download the latest version of Enhanced Ecommerce 1.2.0 or greater from www.magepal.com account.


### Why use our Google Tag Manager extension?
Google Tag Manager is only as powerful as the data layer powering it. Adding Google Tag Manager code snippet to the header section of your Magento store may seems like the ideal quick and easy way to add GTM. But this will not be sufficient when integrating any third-parties tracking codes that require site specific data from Magento, such as page type, product name, product price, order items, order id or any other data. Our extension provide all the necessary data elements to accomplish any integration with in 2 minutes and if the data is not available then you can quickly extending our extension with a few lines of code.
Learn more about [customizing Google Tag Manger](https://www.magepal.com/help/docs/google-tag-manager-for-magento/#api). 

### Google Analytics Enhanced E-commerce
Want to track more? Upgrade to our new [Enhanced E-commerce for Google Tag Manager v1.2.0](https://www.magepal.com/enhanced-ecommerce-for-google-tag-manager.html?utm_source=Enhanced%20Ecommerce%20for%20Google%20Tag%20Manager&utm_medium=github) to take full advantage of Google Analytics most powerful e-commerce features. 
Gain valuable insight and increase your conversion rate by leveraging Google Enhanced Ecommerce to better understand your user actions and behaviors.

Learn more about our [Google Enhanced Ecommerce](https://www.magepal.com/enhanced-ecommerce-for-google-tag-manager.html?utm_source=Enhanced%20Ecommerce%20for%20Google%20Tag%20Manager&utm_medium=github) extension today. A small increase in your store’s conversion rate can make a giant impact on your revenue.

### Third Party Integration with Google Tag Manager
Adding Facebook pixel, Bing UAT, SnapChat or any other third-party code snippet to your website but frustrated by
all the hassle and time it take to configure Google Tag Manager? Learn how simple and easy it is to integrate any 
tracking code to your Magento store with our new [DataLayer extension](https://www.magepal.com/datalayer-for-google-tag-manager.html?utm_source=data%20layer%20for%20Google%20Tag%20Manager&utm_medium=github).

### General Data Protection Regulation (GDPR) Support
Now you can quickly disable analytic tracking for customer who do not want to by track by enabling Cookie Restriction Mode or base on existing or non-existing cookie.
 
 - Stores > Configuration > General > Web > Default Cookie Settings > Cookie Restriction Mode. 
 
Please Note: Merchants should consult with their own legal counsel to ensure that they are compliant with the GDPR. 

### Features
* Quick and easy setup
* Add tag via XML layout and/or observer
* Advance Data layer with over 60+ data elements
* Fully customizable with 10 lines of code
* General Data Protection Regulation (GDPR) Support

![Google Tag Manager for Magento](https://image.ibb.co/dhmoLx/Google_Tag_Manager_for_Magento2_by_Magepal.png)

### Benefits of using Google Tag Manager with Magento
There are a number of benefits to using GTM with Magento:

- One Centralized Tag Management source - Google tag Manager is one of the tops and most widely used JavaScript tag management, therefore, anyone with Google Tag Manager experience will have all the knowledge they need to make edits to your site.
- Little to No Technically Knowledge - Digital marketer agencies with so tech skills can quickly make and publish changes to Google Tag Manager without needing to call in developers.
- Version Control - Every change to your Googe Tag Manager container is tracked with a history of who and what was changed. 
- Easy to Use - Google Tag Manager is very simple and easy to use. You can easily export your GTM configuration in a text file that could be saved and reimport.
- Reduce Number of Magento Extensions Needed - Installing individual extensions for AdWords, Facebook tracking, Snapchat, Microsoft Bing is time consuming and resource intensive on your Magento store. Using Tag Manager you only need to install and maintaining one extension.
- Eliminate Themes and Order Success Page Edits - 99% of merchants, developers and agencies don't know or use best practice when inserting javascript tracking code snippets to a Magento store, and often just add hardcode each javascript code snippets at random places within the themes files which make it unmaintainable over time as you switch between different service provider. 

### How to Customize Google Tag Manager Extension 
Need to add more data to your data layer or change existing data to meet your client needs?
Add, changing or removing information from the data layer to meet your client needs is as simple as adding few lines of 
php and di.xml code. See our documentation to learn more about 
[how to customizing Google Tag Manger](https://www.magepal.com/help/docs/google-tag-manager-for-magento/#api).

  
### Documentation & Installation Guide

[How to Installing Google Tag Manager](https://www.magepal.com/help/docs/google-tag-manager-for-magento/#installation)

[How to setup Google Tag Manager](https://www.magepal.com/help/docs/google-tag-manager-for-magento/#configuration)

[How to customizing Google Tag Manager](https://www.magepal.com/help/docs/google-tag-manager-for-magento/#api)

[Google Tag Manger Data Layer attributes](https://www.magepal.com/help/docs/google-tag-manager-for-magento/#datalayer)

[How to debugging Google Tag Manager](https://www.magepal.com/help/docs/google-tag-manager-for-magento/#debug)

### Composer Installation

```bash
composer require magepal/magento2-googletagmanager
```

### Data layer attributes

Our Magento extension provide a vast array of over 60 preconfigure data layer elements to make integrating your Magento store with any third-party service a breeze using Google Tag Manager.

* Trigger: event equals gtm.dom
  * pageType (i.e catalog_category_view)
  * list (cart, category, detail, other)


#### Customer
* Trigger: event equals mpCustomerSession
  * customer.isLoggedIn
  * customer.id
  * customer.groupId
  * order.email_sha1**
  * order.email**
  * order.customer_id**
  
#### Product Impression  
* Trigger: event equals productImpression
  * ecommerce.impressions[].name*
  * ecommerce.impressions[].id*
  * ecommerce.impressions[].price*
  * ecommerce.impressions[].list*
  * ecommerce.impressions[].position*
  * ecommerce.impressions[].category*


#### Category
* Trigger: event equals categoryPage
  * category.id
  * category.name
  * category.path

#### Product Detail Page
* Trigger: event equals productPage
  * product.id
  * product.name
  * product.sku
  * product.parent_sku
  * product.price
  * product.product_type
  * attribute_set_id
  * product.path
  
* Trigger: event equals productDetail
  * ecommerce.currencyCode*
  * ecommerce.products[].id*
  * ecommerce.products[].name*
  * ecommerce.products[].category*
  * ecommerce.products[].price*  

#### Cart
* Trigger: event equals cartPage
  * cart.hasItems
  * cart.items[].sku
  * cart.items[].parent_sku
  * cart.items[].product_type
  * cart.items[].name
  * cart.items[].parent_name
  * cart.items[].price
  * cart.items[].price_incl_tax
  * cart.items[].discount_amount
  * cart.items[].tax_amount
  * cart.items[].quantity
  * cart.total
  * cart.itemCount
  * cart.itemQty
  * cart.hasCoupons
  * cart.couponCode
  
##### Add to Cart
* Trigger: event equals addToCart
  * ecommerce.add.products[].id*
  * ecommerce.add.products[].name*
  * ecommerce.add.products[].price*
  * ecommerce.add.products[].quantity*
  * ecommerce.add.products[].parent_sku*
  * ecommerce.add.products[].variant*
  * ecommerce.add.products[].category*

##### Remove from Cart
* Trigger: event equals removeFromCart
  * ecommerce.remove.products[].id*
  * ecommerce.remove.products[].name*
  * ecommerce.remove.products[].price*
  * ecommerce.remove.products[].quantity*
  * ecommerce.remove.products[].variant*
  * ecommerce.remove.products[].category*

### Global Data Layer

* Trigger: event equals addToCart
  * cart.add.products[].id*
  * cart.add.products[].name*
  * cart.add.products[].price*
  * cart.add.products[].quantity*
  * cart.add.products[].parent_sku*
  * cart.add.products[].variant*
  * cart.add.products[].category*
  
* Trigger: event equals removeFromCart
  * cart.remove.products[].id*
  * cart.remove.products[].name*
  * cart.remove.products[].price*
  * cart.remove.products[].quantity*
  * cart.add.products[].parent_sku*
  * cart.remove.products[].variant*
  * cart.remove.products[].category*  

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
  * order.email_sha1**
  * order.email**
  * order.customer_id**
  * order.has_previous_order**
  * order.is_first_order**
  * order.previous_order_count**
  * order.is_new_customer**
  * order.items[].sku
  * order.items[].id
  * order.items[].parent_sku
  * order.items[].product_id
  * order.items[].name
  * order.items[].parent_name
  * order.items[].price
  * order.items[].price_incl_tax
  * order.items[].quantity
  * order.items[].subtotal
  * order.items[].product_type
  * order.items[].discount_amount
  * order.items[].discount_percent
  * order.items[].tax_amount
  * order.items[].is_virtual
  * order.items[].variant
  * order.items[].categories
 
`*` - Data layer provide by our [Enhanced Ecommerce Extension](https://www.magepal.com/enhanced-ecommerce-for-google-tag-manager.html)

`**`  - Data layer provide by our [Data Layer Extension](https://www.magepal.com/magento2/extensions/datalayer-for-google-tag-manager.html)
  

Contribution
---
Want to contribute to this extension? The quickest way is to open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).


Support
---
If you encounter any problems or bugs, please open an issue on [GitHub](https://github.com/magepal/magento2-googletagmanager/issues). For fast Premium Support visit our [Google Tag Manager](https://www.magepal.com/magento2/extensions/google-tag-manager.html?utm_source=GTM&utm_medium=Premium%20Support) product page for detail.

Need help setting up or want to customize this extension to meet your business needs? Please email support@magepal.com and if we like your idea we will add this feature for free or at a discounted rate.

Magento 2 Extensions
---

- [Enhanced E-commerce](https://www.magepal.com/magento2/extensions/enhanced-ecommerce-for-google-tag-manager.html) 
- [Enhanced Success Page for Magento 2](https://www.magepal.com/magento2/extensions/enhanced-success-page.html)
- [Enhanced Transactional Emails for Magento 2](https://www.magepal.com/magento2/extensions/enhanced-transactional-emails.html)
- [Google Tag Manager](https://www.magepal.com/magento2/extensions/google-tag-manager.html) 
- [Reindex](https://www.magepal.com/magento2/extensions/reindex.html) 
- [Custom Shipping Method](https://www.magepal.com/magento2/extensions/custom-shipping-rates-for-magento-2.html) 
- [Preview Order Confirmation](https://www.magepal.com/magento2/extensions/preview-order-confirmation-page-for-magento-2.html)
- [Guest to Customer](https://www.magepal.com/magento2/extensions/guest-to-customer.html) 
- [Admin Form Fields Manager](https://www.magepal.com/magento2/extensions/admin-form-fields-manager-for-magento-2.html) 
- [Customer Dashboard Links Manager](https://www.magepal.com/magento2/extensions/customer-dashboard-links-manager-for-magento-2.html) 
- [Lazy Loader](https://www.magepal.com/magento2/extensions/lazy-load.html) 
- [Order Confirmation Page Miscellaneous Scripts](https://www.magepal.com/magento2/extensions/order-confirmation-miscellaneous-scripts-for-magento-2.html)
- [HTML Minifier for Magento2](https://www.magepal.com/magento2/extensions/html-minifier.html)
- [Custom SMTP](https://www.magepal.com/magento2/extensions/custom-smtp.html)
- [Catalog Hover Image for Magento](https://www.magepal.com/magento2/extensions/catalog-hover-image-for-magento.html)

© MagePal LLC. | [www.magepal.com](http:/www.magepal.com)
