<?php

namespace Jackal\Downloader\Ext\Facebook\Exception;

use Jackal\Downloader\Exception\DownloadException;

class FacebookDownloadException extends DownloadException
{
    public static function videoURLsNotFound() : FacebookDownloadException
    {
        return new FacebookDownloadException('No video URLs found');
    }

    public static function formatNotFound(array $selectedFormats, array $available) : FacebookDownloadException
    {
        return new FacebookDownloadException(sprintf(
            'Format%s %s is not available. [Available formats are: %s]',
            count($selectedFormats) == 1 ? '' : 's',
            implode(', ', $selectedFormats),
            implode(', ', array_keys($available))
        ));
    }
}