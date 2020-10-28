<?php
class Code {
	protected $prefix;
	protected $id;
	protected $weight;
	protected $role;

	public function __construct($prefix, $id, $weight, $role) {
		$this->prefix = $prefix;
		$this->id = $id;
		$this->weight = $weight;
		$this->role = $role;
	}

	public static function GetEmptyCode() {
		return new self("", "", "", "");
	}

	public function Role() {
		return $this->role;
	}

	public function Prefix() {
		return $this->prefix;
	}

	public function Id() {
		return $this->id;
	}

	public function Weight() {
		return $this->weight;
	}
}
?>
