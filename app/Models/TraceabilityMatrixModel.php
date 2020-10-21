<?php  namespace App\Models;

use CodeIgniter\Model;

class TraceabilityMatrixModel extends Model{
    protected $table = 'docsgo-traceability';
    protected $allowedFields = ['design', 'code', 'update_date'];


    public function getTraceabilityData(){
        $db      = \Config\Database::connect();
        
        $sql = "(SELECT options.traceability_id as id, options.type, trace.code, trace.design, GROUP_CONCAT(CONCAT_WS(',', req.requirement) SEPARATOR '<br/>') as requirement
        FROM `docsgo-requirements` req, `docsgo-traceability-options` options, `docsgo-traceability` AS trace
        WHERE req.id = options.requirement_id and options.traceability_id and trace.id = options.traceability_id 
        GROUP BY  options.traceability_id,options.type
        ORDER BY trace.update_date)
        UNION
        (SELECT options.traceability_id as id, options.type, trace.code, trace.design, GROUP_CONCAT(CONCAT_WS(',', testCases.testcase) SEPARATOR '<br/>') as testcase
        FROM `docsgo-test-cases` AS testCases, `docsgo-traceability-options` options, `docsgo-traceability` AS trace
        WHERE testCases.id = options.requirement_id and options.traceability_id and trace.id = options.traceability_id 
        GROUP BY  options.traceability_id,options.type
        ORDER BY trace.update_date);";

        $query = $db->query($sql);
        $traceabilityData = $query->getResult('array');

        $data = array();
        foreach($traceabilityData as $row){
            
            $id = $row["id"];
            $type = $row["type"];
            $code = $row["code"];
            $design = $row["design"];

            $data[$id]["id"] = $id;
            $data[$id]["code"] = $code;
            $data[$id]["design"] = $design;
            $requirement = $row["requirement"];

            $temp = array();

            if(array_key_exists($id, $data)){
                $temp = $data[$id];
            }

            if($type == "Subsystem"){
                 $data[$id]["subsysreq"] = $requirement;
            }else if($type == "System"){
                 $data[$id]["system"] = $requirement;
            }else if($type == "testcase"){
                 $data[$id]["testcase"] = $requirement;
            }else {
                $data[$id]["cncr"] = $requirement;
            }
        }

        $matrix = array();
        //Removing Index
        foreach ($data as $row){
            array_push($matrix, $row);
        }
        
        return array_reverse($matrix);
    }

    public function getunmapedList () {
        $db      = \Config\Database::connect();
        
        $sql = "(SELECT id, type, requirement FROM `docsgo-requirements` WHERE type='User Needs' AND (id NOT IN ( SELECT requirement_id FROM `docsgo-traceability-options` WHERE type='User Needs')) 
        UNION( SELECT id, type, requirement FROM `docsgo-requirements` WHERE type='System' AND (id NOT IN ( SELECT requirement_id FROM `docsgo-traceability-options` WHERE type='System'))) 
        UNION( SELECT id, type, requirement FROM `docsgo-requirements` WHERE type='SubSystem' AND (id NOT IN ( SELECT requirement_id FROM `docsgo-traceability-options` WHERE type='SubSystem'))) 
        UNION ( SELECT id, 'testcase' as type, testcase as requirement FROM `docsgo-test-cases` WHERE id NOT IN ( SELECT requirement_id FROM `docsgo-traceability-options` WHERE type='testcase')));";
        $query = $db->query($sql);
        $unmappedData = $query->getResult('array');
        
        $data = []; $userNeeds = ""; $system = ""; $subSystem=""; $testCase="";
        foreach($unmappedData as $row){ 
            if($row['type'] == 'User Needs')
                $userNeeds = $userNeeds.$row['requirement']."<br/>";
            if($row['type'] == 'System')
                $system = $system.$row['requirement']."<br/>";
            if($row['type'] == 'Subsystem')
                $subSystem = $subSystem.$row['requirement']."<br/>";
            if($row['type'] == 'testcase')
                $testCase = $testCase.$row['requirement']."<br/>";
        };
        $data['userNeedsList'] = $userNeeds;
        $data['systemList'] = $system;
        $data['subSystemList'] = $subSystem;
        $data['testCaseList'] = $testCase;
        return $data;
    }

}

