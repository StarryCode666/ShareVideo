<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/16/016
 * Time: 22:00
 */
namespace app\admins\controller;
use think\Controller;
use Util\data\Sysdb;
/*
 *
 *管理员控制页面
 *
 */

class Admin extends BaseAdmin
{
    //管理员列表
    public function index(){
        $data['lists']=$this->db->table('admins')->lists();
        $this->assign('data',$data);
        return $this->fetch();
    }
    public function save(){
        $data['username'] = trim(input('post.username'));
        $data['gid'] = (int)(input('post.gid'));
        $password = trim(input('post.password'));
        $data['truename'] = trim(input('post.truename'));
        $data['status'] = (int)(input('post.status'));
        $data['add_time'] = time();
        $error[]=array('code'=>0,'msg'=>'error');

        if($data['username'] ==''){
            $error['msg']='请输入正确用户名';
            return $error;
        }
        if($data['gid'] == ''){
            $error['msg']='请选择角色';
            return $error;
        }
        if($password == ''){
            $error['msg']='请输入密码';
            return $error;
        }
        if($data['truename'] == ''){
            $error['msg']='请输入真名';
            return $error;
        }
        //检查用户名是否存在
        $item = $this->db->table('admins')->where(array('username'=>$data['username']))->item();
        if($item){
            $error['msg']='用户名已存在';
            return $error;
        }
        $data['password'] = md5($data['username'].$password);
        $res = $this->db->table('admins')->insert($data);
        if(!$res){
            $error['msg']='注册失败';
            return $error;
        }
        return $succesed[]=array('code'=>1,'msg'=>'注册成功');
    }
    public function save_user(){
        $data['username'] = trim(input('post.username'));
        $password = trim(input('post.password'));
        $data['truename'] = trim(input('post.truename'));
        $data['sex'] = (int)(input('post.sex'));
        $data['gid'] = 51;
        $data['status'] = 0;
        $data['add_time'] = time();
        $error[]=array('code'=>0,'msg'=>'error');

        if($data['username'] ==''){
            $error['msg']='请输入正确用户名';
            return $error;
        }
        if($password == ''){
            $error['msg']='请输入密码';
            return $error;
        }
        if($data['truename'] == ''){
            $error['msg']='请输入真名';
            return $error;
        }
        if($data['sex'] == ''){
            $error['msg']='请选择性别';
            return $error;
        }
        //检查用户名是否存在
        $item = $this->db->table('admins')->where(array('username'=>$data['username']))->item();
        if($item){
            $error['msg']='用户名已存在';
            return $error;
        }
        $data['password'] = md5($data['username'].$password);
        $res = $this->db->table('admins')->insert($data);
        if(!$res){
            $error['msg']='注册失败';
            return $error;
        }
        return $succesed[]=array('code'=>1,'msg'=>'注册成功');
    }
}