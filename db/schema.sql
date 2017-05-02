--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: -
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: auth_session; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE auth_session (
    token character varying(255) NOT NULL,
    created_at timestamp with time zone NOT NULL,
    expire_at timestamp with time zone NOT NULL,
    user_id integer NOT NULL,
    user_ip character varying(200) NOT NULL
);


--
-- Name: tire_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tire_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tire; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tire (
    id integer DEFAULT nextval('tire_id_seq'::regclass) NOT NULL,
    brand character varying(100) NOT NULL,
    size character varying(100) NOT NULL,
    type character varying(100) NOT NULL,
    model character varying(100) NOT NULL,
    dot character varying(100) NOT NULL,
    code character varying(100) NOT NULL,
    purchase_price double precision NOT NULL,
    purchase_date date NOT NULL
);


--
-- Name: tire_brand_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tire_brand_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tire_brand; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tire_brand (
    id integer DEFAULT nextval('tire_brand_id_seq'::regclass) NOT NULL,
    name character varying(100) NOT NULL
);


--
-- Name: tire_model_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tire_model_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tire_model; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tire_model (
    id integer DEFAULT nextval('tire_model_id_seq'::regclass) NOT NULL,
    name character varying(100) NOT NULL
);


--
-- Name: tire_size_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tire_size_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tire_size; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tire_size (
    id integer DEFAULT nextval('tire_size_id_seq'::regclass) NOT NULL,
    name character varying(100) NOT NULL
);


--
-- Name: tire_type_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tire_type_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tire_type; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tire_type (
    id integer DEFAULT nextval('tire_type_id_seq'::regclass) NOT NULL,
    name character varying(100) NOT NULL
);


--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: users; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE users (
    id integer DEFAULT nextval('users_id_seq'::regclass) NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    username character varying(255) NOT NULL,
    passwd character varying(255) NOT NULL
);


--
-- Name: vehicle_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE vehicle_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: vehicle; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE vehicle (
    id integer DEFAULT nextval('vehicle_id_seq'::regclass) NOT NULL,
    brand character varying(100) NOT NULL,
    category character varying(100) NOT NULL,
    model character varying(100) NOT NULL,
    type character varying(100) NOT NULL,
    plate character varying(40) NOT NULL
);


--
-- Name: vehicle_brand_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE vehicle_brand_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: vehicle_brand; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE vehicle_brand (
    id integer DEFAULT nextval('vehicle_brand_id_seq'::regclass) NOT NULL,
    name character varying(100) NOT NULL
);


--
-- Name: vehicle_category_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE vehicle_category_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: vehicle_category; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE vehicle_category (
    id integer DEFAULT nextval('vehicle_category_id_seq'::regclass) NOT NULL,
    name character varying(100) NOT NULL
);


--
-- Name: vehicle_model_brand_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE vehicle_model_brand_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: vehicle_model_brand; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE vehicle_model_brand (
    id integer DEFAULT nextval('vehicle_model_brand_id_seq'::regclass) NOT NULL,
    brand character varying(100) NOT NULL,
    model character varying(100) NOT NULL
);


--
-- Name: vehicle_type_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE vehicle_type_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: vehicle_type; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE vehicle_type (
    id integer DEFAULT nextval('vehicle_type_id_seq'::regclass) NOT NULL,
    name character varying(100) NOT NULL
);


--
-- Name: auth_session_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY auth_session
    ADD CONSTRAINT auth_session_pkey PRIMARY KEY (token);


--
-- Name: tire_brand_name_key; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tire_brand
    ADD CONSTRAINT tire_brand_name_key UNIQUE (name);


--
-- Name: tire_brand_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tire_brand
    ADD CONSTRAINT tire_brand_pkey PRIMARY KEY (id);


--
-- Name: tire_code_key; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tire
    ADD CONSTRAINT tire_code_key UNIQUE (code);


--
-- Name: tire_model_name_key; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tire_model
    ADD CONSTRAINT tire_model_name_key UNIQUE (name);


--
-- Name: tire_model_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tire_model
    ADD CONSTRAINT tire_model_pkey PRIMARY KEY (id);


--
-- Name: tire_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tire
    ADD CONSTRAINT tire_pkey PRIMARY KEY (id);


--
-- Name: tire_size_name_key; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tire_size
    ADD CONSTRAINT tire_size_name_key UNIQUE (name);


--
-- Name: tire_size_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tire_size
    ADD CONSTRAINT tire_size_pkey PRIMARY KEY (id);


--
-- Name: tire_type_name_key; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tire_type
    ADD CONSTRAINT tire_type_name_key UNIQUE (name);


--
-- Name: tire_type_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tire_type
    ADD CONSTRAINT tire_type_pkey PRIMARY KEY (id);


--
-- Name: users_email_key; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_email_key UNIQUE (email);


--
-- Name: users_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: users_username_key; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_username_key UNIQUE (username);


--
-- Name: vehicle_brand_name_key; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY vehicle_brand
    ADD CONSTRAINT vehicle_brand_name_key UNIQUE (name);


--
-- Name: vehicle_brand_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY vehicle_brand
    ADD CONSTRAINT vehicle_brand_pkey PRIMARY KEY (id);


--
-- Name: vehicle_category_name_key; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY vehicle_category
    ADD CONSTRAINT vehicle_category_name_key UNIQUE (name);


--
-- Name: vehicle_category_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY vehicle_category
    ADD CONSTRAINT vehicle_category_pkey PRIMARY KEY (id);


--
-- Name: vehicle_model_brand_model_key; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY vehicle_model_brand
    ADD CONSTRAINT vehicle_model_brand_model_key UNIQUE (model);


--
-- Name: vehicle_model_brand_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY vehicle_model_brand
    ADD CONSTRAINT vehicle_model_brand_pkey PRIMARY KEY (id);


--
-- Name: vehicle_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY vehicle
    ADD CONSTRAINT vehicle_pkey PRIMARY KEY (id);


--
-- Name: vehicle_plate_key; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY vehicle
    ADD CONSTRAINT vehicle_plate_key UNIQUE (plate);


--
-- Name: vehicle_type_name_key; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY vehicle_type
    ADD CONSTRAINT vehicle_type_name_key UNIQUE (name);


--
-- Name: vehicle_type_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY vehicle_type
    ADD CONSTRAINT vehicle_type_pkey PRIMARY KEY (id);


--
-- Name: auth_session_user_id_idx; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX auth_session_user_id_idx ON auth_session USING btree (user_id);


--
-- Name: tire_brand_idx; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX tire_brand_idx ON tire USING btree (brand);


--
-- Name: tire_model_idx; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX tire_model_idx ON tire USING btree (model);


--
-- Name: tire_size_idx; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX tire_size_idx ON tire USING btree (size);


--
-- Name: tire_type_idx; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX tire_type_idx ON tire USING btree (type);


--
-- Name: vehicle_brand_idx; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX vehicle_brand_idx ON vehicle USING btree (brand);


--
-- Name: vehicle_category_idx; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX vehicle_category_idx ON vehicle USING btree (category);


--
-- Name: vehicle_model_brand_brand_idx; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX vehicle_model_brand_brand_idx ON vehicle_model_brand USING btree (brand);


--
-- Name: vehicle_type_idx; Type: INDEX; Schema: public; Owner: -; Tablespace: 
--

CREATE INDEX vehicle_type_idx ON vehicle USING btree (type);


--
-- Name: fk_auth_session_user; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY auth_session
    ADD CONSTRAINT fk_auth_session_user FOREIGN KEY (user_id) REFERENCES users(id) DEFERRABLE INITIALLY DEFERRED;


--
-- Name: fk_tire_brand_x; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tire
    ADD CONSTRAINT fk_tire_brand_x FOREIGN KEY (brand) REFERENCES tire_brand(name) DEFERRABLE INITIALLY DEFERRED;


--
-- Name: fk_tire_model_x; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tire
    ADD CONSTRAINT fk_tire_model_x FOREIGN KEY (model) REFERENCES tire_model(name) DEFERRABLE INITIALLY DEFERRED;


--
-- Name: fk_tire_size_x; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tire
    ADD CONSTRAINT fk_tire_size_x FOREIGN KEY (size) REFERENCES tire_size(name) DEFERRABLE INITIALLY DEFERRED;


--
-- Name: fk_tire_type_x; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY tire
    ADD CONSTRAINT fk_tire_type_x FOREIGN KEY (type) REFERENCES tire_type(name) DEFERRABLE INITIALLY DEFERRED;


--
-- Name: fk_vehicle_brand; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY vehicle_model_brand
    ADD CONSTRAINT fk_vehicle_brand FOREIGN KEY (brand) REFERENCES vehicle_brand(name) DEFERRABLE INITIALLY DEFERRED;


--
-- Name: fk_vehicle_brand_x; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY vehicle
    ADD CONSTRAINT fk_vehicle_brand_x FOREIGN KEY (brand) REFERENCES vehicle_brand(name) DEFERRABLE INITIALLY DEFERRED;


--
-- Name: fk_vehicle_category_x; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY vehicle
    ADD CONSTRAINT fk_vehicle_category_x FOREIGN KEY (category) REFERENCES vehicle_category(name) DEFERRABLE INITIALLY DEFERRED;


--
-- Name: fk_vehicle_type_x; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY vehicle
    ADD CONSTRAINT fk_vehicle_type_x FOREIGN KEY (type) REFERENCES vehicle_type(name) DEFERRABLE INITIALLY DEFERRED;


--
-- PostgreSQL database dump complete
--

