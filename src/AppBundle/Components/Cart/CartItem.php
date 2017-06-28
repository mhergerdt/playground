<?php
/**
 * Created by PhpStorm.
 * User: marcel
 * Date: 26.06.17
 * Time: 21:20
 */

namespace AppBundle\Components\Cart;


use Money\Money;

class CartItem
{
    /**
     * @var IBuyable
     */
    private $product;
    /**
     * @var int
     */
    private $amount;

    /**
     * CartItem constructor.
     *
     * @param IBuyable $product
     * @param int      $amount
     */
    public function __construct(IBuyable $product, int $amount)
    {
        $this->product = $product;
        $this->amount = $amount;
    }

    /**
     * @return IBuyable
     */
    public function getProduct(): IBuyable
    {
        return $this->product;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return Money
     */
    public function getTotal(): Money
    {
        return $this->product->getPrice()->multiply($this->amount);
    }
}