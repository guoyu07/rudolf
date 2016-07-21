<?php

namespace Rudolf\Modules\Articles\Category\One\Admin;

use Rudolf\Framework\View\AdminView;

class View extends AdminView
{
    public function edit($category)
    {
        $this->category = new Category($category);

        $this->pageTitle = _('Edit category');
        $this->head->setTitle($this->pageTitle);

        $this->path = $this->category->editUrl();

        $this->templateType = 'edit';

        $this->template = 'category-one';
    }

    public function add($category)
    {
        $this->category = new Category($category);

        $this->pageTitle = _('Add category');
        $this->head->setTitle($this->pageTitle);

        $this->path = DIR.'/admin/articles/categories/add';

        $this->templateType = 'add';

        $this->template = 'category-one';
    }
}
