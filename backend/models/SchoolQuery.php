<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-04-27
 * Time: 16:47
 */
namespace backend\models;
use Yii;
class SchoolQuery extends \yii\base\Model
{
    public static function getSchool($params)
    {
        $from_unix_time = 0;
        $to_unix_time = "2038-1-19";
        if(isset($params['from_date']) && isset($params['to_date']))
        {
            $from_unix_time = $params['from_date'];
            $to_unix_time = $params['to_date'];
        }
        $today_begin_time = ($from_unix_time==0)?date("Y-m-d"):$from_unix_time;
        $today_end_time = ($from_unix_time==0)?$today_begin_time + 86400:$to_unix_time;
        $school_id = \yii::$app->view->params['schoolid'];
        if($school_id ==0){
            return \yii::$app->getDb()->createCommand('select tmp.*,tmp2.* from ( SELECT s.id,s.name,count(DISTINCT t.id) as snum,count(DISTINCT n.stu_id) as bnum,count(DISTINCT n.stu_id)/count(DISTINCT t.id) as brate,
(SELECT count(t.id) as a FROM zf_students t where t.school_id=s.id AND  t.upendtimepa between :fromtime1 and :endtime1 and t.enddatepa > NOW()) mnumpa,
(SELECT count(t.id) as a FROM zf_students t where t.school_id=s.id AND  t.upendtimepa between :fromtime2 and :endtime2 and t.enddatepa > NOW())/count(DISTINCT t.id) as mratepa,
(SELECT count(t.id) as a FROM zf_students t where t.school_id=s.id AND  t.upendtimejx between :fromtime3 and :endtime3 and t.enddatejx > NOW()) mnumjx,
(SELECT count(t.id) as a FROM zf_students t where t.school_id=s.id AND  t.upendtimejx between :fromtime4 and :endtime4 and t.enddatejx > NOW())/count(DISTINCT t.id) as mratejx,
(SELECT count(t.id) as a FROM zf_students t where t.school_id=s.id AND  t.upendtimeqq between :fromtime5 and :endtime5 and t.enddateqq > NOW()) mnumqq,
(SELECT count(t.id) as a FROM zf_students t where t.school_id=s.id AND  t.upendtimeqq between :fromtime6 and :endtime6 and t.enddateqq > NOW())/count(DISTINCT t.id) as mrateqq,
(SELECT count(t.id) as a FROM zf_students t where t.school_id=s.id AND  t.upendtimeck between :fromtime7 and :endtime7 and t.enddateck > NOW()) mnumck,
(SELECT count(t.id) as a FROM zf_students t where t.school_id=s.id AND  t.upendtimeck between :fromtime8 and :endtime8 and t.enddateck > NOW())/count(DISTINCT t.id) as mrateck
FROM zf_school s LEFT JOIN zf_students t on t.school_id=s.id
LEFT JOIN zf_parent n on n.stu_id= t.id    and n.created between :fromtime and :endtime
 GROUP BY s.id) tmp left join (select st.school_id,count(distinct card.stuid) as cnum,count(distinct card.stuid)/count(distinct st.id) as crate from zf_students as st left join zf_safe_card as card on st.id = card.stuid and card.ctime between :today_begin_time and :today_end_time group by st.school_id)tmp2 on tmp.id = tmp2.school_id   order by tmp.id ASC ',[":fromtime1"=>$from_unix_time,":endtime1"=>$to_unix_time,":fromtime2"=>$from_unix_time,":endtime2"=>$to_unix_time,":fromtime3"=>$from_unix_time,":endtime3"=>$to_unix_time,":fromtime4"=>$from_unix_time,":endtime4"=>$to_unix_time,":fromtime5"=>$from_unix_time,":endtime5"=>$to_unix_time,":fromtime6"=>$from_unix_time,":endtime6"=>$to_unix_time,":fromtime7"=>$from_unix_time,":endtime7"=>$to_unix_time,":fromtime8"=>$from_unix_time,":endtime8"=>$to_unix_time,":fromtime"=>$from_unix_time,":endtime"=>$to_unix_time,":today_begin_time"=>$today_begin_time,":today_end_time"=>$today_end_time])->queryAll();
        }else{
            return \yii::$app->getDb()->createCommand('select tmp.*,tmp2.* from ( SELECT s.id,s.name,count(DISTINCT t.id) as snum,count(DISTINCT n.stu_id) as bnum,count(DISTINCT n.stu_id)/count(DISTINCT t.id) as brate,
(SELECT count(t.id) as a FROM zf_students t where t.school_id=s.id AND  t.upendtimepa between :fromtime1 and :endtime1 and t.enddatepa > NOW()) mnumpa,
(SELECT count(t.id) as a FROM zf_students t where t.school_id=s.id AND  t.upendtimepa between :fromtime2 and :endtime2 and t.enddatepa > NOW())/count(DISTINCT t.id) as mratepa,
(SELECT count(t.id) as a FROM zf_students t where t.school_id=s.id AND  t.upendtimejx between :fromtime3 and :endtime3 and t.enddatejx > NOW()) mnumjx,
(SELECT count(t.id) as a FROM zf_students t where t.school_id=s.id AND  t.upendtimejx between :fromtime4 and :endtime4 and t.enddatejx > NOW())/count(DISTINCT t.id) as mratejx,
(SELECT count(t.id) as a FROM zf_students t where t.school_id=s.id AND  t.upendtimeqq between :fromtime5 and :endtime5 and t.enddateqq > NOW()) mnumqq,
(SELECT count(t.id) as a FROM zf_students t where t.school_id=s.id AND  t.upendtimeqq between :fromtime6 and :endtime6 and t.enddateqq > NOW())/count(DISTINCT t.id) as mrateqq,
(SELECT count(t.id) as a FROM zf_students t where t.school_id=s.id AND  t.upendtimeck between :fromtime7 and :endtime7 and t.enddateck > NOW()) mnumck,
(SELECT count(t.id) as a FROM zf_students t where t.school_id=s.id AND  t.upendtimeck between :fromtime8 and :endtime8 and t.enddateck > NOW())/count(DISTINCT t.id) as mrateck
FROM zf_school s LEFT JOIN zf_students t on t.school_id=s.id
LEFT JOIN zf_parent_student n on n.stu_id= t.id    and n.created between :fromtime and :endtime
where s.id= :school_id GROUP BY s.id) tmp left join (select st.school_id,count(distinct card.stuid) as cnum,count(distinct card.stuid)/count(distinct st.id) as crate from zf_students as st left join zf_safe_card as card on st.id = card.stuid and card.ctime between :today_begin_time and :today_end_time group by st.school_id)tmp2 on tmp.id = tmp2.school_id   order by tmp.id ASC ',[":fromtime1"=>$from_unix_time,":endtime1"=>$to_unix_time,":fromtime2"=>$from_unix_time,":endtime2"=>$to_unix_time,":fromtime3"=>$from_unix_time,":endtime3"=>$to_unix_time,":fromtime4"=>$from_unix_time,":endtime4"=>$to_unix_time,":fromtime5"=>$from_unix_time,":endtime5"=>$to_unix_time,":fromtime6"=>$from_unix_time,":endtime6"=>$to_unix_time,":fromtime7"=>$from_unix_time,":endtime7"=>$to_unix_time,":fromtime8"=>$from_unix_time,":endtime8"=>$to_unix_time,":fromtime"=>$from_unix_time,":endtime"=>$to_unix_time,":today_begin_time"=>$today_begin_time,":today_end_time"=>$today_end_time,":school_id"=>$school_id])->queryAll();
        }
    }

    public static function gettongji($params){
        $from_unix_time = 0;
        $to_unix_time = "2038-1-19";
        if(isset($params['from_date']) && isset($params['to_date']))
        {
            $from_unix_time = $params['from_date'];
            $to_unix_time = $params['to_date'];
        }
        $today_begin_time = ($from_unix_time==0)?date("Y-m-d"):$from_unix_time;
        $today_end_time = ($from_unix_time==0)?$today_begin_time + 86400:$to_unix_time;
        $school_id = \yii::$app->view->params['schoolid'];
        if($school_id ==0)
        {
            return \yii::$app->getDb()->createCommand('select tmp.* from ( SELECT count(DISTINCT t.id) as snum,count(DISTINCT n.stu_id) as bnum,count(DISTINCT n.stu_id)/count(DISTINCT t.id) as brate,
(select count(distinct card.stuid) from  zf_safe_card as card where  card.ctime between :today_begin_time and :today_end_time) as cnum,
(select count(distinct card.stuid) from  zf_safe_card as card where  card.ctime between :today_begin_time and :today_end_time)/(select count(id) from zf_students) as crate,
(SELECT count(t.id) as a FROM zf_students t where t.upendtimepa between :fromtime1 and :endtime1 and t.enddatepa > NOW()) mnumpa,
(SELECT count(t.id) as a FROM zf_students t where t.upendtimepa between :fromtime2 and :endtime2 and t.enddatepa > NOW())/count(DISTINCT t.id) as mratepa,
(SELECT count(t.id) as a FROM zf_students t where t.upendtimejx between :fromtime3 and :endtime3 and t.enddatejx > NOW()) mnumjx,
(SELECT count(t.id) as a FROM zf_students t where t.upendtimejx between :fromtime4 and :endtime4 and  t.enddatejx > NOW())/count(DISTINCT t.id) as mratejx,
(SELECT count(t.id) as a FROM zf_students t where t.upendtimeqq between :fromtime5 and :endtime5 and  t.enddateqq > NOW()) mnumqq,
(SELECT count(t.id) as a FROM zf_students t where t.upendtimeqq between :fromtime6 and :endtime6 and t.enddateqq > NOW())/count(DISTINCT t.id) as mrateqq,
(SELECT count(t.id) as a FROM zf_students t where t.upendtimeck between :fromtime7 and :endtime7 and t.enddateck > NOW()) mnumck,
(SELECT count(t.id) as a FROM zf_students t where t.upendtimeck between :fromtime8 and :endtime8 and t.enddateck > NOW())/count(DISTINCT t.id) as mrateck
FROM zf_students t
LEFT JOIN zf_parent_student n on n.stu_id= t.id  and  n.created between :fromtime and :endtime
) tmp',[":today_begin_time"=>$today_begin_time,":today_end_time"=>$today_end_time,":today_begin_time2"=>$today_begin_time,":today_end_time2"=>$today_end_time,":fromtime1"=>$from_unix_time,":endtime1"=>$to_unix_time,":fromtime2"=>$from_unix_time,":endtime2"=>$to_unix_time,":fromtime3"=>$from_unix_time,":endtime3"=>$to_unix_time,":fromtime4"=>$from_unix_time,":endtime4"=>$to_unix_time,":fromtime5"=>$from_unix_time,":endtime5"=>$to_unix_time,":fromtime6"=>$from_unix_time,":endtime6"=>$to_unix_time,":fromtime7"=>$from_unix_time,":endtime7"=>$to_unix_time,":fromtime8"=>$from_unix_time,":endtime8"=>$to_unix_time,":fromtime"=>$from_unix_time,":endtime"=>$to_unix_time])->queryAll();
        }
    }

    public static function getClass($sid)
    {
        return \yii::$app->getDb()->createCommand('SELECT c.sid,c.id,c.name,count(DISTINCT t.id) as cnum,count(DISTINCT n.stu_id) as bnum,ifnull(count(DISTINCT n.stu_id)/count(DISTINCT t.id),0) as brate,
(SELECT count(t.id) as a FROM zf_students t where t.class_id=c.id and t.enddatepa > NOW()) mnumpa,
ifnull((SELECT count(t.id) as a FROM zf_students t where t.class_id=c.id and t.enddatepa > NOW())/count(DISTINCT t.id),0) as mratepa,
(SELECT count(t.id) as a FROM zf_students t where t.class_id=c.id and t.enddatejx > NOW()) mnumjx,
ifnull((SELECT count(t.id) as a FROM zf_students t where t.class_id=c.id and t.enddatejx > NOW())/count(DISTINCT t.id),0) as mratejx,
(SELECT count(t.id) as a FROM zf_students t where t.class_id=c.id and t.enddateqq > NOW()) mnumqq,
ifnull((SELECT count(t.id) as a FROM zf_students t where t.class_id=c.id and t.enddateqq > NOW())/count(DISTINCT t.id),0) as mrateqq,
(SELECT count(t.id) as a FROM zf_students t where t.class_id=c.id and t.enddateck > NOW()) mnumck,
ifnull((SELECT count(t.id) as a FROM zf_students t where t.class_id=c.id and t.enddateck > NOW())/count(DISTINCT t.id),0) as mrateck,
count(DISTINCT d.stuid) as dnum,ifnull(count(DISTINCT d.stuid)/count(DISTINCT t.id),0) as drate FROM zf_class c LEFT JOIN zf_students t on t.class_id= c.id LEFT JOIN zf_parent_student n on n.stu_id= t.id  
 LEFT JOIN zf_safe_card d on d.stuid= t.id WHERE ( c.sid = :sid ) GROUP BY c.id',[":sid"=>$sid])->queryAll();
    }
    public static function getSafecard($sid)
    {
        return \yii::$app->getDb()->createCommand('SELECT t.id,t.class_id as class,s.name,t.name as stuName,d.ctime,d.info FROM zf_school s,zf_students t,zf_safe_card as d where  t.school_id= s.id  and  d.stuid= t.id and ( s.id = :sid ) ORDER BY d.ctime desc',[":sid"=>$sid])->queryAll();
    }
    public static function getFee($sid)
    {
        return \yii::$app->getDb()->createCommand('SELECT t.id,s.name,t.name as stuName,t.class_id as class,t.upendtimepa,t.enddatepa,t.upendtimejx,t.enddatejx,t.upendtimeqq,t.enddateqq,t.upendtimeck,t.enddateck FROM zf_school s LEFT JOIN zf_students t on t.school_id= s.id   LEFT JOIN zf_safe_card d on d.stuid= t.id WHERE ( s.id = :sid ) GROUP BY t.id ORDER BY t.name desc',[":sid"=>$sid])->queryAll();
        return \yii::$app->getDb()->createCommand('SELECT t.id,s.name,t.name as stuName,t.class_id as class,t.upendtimepa,t.enddatepa,t.upendtimejx,t.enddatejx,t.upendtimeqq,t.enddateqq,t.upendtimeck,t.enddateck FROM zf_school s LEFT JOIN zf_students t on t.school_id= s.id   LEFT JOIN zf_safe_card d on d.stuid= t.id WHERE ( s.id = :sid ) GROUP BY t.id ORDER BY t.name desc',[":sid"=>$sid])->queryAll();
    }
    public static function getBind($sid)
    {
        return \yii::$app->getDb()->createCommand('SELECT t.id,s.name,ifnull(t.stu_no,0),s.name,t.name as stu_name,t.class_id FROM zf_school s LEFT JOIN zf_students t on t.school_id= s.id LEFT JOIN zf_parent_student n on n.stu_id= t.id WHERE ( s.id = :sid AND n.stu_id= t.id  )  GROUP BY t.id ORDER BY t.id desc',[":sid"=>$sid])->queryAll();
    }
    public static function getConnect($sid)
    {
        return \yii::$app->getDb()->createCommand('SELECT t3.out_uid,t3.sid,t3.stu_id as stuName,COUNT(t3.out_uid) AS 
sendNum from ( SELECT t.id,t.out_uid,t.content,t2.sid,t2.stu_id from zf_outbox t LEFT JOIN
 zf_parent_student t2 on t.out_uid=t2.parent_id where t.type=0 and t2.sid=:sid) t3 GROUP BY t3.stu_id ORDER BY COUNT(t3.out_uid) DESC',[":sid"=>$sid])->queryAll();
    }


    public static function getWeibangding($params){
        if(empty($params['school'])){
            $params['school'] ="正梵高级中学";
        }
        if(isset($params['role'])){
            if($params['role']=='yjfwbd'){
                $sql = "select a.id, a.name,b.name as class,c.name as school from zf_students a LEFT JOIN zf_class b ON a.class_id=b.id LEFT JOIN zf_school c ON a.school_id = c.id
where c.name LIKE  :schools and (a.enddatejx>NOW() or enddateqq > NOW() or  enddateck > NOW()) AND a.id  NOT in(select DISTINCT d.stu_id from zf_parent_student d ) ORDER BY a.class_id";
                return \Yii::$app->getDb()->createCommand($sql,[":schools"=>"%".$params['school']."%"])->queryAll();
            }elseif($params['role']=='wjf'){
                $sql = "SELECT a.id, a.name,b.name as class,c.name as school from zf_students a LEFT JOIN zf_class b ON a.class_id=b.id LEFT JOIN zf_school c ON a.school_id = c.id WHERE
 a.enddateqq < NOW() and a.enddatejx < NOW() and a.enddateck < NOW() and c.name LIKE :school ORDER BY a.class_id";
                return \Yii::$app->getDb()->createCommand($sql,[":school"=>"%".$params['school']."%"])->queryAll();
            }elseif($params['role']=='yjf'){
                $sql = "SELECT  a.id, a.name,b.name as class,c.name as school from zf_students a LEFT JOIN zf_class b ON a.class_id=b.id LEFT JOIN zf_school c ON a.school_id = c.id WHERE
 (a.enddateqq > NOW() or a.enddatejx > NOW() or a.enddateck > NOW()) and c.name LIKE :school ORDER BY a.class_id";
                return \Yii::$app->getDb()->createCommand($sql,[":school"=>"%".$params['school']."%"])->queryAll();
            }elseif($params['role']=='wbd'){
                return \Yii::$app->getDb()->createCommand('select a.id, a.name,b.name as class,c.name as school from zf_students a LEFT JOIN zf_class b ON a.class_id=b.id LEFT JOIN zf_school c ON a.school_id = c.id 
where c.name LIKE :schools  AND a.id NOT in(select DISTINCT d.stu_id from zf_parent_student d) ORDER BY a.class_id',[":schools"=>"%".$params['school']."%"])->queryAll();
            }else{
                return \Yii::$app->getDb()->createCommand('select a.id, a.name,b.name as class,c.name as school from zf_students a LEFT JOIN zf_class b ON a.class_id=b.id LEFT JOIN zf_school c ON a.school_id = c.id 
where c.name LIKE :schools  AND a.id in(select DISTINCT d.stu_id from zf_parent_student d) ORDER BY a.class_id',[":schools"=>"%".$params['school']."%"])->queryAll();
            }
        }
    }


}