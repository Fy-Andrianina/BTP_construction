@REM @echo off
SET PGPASSWORD=postgres
echo Paramètre passé au fichier .bat : %1
psql -U postgres -d btp_3 -f "%1"
@REM pause
