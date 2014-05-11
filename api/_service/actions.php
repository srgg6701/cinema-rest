<?php
/**
    файл относится исключительно к REST-сервису и к роутеру
    (как и к какому-либо другому ресурсу сайта) не подключается */
require_once dirname(__FILE__).'/../../includes/connect_db.php';

/**
 * Отменить заказ
 */
function getCancel(){
    echo "<hr>".__FUNCTION__."<hr>";
}
/**
 * Показать залы по кинотеатрам
 */
function getHallsByCinema(){
    global $connect;
    $query = "SELECT
    h.id AS 'id', c.name AS 'cinema', h.name AS 'hall', seats_amount
        FROM halls h, cinema c
    WHERE h.cinema_id = c.id
    ORDER BY c.name";
    $halls = array();
    foreach($connect->query($query,PDO::FETCH_ASSOC) as $row){
        if(!array_key_exists($row['cinema'],$halls)){
            $halls[$row['cinema']] = array();
        }
        $halls[$row['cinema']][$row['id']] = array($row['hall'],$row['seats_amount']);
    }
    return $halls;
}
/**
 *  Показать сеансы по залам, в которых идёт фильм
 */
function getMovieSeances($id=NULL){
    global $connect;
    $query="SELECT
  s.id    AS 'seance_id',
  h.id    AS 'hall_id',
  m.id    AS 'movie_id',
  m.name  AS 'movie_name',
  DATE_FORMAT(s.showtime,'%m.%d %k:%i')
          AS showtime,
  s.free_seats_numbers,
  c.name  AS 'cinema',
  h.name  AS 'hall'
  FROM  seances s,
        movies m ,
        halls h,
        cinema c
  WHERE h.cinema_id = c.id
    AND s.movies_id = m.id
    AND s.halls_id = h.id";
    if($id)
        $query.="
    AND m.id = $id";
    $query.="
  ORDER BY c.name"; //echo "<div>$query</div>";
    $seances = array();
    $movie_name=true;
    foreach($connect->query($query,PDO::FETCH_ASSOC) as $row){
        if($movie_name){
            $seances[$row['movie_id']]=$row['movie_name'];
            $movie_name=false;
        }

        if(!isset($seances[$row['cinema']]))
            $seances[$row['cinema']] = array();

        if(!isset($seances[$row['cinema']][$row['seance_id']]))
            $seances[$row['cinema']][$row['seance_id']] = array();

        $seances[$row['cinema']][$row['seance_id']]['hall']=array('hall_id'=>$row['hall_id'],'hall_name'=>$row['hall']);
        $seances[$row['cinema']][$row['seance_id']]['showtime']=$row['showtime'];
        $seances[$row['cinema']][$row['seance_id']]['free_seats_numbers']=$row['free_seats_numbers'];
    }   //var_dump("<pre>",$seances,"<pre/>");
    return $seances;
}
/**
 * Показать сеансы зала
 */
function getSeancesByHall($id=NULL){
    global $connect;
    $query = "SELECT
  s.id    AS 'seance_id',
  m.id    AS 'movie_id',
  m.name  AS 'movie_name',
  DATE_FORMAT(s.showtime,'%m.%d %k:%i')
          AS showtime,
  s.free_seats_numbers
  FROM  seances s,
        movies m
  WHERE s.movies_id = m.id";

    if($id) $query.="
    AND s.halls_id = $id";

    $query.="
  ORDER BY m.id";

    $result=$connect->query($query,PDO::FETCH_ASSOC);
    $seances=array();
    foreach($result as $row){		
    	$seances[$row['seance_id']]=$row;
        unset($seances[$row['seance_id']]['seance_id']);
	}
    return $seances;
}
/**
* Сформировать список мест по сеансу
*/
function getSeats($seance_id){

    global $connect;
    $query = "SELECT  tickets.user_id,
              seats_amount AS all_places,
                     seats AS taken_places
                FROM halls, seances
           LEFT JOIN tickets ON tickets.seance_id = seances.id
               WHERE halls_id = halls.id
                 AND seances.id =$seance_id"; //echo "<div>$query</div>"; die();
    $taken_places=array();
    foreach($connect->query($query, PDO::FETCH_ASSOC) as $i=>$row){
        if(!$i) $all_places=$row['all_places'];
        $taken_places[$row['user_id']]=explode(',',$row['taken_places']);
    }
    return array('all_places'=>$all_places,'taken_places'=>$taken_places);
}
/**
 * Получить заказы юзера
 */
function getUserOrders($user_id){
    global $connect;
    $query = "SELECT
       tickets.id AS tickets_id,
       tickets.seance_id,
movies.name AS movie_name,
cinema.name AS cinema_name,
 halls.name AS halls_name,
      seats AS taken_places,
  DATE_FORMAT(showtime, \"%d.%m.%y %k:%i\") AS showtime,
  HOUR(TIMEDIFF(showtime,NOW()))
            AS hours_left
  FROM halls, seances, movies, tickets, cinema
 WHERE halls_id = halls.id
    AND tickets.seance_id = seances.id
    AND seances.movies_id = movies.id
    AND cinema.id = halls.cinema_id
    AND user_id =".$user_id."
 ORDER BY showtime, movie_name";
    $result = $connect->query($query, PDO::FETCH_ASSOC);
    $orders=array();
    foreach ($result as $row) {
        $orders[$row['seance_id']] = $row;
        unset($orders[$row['seance_id']]['seance_id']);
    }
    return $orders;
}
/**
 * Проверить, есть ли уже такой заказ.
 * В зависимости от результата вызвать либо makeOrder(),
 * либо updateOrder()
 */
function handleOder($post){
    global $connect;
    $query="SELECT count(*) AS cnt FROM tickets
      WHERE seance_id = $post[seance_id] AND user_id = ".$post['active_user_id'];
    $result = $connect->query($query, PDO::FETCH_NUM)->fetchAll();
    $res = intval($result[0][0]);
    return ($res) ? updateOrder($post) : makeOrder($post);
}
/**
 * Обработать полученные места.
 * На выходе получаем массив вида:
 * [количество_мест] => 3,5,1,8,2,15,14,10 ... n - набор соответствующего заказа
 */
function handleSeanceParams($post){
    $seances_ids = array();
    foreach($post as $key=>$val)
        if(strstr($key,'seat_'))
            $seances_ids[]=$val;
    $seats_amount = count($seances_ids);
    $seances_ids=implode(",",$seances_ids);
    $array = array('seats_amount'=>$seats_amount, 'seances_ids'=>$seances_ids);
    var_dump("<pre>",$array,"<pre/>");
    return $array;
}
/**
 * Оформить новый заказ
 */
function makeOrder($post){
    global $connect;
    $seance_params=handleSeanceParams($post);
    $query = "INSERT INTO tickets (user_id, seance_id, seats)
    VALUES ($post[active_user_id],$post[seance_id],'".$seance_params['seances_ids']."')";
    //echo "<div>makeOrder: $query</div>"; // die();
    if($connect->exec($query))
        return updateFreeSeatsAmount($seance_params['seats_amount'], $post['seance_id']);
}
/**
 *
 */
function storeUserOrdersSet($post){ //  tickets_id
    global $connect;
    // подзапрос для получения количества билетов в ticket
    $tickets_seats_len_query  = "\n
                     SELECT ( length(seats)-length(replace(seats, ',', ''))
                            )+1 AS seats_len
                       FROM tickets
                      WHERE id = $post[tickets_id]";
    // обновление данных сеанса
    $upd_seances_free_seats_amount_query = "UPDATE seances
          SET free_seats_numbers = free_seats_numbers+( $tickets_seats_len_query ) WHERE id = $post[seance_id];\n";
    /**
     * Сначала выяснить, не были ли разотмечены все чекбоксы.
     * Если да, - удалить ticket с обновлением данных сеанса
     */
    $seance_params=handleSeanceParams($post);
    //  [количество_мест] => 3,5,1,8,2,15,14,10 ... n
    if(!$seance_params['seats_amount']){
        try{
        /**
            получить количество билетов (все, поскольку запись удаляется),
            на которые будет увеличено количество свободных мест на сеансе.    */
            $query      = " $upd_seances_free_seats_amount_query
                      DELETE FROM tickets
                  WHERE id = $post[tickets_id]";
            echo "<div>storeUserOrdersSet (удаление заказа): $query</div>"; //die();
            return $connect->exec($query);
        }catch(Exception $e){
            echo $e->getMessage();
            return false;
        }
    }else{
        // если таки места остались/добавились:
        /*
        // выяснить разницу между текущим колич. мест и тем, что пришло
        $result = $connect->query($tickets_seats_len_query, PDO::FETCH_NUM)->fetchAll();*/
        /*
        //$seances_ids = explode(",",$seance_params['seances_ids']);

        //$diff = count($seance_params['seats_amount'])-intval($result[0][0]);

        //echo "<div>updateOrder: diff = $diff</div>";
        //echo "--------------<br>seances_ids:";
        //var_dump("<pre>",$seances_ids,"<pre/>"); */

        $query = "UPDATE seances
          SET free_seats_numbers = free_seats_numbers-( " .
            // количество пришедших отмеченных чекбоксов минус количество в заказе
            $seance_params['seats_amount'] . "-(
                $tickets_seats_len_query
            )
           ) WHERE id = $post[seance_id];
        UPDATE tickets SET seats = '$seance_params[seances_ids]'
          WHERE id = ".$post['tickets_id'];

        // сначала обновить запись в tickets
        /*$query = $upd_seances_free_seats_amount_query .
            "UPDATE tickets SET seats = '$seance_params[seances_ids]'
          WHERE id = ".$post['tickets_id'];*/

        // теперь обновить количество свободных мест на сеансе
        //;
        echo "<div>storeUserOrdersSet (обновление заказа): $query</div>"; //die();
        try{
            $connect->exec($query); //updateFreeSeatsAmount($diff, $post['seance_id']);
            //$connect->exec($upd_seances_free_seats_amount_query);
        }catch(Exception $e){
            echo "<div>Error: ".$e->getMessage()."</div>";
        }
    }
}
/**
 * Обновить данные заказа
 */
function updateOrder($post){
    global $connect;
    $seance_params=handleSeanceParams($post);
    // выяснить разницу между текущим колич. мест и тем, что пришло
    $cnt_query="SELECT (length(seats)-length(replace(seats, ',', '')))+1 AS seats_len
                  FROM tickets
                 WHERE seance_id = $post[seance_id]
                     AND user_id = $post[active_user_id]";
    $result = $connect->query($cnt_query, PDO::FETCH_NUM)->fetchAll();
    $seances_ids = explode(",",$seance_params['seances_ids']);
    $diff = count($seances_ids)-intval($result[0][0]);
    //echo "<div>updateOrder: diff = $diff</div>";
    //echo "--------------<br>seances_ids:";
    //var_dump("<pre>",$seances_ids,"<pre/>");
    //
    $query = "UPDATE tickets SET seats = '$seance_params[seances_ids]'
          WHERE seance_id = $post[seance_id]
          AND user_id = ".$post['active_user_id'];
    //echo "<div>updateOrder: $query</div>"; //die();
    if ($connect->exec($query))
        return updateFreeSeatsAmount($diff, $post['seance_id']);
}
/**
 * Обновить колич. свободных мест на сеансе
 */
function updateFreeSeatsAmount($taken_seats_number, $seance_id){
    global $connect;
    $query = "UPDATE seances
    SET free_seats_numbers = free_seats_numbers-($taken_seats_number)
    WHERE id = $seance_id";
    //echo "<div>$query</div>";
    return $connect->exec($query);
}
