<?php
    namespace App\Controllers;

    use App\Models\M_User;

    class user extends BaseController 
    {
        public function index(){
            $data = [
                'title' => 'Form Login',
                'tampil' => 'login',

            ];
            echo view('templates/wrapper', $data); 
        }

            public function register(){
                $data = [
                    'title' => 'Form Register',
                    'tampil' => 'register',

                ];
                echo view('templates/wrapper', $data); 
            }
        
        public function regis(){
            helper(['form', 'url', 'date']);

            $userModel = new M_user();
            
            $now = date('Y-m-d H:i:s');

            $valid = $this->validate([
                'firstname' => [
                    'label' => 'Firstname',
                    'rules' => 'required',
                    'errors' =>[
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required|is_unique[user.email]',
                    'errors' =>[
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} sudah digunakan' 
                    ]
                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => 'required',
                    'errors' =>[
                        'required' => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if(!$valid){
                echo \Config\Services::validation()->listErrors();
            }else {
                $data = [
                    'firstname' => $this->request->getVar('firstname'),
                    'lastname' => $this->request->getVar('lastname'),
                    'email' => $this->request->getVar('email'),
                    'password' => $this->request->getVar('password'),
                    'date_update' => $now
                ];
        
                $save = $userModel->insert($data);
                $session = session();
                session()->setFlashdata('message', 'selamat registrasi berhasil');
                return redirect() -> to(base_url('user'));
            }
            
            
        } 
    }