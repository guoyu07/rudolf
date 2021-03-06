<?php

namespace Rudolf\Modules\Albums\Category\One\Admin;

use Rudolf\Framework\Controller\AdminController;
use Rudolf\Modules\Categories\One\Admin\AddForm;
use Rudolf\Modules\Categories\One\Admin\AddModel;

class AddController extends AdminController
{
    /**
     * @throws \Exception
     */
    public function add()
    {
        $form = new AddForm();
        $form->setModel(new AddModel());
        $form->setType('albums');

        // if data was send
        if (isset($_POST['add'])) {
            $form->handle($_POST);

            if ($form->isValid()) {
                $id = $form->save();
                $this->redirect(DIR.'/admin/albums/categories/edit/'.$id);
            }

            $form->displayAlerts();
        }

        $view = new AddView();
        $view->add($form->getDataToDisplay());
        $view->render('admin');
    }
}
