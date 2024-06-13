<?php

namespace App\Controllers;

class GolonganController extends BaseController
{
    public function index()
    {
        $data = [
            "result" => $this->golongan->where('deletedAt is null')->get()->getResult()
        ];
        return view('Dashboard/hrd/Golongan/index',$data);
    }
    public function create()
    {

        return view('Dashboard/hrd/Golongan/create');
    }

    public function list()
    {
        $data = $this->golongan->where('deletedAt is null')->findAll();
        return $this->response->setJSON($data);
    }

    public function save() {
        $isValid = [
            'namaGolongan' => 'required',
            'bonus' => 'required',
        ];
       
        if (!$this->validate($isValid)) {
            $html = $this->valid->listErrors();
            $oneline = preg_replace('/\s+/', ' ', $html);
            $this->sesi->setFlashdata('validation', $oneline);
            return redirect()->to('dashboard/golongan/create');
        }
        $bonus = filter_var($this->request->getVar('bonus'), FILTER_SANITIZE_NUMBER_INT);
        $bonus = $bonus / 100;
        $gaji = $this->request->getVar('gajiPokok');
        $gaji = preg_replace('/[^\d.]/', '', $gaji);
        $data = [
           'namaGolongan' => $this->request->getVar('namaGolongan'),
           'gajiPokok' => $gaji,
           'bonus' => $bonus,
        ];
        try {
            $this->golongan->save($data);
            $this->sesi->setFlashdata('sukses', 'Sukses menambah data golongan');
            return redirect()->to('dashboard/golongan');
        } catch (\Exception $e) {
         $e->getMessage();
        }
    }

    public function edit($id = null) {
        $data = [
            'result' => $this->golongan->where('deletedAt is null')->where('id',$id)->first(),
        ];
        return view('Dashboard/hrd/Golongan/edit',$data);
    }

    public function update($id = null) {
        $isValid = [
            'namaGolongan' => 'required',
            'bonus' => 'required',
        ];
       
        if (!$this->validate($isValid)) {
            $html = $this->valid->listErrors();
            $oneline = preg_replace('/\s+/', ' ', $html);
            $this->sesi->setFlashdata('validation', $oneline);
            return redirect()->to('dashboard/golongan/edit/'.$id);
        }
        $bonus = filter_var($this->request->getVar('bonus'), FILTER_SANITIZE_NUMBER_INT);
        $bonus = $bonus / 100;
        $gaji = $this->request->getVar('gajiPokok');
        $gaji = preg_replace('/[^\d.]/', '', $gaji);
        $data = [
            'namaGolongan' => $this->request->getVar('namaGolongan'),
            'gajiPokok' => $gaji,
            'bonus' => $bonus,
        ];
        try {
            $this->golongan->update($id,$data);
            $this->sesi->setFlashdata('sukses', 'Sukses mengubah data golongan');
            return redirect()->to('dashboard/golongan');
        } catch (\Exception $e) {
         $e->getMessage();
        }
    }

    public function delete($id)
    {
        $this->golongan->delete($id);
        $this->sesi->setFlashdata('sukses', 'Data berhasil dihapus');
        return redirect()->to('dashboard/golongan'); 
    }
}
