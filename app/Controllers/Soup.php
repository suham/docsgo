<?php namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\SoupModel;
use App\Models\RiskAssessmentModel;
class Soup extends BaseController
{
	public function index()
    {
		$data = [];
		$data['pageTitle'] = 'Software Of Unknown Provenance (SOUP)';
		$data['addBtn'] = True;
		$data['addUrl'] = "/soup/add";

		// helper(['form']);
		$data['projects'] = $this->getProjects();
		$model = new SoupModel();
		$data['data'] = $model->orderBy('soup', 'asc')->findAll();	
		

		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('Soup/list',$data);
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
		$model = new SoupModel();
		$data = [];
		$data['pageTitle'] = 'Software Of Unknown Provenance (SOUP)';
		$data['addBtn'] = False;
		$data['backUrl'] = "/soup";
		$data['soupStatus'] = ['Open', 'Close'];

		if($id == ""){
			$data['action'] = "add";
			$data['formTitle'] = "Add SOUP";

			$rules = [
				'project' => 'required',
				'soup' => 'required|min_length[3]|max_length[64]',
				'version' => 'required|min_length[3]|max_length[64]',
				'purpose' => 'required',
				'validation' => 'required',
				'status' => 'required',
			];

		}else{
			$data['action'] = "add/".$id;
			$data['formTitle'] = "Update SOUP";

			$rules = [
				'project' => 'required',
				'soup' => 'required|min_length[3]|max_length[64]',
				'version' => 'required|min_length[3]|max_length[64]',
				'purpose' => 'required|min_length[3]|max_length[1000]',
				'validation' => 'required|min_length[3]|max_length[1000]',
				'status' => 'required',
			];	

			$data['member'] = $model->where('id',$id)->first();		
		}
		

		if ($this->request->getMethod() == 'post') {
			$currentTime = gmdate("Y-m-d H:i:s");
			$newData = [
				'project_id' => $this->request->getVar('project'),
				'soup' => $this->request->getVar('soup'),
				'version' => $this->request->getVar('version'),
				'purpose' => $this->request->getVar('purpose'),
				'validation' => $this->request->getVar('validation'),
				'status' => $this->request->getVar('status'),
				'update_date' => $currentTime,
			];

			$data['member'] = $newData;
			if (! $this->validate($rules)) {
				$data['validation'] = $this->validator;
			}else{

				if($id > 0){
					$newData['id'] = $id;
					// date_default_timezone_set('Asia/Kolkata');
					// $timestamp = date("Y-m-d H:i:s");
					// $newData['update_date'] = $timestamp;
					$message = 'Soup successfully updated.';
				}else{
					$message = 'Soup successfully added.';
				}

				$model->save($newData);
				$session = session();
				$session->setFlashdata('success', $message);
			}
		}

		$data['projects'] = $this->getProjects();
		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('Soup/form', $data);
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
			$model = new SoupModel();
			$model->delete($id);
			$model = new RiskAssessmentModel();
			$model->where('soup_id', $id)->delete();
			$response = array('success' => "True");
			echo json_encode( $response );
		}
		else{
			$response = array('success' => "False");
			echo json_encode( $response );
		}
	}

}