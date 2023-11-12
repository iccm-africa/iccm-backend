<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Accommodation;
use App\Models\Currency;
use App\Models\Product;
use App\Services\GroupRegistrationService;
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
    public function __construct(protected GroupRegistrationService $registration)
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
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return \App\Models\User
     * @throws \Exception
     */
    protected function create(array $data)
    {
		$accommodation = Accommodation::find($data['accommodation']);
        $user = $this->registration->registerGroup($data, 'groupadmin');
        return $user;
    }
}
