<?php

class Admin{
    // будем сохранять набор полей и их имена для запросов
    public static $tableFields = array();
    /**
     * Добавить запись в таблицу
     */
    public static function createRecord($post){
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
        if($post[table]=="seances"){
            $fields[]="datetime";
            $values[]=date("Y-m-d H:i:s");
        }
        $query.="`" . implode("`, `",$fields) . "`) VALUES (";
        $query.="'" . implode("', '",$values) . "')";
        $connect->exec($query);
    }
    /**
     *
     */
    public static function getTableFields($table_name){
        if(empty(self::$tableFields)){
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
                    $fields=array('Заказанные места', 'id сеанса');
                    break;
                case 'user':
                    $fields=array('Имя зрителя');
                    break;
            }
            self::$tableFields = $fields;
        }
        return self::$tableFields;
    }
    /**
     * Сгенерировать список таблиц БД
     */
    public static function getAdminTables(){
        global $db_name, $connect;
        $query = 'SELECT table_name FROM information_schema.TABLES
 WHERE table_schema = "'.$db_name.'" ORDER BY table_name';
        foreach($connect->query($query,PDO::FETCH_ASSOC) as $table_name):?>
            <li><a href="<?php echo SITE_ROOT;?>admin/<?php
                echo $table_name['table_name'];?>"><?php
                    echo $table_name['table_name'];?></a>
            </li>
        <?php
        endforeach;
    }
    /**
     * Получить все записи из таблицы
     */
    public static function getAllRecords($table_name){ // $segments[3]
        global $connect;

        switch($table_name){
            case 'seances':
                $order='datetime';
                break;
            case 'halls':
                $order='cinema.name';
                break;
            case 'tickets':
                $order='id';
                break;
            default:
                $order='id';
        }
        $fields_names = self::getTableFields($table_name);

        $query = "SELECT ".$table_name.".id, ";

        switch($table_name){
            case 'seances':
                $query.="
            movies.name AS '$fields_names[0]', -- Фильм,
            cinema.name AS '$fields_names[1]', -- Кинотеатр,
             halls.name AS '$fields_names[2]', -- Зал,
DATE_FORMAT(showtime,'%d.%m.%Y %k:%i')
                        AS '$fields_names[3]', -- Время показа
     free_seats_numbers AS '$fields_names[4]', -- Своб. мест
DATE_FORMAT(datetime,'%d.%m.%Y %k:%i')
                        AS '$fields_names[5]'  -- Дата записи
  FROM seances, movies, cinema, halls
  WHERE seances.movies_id = movies.id
    AND seances.halls_id = halls.id
    AND halls.cinema_id = cinema.id ";
                break;
            case 'cinema': case 'movies':
            $query.="name AS '$fields_names[0]'
            FROM $table_name
            ORDER BY $order";
            break;
            case 'halls':
                $query.="halls.name AS '$fields_names[0]', -- Название зала
                    cinema.name AS '$fields_names[1]', -- Кинотеатр,
                   seats_amount AS '$fields_names[2]'  -- Свободных мест
                FROM cinema, halls
            WHERE halls.cinema_id = cinema.id
            ORDER BY $order";
                break;
            case 'tickets':
                $query.="seats AS '$fields_names[0]',
                 seance_id AS '$fields_names[1]'
                 FROM $table_name
            ORDER BY $order"; // Код билета
                break;
            default:
                $query ="SELECT * FROM $table_name ORDER BY `$order`";
        }   //фecho "<div>$query</div>"; die($table_name);
        return $connect->query($query, PDO::FETCH_NUM);
    }
    /**
    * Сгенерировать выпадающий список выбора связанных данных таблицы
    */
    public static function makeSelect($fieldname, $join_table=false){
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

}