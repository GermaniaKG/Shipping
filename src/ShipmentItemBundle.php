<?php
namespace Germania\Shipping;



/**
 * Just for collecting Shipment items with a common textual description.
 */
class ShipmentItemBundle implements \IteratorAggregate, \Countable, \JsonSerializable
{

    /**
     * Textual description for this item bundle
     * @var string
     */
    public $description = "";

    /**
     * Shipment item storage
     * @var array
     */
    public $items = array();


    /**
     * @param array  $items       Shipment items
     * @param string $description Optional: textual description
     */
    public function __construct( array $items, string $description = "")
    {
        $this->description = $description;
        $this->items = $items;
    }


    /**
     * Returns the textual bundle description.
     * @return string
     */
    public function getDescription() : string
    {
        return $this->description;
    }


    /**
     * Returns an array with all Delivery note numbers
     * @return array
     */
    public function getDeliveryNoteNumbers()
    {
        return array_map(function($item) {
            return $item->getDeliveryNoteNumber();
        }, $this->items);
    }


    /**
     * Adds a ShipmentItem
     * @param  ShipmentItem $item
     * @return self
     */
    public function push( ShipmentItemInterface $item )
    {
        $this->items[] = $item;
        return $this;
    }


    /**
     * Counts the ShipmentItems
     * @inheritDoc
     */
    public function count()
    {
        return count( $this->items );
    }


    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return $this->items;
    }


    /**
     * @inheritDoc
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator( $this->items );
    }
}
