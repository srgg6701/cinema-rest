SELECT
  IF(ISNULL(tickets.id),'',tickets.id) AS tickets_id,
  IF(ISNULL(user.id),'', user.id) AS  user_id,
  IF(ISNULL(tickets.seats),'',tickets.seats) AS user_seats,
  seances.id AS seance_id,
  seances.free_seats_numbers,
  IF(ISNULL(user.username),'',user.username) as username,
  movies.id AS movie_id,
  movies.name AS movie_name,
  seances.showtime,
  cinema.id AS cinema_id,
  cinema.name AS cinema_name,
  halls.name AS halls_name,
  halls.seats_amount,
  seances.halls_id
FROM seances
  LEFT JOIN halls
    ON seances.halls_id = halls.id
  LEFT JOIN movies
    ON seances.movies_id = movies.id
  LEFT JOIN tickets
     ON tickets.seance_id = seances.id
  LEFT JOIN user
    ON tickets.user_id = user.id
  LEFT JOIN cinema
    ON halls.cinema_id = cinema.id
  ORDER BY tickets.id DESC