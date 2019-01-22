<?php
namespace tests;

use Germania\Shipping\ShipmentItemFactory;
use Germania\Shipping\ShipmentItemInterface;

use Germania\Tracking\TrackingInfoInterface;


class ShipmentItemFactoryTest extends \PHPUnit\Framework\TestCase
{


    /**
     * @dataProvider provideValidShippingData
     */
    public function testFactoryMethod( $delivery_note_number, $tracking_id, $tracking_link )
    {
        $sut = new ShipmentItemFactory;
        $item = $sut->fromArray([
            'delivery_note_number' => $delivery_note_number,
            'tracking_id'          => $tracking_id,
            'tracking_link'        => $tracking_link
        ]);

        $this->assertInstanceOf( ShipmentItemInterface::class, $item);
        $this->assertEquals( $delivery_note_number, $item->getDeliveryNoteNumber() );

        $tracking_info = $item->getTrackingInfo();
        $this->assertInstanceOf( TrackingInfoInterface::class, $tracking_info);
        $this->assertEquals( $tracking_id, $tracking_info->getTrackingID() );
        $this->assertEquals( $tracking_link, $tracking_info->getTrackingLink() );
    }



    /**
     * @dataProvider provideInvalidShippingData
     */
    public function testUnexpectedValue( $delivery_note_number, $tracking_id, $tracking_link )
    {
        $sut = new ShipmentItemFactory;

        $this->expectException( \UnexpectedValueException::class);

        $sut->fromArray([
            'delivery_note_number' => $delivery_note_number,
            'tracking_id'          => $tracking_id,
            'tracking_link'        => $tracking_link
        ]);
    }


    /**
     * @dataProvider provideInvalidArguments
     */
    public function testInvalidArgumentException( $factory_data )
    {
        $sut = new ShipmentItemFactory;
        $this->expectException( \InvalidArgumentException::class);
        $sut->fromArray($factory_data);
    }



    public function provideValidShippingData()
    {
        return array(
            [ 'item_id', 'tracking_id', 'tracking_link' ]
        );
    }


    public function provideInvalidShippingData()
    {
        return array(
            [ null, 'tracking_id', 'tracking_link' ],
            [ 'item_id', null, 'tracking_link' ],
            [ 'item_id', 'tracking_id', null ]
        );
    }


    public function provideInvalidArguments()
    {
        return array(
            [ null ],
            [ 1 ],
            [ true ],
            [ "string" ]
        );
    }

}
