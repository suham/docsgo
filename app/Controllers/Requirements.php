<?php namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\RequirementsModel;
class Requirements extends BaseController
{
	public function index()
    {
		$data = [];
		$data['pageTitle'] = 'Requirements';
		$data['addBtn'] = True;
		$data['addUrl'] = "/requirements/add";

		// helper(['form']); 
		$data['projects'] = $this->getProjects();
		$data['requirementStatus'] = array('System' => "System", 'Subsystem' => "Subsystem", 'User Needs' => "User Needs");		
		$status = $this->request->getVar('status');
		$data['requirementSelected'] = $status;
		if($status == 'All' || $status == ''){
			$status ='';
			$data['requirementSelected'] = 'User Needs';
		}
		$model = new RequirementsModel();
		$data["data"] = $model->getRequirements($status);

		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('Requirements/list',$data);
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
		$model = new RequirementsModel();
		$data = [];
		$data['pageTitle'] = 'Requirements';
		$data['addBtn'] = False;
		$data['backUrl'] = "/requirements";
		$requirementStatus = array('System' => "System", 'Subsystem' => "Subsystem", 'User Needs' => "User Needs");

		if($id == ""){
			$data['action'] = "add";
			$data['formTitle'] = "Add Requirements";

			$rules = [
				'type' => 'required',
				'requirement' => 'required|min_length[3]|max_length[100]',
				'description' => 'required|min_length[3]|max_length[500]',
			];

		}else{
			$data['action'] = "add/".$id;
			$data['formTitle'] = "Update Requirements";

			$rules = [
				'type' => 'required',
				'requirement' => 'required|min_length[3]|max_length[100]',
				'description' => 'required|min_length[3]|max_length[500]',
			];	

			$data['member'] = $model->where('id',$id)->first();		
		}
		

		if ($this->request->getMethod() == 'post') {
			$currentTime = gmdate("Y-m-d H:i:s");
			$newData = [
				'type' => $this->request->getVar('type'),
				'requirement' => $this->request->getVar('requirement'),
				'description' => $this->request->getVar('description'),
				'update_date' => $currentTime,
			];

			$data['member'] = $newData;
			if (! $this->validate($rules)) {
				$data['validation'] = $this->validator;
			}else{

				if($id > 0){
					$newData['id'] = $id;
					$message = 'Requirements updated.';
				}else{
					$message = 'Requirements successfully added.';
				}

				$model->save($newData);
				$session = session();
				$session->setFlashdata('success', $message);
			}
		}
		$data['requirementStatus'] = array('System' => "System", 'Subsystem' => "Subsystem", 'User Needs' => "User Needs");
		$data['projects'] = $this->getProjects();
		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('Requirements/form', $data);
		echo view('templates/footer');
	}

	private function getProjects(){
        $projectModel = new ProjectModel();
        $data = $projectModel->findAll();	
		$projects = [];
		foreach($data as $project){
			$projects[$project['project-id']] = $project['name'];
		}
		return $projects;
	}


	public function delete(){
		if (session()->get('is-admin')){
			$id = $this->returnParams();
			$model = new RequirementsModel();
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