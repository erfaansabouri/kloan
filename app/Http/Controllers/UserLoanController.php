<?php

namespace App\Http\Controllers;

use App\Models\Installment;
use App\Models\LoanType;
use App\Models\User;
use App\Models\UserLoan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserLoanController extends Controller
{
    public function twoMonthDiff(Request $request)
    {
        $request->validate([
            'first_month' => ['nullable'],
            'first_year' => ['nullable'],
            'second_month' => ['nullable'],
            'second_year' => ['nullable'],
        ]);

        $users = User::query()
            ->whereHas('installments', function ($q) use ($request){
                $q->whereIn('month', [$request->first_month, $request->second_month]);
                $q->whereIn('year', [$request->first_year, $request->second_year]);
            })->get();

        foreach ($users ?? [] as $user)
        {
            $user['total_first_date'] = $user->getTotalInstallmentOfDate($request->first_month, $request->first_year);
            $user['total_second_date'] = $user->getTotalInstallmentOfDate($request->second_month, $request->second_year);
        }

        $firstMonth = $request->first_month;
        $firstYear = $request->first_year;
        $secondMonth = $request->second_month;
        $secondYear = $request->second_year;
        return view('management.user_loan.two_month_diff', compact('users', 'firstMonth', 'firstYear', 'secondMonth', 'secondYear'));

    }

    public function totalReceivedLoans(Request $request)
    {
        if($request->search)
        {
            $users = User::query()
                ->where('status', 1)
                ->where('identification_code', $request->search)
                ->paginate(5)
                ->append([
                    'total_received_loans'
                ]);

            $loanTypes = LoanType::query()
                ->parent()
                ->get();

            return view('management.user_loan.total_received_loans', compact('users', 'loanTypes'));
        }
        $users = User::query()
            ->where('status', 1)
            ->paginate(5)
            ->append([
                'total_received_loans'
            ]);

        $loanTypes = LoanType::query()
            ->parent()
            ->get();


        return view('management.user_loan.total_received_loans', compact('users', 'loanTypes'));

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->search)
        {
            $userLoans = UserLoan::query()
                ->whereHas('user' , function ($q) use ($request){
                    $q->where('identification_code', $request->search);
                })
                ->visible()
                ->with(['user', 'loan'])
                ->paginate(20);
            return view('management.user_loan.index', compact('userLoans'));
        }

        $userLoans = UserLoan::query()
            ->visible()
            ->with(['user', 'loan'])
            ->paginate(20);
        return view('management.user_loan.index', compact('userLoans'));
    }

    public function completedIndex()
    {
        $userLoans = UserLoan::query()
            ->with(['user', 'loan'])
            ->visible()
            ->whereHas('installments')
            ->orderByDesc('user_loan.id')
            ->paginate(20)
            ->append([
                'total_received_installment_amount',
                'total_remained_installment_amount',
            ]);

        return view('management.user_loan.completed_index', compact('userLoans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $loanTypes = LoanType::query()
            ->child()
            ->get();
        return view('management.user_loan.create', compact('loanTypes'));

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
            'loan_type_id' => ['required', 'numeric'],
            'total_amount' => ['required', 'numeric'],
            'installment_count' => ['required', 'numeric', 'min:1'],
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
                'loan_type_id' => $request->loan_type_id,
                'total_amount' => $request->total_amount,
                'installment_count' => $request->installment_count,
                'installment_amount' => round($request->total_amount/$request->installment_count,2),
                'first_installment_received_at' => (new \Morilog\Jalali\Jalalian($request->first_installment_received_at_year, $request->first_installment_received_at_month, $request->first_installment_received_at_day, 12, 0, 0))->toCarbon()->toDateTimeString(),
                'loan_paid_to_user_at' => (new \Morilog\Jalali\Jalalian($request->loan_paid_to_user_at_year, $request->loan_paid_to_user_at_month, $request->loan_paid_to_user_at_day, 12, 0, 0))->toCarbon()->toDateTimeString(),
            ]);

        return redirect()->back()->with('result', 'با موفقیت ایجاد شد!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userLoan = UserLoan::query()
            ->with(['user', 'loan'])
            ->where('id', $id)
            ->firstOrFail()
            ->append([
                'total_received_installment_amount',
                'total_remained_installment_amount',
            ]);

        $installments = Installment::query()
            ->where('user_loan_id', $id)
            ->get();
        return view('management.user_loan.show', compact('userLoan', 'installments'));
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

    public function archive($id)
    {
        $userLoan = UserLoan::query()
            ->where('id', $id)
            ->firstOrFail();

        $userLoan->archive_at = Carbon::now();
        $userLoan->save();
        return redirect()->back()->with('result', 'با موفقیت بایگانی شد!');

    }
}
