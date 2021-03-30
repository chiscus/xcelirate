Feature: List of quotes
  In order to retrieve a list of quotes
  As an user
  I need to ask the API for a number and an author

  Rules:
  - Number of quotes under 10
  - The author should be filled
  - Quotes shall be shouted with capital letters and exclamation marks
  - The result should be cached

  Scenario: Asking for an incorrect author
    Given that the user didn't input an author
    When the user requested the list from "http://awesomequotesapi.com/shout/"
    Then the result should be an error message

  Scenario: Trying to retrieve more than 10 quotes
    Given that the user asked for more than 10 quotes from an author
    When the user requested the data from "http://awesomequotesapi.com/shout/"
    Then the result must be an error

  Scenario: Retrieving the correct number and the correct author but query is not cached
    Given that the user asked for less than 10 quotes from an author
    And the user asked for a known author
    When the user requested the result from "http://awesomequotesapi.com/shout/"
    Then the result should be a list of quotes from the database
    And the quotes should be shouted with capital letters and exclamation marks
