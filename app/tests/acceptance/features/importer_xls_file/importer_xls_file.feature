Feature: Check data and update database
In order to import data to database
As a Developer
I need to validate data coming from spreadsheet before save to database

Background:
    Given i have a default directory "app/storage/importer"

Scenario: List available files to import
    Given i haven`t a filename
    When i try to list my available options
    Then i should recieve a list of filenames
    """
    app/storage/importer/primeira-versao-22-02.xls
    app/storage/importer/segunda-versao-29-05.xls
    app/storage/importer/teste-conteudo.xls
    app/storage/importer/versao-sem-tipo-4-e-5.xls
    """

Scenario: Import goals with success
    Given i have a parsed content "decima-segunda-versao-29-05.xls"
    And i have validate goals
    When i try to save goals to database
    Then i should receive a list of successfull changes
@current
Scenario Outline: Import projects with success
    Given i have a parsed content "decima-segunda-versao-29-05.xls"
    And i have validate projects of type <type_of_project>
    When i try to save projects of type <type_of_project> to database
    Then i should receive a list of successfull changes

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
