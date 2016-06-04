<?php
namespace Rudolf\Modules\Albums\Roll;

use Rudolf\Component\Helpers\Pagination\Calc as Pagination;
use Rudolf\Component\Helpers\Pagination\Loop;
use Rudolf\Component\Modules\Module;
use Rudolf\Modules\A_front\FView;

class View extends FView
{
    public function rollView($data, $pagination)
    {
        $module = new Module('albums');
        $config = $module->getConfig();

        $this->loop = new Loop($data, $pagination,
        	'Rudolf\\Modules\\Albums\\One\\Album',
        	$config['path']
        );

        $this->template = 'albums';
    }
}
