
DO $$ DECLARE
    r RECORD;
BEGIN
    FOR r IN (SELECT constraint_name, table_name
              FROM information_schema.table_constraints
              WHERE constraint_type = 'FOREIGN KEY') 
    LOOP
        EXECUTE 'ALTER TABLE ' || quote_ident(r.table_name) || ' ADD CONSTRAINT ' || quote_ident(r.constraint_name) || ' FOREIGN KEY (' || pg_get_constraintdef(pg_constraint.oid) || ')';
    END LOOP;
END $$;