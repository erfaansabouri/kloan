<?php

namespace App\Http\Controllers;

use App\Exports\AllUserLoans;
use App\Exports\OneUserLoans;
use App\Exports\UserLoanTypesExport;
use App\Models\User;
use App\Models\UserLoan;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Maatwebsite\Excel\Facades\Excel;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function userLoanExport(Request $request)
    {
        $user = User::query()->where('identification_code', $request->identification_code)->firstOrFail();
        return Excel::download(new OneUserLoans($user), $request->identification_code. '_loans_and_installments.xlsx');
    }

    public function allUserLoansExport(Request $request)
    {
        return Excel::download(new AllUserLoans(),'all_loans.xlsx');
    }

    public function userLoanTypesExport(Request $request)
    {
        $user = User::query()->where('identification_code', $request->identification_code)->firstOrFail();
        return Excel::download(new UserLoanTypesExport($request->identification_code), $request->identification_code. '_loanTypes.xlsx');

    }
}
