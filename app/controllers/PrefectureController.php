<?php

use \Src\pointLocation;

class PrefectureController extends BaseController
{
    public function index()
    {
        return Prefecture::all();
    }

    public function findByCoordinates($lat, $long)
    {


        $pointLocation = new pointLocation();
        //$points = array("-46.65794169999999 -23.6071459");
        //$points = array("-90.80756 40.6363267");
        $points = array($long . " " . $lat);

        //$polygon = array("-50 30","50 70","100 50","80 10","110 -10","110 -30","-20 -50","-30 -40","10 -10","-10 10","-30 -20","-50 30");

        $path = app_path() . '/storage/importer/';

        $string = file_get_contents($path."prefecture.json");
        $json_a=json_decode($string,true);

        foreach ($json_a['features'] as $feature) {
            $polygon = array();

            foreach ($feature['geometry']['coordinates'] as $coord2) {
                if (is_array($coord2)) {
                    foreach ($coord2 as $coord) {
                        $polygon[] = $coord[0] . " " . $coord[1];
                    }
                }

            }

            if ($pointLocation->pointInPolygon($points[0], $polygon) == 'inside') {
                $prefecture = Prefecture::where('name', 'like', '%'.mb_strtolower($feature['properties']['name']))->get();

                if (count($prefecture) > 0) {
                    return $prefecture;
                }
            }
        }
    }
}
