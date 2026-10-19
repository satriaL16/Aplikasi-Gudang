<?php 

namespace App\Livewire\Superadmin\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected$paginationTheme = 'bootstrap';
    public $paginate = '10';
    public $search = '';
    public $nama, $email, $role, $password, $password_confirmation, $user_id;
    public function render()
    {
        $data = [
            'title' => 'Data User',
            'user' => User::where('nama', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orWhere('role', 'like', '%' . $this->search . '%')
            ->orderBy('role', 'asc')->paginate($this->paginate),
        ];
        return view('components.superadmin.user.index', $data);
    }

    public function create() {
        $this->resetValidation();
        $this->reset([
            'nama',
            'email',
            'role',
            'password',
            'password_confirmation',
        ]);
    }

    public function store()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'role' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|same:password',
        ],[
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'role.required' => 'Role wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password_confirmation.required' => 'Konfirmasi Password wajib diisi.',
            'password_confirmation.same' => 'Konfirmasi Password tidak sama dengan Password.',
        ]);

        $user = new User();
        $user->nama = $this->nama;
        $user->email = $this->email;
        $user->role = $this->role;
        $user->password = Hash::make($this->password);
        $user->save();

        $this->dispatch('close-create-modal');
    }

    public function edit($id)
    {
        $this->resetValidation();
        $user = User::findOrFail($id);
        $this->nama = $user->nama;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->password = '';
        $this->password_confirmation = '';  
        $this->user_id = $user->id;
    }
    
    public function update($id)
    {
        $user = User::findOrFail($id);
        $this->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|string|max:255',
            'password' => 'nullable|string|min:8',
        ],[
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'role.required' => 'Role wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $user->nama = $this->nama;
        $user->email = $this->email;
        $user->role = $this->role;
        if (filled($this->password)) {
            $user->password = Hash::make($this->password);
        }
        $user->save();

        $this->dispatch('close-edit-modal');
    }

    public function confirm($id)
    {
        $user = User::findOrFail($id);
        $this->nama = $user->nama;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->user_id = $user->id;
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        $this->dispatch('close-delete-modal');
    }
}