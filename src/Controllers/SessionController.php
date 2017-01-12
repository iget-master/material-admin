<?php namespace IgetMaster\MaterialAdmin\Controllers;

use Illuminate\Routing\Controller as BaseController;

class SessionController extends BaseController
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if (\Request::has('expired')) {
            \Session::put('alert', [
                'type' => 'danger',
                'message' => trans('materialadmin::admin.session_expired')
            ]);
        }

        return \View::make('materialadmin::login');
    }

    /**
     * Check if current session is valid
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function check()
    {
        return response()->json(auth()->check());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        if (\Auth::attempt(\Input::only('email', 'password'))) {
            return \Redirect::intended(route(\Config::get('admin.home_route')))->with('alert', array('type'=>'success', 'message'=>'Seja bem vindo.'));
        }

        return \Redirect::back()->withInput()->with('alert', array('type'=>'danger', 'message'=>'Usuário e/ou senha incorretos.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy()
    {
        \Auth::logout();

        return \Redirect::route('materialadmin.login');
    }
}
