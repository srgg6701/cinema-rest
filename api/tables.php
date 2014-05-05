<?php
require_once $path."connect_db.php";



function makeSelect($fieldname, $connect){
    $select = "
            <select name='$fieldname'>
                <option>- id : NAME -</option>";
    $tbl = preg_replace('/\B_id$/','',$fieldname); //echo "<h1>tbl: $tbl</h1>";
    $query="SELECT id, name FROM $tbl ORDER BY name DESC"; //echo "<div>$query</div>";
    if($result=$connect->query($query, PDO::FETCH_ASSOC)){
        foreach($result as $row)
            $select.="<option value='$row[id]'>$row[id] : $row[name]</option>";
    }
    $select.="
            </select>";
    return $select;
}

//echo "<div>rows: ".$table_data->rowCount()."</div>";
$table = '<table class="db_table">
            <tr>';
$table_add='<table class="db_table_add">';
$table_data=$connect->query("DESC $segments[3]", PDO::FETCH_ASSOC);
// сгенерировать строку с заголовками
foreach($table_data as $row){
    $table.="<th>$row[Field]</th>";

    if($row['Key']!="PRI"&&$row['Type']!="datetime"){
        $table_add.="<tr>
                <td>$row[Field]</td>
                <td>";
        if($row['Type']=='text')
            $table_add.="<textarea></textarea>";
        else{
            if(preg_match('/\B_id$/',$row['Field']))
                $table_add.=makeSelect($row['Field'],$connect);
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

$query="SELECT * FROM $segments[3] ORDER BY id DESC";
$table_data = $connect->query($query, PDO::FETCH_NUM);

foreach($table_data as $row){
    $table.='<tr>';
    foreach($row as $i=>$col){

        $table.="<td>$col</td>";
    }
    // добавить ячейку для удаления записи
    $table.='<td>x</td>';
    $table.='</tr>';
}
$table.= '</table>';
