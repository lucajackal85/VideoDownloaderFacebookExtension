<?php

namespace Jackal\Downloader\Ext\Facebook\Tests\Downloader;

use Jackal\Downloader\Ext\Facebook\Downloader\FacebookDownloader;
use PHPUnit\Framework\TestCase;

class FacebookDownloaderTest extends TestCase
{
    public function getURLs(){
        return [
            ['https://www.facebook.com/video.php?v=100000000000000'],
            ['https://www.facebook.com/watch/?v=100000000000000'],
            ['https://www.facebook.com/username1/videos/100000000000000'],
            ['https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2FFerrari%2Fvideos%2F100000000000000%2F&show_text=0&width=560'],
        ];
    }

    /**
     * @dataProvider getURLs
     */
    public function testGetPublicUrlRegex($string){

        preg_match(FacebookDownloader::getPublicUrlRegex(), $string, $matches);

        $this->assertEquals(100000000000000, $matches[1]);

    }
}