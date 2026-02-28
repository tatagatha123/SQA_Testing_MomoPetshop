<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class Auth extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // ─────────────────────────────────────────
    // FORM LOGIN — GET /login
    // ─────────────────────────────────────────
    public function login(): string|RedirectResponse
    {
        // Kalau sudah login, langsung ke dashboard
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login', [
            'title'      => 'Login',
            'validation' => null,
        ]);
    }

    // ─────────────────────────────────────────
    // PROSES LOGIN — POST /login
    // ─────────────────────────────────────────
    public function loginProses(): string|RedirectResponse
    {
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        if (! $this->validate($rules)) {
            return view('auth/login', [
                'title'      => 'Login',
                'validation' => $this->validator,
            ]);
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->userModel->verifyLogin($username, $password);

        if (! $user) {
            return view('auth/login', [
                'title'      => 'Login',
                'validation' => null,
                'error'      => 'Username atau password salah.',
            ]);
        }

        // Set session
        session()->set([
            'id_user'   => $user['id_user'],
            'username'  => $user['username'],
            'logged_in' => true,
        ]);

        return redirect()->to('/dashboard')->with('success', 'Selamat datang, ' . $user['username'] . '!');
    }

    // ─────────────────────────────────────────
    // FORM REGISTER — GET /register
    // ─────────────────────────────────────────
    public function register(): string|RedirectResponse
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/register', [
            'title'      => 'Buat Akun',
            'validation' => null,
        ]);
    }

    // ─────────────────────────────────────────
    // PROSES REGISTER — POST /register
    // ─────────────────────────────────────────
    public function registerProses(): string|RedirectResponse
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
                'max_length' => 'Username maksimal 50 karakter.',
                'is_unique'  => 'Username sudah digunakan, pilih yang lain.',
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
            return view('auth/register', [
                'title'      => 'Buat Akun',
                'validation' => $this->validator,
            ]);
        }

        $this->userModel->insert([
            'username' => $this->request->getPost('username'),
            'password' => $this->userModel->hashPassword($this->request->getPost('password')),
        ]);

        return redirect()->to('/login')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }

    // ─────────────────────────────────────────
    // LOGOUT — GET /logout
    // ─────────────────────────────────────────
    public function logout(): RedirectResponse
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Kamu berhasil logout.');
    }
}