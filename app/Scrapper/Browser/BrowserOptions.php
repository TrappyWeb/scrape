<?php

namespace App\Scrapper\Browser;

use App\Traits\Create;

class BrowserOptions
{
    use Create;

    public function options(): array
    {
        return [
            'userAgent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36',
            'noSandbox' => true,
            'disableGpu' => true,
            'headless' => true
        ];
    }
}
