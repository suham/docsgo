<?php namespace App\Controllers;

use App\Models\TestCasesModel;
class TestCases extends BaseController
{
	public function index()
    {
		$data = [];
		$data['pageTitle'] = 'Test Cases';
		$data['addBtn'] = True;
		$data['addUrl'] = "/test-cases/add";

		// helper(['form']);
		$model = new TestCasesModel();
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

	public function add(){

		$id = $this->returnParams();

		helper(['form']);
		$model = new TestCasesModel();
		$data = [];
		$data['pageTitle'] = 'Test Cases';
		$data['addBtn'] = False;
		$data['backUrl'] = "/test-cases";

		if($id == ""){
			$data['action'] = "add";
			$data['formTitle'] = "Add Test Cases";

			$rules = [
				'testcase' => 'required|min_length[3]|max_length[64]',
				'description' => 'required|min_length[3]'
			];

		}else{
			$data['action'] = "add/".$id;
			$data['formTitle'] = "Update";

			$rules = [
				'testcase' => 'required|min_length[3]|max_length[64]',
				'description' => 'required|min_length[3]'
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
			$id = $this->returnParams();
			$model = new TestCasesModel();
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