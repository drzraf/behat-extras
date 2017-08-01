<?php
namespace BehatExtras\Context;

use Behat\MinkExtension\Context\RawMinkContext;

class WaitContext extends RawMinkContext
{
    /**
     * @Given /^I wait until I am on "([^"]*)"$/
     */
    public function iWaitUntilIAmOn($location)
    {
        $tries = 15;
        $fullLocation = $this->getMinkParameter('base_url') . $location;
        for ($c = 0; $c < $tries; $c++) {
            if ($fullLocation != $this->getSession()->getCurrentUrl()) {
                sleep(1);
                continue;
            } else {
                return;
            }
        }
        throw new \Exception("Timed out waiting for URL to be: $fullLocation");
    }
}

