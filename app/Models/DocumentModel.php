<?php  namespace App\Models;

use CodeIgniter\Model;

class DocumentModel extends Model{
    protected $table = 'docsgo-documents';
    protected $allowedFields = ["project-id","review-id","type","category","author-id", "update-date","json-object","file-name","status"];
    
    public function getProjects($type = "", $status = "", $project_id = ""){
        $db      = \Config\Database::connect();
        
        $whereCondition = "";
        if($type != ""){
            $whereCondition = "WHERE docs.`type` = '".$type."' ";
        }

        if($status != "" && $project_id  != ""){
            $whereCondition = "WHERE docs.`status` = '".$status."' and docs.`project-id` = ".$project_id." ";
        }

        $sql = "SELECT docs.`id`,docs.`project-id`,docs.`review-id`,docs.`type`,docs.`author-id`, team.`name` as `author`, docs.`update-date`,docs.`json-object`,docs.`file-name`,docs.`status`
        FROM `docsgo-documents` AS docs
        INNER JOIN `docsgo-team-master` AS team ON docs.`author-id` = team.`id` 
        ".$whereCondition."
        ORDER BY docs.`update-date` DESC;";

        $query = $db->query($sql);

        $data = $query->getResult('array');
        
        return $data;
    }

}