<?php namespace App\Controllers;

use App\Models\ReviewModel;
use App\Models\ProjectModel;
use App\Models\TeamModel;
use App\Models\DocumentModel;

class Reviews extends BaseController
{
    public function index()
    {
        $data = [];
		$data['pageTitle'] = 'Review Register';
		$data['addBtn'] = True;
		$data['addUrl'] = "/reviews/add";

		$model = new ReviewModel();
		$data['data'] = $model->orderBy('updated-at', 'desc')->findAll();	
		
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

	public function addDocReview(){
		if ($this->request->getMethod() == 'post') {
			$response = array();
			$currentTime = gmdate("Y-m-d H:i:s");
			$data = [
				"project-id" => $this->request->getVar('projectId'),
				"review-name" =>$this->request->getVar('reviewName'),
				"category" => $this->request->getVar('category'),
				"context" => $this->request->getVar('context'),
				"description" => $this->request->getVar('description'),
				"review-by" =>$this->request->getVar('reviewBy'),
				"assigned-to" => $this->request->getVar('assignedTo'),
				"review-ref" => $this->request->getVar('reviewRef'),
				'updated-at' => $currentTime,
				"status" => $this->request->getVar('status'),
			];

			
			$id = $this->request->getVar('id');
			$docId = $this->request->getVar('docId');
			$model = new ReviewModel();

			if($id != ""){
				$model->update($id, $data);
				$response['reviewId'] = $id;
			}else{
				$reviewId = $model->insert($data);

				$docData = [
					"review-id" => $reviewId 
				];
				$documentModel = new DocumentModel();
				$documentModel->update($docId,$docData);
				$response['reviewId'] = $reviewId;
			}

			
			$response["success"] = "True";
			$response['data'] = $data;

			echo json_encode($response);
		}
	}
	
	public function add(){
		$id = $this->returnParams();

		helper(['form']);
		$model = new ReviewModel();
		$data = [];
		$data['pageTitle'] = 'Review Register';
		$data['addBtn'] = False;
		$data['backUrl'] = "/reviews";
		$data['projects'] = $this->getProjects();
		$teamModel = new TeamModel();
		$data['teamMembers'] = $teamModel->getMembers();
		$data['reviewStatus'] = ['Request Change', 'Ready For Review', 'Accepted'];
		
		$data['categoryList'] = ["User Needs", "Plan", "Requirements", "Design",
		 "Code", "Verification", "Validation", "Release", "Risk Management", "Traceability"];

		if($id == ""){
			$data['action'] = "add";
			$data['formTitle'] = "Add";
		}else{
			$data['action'] = "add/".$id;
			
			$data['review'] = $model->where('id',$id)->first();		
			$data['formTitle'] = $data['review']['review-name'];
		}
		$currentTime = gmdate("Y-m-d H:i:s");
		if ($this->request->getMethod() == 'post') {
			$rules = [
				"project-id" => 'required',
				"review-name" =>'required|max_length[64]',
				"assigned-to" => 'required',
				"context" => 'required|max_length[60]',
				"description" => 'required',
				"review-by" =>'required',
				"review-ref" => 'max_length[500]',
				"status" => 'required',
				"category" => 'required',
			];

			$errors = [
				'description' => [
					'required' => 'Review Comment is required.',
				],
				'review-ref' => [
					'max_length' => "Author's should not exceed 500 characters",
				]
			];

			$newData = [
				"assigned-to" => $this->request->getVar('assigned-to'),
				"context" => $this->request->getVar('context'),
				"description" => $this->request->getVar('description'),
				"project-id" => $this->request->getVar('project-id'),
				"review-by" =>$this->request->getVar('review-by'),
				"review-name" =>$this->request->getVar('review-name'),
				"review-ref" => $this->request->getVar('review-ref'),
				"status" => $this->request->getVar('status'),
				'updated-at' => $currentTime,
				"category" => $this->request->getVar('category')
			];

			$data['review'] = $newData;

			if (! $this->validate($rules, $errors)) {
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