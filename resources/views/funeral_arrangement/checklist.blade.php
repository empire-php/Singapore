<form id="checklist_frm" <?php echo (isset($is_repatriation_form))?'action="/FArepatriation/autosave_checklist"':''?>>
    {!! csrf_field() !!}

    <input type="hidden" name="generated_code" value="{{ $object->generated_code }}" />
    <?php if (isset($is_repatriation_form)):?>
    <input type="hidden" name="id" id="id" value="{{ $object->id }}" />
    <?php else:?>
    <input type="hidden" name="faid" id="faid" value="{{ $object->id }}" />
    <?php endif;?>
    
<table id="checklist" border="1">
    <thead>
    <th colspan="2">CHECKLIST</th>
    </thead>
    <tbody>
        @foreach( $checlist_items as $item )
        <tr>
            @if ($item->position < $last_item_position - 1 )
            <td rowspan="2" class="check_td">
                <img class="check_act" src="{{ URL::to('/') }}/images/markers/check_mark_blue.png" />
                <input type="checkbox" name="active_item_{{ $item->id }}" id="active_item_{{ $item->id }}"
                @if (isset($saved_checklist[$item->id]["active_item"]))   
                checked="true"
                @endif
                />
            </td>
            
            <td class="item_name">
            @else
            <td rowspan="2"></td>
            <td>
            @endif
                {{ $item->name }}
            </td>
        </tr>
        <tr><td class="remarks_td">Remarks: 
                @if ($item->position < $last_item_position - 1 )
                <input type="text" name="remarks_{{ $item->id }}" value="{{ (isset($saved_checklist[$item->id]["remarks"]))?$saved_checklist[$item->id]["remarks"]:''}}" />
                @else
                <textarea cols="2" name="remarks_{{ $item->id }}">{{(isset($saved_checklist[$item->id]["remarks"]))?$saved_checklist[$item->id]["remarks"]:''}}</textarea>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</form>
<script type="text/javascript">
    

</script>