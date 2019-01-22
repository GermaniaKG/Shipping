# Germania KG · Shipping

**Classes and interfaces for dealing with shipment items**

![](https://img.shields.io/packagist/php-v/germania-kg/shipping.svg)
![](https://img.shields.io/travis/GermaniaKG/Shipping.svg)
![](https://img.shields.io/scrutinizer/g/germaniakg/shipping.svg)
![](https://img.shields.io/scrutinizer/coverage/g/GermaniaKG/Shipping.svg)


## Installation

```bash
$ composer require germania-kg/shipping
```



## Requirements

This package requires [germania-kg/tracking](https://packagist.org/packages/germania-kg/tracking) package.



## Usage



### ShipmentItemInterface

The **ShipmentItemInterface** extends *Germania\Shipping\DeliveryNoteNumberProviderInterface* and *Germania\Tracking\TrackingInfoProviderInterface*. It provides grants these methods:

- *getDeliveryNoteNumber*
- *getTrackingInfo*



### ShipmentItem

The **ShipmentItem** class implements *ShipmentItemInterface* and additionally provides setter methods *setTrackingInfo* and *setDeliveryNoteNumber*:

```php
<?php
use Germania\Shipping\ShipmentItem;
use Germania\Tracking\TrackingInfo;

// Prepare components
$tracking_info = new TrackingInfo;
$tracking_info->setTrackingID("foo");
$tracking_info->setTrackingLink("https://track.test.com/?id=foo");

// Use setters
$item = new ShipmentItem;
$item->setDeliveryNoteNumber( "123456" );
$item->setTrackingInfo( $tracking_info );

// Eval
echo $item->getDeliveryNoteNumber();              // "123456"
echo $item->getTrackingInfo()->getTrackingLink(); // "https://track.test.com/?id=foo"
echo $item->getTrackingInfo()->getTrackingID();   // "foo"

```



### ShipmentItemFactory

The **fromArray** method accepts both *array* and *ArrayAccess* with these keys required:

- delivery_note_number
- tracking_id
- tracking_link

Anything else passed will trigger a *InvalidArgumentException* or *UnexpectedValueException* respectively.

```php
<?php
use Germania\Shipping\ShipmentItemFactory;  
use Germania\Shipping\ShipmentItemInterface;  

$item_factory = new ShipmentItemFactory;
$item = $item_factory->fromArray([
 	'delivery_note_number' => '123456',
  'tracking_id' => 'foo',
  'tracking_link' => 'https://track.test.com/?id=foo'
]);

echo ($item instanceOf ShipmentItemInterface)
? "OK" : "huh?";
```



### ShipmentItemBundle

Bundles multiple shipment items and lets you add a textual description. It additionally implements **\IteratorAggregate** and **\Countable**.

```php
<?php
use Germania\Shipping\ShipmentItemBundle; 

// Prepare
$item1 = new ShipmentItem; #...
$item2 = new ShipmentItem; #...

$items = array(
	$item1,
  $item2
);

// Setup bundle
$description = "Optional: textual desription";
$bundle = new ShipmentItemBundle( $items, $description);
$bundle = new ShipmentItemBundle( $items);

// Add item
$bundle->push( new ShipmentItem );

// Play
$array = $bundle->getDeliveryNoteNumbers();
echo $bundle->getDescription();
echo count( $bundle ); // int 3

foreach ($bundle as $item) {
	echo $item->getDeliveryNoteNumber();  
}

```




## Development

```bash
$ git clone https://github.com/GermaniaKG/Shipping.git shipping
$ cd shipping
$ composer install

# Run PhpUnit
$ composer test
```

