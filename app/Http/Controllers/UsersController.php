<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Http\Requests\UserEditPasswordRequest;
use App\Http\Requests\UserEditRequest;
use App\Repositories\UserRepository;
use App\Review;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Laracasts\Flash\Flash;

class UsersController extends Controller
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
        $this->middleware('auth',['only' => ['postReview']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly review to user
     *
     * @param ReviewRequest $request
     * @return Response
     */
    public function postReview($username, ReviewRequest $request)
    {

        $input = array_add($request->all(),'author_id', Auth()->user()->id);

        $user = $this->userRepository->findByUsername($username);
        $review = New Review;
        $review->storeReviewForUser($user->id, $input['author_id'], $input['comment'], $input['rating']);

        return Redirect()->route('profile_reviews', $user->username);

    }
    /**
     * Store a newly review to user
     *
     * @param ReviewRequest $request
     * @return Response
     */
    public function Reviews($username)
    {

        $user = $this->userRepository->findByUsername($username);
        $reviews = $user->reviews()->approved()->notSpam()->orderBy('created_at','desc')->paginate(10);


        return view('profiles.reviews')->with(compact('user','reviews'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param UserEditPasswordRequest $request
     * @return Response
     */
    public function update($id , UserEditPasswordRequest $request)
    {

        $input = $request->only('password', 'password_confirmation');

        $user = $this->userRepository->update($id, $input);

        Flash::message('Contraseña actualizada');

        return  Redirect()->route('profile.edit', $user->username);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
