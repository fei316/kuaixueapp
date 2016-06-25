<?php
class IndexController extends Controller
{
    public function __init(){
        //echo '应用Index构造方法执行';
    }

    public function index(){
        //$this->success('成功');
        //$this->error('失败');
        //go('http://www.baidu.com', 2, '一会儿就跳走啦');
        p(IS_AJAX);
        if (IS_POST) {
            p($_POST);
        }
        $this->display();
    }

    public function add(){
        //$this->display();
    }
}