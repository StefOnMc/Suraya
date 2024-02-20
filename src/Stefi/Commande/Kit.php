<?php

namespace Stefi\Commande;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\PotionType;
use pocketmine\item\VanillaItems;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use Stefi\API\CooldownsAPI;

class Kit extends Command
{
public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = [])
{
	parent::__construct($name, $description, $usageMessage, $aliases);
	$this->setPermission("kit.use");
}

public function execute(CommandSender $sender, string $commandLabel, array $args)
{
	if($sender instanceof Player){
		if(isset($args[0])){
switch($args[0]) {
	case "sorcier":

if(CooldownsAPI::hasCooldown($sender->getName(),"sorcier")){
	$time = CooldownsAPI::getTime($sender->getName(),"sorcier");
$sender->sendMessage("§c Il vous reste $time.");
}else{
	$sender->sendToastNotification("","Vous avez bien récupéré le kit sorcier.");
	if(!$this->Isfull($sender) && !$this->IsfullArmor($sender)){
		CooldownsAPI::setCooldown($sender->getName(),30,"seconde","sorcier");
	$objArmor = [
		VanillaItems::IRON_HELMET(),
		VanillaItems::IRON_CHESTPLATE(),
		VanillaItems::IRON_LEGGINGS(),
		VanillaItems::IRON_BOOTS()
	];
	$obj = [
		VanillaItems::IRON_SWORD(),
		VanillaItems::POTION()->setType(PotionType::LONG_REGENERATION()),
		VanillaItems::SPLASH_POTION()->setType(PotionType::STRONG_REGENERATION()),
		VanillaItems::SPLASH_POTION()->setType(PotionType::POISON()),
		VanillaItems::POTION()->setType(PotionType::SWIFTNESS())->setCount(2)
	];
	foreach($objArmor as $armor){
		$sender->getArmorInventory()->addItem($armor);
	}
	foreach ($obj as $item){
		$sender->getInventory()->addItem($item);
	}

}else{
		$sender->sendMessage("§cVotre inventaire et plein.");
	}
}

		break;
	case "tank":
		if(CooldownsAPI::hasCooldown($sender->getName(),"tank")){
			$time = CooldownsAPI::getTime($sender->getName(),"tank");
			$sender->sendMessage("§c Il vous reste $time.");
		}else{
			if(!$this->Isfull($sender) && !$this->IsfullArmor($sender)){
				$sender->sendToastNotification("","Vous avez bien récupéré le kit tank.");
				CooldownsAPI::setCooldown($sender->getName(),30,"seconde","tank");
				$objArmor = [
					VanillaItems::DIAMOND_HELMET()->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PROTECTION(),2)),
					VanillaItems::DIAMOND_CHESTPLATE()->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PROTECTION(),2)),
					VanillaItems::DIAMOND_LEGGINGS()->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PROTECTION(),2)),
					VanillaItems::DIAMOND_BOOTS()->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PROTECTION(),2))
				];
				$obj = [
VanillaItems::DIAMOND_SWORD()
				];
				foreach($objArmor as $armor){
					$sender->getArmorInventory()->addItem($armor);
				}
				foreach ($obj as $item){
					$sender->getInventory()->addItem($item);
				}
			}else{
				$sender->sendMessage("§cVotre inventaire et plein.");
			}
		}
		break;
	case "chevalier":
		if(CooldownsAPI::hasCooldown($sender->getName(),"chevalier")){
			$time = CooldownsAPI::getTime($sender->getName(),"chevalier");
			$sender->sendMessage("§c Il vous reste $time.");
		}else{
			if(!$this->Isfull($sender) && !$this->IsfullArmor($sender)){
				$sender->sendToastNotification("","Vous avez bien récupéré le kit chevalier.");
				CooldownsAPI::setCooldown($sender->getName(),30,"seconde","chevalier");
				$objArmor = [
					VanillaItems::DIAMOND_HELMET(),
					VanillaItems::DIAMOND_CHESTPLATE(),
					VanillaItems::DIAMOND_LEGGINGS(),
					VanillaItems::DIAMOND_BOOTS()
				];
				$obj = [
					VanillaItems::DIAMOND_SWORD()->addEnchantment(new EnchantmentInstance(VanillaEnchantments::SHARPNESS(),2))
				];
				foreach($objArmor as $armor){
					$sender->getArmorInventory()->addItem($armor);
				}
				foreach ($obj as $item){
					$sender->getInventory()->addItem($item);
				}
			}else{
				$sender->sendMessage("§cVotre inventaire et plein.");
			}
		}
		break;
}
		}else{
			$sender->sendMessage("§c/kit sorcier/tank/chevalier");
		}
	}
}

public function Isfull(Player $p): bool{
	$invC = $p->getInventory()->getContents();
	$invSize = $p->getInventory()->getSize();
	if (count($invC) >= $invSize) {
		return true;
	} else {
		return false;
	}
}
	public function IsfullArmor(Player $p): bool{
		$invC = $p->getArmorInventory()->getContents();
		$invSize = $p->getArmorInventory()->getSize();
		if (count($invC) >= $invSize) {
			return true;
		} else {
			return false;
		}
	}
}