<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
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
     * @param UserRepository $userRepository
     */
    function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware('currentUser', ['only' => ['edit', 'update']]);

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
        $reviews = $user->reviews()->approved()->notSpam()->orderBy('created_at','desc')->paginate(100);
        return View('profiles.show')->with(compact('user','reviews'));
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

        return Redirect()->route('profile.edit', $user->username);
    }


}
