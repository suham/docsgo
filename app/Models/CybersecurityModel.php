<?php  namespace App\Models;

use CodeIgniter\Model;

class CybersecurityModel extends Model{
    protected $table = 'docsgo-cybersecurity';
    protected $allowedFields = ['project_id', 'reference', 'description', 'control', 'evidence', 'update_date', 'status'];

}