<?php

namespace GildedRose;

class GildedRose
{
    const AGED_BRIE_NAME = 'Aged Brie';
    const SULFURAS_HAND_OF_RAGNAROS_NAME = 'Sulfuras, Hand of Ragnaros';
    const BACKSTAGE_PASSES_TO_A_TAFKAL_80_ETC_CONCERT_STR = 'Backstage passes to a TAFKAL80ETC concert';
    const MIN_ITEM_QUALITY = 0;
    const MAX_ITEMS_QUALITY = 50;
    const DAYS_LEFT_WITH_DOUBLE_THE_QUALITY = 11;
    const DAYS_LEFT_WITH_TRIPLE_THE_QUALITY = 6;
    const ITEM_QUALITY_STEP = 1;
    const MIN_SELLING_DAYS = 0;
    const ITEM_SELL_IN_STEP = 1;
    /**
     * @var Item[]
     */
    private array $items;

    /**
     * @param Item[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            if ($item->name != self::AGED_BRIE_NAME && $item->name != self::BACKSTAGE_PASSES_TO_A_TAFKAL_80_ETC_CONCERT_STR) {
                if ($item->quality > self::MIN_ITEM_QUALITY) {
                    if ($item->name != self::SULFURAS_HAND_OF_RAGNAROS_NAME) {
                        $item->quality = $item->quality - self::ITEM_QUALITY_STEP;
                    }
                }
            } else {
                if ($item->quality < self::MAX_ITEMS_QUALITY) {
                    $item->quality = $item->quality + self::ITEM_QUALITY_STEP;
                    if ($item->name == self::BACKSTAGE_PASSES_TO_A_TAFKAL_80_ETC_CONCERT_STR) {
                        if ($item->sellIn < self::DAYS_LEFT_WITH_DOUBLE_THE_QUALITY) {
                            if ($item->quality < self::MAX_ITEMS_QUALITY) {
                                $item->quality = $item->quality + self::ITEM_QUALITY_STEP;
                            }
                        }
                        if ($item->sellIn < self::DAYS_LEFT_WITH_TRIPLE_THE_QUALITY) {
                            if ($item->quality < self::MAX_ITEMS_QUALITY) {
                                $item->quality = $item->quality + self::ITEM_QUALITY_STEP;
                            }
                        }
                    }
                }
            }

            if ($item->name != self::SULFURAS_HAND_OF_RAGNAROS_NAME) {
                $item->sellIn = $item->sellIn - self::ITEM_QUALITY_STEP;
            }

            if ($item->sellIn < self::MIN_SELLING_DAYS) {
                if ($item->name != self::AGED_BRIE_NAME) {
                    if ($item->name != self::BACKSTAGE_PASSES_TO_A_TAFKAL_80_ETC_CONCERT_STR) {
                        if ($item->quality > self::MIN_ITEM_QUALITY) {
                            if ($item->name != self::SULFURAS_HAND_OF_RAGNAROS_NAME) {
                                $item->quality = $item->quality - self::ITEM_QUALITY_STEP;
                            }
                        }
                    } else {
                        $item->quality = self::MIN_ITEM_QUALITY;
                    }
                } else {
                    if ($item->quality < self::MAX_ITEMS_QUALITY) {
                        $item->quality = $item->quality + self::ITEM_QUALITY_STEP;
                    }
                }
            }
        }
    }
}

