Feature: League
  Scenario: Get a list of all leagues
    Given I send a "GET" request to "/leagues"
    Then the response should be in JSON
    And the response should be equal to
      """
    {"data":[{"id":1,"name":"Premier League"},{"id":2,"name":"Sunshine League"}]}
      """
  Scenario: Get a list of a specific leagues
    Given I send a "GET" request to "/leagues/1"
    Then the response should be in JSON
    And the response should be equal to
      """
    {"data":{"id":1,"name":"Premier League"}}
      """