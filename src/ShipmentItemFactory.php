<?php
namespace Germania\Shipping;

use Germania\Tracking\TrackingInfo;

class ShipmentItemFactory
{

    public $php_record_class = ShipmentItem::class;


    public function fromArray( $data )
    {

        if (!is_array($data)
        and !$data instanceOf \ArrayAccess):
            throw new \InvalidArgumentException("Array or ArrayAccess instance expected");
        endif;

        // Setup new instance
        $php_class = $this->php_record_class;
        $shipment_item = new $php_class;

        // Required fields:
        if (empty($data['delivery_note_number'])
        or  empty($data['tracking_id'])
        or  empty($data['tracking_link'])):
            $msg = "Raw data array requires keys 'delivery_note_number', 'tracking_id', 'tracking_link'";
            throw new \UnexpectedValueException( $msg );
        endif;


        $tracking_info = new TrackingInfo;
        $tracking_info->setTrackingID( $data['tracking_id'] );
        $tracking_info->setTrackingLink( $data['tracking_link'] );

        $shipment_item->setTrackingInfo( $tracking_info );
        $shipment_item->setDeliveryNoteNumber( $data['delivery_note_number'] );

        return $shipment_item;
    }
}
