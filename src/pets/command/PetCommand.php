<?php

namespace pets\command;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pets\main;
use pocketmine\utils\TextFormat;

class PetCommand extends PluginCommand {

	public function __construct(main $main, $name) {
		parent::__construct(
				$name, $main
		);
		$this->main = $main;
		$this->setPermission("pets.command");
		$this->setAliases(array("pet"));
	}

	public function execute(CommandSender $sender, $currentAlias, array $args) {
		  
                         if (!isset($args[0])) {
                          if($sender->hasPermission('pets.command')){
			$this->main->togglePet($sender);
                         return true;
                          }else{
                           $sender->sendMessage(TextFormat::RED."You do not have permission to use this command");
			
                    return true;
                }
                         }
		 if($args[0] == "help"){
				if($sender->hasPermission('pets.command.help')){
				$sender->sendMessage("§e======PetHelp======");
				$sender->sendMessage("§b/pets to Spawn your Pet");
				$sender->sendMessage("§b/pets type [type]");
				$sender->sendMessage("§bTypes: blaze, pig, chicken, wolf, rabbit, magma, bat, silverfish");
                                return true;
				}else{$sender->sendMessage(TextFormat::RED."You do not have permission to use this command");
					    }
				return true;
                 }
			if($args[0] == "type"){
				if (isset($args[1])){
					if($args[1] == "wolf"){
							if ($sender->hasPermission("pets.type.wolf")){
								$this->main->changePet($sender, "WolfPet");
								$sender->sendMessage("Your pet has changed to Wolf!");
								return true;
							}else{
								$sender->sendMessage("You do not have permission for dog pet!");
								return true;
							}
                                        }
						if($args[1] == "chicken"){
							if ($sender->hasPermission("pets.type.chicken")){
								$this->main->changePet($sender, "ChickenPet");
								$sender->sendMessage("Your pet has changed to Chicken!");
								return true;
							}else{
								$sender->sendMessage("You do not have permission for chicken pet!");
								return true;
							}
                                                }
						if($args[1] == "pig"){
							if ($sender->hasPermission("pets.type.pig")){
								$this->main->changePet($sender, "PigPet");
								$sender->sendMessage("Your pet has changed to Pig!");
								return true;
							}else{
								$sender->sendMessage("You do not have permission for pig pet!");
								return true;
							}
                                                }
						if($args[1] == "blaze"){
							if ($sender->hasPermission("pets.type.blaze")){
								$this->main->changePet($sender, "BlazePet");
								$sender->sendMessage("Your pet has changed to Blaze!");
								return true;
							}else{
								$sender->sendMessage("You do not have permission for blaze pet!");
								return true;
							}
                                                }
						if($args[1] == "magma"){
							if ($sender->hasPermission("pets.type.magma")){
								$this->main->changePet($sender, "MagmaPet");
								$sender->sendMessage("Your pet has changed to Magma!");
								return true;
							}else{
								$sender->sendMessage("You do not have permission for blaze pet!");
								return true;
							}
                                                }
						if($args[1] == "rabbit"){
							if ($sender->hasPermission("pets.type.rabbit")){
								$this->main->changePet($sender, "RabbitPet");
								$sender->sendMessage("Your pet has changed to Rabbit!");
								return true;
							}else{
								$sender->sendMessage("You do not have permission for rabbit pet!");
								return true;
							}
                                                }
						if($args[1] == "bat"){
							if ($sender->hasPermission("pets.type.bat")){
								$this->main->changePet($sender, "BatPet");
								$sender->sendMessage("Your pet has changed to Bat!");
								return true;
							}else{
								$sender->sendMessage("You do not have permission for bat pet!");
								return true;
							}
                                                }
						if($args[1] == "silverfish"){
							if ($sender->hasPermission("pets.type.silverfish")){
								$this->main->changePet($sender, "SilverFishPet");
								$sender->sendMessage("Your pet has changed to SiverFish!");
								return true;
							}else{
								$sender->sendMessage("You do not have permission for SilverFish pet!");
								return true;
							}
						
							}
								if($args[1] == "spider"){
							if ($sender->hasPermission("pets.type.spider")){
								$this->main->changePet($sender, "SpiderPet");
								$sender->sendMessage("Your pet has changed to Spider!");
								return true;
							}else{
								$sender->sendMessage("You do not have permission for spider pet!");
								return true;
							}
                                                }
                                
						
				
			
        
	}
                                                
                                                
                        }                            
        }
}
                        

                         
        

