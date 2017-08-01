<?php

namespace BehatExtras\Context;

use Behat\MinkExtension\Context\MinkContext;

class WebdriverContext extends MinkContext
{
    /**
     * @when /^(?:|I )confirm the popup$/
     */
    public function confirmPopup()
    {
        $this->getSession()->getDriver()->acceptAlert();
    }

    /**
     * @when /^(?:|I )cancel the popup$/
     */
    public function cancelPopup()
    {
        $this->getSession()->getDriver()->dismissAlert();
    }

    /**
     * @When /^(?:|I )should see "([^"]*)" in popup$/
     *
     * @param string $message
     *
     * @return bool
     */
    public function assertPopupMessage($message)
    {
        return $message == $this->getSession()->getDriver()->getAlert_text();
    }

    /**
     * @When /^(?:|I )fill "([^"]*)" in popup$/
     *
     * @param string $test
     */
    public function setPopupText($test)
    {
        $this->getSession()->getDriver()->postAlert_text($test);
    }
}
