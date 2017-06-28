<?php

namespace AppBundle\Controller;

use AppBundle\Components\Cart\Cart;
use AppBundle\Components\DeepTown\Item;
use AppBundle\Components\DeepTown\ItemWithQuantity;
use AppBundle\Components\DeepTown\RequiredItemsCalculator;
use AppBundle\Entity\Product;
use Money\Money;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $cart = new Cart();
        $cart->add(
            (new Product())
                ->setId('abc')
                ->setTitle('Test Test')
                ->setDescription('Lorem ipsum dolor amet')
                ->setPrice(Money::EUR(395)),
            5
        );
        $cart->add(
            (new Product())
                ->setId('abc123')
                ->setTitle('Test Test')
                ->setDescription('Lorem ipsum dolor amet')
                ->setPrice(Money::EUR(695)),
            2
        );

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'cart'     => $cart
        ]);
    }

    /**
     * @Route("/deepTown", name="deepTownCalculator")
     */
    public function deepTownCalculatorAction()
    {
        $emerald = new Item('Emerald');
        $copper = new Item('Copper');
        $aluminium = new Item('Aluminium');
        $coal = new Item('Emerald');
        $amber = new Item('Amber');

        $polishedEmerald = new Item('Polished Emerald', [new ItemWithQuantity($emerald, 1)]);
        $graphite = new Item('Graphite', [new ItemWithQuantity($coal, 5)]);
        $copperBar = new Item('Copper Bar', [new ItemWithQuantity($copper, 5)]);
        $aluminiumBar = new Item('Aluminium Bar', [new ItemWithQuantity($aluminium, 5)]);
        $aluminiumBottle = new Item('Aluminium Bottle', [new ItemWithQuantity($aluminiumBar, 1)]);
        $wire = new Item('Wire', [new ItemWithQuantity($copperBar, 1)]);
        $amberInsulation = new Item('AmberInsulation', [
            new ItemWithQuantity($amber, 10),
            new ItemWithQuantity($aluminiumBottle, 1)
        ]);
        $insulatedWire = new Item('Insulated Wire', [
            new ItemWithQuantity($wire, 1),
            new ItemWithQuantity($amberInsulation, 1)
        ]);
        $lamp = new Item('Lamp', [
            new ItemWithQuantity($copperBar, 5),
            new ItemWithQuantity($wire, 10),
            new ItemWithQuantity($graphite, 20)
        ]);

        $greenLaser = new Item('Green Laser', [
            new ItemWithQuantity($polishedEmerald, 1),
            new ItemWithQuantity($insulatedWire, 1),
            new ItemWithQuantity($lamp, 1)
        ]);

        $item = $greenLaser;
        $quantity = 7500;

        $calculator = new RequiredItemsCalculator();
        $requiredItems = $calculator->calculate($item, $quantity);

        return $this->render('default/deepTown.html.twig', [
            'item'          => $item,
            'quantity'      => $quantity,
            'requiredItems' => $requiredItems
        ]);
    }
}
