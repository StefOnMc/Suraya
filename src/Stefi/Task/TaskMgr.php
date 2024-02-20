<?php

namespace Stefi\Task;

use Stefi\Suraya;

class TaskMgr
{
public static function Init(){
	$task = Suraya::Task();
	$task->scheduleRepeatingTask(new CooldownsTask(),20);
	$task->scheduleRepeatingTask(new ResetKillTask(),300*20);
	$task->scheduleRepeatingTask(new ChestReffill(),20);
}
}