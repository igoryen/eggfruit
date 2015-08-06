INSERT INTO eggfruit.entry (
  applied_date, 
  position_name, 
  job_posting_url,
  company_name, 
  company_url,
  interview_date,
  response_date,
  response_value
  ) VALUES (
  "2015-08-06", #applied_date, 
  "Junior Software Developer",#position_name, 
  "http://ca.indeed.com/viewjob?jk=c0d98719d8987f14&from=api&q=php&l=North+York&atk=19s23und2b9r4bcp&sclk=1&sjdu=vQIlM60yK_PwYat7ToXhk26rZBa3_LKy6-LJeP8g5KIfzMFxy8R2h-N_15w1rsk54J16YiSRS50_KttS5XlEzHFpZlgOPANZFsaT2B9cz8q63MpRBVwBzXzhrqqfA_foJwhNRsaufsqsmBp9blgp9qFwuxdxl7NbOR75hAhyNXn_-NMOfBb1gchX3LQ3S7xwzCQ6JZcsJhCs0yFJbha0wPhDmxMpgI1Mo8JvIlPVMw4&pub=4091175049249359",#job_posting_url
  "Nextopia - Toronto, ON",#company_name, 
  "",#company_url,
  null,#interview_date,
  null,#response_date,
  ""#response_value
  );

SELECT * FROM eggfruit.entry ORDER BY company_name;

SELECT count(*) FROM eggfruit.entry 
        WHERE (accepted = '0') OR (DATEDIFF(NOW(), `applied_date`) > 4 )
        ORDER BY applied_date DESC;

SELECT DISTINCT applied_date, count(*) AS occurences FROM  eggfruit.entry group by applied_date;

