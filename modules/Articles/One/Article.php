<?php
/**
 * This file is part of Rudolf articles module.
 * 
 * Article
 * 
 * @author Mikołaj Pich <m.pich@outlook.com>
 * @package Rudolf\Modules\Articles\One
 * @version 0.1
 */

namespace Rudolf\Modules\Articles\One;
use Rudolf\Hooks\Hooks,
	Rudolf\Html\Text,
	Rudolf\Images\Image;

class Article {

	/**
	 * @var array Article data
	 */
	protected $article;

	/**
	 * Constructor
	 * 
	 * @param array $article
	 */
	public function __construct($article = array()) {
		$this->setData($article);
	}

	/**
	 * Set article data
	 * 
	 * @param array $article
	 */
	public function setData($article) {
		$this->article = array_merge(
			[
				'id' => 0,
				'category_ID' => 0,
				'title' => '',
				'keywords' => '',
				'description' => '',
				'content' => '',
				'author' => '',
				'author' => '',
				'date' => '',
				'added' => '',
				'modified' => '',
				'adder_ID' => 0,
				'adder_first_name' => '',
				'adder_surname' => '',
				'modifier_ID' => 0,
				'modifier_first_name' => '',
				'modifier_surname' => '',
				'views' => 0,
				'slug' => '',
				'url' => '',
				'album' => '',
				'thumb' => '',
				'thumbnail' => '',
				'photos' => '',
				'published' => false,
				'category' => '',
				'category_title' => '',
				'category_url' => '',
			],
			(array) $article
		);
	}

	/**
	 * Returns article ID
	 * 
	 * @return int
	 */
	public function id() {
		return (int) $this->article['id'];
	}

	/**
	 * Returns category ID
	 * 
	 * @return int
	 */
	public function categoryID() {
		return (int) $this->article['category_ID'];
	}

	/**
	 * Returns article title
	 * 
	 * @param string $type null|raw
	 * 
	 * @return string
	 */
	public function title($type = '') {
		$title = $this->article['title'];
		if('raw' === $type) {
			return $title;
		}

		return Text::escape($title);
	}

	/**
	 * Returns the keywords
	 * 
	 * @param string $type null|raw
	 * 
	 * @return string
	 */
	public function keywords($type = '') {
		$keywords = $this->article['keywords'];
		if('raw' === $type) {
			return $keywords;
		}

		return Text::escape($keywords);
	}

	/**
	 * Returns the description
	 * 
	 * @param string $type
	 * 
	 * @return string
	 */
	public function description($type = '') {
		$description = $this->article['description'];
		if('raw' === $type) {
			return $description;
		}

		return Text::escape($description);
	}

	/**
	 * Returns article content
	 * 
	 * @param bool|int $truncate
	 * @param bool $stripTags
	 * @param bool $escape
	 * 
	 * @return string
	 */
	public function content($truncate = false, $stripTags = false, $escape = false) {
		$content = $this->article['content'];

		if(true === $stripTags) {
			$content = strip_tags($content);
		}

		if(false !== $truncate and strlen($content) > $truncate) {
			$content = Text::truncate($content, $truncate);
		}

		if(true === $escape) {
			$content = Text::escape($content);
		}

		return $content;
	}

	/**
	 * Returns the author
	 * 
	 * @param bool $adder Returns adder name if fields empty
	 * 
	 * @return string
	 */
	public function author($adder = true) {
		$author = $this->article['author'];

		// if fields is empty and $adder is true
		if(empty($author) and true === $adder) {
			$author = $this->adderFullName(false);
		}

		return Text::escape($author);
	}

	/**
	 * Returns article date
	 * 
	 * @param bool|string $format
	 * @param string $style normal|locale
	 * 
	 * @return string If date field empty, return current date
	 */
	public function date($format = false, $style = 'normal', $inflected = true) {
		$date = $this->article['date'];

		if(empty($date)) {
			$date = date('Y-m-d H:i:s');
		}

		switch ($style) {
			case 'locale': // http://php.net/manual/en/function.strftime.php
				$format = ($format) ? $format : '%D';
				$date = strftime($format, strtotime($date));
				break;
			
			default: // http://php.net/manual/en/datetime.formats.date.php
				$format = ($format) ? $format : 'Y-m-d H:i:s';
				$date = date_format(date_create($date), $format);
				break;
		}
		
		$date = Hooks::apply_filters('date_format_filter', $date);

		if(true === $inflected) {
			$month = [
				'styczeń' => 'stycznia', // 01
				'luty' => 'lutego', // 02
				'marzec' => 'marca', // 03
				'kwiecień' => 'kwietnia', // 04
				'maj' => 'maja', // 05
				'czerwiec' => 'czerwca', // 06
				'lipiec' => 'lipca', // 07
				'sierpień' => 'sierpnia', // 08
				'wrzesień' => 'września', // 09
				'październik' => 'października', // 10
				'listopad' => 'listopada', // 11
				'grudzień' => 'grudnia' // 12
			];

			foreach ($month as $key => $value) {
				$date = str_replace($key, $value, $date);
			}
		}

		return $date;
	}

	/**
	 * Returns date of article added
	 * 
	 * @return string
	 */
	public function added() {
		return $this->article['added'];
	}

	/**
	 * Returns date of last article modified
	 * 
	 * @return string
	 */
	public function modified() {
		return $this->article['modified'];
	}

	/**
	 * Returns adder ID
	 * 
	 * @return int
	 */
	public function adderID() {
		return (int) $this->article['adder_ID'];
	}

	/**
	 * Returns first name and surname of adder
	 * 
	 * @param string $type
	 * 
	 * @return string
	 */
	public function adderFullName($type = '') {
		$name = trim($this->article['adder_first_name'] . ' ' . $this->article['adder_surname']);
		if('raw' === $type) {
			return $name;
		}

		return Text::escape($name);
	}

	/**
	 * Returns modifier ID
	 * 
	 * @return int
	 */
	public function modifierID() {
		return (int) $this->article['modifier_ID'];
	}

	/**
	 * Returns modifier full name
	 * 
	 * @return int
	 */
	public function modifierFullName($type = '') {
		$name = $this->article['modifier_first_name'] . ' ' . $this->article['modifier_surname'];
		if('raw' === $type) {
			return $name;
		}

		return Text::escape($name);
	}

	/**
	 * Checks whether the article has modified
	 * 
	 * @return bool
	 */
	public function isModified() {
		return (bool) $this->article['modified'];
	}

	/**
	 * Returns the number of views
	 * 
	 * @return int
	 */
	public function views() {
		return (int) $this->article['views'];
	}

	/**
	 * Returns article slug
	 * 
	 * @return string
	 */
	public function slug() {
		return $this->article['slug'];
	}

	/**
	 * Returns article url
	 * 
	 * @return string
	 */
	public function url() {
		return sprintf('%1$s/%2$s/%3$s/%4$s/%5$s',
			DIR,
			'artykuly',
			$this->date('Y'),
			$this->date('m'),
			$this->article['slug']
		);
	}

	/**
	 * Returns album path
	 * 
	 * @return string
	 */
	public function album() {
		return Text::escape($this->article['album']);
	}

	/**
	 * Returns thumb path
	 * 
	 * @return string
	 */
	public function thumb() {
		return Text::escape($this->article['thumb']);
	}

	/**
	 * Checks whether the article has a thumbnail
	 * 
	 * @return bool
	 */
	public function hasThumbnail() {
		return (bool) $this->article['thumb'];
	}

	/**
	 * Returns thumbnail code or only address
	 * 
	 * @param int $width Image width
	 * @param int $height Image height
	 * @param bool $album Add album address if exists
	 * @param string $alt Set alternative text
	 * @param string $default Default thumb path. It use when thumb path is empty
	 * 
	 * @return string
	 */
	public function thumbnail($width = 100, $height = 100, $album = false, $alt = '', $default = '') {
		$path = $this->thumb();
		$alt = ($alt) ? $alt : $this->title('raw');

		if(!$this->hasThumbnail()) {
			if(!empty($default)) {
				$path = $default;
			} else {
				return false;
			}
		}

		$path = Image::resize($path, $width, $height);

		$image = sprintf('<img src="%1$s" alt="%4$s" width="%2$s" height="%3$s"/>',
			$path, $width, $height, $alt
		);

		if(true === $album and !empty($this->album())) {
			$album = $this->album();
			$image = sprintf('<a href="%1$s">%2$s</a>', $album, $image);
		}

		return $image;
	}

	/**
	 * Returns the number of photos
	 * 
	 * @return int
	 */
	public function photos() {
		return (int) $this->article['photos'];
	}

	/**
	 * Checks whether the article has a photos
	 * 
	 * @return bool
	 */
	public function hasPhotos() {
		return (bool) $this->article['photos'];
	}

	/**
	 * Chcecks whether the article is published
	 * 
	 * @return bool
	 */
	public function isPublished() {
		return (bool) $this->article['published'];
	}

	/**
	 * Returns article category anchor
	 * 
	 * @return string
	 */
	public function category() {
		return sprintf('<a href="%1$s">%2$s</a>',
			$this->categoryUrl(),
			$this->categoryTitle()
		);
	}

	/**
	 * Returns category title
	 * 
	 * @param string $type
	 * 
	 * @return string
	 */
	public function categoryTitle($type = '') {
		$title = $this->article['category_title'];

		if('raw' === $type) {
			return $title;
		}

		return Text::escape($title);
	}

	/**
	 * Returns category url
	 * 
	 * @return string
	 */
	public function categoryUrl() {
		return sprintf('%1$s/%2$s/%3$s',
			DIR,
			'artykuly/kategorie',
			Text::escape($this->article['category_url'])
		);
	}

	/**
	 * Checks whether the article has a category
	 * 
	 * @return bool
	 */
	public function hasCategory() {
		return (bool) $this->article['category_url'];
	}
}