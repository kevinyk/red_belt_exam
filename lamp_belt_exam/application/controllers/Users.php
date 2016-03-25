<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function index()
	{
		redirect('main');
	}
	public function login_index()
	{
		$this->load->view('login_view');
	}
	public function friends_index()
	{
		$this->load->model('User');
		$currentUserID = $this->session->userdata['currentUser']['id'];
		$currentUsers['friends'] = $this->User->getAllFriends($currentUserID);
		if ($currentUsers['friends'])
		{
			$currentUsers['lonercheck'] = null;
		}
		else
		{
			$currentUsers['lonercheck'] = "You don't have friends yet.";
		}
		$currentUsers['nonfriends'] = $this->User->getAllNonFriends($currentUserID);
		$this->load->view('friends_view', $currentUsers);
	}
	public function profile_index($userID)
	{
		$this->load->model('User');
		$currentProfile = $this->User->getUserInfo($userID);
		$this->load->view('profile_view', $currentProfile);
	}
	public function process_register()
	{
		$this->load->library("form_validation");
		$this->form_validation->set_rules("name", "Name", "trim|required");
		$this->form_validation->set_rules("alias", "Alias", "trim|required");
		$this->form_validation->set_rules("email", "Email", "trim|required|valid_email");
		$this->form_validation->set_rules("password", "Password", 'trim|required|matches[passwordconf]|md5');
		$this->form_validation->set_rules("passwordconf", "Password Confirmation", 'trim|required');
		// $this->form_validation->set_rules('dob', 'Date of birth', 'regex_match[(0[1-9]|1[0-9]|2[0-9]|3(0|1))-(0[1-9]|1[0-2])-\d{4}]');
		$this->form_validation->set_rules('dob', 'Date of birth', 'required');
			if($this->form_validation->run() === FALSE)
				{
				     $this->view_data["errors"] = validation_errors();
				     $this->session->set_userdata('regError', $this->view_data["errors"]);
				     // $this->session->set_userdata('regError', validation_errors());
				     redirect('/main');
				}
			else
				{
					 $newUser = $this->input->post();
					 $this->load->model('User');
					 // var_dump($newUser);
				  //    die();
					 $this->session->unset_userdata('regError');
					 $this->session->unset_userdata('loginError');
					 $add_newUser = $this->User->addUser($newUser);
				     // $this->load->view('registration_success');
				     $currentUser = $this->User->loginUser($newUser);
					 $this->session->set_userdata('currentUser', $currentUser);
					 redirect('/friends');
				}
	}
	public function process_login()
	{
		$this->load->library("form_validation");
		$this->form_validation->set_rules("email", "Email", "trim|required|valid_email");
		$this->form_validation->set_rules("password", "Password", 'trim|required|md5');
			if($this->form_validation->run() === FALSE)
				{
				     $this->view_data["errors"] = validation_errors();
				     $this->session->set_userdata('loginError', $this->view_data["errors"]);
				     // $this->session->set_userdata('regError', validation_errors());
				     redirect('/main');
				}
			else
				{
					 $newUser['email'] = $this->input->post('email');
					 $newUser['password'] = $this->input->post('password');
					 $this->load->model('User');
					 $currentUser = $this->User->loginUser($newUser);
					 $this->session->set_userdata('currentUser', $currentUser);
					 $this->session->unset_userdata('loginError');
					 $this->session->unset_userdata('regError');
				     redirect('/friends');
				}
	}
	public function deleteUser($userID)
	{
		$this->load->model('User');
		$this->User->deleteUser($userID);
	}
	public function addFriend($friendID)
	{
		$this->load->model('User');
		$this->User->insertFriend($friendID);
		redirect('/friends');
	}
	public function deleteFriendship($friendID)
	{
		$this->load->model('User');
		$userID = $this->session->userdata['currentUser']['id'];
		$this->User->deleteFriend($userID,$friendID);
		redirect('/friends');
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('/main');
	}
}