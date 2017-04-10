<?php

	namespace Brin;

	use pocketmine\scheduler\PluginTask;

	use pocketmine\math\Vector3;

	class aAC_Timer extends PluginTask {

		public function __construct($plugin, $player) {
			parent::__construct($plugin);
			$this->player = $player;
		}

		public function onRun($tick) {
			$user = mb_strtolower($this->player->getName());
			$blocks    = $this->getOwner()->open[$user]['coords'];
			$entities  = $this->getOwner()->open[$user]['entities'];
			$particles = $this->getOwner()->open[$user]['particles'];
			unset($this->getOwner()->open[$user]);

			$level = $this->player->getLevel();
			foreach($blocks as $coords => $block) {
				$coords = explode(':', $coords);
				$level->setBlock(new Vector3($block->x, $block->y, $block->z), $block);
			}

			foreach($entities as $entity)
				$this->getOwner()->removeEntity($entity, $level);

			if($particles !== false)
				$this->getOwner()->getServer()->getScheduler()->cancelTask($particles);
		}

	}

?>