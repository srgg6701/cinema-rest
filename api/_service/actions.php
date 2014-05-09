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
 *
 */
function makeOrder(){

    echo "<hr>".__FUNCTION__."<hr>";
}
/**
* Показать свободные места
*/
function getSeats($seance_id){
    global $connect;
    $query = "SELECT seats_amount AS all_places,
                     seats AS taken_places
                FROM halls, seances
           LEFT JOIN tickets ON tickets.seance_id = seances.id
               WHERE halls_id = halls.id
                 AND seances.id =$seance_id"; //echo "<div>$query</div>";
    $places=array();
    foreach($connect->query($query, PDO::FETCH_ASSOC) as $row){
        $places[]=$row['all_places'];
        $places[]=explode(',',$row['taken_places']);
    }
    $seatsHTML = '';
    foreach(range(1,(int)$places[0]) as $current_place){
        $seatsHTML.='<label id="seat['.$current_place.']">';
        $seatsHTML.='<input type="checkbox"';
        if(in_array($current_place,$places[1]))
            $seatsHTML.=' checked="checked"';
        $seatsHTML.=">";
        $seatsHTML.=$current_place;
        $seatsHTML.='</label>';
    }
    return $seatsHTML;
}
/**
*
*/
function getCancel(){
    echo "<hr>".__FUNCTION__."<hr>";
}