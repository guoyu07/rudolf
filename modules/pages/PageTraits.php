<?php
/**
 * This file is part of pages Rudolf module.
 * 
 * Page traits
 * 
 * @author Mikołaj Pich <m.pich@outlook.com>
 * @package Rudolf\Modules\pages
 * @version 0.1
 */

namespace Rudolf\Modules\pages;

trait PageTraits {

	public function title() {
		return $this->page['title'];
	}

	public function author() {
		return $this->page['author'];
	}

	public function date() {
		return $this->page['date'];
	}

	public function views() {
		return $this->page['views'];
	}

	public function content() {
		return $this->page['content'];
	}
}
