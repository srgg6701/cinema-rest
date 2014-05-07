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
        /*array_push( $halls[$row['cinema']],
                array(  'id'=>$row['id'],
                        'name'=>$row['hall'],
                        'seats_amount'=>$row['seats_amount']) );*/
    }
    return $halls;
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
