<?php
/**
 * Created by PhpStorm.
 * author: huanglele
 * Date: 2016/6/3
 * Time: 16:47
 * Description:
 */

namespace Admin\Controller;


class UserController extends CommonController
{

    /**
     * 显示
     */
    public function index(){
        $map = array();
        $uid = I('get.uid');
        if($uid){
            $map['uid'] = $uid;
        }
        $this->assign('uid',$uid);

        $name = I('get.name');
        if($name){
            $map['nickname'] = array('like','%'.$name.'%');
        }
        $this->assign('name',$name);

        $order = 'uid desc';
        $this->getData('user',$map,$order,'uid,headimgurl,nickname,vip,money');
        $this->assign('Status',C('UserStatue'));

        $this->display('index');
    }

    /**
     * 查看一个用户的详细信息
     */
    public function detail(){
        $uid = I('get.uid');
        $info = M('user')->find($uid);
        $this->assign('info',$info);
        if($info['agent']){ //查看团队信息
            $map['leader'] = session('uid');
            $teamNum = $this->getCount('user',$map);
            $this->assign('teamNum',$teamNum);
        }
        $this->assign('VipMap',S('VipMap'));
        $this->display('detail');
    }

    /**
     * 更新一个用户的等级
     */
    public function update(){
        $data = $_POST;
        M('user')->save($data);
        $this->success('操作成功');
    }

}