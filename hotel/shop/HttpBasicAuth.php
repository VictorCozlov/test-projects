<?php
require('Slim/Middleware.php');

/*The HttpBasicAuth class logic lay on idea that therea exist a session table. If there are user headers then we can verify if the usercode has an open session, In case of an open session we assign to request a new field isAuthorized = true, else is set in false
 */

class HttpBasicAuth extends \Slim\Middleware{
	protected $usercode;
	protected $password;

	public function __construct($session) {
		$this->session = $session;
	}

	public function call() {
		$session = $this->session;
		$req = $this->app->request();
		$res = $this->app->response();

		$usercode = trim($req->headers('Usercode'));

		if(strlen($usercode) === 0) {
			$req->isAuth = false;
		} else {
			$uri = $req->getResourceUri();
			$pregArray = array();

			if(preg_match("/^\/(?<region>\w+)/", $uri, $pregArray) === 1) {
					$region = $pregArray['region'];
					$req->isAuth = $this->session->isOpen($region, $usercode);
			} else
			{
				$req->isAuth = false;
			}
		}

		$this->next->call();
	}
}
?>
