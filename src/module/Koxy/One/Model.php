<?php

namespace Rudolf\Modules\Koxy\One;

use Rudolf\Framework\Model\FrontModel;

class Model extends FrontModel
{
    private $extension = 'png';

    public function vote($type, $post)
    {
        $id = str_replace('.'.$this->extension, '', $post['id']);

        $file = UPLOADS_ROOT.'/moments-db/'.$id.'.txt';

        if (file_exists($file)) {
            $content = file_get_contents($file);
            $contentArray = explode(':', $content);
        } else {
            file_put_contents($file, '0:0');
            $contentArray = [0, 0];
        }

        $cookieName = 'vote_'.$id;
        if (!isset($_COOKIE[$cookieName])) {
            switch ($type) {
                case 'down':
                    $type = 'down';
                    ++$contentArray[1];
                    break;

                case 'up':
                    $type = 'up';
                    ++$contentArray[0];
                    break;

                default:
                    return ['coś się popsuło'];
                    break;
            }

            file_put_contents($file, implode(':', $contentArray));

            setcookie('vote_'.$id, $type, time() + (3600 * 24 * 365 * 5), DIR);
        }

        return [
            'up' => $contentArray[0],
            'down' => $contentArray[1],
        ];
    }
}
