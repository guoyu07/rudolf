<?php
/**
 * This file is part of Rudolf articles module.
 * 
 * This is the model of articles module.
 * 
 * @author Mikołaj Pich <m.pich@outlook.com>
 * @package Rudolf\Modules\Articles\Roll
 * @version 0.1
 */
 
namespace Rudolf\Modules\Articles\Roll;
use Rudolf\Modules\A_front\FView,
	Rudolf\Modules\Articles\Traits,
	Rudolf\Libs\Pagination,
	Rudolf\Html\Navigation;

class View extends FView {
	use Traits;

	public $path;

	private $current = -1;

	public function setData($data, Pagination $pagination) {
		$this->data = $data;

		$this->pagination = $pagination;

		$this->template = 'index';
	}

	/**
	 * Chech, is any articles to display
	 * 
	 * @return bool
	 */
	public function isArticles() {
		return is_array($this->data);
	}

	/**
	 * Returns number of article to display on page
	 * 
	 * @return int
	 */
	public function total() {
		return count($this->data);
	}

	/**
	 * Whether there are more posts available in the loop
	 *
	 * @return bool
	 */
	public function haveArticles() {
		if ($this->current + 1 < $this->total()) {
			return true;
		}
		return false;
	}

	/**
	 * Set the current article
	 *
	 * @return void
	 */
	public function article() {
		$this->current += 1;
		$this->article = $this->data[$this->current];
	}

	/**
	 * Return navigation
	 * 
	 * @param array $classes
	 * 		ul
	 * 		current
	 * @param int $navNumber
	 * 
	 * @return string
	 */
	public function nav($classes, $nesting = 2) {
		$nav = new Navigation();
		$calculations = $this->pagination->nav();
		
		return $nav->createPagingNavigation($calculations, $this->path, $classes, $nesting);
	}

	/**
	 * Checks if pagination is needed
	 * 
	 * @return bool
	 */
	public function isPagination() {
		return 1 < $this->pagination->getAllPages();
	}
}