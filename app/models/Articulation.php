<?php

class Articulation extends Eloquent
{
    public function goals()
    {
        return $this->hasMany("Goal");
    }
}
