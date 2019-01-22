<?php
namespace Germania\Shipping;

interface DeliveryNoteNumberProviderInterface
{

    /**
     * Returns sender's delivery note number (German: "Lieferscheinnummer")
     * @return string
     */
    public function getDeliveryNoteNumber() : string;
}
