<?php
/**
 * Created by PhpStorm.
 * User: csw
 * Date: 2018/5/7
 * Time: 10:07
 */
class CommonLogic extends CI_Logic{

    /**csw
     * 获取左侧导航的连接信息
     */
    public function getSlidebarLink()
    {
        $this->config->load('common');
        $slideBarLink = $this->config->item('slidebarLink');
        return $slideBarLink;
    }


    /**csw
     * 字段唯一性验证
     * 判断将要添加（修改）的数据是否唯一
     */
    public function isUnique($table,$field,$val,$id='')
    {
        $this->load->model('commonModel');
        if(!$id)
            $res = $this->commonModel->addUnique($table,$field,$val);
        else
            $res = $this->commonModel->editUnique($table,$field,$val,$id);

        $res = $res ? false : true;
        return $res;
    }


}