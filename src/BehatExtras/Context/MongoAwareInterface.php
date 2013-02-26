<?php
namespace BehatExtras\Context;

interface MongoAwareInterface
{
    public function setMongoClient(\MongoClient $mongoClient);
    public function setMongoDatabase($mongoDatabase);
}