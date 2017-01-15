<?php

namespace Rudolf\Framework\Controller;

use Rudolf\Framework\Model\AdminModel;
use Rudolf\Framework\View\AdminView;

class AdminController extends BaseController
{
    public function init()
    {
        $model = new AdminModel();
        $this->auth = $model->getAuth();

        // if not logged in
        if (!$this->auth->check()) {
            $this->redirect(DIR.'/user/login');
        }

        AdminView::setUserInfo($this->auth->getUser());
        AdminView::setAdminData($model->getMenuItems(), $this->request);
    }
}
