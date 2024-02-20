<?php

namespace Stefi\Commande;

use Stefi\Suraya;

class CmdMgr
{
public static function Init(){
	$cmd = Suraya::Cmd();
	$cmd->registerAll("Suraya",[
		new Kit("kit","Se ravitaillier de stuff.","/kit",[]),
		new Elo("elo","Voir le top elo du serveur.","/elo",[]),
		new Xyz("xyz","Voir les coordonées (staff).","/xyz",[])
	]);
}
}