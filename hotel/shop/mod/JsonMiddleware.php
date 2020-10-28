<?php
class JsonMiddleware extends \Slim\Middleware{
	public function call(){
		$req = $this->app->request();
		echo $req->getContentType();

		$this->next->call();
	}
}
?>
