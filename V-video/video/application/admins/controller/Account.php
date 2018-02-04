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
 *
 *
 */

class Account extends Controller{
    public function login(){

        return $this->fetch();
    }
    public function dologin(){
        $username = $_POST['username'];
        $pwd =md5($_POST['username'].$_POST['password']);
        $imgcode = $_POST['imgcode'];
        if(empty($username) || empty($pwd) || empty($imgcode)){
            $this->redirect('/admins.php/admins/Account/login?error=用户名和密码及验证码不能为空');
        }
        //获取数据库
        $this->db = new Sysdb();
        $admin = $this->db->table('admins')->where(array('username'=>$username))->item();
        //验证
        $error = '错误';
        if(!captcha_check($imgcode)){
            $this->redirect('/admins.php/admins/Account/login?error=验证码错误');
        }

        if(!$admin){
            $this->redirect('/admins.php/admins/Account/login?error=账号不存在');
        }
        if($pwd !== $admin['password']){
            $this->redirect('/admins.php/admins/Account/login?error=密码错误');
        }
        if($admin['status'] == 1){
            $this->redirect('/admins.php/admins/Account/login?error=用户已封号');
        }
        //设置session
        session('admin',$admin);
        $this->redirect('/admins.php/admins/Vhome/index?success=登录成功');

    }
}