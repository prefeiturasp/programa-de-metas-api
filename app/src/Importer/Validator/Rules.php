<?php
namespace Src\Importer\Validator;

class Rules
{
    public static $rules = array(
        'goal' => array(
            'name'             => 'stringLowerThan350',
            'secretaries'      => array('splitContentByComma', 'getSecretaryRegisteredId'),
            'status'           => 'getValidStatus'
        ),
        'project' => array(
            1 => array(
                'goal_id'     => 'getGoalRegisteredId',
                'name'        => 'stringLowerThan255',
                'prefectures' => array('splitContentByComma', 'getPrefectureRegisteredId'),
                'gps'         =>  array('splitContentByComma', 'validateCoordinates'),
                'milestones'  => array('verifyAllRequiredMilestonesExists'), // apenas para entrar no loop de validacao
                'weight_about_goal' => 'validPercentage',
                'budget_executed' => 'validFloatNumber'
            ),
            2 => array(
                'goal_id'     => 'getGoalRegisteredId',
                'name'        => 'stringLowerThan255',
                'prefectures' => array('splitContentByComma', 'getPrefectureRegisteredId'),
                'gps'         =>  array('splitContentByComma', 'validateCoordinates'),
                'milestones'  => array('verifyAllRequiredMilestonesExists'), // apenas para entrar no loop de validacao
                'weight_about_goal' => 'validPercentage',
                'budget_executed' => 'validFloatNumber'
            ),
            3 => array(
                'goal_id'     => 'getGoalRegisteredId',
                'name'        => 'stringLowerThan255',
                'prefectures' => array('splitContentByComma', 'getPrefectureRegisteredId'),
                'gps'         =>  array('splitContentByComma', 'validateCoordinates'),
                'milestones'  => array('verifyAllRequiredMilestonesExists'), // apenas para entrar no loop de validacao
                'weight_about_goal' => 'validPercentage',
                'budget_executed' => 'validFloatNumber'
            ),
            4 => array(
                'goal_id'     => 'getGoalRegisteredId',
                'name'        => 'stringLowerThan255',
                'prefectures' => array('splitContentByComma', 'getPrefectureRegisteredId'),
                'gps'         =>  array('splitContentByComma', 'validateCoordinates'),
                'milestones'  => array('verifyAllRequiredMilestonesExists'), // apenas para entrar no loop de validacao
                'weight_about_goal' => 'validPercentage',
                'budget_executed' => 'validFloatNumber'
            ),
            5 => array(
                'goal_id'     => 'getGoalRegisteredId',
                'name'        => 'stringLowerThan255',
                'prefectures' => array('splitContentByComma', 'getPrefectureRegisteredId'),
                'gps'         =>  array('splitContentByComma', 'validateCoordinates'),
                'milestones'  => array('verifyAllRequiredMilestonesExists'), // apenas para entrar no loop de validacao
                'weight_about_goal' => 'validPercentage',
                'budget_executed' => 'validFloatNumber'
            ),
            6 => array(
                'goal_id'     => 'getGoalRegisteredId',
                'name'        => 'stringLowerThan255',
                'prefectures' => array('splitContentByComma', 'getPrefectureRegisteredId'),
                'milestones'  => array('verifyAllRequiredMilestonesExists'), // apenas para entrar no loop de validacao
                'weight_about_goal' => 'validPercentage',
                'budget_executed' => 'validFloatNumber'
            ),
            7 => array(
                'goal_id'     => 'getGoalRegisteredId',
                'name'        => 'stringLowerThan255',
                'prefectures' => array('splitContentByComma', 'getPrefectureRegisteredId'),
                'milestones'  => array('verifyAllRequiredMilestonesExists'), // apenas para entrar no loop de validacao
                'weight_about_goal' => 'validPercentage',
                'budget_executed' => 'validFloatNumber'
            ),
            8 => array(
                'goal_id'     => 'getGoalRegisteredId',
                'name'        => 'stringLowerThan255',
                'goal_target' => 'validFloatNumber',
                'prefectures' => array('splitContentByComma', 'getPrefectureRegisteredId'),
                'gps'         =>  array('splitContentByComma', 'validateCoordinates'),
                'months'      => array('verifyAllRequiredMonthsExists'), // apenas para entrar no loop de validacao
                'weight_about_goal' => 'validPercentage'
            )
        )
    );
}
