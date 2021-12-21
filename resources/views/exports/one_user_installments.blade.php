<table>
    <thead>
    <tr>
        <th>نام</th>
        <th>نام خانوادگی</th>
        <th>کد پرسنلی</th>
        <th>کد حسابداری</th>
        <th>کد ملی</th>
        <th>محل خدمت</th>
        <th>وضعیت</th>
        <th>عنوان وام</th>
        <th>مبلغ قسط</th>
        <th>سال</th>
        <th>ماه</th>
    </tr>
    </thead>
    <tbody>
    @foreach($installments as $installment)
    <tr>
        <td>{{ $user->first_name }}</td>
        <td>{{ $user->last_name}}</td>
        <td>{{ $user->identification_code}}</td>
        <td>{{ $user->accounting_code}}</td>
        <td>{{ $user->national_code}}</td>
        <td>{{ $user->site->title}}</td>
        <td>{{ $user->status}}</td>
        <td>{{ $loan_type->title }} </td>
        <td>{{ $installment->received_amount }} </td>
        <td>{{ $installment->year }} </td>
        <td>{{ $installment->month }} </td>
    </tr>
    @endforeach
</table>