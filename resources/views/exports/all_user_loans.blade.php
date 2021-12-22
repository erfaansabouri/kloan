<table>
    <thead>
    <tr>
        <th>ردیف</th>
        <th>کد پرسنلی</th>
        <th>شناسه حسابداری</th>
        <th>نام</th>
        <th>نام خانوادگی</th>
        <th>وام</th>
        <th>مبلغ کل وام</th>
        <th>تعداد قسط</th>
        <th>مبلغ هر قسط</th>
        <th>تعداد اقساط باقی مانده</th>
        <th>مبلغ باقی مانده از وام</th>
        <th>تاریخ پرداخت وام</th>
        <th>تاریخ وصول اولین قسط</th>
    </tr>
    </thead>
    <tbody>
    @foreach($userLoans as $userLoan)
    <tr>
        <td>{{ $userLoan->id }}</td>
        <td>{{ $userLoan->user->identification_code }}</td>
        <td>{{ $userLoan->user->accounting_code }}</td>
        <td>{{ $userLoan->user->first_name }}</td>
        <td>{{ $userLoan->user->last_name }}</td>
        <td>{{ $userLoan->loan->title }}</td>
        <td>{{ $userLoan->total_amount }}</td>
        <td>{{ $userLoan->installment_count }}</td>
        <td>{{ $userLoan->installment_amount }}</td>
        <td>{{ $userLoan->remained_installment_count }}</td>
        <td>{{ $userLoan->total_remained_installment_amount }}</td>
        <td>{{(new \App\Models\TimeHelper)->georgian2jalali($userLoan->loan_paid_to_user_at) }}</td>
        <td>{{(new \App\Models\TimeHelper)->georgian2jalali($userLoan->first_installment_received_at) }}</td>
    </tr>
    @endforeach
</table>
