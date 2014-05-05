<?php

class BaseController extends Controller {

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */

    protected $goals_grouped = array(
            11, // (consultórios na rua),
            35, // (Unid. Habitacionais),
            37, // (Regularização fundiária),
            42, // (Casas de mediação),
            47, // (Esporte 24h),
            54, // (CEFAI),
            73, // (Praças wifi),
            89, // (Coleta seletiva),
            97 // (ciclovias)
        );
    protected function setupLayout()
    {
        if ( ! is_null($this->layout))
        {
            $this->layout = View::make($this->layout);
        }
    }

}
