<?php namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\IssueModel;
class Issues extends BaseController
{
		
	public function index()
    {
		$data = [];
		$data['pageTitle'] = 'Issues/Observations List';
		$data['addBtn'] = True;
		$data['addUrl'] = "/issues/add";
		$data['addUpload'] = True;
		$data['addUploadUrl'] = "/issues/upload";
		$data['sourceStatus'] = ['Ticket', 'Observation'];


		// helper(['form']);
		$data['projects'] = $this->getProjects();
		$model = new IssueModel();
		$data['data'] = $model->orderBy('issue', 'asc')->findAll();	

		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('Issues/list',$data);
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
		$model = new IssueModel();
		$data = [];
		$data['pageTitle'] = 'Issues/Observations List';
		$data['addBtn'] = False;
		$data['backUrl'] = "/issues";
		$data['issueStatus'] = ['Open', 'Close'];
		$data['sourceStatus'] = ['Ticket', 'Observation'];

		if($id == ""){
			$data['action'] = "add";
			$data['formTitle'] = "Add Issue/Observation";

			$rules = [
				'project' => 'required',
				'issue' => 'required|min_length[3]|max_length[64]',
				'description' => 'required|min_length[6]|max_length[1000]',
				'source' => 'required',
				'status' => 'required',
			];

		}else{
			$data['action'] = "add/".$id;
			$data['formTitle'] = "Update";

			$rules = [
				'project' => 'required',
				'issue' => 'required|min_length[3]|max_length[64]',
				'description' => 'required|min_length[6]|max_length[100]',
				'source' => 'required',
				'status' => 'required'
			];	

			$data['member'] = $model->where('id',$id)->first();		
		}
		

		if ($this->request->getMethod() == 'post') {
			$currentTime = gmdate("Y-m-d H:i:s");
			$newData = [
				'project_id' => $this->request->getVar('project'),
				'issue' => $this->request->getVar('issue'),
				'issue_description' => $this->request->getVar('description'),
				'update_date' => $currentTime,
				'source' => $this->request->getVar('source'),
				'status' => $this->request->getVar('status'),
				
			];

			// $format = "%Y-%m-%d %h:%i %a";
	        // $date =  date('Y-m-d h:m:s');
			// print_r ($date);

			// print_r ($newData);
			$data['member'] = $newData;
			if (! $this->validate($rules)) {
				$data['validation'] = $this->validator;
			}else{
				if($id > 0){
					$newData['id'] = $id;
					// date_default_timezone_set('Asia/Kolkata');
					// $timestamp = date("Y-m-d H:i:s");
					// $newData['update_date'] = $timestamp;
					$message = 'Issue successfully updated.';
				}else{
					$message = 'Issue successfully added.';
				}

				$model->save($newData);
				$session = session();
				$session->setFlashdata('success', $message);
			}
		}

		$data['issueStatus'] = ['Open', 'Close'];
		$data['projects'] = $this->getProjects();
		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('Issues/form', $data);
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
			$model = new IssueModel();
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