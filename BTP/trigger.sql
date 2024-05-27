
-------------------------CODE DE la table maison;
-- CREATE OR REPLACE FUNCTION update_type_maison()
-- RETURNS TRIGGER AS $$
-- BEGIN
--     -- Définir la nouvelle valeur pour la colonne code_type_maison
--     NEW.code_type_maison := 'MA' || NEW.id;

--     -- Mettre à jour la dernière ligne insérée
--     UPDATE type_maison
--     SET code_type_maison = NEW.code_type_maison
--     WHERE id = NEW.id;

--     RETURN NEW;
-- END;
-- $$ LANGUAGE plpgsql;

-- -- Créer le trigger
-- CREATE TRIGGER insert_trigger
-- AFTER INSERT ON type_maison
-- FOR EACH ROW EXECUTE FUNCTION update_type_maison();




CREATE OR REPLACE FUNCTION update_code_table(colonne_a_updater TEXT, prefix TEXT, table_prefix TEXT, id_column TEXT)
RETURNS TRIGGER AS $$
BEGIN
    -- Définir la nouvelle valeur pour la colonne spécifiée
    EXECUTE 'UPDATE ' || table_prefix || ' SET ' || colonne_a_updater || ' = ''' || prefix || ''' || $1.' || colonne_a_updater || ' WHERE ' || id_column || ' = $1.' || id_column USING NEW;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Créer le trigger
CREATE TRIGGER insert_trigger
AFTER INSERT ON table
FOR EACH ROW EXECUTE FUNCTION update_code_table('code_type_maison', 'MA', 'type_maison', 'id_maison');


-- DROP FUNCTION IF EXISTS update_type_maison(TEXT, TEXT, TEXT);
-- DROP TRIGGER IF EXISTS insert_trigger ON type_maison;
