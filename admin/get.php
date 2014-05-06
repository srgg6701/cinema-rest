<?php
/**
 * генерация интерфейса управления таблицами БД для админа:
 просмотр, добавление, удаление */
$table_name = $segments[2];
$table_add='<table class="db_table_add">';
// сгенерировать строки добавления записей
$xtra_field=false; // макс. колич. мест в зале
foreach($connect->query("DESC $table_name", PDO::FETCH_ASSOC) as $row){
    //$table.="<th>$row[Field]</th>";

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
                if($row['Field']=='showtime'){ // и дата, и время
                    $table_add.="<input type=\"date\" name=\"$row[Field]\" value=\"\">";
                    $table_add.="<input type=\"time\" name=\"time\" value=\"\">";
                }
                else // текстовое поле
                    $table_add.="<input type=\"text\" name=\"$row[Field]\" value=\"\">";
            }
        }
        $table_add.="</td>
        </tr>";
    }
}
$table_add.='</table>';

switch($table_name){
    case 'cinema':
        $fields=array('Название');
        break;
    case 'halls':
        $fields=array('Название зала','Кинотеатр', 'Свободных мест');
        break;
    case 'movies':
        $fields=array('Название фильма');
        break;
    case 'seances':
        $fields=array('Фильм','Кинотеатр','Зал','Время показа','Своб. мест','Дата записи');
        break;
    case 'tickets':
        $fields=array('Код билета');
        break;
}

$table = '<table class="db_table">
            <tr>
                <th>id</th>';

foreach($fields as $field)
    $table.='<th>'.$field.'</th>';
// добавить столбец для удаления записи
$table.='<th>x</th>
        </tr>';
//
if($records=getAllRecords($table_name,$fields))
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
