<?php namespace App\Filters;
 
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;
use App\Models\GroupRole;
 
class RoleManage implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        } else {
            $isUser = new UsersModel();
            $gpRole = new GroupRole();
            $cekUsername = session()->get('username');
            $getData = $isUser->where('username', $cekUsername)->join('grouprole', 'grouprole.id = users.role_id')->first();
            if(in_array($getData->role, $arguments)){
                return;
            }else{
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }    
        }
    }
 
    //--------------------------------------------------------------------
 
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}