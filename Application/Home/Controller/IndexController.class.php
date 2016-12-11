<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {
        layout('Layout/layout');
        $this->display();
    }

    public function register()
    {
        layout('Layout/layout');
        $this->display();
    }

    public function login()
    {
        layout('Layout/layout');
        $this->display();
    }

    public function single()
    {
        layout('Layout/layout');
        $this->display();
    }
}