<?php
namespace Rudolf\Modules\Articles\Feed;

use Rudolf\Component\Feed;
use Rudolf\Component\Helpers\Pagination\Calc as Pagination;
use Rudolf\Component\Helpers\Pagination\Loop as Loop;
use Rudolf\Component\Modules\Module;
use Rudolf\Modules\A_front\FView;
use Rudolf\Modules\Articles\Roll\Roll;

class View extends FView
{
	public function setArticles($data, Pagination $pagination)
	{
		$this->data = $data;
		$this->pagination = $pagination;
	}

	public function rss2()
	{
		$module = new Module('articles');
		$config = $module->getConfig();

		$generator = new Feed\RSS2Generator();
		$generator->setTitle($config['feed_title']);
		$generator->setLink('http://zsrokietnica.project/feed/rss');
		$generator->setDescription($config['feed_description']);

		$loop = new Loop($this->data, $this->pagination,
			'Rudolf\\Modules\\Articles\\One\\Article'
		);

		while ($loop->haveItems()) { $article = $loop->item();
			$item = new Feed\RSS2Item();
			
			$item->setTitle($article->title());
			$item->setLink('http://zsrokietnica.project'. $article->url());
			$item->setDescription($article->content());
			$item->setAuthor($article->author());
			$item->setPubDate($article->date('D, d M Y H:i:s T'));
			$array[] = $item->getItem();
		}

		$generator->setItems($array);

		return $generator->generate();
	}

	public function atom()
	{
		
	}
}
