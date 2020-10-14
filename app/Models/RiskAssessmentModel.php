<?php  namespace App\Models;

use CodeIgniter\Model;

class RiskAssessmentModel extends Model{
    protected $table = 'docsgo-risk-assessment';
    protected $allowedFields = ['risk_type', 'risk_details', 'failure', 'harm', 'mitigation', 'severity', 'occurrence', 'detectability', 'rpn', 'update_date', 'issue_id', 'cybersecurity_id', 'soup_id'];

}