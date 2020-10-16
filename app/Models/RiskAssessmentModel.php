<?php  namespace App\Models;

use CodeIgniter\Model;

class RiskAssessmentModel extends Model{
    protected $table = 'docsgo-risks';
    protected $allowedFields = ['project_id', 'category', 'name', 'description', 'information', 'severity', 'occurrence', 'detectability', 'rpn', 'status', 'update_date'];

}