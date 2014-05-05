<?php

class AxisController extends BaseController
{
    public function index()
    {
        return Axis::all();
    }
}
