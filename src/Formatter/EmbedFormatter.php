<?php

namespace Runig006\FlarumAffiliation\Formatter;

use Exception;
use Illuminate\Support\Facades\Log;
use s9e\TextFormatter\Configurator;

class EmbedFormatter
{
    public $config = [];
    public $amazon = [];

    public function __invoke(Configurator $configurator)
    {
        $this->buildParams($configurator->rendering->parameters);
        extract($configurator->finalize());
    }

    public function loadAmazon()
    {
        $amazon = [];
        foreach ($this->config as $c) {
            if (strpos($c['domain'], 'amazon') !== false && isset($c['params']['tag'])) {
                $tag = $c['params']['tag'];
                $lang = explode(".", $c['domain']);
                if (count($lang) > 1) {
                    $lang = array_pop($lang);
                    $amazon[$lang] = $tag;
                }
                if (isset($amazon['default']) == false) {
                    $amazon['default'] = $tag;
                }
            }
        }
        $this->amazon = $amazon;
    }

    private function buildParams(&$params)
    {
        $langs = ['uk', 'de', 'fr', 'jp', 'ca', 'it', 'es', 'in'];
        $key = 'AMAZON_ASSOCIATE_TAG';
        foreach ($this->amazon as $k => $v) {
            $paramKey = $key;
            if ($k != 'default') {
                $paramKey .= "_" . strtoupper($k);
            }
            $params[$paramKey] = $v;
        }
        if (isset($params[$key])) {
            foreach ($langs as $l) {
                $paramKey = $key . "_" . strtoupper($l);
                if (isset($params[$paramKey]) == false) {
                    $params[$paramKey] = $params[$key];
                }
            }
        }
        return $params;
    }
}
