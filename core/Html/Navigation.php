<?php
/**
 * This file is part of Rudolf.
 *
 * Navigation.
 *
 * @author Mikołaj Pich <m.pich@outlook.com>
 * @package Rudolf\Html
 * @version 0.1
 */

namespace Rudolf\Html;

class Navigation {

	/**
	 * It create page navigation
	 * 
	 * @param array $items Array of navigation items
	 * @param int $current Id of current page
	 * @param array $classes
	 * @param int $nesting
	 * 
	 * @return string
	 */
	public function createPageNavigation($type, $items, $current, $classes, $nesting = 0) {
		$builder = new \Rudolf\Libs\MenuBuilder();
		foreach ($items as $key => $value) {
			if($type === $value['menu_type']) {
				$newItems[] = $items[$key];
			}
		}

		return $builder->getMenuHtml(0, $newItems, DIR.'/', $classes, $current, $nesting);
	}

	/**
	 * It create breadcrumb
	 *
	 * @param boolean $a create breadcrumb or only return array with breadrumb data
	 * @param array $menu array with menu elements
	 * @param array $address Address array
	 * @param int $nesting
	 *
	 * @return array|string
	 */
	public function createBreadcrumbsNavigation($a, $menu, $address, $nesting = 0) {
		$url = null;

		for($pid = 0, $i = 0; $i < count($address); $i++) {
			if($pid == $menu[$address[$i]]['parent_id']) {
				$array[$i] = array($url . '/' . $address[$i], $menu[$address[$i]]['title']);
				$pid = $menu[$address[$i]]['id'];
				$url .= '/' . $address[$i];
			}
		}

		if($a) {
			return $array;
		} elseif(!$a) {
			$html[] = '<li><a href="' . DIR . '">Start</a></li>';

			$tab = str_repeat("\t", $nesting);

			for($i = 0; $i < (count($array) - 1); $i++) {
				$html[] = sprintf('%1$s<li><a href="%2$s">%3$s</a></li>',
					$tab, // nesting
					DIR . $array[$i][0],
					$array[$i][1]
				);
			}

			$html[] = sprintf('%1$s<li class="active">%2$s</li>',
				$tab, // nesting
				$array[$i][1]
			);
			
			return implode("\r\n", $html);
		}
	}

	/**
	 * It created paging navigation
	 *
	 * @param array $nav with data for loop
	 * 		<page> - current page
	 * 		<forstart> - 
	 * 		<forend> - 
	 * 		<allpages> - 
	 * 		<prev> - 
	 * 		<next> - 
	 * 
	 * @param string $path path with a slash at the beginning and at the end without him, like: '/kg'
	 * @param array $classes specifies a pagination appearance
	 * @param int $nesting
	 * 
	 * @return string
	 */
	public function createPagingNavigation($nav, $path = null, $classes = null, $nesting = 0) {
		$html[] = sprintf('<ul%1$s>', ($classes['ul']) ? ' class="' . $classes['ul'].'"' : '');
		if(!isset($classes['current'])) {
			$classes['current'] = 'current';
		}

		$nest = str_repeat("\t", $nesting);
		$tab = str_repeat("\t", 1 + $nesting);

		if($nav['page'] > 1) {
			$html[] = sprintf('%1$s<li><a href="%2$s">«</a></li>', $tab, DIR . $path.'/page/' . $nav['prev']);
		}
		if ($nav['forstart'] > 1) {
			$html[] = sprintf('%1$s<li><a href="%2$s">1</a></li>', $tab, DIR . $path);
		}
		if ($nav['forstart'] > 2) {
			$html[] = sprintf('%1$s<li><a>...</a></li>', $tab);
		}
		for($nav['forstart']; $nav['forstart'] < $nav['forend']; $nav['forstart']++) {
			if($nav['forstart'] == $nav['page']) {
				$html[] = sprintf(
					'%1$s<li class="%2$s"><a href="%3$s">%4$s</a></li>', 
					$tab, 
					$classes['current'],
					DIR . $path . '/page/' . $nav['forstart'],
					$nav['forstart']
				);
			}
			if($nav['forstart'] != $nav['page']) {
				$html[] = sprintf(
					'%1$s<li><a href="%2$s">%3$s</a></li>', 
					$tab, 
					DIR . $path . '/page/' . $nav['forstart'],
					$nav['forstart']
				);
			}
		}
		if($nav['forstart'] < $nav['allpages']) {
			$html[] = sprintf('%1$s<li><a>...</a></li>', $tab);
		}
		if($nav['forstart'] - 1 < $nav['allpages']) {
			$html[] = sprintf(
				'%1$s<li><a href="%2$s">%3$s</a></li>',
				$tab,
				DIR . $path . '/page/' . $nav['allpages'],
				$nav['allpages']
			);
		}
		if($nav['page'] < $nav['allpages']) {
			$html[] = sprintf(
				'%1$s<li><a href="%2$s">»</a></li>',
				$tab,
				DIR . $path . '/page/' . $nav['next']
			); 
		}
		$html[] = $nest . '</ul>'."\n";
		
		return implode("\r\n", $html);
	}
}