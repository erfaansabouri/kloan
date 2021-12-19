<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserLoan;
use Illuminate\Http\Request;

class UserLoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userLoans = UserLoan::query()
            ->with(['user', 'loan'])
            ->paginate(20);
        return view('management.user_loan.index', compact('userLoans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('management.user_loan.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'identification_code' => ['required', 'exists:users,identification_code'],
            'total_amount' => ['required', 'numeric'],
            'installment_count' => ['required', 'numeric'],
            'first_installment_received_at_day' => ['required', 'numeric'],
            'first_installment_received_at_month' => ['required', 'numeric'],
            'first_installment_received_at_year' => ['required', 'numeric'],
            'loan_paid_to_user_at_day' => ['required', 'numeric'],
            'loan_paid_to_user_at_month' => ['required', 'numeric'],
            'loan_paid_to_user_at_year' => ['required', 'numeric'],
        ]);

        UserLoan::query()
            ->create([
                'user_id' => User::query()->where('identification_code', $request->identification_code)->first()->id,
                'loan_type_id' => 1,
                'total_amount' => $request->total_amount,
                'installment_count' => $request->installment_count,
                'installment_amount' => $request->total_amount/$request->installment_count,
                'first_installment_received_at' => (new \Morilog\Jalali\Jalalian($request->first_installment_received_at_year, $request->first_installment_received_at_month, $request->first_installment_received_at_day, 12, 0, 0))->toCarbon()->toDateTimeString(),
                'loan_paid_to_user_at' => (new \Morilog\Jalali\Jalalian($request->loan_paid_to_user_at_year, $request->loan_paid_to_user_at_month, $request->loan_paid_to_user_at_day, 12, 0, 0))->toCarbon()->toDateTimeString(),
            ]);

        return redirect()->back();
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
