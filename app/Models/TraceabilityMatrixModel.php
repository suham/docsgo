<?php  namespace App\Models;

use CodeIgniter\Model;

class TraceabilityMatrixModel extends Model{
    protected $table = 'docsgo-traceability';
    protected $allowedFields = ['design', 'code', 'update_date'];


    public function getTraceabilityData(){
        $db      = \Config\Database::connect();
        
        $sql = "SELECT *
        FROM ((SELECT options.traceability_id as id, options.type, trace.code, trace.design, trace.update_date,GROUP_CONCAT(CONCAT_WS(',', req.requirement) ORDER BY req.requirement SEPARATOR '<br/>') as requirement
        FROM `docsgo-requirements` req, `docsgo-traceability-options` options, `docsgo-traceability` AS trace
        WHERE req.id = options.requirement_id and options.traceability_id and trace.id = options.traceability_id 
        GROUP BY  options.traceability_id,options.type
        )
        UNION 
        (SELECT options.traceability_id as id, options.type, trace.code, trace.design, trace.update_date, GROUP_CONCAT(CONCAT_WS(',', testCases.testcase) ORDER BY testCases.testcase SEPARATOR '<br/>') as testcase
        FROM `docsgo-test-cases` AS testCases, `docsgo-traceability-options` options, `docsgo-traceability` AS trace
        WHERE testCases.id = options.requirement_id and options.traceability_id and trace.id = options.traceability_id 
        GROUP BY  options.traceability_id,options.type
        )) AS TMATRIX ORDER BY update_date desc;";

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
        
        return $matrix;
    }

    public function getunmapedList () {
        $db      = \Config\Database::connect();

        $sql = "(SELECT GROUP_CONCAT(CONCAT_WS(',', req.requirement)  ORDER BY req.requirement SEPARATOR '<br/>' ) as requirement, type
        FROM `docsgo-requirements` req
        WHERE req.id NOT IN (
            SELECT options.requirement_id
             FROM `docsgo-traceability-options` as options
        ) 
        GROUP BY req.type)
        UNION
        (SELECT GROUP_CONCAT(CONCAT_WS(',', tests.testcase)  ORDER BY tests.testcase SEPARATOR '<br/>') as requirement, 'testcase' as type
        FROM `docsgo-test-cases` tests
        WHERE tests.id NOT IN (
            SELECT options.requirement_id
             FROM `docsgo-traceability-options` as options
        ))";
        
        $query = $db->query($sql);
        $unmappedData = $query->getResult('array');
        $data = array();
        foreach($unmappedData as $row){
            $data[$row["type"]] = $row["requirement"];
        }
        
        return $data;
    }

}

