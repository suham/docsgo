<?php namespace App\Controllers;

use App\Models\TeamModel;
class Team extends BaseController
{
	public function index()
    {
		$data = [];
		$data['pageTitle'] = 'Team';
		$data['addBtn'] = True;
		$data['addUrl'] = "/team/add";

		// helper(['form']);
		$model = new TeamModel();
		$data['data'] = $model->orderBy('is-manager', 'desc')->orderBy('name', 'asc')->findAll();	
		
		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('Team/list',$data);
		echo view('templates/footer');
	}

	private function returnParams(){
		$uri = $this->request->uri;
		$id = $uri->getSegment(3);
		if($id != ""){
			$id = intval($id);
		}
		return $id;
	}

	public function add(){

		$id = $this->returnParams();

		helper(['form']);
		$model = new TeamModel();
		$data = [];
		$data['pageTitle'] = 'Team';
		$data['addBtn'] = False;
		$data['backUrl'] = "/team";

		if($id == ""){
			$data['action'] = "add";
			$data['formTitle'] = "Add Member";

			$rules = [
				'name' => 'required|min_length[3]|max_length[64]',
				'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[docsgo-team-master.email]',
			];

		}else{
			$data['action'] = "add/".$id;
			$data['formTitle'] = "Update Member";

			$rules = [
				'name' => 'required|min_length[3]|max_length[64]',
			];	

			$data['member'] = $model->where('id',$id)->first();		
		}
		

		if ($this->request->getMethod() == 'post') {
			$is_manager_text = $this->request->getVar('is-manager');
			$is_manager = 0;
			if($is_manager_text == 'on'){
				$is_manager = 1;
			}
			$newData = [
				'name' => $this->request->getVar('name'),
				'email' => $this->request->getVar('email'),
				'role' => $this->request->getVar('role'),
				'responsibility' => $this->request->getVar('responsibility'),
				'is-manager' => $is_manager,
			];

			$data['member'] = $newData;

			if (! $this->validate($rules)) {
				$data['validation'] = $this->validator;
			}else{

				if($id > 0){
					$newData['id'] = $id;
					$message = 'Team member successfully updated.';
				}else{
					$message = 'Team member successfully added.';
				}

				$model->save($newData);
				$session = session();
				$session->setFlashdata('success', $message);
			}
		}
		
		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('Team/form', $data);
		echo view('templates/footer');
	}

	public function delete(){
		if (session()->get('is-admin')){
			$id = $this->returnParams();
			$model = new TeamModel();
			$model->delete($id);
			$response = array('success' => "True");
			echo json_encode( $response );
		}
		else{
			$response = array('success' => "False");
			echo json_encode( $response );
		}
	}

}