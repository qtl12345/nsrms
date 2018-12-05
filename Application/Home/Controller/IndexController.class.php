<?php

namespace Home\Controller;

class IndexController extends BaseController {

    public function index() {
        $username = $_SESSION['user_name'];
        $d = M('manager')->where("user_name='$username'")->find();
        $user_role_id = $d['user_role_id'];
        $rolemanger = M('role')->where("user_role_id='$user_role_id'")->find();
        $mangerid = $rolemanger['role_auth_id'];
        $map['id'] = array('in', $mangerid);
        $map['iframe'] = array('eq', 1);
        $mangername = M('auth')->where($map)->select();
        $m['id'] = array('in', $mangerid);
        $m['iframe'] = array('eq', 0);
        $b = M('auth')->where($m)->select();
        $this->assign('subseries', $b);
        $this->assign('mangername', $mangername);
        $this->display();
    }

    public function info() {
        $this->display();
    }

    public function addtree() {
        
    }

}
