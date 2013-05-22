<?php

	require_once "db.inc.php";

	class Issue {

		public $title;
		public $text;
		public $open;
		public $active;

		public __construct($title, $text) {
			this->title = $title;
			this->text = $text;
			this->open = true;
			this->active = false;
		}

		public static function spin() {
			$res = Database::Query("SELECT * FROM issues WHERE active = false AND open = true ORDER BY RAND() LIMIT 1");

		}
		
	}

?>