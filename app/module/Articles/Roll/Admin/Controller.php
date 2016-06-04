<?php
namespace Rudolf\Modules\Articles\Roll\Admin;

use Rudolf\Modules\A_admin\AdminController;
use Rudolf\Modules\Articles\Roll;
use Rudolf\Component\Libs\Pagination;

class Controller extends AdminController
{
    public function getList($page)
    {
        $page = $this->firstPageRedirect($page, 301, $location = '../../list');

        $list = new Roll\Model();
        
        $pagination = new Pagination($list->getTotalNumber('1=1'), $page);
        $results = $list->getList($pagination);

        $view = new View();

        $view->setData($results, $pagination);

        $view->setActive(['admin/articles', 'admin/articles/list']);

        $view->render('admin');
    }
}
