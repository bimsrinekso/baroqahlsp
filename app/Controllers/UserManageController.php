<?php

namespace App\Controllers;
use Ramsey\Uuid\Uuid;
class UserManageController extends BaseController
{
    public function index()
    {
        return view('Dashboard/admin/usermanage/index');
    }
    public function list()
    {
        $data = $this->users->select('users.*,grouprole.role')->join('grouprole','grouprole.id = users.role_id')->where('users.deletedAt is null')->findAll();
        return $this->response->setJSON($data);
    }

    public function create()
    {
        return view('Dashboard/admin/usermanage/create');
    }

    public function save()
    {
        $isValid = [
            'username' => 'required',
            'email' => 'required',
            'password' => 'required|min_length[6]',
            'role' => 'required',
        ];
       
        if (!$this->validate($isValid)) {
            $html = $this->valid->listErrors();
            $oneline = preg_replace('/\s+/', ' ', $html);
            $this->sesi->setFlashdata('validation', $oneline);
            return redirect()->to('dashboard/usermanage/create');
        }
        $uuid = Uuid::uuid4();
        $dataUsers = [
            'id' => $uuid->toString(),
            'username' => $this->request->getVar('username'),
            'email' => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
            'role_id' => $this->request->getVar('role'),
            'avatar' => 'default.png'
        ];
        try {
            $this->users->insert($dataUsers);
            $this->sesi->setFlashdata('sukses', 'Sukses menambah data user');
            return redirect()->to('dashboard/usermanage');
        } catch (\Exception $e) {
         $e->getMessage();
        }
    }
    
    public function edit($id = null) {
        $data = [
            'result' => $this->users->where('deletedAt is null')->where('id',$id)->first(),
        ];
        return view('Dashboard/admin/usermanage/edit',$data);
    }

    public function update($id = null) {
        $isValid = [
            'username' => 'required',
            'email' => 'required',
            'role' => 'required',
        ];
       
        if (!$this->validate($isValid)) {
            $html = $this->valid->listErrors();
            $oneline = preg_replace('/\s+/', ' ', $html);
            $this->sesi->setFlashdata('validation', $oneline);
            return redirect()->to('dashboard/usermanage/edit/'.$id);
        }
        $data = [
            'username' => $this->request->getVar('username'),
            'email' => $this->request->getVar('email'),
            'role_id' => $this->request->getVar('role'),
        ];
        try {
            $this->users->update($id,$data);
            $this->sesi->setFlashdata('sukses', 'Sukses mengubah data user');
            return redirect()->to('dashboard/usermanage');
        } catch (\Exception $e) {
         $e->getMessage();
        }
    }

    public function delete($id)
    {
        $this->users->delete($id);
        $this->sesi->setFlashdata('sukses', 'Data berhasil dihapus');
        return redirect()->to('dashboard/usermanage'); 
    }

    public function getRole()
    {
       $data = $this->grole->findAll();
       return $this->response->setJSON($data);
    }
}
