<?php

namespace Stefi\API;

use pocketmine\utils\Config;
use Stefi\Suraya;

class StaffAPI
{
	/** @var Config */
	private static $staffdata;
public static function Init()
{
	self::$staffdata = new Config(Suraya::getInstance()->getDataFolder() . "staff.yml");
}


}