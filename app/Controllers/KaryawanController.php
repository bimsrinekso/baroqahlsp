<?php

namespace App\Controllers;

class KaryawanController extends BaseController
{
    public function index()
    {
        $data = [
            "result" => $this->karyawan->where('deletedAt is null')->get()->getResult()
        ];
        return view('Dashboard/hrd/Karyawan/index',$data);
    }
    public function create()
    {

        return view('Dashboard/hrd/Karyawan/create');
    }

    public function list()
    {
        $data = $this->karyawan->select('karyawan.*,golongan.namaGolongan,golongan.gajiPokok,golongan.bonus')->join('golongan','golongan.id = karyawan.golongan')->where('karyawan.deletedAt is null')->findAll();
        return $this->response->setJSON($data);
    }

    public function listUsers()
    {
        $currentKaryawanId = $this->request->getVar('selectedKar');
        $cekValid = $currentKaryawanId != "";
        $query = $this->karyawan->select('*')->where('karyawan.deletedAt is null');
        
        if ($currentKaryawanId != "") {
            $query->where('karyawan.userID IS NULL')->orWhere('karyawan.id', $currentKaryawanId);
        } else {
            $query->where('karyawan.userID IS NULL');
        }
        
        $data = $query->get()->getResult();
        return $this->response->setJSON($data);
    }
    public function save() {
        $isValid = [
            'namaKaryawan' => 'required',
            'alamat' => 'required',
            'tanggalLahir' => 'required',
            'tanggalMasuk' => 'required',
            'golongan' => 'required',
        ];
       
        if (!$this->validate($isValid)) {
            $html = $this->valid->listErrors();
            $oneline = preg_replace('/\s+/', ' ', $html);
            $this->sesi->setFlashdata('validation', $oneline);
            return redirect()->to('dashboard/karyawan/create');
        }
        $tanggalLahir = str_replace('-', '', $this->request->getVar('tanggalLahir'));
        $randomAngka = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
        $nip = $tanggalLahir . $randomAngka;
        $data = [
            'NIP'=> $nip,
            'namaKaryawan' => $this->request->getVar('namaKaryawan'),
            'alamat' => $this->request->getVar('alamat'),
            'tanggalLahir' => $tanggalLahir,
            'tanggalMasuk' => $this->request->getVar('tanggalMasuk'),
            'golongan' => $this->request->getVar('golongan'),
        ];
        try {
            $this->karyawan->save($data);
            $this->sesi->setFlashdata('sukses', 'Sukses menambah data karyawan');
            return redirect()->to('dashboard/karyawan');
        } catch (\Exception $e) {
         $e->getMessage();
        }
    }

    public function edit($id = null) {
        $data = [
            'result' => $this->karyawan->where('deletedAt is null')->where('id',$id)->first(),
        ];
        return view('Dashboard/hrd/Karyawan/edit',$data);
    }

    public function update($id = null) {
        $isValid = [
            'namaKaryawan' => 'required',
            'alamat' => 'required',
            'tanggalLahir' => 'required',
            'tanggalMasuk' => 'required',
            'golongan' => 'required',
        ];
       
        if (!$this->validate($isValid)) {
            $html = $this->valid->listErrors();
            $oneline = preg_replace('/\s+/', ' ', $html);
            $this->sesi->setFlashdata('validation', $oneline);
            return redirect()->to('dashboard/karyawan/edit/'.$id);
        }
        $data = [
            'namaKaryawan' => $this->request->getVar('namaKaryawan'),
            'alamat' => $this->request->getVar('alamat'),
            'tanggalLahir' => $this->request->getVar('tanggalLahir'),
            'tanggalMasuk' => $this->request->getVar('tanggalMasuk'),
            'golongan' => $this->request->getVar('golongan'),
        ];
        try {
            $this->karyawan->update($id,$data);
            $this->sesi->setFlashdata('sukses', 'Sukses mengubah data karyawan');
            return redirect()->to('dashboard/karyawan');
        } catch (\Exception $e) {
         $e->getMessage();
        }
    }

    public function delete($id)
    {
        $this->karyawan->delete($id);
        $this->sesi->setFlashdata('sukses', 'Data berhasil dihapus');
        return redirect()->to('dashboard/karyawan'); 
    }
}
