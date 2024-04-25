# GLS Poland
GLS Poland Shipping module for Magento 2 and Adobe Commerce.

## Installation
To install the GLS Poland Shipping module use composer.

### Add repository
Add new repository to your composer.json file with:

/** TODO: Add a GLS client repo **/

```bash
composer config repositories.gls-poland git https://github.com/glspoland/Magento-Integration-Module.git
```

### Require repository
Then you can require the repo with:

/** TODO: Add a GLS client repo **/

```bash
composer require glspoland/module-shipping:0.0.24
```

### Module Setup
To install the GLS Poland Shipping module, you need to run the following CLI commands in magento root directory.

Enable GLS Poland Shipping module in Magento
```
php bin/magento module:enable GlsPoland_Shipping
```

Setup Magento
```
php bin/magento setup:upgrade
```

Compile code
```
php bin/magento setup:di:compile
```

Deploy static content
```
php bin/magento setup:static-content:deploy
```

Flush cache 
```
php bin/magento cache:flush
```

## Tested with Magento 2 versions
* Magento 2 (Community Edition) 
  * ver. 2.4.6-p2
  * ver. 2.4.6-p3

* Adobe Commerce (Enterprise Edition)
  * ver. 2.4.6-p2
  * ver. 2.4.6-p3
