<?php

namespace SuperPickaxe\utils;

class TimeUtils
{
    public static function getCurrentTimestamp(): float
    {
        return floor(microtime(true) * 1000);
    }
}