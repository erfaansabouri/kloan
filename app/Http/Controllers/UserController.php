<?php

namespace App\Http\Controllers;

use App\Models\Installment;
use App\Models\Saving;
use App\Models\Site;
use App\Models\User;
use App\Models\UserLoan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Morilog\Jalali\Jalalian;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        $users = User::query()
            ->with(['site'])
            ->orderByDesc('id');
        if (!empty($request->search))
        {
            $text = $request->search;
            $users->where(function($query) use ($text){

                $query->orwhere('first_name', 'LIKE', "%{$text}%");
                $query->orwhere('last_name', 'LIKE', "%{$text}%");
                $query->orwhere('id', 'LIKE', "%{$text}%");
                $query->orwhere('identification_code', 'LIKE', "%{$text}%");
                $query->orwhere('accounting_code', 'LIKE', "%{$text}%");
            });
        }

        $users = $users->paginate(20);
        return view('management.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     *
     */
    public function create()
    {
        $sites = Site::query()->get();
        return view('management.users.create', compact('sites'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function store(Request $request)
    {
        $request->validate([
            'identification_code' => ['unique:users'],
            'accounting_code' => ['unique:users'],
            'status' => ['required'],
            'site_id' => ['required'],
        ]);
        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->identification_code = $request->identification_code;
        $user->accounting_code = $request->accounting_code;
        $user->status = $request->status;
        $user->site_id = $request->site_id;
        $user->save();

        return redirect()->back()->with('result', 'پرسنل با موفقیت ایجاد شد!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     */
    public function show($id)
    {
        $user = User::query()
            ->with(['site'])
            ->findOrFail($id);
        $date = Jalalian::forge('today')->format('%A, %d %B %Y');

        return view('management.users.show', compact('user', 'date'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     */
    public function edit($id)
    {
        $user = User::query()
            ->with(['site'])
            ->findOrFail($id);
        $sites = Site::query()->get();
        return view('management.users.edit', compact('user', 'sites'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'identification_code' => ['required' , Rule::unique('users')->ignore($id, 'id')],
            'accounting_code' => ['required' , Rule::unique('users')->ignore($id, 'id')],
            'status' => ['required'],
            'site_id' => ['required'],
        ]);
        $user = User::query()->findOrFail($id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->identification_code = $request->identification_code;
        $user->accounting_code = $request->accounting_code;
        $user->status = $request->status;
        $user->site_id = $request->site_id;
        $user->save();

        return redirect()->back()->with('result', 'پرسنل با موفقیت ویرایش شد!');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::query()->findOrFail($id);

        UserLoan::query()
            ->where('user_id', $user->id)
            ->delete();

        Installment::query()
            ->where('user_id', $user->id)
            ->delete();

        Saving::query()
            ->where('user_id', $user->id)
            ->delete();

        $user->delete();

        return redirect()->back()->with('result', 'پرسنل با موفقیت حذف شد!');

    }
}
