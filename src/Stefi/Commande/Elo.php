<?php

namespace Stefi\Commande;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use Stefi\API\EloAPI;
use Stefi\Suraya;

class Elo extends Command
{
	public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = [])
	{
		parent::__construct($name, $description, $usageMessage, $aliases);
		$this->setPermission("elo.use");
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args)
	{
		if ($sender instanceof Player) {
			$eloData = [];
			foreach (Suraya::Server()->getOnlinePlayers() as $player) {
				$eloData[$player->getName()] = EloAPI::getElo($player);
			}


			arsort($eloData);


			$page = isset($args[0]) ? max(1, (int)$args[0]) : 1;
			$perPage = 10;
			$totalPages = ceil(count($eloData) / $perPage);


			$start = ($page - 1) * $perPage;
			$end = $start + $perPage;
			$message = "Classement ELO - Page $page/$totalPages:\n";
			$i = 0;
			foreach ($eloData as $playerName => $elo) {
				$i++;
				if ($i > $end) break;
				if ($i > $start) {
					$message .= "$playerName : $elo points\n";
				}
			}

			$sender->sendMessage($message);
			$sender->sendMessage("Votre elo et de ". EloAPI::getElo($sender));
		} else {
			$sender->sendMessage("Cette commande ne peut être exécutée que par un joueur.");
		}
		return true;
	}

}