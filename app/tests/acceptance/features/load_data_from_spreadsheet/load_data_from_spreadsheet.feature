Feature: Update information from spreadsheets availables
In order to update information from spreadsheet
As a Developer
I need to be able to give a valid filename and all goals and projects will be updated

Scenario: List available files to import
    Given i have a CommandImporter
    When i execute the command without parameters
    Then i should recieve a list of filenames availables

Scenario: Import only goals
    Given i have a CommandImporter
    And i have a "load:goals" task
    When i execute the command with following parameters "filename" and values "segunda-versao-27-02.xls"
    Then i should receive a list of meta changes

Scenario: Import only projects
    Given i have a CommandImporter
    And i have a "load:projects" task
    When i execute the command with following parameters "filename" and value "segunda-versao-27-02.xls"
    And i should to be able to count projects by type imported
        | type | total |
        | 1    | 100   |
        | 4    | 100   |

Scenario: Import all goals and projects of all types
    Given i have a CommandImporter
    And i have a "load" task
    When i execute the command with following parameters "filename" and value "segunda-versao-27-02.xls"
    Then i should be able to count "123" metas and total of projects by type
        | type | total |
        | 1    | 100   |
        | 4    | 100   |

#Scenario: Log errors when trying to save meta
#    Given i have the following meta values
#        """
#
#            Implantar 12 novos Consultórios na Rua com tratamentos odontológicos e relacionados ao abuso de álcool e outras drogas
#            SMS
#            Superada
#            Dúvida: se os consultórios são móveis, como podemos afirmar a qual subprefitura pertencem? Na ficha original da meta a indicação de subprefeituras é diferente da apresentada no balanço SGM.
#            Quantas pessoas atendidas? Que tipo de atendimento? Qual a composição das equipes em cada consultórios?
#            Sobre o custo, indicado na ficha de identidade da meta como R$ 24 milhões, como está composto?
#
#
#
#
#        """
#    When i try to save meta
#    Then i should see the message "Meta could not be null" in log file named "importer.log"
