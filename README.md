## Google Tag Manager for Magento2 with Data Layer
Google Tag Manager allows you to quickly and easily add or update AdWords, Google Analytics, Facebook Tags and other code snippets on your website without editing any site code.

#Features
Quick and easy setup
Add tag via XML layout
Data layer support

#### Installation
1. Install Google Tag Manager
 * Download the extension
 * Unzip the file
 * Create a folder {Magento root}/app/code/MagePal/GoogleTagManager
 * Copy the content from the unzip folder

 * php -f bin/magento module:enable --clear-static-content MagePal_GoogleTagManager
 * php -f bin/magento setup:upgrade

2. Log into your Magetno Admin, then goto Store -> System -> MagePal -> Google Tag Manager and enter your GTM account credentials

###Data layer attributes
---------
* pageType (i.e catalog_category_view)
* list (cart, category, detail, other)

####Customer
* customer.isLoggedIn
* customer.id
* customer.groupId

####Category
* category.id
* customer.category

####Product
* product.id
* product.name
* product.sku

####Cart
* cart.hasItems
* cart.items[].sku
* cart.items[].name
* cart.items[].price
* cart.items[].quantity
* cart.total
* cart.itemCount
* cart.hasCoupons
* cart.couponCode

