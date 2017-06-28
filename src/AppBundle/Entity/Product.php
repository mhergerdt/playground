<?php
/**
 * Created by PhpStorm.
 * User: marcel
 * Date: 26.06.17
 * Time: 23:10
 */

namespace AppBundle\Entity;


use AppBundle\Components\Cart\IBuyable;
use Money\Money;

class Product implements IBuyable
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var Money
     */
    private $price;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return Product
     */
    public function setId(string $id): Product
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return Product
     */
    public function setTitle(string $title): Product
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Product
     */
    public function setDescription(string $description): Product
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Money
     */
    public function getPrice(): Money
    {
        return $this->price;
    }

    /**
     * @param Money $price
     *
     * @return Product
     */
    public function setPrice(Money $price): Product
    {
        $this->price = $price;

        return $this;
    }
}