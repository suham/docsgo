<?php  namespace App\Models;

use CodeIgniter\Model;

class RiskAssessmentModel extends Model{
    protected $table = 'docsgo-risks';
    protected $allowedFields = ['project_id', 'risk_type', 'risk', 'description', 'component', 'hazard-analysis', 'baseScore_severity','status', 'assessment', 'update_date'];


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
        $sql = "SELECT * from `docsgo-risks` ". $whereCondition . "ORDER BY update_date desc;";
        $query = $db->query($sql);
        $data = $query->getResult('array');
        return $data;
    }

    function getVulnerabilitiesList(){
        $db = \Config\Database::connect();

        $whereCondition = " WHERE risk_type = 'Vulnerability' "; 
        $sql = "SELECT * FROM `docsgo-risks` ". $whereCondition . "ORDER BY update_date desc;";
        $query = $db->query($sql);
        $data = $query->getResult('array');
        return $data;
    }

    function updateVulnerabilityDescription( $riskId, $description){
        $db = \Config\Database::connect();

        $whereCondition = " WHERE id = ".$riskId." "; 
        $sql = "UPDATE `docsgo-risks` SET `description` = '".$description."'
        ".$whereCondition ."";

        $query = $db->query($sql);
        $data = $query->getResult('array');

        return $data; 
    }

    function getRisksForDocuments($condition = ""){
        $db      = \Config\Database::connect();
        $sql = "SELECT * from `docsgo-risks` ".$condition." ORDER BY update_date desc;";
        $query = $db->query($sql);
        $result = $query->getResult('array');
        $data = array();
        
    // $data['assessment'] = $row['assessment'];
       


        foreach($result as $row){
            $temp = array();
            $temp['baseScore_severity'] = $row['baseScore_severity'];
            $temp['component'] = $row['component'];
            $temp['description'] = $row['description'];
            $temp['id'] = $row['id'];
            $temp['hazard-analysis'] = $row['hazard-analysis'];
            $temp['project_id'] = $row['project_id'];
            $temp['risk'] = $row['risk'];
            $temp['risk_type'] = $row['risk_type'];
            $temp['status'] = $row['status'];
            
            if($row['assessment'] == "" ){
                $temp['assessment'] = "";
            }else{
                $assessment = json_decode( $row['assessment'], true );
                if($assessment["risk-assessment"]["cvss"][0]["Score"][0]["value"] == ""){
                    //FMEA
                    $fmea = $assessment["risk-assessment"]["fmea"];
                    $content = "<ol>";
                    foreach($fmea as $section){
                        $content .= "<li>".($section["category"])." => ";
                        if($section["value"] == ""){
                            $section["value"] = "--";
                        }
                        $content .= " ".$section["value"]."</li>";
                    }
                    $content .= "</ol>";
                    $temp['assessment'] = $content;
                }else{
                    //CVSS
                    $cvss = $assessment["risk-assessment"]["cvss"][0];
                    $temp['assessment'] = "";
                    foreach($cvss as $key=>$metric){
                        if($key == "Score"){
                            $key = "CVSS 3.1 ". $key;
                        }
                        $content = "**".strtoupper($key)."** <br/>";
                        $content .= "<ol>";
                        foreach($metric as $section){
                            $content .= "<li>".$section["category"] . " => ";
                            if($section["value"] == ""){
                                $section["value"] = "--";
                            }
                            $content .= " ".$section["value"]."</li>";
                        }
                        $content .= "</ol>";
                        $temp['assessment'] .= $content .  "<br/>" ;
                    }
                    
                }
            }
           
            array_push($data, $temp);
        }

        return $data;
    }

    function formatAssesment($data){

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