<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel-orders setting
    |--------------------------------------------------------------------------
    */

    // Orders List Pagination
    'enablePagination'              => true,
    'paginateListSize'              => env('USER_LIST_PAGINATION_SIZE', 25),

    // Enable Search Orders- Uses jQuery Ajax
    'enableSearchOrders'             => true,

    // Orders List JS DataTables - not recommended use with pagination
    'enabledDatatablesJs'           => false,
    'datatablesJsStartCount'        => 25,
    'datatablesCssCDN'              => 'https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css',
    'datatablesJsCDN'               => 'https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js',
    'datatablesJsPresetCDN'         => 'https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js',

    // Bootstrap Tooltips
    'tooltipsEnabled'               => true,
    'enableBootstrapPopperJsCdn'    => true,
    'bootstrapPopperJsCdn'          => 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js',

];
