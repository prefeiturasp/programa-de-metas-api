## Programa De Metas

### Configuração inicial

1. clone this repo
2. install vendor libraries ```composer install```
3. configure database at ```app/config/database.php```
4. run migrations ```php artisan migrate```
5. run seeds ```php artisan db:seed```

### API

É recomendado que seja utilizada a biblioteca [guzzle](http://guzzle.readthedocs.org/en/latest/)

Endpoints disponíveis:

*   /axes -> lista eixos diponíveis
*   /articulations -> lista articulações diponíveis
*   /objectives -> lista objetivos diponíveis
*   /secretaries -> lista secretarias diponíveis
*   /prefectures -> lista sub-prefeitura diponíveis
**   /prefectures?cep=04087-002 -> procura sub-prefeitura por CEP

*   /goals -> lista de todas as metas
*   /goals?axis=1 -> lista de todas as metas do eixo_id 1
*   /goals?articulation=1 -> lista de todas as metas da articulação #1
*   /goals?objective=1 -> lista de todas as metas do objetivo #1
*   /goals?secretary=1 -> lista de todas as metas da secretary #1
*   /goals?prefecture=1 -> lista de todas as metas do prefecture #1

*   /goal/1 -> detalhes da meta 1
*   /goal/1/status -> retorna a porcentagem total da meta
*   /goal/1/progress -> retorna progresso por grupo de etapas e/ou por mês
*   /goal/1/follow -> seguir meta #1 { email: "lucaspirola@gmail.com", nome: "Lucas Pirola", goal_id: 1 }
*   /goal/1/projects -> lista de projetos da meta 1

*   /projects -> lista de todos os projetos
*   /project/1 -> detalhes do projeto 1
*   /project/1/status -> retorna total
*   /project/1/progress -> retorna
*   /projects?type=5 -> lista de todos os projetos da tipologia 5

### Importação (não finalizada)

Listar os arquivos disponíveis para importação

```
php artisan importer
```

Listar as Worksheets da planilha especificada

```
php artisan importer --filename=decima-primeira-versao-02-04.xls
```

Importar somente as metas

```
php artisan importer:load --filename=decima-primeira-versao-02-04.xls --type=goal
```

Importar projetos de cada tipologia separadamente

```
php artisan importer:load --filename=decima-primeira-versao-02-04.xls --type=project --milestone=1
php artisan importer:load --filename=decima-primeira-versao-02-04.xls --type=project --milestone=2
php artisan importer:load --filename=decima-primeira-versao-02-04.xls --type=project --milestone=3
php artisan importer:load --filename=decima-primeira-versao-02-04.xls --type=project --milestone=4
php artisan importer:load --filename=decima-primeira-versao-02-04.xls --type=project --milestone=5
php artisan importer:load --filename=decima-primeira-versao-02-04.xls --type=project --milestone=6
php artisan importer:load --filename=decima-primeira-versao-02-04.xls --type=project --milestone=7
php artisan importer:load --filename=decima-primeira-versao-02-04.xls --type=project --milestone=8
php artisan importer:load --filename=decima-primeira-versao-02-04.xls --type=project --milestone=9
```

### Testes (forma atual de importação)

Lista de testes implementados e como rodá-los separadamente

```
php artisan behat:run read_xls_file         # read a cell on spreadsheet
php artisan behat:run parse_xls_file        # easily get content from goals and projects
php artisan behat:run validation_xls_file   # validate all data based on some rules
php artisan behat:run importer_xls_file     # import validate data to database
```
