<?php
namespace BehatExtras\Initializer;

use Behat\Behat\Context\Initializer\InitializerInterface,
    Behat\Behat\Context\ContextInterface,
    BehatExtras\Context\InboxAwareInterface;

class InboxInitializer implements InitializerInterface
{
    protected $configOptions;

    public function __construct(array $configOptions)
    {
        $this->configOptions = $configOptions;
    }

    public function supports(ContextInterface $context)
    {
        return ($context instanceof InboxAwareInterface);
    }

    /**
     * Initializes provided context.
     *
     * @param ContextInterface $context
     */
    public function initialize(ContextInterface $context)
    {
        $options = $this->configOptions;
        $storageConfig['host'] = $options['host'];
        $storageConfig['user'] = $options['user'];
        $storageConfig['password'] = $options['password'];
        $storageConfig['port'] = $options['port'];

        switch($options['protocol']) {
            case "pop3";
                $storageClass = '\Zend\Mail\Storage\Pop3';
                break;
            case "pop3-ssl":
                $storageClass = '\Zend\Mail\Storage\Pop3';
                $storageConfig['ssl'] = 'SSL';
                break;
            case "pop3-tls":
                $storageClass = '\Zend\Mail\Storage\Pop3';
                $storageConfig['ssl'] = 'TLS';
                break;
            case "imap";
                $storageClass = '\Zend\Mail\Storage\Imap';
                break;
            case "imap-ssl":
                $storageClass = '\Zend\Mail\Storage\Imap';
                $storageConfig['ssl'] = 'SSL';
                break;
            case "imap-tls":
                $storageClass = '\Zend\Mail\Storage\Imap';
                $storageConfig['ssl'] = 'TLS';
                break;
            default:
                throw new \RuntimeException($options["protocol"] . " is not a recognized protocol");

        }
        $storage = new $storageClass($storageConfig);
        $context->setMailStorage($storage);
    }

}