<?php

namespace Stefi\Listen;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\player\Player;

class Staff implements Listener
{
public function StickKb(EntityDamageByEntityEvent $e){
	$d = $e->getDamager();
	$entity = $e->getEntity();
	if($d instanceof Player && $entity instanceof Player){

	}
}
}