<?php
namespace Germania\Shipping;

use Germania\Tracking\TrackingInfoAwareTrait;
use Germania\Tracking\TrackingInfoAwareInterface;

class ShipmentItem extends ShipmentItemAbstract implements ShipmentItemInterface, TrackingInfoAwareInterface
{

    use TrackingInfoAwareTrait;

    /**
     * @param string $delivery_note_number
     */
    public function setDeliveryNoteNumber ( string $delivery_note_number )
    {
        $this->delivery_note_number = $delivery_note_number;
        return $this;
    }





}
