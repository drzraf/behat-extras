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

  #MongoObjects need to be in 24bit.  Otherwise, the driver will make its own using increments
  #and the actual value in Mongo will be different.
  Scenario: Mongo object fixtures
    Given a "test" collection with documents:
    | _id                                  | UnixTimestampDate               |  RegularDate                |
    | ObjectId("ef959f706ccdc0b9a3eb5199") | Date(1445444940)                | Date("2010-01-15 00:00:00") |

    And a "foreign" collection with documents:
    | lookup                               |  foo       |
    | ObjectId("ef959f706ccdc0b9a3eb5199") |  bar1      |
    | ObjectId("ef959f706ccdc0b9a3eb5199") |  bar2      |
    | ObjectId("ef959f706ccdc0b9a3eb5199") |  bar3      |
