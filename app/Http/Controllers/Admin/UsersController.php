<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\UserEditRequest;
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;


class UsersController extends Controller {

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
    }


    /**
     * Display a listing of users
     *
     * @param Request $request
     * @return Response
     */
	public function index(Request $request)
	{
        $search = $request->all();
       // dd($search);
        if (! count($search) > 0 || ! isset($search['q']) )
        {
            $search['q'] = "";
        }
        $search['active'] = (isset($search['active'])) ? $search['active'] : '';
        $search['dir'] = (isset($search['dir'])) ? $search['dir'] : '';
        $search['order'] = (isset($search['order'])) ? $search['order'] : '';


        $users = $this->userRepository->findAll($search);
        //dd($search['dir']);
        return View('admin.users.index')->with([
            'users'          => $users,
            'search'         => $search['q'],
            'selectedStatus' => $search['active'],
            'order' => $search['order'],
            'dir' => ($search['dir'] == '') ? '' : (($search['dir'] == 'desc') ? 'asc' : 'desc')

        ]);
	}

	/**
	 * Show the form for creating a new user.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View('admin.users.create');
	}

    /**
     * Store a newly created user in storage.
     *
     * @param UserRequest $request
     * @return Response
     */
	public function store(UserRequest $request)
	{
        $input = $request->only('username', 'email', 'password', 'password_confirmation');

        $this->userRepository->store($input);

        Flash::message('User created');

        return Redirect()->route('users');
	}

	/**
	 * Show the form for editing the specified user.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $user = $this->userRepository->findById($id);

        return View('admin.users.edit')->with(compact('user'));
	}

    /**
     * Update the specified user in storage.
     *
     * @param  int $id
     * @param UserEditRequest $request
     * @return Response
     */
	public function update($id, UserEditRequest $request)
	{
        $input = $request->only('username', 'email', 'password', 'password_confirmation');

        $this->userRepository->update($id, $input);

        Flash::message('User updated');

        return Redirect()->route('users');
	}

    /**
     * Active a user.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function active($id)
    {
        $this->userRepository->update_active($id, 1);

        return Redirect()->route('users');
    }

    /**
     * Inactive a user.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function inactive($id)
    {
        $this->userRepository->update_active($id, 0);

        return Redirect()->route('users');
    }

    /**
     * Remove the specified user from storage.
     * DELETE /users/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->userRepository->destroy($id);

        Flash::message('User Deleted');

        return Redirect()->route('users');
    }

    /**
     * List of user for the modal view in products sections
     * @param Request $request
     * @return mixed
     */
    public function list_users(Request $request)
    {
        return $this->userRepository->list_users($request->input('exc_id'), $request->input('key'));
    }

}
