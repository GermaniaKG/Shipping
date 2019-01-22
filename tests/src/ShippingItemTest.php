<?php
namespace tests;

use Germania\Shipping\ShipmentItem;
use Germania\Shipping\ShipmentItemInterface;
use Germania\Tracking\TrackingInfoInterface;
use Germania\Tracking\TrackingInfo;

use Prophecy\Argument;

class ShippingItemTest extends \PHPUnit\Framework\TestCase
{


    /**
     * @dataProvider provideShippingData
     */
    public function testDeliveryNoteNumberInterceptors( $delivery_note_number )
    {
        $sut = new ShipmentItem;

        $this->assertEmpty( $sut->getDeliveryNoteNumber() );

        $sut->setDeliveryNoteNumber( $delivery_note_number );
        $this->assertEquals( $delivery_note_number, $sut->getDeliveryNoteNumber() );
    }


    /**
     * @dataProvider provideShippingData
     */
    public function testTrackingInfoInterceptors( $delivery_note_number )
    {
        $sut = new ShipmentItem;

        $this->assertEmpty( $sut->getTrackingInfo() );

        $tracking_info_mock = $this->prophesize( TrackingInfoInterface::class );
        $tracking_info = $tracking_info_mock->reveal();

        $sut->setTrackingInfo( $tracking_info );
        $this->assertEquals( $tracking_info, $sut->getTrackingInfo() );
    }


    /**
     * @dataProvider provideShippingData
     */
    public function testFluentInterface( $delivery_note_number )
    {
        $sut = new ShipmentItem;

        $fluent = $sut->setDeliveryNoteNumber( $delivery_note_number );
        $this->assertInstanceOf( ShipmentItemInterface::class , $fluent );
    }


    public function testJson( )
    {
        $sut = new ShipmentItem;

        $this->assertEmpty( $sut->getTrackingInfo() );

        $tracking_info = new TrackingInfo;
        $tracking_info->setTrackingID("foo");
        $tracking_info->setTrackingLink("bar");

        $sut->setTrackingInfo( $tracking_info );
        # $json = $sut->jsonSerialize();
        $json = json_decode(json_encode($sut));

        $this->assertObjectHasAttribute("delivery_note_number", $json);
        $this->assertObjectHasAttribute("tracking_info", $json);

        $ti = $json->tracking_info;
        $this->assertObjectHasAttribute("id", $ti);
        $this->assertObjectHasAttribute("href", $ti);

    }



    public function provideShippingData()
    {
        return array(
            [ 'foo' ]
        );
    }

}
