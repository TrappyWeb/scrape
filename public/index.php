<?php

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/

require __DIR__.'/../vendor/autoload.php';

use App\Scrapper\Browser\CreateBrowser;
use HeadlessChromium\Page;

const TOKEN = 'b0f2d07a-f50b-40eb-8d4b-44561b68287d';

function error(string $error): never
{
    header('Content-Type: application/json');
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    http_response_code(404);
    exit(json_encode(['error' => $error]));
}

$url = $_GET['url'];
$token = $_GET['token'] ?? false;
$timeout = $_GET['timeout'] ?? 30;

if ($token !== TOKEN) {
    error('Authentication token not provided.');
}

try {
    $browser = CreateBrowser::create();

    $page = $browser
        ->browser()
        ->createPage();
    $page
        ->navigate($url)
        ->waitForNavigation(Page::DOM_CONTENT_LOADED);
    $content = $page->getHtml();
    $browser->browser()->close();

    exit($content);
} catch (RuntimeException $e) {
    error($e->getMessage());
} catch (Exception $e) {
    error($e->getMessage());
}