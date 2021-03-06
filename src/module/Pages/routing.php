<?php

use Rudolf\Component\Routing\Route;

$collection->add('pages', new Route(
    '<page>',
    'Rudolf\Modules\Pages\One\Controller::page',
    array(
        'page' => "[a-z0-9-\/]*(/)?$",
    ),
    [],
    2000
));

# admin
############################

// list
$collection->add('pages/admin', new Route(
    'admin/pages([\/])?',
    'Rudolf\Modules\Pages\Roll\Admin\Controller::redirectTo',
    [],
    ['target' => DIR.'/admin/pages/list']
));
$collection->add('pages/roll/admin', new Route(
    'admin/pages/list(/page/<page>)?',
    'Rudolf\Modules\Pages\Roll\Admin\Controller::getList',
    ['page' => '[1-9][0-9]*$'],
    ['page' => 0]
));

// page
$collection->add('pages/one/admin/edit', new Route(
    'admin/pages/edit/<id>$',
    'Rudolf\Modules\Pages\One\Admin\EditController::edit',
    ['id' => '[1-9][0-9]*']
));
$collection->add('pages/one/admin/del', new Route(
    'admin/pages/del/<id>$',
    'Rudolf\Modules\Pages\One\Admin\DelController::del',
    ['id' => '[1-9][0-9]*']
));
$collection->add('pages/one/admin/add', new Route(
    'admin/pages/add$',
    'Rudolf\Modules\Pages\One\Admin\AddController::add'
));
