<?php

namespace App\Livewire;

use App\Models\User;
use FontLib\Table\Type\name;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Rule;
use Livewire\Component;



use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;


class UserRegistration extends Component
{
    
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        event(new Registered($user = User::where('email', $this->email)->first()));

        Auth::login($user);

        return redirect('/dashboard');

       
    }


    public function render()
    {
        return view('livewire.user-registration');
    }
}
