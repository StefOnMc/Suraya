<?php

namespace Stefi;


use pocketmine\command\SimpleCommandMap;
use pocketmine\plugin\PluginBase;
use pocketmine\plugin\PluginManager;
use pocketmine\scheduler\TaskScheduler;
use pocketmine\Server;
use pocketmine\utils\SingletonTrait;
use Stefi\API\CooldownsAPI;
use Stefi\API\EloAPI;
use Stefi\API\KillAPI;
use Stefi\Commande\CmdMgr;
use Stefi\Listen\ListenMgr;
use Stefi\Task\TaskMgr;

class Suraya extends PluginBase
{
	use SingletonTrait;
	public static function Server(): Server{
		return self::$instance->getServer();
	}
	public static function Task(): TaskScheduler{
		return self::$instance->getScheduler();
	}
	public static function Events(): PluginManager{
		return self::$instance->getServer()->getPluginManager();
	}
	public static function Cmd(): SimpleCommandMap {
		return self::$instance->getServer()->getCommandMap();
	}
	protected function onLoad(): void
	{
		self::setInstance($this);
	}

	protected function onEnable(): void
{
	CooldownsAPI::Init();
	EloAPI::Init();
	KillAPI::Init();
	TaskMgr::Init();
	ListenMgr::Init();
	CmdMgr::Init();


	$this->getLogger()->info("Suraya minicore lancée !");
}

}