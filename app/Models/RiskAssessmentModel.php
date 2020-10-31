<?php  namespace App\Models;

use CodeIgniter\Model;

class RiskAssessmentModel extends Model{
    protected $table = 'docsgo-risks';
    protected $allowedFields = ['project_id', 'risk_type', 'risk', 'description', 'component', 'mitigation', 'baseScore_severity','status', 'assessment', 'update_date'];

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

    function getRisks($status = '', $type = '') {
        $db      = \Config\Database::connect();
        $whereCondition = ""; $riskType = 'Vulnerability';
        $riskCategory = ['Open-Issue', 'Vulnerability', 'SOUP'];
        if(in_array($type, $riskCategory)) 
            $riskType = $type;
        if($status == "All"){
            $whereCondition = " WHERE risk_type = '".$riskType."' ";
        }else{
            $whereCondition = " WHERE risk_type = '".$riskType."' AND status = '".$status."' ";
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
        $settingsModel = new SettingsModel();

        $serverConfig = $settingsModel->getSettings("third-party");
        
        $serverDetails = json_decode($serverConfig[0]['options']);
        $BASE_URL = "";
        foreach( $serverDetails as $server ){
            if($server->key == "sonar"){
                $BASE_URL= $server->value;
            }
        }
        
        $vulnerabilities = [];
        if( $BASE_URL){
            try {
                $ch = curl_init();  
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                curl_setopt($ch, CURLOPT_URL, "$BASE_URL/api/issues/search?types=VULNERABILITY&statuses=OPEN"); 
                $result = curl_exec($ch); 
                curl_close($ch);
    
                $data = json_decode($result);
                // print_r($data);
                if( $data->total ){
                    $count = $data->total;  
                    $pageCount = floor($count/100);
                    if( $pageCount == 0 ){
                        $pageCount = 1;
                    }        
                    if( $count != 0 && $pageCount > 0 ){
                        for( $i = 1; $i <= $pageCount; $i++ ){
                            $pageIndex = $i;
                            $curlReq = curl_init();  
                            curl_setopt($curlReq, CURLOPT_RETURNTRANSFER, 1); 
                            curl_setopt($curlReq, CURLOPT_URL, "$BASE_URL/api/issues/search?types=VULNERABILITY&statuses=OPEN&pageIndex=$pageIndex"); 
                            $res = curl_exec($curlReq); 
                            $tmp = json_decode($res);
                            $vulnerabilities = array_merge( $vulnerabilities, $tmp->issues);
                        }
                    }
                }
            } catch(Exception $e){
                error_log($e);
                return false;
            }
            return $vulnerabilities;
        } else {
            return false;
        }        
    }
}