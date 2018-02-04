<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/23/023
 * Time: 19:06
 */
namespace app\admins\controller;
use think\Controller;
use Util\data\Sysdb;
/*
 *
 *管理员控制页面
 *
 */

class Upload extends BaseAdmin
{
    public function index(){
        return $this->fetch();
    }
    //上传文件
    public function savefile(){
//        var_dump($_FILES);
        $username = $_SESSION['think']['admin']['username'];
        $file=$_FILES['upvideo'];
        $data['savename'] = md5($file['name'].date('Y-m-d H:i:s').rand());
        $movepath = '../public/static/resource/uploads/'.$data['savename'].'.mp4';
        $data['savepath'] = '../../../static/resource/uploads/'.$data['savename'].'.mp4';
        $data['vd_name'] = $_POST['vd_name'];
        $data['describe'] = $_POST['describe'];
        $data['file_md5'] = md5_file($file['tmp_name']);
        $data['up_time'] = time();
        //var_dump($_SESSION['think']['admin']);
        $data['username'] = $massage_data['username'] = $space_data['username'] = $_SESSION['think']['admin']['username'];
        $space_data['truename'] = $_SESSION['think']['admin']['truename'];
        $user_imgsrc = $this->db->table('admins')->field('imgsrc')->where(array('username'=>$username))->item();
        $space_data['imgsrc'] = $user_imgsrc['imgsrc'] ;
        $space_data['vd_name'] = $_POST['vd_name'];
        $space_data['describe'] = $_POST['describe'];
        $massage_data['ms_time'] = $space_data['up_time'] = time();
        //检查资源是否存在
        $item1 = $this->db->table('resources')->where(array('file_md5'=>$data['file_md5']))->item();
        if($item1){
            $massage_data['ms_title'] = 0;
            $massage_data['ms_body'] = '上传失败，你已经上传过该内容...';
            $this->db->table('massage')->insert($massage_data);
            $this->error('上传失败  ￣□￣｜｜');
        }
        //闪电快传
        $item2 = $this->db->table('resources')->where(array('file_md5'=>$data['file_md5']))->item();
        if ($item2){
            move_uploaded_file($file['tmp_name'],$movepath);
            //发布动态
            $res = $this->db->table('space')->insert($space_data);
            if(!$res){
                $massage_data['ms_title'] = 0;
                $massage_data['ms_body'] = '上传失败，数据库异常...请联系开发人员';
                $this->db->table('massage')->insert($massage_data);
                $this->error('上传失败  ￣□￣｜｜');
            }
            $massage_data['ms_title'] = 1;
            $massage_data['ms_body'] = '你内容已经成功上传，谢谢贡献(๑•ᴗ•๑)';
            $this->db->table('massage')->insert($massage_data);
            $this->success('上传成功！Thanks♪(･ω･)ﾉ');
        }
        //资源数据存入数据库
        $res = $this->db->table('resources')->insert($data);
        if(!$res){
            $massage_data['ms_title'] = 0;
            $massage_data['ms_body'] = '上传失败，数据库异常...请联系开发人员';
            $this->db->table('massage')->insert($massage_data);
            $this->error('上传失败  ￣□￣｜｜');
        }
        move_uploaded_file($file['tmp_name'], $movepath);
        //发布动态
        $res = $this->db->table('space')->insert($space_data);
        if(!$res){
            $massage_data['ms_title'] = 0;
            $massage_data['ms_body'] = '上传失败，数据库异常...请联系开发人员';
            $this->db->table('massage')->insert($massage_data);
            $this->error('上传失败  ￣□￣｜｜');
        }
        $massage_data['ms_title'] = 1;
        $massage_data['ms_body'] = '你内容已经成功上传，谢谢贡献(๑•ᴗ•๑)';
        $this->db->table('massage')->insert($massage_data);
        $this->success('上传成功！Thanks♪(･ω･)ﾉ');
    }
}