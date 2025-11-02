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

try {
    $browser = CreateBrowser::create();

    $uri = $_GET['uri'];

    $page = $browser
        ->browser()
        ->createPage();
    $page
        ->navigate($uri)
        ->waitForNavigation(Page::DOM_CONTENT_LOADED);
    $content = $page->getHtml();
    $browser->browser()->close();

    exit($content);
} catch (RuntimeException $e) {
    throw $e;
} catch (Exception $e) {
    exit($e->getMessage());
}