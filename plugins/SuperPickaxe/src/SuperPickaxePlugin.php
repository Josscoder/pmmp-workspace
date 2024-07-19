<?php

namespace SuperPickaxe;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use pocketmine\utils\TextFormat;

class SuperPickaxePlugin extends PluginBase {

    use SingletonTrait;

    protected function onLoad(): void
    {
        self::setInstance($this);
    }

    protected function onEnable(): void
    {
        $this->getLogger()->info(TextFormat::GREEN . 'SuperPickaxe Plugin Enabled');
    }

    protected function onDisable(): void
    {
        $this->getLogger()->info(TextFormat::RED . 'SuperPickaxe Plugin Disabled');
    }
}