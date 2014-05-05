<?php

class Follow extends Eloquent
{
    protected $guarded = array('id', 'created_at', 'updated_at');

    protected $fillable = array(
        'goal_id',
        'name',
        'email'
    );

    public function goals()
    {
        return $this->belongsTo("Goal");
    }
}
