<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OptionRequest;
use App\Option;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class OptionsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        /*$search = $request->all();
        $search['q'] = (isset($search['q'])) ? trim($search['q']) : '';*/

        $options = Option::paginate(10);

        return View('admin.options.index')->with(compact('options'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View('admin.options.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OptionRequest $request
     * @return Response
     */
    public function store(OptionRequest $request)
    {
        $input = $request->all();

        $option = Option::create($input);

        Flash('Option created');

        return Redirect()->route('options');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $option = Option::findOrFail($id);

        return View('admin.options.edit')->with(compact('option'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param OptionRequest $request
     * @return Response
     */
    public function update($id, OptionRequest $request)
    {
        $input = $request->all();

        $option = Option::findOrFail($id);

        $option->fill($input);
        $option->save();

        Flash('Option updated');

        return Redirect()->route('options');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {

        $option = Option::findOrFail($id);
        $option->delete();

        Flash('Option Deleted');

        return Redirect()->route('options');
    }
}
