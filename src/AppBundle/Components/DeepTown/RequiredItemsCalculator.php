<?php
/**
 * Created by PhpStorm.
 * User: marcel
 * Date: 27.06.17
 * Time: 21:15
 */

namespace AppBundle\Components\DeepTown;


class RequiredItemsCalculator
{
    /**
     * @param Item $item
     * @param int  $quantity
     *
     * @return ItemWithQuantity[]
     */
    public function calculate(Item $item, int $quantity = 1): array
    {
        /**
         * @var ItemWithQuantity[]
         */
        $requiredItems = [];

        foreach ($item->getComponents() as $component) {
            $this->addRequiredItem($requiredItems, $component->getItem(), $component->getQuantity() * $quantity);
        }

        return $requiredItems;
    }

    /**
     * @param ItemWithQuantity[] $requiredItems
     * @param Item               $item
     * @param int                $quantity
     */
    private function addRequiredItem(array &$requiredItems, Item $item, int $quantity)
    {
        foreach ($item->getComponents() as $component) {
            $this->addRequiredItem($requiredItems, $component->getItem(), $component->getQuantity() * $quantity);
        }

        if (isset($requiredItems[$item->getName()])) {
            $quantity = $requiredItems[$item->getName()]->getQuantity() + $quantity;
        }

        $requiredItems[$item->getName()] = new ItemWithQuantity($item, $quantity);
    }
}