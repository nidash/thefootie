Feature: Team
  Scenario: Get a list of all teams
    Given I send a "GET" request to "/teams"
    Then the response should be in JSON
    And the response should be equal to
      """
    {"data":[{"id":1,"name":"Team1","strip":"Red striped shirts, white shorts"},{"id":2,"name":"Team2","strip":"Red shirts, red shorts"}]}
      """
  Scenario: Get a list of a specific leagues
    Given I send a "GET" request to "/teams/1"
    Then the response should be in JSON
    And the response should be equal to
      """
    {"data":{"id":1,"name":"Team1","strip":"Red striped shirts, white shorts"}}
      """