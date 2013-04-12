<?php
namespace BehatExtras\Context;

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Exception\PendingException;
use Behat\Mink\Mink;
use Behat\MinkExtension\Context\MinkAwareInterface;

class WaitContext extends BehatContext implements MinkAwareInterface
{
    /**
     * @var \Behat\Mink\Mink
     */
    protected $mink;
    protected $minkParameters;

    /**
     * Sets Mink instance.
     *
     * @param Mink $mink Mink session manager
     */
    public function setMink(Mink $mink)
    {
        $this->mink = $mink;
    }

    /**
     * Sets parameters provided for Mink.
     *
     * @param array $parameters
     */
    public function setMinkParameters(array $parameters)
    {
        $this->minkParameters = $parameters;
    }


    /**
     * @Given /^I wait until I am on "([^"]*)"$/
     */
    public function iWaitUntilIAmOn($location)
    {
        $tries = 15;
        $fullLocation = $this->minkParameters['base_url'] . $location;
        for ($c = 0; $c < $tries; $c++) {
            if ($fullLocation != $this->mink->getSession()->getCurrentUrl()) {
                sleep(1);
                continue;
            } else {
                return;
            }
        }
        throw new \Exception("Timed out waiting for URL to be: $fullLocation");
    }


}

