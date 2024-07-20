<?php

namespace SuperPickaxe;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use pocketmine\utils\TextFormat;
use SuperPickaxe\command\SuperPickaxeRadiusCommand;
use SuperPickaxe\listener\SuperPickaxeListener;

class SuperPickaxePlugin extends PluginBase
{
    use SingletonTrait;

    private int $radius = 3;

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

    public function getRadius(): int
    {
        return $this->radius;
    }

    public function setRadius(int $radius): void
    {
        $this->radius = $radius;
    }
}