<?php
<<<<<<< HEAD
=======

>>>>>>> 8f771997721bbd6ba4927184948de8741686c027
namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
<<<<<<< HEAD
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'order_date', 'status', 'total'];
}

class OrderItemModel extends Model
{
    protected $table = 'order_items';
    protected $primaryKey = 'id';
    protected $allowedFields = ['order_id', 'product_id', 'quantity', 'price'];
=======

    protected $primaryKey = 'id';

    protected $allowedFields = [

        'order_number',
        'customer_name',
        'total',
        'status',
        'order_date'

    ];
>>>>>>> 8f771997721bbd6ba4927184948de8741686c027
}
