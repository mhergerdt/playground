<?php
/**
 * Created by PhpStorm.
 * User: marcel
 * Date: 27.06.17
 * Time: 21:09
 */

namespace AppBundle\Components\DeepTown;


class Item
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var ItemWithQuantity[]
     */
    private $components;

    /**
     * Item constructor.
     *
     * @param string             $name
     * @param ItemWithQuantity[] $components
     */
    public function __construct(string $name, array $components = [])
    {
        $this->name = $name;
        $this->components = $components;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Item
     */
    public function setName(string $name): Item
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return ItemWithQuantity[]
     */
    public function getComponents(): array
    {
        return $this->components;
    }

    /**
     * @param ItemWithQuantity[] $components
     *
     * @return Item
     */
    public function setComponents(array $components): Item
    {
        $this->components = $components;

        return $this;
    }
}
