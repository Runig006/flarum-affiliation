<?php

namespace Runig006\FlarumAffiliation;

use Flarum\Extend;
use Runig006\FlarumAffiliation\Formatter\UrlFormatter;
use Runig006\FlarumAffiliation\Providers\FormatterProvider;

return [
    (new Extend\Locales(__DIR__ . '/locale')),

    (new Extend\Frontend('admin'))
        ->js(__DIR__ . '/js/dist/admin.js'),

    (new Extend\Formatter())
        ->render(UrlFormatter::class),
    (new Extend\ServiceProvider())
        ->register(FormatterProvider::class),
];
