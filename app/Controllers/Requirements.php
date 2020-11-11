<?php namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\RequirementsModel;
use App\Models\SettingsModel;
use App\Models\TraceabilityMatrixModel;
use App\Models\TraceabilityOptionsModel;

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
		$data['requirementCategory'] = $this->getRequirementCategoryEnums();
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

	private function getRequirementCategoryEnums() {
		$settingsModel = new SettingsModel;
		$requirementCategory = $settingsModel->where("identifier","requirementsCategory")->first();
		if($requirementCategory["options"] != null){
			$requirementCategory = json_decode( $requirementCategory["options"], true );
		}else{
			$requirementCategory = [];
		}
		return $requirementCategory;
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
		$data['requirementCategory'] = $this->getRequirementCategoryEnums();

		if($id == ""){
			$data['action'] = "add";
			$data['formTitle'] = "Add Requirements";

			$rules = [
				'type' => 'required',
				'requirement' => 'required|min_length[3]|max_length[100]',
				'description' => 'required|min_length[3]|max_length[2100]',
			];

		}else{
			$data['action'] = "add/".$id;
			$data['formTitle'] = "Update Requirements";

			$rules = [
				'type' => 'required',
				'requirement' => 'required|min_length[3]|max_length[100]',
				'description' => 'required|min_length[3]|max_length[2100]',
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
			if ($this->request->getMethod() == 'post') {
                $id = $this->request->getVar('id');
                $type = $this->request->getVar('type');

				//If type is 'User Needs | Standards | Guidance delete all options and traceability two tables data
				if(($type == 'User Needs') || ($type == 'Standards') || ($type == 'Guidance')){
					// Track the traceability_id from options where type=$type&&requirement_id=$id
					$check1 = array('requirement_id'=> $id, 'type'=> $type);
					$model2 = new TraceabilityOptionsModel;
					$data = $model2->select('traceability_id')->where($check1)->findAll();
					if(isset($data) && count($data) > 0){
						foreach($data as $val){
							$traceabilityId = $val['traceability_id'];
							$model3 = new TraceabilityMatrixModel;
							$model3->delete($traceabilityId);
							$model2->where('traceability_id', $traceabilityId)->delete();
						}
					}
				}else{
					//Delete all options wrt of id and type
					$model2 = new TraceabilityOptionsModel;
					$check2 = array('requirement_id'=> $id, 'type'=> $type);
					$model2->where($check2)->delete();
				}
				$model1 = new RequirementsModel();
				$model1->delete($id);

				$response = array('success' => "True");
				echo json_encode( $response );
			}
		}else{
			$response = array('success' => "False");
			echo json_encode( $response );
		}
	}


}