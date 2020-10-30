<?php  namespace App\Models;

use CodeIgniter\Model;

class RiskAssessmentModel extends Model{
    protected $table = 'docsgo-risks';
    protected $allowedFields = ['project_id', 'risk_type', 'risk', 'description', 'component', 'mitigation', 'severity', 'occurrence', 'detectability', 'rpn', 'base_score','status', 'assessment', 'update_date'];

    function getRisksOld($status = ""){
        $db      = \Config\Database::connect();
        $whereCondition = "";
        if($status != ""){
            $whereCondition = " WHERE risks.status = '".$status."' ";
        }
        $sql = "SELECT
        risks.id, proj.name as project, risks.risk_type, risks.risk, risks.description, risks.mitigation,  risks.rpn, risks.status, risks.update_date,
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

    function getRisks($status = '') {
        $db      = \Config\Database::connect();
        $whereCondition = "";
        if($status != ""){
            $whereCondition = " WHERE status = '".$status."' ";
        }
        $sql = "SELECT * from `docsgo-risks` ". $whereCondition . "ORDER BY update_date;";
        $query = $db->query($sql);
        $data = $query->getResult('array');
        return $data;
    }

    function getVulnerabilitiesList(){
        $db = \Config\Database::connect();

        $whereCondition = " WHERE risk_type = 'Vulnerability' "; 
        $sql = "SELECT * FROM `docsgo-risks`
        ".$whereCondition ."
        ORDER BY update_date;";

        $query = $db->query($sql);
        $data = $query->getResult('array');
        return $data;
    }

    function getSonarRecords(){
        $SONAR_IP = '13.233.238.97';
        $BASE_URL = 'sonar/api';
        $vulnerabilities = json_encode([]);

        try {
            $ch = curl_init();  
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
            curl_setopt($ch, CURLOPT_URL, "http://$SONAR_IP:9000/$BASE_URL/issues/search?types=VULNERABILITY"); 
            $result = curl_exec($ch); 
            curl_close($ch);

            $data = json_decode($result);
            if( $data->total ){
                $count = $data->total;  
                $pageCount = floor($count/100);
                if( $count != 0 && $pageCount >= 0 ){
                    for( $i = 0; $i <= $pageCount; $i++ ){
                        $pageIndex = ++$i;
                        $curlReq = curl_init();  
                        curl_setopt($curlReq, CURLOPT_RETURNTRANSFER, 1); 
                        curl_setopt($curlReq, CURLOPT_URL, "http://$SONAR_IP:9000/$BASE_URL/issues/search?types=VULNERABILITY&pageIndex=$pageIndex"); 
                        $res = curl_exec($curlReq); 
                        $vulnerabilities = (object) array_merge( (array) $vulnerabilities, (array) json_decode($res));
                    }
                }
            }
        } catch(Exception $e){
            error_log($e);
        }
        return $vulnerabilities->issues;
    }
}