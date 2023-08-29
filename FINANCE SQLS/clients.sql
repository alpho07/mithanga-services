drop table if exists clients;
create table clients as 
SELECT 
  LPAD(ACCOUNT_NO,4,'0') id,
  w.id area,
  k.NAME account_name,
  PHONE_NO phone_no,
  '2020-01-01' account_open_date,
  LPAD(ACCOUNT_NO,4,'0') meter_number,
  NULL plot_number,
  1 status,
  NULL connection_date,
  NULL vaccation_date,
  NULL reconnection_date,
 NULL  meter_reading_date,
  NULL avatar,
  NULL national_id,
  NULL comment,
  NULL email,
  now() created_at,
  now()updated_at,
  NULL kra_pin

FROM finance_data k
INNER JOIN areas w ON w.name = k.field5
ORDER BY ACCOUNT_NO  ASC;


drop table if exists meter_readings;
create table meter_readings as
SELECT
  null id,
  account client_id,
  date_ reading_date,
  reading current_reading,
  CASE WHEN date_='2023-05-30 23:59:00' THEN 1 ELSE 0 END bill_run,
  1 standing_charge,
  'c' discon,
  null calc
 FROM readings;
 
 
 
 drop table if exists meter_readings;
create table meter_readings as
SELECT
  null id,
  account client_id,
  period reading_date,
  CASE WHEN period='2023-06-30' THEN prev_reading ELSE curr_reading END AS current_reading,
  CASE WHEN period='2023-06-30' THEN 1 ELSE 0 END bill_run,
  1 standing_charge,
  'c' discon,
  null calc
 FROM source_table;
 
 
 
insert into transactions 
SELECT 
LAST_INSERT_ID() id,
account client_id,
'Account Credit Adjustment' description,
now() date,
'credit' type,
0 last_read,
CAST(REPLACE(PAID,',','') AS INT)  amount,
0.0 amount_received,
0 units,
DATE_FORMAT(now(),'%Y%m%d%h%i%s') reference,
now() created_at,
now() updated_at,
 2 mop,
 0 bank,
 0 branch,
 null staff,
 null comments,
 0 lc,
 0 dnp,
 0 scheduler,
 'pending' sstatus,
 null smessage,
 'no' sc
FROM readings
WHERE `date_` = '2023-05-30 23:59:00' 
AND `PAID` != '0.00'