<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class ImportModel extends CI_Model
{
    public function initialiser_table_erreur($table_erreur){
        $sql_2="TRUNCATE table $table_erreur";
       
        $this->db->query($sql_2);

    }
    public function initialiser_table($nom_sequence,$table_erreur){
        $sql_1="ALTER sequence $nom_sequence restart with 1";
        $sql_2="TRUNCATE table $table_erreur";
        $this->db->query($sql_1);
        $this->db->query($sql_2);

    }
    public function insert_all_devis_maison_travaux()
    {
        try {
            $this->db->trans_start(); // Démarre la transaction
            $this->insert_Type_Maison();
            $this->insert_Unite();
            $this->insert_lieu();
            $this->insert_Type_Travaux();
            $this->insert_devis_Maison();
            $this->insert_detail_Travaux();

            $this->insert_Finition();
            $this->insert_Client();
            $this->insert_Devis_client();

            // Si une erreur se produit, effectuez un rollback
            if ($erreur) {
                $this->db->trans_rollback(); // Annule la transaction
                throw new Exception('Une erreur s\'est produite. La transaction a été annulée.');
            } else {
                $this->db->trans_complete(); // Valide la transaction
                echo 'Transaction terminée avec succès.';
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function insert_Type_Maison()
    {
        $sql = "INSERT INTO type_maison(nom_maison,description,surface)
        SELECT t_m_t.type_maison,t_m_t.description,CAST(t_m_t.surface AS numeric) as surface
        from temp_maison_travaux t_m_t 
        GROUP by t_m_t.type_maison,t_m_t.description,surface";
        $this->db->query($sql);
    }
    public function insert_Unite()
    {
        $sql = "insert into unite(nom_unite,abbreviation)
        select t_m_t.unite ,t_m_t.unite
        from temp_maison_travaux t_m_t
        group by unite";
        $this->db->query($sql);
    }

    public function insert_Type_Travaux()
    {
        $sql = "INSERT INTO type_travaux(code_type_travaux,nom_type_travaux,prix_unitaire,idunite)
        (SELECT t_m_t.code_travaux,t_m_t.type_travaux,CAST(t_m_t.prix_unitaire AS numeric) as prix_unitaire,unite.idunite
        from  temp_maison_travaux t_m_t
        join unite on unite.nom_unite=t_m_t.unite
        group by t_m_t.code_travaux,t_m_t.type_travaux,unite.idunite,prix_unitaire)";
        $this->db->query($sql);
    }
    public function insert_devis_Maison()
    {
        $sql = "INSERT into devis_maison(idtype_maison,duree)
            (SELECT  type_maison.idtype_maison,CAST(t_m_t.duree_travaux AS numeric) as duree
            from temp_maison_travaux t_m_t
            join type_maison on t_m_t.type_maison=type_maison.nom_maison
            group by type_maison.idtype_maison,duree)";
        $this->db->query($sql);
    }

    public function insert_detail_Travaux()
    {
        $sql = "INSERT INTO detail_travaux(iddevis_maison,idtype_travaux,quantite)
            (SELECT d_m.iddevis_maison,t_p.idtype_travaux, CAST(t_m_t.quantite AS numeric) as quantite
            FROM temp_maison_travaux t_m_t
            join type_travaux t_p on t_m_t.type_travaux=t_p.nom_type_travaux
            join type_maison t_m on t_m_t.type_maison=t_m.nom_maison
            join devis_maison d_m on t_m.idtype_maison=d_m.idtype_maison
            group by  d_m.iddevis_maison,t_p.idtype_travaux,quantite
            )";
        $this->db->query($sql);
    }
    public function insert_Finition()
    {
        $sql = "INSERT into finition(nom_finition,pourcentage)
            SELECT temp_devis.finition,CAST(temp_devis.taux_finition AS numeric) as pourcentage
            from temp_devis
            group by temp_devis.finition,pourcentage";
        $this->db->query($sql);
    }
    public function insert_Client()
    {
        $sql = "insert into client(numero)
            SELECT temp_devis.client_numero
            from temp_devis
            group by temp_devis.client_numero";
        $this->db->query($sql);
    }
    public function insert_Devis_client()
    {
        $sql = "INSERT into devis_client(code_devis,idclient,date,date_debut,iddevis_maison,idfinition,idlieu)
                    (SELECT t_d.devis_client,client.idclient,TO_DATE(t_d.date_devis, 'DD/MM/YYYY') as date_devis,TO_DATE(t_d.date_debut , 'DD/MM/YYYY') as date_debut,d_m.iddevis_maison,f.idfinition,l.idlieu
                        from  temp_devis t_d
                        join client on t_d.client_numero=client.numero
                        join type_maison t_m on t_d.type_maison=t_m.nom_maison
                        join devis_maison d_m on t_m.idtype_maison=d_m.idtype_maison
                        join finition f on t_d.finition=f.nom_finition
                        join lieu l on t_d.lieu=l.nom_lieu
                        group by t_d.devis_client,client.idclient, date_devis, date_debut,d_m.iddevis_maison,f.idfinition,l.idlieu
                    )";

        $this->db->query($sql);
        $this->update_table_devis_client();
    }
    public function insert_Payement()
    {
        $this->load->helper("my_query");
        $sql1="SELECT TO_DATE(t_p.date_paiement, 'DD/MM/YYYY'),CAST(t_p.montant AS numeric) as montant,devis_client.iddevis_client,t_p.code_paiement
                 from temp_paiement t_p 
                join devis_client on t_p.devis_client=devis_client.code_devis
                GROUP by t_p.date_paiement,devis_client.iddevis_client,montant,code_paiement";

        $query=$this->db->query($sql1);
        $result=fetch_array($query);
        foreach($result as $r){
            $temp="INSERT INTO payement_devis (date, montant, iddevis_client, code_payement)
                    SELECT ?, ?, ?, ?
                    WHERE NOT EXISTS (
                        SELECT 1 FROM payement_devis WHERE code_payement like '%".$r['code_paiement']."%'
                    )";
            
            $this->db->query($temp,$r);
        }
        //qui ne se souci pas de doublons
        // $sql = "insert into payement_devis(date,montant,iddevis_client,code_payement)
        //     (SELECT TO_DATE(t_p.date_paiement, 'DD/MM/YYYY'),CAST(t_p.montant AS numeric) as montant,devis_client.iddevis_client,t_p.code_paiement
        //         from temp_paiement t_p 
        //         join devis_client on t_p.devis_client=devis_client.code_devis
        //         GROUP by t_p.date_paiement,devis_client.iddevis_client,montant,code_paiement)";
        // $this->db->query($sql);

    
    }
    public function insert_lieu()
    {
        $sql = "insert into lieu(nom_lieu)
            SELECT temp_devis.lieu
            from temp_devis
            group by temp_devis.lieu";
        $this->db->query($sql);
    }
    // A excecuter apres insertion gloabale dans les tables devis_client
    public function update_table_devis_client()
    {
        $this->update_montant_sans_finition();
        $this->update_duree();
        $this->update_finition();
        $this->update_date_fin();
        $this->update_montant_avec_finition();
        $this->insert_detail_devis_client();
    }
    public function update_montant_sans_finition()
    {
        $sql = "UPDATE devis_client 
                SET montant_sans_finition = (
                    SELECT v_devis_maison_montant.montant 
                    FROM v_devis_maison_montant
                    WHERE v_devis_maison_montant.iddevis_maison = devis_client.iddevis_maison
                )";

        // Exécuter la requête
        $this->db->query($sql);
    }
    public function update_duree()
    {
        $sql = "UPDATE devis_client 
                SET duree = (
                    SELECT devis_maison.duree
                    FROM devis_maison 
                    WHERE devis_maison.iddevis_maison = devis_client.iddevis_maison
                )";

        // Exécuter la requête
        $this->db->query($sql);
    }
    public function update_finition()
    {
        $sql = "UPDATE devis_client 
                SET pourcentage_finition = (
                    SELECT finition.pourcentage
                    FROM finition
                    WHERE devis_client.idfinition = finition.idfinition
                )";

        // Exécuter la requête
        $this->db->query($sql);
    }
    public function update_montant_avec_finition()
    {
        $sql = "UPDATE devis_client 
        SET montant_avec_finition = 
           ( (devis_client.montant_sans_finition * devis_client.pourcentage_finition)/100) + devis_client.montant_sans_finition ";
        $this->db->query($sql);
    }
    public function update_date_fin()
    {
        $sql = "UPDATE devis_client
        SET date_fin = 
             (devis_client.date_debut+ devis_client.duree * INTERVAL '1 DAY') ";
        $this->db->query($sql);
    }
    public function insert_detail_devis_client()
    {
        $sql = "INSERT INTO detail_devis_client (iddevis_client, idtype_travaux, quantite, montant, prix_unitaire,nom_type_travaux)
        SELECT dc.iddevis_client, vdt.idtype_travaux, vdt.quantite, vdt.montant, vdt.prix_unitaire,vdt.nom_type_travaux
        FROM v_detail_travaux vdt
        JOIN devis_client dc ON vdt.iddevis_maison = dc.iddevis_maison";
        $this->db->query($sql);
    }
}
