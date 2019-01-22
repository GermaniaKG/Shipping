<?php
namespace Germania\Shipping;

use Germania\Tracking\TrackingInfoProviderInterface;

interface ShipmentItemInterface extends DeliveryNoteNumberProviderInterface, TrackingInfoProviderInterface
{


}
