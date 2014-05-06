<?php
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