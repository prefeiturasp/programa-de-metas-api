Feature: ParseXlsFile
In order to import data to api
As Developer
I need to be able to get the content from spreadsheet easily, without config anything

Background: Read content of file
    Given a opened file named "decima-sexta-versao.xls"

Scenario: Receive a list of worksheets
    Given There is a excel file loaded
    When I try to get all worksheet availables
    Then i should receive a list
        """
        Classif. Metas
        Resumo_fases
        Fases_definições
        Status metas
        Status tipo 1
        Status tipo 2
        Status tipo  3
        Status tipo 4
        Status tipo 5
        Status tipo 6
        Status tipo 7
        Status tipo 8
        Status tipo 9
        """

Scenario: Receive a list of metas
    Given There is a excel file loaded
    And the name of worksheet is "Status metas"
    When I try to get all meta available
    Then I should receive a list of metas
    And The meta must have the following colummns
        """
        Meta
        Meta_Desc
        Secretaria
        Status da Meta
        Selos Transversais
        Andamento qualitativo 1
        Andamento qualitativo 2
        Andamento qualitativo 3
        Andamento qualitativo 4
        Andamento qualitativo 5
        Andamento qualitativo 6
        """

Scenario: Receive a list of projects from type "1"
    Given There is a excel file loaded
    And the name of worksheet is "Status tipo 1"
    When I try to get all projetcts available of type "1"
    Then I should receive a list of projects
    And The projects of type "1" must have the following colummns
        """
        Meta
        Descrição Projeto Obra em terreno público
        Subprefeitura
        Distrito
        Endereço
        Coordenada (google maps)
        Definição de Terreno (10%)
        Projeto Básico (5%)
        Garantia da fonte de financiamento (15%)
        Licitação da obra (10%)
        Licenciamento (5%)
        Obras - Fase 1 (15%)
        Obras - Fase 2 (25%)
        Implantação de estrutura (5%)
        Recursos Humano (5%)
        Equipamento em operação (5%)
        Peso do projeto sobre o total da meta (%)
        Orçamento executado (Liquidado e a liquidar) 2013
        Andamento qualitativo 1
        Andamento qualitativo 2
        Andamento qualitativo 3
        Andamento qualitativo 4
        Andamento qualitativo 5
        Andamento qualitativo 6
        """
