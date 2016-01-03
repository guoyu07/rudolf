<?php
/**
 * This file is part of Rudolf articles module.
 * 
 * This is the model of articles module.
 * 
 * @author Mikołaj Pich <m.pich@outlook.com>
 * @package Rudolf\Modules\articles
 * @version 0.1
 */
 
namespace Rudolf\Modules\articles;
use Rudolf\Abstracts\View,
	Rudolf\Libs\Pagination,
	Rudolf\Html\Navigation;

class ArticlesListView extends View {
	use ArticleTraits;

	public $path;

	private $current = -1;

	public function setData($data, $paginationInfo) {
		$this->data = $data;

		$this->paginationInfo = $paginationInfo;

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
	public function nav($classes, $navNumber = false) {
		$navInfo = $this->paginationInfo;

		if(is_object($this->theme)) {
			$onPage = $this->theme->article['pagination']['onPage'];
			$navNumberTheme = $this->theme->article['pagination']['navNumber'];
		} else {
			$onPage = 10;
		}
		
		$navNumber = ($navNumber) ? $navNumber : $navNumberTheme;
		
		$nav = new Navigation();
		$pagination = new Pagination($navInfo['total'], $navInfo['page'], $onPage, $navNumber);

		return $nav->createPagingNavigation($pagination->nav(), $this->path, $classes, $nesting = 2);
	}
}
