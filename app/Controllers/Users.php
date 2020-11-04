<?php namespace App\Controllers;

// use App\Models\UserModel;
use App\Models\TeamModel;

class Users extends BaseController
{
	public function index()
	{
		$data = [];
		helper(['form']);


		if ($this->request->getMethod() == 'post') {
			//let's do the validation here
			$rules = [
				'email' => 'required|min_length[6]|max_length[50]|valid_email',
				'password' => 'required|min_length[8]|max_length[255]|validateUser[email,password]',
			];

			$errors = [
				'password' => [
					'validateUser' => 'Email or Password don\'t match'
				]
			];

			if (! $this->validate($rules, $errors)) {
				$data['validation'] = $this->validator;
			}else{
				$model = new TeamModel();

				$user = $model->where('email', $this->request->getVar('email'))
											->first();

				$this->setUserSession($user);
				return redirect()->to('projects');

			}
		}

		echo view('templates/header', $data);
		echo view('login');
		echo view('templates/footer');
	}

	private function setUserSession($user){
		$data = [
			'id' => $user['id'],
			'name' => $user['name'],
			'email' => $user['email'],
			'is-admin' => $user['is-admin'],
			'is-manager' => $user['is-manager'],
			'isLoggedIn' => true,
		];

		session()->set($data);
		return true;
	}

	// public function register(){
	// 	$data = [];
	// 	helper(['form']);

	// 	if ($this->request->getMethod() == 'post') {
	// 		//let's do the validation here
	// 		$rules = [
	// 			'name' => 'required|min_length[3]|max_length[50]',
	// 			'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[docsgo-users.email]',
	// 			'password' => 'required|min_length[8]|max_length[255]',
	// 			'password_confirm' => 'matches[password]',
	// 			'pass_code' => 'required|max_length[255]|validatePassCode[pass_code]',
	// 		];

	// 		$errors = [
	// 			'pass_code' => [
	// 				'validatePassCode' => 'Pass Code incorrect. Contact admin for a pass code.'
	// 			]
	// 		];

	// 		if (! $this->validate($rules, $errors)) {
	// 			$data['validation'] = $this->validator;
	// 		}else{
	// 			$model = new UserModel();

	// 			$newData = [
	// 				'name' => $this->request->getVar('name'),
	// 				'email' => $this->request->getVar('email'),
	// 				'password' => $this->request->getVar('password'),
	// 			];
	// 			$model->save($newData);
	// 			$session = session();
	// 			$session->setFlashdata('success', 'Successful Registration');
	// 			return redirect()->to('/');

	// 		}
	// 	}


	// 	echo view('templates/header', $data);
	// 	echo view('register');
	// 	echo view('templates/footer');
	// }

	public function profile(){
		
		$data = [];
		$data['pageTitle'] = 'My Profile';
		$data['addBtn'] = False;
		$data['backUrl'] = "/";
		helper(['form']);
		$model = new TeamModel();

		if ($this->request->getMethod() == 'post') {
			//let's do the validation here
			$rules = [
				'name' => 'required|min_length[3]|max_length[50]',
				];

			if($this->request->getPost('password') != ''){
				$rules['password'] = 'required|min_length[8]|max_length[255]';
				$rules['password_confirm'] = 'matches[password]';
			}


			if (! $this->validate($rules)) {
				$data['validation'] = $this->validator;
			}else{

				$newData = [
					'id' => session()->get('id'),
					'name' => $this->request->getPost('name'),
					];
					if($this->request->getPost('password') != ''){
						$newData['password'] = $this->request->getPost('password');
					}
				$model->save($newData);

				session()->setFlashdata('success', 'Successfuly Updated');
				return redirect()->to('/profile');

			}
		}

		$data['user'] = $model->where('id', session()->get('id'))->first();
		echo view('templates/header', $data);
		echo view('templates/pageTitle', $data);
		echo view('profile');
		echo view('templates/footer');
	}

	// public function viewUsers(){
	// 	$data = [];
	// 	$data['addBtn'] = False;
	// 	$data['backUrl'] = "/";
	// 	if (session()->get('is-admin')){
			
	// 		$data['pageTitle'] = 'Users';
	
	// 		$model = new UserModel();
	// 		$users = $model->getUsers();
			
	// 		$data['data'] = $users;
	// 		echo view('templates/header', $data);
	// 		echo view('templates/pageTitle', $data);
	// 		echo view('Admin/Users/list', $data);
	// 		echo view('templates/footer');
	// 	}else{
			
	// 		$data['pageTitle'] = 'You are not authorized to view this page.';
	// 		echo view('templates/header', $data);
	// 		echo view('templates/pageTitle', $data);
	// 		echo view('templates/footer');
	// 	}
		
	// }

	public function updateAdminStatus(){
		$response = array();
		if ($this->request->getMethod() == 'post') {
			$id = $this->request->getPost('id');
			$model = new TeamModel();
			$user = $model->find($id);
			// $user['is-admin'] = !$user['is-admin'];
			$model->updateAdminStatus($id, !$user['is-admin']);
			$response['success'] = 'true';
			echo json_encode($response);
	
		}else{
			$response['success'] = 'false';
		}
		
	}

	public function logout(){
		session()->destroy();
		return redirect()->to('/');
	}

	//--------------------------------------------------------------------

}
