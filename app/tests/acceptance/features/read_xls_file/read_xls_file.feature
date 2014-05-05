Feature: Read a xls file
	In order read a cell on spreadsheet
	As Developer
	I need to be able to open and read the xls file

Scenario: File not found
	Given There is a default directory to search files
	When I try to found a file named "arquivo-nao-existe.xls"
	Then I should throw a exception "Can not open, file not found"

Scenario: File founded
	Given There is a default directory to search files
	When I try to found a file named "teste-conteudo.xls"
	Then I should get complete path of file

Scenario: Read content of file 
	Given I try to open a file named "teste-conteudo.xls"
	And I load as excel content
	When I try to read column one and cell one 
	Then I should get "META"