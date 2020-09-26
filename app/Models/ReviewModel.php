<?php  namespace App\Models;

use CodeIgniter\Model;

class ReviewModel extends Model{
    protected $table = 'docsgo-reviews';
    protected $allowedFields = ["authors","closed-date","description1","description2",
                                "description3","opened-date","project-id","review-date","review-items","reviewed-by",
                                "reviewed-date","reviewers","status","subtitle"];
    
}