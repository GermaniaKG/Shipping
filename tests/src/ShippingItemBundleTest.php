<?php
namespace tests;

use Germania\Shipping\ShipmentItem;
use Germania\Shipping\ShipmentItemInterface;
use Germania\Shipping\ShipmentItemBundle;
use Germania\Tracking\TrackingInfoInterface;
use Germania\Tracking\TrackingInfo;

class ShippingItemBundleTest extends \PHPUnit\Framework\TestCase
{


    /**
     * @dataProvider provideCtorArguments
     */
    public function testInterfaces( $items, $description )
    {
        $sut = $description
        ? new ShipmentItemBundle( $items, $description )
        : new ShipmentItemBundle( $items );

        $this->assertInstanceOf( \JsonSerializable::class, $sut);
    }


    /**
     * @dataProvider provideCtorArguments
     */
    public function testCountable( $items, $description )
    {
        $sut = $description
        ? new ShipmentItemBundle( $items, $description )
        : new ShipmentItemBundle( $items );

        $this->assertInstanceOf( \Countable::class, $sut);
        $this->assertEquals( count($items), count($sut) );
    }



    /**
     * @dataProvider provideCtorArguments
     */
    public function testDescription( $items, $description )
    {
        $sut = $description
        ? new ShipmentItemBundle( $items, $description )
        : new ShipmentItemBundle( $items );

        $this->assertEquals( (string) $description, $sut->getDescription() );
    }


    /**
     * @dataProvider provideCtorArguments
     */
    public function testPushMethod( $items, $description )
    {
        $sut = $description
        ? new ShipmentItemBundle( $items, $description )
        : new ShipmentItemBundle( $items );

        $old_count = count($sut);

        $new_item = $this->createShipmentItemMock( "foobar" );
        $sut->push( $new_item );

        $this->assertEquals( count($sut), $old_count + 1 );
    }

    /**
     * @dataProvider provideCtorArguments
     */
    public function testGetDeliveryNoteNumbers( array $items, $description )
    {
        $sut = $description
        ? new ShipmentItemBundle( $items, $description )
        : new ShipmentItemBundle( $items );

        $bundle_items = $sut->getDeliveryNoteNumbers();
        $this->assertInternalType("array", $bundle_items );
        foreach($items as $i):
            $this->assertTrue(in_array($i->getDeliveryNoteNumber(), $bundle_items ));
        endforeach;
    }

    /**
     * @dataProvider provideCtorArguments
     */
    public function testJson( array $items, $description )
    {
        $sut = $description
        ? new ShipmentItemBundle( $items, $description )
        : new ShipmentItemBundle( $items );

        $this->assertInstanceOf( \JsonSerializable::class, $sut);

        $json_sut = json_decode(json_encode($sut));
        $this->assertInternalType( "array", $json_sut);

        foreach($json_sut as $json_item):
            $this->assertObjectHasAttribute('delivery_note_number', $json_item);
        endforeach;

    }


    /**
     * @dataProvider provideCtorArguments
     */
    public function testIterator( $items, $description )
    {
        $sut = $description
        ? new ShipmentItemBundle( $items, $description )
        : new ShipmentItemBundle( $items );

        $this->assertInstanceOf( \Traversable::class, $sut);
        $this->assertInstanceOf( \ArrayIterator::class, $sut->getIterator() );
    }



    public function provideCtorArguments()
    {
        $item1 = $this->createShipmentItemMock( "foo" );
        $item2 = $this->createShipmentItemMock( "bar" );

        return array(
            [ array(), null ],
            [ array(), false ],
            [ array( $item1 ), "One foo item" ],
            [ array( $item1, $item2 ), "Two items: foo and bar" ]
        );
    }


    protected function createShipmentItemMock( $delivery_note_number )
    {
        $item_mock = $this->prophesize( ShipmentItemInterface::class );
        $item_mock->getDeliveryNoteNumber()->willReturn( $delivery_note_number );
        $item_mock->jsonSerialize()->willReturn( array('delivery_note_number' => $delivery_note_number) );
        return $item_mock->reveal();
    }

}
