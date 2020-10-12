<?php  namespace App\Models;

use CodeIgniter\Model;

class IssueModel extends Model{
    protected $table = 'docsgo-issues';
    protected $allowedFields = ['project_id', 'issue', 'issue_description', 'update_date', 'source', 'status'];

}