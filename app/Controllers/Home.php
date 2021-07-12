<?php

namespace App\Controllers;

use App\Models\Users_model;

class Home extends BaseController
{
	protected function onLoad(){

	}

	public function languange(){
		$this->setLocale();
		return $this->index();
	}

	public function index($rdr = NULL)
	{
		$this->getLocale();
		$rdr = ($rdr==NULL?$this->request->getGetPost("redirect"):$rdr);
		if($rdr!=NULL){
			return redirect()->to("/".base64_decode($rdr));
		}

		if(session()->has("keepalive")){
			if (session("keepalive")==1) {
				if (session()->has("username") && session()->has("password")) {
					if (session("username") != NULL && session("password") != NULL) {
						return $this->login_auth(session("username"), session("password"));
					}
				}
			}
		}

		return $this->login();
	}

	public function login(){
		$this->getLocale();
		return view('login', array('PageAttribute'=>$this->PageData));
	}

	public function login_auth($username = NULL, $password = NULL){
		$this->getLocale();
		if($username == NULL) $username = $this->request->getPost("username");
		if($password == NULL) $password = $this->request->getPost("password");

		$user = new Users_model();

		$account = $user->where(array('username'=>$username,'password'=>md5(trim($password))))->first();

		if ($account) {
			$sess = array(
				"username" => $account->username,
				"password" => $password,
				"nama" => $account->nama,
				"level" => $account->level,
				"keepalive" => 0,
			);
			if ($this->request->getPOST("keepalive") == 1) $sess["keepalive"] = 1;
			session()->set($sess);
			return redirect()->to("/administrator/Dashboard");
		}else{
            session()->setFlashdata('ci_flash_message', lang("Errors.errorLoginFailed", [], $this->PageData['locale']));
            session()->setFlashdata('ci_flash_message_type', 'error');
			return redirect()->to("/Home/login");
		}
	}

	public function logout(){
		$this->getLocale();
		$sess = array(
			"username",
			"password",
			"nama",
			"level",
			"keepalive",
		);
		session()->remove($sess);
		return $this->login();
	}
}
