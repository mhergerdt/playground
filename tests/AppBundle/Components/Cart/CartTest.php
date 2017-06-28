<?php
/**
 * Created by PhpStorm.
 * User: marcel
 * Date: 26.06.17
 * Time: 21:38
 */

namespace AppBundle\Components\Cart;

use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    public function testAdd()
    {
        /** @var IBuyable|\PHPUnit_Framework_MockObject_MockObject $productMock1 */
        $productMock1 = $this->getMockBuilder(IBuyable::class)->getMock();
        $productMock1->expects($this->any())->method('getId')->willReturn('1');
        /** @var IBuyable|\PHPUnit_Framework_MockObject_MockObject $productMock2 */
        $productMock2 = $this->getMockBuilder(IBuyable::class)->getMock();
        $productMock2->expects($this->any())->method('getId')->willReturn('2');

        $cart = new Cart();
        $cart->add($productMock1);

        $this->assertCount(1, $cart);
        $this->assertSame($productMock1, $cart[0]->getProduct());
        $this->assertSame(1, $cart[0]->getAmount());

        $cart->add($productMock1, 2);

        $this->assertCount(1, $cart);
        $this->assertSame($productMock1, $cart[0]->getProduct());
        $this->assertSame(3, $cart[0]->getAmount());

        $cart->add($productMock2, 2);

        $this->assertCount(2, $cart);
        $this->assertSame($productMock1, $cart[0]->getProduct());
        $this->assertSame(3, $cart[0]->getAmount());
        $this->assertSame($productMock2, $cart[1]->getProduct());
        $this->assertSame(2, $cart[1]->getAmount());
    }

    /**
     * @depends testAdd
     */
    public function testSet()
    {
        /** @var IBuyable|\PHPUnit_Framework_MockObject_MockObject $productMock1 */
        $productMock1 = $this->getMockBuilder(IBuyable::class)->getMock();
        $productMock1->expects($this->any())->method('getId')->willReturn('1');
        /** @var IBuyable|\PHPUnit_Framework_MockObject_MockObject $productMock2 */
        $productMock2 = $this->getMockBuilder(IBuyable::class)->getMock();
        $productMock2->expects($this->any())->method('getId')->willReturn('2');

        $cart = new Cart();
        $cart->add($productMock1, 5);
        $cart->add($productMock2, 1);

        $cart->set($productMock1, 1);

        $this->assertCount(2, $cart);
        $this->assertSame($productMock1, $cart[0]->getProduct());
        $this->assertSame(1, $cart[0]->getAmount());
        $this->assertSame($productMock2, $cart[1]->getProduct());
        $this->assertSame(1, $cart[1]->getAmount());

        $cart->set($productMock2, -1);

        $this->assertCount(1, $cart);
        $this->assertSame($productMock1, $cart[0]->getProduct());
        $this->assertSame(1, $cart[0]->getAmount());
    }

    /**
     * @depends testAdd
     */
    public function testRemove()
    {
        /** @var IBuyable|\PHPUnit_Framework_MockObject_MockObject $productMock1 */
        $productMock1 = $this->getMockBuilder(IBuyable::class)->getMock();
        $productMock1->expects($this->any())->method('getId')->willReturn('1');
        /** @var IBuyable|\PHPUnit_Framework_MockObject_MockObject $productMock2 */
        $productMock2 = $this->getMockBuilder(IBuyable::class)->getMock();
        $productMock2->expects($this->any())->method('getId')->willReturn('2');

        $cart = new Cart();
        $cart->add($productMock1, 5);
        $cart->add($productMock2, 1);

        $cart->remove($productMock1);

        $this->assertCount(2, $cart);
        $this->assertSame($productMock1, $cart[0]->getProduct());
        $this->assertSame(4, $cart[0]->getAmount());
        $this->assertSame($productMock2, $cart[1]->getProduct());
        $this->assertSame(1, $cart[1]->getAmount());

        $cart->remove($productMock2);

        $this->assertCount(1, $cart);
        $this->assertSame($productMock1, $cart[0]->getProduct());
        $this->assertSame(4, $cart[0]->getAmount());
    }

    public function testArrayAccess()
    {
        /** @var IBuyable|\PHPUnit_Framework_MockObject_MockObject $productMock1 */
        $productMock1 = $this->getMockBuilder(IBuyable::class)->getMock();
        $productMock1->expects($this->any())->method('getId')->willReturn('1');
        /** @var IBuyable|\PHPUnit_Framework_MockObject_MockObject $productMock2 */
        $productMock2 = $this->getMockBuilder(IBuyable::class)->getMock();
        $productMock2->expects($this->any())->method('getId')->willReturn('2');

        $cart = new Cart();
        $cart[] = $productMock1;

        $this->assertCount(1, $cart);
        $this->assertSame($productMock1, $cart[0]->getProduct());
        $this->assertSame(1, $cart[0]->getAmount());

        $cart[5] = $productMock2;

        $this->assertCount(2, $cart);
        $this->assertSame($productMock1, $cart[0]->getProduct());
        $this->assertSame(1, $cart[0]->getAmount());
        $this->assertSame($productMock2, $cart[1]->getProduct());
        $this->assertSame(1, $cart[1]->getAmount());

        unset($cart[1]);

        $this->assertCount(1, $cart);
        $this->assertSame($productMock1, $cart[0]->getProduct());
        $this->assertSame(1, $cart[0]->getAmount());

        $this->assertTrue(isset($cart[0]));
        $this->assertFalse(isset($cart[1]));

        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage('The object added to cart must implement interface ' . IBuyable::class);

        $cart[] = 'invalid';
    }
}
