<?php

namespace Rudolf\Modules\Albums\Category\One\Admin;

use Rudolf\Framework\View\AdminView;

class AddView extends AdminView
{
    public function add($category)
    {
        $this->category = new Category($category);

        $this->pageTitle = _('Add category');
        $this->head->setTitle($this->pageTitle);

        $this->path = DIR.'/admin/albums/categories/add';

        $this->templateType = 'add';

        $this->template = 'category-one';
    }
}
