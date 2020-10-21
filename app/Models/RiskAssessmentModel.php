<?php  namespace App\Models;

use CodeIgniter\Model;

class RiskAssessmentModel extends Model{
    protected $table = 'docsgo-risks';
    protected $allowedFields = ['project_id', 'category', 'name', 'description', 'information', 'severity', 'occurrence', 'detectability', 'rpn', 'status', 'update_date'];

    function getRisks($status = ""){
        $db      = \Config\Database::connect();
        $whereCondition = "";
        if($status != ""){
            $whereCondition = " WHERE risks.status = '".$status."' ";
        }
        $sql = "SELECT
        risks.id, proj.name as project, risks.category, risks.name, risks.description, risks.information,  risks.rpn, risks.status, risks.update_date,
         sev.`name` AS severity, occ.`name` AS occurrence, det.`name` AS detectability
        FROM `docsgo-risks` risks
        LEFT JOIN `docsgo-status-options` sev ON  sev.`value`=risks.`severity`
        LEFT JOIN `docsgo-status-options` occ ON risks.`occurrence` = occ.`value`
        LEFT JOIN `docsgo-status-options` det ON risks.`detectability` = det.`value`
        LEFT JOIN `docsgo-projects` proj ON risks.`project_id` = proj.`project-id`
        ".$whereCondition ."
        ORDER BY update_date;";

        $query = $db->query($sql);
        $data = $query->getResult('array');

        return $data;
    }

}