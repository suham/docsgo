<?php  namespace App\Models;

use CodeIgniter\Model;

class DropdownSettingsModel extends Model{
    protected $table = 'docsgo-settings';
    protected $allowedFields = ['type', 'identifier', 'options'];
}