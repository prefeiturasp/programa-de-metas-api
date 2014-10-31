<?php

use \Src\Milestones;

class GoalController extends BaseController
{
    public function index()
    {
        $axis = Input::get('axis');
        $articulation = Input::get('articulation');
        $objective = Input::get('objective');

        $secretary = Input::get('secretary');
        $prefecture = Input::get('prefecture');
        $status = Input::get('status');
        $label = Input::get('label');

        //Cache::forget('homepage.goals');
        //$metas = Cache::rememberForever('homepage.goals', function () use ($axis, $articulation, $objective, $prefecture, $secretary) {

        $metas = Goal::with(array('secretaries', 'projects.prefectures'))
                    ->axis($axis)
                    ->status($status)
                    ->articulation($articulation)
                    ->objective($objective)
                    ->prefecture($prefecture)
                    ->secretary($secretary)
                    ->label($label)
                    ->get();

        foreach ($metas as $k => $meta) {

            $meta['status'] = Goal::$statusName[$meta['status']];

            // IF PARA AS METAS 8 e 9 QUE NÃO POSSUEM PROJETO ASSOCIADO
            if (count($meta['projects'])>0) {

            }

            $meta->porcentagem = $this->getStatus($meta['projects'], $meta['id']);

            $metas[$k] = $meta;
        }

        return $metas;
    }

    public function follow($goal_id)
    {
        $email = Input::get('email');
        $name = Input::get('name');
        return Follow::create(array('email'=>$email, 'goal_id'=>$goal_id, 'name'=>$name));
    }

    public function progress($goal_id)
    {
        $project_list = Project::where('goal_id', '=', $goal_id)->get();
        //$project_list = Project::with('projectMilestones')->where('goal_id', '=', $goal_id)->get();
        $progress['tipos_agrupados'] = $progress['tipo5'] = $progress['tipo6'] = $progress['tipo7'] = $progress['tipo8'] = array();
        $progress['tipos_agrupados'][1] =$progress['tipos_agrupados'][2] = $progress['tipos_agrupados'][3] = 0;

        foreach ($project_list as $project) {
            $ja_contou = false;

            if ($project['project_type'] < 5) {
                $milestones = ProjectMilestone::where('project_id', '=', $project['id'])->get();

                // PROJETO CONCLUIDO
                $total_milestones = 0;
                foreach ($milestones as $milestone) {
                    $total_milestones = $total_milestones + $milestone['status'];
                }

                if (count($milestones)*100 == $total_milestones) {
                    $progress['tipos_agrupados'][3] = $progress['tipos_agrupados'][3] + 1;
                    $ja_contou = true;
                }

                // PROJETO EM FASE DE OBRA
                if (!$ja_contou) {
                    foreach ($milestones as $milestone) {
                        $milestones_of_group = Milestones::$groups[2]['milestones'][$project['project_type']];
                        if ((!$ja_contou) && ($milestone['status']>=50) && (in_array($milestone['milestone'], $milestones_of_group))) {
                            $progress['tipos_agrupados'][2] = $progress['tipos_agrupados'][2] + 1;
                            $ja_contou = true;
                        }
                    }
                }

                if (!$ja_contou) {
                    $progress['tipos_agrupados'][1] = $progress['tipos_agrupados'][1] + 1;
                }

            } elseif (($project['project_type'] > 4) && ($project['project_type'] < 8)) {

                $milestones = ProjectMilestone::where('project_id', '=', $project['id'])->get();

                foreach ($milestones as $milestone) {
                    $milestones_desc = Milestones::$data[$project['project_type']][$milestone['milestone']]['name'];
                    if ($milestone['status']==50) {
                        $progress['tipo'.$project['project_type']][$project['id']][$milestones_desc] = 'Em Andamento';
                    } elseif ($milestone['status']==100) {
                        $progress['tipo'.$project['project_type']][$project['id']][$milestones_desc] = 'Concluída';
                    } else {
                        $progress['tipo'.$project['project_type']][$project['id']][$milestones_desc] = 'Não Iniciada';
                    }
                }

            } elseif ($project['project_type'] == 8) {
                $projectMonthlyProgress = ProjectMonthlyProgress::with('prefecture')->where('project_id', '=', $project['id'])->get();
                foreach ($projectMonthlyProgress as $monthlyProgress) {
                    //$date = DateTime::createFromFormat('Y-m-d H:i:s', $monthlyProgress['month_year']);

                    $month_year = $monthlyProgress['month_year']->format('F');
                    if (in_array($goal_id, $this->goals_grouped)) {
                        if (isset($progress['tipo8'][0][$month_year])) {
                            $progress['tipo8'][0][$month_year] = $progress['tipo8'][0][$month_year] + intval($monthlyProgress['value']);
                        } else {
                            $progress['tipo8'][0][$month_year] = intval($monthlyProgress['value']);
                        }
                    } else {
                        if (isset($progress['tipo8'][$monthlyProgress['project_id']][$month_year])) {
                            $progress['tipo8'][$monthlyProgress['project_id']][$month_year] = $progress['tipo8'][$monthlyProgress['project_id']][$month_year] + intval($monthlyProgress['value']);
                        } else {
                            $progress['tipo8'][$monthlyProgress['project_id']][$month_year] = intval($monthlyProgress['value']);
                        }
                    }
                }
            }

        }

        return $progress;
    }

    public function status($goal_id)
    {
        $project_list = Project::where('goal_id', '=', $goal_id)->get();
        return $this->getStatus($project_list, $goal_id);
    }

    protected function getStatus($project_list, $goal_id)
    {
        if ($goal_id ==89) {
            return array('concluido'=>47.6, 'restante'=>52.4);
        } else if ($goal_id ==114) {
            return array('concluido'=>100, 'restante'=>0);
        }
        if (in_array($goal_id, $this->goals_grouped)) {
            return $this->calculatePercentageGrouped($project_list);
        } else {
            return $this->calculatePercentage($project_list);
        }
    }

    // LÓGICA DUPLICADA POR UMA INVENÇÃO DE ÚLTIMA HORA DO PEDRO
    protected function calculatePercentageGrouped($project_list)
    {
        $total = $total_projeto = $total_weight = 0;

        if (count($project_list)>0) {
            foreach ($project_list as $project) {
                if ($project['project_type'] < 8) {
                    $total = $total + (floatval($project['weight_about_goal'])*$this->getMilestonesPercentageComplete($project['id'], $project['project_type']));
                }
            }

            foreach ($project_list as $project) {
                if ($project['project_type'] == 8) {
                    if ($project['weight_about_goal'] == 0) {
                        $total = 0;
                    } else {
                        $total_projeto = $total_projeto + $this->getMonthByMonthPercentageComplete($project['id'], $project['goal_id']);
                    }
                    $project_id_default = $project['id'];
                    $weight_about_goal = $project['weight_about_goal'];
                }
            }

            $project_default = ProjectMonthlyProgress::where('project_id', '=', $project_id_default)->first();

            $weight_about_goal = floatval($weight_about_goal);
            $total_projeto = floatval($total_projeto);
            $goal_target = floatval($project_default['goal_target']);

            $total = $total + (($weight_about_goal*$total_projeto) / $goal_target);
        }

        return array('concluido'=>$total,'restante'=>100-$total);
    }

    protected function calculatePercentage($project_list)
    {
        $total = 0;

        if (count($project_list)>0) {
            foreach ($project_list as $project) {
                if ($project['project_type'] < 8) {
                    $total = $total + (floatval($project['weight_about_goal'])*$this->getMilestonesPercentageComplete($project['id'], $project['project_type']));
                } elseif ($project['project_type'] == 8) {
                    if ($project['weight_about_goal'] == 0) {
                        $total = 0 + $total;
                    } else {
                        $total = $total + (floatval($project['weight_about_goal'])*$this->getMonthByMonthPercentageComplete($project['id'],$project['goal_id']));
                    }
                }
            }
        }

        return array('concluido'=>$total,'restante'=>100-$total);
    }

    protected function getMonthByMonthPercentageComplete($project_id, $goal_id)
    {
        $total_complete = 0;
        $ProjectMonthlyProgress = ProjectMonthlyProgress::where('project_id', '=', $project_id)->get();

        foreach ($ProjectMonthlyProgress as $monthlyProgress) {
            $total_complete = $total_complete + $monthlyProgress['value'];
        }

        if ((empty($ProjectMonthlyProgress[0]['goal_target'])) || ($ProjectMonthlyProgress[0]['goal_target'] == 0)) {
            $total_projeto = 0;
        } else {


            if (in_array($goal_id, $this->goals_grouped)) {
                // var_dump($total_complete, $project_id);
                $total_projeto = $total_complete;
            } else {
                $total_projeto = ($total_complete)/$ProjectMonthlyProgress[0]['goal_target'];
            }
        }

        return $total_projeto;
    }

    protected function getMilestonesPercentageComplete($project_id, $project_type)
    {

        $total_complete = array();
        $projectMilestones = ProjectMilestone::where('project_id', '=', $project_id)->get();

        foreach ($projectMilestones as $milestone) {
            $porcentagem = Milestones::$data[$project_type];

            if (!isset($total_complete[$milestone['project_id']][$milestone['prefecture_id']])) {
                if ($milestone['status'] == 50) {
                    $total_complete[$milestone['project_id']][$milestone['prefecture_id']] = $porcentagem[$milestone['milestone']]['percentage'] / 2;
                } elseif ($milestone['status'] > 50) {
                    $total_complete[$milestone['project_id']][$milestone['prefecture_id']] = $porcentagem[$milestone['milestone']]['percentage'];
                } else {
                    $total_complete[$milestone['project_id']][$milestone['prefecture_id']] = 0;
                }
            } else {
                if ($milestone['status'] == 50) {
                    $total_complete[$milestone['project_id']][$milestone['prefecture_id']] = $total_complete[$milestone['project_id']][$milestone['prefecture_id']] + ($porcentagem[$milestone['milestone']]['percentage'] / 2);
                } elseif ($milestone['status'] > 50) {
                    $total_complete[$milestone['project_id']][$milestone['prefecture_id']] = $total_complete[$milestone['project_id']][$milestone['prefecture_id']] + $porcentagem[$milestone['milestone']]['percentage'];
                } else {
                    $total_complete[$milestone['project_id']][$milestone['prefecture_id']] = $total_complete[$milestone['project_id']][$milestone['prefecture_id']] + 0;
                }
            }
        }

        $total_projeto = 0;
        foreach ($total_complete as $total_by_prefecture) {
            foreach ($total_by_prefecture as $prefecture_id => $value) {
                if ($value != 0) {
                    $total_projeto = $total_projeto + ($value/100);
                }
            }
        }

        return $total_projeto;
    }

    public function show($id)
    {
        $meta = Goal::with(array('secretaries', 'projects.prefectures'))->find($id);

        $meta['status'] = Goal::$statusName[$meta['status']];

        // IF PARA AS METAS 8 e 9 QUE NÃO POSSUEM PROJETO ASSOCIADO
        if (count($meta['projects'])>0) {

        }

        $meta->porcentagem = $this->getStatus($meta['projects'], $meta['id']);

        return $meta;
    }

    public function relatedProjects($goal_id)
    {
        return Project::findByGoal($goal_id);
    }
}
