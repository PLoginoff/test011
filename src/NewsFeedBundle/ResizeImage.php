<?php

namespace NewsFeedBundle;

use Eventviva\ImageResize;

class ResizeImage
{
    protected $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    public function resize($width = 100, $height = 100)
    {
        $image = new ImageResize($this->filename);
        $image->resizeToWidth($width);
        $image->crop($width, $height);
        return $image->save($this->filename);
    }
}