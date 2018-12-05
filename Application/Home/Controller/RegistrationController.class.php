<?php

namespace Home\Controller;

use Think\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RegistrationController extends BaseController {

    public function report() {
        $this->display();
    }

    public function registration() {
        $this->display();
    }

    public function select() {
        $xb = M("xb");
        $zy = M("zy");
        $data = $_POST['data'];
        $noticenum = $_POST['noticeNumber'];
        if ($data == 1) {
            $a = $xb->select();
            $this->ajaxReturn($a);
        }
        if ($data == 2) {
            $xbdm = isset($_POST['datatype']) ? $_POST['datatype'] : "";
            $z = $zy->where("xbdm='$xbdm'")->select();
            $this->ajaxReturn($z);
        }
        if ($data == 3) {
            $registration = M('registration');
            $r = $registration->where("noticenumber='$noticenum'")->find();
            $b = $r['faculty'];
            $x = M('xb')->where("xbmc='$b'")->find();
            $v = $r['major'];
            $l = M('zy')->where("zymc='$v'")->find();
            $result = array(
                "xbdm" => $x['xbdm'],
                "sum" => $r,
                "zydm" => $l['zydm']
            );
            if ($r) {
                $this->ajaxReturn($result);
            } else {
                $ero = ["没有找到该通知书编号!"];
                $this->ajaxReturn($ero);
            }
        }
    }

    public function uploadify() {
        $upload = new \Think\Upload(); // 实例化上传类
        $upload->maxSize = 0; // 设置附件上传大小
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg'); // 设置附件上传类型
        $upload->rootPath = '././';
        $upload->savePath = 'Public/photoupload/'; //设置附件上传（子）目录
        $upload->replace = true; //覆盖相同文件
        $upload->hash = true;
        $upload->saveName = 'time';
        $upload->autoSub = true;
        $upload->subName = array('date', 'Ymd');
        $img_info = $upload->uploadOne($_FILES['img_path']); // 上传文件
        if ($img_info) {
            die($img_info['savepath'] . $img_info['savename']);
        } else {
            $this->error($upload->getError());
        }
    }

    public function savedata() {
//        var_dump($_POST);
//        $datae = "";
        $noticeNumbe = $_POST['noticeNumber'];
        $abc = M('registration')->where("noticenumber=$noticeNumbe")->find();
        $faculty = $_POST['department'];
        $major = $_POST['major'];
//        var_dump($major);
        $sex = $_POST['sex'];
        $t = M('xb')->where("xbdm='$faculty'")->find();
        $x = M('zy')->where("zydm='$major'")->find();
        if (!empty($_POST)) {
            $registration = M('registration');
            $registration->candidatenumber = $_POST['examineeNumber'];
            $registration->address = $_POST['homeAddress'];
            $registration->birthdata = $_POST['birthday'];
            $registration->faculty = $t['xbmc'];
            $registration->graduatedschool = $_POST['finishSchool'];
            $registration->idnumber = $_POST['idcard'];
            $registration->major = $x['zymc'];
            $registration->myphone = $_POST['telphone'];
            $registration->name = $_POST['studentName'];
            $registration->nation = $_POST['nation'];
            $registration->photo = $_POST['photoc'];
            $registration->postcode = $_POST['postcode'];
            $registration->sex = $sex;
            $registration->currenttime = date('Y-m-d');
            $s = $registration->where("noticenumber=$noticeNumbe")->save();
            if ($s) {
                if ($abc['sex'] != $sex) {
                    $dataa = array('dormvalue' => '', 'dormposition' => '');
                    $registration->where("noticenumber=$noticeNumbe")->setField($dataa);
                }
                $data = ["数据保存成功！"];
//                var_dump("asdfghj");
                $this->ajaxReturn($data);
                return;
            } else {
                $dataa = ["数据保存失败！"];
                $this->ajaxReturn($dataa);
            }
        }
    }

    public function regislist() {
        $this->display('regislist');
    }

    public function gridlist() {
        $pageIndex = $_POST['page']; //当前页码页码
        $pageSize = $_POST['rows']; //每页显示行
        $departmentCode = $_POST['xb'];
        $majorCode = $_POST['zy'];
        $studentName = $_POST['name'];
        $dorm = $_POST['dormd'];
        if ($studentName != '') {
            $where['name'] = array('like', '%' . $studentName . '%');
        }
        if ($departmentCode != "请选择") {
            $where['faculty'] = $departmentCode;
        }
        if ($majorCode != "请选择") {
            $where['major'] = $majorCode;
        }
        if ($dorm != "请选择") {
            $where['dormvalue'] = $dorm;
        }
        $count = M('registration')->where($where)->count();
        $startno = ($pageIndex - 1) * $pageSize;
        $limit = $startno . ',' . $pageSize;
        $studentList = M('registration')->where($where)->order('currenttime asc')->limit($limit)->select();
        $result = array(
            "total" => $count, //记录总数
            "rows" => $studentList  //记录
        );
        $this->ajaxReturn($result, 'JSON');
    }

    public function yxcount() {
        $result = M('registration')->field(array('faculty' => 'name', 'count(*)' => 'value'))->group('faculty')->select();
        $this->ajaxReturn($result, "JSON");
    }

    public function zycount() {
        $result = M('registration')->field('count(*) as zycount,major')->group('major')->select();
        $this->ajaxReturn($result, "JSON");
    }

    public function dorms() {
        $datatype = $_POST['datatype'];
        if ($datatype == 1) {
            $dromname = $_POST['data'];
            $lt = M('registration')->where("dormvalue='$dromname'")->select();
            $re = M('dorm')->where("dormvalue='$dromname'")->find();
            $result = array(
                "amount" => $re['spec'], //寝室人数
                "rows" => $lt  //记录
            );
            $this->ajaxReturn($result, "JSON");
        }
        if ($datatype == 2) {
            $relt = M('dorm')->select();
            $this->ajaxReturn($relt, "JSON");
        }

        if ($datatype == 4) {
            $xbmc = $_POST['yxmc'];
            $sex = $_POST['sex'];
            $aa = M('xb')->where("XBMC='$xbmc'")->find();
            $xbdm = $aa['xbdm'];

            $relt = M('dorm')->where("xbdm='$xbdm'and dclass='$sex'")->select();
            $this->ajaxReturn($relt, "JSON");
        }
    }

    public function savedorm() {
        $dormvalue = $_POST['dormvalue'];
        $dormposition = $_POST['dormposition'];
        $name = $_POST['name'];
        $data = array(
            'dormvalue' => $dormvalue,
            'dormposition' => $dormposition
        );
        $result = M('registration')->where("name='$name'")->setField($data);
        ;
        $this->ajaxReturn($result, "JSON");
    }

    function onreport() {
        require 'vendor/autoload.php';
        $departmentCode = $_POST['department'];
        $majorCode = $_POST['major'];
        $studentName = $_POST['studentName'];
        $dorm = $_POST['dorm'];
        if ($studentName != '') {
            $where['name'] = array('like', '%' . $studentName . '%');
        }
        if ($departmentCode != "请选择") {
            $where['faculty'] = $departmentCode;
        }
        if ($majorCode != "请选择") {
            $where['major'] = $majorCode;
        }
        if ($dorm != "请选择") {
            $where['dormvalue'] = $dorm;
        }
        $expTableData = M('registration')->where($where)->order('currenttime asc')->select();
        $expCellName = array(
            array('noticenumber', '通知书编号'),
            array('name', '姓名'),
            array('sex', '性别'),
            array('birthdata', '出生日期'),
            array('idnumber', '身份证号'),
            array('nation', '民族'),
            array('faculty', '院系'),
            array('major', '专业'),
            array('graduatedschool', '毕业中学'),
            array('myphone', '联系电话'),
            array('patriarchphone', '家长电话'),
            array('address', '家庭住址'),
            array('postcode', '邮政编码'),
            array('dormvalue', '寝室'),
            array('currenttime', '入学年份')
        );
        $this->exportExcel($expCellName, $expTableData);
    }

    private function exportExcel($expCellName, $expTableData) {
        $fileName = time() . '(' . date('Y') . '年新生数据' . ')'; //导出excal 文件名称
        $cellNum = count($expCellName); //有多少列
        $dataNum = count($expTableData); //有多少行
        vendor("PHPExcel.PHPExcel");
        ini_set("memory_limit", "1024M");
        $objPHPExcel = new \PHPExcel(); //实例化PHPExcel类库，相当于新建一个Excel表
        $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O',
            'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE',
            'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT',
            'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');
        //在第二行插入每列的标题
        for ($i = 0; $i < $cellNum; $i++) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i] . '1', $expCellName[$i][1]);
        }
        //从第三行开始插入数据
        for ($i = 0; $i < $dataNum; $i++) {
            for ($j = 0; $j < $cellNum; $j++) {
                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j] . ($i + 2), $expTableData[$i][$expCellName[$j][0]]);
            }
        }
        $objSheet = $objPHPExcel->getActiveSheet(); //获取当前活动sheet
        $objSheet->setTitle('sheet1'); //给当前的活动sheet起个名称
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="' . $fileName . '.xlsx"');
        header("Content-Disposition:attachment;filename=$fileName.xlsx"); //attachment新窗口打印inline本窗口打印
        header('Cache-Control: max-age=0');
        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
        $response = array(
            'success' => true,
            'url' => $this->saveExcelToLocalFile($objWriter, $fileName),
        );
        if ($response) {
            $this->ajaxReturn($response, "json");
        }
    }

    private function saveExcelToLocalFile($objWriter, $filename) {
        $filePath = './Public/uploads/' . $filename . '.xlsx';
        $objWriter->save($filePath);
        return $filePath;
    }

}
