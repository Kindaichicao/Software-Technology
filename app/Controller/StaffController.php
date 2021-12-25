<?php

namespace App\Controller;

use App\Core\Auth;
use App\Core\Cookie;
use App\Core\Controller;
use App\Core\Request;
use App\Model\StaffModel;

class StaffController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function staff()
    {
        Auth::checkAuthentication();
        //Auth::ktraquyen("CN01");
        $this->View->render('staff/staff');
    }

    public function create(){
        Auth::checkAuthentication();
        // Auth::ktraquyen("CN04");
        $tennhanvien = Request::post('tennhanvien');
        $gioitinhnhanvien = Request::post('gioitinhnhanvien');
        $ngaysinhnhanvien = Request::post('ngaysinhnhanvien');
        $emailnhanvien = Request::post('emailnhanvien');
        $cccdnhanvien = Request::post('cccdnhanvien');
        $sodienthoainhanvien = Request::post('sodienthoainhanvien');
        $diachinhanvienn = Request::post('diachinhanvienn');

        $kq = StaffModel::create($tennhanvien, $gioitinhnhanvien, $ngaysinhnhanvien, $emailnhanvien, $cccdnhanvien, $sodienthoainhanvien, $diachinhanvienn);
        $response = [
            'thanhcong' => $kq
        ];
        $this->View->renderJSON($response);
    }

    public function update(){
        
    }

    public function delete(){
        
    }

    public function getList(){
        Auth::checkAuthentication(); // Ktra có đang đăng nhập hay chưa
        //Auth::ktraquyen("CN01");
        $search = Request::get('search');
        $page = Request::get('page', 1);
        $rowsPerPage = Request::get('rowsPerPage', 10);
        $data = StaffModel::getList($page, $rowsPerPage);
        $this->View->renderJSON($data);
    }

    public function getStaff(){
        Auth::checkAuthentication();
        // Auth::ktraquyen("CN01");
        $manv = Request::post('manv');
        $kq1 = StaffModel::getStaff($manv);
        $response['thanhcong'] = false;
        if($kq1 == null ){
            $response['thanhcong'] = false;
        } else{   
            $response['ma_nv'] = $kq1->ma_nv;
            $response['ma_tk'] = $kq1->ma_tk;
            $response['ho_ten'] = $kq1->ho_ten;
            $response['gioi_tinh'] = $kq1->gioi_tinh;
            $response['ngay_sinh'] = $kq1->ngay_sinh;
            $response['email'] = $kq1->email;
            $response['cccd'] = $kq1->cccd;
            $response['sdt'] = $kq1->sdt;
            $response['dia_chi'] = $kq1->dia_chi;
            $response['thanhcong'] = true;
        }
        $this->View->renderJSON($response);
    }
    public function advancedSearch()
    {
        Auth::checkAuthentication();
        //Auth::ktraquyen("CN01");
        $search = Request::get('search');
        $search2 = Request::get('search2');
        $page = Request::get('page', 1);
        $rowsPerPage = Request::get('rowsPerPage', 10);
        $data = StaffModel::getAdvancedPagination($search, $search2,$page, $rowsPerPage);
        $this->View->renderJSON($data);
    }  
}