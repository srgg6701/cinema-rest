SELECT tickets.user_id, 
       tickets.seance_id, 
        movies.name,
        seats AS taken_places,
        showtime,
        -- NOW() AS now,
        -- NOW()-showtime 
        -- TIMESTAMPDIFF(SECOND, '2014-11-05 00:49:39', '2014-11-05 1:27:35')
        -- TIMESTAMPDIFF(SECOND, showtime, NOW())        
        -- AS datetime_diff,
        HOUR(TIMEDIFF(showtime,NOW())) AS hours
  
  FROM halls, seances , movies, tickets               
 WHERE halls_id = halls.id          
    AND tickets.seance_id = seances.id        
    AND seances.movies_id = movies.id
    AND user_id = 8