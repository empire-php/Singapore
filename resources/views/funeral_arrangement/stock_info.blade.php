The selected item(s) can be found in more than 1 storage location.
<br />
Please select the storage location you will retrieve the item from.
</br>
<?php if(count($fa_items)>0):?>
<table class="table table-bordered">
    <thead>
        <th>Section Name</th>
        <th>Category Name</th>
        <th>Selection Category</th>
        <th>Selection Item</th>
        <th>Inventory storage</th>
    </thead>
    <tbody>
        <?php foreach($fa_items as $item):?>
      
        <tr>
            <td>
            {{$item->section_name}}    
            </td>
            <td>
            {{$item->category_name}}    
            </td>
            <td>
            {{$item->selection_category}}    
            </td>
            <td>
            {{$item->selection_item_name}}    
            </td>
            
            <td>
                <select id="storage_select_item_{{$item->id}}">
                    <option>Select location</option>
                    <option value="w">Warehouse - qty {{$list['fa_package'][$item->id]["w"]}}</option>
                    <option value="s">Store Room - qty {{$list['fa_package'][$item->id]["s"]}}</option>
                </select>
            </td>
            
        </tr>
        <?php endforeach;?>
        
        
    </tbody>
</table>
</hr>
<?php endif; ?>
<table class="table table-bordered">
    <thead>
        <th>Item Type</th>
        <th>Group Name</th>
        <th>Selection Category</th>
        <th>Selection Item</th>
        <th>Inventory storage</th>
    </thead>
    <tbody>
        <?php foreach($group_items as $item):?>
        <tr>
            <td>
            {{$item->item_type}}    
            </td>
            <td>
            {{$item->group_name}}    
            </td>
            <td>
            {{$item->selection_category}}    
            </td>
            <td>
            {{$item->selection_item_name}}    
            </td>
            
            <td>
                <select id="group_select_item_{{$item->id}}">
                    <option>Select location</option>
                    <option value="w">Warehouse - qty {{$list['group_items'][$item->id]["w"]}}</option>
                    <option value="s">Store Room - qty {{$list['group_items'][$item->id]["s"]}}</option>
                </select>
            </td>
            
        </tr>
        <?php endforeach;?>
        
        
    </tbody>
</table>

