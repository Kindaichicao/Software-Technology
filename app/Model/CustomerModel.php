<?php

namespace App\Model;

use App\Core\Cookie;
use App\Core\DatabaseFactory;
use PDO;

class CustomerModel{
    public static function findOneByMaKH($makh)
    {
        $database = DatabaseFactory::getFactory()->getConnection();

        $query = $database->prepare("SELECT kh.*, hkh.ten_hang FROM khach_hang kh, hang_khach_hang hkh WHERE kh.ma_kh = :makh and kh.ma_hang_kh = hkh.ma_hang_kh LIMIT 1");
        $query->execute([':makh' => $makh]);

        if ($row = $query->fetch()) {
            return $row;
        }
        return null;
    }
    public static function create($fullname, $hochieu, $cccd, $sdt, $email, $ngaysinh, $gender, $address){
        $database = DatabaseFactory::getFactory()->getConnection();

        $sqlhkh = "SELECT ma_hang_kh FROM hang_khach_hang WHERE muc_diem = 0 and trang_thai=1";
        $qrhkh = $database->prepare($sqlhkh);
        $qrhkh->execute();
        $mahkh = $qrhkh->fetch(PDO::FETCH_COLUMN);

        $sql = "";
        if(empty($hochieu)){
            $sql .= "INSERT INTO khach_hang (ma_tk, ma_hang_kh, so_ho_chieu, ho_ten, gioi_tinh, ngay_sinh, email, cccd, sdt, dia_chi, diem_tich_luy, trang_thai)
                    VALUES ( NULL, '$mahkh', NULL, '$fullname', '$gender', '$ngaysinh', '$email', '$cccd', '$sdt', '$address', 0, 1)";
        }
        else {
            $sql .= "INSERT INTO khach_hang (ma_tk, ma_hang_kh, so_ho_chieu, ho_ten, gioi_tinh, ngay_sinh, email, cccd, sdt, dia_chi, diem_tich_luy, trang_thai)
                    VALUES ( NULL, '$mahkh', '$hochieu', '$fullname', '$gender', '$ngaysinh', '$email', '$cccd', '$sdt', '$address', 0, 1)";
        }
        $query = $database->prepare($sql);
        $query->execute();
        $count = $query->rowCount();
        if ($count == 1) {
            return true;
        }

        return false;
    }

    public static function update(){
        
    }

    public static function delete(){
        
    }

    public static function getCustomer(){
        
    }

    public static function getList($page = 1, $rowsPerPage = 10){
        $limit = $rowsPerPage;
        $offset = $rowsPerPage * ($page - 1);

        $database = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT khach_hang.*, hang_khach_hang.ten_hang from khach_hang, hang_khach_hang WHERE khach_hang.ma_hang_kh = hang_khach_hang.ma_hang_kh and khach_hang.trang_thai = 1 LIMIT :limit OFFSET :offset"; // limit 0,5
        
        $query = $database->prepare($sql);

        $query->bindValue(':limit', $limit, PDO::PARAM_INT);
        $query->bindValue(':offset', $offset, PDO::PARAM_INT);

        $query->execute();
        $data = $query->fetchAll(); // = while( $r=mysqli_fetch_array())

        // data['ten_chuc_vu']

        $count = 'SELECT COUNT(ma_kh) FROM khach_hang WHERE trang_thai = 1';

        $countQuery = $database->query($count);
        $totalRows = $countQuery->fetch(PDO::FETCH_COLUMN); // $totalRows=35

        $response = [
            'page' => $page,
            'rowsPerPage' => $rowsPerPage,
            'totalPage' => ceil(intval($totalRows) / $rowsPerPage),// 4 trang
            'data' => $data,
        ];
        return $response; 
    }
}