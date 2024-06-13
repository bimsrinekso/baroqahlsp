<?php

namespace App\Controllers;

class AuthLogin extends BaseController
{
    public function index()
    {
        if($this->sesi->get('logged_in') == true){
            return redirect()->to('/');
        }else{
            $data = [
                'validation' => $this->valid
            ];
            return view('Auth/Login/index', $data);
        }
    }

    public function cekLogin(){
        $isValid = [
            'username' => 'required',
            'password' => 'required|min_length[6]',
        ];
        if (!$this->validate($isValid)) {
            return redirect()->to('/login')->withInput()->with('validation', '');
        }
        $user = $this->users->where("username", $this->request->getVar("username"))->first();
        if (!$user) {
            $this->sesi->setFlashdata('error', 'Username tidak ditemukan');
            return redirect()->to('/login');
        }else{
            $cekPw = password_verify($this->request->getVar("password"), $user->password);
            if(!$cekPw){
                $this->sesi->setFlashdata('error', 'Password salah');
                return redirect()->to('/login');
            }else {
                $ses_data = [
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'logged_in' => true,
                    'role' => $user->role_id,
                    'avatar' => $user->avatar
                ];
                $this->sesi->set($ses_data);
                return redirect()->to('/dashboard');
            }
        }
    }

    public function isLogout(){
        $this->sesi->destroy();
        return redirect()->to('/login');
    }
}