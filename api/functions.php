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
    return $connect->query("SELECT * FROM $table_name ORDER BY id DESC", PDO::FETCH_NUM);
}
/**
 * Сгенерировать выпадающий список
 */
function makeSelect($fieldname, $xtra_field=false){
    global $connect;
    if($xtra_field)
        return "Выберите кинофильм выше.";
    $select = "
            <select name='$fieldname'>
                <option>- id : NAME -</option>";
    $tbl = preg_replace('/\B_id$/','',$fieldname); //echo "<h1>tbl: $tbl</h1>";
    $query="SELECT id, name FROM $tbl ORDER BY name DESC"; //echo "<div>$query</div>";
    if($result=$connect->query($query, PDO::FETCH_ASSOC)){
        foreach($result as $row){
            $select.="<option value='$row[id]'>$row[id] : $row[name]</option>";
        }
    }
    $select.="
            </select>";
    return $select;
}