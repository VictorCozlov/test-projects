<?php
class Discont {
	public function __construct($dbConn) {
		$this->dbConn = $dbConn;
	}

	public function compute($clientId, $ticketId, $slim, $rowId = null) {
		$dbConn = $this->dbConn;
		
		//clear all existent discont
		if( !empty($goodId)) {
			//we are working with TicketContent
			//by goodId we understna TicketContent.id
			$goodCondition = " AND `id`= $goodId ";
		}
		
		$sql = "UPDATE `shopTicketContent` SET `summDiscont`=`summ`, `discont`=0 WHERE `ticketId`=$ticketId " . $goodCondition;
		$query = mysqli_query($dbConn, $sql);
		if($query == false){
			$slim->halt(500, "Discont.php- >compute, ".mysqli_error($dbConn)." sql=$sql");
		}

		//determine the discount id
		$sql = "SELECT * FROM `shopClient` WHERE `id`=$clientId";
		$query = mysqli_query($dbConn, $sql);
		if($query == false) {
			$slim->halt(500, "Discont.php- >compute, ".mysqli_error($dbConn)." sql=$sql");
		}

		if(mysqli_num_rows($query) == 0) {
			$slim->halt(500, "Discont.php- >compute, You request a client that doesn't exist");
		}


		$clientData = mysqli_fetch_assoc($query);
		$discontId = $clientData['discontId'];
		call_user_func_array(array($this, "discont$discontId"), func_get_args()); 
	}

	private function discont0($clientId, $ticketId, $slim, $rowId = null) {
		//is empty
		//correspond to anonim client
		//first step in compute is to empty all existent discont for this $ticketId and $rowId
		//in this case for discont0 remain to silently accept
	}

	private function discont1($clientId, $ticketId, $slim, $rowId = null) {
		//accumulate discount
		//the discont is given in dependence of just paid fund

		//get info about $ticketId and $rowId
		$dbConn = $this->dbConn;

		if(!empty($rowId)) {
			$rowCondition = " AND `id`=$rowId ";
		}

		$sql = "SELECT * FROM `shopTicketContent` WHERE `ticketId`=$ticketId " . $rowCondition;
		$ticketContent = mysqli_query($dbConn, $sql);
		if($ticketContent == false) {
			$slim->halt(500,  "Discont.php- >discont1, You request a client that doesn't exist".mysqli_error($dbConn)." sql=$sql");
		}

		if(mysqli_num_rows($ticketContent) === 0) {
			//there are no actions then ticket is empty
			return;
		}

		//get accumulated sum of clientId
		$sql = "SELECT sum(`suma` - `discont`) AS `summ` FROM `shopTicket` WHERE `clientId` = $clientId";

		$query = mysqli_query($dbConn, $sql);
		if($query == false) {
			$slim->halt(500,  "Discont.php- >discont1, mysqli error ".mysqli_error($dbConn)." sql=$sql");
		}

		if(mysqli_num_rows($query) == 0) {
			$slim->halt(500,  "Discont.php- >discont1, You request a client that doesn't exist");
		}

		$summAcc = mysqli_fetch_assoc($query);
		$summAcc = (float)$summAcc['summ'];

		//get the ratio from summAcc
		$ratio = 0;

		if($summAcc > 500) {
			$ratio = 0.1; //10 percent
		}

		while($row = mysqli_fetch_assoc($ticketContent)) {
			$discont = (float)$row['discont'];
			$summDiscont = (float)$row['summDiscont'];
			$summ = (float)$row['summ'];
			$id = $row['id'];

			$addedDiscont = $ratio * $summ;
			$discont = $discont + $addedDiscont;
			$summDiscont = $summ - $discont;

			$sql = "UPDATE `shopTicketContent` SET `discont`=$discont, `summDiscont`=$summDiscont WHERE `id`=$id";
			$query = mysqli_query($dbConn, $sql);
			if($query == false) {
				$slim->halt(500,  "Discont.php- >discont1, You request a client that doesn't exist".mysqli_error($dbConn)." sql=$sql");
			}
		}
	}

	public function getParam($discontId) {
		$dbConn = $this->dbConn;
	}
}
?>
