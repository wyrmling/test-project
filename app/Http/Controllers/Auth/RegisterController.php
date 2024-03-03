<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUser;
use App\Models\PhoneBook;
use App\Models\User;
use App\Models\UserCountries;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class RegisterController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return view('register');
    }

    /**
     * @param \App\Http\Requests\RegisterUser $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(RegisterUser $request)
    {
        $user = $this->create($request->all());

        event(new Registered($user));

        return new JsonResponse([], 201);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = null;
        DB::transaction(function () use ($data, &$user) {
            $user = User::create([
                'name' => $data['fullName'],
                'email' => $data['email'],
                // TODO:
                'password' => Hash::make(Str::random(10)),
            ]);

            UserCountries::create([
                'user_id' => $user->id,
                'country_name' => $data['countryName'],
                'country_code' => $data['countryId'],
            ]);

            PhoneBook::create([
                'user_id' => $user->id,
                'type' => PhoneBook::TYPE_MAIN,
                'phone' => $data['phoneNumber'],
            ]);
        });

        return $user;
    }
}
