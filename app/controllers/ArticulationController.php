<?php

class ArticulationController extends BaseController
{
    public function index()
    {
        return Articulation::all();
    }
}
