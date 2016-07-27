<?php

namespace Rudolf\Modules\Articles\One\Admin;

use Rudolf\Framework\View\AdminView;
use Rudolf\Modules\Categories\CategoryAddon;

class EditView extends AdminView
{
    use CategoryAddon;

    /**
     * Set data to edit article.
     * 
     * @param array $article
     */
    public function editArticle($article)
    {
        $this->article = new Article($article);

        $this->pageTitle = _('Edit article');
        $this->head->setTitle($this->pageTitle);

        $this->path = $this->article->editUrl();

        $this->templateType = 'edit';

        $this->template = 'articles-one';
    }
}
