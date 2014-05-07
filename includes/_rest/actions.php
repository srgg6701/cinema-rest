<?php
/**
    файл относится исключительно к REST-сервису и к роутеру
    (как и к какому-либо другому ресурсу сайта) не подключается */
require_once dirname(__FILE__).'/../connect_db.php';

function getSchedule(){
    echo "<hr>".__FUNCTION__."<hr>";
    //getAllRecords($table_name, $fields_names);
}


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
function getSeancesByHall($id){
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
  WHERE s.movies_id = m.id
    AND s.halls_id = $id
  order by m.id";
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
function getSeats(){
    echo "<hr>".__FUNCTION__."<hr>";
}
/**
*
*/
function getOrder(){
    echo "<hr>".__FUNCTION__."<hr>";
}
/**
*
*/
function getCancel(){
    echo "<hr>".__FUNCTION__."<hr>";
}
