<?php

namespace Module\Productrestrictor\Config;

// Register our new entity location for Posttypes
use App\Libraries\Admin\Permissions;
use App\Libraries\System\Events;
use Module\Productrestrictor\Models\ProductRestrictionModel;

// Add tab to the product page
Events::on('admin_store_product_tabs', function($tabs) {
    $tabs['restrictions'] = [
        'tab' => '<i class="fa-solid fa-triangle-exclamation left"></i> Restrictions',
        'view' => '\Module\Productrestrictor\Views\tab',
    ];
    return $tabs;
});

Events::on('admin_store_product_save_after', function($product) {
    // New product restriction model
    $productRestrictionModel = new ProductRestrictionModel();
    // Check if there is one already there with this product id
    $productRestriction = $productRestrictionModel->where('product_id', $product['product_id'])->first();
    // If there is not one, create one
    if (!$productRestriction) {
        if(count($_POST['user_restrictions']) > 0) {
            $productRestriction = $productRestrictionModel->save([
                'product_id' => $product['product_id'],
                'account_types' => implode('|', $_POST['user_restrictions']),
            ]);
        }
    } else {
        // Update the existing one
        if(count($_POST['user_restrictions']) == 0) {
            $productRestrictionModel->delete($productRestriction['restriction_id']);
        } else {
            $productRestrictionModel->update($productRestriction['restriction_id'], [
                'account_types' => implode('|', $_POST['user_restrictions']),
            ]);
        }
    }

    return $product;
});