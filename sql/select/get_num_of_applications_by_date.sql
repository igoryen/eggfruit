SELECT DISTINCT
    applied_date AS `date`, COUNT(*) AS occurences
FROM
    eggfruit.entry
GROUP BY applied_date
ORDER BY `occurences` DESC;
