<?php
namespace Rudolf\Modules\Articles\Roll;

use Rudolf\Component\Helpers\Pagination\Calc as Pagination;
use Rudolf\Component\Helpers\Pagination\Loop;
use Rudolf\Modules\A_front\FView;

class View extends FView
{
    public function rollView($data, Pagination $pagination)
    {
        $this->loop = new Loop($data, $pagination,
        	'Rudolf\\Modules\\Articles\\One\\Article'
        );

        $this->template = 'index';
    }
}
