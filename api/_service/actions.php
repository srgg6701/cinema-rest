<?php
/**
    файл относится исключительно к REST-сервису и к роутеру
    (как и к какому-либо другому ресурсу сайта) не подключается */
require_once dirname(__FILE__).'/../../includes/connect_db.php';

/**
 *
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
 *
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
 *
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
* Показать свободные места
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
    $current_user_id = $_SESSION['active_user_id'];
    $seatsHTML = '';
    //
    foreach(range(1,(int)$all_places) as $current_place){
        $label='<label>';
        $hidden='';
        $input_name = ' name="seat_'.$current_place.'"';
        $HTML='<input id="seat_'.$current_place.'" type="checkbox"';
        // проверить, не занято ли место, и, если да, то не текущим ли юзером
        foreach ($taken_places as $user_id=>$user_taken_places) {
            if(in_array($current_place,$user_taken_places)){
                $HTML.=' checked disabled';
                if($user_id==$current_user_id){
                    // перезаписывает ранее созданный
                    $label='<label class="mine">';
                    // нужен для отправки данных отмеченных (и заблокированных) чекбоксов
                    $hidden='<input type="hidden" ' . $input_name .
                        ' value="'.$current_place.'">';
                }
            }else
                $HTML.=$input_name;
        }
        $HTML.=' value="'.$current_place.'">';
        $HTML.=$current_place;
        $seatsHTML.=$label.$HTML.'</label>'.$hidden;
    }

    return $seatsHTML;
}
/**
*
*/
function getCancel(){
    echo "<hr>".__FUNCTION__."<hr>";
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
    //echo("<pre>res: ".$res."<pre/>");
    //echo "<div>handleOder: $query</div>";
    return ($res) ? updateOrder($post) : makeOrder($post);
}
/**
 * Обработать полученные места
 */
function handleSeanceParams($post){
    $seances_ids = array();
    foreach($post as $key=>$val)
        if(strstr($key,'seat_'))
            $seances_ids[]=$val;
    $seats_amount = count($seances_ids);
    $seances_ids=implode(",",$seances_ids);
    return array('seats_amount'=>$seats_amount, 'seances_ids'=>$seances_ids);
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
          AND user_id = ".$post[active_user_id];
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
