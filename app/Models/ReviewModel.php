<?php  namespace App\Models;

use CodeIgniter\Model;

class ReviewModel extends Model{
    protected $table = 'docsgo-reviews';
    protected $allowedFields = ["assigned-to","context","description","id","project-id",
                                "review-by","review-name","review-ref","status"];


    public function getMappedRecords(){
        $db      = \Config\Database::connect();
        $sql = "SELECT rev.`id`, team.`name` as `review-by`, team2.name as `assigned-to`,
        rev.`context`,rev.`description`,proj.`name` as `project-name`,rev.`review-name`,rev.`review-ref`,rev.`status`
        FROM `docsgo-reviews` AS rev
        INNER JOIN `docsgo-projects` AS proj ON proj.`project-id` = rev.`project-id`
        INNER JOIN `docsgo-team-master` AS team ON rev.`review-by` = team.`id` 
        INNER JOIN `docsgo-team-master` AS team2 ON rev.`assigned-to` = team2.`id`;";

        $query = $db->query($sql);

        $data = $query->getResult('array');
        
        return $data;
    }
                                
}