
ALTER sequence "public".client_idclient_seq restart with 1;

ALTER sequence "public".detail_devis_client_iddetail_devis_seq restart with 1;

ALTER sequence "public".detail_travaux_iddetail_travaux_seq restart with 1;

ALTER sequence "public".devis_client_iddevis_client_seq restart with 1;

ALTER sequence "public".devis_maison_iddevis_maison_seq restart with 1;

ALTER sequence "public".finition_idfinition_seq restart with 1;

ALTER sequence "public".lieu_idlieu_seq restart with 1;

ALTER sequence "public".payement_devis_idpayement_seq restart with 1;

ALTER sequence "public".temp_maison_travaux_id_seq restart with 1;

ALTER sequence "public".temp_paiement_id_seq restart with 1;

ALTER sequence "public".type_maison_idtype_maison_seq restart with 1;

ALTER sequence "public".type_travaux_idtype_travaux_seq restart with 1;

ALTER sequence "public".unite_abbreviation_seq restart with 1;

ALTER sequence "public".unite_idunite_seq restart with 1;

ALTER sequence "public".unite_num_unite_seq restart with 1;





TRUNCATE table client;
TRUNCATE table devis_client;
TRUNCATE table detail_devis_client;
TRUNCATE table finition;
TRUNCATE table payement_devis;

TRUNCATE TABLE detail_travaux;
TRUNCATE table type_travaux;
TRUNCATE table type_maison;
TRUNCATE table devis_maison;
TRUNCATE table unite;


