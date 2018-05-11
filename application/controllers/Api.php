<?php
/**
 * Created by PhpStorm.
 * User: csw
 * Date: 2018/5/9
 * Time: 16:30
 */

class Api extends CI_Controller{

    public function addNormCensus()
    {
        $this->load->logic('normLogic');

        $normId = $this->input->post('normId');
        $normValue = $this->input->post('normValue');
        $normTime = $this->input->post('normTime');

        $resAdd = $this->normLogic->addNormCensus($normId,$normValue,$normTime);
        header('Content-type:application/json');
        echo json_encode($resAdd);
    }


    private function addTestData()
    {
        $this->load->logic('normLogic');
        $this->normLogic->addTestData();
    }

}