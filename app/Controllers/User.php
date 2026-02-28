<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class User extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // ─────────────────────────────────────────
    // LIST — GET /user
    // ─────────────────────────────────────────
    public function index(): string
    {
        $search = $this->request->getGet('search');

        $builder = $this->userModel;

        if ($search) {
            $builder = $this->userModel->like('username', $search);
        }

        $users = $builder->findAll();

        return view('user/index', [
            'title'  => 'Manajemen User',
            'menu'   => 'user',
            'users'  => $users,
            'search' => $search,
        ]);
    }

    // ─────────────────────────────────────────
    // FORM TAMBAH — GET /user/create
    // ─────────────────────────────────────────
    public function create(): string
    {
        return view('user/form', [
            'title'      => 'Tambah User',
            'menu'       => 'user',
            'user'       => null,
            'validation' => null,
        ]);
    }

    // ─────────────────────────────────────────
    // SIMPAN — POST /user/store
    // ─────────────────────────────────────────
    public function store()
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'password' => 'required|min_length[6]',
            'konfirmasi_password' => 'required|matches[password]',
        ];

        $messages = [
            'username' => [
                'required'   => 'Username wajib diisi.',
                'min_length' => 'Username minimal 3 karakter.',
                'is_unique'  => 'Username sudah digunakan.',
            ],
            'password' => [
                'required'   => 'Password wajib diisi.',
                'min_length' => 'Password minimal 6 karakter.',
            ],
            'konfirmasi_password' => [
                'required' => 'Konfirmasi password wajib diisi.',
                'matches'  => 'Konfirmasi password tidak cocok.',
            ],
        ];

        if (! $this->validate($rules, $messages)) {
            return view('user/form', [
                'title'      => 'Tambah User',
                'menu'       => 'user',
                'user'       => null,
                'validation' => $this->validator,
            ]);
        }

        $this->userModel->insert([
            'username' => $this->request->getPost('username'),
            'password' => $this->userModel->hashPassword($this->request->getPost('password')),
        ]);

        return redirect()->to('/user')->with('success', 'User berhasil ditambahkan.');
    }

    // ─────────────────────────────────────────
    // HAPUS — GET /user/delete/{id}
    // ─────────────────────────────────────────
    public function delete(int $id)
    {
        $user = $this->userModel->find($id);

        if (! $user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("User dengan ID $id tidak ditemukan.");
        }

        // Cegah hapus diri sendiri
        $session = session();
        if ($session->get('id_user') == $id) {
            return redirect()->to('/user')->with('error', 'Tidak dapat menghapus akun yang sedang aktif.');
        }

        $this->userModel->delete($id);

        return redirect()->to('/user')->with('success', 'User berhasil dihapus.');
    }
}
