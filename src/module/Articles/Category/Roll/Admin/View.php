<?php

namespace Rudolf\Modules\Articles\Category\Roll\Admin;

use Rudolf\Component\Helpers\Pagination\Calc as Pagination;
use Rudolf\Component\Helpers\Pagination\Loop;
use Rudolf\Framework\View\AdminView;
use Rudolf\Modules\Articles\Category\One\Admin\Category;

class View extends AdminView
{
    /**
     * @var Loop
     */
    protected $loop;

    /**
     * @param array $data
     * @param Pagination $pagination
     */
    public function setData(array $data, Pagination $pagination)
    {
        $this->loop = new Loop(
            $data,
            $pagination,
            Category::class,
            '/admin/articles\\categories/list'
        );

        $this->pageTitle = _('Category list');

        $this->head->setTitle($this->pageTitle);

        $this->template = 'categories-list';
    }
}
