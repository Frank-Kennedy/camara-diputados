--
-- PostgreSQL database dump
--

\restrict XY1WdOTKFjq3vglkC7d67td6bymCK4gvuKT4VZEGKPXL3bAg0z8ugiHIz5wFnVz

-- Dumped from database version 15.18
-- Dumped by pg_dump version 18.3

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: public; Type: SCHEMA; Schema: -; Owner: postgres
--

-- *not* creating schema, since initdb creates it


ALTER SCHEMA public OWNER TO postgres;

--
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON SCHEMA public IS '';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: cache; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache OWNER TO postgres;

--
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache_locks OWNER TO postgres;

--
-- Name: comisiones; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.comisiones (
    id bigint NOT NULL,
    name_es character varying(255) NOT NULL,
    name_fr character varying(255),
    name_pt character varying(255),
    name_en character varying(255),
    description_es text NOT NULL,
    description_fr text,
    description_pt text,
    description_en text,
    image character varying(255),
    is_active boolean DEFAULT true NOT NULL,
    deleted_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.comisiones OWNER TO postgres;

--
-- Name: comisiones_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.comisiones_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.comisiones_id_seq OWNER TO postgres;

--
-- Name: comisiones_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.comisiones_id_seq OWNED BY public.comisiones.id;


--
-- Name: consultas_ciudadanas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.consultas_ciudadanas (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    last_name character varying(255),
    email character varying(255) NOT NULL,
    phone character varying(255),
    subject_es character varying(255) NOT NULL,
    subject_fr character varying(255),
    subject_pt character varying(255),
    subject_en character varying(255),
    type character varying(255) NOT NULL,
    message_es text NOT NULL,
    message_fr text,
    message_pt text,
    message_en text,
    file_attachment character varying(255),
    status character varying(255) DEFAULT 'pendiente'::character varying NOT NULL,
    response_es text,
    response_fr text,
    response_pt text,
    response_en text,
    user_id bigint,
    response_date date,
    is_public boolean DEFAULT false NOT NULL,
    is_anonymous boolean DEFAULT false NOT NULL,
    deleted_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT consultas_ciudadanas_status_check CHECK (((status)::text = ANY ((ARRAY['pendiente'::character varying, 'en_proceso'::character varying, 'resuelta'::character varying, 'archivada'::character varying])::text[]))),
    CONSTRAINT consultas_ciudadanas_type_check CHECK (((type)::text = ANY ((ARRAY['sugerencia'::character varying, 'consulta'::character varying, 'queja'::character varying, 'solicitud'::character varying, 'denuncia'::character varying])::text[])))
);


ALTER TABLE public.consultas_ciudadanas OWNER TO postgres;

--
-- Name: consultas_ciudadanas_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.consultas_ciudadanas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.consultas_ciudadanas_id_seq OWNER TO postgres;

--
-- Name: consultas_ciudadanas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.consultas_ciudadanas_id_seq OWNED BY public.consultas_ciudadanas.id;


--
-- Name: diputado_comision; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.diputado_comision (
    id bigint NOT NULL,
    diputado_id bigint NOT NULL,
    comision_id bigint NOT NULL,
    role character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.diputado_comision OWNER TO postgres;

--
-- Name: diputado_comision_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.diputado_comision_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.diputado_comision_id_seq OWNER TO postgres;

--
-- Name: diputado_comision_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.diputado_comision_id_seq OWNED BY public.diputado_comision.id;


--
-- Name: diputados; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.diputados (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    last_name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    phone character varying(255),
    photo character varying(255),
    political_party character varying(255) NOT NULL,
    constituency character varying(255) NOT NULL,
    "position" character varying(255),
    biography_es text,
    biography_fr text,
    biography_pt text,
    biography_en text,
    social_networks json,
    start_date date NOT NULL,
    end_date date,
    is_active boolean DEFAULT true NOT NULL,
    views integer DEFAULT 0 NOT NULL,
    deleted_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.diputados OWNER TO postgres;

--
-- Name: diputados_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.diputados_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.diputados_id_seq OWNER TO postgres;

--
-- Name: diputados_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.diputados_id_seq OWNED BY public.diputados.id;


--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.failed_jobs_id_seq OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: galeria_imagenes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.galeria_imagenes (
    id bigint NOT NULL,
    image character varying(255) NOT NULL,
    caption_es character varying(255),
    caption_fr character varying(255),
    caption_pt character varying(255),
    caption_en character varying(255),
    noticia_id bigint NOT NULL,
    "order" integer DEFAULT 0 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.galeria_imagenes OWNER TO postgres;

--
-- Name: galeria_imagenes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.galeria_imagenes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.galeria_imagenes_id_seq OWNER TO postgres;

--
-- Name: galeria_imagenes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.galeria_imagenes_id_seq OWNED BY public.galeria_imagenes.id;


--
-- Name: institutional_info; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.institutional_info (
    id bigint NOT NULL,
    section character varying(255) NOT NULL,
    title_es character varying(255) NOT NULL,
    title_fr character varying(255),
    title_pt character varying(255),
    title_en character varying(255),
    content_es text NOT NULL,
    content_fr text,
    content_pt text,
    content_en text,
    image character varying(255),
    "order" integer DEFAULT 0 NOT NULL,
    is_active boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.institutional_info OWNER TO postgres;

--
-- Name: institutional_info_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.institutional_info_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.institutional_info_id_seq OWNER TO postgres;

--
-- Name: institutional_info_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.institutional_info_id_seq OWNED BY public.institutional_info.id;


--
-- Name: leyes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.leyes (
    id bigint NOT NULL,
    title_es character varying(255) NOT NULL,
    title_fr character varying(255),
    title_pt character varying(255),
    title_en character varying(255),
    code character varying(255) NOT NULL,
    type character varying(255) NOT NULL,
    status character varying(255) DEFAULT 'propuesta'::character varying NOT NULL,
    summary_es text NOT NULL,
    summary_fr text,
    summary_pt text,
    summary_en text,
    content_es text,
    content_fr text,
    content_pt text,
    content_en text,
    presentation_date date NOT NULL,
    approval_date date,
    file_pdf character varying(255),
    diputado_id bigint NOT NULL,
    comision_id bigint,
    views integer DEFAULT 0 NOT NULL,
    downloads integer DEFAULT 0 NOT NULL,
    is_public boolean DEFAULT true NOT NULL,
    deleted_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    category character varying(255),
    is_featured boolean DEFAULT false NOT NULL,
    CONSTRAINT leyes_category_check CHECK (((category)::text = ANY ((ARRAY['civil'::character varying, 'penal'::character varying, 'laboral'::character varying, 'administrativo'::character varying, 'constitucional'::character varying, 'otros'::character varying])::text[]))),
    CONSTRAINT leyes_status_check CHECK (((status)::text = ANY ((ARRAY['propuesta'::character varying, 'en_discusion'::character varying, 'aprobada'::character varying, 'rechazada'::character varying, 'archivada'::character varying])::text[]))),
    CONSTRAINT leyes_type_check CHECK (((type)::text = ANY ((ARRAY['ley'::character varying, 'proyecto'::character varying, 'resolucion'::character varying, 'decreto'::character varying])::text[])))
);


ALTER TABLE public.leyes OWNER TO postgres;

--
-- Name: leyes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.leyes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.leyes_id_seq OWNER TO postgres;

--
-- Name: leyes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.leyes_id_seq OWNED BY public.leyes.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: multimedia; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.multimedia (
    id bigint NOT NULL,
    title_es character varying(255) NOT NULL,
    title_fr character varying(255),
    title_pt character varying(255),
    title_en character varying(255),
    type character varying(255) NOT NULL,
    url character varying(255) NOT NULL,
    embed_code character varying(255),
    thumbnail character varying(255),
    description_es text,
    description_fr text,
    description_pt text,
    description_en text,
    recorded_date date NOT NULL,
    is_live boolean DEFAULT false NOT NULL,
    is_active boolean DEFAULT true NOT NULL,
    views integer DEFAULT 0 NOT NULL,
    deleted_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT multimedia_type_check CHECK (((type)::text = ANY ((ARRAY['video'::character varying, 'audio'::character varying, 'live_stream'::character varying])::text[])))
);


ALTER TABLE public.multimedia OWNER TO postgres;

--
-- Name: multimedia_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.multimedia_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.multimedia_id_seq OWNER TO postgres;

--
-- Name: multimedia_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.multimedia_id_seq OWNED BY public.multimedia.id;


--
-- Name: noticias; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.noticias (
    id bigint NOT NULL,
    title_es character varying(255) NOT NULL,
    title_fr character varying(255),
    title_pt character varying(255),
    title_en character varying(255),
    slug character varying(255) NOT NULL,
    summary_es text NOT NULL,
    summary_fr text,
    summary_pt text,
    summary_en text,
    content_es text NOT NULL,
    content_fr text,
    content_pt text,
    content_en text,
    featured_image character varying(255),
    category character varying(255) NOT NULL,
    published_date date NOT NULL,
    is_published boolean DEFAULT false NOT NULL,
    is_featured boolean DEFAULT false NOT NULL,
    views integer DEFAULT 0 NOT NULL,
    user_id bigint NOT NULL,
    tags json,
    deleted_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT noticias_category_check CHECK (((category)::text = ANY ((ARRAY['institucional'::character varying, 'legislativo'::character varying, 'eventos'::character varying, 'comunicados'::character varying, 'internacional'::character varying])::text[])))
);


ALTER TABLE public.noticias OWNER TO postgres;

--
-- Name: noticias_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.noticias_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.noticias_id_seq OWNER TO postgres;

--
-- Name: noticias_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.noticias_id_seq OWNED BY public.noticias.id;


--
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_tokens OWNER TO postgres;

--
-- Name: sessions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


ALTER TABLE public.sessions OWNER TO postgres;

--
-- Name: transparencia; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.transparencia (
    id bigint NOT NULL,
    title_es character varying(255) NOT NULL,
    title_fr character varying(255),
    title_pt character varying(255),
    title_en character varying(255),
    category character varying(255) NOT NULL,
    year integer NOT NULL,
    file_pdf character varying(255),
    file_excel character varying(255),
    description_es text,
    description_fr text,
    description_pt text,
    description_en text,
    publication_date date NOT NULL,
    is_public boolean DEFAULT true NOT NULL,
    downloads integer DEFAULT 0 NOT NULL,
    deleted_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT transparencia_category_check CHECK (((category)::text = ANY ((ARRAY['presupuesto'::character varying, 'informe_gestion'::character varying, 'rendicion_cuentas'::character varying, 'contrataciones'::character varying, 'planificacion'::character varying])::text[])))
);


ALTER TABLE public.transparencia OWNER TO postgres;

--
-- Name: transparencia_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.transparencia_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.transparencia_id_seq OWNER TO postgres;

--
-- Name: transparencia_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.transparencia_id_seq OWNED BY public.transparencia.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    last_name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    phone character varying(255),
    "position" character varying(255),
    role character varying(255) DEFAULT 'viewer'::character varying NOT NULL,
    is_active boolean DEFAULT true NOT NULL,
    last_login timestamp(0) without time zone,
    avatar character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT users_role_check CHECK (((role)::text = ANY ((ARRAY['admin'::character varying, 'editor'::character varying, 'viewer'::character varying])::text[])))
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: comisiones id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.comisiones ALTER COLUMN id SET DEFAULT nextval('public.comisiones_id_seq'::regclass);


--
-- Name: consultas_ciudadanas id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.consultas_ciudadanas ALTER COLUMN id SET DEFAULT nextval('public.consultas_ciudadanas_id_seq'::regclass);


--
-- Name: diputado_comision id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.diputado_comision ALTER COLUMN id SET DEFAULT nextval('public.diputado_comision_id_seq'::regclass);


--
-- Name: diputados id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.diputados ALTER COLUMN id SET DEFAULT nextval('public.diputados_id_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: galeria_imagenes id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.galeria_imagenes ALTER COLUMN id SET DEFAULT nextval('public.galeria_imagenes_id_seq'::regclass);


--
-- Name: institutional_info id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.institutional_info ALTER COLUMN id SET DEFAULT nextval('public.institutional_info_id_seq'::regclass);


--
-- Name: leyes id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.leyes ALTER COLUMN id SET DEFAULT nextval('public.leyes_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: multimedia id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.multimedia ALTER COLUMN id SET DEFAULT nextval('public.multimedia_id_seq'::regclass);


--
-- Name: noticias id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.noticias ALTER COLUMN id SET DEFAULT nextval('public.noticias_id_seq'::regclass);


--
-- Name: transparencia id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.transparencia ALTER COLUMN id SET DEFAULT nextval('public.transparencia_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache (key, value, expiration) FROM stdin;
\.


--
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache_locks (key, owner, expiration) FROM stdin;
\.


--
-- Data for Name: comisiones; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.comisiones (id, name_es, name_fr, name_pt, name_en, description_es, description_fr, description_pt, description_en, image, is_active, deleted_at, created_at, updated_at) FROM stdin;
1	Comisión de Justicia	\N	\N	\N	Asuntos judiciales	\N	\N	\N	\N	t	\N	2026-06-17 19:28:57	2026-06-17 19:28:57
2	Comisión de Economía	\N	\N	\N	Asuntos económicos	\N	\N	\N	\N	t	\N	2026-06-17 19:28:57	2026-06-17 19:28:57
3	Comisión de Salud	\N	\N	\N	Asuntos de salud	\N	\N	\N	\N	t	\N	2026-06-17 19:28:57	2026-06-17 19:28:57
\.


--
-- Data for Name: consultas_ciudadanas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.consultas_ciudadanas (id, name, last_name, email, phone, subject_es, subject_fr, subject_pt, subject_en, type, message_es, message_fr, message_pt, message_en, file_attachment, status, response_es, response_fr, response_pt, response_en, user_id, response_date, is_public, is_anonymous, deleted_at, created_at, updated_at) FROM stdin;
1	Pedro	Obiang	pedro.obiang@email.com	666111111	Consulta sobre Ley de Transparencia	\N	\N	\N	consulta	Cómo puedo acceder a la información pública establecida en la nueva Ley de Transparencia?	\N	\N	\N	\N	pendiente	\N	\N	\N	\N	\N	\N	f	f	\N	2026-06-17 17:23:51	2026-06-17 17:23:51
2	Lucía	Nguema	lucia.nguema@email.com	666222222	Sugerencia para mejorar el portal	\N	\N	\N	sugerencia	Sugiero que el portal incluya más información sobre el trabajo de las comisiones parlamentarias.	\N	\N	\N	\N	en_proceso	\N	\N	\N	\N	\N	\N	f	f	\N	2026-06-17 17:23:51	2026-06-17 17:23:51
3	Mateo	Mba	mateo.mba@email.com	666333333	Solicitud de información sobre presupuestos	\N	\N	\N	solicitud	Solicito información detallada sobre los presupuestos asignados a la Cámara de Diputados.	\N	\N	\N	\N	resuelta	\N	\N	\N	\N	\N	\N	f	f	\N	2026-06-17 17:23:51	2026-06-17 17:23:51
4	Elena	Hits	elena.hits@email.com	666444444	Queja sobre atención ciudadana	\N	\N	\N	queja	He enviado consultas anteriores sin obtener respuesta. Solicito mayor atención.	\N	\N	\N	\N	pendiente	\N	\N	\N	\N	\N	\N	f	f	\N	2026-06-17 17:23:51	2026-06-17 17:23:51
5	Andrés	Esono	andres.esono@email.com	666555555	Denuncia sobre irregularidades	\N	\N	\N	denuncia	Denuncio posibles irregularidades en el proceso de contratación de servicios de la Cámara.	\N	\N	\N	\N	archivada	\N	\N	\N	\N	\N	\N	f	f	\N	2026-06-17 17:23:51	2026-06-17 17:23:51
6	Anónimo		anonimo@parlamentoge.qq	\N	No me han dado chapas	\N	\N	\N	queja	Durante el reparto de chapas no fui agraciado	\N	\N	\N	\N	pendiente	\N	\N	\N	\N	\N	\N	f	t	\N	2026-06-18 12:24:50	2026-06-18 12:24:50
\.


--
-- Data for Name: diputado_comision; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.diputado_comision (id, diputado_id, comision_id, role, created_at, updated_at) FROM stdin;
1	1	1	Presidente	2026-06-17 19:28:59	2026-06-17 19:28:59
2	2	2	Miembro	2026-06-17 19:28:59	2026-06-17 19:28:59
3	3	3	Miembro	2026-06-17 19:28:59	2026-06-17 19:28:59
\.


--
-- Data for Name: diputados; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.diputados (id, name, last_name, email, phone, photo, political_party, constituency, "position", biography_es, biography_fr, biography_pt, biography_en, social_networks, start_date, end_date, is_active, views, deleted_at, created_at, updated_at) FROM stdin;
4	Ana	Nguema	ana.nguema@parlamentoge.qq	222444444	diputados/4.jpg	Partido Democrático	Evinayong	Diputada	Diputada con especialización en temas de educación y cultura.	\N	\N	\N	\N	2023-01-01	\N	t	1	\N	2026-06-17 17:22:33	2026-06-18 08:36:32
5	José	Esono	jose.esono@parlamentoge.qq	222555555	diputados/5.jpg	Partido Democrático	Malabo	Diputado	Diputado con experiencia en economía y finanzas públicas.	\N	\N	\N	\N	2023-01-01	\N	t	2	\N	2026-06-17 17:22:33	2026-06-18 08:36:32
2	María	Rodríguez	maria.rodriguez@parlamentoge.qq	222222222	diputados/2.jpg	Partido Democrático	Bata	Vicepresidenta	Vicepresidenta de la Cámara, abogada y defensora de los derechos de la mujer.	\N	\N	\N	\N	2023-01-01	\N	t	2	\N	2026-06-17 17:22:33	2026-06-18 12:04:16
1	Juan	Pérez	juan.perez@parlamentoge.qq	222111111	diputados/1.jpg	Partido Democrático	Malabo	Presidente	Presidente de la Cámara de Diputados con más de 15 años de experiencia en la política nacional.	\N	\N	\N	\N	2023-01-01	\N	t	3	\N	2026-06-17 17:22:33	2026-06-19 06:34:33
3	Carlos	Mba	carlos.mba@parlamentoge.qq	222333333	diputados/3.jpg	Partido Democrático	Ebebiyin	Secretario	Secretario de la Mesa Directiva, experto en derecho constitucional.	\N	\N	\N	\N	2023-01-01	\N	t	5	\N	2026-06-17 17:22:33	2026-06-19 06:55:27
\.


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: galeria_imagenes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.galeria_imagenes (id, image, caption_es, caption_fr, caption_pt, caption_en, noticia_id, "order", created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: institutional_info; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.institutional_info (id, section, title_es, title_fr, title_pt, title_en, content_es, content_fr, content_pt, content_en, image, "order", is_active, created_at, updated_at) FROM stdin;
1	mision	Nuestra Misión	\N	\N	\N	Representar al pueblo ecuatoriano, legislar para el bien común y fiscalizar la acción del gobierno con transparencia y eficiencia.	\N	\N	\N	\N	0	t	2026-06-17 16:17:23	2026-06-17 16:17:23
2	vision	Nuestra Visión	\N	\N	\N	Ser un parlamento modelo en África, referente en transparencia, participación ciudadana y desarrollo legislativo.	\N	\N	\N	\N	0	t	2026-06-17 16:17:23	2026-06-17 16:17:23
3	valores	Nuestros Valores	\N	\N	\N	Transparencia, participación, democracia, justicia social, igualdad y desarrollo sostenible.	\N	\N	\N	\N	0	t	2026-06-17 16:17:23	2026-06-17 16:17:23
4	historia	Historia	\N	\N	\N	La Cámara de Diputados de Guinea Ecuatorial fue fundada en ... como el órgano legislativo de la nación.	\N	\N	\N	\N	0	t	2026-06-17 16:17:23	2026-06-17 16:17:23
5	mision	Nuestra Misión	\N	\N	\N	Representar al pueblo ecuatorial, legislar para el bien común y fiscalizar la acción del gobierno con transparencia y eficiencia.	\N	\N	\N	\N	1	t	2026-06-17 17:21:34	2026-06-17 17:21:34
6	vision	Nuestra Visión	\N	\N	\N	Ser un parlamento modelo en África, referente en transparencia, participación ciudadana y desarrollo legislativo.	\N	\N	\N	\N	2	t	2026-06-17 17:21:34	2026-06-17 17:21:34
7	valores	Nuestros Valores	\N	\N	\N	Transparencia, participación, democracia, justicia social, igualdad y desarrollo sostenible.	\N	\N	\N	\N	3	t	2026-06-17 17:21:34	2026-06-17 17:21:34
8	historia	Historia de la Cámara	\N	\N	\N	La Cámara de Diputados de Guinea Ecuatorial fue fundada en 1968 como el órgano legislativo de la nación, representando al pueblo y velando por sus intereses.	\N	\N	\N	\N	4	t	2026-06-17 17:21:34	2026-06-17 17:21:34
9	estructura	Estructura Organizativa	\N	\N	\N	La Cámara está compuesta por la Presidencia, Mesa Directiva, Comisiones Permanentes y Grupos Parlamentarios.	\N	\N	\N	\N	5	t	2026-06-17 17:21:34	2026-06-17 17:21:34
\.


--
-- Data for Name: leyes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.leyes (id, title_es, title_fr, title_pt, title_en, code, type, status, summary_es, summary_fr, summary_pt, summary_en, content_es, content_fr, content_pt, content_en, presentation_date, approval_date, file_pdf, diputado_id, comision_id, views, downloads, is_public, deleted_at, created_at, updated_at, category, is_featured) FROM stdin;
1	Ley de Transparencia y Acceso a la Información	\N	\N	\N	LTI-2024-001	ley	aprobada	Ley que garantiza el acceso a la información pública y promueve la transparencia en la gestión gubernamental.	\N	\N	\N	La presente ley establece los mecanismos para que los ciudadanos puedan acceder a la información pública de manera ágil y efectiva...	\N	\N	\N	2024-01-15	2024-03-20	\N	1	\N	4	0	t	\N	2026-06-17 17:23:00	2026-06-18 12:27:32	\N	f
5	Proyecto de Ley de Desarrollo Económico	\N	\N	\N	PDE-2024-005	proyecto	propuesta	Proyecto de ley que propone medidas para el desarrollo económico y la creación de empleo.	\N	\N	\N	El presente proyecto de ley propone medidas para impulsar el desarrollo económico...	\N	\N	\N	2024-05-01	\N	\N	5	\N	3	0	t	\N	2026-06-17 17:23:00	2026-06-18 14:49:03	\N	f
2	Ley de Presupuestos Generales del Estado 2025	\N	\N	\N	PGE-2024-002	ley	aprobada	Ley que aprueba los presupuestos generales del estado para el ejercicio fiscal 2025.	\N	\N	\N	La presente ley aprueba los presupuestos generales del estado para el año 2025...	\N	\N	\N	2024-02-01	2024-04-10	leyes/ih2TWxUh5idrFO2X5upGMS0LsszJLp4dQ3l1kfPS.pdf	2	\N	7	1	t	\N	2026-06-17 17:23:00	2026-06-18 15:40:32	\N	f
4	Resolución sobre la Protección del Medio Ambiente	\N	\N	\N	RMA-2024-004	resolucion	aprobada	Resolución que establece medidas para la protección del medio ambiente y recursos naturales.	\N	\N	\N	La presente resolución establece medidas urgentes para la protección del medio ambiente...	\N	\N	\N	2024-04-01	2024-05-15	\N	4	\N	7	0	t	\N	2026-06-17 17:23:00	2026-06-18 15:44:13	\N	f
3	Proyecto de Ley de Reforma Educativa	\N	\N	\N	PRE-2024-003	proyecto	en_discusion	Proyecto de ley que busca reformar el sistema educativo nacional.	\N	\N	\N	El presente proyecto de ley propone reformas integrales al sistema educativo...	\N	\N	\N	2024-03-01	\N	\N	3	\N	2	0	t	\N	2026-06-17 17:23:00	2026-06-18 15:12:26	\N	f
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	2026_06_17_153304_create_users_table	1
2	2026_06_17_153335_create_sessions_table	1
3	2026_06_17_154120_create_password_reset_tokens_table	1
4	2026_06_17_154232_create_failed_jobs_table	1
5	2026_06_17_154328_create_cache_table	1
6	2026_06_17_154439_create_diputados_table	1
7	2026_06_17_154503_create_comisiones_table	1
8	2026_06_17_154524_create_diputado_comision_table	2
9	2026_06_17_154553_create_leyes_table	2
10	2026_06_17_154636_create_noticias_table	2
11	2026_06_17_154934_create_galeria_imagenes_table	2
12	2026_06_17_154957_create_multimedia_table	2
13	2026_06_17_155021_create_transparencia_table	2
14	2026_06_17_155046_create_consultas_ciudadanas_table	2
15	2026_06_17_155109_create_institutional_info_table	2
16	2026_06_18_115329_add_category_to_leyes_table	3
\.


--
-- Data for Name: multimedia; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.multimedia (id, title_es, title_fr, title_pt, title_en, type, url, embed_code, thumbnail, description_es, description_fr, description_pt, description_en, recorded_date, is_live, is_active, views, deleted_at, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: noticias; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.noticias (id, title_es, title_fr, title_pt, title_en, slug, summary_es, summary_fr, summary_pt, summary_en, content_es, content_fr, content_pt, content_en, featured_image, category, published_date, is_published, is_featured, views, user_id, tags, deleted_at, created_at, updated_at) FROM stdin;
9	La Cámara se suma al Día Internacional de la Democracia	\N	\N	\N	dia-internacional-democracia	La Cámara de Diputados organizó actividades conmemorativas por el Día Internacional de la Democracia.	\N	\N	\N	En el marco del Día Internacional de la Democracia, la Cámara de Diputados organizó un conversatorio sobre el papel de los parlamentos en la consolidación democrática. Participaron diputados, académicos y representantes de la sociedad civil. Se destacó la importancia de la participación ciudadana y la transparencia en la gestión pública.	\N	\N	\N	noticias/GslVHC23bB8zfgW9llgVqdidf6QO8ImaEn63esNz.jpg	eventos	2024-05-15	t	f	2	1	\N	\N	2026-06-17 17:08:42	2026-06-18 14:48:36
7	Nuevo Reglamento de la Cámara será debatido en comisión	\N	\N	\N	nuevo-reglamento-camara-comision	La Comisión de Reglamento inició el debate sobre la reforma del reglamento interno de la Cámara de Diputados.	\N	\N	\N	La Comisión de Reglamento de la Cámara de Diputados inició el debate sobre la reforma del reglamento interno. Entre los cambios propuestos se incluyen la modernización de los procedimientos legislativos y el fortalecimiento de la participación ciudadana. El nuevo reglamento será sometido a votación en el próximo pleno.	\N	\N	\N	noticias/7.jpg	legislativo	2024-05-25	t	f	1	1	\N	\N	2026-06-17 17:08:42	2026-06-18 08:58:19
2	Inauguración del período ordinario de sesiones 2024-2025	\N	\N	\N	inauguracion-periodo-sesiones-2024	El Presidente de la Cámara inauguró el nuevo período ordinario de sesiones con un discurso enfocado en la unidad y el desarrollo.	\N	\N	\N	El Presidente de la Cámara de Diputados, Juan Pérez, inauguró el período ordinario de sesiones 2024-2025 con un llamado a la unidad nacional y al trabajo conjunto por el desarrollo de Guinea Ecuatorial. Durante su discurso, destacó los logros alcanzados en la legislatura anterior y los desafíos que enfrenta el país.	\N	\N	\N	noticias/2.jpg	institucional	2024-06-10	t	t	13	1	\N	\N	2026-06-17 17:08:42	2026-06-18 18:51:16
5	Aprobado el Presupuesto General del Estado 2025	\N	\N	\N	presupuesto-general-estado-2025	La Cámara aprobó el Presupuesto General del Estado para el año 2025 con un enfoque en inversión social.	\N	\N	\N	Por mayoría, la Cámara de Diputados aprobó el Presupuesto General del Estado para el ejercicio fiscal 2025. El presupuesto asigna recursos significativos a educación, salud e infraestructura. El Ministro de Finanzas destacó que el presupuesto busca equilibrar el crecimiento económico con el bienestar social.	\N	\N	\N	noticias/5.jpg	legislativo	2024-06-01	t	f	0	1	\N	\N	2026-06-17 17:08:42	2026-06-18 08:37:11
4	Diputados participan en foro internacional sobre democracia	\N	\N	\N	diputados-foro-internacional-democracia	Una delegación de diputados participó en el Foro Internacional sobre Democracia y Gobernanza en África.	\N	\N	\N	Una delegación de la Cámara de Diputados, encabezada por el Vicepresidente, participó en el Foro Internacional sobre Democracia y Gobernanza celebrado en Addis Abeba. Los diputados compartieron experiencias sobre el proceso democrático en Guinea Ecuatorial y conocieron buenas prácticas de otros países africanos.	\N	\N	\N	\N	internacional	2026-06-18	t	f	0	1	\N	\N	2026-06-17 17:08:42	2026-06-18 14:55:42
12	Dimisión en bloque del Gobierno de Guinea Ecuatorial	\N	\N	\N	dimision-en-bloque-del-gobierno-de-guinea-ecuatorial-1781810198	El Primer Ministro y todo su gabinete presentaron su dimisión irrevocable ante el Presidente de la República, en un movimiento sin precedentes en la historia política del país.	\N	\N	\N	<p>En un hecho hist&oacute;rico para la pol&iacute;tica nacional, el Primer Ministro de Guinea Ecuatorial y la totalidad de su gabinete ministerial han presentado esta ma&ntilde;ana su dimisi&oacute;n en bloque ante el Presidente de la Rep&uacute;blica. El anuncio se produjo tras una reuni&oacute;n extraordinaria del Consejo de Ministros celebrada en el Palacio Presidencial de Malabo, donde el jefe del Ejecutivo entreg&oacute; la carta de renuncia firmada por todos los miembros del gobierno.</p>\r\n<p><strong>Declaraciones del Primer Ministro</strong></p>\r\n<p><em>En su discurso de despedida, el Primer Ministro manifest&oacute;: "He tomado esta decisi&oacute;n tras una profunda reflexi&oacute;n sobre el futuro de nuestra naci&oacute;n. Agradezco al Presidente de la Rep&uacute;blica por la confianza depositada durante todos estos a&ntilde;os y pongo a disposici&oacute;n del pa&iacute;s mi experiencia para lo que sea necesario"</em></p>\r\n<p>El jefe del Ejecutivo destac&oacute; los logros alcanzados durante su mandato, entre los que mencion&oacute;:</p>\r\n<ul>\r\n<li>El crecimiento econ&oacute;mico sostenido durante los &uacute;ltimos a&ntilde;os</li>\r\n<li>La mejora de las infraestructuras del pa&iacute;s</li>\r\n<li>Los avances en materia de transparencia y modernizaci&oacute;n institucional</li>\r\n<li>El fortalecimiento de las relaciones internacionales</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;<strong>Reacciones pol&iacute;ticas</strong></p>\r\n<p>Desde la C&aacute;mara de Diputados, el Presidente de la misma ha declarado que "se respeta la decisi&oacute;n del Primer Ministro y se trabajar&aacute; para garantizar la estabilidad institucional durante el proceso de transici&oacute;n".</p>\r\n<p>Los distintos grupos parlamentarios han solicitado una sesi&oacute;n extraordinaria para abordar la situaci&oacute;n y conocer los detalles del proceso de relevo gubernamental.</p>\r\n<p><strong>&nbsp;Pr&oacute;ximos pasos</strong></p>\r\n<p>El Presidente de la Rep&uacute;blica tiene ahora la responsabilidad constitucional de designar un nuevo Primer Ministro y conformar un nuevo gobierno. Seg&uacute;n fuentes cercanas al Palacio Presidencial, el mandatario podr&iacute;a hacer el anuncio en las pr&oacute;ximas horas</p>\r\n<p>Este movimiento pol&iacute;tico supone un hito en la vida democr&aacute;tica del pa&iacute;s y abre un nuevo escenario de cara a los pr&oacute;ximos meses, en un contexto de importantes desaf&iacute;os econ&oacute;micos y sociales.</p>\r\n<p><strong>Reacciones internacionales</strong></p>\r\n<p>Varios pa&iacute;ses de la regi&oacute;n han manifestado su respeto por la decisi&oacute;n adoptada y han expresado su confianza en que el proceso de transici&oacute;n se desarrolle con normalidad y estabilidad.</p>\r\n<p>La Uni&oacute;n Africana y la CEDEAO han emitido comunicados en los que destacan "la importancia de la estabilidad institucional y el respeto a los procedimientos constitucionales".</p>\r\n<p>Esta noticia est&aacute; en desarrollo y se ir&aacute; actualizando a medida que se conozcan nuevos detalles.</p>	\N	\N	\N	noticias/P9YwRz7QNmOlNNlXb1ajfLWWZdAUvJfEyHQV5zli.png	institucional	2026-06-18	t	t	0	1	\N	\N	2026-06-18 19:16:38	2026-06-18 19:16:38
8	Reunión bilateral con delegación parlamentaria de España	\N	\N	\N	reunion-bilateral-espana	Una delegación parlamentaria de España visitó la Cámara para fortalecer las relaciones bilaterales.	\N	\N	\N	Una delegación de la Comisión de Asuntos Exteriores del Congreso de los Diputados de España realizó una visita oficial a la Cámara de Diputados de Guinea Ecuatorial. Ambas delegaciones discutieron temas de cooperación bilateral, intercambio de experiencias legislativas y proyectos conjuntos de desarrollo.	\N	\N	\N	noticias/8.jpg	internacional	2024-05-20	t	f	0	1	\N	\N	2026-06-17 17:08:42	2026-06-18 08:37:13
6	Jornada de puertas abiertas en la Cámara de Diputados	\N	\N	\N	jornada-puertas-abiertas-camara	La Cámara de Diputados organizó una jornada de puertas abiertas para acercar la institución a los ciudadanos.	\N	\N	\N	Con gran éxito, la Cámara de Diputados celebró su primera jornada de puertas abiertas del año. Cientos de ciudadanos visitaron las instalaciones, conocieron el trabajo de los diputados y participaron en talleres sobre participación ciudadana. El evento busca fortalecer la confianza en las instituciones democráticas.	\N	\N	\N	noticias/6.jpg	eventos	2024-05-28	t	f	1	1	\N	\N	2026-06-17 17:08:42	2026-06-18 08:37:14
1	Cámara de Diputados aprueba nueva Ley de Transparencia	\N	\N	\N	nueva-ley-transparencia-aprobada	La Cámara de Diputados aprobó por unanimidad la nueva Ley de Transparencia que garantiza el acceso a la información pública.	\N	\N	\N	En una sesión histórica, la Cámara de Diputados de Guinea Ecuatorial aprobó la nueva Ley de Transparencia. Esta ley establece mecanismos claros para que los ciudadanos puedan acceder a la información pública de manera ágil y efectiva. La ley fue presentada por la Comisión de Justicia y recibió el apoyo de todos los grupos parlamentarios. Entrará en vigor en los próximos 90 días.	\N	\N	\N	noticias/1.jpg	legislativo	2024-06-15	t	t	1	1	\N	\N	2026-06-17 17:08:42	2026-06-18 08:58:13
10	Informe anual de gestión 2023 presentado a la Cámara	\N	\N	\N	informe-gestion-2023	El Gobierno presentó el informe anual de gestión correspondiente al año 2023 ante la Cámara de Diputados.	\N	\N	\N	El Primer Ministro presentó ante el pleno de la Cámara de Diputados el informe anual de gestión del Gobierno para el año 2023. El informe detalla los avances en materia económica, social e institucional. Los diputados realizarán preguntas y solicitarán aclaraciones en las próximas sesiones de control político.	\N	\N	\N	noticias/10.jpg	institucional	2024-05-10	t	f	4	1	\N	\N	2026-06-17 17:08:42	2026-06-18 18:05:26
11	Dimisión en bloque del Gobierno de Guinea Ecuatorial	\N	\N	\N	dimision-en-bloque-del-gobierno-de-guinea-ecuatorial	El Primer Ministro y todo su gabinete presentaron su dimisión irrevocable ante el Presidente de la República, en un movimiento sin precedentes en la historia política del país.	\N	\N	\N	<p>En un hecho hist&oacute;rico para la pol&iacute;tica nacional, el Primer Ministro de Guinea Ecuatorial y la totalidad de su gabinete ministerial han presentado esta ma&ntilde;ana su dimisi&oacute;n en bloque ante el Presidente de la Rep&uacute;blica. El anuncio se produjo tras una reuni&oacute;n extraordinaria del Consejo de Ministros celebrada en el Palacio Presidencial de Malabo, donde el jefe del Ejecutivo entreg&oacute; la carta de renuncia firmada por todos los miembros del gobierno.</p>\r\n<p><strong>Declaraciones del Primer Ministro</strong></p>\r\n<p><em>En su discurso de despedida, el Primer Ministro manifest&oacute;: "He tomado esta decisi&oacute;n tras una profunda reflexi&oacute;n sobre el futuro de nuestra naci&oacute;n. Agradezco al Presidente de la Rep&uacute;blica por la confianza depositada durante todos estos a&ntilde;os y pongo a disposici&oacute;n del pa&iacute;s mi experiencia para lo que sea necesario"</em></p>\r\n<p>El jefe del Ejecutivo destac&oacute; los logros alcanzados durante su mandato, entre los que mencion&oacute;:</p>\r\n<ul>\r\n<li>El crecimiento econ&oacute;mico sostenido durante los &uacute;ltimos a&ntilde;os</li>\r\n<li>La mejora de las infraestructuras del pa&iacute;s</li>\r\n<li>Los avances en materia de transparencia y modernizaci&oacute;n institucional</li>\r\n<li>El fortalecimiento de las relaciones internacionales</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;<strong>Reacciones pol&iacute;ticas</strong></p>\r\n<p>Desde la C&aacute;mara de Diputados, el Presidente de la misma ha declarado que "se respeta la decisi&oacute;n del Primer Ministro y se trabajar&aacute; para garantizar la estabilidad institucional durante el proceso de transici&oacute;n".</p>\r\n<p>Los distintos grupos parlamentarios han solicitado una sesi&oacute;n extraordinaria para abordar la situaci&oacute;n y conocer los detalles del proceso de relevo gubernamental.</p>\r\n<p><strong>&nbsp;Pr&oacute;ximos pasos</strong></p>\r\n<p>El Presidente de la Rep&uacute;blica tiene ahora la responsabilidad constitucional de designar un nuevo Primer Ministro y conformar un nuevo gobierno. Seg&uacute;n fuentes cercanas al Palacio Presidencial, el mandatario podr&iacute;a hacer el anuncio en las pr&oacute;ximas horas</p>\r\n<p>Este movimiento pol&iacute;tico supone un hito en la vida democr&aacute;tica del pa&iacute;s y abre un nuevo escenario de cara a los pr&oacute;ximos meses, en un contexto de importantes desaf&iacute;os econ&oacute;micos y sociales.</p>\r\n<p><strong>Reacciones internacionales</strong></p>\r\n<p>Varios pa&iacute;ses de la regi&oacute;n han manifestado su respeto por la decisi&oacute;n adoptada y han expresado su confianza en que el proceso de transici&oacute;n se desarrolle con normalidad y estabilidad.</p>\r\n<p>La Uni&oacute;n Africana y la CEDEAO han emitido comunicados en los que destacan "la importancia de la estabilidad institucional y el respeto a los procedimientos constitucionales".</p>\r\n<p>Esta noticia est&aacute; en desarrollo y se ir&aacute; actualizando a medida que se conozcan nuevos detalles.</p>	\N	\N	\N	noticias/RT1xrSwO4Wnyzz9VF2ryZAvu1vDlxebB7aiVFhtU.png	institucional	2026-06-18	t	t	1	1	\N	2026-06-18 19:22:10	2026-06-18 19:14:43	2026-06-18 19:22:10
3	Comisión de Salud presenta informe sobre sistema sanitario	\N	\N	\N	comision-salud-informe-sanitario	La Comisión de Salud presentó un informe detallado sobre el estado del sistema sanitario nacional y propone mejoras.	\N	\N	\N	La Comisión de Salud de la Cámara de Diputados presentó un exhaustivo informe sobre el estado del sistema sanitario en Guinea Ecuatorial. El documento incluye recomendaciones para mejorar la infraestructura hospitalaria, la formación de personal médico y el acceso a medicamentos en zonas rurales. El informe será debatido en las próximas sesiones plenarias.	\N	\N	\N	\N	comunicados	2024-06-08	f	f	1	1	\N	\N	2026-06-17 17:08:42	2026-06-19 06:28:32
\.


--
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sessions (id, user_id, ip_address, user_agent, payload, last_activity) FROM stdin;
Wmyq0o1V6q0VYiAVZA726oUNAGC9v5j0NBUNzhLw	1	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36	eyJfdG9rZW4iOiJyb2xKZ2RZSjFSZTFDckcwOWlqa1NnbUFJcWF5cTlONmp5ZXRpSVRVIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hZG1pblwvbm90aWNpYXNcL2NyZWF0ZSIsInJvdXRlIjoiYWRtaW4ubm90aWNpYXMuY3JlYXRlIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjF9	1781808935
iIM5mZVltvMl3TkHOWDiJrIJLBtMZBSz6gNmo75e	1	172.20.36.34	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:152.0) Gecko/20100101 Firefox/152.0	eyJfdG9rZW4iOiJSV01lOUNYM2U3UDZtZzVJSVhlQ2NXNW1rQ3dFQUpFVXJFVTduMDBkIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvc3dhcHBvZG1ncjo4MDAwXC9hZG1pblwvbm90aWNpYXMiLCJyb3V0ZSI6ImFkbWluLm5vdGljaWFzLmluZGV4In0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxfQ==	1781810530
3B88qQVi3K30IWRCZSGXHnd5irXH5sjxu9zUScvG	\N	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36	eyJfdG9rZW4iOiJKM3RGRTZVMWhGMVJmZ3FiS1FFNzVVZWdxRmU3a0tBaGt1eWJYam5UIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvbG9jYWxob3N0OjgwMDBcL2FkbWluXC91c2Vycz9yb2xlPSZzZWFyY2g9JnN0YXR1cz1hY3RpdmUifSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9yZWdpc3RlciIsInJvdXRlIjoicmVnaXN0ZXIifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==	1781800365
81NqLSITDqRXZV3dlCntsMas7n6GKva43m3TU8Z1	1	172.20.36.34	Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:152.0) Gecko/20100101 Firefox/152.0	eyJfdG9rZW4iOiJ3QWxwUUxmY0JRWko5R0s2eENVbmxGbWFWdERwQ3ZTbzdrdzhZdnJSIiwidXJsIjpbXSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3N3YXBwb2RtZ3I6ODAwMFwvYWRtaW5cL2RpcHV0YWRvcyIsInJvdXRlIjoiYWRtaW4uZGlwdXRhZG9zLmluZGV4In0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjF9	1781852398
\.


--
-- Data for Name: transparencia; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.transparencia (id, title_es, title_fr, title_pt, title_en, category, year, file_pdf, file_excel, description_es, description_fr, description_pt, description_en, publication_date, is_public, downloads, deleted_at, created_at, updated_at) FROM stdin;
1	Presupuesto General del Estado 2025	\N	\N	\N	presupuesto	2025	\N	\N	Documento detallado del presupuesto general del estado para el año fiscal 2025.	\N	\N	\N	2024-01-01	t	0	\N	2026-06-17 17:23:34	2026-06-17 17:23:34
2	Informe de Gestión 2023	\N	\N	\N	informe_gestion	2023	\N	\N	Informe anual de gestión de la Cámara de Diputados correspondiente al año 2023.	\N	\N	\N	2024-02-15	t	0	\N	2026-06-17 17:23:34	2026-06-17 17:23:34
3	Rendición de Cuentas 2023	\N	\N	\N	rendicion_cuentas	2023	\N	\N	Documento de rendición de cuentas de la gestión parlamentaria del año 2023.	\N	\N	\N	2024-03-20	t	0	\N	2026-06-17 17:23:34	2026-06-17 17:23:34
4	Plan Estratégico 2024-2028	\N	\N	\N	planificacion	2024	\N	\N	Plan estratégico de la Cámara de Diputados para el período 2024-2028.	\N	\N	\N	2024-04-10	t	0	\N	2026-06-17 17:23:34	2026-06-17 17:23:34
5	Contrataciones Públicas 2024	\N	\N	\N	contrataciones	2024	\N	\N	Informe sobre contrataciones públicas realizadas por la Cámara de Diputados en el año 2024.	\N	\N	\N	2024-05-01	t	0	\N	2026-06-17 17:23:34	2026-06-17 17:23:34
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, name, last_name, email, email_verified_at, password, remember_token, phone, "position", role, is_active, last_login, avatar, created_at, updated_at) FROM stdin;
2	MenosNueve	Test	tra.test@test.com	2026-06-17 18:00:56	$2y$12$7s28.97bdzPc0kANq89QCOWeLj/VbVE5oLufgqH75bTa5euPeW7Y.	\N	\N	\N	viewer	t	\N	\N	2026-06-17 18:00:56	2026-06-18 11:48:20
3	Aurelio	Besupa	aurelio@parlamentoge.qq	2026-06-18 11:50:38	$2y$12$FCP4avb6OVN2WrOg8qxi0Of2Kw6d1x.3S.j0Isc25otPeRrkD2fr6	\N	\N	\N	editor	f	\N	\N	2026-06-18 11:50:38	2026-06-18 11:50:38
1	Admin	Sistema	admin@parlamentoge.qq	2026-06-17 16:09:23	$2y$12$n0E/M/FMjcVBvzjYnKIbAO9miihfOEhV.KSER1Ze5YY/WtKMVGAcW	Lrk79WgHof7ZsOsGQBiR98vs3u4S8zLG3MrGfbVvaRzgtTIt8K2LGi4NEr99	\N	\N	admin	t	2026-06-19 06:28:32	\N	2026-06-17 16:09:27	2026-06-19 06:28:32
\.


--
-- Name: comisiones_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.comisiones_id_seq', 3, true);


--
-- Name: consultas_ciudadanas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.consultas_ciudadanas_id_seq', 6, true);


--
-- Name: diputado_comision_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.diputado_comision_id_seq', 3, true);


--
-- Name: diputados_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.diputados_id_seq', 5, true);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: galeria_imagenes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.galeria_imagenes_id_seq', 1, false);


--
-- Name: institutional_info_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.institutional_info_id_seq', 9, true);


--
-- Name: leyes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.leyes_id_seq', 5, true);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 16, true);


--
-- Name: multimedia_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.multimedia_id_seq', 1, false);


--
-- Name: noticias_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.noticias_id_seq', 12, true);


--
-- Name: transparencia_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.transparencia_id_seq', 5, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 3, true);


--
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- Name: comisiones comisiones_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.comisiones
    ADD CONSTRAINT comisiones_pkey PRIMARY KEY (id);


--
-- Name: consultas_ciudadanas consultas_ciudadanas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.consultas_ciudadanas
    ADD CONSTRAINT consultas_ciudadanas_pkey PRIMARY KEY (id);


--
-- Name: diputado_comision diputado_comision_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.diputado_comision
    ADD CONSTRAINT diputado_comision_pkey PRIMARY KEY (id);


--
-- Name: diputados diputados_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.diputados
    ADD CONSTRAINT diputados_email_unique UNIQUE (email);


--
-- Name: diputados diputados_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.diputados
    ADD CONSTRAINT diputados_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: galeria_imagenes galeria_imagenes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.galeria_imagenes
    ADD CONSTRAINT galeria_imagenes_pkey PRIMARY KEY (id);


--
-- Name: institutional_info institutional_info_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.institutional_info
    ADD CONSTRAINT institutional_info_pkey PRIMARY KEY (id);


--
-- Name: leyes leyes_code_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.leyes
    ADD CONSTRAINT leyes_code_unique UNIQUE (code);


--
-- Name: leyes leyes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.leyes
    ADD CONSTRAINT leyes_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: multimedia multimedia_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.multimedia
    ADD CONSTRAINT multimedia_pkey PRIMARY KEY (id);


--
-- Name: noticias noticias_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.noticias
    ADD CONSTRAINT noticias_pkey PRIMARY KEY (id);


--
-- Name: noticias noticias_slug_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.noticias
    ADD CONSTRAINT noticias_slug_unique UNIQUE (slug);


--
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: transparencia transparencia_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.transparencia
    ADD CONSTRAINT transparencia_pkey PRIMARY KEY (id);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- Name: consultas_ciudadanas consultas_ciudadanas_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.consultas_ciudadanas
    ADD CONSTRAINT consultas_ciudadanas_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id);


--
-- Name: diputado_comision diputado_comision_comision_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.diputado_comision
    ADD CONSTRAINT diputado_comision_comision_id_foreign FOREIGN KEY (comision_id) REFERENCES public.comisiones(id) ON DELETE CASCADE;


--
-- Name: diputado_comision diputado_comision_diputado_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.diputado_comision
    ADD CONSTRAINT diputado_comision_diputado_id_foreign FOREIGN KEY (diputado_id) REFERENCES public.diputados(id) ON DELETE CASCADE;


--
-- Name: galeria_imagenes galeria_imagenes_noticia_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.galeria_imagenes
    ADD CONSTRAINT galeria_imagenes_noticia_id_foreign FOREIGN KEY (noticia_id) REFERENCES public.noticias(id) ON DELETE CASCADE;


--
-- Name: leyes leyes_comision_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.leyes
    ADD CONSTRAINT leyes_comision_id_foreign FOREIGN KEY (comision_id) REFERENCES public.comisiones(id);


--
-- Name: leyes leyes_diputado_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.leyes
    ADD CONSTRAINT leyes_diputado_id_foreign FOREIGN KEY (diputado_id) REFERENCES public.diputados(id);


--
-- Name: noticias noticias_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.noticias
    ADD CONSTRAINT noticias_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id);


--
-- Name: SCHEMA public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE USAGE ON SCHEMA public FROM PUBLIC;


--
-- PostgreSQL database dump complete
--

\unrestrict XY1WdOTKFjq3vglkC7d67td6bymCK4gvuKT4VZEGKPXL3bAg0z8ugiHIz5wFnVz

