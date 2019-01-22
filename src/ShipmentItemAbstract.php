<?php
namespace Germania\Shipping;

use Germania\Tracking\TrackingInfoProviderTrait;

abstract class ShipmentItemAbstract implements ShipmentItemInterface
{

    use TrackingInfoProviderTrait;

    /**
     * Sender's delivery note number (German: "Lieferscheinnummer")
     * @var string
     */
    public $delivery_note_number = "";


    /**
     * @inheritDoc
     */
    public function getDeliveryNoteNumber() : string
    {
        return $this->delivery_note_number;
    }


}
