<table>
    <thead>
    <tr>
        <th class="column-title">ردیف</th>
        <th class="column-title">نام</th>
        <th class="column-title">نام خانوادگی</th>
        <th class="column-title">کد پرسنلی</th>
        <th class="column-title">شناسه حسابداری</th>
        @foreach($loanTypes as $loanType)
            <th class="column-title">{{ $loanType->title }}</th>
        @endforeach
        <th class="column-title">مجموع</th>
    </tr>

    </thead>
    <tbody>
    <tr class="even pointer ">
        <td class=" ">{{ $user->id }}</td>
        <td class=" ">{{ $user->first_name }}</td>
        <td class=" ">{{ $user->last_name }}</td>
        <td class=" ">{{ $user->identification_code }}</td>
        <td class=" ">{{ $user->accounting_code }}</td>
        @php $horizontalTotal = 0; @endphp
        @foreach($loanTypes as $loanType)
            @php $horizontalTotal += ($user->total_received_loans)[$loanType->title] @endphp
            <td class="comma_numbers">{{ ($user->total_received_loans)[$loanType->title] }} </td>
        @endforeach
        <td class="comma_numbers">{{ $horizontalTotal }}</td>
        @php $horizontalTotal = 0; @endphp
    </tr>
</table>
