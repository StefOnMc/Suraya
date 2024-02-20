<?php
namespace Stefi\Commande;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use Stefi\API\EloAPI;

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
			$eloData = EloAPI::getAllElo();
			arsort($eloData);

			if (isset($args[0])) {
				$page = (int)$args[0];
				if ($page < 1) {
					$sender->sendMessage("Impossible d'afficher une page négative.");
					return false;
				}
			} else {
				$page = 1;
			}

			$totalPages = ceil(count($eloData) / 10);

			if ($page > $totalPages) {
				$sender->sendMessage("La page spécifiée n'existe pas.");
				return false;
			}

			$start = ($page - 1) * 10;
			$end = $start + 10;
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


			$sender->sendMessage("Votre elo est de " . EloAPI::getElo($sender));
		} else {
			$sender->sendMessage("Cette commande ne peut être exécutée que par un joueur.");
		}
		return true;
	}
}

