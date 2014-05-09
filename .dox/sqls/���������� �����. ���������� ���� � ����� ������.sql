SELECT (length(`name`)-length(replace(`name`, ',', '')))+1 AS seats_len 
  FROM movies WHERE id = 25