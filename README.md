## Google Tag Manager for Magento2 with Data Layer

[![Total Downloads](https://poser.pugx.org/magepal/magento2-googletagmanager/downloads)](https://packagist.org/packages/magepal/magento2-googletagmanager)
[![Latest Stable Version](https://poser.pugx.org/magepal/magento2-googletagmanager/v/stable)](https://packagist.org/packages/magepal/magento2-googletagmanager)

Google Tag Manager allows you to quickly and easily add or update AdWords, Google Analytics, Facebook Tags and other code snippets on your website without edit to your magento 2 codebase.

### Features
* Quick and easy setup
* Add tag via XML layout and/or observer
* Data layer support

## Installation

#### Step 1
##### Using Composer (recommended)
```
composer require magepal/magento2-googletagmanager
```

##### Manually
 * Download the extension
 * Unzip the file
 * Create a folder {Magento 2 root}/app/code/MagePal/GoogleTagManager
 * Copy the content from the unzip folder


#### Step 2 - Enable GTM ("cd" to {Magento root} folder)
```
  php -f bin/magento module:enable --clear-static-content MagePal_GoogleTagManager
  php -f bin/magento setup:upgrade
```

#### Step 3 - Configure GTM

Log into your Magento 2 Admin, then goto Stores -> Configuration -> MagePal -> Google Tag Manager and enter your GTM account credentials

### Data layer attributes
---------
* pageType (i.e catalog_category_view)
* list (cart, category, detail, other)

#### Customer
* customer.isLoggedIn
* customer.id
* customer.groupId

#### Category
* category.id
* category.name
* category.path

#### Product
* product.id
* product.name
* product.sku
* product.path

#### Cart
* cart.hasItems
* cart.items[].sku
* cart.items[].name
* cart.items[].price
* cart.items[].quantity
* cart.total
* cart.itemCount
* cart.itemQty
* cart.hasCoupons
* cart.couponCode

#### Order
* transactionId
* transactionAffiliation
* transactionTotal
* transactionShipping
* transactionTax
* transactionCouponCode
* transactionDiscount
* transactionSubTotal
* transactionProducts[].sku
* transactionProducts[].name
* transactionProducts[].price
* transactionProducts[].quantity

Contribution
---
Want to contribute to this extension? The quickest way is to open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).


Support
---
If you encounter any problems or bugs, please open an issue on [GitHub](https://github.com/magepal/magento2-googletagmanager/issues).

Need help setting up or want to customize this extension to meet your business needs? Please email support@magepal.com and if we like your idea we will add this feature for free or at a discounted rate.

© MagePal LLC.
