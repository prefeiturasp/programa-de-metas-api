<?php

namespace Src;

class Milestones
{
    public static $groups = array(
        '1' => array(
                'nome' => 'em etapas anteriores ao início das obras',
                'milestones' => array(
                        '1' => array(1,2,3,4,5),
                        '2' => array(1,2,3,4,5),
                        '3' => array(1,2,3),
                        '4' => array(1,2,3)
                )
            ),
        '2' => array(
                'nome' => 'em obras ou implantação de estruturas',
                'milestones' => array(
                        '1' => array(6,7,8),
                        '2' => array(6,7),
                        '3' => array(4,5),
                        '4' => array(4,5)
                )
            ),
        '3' => array(
                'nome' => 'concluídos(as)'
            )
    );
    public static $data = array(
        '1' => array(
                1 => array(
                    'name'=>'Definição de Terreno',
                    'percentage'=>10
                ),
                2 => array(
                    'name'=>'Projeto Básico',
                    'percentage'=>5
                ),
                3 => array(
                    'name'=>'Garantia da fonte de financiamento',
                    'percentage'=>10
                ),
                4 => array(
                    'name'=>'Licencia-mento',
                    'percentage'=>5
                ),
                5 => array(
                    'name'=>'Licitação da obra',
                    'percentage'=>10
                ),
                6 => array(
                    'name'=>'Obras - Fase 1',
                    'percentage'=>20
                ),
                7 => array(
                    'name'=>'Obras - Fase 2',
                    'percentage'=>35
                ),
                8 => array(
                    'name'=>'Estruturação para funcionamento',
                    'percentage'=>5
                )),
        '2' => array(
                1 => array(
                    'name'=>'Projeto Básico',
                    'percentage'=>5
                ),
                2 => array(
                    'name'=>'Garantia da fonte de financiamento',
                    'percentage'=>20
                ),
                3 => array(
                    'name'=>'Licitação da Obra',
                    'percentage'=>5
                ),
                4 => array(
                    'name'=>'Licenciamento',
                    'percentage'=>5
                ),
                5 => array(
                    'name'=>'Desapropriação',
                    'percentage'=>25
                ),
                6 => array(
                    'name'=>'Obras de infraestrutura Fase 1',
                    'percentage'=>10
                ),
                7 => array(
                    'name'=>'Obras de infraestrutura Fase 2',
                    'percentage'=>30
                )),
        '3' => array(
                1 => array(
                    'name'=>'Identificação do imóvel',
                    'percentage'=>25
                ),
                2 => array(
                    'name'=>'Contrato de Aluguel',
                    'percentage'=>5
                ),
                3 => array(
                    'name'=>'Garantia da fonte de financiamento',
                    'percentage'=>15
                ),
                4 => array(
                    'name'=>'Obras - Reforma',
                    'percentage'=>25
                ),
                5 => array(
                    'name'=>'Implantação de estrutura',
                    'percentage'=>30
                )
            ),
        '4' => array(
                1 => array(
                    'name'=>'Projeto de Readequação',
                    'percentage'=>10
                ),
                2 => array(
                    'name'=>'Garantia da fonte de financiamento',
                    'percentage'=>10
                ),
                3 => array(
                    'name'=>'Licitação da obra',
                    'percentage'=>10
                ),
                4 => array(
                    'name'=>'Obras de readequação',
                    'percentage'=>45
                ),
                5 => array(
                    'name'=>'Implantação de estrutura',
                    'percentage'=>25
                )),
        '5' => array(
                1 => array(
                    'name'=>'Construção de instrumentos normativos e/ou do modelo de gestão',
                    'percentage'=>30
                ),
                2 => array(
                    'name'=>'Aprovação dos instrumentos normativos e/ou do modelo de gestão',
                    'percentage'=>35
                ),
                3 => array(
                    'name'=>'Infraestrutura e  equipamentos',
                    'percentage'=>35
                )),
        '6' => array(
                1 => array(
                    'name'=>'Definição de escopo',
                    'percentage'=>5
                ),
                2 => array(
                    'name'=>'Garantia da fonte de financiamento',
                    'percentage'=>10
                ),
                3 => array(
                    'name'=>'Desenvolvimento de Sistema Etapa 1',
                    'percentage'=>25
                ),
                4 => array(
                    'name'=>'Desenvolvimento de Sistema Etapa 2',
                    'percentage'=>40
                ),
                5 => array(
                    'name'=>'Definição do Modelo de Gestão/de Funcionamento',
                    'percentage'=>5
                ),
                6 => array(
                    'name'=>'Homologação',
                    'percentage'=>15
                )),
        '7' => array(
                1 => array(
                    'name'=>'Estudos e diagnósticos iniciais',
                    'percentage'=>15
                ),
                2 => array(
                    'name'=>'Elaboração da minuta inicial',
                    'percentage'=>15
                ),
                3 => array(
                    'name'=>'Consultas públicas',
                    'percentage'=>20
                ),
                4 => array(
                    'name'=>'Aprovação técnica e elaboração da minuta final',
                    'percentage'=>20
                ),
                5 => array(
                    'name'=>'Análise e aprovação',
                    'percentage'=>30))
        );
}
