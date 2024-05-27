DO $$ DECLARE
    r RECORD;
BEGIN
    FOR r IN (SELECT constraint_name, table_name
              FROM information_schema.table_constraints
              WHERE constraint_type = 'FOREIGN KEY') 
    LOOP
        EXECUTE 'ALTER TABLE ' || quote_ident(r.table_name) || ' DROP CONSTRAINT ' || quote_ident(r.constraint_name);
    END LOOP;
END $$;