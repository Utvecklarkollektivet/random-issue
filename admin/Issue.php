<?php

	require_once "db.inc.php";

	class Issue {

		public $id;
		public $title;
		public $text;
		public $open;
		public $active;

		public function __construct($title = "", $text = "") {
			$this->title = $title;
			$this->text = $text;
			$this->open = true;
			$this->active = false;
		}

		public static function spin() {
			if(Issue::canSpin()) {
				$res = Database::Query("SELECT * FROM issues WHERE active = false AND open = true ORDER BY RAND() LIMIT 1")->fetch();
				if($res) {
					$issue = Issue::load($res);
					$issue->active = true;
					$issue->save();	
				}
				else {
					return null;
				}
				
			}
		}

		private static function load($data) {
			$i = new Issue();
			foreach($data as $key => $value) {
				$i->$key = $value;
			}
			return $i;
		}

		public function save() {
			$data = array(
				':title' => $this->title,
				':text' => $this->text,
				':active' => $this->active,
				':open' => $this->open, 
				':id' => $this->id,
				);
			Database::Query("UPDATE issues SET title = :title, text = :text, open = :open, active = :active WHERE id = :id", $data);
		}

		public function close(){
			$this->active = false;
			$this->open = false;
			$this->save();
			Issue::spin();
		}
		
		public static function find($id) {
			$res = Database::Query("SELECT * FROM issues WHERE id = :id LIMIT 1", array(":id" => $id))->fetch();
			return Issue::load($res);
		}

		public static function canSpin() {
			$res = Database::Query("SELECT COUNT(id) as count FROM issues WHERE active = 1")->fetch();
			return ($res["count"] < 1);
		}

		public static function getActive() {
			$res = Database::Query("SELECT * FROM issues WHERE active = true LIMIT 1")->fetch();
			if($res != NULL) {
				return Issue::load($res);
			}
			else {
				if(Issue::spin())
					return Issue::getActive();
				else
					return null;
			}
		}

	}

?>