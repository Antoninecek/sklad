select D.ean, imei, imei1, zarKusy, invKusy, zbozi, model, popis, sapKusy, C.celkem from (

select B.ean, B.imei, B.imei1, B.zarKusy, B.invKusy, zbozi, model, popis, sap.kusy as sapKusy
from (
    select coalesce(A.ean, inventura.ean) as ean, imei, imei1, A.kusy as zarKusy, inventura.kusy as invKusy 
    from (  
          select ean, imei, imei1, sum(kusy) as kusy 
          from 
              zarizeni where imei is null 
              group by ean 
              having sum(kusy) != 0 
              
              union 
              
              select ean, imei, imei1, kusy 
              from 
                  zarizeni 
                  where imei is not null 
                  group by imei 
                  having sum(kusy) != 0 
          ) as A 
          left join inventura on A.ean = inventura.ean 
 
    union 
 
    select coalesce(A.ean, inventura.ean) as ean, imei, imei1, A.kusy as zarKusy, inventura.kusy as invKusy  
    from ( 
          select ean, imei, imei1, sum(kusy) as kusy 
          from 
              zarizeni 
              where imei is null 
              group by ean 
              having sum(kusy) != 0 
              
              union
               
              select ean, imei, imei1, kusy 
                    from 
                        zarizeni 
                        where imei is not null 
                        group by imei 
                        having sum(kusy) != 0 
          ) as A
          right join inventura on A.ean = inventura.ean
     ) as B

     
     
     
left join sap on B.ean = sap.ean order by ean

 ) as D 
 
 left join (select sum(kusy) as celkem, ean from zarizeni where imei is not null group by ean having sum(kusy) != 0) as C on D.ean = C.ean
 