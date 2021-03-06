<?php

namespace Rudolf\Modules\Articles\Category\One\Admin;

use Rudolf\Component\Http\HttpErrorException;
use Rudolf\Framework\Controller\AdminController;
use Rudolf\Modules\Categories\One\Admin\DelForm;
use Rudolf\Modules\Categories\One\Admin\DelModel;
use Rudolf\Modules\Categories\One\Model as OneModel;

class DelController extends AdminController
{
    /**
     * @param $id
     *
     * @throws HttpErrorException
     * @throws \Exception
     */
    public function del($id)
    {
        // if data was send
        if (isset($_POST['delete'])) {
            $form = new DelForm();
            $form->handle(['id' => $id]);
            $form->setModel(new DelModel());

            if ($form->isValid()) {
                $form->delete();
                $this->redirect(DIR.'/admin/articles/categories');
            }

            $form->displayAlerts();
        }

        $category = (new OneModel())->getCategoryInfoById($id);

        if (!$category) {
            throw new HttpErrorException('Category not found', 404);
        }

        $view = new DelView();
        $view->delCategory($category);
        $view->render('admin');
    }
}
