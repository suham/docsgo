<?php namespace App\Controllers;

use App\Models\TestCasesModel;
use App\Models\TraceabilityOptionsModel;

class TestCases extends BaseController
{
	public function index()
    {
		$data = [];
		$data['pageTitle'] = 'Test';
		$data['addBtn'] = True;
		$data['addUrl'] = "/test-cases/add";
		$data['AddMoreBtn'] = true;
		$data['AddMoreBtnText'] = "Sync";

		$model = new TestCasesModel();
		
		$status = $this->request->getVar('status');
		if($status == 'sync'){
			$this->syncTestCases();
		}
		$data['data'] = $model->orderBy('testcase', 'asc')->findAll();	
		

		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('TestCases/list',$data);
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

	public function syncTestCases(){
		$model = new TestCasesModel();

		$testCases = $model->fetchTestLinkTestCases();

		if( $testCases ){
			$testCaseIdPrefix = $testCases->testCasePrefix; 
			foreach( $testCases->testCasesList as $testCase ){
				$description = "[$testCaseIdPrefix-$testCase->tc_external_id:$testCase->name] $testCase->summary";
				$whereCondition =  " WHERE testcase = '" . addslashes($testCase->name) . "'";
				$result = $model->getTestCaseRecord($whereCondition);
				if ($result) {
					// check whether the description is same or not, if not then update the description
					if ( $description != $result[0]['description'] ) {
						// update the test case description
						$updateData = [
							'id' => $result[0]['id'],
							'description' => $description,
							'update_date' => gmdate("Y-m-d H:i:s")
						];
						$model->save($updateData);
					}
				} else {
					// insert a new record
					$newData = [
						'testcase' => $testCase->name,
						'description' => $description,
						'update_date' => gmdate("Y-m-d H:i:s"),
					];
					$model->save($newData);
				}
			}
		} else {
			error_log("[DocsGo][TestCases.syncTestCases][INFO] test cases list is empty.");
			return;
		}
		
	}
	
	public function add(){

		$id = $this->returnParams();

		helper(['form']);
		$model = new TestCasesModel();
		$data = [];
		$data['pageTitle'] = 'Test';
		$data['addBtn'] = False;
		$data['backUrl'] = "/test-cases";

		if($id == ""){
			$data['action'] = "add";
			$data['formTitle'] = "Add Test";

			$rules = [
				'testcase' => 'required|min_length[3]|max_length[100]',
				'description' => 'required|min_length[3]|max_length[500]'
			];

		}else{
			$data['action'] = "add/".$id;
			$data['formTitle'] = "Update Test";

			$rules = [
				'testcase' => 'required|min_length[3]|max_length[100]',
				'description' => 'required|min_length[3]|max_length[500]'
			];	

			$data['member'] = $model->where('id',$id)->first();		
		}
		

		if ($this->request->getMethod() == 'post') {
			$currentTime = gmdate("Y-m-d H:i:s");
			$newData = [
				'testcase' => $this->request->getVar('testcase'),
				'description' => $this->request->getVar('description'),
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
					$message = 'Test Cases successfully updated.';
				}else{
					$message = 'Test Cases successfully added.';
				}

				$model->save($newData);
				$session = session();
				$session->setFlashdata('success', $message);
			}
		}

		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('TestCases/form', $data);
		echo view('templates/footer');
	}

	public function delete(){
		if (session()->get('is-admin')){
			//Delete all options wrt of id and type
			$id = $this->returnParams();
			$model = new TraceabilityOptionsModel;
			$check = array('requirement_id'=> $id, 'type'=> 'testcase');
			$model->where($check)->delete();

			$model1 = new TestCasesModel();
			$model1->delete($id);
			$response = array('success' => "True");
			echo json_encode( $response );
		}
		else{
			$response = array('success' => "False");
			echo json_encode( $response );
		}
	}

}