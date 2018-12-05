<?php

namespace Home\Controller;

use Think\Controller;

/**
 * 基础控制器（权限控制都由它派生）
 */
class BaseController extends Controller
{
    public function _initialize()
    {
        //判断用户是否已登录
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
            redirect(U('Login/login', '', ''));
        }
        
      //  请求控制器的时候判断用户权限
//        $req = MODULE_NAME . '-' . CONTROLLER_NAME . '-' . ACTION_NAME;
//        $auth = explode(",", session('auth'));
//        if (!in_array($req, $auth, true)) {
//            //在iframe中这种方式处理有问题
//            $this->error('无权访问',true);
//        }
    }

    /**
     * 空操作（处理非法请求）
     */
    public function _empty()
    {
        redirect(U('Login/index', '', ''));
    }
}
