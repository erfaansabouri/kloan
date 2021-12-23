<table>
    <thead>
    <tr>
        <th class="column-title">ردیف</th>
        <th class="column-title">نام</th>
        <th class="column-title">نام خانوادگی</th>
        <th class="column-title">کد پرسنلی</th>
        <th class="column-title">محل خدمت</th>
        <th class="column-title">ماه</th>
        <th class="column-title">سال</th>
        <th class="column-title">مبلغ پس انداز ماه</th>
        <th class="column-title">پس انداز کل</th>
    </tr>
    </thead>
    <tbody>
    @php $total=0 @endphp

    @foreach($savings as $saving)

    <tr>
        <td class=" ">{{ $saving->id }}</td>
        <td class=" ">{{ $saving->user->first_name }}</td>
        <td class=" ">{{ $saving->user->last_name }}</td>
        <td class=" ">{{ $saving->user->identification_code }}</td>
        <td class=" ">{{ @$saving->user->site->title }}</td>
        <td class=" ">{{ @$saving->month }}</td>
        <td class=" ">{{ @$saving->year }}</td>
        <td class="">{{ @$saving->amount }} </td>
        @php $total += $saving->amount; @endphp
        <td class="">{{ $total }} </td>
        @php $total=0 @endphp

    </tr>
    @endforeach
</table>
