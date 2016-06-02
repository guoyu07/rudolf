<?php
namespace Rudolf\Modules\Categories\One;

use Rudolf\Component\Abstracts\AModel;
use Rudolf\Component\Libs\Pagination;

class Model extends AModel {

    /**
     * Get category info
     * 
     * @param string $slug
     * 
     * @return array
     */
    public function getCategoryInfo($slug, $type)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->prefix}categories WHERE slug = :slug and type = :type");
        $stmt->bindValue(':slug', $slug, \PDO::PARAM_INT);
        $stmt->bindValue(':type', $type, \PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (empty($results[0])) {
            return false;
        }

        return $results[0];
    }
}