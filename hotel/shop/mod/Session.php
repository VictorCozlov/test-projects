<?php
require 'Slim/Middleware.php';

class Session extends \Slim\Middleware{
	protected $dbLink;
	protected $app;
	protected $codeProcessor;

	public function __construct($dbLink, $app, $codeProcessor) {
		$this->dbLink = $dbLink;
		$this->app = $app;
		$this->codeProcessor = $codeProcessor;
	}

	public function isOpen($clientCode, $desktopId) {
		$link  = $this->dbLink;
		$sql = "SELECT *, TIMESTAMPDIFF(SECOND, `lastrequest`, NOW()) AS timeInterval FROM `shopSession` WHERE `usercode`='$clientCode' AND `desktopId`='$desktopId'";
		$query = mysqli_query($link, $sql);
		if($query === false) {
			$this->app->halt(500, "class Session-.isOpen ".mysqli_error($link)." sql=$sql");	
		}

		if($query->num_rows === 0){
			return false;
		} elseif($query->num_rows > 1) {
			$this->app->halt(500, "class Session-.isOpen there are two record for same usercode = '$clientCode'");
		}

		$queryResult = mysqli_fetch_assoc($query);
		$queryTimeInterval = (int)$queryResult['timeInterval'];

		$sql = "SELECT * FROM `shopParams` WHERE `region`='general' AND `varName`='sessionLifetime'";
		$query = mysqli_query($link, $sql);
		if($query === false) {
			$this->app->halt(500, "class Session-.isOpen ".mysqli_error($link)." sql=$sql");	
		}

		$queryResult = mysqli_fetch_array($query);
		$paramsLifetime = (int)$queryResult['vval'];

		if($paramsLifetime < $queryTimeInterval) {
			$this->close($clientCode, $desktopId);
			return false;
		} else {
			$this->update($clientCode, $desktopId);
		}

		return true;
	}

	public function close($clientCode, $desktopId){
		$link  = $this->dbLink;
		$sql = "DELETE FROM `shopSession` WHERE `usercode`='$clientCode' AND `desktopId`='$desktopId'";
		$query = mysqli_query($link, $sql);
		if($query === false) {
			$this->app->halt(500, "class Session.close ".mysqli_error($link)." sql=$sql");	
		}
	}

	public function open($clientCode, $desktopId){
		$link = $this->dbLink;
		$sql = "INSERT INTO `shopSession`(`usercode`, `desktopId`, `lastrequest`) VALUES('$clientCode', '$desktopId', NOW())";
		$query = mysqli_query($link, $sql);
		if($query === false) {
			if(in_array(mysqli_errno($link), array(1022, 1060, 1061, 1062, 1063, 1291) )) {
				$this->app->halt(403, "There are just an open session with this code");
			} else {
				$this->app->halt(500, "Session.open ".mysqli_error($link)."sql = '$sql' errNo = ".mysqli_errno($link));
			}
		}
	}

	public function update($clientCode, $desktopId){
		$link  = $this->dbLink;
		$sql = "UPDATE `shopSession` SET `lastrequest`=NOW() WHERE `usercode`='$clientCode' AND `desktopId`='$desktopId'";
		$query = mysqli_query($link, $sql);
		if($query === false) {
			$this->app->halt(500, "class Session.update ".mysqli_error($link)." sql=$sql");	
		}
	}

	public function call() {
		$request = $this->app->request();
		$response = $this->app->response();
		$path = $request->getPath();

		$regRes = array();
		if(preg_match("/(?:\/(?P<auth>auth))?\/(?P<sellerCode>\d{13}|parameters)\/(?P<desktopId>\d{13,15}|ClientStart)\/?$/", $path, $regRes) === 0) {
			$response->setStatus(404);
			$response->setBody("Incorrect address format"."path: $path");
			return;
		}

		//decompose regex
		$desktopId = $regRes['desktopId'];
		$urlSellerPart = $regRes['sellerCode'];

		//get code object
		if($urlSellerPart === 'parameters') {
			$sellerCode = $this->codeProcessor->GetEmptyCode();
		} else {
			$sellerCode = $this->codeProcessor->GetCodeObj($urlSellerPart);
		}
		$sellerId = $sellerCode->Id();

		//determine the condition parts
		$isSessionOpen = $sellerCode->Role() === "seller" && $this->isOpen($sellerId, $desktopId); 
		$isAuthRequest = isset($regRes['auth']);
		$isParametersRequest = $urlSellerPart === 'parameters' && $desktopId === 'ClientStart';
		if(!( $isSessionOpen || $isAuthRequest || $isParametersRequest)) {
			$response->setStatus(401);
			return;
		}
		$this->next->call();

		/*echo "<br>"
		echo $request->getRootUri();
		echo "<br>"
		echo $request->getResourceUri();
		echo "<br>"
		echo $request->getBody();
		 */
	}
}
?>
