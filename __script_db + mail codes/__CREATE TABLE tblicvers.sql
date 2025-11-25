-- Table: tblicvers

-- DROP TABLE tblicversvers;

CREATE TABLE tblicvers
(
  tblicvers_id_pk id NOT NULL,
  tblicvers_release char(5), 
  tblicvers_tblic_tp character(2),
  --tblicvers_desc descrizione,
  tblicvers_versione character varying(10),
  tblicvers_note character varying(300),
  tblicvers_dt_agg data,  
  tblicvers_stato boolean DEFAULT true,
  tblicvers_dtvar data,
  tblicvers_tyute_id id,
  tblicvers_tyazi_id id,
  tblicvers_tbdep_id id,

  CONSTRAINT pk_tblicvers PRIMARY KEY (tblicvers_id_pk)



)
WITH (
  OIDS=FALSE
);
ALTER TABLE tblicvers
  OWNER TO nrgmaster;
GRANT ALL ON TABLE tblicvers TO nrgmaster;
GRANT ALL ON TABLE tblicvers TO gnrgmaster;
GRANT SELECT, UPDATE, INSERT, DELETE ON TABLE tblicvers TO gnrguser;
GRANT SELECT ON TABLE tblicvers TO gnrgguest;
COMMENT ON TABLE tblicvers
  IS 'VERSIONI RILASCIATE';

COMMENT ON COLUMN tblicvers.tblicvers_tblic_tp IS 'Tipologia Licenza uguale a tblic_tp (SI, VA, SK)';
COMMENT ON COLUMN tblicvers.tblicvers_versione IS 'Versione rilasciata';
COMMENT ON COLUMN tblicvers.tblicvers_dt_agg IS 'Data Rilascio';
COMMENT ON COLUMN tblicvers.tblicvers_note IS 'Note di versione';

CREATE SEQUENCE s_tblicvers_id
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 3
  CACHE 1;
ALTER TABLE s_tblicvers_id
  OWNER TO nrgmaster;
GRANT ALL ON TABLE s_tblicvers_id TO nrgmaster;
GRANT ALL ON TABLE s_tblicvers_id TO gnrgmaster;
GRANT SELECT, UPDATE ON TABLE s_tblicvers_id TO gnrguser;
GRANT SELECT ON TABLE s_tblicvers_id TO gnrgguest;

;

