<?php
namespace WowApi\Api;

class Auction extends AbstractApi
{
    public function getAuctions($realm)
    {
        $cacheEngine = $this->client->getCache();
        $index = $this->getAuctionIndex($realm);

        if($index) {
            $auctions = $this->getRequest()->send($index['url']);
            return $auctions;
        }

        return false;
    }

    public function getAuctionIndex($realm)
    {
        $indexFile = $this->get($this->generatePath('auction/data/:realm', array(
            'realm' => $realm,
        )));

        if(isset($indexFile['files']) && isset($indexFile['files'][0])) {
            return $indexFile['files'][0];
        }

        return false;
    }
}
