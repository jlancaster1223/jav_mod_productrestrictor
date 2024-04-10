<?php

namespace Module\Productrestrictor\Controllers;

use App\Controllers\BaseController;
use Module\Productrestrictor\Models\ProductRestrictionModel;

class FrontRestrict extends BaseController {
    public function getRestrictionsById($id) {
        $productRestrictionModel = new ProductRestrictionModel();
        $productRestriction = $productRestrictionModel->where('product_id', $id)->first();
        if ($productRestriction) {
            return explode('|',$productRestriction['account_types']);
        }
        return '';
    }
}