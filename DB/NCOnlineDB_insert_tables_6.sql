CREATE TABLE mto.Test
(
  formID INT NOT NULL AUTO_INCREMENT,
  Programmer VARCHAR(255) NULL,
  Assy VARCHAR(25) NULL,
  Model VARCHAR(20) NULL,
  FWC VARCHAR(6) NULL,
  Media VARCHAR(25) NULL,
  Program_number VARCHAR(35) NULL,
  Used_to_make VARCHAR(255) NULL,
  Program_Date DATE NULL,
  Program_Time TIME NULL,
  Program_type VARCHAR(40) NULL,
  Part_Status CHAR(50) NULL,
  Rev_reason CHAR(20) NULL,
  Prev_buy_off CHAR(12) NULL,
  Programmers_instructions VARCHAR(50) NULL,
  programmers_notes TEXT NULL,
  Milling_proc CHAR(20) NULL,
  operators_notes TEXT NULL,
  Geometry CHAR(20) NULL,
  Signature VARCHAR(50) NULL,
  Layout_Date DATE NULL,
  layout_notes TEXT NULL,
  Shop_signature CHAR(50) NULL,
  Shop_Date DATE NULL,
  PRIMARY KEY (formID)
);

CREATE TABLE mto.First_part_mto_run (
  first_part_mto_run_id INT NOT NULL AUTO_INCREMENT,
  formID INT NOT NULL,
  operators_name VARCHAR(64) NULL,
  date DATE NULL,
  p_o_num INT NULL,
  machine INT NULL,
  shift TINYINT(3) NULL,
  seq_from_to VARCHAR(45) NULL,
  PRIMARY KEY (first_part_mto_run_id),
  INDEX fk_first_mto_run_copy1_formID1_idx (formID ASC),
  CONSTRAINT fk_first_mto_run_copy1_formID1
    FOREIGN KEY (formID)
    REFERENCES Test (formID)
    ON DELETE CASCADE
    ON UPDATE NO ACTION
);

CREATE TABLE mto.Tooling_sequence (
  tooling_sequence_id INT NOT NULL,
  formID INT NOT NULL,
  mto_comments TEXT NULL,
  fr_rpm_100 TINYINT NULL,
  tooling_mto_status VARCHAR(45) NULL,
  file_url VARCHAR(255) NULL,
  seq_num INT(7) NULL,
  INDEX fk_tooling_sequence_copy1_formID1_idx (formID ASC),
  CONSTRAINT fk_tooling_sequence_copy1_formID1
    FOREIGN KEY (formID)
    REFERENCES Test (formID)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
    PRIMARY KEY (tooling_sequence_id, formID)
);