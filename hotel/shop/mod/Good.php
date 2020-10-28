<?php
function getGood($goodCode, $sellerCode, $desktopCode) {
	global $dbConn;
	global $codeProcessor;
	global $app;
	$client = new Good($sellerCode, $codeProcessor , $app, $dbConn);

	echo $client->GetGood($goodCode);

	return true;
}

class Good {
	public function __construct($sellerCode, $codeProcessor, $slim, $dbConn) {
		$this->codeProcessor = $codeProcessor;
		$this->slim = $slim;
		$this->dbConn = $dbConn;
	}

	public function GetGood($goodCode){

		$goodObj = $this->codeProcessor->GetCodeObj($goodCode);
		$id = $goodObj->Id();
		$sql = "SELECT * FROM `shopGoods` WHERE `id`=$id";
		$query = mysqli_query($this->dbConn, $sql);
		if($query === false) {
			$app->halt(500, "Good.php: ".mysqli_error($dbConn)." sql=$sql");
		}

		if(mysqli_num_rows($query) == 0) {
			$app->halt(404, "Inexistent goodID");
		}

		$res = mysqli_fetch_assoc($query);
		return json_encode(array(
			'name1' => $res['name1'],
		));
	}

}
?>
