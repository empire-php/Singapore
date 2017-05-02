@if ($today)
    <tr class="added_tr">
        <td><?php echo htmlspecialchars_decode($today->body_received_at)?></td>
        <td>{{$today->deceased_name}}</td>
        <td>{{$today->hospital}}</td>
        <td>{{ ($today->shiftedByUser)?$today->shiftedByUser->name:"-"}}</td>
        <td>{{$today->clothing}}</td>
        <td>{{$today->photo}}</td>
        <td>{{$today->coffin_model}}</td>
        <td>{{$today->items_in_coffin}}</td>
        <td>{{$today->embalming_start_at}}</td>
        <td>{{$today->embalming_end_at}}</td>
        <td>{{$today->dressing}}</td>
        <td>{{$today->makeup}}</td>
        <td><?php echo $today->body_sent_at?></td>
        <td>{{$today->status}}</td>
    </tr>
@else
    @foreach($logs as $line)
    <tr class="search_added_tr">
        <td><?php echo $line->body_received_at?></td>
        <td>{{$line->deceased_name}}</td>
        <td>{{$line->hospital}}</td>
        <td>{{$line->shiftedByUser->name}}</td>
        <td>{{$line->clothing}}</td>
        <td>{{$line->photo}}</td>
        <td>{{$line->coffin_model}}</td>
        <td>{{$line->items_in_coffin}}</td>
        <td>{{$line->embalming_start_at}}</td>
        <td>{{$line->embalming_end_at}}</td>
        <td>{{$line->dressing}}</td>
        <td>{{$line->makeup}}</td>
        <td><?php echo $line->body_sent_at?></td>
        <td>{{$line->status}}</td>
    </tr>
    @endforeach
@endif