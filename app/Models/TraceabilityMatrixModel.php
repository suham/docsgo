<?php  namespace App\Models;

use CodeIgniter\Model;

class TraceabilityMatrixModel extends Model{
    protected $table = 'docsgo-traceability';
    protected $allowedFields = ['design', 'code', 'update_date'];

    public function getTraceabilityMatrix(){
        $db      = \Config\Database::connect();
        $sql = "SELECT  trace.id, trace.code, trace.design, req1.requirement as cncr, req2.requirement as sysreq, req3.requirement as subsysreq, tc.testcase
        FROM `docsgo-traceability` AS trace
        INNER JOIN `docsgo-requirements` AS req1 ON req1.`id` = trace.`cncr`
        INNER JOIN `docsgo-requirements` AS req2 ON req2.`id` = trace.`sysreq`
        INNER JOIN `docsgo-requirements` AS req3 ON req3.`id` = trace.`subsysreq`
        INNER JOIN `docsgo-test-cases` AS tc ON tc.`id` = trace.`testcase`;";

        $query = $db->query($sql);

        $data = $query->getResult('array');
        
        return $data;
    }

    public function getTraceabilityMatrixTabularData() {
        $db      = \Config\Database::connect();
        $sql = "SELECT  a.id, a.design, a.code, b.traceability_id, b.type, b.requirement_id, c.requirement,d.testcase
        FROM `docsgo-traceability` AS a
        LEFT JOIN `docsgo-traceability-options` AS b ON a.`id` = b.`traceability_id`
        LEFT JOIN `docsgo-requirements` AS c ON c.`id` = b.`requirement_id` AND b.type != 'testcase'
        LEFT JOIN `docsgo-test-cases` AS d ON b.`requirement_id` = d.`id`  AND b.type = 'testcase';";

        $query = $db->query($sql);
        $data = $query->getResult('array');
        return $data;
    }

}

