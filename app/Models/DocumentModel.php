<?php  namespace App\Models;

use CodeIgniter\Model;

class DocumentModel extends Model{
    protected $table = 'docsgo-documents';
    protected $allowedFields = ["project-id", "review-id", "type", "category", "author-id", "reviewer-id", 
                                "update-date", "json-object", "file-name", "status", "revision-history"];
    
    public function getProjects($type = "", $status = "", $project_id = ""){
        $db      = \Config\Database::connect();
        
        $whereCondition = "";
        if($type != ""){
            $whereCondition = "WHERE docs.`type` = '".$type."' ";
        }

        if($status != "" && $project_id  != ""){
            $whereCondition = "WHERE docs.`status` = '".$status."' and docs.`project-id` = ".$project_id." ";
        }

        $sql = "SELECT docs.`id`,docs.`project-id`,docs.`review-id`,docs.`type`,docs.`author-id`, author.`name` as `author`, reviewer.`name` as `reviewer`, docs.`update-date`,docs.`json-object`,docs.`file-name`,docs.`status`
        FROM `docsgo-documents` AS docs
        INNER JOIN `docsgo-team-master` AS author ON docs.`author-id` = author.`id` 
        INNER JOIN `docsgo-team-master` AS reviewer ON docs.`reviewer-id` = reviewer.`id` 
        ".$whereCondition."
        ORDER BY docs.`update-date` DESC;";

        $query = $db->query($sql);

        $data = $query->getResult('array');
        
        return $data;
    }

    public function getDocumentsData($type = '', $id = '') {
        $db = \config\Database::connect();

        $whereCondition = "";
        if($type == 'project'){
            $sql = "SELECT * FROM `docsgo-documents` WHERE `project-id` = '".$id."' AND `status` = 'Approved' ";
        }else{
            $whereCondition = "WHERE `id` = '".$id."' ";
            $sql = "SELECT * FROM `docsgo-documents` ". $whereCondition;
        }
        $query = $db->query($sql);
        $data = $query->getResult('array');
        return $data;
    }

    public function getDocuments($whereCondition = "", $limit = ""){
        $db      = \Config\Database::connect();
        
        $sql = "SELECT docs.`id`,docs.`project-id`,docs.`review-id`,docs.`type`,docs.`author-id`, author.`name` as `author`, reviewer.`name` as `reviewer`, docs.`update-date`,docs.`json-object`,docs.`file-name`,docs.`status`
        FROM `docsgo-documents` AS docs
        INNER JOIN `docsgo-team-master` AS author ON docs.`author-id` = author.`id` 
        INNER JOIN `docsgo-team-master` AS reviewer ON docs.`reviewer-id` = reviewer.`id` 
        ".$whereCondition."
        ORDER BY docs.`update-date` DESC ".$limit." ;";

        $query = $db->query($sql);

        $data = $query->getResult('array');

        for($i=0; $i<count($data);$i++){
			$decodedJson = json_decode($data[$i]['json-object'], true);
			$data[$i]['title'] = $decodedJson[$data[$i]['type']]['cp-line3'];
		}
        
        return $data;

    }

    public function getDocumentsCount($project_id){
        $db      = \Config\Database::connect();
        
        $sql = "select count(*) as count ,status from `docsgo-documents` where `project-id` = ".$project_id." group by status";

        $query = $db->query($sql);

        $result = $query->getResult('array');
        if(count($result)){
            for($i=0; $i<count($result);$i++){
                $data[$result[$i]['status']] = $result[$i]['count'];
            }
            return $data;
        }else{
            return null;
        }
    
    }

}