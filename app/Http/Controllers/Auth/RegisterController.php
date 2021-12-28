<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Accommodation;
use App\Group;
use App\Product;
use App\Currency;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/group';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
		$this->redirectTo = route('group');
    }
    
    public function showRegistrationForm()
    {
		$accommodations = Accommodation::all();
		$products = Product::all();
		$def = Currency::def();
		return view ('auth.register', compact('accommodations', 'products', 'def'))->with('login', true);
	}

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'passport' => ['required', 'string', 'max:255'],
            'gender' => ['required'],
            'residence' => ['required', 'string', 'max:255'],
            'organisation' => ['required', 'string', 'max:255'],
            'orgtype' => ['required', 'string', 'max:255'],
            'orgtypeother' => $data['orgtype'] == 'other'? ['required', 'string', 'max:255'] : '',
            'address' => ['required', 'string', 'max:255'],
            'town' => ['required', 'string', 'max:255'],
            'zipcode' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'string', 'max:255'],
            'accommodation' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
		$accommodation = Accommodation::find($data['accommodation']);
		$user = new User;
		$user->fill([
            'name' 		=> $data['name'],
            'lastname'	=> $data['lastname'],
            'nickname'	=> $data['nickname'],
            'passport' 	=> $data['passport'],
            'gender'	=> $data['gender'],
            'residence'	=> $data['residence'],
            'email' 	=> $data['email'],
            'mail_id'	=> bin2hex(random_bytes(8)),
            'password' 	=> Hash::make($data['password']),
        ]);
        $user->role = 'groupadmin';
        $user->accommodation()->associate($accommodation);
        $group = new Group;
		$group->fill([
			'name' 		=> $data['organisation'],
			'website' 	=> $data['website'],
            'org_type'	=> $data['orgtype'] == 'other' ? $data['orgtypeother'] : $data['orgtype'],
            'address'	=> $data['address'],
            'town'		=> $data['town'],
            'state'		=> $data['state'],
            'zipcode'	=> $data['zipcode'],
            'country'	=> $data['country'],
            'telephone'	=> $data['telephone'],  
		]);
		$keys = array_keys($data);
		$ids=[];
		foreach ($keys as $k) {
			if (preg_match("/^product_([0-9]+)$/", $k, $matches) === 1) {
				$ids[] = $matches[1];
			}
		}
		DB::transaction(function() use ($group, $user, $ids) {
			$group->save();
			$group->users()->save($user);
			$user->products()->sync($ids);
		});
        return $user;
    }
}
