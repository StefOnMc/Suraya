<?php

namespace Stefi\API;

use pocketmine\utils\Config;
use Stefi\Suraya;

class CooldownsAPI
{
	/** @var Config */
	public static $cooldowns;
	public static function Init(){
		self::$cooldowns = new Config(Suraya::getInstance()->getDataFolder() . "cooldowns.yml", Config::YAML);
	}
	private static function setCooldowns(string $name, int $cooldownTime, string $grade) {

		$cooldownData = self::$cooldowns->getNested("cooldowns.$grade", []);
		$cooldownData[$name] = $cooldownTime;
		self::$cooldowns->setNested("cooldowns.$grade", $cooldownData);
		self::$cooldowns->save();
	}
	public static function setCooldown($playerName, $time, string $format , string $grade) {
		$seconds = $time;
		if ($format === 'minute') {
			$seconds *= 60;
		} elseif ($format === 'heure') {
			$seconds *= 3600;
		} elseif ($format === 'jour') {
			$seconds *= 86400;
		}

		self::setCooldowns($playerName, $seconds,$grade);
	}
	private static function getTimes(string $name,string $grade) {
		$cooldownData = self::$cooldowns->getNested("cooldowns.$grade", []);

		if (isset($cooldownData[$name])) {
			return $cooldownData[$name];
		}

		return 0;
	}


	public static function getTime(string $playerName,string $grade) {
		$remainingTime = self::getTimes($playerName,$grade);
		return self::FormatTime($remainingTime);
	}

	public static function hasCooldown(string $playerName,string $grade) {
		$cooldownData = self::$cooldowns->getNested("cooldowns.$grade", []);
		return isset($cooldownData[$playerName]);
	}
	public static function FormatTime($seconds) {
		if ($seconds >= 31536000) { // 31536000 secondes dans une année
			$years = floor($seconds / 31536000);
			$days = floor(($seconds % 31536000) / 86400);
			$hours = floor(($seconds % 86400) / 3600);
			$minutes = floor(($seconds % 3600) / 60);

			$formattedTime = "$years année(s)";

			if ($days > 0) {
				$formattedTime .= ", $days jour(s)";
			}

			if ($hours > 0) {
				$formattedTime .= ", $hours heure(s)";
			}

			if ($minutes > 0) {
				$formattedTime .= ", $minutes minute(s)";
			}

			return $formattedTime;
		} elseif ($seconds >= 86400) {
			$days = floor($seconds / 86400);
			$hours = floor(($seconds % 86400) / 3600);
			$minutes = floor(($seconds % 3600) / 60);
			return "$days jour(s), $hours heure(s) et $minutes minute(s)";
		} elseif ($seconds >= 3600) {
			$hours = floor($seconds / 3600);
			$minutes = floor(($seconds % 3600) / 60);
			return "$hours heure(s) et $minutes minute(s)";
		} elseif ($seconds >= 60) {
			$minutes = floor($seconds / 60);
			return "$minutes minute(s)";
		} else {
			return "$seconds seconde(s)";
		}
	}
}