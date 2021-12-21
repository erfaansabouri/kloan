<?php

namespace App\Http\Controllers;

use App\Exports\OneUserLoans;
use App\Models\User;
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
        return Excel::download(new OneUserLoans($user), $user->id. '_loans.xlsx');
    }
}
