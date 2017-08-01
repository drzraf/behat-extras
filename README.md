behat-extras
============

Additional contexts and extensions for everyday Behat and Mink use


## How to use:

Add the new context to your suite inside behat.yml:
```
default:
  suites:
    default:
      contexts:
        - BehatExtras\Context\DragAndDropContext
```
