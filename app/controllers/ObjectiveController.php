<?php

class ObjectiveController extends BaseController
{
    public function index()
    {
        return Objective::all();
    }
}
