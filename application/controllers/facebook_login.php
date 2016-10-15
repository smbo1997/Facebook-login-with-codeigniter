<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class facebooklogin extends MY_Controller {

    private $fb_user;
   
    public function __construct() {
        parent::__construct();
         $this->load->library('facebook');
         $this->fb_user = $this->facebook->getUser();
    }


    public function facebook_login() {
        $user_profile = $this->facebook->api('/me?fields=id,first_name,last_name,email');
        $this->data['user_profile'] = $user_profile;
        $facebook_id = $user_profile['id'];
		$email = $user_profile['email'];
        $firstname = $user_profile['first_name'],
        $lastname = $user_profile['last_name'],
		
		if(isset($facebook_id) && !empty($facebook_id)){ 
            $this->session->set_userdata(array('userId' => $facebook_id));
        }
        redirect('/facebooklogin/login');
    }
	
	public function login() {
       $userId = $this->session->userdata('userId');
        if (!$userId) {
            $this->data['login_url'] = $this->facebook->getLoginUrl(array(
                'redirect_uri' => site_url('/' . $this->language . '/welcome/facebook_login')
            ));
        }
        if (isset($userId) && !empty($userId)) {
            redirect('/facebooklogin/user_page');
        }
}
