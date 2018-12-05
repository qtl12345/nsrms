<?php

namespace Home\Controller;

class UserController extends BaseController {

    public function loaddata() {
        header("Content-Type:text/html;charset=utf-8");
        $upload = new \Think\Upload(); // 实例化上传类
        $upload->maxSize = 3145728; // 设置附件上传大小
        $upload->exts = array('xls', 'xlsx', 'csv'); // 设置附件上传类
        $upload->rootPath = 'Public/Uploads/';
        $upload->savePath = ''; // 设置附件上传目录
        $info = $upload->uploadOne($_FILES['xlsxfile']);
        $filename = 'Public/Uploads/' . $info['savepath'] . $info['savename'];
        $exts = $info['ext'];
        if (!$info) {
            $this->ajaxReturn(array('errorCode' => 1, 'msg' => $upload->getErrorMsg()), "JSON");
        } else {
            require 'vendor/autoload.php';
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filename);
            $worksheet = $spreadsheet->getActiveSheet();
            $highestRow = $worksheet->getHighestRow(); // 总行数
            $highestColumn = $worksheet->getHighestColumn(); // 总列数
            for ($row = 2; $row <= $highestRow; $row++) {
                $item['noticenumber'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                $item['candidatenumber'] = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                $item['name'] = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                $item['sex'] = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                $item['idnumber'] = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
//                $item['birthdata'] = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                $item['birthdata'] = gmdate("Y-m-d H:i:s", \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp(
                                ($worksheet->getCellByColumnAndRow(6, $row)->getValue())));
                $item['nation'] = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                $item['faculty'] = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                $item['major'] = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                $item['graduatedschool'] = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                $item['currenttime'] = gmdate("Y-m-d H:i:s", \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp(
                                ($worksheet->getCellByColumnAndRow(15, $row)->getValue())));
                $item['postcode'] = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                $item['myphone'] = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                $item['patriarchphone'] = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                $item['address'] = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                $data[] = $item;
            }
//            return;
            $sum = count($data);
            M('registration')->startTrans(); //开启事务
            $flag = true;
            $i = 1;
            foreach ($data as $k => $v) {
                try {
                    M('registration')->data($v)->add();
                    $i++;
                } catch (\Exception $e) {
                    $flag = false;
                    break;
                }
            }
            if ($flag) {
                M('registration')->commit();
                $this->ajaxReturn(array("errorCode" => 0, 'msg' => '导入成功,共计导入数据' . $sum . '条'));
            } else {
                M('registration')->rollback();
                $this->ajaxReturn(array("errorCode" => 3, 'msg' => '导入失败,导入数据第' . $i . '行格式有误'));
            }
        }
    }

    public function index() {
        $this->display();
    }

    public function import() {
        $this->display();
    }

    public function editpwd() {
        $this->display();
    }

    public function menu() {
        $this->display();
    }

    public function editpwde() {
        $form = M('Manager');
        $oldpassword = $_POST['oldpassword'];
        $newpassword = $_POST['newpassword'];
        $repassword = $_POST['repassword'];
        $userid = $_SESSION['user_id'];
        if ($repassword == $newpassword) {
            $d = $form->where("user_id='$userid'")->find();
            if ($d['user_pwd'] == $oldpassword) {
                $form->user_pwd = $newpassword;
                $a = $form->where("user_id='$userid'")->save();
                $result = ["密码修改成功,即将推出系统!"];
            } else {
                $result = ["原密码错误!"];
            }
        } else {
            $result = ["两次密码不一致!"];
        }
        $this->ajaxReturn($result);
    }

    public function serarchuser() {
        $pageIndex = $_POST['page']; //当前页码页码
        $pageSize = $_POST['rows']; //每页显示行
        $username = $_POST['username'];
        $myusername = session('user_name');
        $where['user_name'] = array('NEQ', $myusername);
        if ($username != '') {
            $where['user_name'] = array('like', '%' . $username . '%');
        }
        $count = M('manager')->where($where)->count();
        $startno = ($pageIndex - 1) * $pageSize;
        $limit = $startno . ',' . $pageSize;
        $list = M('manager')->where($where)->limit($limit)->select();
        $result = array(
            "total" => $count, //记录总数
            "rows" => $list  //记录
        );
        $this->ajaxReturn($result);
    }

    function editUserStatus() {
        $ids = $_POST['ids'];
        $lock = $_POST['lock'];
        if ($lock == 0) {
            $lock = 1;
        } else {
            $lock = 0;
        }
        $relust = M('Manager')->where("user_id='$ids'")->setField('lock', $lock);
        $list = "";
        if ($relust > 0) {
            $list = '操作成功';
        } else {
            $list = '操作失败';
        }
        $this->ajaxReturn($list);
    }

    function resetpwd() {
        $datatype = $_POST['datatype'];
        $user_pwd = "123";
        if ($datatype == 111) {
            $ids = $_POST['ids'];
            foreach ($ids as $value) {
                $relust = M('Manager')->where("user_id='$value'")->setField('user_pwd', $user_pwd);
                $s = $s + $relust;
            }
        } else {
            $ids = $_POST['ids'];
            $relust = M('Manager')->where("user_id='$ids'")->setField('user_pwd', $user_pwd);
            $s = $s + $relust;
        }
        if ($relust > 0) {
            $list = '操作成功';
        } else {
            $list = '请不要重复操作';
        }
        $this->ajaxReturn($list);
    }

    function adduser() {
        $addusername = $_POST['addusername'];
        $add_confirmpwd = $_POST['add_confirmpwd'];
        $rest = "";
        $ast = M('manager')->getField('user_name', true);
        foreach ($ast as $value) {
            if ($value == $addusername) {
                $rest = "已有该用户，请重新添加";
                $this->ajaxReturn($rest);
                return;
            }
        }
        $data['user_name'] = $addusername;
        $data['user_pwd'] = $add_confirmpwd;
        $a = M('manager')->add($data);
        if ($a > 0) {
            $rest = "添加用户成功";
        } else {
            $rest = "添加用户失败";
        }
        $this->ajaxReturn($rest);
    }

    function edituser() {
        $ids = $_POST['ids'];
        $result = '';
        $lock = $_POST['lock'];
        if ($lock == 1) {
            foreach ($ids as $value) {
                $a = M('manager')->where("user_id='$value'")->setField('lock', '1');
                $s = $s + $a;
            }
        } else {
            foreach ($ids as $value) {
                $a = M('manager')->where("user_id='$value'")->setField('lock', '0');
                $s = $s + $a;
            }
        }
        if ($s > 0) {
            $result = '操作成功';
        } else {
            $result = '请不要重复操作';
        }
        $this->ajaxReturn($result);
    }

}
