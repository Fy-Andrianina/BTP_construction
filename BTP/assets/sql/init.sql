ALTER sequence "public".client_idclient_seq restart with 1;

ALTER sequence "public".detail_devis_client_iddetail_devis_seq restart with 1;

ALTER sequence "public".detail_travaux_iddetail_travaux_seq restart with 1;

ALTER sequence "public".devis_client_iddevis_client_seq restart with 2;

ALTER sequence "public".devis_maison_iddevis_maison_seq restart with 1;

ALTER sequence "public".finition_idfinition_seq restart with 1;

ALTER sequence "public".payement_devis_idpayement_seq restart with 1;

ALTER sequence "public".type_maison_idtype_maison_seq restart with 4;

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
TRUNCATE table lieu;
TRUNCATE table payement_devis;
TRUNCATE table unite;
TRUNCATE table temp_devis;
TRUNCATE table temp_maison_travaux;
TRUNCATE table temp_paiement;
TRUNCATE table error_import;


ALTER TABLE "public".detail_devis_client ADD CONSTRAINT fk_detail_devis_client FOREIGN KEY ( iddevis_client ) REFERENCES "public".devis_client( iddevis_client );

ALTER TABLE "public".detail_devis_client ADD CONSTRAINT fk_detail_devis_client_travaux FOREIGN KEY ( idtype_travaux ) REFERENCES "public".type_travaux( idtype_travaux );

ALTER TABLE "public".detail_travaux ADD CONSTRAINT fk_detail_travaux_devis_maison FOREIGN KEY ( iddevis_maison ) REFERENCES "public".devis_maison( iddevis_maison );

ALTER TABLE "public".detail_travaux ADD CONSTRAINT fk_detail_travaux_type_travaux FOREIGN KEY ( idtype_travaux ) REFERENCES "public".type_travaux( idtype_travaux );

ALTER TABLE "public".devis_client ADD CONSTRAINT fk_devis_client_client FOREIGN KEY ( idclient ) REFERENCES "public".client( idclient );

ALTER TABLE "public".devis_client ADD CONSTRAINT fk_devis_client_devis_maison FOREIGN KEY ( iddevis_maison ) REFERENCES "public".devis_maison( iddevis_maison );

ALTER TABLE "public".devis_client ADD CONSTRAINT fk_devis_client_finition FOREIGN KEY ( idfinition ) REFERENCES "public".finition( idfinition );

ALTER TABLE "public".devis_client ADD CONSTRAINT fk_devis_client_lieu FOREIGN KEY ( idlieu ) REFERENCES "public".lieu( idlieu );

ALTER TABLE "public".devis_maison ADD CONSTRAINT fk_devis_maison_client FOREIGN KEY ( idtype_maison ) REFERENCES "public".type_maison( idtype_maison );

ALTER TABLE "public".payement_devis ADD CONSTRAINT fk_payement_devis_devis_client FOREIGN KEY ( iddevis_client ) REFERENCES "public".devis_client( iddevis_client );

ALTER TABLE "public".type_travaux ADD CONSTRAINT fk_type_travaux_unite FOREIGN KEY ( idunite ) REFERENCES "public".unite( idunite );



