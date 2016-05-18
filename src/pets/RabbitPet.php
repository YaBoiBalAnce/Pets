<?php

namespace pets;

class RabbitPet extends Pets {

	const NETWORK_ID = 101;

	public $width = 0.3;
	public $height = 0.5;
	
	public function getName() {
		return "RabbitPet";
	}

	public function getSpeed() {
		return 1.5;
	}
	

}
