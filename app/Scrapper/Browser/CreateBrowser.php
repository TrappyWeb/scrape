<?php

namespace App\Scrapper\Browser;

use App\Scrapper\Browser\BrowserOptions;
use App\Traits\Create;
use HeadlessChromium\Browser;
use HeadlessChromium\BrowserFactory;
use HeadlessChromium\Browser\ProcessAwareBrowser;

class CreateBrowser
{
    use Create;

    private Browser | ProcessAwareBrowser $browser;

    private function __construct()
    {
        $this->browser = $this->connectToBrowser();
    }

    private function connectToBrowser(): ProcessAwareBrowser
    {
        $browserFactory = new BrowserFactory();

        return $browserFactory->createBrowser(
            BrowserOptions::create()->options()
        );
    }

    /**
     * Get the browser instance.
     *
     * @return Browser|ProcessAwareBrowser The browser instance.
     */
    public function browser(): Browser | ProcessAwareBrowser
    {
        if ($this->browser->getConnection()->isConnected() === false) {
            $this->browser = $this->connectToBrowser();
        }

        return $this->browser;
    }
}
