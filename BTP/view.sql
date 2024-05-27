CREATE SEQUENCE "public".client_idclient_seq START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".detail_devis_client_iddetail_devis_seq START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".detail_travaux_iddetail_travaux_seq START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".devis_client_iddevis_client_seq START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".devis_maison_iddevis_maison_seq START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".finition_idfinition_seq START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".lieu_idlieu_seq START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".payement_devis_idpayement_seq START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".type_maison_idtype_maison_seq START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".type_travaux_idtype_travaux_seq START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".unite_abbreviation_seq START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".unite_idunite_seq START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".unite_num_unite_seq START WITH 1 INCREMENT BY 1;

CREATE SEQUENCE "public".utilisateur_idutilisateur_seq START WITH 1 INCREMENT BY 1;

CREATE  TABLE "public".client ( 
	idclient             integer DEFAULT nextval('client_idclient_seq'::regclass) NOT NULL  ,
	numero               varchar    ,
	code_client          varchar    ,
	CONSTRAINT pk_client PRIMARY KEY ( idclient )
 );

CREATE  TABLE "public".error_import ( 
	ligne                integer    ,
	error                integer    
 );

CREATE  TABLE "public".finition ( 
	idfinition           integer DEFAULT nextval('finition_idfinition_seq'::regclass) NOT NULL  ,
	nom_finition         varchar    ,
	pourcentage          numeric    ,
	code_finition        varchar    ,
	CONSTRAINT pk_finition PRIMARY KEY ( idfinition )
 );

CREATE  TABLE "public".lieu ( 
	idlieu               integer DEFAULT nextval('lieu_idlieu_seq'::regclass) NOT NULL  ,
	nom_lieu             varchar(30)    ,
	CONSTRAINT pk_lieu PRIMARY KEY ( idlieu )
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

CREATE  TABLE "public".temp_paiement ( 
	devis_client         varchar    ,
	code_paiement        varchar    ,
	date_paiement        varchar    ,
	montant              varchar    
 );

CREATE  TABLE "public".type_maison ( 
	idtype_maison        integer DEFAULT nextval('type_maison_idtype_maison_seq'::regclass) NOT NULL  ,
	nom_maison           varchar(30)    ,
	description          text    ,
	code_type_maison     varchar    ,
	surface              numeric    ,
	CONSTRAINT pk_type_maison PRIMARY KEY ( idtype_maison )
 );

CREATE  TABLE "public".unite ( 
	idunite              integer DEFAULT nextval('unite_idunite_seq'::regclass) NOT NULL  ,
	nom_unite            varchar  NOT NULL  ,
	abbreviation         varchar  NOT NULL  ,
	CONSTRAINT pk_unite PRIMARY KEY ( idunite )
 );

CREATE  TABLE "public".utilisateur ( 
	idutilisateur        integer DEFAULT nextval('utilisateur_idutilisateur_seq'::regclass) NOT NULL  ,
	nom                  varchar(30)    ,
	prenom               varchar(30)    ,
	sexe                 integer    ,
	email                varchar    ,
	"password"           text    ,
	"admin"              integer DEFAULT 0   ,
	dtn                  date    ,
	CONSTRAINT pk_utilisateur PRIMARY KEY ( idutilisateur )
 );

CREATE  TABLE "public".devis_maison ( 
	iddevis_maison       integer DEFAULT nextval('devis_maison_iddevis_maison_seq'::regclass) NOT NULL  ,
	idtype_maison        integer    ,
	duree                integer    ,
	CONSTRAINT pk_devis_maison PRIMARY KEY ( iddevis_maison ),
	CONSTRAINT fk_devis_maison_client FOREIGN KEY ( idtype_maison ) REFERENCES "public".type_maison( idtype_maison )   
 );

CREATE  TABLE "public".type_travaux ( 
	idtype_travaux       integer DEFAULT nextval('type_travaux_idtype_travaux_seq'::regclass) NOT NULL  ,
	nom_type_travaux     varchar    ,
	prix_unitaire        numeric    ,
	idunite              integer    ,
	code_type_travaux    varchar    ,
	CONSTRAINT pk_type_travaux PRIMARY KEY ( idtype_travaux ),
	CONSTRAINT fk_type_travaux_unite FOREIGN KEY ( idunite ) REFERENCES "public".unite( idunite )   
 );

CREATE  TABLE "public".detail_travaux ( 
	iddetail_travaux     integer DEFAULT nextval('detail_travaux_iddetail_travaux_seq'::regclass) NOT NULL  ,
	idtype_travaux       integer    ,
	iddevis_maison       integer    ,
	quantite             numeric    ,
	CONSTRAINT pk_detail_travaux PRIMARY KEY ( iddetail_travaux ),
	CONSTRAINT fk_detail_travaux_devis_maison FOREIGN KEY ( iddevis_maison ) REFERENCES "public".devis_maison( iddevis_maison )   ,
	CONSTRAINT fk_detail_travaux_type_travaux FOREIGN KEY ( idtype_travaux ) REFERENCES "public".type_travaux( idtype_travaux )   
 );

CREATE  TABLE "public".devis_client ( 
	iddevis_client       integer DEFAULT nextval('devis_client_iddevis_client_seq'::regclass) NOT NULL  ,
	iddevis_maison       integer    ,
	idclient             integer    ,
	idfinition           integer    ,
	montant_sans_finition numeric    ,
	montant_avec_finition numeric    ,
	date_debut           date    ,
	date_fin             date    ,
	pourcentage_finition integer    ,
	duree                integer    ,
	"date"               date    ,
	idlieu               integer    ,
	code_devis           varchar    ,
	CONSTRAINT pk_devis_client PRIMARY KEY ( iddevis_client ),
	CONSTRAINT fk_devis_client_client FOREIGN KEY ( idclient ) REFERENCES "public".client( idclient )   ,
	CONSTRAINT fk_devis_client_devis_maison FOREIGN KEY ( iddevis_maison ) REFERENCES "public".devis_maison( iddevis_maison )   ,
	CONSTRAINT fk_devis_client_finition FOREIGN KEY ( idfinition ) REFERENCES "public".finition( idfinition )   ,
	CONSTRAINT fk_devis_client_lieu FOREIGN KEY ( idlieu ) REFERENCES "public".lieu( idlieu )   
 );

CREATE  TABLE "public".payement_devis ( 
	idpayement           integer DEFAULT nextval('payement_devis_idpayement_seq'::regclass) NOT NULL  ,
	"date"               date    ,
	montant              numeric    ,
	iddevis_client       integer    ,
	code_payement        varchar    ,
	CONSTRAINT pk_payement_devis PRIMARY KEY ( idpayement ),
	CONSTRAINT fk_payement_devis_devis_client FOREIGN KEY ( iddevis_client ) REFERENCES "public".devis_client( iddevis_client )   
 );

CREATE  TABLE "public".detail_devis_client ( 
	iddetail_devis       integer DEFAULT nextval('detail_devis_client_iddetail_devis_seq'::regclass) NOT NULL  ,
	iddevis_client       integer    ,
	idtype_travaux       integer    ,
	quantite             numeric    ,
	montant              numeric    ,
	prix_unitaire        numeric    ,
	nom_type_travaux     varchar(30)    ,
	CONSTRAINT pk_detail_devis_client PRIMARY KEY ( iddetail_devis ),
	CONSTRAINT fk_detail_devis_client FOREIGN KEY ( iddevis_client ) REFERENCES "public".devis_client( iddevis_client )   ,
	CONSTRAINT fk_detail_devis_client_travaux FOREIGN KEY ( idtype_travaux ) REFERENCES "public".type_travaux( idtype_travaux )   
 );

CREATE VIEW "public".v_detail_devis_travaux AS  SELECT t_p.idtype_travaux,
    d_t.nom_type_travaux,
    t_p.prix_unitaire,
    t_p.idunite,
    t_p.nom_unite,
    t_p.abbreviation,
    d_t.quantite,
    d_t.montant,
    d_t.iddevis_client
   FROM (detail_devis_client d_t
     JOIN v_type_travaux t_p ON ((d_t.idtype_travaux = t_p.idtype_travaux)));

CREATE VIEW "public".v_detail_travaux AS  SELECT t_p.idtype_travaux,
    t_p.nom_type_travaux,
    t_p.prix_unitaire,
    t_p.idunite,
    t_p.nom_unite,
    t_p.abbreviation,
    d_t.iddevis_maison,
    d_t.quantite,
    (d_t.quantite * t_p.prix_unitaire) AS montant
   FROM (detail_travaux d_t
     JOIN v_type_travaux t_p ON ((d_t.idtype_travaux = t_p.idtype_travaux)));

CREATE VIEW "public".v_devis_client AS  SELECT devis_client.iddevis_client,
    devis_client.iddevis_maison,
    devis_client.idclient,
    devis_client.idfinition,
    devis_client.montant_sans_finition,
    devis_client.montant_avec_finition,
    devis_client.date_debut,
    devis_client.date_fin,
    devis_client.pourcentage_finition,
    devis_client.duree,
    devis_client.date,
    f.nom_finition
   FROM (devis_client
     JOIN finition f ON ((devis_client.idfinition = f.idfinition)));

CREATE VIEW "public".v_devis_maison AS  SELECT t_m.idtype_maison,
    t_m.nom_maison,
    t_m.description,
    t_m.code_type_maison,
    t_m.surface,
    d_m.duree,
    v_d_t.idtype_travaux,
    v_d_t.nom_type_travaux,
    v_d_t.prix_unitaire,
    v_d_t.idunite,
    v_d_t.nom_unite,
    v_d_t.abbreviation,
    v_d_t.iddevis_maison,
    v_d_t.quantite,
    v_d_t.montant
   FROM ((devis_maison d_m
     JOIN type_maison t_m ON ((t_m.idtype_maison = d_m.idtype_maison)))
     JOIN v_detail_travaux v_d_t ON ((d_m.iddevis_maison = v_d_t.iddevis_maison)));

CREATE VIEW "public".v_devis_maison_montant AS  SELECT sum(v_devis_maison.montant) AS montant,
    v_devis_maison.iddevis_maison
   FROM v_devis_maison
  GROUP BY v_devis_maison.iddevis_maison;

CREATE VIEW "public".v_payement_etat AS  SELECT devis_client.iddevis_client,
    COALESCE(v_payement_payer.montant_paye, (0)::numeric) AS montant_paye,
    (COALESCE(devis_client.montant_avec_finition, (0)::numeric) - COALESCE(v_payement_payer.montant_paye, (0)::numeric)) AS reste_a_payer,
    devis_client.montant_avec_finition AS montant_a_payer
   FROM (v_payement_payer
     RIGHT JOIN devis_client ON ((v_payement_payer.iddevis_client = devis_client.iddevis_client)));

CREATE VIEW "public".v_payement_etat_devis AS  SELECT v_e_d.montant_paye,
    v_e_d.reste_a_payer,
    v_e_d.montant_a_payer,
    v_d.iddevis_client,
    v_d.iddevis_maison,
    v_d.idclient,
    v_d.idfinition,
    v_d.montant_sans_finition,
    v_d.montant_avec_finition,
    v_d.date_debut,
    v_d.date_fin,
    v_d.pourcentage_finition,
    v_d.duree,
    v_d.date,
    v_d.nom_finition
   FROM (v_payement_etat v_e_d
     RIGHT JOIN v_devis_client v_d ON ((v_e_d.iddevis_client = v_d.iddevis_client)));

CREATE VIEW "public".v_payement_payer AS  SELECT payement_devis.iddevis_client,
    sum(payement_devis.montant) AS montant_paye
   FROM payement_devis
  GROUP BY payement_devis.iddevis_client;

CREATE VIEW "public".v_type_travaux AS  SELECT t_p.idtype_travaux,
    t_p.nom_type_travaux,
    t_p.prix_unitaire,
    t_p.idunite,
    u.nom_unite,
    u.abbreviation
   FROM (type_travaux t_p
     JOIN unite u ON ((t_p.idunite = u.idunite)));

COMMENT ON TABLE "public".detail_devis_client IS 'detail des travaux ( equivalent a detail_travaux) qui definit';

COMMENT ON VIEW "public".v_devis_client IS 'qui met en relation devis_client et finition';

COMMENT ON VIEW "public".v_type_travaux IS 'type_travaux et unite';
