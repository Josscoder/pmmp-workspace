<?php

namespace SuperPickaxe\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use SuperPickaxe\SuperPickaxePlugin;

class SuperPickaxeRadiusCommand extends Command
{
    public function __construct()
    {
        parent::__construct(
            'superpickaxeradius',
            'Change the radius of the super pickaxe',
            '/%s <radius>',
            ['spa']
        );

        $this->setPermission('superpickaxe.radius.command');
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): void
    {
        if (count($args) < 1) {
            $sender->sendMessage(TextFormat::RED . sprintf($this->getUsage(), $commandLabel));

            return;
        }

        $radius = intval($args[0]);
        SuperPickaxePlugin::getInstance()->setRadius($radius);

        $sender->sendMessage(TextFormat::GREEN . sprintf("Radius changed to %s", $radius));
    }
}