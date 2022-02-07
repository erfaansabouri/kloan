<?php

namespace App\Http\Controllers;

use App\Models\Saving;
use App\Models\SavingImportLog;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserLoanImportLog;
use Illuminate\Http\Request;

class SavingController extends Controller
{
    public function importStatus()
    {
        $logs = SavingImportLog::query()
            ->get();

        return view('management.user_loan.import_status', compact('logs'));
    }
    public function user(Request $request)
    {
        $request->validate([
            'search' => ['nullable'],
        ]);
        if(!$request->search)
        {
            $savings = [];
            return view('management.savings.user', compact('savings'));

        }
        $savings = Saving::query()
            ->whereHas('user', function ($q) use ($request){
                $q->where('identification_code', $request->search);
            })
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        return view('management.savings.user', compact('savings'));
    }

    public function receiveFromAllUsersCreate()
    {
        $amount = Setting::getMonthlySavingAmount();
        return view('management.savings.receive_from_all_users', compact('amount'));
    }

    public function receiveFromAllUsersStore(Request $request)
    {
        $request->validate([
            'amount' => ['required'],
            'month' => ['required', 'numeric', 'min:1', 'max:12'],
            'year' => ['required', 'numeric', 'min:1300', 'max:1500'],
        ]);

        $activeUsers = User::query()
            ->where('status', '=', 1)
            ->get();

        $count = 0;

        foreach ($activeUsers as $activeUser)
        {

            if(!$activeUser->hasPaidSaving($request->month, $request->year))
            {
                Saving::query()
                    ->create([
                        'user_id' => $activeUser->id,
                        'amount' => $request->amount,
                        'month' => $request->month,
                        'year' => $request->year,
                    ]);
                $count++;
            }
        }
        return redirect()->back()->with('result', "برای $count نفر پس انداز ماهیانه ایجاد شد.");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $saving = Saving::query()->findOrFail($id);
        return view('management.savings.edit', compact('saving'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $saving = Saving::query()->findOrFail($id);
        $request->validate([
            'amount' => ['required', 'numeric'],
        ]);
        $saving->amount = $request->amount;
        $saving->save();
        return redirect()->back()->with('result', 'با موفقیت ویرایش شد!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
