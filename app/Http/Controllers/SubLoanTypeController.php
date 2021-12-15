<?php

namespace App\Http\Controllers;

use App\Models\LoanType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubLoanTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index()
    {
        $loanTypes = LoanType::query()
            ->with([
                'parent'
            ])
            ->child()
            ->paginate(20);

        return view('management.sub_loan_types.index', compact('loanTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     *
     */
    public function create()
    {
        $parents = LoanType::query()
            ->withCount([
                'children'
            ])
            ->parent()
            ->get();
        return view('management.sub_loan_types.create', compact('parents'));
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
            'parent_id' => ['required'],
        ]);

        $newLoanType = new LoanType();
        $newLoanType->parent_id = $request->parent_id;
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
        $parents = LoanType::query()
            ->withCount([
                'children'
            ])
            ->parent()
            ->get();
        $loanType = LoanType::query()->child()->findOrFail($id);
        return view('management.sub_loan_types.edit', compact('loanType', 'parents'));
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
            'parent_id' => ['required'],
        ]);

        $newLoanType = LoanType::query()->findOrFail($id);
        $newLoanType->parent_id = $request->parent_id;
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
