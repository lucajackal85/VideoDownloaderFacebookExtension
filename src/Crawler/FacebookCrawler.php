<?php


namespace Jackal\Downloader\Ext\Facebook\Crawler;


use Jackal\Downloader\Ext\Facebook\Exception\FacebookDownloadException;
use Symfony\Component\DomCrawler\Crawler;

class FacebookCrawler extends Crawler
{
    public function getFacebookURLs(array $formats) : array {

        $hd = $this->filter('#hdlink');
        $sd = $this->filter('#sdlink');
        $results = [
            'hd' => $hd->count() ? $hd->first()->attr('href') : null,
            'sd' => $sd->count() ? $sd->first()->attr('href') : null,
        ];

        if(!isset($results['hd']) and !isset($results['sd'])){
            throw FacebookDownloadException::videoURLsNotFound();
        }

        return $results;
    }
}