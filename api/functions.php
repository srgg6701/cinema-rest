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
function getAllRecords($table_name, $fields_names){ // $segments[3]
    global $connect;
    switch($table_name){
        case 'seances':
            $order='datetime';
            break;
        case 'halls':
            $order='cinema.name';
            break;
        default:
            $order='name';
    } //echo "<div>SELECT * FROM $table_name ORDER BY `$order` DESC</div>";
    $query = "SELECT ".$table_name.".id, ";
    switch($table_name){
        case 'seances':
            $query.="
            movies.name AS '$fields_names[0]', -- Фильм,
            cinema.name AS '$fields_names[1]', -- Кинотеатр,
             halls.name AS '$fields_names[2]', -- Зал,
               showtime AS '$fields_names[3]', -- Время показа
     free_seats_numbers AS '$fields_names[4]', -- Своб. мест
               datetime AS '$fields_names[5]'  -- Дата записи
  FROM seances, movies, cinema, halls
  WHERE seances.movies_id = movies.id
    AND seances.halls_id = halls.id
    AND halls.cinema_id = cinema.id ";
            break;
        case 'cinema': case 'movies':
            $query.="name AS '$fields_names[0]'";
            break;
        case 'halls':
            $query.="halls.name AS '$fields_names[0]', -- Название зала
                    cinema.name AS '$fields_names[1]', -- Кинотеатр,
                   seats_amount AS '$fields_names[2]'  -- Свободных мест
  FROM cinema, halls WHERE halls.cinema_id = cinema.id";
            break;
        case 'tickets':
            $query.="code AS '$fields_names[0]'"; // Код билета
            break;
        default:
            $query ="SELECT * FROM $table_name ORDER BY `$order`";
    }

    return $connect->query($query, PDO::FETCH_NUM);
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