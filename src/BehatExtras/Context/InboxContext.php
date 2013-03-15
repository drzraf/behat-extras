<?php
namespace BehatExtras\Context;

use Behat\Behat\Context\ContextInterface,
    Behat\Behat\Exception\PendingException;
use Symfony\Component\Config\Definition\Exception\Exception;


class InboxContext implements ContextInterface, InboxAwareInterface
{
    /**
     * @var \Zend\Mail\Storage\AbstractStorage
     */
    protected $mailStorage;

    public function setMailStorage(\Zend\Mail\Storage\AbstractStorage $storage)
    {
        $this->mailStorage = $storage;
    }

    /**
     * @afterScenario
     */
    public function cleanup()
    {
        $this->mailStorage->close();
    }

    /**
     * @Then /^I should see an email from "([^"]*)"$/
     */
    public function iShouldSeeAnEmailFrom($sender)
    {
        $this->mailStorage->next();
        $message = $this->mailStorage->current();
        $from = $message->getHeader('from', 'string');
        if (preg_match('`(.+?) <(.+?)>`', $from, $matches)) {
            $fromName = $matches[1];
            $fromEmail = $matches[2];
            if (!($fromEmail == $sender || $fromName == $sender)) {
                throw new \Exception("Did not find a message from $sender");
            }
        } else {
            if ($from != $sender) {
                throw new \Exception("Did not find a message from $sender");
            }
        }
    }

    /**
     * @Then /^I should see an email with subject "([^"]*)"$/
     */
    public function iShouldSeeAnEmailWithSubject($subject)
    {
        $this->mailStorage->next();
        $message = $this->mailStorage->current();
        var_dump($message);
        if ($message->subject != $subject) {
            throw new \Exception("Did not find a message with subject $subject");
        }
    }

    /**
     * @Then /^I should see an email whose body contains "([^"]*)"$/
     */
    public function iShouldSeeAnEmailWhoseBodyContains($arg1)
    {
        throw new PendingException();
    }


    /**
     * @Then /^I should see an email with the following properties:$/
     */
    public function iShouldSeeAnEmailWithTheFollowingProperties(TableNode $table)
    {
        throw new PendingException();
    }

}