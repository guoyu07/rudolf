<?php

namespace Rudolf\Modules\Appearance\Menu;

use Rudolf\Component\Alerts\Alert;
use Rudolf\Component\Alerts\AlertsCollection;
use Rudolf\Framework\Controller\AdminController;
use Rudolf\Framework\Model\FrontModel;

class AddController extends AdminController
{
    /**
     * @throws \Exception
     */
    public function add()
    {
        if (isset($_POST['add'])) {
            $model = new AddModel();
            $id = $model->add($_POST);
            if ($id) {
                AlertsCollection::add(new Alert(
                    'success',
                    'Poprawnie dodano!'
                ));
                $this->redirectTo(DIR.'/admin/appearance/menu/edit/'.$id);
                return;
            }
            AlertsCollection::add(new Alert(
                'error',
                'Coś się zepsuło!'
            ));
        }

        $view = new AddView();
        $view->display(new MenuItem([
            'id' => -1,
            'parent_id' => 0,
            'title' => '',
            'slug' => '',
            'caption' => '',
            'menu_type' => 'main',
            'item_type' => '',
            'position' => 0,
        ]), (new Model())->getTypes(), (new FrontModel())->getMenuItems());
        $view->render('admin');
    }
}
