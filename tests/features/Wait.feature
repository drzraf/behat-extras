@javascript
Feature: waiting
  As a Developer
  In order to test complex interaction
  I want to wait for the page in various different ways

  Scenario: wait for url to change
    Given I open "waitlocation.html"
    And I wait until I am on "file:///Users/josh/projects/behat-extras/tests/resources/waitlocation.html?foo"