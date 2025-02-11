<?php
namespace App\Models;

use CodeIgniter\Model;

class HarborBoatModel extends Model {
    protected $table = 'harbor_boats';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name',
        'type',
        'length',
        'width',
        'draft',
        'rental_price_per_day',
        'availablility_status',
        'description',
    ];

    protected $returnType = 'object';
}