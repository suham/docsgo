<?php  namespace App\Models;

use CodeIgniter\Model;

class TraceabilityMatrixModel extends Model{
    protected $table = 'docsgo-traceability';
    protected $allowedFields = ['cncr', 'sysreq', 'subsysreq', 'design', 'code', 'testcase', 'update_date'];

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

}

