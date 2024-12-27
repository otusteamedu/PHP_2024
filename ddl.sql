DROP TABLE IF EXISTS patients CASCADE;
CREATE TABLE patients
(
    id        bigint NOT NULL AUTO_INCREMENT,
    full_name varchar(100) NOT NULL,
    birthday  timestamp NOT NULL,
    phone     varchar(100)   null,

    CONSTRAINT patients_pkey PRIMARY KEY (id)
);


DROP TABLE IF EXISTS medics CASCADE;
CREATE TABLE medics
(
    id             bigint NOT NULL AUTO_INCREMENT,
    full_name      varchar(100)   NOT NULL,
    position_name  varchar(100)   NOT NULL,
    cabinet_number int       NOT null,

    CONSTRAINT medics_pkey PRIMARY KEY (id)
);


DROP TABLE IF EXISTS medical_studies CASCADE;
CREATE TABLE medical_studies
(
    id         bigint NOT NULL AUTO_INCREMENT,
    patient_id bigint NOT NULL,
    medic_id   bigint NOT NULL,
    diagnoses  varchar(100)   not null,
    study_memo text,
    study_date timestamp,

    CONSTRAINT medical_studies_pkey PRIMARY KEY (id),
    CONSTRAINT medical_studies_patients_fk FOREIGN KEY (patient_id) REFERENCES patients (id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT medical_studies_medic_fk FOREIGN KEY (medic_id) REFERENCES medics (id) ON DELETE RESTRICT ON UPDATE CASCADE
);






















