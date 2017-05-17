<?php

namespace NewsFeedBundle\Tests;

use NewsFeedBundle\ResizeImage;

class ResizeImageTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider getTestData
     */
    public function testResize($data)
    {
        $orignal = __DIR__.'/fixtures/'.$data['file'];
        $test    = __DIR__.'/fixtures/image-try.jpg';

        \copy($orignal, $test);

        $resizer = new ResizeImage($test);
        $resizer->resize($data['width'], $data['height']);

        $info = getimagesize($test);
        
        $this->assertEquals($data['width'], $info[0]);
        $this->assertEquals($data['height'], $info[1]);

        \unlink($test);
    }

    public function getTestData()
    {
        return [
            [
                'data' => [
                    'file' => 'image.jpg',
                    'width'  => 100,
                    'height' => 100
                ],
            ],
            [
                'data' => [
                    'file' => 'image.jpg',
                    'width'  => 200,
                    'height' => 100
                ],
            ],
        ];
    }
}
