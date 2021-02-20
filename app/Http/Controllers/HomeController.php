<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    //Cuenta
    public function profile()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        // dd($request);
        $request->validate([
            'first_name' => ['required', 'string', 'min:5', 'max:255'],
            'last_name' => ['required', 'string', 'min:5', 'max:255'],
            'phone' => ['required', 'digits:10'],
            'password' => ['nullable','min:6','string','max:255'],
            'image' => ['image']
        ]);

        //perfil
        $profile = Auth::user()->profile;

        if($request->password){
            $user = User::find(Auth::user()->id);
            $user->password = Hash::make($request->password);
            $user->save();
        }

        if ($request->image) {
            //Guardar la imagen en el servidor
            $path = $request->image->store('profiles', 'public');

            if($profile->image){
                unlink('storage/' . $profile->image);
            }

            $profile->image = $path;
        }

        //Actualizar datos
        $profile->first_name = $request->first_name;
        $profile->last_name = $request->last_name;
        $profile->phone = $request->phone;

        $profile->save();

        return redirect('/profile')->with('success','Tus datos han sido actualizados.');
    }
}
