<?php

namespace StockPortfolioTracker;

/**
 * Class MarketData
 *
 * @package StockPortfolioTracker
 */
class MarketData
{
    const CACHE_FOLDER = 'data';
    const C_NAME = 'A3';

    protected $params;

    protected $endPoints = [
        'quotes' => [
            'url'       => 'https://query%d.finance.yahoo.com/v7/finance/quote?formatted=false&symbols=%s&fields=shortName,longName,regularMarketOpen,regularMarketPrice,regularMarketChange,regularMarketChangePercent,regularMarketVolume,sharesOutstanding,marketCap,fiftyTwoWeekLow,fiftyTwoWeekHigh&crumb=%s',
            'result'    => 'quoteResponse.result',
            'cache'     => 600
        ],
        'history' => [
            'url'       => 'https://query%d.finance.yahoo.com/v8/finance/chart/%s?range=%s&interval=%s&includePrePost=false&crumb=%s',
            'result'    => 'chart.result',
            'cache'     => [
                '5m' => 300,
                '15m' => 900,
                '30m' => 1800,
                '60m' => 3600,
                '90m' => 5400,
                '1h' => 3600,
                '1d' => 43200, // 12h
                '5d' => 86400, // 24h
                '1wk' => 86400, // 24h
                '1mo' => 86400, // 24h
                '3mo' => 604800, // 7d
            ]
        ]
    ];

    protected $creds;

    function __construct($request)
    {
        // automatically create cache dir if it doesn't exist
        $cacheDirPath = __DIR__ . '/../../' . self::CACHE_FOLDER;
        if (!is_dir($cacheDirPath))
            mkdir($cacheDirPath);

        foreach ($request as $key => $value) {
            if (in_array($key, ['type', 'assets', 'range', 'interval'])) {
                $this->params[$key] = $value;
            }
        }

        $this->creds = $request['creds'] ?? [];
    }

    public function get()
    {
        $data = [];

        if (isset($this->endPoints[$this->params['type']]) && is_array($this->params['assets']) && !empty($this->params['assets'])) {
            $assets = [];
            // loop through requested assets
            foreach ($this->params['assets'] as $asset) {
                // check if cache for the given asset exists and not expired
                $cacheFileName = $this->getCacheFileName($asset);
                if (Helper::cacheExists($cacheFileName, $this->getCacheTime())) {
                    $data[] = Helper::readJson($cacheFileName);
                // otherwise mark the given asset to pull data from API
                } else {
                    $assets[] = $asset;
                }
            }

            // if not all data can be loaded from cache
            if (!empty($assets)) {
                $urls = $this->getRequestUrls($assets);

                foreach ($urls as $url) {
                    $http = $this->getValueB() ? new Http($url, ['cookies' => [self::C_NAME => $this->getValueB()]]) : new Http($url);
                    $response = Helper::decode($http->get());

                    // get array of data items
                    $dataItems = Helper::getObjectProperty($response, $this->endPoints[$this->params['type']]['result']);

                    if (!empty($dataItems)) {
                        // loop through all received data items
                        foreach ($dataItems as $dataItem) {
                            $dataItem = $this->processDataItem($dataItem); // re-format item object if needed
                            $data[] = $dataItem; // add item to the result array
                            Helper::saveJson($this->getCacheFileName($dataItem['symbol']), $dataItem); // save in cache
                        }
                    }
                }
            }
        }

        return json_encode(['success' => !empty($data) ? TRUE : FALSE, 'data' => $data]);
    }

    /**
     * Get API request URLs based on the request type
     *
     * @param $assets
     * @return array
     */
    private function getRequestUrls($assets)
    {
        $urls = [];
        $baseUrl = $this->endPoints[$this->params['type']]['url'];

        // for history requests each asset should be processed one by one
        if ($this->params['type'] == 'history') {
            foreach ($assets as $asset) {
                $urls[] = sprintf($baseUrl, rand(1, 2), $asset, $this->params['range'], $this->params['interval'], $this->getValueA());
            }
        }  else {
            $urls[] = sprintf($baseUrl, rand(1, 2), implode(',', $assets), $this->getValueA());
        }

        return $urls;
    }

    private function processDataItem($item)
    {
        $result = [];

        // regular quotes
        if ($this->params['type'] == 'quotes') {
            $result['type'] = Helper::getObjectProperty($item, 'quoteType');
            $result['symbol'] = Helper::getObjectProperty($item, 'symbol');
            $result['name'] = Helper::getObjectProperty($item, 'longName') ?: Helper::getObjectProperty($item, 'shortName');
            $result['price'] = Helper::getObjectProperty($item, 'regularMarketPrice');
            $result['currency'] = Helper::getObjectProperty($item, 'currency');
            $result['change_abs'] = Helper::getObjectProperty($item, 'regularMarketChange');
            $result['change_pct'] = Helper::getObjectProperty($item, 'regularMarketChangePercent') / 100;
            $result['last_update'] = Helper::getObjectProperty($item, 'regularMarketTime') * 1000; // seconds --> miliseconds
        // historical data
        } elseif ($this->params['type'] == 'history') {
            $ts = Helper::getObjectProperty($item, 'timestamp');
            $close = Helper::getObjectProperty($item, 'indicators.quote.0.close');

            $result['symbol'] = Helper::getObjectProperty($item, 'meta.symbol');
            $result['currency'] = Helper::getObjectProperty($item, 'meta.currency');
            $result['date'] = !empty($ts) ? array_map(function($date) { return (new \DateTime())->setTimezone(new \DateTimeZone('UTC'))->setTimestamp($date)->modify('midnight')->getTimestamp(); }, $ts) : []; // convert close of working day date to midnight timestamp
            $result['close'] = !empty($close) ? $close : [];
        }

        return $result;
    }

    private function getCacheFileName($asset)
    {
        return $this->params['type'] == 'history' ?
            sprintf('%s/%s_%s_%s_%s.json', self::CACHE_FOLDER, $asset, $this->params['type'], $this->params['range'], $this->params['interval']) :
            sprintf('%s/%s_%s.json', self::CACHE_FOLDER, $asset, $this->params['type']);
    }

    private function getCacheTime()
    {
        return $this->params['type'] == 'history' ?
            $this->endPoints[$this->params['type']]['cache'][$this->params['interval']] :
            $this->endPoints[$this->params['type']]['cache'];
    }

    protected function getValueA()
    {
        return $this->creds['a'] ?? NULL;
    }

    protected function getValueB()
    {
        return $this->creds['b'] ?? NULL;
    }
}
