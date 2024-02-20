<?php

namespace Stefi\Listen;

use pocketmine\block\VanillaBlocks;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\math\Vector3;

class LaunchPad implements Listener
{
	public function Plaque(PlayerMoveEvent $e){
		$p = $e->getPlayer();
		$world = $p->getLocation()->getWorld();
		$pos = $p->getPosition();
		$block = $world->getBlock($pos);
		$direction = $p->getDirectionPlane()->normalize()->multiply(2);
		if($block->getTypeId() === VanillaBlocks::STONE_PRESSURE_PLATE()->getTypeId()){
			$p->setMotion(new Vector3($direction->getX(),1,$direction->getY()));
		}
		$p->getHungerManager()->addFood("20");
	}
}