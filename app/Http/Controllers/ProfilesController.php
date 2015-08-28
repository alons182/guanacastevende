<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Newsletters\Mandrill\MandrillNewsletter;
use App\Newsletters\NewsletterList;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Laracasts\Flash\Flash;

class ProfilesController extends Controller
{

    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var NewsletterList
     */
    private $newsletterList;
    /**
     * @var MandrillNewsletter
     */
    private $mandrill;

    /**
     * @param UserRepository $userRepository
     * @param NewsletterList $newsletterList
     * @param MandrillNewsletter $mandrill
     */
    function __construct(UserRepository $userRepository, NewsletterList $newsletterList, MandrillNewsletter $mandrill)
    {
        $this->userRepository = $userRepository;
        $this->middleware('auth', ['only' => ['show']]);
        $this->middleware('currentUser', ['only' => ['edit', 'update']]);

        $this->newsletterList = $newsletterList;
        $this->mandrill = $mandrill;
    }


    /**
     * Display the specified resource.
     *
     * @param $username
     * @return Response
     * @internal param int $id
     */
    public function show($username)
    {
        $user = $this->userRepository->findByUsername($username);

        /*try {
        $this->mandrill->send(auth()->user()->email, auth()->user()->profile->first_name);
        } catch (\Mandrill_ValidationError $e) {
            Flash::message($e->getMessage());
        }*/


        return View('profiles.show')->with(compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $username
     * @return Response
     * @internal param int $id
     */
    public function edit($username)
    {

        $user = $this->userRepository->findByUsername($username);
        return View('profiles.edit')->with(compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $username
     * @param ProfileRequest $request
     * @return Response
     * @internal param int $id
     */
    public function update($username, ProfileRequest $request)
    {
        $user = $this->userRepository->findByUsername($username);
        $input = $request->all();
        $user->profile->fill($input)->save();

        Flash::message('Perfil Actualizado!');

        try {
            $this->newsletterList->subscribeTo('Guanacaste Vende',$user->email,$request->get('first_name'),$request->get('last_name'));
        } catch (\Mailchimp_Error $e) {
            Flash::message($e->getMessage());
        }

        return Redirect()->route('profile.show', $user->username);
    }

    /**
     * Display a listing of the resource.
     *
     * @param $username
     * @return Response
     */
    public function Favorites($username)
    {

        $user = $this->userRepository->findByUsername($username);

        return view('profiles.favorites')->with(compact('user'));
    }



}
