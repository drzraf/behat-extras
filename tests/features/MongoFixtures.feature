Feature: Mongo Fixtures
  As a developer
  In order to isolate tests in my suite from each other
  I may want to use data fixtures

  Background:
    Given the mongo database is clean

  Scenario: fixtures
    Given a "test" collection with documents:
    | name | foo.bar | baz[] |
    | test | baz     | 1,2,3 |

  Scenario: raw json
    Given a new "test" document with:
    """
    {
        "name": "foo"
    }
    """