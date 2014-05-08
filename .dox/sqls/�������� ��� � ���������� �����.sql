SELECT (
    SELECT seats_amount FROM halls, seances
  WHERE halls_id = halls.id
  AND seances.id = (
        SELECT LEFT(code,LOCATE("-",`code`)-1)
          FROM cinema.tickets WHERE id = 1
      )
  ) AS all_places, 
  SUBSTRING(code, LOCATE("-",`code`)+1) AS taken_places 
  FROM cinema.tickets WHERE id = 1