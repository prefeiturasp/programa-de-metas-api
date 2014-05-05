<?php

class ProjectMilestone extends Eloquent
{
    protected $guarded = array('id', 'created_at', 'updated_at');

    protected $fillable = array(
        'project_id',
        'prefecture_id',
        'milestone',
        'status',
    );

    public function projects()
    {
        return $this->belongsTo("Project");
    }
}
