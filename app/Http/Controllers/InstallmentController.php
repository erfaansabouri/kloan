<?php

namespace App\Http\Controllers;

use App\Models\Installment;
use App\Models\LoanType;
use App\Models\User;
use App\Models\UserLoan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class InstallmentController extends Controller
{

    public function kosoorat(Request $request)
    {
        $request->validate([
            'month' => ['nullable', 'min:1', 'max:12', 'numeric'],
            'year' => ['nullable','min:1300', 'max:1500', 'numeric'],
            'site_id' => ['nullable','min:1300', 'max:1500', 'numeric'],
        ]);

        $users = User::query()
            ->whereHas('installments', function ($q) use ($request){
                $q->where('month', $request->month)->where('year', $request->year);
            })->orWhereHas('savings', function ($q2) use ($request){
                $q2->where('month', $request->month)->where('year', $request->year);
            })->get();

        foreach ($users as $user)
        {
            $user['total_saving'] = $user->getTotalSavingsDate($request->month, $request->year);
            $user['total_installments'] = $user->getTotalPaidInstallmentsByGroup($request->month, $request->year);
        }

        $loanTypes = LoanType::query()
            ->parent()
            ->get();

        $month = $request->month;
        $year = $request->year;
        return view('management.installments.kosoorat', compact('users', 'loanTypes', 'month', 'year'));
    }

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

        $date = (new Jalalian($request->year, $request->month, 30, 00, 00, 0))->toCarbon()->toDateTimeString();
        $date = Carbon::parse($date);

        $activeUsers = User::query()
            ->where('status', 1)
            ->get();

        $totalReceived = 0;

        foreach ($activeUsers as $activeUser)
        {
            // check if has active loan
            $userLoans = UserLoan::query()
                ->where('user_id', $activeUser->id)
                ->where('first_installment_received_at', '<=' , Carbon::now()->endOfMonth())
                ->get();
            foreach ($userLoans as $userLoan)
            {
                if(!$userLoan->isReceivedCompletely() && !$userLoan->isInstallmentReceivedForMonthYear($request->month, $request->year))
                {
                    Installment::query()
                        ->create([
                            'user_id' => $userLoan->user_id,
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
        return redirect()->back()->with('result', "تعداد  $totalReceived قسط از پرسنل کسر شد.");



    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'month' => ['nullable'],
            'year' => ['nullable'],
            'site_id' => ['nullable']
        ]);


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
        Installment::query()
            ->findOrFail($id)->delete();
        return redirect()->back()->with('result', "قسط حذف شد.");

    }
}
