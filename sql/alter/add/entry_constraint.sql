# http://www.w3schools.com/sql/sql_unique.asp

ALTER TABLE eggfruit.entry
ADD CONSTRAINT uc_entry UNIQUE (
position_name,
job_posting_url,
company_name);

