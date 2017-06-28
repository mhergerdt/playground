<?php
/**
 * Created by PhpStorm.
 * User: marcel
 * Date: 26.06.17
 * Time: 21:34
 */

namespace AppBundle\Components\Cart;

use Money\Money;

interface IBuyable
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @return Money
     */
    public function getPrice(): Money;
}
