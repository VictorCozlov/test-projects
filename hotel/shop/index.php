<?php
    require 'Slim/Slim.php';
    //require 'HttpBasicAuth.php';
    require('mod/Session.php');
	require('mod/CodeProcessor.php');
	require('mod/Ticket.php');
	require('mod/Client.php');
	require('mod/Good.php');
	require('mod/Discont.php');

    \Slim\Slim::registerAutoloader();

    /*start parameters initialization*/
    $app = new \Slim\Slim();

    /*middleware*/
    $dbConn = getDbConnection();
	$codeProcessor = new CodeProcessor($dbConn, $app);
    $session = new Session($dbConn, $app, $codeProcessor);

	$app->add($session);

	//testZone
	$app->get('/test/:a/:b', 'test');

	//ticket zone
	$app->get('/ticket/:ticketCode/:sellerCode/:desktopCode', 'getTicket'); //will get ticket info
	$app->put('/ticket/:ticketCode/:sellerCode/:desktopCode', 'putTicket'); //will update ticket info
	$app->put('/ticket/:sellerCode/:desktopCode', 'putTicketCreate'); //will create a ticket
	$app->post('/ticket/:sellerCode/:desktopCode', 'postTicket'); //will create a ticket an empty ticket and return it's id

	$app->delete('/ticket/:ticketCode/:sellerCode/:desktopCode', 'deleteTicket'); //will delete ticket
	$app->delete('/ticket/:ticketCode/:sqlId/:sellerCode/:desktopCode', 'deleteTicketRow'); //will delete a row from ticket with row id equal to sqlId

	//good zone
	$app->get('/good/:goodCode/:sellerCode/:desktopCode', 'getGood'); //will get info about goodCode 

	//client zone
	$app->get('/client/:clientCode/:sellerCode/:desktopCode', 'getClient'); //will get info about clientCode 
	$app->put('/client/:ticketCode/:clientCode/:sellerCode/:desktopCode', 'putClient'); //will update the ticket with ticketCode(if is active) with clientCode 
	//parameteres zone
    $app->get('/parameters/:region', 'getParam');

	//auth zone
    $app->get('/auth/:clientCode/:desktopCode', 'getAuth');
	$app->delete('/auth/:clientCode/:desktopCode', 'delAuth');

    
    $app->run();

	//test zone
	function test($a, $b) {
		global $codeProcessor;
		$code = $codeProcessor->GetCodeObj("2800001001017");
		echo "<br>role = ", $code->Role();
		echo "<br>prefix = ", $code->Prefix();
		echo "<br>id = ", $code->Id();
		echo "<br>weight = ", $code->Weight();

		echo "<br>transfomed back = ", $codeProcessor->GetCodeStr($code);
		return True;
	}



	//auth zone
    function delAuth($clientCode, $desktopCode){
		global $session;
		global $codeProcessor;
		global $app;

		$clientCode = $codeProcessor->GetCodeObj($clientCode);
		if($clientCode->Role() !== "seller") {
			$response = $app->response();
			$response->setStatus(400);
			$response->setBody("incorrect address");
			return true;
		}

		$sellerId = $clientCode->Id();
		$dbLink = getDbConnection();
		//verify if there are no freezed tickets or active tickets
		$sql = "SELECT * FROM `shopTicket` WHERE `sellerId`=$sellerId AND `status` not in ('3', '4')";
		$query = mysqli_query($dbLink, $sql);
		if($query === false) {
			$app->halt(500, "index.php-\>delAuth: mysqli_error ".mysqli_error($dbLink)." sql=$sql");
		}

		if(mysqli_num_rows($query) > 0 ) {
			$app->halt(403, "There just exist either  opened or freezed tickets . You can't log out");
		}

		$session->close($sellerId, $desktopCode);
		return true;
	}

    function getAuth($clientCode, $desktopCode){
		//sleep(15); ///for future
		global $app;
		global $session;
		global $codeProcessor;

        $link = getDbConnection();
		$clientCode = $codeProcessor->GetCodeObj($clientCode);
		if($clientCode->Role() !== "seller") {
			$response = $app->response();
			$response->setStatus(400);
			$response->setBody("incorrect address");
			return true;
		}

		$clientId = $clientCode->Id();
        $sql = "Select `id` From `shopUser` Where `cod` = '$clientId'";
        
        $result = mysqli_query($link, $sql);
		if($result === false){
			$app->halt(500, mysqli_error($link)."sql = '$sql' errNo = ".mysqli_errno($link));
		}

        $row = mysqli_fetch_assoc($result);
        
        $id = (int)$row['id']; 
        
        $sql = "Select * From `hotelUser` Where `id` = '$id'";
        $result = mysqli_query($link, $sql);
        if($result === false){
			$app->halt(500, mysqli_error($link)."sql = '$sql'");
        }

        $response = array();
        if($result->num_rows == 0){ 
			$app->halt(404, "There do not exist such a user"); //not found status code
        }else{
            $row = mysqli_fetch_assoc($result);
            $response['login'] = $row["login"]; 
            $response['fname'] = $row["fname"]; 
            $response['lname'] = $row["lname"]; 
            $response['position'] = $row["position"];
        }
        
		//success part of code
		$session->open($clientId, $desktopCode);
        echo json_encode($response);
    }

    function getParam($region) {
		global $app;

        $link = getDbConnection();
        $sql = "SELECT * FROM `shopParams` WHERE `region` = '$region'" ;
            
        $result = mysqli_query($link, $sql);
        if($result === false) {
				$app->halt(500, mysqli_error($link)."sql = '$sql'");
        }
        $ar = array();
		while($row = mysqli_fetch_assoc($result)) $ar[] = $row;
        
        $jsonR = array(
            'region'=>$region,
            'vars'=>$ar,
        ); 
        
        echo json_encode($jsonR);
    }
    
    
    function getDbConnection(){
        $dbhost = "localhost";
        $dbuser = "gltltd_petru";
        $dbpass = "daSMgJKmuxGmjJ";
        $dbname = "gltltd_petru";
        
        $link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die("Error" .mysqli_error($link));
            if (mysqli_connect_errno()) {
             printf("Не удалось подключиться: %s\n", mysqli_connect_error());
             }
        return $link;        
    }
?>
