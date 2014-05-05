<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
    return View::make('hello');
});

// goals
Route::get("goals/{axis?}{articulation?}{secretary?}{objective?}{prefecture?}", array(
    "uses" => "GoalController@index"
));

Route::get("goal/{id}", array(
    "uses" => "GoalController@show"
));

Route::post("goal/{id}/follow", array(
    "uses" => "GoalController@follow"
));

Route::get("goal/{id}/progress", array(
    "uses" => "GoalController@progress"
));
Route::get("goal/{id}/status", array(
    "uses" => "GoalController@status"
));
Route::get("goal/{id}/projects", array(
    "uses" => "GoalController@relatedProjects"
));

// projects
Route::get("projects/types", array(
    "uses" => "ProjectController@types"
));
Route::get("project/type/{id}/milestones", array(
    "uses" => "ProjectController@milestones"
));
Route::get("project/{id}", array(
    "uses" => "ProjectController@show"
));
Route::get("project/{id}/status", array(
    "uses" => "ProjectController@status"
));
Route::get("project/{id}/progress", array(
    "uses" => "ProjectController@progress"
));

// helpers
Route::get("axes", array(
    "uses" => "AxisController@index"
));
Route::get("objectives", array(
    "uses" => "ObjectiveController@index"
));
Route::get("secretaries", array(
    "uses" => "SecretaryController@index"
));
Route::get("prefectures", array(
    "uses" => "PrefectureController@index"
));
Route::get("prefectures/findByCoordinates/{lat}/{long}", array(
    "uses" => "PrefectureController@findByCoordinates"
));
Route::get("articulations", array(
    "uses" => "ArticulationController@index"
));
