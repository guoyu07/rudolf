<?php
/**
 * This file is part of Rudolf.
 *
 * Abstract view.
 *
 * @author Mikołaj Pich <m.pich@outlook.com>
 * @package Rudolf\Component\Abstracts
 * @version 0.1
 */

namespace Rudolf\Component\Abstracts;
use Rudolf\Component\Html\Head,
	Rudolf\Component\Html\Exceptions\ThemeNotFoundException,
	Rudolf\Component\Html\Exceptions\TemplateNotFoundException;

abstract class AView {

	/**
	 * @var string Server-side path to theme catalog
	 */
	public $themePath;

	/**
	 * @var string 
	 */
	public $themeRoot;

	/**
	 * @var string
	 */
	public $themeName;

	/**
	 * @var string
	 */
	public $side;

	/**
	 * @var object
	 */
	public $theme;

	/**
	 * Constructor
	 */
	public function __construct() {
		// create necessary objects
		$this->head = new Head();
	}

	/**
	 * Render page
	 * 
	 * @param string $side front|admin
	 * @param string $type html|json
	 * 
	 * @return void
	 */
	public function render($side = 'front', $type = 'html') {
		if('admin' === $side) {
			$this->side = 'admin';
			$this->themeName = ADMIN_THEME;
			$path = '/' . $this->side . '/' . $this->themeName;
		} else {
			$this->side = 'front';
			$this->themeName = FRONT_THEME;
			$path = '/' . $this->side . '/' . $this->themeName;
		}

		$this->themeRoot = THEMES_ROOT . $path;
		$this->themePath = THEMES . $path;

		$this->loadConfig();

		switch ($type) {
			case 'json':
				$this->renderJson();
				break;
			
			default:
				$this->renderHtml();
				break;
		}
	}

	/**
	 * Render page in html
	 * 
	 * @return void
	 */
	private function renderHtml() {
		$file = $this->themeRoot .'/templates/'. $this->template .'.html.php';
		
		if(!file_exists($this->themeRoot)) {
			throw new ThemeNotFoundException("Theme ". $this->themeName ." does not exist");
		} elseif(is_file($file)) {
			include $file;
		} else {
			throw new TemplateNotFoundException("Template file '{$this->template}' does not exist in ". $this->themeName);
		}
	}

	/**
	 * Render page in json
	 * 
	 * @return void
	 */
	private function renderJson() {
		header('Content-Type: application/json');
		echo json_encode($this->data);
	}
	
	/**
	 * Load theme config class
	 */
	private function loadConfig() {
		$file = $this->themeRoot . '/' . $this->themeName . '.php';
		
		if(is_file($file)) {
			include $file;
			$class = ucfirst($this->themeName);
			$this->theme = new $class($this);
		}
	}
}
