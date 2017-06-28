<?php
/**
 * Created by PhpStorm.
 * User: marcel
 * Date: 27.06.17
 * Time: 21:42
 */

namespace AppBundle\Components\DeepTown;

use PHPUnit\Framework\TestCase;

class RequiredItemsCalculatorTest extends TestCase
{
    public function testCalculate()
    {
        $coal = new Item('Coal');
        $copper = new Item('Copper');
        $graphite = new Item('Graphite', [new ItemWithQuantity($coal, 5)]);
        $copperBar = new Item('Copper Bar', [new ItemWithQuantity($copper, 5)]);
        $wire = new Item('Wire', [new ItemWithQuantity($copperBar, 1)]);
        $lamp = new Item('Lamp', [
            new ItemWithQuantity($copperBar, 5),
            new ItemWithQuantity($wire, 10),
            new ItemWithQuantity($graphite, 20)
        ]);

        $calculator = new RequiredItemsCalculator();
        $requiredItems = $calculator->calculate($lamp);

        $this->assertEquals(100, $requiredItems['Coal']->getQuantity());
        $this->assertEquals(75, $requiredItems['Copper']->getQuantity());
        $this->assertEquals(20, $requiredItems['Graphite']->getQuantity());
        $this->assertEquals(15, $requiredItems['Copper Bar']->getQuantity());
        $this->assertEquals(10, $requiredItems['Wire']->getQuantity());

        $requiredItems = $calculator->calculate($lamp, 5);

        $this->assertEquals(500, $requiredItems['Coal']->getQuantity());
        $this->assertEquals(375, $requiredItems['Copper']->getQuantity());
        $this->assertEquals(100, $requiredItems['Graphite']->getQuantity());
        $this->assertEquals(75, $requiredItems['Copper Bar']->getQuantity());
        $this->assertEquals(50, $requiredItems['Wire']->getQuantity());
    }
}
