<?php

namespace Jackal\Downloader\Ext\Facebook\Downloader;

use GuzzleHttp\Client;
use Jackal\Downloader\Downloader\AbstractDownloader;
use Jackal\Downloader\Ext\Facebook\Crawler\FacebookCrawler;

class FacebookDownloader extends AbstractDownloader
{
    protected $downloadLinks = [];

    /**
     * @return array
     * @throws \Jackal\Downloader\Ext\Facebook\Exception\FacebookDownloadException
     */
    protected function getDownloadLinks() : array{
        if($this->downloadLinks == []){
            $client = new Client([
                'base_uri' => 'https://fbdown.net/it/',
            ]);

            $response = $client->post('download.php', [
                'form_params' => ['URLz' => 'https://www.facebook.com/watch/?v=' . $this->getVideoId()],
            ]);

            $crawler = new FacebookCrawler($response->getBody()->getContents());
            $this->downloadLinks = $crawler->getFacebookURLs($this->getFormats());
        }

        return $this->downloadLinks;
    }

    /**
     * @return string
     * @throws \Jackal\Downloader\Exception\DownloadException
     */
    public function getURL(): string
    {
        $results = $this->filterByFormats($this->getDownloadLinks());
        return array_key_exists('hd', $results) ? $results['hd'] : $results['sd'];
    }

    /**
     * @return array
     * @throws \Jackal\Downloader\Ext\Facebook\Exception\FacebookDownloadException
     */
    public function getFormatsAvailable(): array
    {
        return array_keys($this->getDownloadLinks());
    }

    public static function getPublicUrlRegex(): string
    {
        return '/facebook\.com\/(?:.*)(?:videos?|watch)(?:.*)(?:%2F|\/|v=)([\d]+)/i';
    }

    public static function getType(): string
    {
        return 'facebook';
    }
}