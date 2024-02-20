<?php

namespace Stefi\Task;

use pocketmine\scheduler\Task;
use Stefi\API\CooldownsAPI;

class CooldownsTask extends Task
{
	public function onRun(): void {
		$allData = CooldownsAPI::$cooldowns->getAll();

		foreach ($allData as $grade => $cooldownData) {
			if (!is_array($cooldownData)) {
				continue;
			}

			foreach ($cooldownData as $player => $cooldownArray) {
				if (!is_array($cooldownArray)) {
					continue;
				}

				foreach ($cooldownArray as $playerName => $cooldown) {
					if (is_numeric($cooldown)) {
						$cooldownArray[$playerName] = $cooldown - 1;

						if ($cooldownArray[$playerName] <= 0) {
							unset($cooldownArray[$playerName]);
						}
					}
				}

				$cooldownData[$player] = $cooldownArray;
			}

			CooldownsAPI::$cooldowns->setNested("$grade", $cooldownData);
		}

		CooldownsAPI::$cooldowns->save();
	}
}