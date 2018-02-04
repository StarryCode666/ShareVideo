<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/16/016
 * Time: 22:00
 */
namespace app\admins\controller;
use think\Controller;
use think\Db;
use Util\data\Sysdb;
/*
 *
 *
 *
 */

class Vhome extends BaseAdmin
{
    public function index()
    {
        return $this->fetch();
    }
    public function chip(){
        if (isset($_GET['flag'])){
            $flag = (int)($_GET['flag']);
            $res = $this->db->table('resources')->field('sor_id')->lists();
            $max_id = max($res)['sor_id'];
            if ($flag == 1){
                $C_id['v1'] = (int)($_GET['l_id']);
                $C_id['v1'] = $C_id['v1'] + 1;
                $C_id['v2']= $C_id['v1']+1;
                $C_id['v3']= $C_id['v2']+1;
                if ($C_id['v3'] >= $max_id || $C_id['v2'] >= $max_id || $C_id['v1'] >= $max_id){
                    $C_id['v3']= $max_id;
                    $C_id['v2']= $C_id['v3'] - 1;
                    $C_id['v1'] = $C_id['v2'] - 1;
                }
                $data['lists1'] = $this->db->table('resources')->where(array('sor_id'=>$C_id['v1']))->lists();
                $data['lists2'] = $this->db->table('resources')->where(array('sor_id'=>$C_id['v2']))->lists();
                $data['lists3'] = $this->db->table('resources')->where(array('sor_id'=>$C_id['v3']))->lists();
                $this->assign('data', $data);
//                var_dump($data);
                return $this->fetch();
            }
            if ($flag == 0){
                $C_id['v1'] = (int)($_GET['l_id']);
                $C_id['v1'] = $C_id['v1'] - 3;
                if ($C_id['v1'] <= 8) $C_id['v1']=8;
                $C_id['v2']= $C_id['v1']+1;
                $C_id['v3']= $C_id['v2']+1;
                $data['lists1'] = $this->db->table('resources')->where(array('sor_id'=>$C_id['v1']))->lists();
                $data['lists2'] = $this->db->table('resources')->where(array('sor_id'=>$C_id['v2']))->lists();
                $data['lists3'] = $this->db->table('resources')->where(array('sor_id'=>$C_id['v3']))->lists();
                $this->assign('data', $data);
//                var_dump($data);
                return $this->fetch();
            }
        }else{
            $C_id['v1']= 8;
            $C_id['v2']= $C_id['v1']+1;
            $C_id['v3']= $C_id['v2']+1;
//        dump($C_id['v1']);
            $data['lists1'] = $this->db->table('resources')->where(array('sor_id'=>$C_id['v1']))->lists();
            $data['lists2'] = $this->db->table('resources')->where(array('sor_id'=>$C_id['v2']))->lists();
            $data['lists3'] = $this->db->table('resources')->where(array('sor_id'=>$C_id['v3']))->lists();
            $this->assign('data', $data);
            return $this->fetch();
        }
    }
    public function space(){
        $data['lists'] = $this->db->table('space')->lists();
        $this->assign('data',$data);
        return $this->fetch();
    }
    public function messages(){
        $username = $_SESSION['think']['admin']['username'];
        $data['lists'] = $this->db->table('massage')->where(array('username'=>$username))->lists();
        if ($data['lists']){
        $this->assign('data',$data);
        return $this->fetch();
        }
        return $this->fetch();
    }
    public function search(){
        if (isset($_POST['search'])){
        $search_sql = ['like','%'.$_POST['search'].'%'];
        $res = $this->db->table('resources')->where(array('vd_name'=>$search_sql))->lists();
        $data['lists'] = $res;
        $this->assign('data',$data);
        return $this->fetch();

        }
        return $this->fetch();
    }
    public function love(){
        $data['username'] = $_SESSION['think']['admin']['username'];
        $data['sor_id'] = $_POST['add'];

        $res = $this->db->table('love')->where($data)->item();
        if ($res){
            $love_sum_res = $this->db->table('resources')->where(array('sor_id'=>$data['sor_id']))->setDec('love_sum');
            $res = $this->db->table('love')->where($data)->delete();
            if ($res){
            $ret['msg'] = '已经取消收藏';
            exit(json_encode($ret));
            }
        }
        $data['add_time'] = time();
        $res = $this->db->table('love')->insert($data);
        if (!$res){
            $ret['msg'] = '收藏失败';
            exit(json_encode($ret));
        }
        $love_sum_res = $this->db->table('resources')->where(array('sor_id'=>$data['sor_id']))->setInc('love_sum');
        $ret['msg'] = '收藏成功';
        exit(json_encode($ret));

    }
    public function colect(){
        $username = $_SESSION['think']['admin']['username'];
        $res = $this->db->table('love')->field('sor_id')->where(array('username'=>$username))->lists();
        if ($res){
        $j = 1;
        foreach ($res as $key=>$value){
            $i[$key] = $this->db->table('resources')->where($value)->lists();
            foreach ($i[$key] as $value2){
                $last_res[$j] = $value2;
                $j++;

            }
        }
        $data['lists'] = $last_res;
        $this->assign('data',$data);
        return $this->fetch();
        }
        return $this->fetch();
    }
}