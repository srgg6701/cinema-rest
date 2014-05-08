SELECT SUBSTRING(code, LOCATE("-",`code`)+1) AS places 
  FROM cinema.tickets