<?php

namespace Stefi\API;


use pocketmine\player\Player;
use pocketmine\utils\Config;
use Stefi\Suraya;

class EloAPI
{
	/** @var Config */
	public static $data;
	public static function Init(){
		self::$data = new Config(Suraya::getInstance()->getDataFolder() . "Elo.yml", Config::YAML);
	}

	private static function getPlayerName($player): string
	{
		if ($player instanceof Player) return $player->getName(); else return $player;
	}


	public static function existElo($player): bool
	{
		return self::$data->exists(self::getPlayerName($player));
	}

	public static function addElo($player, int $elo): void
	{
		self::setElo($player, self::getElo($player) + $elo);
	}

	public static function removeElo($player, int $elo): void
	{
		$currentElo = self::getElo($player);
		if ($currentElo - $elo >= 0) {
			self::setElo($player, $currentElo - $elo);
		} else {
			self::setElo($player, 0);
		}
	}



	public static function setElo($player, int $elo): void
	{
		self::$data->set(self::getPlayerName($player), $elo);
		self::$data->save();
	}

	public static function getElo($player)
	{
		return self::$data->get(self::getPlayerName($player));
	}
	public static function getAllElo(): array
	{
		$eloData = [];
		$allData = self::$data->getAll();

		foreach ($allData as $playerName => $elo) {
			$eloData[$playerName] = $elo;
		}

		return $eloData;
	}

}