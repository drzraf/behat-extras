<?php
namespace BehatExtras\Context;

use Behat\MinkExtension\Context\RawMinkContext;

class DragAndDropContext extends RawMinkContext
{

    /**
     * @When /^I drag "([^"]*)" "([^"]*)" pixels to the right$/
     */
    public function iDragPixelsToTheRight($element, $pixels)
    {
        $this->dragByPixels($element, $pixels, 0);
    }

    /**
     * @When /^I drag "([^"]*)" "([^"]*)" pixels to the left$/
     */
    public function iDragPixelsToTheLeft($element, $pixels)
    {
        $this->dragByPixels($element, -$pixels, 0);
    }

    /**
     * @When /^I drag "([^"]*)" "([^"]*)" pixels up$/
     */
    public function iDragPixelsUp($element, $pixels)
    {
        $this->dragByPixels($element, 0, -$pixels);
    }

    /**
     * @When /^I drag "([^"]*)" "([^"]*)" pixels down$/
     */
    public function iDragPixelsDown($element, $pixels)
    {
        $this->dragByPixels($element, 0, $pixels);
    }

    public function dragByPixels($selector, $pixelsX, $pixelsY)
    {
        $session = $this->getSession();
        $el = $session->getPage()->find('css', $selector);
        // ToDo: see https://github.com/minkphp/Mink/pull/596
        // about having the WebDriver interface implementing moveTo()
        $session->moveTo(['element' => $el->getID(), 'xoffset' => 2, 'yoffset' => 2]);
        $session->buttondown("");
        $session->moveTo(['element' => null, 'xoffset' => (int) $pixelsX, 'yoffset' => (int) $pixelsY]);
        $session->buttonup("");
        usleep(50000);
    }
}