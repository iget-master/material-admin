<?php namespace IgetMaster\MaterialAdmin\Controllers;

use Illuminate\Routing\Controller as BaseController;

class SessionController extends BaseController
{
    /**
     * Show the form for creating a new resource.
     */
    public function login()
    {
        return redirect(env('WEBAPP_URL') . '/login?legacy=true');
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
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy()
    {
        \Auth::logout();

        return redirect(env('WEBAPP_URL') . '/logout');
    }
}
