# VideoDownloaderFacebookExtension

## Installation
```
composer require jackal/video-downloader-ext-Facebook
```

## Usage
```
use Jackal\Downloader\Ext\Facebook\Downloader\FacebookDownloader;

require_once __DIR__ . '/vendor/autoload.php';

$facebookVideoId = '624784478047637';

$vd = new \Jackal\Downloader\VideoDownloader();
$vd->registerDownloader(FacebookDownloader::VIDEO_TYPE, FacebookDownloader::class);

$downloader = $vd->getDownloader(FacebookDownloader::VIDEO_TYPE, $facebookVideoId, [
    'format' => ['hd'],
]);

$downloader->download(__DIR__ . '/output.avi');
```
