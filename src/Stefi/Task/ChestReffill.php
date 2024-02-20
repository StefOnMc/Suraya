<?php

namespace Stefi\Task;

use pocketmine\block\tile\Chest;
use pocketmine\block\VanillaBlocks;
use pocketmine\item\VanillaItems;
use pocketmine\scheduler\Task;
use Stefi\Suraya;

class ChestReffill extends Task
{
	private static int $timer = 100;
public function onRun(): void
{
	self::$timer--;
	if(self::$timer === 0){
		foreach(Suraya::Server()->getWorldManager()->getWorlds() as $w){
			if($w->getDisplayName() === "Stealed"){
				$w->setBlockAt(1,90,7,VanillaBlocks::CHEST());
				$w->setBlockAt(1,91,7,VanillaBlocks::CHEST());
				$w->setBlockAt(1,92,7,VanillaBlocks::CHEST());
				$c = $w->getTileAt(1,90,7);
				$d = $w->getTileAt(1,91,7);
				$e = $w->getTileAt(1,92,7);
				if($c instanceof Chest && $d instanceof Chest && $e instanceof Chest){
					$this->RandomLoot($c);
					$this->RandomLoot($d);
					$this->RandomLoot($e);
				}
			}
		}
		self::$timer = 100;
		Suraya::Server()->getLogger()->info("Oe il a bien spawn");
	}else{
		if(self::$timer === 15 or self::$timer === 5){
			Suraya::Server()->getLogger()->info("Oe il spawn dans ". self::$timer . " seconde");
		}
	}

}

private function RandomLoot(Chest $e){
	$loot = mt_rand(1,3);

	switch ($loot){
		case 1:
			Suraya::Server()->getLogger()->info("loot 1");
			$e->getInventory()->clearAll();
			$e->getInventory()->setItem(12,VanillaItems::APPLE());
			break;
		case 2:
			Suraya::Server()->getLogger()->info("loot 2");
			$e->getInventory()->clearAll();
			$e->getInventory()->setItem(12,VanillaItems::BONE());
			break;
		case 3:
			Suraya::Server()->getLogger()->info("loot 3");
			$e->getInventory()->clearAll();
			$e->getInventory()->setItem(12,VanillaItems::IRON_BOOTS());
			break;
	}
}
}