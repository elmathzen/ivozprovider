Feature: Update carriers
  In order to manage carriers
  As a brand admin
  I need to be able to update them through the API.

  @createSchema
  Scenario: Update a carrier
    Given I add Brand Authorization header
     When I add "Content-Type" header equal to "application/json"
      And I add "Accept" header equal to "application/json"
      And I send a "PUT" request to "/carriers/1" with body:
      """
      {
          "description": "Artemis-Updated",
          "name": "Artemis-Updated",
          "transformationRuleSet": 1
      }
      """
     Then the response status code should be 200
      And the response should be in JSON
      And the header "Content-Type" should be equal to "application/json; charset=utf-8"
      And the JSON should be equal to:
      """
      {
          "description": "Artemis-Updated",
          "name": "Artemis-Updated",
          "balance": 0,
          "calculateCost": true,
          "id": 1,
          "transformationRuleSet": 1,
          "currency": null,
          "proxyTrunk": 1,
          "mediaRelaySets": null,
          "mediaRelaySet": 0
      }
      """

  @createSchema
  Scenario: Update a carrier with an unrelated media relay set
    Given I add Brand Authorization header
     When I add "Content-Type" header equal to "application/json"
      And I add "Accept" header equal to "application/json"
      And I send a "PUT" request to "/carriers/1" with body:
      """
      {
        "mediaRelaySet": 2
      }
      """
     Then the response status code should be 403
      And the response should be in JSON
      And the header "Content-Type" should be equal to "application/problem+json; charset=utf-8"
      And the JSON should be like:
      """
      {
        "detail": "Rejected request during security check"
      }
      """
