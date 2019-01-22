<?php
namespace tests;

use Germania\Shipping\ShipmentItem;
use Germania\Shipping\ShipmentItemInterface;
use Germania\Tracking\TrackingInfoInterface;

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



    public function provideShippingData()
    {
        return array(
            [ 'foo' ]
        );
    }

}
