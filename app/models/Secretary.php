<?php

class Secretary extends Eloquent
{
    public function goals()
    {
        return $this->belongsToMany('Goal');
    }

    protected function findByAcronym($acronym)
    {
        return self::where(DB::raw('LOWER(acronym)'), '=', Str::lower(trim($acronym)))->first();
    }
}
