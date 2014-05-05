<?php

class Project extends Eloquent
{
    protected $guarded = array('id', 'created_at', 'updated_at');

    protected $fillable = array(
        'name',
        'goal_id',
        'address',
        'district',
        'gps_lat',
        'gps_long',
        'weight_about_goal',
        'budget_executed',
        'project_type',
        'qualitative_progress_1',
        'qualitative_progress_2',
        'qualitative_progress_3',
        'qualitative_progress_4',
        'qualitative_progress_5',
        'qualitative_progress_6',
    );

    public function goal()
    {
        return $this->belongsTo("Goal");
    }

    public function prefectures()
    {
        return $this->belongsToMany('Prefecture');
    }

    public function projectMilestones()
    {
        return $this->hasMany("ProjectMilestone");
    }

    public function projectsMonthlyProgresses()
    {
        return $this->hasMany("ProjectMonthlyProgress");
    }

    public static function findByNameAndType($name, $type)
    {
        $name = Str::lower(trim($name));
        return self::where(DB::raw('LOWER(name)'), '=', $name)
                ->where('project_type', '=', $type)
                ->first();
    }

    public static function findByGoal($goal_id)
    {
        return self::where('goal_id', '=', $goal_id)->get();
    }
}
