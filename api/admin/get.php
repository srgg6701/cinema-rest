<?php
/*if(isset($filter_name)){
    getDataByFilter($filter_name,$filter_value);
    exit();
} */

/**
 * генерация интерфейса управления таблицами БД для админа:
 просмотр, добавление, удаление */
$table = '<table class="db_table">
            <tr>';
$table_add='<table class="db_table_add">';
// сгенерировать строку с заголовками
$xtra_field=false; // макс. колич. мест в зале
foreach($connect->query("DESC $segments[3]", PDO::FETCH_ASSOC) as $row){
    $table.="<th>$row[Field]</th>";

    if($row['Key']!="PRI"&&$row['Type']!="datetime"){
        $table_add.="<tr>
                <td>$row[Field]</td>
                <td>";
        // добавить контроль максимального количества мест в зале:
        $xtra_field=($row['Field']=='halls_id')? true:false;
        if($row['Type']=='text') // пока нет, но в будущем, возможно, появится поле типа "текст"
            $table_add.="<textarea name=\"$row[Field]\"></textarea>";
        else{
            if(preg_match('/\B_id$/',$row['Field']))
                $table_add.=makeSelect($row['Field'],$xtra_field);
            else{
                $ftype=($row['Field']=='showtime')? 'date':'text';
                $table_add.="<input type=\"$ftype\" name=\"$row[Field]\">";
            }
        }
        $table_add.="</td>
        </tr>";
    }
}
$table_add.='</table>';
// добавить столбец для удаления записи
$table.='<th>x</th>
        </tr>';
//
if($records=getAllRecords($segments[3]))
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
