<?php

use \Src\Milestones;

class ProjectController extends BaseController
{
    public function show($id)
    {
        return Project::with(array('goal', 'prefectures'))->find($id);
    }

    public function types()
    {
        return array(
            array('id'=>'1','name'=>'Construção de equipamento'),
            array('id'=>'2','name'=>'Obras de infraestrutura'),
            array('id'=>'3','name'=>'Novos equipamentos em imóvel alugado'),
            array('id'=>'4','name'=>'Equipamentos readequados'),
            array('id'=>'5','name'=>'Novos órgãos ou estruturas administrativas'),
            array('id'=>'6','name'=>'Sistemas'),
            array('id'=>'7','name'=>'Atos Normativos'),
            array('id'=>'8','name'=>'Novos serviços ou benefícios'),
            );
    }

    public function status($id)
    {

    }

    public function progress($project_id)
    {
        $project = Project::find($project_id);
        if ($project['project_type'] == 8) {
            return ProjectMonthlyProgress::with('prefecture')->where('project_id', '=', $project_id)->get();
        } else {
            return ProjectMilestone::where('project_id', '=', $project_id)->get();
        }
    }

    public function milestones($id)
    {
        switch ($id) {
            case '1':
                return Milestones::$data[1];

                break;
            case '2':
                return Milestones::$data[2];

                break;
            case '3':
                return Milestones::$data[3];

                break;
            case '4':
                return Milestones::$data[4];

                break;
            case '5':
                return Milestones::$data[5];

                break;
            case '6':
                return Milestones::$data[6];

                break;
            case '7':
                return Milestones::$data[7];

                break;

            default:
                # code...
                break;
        }
    }
}
