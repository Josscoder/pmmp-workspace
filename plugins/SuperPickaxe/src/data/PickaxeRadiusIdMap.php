<?php

namespace SuperPickaxe\data;

use pocketmine\item\ItemTypeIds;
use pocketmine\utils\SingletonTrait;
use SuperPickaxe\SuperPickaxePlugin;

class PickaxeRadiusIdMap
{
    use SingletonTrait;

    private array $idToEnum = [];

    public function __construct()
    {
        $this->register(ItemTypeIds::WOODEN_PICKAXE, 1);
        $this->register(ItemTypeIds::STONE_PICKAXE, 2);
        $this->register(ItemTypeIds::IRON_PICKAXE, 3);
        $this->register(ItemTypeIds::GOLDEN_PICKAXE, 4);
        $this->register(ItemTypeIds::DIAMOND_PICKAXE, 5);
        $this->register(ItemTypeIds::NETHERITE_PICKAXE, 6);
    }

    private function register(int $id, int $radius): void
    {
        $this->idToEnum[$id] = $radius;
    }

    public function fromId(int $id): ?int
    {
        return $this->idToEnum[$id] ?? SuperPickaxePlugin::getInstance()->getDefaultRadius();
    }
}