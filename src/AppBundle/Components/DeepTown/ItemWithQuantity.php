<?php
/**
 * Created by PhpStorm.
 * User: marcel
 * Date: 27.06.17
 * Time: 21:12
 */

namespace AppBundle\Components\DeepTown;


class ItemWithQuantity
{
    /**
     * @var Item
     */
    private $item;

    /**
     * @var int
     */
    private $quantity;

    /**
     * Component constructor.
     * @param Item $item
     * @param int $quantity
     */
    public function __construct(Item $item, int $quantity)
    {
        $this->item = $item;
        $this->quantity = $quantity;
    }

    /**
     * @return Item
     */
    public function getItem(): Item
    {
        return $this->item;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
