Feature: Inbox
  As a developer
  In order to verify the correct operation of my application
  I want to be able to confirm that an email was sent and received to a specific address

  Scenario:
    Then I should see an email from "josh.butts@vertive.com"
    And I should see an email with subject "test email"
    And I should see an email whose body contains "Hello!"
    And I should see an email with the following properties:
      | from                   | to                  | subject    | body_contains |
      | josh.butts@vertive.com | test@dailydeals.com | test email | Hello!        |