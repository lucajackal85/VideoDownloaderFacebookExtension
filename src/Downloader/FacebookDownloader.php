<?php

namespace Jackal\Downloader\Ext\Facebook\Downloader;

use GuzzleHttp\Client;
use Jackal\Downloader\Downloader\AbstractDownloader;
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

        $crawler = new Crawler($response->getBody()->getContents());

        $hd = $crawler->filter('#hdlink');
        $sd = $crawler->filter('#sdlink');
        $results = [
            'hd' => $hd->count() ? $hd->first()->attr('href') : null,
            'sd' => $sd->count() ? $sd->first()->attr('href') : null,
        ];

        if(!array_key_exists('hd', $results) and !array_key_exists('sd', $results)){
            throw FacebookDownloadException::videoURLsNotFound();
        }

        if($this->getFormats() != []) {
            foreach ($this->getFormats() as $selectedFormat) {
                if (array_key_exists($selectedFormat, $results)) {
                    return $results[$selectedFormat];
                }
            }

            throw FacebookDownloadException::formatNotFound($this->getFormats(), $results);
        }

        return array_key_exists('hd', $results) ? $results['hd'] : $results['sd'];
    }

    protected function getFormats() : array
    {
        if(!isset($this->options['format'])){
            return [];
        }

        if(!is_array($this->options['format'])){
            return [$this->options['format']];
        }

        return $this->options['format'];

    }
}