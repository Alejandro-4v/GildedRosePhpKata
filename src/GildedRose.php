<?php

namespace GildedRose;

class GildedRose {
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
    public function __construct(array $items) {
        $this->items = $items;
    }

    public function updateQuality(): void {
        foreach ($this->items as $item) {
            if ($this->isSulfuras($item)) {
                if ($this->isQualityAboveMinimum($item)) {
                    if ($this->isNotSulfuras($item)) {
                        $item->quality = $this->decreaseQuality($item);
                    }
                }
            } else {
                if ($this->isQualityBelowMax($item)) {
                    $item->quality = $this->increaseQuality($item);
                    if ($this->isBackstagePass($item)) {
                        if ($this->isFirstSellInThresholdMet($item)) {
                            if ($this->isQualityBelowMax($item)) {
                                $item->quality = $this->increaseQuality($item);
                            }
                        }
                        if ($this->isSecondSellInTresholdMet($item)) {
                            if ($this->isQualityBelowMax($item)) {
                                $item->quality = $this->increaseQuality($item);
                            }
                        }
                    }
                }
            }

            if ($this->isNotSulfuras($item)) {
                $item->sellIn = $this->decreaseSellIn($item);
            }

            if ($this->isItemExpired($item)) {
                if ($this->isNotAgedBrie($item)) {
                    if ($this->isNotBackstagePass($item)) {
                        if ($this->isQualityAboveMinimum($item)) {
                            if ($this->isNotSulfuras($item)) {
                                $item->quality = $this->decreaseQuality($item);
                            }
                        }
                    } else {
                        $item->quality = self::MIN_ITEM_QUALITY;
                    }
                } else {
                    if ($this->isQualityBelowMax($item)) {
                        $item->quality = $this->increaseQuality($item);
                    }
                }
            }
        }
    }

    /**
     * @param Item $item
     * @return bool
     */
    public function isSulfuras(Item $item): bool {
        return $this->isNotAgedBrie($item) && $this->isNotBackstagePass($item);
    }

    /**
     * @param Item $item
     * @return bool
     */
    public function isQualityAboveMinimum(Item $item): bool {
        return $item->quality > self::MIN_ITEM_QUALITY;
    }

    /**
     * @param Item $item
     * @return bool
     */
    public function isNotSulfuras(Item $item): bool {
        return $item->name != self::SULFURAS_HAND_OF_RAGNAROS_NAME;
    }

    /**
     * @param Item $item
     * @return int
     */
    public function decreaseQuality(Item $item): int {
        return $item->quality - self::ITEM_QUALITY_STEP;
    }

    /**
     * @param Item $item
     * @return bool
     */
    public function isQualityBelowMax(Item $item): bool {
        return $item->quality < self::MAX_ITEMS_QUALITY;
    }

    /**
     * @param Item $item
     * @return int
     */
    public function increaseQuality(Item $item): int {
        return $item->quality + self::ITEM_QUALITY_STEP;
    }

    /**
     * @param Item $item
     * @return bool
     */
    public function isBackstagePass(Item $item): bool {
        return $item->name == self::BACKSTAGE_PASSES_TO_A_TAFKAL_80_ETC_CONCERT_STR;
    }

    /**
     * @param Item $item
     * @return bool
     */
    public function isFirstSellInThresholdMet(Item $item): bool {
        return $item->sellIn < self::DAYS_LEFT_WITH_DOUBLE_THE_QUALITY;
    }

    /**
     * @param Item $item
     * @return bool
     */
    public function isSecondSellInTresholdMet(Item $item): bool {
        return $item->sellIn < self::DAYS_LEFT_WITH_TRIPLE_THE_QUALITY;
    }

    /**
     * @param Item $item
     * @return int
     */
    public function decreaseSellIn(Item $item): int {
        return $item->sellIn - self::ITEM_SELL_IN_STEP;
    }

    /**
     * @param Item $item
     * @return bool
     */
    public function isItemExpired(Item $item): bool {
        return $item->sellIn < self::MIN_SELLING_DAYS;
    }

    /**
     * @param Item $item
     * @return bool
     */
    public function isNotAgedBrie(Item $item): bool {
        return $item->name != self::AGED_BRIE_NAME;
    }

    /**
     * @param Item $item
     * @return bool
     */
    public function isNotBackstagePass(Item $item): bool {
        return $item->name != self::BACKSTAGE_PASSES_TO_A_TAFKAL_80_ETC_CONCERT_STR;
    }
}

