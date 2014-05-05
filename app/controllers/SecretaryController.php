<?php

class SecretaryController extends BaseController
{
    public function index()
    {
        return Secretary::all();
    }
}
