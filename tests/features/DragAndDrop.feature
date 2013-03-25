@javascript
Feature: Drag and Drop
  As a developer
  In order to test various UI interactions
  I want to be able to write tests that use drag and drop actions

  Scenario:
    Given I open "draganddrop.html"
    When I drag ".ui-slider-handle" "50" pixels to the right
