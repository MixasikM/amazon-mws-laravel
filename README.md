amazon-mws-laravel
============

A PHP package to connect to Amazon's Merchant Web Services (MWS) in an object-oriented manner, with a focus on intuitive usage.

Currently optimizing for Laravel Framework.

This is __NOT__ for Amazon Web Services (AWS) - Cloud Computing Services.

## Installation

1. `composer require mixasikm/amazon-mws-laravel`

2. add the service provider to the providers array in config/app.php:
```
MixasikM\AmazonMws\ServiceProvider::class,
```

There's no facades to add in config/app.php

3. Copy amazon-mws.php configuration file from src/config/amazon-mws.php to Laravel's config directory.

## Usage
All of the technical details required by the API are handled behind the scenes,
so users can easily build code for sending requests to Amazon
without having to jump hurdles such as parameter URL formatting and token management. 
The general work flow for using one of the objects is this:

1. Create an object for the task you need to perform.
2. Load it up with parameters, depending on the object, using *set____* methods.
3. Submit the request to Amazon. The methods to do this are usually named *fetch____* or *submit____* and have no parameters.
4. Reference the returned data, whether as single values or in bulk, using *get____* methods.
5. Monitor the performance of the library using the built-in logging system.

Note that if you want to act on more than one Amazon store, you will need a separate object for each store.

Also note that the objects perform best when they are not treated as reusable. Otherwise, you may end up grabbing old response data if a new request fails.

## Example Usage

Here are a couple of examples of the library in use.
All of the technical details required by the API are handled behind the scenes,
so users can easily build code for sending requests to Amazon
without having to jump hurdles such as parameter URL formatting and token management. 

Here is an example of a function used to get all warehouse-fulfilled orders from Amazon updated in the past 24 hours:
```php
use MixasikM\AmazonMws\AmazonOrderList;

function getAmazonOrders() {
    $amz = new AmazonOrderList("myStore"); //store name matches the array key in the config file
    $amz->setLimits('Modified', "- 24 hours");
    $amz->setFulfillmentChannelFilter("MFN"); //no Amazon-fulfilled orders
    $amz->setOrderStatusFilter(
        array("Unshipped", "PartiallyShipped", "Canceled", "Unfulfillable")
        ); //no shipped or pending
    $amz->setUseToken(); //Amazon sends orders 100 at a time, but we want them all
    $amz->fetchOrders();
    return $amz->getList();
}
```
This example shows a function used to send a previously-created XML feed to Amazon to update Inventory numbers:
```php
use MixasikM\AmazonMws\AmazonOrderList;

function sendInventoryFeed($feed) {
    $amz = new AmazonFeed("myStore"); //store name matches the array key in the config file
    $amz->setFeedType("_POST_INVENTORY_AVAILABILITY_DATA_"); //feed types listed in documentation
    $amz->setFeedContent($feed);
    $amz->submitFeed();
    return $amz->getResponse();
}
```
