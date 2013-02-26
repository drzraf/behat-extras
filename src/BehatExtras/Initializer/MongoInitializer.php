<?php
namespace BehatExtras\Initializer;

use Behat\Behat\Context\Initializer\InitializerInterface,
    Behat\Behat\Context\ContextInterface,
    BehatExtras\Extension\MongoExtension,
    BehatExtras\Context\MongoAwareInterface;

class MongoInitializer implements InitializerInterface
{
    protected $mongoHost;
    protected $mongoDatabase;

    public function __construct($mongoHost, $mongoDatabase)
    {
        $this->mongoHost = $mongoHost;
        $this->mongoDatabase = $mongoDatabase;
    }

    public function supports(ContextInterface $context)
    {
        return ($context instanceof MongoAwareInterface);
    }

    /**
     * Initializes provided context.
     *
     * @param ContextInterface $context
     */
    public function initialize(ContextInterface $context)
    {
        $context->setMongoClient(new \MongoClient("mongodb://$this->mongoHost:27017"));
        $context->setMongoDatabase($this->mongoDatabase);
    }

}