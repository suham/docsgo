<?php  namespace App\Models;

use CodeIgniter\Model;

class ReviewModel extends Model{
    protected $table = 'docsgo-reviews';
    protected $allowedFields = ["assigned-to","context","description", "code-diff", "id","project-id",
                                "review-by","review-name","review-ref","status","updated-at", "category"];


    public function getMappedRecords($whereCondition = ""){
        $db      = \Config\Database::connect();
        $sql = "SELECT rev.`id`, team.`name` as `review-by`, team2.name as `assigned-to`,
        rev.`context`,rev.`description`,proj.`name` as `project-name`,rev.`review-name`,rev.`review-ref`,rev.`status`
        FROM `docsgo-reviews` AS rev
        INNER JOIN `docsgo-projects` AS proj ON proj.`project-id` = rev.`project-id`
        INNER JOIN `docsgo-team-master` AS team ON rev.`review-by` = team.`id` 
        INNER JOIN `docsgo-team-master` AS team2 ON rev.`assigned-to` = team2.`id` ".$whereCondition.";";

        $query = $db->query($sql);

        $data = $query->getResult('array');
        
        return $data;
    }

    public function getReviewsCount($project_id){
        $db      = \Config\Database::connect();
        
        $sql = "select count(*) as count ,status from `docsgo-reviews` where `project-id` = ".$project_id." group by status";

        $query = $db->query($sql);

        $result = $query->getResult('array');

        for($i=0; $i<count($result);$i++){
			$data[$result[$i]['status']] = $result[$i]['count'];
		}
        
        return $data;
    }
                                
}