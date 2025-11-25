-- Table: tblic

-- DROP TABLE tblic;

CREATE TABLE tblic
(
  tblic_id_pk id NOT NULL,
  tblic_tbana_id id,
  tblic_tp char(2),
  tblic_cd varchar(100),
  tblic_figlio boolean DEFAULT false,
  tblic_padre_tblic_id id,
  tblic_natura char(2),
  tblic_postazioni smallint DEFAULT 1, 
  tblic_desc descrizione,
  tblic_versione character varying(10), 
  tblic_verstest character varying(10),
  tblic_server character varying(50), 
  tblic_nodo character varying(100),  
  tblic_ambiente character varying(50),    
  tblic_invii smallint DEFAULT 0, 
  tblic_giga numeric(5,0) DEFAULT 0, 
  tblic_conn character varying(50), 
  tblic_note character varying(200), x

  tblic_dt_agg data,  
  tblic_stato boolean DEFAULT true,
  tblic_dtvar data,
  tblic_tyute_id id,
  tblic_tyazi_id id,
  tblic_tbdep_id id,

  CONSTRAINT pk_tblic PRIMARY KEY (tblic_id_pk),
  CONSTRAINT tblic_tbana_id FOREIGN KEY (tblic_tbana_id)
      REFERENCES tbana (tbana_id_pk) MATCH FULL
      ON UPDATE CASCADE ON DELETE RESTRICT

)
WITH (
  OIDS=FALSE
);
ALTER TABLE tblic
  OWNER TO nrgmaster;
GRANT ALL ON TABLE tblic TO nrgmaster;
GRANT ALL ON TABLE tblic TO gnrgmaster;
GRANT SELECT, UPDATE, INSERT, DELETE ON TABLE tblic TO gnrguser;
GRANT SELECT ON TABLE tblic TO gnrgguest;
COMMENT ON TABLE tblic
  IS 'LICENZE';
COMMENT ON COLUMN tblic.tblic_cd IS 'Codice Licenza';
COMMENT ON COLUMN tblic.tblic_figlio IS 'Licenza subordinata (sottoditte con stessa licenza es. Siron - Castello)';
COMMENT ON COLUMN tblic.tblic_padre_tblic_id IS 'ID della licenza padre, in monoazienda = se stessa ossia tblic_id_pk';
COMMENT ON COLUMN tblic.tblic_conn IS 'Stringhe di connessione';
COMMENT ON COLUMN tblic.tblic_server IS 'Server di connessione';
COMMENT ON COLUMN tblic.tblic_nodo IS 'Nodo di connessione';
COMMENT ON COLUMN tblic.tblic_ambiente IS 'Descrione ambiente della licenza (es. TEST, DITTA)';
COMMENT ON COLUMN tblic.tblic_invii IS 'Numero invii acquistati';
COMMENT ON COLUMN tblic.tblic_tp IS 'Caratteri identificativi licenza (es. SI Sigla, VA Varhub, SK Sknt)';
COMMENT ON COLUMN tblic.tblic_natura IS 'Carattere identificativo del tipo licenza (es. S Start U Ultimante C Cloud vuoto Tipologia Unica)';
COMMENT ON COLUMN tblic.tblic_dt_agg IS 'Data aggiornamento o scadenza';
COMMENT ON COLUMN tblic.tblic_postazioni IS 'Numero postazioni con licenza';
COMMENT ON COLUMN tblic.tblic_versione IS 'Versione operativa';
COMMENT ON COLUMN tblic.tblic_verstest IS 'Versione ambiente di test';

CREATE SEQUENCE s_tblic_id
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 3
  CACHE 1;
ALTER TABLE s_tblic_id
  OWNER TO nrgmaster;
GRANT ALL ON TABLE s_tblic_id TO nrgmaster;
GRANT ALL ON TABLE s_tblic_id TO gnrgmaster;
GRANT SELECT, UPDATE ON TABLE s_tblic_id TO gnrguser;
GRANT SELECT ON TABLE s_tblic_id TO gnrgguest;

;

