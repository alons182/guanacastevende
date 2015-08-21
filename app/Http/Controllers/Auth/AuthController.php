<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\UserRequest;
use App\Newsletters\NewsletterList;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var NewsletterList
     */
    private $newsletterList;

    /**
     * Create a new authentication controller instance.
     *
     * @param UserRepository $userRepository
     * @param NewsletterList $newsletterList
     */
    public function __construct(UserRepository $userRepository, NewsletterList $newsletterList)
    {
        $this->middleware('guest', ['except' => 'getLogout']);
        $this->userRepository = $userRepository;
        $this->newsletterList = $newsletterList;
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
            'username' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email', 'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $credentials = array_add($credentials, 'active', '1');

        if (Auth::attempt($credentials, $request->has('remember')))
        {
            if (Auth::user()->hasRole('administrator'))
                return redirect()->intended('/admin');

            return redirect()->intended('/');
        }

        return redirect($this->loginPath())
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => $this->getFailedLoginMessage(),
            ]);
    }

    public function postRegister(UserRequest $request)
    {

        $user = $this->userRepository->store($request->all());


        Auth::login($user);
        Flash::message('Cuenta Creada correctamente. se te ha enviado un correo con la información de usuario. Completa tu perfil por favor, es importante !');

        try {
            $this->newsletterList->subscribeTo('Guanacaste Vende',$request->get('email'),$request->get('username'),'');
        } catch (\Mailchimp_Error $e) {
            Flash::message($e->getMessage());
        }



        return redirect()->route('profile.edit',$user->username);
    }

}
