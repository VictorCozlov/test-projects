<?php
require('Code.php');

class ProcessCodeException extends Exception {
}

class CodeProcessor{
	protected $eanMask;

	public function __construct($dbLink, $slim){
		$this->SetErrorMessage("");
		$this->slim = $slim;
		$this->GetEANCodePrefixes($dbLink);
		$this->GetCodeMask($dbLink);

	}

	protected function GetCodeMask($dbLink){
		$sql = "SELECT * FROM `shopParams` WHERE `VarName`='EANCodeMask'";
		$query = mysqli_query($dbLink, $sql);
		if($query === false) {
			$slim->halt(500, mysqli_error($dbLink)." sql=$sql");
		}
		$this->eanMask = array();
		while($el = mysqli_fetch_assoc($query)) {
			$this->eanMask[$el['key']] = $el['vval'];
		}
	}

	protected function GetEANCodePrefixes($dbLink) {
		$sql = "SELECT * FROM `shopParams` WHERE `VarName`='EANCode'";
		$query = mysqli_query($dbLink, $sql);
		if($query === false) {
			$slim->halt(500, mysqli_error($dbLink)." sql=$sql");
		}
		$this->codes = array();
		while($el = mysqli_fetch_assoc($query)) {
			$this->codes[$el['key']] = $el['vval'];
		}
	}

	public function PrefixLength() {
		return $this->eanMask['prefix'];
	}

	public function IdLength() {
		return $this->eanMask['id'];
	}

	public function WeightIntLength() {
		return $this->eanMask['weightIntPart'];
	}

	public function WeightFracLength() {
		return $this->eanMask['weightFracPart'];
	}

	public function GetCodeObj($code, $silent = false) {
		if(!$this->IsValid($code)) {
			if(!$silent) {
				throw new ProcessCodeException($this->GetErrorMessage());
			} else {
				//in this place I don't set the error message because the error message was setted previously
				//in $this->IsValid function
				return false;
			}
		}

		$prefixLength = $this->PrefixLength();
		$idLength = $this->IdLength();
		$wIntLength =$this->WeightIntLength();
		$wFracLength = $this->WeightFracLength();

		$pregExpr = "/^(?P<prefix>\d{".$prefixLength."})(?P<id>\d{".$idLength."})(?P<wInt>\d{".$wIntLength."})(?P<wFrac>\d{".$wFracLength."})\d$/";
		$pregRes = array();

		if(preg_match($pregExpr, $code, $pregRes) === 0) {
			$msg = "CodeProcessor-\>ProcessCode:\code is not digestiv for preg_match";
			if(!$silent) {
				throw new ProcessCodeException($msg);
			} else {
				$this->SetErrorMessage($msg);
				return false;
			}
		}

		$prefix = $pregRes['prefix'];
		$id = $pregRes['id'];
		$wInt = $pregRes['wInt'];
		$wFrac = $pregRes['wFrac'];
		$weight = (double)($wInt.".".$wFrac);

		$role = array_keys($this->codes, $prefix);
		$role = $role[0];

		if(is_null($role)) {
			$msg = "CodeProcessor-\>ProcessCode:\$code's role can not be determined";
			if(!$silent) {
				throw new ProcessCodeException($msg);
			} else {
				$this->SetErrorMessage($msg);
				return false;
			}
		}

		return new Code($prefix, $id, $weight, $role);
	}

	public function GetEmptyCode() {
		return Code::GetEmptyCode();
	}

	public function GetCodeStr($code, $silent = false){
		$id = $code->Id(); 
		$role = $code->Role();
		$prefix = $code->Prefix();
		$weight = $code->Weight();

		//transform to str section
		$wIntVal = intval($weight);
		$wFracLength = $this->WeightFracLength();
		$wFracVal = ($weight - $wIntVal) * pow(10, $wFracLength);
		$wInt = $this->FillWithZeroes(intval($weight), $this->WeightIntLength());
		$wFrac = $this->FillWithZeroes($wFracVal, $wFracLength);
		$id = $this->FillWithZeroes($id, $this->IdLength()); 
		$prefix = $this->FillWithZeroes($prefix, $this->PrefixLength());

		$partialCode = $prefix.$id.$wInt.$wFrac;
		$checkSum = (string)$this->CheckSum($partialCode);

		return $partialCode.$checkSum;
	}

	protected function FillWithZeroes($target, $targetLength) {
		$target = (string)$target;
		$startIndex = strlen($target);

		for($i = $startIndex; $i < $targetLength; $i++) {
			$target = "0".$target;
		}

		return $target;
	}

	public function IsValid($code){
		if(!is_string($code)){
			$this->SetErrorMessage("CodeProcessor-\>IsValid: \$code is not a string");
			return false;
		}

		if(strlen($code) != 13){
			$this->SetErrorMessage("CodeProcessor-\>IsValid:\$code do not have the length equal to 13");
			return false;
		}
		
		$originalCheckSum = (int)substr($code, 12);
		$calculatedCheckSum = $this->CheckSum(substr($code, 0, 12));
		if($originalCheckSum !== $calculatedCheckSum){
			$this->SetErrorMessage("CodeProcessor-\>IsValid:\$code has a wrong check sum. Correct check sum = $calculatedCheckSum, Incorrect check sum = $originalCheckSum.");
			return false;
		}

		return true;
	}

	//CheckSum will work only with $code with length equal to 12
	protected function CheckSum($code) {
		if(strlen($code) != 12) {
			$msg = "\code do not have the length equal to 12";
			throw new ProcessCodeException($msg);
		}

		$sum = 0;
		for($i = 0; $i < 12; $i++) {
			$char = (int)substr($code, $i, 1);
			$sum += $i % 2 ? $char * 3 : $char; 
		}

		$rest = $sum % 10;

		if($rest === 0) {
			return 0;
		} 
		
		return 10 - $rest;
	}

	protected function SetErrorMessage($msg) {
		$this->errorMessage = $msg;
	}

	public function GetErrorMessage() {
		return $this->errorMessage;
	}
}
?>
