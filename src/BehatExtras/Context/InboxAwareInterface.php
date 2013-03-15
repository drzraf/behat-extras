<?php
namespace BehatExtras\Context;

interface InboxAwareInterface
{
    public function setMailStorage(\Zend\Mail\Storage\AbstractStorage $storage);
}