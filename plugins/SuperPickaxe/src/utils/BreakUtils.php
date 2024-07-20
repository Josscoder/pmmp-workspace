<?php

namespace SuperPickaxe\utils;

use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class BreakUtils
{
    public static function breakArea(?Player $player, AxisAlignedBB $collidedBox, int $radius): void
    {
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
                    $player->sendMessage(TextFormat::RED . sprintf('Breaking at: %s, %s, %s', $x, $y, $z));
                }
            }
        }
    }
}