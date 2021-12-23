<table>
    <thead>
    <tr>
        <th class="">ردیف</th>
        <th class="">کد پرسنلی</th>
        <th class="">شناسه حسابداری</th>
        <th class="">نام</th>
        <th class="">نام خانوادگی</th>
        <th class="">محل خدمت</th>
        <th class="">پس انداز</th>
        @foreach($loanTypes as $loanType)
            <th class="">{{ $loanType->title }}</th>
        @endforeach
        <th class="">جمع</th>
        <th class="">ماه</th>
        <th class="">سال</th>
    </tr>
    </thead>
    <tbody>
    @php $hTotal = 0; $staticHTotal = 0; $sumOfSavingVertical = 0; $dynamicColsSum = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0] @endphp
    @foreach($users as $user)
        <tr class=" ">
            <td class=" ">{{ $user->id }}</td>
            <td class=" ">{{ $user->identification_code }}</td>
            <td class=" ">{{ $user->accounting_code }}</td>
            <td class=" ">{{ $user->first_name }}</td>
            <td class=" ">{{ $user->last_name }}</td>

            <td class=" ">{{ $user->site->title }}</td>
            <td class="">{{ $user->total_saving }} </td>
            @php $sumOfSavingVertical += $user->total_saving; @endphp
            @php $hTotal += $user->total_saving @endphp
            @php $firstCounter = 0; @endphp
            @foreach($loanTypes as $loanType)
                <td class=" ">{{ @($user->total_installments)[$loanType->title] }} </td>
                @php $hTotal += @($user->total_installments)[$loanType->title] @endphp
                @php $dynamicColsSum[$firstCounter++] += @($user->total_installments)[$loanType->title] @endphp
            @endforeach
            <td class="">{{ $hTotal }} </td>
            <td class="">{{ $month }}</td>
            <td class="">{{ $year }}</td>
        </tr>
        @php $staticHTotal += $hTotal; $hTotal = 0; $firstCounter=0; @endphp
    @endforeach
    <tr class="">
        <td class=" ">-</td>
        <td class=" ">-</td>
        <td class=" ">-</td>
        <td class=" ">-</td>
        <td class=" ">-</td>
        <td class=" ">-</td>
        <td class="">{{ $sumOfSavingVertical }} </td>
        @php $counter = 0; @endphp
        @foreach($loanTypes as $loanType)
            <th class="">{{ $dynamicColsSum[$counter++] }} </th>
        @endforeach
        <td class="">{{ $staticHTotal }} </td>
    </tr>
</table>
