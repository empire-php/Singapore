<?php
    if(!isset($section)) {
        exit();
    }
?>
<?php $rows = App\NicheRow::where('niche_section_id', $section->id)->count(); $rowspan = $rows + 1;?>
<?php $leftColumns = App\NicheColumn::where('niche_section_id', $section->id)->where('side', 'left')->count(); ?>
<?php $rightColumns = App\NicheColumn::where('niche_section_id', $section->id)->where('side', 'right')->count(); ?>
<?php $columns = $leftColumns + $rightColumns; ?>

@if($rows > 0)
    <table class="table table-bordered suite-table" id="suiteTable" style="width: 100%;">
        <tr>
            <td></td>
            @if($leftColumns > 0)
                <?php $left_columns = App\NicheColumn::where('niche_section_id', $section->id)->where('side', 'left')->orderby('sort_order')->get(); ?>
                @foreach($left_columns as $left_column)
                    <td side="left">{{ $left_column->name }}</td>
                @endforeach
            @else
                <td side="left" style="display: none;"></td>
            @endif

            <?php if($rows == 0) $rowspan = 2; else $rowspan=$rowspan+1; ?>
            <td align="center" class="border-td" rowspan="{{$rowspan}}" style="width: 30px;vertical-align:middle;" id="entrance">Entrance</td>

            @if($rightColumns > 0)
                <?php $right_columns = App\NicheColumn::where('niche_section_id', $section->id)->where('side', 'right')->orderby('sort_order','desc')->get(); ?>
                @foreach($right_columns as $right_column)
                    <td side="right">{{ $right_column->name }}</td>
                @endforeach
            @else
                <td side="right" style="display:none;"></td>
            @endif
            <td></td>
        </tr>

        <?php $rrows = App\NicheRow::where('niche_section_id', $section->id)->orderby('sort_order')->get(); ?>

        @foreach($rrows as $row)
            <tr rowid="{{ $row->id }}">
                <td>{{ $row->name }}</td>
                @if($leftColumns > 0)
                    <?php $left_columns = App\NicheColumn::where('niche_section_id', $section->id)->where('side', 'left')->orderby('sort_order')->get(); ?>
                    @foreach($left_columns as $left_column)
                        <?php $cell = App\NicheCell::where('niche_row_id', $row->id)->where('niche_column_id', $left_column->id)->first(); ?>
                        @if($cell)
                            <?php
                                if($cell->status == 0){
                                    $style = "background-color:#92cf51;";
                                    $class = "selectable";
                                }

                                if($cell->status == 1) {
                                    $class = "selectable";
                                    $style = "background-color:#fff;";
                                }

                                if($cell->status == 2) {
                                    $class = "";
                                    $style = "background-color:yellow;";
                                }
                                if($cell->status == 3){
                                    $class = "";
                                    $style = "background-color:#abb8ca;";
                                }
                            ?>
                            <td class="border-td re-editable {{ $class }}" columnid="{{$left_column->id}}" cellid="{{ $cell->id }}" side="left" id="td_{{$row->id}}_{{$left_column->id}}" style="{{ $style }}">{{ $cell->name }} @if($cell->customer_name)[{{ $cell->customer_name }}]@endif </td>
                        @else
                            <td class="border-td editable" columnid="{{$left_column->id}}"  id="td_{{$row->id}}_{{$left_column->id}}" side="left"></td>
                        @endif

                    @endforeach
                @else
                    <td side="left" class="border-td editable" style="display:none"></td>
                @endif

                @if($rightColumns > 0)
                    <?php $right_columns = App\NicheColumn::where('niche_section_id', $section->id)->where('side', 'right')->orderby('sort_order','desc')->get(); ?>

                    @foreach($right_columns as $right_column)
                        <?php $cell = App\NicheCell::where('niche_row_id', $row->id)->where('niche_column_id', $right_column->id)->first(); ?>
                        @if($cell)
                            <?php
                            if($cell->status == 0){
                                $style = "background-color:#92cf51;";
                                $class = "selectable";
                            }

                            if($cell->status == 1) {
                                $class = "selectable";
                                $style = "background-color:#fff;";
                            }

                            if($cell->status == 2) {
                                $class = "";
                                $style = "background-color:yellow;";
                            }
                            if($cell->status == 3){
                                $class = "";
                                $style = "background-color:#abb8ca;";
                            }

                            ?>
                            <td class="border-td re-editable {{ $class }}" columnid="{{$right_column->id}}" cellid="{{ $cell->id }}" side="right" id="td_{{$row->id}}_{{$right_column->id}}" style="{{ $style }}">{{ $cell->name }}@if($cell->customer_name)[{{ $cell->customer_name }}]@endif</td>
                        @else
                            <td class="border-td editable" columnid="{{$right_column->id}}" id="td_{{$row->id}}_{{$right_column->id}}" side="right"></td>
                        @endif
                    @endforeach
                @else
                    <td side="right" class="border-td editable" style="display: none;"></td>
                @endif
                <td>{{ $row->name }}</td>
            </tr>
        @endforeach
    </table>
@else
        <table class="table table-bordered suite-table">
            <tr>
                <td></td>
                @if($leftColumns > 0)
                    <?php $left_columns = App\NicheColumn::where('niche_section_id', $section->id)->where('side', 'left')->orderby('sort_order')->get(); ?>
                    @foreach($left_columns as $left_column)
                        <td columnid="{{ $left_column->id }}" side="left">{{ $left_column->name }}</td>
                    @endforeach
                @else
                    <td side="left" style="display: none;"></td>
                @endif

                <?php if($rows == 0) $rowspan = 2; else $rowspan = $rowspan+1; ?>
                <td align="center" class="border-td" rowspan="{{$rowspan}}" style="width: 30px;vertical-align:middle;" id="entrance">Entrance</td>

                @if($rightColumns > 0)
                    <?php $right_columns = App\NicheColumn::where('niche_section_id', $section->id)->where('side', 'right')->orderby('sort_order','desc')->get(); ?>

                    @foreach($right_columns as $right_column)
                        <td columnid="{{ $right_column->id }}" side="right">{{ $right_column->name }}</td>
                    @endforeach
                @else
                    <td side="right" style="display:none;"></td>
                @endif
                <td></td>
            </tr>
            <tr style="display: none;">
                <td></td>
                @if($leftColumns > 0)
                    @for($i=0; $i<$leftColumns; $i++)
                        <td side="left" class="border-td"></td>
                    @endfor
                @else
                    <td side="left" class="border-td"></td>
                @endif
                @if($rightColumns > 0)
                    @for($i=0; $i<$leftColumns; $i++)
                        <td side="right" class="border-td"></td>
                    @endfor
                @else
                    <td side="right" class="border-td"></td>
                @endif
                <td></td>
            </tr>
        </table>
    </div>
@endif