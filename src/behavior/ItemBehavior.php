<?php

namespace GildedRose\behavior;

use GildedRose\Item;

abstract class ItemBehavior
{
    /**
     * @var Item
     */
    protected Item $item;

    /**
     * @param Item $item
     */
    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    /**
     * @return void
     */
    abstract public function updateQuality(): void;

    /**
     * @return void
     */
    abstract public function updateSellIn(): void;
}
