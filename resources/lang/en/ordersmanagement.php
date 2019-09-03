<?php

return [

    // Titles
    'showing-all-orders'     => 'Showing All Orders',
    'orders-menu-alt'        => 'Show Orders Management Menu',
    'create-new-order'       => 'Create New Order',
    'show-deleted-orders'    => 'Show Deleted Order',
    'editing-order'          => 'Editing Order :name',
    'showing-order'          => 'Showing Order :name',
    'showing-order-title'    => ':name\'s Information',

    // Flash Messages
    'createSuccess'   => 'Successfully created order! ',
    'updateSuccess'   => 'Successfully updated order! ',
    'deleteSuccess'   => 'Successfully deleted order! ',
    'deleteSelfError' => 'You cannot delete yourself! ',

    // Show Order Tab
    'viewProfile'            => 'View Profile',
    'editOrder'               => 'Edit Order',
    'deleteOrder'             => 'Delete Order',
    'ordersBackBtn'           => 'Back to Orders',
    'ordersPanelTitle'        => 'Order Information',
    'labelOrderName'          => 'Ordername:',
    'labelEmail'             => 'Email:',
    'labelFirstName'         => 'First Name:',
    'labelLastName'          => 'Last Name:',
    'labelRole'              => 'Role:',
    'labelStatus'            => 'Status:',
    'labelAccessLevel'       => 'Access',
    'labelPermissions'       => 'Permissions:',
    'labelCreatedAt'         => 'Created At:',
    'labelUpdatedAt'         => 'Updated At:',
    'labelIpEmail'           => 'Email Signup IP:',
    'labelIpEmail'           => 'Email Signup IP:',
    'labelIpConfirm'         => 'Confirmation IP:',
    'labelIpSocial'          => 'Socialite Signup IP:',
    'labelIpAdmin'           => 'Admin Signup IP:',
    'labelIpUpdate'          => 'Last Update IP:',
    'labelDeletedAt'         => 'Deleted on',
    'labelIpDeleted'         => 'Deleted IP:',
    'ordersDeletedPanelTitle' => 'Deleted Order Information',
    'ordersBackDelBtn'        => 'Back to Deleted Orders',

    'successRestore'    => 'Order successfully restored.',
    'successDestroy'    => 'Order record successfully destroyed.',
    'errorOrderNotFound' => 'Order not found.',

    'labelOrderLevel'  => 'Level',
    'labelOrderLevels' => 'Levels',

    'orders-table' => [
        'caption'   => '{1} :orderscount order total|[2,*] :orderscount total orders',
        'id'        => 'ID',
        'name'      => 'Ordername',
        'fname'     => 'First Name',
        'lname'     => 'Last Name',
        'email'     => 'Email',
        'role'      => 'Role',
        'created'   => 'Created',
        'updated'   => 'Updated',
        'actions'   => 'Actions',
        'updated'   => 'Updated',
    ],

    'buttons' => [
        'create-new'    => 'New Order',
        'delete'        => '<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i>  <span class="hidden-xs hidden-sm">Delete</span><span class="hidden-xs hidden-sm hidden-md"> Order</span>',
        'show'          => '<i class="fa fa-eye fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm">Show</span><span class="hidden-xs hidden-sm hidden-md"> Order</span>',
        'edit'          => '<i class="fa fa-pencil fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm">Edit</span><span class="hidden-xs hidden-sm hidden-md"> Order</span>',
        'back-to-orders' => '<span class="hidden-sm hidden-xs">Back to </span><span class="hidden-xs">Orders</span>',
        'back-to-order'  => 'Back  <span class="hidden-xs">to Order</span>',
        'delete-order'   => '<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i>  <span class="hidden-xs">Delete</span><span class="hidden-xs"> Order</span>',
        'edit-order'     => '<i class="fa fa-pencil fa-fw" aria-hidden="true"></i> <span class="hidden-xs">Edit</span><span class="hidden-xs"> Order</span>',
    ],

    'tooltips' => [
        'delete'        => 'Delete',
        'show'          => 'Show',
        'edit'          => 'Edit',
        'create-new'    => 'Create New Order',
        'back-orders'    => 'Back to orders',
        'email-user'    => 'Email :user',
        'submit-search' => 'Submit Orders Search',
        'clear-search'  => 'Clear Search Results',
    ],

    'messages' => [
        'orderNameTaken'          => 'Ordername is taken',
        'orderNameRequired'       => 'Ordername is required',
        'fNameRequired'          => 'First Name is required',
        'lNameRequired'          => 'Last Name is required',
        'emailRequired'          => 'Email is required',
        'emailInvalid'           => 'Email is invalid',
        'passwordRequired'       => 'Password is required',
        'PasswordMin'            => 'Password needs to have at least 6 characters',
        'PasswordMax'            => 'Password maximum length is 20 characters',
        'captchaRequire'         => 'Captcha is required',
        'CaptchaWrong'           => 'Wrong captcha, please try again.',
        'roleRequired'           => 'Order role is required.',
        'order-creation-success'  => 'Successfully created order!',
        'update-order-success'    => 'Successfully updated order!',
        'delete-success'         => 'Successfully deleted the order!',
        'cannot-delete-yourself' => 'You cannot delete yourself!',
    ],

    'show-order' => [
        'id'                => 'Order ID',
        'name'              => 'Ordername',
        'email'             => '<span class="hidden-xs">Order </span>Email',
        'role'              => 'Order Role',
        'created'           => 'Created <span class="hidden-xs">at</span>',
        'updated'           => 'Updated <span class="hidden-xs">at</span>',
        'labelRole'         => 'Order Role',
        'labelAccessLevel'  => '<span class="hidden-xs">Order</span> Access Level|<span class="hidden-xs">Order</span> Access Levels',
    ],

    'search'  => [
        'title'             => 'Showing Search Results',
        'found-footer'      => ' Record(s) found',
        'no-results'        => 'No Results',
        'search-orders-ph'   => 'Search Orders',
    ],

    'modals' => [
        'delete_order_message' => 'Are you sure you want to delete :order?',
    ],
];
