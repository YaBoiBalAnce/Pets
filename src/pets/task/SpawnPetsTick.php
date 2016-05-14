<?php

namespace pets\task;

use pocketmine\scheduler\PluginTask;
use pets\main;

/**
 * This task checks every 1 minute if player is need to get random pet message
 */
class SpawnPetsTick extends PluginTask {
	
	/**
	 * Base class constructor
	 * @param Plugin $plugin
	 */
	public function __construct(main $main) {
		parent::__construct($main);
		$this->main = $main;
	}
	
	/**
	 * Repeatable check for pet message receivers
	 * 
	 * @param int $currentTick
	 */
	public function onRun($currentTick) {
		$onlinePlayers = \pocketmine\Server::getInstance()->getOnlinePlayers();
		foreach ($onlinePlayers as $player) {
			if(($state = $this->main->getPetState($player->getName()))) {
				if($state['state'] == "toggle") {
					$this->main->togglePetEnable($player->getName());
				} elseif($state['state'] == "enable") {
					$this->main->enablePet($player, $state['petType']);
				} elseif($state['state'] == "show") {
					$this->main->showPet($player, $state['petType']);
				} elseif($state['state'] == "hide") {
					$this->main->hidePet($player);					
				}  elseif($state['state'] == "create") {
					$this->main->createPet($player);					
				}
				$this->main->clearPetState($player->getName());
			}
		}
	}
	
	
}
