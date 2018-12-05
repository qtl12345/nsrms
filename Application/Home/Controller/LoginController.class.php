<?php

namespace Home\Controller;

use Think\Controller;
use Think\Verify;

class LoginController extends Controller {

    public function login() {
        $this->display();
    }

    public function loginset() {
        if (!empty($_POST)) {
            $username = $_POST['username'];
            $loginip = '127.0.0.1';
            $very = new Verify();
            if ($very->check($_POST['verify'])) {
                $m = M('manager');
                $d = $m->where("user_name='$username'")->find();
                if ($d['lock']) {
                    $this->error('用户已被锁定，无法登录！', U('Login/login', '', ''));
                }
                if ($d) {
                    if ($d['user_pwd'] == $_POST['userpwd']) {
                        session("user_name", $d['user_name']);
                        session("user_id", $d['user_id']);
                        session('now', date('Y-m-d H:i', time()));
                        $data = array('logintime' => date('Y-m-d H:i', time()), 'loginip' => $loginip);
                        M('manager')->where("user_name='$username'")->setField($data);
                        $this->success('登录成功，正在为您跳转...', U('Index/Index', '', ''));
                    } else {
                        $this->error('用户名或者密码错误，请重试！', U('Login/login', '', ''));
                    }
                }
            } else {
                $this->error('验证码错误，请重试！', U('Login/login', '', ''));
            }
        }
    }

    public function exits() {
        session_destroy();
        redirect("login");
    }

    public function veryimg() {
        $config = array('fontSize' => 30, // 验证码字体大小   
            'length' => 4, // 验证码位数   
            'codeSet' => '1234567890',
            'useCurve' => false,
        );
        $Verify = new Verify($config);
        $Verify->entry();
    }

}
