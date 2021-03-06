<?php

namespace Rudolf\Modules\Appearance\Editor;

use Rudolf\Framework\View\AdminView;

class EditorView extends AdminView
{
    /**
     * @var array
     */
    protected $filesList;

    /**
     * @var array
     */
    protected $file;

    /**
     * @param array $filesList
     * @param array $file
     */
    public function editor(array $filesList, array $file)
    {
        $this->pageTitle = _('Theme editor');
        $this->head->setTitle($this->pageTitle);

        $this->filesList = $filesList;

        $this->file = $file;

        $this->template = 'appearance-editor';
    }
}
