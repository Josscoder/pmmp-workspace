<?php

namespace SuperPickaxe\listener;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\item\Pickaxe;
use pocketmine\player\Player;
use SuperPickaxe\data\PickaxeRadiusIdMap;
use SuperPickaxe\SuperPickaxePlugin;

class SuperPickaxeListener implements Listener
{
    private array $breaking = [];

    public function onBreakBlock(BlockBreakEvent $event): void
    {
        $player = $event->getPlayer();

        $item = $event->getItem();

        if (!($item instanceof Pickaxe) || in_array($player->getName(), $this->breaking)) { //Using array breaking to avoid recursion
            return;
        }

        $this->breaking[] = $player->getName();

        $core = SuperPickaxePlugin::getInstance();

        foreach ($event->getBlock()->getCollisionBoxes() as $box) {
            $core->breakArea($player, $box, PickaxeRadiusIdMap::getInstance()->fromId($item->getTypeId()));
        }

        $this->removeFromBreakingArray($player);
    }

    public function onQuit(PlayerQuitEvent $event): void
    {
        $this->removeFromBreakingArray($event->getPlayer());
    }

    private function removeFromBreakingArray(Player $player): void
    {
        $key = array_search($player->getName(), $this->breaking);
        if ($key !== false) {
            unset($this->breaking[$key]);
        }
    }
}