<?php  namespace App\Models;

use CodeIgniter\Model;

class StatusOptionsModel extends Model{
    protected $table = 'docsgo-status-options';
    protected $allowedFields = ['name', 'value'];

}