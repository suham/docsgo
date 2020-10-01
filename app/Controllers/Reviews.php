<?php namespace App\Controllers;

use App\Models\ReviewModel;
use App\Models\ProjectModel;
use App\Models\TeamModel;

class Reviews extends BaseController
{
    public function index()
    {
        $data = [];
		$data['pageTitle'] = 'Reviews';
		$data['addBtn'] = True;
		$data['addUrl'] = "/reviews/add";

		$model = new ReviewModel();
		$data['data'] = $model->findAll();	
		
		$data['projects'] = $this->getProjects();
		$teamModel = new TeamModel();
		$data['teamMembers'] = $teamModel->getMembers();

		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('Reviews/list',$data);
		echo view('templates/footer');
	}

	public function projectReview()
    {
        $data = [];
		
		$data['addBtn'] = True;
		$data['addUrl'] = "/reviews/add";
		$id = $this->returnParams();
		$model = new ReviewModel();
		$data['data'] = $model->findAll();	
		$data['data'] = $model->where('project-id',$id)->findAll();	
		
		
		$data['projects'] = $this->getProjects();
		$data['pageTitle'] = $data['projects'][$id].' Reviews';
		$teamModel = new TeamModel();
		$data['teamMembers'] = $teamModel->getMembers();

		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('Reviews/list',$data);
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
		$model = new ReviewModel();
		$data = [];
		$data['pageTitle'] = 'Reviews';
		$data['addBtn'] = False;
		$data['backUrl'] = "/reviews";
		$data['projects'] = $this->getProjects();
		$teamModel = new TeamModel();
		$data['teamMembers'] = $teamModel->getMembers();
		$data['reviewStatus'] = ['Change', 'Accepted', 'Rejected'];
		
		if($id == ""){
			$data['action'] = "add";
			$data['formTitle'] = "Add Review";
		}else{
			$data['action'] = "add/".$id;
			$data['formTitle'] = "Update";
			$data['review'] = $model->where('id',$id)->first();		
		}
		
		if ($this->request->getMethod() == 'post') {
			$rules = [
				"project-id" => 'required',
				"review-name" =>'required|max_length[64]',
				"assigned-to" => 'required|max_length[50]',
				"context" => 'max_length[200]',
				"description" => 'max_length[400]',
				"review-by" =>'required|max_length[50]',
				"review-ref" => 'max_length[250]',
				"status" => 'required'
			];

			$newData = [
				"assigned-to" => $this->request->getVar('assigned-to'),
				"context" => $this->request->getVar('context'),
				"description" => $this->request->getVar('description'),
				"project-id" => $this->request->getVar('project-id'),
				"review-by" =>$this->request->getVar('review-by'),
				"review-name" =>$this->request->getVar('review-name'),
				"review-ref" => $this->request->getVar('review-ref'),
				"status" => $this->request->getVar('status')
			];

			$data['review'] = $newData;

			if (! $this->validate($rules)) {
				$data['validation'] = $this->validator;
			}else{

				if($id > 0){
					$newData['id'] = $id;
					$message = 'Review successfully updated.';
				}else{
					$message = 'Review successfully added.';
				}

				$model->save($newData);
				$session = session();
				$session->setFlashdata('success', $message);
			}
		}
		
		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('Reviews/form', $data);
		echo view('templates/footer');
	}

	public function delete(){
		if (session()->get('is-admin')){
			$id = $this->returnParams();

			$model = new ReviewModel();
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