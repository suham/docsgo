<?php namespace App\Controllers;

use App\Models\ReviewModel;
use App\Models\ProjectModel;
use App\Models\TeamModel;
use App\Models\DocumentModel;
use App\Models\SettingsModel;

class Reviews extends BaseController
{
    public function index()
    {
        $data = [];
		$data['pageTitle'] = 'Review Register';
		$data['addBtn'] = True;
		$data['addUrl'] = "/reviews/add";

		$selectedStatus = null;
		$selectedProject = null;

		if(isset($_SESSION['PREV_URL'])){
			$prev_url = $_SESSION['PREV_URL'];
			if($prev_url["name"] == "reviewsList"){
				$vars = $prev_url["vars"];
				$selectedStatus = $vars['view'];
				$selectedProject = $vars['project_id'];
			}
		}

		$teamModel = new TeamModel();
		$data['teamMembers'] = $teamModel->getMembers();

		$settingsModel = new SettingsModel();		
		$documentStatusOptions =  $settingsModel->getConfig("documentStatus");
		$data["reviewStatus"] = $documentStatusOptions; //Status Radio Buttons

		if($selectedStatus == null){
			if($documentStatusOptions != null){
				$selectedStatus = $documentStatusOptions[0]; //Default status
			}else{
				$selectedStatus = null;
			}
		}
		
		$projectModel = new ProjectModel();
		$data['projects'] = $projectModel->getProjects(); //Projects Dropdown
		
		if($selectedProject == null){
			$selectedProject = $this->getActiveProjectId(); //Default project
		}

		$reviewModel = new ReviewModel();
		$data['reviewsCount'] = $reviewModel->getReviewsCount($selectedProject);

		$data['selectedProject'] = $selectedProject;
		$data['selectedStatus'] = $selectedStatus;

		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('Reviews/list',$data);
		echo view('templates/footer');
	}

	public function getReviewStats(){
		$project_id = $this->request->getVar('project_id');

		$reviewModel = new ReviewModel();
		$reviewStats = $reviewModel->getReviewsCount($project_id);
		$response["success"] = "True";
        $response["reviewStats"] = $reviewStats;
        
        echo json_encode($response);
	}

	private function getActiveProjectId(){

		$projectModel = new ProjectModel();
		$activeProject = $projectModel->where("status","Active")->first();	
		
		if($activeProject != ""){
			return $activeProject['project-id'];
		}else{
			$activeProject = $projectModel->first();	
			if($activeProject != ""){
				return $activeProject['project-id'];
			}else{
				return null;
			}
		}
	}

	public function getReviews(){
		$view = $this->request->getVar('view');
		$project_id = $this->request->getVar('project_id');

		$vars['view'] = $view;
		$vars['project_id'] = $project_id;

		helper('Helpers\utils');
		setPrevUrl('reviewsList', $vars);
		
		$model = new ReviewModel();
		$whereCondition = ' WHERE rev.`status` = "'.$view.'" and proj.`project-id` = '.$project_id;

		$data = $model->getMappedRecords($whereCondition);
		
		$response["success"] = "True";
        $response["reviews"] = $data;
        
        echo json_encode($response);
		
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
			$status = $this->request->getVar('status');
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
				"status" => $status,
			];

			
			$reviewId = $this->request->getVar('id');
			$docId = $this->request->getVar('docId');
			$model = new ReviewModel();

			//Updating Review
			if($reviewId != ""){
				$model->update($reviewId, $data);
			}else{
				$reviewId = $model->insert($data);
			}

			$documentModel = new DocumentModel();

			// Updating Document Revision
			$doc = $documentModel->where('id',$docId)->first();
			$revision["dateTime"] = $currentTime;
			$revision["who"] = session()->get("name");
			$revision["type"] = "Reviewed";
			$revision["log"] = "Review comments added.";
			if($doc['status'] != $status){
				$revision["log"] .= " Document status updated to ".$status;
			}
			$revisionHistory = $doc["revision-history"];
			if($revisionHistory != null){
				$revisionHistory = json_decode($revisionHistory, true);
			}else{
				$revisionHistory["revision-history"] = array();
			}
			array_push($revisionHistory["revision-history"], $revision);

			//Adding review id to the document
			$docData = [
				"review-id" => $reviewId,
				"status" => $status,
				'update-date' => $currentTime,
				'revision-history' => json_encode($revisionHistory)
			];
			
			$documentModel->update($docId,$docData);

			$response["success"] = "True";
			$response['reviewId'] = $reviewId;
			$response["revisionHistory"] = json_encode($revisionHistory);
			$response['status'] = $status;
			
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

		$projectModel = new ProjectModel();
		$data['projects'] = $projectModel->getProjects();

		$teamModel = new TeamModel();
		$data['teamMembers'] = $teamModel->getMembers();
		// $data['reviewStatus'] = ['Request Change', 'Ready For Review', 'Accepted'];
		$settingsModel = new SettingsModel();
		$reviewStatus = $settingsModel->where("identifier","documentStatus")->first();
		if($reviewStatus["options"] != null){
			$data["reviewStatus"] = json_decode( $reviewStatus["options"], true );
		 }else{
			$data["reviewStatus"] = [];
		 }

		$reviewCategory = $settingsModel->where("identifier","reviewCategory")->first();
		if($reviewCategory["options"] != null){
			$data["reviewCategory"] = json_decode( $reviewCategory["options"], true );
		}else{
		$data["reviewCategory"] = [];
		}

		// $data['categoryList'] = ["User Needs", "Plan", "Requirements", "Design",
		//  "Code", "Verification", "Validation", "Release", "Risk Management", "Traceability"];

		if($id == ""){
			$data['formTitle'] = "Add Review";
			//Add new form, auto fill the project,Name,Author fields
			$project_id =  $this->request->getVar('project_id');
			if($project_id == "null"){
				$session = session();
				$session->setFlashdata('alert', "danger");
				$session->setFlashdata('message', "Create a project first!");
				return redirect()->to('/reviews');
			}
			$data['project_id'] = $project_id;
			$data['project_name'] = $data['projects'][$project_id];
			$data['action'] = "add?project_id=${project_id}";
			$TeamModel = new TeamModel();
			$data['user'] = $TeamModel->where('id', session()->get('id'))->first();
			$data['review']['assigned-to'] = $data['user']['id'];			
		}else{
			
			$data['action'] = "add/".$id;
			
			$data['review'] = $model->where('id',$id)->first();		
			$data['formTitle'] = 'R-'.$data['review']['id']." ".$data['review']['context'];
			//Update form, auto fill the project field
			$project_id = $data['review']['project-id'];
			$data['project_id'] = $project_id;
			$data['project_name'] = $data['projects'][$project_id];		

			$data['nearByReviews'] = $this->getNearByReviews($data['review']['updated-at']);
			
		}
		$currentTime = gmdate("Y-m-d H:i:s");
		if ($this->request->getMethod() == 'post') {
			$rules = [
				"project-id" => 'required',
				"review-name" =>'required|max_length[64]',
				"assigned-to" => 'required',
				"context" => 'required|max_length[60]',
				"review-by" =>'required',
				"status" => 'required',
				"category" => 'required',
			];

			$errors = [
				'review-by' => [
					'required' => 'Select a reviewer',
				]
			];

			$newData = [
				"assigned-to" => $this->request->getVar('assigned-to'),
				"context" => $this->request->getVar('context'),
				"description" => $this->request->getVar('description'),
				"code-diff" => $this->request->getVar('code-diff'),
				"project-id" => $this->request->getVar('project-id'),
				"review-by" =>$this->request->getVar('review-by'),
				"review-name" =>$this->request->getVar('review-name'),
				"review-ref" => $this->request->getVar('review-ref'),
				"status" => $this->request->getVar('status'),
				'updated-at' => $currentTime,
				"category" => $this->request->getVar('category')
			];

			if (! $this->validate($rules, $errors)) {
				$data['validation'] = $this->validator;
			}else{
				$session = session();
				if($id > 0){
					$newData['id'] = $id;
					$data['review'] = $newData;
					$model->save($newData);
					$message = 'Review successfully updated.';
					$session->setFlashdata('success', $message);
				}else{
					$reviewId = $model->insert($newData);
					$message = 'Review successfully added.';
					$session->setFlashdata('success', $message);
					return redirect()->to('/reviews/add/'.$reviewId);
				}
				
			}
		}
		
		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('Reviews/form', $data);
		echo view('templates/footer');
	}

	private function getNearByReviews($id){
		$prevId = null; $nextId = null;

		if(isset($_SESSION['PREV_URL'])){
			$prev_url = $_SESSION['PREV_URL'];
			if($prev_url["name"] == "reviewsList"){
				$vars = $prev_url["vars"];
				$status = $vars['view'];
				$project_id = $vars['project_id'];
				$model = new ReviewModel();
				$prevId = $model->getPrevReviewId($id, $project_id, $status);
				$nextId = $model->getNextReviewId($id, $project_id, $status);
			}
		}
		
		$rev["prevId"] = $prevId;
		$rev["nextId"] = $nextId;

		return $rev;
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