<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $totalKaryawan = $this->karyawan->select('COUNT(*) as totalKaryawan')->where("deletedAt IS NULL")->findAll();
        $totalUser = $this->users->select('COUNT(*) as totalUser')->where("deletedAt IS NULL")->findAll();
        if($this->sesi->get('role') == 1) {
            $data = [
                "totalKaryawan" => $totalKaryawan,
                "totalUser" =>$totalUser
            ];
            return view('Dashboard/admin/index',$data);    
        } else if($this->sesi->get('role') == 2) {
            $data = [
                "totalKaryawan" => $totalKaryawan,
            ];
            return view('Dashboard/hrd/index',$data);    

        } else {
            $userid = $this->sesi->get('user_id');
            $dataUsers = $this->users->join('karyawan','karyawan.userID = users.id')
            ->where("users.deletedAt IS NULL")->where("karyawan.deletedAt IS NULL")->where('users.id',$userid)->first();
            $data = [ 
                "dataUsers" => $dataUsers,
            ];
            return view('Dashboard/karyawan/index',$data);
        }
    }
}
