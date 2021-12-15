<?php

namespace App\Http\Controllers;

use App\Models\LoanType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LoanTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index()
    {
        $loanTypes = LoanType::query()
            ->withCount([
                'children'
            ])
            ->parent()
            ->paginate(20);

        return view('management.loan_types.index', compact('loanTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     *
     */
    public function create()
    {
        return view('management.loan_types.create');
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
            'title' => ['required', 'unique:loan_types'],
            'code' => ['required', 'unique:loan_types'],
        ]);

        $newLoanType = new LoanType();
        $newLoanType->title = $request->title;
        $newLoanType->code = $request->code;
        $newLoanType->save();

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     */
    public function edit($id)
    {
        $loanType = LoanType::query()->parent()->findOrFail($id);
        return view('management.loan_types.edit', compact('loanType'));
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
            'title' => ['required' , Rule::unique('loan_types')->ignore($id, 'id')],
            'code' => ['required' , Rule::unique('loan_types')->ignore($id, 'id')],
        ]);

        $newLoanType = LoanType::query()->findOrFail($id);
        $newLoanType->title = $request->title;
        $newLoanType->code = $request->code;
        $newLoanType->save();

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
