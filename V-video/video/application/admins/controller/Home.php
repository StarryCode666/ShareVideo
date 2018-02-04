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

class Home extends BaseAdmin
{
    public function index(){
        return $this->fetch();
    }
    public function Welcome(){
        return $this->fetch();
    }
}