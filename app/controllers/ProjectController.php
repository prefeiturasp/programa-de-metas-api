<?php
use \Src\Milestones;
use \GeoJson\Geometry\Point;
use \GeoJson\Feature\Feature;
use \GeoJson\Feature\FeatureCollection;

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
    /**
     *  {
     *      type: "Feature",
     *      properties: {
     *          id: 1,
     *          name: "Ecoponto Água Rasa",
     *          goal_id: 91,
     *          project_type: 1,
     *          district: "Água Rasa",
     *          address: "Av. Salim Farah Maluf, 1500",
     *          gps_lat: -23.556476,
     *          gps_long: -46.577297,
     *          weight_about_goal: 1.19,
     *          budget_executed: 157992.35,
     *          qualitative_progress_1: "NULL",
     *          qualitative_progress_2: "NULL",
     *          qualitative_progress_3: "NULL",
     *          qualitative_progress_4: "NULL",
     *          qualitative_progress_5: "NULL",
     *          qualitative_progress_6: "NULL",
     *          created_at: "2014-04-03 12:25:28",
     *          updated_at: "2014-04-03 12:25:28"
     *      },
     *      geometry: {
     *          type: "Point",
     *          coordinates: [
     *          -46.577297,
     *          -23.556476
     *          ]
     *      }
     *  },
    **/
    public function geojson()
    {
        $projects = $features = array();

        $projects = Project::with(array('goal.secretaries', 'goal', 'prefectures'))->take(100)->get();

        foreach ($projects as $project) {
            $point = new Point(array(floatval($project['gps_lat']), floatval($project['gps_long'])));
            $properties = array(
                'id'           => $project['id'],
                'name'         => $project['name'],
                'address'      => $project['address'],
                'prefectures'  => $project['prefectures']->toArray(),
                'secretary'    => $project['goal']['secretaries']->toArray(),
                'objective'    => $project['goal']['objective_id'],
                'goal_id'      => $project['goal_id'],
                'location_type'=> $project['location_type']
            );
            $features[] = new Feature($point, $properties);
        }

        return json_encode(new FeatureCollection($features));
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
