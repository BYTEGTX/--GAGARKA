<?php

return array(
    'storage/log' => 'user/storageLog',
    'api/addItemPoint'=>'user/addItemPoint',
    'api/addItemStorage'=>'user/addItemStorage',
    'api/delItemStorage'=>'user/delItemStorage',
    'api/edititem' => 'user/editItem',
    'api/csv'=>'user/CSV',
    'orders'=>'user/orders',
    'staff'=>'user/staff',
    'storage'=>'user/storage',
    'api/addorder' => 'user/ApiOrder',
    'api/delorder' => 'user/delOrder',
    'api/settype' => 'user/settype',
    'api/login' => 'user/ApiLogin',
    'login'=>'user/login',
    'login?'=>'user/login',
    'logout'=>'user/logout',
    'u/([0-9a-z_]+)' => 'user/user/$1',
    '' => 'user/index'
);