<?php

class Goal extends Eloquent
{
    public static $statusName = array(
        5=>'superada',
        4=>'concluída',
        3=>'em andamento com benefícios à população',
        2=>'em andamento',
        1=>'não iniciada'
    );

    public function secretaries()
    {
        return $this->belongsToMany('Secretary');
    }

    public function projects()
    {
        return $this->hasMany("Project");
    }

    public function axis()
    {
        return $this->hasOne("Axis");
    }

    public function objectives()
    {
        return $this->hasOne("Objective");
    }

    public function articulations()
    {
        return $this->hasOne("Articulation");
    }

    public function scopeAxis($query, $value)
    {
        if (is_null($value)) {
            return $query;
        }
        return $query->where('axis_id', '=', $value);
    }

    public function scopeArticulation($query, $value)
    {
        if (is_null($value)) {
            return $query;
        }
        return $query->where('articulation_id', '=', $value);
    }

    public function scopeObjective($query, $value)
    {
        if (is_null($value)) {
            return $query;
        }
        return $query->where('objective_id', '=', $value);
    }

    public function scopeStatus($query, $value)
    {
        if (is_null($value)) {
            return $query;
        }

        if ($value == 2) {
            $value = array(2,3);
        } elseif ($value == 3) {
            $value = array(3,4,5);
        } elseif ($value == 4) {
            $value = array(4,5);
        } else {
            $value = array($value);
        }

        return $query->whereIn('status', $value);
    }

    public function scopePrefecture($query, $value)
    {
        if (is_null($value)) {
            return $query;
        }

        $query = $query->whereHas('projects', function ($q) use ($value) {
            $q
                ->join('prefecture_project', 'prefecture_project.project_id', '=', 'projects.id')
                ->where('prefecture_project.prefecture_id', '=', $value);
            return $q;
        });

        return $query;
    }

    public function scopeSecretary($query, $value)
    {
        if (is_null($value)) {
            return $query;
        }

        return $query->whereHas('secretaries', function ($q) use ($value) {
            $q->where('goal_secretary.secretary_id', '=', $value);
        });
    }
}
