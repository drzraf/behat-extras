<?php
namespace BehatExtras\Context;

use Behat\Behat\Context\BehatContext;

class KitchenSinkContext extends BehatContext
{
    public function __construct()
    {
        $this->useContext('mongo_fixtures', new MongoFixturesContext);
    }
}