<?php

use App;
use Config;
use Input;
use Lang;
use Mail;
use Response;
use Redirect;
use Session;
use View;
use URL;

use Demo;
use Isr;
use User;
use UserDemoAccess;

class UsersController extends Controller
{

    /**
     * Display a listing of the users.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::orderBy('company', 'asc')
                     ->orderBy('email', 'asc')
                     ->paginate(20);

        return View::make("users.index")->with(array("users"=>$users));
    }

    /**
     * Displays the form for account creation
     *
     * @return  Illuminate\Http\Response
     */
    public function create()
    {
        //return View::make(Config::get('confide::signup_form'));
        $user = new User();
        $isrs = Isr::isrList();
        $demos = Demo::orderBy('language', 'asc')
                     ->orderBy('enterprise_version', 'desc')
                     ->orderBy('title', 'asc')->get();
        $user_demo_access = array();

        return View::make('users.form')->with([
            'title'             => 'Add a New User',
            'action'            => 'users.store',
            'demos'             => $demos,
            'isrs'              => $isrs,
            'user'              => $user,
            'user_demo_access'  => $user_demo_access,
            'method'            => 'post'
        ]);
    }

    /**
     * Store a newly created user in storage.
     *
     * @return Response
     */
    public function store()
    {
        $user               = new User();

        $user->email             = Input::get('email');
        $user->company           = Input::get('company');
        $user->expires           = Input::get('expires');
        $user->isr_contact_id    = Input::get('isr_contact_id');
        $user->confirmation_code = md5(uniqid(mt_rand(), true));
        $password                = $user->autoGeneratePassword();

        if ($user->save()) {
            $user->confirm();
            if ($user_demo_access = UserDemoAccess::updateUserDemoAccess($user->id, Input::get('demo-access'))) {
                // return Redirect::action('users.show', $user->id)
                return Redirect::action('users.index')
                      ->with('message', "The user {$user->email} was successfully created.<br />Their password is: ".$password."<br />Their expiration date is: {$user->expires}");
            } else {
                $error = $user_demo_access->errors()->all(':message');

                return Redirect::route('users.create')
                    ->withInput(Input::except('password'))
                    ->withError('There was a problem with your submission. The demo access selections did not save.')
                    ->withErrors($user_demo_access->errors());
            }

        } else {
            $error = $user->errors()->all(':message');

            return Redirect::route('users.create')
                ->withInput(Input::except('password'))
                ->withError('There was a problem with your submission. See below for more information.')
                ->withErrors($user->errors());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    //public function show($user)
    {
        $user = User::findOrFail($id);
        $isrs = Isr::isrList();
        $demos = Demo::orderBy('language', 'asc')
                     ->orderBy('enterprise_version', 'desc')
                     ->orderBy('title', 'asc')->get();
        $user_demo_access = UserDemoAccess::accessList($id);

        return View::make('users.form')->with([
            'title'             => "Update User: {$user->email}",
            'action'            => ['users.update', $user->id],
            'isrs'              => $isrs,
            'demos'             => $demos,
            'user'              => $user,
            'user_demo_access'  => $user_demo_access,
            'method'            => 'put'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $user = User::findOrFail($id);
        if (Input::get('password')) {
            if (Input::get('password') === Input::get('password_confirmation')) {
                $user->password = Input::get('password');
                $user->password_confirmation = Input::get('password_confirmation');
            } else {
                return Redirect::route('users.show', $user->id)
                      ->withInput(Input::except('password'))
                      ->withError('There was a problem with your submission. The passwords did not match.')
                      ->withErrors($user->errors());
            }
        }
        $user->company        = Input::get('company');
        $user->expires        = Input::get('expires');
        $user->isr_contact_id = Input::get('isr_contact_id');

        if ($user->save()) {
            $demo_selections = Input::get('demo-access');
            if ($user_demo_access = UserDemoAccess::updateUserDemoAccess($user->id, $demo_selections)) {
                // return Redirect::to(URL::route('users.index'))
                return Redirect::action('users.show', $user->id)
                      ->with('message', "The user {$user->email} was successfully updated.");
            } else {
                return Redirect::route('users.show', $user->id)
                    ->withInput(Input::except('password'))
                    ->withError('There was a problem with your submission. The demo access selections did not save.');
            }

        } else {
            return Redirect::route('users.show', $user->id)
                ->withInput(Input::except('password'))
                ->withError('There was a problem with your submission. See below for more information.')
                ->withErrors($user->errors());
        }
    }

    /**
     * Displays the login form
     *
     * @return  Illuminate\Http\Response
     */
    public function login()
    {
        if (Confide::user()) {
            return Redirect::to('/');
        } else {
            return View::make(Config::get('confide::login_form'));
        }
    }

    /**
     * Attempt to do login
     *
     * @return  Illuminate\Http\Response
     */
    public function doLogin()
    {
        $repo = App::make('UserRepository');
        $input = Input::all();

        if ($repo->login($input)) {
            return Redirect::intended('/');
        } else {
            if ($repo->isThrottled($input)) {
                $err_msg = Lang::get('confide::confide.alerts.too_many_attempts');
            } elseif ($repo->existsButNotConfirmed($input)) {
                $err_msg = Lang::get('confide::confide.alerts.not_confirmed');
            } else {
                $err_msg = Lang::get('confide::confide.alerts.wrong_credentials');
            }

            return Redirect::action('UsersController@login')
                ->withInput(Input::except('password'))
                ->with('error', $err_msg);
        }
    }

    /**
     * Attempt to confirm account with code
     *
     * @param  string $code
     *
     * @return  Illuminate\Http\Response
     */
    public function confirm($code)
    {
        if (Confide::confirm($code)) {
            $notice_msg = Lang::get('confide::confide.alerts.confirmation');
            return Redirect::action('UsersController@login')
                ->with('notice', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_confirmation');
            return Redirect::action('UsersController@login')
                ->with('error', $error_msg);
        }
    }

    /**
     * Displays the forgot password form
     *
     * @return  Illuminate\Http\Response
     */
    public function forgotPassword()
    {
        return View::make(Config::get('confide::forgot_password_form'));
    }

    /**
     * Attempt to send change password link to the given email
     *
     * @return  Illuminate\Http\Response
     */
    public function doForgotPassword()
    {
        if (Confide::forgotPassword(Input::get('email'))) {
            $notice_msg = Lang::get('confide::confide.alerts.password_forgot');
            return Redirect::action('UsersController@login')
                ->with('notice', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_forgot');
            return Redirect::action('UsersController@doForgotPassword')
                ->withInput()
                ->with('error', $error_msg);
        }
    }

    /**
     * Shows the change password form with the given token
     *
     * @param  string $token
     *
     * @return  Illuminate\Http\Response
     */
    public function resetPassword($token)
    {
        return View::make(Config::get('confide::reset_password_form'))
                ->with('token', $token);
    }

    /**
     * Attempt change password of the user
     *
     * @return  Illuminate\Http\Response
     */
    public function doResetPassword()
    {
        $repo = App::make('UserRepository');
        $input = array(
            'token'                 =>Input::get('token'),
            'password'              =>Input::get('password'),
            'password_confirmation' =>Input::get('password_confirmation'),
        );

        // By passing an array with the token, password and confirmation
        if ($repo->resetPassword($input)) {
            $notice_msg = Lang::get('confide::confide.alerts.password_reset');
            return Redirect::action('UsersController@login')
                ->with('notice', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_reset');
            return Redirect::action('UsersController@resetPassword', array('token'=>$input['token']))
                ->withInput()
                ->with('error', $error_msg);
        }
    }

    /**
     * Log the user out of the application.
     *
     * @return  Illuminate\Http\Response
     */
    public function logout()
    {
        Confide::logout();

        return Redirect::to('/');
    }
}
