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

class BaseAdmin extends Controller
{
    public function __construct(){
        parent::__construct();
        $this->_admin =session('admin');

        if(!$this->_admin){
            header('location:/admins.php/admins/Account/login?error=用户未登录');
            exit();
        }
        $this->db = new Sysdb();
    }
}