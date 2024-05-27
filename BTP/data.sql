-- email:admin@gmail.com mdp:admin

insert into unite(nom_unite,abbreviation) values
('metre cube','m3'),('kilogramme','kg'),('gramme','g'),('metre carre','m2'),('forfaitaire','fft');

insert into finition (nom_finition,pourcentage)
values('Standart',0),('Gold',10),('Premium',15),('VIP',20);

insert into type_maison(nom_maison,description) values
('Simple',' maison de  40 m2 ,2 Chambres, toillete et douche a l exterieur'),
('Moyen','Maison de 70 m2 , 4 chambres, toilette et douche a l interieur, jardin 20m2'),
('Villa','Villa de 120 m2, 6 chambres, 2 salle de bains, 1 piscine,terrain de 100 m2');

insert into type_travaux(nom_type_travaux,prix_unitaire,idunite) values
('mur de soutenement et demi cloture',190000.0,1),
('Decapage des terrains meubles',3072,4),
('Dressage du plateforme',3736,4),
('Fouille d ouvrage terrain ferme',9390,1),
('Remblai d ouvrage',37563,1),
('Travaux d implantation',152656,5);

insert into devis_maison(idtype_maison,duree) values(1,100),(2,200),(3,300);

insert into detail_travaux(idtype_travaux,iddevis_maison,quantite) values
(1,1,40),
(1,2,50),
(2,2,60),
(2,3,70),
(6,1,3),
(6,2,1),
(6,3,2);


-- UPDATE DE PU dnas detail_travaux
-- UPDATE detail_travaux set prix_unitaire=
-- (SELECT type_travaux.prix_unitaire from type_travaux join detail_travaux on type_travaux.idtype_travaux=detail_travaux.idtype_travaux WHERE detail_travaux.iddetail_travaux=7),
-- montant=
-- (SELECT type_travaux.prix_unitaire*detail_travaux.quantite from type_travaux join detail_travaux on type_travaux.idtype_travaux=detail_travaux.idtype_travaux WHERE detail_travaux.iddetail_travaux=7)
-- WHERE detail_travaux.iddetail_travaux=7;

-- UPDATE devis_maison set montant_total= 
-- (SELECT sum(detail_travaux.montant) as montant from detail_travaux where detail_travaux.iddevis_maison=2)
-- WHERE devis_maison.iddevis_maison=2;


insert into devis_client(iddevis_maison,idfinition,idclient,date_debut,date)
values(1,1,1,'2024-02-01','2024-01-19');


-- update de montant sans finition etduree, pourcentage la table devis_client
UPDATE devis_client set 
    montant_sans_finition=
        (SELECT v_devis_maison_montant.montant from v_devis_maison_montant where v_devis_maison_montant.iddevis_maison=1),
    duree=
        (SELECT devis_maison.duree from devis_maison where devis_maison.iddevis_maison=1),
    pourcentage_finition=
    (SELECT finition.pourcentage from finition where finition.idfinition=1)
where devis_client.iddevis_client=1;

-- update de montant avec finition la table devis_client
UPDATE devis_client set 
montant_avec_finition=
    (SELECT ((devis_client.montant_sans_finition*devis_client.pourcentage_finition)/100)+devis_client.montant_sans_finition 
    from devis_client where devis_client.iddevis_client=1)
    where devis_client.iddevis_client=1;

-- update de date fin dans la table devis_client
UPDATE devis_client
SET date_fin = (
    SELECT (devis_client.date_debut+ devis_client.duree * INTERVAL '1 DAY')
    FROM devis_client
    WHERE devis_client.iddevis_client = 1
)
WHERE devis_client.iddevis_client = 1;

---insertion dans la table detail_devis_client
INSERT into detail_devis_client(iddevis_client,idtype_travaux, quantite,montant,prix_unitaire)
SELECT 1,v_detail_travaux.idtype_travaux,v_detail_travaux.quantite,v_detail_travaux.montant,v_detail_travaux.prix_unitaire-- remplacer 1 par iddevis du client
from v_detail_travaux 
where v_detail_travaux.iddevis_maison=1; -- 1 par iddevis_maison




--creation de view qui relie le (type_travaux + unite)
CREATE OR REPLACE VIEW v_type_travaux as
SELECT t_p.*,u.nom_unite,u.abbreviation
from type_travaux t_p
join unite u on t_p.idunite=u.idunite;

--creation de view qui relie le detail_travaux et v_type_travaux(type_trvaux+unite)
CREATE OR REPLACE VIEW v_detail_travaux as
SELECT t_p.*,d_t.iddevis_maison,d_t.quantite, d_t.quantite* t_p.prix_unitaire as montant
from detail_travaux d_t
join v_type_travaux t_p on d_t.idtype_travaux=t_p.idtype_travaux;

--creation de view qui relie le devis_maison et type_maison
CREATE or replace view  v_devis_maison as
SELECT t_m.*,d_m.duree,v_d_t.*
from devis_maison d_m
join type_maison t_m on t_m.idtype_maison=d_m.idtype_maison
join v_detail_travaux v_d_t on d_m.iddevis_maison=v_d_t.iddevis_maison;

--creation de view qui donne le montant total par devis_maison
CREATE or replace view v_devis_maison_montant as
SELECT sum(v_devis_maison.montant) as montant,v_devis_maison.iddevis_maison
from v_devis_maison group by v_devis_maison.iddevis_maison;

-- drop view v_devis_maison;
-- drop view v_detail_travaux;

--creation de view qui relie le devis_client et finition
CREATE OR REPLACE VIEW v_devis_client as
SELECT devis_client.*,f.nom_finition
from devis_client
join finition f on devis_client.idfinition=f.idfinition;


--creation de view qui relie le detail_devis_client  et type_travaux 
CREATE OR REPLACE VIEW v_detail_devis_travaux as
SELECT t_p.*,d_t.quantite, d_t.montant,d_t.iddevis_client
from detail_devis_client d_t
join v_type_travaux t_p on d_t.idtype_travaux=t_p.idtype_travaux;


-- SELECT * from v_detail_devis_travaux where iddevis_client=1;
-- view qui montre les payement fait sur un devis_client
CREATE OR REPLACE VIEW v_payement_payer as
SELECT payement_devis.iddevis_client,sum(payement_devis.montant) as montant_paye
from payement_devis
group by payement_devis.iddevis_client;

-- view qui montre l'etat de paye fait sur un devis_client
CREATE OR REPLACE VIEW v_payement_etat as
SELECT devis_client.iddevis_client,COALESCE(v_payement_payer.montant_paye,0) as montant_paye,
    (COALESCE(devis_client.montant_avec_finition,0) - COALESCE(v_payement_payer.montant_paye,0)) as reste_a_payer,
    devis_client.montant_avec_finition as montant_a_payer
from v_payement_payer
 right join devis_client on v_payement_payer.iddevis_client=devis_client.iddevis_client;

-- view qui montre l'etat de paye fait sur un devis_client avec les details du devis client
CREATE OR REPLACE VIEW v_payement_etat_devis as
SELECT v_e_d.montant_paye,v_e_d.reste_a_payer,v_e_d.montant_a_payer,v_d.*
from v_payement_etat v_e_d
right join v_devis_client v_d on v_e_d.iddevis_client=v_d.iddevis_client;


select sum(devis_client.montant_avec_finition) from devis_client;
-- select sum(devis_client.montant_avec_finition) from devis_client;

SELECT SUM(devis_client.montant_avec_finition) AS montant, EXTRACT(MONTH FROM devis_client.date) AS mois
FROM devis_client
WHERE EXTRACT(YEAR FROM devis_client.date) = 2025
GROUP BY mois;


CREATE  TABLE "public".temp_maison_travaux ( 
	type_maison          varchar  NOT NULL  ,
	description          text    ,
	surface              varchar    ,
	code_travaux         varchar    ,
	type_travaux         varchar    ,
	unite                varchar    ,
	prix_unitaire        varchar    ,
	quantite             varchar    ,
	duree_travaux        integer    
 );
CREATE  TABLE "public".temp_devis ( 
	client_numero        varchar    ,
	devis_client         varchar    ,
	type_maison          varchar    ,
	finition             varchar    ,
	taux_finition        varchar    ,
	date_devis           varchar    ,
	date_debut           varchar    ,
	lieu                 varchar    
 );
CREATE  TABLE "public".temp_paiement ( 
	devis_client         varchar    ,
	code_paiement        varchar    ,
	date_paiement        varchar    ,
	montant              varchar    
 );
INSERT INTO type_maison(nom_maison,description,surface)
SELECT t_m_t.type_maison,t_m_t.description,CAST(t_m_t.surface AS numeric) as surface
from temp_maison_travaux t_m_t 
GROUP by t_m_t.type_maison,t_m_t.description,surface;

insert into unite(nom_unite,abbreviation)
select t_m_t.unite ,t_m_t.unite
from temp_maison_travaux t_m_t
group by unite;

INSERT INTO type_travaux(code_type_travaux,nom_type_travaux,prix_unitaire,idunite)
(SELECT t_m_t.code_travaux,t_m_t.type_travaux,CAST(t_m_t.prix_unitaire AS numeric) as prix_unitaire,unite.idunite
from  temp_maison_travaux t_m_t
join unite on unite.nom_unite=t_m_t.unite
group by t_m_t.code_travaux,t_m_t.type_travaux,unite.idunite,prix_unitaire);


INSERT into devis_maison(idtype_maison,duree)
(SELECT  type_maison.idtype_maison,CAST(t_m_t.duree_travaux AS numeric) as duree
from temp_maison_travaux t_m_t
join type_maison on t_m_t.type_maison=type_maison.nom_maison
group by type_maison.idtype_maison,duree);


INSERT INTO detail_travaux(iddevis_maison,idtype_travaux,quantite)
(SELECT d_m.iddevis_maison,t_p.idtype_travaux, CAST(t_m_t.quantite AS numeric) as quantite
FROM temp_maison_travaux t_m_t
join type_travaux t_p on t_m_t.type_travaux=t_p.nom_type_travaux
join type_maison t_m on t_m_t.type_maison=t_m.nom_maison
join devis_maison d_m on t_m.idtype_maison=d_m.idtype_maison
group by  d_m.iddevis_maison,t_p.idtype_travaux,quantite
);

INSERT into finition(nom_finition,pourcentage)
SELECT temp_devis.finition,CAST(temp_devis.taux_finition AS numeric) as pourcentage
from temp_devis
group by temp_devis.finition,pourcentage;

insert into client(numero)
SELECT temp_devis.client_numero
from temp_devis
group by temp_devis.client_numero;

INSERT into devis_client(code_devis,idclient,date,date_debut,iddevis_maison,idfinition)
(SELECT t_d.devis_client,client.idclient,TO_DATE(t_d.date_devis, 'DD/MM/YYYY') as date_devis,TO_DATE(t_d.date_debut , 'DD/MM/YYYY') as date_debut,d_m.idtype_maison,f.idfinition
    from  temp_devis t_d
    join client on t_d.client_numero=client.numero
    join type_maison t_m on t_d.type_maison=t_m.nom_maison
    join devis_maison d_m on t_m.idtype_maison=d_m.idtype_maison
    join finition f on t_d.finition=f.nom_finition
    group by t_d.devis_client,client.idclient, date_devis, date_debut,d_m.idtype_maison,f.idfinition
);


insert into payement_devis(date,montant,iddevis_client,code_payement)
(SELECT TO_DATE(t_p.date_paiement, 'DD/MM/YYYY'),CAST(t_p.montant AS numeric) as montant,devis_client.iddevis_client,t_p.code_paiement
    from temp_paiement t_p 
    join devis_client on t_p.devis_client=devis_client.code_devis
    GROUP by t_p.date_paiement,devis_client.iddevis_client,montant,code_paiement);
--  truncate table temp_maison_travaux;
--   truncate table temp_devis;



UPDATE devis_client set 
    montant_sans_finition=
        (SELECT v_devis_maison_montant.montant from v_devis_maison_montant)

ALTER TABLE detail_devis_client
ALTER COLUMN nom_type_travaux TYPE varchar;


--Somme des payements effectuer sur un devis efa misy vue io
select sum(payement_devis.montant) as montant,devis_client.code_devis
from payement_devis 
join devis_client on payement_devis.iddevis_client=devis_client.iddevis_client 
group by devis_client.iddevis_client;


-- historique de payement par devis_client de plus recent 
Select p.montant,p.date
from payement_devis p
where p.iddevis_client=1
ORDER by p.date desc;

insert into payement_devis(date,montant,iddevis_client,code_payement)
            (SELECT TO_DATE(t_p.date_paiement, 'DD/MM/YYYY'),CAST(t_p.montant AS numeric) as montant,devis_client.iddevis_client,temp.code_payement
                from temp_paiement t_p
                join devis_client on t_p.devis_client=devis_client.code_devis
                left join v_temp_paiement temp on temp.code_payement=t_p.code_paiement
                GROUP by t_p.date_paiement,devis_client.iddevis_client,montant,code_payement)

CREATE VIEW v_temp_paiement as
Select payement_devis.code_payement from payement_devis

create table temp(code_paiement varchar);