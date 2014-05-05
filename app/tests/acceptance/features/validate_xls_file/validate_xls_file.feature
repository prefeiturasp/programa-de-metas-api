Feature: validate_xls_file
In order to import data from spreadsheet
As a Developer
I need to check content

Background:
    Given I have a spreadsheet loaded named "quarta-versao-07-03.xls"

Scenario: Length of meta name is lower than 350
    Given I have list of goals
    When I validate the goals
    Then I should assert the length is not bigger than 350

Scenario: Must found at least one valid Secretary by meta when importing
    Given I have list of goals
    When I validate the goals
    Then I should found multi secretaries acronym when a comma
    And I should be able to map secretary acronym to secretary register

Scenario: Indentifier correct values to status
    Given I have list of goals
    When I validate the goals
    Then I should be able to found valid status

Scenario Outline: Is goal exists
    Given I have list of projects of type <type_of_project>
    When I validate the project
    Then I should certificate goal exists

    Examples:
    | type_of_project |
    |        1        |
    |        2        |
    |        3        |
    |        4        |
    |        5        |
    |        6        |
    |        7        |
    |        8        |
    |        9        |


Scenario: Is project exists
    Given I have list of projects of type 1
    When I validate the project
    Then I should certificate projects exists

Scenario Outline: Length of project name is lower than 255
    Given I have list of projects of type <type_of_project>
    When I validate the project
    Then I should assert the length of project name is not bigger than 255

    Examples:
    | type_of_project |
    |        1        |
    |        2        |
    |        3        |
    |        4        |
    |        5        |
    |        6        |
    |        7        |
    |        8        |
    |        9        |

Scenario Outline: Validate column to a prefecture exists
    Given I have list of projects of type <type_of_project>
    When I validate the project
    Then I should be able to map a prefecture acronym to valid id

    Examples:
    | type_of_project |
    |        1        |
    |        2        |
    |        3        |
    |        4        |
    |        5        |
    |        6        |
    |        7        |
    |        8        |
    |        9        |

Scenario Outline: Validate column against latitude and longitude values
    Given I have list of projects of type 1
    When I validate the project
    Then I should be able to found a valid point on map

    Examples:
    | type_of_project |
    |        1        |
    |        2        |
    |        3        |
    |        4        |
    |        5        |
    |        6        |
    |        9        |

Scenario Outline: Validate columns co-related to milestones
    Given I have list of projects of type <type_of_project>
    When I validate the project
    Then I should be able to found valid status at milestones

    Examples:
    | type_of_project |
    |        1        |
    |        2        |
    |        3        |
    |        4        |
    |        5        |
    |        6        |
    |        7        |
    |        8        |

Scenario: Target goal must be float
    Given I have list of projects of type 9
    When I validate the project
    Then Target goal values must be float and required

Scenario: Validate columns co-related to monthly progress
    Given I have list of projects of type 9
    When I validate the project
    Then I should be able to found valid values each month from 2013 to 2016
