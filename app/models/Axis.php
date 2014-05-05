<?php

class Axis extends Eloquent
{
    public function goals()
    {
        return $this->hasMany("Goal");
    }
}
