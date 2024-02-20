<?php

namespace Stefi\Commande;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\network\mcpe\protocol\GameRulesChangedPacket;
use pocketmine\network\mcpe\protocol\types\BoolGameRule;
use pocketmine\player\Player;

class Xyz extends Command
{
	public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = [])
	{
		parent::__construct($name, $description, $usageMessage, $aliases);
		$this->setPermission("xyz.use");
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args)
{
	if($sender instanceof Player){
		if(isset($args[0])){
			switch($args[0]){
				case "on":
					$pk = new GameRulesChangedPacket();
					$pk->gameRules = [
						"showcoordinates" => new BoolGameRule(true,false)
					];
					$sender->getNetworkSession()->sendDataPacket($pk);
					$sender->sendMessage("§aVous avez bien activé les coordonées.");
					break;
				case "off":
					$pk = new GameRulesChangedPacket();
					$pk->gameRules = [
						"showcoordinates" => new BoolGameRule(false,false)
					];
					$sender->getNetworkSession()->sendDataPacket($pk);
					$sender->sendMessage("§cVous avez bien désactivé les coordonées.");
					break;
			}
		}else{
			$sender->sendMessage("§c/xyz on/off");
		}
	}
}
}