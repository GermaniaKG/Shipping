<?php
namespace Germania\Shipping;

use Germania\Tracking\TrackingInfoAwareInterface;

interface ShipmentItemInterface extends DeliveryNoteNumberProviderInterface, TrackingInfoAwareInterface, \JsonSerializable
{


}
