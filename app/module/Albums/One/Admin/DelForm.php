<?php

namespace Rudolf\Modules\Albums\One\Admin;

use Rudolf\Component\Forms\Form;

class DelForm extends Form
{
    /**
     * @var DelModel
     */
    protected $model;

    public function setModel(DelModel $model)
    {
        $this->model = $model;
    }

    public function check()
    {
        $this->validator
            ->checkIsInt('id', $this->data['id'], [
                'not_int' => _('Album ID is not valid'),
            ]);

        $this->id = $this->data['id'];
    }

    public function delete()
    {
        $this->model->delete($this->id);
    }
}
