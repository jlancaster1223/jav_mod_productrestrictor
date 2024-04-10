<?php
// Get all user groups
$user_groups = new \App\Models\AccountTypeModel();
$user_groups = $user_groups->findAll();

$product_restrictions = [
    'groups' => [],
    'user_emails' => '',
];


$url = explode('/', $_SERVER['REQUEST_URI']);
$productID = end($url);

$product_restrictions['groups'] = new \Module\Productrestrictor\Controllers\FrontRestrict();
$product_restrictions['groups'] = $product_restrictions['groups']->getRestrictionsById($productID);
?>

<div x-show="tab == 'restrictions'">
    <div class="panel margin-to" x-data="{show: true}">
        <div class="panel-header">
            Product Restrictions by group
            <button type="button" class="panel-header-minimise" :class="show ? '' : 'minimised'" @click="show = !show"></button>
        </div>
        <div class="panel-body" x-show="show" x-collapse.min.75px :class="show ? '' : 'minimised'">
            <p>If there is nothing selected, then the product will be open to all users</p>
            <div class="category-container">
                <!-- Checkboxes for each user group -->
                <?php foreach ($user_groups as $user_group) : ?>
                    <div class="category-container-item-group root">
                        <div class="category-container-item">
                            <label>
                                <input type="checkbox" name="user_restrictions[]" value="<?=$user_group['account_type_id'];?>" <?=(in_array($user_group['account_type_id'], $product_restrictions['groups']) ? 'checked' : '');?>>
                                 <?=$user_group['account_type_name'];?>
                            </label>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>