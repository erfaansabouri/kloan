<table>
    <thead>
    <tr>
        <th>کد پرسنلی</th>
        <th>شناسه حسابداری</th>
        <th>نام</th>
        <th>نام خانوادگی</th>
        <th>محل خدمت</th>
        <th>وضعیت</th>
        <th>عنوان وام</th>
        <th>مبلغ قسط</th>
        <th>ماه</th>
        <th>سال</th>
    </tr>
    </thead>
    <tbody>
    @foreach($installments as $installment)
    <tr>
        <td>{{ $user->identification_code}}</td>
        <td>{{ $user->accounting_code}}</td>
        <td>{{ $user->first_name }}</td>
        <td>{{ $user->last_name}}</td>
        <td>{{ $user->site->title}}</td>
        <td>{{ $user->status == 1 ? "فعال" : "غیر فعال"}}</td>
        <td>{{ $loan_type->title }} </td>
        <td>{{ $installment->received_amount }} </td>
        <td>{{ $installment->month }} </td>
        <td>{{ $installment->year }} </td>
    </tr>
    @endforeach
</table>