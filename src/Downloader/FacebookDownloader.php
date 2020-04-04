<?php

namespace Jackal\Downloader\Ext\Facebook\Downloader;

use GuzzleHttp\Client;
use Jackal\Downloader\Downloader\AbstractDownloader;
use Jackal\Downloader\Ext\Facebook\Crawler\FacebookCrawler;
use Jackal\Downloader\Ext\Facebook\Exception\FacebookDownloadException;
use Symfony\Component\DomCrawler\Crawler;

class FacebookDownloader extends AbstractDownloader
{
    const VIDEO_TYPE = 'facebook';

    public function getURL(): string
    {
        $client = new Client([
            'base_uri' => 'https://fbdown.net/it/',
        ]);

        $response = $client->post('download.php', [
            'form_params' => ['URLz' => 'https://www.facebook.com/watch/?v=' . $this->getVideoId()],
        ]);

        $crawler = new FacebookCrawler($response->getBody()->getContents());

        $results = $crawler->getFacebookURLs($this->getFormats());

        $results = $this->filterByFormats($results);

        return array_key_exists('hd', $results) ? $results['hd'] : $results['sd'];

    }
}