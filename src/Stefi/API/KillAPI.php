<?php

namespace Stefi\API;

use pocketmine\player\Player;
use pocketmine\utils\Config;
use Stefi\Suraya;

class KillAPI
{
	/** @var Config */
	private static $killsData;
	private static $statsData;
	private static $killstreakdata;

	public static function Init() {
		self::$statsData = new Config(Suraya::getInstance()->getDataFolder() . "deaths.yml", Config::YAML);
		self::$killsData = new Config(Suraya::getInstance()->getDataFolder() . "kills.yml", Config::YAML);
		self::$killstreakdata = new Config(Suraya::getInstance()->getDataFolder() . "killstreak.yml", Config::YAML);
	}
	public static function addDeath(Player $player) {
		$playerName = $player->getName();

		$deathsData = self::$statsData->getNested("deaths", []);
		if (!isset($deathsData[$playerName])) {
			$deathsData[$playerName] = 1;
		} else {
			$deathsData[$playerName]++;
		}
		self::$statsData->setNested("deaths", $deathsData);
		self::$statsData->save();
	}

	public static function getDeaths(Player $player)  {
		$playerName = $player->getName();
		$deathsData = self::$statsData->getNested("deaths", []);

		return isset($deathsData[$playerName]) ? $deathsData[$playerName] : 0;
	}

	public static function addKill(Player $victim, Player $killer) {
		$victimName = $victim->getName();
		$killerName = $killer->getName();

		$killsData = self::$killsData->get($victimName, []);

		if (!isset($killsData[$killerName])) {
			$killsData[$killerName] = 1;
		} else {
			$killsData[$killerName]++;
		}

		self::$killsData->set($victimName, $killsData);
		self::$killsData->save();
	}

	/*public static function getKills(Player $victim) {
		$victimName = $victim->getName();
		$killsData = self::$killsData->get($victimName, []);

		return $killsData;
	}*/

	public static function resetKills(Player $victim) {
		$victimName = $victim->getName();
		self::$killsData->remove($victimName);
		self::$killsData->save();
	}

	private static function getPlayerName($player): string
	{
		if ($player instanceof Player) return $player->getName(); else return $player;
	}
	public static function setKillStreak($player, int $kill): void
	{
		self::$killstreakdata->set(self::getPlayerName($player), $kill);
		self::$killstreakdata->save();
	}

	public static function getKillstreak($player)
	{
		return self::$killstreakdata->get(self::getPlayerName($player));
	}
	public static function addKillStreak($player, int $kill): void
	{
		self::setKillStreak($player, self::getKillstreak($player) + $kill);
	}
	public static function checkKillLimit(Player $victim, Player $killer) {
		$victimName = $victim->getName();
		$killerName = $killer->getName();

		$killsData = self::$killsData->get($victimName, []);

		if (isset($killsData[$killerName]) && $killsData[$killerName] >= 8) {
			return false;
		}

		return true;
	}
}
