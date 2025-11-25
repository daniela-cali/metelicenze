-- Table: tblic

-- DROP TABLE tblic;

CREATE TABLE tblicagg
(
  tblicagg_id_pk id NOT NULL,
  tblicagg_tblic_id id,

  tblicagg_versione character varying(10),
  tblicagg_tblicvers_id id,
  --tblic_verstest character varying(10),
  --tblic_server character varying(50),
  --tblic_nodo character varying(100),    
  --tblic_ambiente character varying(50),     
  --tblic_conn character varying(50),

  tblicagg_note character varying(200),
  tblicagg_dt_agg data,  
  tblicagg_stato boolean DEFAULT true,
  tblicagg_dtvar data,
  tblicagg_tyute_id id,
  tblicagg_tyazi_id id,
  tblicagg_tbdep_id id,

  CONSTRAINT pk_tblicagg PRIMARY KEY (tblicagg_id_pk),
  CONSTRAINT tblicagg_tblic_id FOREIGN KEY (tblicagg_tblic_id)
      REFERENCES tblic (tblic_id_pk) MATCH FULL
      ON UPDATE CASCADE ON DELETE RESTRICT

)
WITH (
  OIDS=FALSE
);
ALTER TABLE tblicagg
  OWNER TO nrgmaster;
GRANT ALL ON TABLE tblicagg TO nrgmaster;
GRANT ALL ON TABLE tblicagg TO gnrgmaster;
GRANT SELECT, UPDATE, INSERT, DELETE ON TABLE tblic TO gnrguser;
GRANT SELECT ON TABLE tblicagg TO gnrgguest;
COMMENT ON TABLE tblicagg
  IS 'AGGIORNAMENTI LICENZE';



COMMENT ON COLUMN tblicagg.tblicagg_versione IS 'Versione installata';
COMMENT ON COLUMN tblicagg.tblicagg_tblicvers_id IS 'Collegamento ai dettagli versione';
COMMENT ON COLUMN tblicagg.tblicagg_note IS 'Eventuali note di aggiornamento';
COMMENT ON COLUMN tblicagg.tblicagg_dt_agg IS 'Data esecuzione aggiornamento';

CREATE SEQUENCE s_tblicagg_id
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 3
  CACHE 1;
ALTER TABLE s_tblicagg_id
  OWNER TO nrgmaster;
GRANT ALL ON TABLE s_tblicagg_id TO nrgmaster;
GRANT ALL ON TABLE s_tblicagg_id TO gnrgmaster;
GRANT SELECT, UPDATE ON TABLE s_tblicagg_id TO gnrguser;
GRANT SELECT ON TABLE s_tblicagg_id TO gnrgguest;

;

