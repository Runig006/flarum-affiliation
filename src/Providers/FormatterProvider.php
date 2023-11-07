<?php

/*
 * This file is part of fof/amazon-affiliation.
 *
 * Copyright (c) FriendsOfFlarum.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Runig006\FlarumAffiliation\Providers;

use Flarum\Foundation\AbstractServiceProvider;
use Flarum\Settings\SettingsRepositoryInterface;
use Runig006\FlarumAffiliation\Formatter\UrlFormatter;

class FormatterProvider extends AbstractServiceProvider
{
    public function register()
    {
        $this->container->singleton(UrlFormatter::class, function () {
            $settings = resolve(SettingsRepositoryInterface::class);
            $json = $settings->get('runig006-flarum-affilation.json', "{}");
            $json = json_decode($json, true);

            $formatter = new UrlFormatter();
            $formatter->config = $json ?? [];
            return $formatter;
        });
    }
}
