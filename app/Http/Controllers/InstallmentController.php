<?php

namespace App\Http\Controllers;

use App\Models\Installment;
use App\Models\User;
use App\Models\UserLoan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InstallmentController extends Controller
{

    public function receiveInstallmentsOfAllUsersCreate(Request $request)
    {
        return view('management.installments.receive_from_all_users');
    }

    public function receiveInstallmentsOfAllUsersStore(Request $request)
    {
        $request->validate([
            'month' => ['required', 'min:1', 'max:12', 'numeric'],
            'year' => ['required','min:1300', 'max:1500', 'numeric']
        ]);

        $activeUsers = User::query()
            ->where('status', 1)
            ->get();

        $totalReceived = 0;

        foreach ($activeUsers as $activeUser)
        {
            // check if has active loan
            $userLoans = UserLoan::query()
                ->where('user_id', $activeUser->id)
                ->get();
            foreach ($userLoans as $userLoan)
            {
                //dd($userLoan->isReceivedCompletely());
                if(!$userLoan->isReceivedCompletely() && !$userLoan->isInstallmentReceivedForMonthYear($request->month, $request->year))
                {
                    Installment::query()
                        ->create([
                            'user_loan_id' => $userLoan->id,
                            'received_amount' => $userLoan->installment_amount,
                            'received_at' => Carbon::now(),
                            'month' => $request->month,
                            'year' => $request->year,
                        ]);

                    $totalReceived++;
                }
            }
        }
        return redirect()->back()->with('result', "tedad $totalReceived ghest az karbar ha kam shod");



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
        //
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
        //
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
