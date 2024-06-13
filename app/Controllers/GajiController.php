<?php

namespace App\Controllers;

class GajiController extends BaseController
{
    public function index()
    {
        return view('Dashboard/hrd/Gaji/index');
    }

    public function list()
    {
        $startDate = $this->request->getVar('startDate');
        $endDate = $this->request->getVar('endDate');
        $idKaryawan = $this->request->getVar('karyawanID');
        $data;
    
        // Default query for all employees with their salary data
        $query = $this->karyawan->select(
            'gaji.*,
            karyawan.namaKaryawan,
            karyawan.NIP,
            karyawan.tanggalMasuk,
            karyawan.gajiPokok,
            karyawan.golongan,
            golongan.bonus'
        )
        ->join('golongan', 'golongan.id = karyawan.golongan')
        ->join('gaji', 'gaji.karyawanId = karyawan.id', 'left')
        ->where('karyawan.deletedAt is null')
        ->where('gaji.deletedAt is null');
    
        // Apply date filters if provided
        if ($startDate != '') {
            $query = $query
                ->where('MONTH(gaji.bulanGaji) >=', $startDate)
                ->where('MONTH(gaji.bulanGaji) <=', $endDate);
        }
    
        // Apply employee ID filter if provided
        if ($idKaryawan != null) {
            $query = $query->where('karyawan.id', $idKaryawan);
        }
    
        // Execute the query and get the results
        $data = $query->findAll();
    
        // Check for employees with no matching salary records
        if (empty($data) && ($startDate != '' || $idKaryawan != null)) {
            $query = $this->karyawan->select(
                'null as gajiId,
                karyawan.id as karyawanId,
                karyawan.namaKaryawan,
                karyawan.NIP,
                karyawan.tanggalMasuk,
                karyawan.gajiPokok,
                karyawan.golongan,
                null as bulanGaji,
                null as totalGaji,
                golongan.bonus'
            )
            ->join('golongan', 'golongan.id = karyawan.golongan')
            ->where('karyawan.deletedAt is null');
    
            if ($idKaryawan != null) {
                $query = $query->where('karyawan.id', $idKaryawan);
            }
    
            $data = $query->findAll();
        }
    
        try {
            return $this->response->setJSON(['data' => $data]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => $e->getMessage()]);
        }
    }

    public function save() {
        
    }
    

}
