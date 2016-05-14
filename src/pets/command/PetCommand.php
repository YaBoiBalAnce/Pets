<?php

namespace pets\command;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pets\main;

class PetCommand extends PluginCommand {

	public function __construct(main $main, $name) {
		parent::__construct(
				$name, $main
		);
		$this->main = $main;
		$this->setPermission("Pets.command");
	}

	public function execute(CommandSender $sender, $currentAlias, array $args) {
	
		if (!isset($args[0])) {
			//$sender->setPetState('toggle');
			$this->main->setPetState("toggle", $sender->getName());
//			$sender->togglePetEnable();
			return true;
		}

		$arg = strtolower($args[0]);

		if ($arg == "yes" || $arg == "on") {
			//$sender->setPetState('show');
			$this->main->setPetState("show", $sender->getName());
//			$sender->showPet();
			return true;
		}

		if ($arg == "no" || $arg == "off") {
			//$sender->setPetState('hide');
			$this->main->setPetState("hide", $sender->getName());
//			$sender->hidePet();
			return true;
		}

		$avilablePets = array("dog", "chicken");
		if (in_array($arg, $avilablePets)) {
			if ($arg == "dog") {
				$arg = "wolf";
			}
			//$sender->setPetState('show', ucfirst($arg) . "Pet");
			$this->main->setPetState("hide", $sender->getName(), ucfirst($arg) . "Pet");
//			$sender->showPet(ucfirst($arg) . "Pet");
			return true;
		}

		//$sender->togglePetEnable();
		$this->main->togglePetEnable($sender->getName());
		return true;
	}

}
