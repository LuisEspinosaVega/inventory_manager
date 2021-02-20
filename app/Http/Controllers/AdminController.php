<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Office;
use App\Models\Provider;
use App\Models\Rol;
use App\Models\User;
use App\Models\Variable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:main_admin');
        $this->middleware('auth');
    }

    public function index()
    {
        // $this->authorize('main_admin'); //Usar las gates definidas

        return view('admin.index');
    }

    //Handle users ----------------------------------------------------------------------------------------------- users
    public function users()
    {
        if (Auth::user()->id != 1) {
            abort('403', 'Sin permisos');
        }
        $users = User::simplePaginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        if (Auth::user()->id != 1) {
            abort('403', 'Sin permisos');
        }
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {

        $newUser = $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:5', 'max:255']
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return redirect('/admin/users');
    }

    public function destroyUser(Request $request)
    {
        if ($request->id_user == 1) {
            abort('403', 'No puedes eliminar al administrador');
        }

        $user = User::find($request->id_user);
        if ($user->profile->image) {
            unlink('storage/' . $user->profile->image);
        }

        $user->profile->delete();

        $user->delete();

        return "deleted";
    }

    public function editUser(User $user)
    {
        if (Auth::user()->id != 1) {
            abort('403', 'Sin permisos');
        }
        // dd($user);
        $rols = Rol::all();
        return view('admin.users.edit', compact('user', 'rols'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:255'],
            'email' => ['required', 'email', 'max:255', "unique:users,email,{$user->id},id"],
            'rol' => ['required']
        ]);

        if ($request->password) {
            $request->validate([
                'password' => ['min:5', 'max:255']
            ]);

            $user->password = Hash::make($request->password);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        //Guardar el rol en perfil
        $user->profile->rol_id = $request->rol;

        $user->profile->save();
        $user->save();

        return redirect('/admin/users');
    }

    // handle category-------------------------------------------------------------------------------------------category
    public function categories()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function createCategory()
    {
        return view('admin.categories.create');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:255', 'unique:categories']
        ]);

        Category::create([
            'name' => $request->name
        ]);

        return redirect('/admin/categories');
    }

    public function editCategory(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, Category $category)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:255', 'unique:categories']
        ]);

        $category->name = $request->name;
        $category->save();

        return redirect('/admin/categories');
    }

    //No delete for awheile

    // handle variables-------------------------------------------------------------------------------------------------------variables
    public function variables()
    {
        $variables = Variable::all();
        $categories = Category::all();
        return view('admin.variables.index', compact('variables', 'categories'));
    }

    public function createVariable()
    {
        $categories = Category::all();
        return view('admin.variables.create', compact('categories'));
    }

    public function storeVariable(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:3', 'max:255'],
            'description' => ['nullable'],
            'category_id' => ['required']
        ]);

        Variable::create([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id
        ]);

        return redirect('/admin/variables');
    }

    public function editVariable(Variable $variable)
    {
        $categories = Category::all();
        return view('admin.variables.edit', compact('variable', 'categories'));
    }

    public function updateVariable(Request $request, Variable $variable)
    {
        $request->validate([
            'name' => ['required', 'min:3', 'max:255'],
            'description' => ['nullable'],
            'category_id' => ['required']
        ]);

        $variable->name = $request->name;
        $variable->description = $request->description;
        $variable->category_id = $request->category_id;

        $variable->save();

        return redirect('/admin/variables');
    }

    // Not destroy forawhile

    // handle rols------------------------------------------------------------------------------------------------------rols
    public function rols()
    {
        $rols = Rol::all();
        return view('admin.rols.index', compact('rols'));
    }

    public function createRol()
    {
        return view('admin.rols.create');
    }

    public function storeRol(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:255', 'unique:rols'],
            'description' => ['required', 'min:5', 'string']
        ]);

        Rol::create([
            'name' => $request->name,
            'description' => $request->description,
            'main_admin' => 0,
            'main_inventory' => isset($request->main_inventory) ? 1 : 0,
            'edit_inventory' => isset($request->edit_inventory) ? 1 : 0,
            'main_rh' => isset($request->main_rh) ? 1 : 0,
            'edit_rh' => isset($request->edit_rh) ? 1 : 0,
            'main_social' => isset($request->main_social) ? 1 : 0,
            'edit_social' => isset($request->edit_social) ? 1 : 0,
            'main_finance' => isset($request->main_finance) ? 1 : 0,
            'edit_finance' => isset($request->edit_finance) ? 1 : 0
        ]);

        return redirect('/admin/rols');
    }

    public function editRol(Rol $rol)
    {
        if ($rol->id == 1 || $rol->id == 2) {
            abort('403', 'No tienes permiso para esta acción');
        }
        return view('admin.rols.edit', compact('rol'));
    }
    // handle providers-------------------------------------------------------------------------------------------------------------
    public function providers()
    {
        $providers = Provider::where('id','>','1')->get();
        return view('admin.providers.index', compact('providers'));
    }

    public function createProvider()
    {
        //Mandar las variables para los filtros (*￣3￣)╭
        $type = Category::select('id')->where('name', 'Tipo proveedor')->pluck('id')[0];
        $bank = Category::select('id')->where('name', 'Banco')->pluck('id')[0];

        $types = Variable::where('category_id', $type)->get();
        $banks = Variable::where('category_id', $bank)->get();

        return view('admin.providers.create', compact('types','banks'));
    }

    public function storeProvider(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:255', 'unique:providers'],
            'type' => ['required'],
            'account' => ['nullable', 'min:24', 'max:25'],
            'clabe' => ['nullable', 'min:18', 'max:19'],
            'rfc' => ['nullable', 'min:12','max:13'],
            'reazon' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'cp' => ['nullable', 'digits:5'],
            'contact' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'digits:10'],
            'about' => ['nullable', 'max:255'],
            'image' => ['image']
        ]);

        if ($request->image) {
            //Guardar la imagen en el servidor
            $path = $request->image->store('providers', 'public');
        } else {
            $path = null;
        }

        Provider::create([
            'name' => $request->name,
            'type' => $request->type,
            'account' => $request->account,
            'clabe' => $request->clabe,
            'rfc' => $request->rfc,
            'reazon' => $request->reazon,
            'country' => $request->country,
            'city' => $request->city,
            'address' => $request->address,
            'cp' => $request->cp,
            'contact' => $request->contact,
            'email' => $request->email,
            'phone' => $request->phone,
            'about' => $request->about,
            'image' => $path
        ]);

        return redirect('/admin/providers');
    }

    public function destroyProvider(Request $request)
    {
        $provider = Provider::find($request->id_provider);
        if ($provider->image) {
            unlink('storage/' . $provider->image);
        }
        $provider->delete();

        return "ok";
    }

    public function editProvider(Provider $provider)
    {
        //Mandar las variables para los filtros (*￣3￣)╭
        $type = Category::select('id')->where('name', 'Tipo proveedor')->pluck('id')[0];
        $bank = Category::select('id')->where('name', 'Banco')->pluck('id')[0];

        $types = Variable::where('category_id', $type)->get();
        $banks = Variable::where('category_id', $bank)->get();

        return view('admin.providers.edit', compact('provider', 'types','banks'));
    }

    public function updateProvider(Request $request, Provider $provider)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:255', "unique:providers,name,{$provider->id},id"],
            'type' => ['required'],
            'account' => ['nullable', 'digits:24'],
            'clabe' => ['nullable', 'digits:18'],
            'rfc' => ['nullable', 'digits:12'],
            'reazon' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'cp' => ['nullable', 'digits:5'],
            'contact' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'digits:10'],
            'about' => ['nullable', 'max:255'],
            'image' => ['image']
        ]);

        if ($request->image) {
            if ($provider->image) {
                unlink('storage/' . $provider->image);
            }
            //Guardar la imagen en el servidor
            $path = $request->image->store('providers', 'public');
            $provider->image = $path;
        }

        $provider->name = $request->name;
        $provider->type = $request->type;
        $provider->account = $request->account;
        $provider->clabe = $request->clabe;
        $provider->rfc = $request->rfc;
        $provider->reazon = $request->reazon;
        $provider->country = $request->country;
        $provider->city = $request->city;
        $provider->address = $request->address;
        $provider->cp = $request->cp;
        $provider->contact = $request->contact;
        $provider->email = $request->email;
        $provider->phone = $request->phone;
        $provider->about = $request->about;

        $provider->save();

        return redirect('/admin/providers');
    }

    // handle offices----------------------------------------------------------------------------------------------------------
    public function offices()
    {
        $offices = Office::where('id', '>', '1')->get();
        return view('admin.offices.index', compact('offices'));
    }

    public function createOffice()
    {
        return view('admin.offices.create');
    }

    public function storeOffice(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:255', 'unique:offices'],
            'country' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'cp' => ['required', 'digits:5'],
            'contact' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'digits:10']
        ]);

        Office::create([
            'name' => $request->name,
            'country' => $request->country,
            'city' => $request->city,
            'address' => $request->address,
            'cp' => $request->cp,
            'contact' => $request->contact,
            'email' => $request->email,
            'phone' => $request->phone
        ]);

        return redirect('/admin/offices');
    }

    public function destroyOffice(Request $request)
    {
        $office = Office::find($request->id_sucursal);
        $office->delete();
        return "ok";
    }

    public function editOffice(Office $office)
    {
        return view('admin.offices.edit', compact('office'));
    }

    public function updateOffice(Request $request, Office $office)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:255', "unique:offices,name,{$office->id},id"],
            'country' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'cp' => ['required', 'digits:5'],
            'contact' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'digits:10']
        ]);

        $office->name = $request->name;
        $office->country = $request->country;
        $office->city = $request->city;
        $office->address = $request->address;
        $office->cp = $request->cp;
        $office->contact = $request->contact;
        $office->email = $request->email;
        $office->phone = $request->phone;

        $office->save();

        return redirect('/admin/offices');
    }
}
