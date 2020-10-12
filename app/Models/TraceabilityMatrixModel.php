<?php  namespace App\Models;

use CodeIgniter\Model;

class TraceabilityMatrixModel extends Model{
    protected $table = 'docsgo-traceability';
    protected $allowedFields = ['cncr', 'sysreq', 'subsysreq', 'design', 'code', 'testcase', 'update_date'];

}

