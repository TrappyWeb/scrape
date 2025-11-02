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

use App\Http\AuthToken;
use App\Http\Response;
use App\Http\Status;
use App\Scrapper\Browser\CreateBrowser;
use HeadlessChromium\Page;

$url = $_GET['url'];

if (AuthToken::validate(array_key_exists('token', $_GET) ? $_GET['token'] : null) === false) {
    Response::json([
        'error' => 'Authentication token not provided.'
    ], Status::HTTP_UNAUTHORIZED);
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
    Response::json([
        'error' => $e->getMessage()
    ], Status::HTTP_UNAUTHORIZED);
} catch (Exception $e) {
    Response::json([
        'error' => $e->getMessage()
    ], Status::HTTP_UNAUTHORIZED);
}