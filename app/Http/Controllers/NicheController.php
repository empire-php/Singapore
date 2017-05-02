<?php

namespace App\Http\Controllers;

use App\NicheCell;
use App\NicheColumn;
use App\NicheRow;
use App\User;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\NicheBlock;
use App\NicheSection;
use App\NicheSuite;
use App\Settings;
use App\Http\Controllers\Controller;

class NicheController extends Controller
{
    //
    /**
     * Developed by David 2017-03-28
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function holdNiche(){

        // update cell status to available

        $cells = NicheCell::where('updated_at', '<', \Carbon\Carbon::now()->subDays(3))->where('status', 0)->get();
        foreach ($cells as $cell) {
            $cell->status = 1;
            $cell->save();
        }


        $blocks = NicheBlock::all();
        return view('niche.holdniche', [
            'blocks' => $blocks,
        ]);
    }

    public function holdNicheCell(Request $request) {

        $status = $request->get('onhold');
        $row_id = $request->get('row_id');
        $column_id = $request->get('column_id');
        $description = $request->get('description');
        $customer_name = $request->get('customer_name');
        $act = $request->get('act');
        $id = $request->get('cell_id');
        $td_index = $request->get('td_index');
        $staff_name = $request->get('staff_name');


        if($act == "add"){
            $cell = new NicheCell();
            $cell->status = $status;
            $cell->niche_row_id = $row_id;
            $cell->niche_column_id = $column_id;
            $cell->description = $description;
            $cell->customer_name = $customer_name;
            $cell->staff_name = $staff_name;
            $cell->td_index = $td_index;
            $cell->save();
        } else {
            $cell = NicheCell::find($id);
            if($status == 0 )
                $cell->status = $status;
            else
                $cell->status = 1;


            $cell->niche_row_id = $row_id;
            $cell->niche_column_id = $column_id;
            $cell->description = $description;
            $cell->customer_name = $customer_name;
            $cell->staff_name = $staff_name;
            $cell->td_index = $td_index;
            $cell->save();
        }
        return $cell;
    }


    public function readNicheSection(Request $request){

        $id = $request->get('section_id');
        $section = NicheSection::find($id);

        return view('niche.section_table', [
            'section' => $section,
        ]);
    }

    //Update Terms & Conditions
    public function updateNicheSettings(Request $request){
        $terms = $request->get('terms');
        $niche_setting = Settings::where('name', 'niche')->get()->first();
        $niche_setting->value = $terms;
        $niche_setting->save();
        $msg = "Save Successfully!";
        return $msg;
    }

    //Add Block
    public function addNicheBlock(Request $request) {
        $block_name = $request->get('block');
        $block = new NicheBlock();
        $block->name = $block_name;
        $block->save();
        $block_id = $block->id;
        return $block_id;
    }

    //Update Block and Suite
    public function updateNicheBlockAndSuite(Request $request){
        $id = $request->get('id');
        $kind = $request->get('element_kind');
        $name = $request->get('element_name');

        if($kind == "block") {
            $block = NicheBlock::find($id);
            if (!$block || $name === null) {
                return response()->json([
                    'status' => 'error',
                    'msg'    => 'Wrong Request',
                ]);
            }
            $block->name = $name;
            $block->save();
            $element_id = $block->id;
        }
        else if($kind== "suite") {
            $suite = NicheSuite::find($id);
            if (!$suite || $name === null) {
                return response()->json([
                    'status' => 'error',
                    'msg'    => 'Wrong Request',
                ]);
            }
            $suite->name = $name;
            $suite->save();
            $element_id = $suite->id;
        }
        else if($kind == "row_edit"){
            $row = NicheRow::find($id);
            if (!$row || $name === null) {
                return response()->json([
                    'status' => 'error',
                    'msg'    => 'Wrong Request',
                ]);
            }
            $row->name = $name;
            $row->save();
            $element_id = $row->id;

        }

        else if($kind == "column_edit"){
            $column = NicheColumn::find($id);
            if (!$column || $name === null) {
                return response()->json([
                    'status' => 'error',
                    'msg'    => 'Wrong Request',
                ]);
            }
            $column->name = $name;
            $column->save();
            $element_id = $column->id;

        }

        return $element_id;
    }

    //Delete Block and Suite
    public function deleteNicheBlockAndSuite(Request $request){
        $id = $request->get('id');
        $kind = $request->get('element_kind');

        if($kind == "block") {
            $block = NicheBlock::find($id);

            foreach($block->niche_suites as $niche_suite) { //delete child suites
                foreach($niche_suite->niche_sections as $niche_section){ //delete child sections
                    foreach($niche_section->niche_rows as $niche_row){ //delete child rows
                        foreach ($niche_row->niche_cells as $niche_cell){ //delete child cells
                            $niche_cell->delete();
                        }
                        $niche_row->delete();
                    }
                    foreach($niche_section->niche_columns as $niche_column){ //delete child columns
                        $niche_column->delete();
                    }
                    $niche_section->delete();
                }
                $niche_suite->delete();
            }
            $block->delete();
        }
        else if($kind == "suite") {
            $suite = NicheSuite::find($id);

            foreach($suite->niche_sections as $niche_section){ //delete child sections
                foreach($niche_section->niche_rows as $niche_row){ //delete child rows
                    foreach ($niche_row->niche_cells as $niche_cell){ //delete child cells
                        $niche_cell->delete();
                    }
                    $niche_row->delete();
                }
                foreach($niche_section->niche_columns as $niche_column){ //delete child columns
                    $niche_column->delete();
                }
                $niche_section->delete();
            }
            $suite->delete();
        }
        else if($kind == "section") {
            $section = NicheSection::find($id);
            foreach($section->niche_rows as $niche_row){ //delete child rows
                foreach ($niche_row->niche_cells as $niche_cell){ //delete child cells
                    $niche_cell->delete();
                }
                $niche_row->delete();
            }
            foreach($section->niche_columns as $niche_column){ //delete child columns
                $niche_column->delete();
            }
            $section->delete();
        }

        return "OK";
    }

    //Add Suite
    public function addNicheSuite(Request $request) {
        $block_id = $request->get('block_id');
        $suite_name = $request->get('suite');
        $suite = new NicheSuite();
        $suite->niche_block_id = $block_id;
        $suite->name = $suite_name;
        $suite->save();
        return $suite->id;
    }

    //Add Section
    public function addNicheSection(Request $request) {
        $suite_id = $request->get('suite_id');
        $section_name = $request->get('section');
        $section_description = $request->get('description');

        $section = new NicheSection();
        $section->niche_suite_id = $suite_id;
        $section->name = $section_name;
        $section->description = $section_description;

        $section->save();
        return $section->id;
    }

    //Update Section
    public function updateNicheSection(Request $request){
        $id = $request->get('id');
        $name = $request->get('name');
        $description = $request->get('description');
        $section = NicheSection::find($id);
        $section->name = $name;
        $section->description = $description;
        $section->save();
        return $section->id;
    }

    //Add Row
    public function addNicheRow(Request $request) {
        $section_id = $request->get('section_id');
        $row_name = $request->get('name');
        $pos = $request->get('pos');
        $current_row_id = $request->get('current_row');


        if($current_row_id == 0 || $current_row_id =='') {
            $new_row = new NicheRow();
            $new_row->name = $row_name;
            $new_row->niche_section_id = $section_id;
            $new_row->sort_order = 1;
            $new_row->save();

        }
        else {
            $current_row = NicheRow::find($current_row_id);
            $old_sort_order = $current_row->sort_order;
            if($pos == "below") {
                $new_sort_order = $old_sort_order + 1;
            } else{
                $new_sort_order = $old_sort_order;
            }

            NicheRow::where('niche_section_id', $section_id)->where('sort_order', '>=', $new_sort_order)->increment('sort_order', 1);

            $new_row = new NicheRow();
            $new_row->name = $row_name;
            $new_row->niche_section_id = $section_id;
            $new_row->sort_order = $new_sort_order;
            $new_row->save();
        }

        return $new_row;
    }

    public function deleteNicheRow(Request $request) {
        $row_id = $request->get('row_id');
        $row = NicheRow::find($row_id);

        $section_id = $row->niche_section_id;

        NicheRow::where('niche_section_id', $row->niche_section_id)->where('sort_order', '>=', $row->sort_order)->decrement('sort_order', 1);
        NicheCell::where('niche_row_id', $row_id)->delete();
        $row->delete();
        return $section_id;
    }


    //Add Column
    public function addNicheColumn(Request $request) {
        $section_id = $request->get('section_id');
        $column_name = $request->get('name');
        $pos = $request->get('pos');
        $side = $request->get('side');
        $current_column_id = $request->get('current_column');


        if($current_column_id == 0 || $current_column_id =='') {
            $now_column = new NicheColumn();
            $now_column->name = $column_name;
            $now_column->niche_section_id = $section_id;
            $now_column->sort_order = 1;
            $now_column->side = $side;
            $now_column->save();

        }
        else {
            $current_row = NicheColumn::find($current_column_id);
            $old_sort_order = $current_row->sort_order;
            if($side == "left") {
                if($pos == "right") {
                    $new_sort_order = $old_sort_order + 1;
                } else {
                    $new_sort_order = $old_sort_order;
                }
            }
            else {
                if($pos == "left") {
                    $new_sort_order = $old_sort_order + 1;
                } else {
                    $new_sort_order = $old_sort_order;
                }
            }

            NicheColumn::where('niche_section_id', $section_id)->where('sort_order', '>=', $new_sort_order)->where('side', $side)->increment('sort_order', 1);

            $now_column = new NicheColumn();
            $now_column->name = $column_name;
            $now_column->niche_section_id = $section_id;
            $now_column->sort_order = $new_sort_order;
            $now_column->side = $side;
            $now_column->save();
        }

        return $now_column;
    }

    public function deleteNicheColumn(Request $request) {
        $column_id = $request->get('column_id');
        $side = $request->get('side');
        $column = NicheColumn::find($column_id);
        $section_id = $column->niche_section_id;

        NicheColumn::where('niche_section_id', $column->niche_section_id)->where('sort_order', '>=', $column->sort_order)->where('side', $side)->decrement('sort_order', 1);

        NicheCell::where('niche_column_id', $column_id)->delete();

        $column->delete();
        return $section_id;
    }

    public function addNicheCell(Request $request){

        $name = $request->get('name');
        $status = $request->get('status');
        $row_id = $request->get('row_id');
        $column_id = $request->get('column_id');
        $description = $request->get('description');
        $selling_price = $request->get('selling_price');
        $maintenance_fee = $request->get('maintenance_fee');
        $type = $request->get('type');
        $act = $request->get('act');
        $id = $request->get('cell_id');
        $td_index = $request->get('td_index');


        if($act == "add"){
            $cell = new NicheCell();
            $cell->name = $name;
            $cell->status = $status;
            $cell->niche_row_id = $row_id;
            $cell->niche_column_id = $column_id;
            $cell->description = $description;
            $cell->selling_price = $selling_price;
            $cell->maintenance_fee = $maintenance_fee;
            $cell->type = $type;
            $cell->td_index = $td_index;
            $cell->save();
        } else {
            $cell = NicheCell::find($id);
            $cell->name = $name;
            $cell->status = $status;
            $cell->niche_row_id = $row_id;
            $cell->niche_column_id = $column_id;
            $cell->description = $description;
            $cell->selling_price = $selling_price;
            $cell->maintenance_fee = $maintenance_fee;
            $cell->type = $type;
            $cell->td_index = $td_index;
            $cell->save();
        }
        return $cell;
    }

    public function readNicheCell(Request $request){
        $id = $request->get('cell_id');
        $cell = NicheCell::find($id);
        if($cell->staff_name) {
            $staff = User::find($cell->staff_name);
            $cell['staff'] = $staff->name;
        } else {
            $cell['staff'] = '';
        }

        return $cell;
    }
}
