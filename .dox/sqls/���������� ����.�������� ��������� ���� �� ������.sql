UPDATE seances s
  SET free_seats_numbers = 
  (SELECT `seats_amount` FROM halls WHERE id = s.halls_id)