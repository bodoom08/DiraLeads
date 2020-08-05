<?php
defined('BASEPATH') or exit('No direct script access allowed');
require(APPPATH . 'third_party/vendor/autoload.php');

use Http\Discovery\HttpClientDiscovery;
use Http\Client\Common\PluginClient;
use Http\Client\Common\Plugin\HeaderSetPlugin;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Client\Common\Plugin\CachePlugin;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Cache\Adapter\Filesystem\FilesystemCachePool;
use Http\Client\Common\Plugin\LoggerPlugin;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Http\Message\Formatter\FullHttpMessageFormatter;

class Telnyx
{
    public function __construct()
    {
        /** @var \Psr\Cache\CacheItemPoolInterface $cachePool */
        $cachePool = new FilesystemCachePool(new Filesystem(new Local(APPPATH . 'cache/telnyx')));

        /** @var \Http\Message\StreamFactory $messageFactory */
        $this->messageFactory = MessageFactoryDiscovery::find();

        $logger = new Logger('telnyx');
        $logger->pushHandler(new RotatingFileHandler(APPPATH . 'logs/telnyx/telnyx.log'));

        $this->client = new PluginClient(HttpClientDiscovery::find(), [
            new HeaderSetPlugin([
                'Content-Type' => 'application/json',
                'x-api-user' => 'info@diraleads.com',
                'x-api-token' => 'rgzYekljThirucLyvKhPoQ'
            ]),
            new LoggerPlugin($logger, new FullHttpMessageFormatter())
            // new CachePlugin($cachePool, $this->messageFactory, [
            //     'default_ttl' => 3600
            // ])
        ]);
    }

    private function getData($path, $method = 'GET', $params = [])
    {
        $response = $this->client->sendRequest(
            $this->messageFactory->createRequest(
                $method,
                'https://api.telnyx.com/' . $path,
                [],
                json_encode($params)
            )
        );

        if ($response->getStatusCode() == 200) {
            return json_decode((string)$response->getBody(), true);
        }

        return $response->getBody()->getContents();
    }

    public function searchNumbers($search_descriptor, $limit = 10, $search_type = 2)
    {
        if (is_string($search_descriptor)) {
            return $this->getData('origination/number_searches/' . $search_descriptor);
        }
        return $this->getData(
            'origination/number_searches',
            'POST',
            compact('search_descriptor', 'search_type', 'limit')
        );
    }

    public function getNumberOrders($id = null)
    {
        return $this->getData('origination/number_orders/' . $id);
    }

    public function createNumberOrders(...$numbers)
    {
        return $this->getData('origination/number_orders', 'POST', [
            "requested_numbers" => $numbers
        ]);
    }

    public function myNumbers($id = null)
    {
        return $this->getData('origination/numbers/' . $id);
    }

    public function numberOrderDocs()
    {
        return $this->getData('number_order_documents');
    }
}
