<?php

namespace Stefi\Listen;

use onebone\economyapi\EconomyAPI;
use pocketmine\console\ConsoleCommandSender;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\player\Player;
use Stefi\API\EloAPI;
use Stefi\API\KillAPI;
use Stefi\Suraya;

class Elo implements Listener
{

	public function InitElo(PlayerJoinEvent $event)
	{
		if (!EloAPI::existElo($event->getPlayer())) {
			EloAPI::$data->set($event->getPlayer()->getName(), 0);
			EloAPI::$data->save();
		}
	}

	function calculateEloAdd(Player $killer) {
		$elo = EloAPI::getElo($killer);
$killername = $killer->getName();
		if ($elo >= 3000) {
			Suraya::Server()->dispatchCommand(new ConsoleCommandSender(Suraya::Server(),Suraya::Server()->getLanguage()),"setgroup $killername chepa");
EloAPI::addElo($killer,mt_rand(25,30));
		} elseif ($elo >= 2000) {
			Suraya::Server()->dispatchCommand(new ConsoleCommandSender(Suraya::Server(),Suraya::Server()->getLanguage()),"setgroup $killername guest");
			EloAPI::addElo($killer,mt_rand(25,30));
		} elseif ($elo >= 1000) {
			Suraya::Server()->dispatchCommand(new ConsoleCommandSender(Suraya::Server(),Suraya::Server()->getLanguage()),"setgroup $killername guest");
			EloAPI::addElo($killer,mt_rand(15,25));
		} elseif ($elo >= 800) {
			Suraya::Server()->dispatchCommand(new ConsoleCommandSender(Suraya::Server(),Suraya::Server()->getLanguage()),"setgroup $killername guest");
			EloAPI::addElo($killer,mt_rand(15,25));
		} elseif ($elo >= 600) {
			Suraya::Server()->dispatchCommand(new ConsoleCommandSender(Suraya::Server(),Suraya::Server()->getLanguage()),"setgroup $killername guest");
			EloAPI::addElo($killer,mt_rand(5,15));
		} elseif ($elo >= 400) {
			Suraya::Server()->dispatchCommand(new ConsoleCommandSender(Suraya::Server(),Suraya::Server()->getLanguage()),"setgroup $killername guest");
			EloAPI::addElo($killer,mt_rand(5,15));
		} elseif ($elo >= 300) {
			Suraya::Server()->dispatchCommand(new ConsoleCommandSender(Suraya::Server(),Suraya::Server()->getLanguage()),"setgroup $killername guest");
			EloAPI::addElo($killer,mt_rand(5,15));
		} elseif ($elo >= 100) {
			Suraya::Server()->dispatchCommand(new ConsoleCommandSender(Suraya::Server(),Suraya::Server()->getLanguage()),"setgroup $killername guest");
			EloAPI::addElo($killer,mt_rand(5,15));
		}else{
			EloAPI::addElo($killer,mt_rand(5,15));
		}
	}
	function calculateEloSup(Player $victim) {
		$elo = EloAPI::getElo($victim);

		if ($elo >= 3000) {
			EloAPI::removeElo($victim,mt_rand(22,30));
		} elseif ($elo >= 2000) {
			EloAPI::removeElo($victim,mt_rand(22,30));
		} elseif ($elo >= 1000) {
			EloAPI::removeElo($victim,mt_rand(14,22));
		} elseif ($elo >= 800) {
			EloAPI::removeElo($victim,mt_rand(14,22));
		} elseif ($elo >= 600) {
			EloAPI::removeElo($victim,mt_rand(3,8));
		} elseif ($elo >= 400) {
			EloAPI::removeElo($victim,mt_rand(3,8));
		} elseif ($elo >= 300) {
			EloAPI::removeElo($victim,mt_rand(3,8));
		} elseif ($elo >= 100) {
			EloAPI::removeElo($victim,mt_rand(3,8));
		}else{
			EloAPI::removeElo($victim,mt_rand(3,8));
		}
	}

	public function Kill(PlayerDeathEvent $event) {
		$player = $event->getPlayer();
		$cause = $player->getLastDamageCause();
		if ($cause instanceof EntityDamageByEntityEvent) {
			$killer = $cause->getDamager();
			if ($killer instanceof Player) {
				if (!KillAPI::checkKillLimit($player, $killer)) {
					$killer->kick("Ah ta voulu doullier, toute t'es stats sont reisialisé .");
					KillAPI::resetKills($killer);
					KillAPI::addDeath($killer);
					EloAPI::setElo($killer,0);
				}else{
					KillAPI::addKill($player,$killer);
					KillAPI::addDeath($player);
					EconomyAPI::getInstance()->addMoney($killer,mt_rand(10,25));
					KillAPI::setKillStreak($player,0);
					KillAPI::addKillStreak($killer,1);
					$this->calculateEloAdd($killer);
					$this->calculateEloSup($player);

				}
			}
		}
	}

}