<table>
    <thead>
    <tr>
        <th class="column-title">ردیف</th>
        <th class="column-title">نام</th>
        <th class="column-title">نام خانوادگی</th>
        <th class="column-title">کد پرسنلی</th>
        <th class="column-title">کد حساب داری</th>
        @foreach($loanTypes as $loanType)
            <th class="column-title">{{ $loanType->title }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>

    @foreach($users as $user)

    <tr>
        <td class=" ">{{ $user->id }}</td>
        <td class=" ">{{ $user->first_name }}</td>
        <td class=" ">{{ $user->last_name }}</td>
        <td class=" ">{{ $user->identification_code }}</td>
        <td class=" ">{{ $user->accounting_code }}</td>
        @foreach($loanTypes as $loanType)
            <th class="column-title">{{ $user->getBedehiOfLoanTypeId($loanType->id) }}</th>
        @endforeach
    </tr>
    @endforeach
</table>
