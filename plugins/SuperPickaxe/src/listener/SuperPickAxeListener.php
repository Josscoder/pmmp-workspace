<?php

namespace SuperPickaxe\listener;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\item\Pickaxe;
use pocketmine\utils\TextFormat;
use SuperPickaxe\SuperPickaxePlugin;
use SuperPickaxe\utils\BreakUtils;
use SuperPickaxe\utils\TimeUtils;

class SuperPickAxeListener implements Listener
{
    private array $breaking = [];

    public function onBreakBlock(BlockBreakEvent $event): void
    {
        $player = $event->getPlayer();

        if (!($event->getItem() instanceof Pickaxe) || isset($this->breaking[$player->getName()])) { //Using array breaking to avoid recursion
            return;
        }

        $this->breaking[$player->getName()] = TimeUtils::getCurrentTimestamp();

        foreach ($event->getBlock()->getCollisionBoxes() as $box) {
            BreakUtils::breakArea($player, $box, SuperPickaxePlugin::getInstance()->getRadius());
        }

        $passedTime = (TimeUtils::getCurrentTimestamp() - $this->breaking[$player->getName()]);
        unset($this->breaking[$player->getName()]);

        $player->sendMessage(TextFormat::GREEN . sprintf('The process took %d milliseconds!', $passedTime));
    }

    public function onQuit(PlayerQuitEvent $event): void
    {
        $player = $event->getPlayer();

        if (isset($this->breaking[$player->getName()])) {
            unset($this->breaking[$player->getName()]);
        }
    }
}