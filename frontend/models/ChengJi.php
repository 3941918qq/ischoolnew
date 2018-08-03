<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-05-24
 * Time: 16:27
 */
namespace frontend\models;

use common\models\ZfChengji;
use common\models\ZfChengjiType;
use common\models\ZfClass;
use common\models\ZfClassChengji;
use common\models\ZfSchoolChengji;
use common\models\ZfStudents;
use common\models\ZfSubject;
use common\models\ZfTeacherClass;
use common\models\ZfUser;
use Yii;
use yii\web\UploadedFile;

class ChengJi extends ZfChengji{
    static private $source_data;   //上传的excel数据
    public function searchChengji($params){
        $cid = $params['cid'];
        $cjdid = $params['cjdid'];
        $stuid= $params['stuid'];
        $isopen = isset($params['isopen'])?$params['isopen']:0;
        if ($stuid != "all"){
            $sql = "SELECT c.stuid,c.stuname,c.kmname,c.score,t.sort FROM zf_chengji c left join zf_subject t on c.kmid=t.id WHERE c.cid=:cid AND c.cjdid=:cjdid AND c.stuid=:stuid order by t.sort asc";
            $users = \Yii::$app->db->createCommand($sql,[':cid'=>$params['cid'],':cjdid'=>$params['cjdid'],':stuid'=>$params['stuid']])->queryAll();
        }else{
            $sql = "SELECT c.stuid,c.stuname,c.kmname,c.score,t.sort FROM zf_chengji c left join zf_subject t on c.kmid=t.id WHERE c.cid=:cid AND c.cjdid=:cjdid order by c.stuid asc,t.sort asc";
            $users = \Yii::$app->db->createCommand($sql,[':cid'=>$params['cid'],':cjdid'=>$params['cjdid']])->queryAll();
        }

        $title = self::scriptTitle($cjdid,$cid);
        $cid = self::scriptCjd($users);
        $res[] = $title;
        $res[] = $cid;
        return json_encode($res);
    }

    //拼凑成绩单标题
    private function scriptTitle($cjdid,$cid){
        // $sql = "select distinct kmname from wp_ischool_chengji where cjdid=:cjdid and cid=:cid order by kmid asc";
        $sql = "SELECT distinct kmname FROM zf_chengji c left join zf_subject t on c.kmid=t.id WHERE c.cid=:cid AND c.cjdid=:cjdid order by c.stuid asc,t.sort asc";
        $title = \Yii::$app->db->createCommand($sql,[':cjdid'=>$cjdid,':cid'=>$cid])->queryAll();
        $newTitle = array();
        $newTitle[] = "姓名";
        foreach($title as $v){
            $newTitle[] = $v['kmname'];
        }
        return $newTitle;
    }

//拼凑成绩
    private function scriptCjd($cjd_arr){
        $cjd = array();
        $cj = array();
        $leng = count($cjd_arr);
        for($i = 0;$i < $leng;$i++){
            if($i != 0){
                if($cjd_arr[$i]['stuid']==$cjd_arr[$i-1]['stuid']){
                    $cj[] = $cjd_arr[$i]['score'];
                }else{
                    $cjd[] = $cj;
                    $cj = array();
                    $cj[] = $cjd_arr[$i]['stuname'];
                    $cj[] = $cjd_arr[$i]['score'];
                }
            }else{
                $cj[] = $cjd_arr[$i]['stuname'];
                $cj[] = $cjd_arr[$i]['score'];
            }

            if($i == $leng-1){
                $cjd[] = $cj;
            }
        }
        return $cjd;
    }

    //家长查询成绩界面
    public function Scorequery($cid){
        $users = ZfClassChengji::find()->select("cjid,zf_school_chengji.name,isopen")->joinWith("cj")->where(['cid'=>$cid])->asArray()->all();
        return $users;
    }
//成绩管理
    public function teachengji($uid){
        $userInfo= ZfUser::findOne($uid);
        $teainfo = ZfTeacherClass::find()->where(['t_id'=>$uid,'role_id'=>'10004'])->one();
        $data['sid'] = $teainfo['sid'];
        $data['cid'] = $teainfo['c_id'];
        $nowyear = date("Y");
        $nowmonth = date("m");
        $xuenian = array();
        if($nowmonth > 7){
            $xuenian[] = array('year'=>$nowyear."-".($nowyear+1)."学年");
        }else{
            $xuenian[] = array('year'=>($nowyear-1)."-".$nowyear."学年");
        }
        $data['xuenian'] = $xuenian;
        $data['type'] = ZfChengjiType::find()->all();
        $data['cjdxx'] = self::Scorequery($teainfo['c_id']);
        return $data;
    }

    //成绩上传
    public function import($params){
        $uid = \yii::$app->view->params['uid'];
        self::initExcel();
        $sid = $params['sid'];
        $cid = $params['cid'];
        $examname = $params['exam'];
        $isopen = !isset($params['isopen'])?'0':$params['isopen'];
        $cjdid = ZfSchoolChengji::find()->select('id')->where(['name'=>$examname,'sid'=>$sid])->asArray()->all();//成绩单ID查询
        if(empty($cjdid)){
            $model = new ZfSchoolChengji();
            $model->sid = $sid;
            $model->name = $examname;
            $model->ctime = date("Y-m-d H:i:s",time());
            $model->save(false);
            $cjdid = \Yii::$app->db->getLastInsertID();
        }else{
            $cjdid = $cjdid[0]['id'];
        }
        $class_cj = ZfClassChengji::find()->select("cjid,zf_school_chengji.name,isopen")->joinWith("cj")->where(['cid'=>$cid,'cjid'=>$cjdid])->asArray()->all();         //班级成绩单信息查询
        if(empty($class_cj)){
            $excel_cont = self::checkChengjiExcel($cid,self::$source_data);
            if($excel_cont['retcode']==0)
            {
                $res = new ZfClassChengji();
                $res->ctime =date("Y-m-d H:i:s",time());
                $res->cid = $cid;
                $res->cjid = $cjdid;
                $res->isopen = $isopen;
                $res->uid = $uid;
                $res->save(false);
                $data = array('data'=>$excel_cont['retdata'],'cid'=>$cid,'cjdid'=>$cjdid,'examname'=>$examname,'uid'=>$uid);
                $excel_cont =  self::sendRecordToParent1($data);
                $result = array("retcode"=>0,"retmsg"=>"发送成功");
            }else{
                //有错误
                $result = array("retcode"=>-1,"retmsg"=>"发送失败，错误信息为".$excel_cont['retdata']);
            }
        }else{
            //不能重复上传
            $result = array("retcode"=>-1,"retmsg"=>"该班级已有名为".$examname."的成绩单，不能重复上传");
        }
        echo "<script>parent.uploadCJDCallbak(".$result['retcode'].",'".$result['retmsg']."')</script>";

    }

    public function initExcel()
    {
        if (\Yii::$app->request->isPost) {
            $model = new ImportData();
            $model->upload = UploadedFile::getInstance($model, 'upload');
            if ($model->validate()) {
                $data = \moonland\phpexcel\Excel::widget([
                    'mode' => 'import',
                    'fileName' => $model->upload->tempName,
                    'setFirstRecordAsKeys' => false,
                    'setIndexSheetByName' => false,
                ]);
                $data = isset($data[0])?$data[0]:$data;
                \Yii::trace($data);
                if(count($data) > 1)
                {
                    array_shift($data);
                    \Yii::trace($data);
//                    var_dump($data);exit();
                    self::$source_data = $data;
                }
                else echo "<script>alert('文件格式错误！');</script>";;
            }
        }
    }

    //验证成绩excel的数据有效性
    private function checkChengjiExcel($cid,$file_name){
        $begin_row_num = 2;

        $data_arrs=$file_name;
        //去除首行列标题字符串中的空格
        $data_arr =[];
        foreach($data_arrs as $value){
            $data_arr[] = array_values($value);
        }

        foreach($data_arr[0] as $k=>$v){
            $data_arr[0][$k] = str_replace(' ', '', $v);
        }

        for($i=0;$i<count($data_arr);$i++){
            $data_arr[$i] = array_filter($data_arr[$i],create_function('$v','return isset($v);'));
        }
        $data_arr[0] = array_filter($data_arr[0]);
        foreach($data_arr as $k=>$v){
            if(!$v){//判断是否为空（false）
                unset($data_arr[$k]);//删除
            }
        }
        $first_row = $data_arr[0];
        //检查是否有姓名列
        if(!in_array("姓名",$first_row)){
            return array("retcode"=>-1,"retdata"=>"请指定姓名列");
        }
        //检查列名是否重复
        foreach($first_row as $k=>$v){
            foreach($first_row as $kt=>$vt){
                if($v==$vt && $k!=$kt){
                    return array("retcode"=>-1,"retdata"=>"名为[".$v."]的列重复");
                }else{
                    continue;
                }
            }
        }

        //检查科目名称有效性
        $sys_subject = self::getAllSysSubject();
        foreach($data_arr[0] as $key=>$excel_sub){
            if($excel_sub!="姓名"){
                $isFound = false;
                //在系统科目查找名称和id，系统里没有的视为无效的科目
                foreach($sys_subject as $sys_sub){
                    if($excel_sub == $sys_sub['name']){
                        //将系统科目名称和id拼接，备用后来的插入操作
                        $data_arr[0][$key]=$sys_sub['name']."-".$sys_sub['id'];
                        $isFound = true;
                        break;
                    }
                }
                if(!$isFound){
                    return array("retcode"=>-1,"retdata"=>"名为[".$excel_sub."]的列为无效的列名");
                }
            }

        }

        //验证科目内容有效性
        $leng = count($data_arr);
        $cols = count($first_row);
        $nameIndex = array_keys($first_row,"姓名",false)[0];
        for($index=1; $index < $leng; $index++){
            $record = $data_arr[$index];
            for($i=0; $i < $cols; $i++){
                if($i == $nameIndex){
                    //检查姓名
                    if($record[$i]==""){
                        return array("retcode"=>-1,"retdata"=>"第".($begin_row_num+$index)."行姓名不能为空");
                    }else{
                        $student = self::queryStudentInfo($cid,$record[$i]);
                        if(!empty($student)){
                            $data_arr[$index][$nameIndex] .= "-".$student[0]['id'];
                        }else{  //不存在该学生
                            return array("retcode"=>-1,"retdata"=>"第".($begin_row_num+$index)."行，该班不存在名为".$record[$nameIndex]."的学生");
                        }
                    }
                }else{      //检查其他列的数值
                    if(!is_numeric($record[$i])){
                        return array("retcode"=>-1,"retdata"=>"第".($begin_row_num+$index)."行".$record[$nameIndex].$first_row[$i]."成绩无效");
                    }
                }
            }
        }

        return array("retcode"=>0,"retdata"=>$data_arr);
    }

    private function getAllSysSubject(){
        $types = ZfSubject::find()->select('id,name')->orderBy('sort asc')->asArray()->all();
        return $types;
    }

    private function queryStudentInfo($cid,$name){
        $res = ZfStudents::find()->select('id,name')->where(['class_id'=>$cid,'name'=>$name])->orderBy('name ASC')->asArray()->all();
        return $res;
    }

    //成绩单推送信息
    public function sendRecordToParent1($_info)
    {
        $uid = \yii::$app->view->params['uid'];
        $userInfo= ZfUser::findOne($uid);
        $sender = $userInfo['name'];
        $data = $_info['data'];
        $cid = $_info['cid'];
        $cjdid = $_info['cjdid'];
        $examName = $_info['examname'];
        $length = count($data);
        $ctime = time();
        $sid = self::getSchoolidbycid($cid);
        $sid = !empty($sid[0]['sid'])?$sid[0]['sid']:1;
        if($length > 1){
            $subject = $data[0];
            $cols = count($subject);
            $nameIndex = array_keys($subject,"姓名",false)[0];
            for($i=1;$i<$length;$i++) {
                $record = $data[$i];
                $stuname = explode("-", $record[$nameIndex]);
                $stuid = $stuname[1];
                $stuname = $stuname[0];
                $content = "家长您好,".$stuname."同学".$examName."成绩如下:\n\n";
                $sql = "insert into zf_chengji(stuid,stuname,cid,cjdid,kmid,kmname,score,ctime) values ";
                for($j = 0; $j < $cols; $j++){
                    if($j != $nameIndex){  //科目列
                        $kemu = explode("-",$subject[$j]);
                        $kmid = $kemu[1];
                        $kemu = $kemu[0];
                        $content .= $kemu.":".$record[$j]."\n\n";
                        $sql .= "(".$stuid.",'".$stuname."',".$cid.",".$cjdid.",".$kmid.",'".$kemu."',".$record[$j].",".$ctime."),";
                    }
                }
                $content .= "来自".$sender."老师\n";
                $sql = substr($sql,0,-1);
                $c = \Yii::$app->db->createCommand($sql)->execute();
/*                //发送推送信息
                if($c){
                    $picurl = self::getSchoolPic($sid);
                    $paropenids = self::getAllopenidbystuid($stuid);
                    $this->doSendRecord($paropenids,$content,$picurl);
                }*/
            }
        }
    }

    //根据班级id获取学校id
    public function getSchoolidbycid($cid){
/*        $connection  = Yii::$app->db;
        $command = $connection->createCommand("select sid,school from wp_ischool_class where id='".$cid."' ORDER BY convert(name USING gbk)")->queryAll();*/
        $command = ZfClass::find($cid)->select('sid')->asArray()->all();
        return $command;
    }


    public function delcjd($params)
    {
        $cjdid = $params['cjdxxid'];
        $cid = $params['cid'];
        $transaction = Yii::$app->db->beginTransaction();
        try  {
            $model3 = ZfChengji::deleteAll(['cjdid'=>$cjdid,'cid'=>$cid]);
            $model2 = ZfClassChengji::deleteAll(['cjid'=>$cjdid,'cid'=>$cid]);
            $model = ZfSchoolChengji::findOne($cjdid)->delete();

            if (!$model || !$model2 || !$model3)
            {
                $transaction->rollBack();
                echo "<script>alert('删除失败,请重试！');window.location='/teacher/chengji'</script>";
            } else {
                $transaction->commit();
                echo "<script>alert('删除成功！');window.location='/teacher/chengji';</script>";
            }
        } catch (Exception $e)
        {
            $transaction->rollBack();
            echo "<script>alert('删除失败,请重试！');window.location='/teacher/chengji';</script>";
        }
    }
}