<?php

class ProjectMonthlyProgress extends Eloquent
{
    protected $guarded = array('id', 'created_at', 'updated_at');

    protected $dates = array('month_year');

    protected $fillable = array(
        'project_id',
        'prefecture_id',
        'goal_target',
        'month_year',
        'value'
    );

    public function project()
    {
        return $this->belongsTo("Project");
    }

    public function prefecture()
    {
        return $this->belongsTo("Prefecture");
    }
}
