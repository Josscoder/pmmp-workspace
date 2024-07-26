<?php

namespace SuperPickaxe;

use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use pocketmine\utils\TextFormat;
use SuperPickaxe\command\SuperPickaxeRadiusCommand;
use SuperPickaxe\listener\SuperPickaxeListener;

class SuperPickaxePlugin extends PluginBase
{
    use SingletonTrait;

    private int $defaultRadius = 3;

    protected function onLoad(): void
    {
        self::setInstance($this);
    }

    protected function onEnable(): void
    {
        $this->getServer()->getCommandMap()->register('superpickaxe', new SuperPickaxeRadiusCommand());
        $this->getServer()->getPluginManager()->registerEvents(new SuperPickaxeListener(), $this);

        $this->getLogger()->info(TextFormat::GREEN . 'SuperPickaxe Plugin Enabled');
    }

    protected function onDisable(): void
    {
        $this->getLogger()->info(TextFormat::RED . 'SuperPickaxe Plugin Disabled');
    }

    public function getDefaultRadius(): int
    {
        return $this->defaultRadius;
    }

    public function setDefaultRadius(int $defaultRadius): void
    {
        $this->defaultRadius = $defaultRadius;
    }

    public function breakArea(?Player $player, AxisAlignedBB $collidedBox, int $radius): void
    {
        $radius = ($radius - 1); //adjust the radius
        $newBox = $collidedBox->expandedCopy($radius, $radius, $radius);

        $minX = floor($newBox->minX);
        $minY = floor($newBox->minY);
        $minZ = floor($newBox->minZ);

        $maxX = floor($newBox->maxX);
        $maxY = floor($newBox->maxY);
        $maxZ = floor($newBox->maxZ);

        for ($x = $minX; $x <= $maxX; $x++) {
            for ($y = $minY; $y <= $maxY; $y++) {
                for ($z = $minZ; $z <= $maxZ; $z++) {
                    if (is_null($player) || !$player->isOnline()) {
                        break;
                    }

                    $player->breakBlock(new Vector3($x, $y, $z));
                }
            }
        }
    }
}