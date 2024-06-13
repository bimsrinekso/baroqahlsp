<?php

namespace App\Controllers;

class GajiController extends BaseController
{
    public function index()
    {
        if ($this->sesi->get('role') == 3) {
            $userid = $this->sesi->get('user_id');
            $dataKar = $this->users->select("karyawan.id")->join('karyawan','karyawan.userID = users.id')
            ->where("users.deletedAt IS NULL")->where("karyawan.deletedAt IS NULL")->where('users.id',$userid)->first();
            $data = [
                "dataKar" =>$dataKar
            ];
            return view('Dashboard/karyawan/Gaji/index',$data);
        } else {
            return view('Dashboard/hrd/Gaji/index');
        }
    }

    public function list()
    {
        $startDate = $this->request->getVar('startDate');
        $endDate = $this->request->getVar('endDate');
        $idKaryawan = $this->request->getVar('karyawanID');
    
        $query = $this->karyawan->select(
            'karyawan.id as karyawanId,
            karyawan.namaKaryawan,
            karyawan.NIP,
            karyawan.tanggalMasuk,
            golongan.gajiPokok,
            karyawan.golongan,
            gaji.bulanGaji,
            gaji.totalGaji,
            gaji.totalPotongan,
            gaji.totalBonus,
            golongan.bonus'
        )
        ->join('golongan', 'golongan.id = karyawan.golongan')
        ->join('gaji', 'gaji.karyawanId = karyawan.id')
        ->where('karyawan.deletedAt is null');
            
        if ($idKaryawan != null) {
            $query = $query->where('karyawan.id', $idKaryawan);
        }
        if ($startDate != '' && $endDate != '') {
            $query = $query
            ->where('gaji.bulanGaji >=', $startDate)
            ->where('gaji.bulanGaji <=', $endDate);
        }
    
        $data = $query->findAll();
        try {
            return $this->response->setJSON(['data' => $data]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => $e->getMessage()]);
        }
    }
    

    public function save() {
        $isValid = [
            'karyawanId' => 'required',
            'bulanGaji' => 'required',
            'gajiPokok' => 'required',
            'totalBonus' => 'required',
            'totalPotongan' => 'required',
            'totalgaji' => 'required'
        ];
        

        if (!$this->validate($isValid)) {
            $html = $this->valid->listErrors();
            $oneline = preg_replace('/\s+/', ' ', $html);
            return $this->response->setJSON(['success' => 400,'message' => $oneline]);
        }
        $idKar = $this->request->getVar('karyawanIDdd');
        $month = $this->request->getVar('month');
        $cekDataDup = $this->gaji->where('bulanGaji',$month)->where('karyawanId',$idKar)->first();

        if (!empty($cekDataDup)) {
            return $this->response->setJSON(['dataDup' => $cekDataDup,'success' => 400, 'message' => 'Duplicate entry']);
        }
    
        $data = [
            "karyawanId" => $idKar,
            "bulanGaji" => $month,
            "gajiPokok" => $this->request->getVar('gajiPokok'),
            "totalBonus" => $this->request->getVar('totalBonus'),
            "totalPotongan" => $this->request->getVar('totalPotongan'),
            "totalGaji" => $this->request->getVar('totalGaji')
        ];
    
        try {
            $this->gaji->save($data);
            return $this->response->setJSON(['dataBody' => $data,'success' => 200, 'message' => 'Sukses menghitung']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['dataBody' => $data,'success' => 400, 'message' => $e->getMessage()]);
        }
    }
    
    

}
