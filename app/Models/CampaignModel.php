<?php

namespace App\Models;

use CodeIgniter\Model;

class CampaignModel extends Model {
    protected $table = 'campaigns';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id',
        'campaign_name',
        'description',
    ];
}
