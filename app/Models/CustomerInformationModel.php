<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerInformationModel extends Model
{
    protected $table = 'customer_information';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    // Only the fields we expect to insert/update from the checkout flow.
    protected $allowedFields = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'street_address',
        'city',
        'state_province',
        'postal_code',
    ];
}
