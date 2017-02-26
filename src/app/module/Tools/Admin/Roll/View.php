<?php

namespace Rudolf\Modules\Tools\Admin\Roll;

use Rudolf\Component\Helpers\Pagination\Calc as Pagination;
use Rudolf\Component\Helpers\Pagination\Loop;
use Rudolf\Framework\View\AdminView;

class View extends AdminView
{
    public function setData($data, Pagination $pagination)
    {
        $this->loop = new Loop(
            $data,
            $pagination,
            'Rudolf\\Modules\\Tools\\Admin\\One\\Tool',
            '/admin/plugins/list'
        );

        $this->pageTitle = _('Tools list');
        $this->head->setTitle($this->pageTitle);

        $this->template = 'tools-list';
    }
}