<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/3/003
 * Time: 10:49
 */
namespace app\admins\controller;
use think\Controller;
use think\Db;
use Util\data\Sysdb;

class User extends BaseAdmin
{
    public function index(){
        $username = $_SESSION['think']['admin']['username'];
        $data['user_data'] = $this->db->table('admins')->where(array('username'=>$username))->lists();
        $data['user_video'] = $this->db->table('resources')->field('vd_name,up_time,love_sum')->where(array('username'=>$username))->lists();
        $this->assign('data',$data);
        return $this->fetch();
    }
    public function updata(){

        $username = $_SESSION['think']['admin']['username'];
        $_POST['birthday'] = trim($_POST['birthday']);
        $res = $this->db->table('admins')->where(array('username'=>$username))->setField($_POST);
        if ($res){
            $ret['msg'] = '修改成功^_^';
            exit(json_encode($ret));
        }
        $ret['msg'] = '修改失败+_+';
        exit(json_encode($ret));
    }
    public function upimg(){
        $username = $_SESSION['think']['admin']['username'];
        $file=$_FILES['img'];
        $savename = md5($file['name'].date('Y-m-d H:i:s').rand());
        $movepath = '../public/static/resource/images/'.$savename.'.jpg';
        $data['imgsrc'] = '../../../static/resource/images/'.$savename.'.jpg';
        move_uploaded_file($file['tmp_name'],$movepath);
        $res_user = $this->db->table('admins')->where(array('username'=>$username))->setField($data);
        $res_space = $this->db->table('space')->where(array('username'=>$username))->setField($data);
        $this->success('上传成功');
    }
}