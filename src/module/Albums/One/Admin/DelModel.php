<?php

namespace Rudolf\Modules\Albums\One\Admin;

use Rudolf\Framework\Model\AdminModel;

class DelModel extends AdminModel
{
    /**
     * Delete article.
     *
     * @param int $id Article ID
     *
     * @return bool
     */
    public function delete($id)
    {
        $query = $this->pdo->prepare("DELETE FROM {$this->prefix}albums WHERE id = :id");
        $query->bindValue(':id', $id, \PDO::PARAM_INT);

        return $query->execute();
    }
}
