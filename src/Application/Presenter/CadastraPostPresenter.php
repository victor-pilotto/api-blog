<?php

namespace App\Application\Presenter;

use App\Domain\Entity\Post;

class CadastraPostPresenter
{
    public static function format(Post $post): array
    {
        $arrPost = $post->jsonSerialize();
        $arrPost['userId'] = $post->user()->id()->value();
        unset($arrPost['id'], $arrPost['published'], $arrPost['updated'], $arrPost['user']);

        return $arrPost;
    }
}