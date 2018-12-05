<?php

/**
 * 基础数据控制器
 */

namespace Home\Controller;


class BaseDataController extends BaseController
{

    public function dorm()
    {
        $this->display();
    }

    public function department()
    {
        $this->display();
    }

    public function major()
    {
        $this->display();
    }

    public function getDepartmentByPageUrl()
    {
        $dep = $_POST['departmentname'];
        $pageIndex = $_POST['page']; //当前页码页码
        $pageSize = $_POST['rows']; //每页显示行
        $startno = ($pageIndex - 1) * $pageSize;
        $limit = $startno . ',' . $pageSize;
        $count = '';
        $studentList = '';
        if ($dep != '请选择') {
            $count = 1;
            $studentList = M('xb')->where("xbmc='$dep'")->select();
        } else {
            $studentList = M('xb')->select();
            $count = M('xb')->count();
        }
        $result = array(
            "total" => $count, //记录总数
            "rows" => $studentList  //记录
        );
        $this->ajaxReturn($result);
    }

    public function getMajorByPageUrl()
    {
        $departmentcode = $_POST['department'];
        $majorcode = $_POST['major'];
        $pageIndex = $_POST['page']; //当前页码页码
        $pageSize = $_POST['rows']; //每页显示行
        $startno = ($pageIndex - 1) * $pageSize;
        $limit = $startno . ',' . $pageSize;
        if ($departmentcode == -1 && $majorcode == -1) {
            $where = "1=1";
        } else {
            if ($departmentCode != -1 && $majorcode == -1) {
                $where['xb.xbdm'] = $departmentcode;
            }
        }
        if ($departmentCode != -1 && $majorcode != -1) {
            $where = "xb.xbdm='$departmentcode'and zy.zydm='$majorcode'";
        }
        $studentList = M('xb')->join(array('zy ON xb.xbdm = zy.xbdm'))->where($where)->limit($limit)->select();
        $count = M('xb')->join(array('zy ON xb.xbdm = zy.xbdm'))->where($where)->count();
        $result = array(
            "total" => $count, //记录总数
            "rows" => $studentList  //记录
        );
        $this->ajaxReturn($result, 'JSON');
    }

    public function getDormByPage()
    {
        $depid = $_POST['departid'];
        $dormname = $_POST['dormname'];
        $pageIndex = $_POST['page']; //当前页码页码
        $pageSize = $_POST['rows']; //每页显示行
        $startno = ($pageIndex - 1) * $pageSize;
        $limit = $startno . ',' . $pageSize;
        if ($depid == -1 && $dormname == '') {
            $where = "1=1";
        }
        if ($depid == -1 && $dormname != '') {
            $where = "dorm.dormvalue like '%" . $dormname . "%'";
        }
        if ($depid != -1 && $dormname == '') {
            $where = "xb.xbdm='$depid'";
        }
        if ($depid != -1 && $dormname != '') {
            $where = "xb.xbdm='$depid'and dorm.dormvalue like '%$dormname%'";
        }
        $Model = new \Think\Model();
        $studentList = $Model->query("select * from dorm join xb on dorm.xbdm = xb.xbdm where $where");
        $count = count($studentList);
        $result = array(
            "total" => $count, //记录总数
            "rows" => $studentList  //记录
        );
        $this->ajaxReturn($result, 'JSON');
    }

    public function doSaveDepartmentUrl()
    {
        $datatype = $_POST['datatype'];
        if ($datatype == 111) {
            $xbdm = $_POST['xbid'];
            $ynamme = $_POST['ynamme'];
            $yxmc = $_POST['xbmc'];
            $upxb = M('xb')->where("XBDM=$xbdm")->setField('XBMC', $ynamme);
            if ($upxb > 0) {
                $a = M('registration')->where("faculty='$yxmc'")->setField('faculty', $ynamme);
            }
            $this->ajaxReturn($a);
        }
        if ($datatype == 110) {
            $add_dep = $_POST['add_dep'];
            $data['xbmc'] = $add_dep;
            $amountname = M('xb')->getField('xbmc', true);
            foreach ($amountname as $value) {
                if ($value == $add_dep) {
                    $this->ajaxReturn("院系名称重复");
                    return;
                }
            }
            $ys = M('xb')->add($data);
            $this->ajaxReturn($ys);
        }
        //修改院系名称完成后更新报到学生信息表中的所有相关院系名称
    }

    public function doSaveMajor()
    {
        //修改专业名称完成后更新报到学生信息表中的所有相关专业名称
        $datatype = $_POST['datatype'];
        if ($datatype == 111) {
            $zydm = $_POST['zyid'];
            $ynamme = $_POST['ynamme'];
            $zymc = $_POST['zymc'];
            $upxb = M('zy')->where("ZYDM=$zydm")->setField('ZYMC', $ynamme);
            if ($upxb > 0) {
                $a = M('registration')->where("major='$zymc'")->setField('major', $ynamme);
            }
            $this->ajaxReturn($a);
        }
        if ($datatype == 110) {
            $add_xbdm = $_POST['add_dep'];
            $add_major = $_POST['add_major'];
            $data['XBDM'] = $add_xbdm;
            $data['ZYMC'] = $add_major;
            $amountname = M("zy")->where("xbdm='$add_xbdm'")->getField('zymc', true);
            foreach ($amountname as $value) {
                if ($value == $add_major) {
                    $this->ajaxReturn("专业名称重复");
                    return;
                }
            }
            $ys = M("zy")->add($data);
            $this->ajaxReturn($ys);
        }
    }

    public function doSaveDorm()
    {
        $datatype = $_POST['datatype'];
        if ($datatype == 111) {
            $vikxbmc = $_POST['vikxbmc'];
            $vikdormvalue = $_POST['vikdormvalue'];
            $vikdclass = $_POST['vikdclass'];
            $vikspec = $_POST['vikspec'];
            $xbid = $_POST['xbid'];
            $data['spec'] = $vikspec;
            $data['xbdm'] = $vikxbmc;
            $data['dormvalue'] = $vikdormvalue;
            $data['dclass'] = $vikdclass;
            $opt = M('dorm')->where("id='$xbid'")->save($data);
            $this->ajaxReturn($opt);
        }
        if ($datatype == 110) {
            $xbdm = $_POST['xbdm'];
            $dormvalue = $_POST['dormvalue'];
            $dclass = $_POST['dclass'];
            $spec = $_POST['spec'];
            $data['spec'] = $spec;
            $data['xbdm'] = $xbdm;
            $data['dormvalue'] = $dormvalue;
            $data['dclass'] = $dclass;
            $amountname = M("dorm")->where("dormvalue='$dormvalue'")->getField('dormvalue', true);
            foreach ($amountname as $value) {
                if ($value == $dormvalue) {
                    $this->ajaxReturn("寝室名称不能重复");
                    return;
                }
            }
            $ys = M("dorm")->add($data);
            $this->ajaxReturn($ys);
        }
    }

}
