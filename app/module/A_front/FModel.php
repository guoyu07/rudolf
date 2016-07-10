<?php
namespace Rudolf\Modules\A_front;

use Rudolf\Framework\Model\BaseModel;

class FModel extends BaseModel
{
    public function getMenuItems()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->prefix}menu");
        $stmt->execute();
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        return $results;
    }

    public function getMenuTypes()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->prefix}menu_types");
        $stmt->execute();
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $results;
    }
}
 