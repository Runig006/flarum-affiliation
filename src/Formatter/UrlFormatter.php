<?php

namespace Runig006\FlarumAffiliation\Formatter;

use Illuminate\Support\Arr;
use s9e\TextFormatter\Renderer;
use s9e\TextFormatter\Utils;

class UrlFormatter
{
    public $config = [];

    public function __invoke(Renderer $renderer, $context, $xml)
    {
        return Utils::replaceAttributes($xml, 'URL', function ($attributes) {
            if (Arr::has($attributes, 'url')) {
                $attributes['url'] = (string) $this->checkUrl($attributes['url']);
            }
            return $attributes;
        });
    }

    public function checkUrl($url)
    {
        $parse = parse_url($url);
        if (
            isset($parse['path']) == false ||
            isset($parse['host']) == false
        ) {
            return $url;
        }
        
        if (substr($parse['path'], -1) == '/') {
            $parse['path'] = substr($parse['path'], 0, -1);
        }
        foreach ($this->config as $c) {
            if (strpos($parse['host'], $c['domain']) !== false) {
                parse_str($parse['query'], $query);
                foreach ($c['params'] as $n => $v) {
                    $query[$n] = $v;
                }
                $query = http_build_query($query);
                $parse['query'] = $query;
                $url = $this->build_url($parse);
            }
        }
        return $url;
    }

    //https://stackoverflow.com/a/35207936
    function build_url(array $parts)
    {
        return (isset($parts['scheme']) ? "{$parts['scheme']}:" : '') .
            ((isset($parts['user']) || isset($parts['host'])) ? '//' : '') .
            (isset($parts['user']) ? "{$parts['user']}" : '') .
            (isset($parts['pass']) ? ":{$parts['pass']}" : '') .
            (isset($parts['user']) ? '@' : '') .
            (isset($parts['host']) ? "{$parts['host']}" : '') .
            (isset($parts['port']) ? ":{$parts['port']}" : '') .
            (isset($parts['path']) ? "{$parts['path']}" : '') .
            (isset($parts['query']) ? "?{$parts['query']}" : '') .
            (isset($parts['fragment']) ? "#{$parts['fragment']}" : '');
    }
}
