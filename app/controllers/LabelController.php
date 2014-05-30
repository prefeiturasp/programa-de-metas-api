<?php

class LabelController extends BaseController
{
    public function index()
    {
        return Goal::$labelName;
    }
}
