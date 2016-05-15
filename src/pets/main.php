<?php

namespace pets;

use pocketmine\level\Location;
use pocketmine\level\Position;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\entity\Entity;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\Server;
use pets\command\PetCommand;
use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\math\Vector3;

class main extends PluginBase implements Listener {
	
	public $pet;
	public static $petState;
	public $petType;
	public $wishPet;
	public static $isPetChanging;
	public function onEnable() {
		$server = Server::getInstance();
		$server->getCommandMap()->register('pets', new PetCommand($this,"pets"));
		Entity::registerEntity(ChickenPet::class);
		Entity::registerEntity(WolfPet::class);
		Entity::registerEntity(PigPet::class);
		//$server->getScheduler()->scheduleRepeatingTask(new task\PetsTick($this), 20*60);//run each minute for random pet messages
		$server->getScheduler()->scheduleRepeatingTask(new task\SpawnPetsTick($this), 20);
		
	}

	public function create($player,$type, Position $source, ...$args) {
		$chunk = $source->getLevel()->getChunk($source->x >> 4, $source->z >> 4, true);

		$nbt = new CompoundTag("", [
			"Pos" => new ListTag("Pos", [
				new DoubleTag("", $source->x),
				new DoubleTag("", $source->y),
				new DoubleTag("", $source->z)
					]),
			"Motion" => new ListTag("Motion", [
				new DoubleTag("", 0),
				new DoubleTag("", 0),
				new DoubleTag("", 0)
					]),
			"Rotation" => new ListTag("Rotation", [
				new FloatTag("", $source instanceof Location ? $source->yaw : 0),
				new FloatTag("", $source instanceof Location ? $source->pitch : 0)
					]),
		]);
		$pet = Entity::createEntity($type, $chunk, $nbt, ...$args);
	//	$pet->setNameTag("Bob The Pet");
		$pet->setOwner($player);
		$pet->spawnToAll();
		return $pet; 
	}

	public function createPet(Player $player, $type, $holdType = "") {
 		if (isset($this->pet[$player->getName()]) != true) {	
			$len = rand(8, 12); 
			$x = (-sin(deg2rad($player->yaw))) * $len  + $player->getX();
			$z = cos(deg2rad($player->yaw)) * $len  + $player->getZ();
			$y = $player->getLevel()->getHighestBlockAt($x, $z);

			$source = new Position($x , $y + 2, $z, $player->getLevel());
			if ($type == "") {
				$pets = array("ChickenPet", "PigPet","WolfPet");
				$type = $pets[rand(0, 2)];
			}
			if ($type != "") {
// 				$pets = array("ChickenPet","PigPet");
// 				foreach ($pets as $key => $petType) {
// 					if($petType == $holdType) {
// 						unset($pets[$key]);
// 						break;
// 					}	
// 				}
// 				$type = $pets[array_rand($pets)];
				if ($type == "pig"){
					$type = "PigPet";
				}
				if ($type = "chicken"){
					$type = "ChickenPet";
				}
			}
			$pet = $this->create($player,$type, $source);
			$this->addPet($player->getName(),$pet);
 		}
	}

	public function onPlayerQuit(PlayerQuitEvent $event) {
		$player = $event->getPlayer();
		$pet = $player->getPet();
		if (!is_null($pet)) {
			$this->close($player->getName());
		}
	}
	
	/**
	 * Get last damager name if it's another player
	 * 
	 * @param PlayerDeathEvent $event
	 */
	public function onPlayerDeath(PlayerDeathEvent $event) {
		$player = $event->getEntity();
		$attackerEvent = $player->getLastDamageCause();
		if ($attackerEvent instanceof EntityDamageByEntityEvent) {
			$attacker = $attackerEvent->getDamager();
			if ($attacker instanceof Player) {
				$player->setLastDamager($attacker->getName());
			}
		}
	}

	
	//ported Pet API by BalAnce
	public static function setPetState($state,$player, $petType = "", $delay = 2) {
		self::$petState[$player] = array(
				'state' => $state,
				'petType' => $petType,
				'delay' => $delay
		);
	}
	
	public function getPetState($player){
		if(isset(self::$petState[$player]['state'])) {
			if(self::$petState[$player]['delay'] > 0){
				self::$petState[$player]['delay']--;
				return false;
			}
			return self::$petState[$player];
		}
		return false;
	}
	
	public function clearPetState($player){
		unset(self::$petState[$player]);
	}
	public function togglePetEnable($player) {
		if (!self::$isPetChanging[$player]) {
			if (isset($this->pet[$player])) {
				$this->getPet($player)->close();
				$this->pet[$player] = null;
				$this->getServer()->getPlayer($player)->sendMessage("Pet Disapeared!");	
				self::$isPetChanging[$player] = false;
			} else {
				$this->enablePet($this->getServer()->getPlayer($player));
			}
		}
	}
	
	public function getPet($player) {
		return $this->pet[$player];
	}
	
	public function enablePet(Player $player, $wishPet = "") {
		$this->petEnable[$player->getName()] = true;
			$type = "";
			$holdType = "";
			if (empty($wishPet)) {
				$holdType = $this->petType[$player->getName()];
			} else {
				$type = $this->wishPet[$player->getName()];
				$this->wishPet[$player->getName()] = "";
			}
			$this->createPet($player, self::$petState[$player->getName()]["petType"], $holdType);
			$player->sendMessage("Pet Summoned!");
	}
	
	public function showPet(Player $player,$type = "") {
			$this->wishPet[$player->getName()] = !empty($type) ? $type : $this->petType;
			if (isset($this->pet[$player->getName()])) {
				$this->getPet($player->getName())->close();
				$this->pet[$player->getName()] = null;
				self::$isPetChanging[$player->getName] = true;
			} else {
				$this->enablePet($player, $this->wishPet[$player->getName()]);
			}
		
	}
	

	public function hidePet(Player $player) {
		$this->petEnable[$player->getName()] = false;
		if (isset($this->pet[$player->getName()])) {
			$this->getPet($player->getName())->close();
			$this->pet[$player->getName()] = null;
			//send random bye message from pet
			$player->sendMessage("Pet hidden!");
		}
	}
	
	public function addPet($player,$pet) {
		$this->pet[$player] = $pet;
		$this->petType[$player] = $pet->getName();
	}
}
