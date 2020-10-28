<?php
function putClient($ticketCode, $clientCode, $sellerCode, $desktopCode) {
	global $dbConn;
	global $codeProcessor;
	global $app;
	$client = new Client($sellerCode, $codeProcessor , $app, $dbConn);

	echo $ticket->PutClient($clientCode, $ticketCode);

	return true;
}

function getClient($clientCode, $sellerCode, $desktopCode) {
	global $dbConn;
	global $codeProcessor;
	global $app;
	$client = new Client($sellerCode, $codeProcessor , $app, $dbConn);

	echo $client->GetClient($clientCode);

	return true;
}

class Client {
	public function __construct($sellerCode, $codeProcessor, $slim, $dbConn) {
		$this->codeProcessor = $codeProcessor;
		$this->slim = $slim;
		$this->dbConn = $dbConn;
		$this->SetSellerCode($sellerCode);
	}

	protected function SetSellerCode($sellerCode) {
		$codeProcessor = $this->codeProcessor;
		$sellerCode = $this->sellerCode = $codeProcessor->GetCodeObj($sellerCode);
		if($sellerCode->Role() !== "seller") {
			$this->Slim()->halt(400, "Seller code do not correspond to the role");
		}
	}

	public function SellerCode() {
		return $this->sellerCode;
	}
	
	public function PutClient($clientCode, $ticketCode) {

	}

	public function GetClient($clientCode) {
		$dbConn = $this->dbConn;
		$codeProcessor = $this->codeProcessor;
		$slim = $this->slim;

		try {
			$clientCodeObj = $codeProcessor->GetCodeObj($clientCode, $silent = true);
		} catch (ProcessCodeException $e) {
			$slim->halt(403, "Wrong client code ".$e->GetMessage);
		}

		$clientId = $clientCodeObj->Id();
		$sql = "SELECT * FROM `shopClient` WHERE `id` = $clientId";
		$query = mysqli_query($dbConn, $sql);
		if($query === false) {
			$slim->halt(500, "Client.php-\>GetClient ".mysqli_error($dbConn)." sql = $sql");
		}

		if(mysqli_num_rows($query) === 0) {
			$slim->halt(404, "This client code can't be found!");
		}

		$res = mysqli_fetch_assoc($query);
		return json_encode(array(
			'id' => $clientCode,
			'canBarrow' => $res['canBarrow'],
		));
	}
}

?>
