<?php

namespace Rudolf\Modules\Albums\One\Admin;

use Rudolf\Modules\Albums\One;

class Album extends One\Album
{
    public function editUrl()
    {
        return DIR.'/admin/albums/edit/'.$this->id();
    }

    public function delUrl()
    {
        return DIR.'/admin/albums/del/'.$this->id();
    }

    /**
     * Get content for textarea.
     */
    public function textarea()
    {
        return $this->content(false, false, false, true);
    }

    public function addCategory()
    {
        return DIR.'/admin/albums/categories/add';
    }
}
