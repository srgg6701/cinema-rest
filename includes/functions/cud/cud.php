<?php
/**
 * Добавить запись в таблицу
 */
function createRecord($post){
    global $connect;
    $query = "INSERT INTO $post[table] (";
    $fields=$values=array();
    foreach($_POST as $key => $val){
        if($key!=='table'){
            if($key=='showtime')
                $val.=" ".$post['time'].":00";
            if($key!='time'){
                $fields[]=$key;
                $values[]=$val;
            }
        }
    }
    if($post['table']=="seances"){
        $fields[]="datetime";
        $values[]=date("Y-m-d H:i:s");
        //$qs = ";
        $fields[] = 'free_seats_numbers';
    }
    $query.="`" . implode("`, `",$fields) . "`) VALUES (";
    $query.="'" . implode("', '",$values);
    /**
     Для таблицы сеансов добавить количество свободных мест, как максимальное */
    if($post['table']=="seances")
        $query.="', (SELECT seats_amount FROM halls WHERE id = ".$post['halls_id']."))";

    else $query.= "')";
    //
    try{
        $connect->exec($query);
    }catch (Exception $e){
        die($e->getMessage());
    }
}
function deleteRecord($table_name,$id){
    global $connect;
    return $connect->exec("DELETE FROM $table_name WHERE id = $id");
}
