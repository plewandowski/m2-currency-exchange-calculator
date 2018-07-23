# Magento 2 currency exchange calculator

This is Magento 2 currency exchange calculator project build for training purposes. It demonstrated how to wrap external API in Magento API and consume it with JS widget.
It's simplified example. In production ready module some improvements would be recommended such of:
- external api response caching or keeping records in db table updated by regular cron job for performance and availability reasons
- better module configuration


## Installation
add following json to composer.json

```
{
"require": {
    "plewandowski/currency-exchange-calculator": "*"
}
...
 "repositories": [
    { "type": "vcs", "url": "https://github.com/plewandowski/m2-currency-exchange-calculator" }
 ]
}
```

then
```
composer update
```
## How it works in general?
1. Calculator block is added in footer via layout xml
2. Calculator frontend logic is a jQuery magento widget is initialized via data-mage-init
3. The widget callas M2 custom REST api resources to fetch actual currency rate
4. M2 REST api calls third-party (currentyl NBP API) underhood

Validation is done using magento validation componenet


