<table>
    <thead>
    <tr>
        <th class="">ردیف</th>
        <th class="">نام</th>
        <th class="">نام خانوادگی</th>
        <th class="">کد پرسنلی</th>
        <th class="">شناسه حسابداری</th>
        <th class="">مبلغ ماه ({{ $firstMonth }} {{ $firstYear }})</th>
        <th class="">مبلغ ماه ({{ $secondMonth }} {{ $secondYear }})</th>
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
        <td class=" ">{{ $user->total_first_date }} </td>
        <td class=" ">{{ $user->total_second_date }} </td>
    </tr>
    @endforeach
</table>
