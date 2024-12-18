DROP TABLE IF EXISTS public.patients CASCADE;
CREATE TABLE public.patients
(
    id        bigserial NOT NULL,
    full_name varchar   NOT NULL,
    birthday  timestamp NOT NULL,
    phone     varchar   null,

    CONSTRAINT patients_pkey PRIMARY KEY (id)
);


DROP TABLE IF EXISTS public.medics CASCADE;
CREATE TABLE public.medics
(
    id             bigserial NOT NULL,
    full_name      varchar   NOT NULL,
    position_name  varchar   NOT NULL,
    cabinet_number int       NOT null,

    CONSTRAINT medics_pkey PRIMARY KEY (id)
);


DROP TABLE IF EXISTS public.medical_studies CASCADE;
CREATE TABLE public.medical_studies
(
    id         bigserial NOT NULL,
    patient_id bigserial NOT NULL,
    medic_id   bigserial NOT NULL,
    diagnoses  varchar   not null,
    study_memo text,
    study_date timestamp,

    CONSTRAINT medical_studies_pkey PRIMARY KEY (id),
    CONSTRAINT medical_studies_patients_fk FOREIGN KEY (patient_id) REFERENCES patients (id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT medical_studies_medic_fk FOREIGN KEY (medic_id) REFERENCES medics (id) ON DELETE RESTRICT ON UPDATE CASCADE
);





