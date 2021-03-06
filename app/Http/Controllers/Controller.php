<?php

namespace App\Http\Controllers;

use App\Exports\AllUserBedehiExport;
use App\Exports\AllUserLoans;
use App\Exports\AllUserSavingsExport;
use App\Exports\OneUserLoans;
use App\Exports\twoMonthDiffExport;
use App\Exports\UserKosooratExport;
use App\Exports\UserLoanTypesExport;
use App\Exports\UserSavingsExport;
use App\Imports\SavingImport;
use App\Imports\UserLoanDeleteImport;
use App\Imports\UserLoansImport;
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

    public function userSavingsExport(Request $request)
    {
        $user = User::query()->where('identification_code', $request->identification_code)->firstOrFail();
        return Excel::download(new UserSavingsExport($request->identification_code), $request->identification_code. '_savings.xlsx');
    }

    public function allUserBedehiExport(Request $request)
    {
        return Excel::download(new AllUserBedehiExport(), 'bedehi.xlsx');
    }

    public function allUserSavingsExport(Request $request)
    {
        return Excel::download(new AllUserSavingsExport(), 'all_savings.xlsx');
    }

    public function userKosooratExport(Request $request)
    {
        $request->validate([
            'month' => ['required', 'numeric'],
            'year' => ['required', 'numeric'],
        ]);
        return Excel::download(new UserKosooratExport($request->month, $request->year), 'kosooraat.xlsx');
    }

    public function twoMonthDiffExport(Request $request)
    {
        $request->validate([
            'first_month' => ['required'],
            'first_year' => ['required'],
            'second_month' => ['required'],
            'second_year' => ['required'],
        ]);

        return Excel::download(new twoMonthDiffExport($request->first_month, $request->first_year, $request->second_month, $request->second_year), 'month_diff.xlsx');
    }

    public function importUserLoans(Request $request)
    {
        $request->validate([
            'file' => 'required'
        ]);

        if($request->file()) {
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
            Excel::import(new UserLoansImport(), request()->file('file'));
            return back()
                ->with('success','File has been uploaded.')
                ->with('file', $fileName);
        }
    }

    public function deleteUserLoans(Request $request)
    {
        $request->validate([
            'file' => 'required'
        ]);

        if($request->file()) {
            Excel::import(new UserLoanDeleteImport(), request()->file('file'));
            return back()
                ->with('success','File has been uploaded.');
        }
    }

    public function getUserDetails(Request $request)
    {
        $user = User::query()
            ->where('identification_code', $request->identification_code)
            ->first();

        if(!$user)
        {
            return response()
                ->json([
                    'first_name' => '???? ???????????? ???? ?????????? ???????? ???????? ??????.',
                    'last_name' => '',
                ]);
        }

        return response()
            ->json([
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
            ]);
    }

    public function importSavings(Request $request)
    {
        $request->validate([
            'file' => 'required'
        ]);

        if($request->file()) {
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
            Excel::import(new SavingImport(), request()->file('file'));
            return back()
                ->with('success','File has been uploaded.')
                ->with('file', $fileName);
        }
    }
}
