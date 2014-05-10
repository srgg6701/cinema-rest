<?php

$table = '<table class="db_table">
            <tr>
                <th>id</th>';

foreach(Admin::getTableFields($table_name) as $field)
    $table.='<th>'.$field.'</th>';
// добавить столбец для удаления записи
$table.='<th>x</th>
        </tr>';
//
if($records=Admin::getAllRecords($table_name))//,$fields
    foreach($records as $row){
        $table.='<tr>';
        foreach($row as $i=>$col){
            $table.="<td>$col</td>";
        }
        // добавить ячейку для удаления записи
        $table.='<td>x</td>';
        $table.='</tr>';
    }
$table.= '</table>'; //var_dump("<pre>",$table,"<pre/>"); die();