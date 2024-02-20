<?php

namespace Stefi\Task;

use pocketmine\scheduler\Task;
use Stefi\API\KillAPI;
use Stefi\Suraya;

class ResetKillTask extends Task
{
	public function onRun(): void
	{
		Suraya::Server()->getLogger()->info("supression des kills");
		foreach (Suraya::Server()->getOnlinePlayers() as $p){
			KillAPI::resetKills($p);
		}
	}
}