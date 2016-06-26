<?php
class IndexController extends Controller
{
    public function __empty(){
        echo 'empty action ';
    }

    public function index(){
        //$code = new Code();
        //echo $code->show();
        $this->assign('var', 'dddddddd');
        $this->display();
    }
}