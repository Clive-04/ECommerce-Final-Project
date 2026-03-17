<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';

    protected $primaryKey = 'id';

    protected $allowedFields = [

        'order_number',
        'customer_name',
        'total',
        'status',
        'order_date'

    ];
}
