<div class="parlour_form">
    <div class="section">   
        <!--<div class="section_title"> selection</div>-->
            <div>
              <!--  <div class="capacity_filter_text">Capacity:</div> 
                <input class="form-control capacity_filter_input" type="text" id="capacity_filter" />
                <div style="clear:both; height:30px"></div>
              -->
                <?php $i = 0;?>

                @foreach($items as $key => $item)
                <div id="columbarium_item_{{$item['id']}}" onclick="selectImagesInsteadItem2select(this)" class="item2select 
                        @if (isset($order))
                        @if ($order->parlour_name == $item['name'])
                        selected_item
                        @endif
                        @endif
                        <?php echo (!isset($is_popup))?'':'popup_view'?>" >

                        <table style="width:100%">
                            <tr>
                                <td class="img_container">
                                    @if (!empty($item["image"]))
                                    <?php $path = explode("|", $item['image']); ?>
                                    <img src="/uploads/{{$path[0]}}" />
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="item_text">
                                    <span class="columbarium_name_container">{{(isset($item['selection_item_name']))?$item['selection_item_name']:''}}</span>
                                 <!--   <br <?php //echo (!isset($is_popup))?'':'style="line-height:5px"'?> />
                                    Capacity: <span class="parlour_capacity_container">{{(isset($item['capacity']))?$item['capacity']:''}}</span>
                                 -->
                                    <br <?php echo (!isset($is_popup))?'':'style="line-height:5px"'?> />
                                    Unit price: $<span class="unit_price">{{(isset($item['unit_price']))?$item['unit_price']:''}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="ala_carte_item_btn">SELECT</td>
                            </tr>
                        </table>
                    </div>
               <?php if (isset($is_popup) && $i++ % 4 == 3):?>
                <div style="clear:both"></div>
                <?php endif;?>
                @endforeach
                <div style="clear:both"></div>
            </div>
    </div>



</div>