<?php

namespace Stefi\Listen;


use Stefi\Suraya;

class ListenMgr
{
public static function Init(){
	$event = Suraya::Events();
	$event->registerEvents(new Elo(),Suraya::getInstance());
	$event->registerEvents(new LaunchPad(),Suraya::getInstance());
	$event->registerEvents(new Knockback(),Suraya::getInstance());
}
}