<?php
namespace Src;

// http://assemblysys.com/php-point-in-polygon-algorithm/
class pointLocation
{
    public $pointOnVertex = true; // Check if the point sits exactly on one of the vertices?

    public function pointLocation()
    {

    }

    public function pointInPolygon($point, $polygon, $pointOnVertex = true)
    {
        $this->pointOnVertex = $pointOnVertex;

        // Transform string coordinates into arrays with x && y values
        $point = $this->pointStringToCoordinates($point);
        $vertices = array();
        foreach ($polygon as $vertex) {
            $vertices[] = $this->pointStringToCoordinates($vertex);
        }

        // Check if the point sits exactly on a vertex
        if (($this->pointOnVertex == true) && ($this->pointOnVertex($point, $vertices) == true)) {
            return "vertex";
        }

        // Check if the point is inside the polygon or on the boundary
        $intersections = 0;
        $vertices_count = count($vertices);

        for ($i=1; $i < $vertices_count; $i++) {
            $vertex1 = $vertices[$i-1];
            $vertex2 = $vertices[$i];
            if (($vertex1['y'] == $vertex2['y']) &&
                ($vertex1['y'] == $point['y']) &&
                ($point['x'] > min($vertex1['x'], $vertex2['x'])) &&
                ($point['x'] < max($vertex1['x'], $vertex2['x']))) {
                // Check if point is on an horizontal polygon boundary
                return "boundary";
            }
            if (($point['y'] > min($vertex1['y'], $vertex2['y'])) &&
                ($point['y'] <= max($vertex1['y'], $vertex2['y'])) &&
                ($point['x'] <= max($vertex1['x'], $vertex2['x'])) &&
                ($vertex1['y'] != $vertex2['y'])) {
                $xinters = ($point['y'] - $vertex1['y']) * ($vertex2['x'] - $vertex1['x']) / ($vertex2['y'] - $vertex1['y']) + $vertex1['x'];

                if ($xinters == $point['x']) { // Check if point is on the polygon boundary (other than horizontal)
                    return "boundary";
                }
                if (($vertex1['x'] == $vertex2['x']) || ($point['x'] <= $xinters)) {
                    $intersections++;
                }
            }
        }
        // If the number of edges we passed through is odd, then it's in the polygon.
        if ($intersections % 2 != 0) {
            return "inside";
        } else {
            return "outside";
        }
    }

    public function pointOnVertex($point, $vertices)
    {
        foreach ($vertices as $vertex) {
            if ($point == $vertex) {
                return true;
            }
        }
    }

    public function pointStringToCoordinates($pointString)
    {
        $coordinates = explode(" ", $pointString);

        $coordinates[0] = str_replace(',', '.', $coordinates[0]);
        $coordinates[1] = str_replace(',', '.', $coordinates[1]);

        return array("x" => (float)$coordinates[0], "y" => (float)$coordinates[1]);
    }
}
