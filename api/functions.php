<?php
/**
 * Сгенерировать список таблиц БД
 */
function getAdminTables(){
    global $db_name, $connect;
    $query = 'SELECT table_name FROM information_schema.TABLES
 WHERE table_schema = "'.$db_name.'" ORDER BY table_name';
    foreach($connect->query($query,PDO::FETCH_ASSOC) as $table_name):?>
        <li><a href="<?php echo SITE_ROOT;?>api/admin/<?php
            echo $table_name['table_name'];?>"><?php
                echo $table_name['table_name'];?></a>
        </li>
    <?php
    endforeach;
}
/**
 * Получить все записи из таблицы
 */
function getAllRecords($table_name){ // $segments[3]
    global $connect;
    switch($table_name){
        case 'seances':
            $order='datetime';
            break;
        default:
            $order='name';
    } //echo "<div>SELECT * FROM $table_name ORDER BY `$order` DESC</div>";
    return $connect->query("SELECT * FROM $table_name ORDER BY `$order` DESC", PDO::FETCH_NUM);
}
/**
 *
 */
/*function getDataByFilter($filter_name,$filter_value){
    echo "filter: ".$filter_name." = ".$filter_value."\n";
} */
/**
 * Сгенерировать выпадающий список
 */
function makeSelect($fieldname, $join_table=false){
    global $connect;
    $select = "
            <select name='$fieldname'>
                <option value=\"0\">- id : NAME -</option>";
    if($join_table)
      $query = "SELECT halls.id,
    CONCAT(cinema.name, \" :: \", halls.name)
                   AS 'name'
                  FROM halls, cinema
                 WHERE halls.cinema_id = cinema.id
              ORDER BY cinema.name";
    else{
        $tbl = preg_replace('/\B_id$/','',$fieldname); //echo "<h1>tbl: $tbl</h1>";
        $query="SELECT id, name FROM $tbl ORDER BY `name` ASC"; //echo "<div>$query</div>";
    }
    if($result=$connect->query($query, PDO::FETCH_ASSOC)){
        foreach($result as $row){
            $select.="<option value='$row[id]'>$row[id] : $row[name]</option>";
        }
    }
    $select.="
            </select>";
    return $select;
}