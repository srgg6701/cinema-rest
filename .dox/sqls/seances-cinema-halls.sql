SELECT
  s.id    AS 'seance_id',
  h.id    AS 'hall_id',
  m.id    AS 'movie_id',
  m.name  AS 'movie_name',
  DATE_FORMAT(s.showtime,'%m.%d %k:%i') 
          AS showtime,
  s.free_seats_numbers,
  c.name  AS 'cinema', 
  h.name  AS 'hall', 
  seats_amount 
  FROM  seances s,
        movies m,
        halls h, 
        cinema c
  WHERE h.cinema_id = c.id
    AND s.movies_id = m.id
    AND s.halls_id = h.id
  order by c.name