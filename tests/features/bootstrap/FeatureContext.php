<?php

use Behat\MinkExtension\Context\MinkContext;

require_once __DIR__ . '/../../../vendor/autoload.php';

/**
 * Features context.
 */
class FeatureContext extends MinkContext
{
    public function __construct(array $parameters)
    {
        $this->useContext('mongo_fixtures', new \BehatExtras\Context\MongoFixturesContext);
        $this->useContext('drag_and_drop', new \BehatExtras\Context\DragAndDropContext);
    }

    /**
     * @Given /^I open "([^"]*)"$/
     */
    public function iOpen($file)
    {
        $filePath = realpath(__DIR__ . '/../../resources/' . $file);
        $this->getSession()->visit("file://$filePath");
    }
}
