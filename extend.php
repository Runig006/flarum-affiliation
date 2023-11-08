<?php

namespace Runig006\FlarumAffiliation;

use Flarum\Extend;
use Runig006\FlarumAffiliation\Formatter\EmbedFormatter;
use Runig006\FlarumAffiliation\Formatter\UrlFormatter;
use Runig006\FlarumAffiliation\Providers\FormatterProvider;

return [
    (new Extend\Locales(__DIR__ . '/locale')),

    (new Extend\Frontend('admin'))
        ->js(__DIR__ . '/js/dist/admin.js')
        ->css(__DIR__ . '/less/Admin.less'),

    (new Extend\Formatter())
        ->render(UrlFormatter::class)
        ->configure(EmbedFormatter::class),
    (new Extend\ServiceProvider())
        ->register(FormatterProvider::class),
];
