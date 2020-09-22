<?php namespace App\Controllers;

use App\Models\TeamModel;
class Team extends BaseController
{
	public function index()
    {
		$data = [];
		$data['pageTitle'] = 'Team List';
		$data['addBtn'] = True;
		$data['addUrl'] = "/team/add";

		// helper(['form']);
		$model = new TeamModel();
		$data['data'] = $model->findAll();	
		
		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('Team/list',$data);
		echo view('templates/footer');
	}

	public function add ($id = 0){

		helper(['form']);
		$model = new TeamModel();
		$data = [];
		$data['pageTitle'] = 'Team List';
		$data['addBtn'] = False;
		$data['backUrl'] = "/team";

		if($id == 0){
			$data['action'] = "add";
			$data['formTitle'] = "Add Member";

			$rules = [
				'name' => 'required|min_length[3]|max_length[64]',
				'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[docsgo-team-master.email]',
			];

		}else{
			$data['action'] = "add/".$id;
			$data['formTitle'] = "Update";

			$rules = [
				'name' => 'required|min_length[3]|max_length[64]',
			];	

			$data['member'] = $model->where('id',$id)->first();		
		}
		

		if ($this->request->getMethod() == 'post') {

			$newData = [
				'name' => $this->request->getVar('name'),
				'email' => $this->request->getVar('email'),
				'role' => $this->request->getVar('role'),
				'responsibility' => $this->request->getVar('responsibility'),
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

	public function delete($id){
		$model = new TeamModel();
		$model->delete($id);
		$response = array('success' => "True");
		echo json_encode( $response );
	}

}