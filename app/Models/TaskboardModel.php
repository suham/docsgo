<?php  namespace App\Models;

use CodeIgniter\Model;

class TaskboardModel extends Model{
    protected $table = 'docsgo-taskboard';
    protected $allowedFields = ['assignee','comments','description','project_id','qa','task_category','title','task_column'];

    public function getTasks($whereCondition = ""){
        $db      = \Config\Database::connect();
        $sql = "SELECT tasks.id, NULLIF(tasks.assignee, 0) AS assignee, tasks.comments, tasks.description, tasks.project_id
                        , NULLIF(tasks.qa, 0) AS qa, tasks.task_category, tasks.title, tasks.task_column
                FROM `docsgo-taskboard` AS tasks
                LEFT JOIN `docsgo-team-master` AS team ON tasks.`assignee` = team.`id` 
                LEFT JOIN `docsgo-team-master` AS team2 ON tasks.`qa` = team2.`id` 
                ".$whereCondition."
                ORDER BY IF(tasks.task_column='Under QA', team2.name, team.name) ASC";

        $query = $db->query($sql);

        $data = $query->getResult('array');
        
        return $data;
    }

}