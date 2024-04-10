<?php

namespace Module\Productrestrictor\Models;

use CodeIgniter\Model;

class ProductRestrictionModel extends Model
{
    protected $table = 'product_restrictions';
    protected $primaryKey = 'restriction_id';

    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'restriction_id',
        'product_id',
        'account_types'
    ];
}