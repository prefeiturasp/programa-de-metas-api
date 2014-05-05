<?php

class Prefecture extends Eloquent
{

    public function projects()
    {
        return $this->belongsToMany('Project');
    }

    protected function findByName($name)
    {
        return self::where(DB::raw('LOWER(name)'), 'like', Str::lower(trim($name)))->first();
        //return self::where('name', '=', $name)->first();
    }
}
