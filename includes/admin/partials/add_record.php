<?php
$table_add='<table class="db_table_add">';
// сгенерировать строки добавления записей
$xtra_field=false; // макс. колич. мест в зале
foreach($connect->query("DESC $table_name", PDO::FETCH_ASSOC) as $row){
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
                $table_add.=Data::makeSelect($row['Field'],$xtra_field);
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