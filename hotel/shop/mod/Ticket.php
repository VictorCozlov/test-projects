<?php
//url mapping zone
function getTicket($ticketCode, $sellerCode, $desktopCode) {
	global $codeProcessor;
	global $app;
	global $dbConn;
	$ticket = new Ticket($sellerCode, $codeProcessor , $app, $dbConn);

	echo $ticket->GetTicket($ticketCode);

	return true;
}

function putTicket($ticketCode, $sellerCode, $desktopCode) {
	global $codeProcessor;
	global $app;
	global $dbConn;
	$ticket = new Ticket($sellerCode, $codeProcessor , $app, $dbConn);

	echo $ticket->PutTicket($ticketCode);

	return true;
}

function putTicketCreate($sellerCode, $desktopCode) {
	global $dbConn;
	global $codeProcessor;
	global $app;
	$ticket = new Ticket($sellerCode, $codeProcessor , $app, $dbConn);

	echo $ticket->PutTicket();

	return true;
}

function postTicket($sellerCode, $desktopCode) {
	global $dbConn;
	global $codeProcessor;
	global $app;
	$ticket = new Ticket($sellerCode, $codeProcessor , $app, $dbConn);

	echo $ticket->PostTicket();

	return true;
}

function deleteTicket($ticketCode, $sellerCode, $desktopCode) {
	global $codeProcessor;
	global $app;
	global $dbConn;
	$ticket = new Ticket($sellerCode, $codeProcessor , $app, $dbConn);

	echo $ticket->DeleteTicket($ticketCode);

	return true;

}

function deleteTicketRow($ticketCode, $sqlRowId, $sellerCode, $desktopCode) {
	global $codeProcessor;
	global $app;
	global $dbConn;
	$ticket = new Ticket($sellerCode, $codeProcessor , $app, $dbConn);

	echo $ticket->DeleteTicketRow($ticketCode, $sqlRowId);

	return true;

}

class Ticket {
	public function __construct($sellerCode, $codeProcessor, $slim, $dbConn) {
		$this->codeProcessor = $codeProcessor;
		$this->slim = $slim;
		$this->dbConn = $dbConn;
		$this->SetSellerCode($sellerCode);

		$this->SetUpPostData();
	}

	protected function SetSellerCode($sellerCode) {
		$codeProcessor = $this->CodeProcessor();
		$sellerCode = $this->sellerCode = $codeProcessor->GetCodeObj($sellerCode);
		if($sellerCode->Role() !== "seller") {
			$this->Slim()->halt(400, "Seller code do not correspond to the role");
		}
	}
	
	public function DbConn() {
		return $this->dbConn;
	}

	public function SellerCode() {
		return $this->sellerCode;
	}

	protected function SetUpPostData() {
		$codeProcessor = $this->CodeProcessor();
		$app = $this->Slim();
		$request = $app->request();
		$postData = json_decode($request->getBody(), true);

		//if(is_null($postData)) {
		//	$app->halt(400, "The post data is not correct packed in json format".$request->getBody());
		//}

		$this->SetGoodCode($postData['goodCode']);
		$this->SetCount($postData['count']);
		$this->SetAssistCode($postData['assistCode']);
		$this->SetFreeze($postData['freeze']);
		$this->SetPaid($postData['paid']);
		$this->SetComment($postData['comment']);
		$this->SetClientCode($postData['clientCode']);
	}

	protected function SetGoodCode($goodCode = null) {
		if(is_null($goodCode)) {
			$this->goodCode = $goodCode;
			return;
		}

		$codeProcessor = $this->CodeProcessor();
		$this->goodCode = $codeProcessor->GetCodeObj($goodCode);
		if(!in_array($this->goodCode->Role(), array("weight", "piece"))) {
			$this->Slim()->halt(400, "The setted goodCode do not match any good role");
		}
	}

	public function GoodCode() {
		return $this->goodCode;
	}

	protected function SetClientCode($clientCode = null) {
		if(is_null($clientCode)) {
			$this->clientCode = $clientCode;
			return;
		}

		$codeProcessor = $this->CodeProcessor();
		$this->clientCode = $codeProcessor->GetCodeObj($clientCode);
		if(!in_array($this->clientCode->Role(), array("client", ))) {
			$this->Slim()->halt(400, "The setted clientCode do not match client role");
		}
	}

	public function ClientCode() {
		return $this->clientCode;
	}

	protected function SetCount($count = null) {
		if(is_null($count)) {
			$this->count = $count;
			return;
		}
		$count = (int)$count;

		if($count <= 0) {
			$this->Slim()->halt(400, "The count can't be a negative number or zero");
		}
		$this->count = (int)$count;
	}

	public function Count() {
		return $this->count;
	}

	protected function SetAssistCode($assistCode = null) {
		if(is_null($assistCode)) {
			$this->assistCode = null;
			return;
		}
		$assistCode = $this->CodeProcessor()->GetCodeObj($assistCode);
		if(!in_array($assistCode->Role(), array('seller', ))) {
			$this->Slim()->halt(400, "The assistCode do not have the correct role");
		}
		$this->assistCode = $assistCode;
	}

	public function AssistCode() {
		return $this->assistCode;
	}

	protected function SetComment($comment) {
		$this->comment = trim($comment);
	}

	public function Comment() {
		return $this->comment;
	}

	protected function SetPaid($paid = null) {
		if(is_null($paid)) {
			$this->paid = null;
			return;
		}

		$this->paid = (bool)(int)$paid;
	}

	public function IsForPaid() {
		return $this->paid;
	}

	protected function SetFreeze($freeze = null) {
		if(is_null($freeze)) {
			$this->freeze = null;
			return;
		}

		$this->freeze = (bool)(int)$freeze;
	}

	public function Freeze() {
		return $this->freeze;
	}

	public function Slim() {
		return $this->slim;
	}

	public function CodeProcessor() {
		return $this->codeProcessor;
	}

	//put ticket for create
	public function Create() {
	}

	protected function GetActiveTicketId() {
		$app = $this->Slim();
		$dbConn = $this->DbConn();
		$sellerId = $this->SellerCode()->Id();

		//active = 1
		$sql = "SELECT `id` FROM `shopTicket` WHERE `sellerid` = '$sellerId' AND `status`= 1";
		$query = mysqli_query($dbConn, $sql);
		if($query === false) {
			$app->halt(500, "Ticket.php: ".mysqli_error($dbConn)." sql=$sql");
		}

		if($query->num_rows === 0) return null;
		if($query->num_rows > 1) {
			$app->halt(500, "There are more than one active ticket");
		}

		$resAr = mysqli_fetch_assoc($query);
		return $resAr['id'];
	}

	//get price for good with id $id
	public function GetGoodInfo($goodId) {
		$dbConn = $this->DbConn();
		$app = $this->Slim();
		$goodId = (int)$goodId;

		$sql = "SELECT * FROM `shopGoods` WHERE `id` = '$goodId'";
		$query = mysqli_query($dbConn, $sql);
		if($query === false) {
			$app->halt(500, "Ticket.php-\>getGoodPrice ".mysqli_error($dbConn)." sql = $sql");
		}

		if($query->num_rows === 0) {
			$app->halt(404, "There do not exist a good with id='$goodId'");
		}

		if($query->num_rows > 1) {
			$app->halt(500, "There exist more than one good with such id");
		}

		$queryResult = mysqli_fetch_assoc($query);
		return array( 'price' => (float)$queryResult['sellCost'],
					'name' => $queryResult['name1']
				);
	}

	protected function UpdateTicketClientCode($ticketCode) {
		$codeProcessor = $this->CodeProcessor();
		$dbConn = $this->DbConn();
		$app = $this->Slim();
		$clientCode = $this->ClientCode();
		$clientId = $clientCode->Id();

		/* verify client id */
		$sql = "SELECT `id` FROM `shopClient` WHERE `id`=$clientId";
		$query = mysqli_query($dbConn, $sql);
		if($query === false) {
			$app->halt(500, "Ticket.php-\>UpdateTicketClientCode ".mysqli_error($dbConn)." sql= $sql");
		}

		if(mysqli_num_rows($query) === 0) {
			$app->halt(403, "The client id is wrong".$sql);
		}

		$res = mysqli_fetch_assoc($query);
		$discontId = $res['discontId'];

		$disconter = new Discont($dbConn);
		$disconter->compute($clientId, $ticketCode, $app);

		
		/* update info about clientId in ticket */
		$sql = "UPDATE `shopTicket` SET `clientId`=$clientId WHERE `id`=$ticketCode ";
		$query = mysqli_query($dbConn, $sql);
		if($query === false) {
			$app->halt(500, "Ticket.php-\>UpdateTicketClientCode ".mysqli_error($dbConn)." sql= $sql");
		}

		//final accord
		$result = array(
			'ticketCode'=>$ticketCode,
			'clientCode'=>$codeProcessor->GetCodeStr($clientCode),
		);

		//final accord
		return json_encode($result);
	}

	protected function UpdateTicket($ticketCode) {
		$codeProcessor = $this->CodeProcessor();
		$dbConn = $this->DbConn();
		$app = $this->Slim();
		$assistCode = $this->AssistCode();
		$assistId = is_null($assistCode) ? '': $assistCode->Id();
		$goodCode = $this->GoodCode();
		$comment = $this->Comment();

		//Calculate the summ for our goods
		$goodInfo = $this->GetGoodInfo($goodCode->Id());
		$priceGood = $goodInfo['price'];
		$nameGood = $goodInfo['name'];
		$count = $goodCode->Role() === "weight" ? $goodCode->Weight() : $this->Count();
		$summ = $count * $priceGood;

		if(!is_null($assistCode)) {
			$count = -$count;
			$summ = -$summ;
		}
		$goodCodeStr = $codeProcessor->GetCodeStr($goodCode);
		$sql = "INSERT INTO `shopTicketContent`(`ticketId`, `goodId`, `weight`, `comment`, `summ`, `summDiscont`, `assistId`, `eanCode`) VALUES('$ticketCode', '".$goodCode->Id()."', $count, '$comment', $summ, $summ, '$assistId', '$goodCodeStr')";
		$query = mysqli_query($dbConn, $sql);
		if($query === false) {
			$app->halt(500, "Ticket.php-\>putTicket ".mysqli_error($dbConn)." sql= $sql");
		}

		$sqlId = mysqli_insert_id($dbConn);
		//discont computation
		//get client id
		$sql = "SELECT * FROM `shopTicket` WHERE `id`=$ticketCode";
		$query = mysqli_query($dbConn, $sql);
		if($query == false) {
			$app->halt(500, "Ticket.php-\>putTicket ".mysqli_error($dbConn)." sql= $sql");
		}

		$clientId = mysqli_fetch_assoc($query);
		$clientId = (int)$clientId['clientId'];
		if($clientId > 0){
			$disconter = new Discont($dbConn);
			$disconter->compute($clientId, $ticketCode, $app, $sqlId);
		}

		$sql = "SELECT * FROM `shopTicketContent` WHERE `id` = $sqlId";
		$query = mysqli_query($dbConn, $sql);
		if($query === false) {
			$app->halt(500, "Ticket.php-\>putTicket ".mysqli_error($dbConn)." sql= $sql");
		}
		$res = mysqli_fetch_assoc($query);
		$discont = $res['discont'];
		$summDiscont = $res['summDiscont'];

		//final accord
		$result = array(
			'ticketCode'=>$ticketCode,
			'goodCode' => $goodCodeStr,
			'weight' => $count,
			//'comment' => $comment,
			'name' => $nameGood, 
			'summ' => $summ,
			'price' => $priceGood,
			'sqlId' => $sqlId,
			'discont' => $discont,
			'summDiscont' => $summDiscont,
		);

		if(!is_null($assistCode)) {
			$result['assistId'] = $codeProcessor->GetCodeStr($assistCode);
		}

		//final accord
		return json_encode($result);
	}

	protected function CreateTicketSQL() {
		$dbConn = $this->DbConn();
		$app = $this->Slim(); $sellerId = $this->SellerCode()->Id();

		//active = 1
		$sql = "INSERT INTO `shopTicket`(`sellerId`, `status`) VALUES('".$sellerId."', 1)"; 
		$query = mysqli_query($dbConn, $sql); 
		if($query === false) { 
			mysqli_query($dbConn, "ROLLBACK"); 
			$app->halt(500, "Ticket.php-\>createTicketSQL ".mysqli_error($dbConn)." sql=$sql"); 
		} 
		
		return mysqli_insert_id($dbConn);
	}

	protected function FreezeTicket($ticketCode) {
		$dbConn = $this->DbConn();
		$app = $this->Slim();
		$ticketCode = trim($ticketCode);
		$freeze = $this->Freeze();

		//active = 1
		//freeze = 2
		$status = $freeze === true ? 2 : 1;
		$sql = "UPDATE `shopTicket` SET `status` = $status WHERE `id`='$ticketCode'";
		$query = mysqli_query($dbConn, $sql);
		if($query === false) {
			$app->halt(500, "Ticket.php-\>freezeTicket ".mysqli_error($dbConn)." sql=$sql");
		}
		return $this->GetFreezeResponse($freeze); 
	}
	
	protected function GetFreezeResponse($freeze) {
		return json_encode(array('freeze' => (string)(int)(bool)$freeze)); 
	}


	protected function GetTicketInfo($ticketCode) {
		if(is_null($ticketCode)) return null;
		$app = $this->Slim();
		$dbConn = $this->DbConn();

		$sql = "SELECT * FROM `shopTicket` WHERE `id` = $ticketCode";
		$query = mysqli_query($dbConn, $sql);
		if($query === false) {
			$app->halt(500, "Ticket.php-\>GetTicketInfo ".mysqli_error($dbConn)." sql= $sql");	
		}

		if($query->num_rows === 0) {
			$app->halt(404, "Ticket.php-\>GetTicketInfo there aren't any ticket with this id");
		}

		return mysqli_fetch_assoc($query);
	}

	//CRUD Opperations
	public function DeleteTicketRow($ticketCode, $sqlRowId) {
		$app = $this->Slim();
		$dbConn = $this->DbConn();
		$codeProcessor = $this->CodeProcessor();

		$ticketInfo = $this->GetTicketInfo($ticketCode);
		$ticketIsActive = is_array($ticketInfo) && $ticketInfo['status'] === '1'; //active status

		if ($ticketIsActive === false) {
			$app->halt(403, "Can't refuse the ticket. It's not active");
		}

		$assistCode= $this->AssistCode();
		if(is_null($assistCode)) {
			$app->halt(400, "Assist code is not setted");
		}
		$assistId = $assistCode->Id();

		$comment = $this->Comment();
		if($comment === "") {
			$app->halt(400, "Comment is empty");
		}

		//verify if the row $sqlId was deleted
		$sql =	"SELECT * FROM `shopTicketContent` WHERE `relateId`= $sqlRowId AND `ticketId` = $ticketCode";
		$query = mysqli_query($dbConn, $sql);
		if($query === false) {
			$app->halt(500, "Ticket.php-\>DeleteTicketRow: mysqli_error ".mysqli_error($dbConn)." sql=$sql");
			
		}

		$numRows = mysqli_num_rows($query);
		if( $numRows > 1 ) {
			$app->halt(500, "Ticket.php-\>DeleteTicketRow: There are more than one deleted rows for id=$sqlRowId");
		} 

		if( $numRows === 1) {
			//this id was deleted once
			$app->halt(409, "This row was deleted");
		}

		//$numRows === 0 and we can delete this row
		//get $sqlId row info
		$sql = "SELECT * FROM `shopTicketContent`, `shopGoods` WHERE `shopTicketContent`.`id` = $sqlRowId AND `shopTicketContent`.`ticketId` = $ticketCode AND `shopGoods`.`id` = `shopTicketContent`.`goodId`";
		$query = mysqli_query($dbConn, $sql);
		if($query === false) {
			$app->halt(500, "Ticket.php-\>DeleteTicketRow: mysqli_error ".mysqli_error($dbConn)." sql=$sql");
		}

		if(mysqli_num_rows($query) === 0) {
			$app->halt(409, "This row does not exist");
		}
		$row = mysqli_fetch_assoc($query);

		$goodId = $row['goodId'];
		$weight = -$row['weight'];
		$summ = -$row['summ'];
		$nameGood = $row['name1'];
		$priceGood = $row['sellCost'];
		$relateId = (int)$row['relateId'];
		if($relateId > 0) {
			$app->halt(409, "Can't delete a row with negative values");
		}


		$sql = "INSERT INTO `shopTicketContent` (`ticketId`, `goodId`, `weight`, `comment`, `summ`, `assistId`, `relateId`) VALUES($ticketCode, '$goodId', $weight, '$comment', $summ, $assistId, $sqlRowId)";
		$query = mysqli_query($dbConn, $sql);
		if($query === false) {
			$app->halt(500, "Ticket.php-\>DeleteTicketRow: mysqli_error ".mysqli_error($dbConn)." sql=$sql");
		}

		//the deleted row haven't code
		//because there are negative values
		$result = array(
			'ticketCode'=>$ticketCode,
			'sqlId' => mysqli_insert_id($dbConn),
		);

		//final accord
		return json_encode($result);

	}

	public function DeleteTicket($ticketCode) {
		$app = $this->Slim();
		$dbConn = $this->DbConn();

		$ticketInfo = $this->GetTicketInfo($ticketCode);
		$ticketIsActive = is_array($ticketInfo) && $ticketInfo['status'] === '1'; //active status

		if ($ticketIsActive === false) {
			$app->halt(403, "Can't refuse the ticket. It's not active");
		}

		$assistCode= $this->AssistCode();
		if(is_null($assistCode)) {
			$app->halt(400, "Assist code is not setted");
		}
		$assistId = $assistCode->Id();

		$comment = $this->Comment();
		if($comment === "") {
			$app->halt(400, "Comment is empty");
		}

		//3 - refuse status
		$sql = "UPDATE `shopTicket` SET `status` = 3, `assistId` = '$assistId', `comment` = '$comment' WHERE `id` = $ticketCode";
		$query = mysqli_query($dbConn, $sql);
		if($sql === false) {
			$app->halt(500, "Ticket.php-\>DeleteTicket ".mysqli_error($dbConn)." sql = $sql");
		}

		return json_encode(array('ticketCode' => $ticketCode));
	}

	public function PostTicket() {
		$app = $this->Slim();
		$dbConn = $this->DbConn();
		$sellerId = $this->SellerCode()->Id();
		$codeProcessor = $this->CodeProcessor();

		//Are there active tickets

		$activeTicketId = $this->GetActiveTicketId(); 
		if(!is_null($activeTicketId)) {
			$app->halt(403, "There exist an active ticket. Can't create a new one.");
		}

		$ticketCode = $this->CreateTicketSQL(); 

		return json_encode(array(
			'ticketCode' => $ticketCode,
		));


	}

	public function GetTicket($ticketCode) {
		$ticketInfo = $this->GetTicketInfo($ticketCode);
		$ticketIsActive = is_array($ticketInfo) && $ticketInfo['status'] === '1'; //'active' status
		$dbConn = $this->DbConn();
		$app = $this->Slim();

		if($ticketIsActive === true) {
			$sql = "SELECT `shopTicketContent`.*, `shopGoods`.`name1` AS `name`, `shopGoods`.`sellcost` AS `price` FROM `shopTicketContent`, `shopGoods` WHERE `ticketId` = $ticketCode AND `shopGoods`.`id` = `shopTicketContent`.`goodId`";
			$query = mysqli_query($dbConn, $sql);
			if($sql === false) {
				$app->halt(500, "Ticket.php-\>GetTicket ".mysqli_error($dbConn)." sql = $sql");
			}

			$res = array();
			while($ar = mysqli_fetch_assoc($query)) {
				$res[] = array(
					'ticketCode'=>$ticketCode,
					'goodCode' => $ar['eanCode'],
					'weight' => $ar["weight"],
					//'comment' => $comment,
					'name' => $ar['name'], 
					'summ' => $ar['summ'],
					'price' => $ar['price'],
					'sqlId' => $ar['id'],
					'discont' => $ar['discont'],
					'summDiscont' => $ar['summDiscont'],
				);
			}

			return json_encode($res);
		}

		$app->halt(400, "Something wrog with this ticket");
	}

	public function PutTicket($ticketCode = null) {
		$ticketInfo = $this->GetTicketInfo($ticketCode);
		$ticketIsActive = is_array($ticketInfo) && $ticketInfo['status'] === '1'; //'active' status
		$ticketIsFreezed = is_array($ticketInfo) && $ticketInfo['status'] === '2'; //freeze' status


		$freeze = $this->Freeze();
		$goodCode = $this->GoodCode();
		$count = $this->Count();
		$app = $this->Slim();

		//if is freeze Mode
		//must I freeze the ticket
		$isFreezeMode = !is_null($freeze);
		$canFreezeTicket = $ticketIsActive && ($freeze === true);
		$canActivateTicket = $ticketIsFreezed && ($freeze === false);

		if($isFreezeMode){
			if ($canFreezeTicket || $canActivateTicket){
				return $this->FreezeTicket($ticketCode);
			} 
		
			if($ticketIsActive && $freeze === false) {
				return $this->GetFreezeResponse($freeze); 
			}

			if($ticketIsFreezed && $freeze === true) {
				return $this->GetFreezeResponse($freeze);
			}

			$app->halt(400, "Something wrong in your request");
		}

		/* pay mode */
		/* set paid status for this ticket */
		/* are there `paid` word in post data */
		if($this->IsForPaid()) {
			$activeTicketId = $this->GetActiveTicketId(); 
			if(is_null($ticketCode)) {
				$app->halt(403, "The ticket is not created!");
			} else if ($ticketIsActive === false) {
				$app->halt(403, "Can't update the ticket. Ticket is not active");
			}

			return $this->PayTicket($ticketCode);
		}

		/* is there update mode */
		/* is added information about goods */
		$updateGoodComponents = !is_null($count) && !is_null($goodCode);
		$updateClientCode = !is_null($this->ClientCode());

		$isUpdateMode = $updateGoodComponents || $updateClientCode;

		if($isUpdateMode) {
			//Must we create a new ticket

			if(is_null($ticketCode)) {
				//we must create a new ticket
				$activeTicketId = $this->GetActiveTicketId(); 
				if(!is_null($activeTicketId)) {
					$app->halt(403, "There exist an active ticket. Can't create a new one.");
				}

				$ticketCode = $this->CreateTicketSQL(); 
			} else if ($ticketIsActive === false) {
				$app->halt(403, "Can't update the ticket. Ticket is not active");
			}

			if($updateGoodComponents) {
				return $this->UpdateTicket($ticketCode);
			} else if($updateClientCode) {
				return $this->UpdateTicketClientCode($ticketCode);
			}
		}

		$app->halt(400, "The post data is incorrect");
	}

	function PayTicket($ticketCode) {
		$app = $this->Slim();
		$dbConn = $this->DbConn();
		$postData = json_decode($app->request->getBody(), true);
		$paymentType = trim($postData['paymentType']);

		if(!in_array($paymentType, array('0', '1'))) {
			$app->halt(400, "payment type must be equal with '0' or '1'");
		}

		//if client want to pay in credit
		//verify that client can do the operation
		if($paymentType == '1') {
			$sql = "SELECT * FROM `shopClient` WHERE `id` = (SELECT `clientId` FROM `shopTicket` WHERE `id`=$ticketCode)";
			$query = mysqli_query($dbConn, $sql); 
			if($query === false) {
				$app->halt(500, "Ticket.php-\>PayTicket ".mysqli_error($dbConn)." sql=$sql");
			}

			if(mysqli_num_rows($query) != 1) {
				$app->halt(500, "Ticket.php-\>PayTicket something wrong with your programm");
			}

			$res = mysqli_fetch_assoc($query);
			if( trim($res['canBarrow']) == '0' ) {
				$app->halt(404, "The client can't pay in credit.");
			}
		}

		
		$sql = "UPDATE `shopTicket` SET `paymentType` = '$paymentType', `status` = 4, `discont` = 0, `suma`=(SELECT SUM(`summ`) FROM `shopTicketContent` WHERE `ticketId` = $ticketCode) WHERE `id`='$ticketCode'";
		$query = mysqli_query($dbConn, $sql);
		if($query === false) {
			$app->halt(500, "Ticket.php-\>PayTicket ".mysqli_error($dbConn)." sql=$sql");
		}

		return json_encode(array('paid'=>'1'));
	}

	//end of class
}


	function createTicket($sellerCode, $desktopCode) {
		global $codeProcessor;
		global $app;

		$sellerCode = $codeProcessor->GetCodeObj($sellerCode);
		$sellerId = $sellerCode->Id();
		$activeTicketId = getActiveTicketId($sellerId); 

		if($activeTicketId !== null) {
			$app->halt(403, "There just exist an open ticket. You must freeze it or pay");
		}

		echo json_encode(array('id'=>createTicketSQL($sellerId)));
		return true;
	}


?>
