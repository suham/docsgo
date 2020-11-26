<?php namespace App\Controllers;

use App\Models\TaskboardModel;
use App\Models\ProjectModel;
use App\Models\TeamModel;

class Taskboard extends BaseController
{
	public function index()
    {
        $data = [];
        $project_id = $this->request->getVar('project-id');
        if($project_id != ""){
            $projectModel = new ProjectModel();
            $project = $projectModel->where('project-id', $project_id)->first();
            
            $title = $project['name'];
            $data['title'] = $title;	
            $data['project_id'] =  $project_id;

            $teamModel = new TeamModel();
            $data['teamMembers'] = $teamModel->getMembers();

            $taskModel = new TaskboardModel();
            $data['tasksArr'] = $taskModel->getTasks("WHERE project_id = ".$project_id);
        }
		echo view('templates/header');
		echo view('taskboard',$data);
		echo view('templates/footer');

    }

    private function isManagerCheck(){
        if(!session()->get('is-manager')){
            $response = array();
            $response["success"] = "False";
            $response["errorMsg"] = "You are not authorized to perform this task. Your changes will not be saved.";
            echo json_encode($response);
            exit(0);
        }
    }

    public function addTask(){
        
        $this->isManagerCheck();

        $id = $this->request->getVar('id');
        $task = [
            "assignee" => $this->request->getVar('assignee'),
            "description" => $this->request->getVar('description'),
            "project_id" => $this->request->getVar('project_id'),
            "verifier" => $this->request->getVar('verifier') ,
            "task_category" => $this->request->getVar('task_category'),
            "task_column" => $this->request->getVar('task_column'),
            "title" => $this->request->getVar('title'),
        ];

        $model = new TaskboardModel();
        if($id != ""){
            $model->update($id, $task);
        }else{
            $id = $model->insert($task);
        }

        
        $response["success"] = "True";
        $response["id"] = $id;
        
        echo json_encode($response);
    }

    public function updateTaskColumn(){
        $this->isManagerCheck();

        $id = $this->request->getVar('id');
        $task = [
            "task_column" => $this->request->getVar('task_column')
        ];

        $model = new TaskboardModel();
        $model->update($id, $task);
        
        $response = array();
        $response["success"] = "True";
        
        echo json_encode($response);
    }

    public function addComment(){
        $this->isManagerCheck();
        
        $jsonComment["comment"] = $this->request->getVar('comment');
        $jsonComment["timestamp"] = gmdate("Y-m-d H:i:s");
        $jsonComment["by"] = session()->get('name');

        $id = $this->request->getVar('id');
        $model = new TaskboardModel();
        $task = $model->find($id);
        $existingComments = $task['comments'];

        if($existingComments == null){
            $existingComments = array();
        }else{
            $existingComments = json_decode($existingComments, true);
        }
        array_push($existingComments, $jsonComment);

        $updatedTask = [
            "comments" => json_encode($existingComments)
        ];

        $model->update($id, $updatedTask);

        $response = array();
        $response["success"] = "True";
        $response['jsonComment'] = json_encode($jsonComment);

        echo json_encode($response);
    }

    public function deleteTask(){
        $this->isManagerCheck();
        
        $id = $this->request->getVar('id');

        $model = new TaskboardModel();
        $model->delete($id);

        $response = array('success' => "True");
        
        echo json_encode($response);       
    }



}