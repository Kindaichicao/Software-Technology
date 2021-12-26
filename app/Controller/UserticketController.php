<?php

namespace App\Controller;

use App\Core\Auth;
use App\Core\Cookie;
use App\Core\Controller;
use App\Core\Request;
use App\Model\UserticketModel;

class UserticketController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        Auth::checkAuthentication();
        //Auth::ktraquyen("CN01");
        $this->View->render('userticket/index');
    }

    public function auto()
    {
        Auth::checkAuthentication();
        //Auth::ktraquyen("CN01");
        $this->View->render('userticket/auto');
    }

    public function sale()
    {
        Auth::checkAuthentication();
        //Auth::ktraquyen("CN01");
        $this->View->render('userticket/sale');
    }

    public function ticket()
    {
        Auth::checkAuthentication();
        //Auth::ktraquyen("CN01");
        $this->View->render('userticket/ticket');
    }

    public function create(){

    }

    public function update(){
        
    }

    public function delete(){
        
    }

    public function getList(){
        
        
    }

    public function getAirline(){
        
    }

    public function payment(){
        
    }

    public function getAirports()
    {
        Auth::checkAuthentication();
        // Auth::ktraquyen("CN01");
        $macv = Request::post('macv');
        $kq = UserticketModel::getAirPorts($macv);
        if($kq == null ){
            $response['thanhcong'] = false;
        } else{   
            $response['data'] = $kq['data'];
            $response['thanhcong'] = true;
        }
        $this->View->renderJSON($response);
    }
}