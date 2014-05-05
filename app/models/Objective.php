<?php

class Objective extends Eloquent
{
    public function goals()
    {
        return $this->hasMany("Goal");
    }
}
