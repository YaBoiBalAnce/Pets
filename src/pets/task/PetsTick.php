<?php

namespace pets\task;

use Pets\Pets;
use pocketmine\scheduler\PluginTask;

/**
 * This task checks every 1 minute if player is need to get random pet message
 */
class PetsTick extends PluginTask {
	
	/**
	 * Base class constructor
	 * @param Plugin $plugin
	 */
	public function __construct($plugin) {
		parent::__construct($plugin);
	}
	
	/**
	 * Repeatable check for pet message receivers
	 * 
	 * @param int $currentTick
	 */
	public function onRun($currentTick) {
		$onlinePlayers = \pocketmine\Server::getInstance()->getOnlinePlayers();
// 		foreach ($onlinePlayers as $player) {
// 			if (self::needPetMessage($player)) {
// 				Pets::sendPetMessage($player, Pets::PET_LOBBY_RANDOM);
// 			}
// 		}
	}
	
	/**
	 * Check if player needs pet message
	 * 
	 * @ param LbPlayer $player
	 * @ return bool
	 */
// 	private static function needPetMessage($player) {
// 		$petsInterval = Pets::getTimeInterval($player->getLobbyTime());
// 		return ($player instanceof LbPlayer &&
// 				$player->getState() === LbPlayer::IN_LOBBY &&
// 				$petsInterval > 2 &&
// 				$player->getPet() != null &&
// 				rand(1,50) == 50);
// 	}
	
	
}
