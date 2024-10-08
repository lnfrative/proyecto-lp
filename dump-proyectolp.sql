PGDMP          
            |         
   proyectolp     16.3 (Ubuntu 16.3-1.pgdg24.04+1)    16.3 A    �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    25313 
   proyectolp    DATABASE     v   CREATE DATABASE proyectolp WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'en_US.UTF-8';
    DROP DATABASE proyectolp;
             
   proyectolp    false                        2615    2200    public    SCHEMA        CREATE SCHEMA public;
    DROP SCHEMA public;
                pg_database_owner    false            �           0    0    SCHEMA public    COMMENT     6   COMMENT ON SCHEMA public IS 'standard public schema';
                   pg_database_owner    false    4            �            1255    25358    notify_messenger_messages()    FUNCTION     �   CREATE FUNCTION public.notify_messenger_messages() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
            BEGIN
                PERFORM pg_notify('messenger_messages', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$;
 2   DROP FUNCTION public.notify_messenger_messages();
       public       
   proyectolp    false    4            �            1259    25433    cubiculo    TABLE     Z   CREATE TABLE public.cubiculo (
    id integer NOT NULL,
    capacidad integer NOT NULL
);
    DROP TABLE public.cubiculo;
       public         heap 
   proyectolp    false    4            �            1259    25429    cubiculo_id_seq    SEQUENCE     x   CREATE SEQUENCE public.cubiculo_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.cubiculo_id_seq;
       public       
   proyectolp    false    4            �            1259    25389    doctrine_migration_versions    TABLE     �   CREATE TABLE public.doctrine_migration_versions (
    version character varying(191) NOT NULL,
    executed_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    execution_time integer
);
 /   DROP TABLE public.doctrine_migration_versions;
       public         heap 
   proyectolp    false    4            �            1259    25438    horario    TABLE     f   CREATE TABLE public.horario (
    id integer NOT NULL,
    hora time(0) without time zone NOT NULL
);
    DROP TABLE public.horario;
       public         heap 
   proyectolp    false    4            �            1259    25430    horario_id_seq    SEQUENCE     w   CREATE SEQUENCE public.horario_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.horario_id_seq;
       public       
   proyectolp    false    4            �            1259    25411    messenger_messages    TABLE     s  CREATE TABLE public.messenger_messages (
    id bigint NOT NULL,
    body text NOT NULL,
    headers text NOT NULL,
    queue_name character varying(190) NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    available_at timestamp(0) without time zone NOT NULL,
    delivered_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone
);
 &   DROP TABLE public.messenger_messages;
       public         heap 
   proyectolp    false    4            �           0    0 $   COLUMN messenger_messages.created_at    COMMENT     Z   COMMENT ON COLUMN public.messenger_messages.created_at IS '(DC2Type:datetime_immutable)';
          public       
   proyectolp    false    221            �           0    0 &   COLUMN messenger_messages.available_at    COMMENT     \   COMMENT ON COLUMN public.messenger_messages.available_at IS '(DC2Type:datetime_immutable)';
          public       
   proyectolp    false    221            �           0    0 &   COLUMN messenger_messages.delivered_at    COMMENT     \   COMMENT ON COLUMN public.messenger_messages.delivered_at IS '(DC2Type:datetime_immutable)';
          public       
   proyectolp    false    221            �            1259    25410    messenger_messages_id_seq    SEQUENCE     �   CREATE SEQUENCE public.messenger_messages_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE public.messenger_messages_id_seq;
       public       
   proyectolp    false    4    221            �           0    0    messenger_messages_id_seq    SEQUENCE OWNED BY     W   ALTER SEQUENCE public.messenger_messages_id_seq OWNED BY public.messenger_messages.id;
          public       
   proyectolp    false    220            �            1259    25443    reserva    TABLE     �   CREATE TABLE public.reserva (
    id integer NOT NULL,
    estado_id integer NOT NULL,
    usuario_id integer NOT NULL,
    cubiculo_id integer NOT NULL,
    horario_id integer NOT NULL,
    created_at timestamp(0) without time zone NOT NULL
);
    DROP TABLE public.reserva;
       public         heap 
   proyectolp    false    4            �           0    0    COLUMN reserva.created_at    COMMENT     O   COMMENT ON COLUMN public.reserva.created_at IS '(DC2Type:datetime_immutable)';
          public       
   proyectolp    false    228            �            1259    25452    reserva_estado    TABLE     l   CREATE TABLE public.reserva_estado (
    id integer NOT NULL,
    estado character varying(255) NOT NULL
);
 "   DROP TABLE public.reserva_estado;
       public         heap 
   proyectolp    false    4            �            1259    25432    reserva_estado_id_seq    SEQUENCE     ~   CREATE SEQUENCE public.reserva_estado_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ,   DROP SEQUENCE public.reserva_estado_id_seq;
       public       
   proyectolp    false    4            �            1259    25431    reserva_id_seq    SEQUENCE     w   CREATE SEQUENCE public.reserva_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.reserva_id_seq;
       public       
   proyectolp    false    4            �            1259    25397    usuario    TABLE     �   CREATE TABLE public.usuario (
    id integer NOT NULL,
    rol_id integer NOT NULL,
    email character varying(255) NOT NULL,
    password character varying(255) NOT NULL
);
    DROP TABLE public.usuario;
       public         heap 
   proyectolp    false    4            �            1259    25395    usuario_id_seq    SEQUENCE     w   CREATE SEQUENCE public.usuario_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.usuario_id_seq;
       public       
   proyectolp    false    4            �            1259    25405    usuario_rol    TABLE     f   CREATE TABLE public.usuario_rol (
    id integer NOT NULL,
    rol character varying(255) NOT NULL
);
    DROP TABLE public.usuario_rol;
       public         heap 
   proyectolp    false    4            �            1259    25396    usuario_rol_id_seq    SEQUENCE     {   CREATE SEQUENCE public.usuario_rol_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.usuario_rol_id_seq;
       public       
   proyectolp    false    4            �           2604    25414    messenger_messages id    DEFAULT     ~   ALTER TABLE ONLY public.messenger_messages ALTER COLUMN id SET DEFAULT nextval('public.messenger_messages_id_seq'::regclass);
 D   ALTER TABLE public.messenger_messages ALTER COLUMN id DROP DEFAULT;
       public       
   proyectolp    false    221    220    221            �          0    25433    cubiculo 
   TABLE DATA           1   COPY public.cubiculo (id, capacidad) FROM stdin;
    public       
   proyectolp    false    226   I       �          0    25389    doctrine_migration_versions 
   TABLE DATA           [   COPY public.doctrine_migration_versions (version, executed_at, execution_time) FROM stdin;
    public       
   proyectolp    false    215   2I       �          0    25438    horario 
   TABLE DATA           +   COPY public.horario (id, hora) FROM stdin;
    public       
   proyectolp    false    227   �I       �          0    25411    messenger_messages 
   TABLE DATA           s   COPY public.messenger_messages (id, body, headers, queue_name, created_at, available_at, delivered_at) FROM stdin;
    public       
   proyectolp    false    221   �I       �          0    25443    reserva 
   TABLE DATA           a   COPY public.reserva (id, estado_id, usuario_id, cubiculo_id, horario_id, created_at) FROM stdin;
    public       
   proyectolp    false    228   J       �          0    25452    reserva_estado 
   TABLE DATA           4   COPY public.reserva_estado (id, estado) FROM stdin;
    public       
   proyectolp    false    229   tJ       �          0    25397    usuario 
   TABLE DATA           >   COPY public.usuario (id, rol_id, email, password) FROM stdin;
    public       
   proyectolp    false    218   �J       �          0    25405    usuario_rol 
   TABLE DATA           .   COPY public.usuario_rol (id, rol) FROM stdin;
    public       
   proyectolp    false    219   �K       �           0    0    cubiculo_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.cubiculo_id_seq', 8, true);
          public       
   proyectolp    false    222            �           0    0    horario_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.horario_id_seq', 1, false);
          public       
   proyectolp    false    223            �           0    0    messenger_messages_id_seq    SEQUENCE SET     H   SELECT pg_catalog.setval('public.messenger_messages_id_seq', 1, false);
          public       
   proyectolp    false    220            �           0    0    reserva_estado_id_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('public.reserva_estado_id_seq', 1, false);
          public       
   proyectolp    false    225            �           0    0    reserva_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.reserva_id_seq', 48, true);
          public       
   proyectolp    false    224            �           0    0    usuario_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.usuario_id_seq', 10, true);
          public       
   proyectolp    false    216            �           0    0    usuario_rol_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('public.usuario_rol_id_seq', 1, false);
          public       
   proyectolp    false    217            �           2606    25437    cubiculo cubiculo_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.cubiculo
    ADD CONSTRAINT cubiculo_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.cubiculo DROP CONSTRAINT cubiculo_pkey;
       public         
   proyectolp    false    226            �           2606    25394 <   doctrine_migration_versions doctrine_migration_versions_pkey 
   CONSTRAINT        ALTER TABLE ONLY public.doctrine_migration_versions
    ADD CONSTRAINT doctrine_migration_versions_pkey PRIMARY KEY (version);
 f   ALTER TABLE ONLY public.doctrine_migration_versions DROP CONSTRAINT doctrine_migration_versions_pkey;
       public         
   proyectolp    false    215            �           2606    25442    horario horario_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.horario
    ADD CONSTRAINT horario_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.horario DROP CONSTRAINT horario_pkey;
       public         
   proyectolp    false    227            �           2606    25419 *   messenger_messages messenger_messages_pkey 
   CONSTRAINT     h   ALTER TABLE ONLY public.messenger_messages
    ADD CONSTRAINT messenger_messages_pkey PRIMARY KEY (id);
 T   ALTER TABLE ONLY public.messenger_messages DROP CONSTRAINT messenger_messages_pkey;
       public         
   proyectolp    false    221            �           2606    25456 "   reserva_estado reserva_estado_pkey 
   CONSTRAINT     `   ALTER TABLE ONLY public.reserva_estado
    ADD CONSTRAINT reserva_estado_pkey PRIMARY KEY (id);
 L   ALTER TABLE ONLY public.reserva_estado DROP CONSTRAINT reserva_estado_pkey;
       public         
   proyectolp    false    229            �           2606    25447    reserva reserva_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.reserva
    ADD CONSTRAINT reserva_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.reserva DROP CONSTRAINT reserva_pkey;
       public         
   proyectolp    false    228            �           2606    25403    usuario usuario_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.usuario
    ADD CONSTRAINT usuario_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.usuario DROP CONSTRAINT usuario_pkey;
       public         
   proyectolp    false    218            �           2606    25409    usuario_rol usuario_rol_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.usuario_rol
    ADD CONSTRAINT usuario_rol_pkey PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.usuario_rol DROP CONSTRAINT usuario_rol_pkey;
       public         
   proyectolp    false    219            �           1259    25450    idx_188d2e3b48d6b68a    INDEX     O   CREATE INDEX idx_188d2e3b48d6b68a ON public.reserva USING btree (cubiculo_id);
 (   DROP INDEX public.idx_188d2e3b48d6b68a;
       public         
   proyectolp    false    228            �           1259    25451    idx_188d2e3b4959f1ba    INDEX     N   CREATE INDEX idx_188d2e3b4959f1ba ON public.reserva USING btree (horario_id);
 (   DROP INDEX public.idx_188d2e3b4959f1ba;
       public         
   proyectolp    false    228            �           1259    25448    idx_188d2e3b9f5a440b    INDEX     M   CREATE INDEX idx_188d2e3b9f5a440b ON public.reserva USING btree (estado_id);
 (   DROP INDEX public.idx_188d2e3b9f5a440b;
       public         
   proyectolp    false    228            �           1259    25449    idx_188d2e3bdb38439e    INDEX     N   CREATE INDEX idx_188d2e3bdb38439e ON public.reserva USING btree (usuario_id);
 (   DROP INDEX public.idx_188d2e3bdb38439e;
       public         
   proyectolp    false    228            �           1259    25404    idx_2265b05d4bab96c    INDEX     I   CREATE INDEX idx_2265b05d4bab96c ON public.usuario USING btree (rol_id);
 '   DROP INDEX public.idx_2265b05d4bab96c;
       public         
   proyectolp    false    218            �           1259    25422    idx_75ea56e016ba31db    INDEX     [   CREATE INDEX idx_75ea56e016ba31db ON public.messenger_messages USING btree (delivered_at);
 (   DROP INDEX public.idx_75ea56e016ba31db;
       public         
   proyectolp    false    221            �           1259    25421    idx_75ea56e0e3bd61ce    INDEX     [   CREATE INDEX idx_75ea56e0e3bd61ce ON public.messenger_messages USING btree (available_at);
 (   DROP INDEX public.idx_75ea56e0e3bd61ce;
       public         
   proyectolp    false    221            �           1259    25420    idx_75ea56e0fb7336f0    INDEX     Y   CREATE INDEX idx_75ea56e0fb7336f0 ON public.messenger_messages USING btree (queue_name);
 (   DROP INDEX public.idx_75ea56e0fb7336f0;
       public         
   proyectolp    false    221            �           2620    25423 !   messenger_messages notify_trigger    TRIGGER     �   CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON public.messenger_messages FOR EACH ROW EXECUTE FUNCTION public.notify_messenger_messages();
 :   DROP TRIGGER notify_trigger ON public.messenger_messages;
       public       
   proyectolp    false    230    221            �           2606    25467    reserva fk_188d2e3b48d6b68a    FK CONSTRAINT     �   ALTER TABLE ONLY public.reserva
    ADD CONSTRAINT fk_188d2e3b48d6b68a FOREIGN KEY (cubiculo_id) REFERENCES public.cubiculo(id);
 E   ALTER TABLE ONLY public.reserva DROP CONSTRAINT fk_188d2e3b48d6b68a;
       public       
   proyectolp    false    226    3300    228            �           2606    25472    reserva fk_188d2e3b4959f1ba    FK CONSTRAINT        ALTER TABLE ONLY public.reserva
    ADD CONSTRAINT fk_188d2e3b4959f1ba FOREIGN KEY (horario_id) REFERENCES public.horario(id);
 E   ALTER TABLE ONLY public.reserva DROP CONSTRAINT fk_188d2e3b4959f1ba;
       public       
   proyectolp    false    3302    228    227            �           2606    25457    reserva fk_188d2e3b9f5a440b    FK CONSTRAINT     �   ALTER TABLE ONLY public.reserva
    ADD CONSTRAINT fk_188d2e3b9f5a440b FOREIGN KEY (estado_id) REFERENCES public.reserva_estado(id);
 E   ALTER TABLE ONLY public.reserva DROP CONSTRAINT fk_188d2e3b9f5a440b;
       public       
   proyectolp    false    229    228    3310            �           2606    25462    reserva fk_188d2e3bdb38439e    FK CONSTRAINT        ALTER TABLE ONLY public.reserva
    ADD CONSTRAINT fk_188d2e3bdb38439e FOREIGN KEY (usuario_id) REFERENCES public.usuario(id);
 E   ALTER TABLE ONLY public.reserva DROP CONSTRAINT fk_188d2e3bdb38439e;
       public       
   proyectolp    false    218    3291    228            �           2606    25424    usuario fk_2265b05d4bab96c    FK CONSTRAINT     ~   ALTER TABLE ONLY public.usuario
    ADD CONSTRAINT fk_2265b05d4bab96c FOREIGN KEY (rol_id) REFERENCES public.usuario_rol(id);
 D   ALTER TABLE ONLY public.usuario DROP CONSTRAINT fk_2265b05d4bab96c;
       public       
   proyectolp    false    3293    218    219            �      x�3�4��4����� ��      �   t   x�s�O.)��K��L/J,���+��	K-*���L,�,8A\]]CsK+C �4�07�r!�cCS4#�M�����̘#@�X["��P04��t���W� 
�7�      �   -   x�3�4��20 ".#NC(Ә���4�44�2M9͠�=... 8
      �      x������ � �      �   T   x�]���0��g��� �R�,�?�$�h|��;L�ТA&�.�͛hΑ"������zΝb��ayT���J �����[�s�3_�1      �   7   x�3�t�wrt��2�p�s�t�q�2�ru�p���p:;�9����1z\\\ BD�      �   �   x�m�Kr�0  �59�!H�]팣"-��MJB'�	?m��z /��QY����{i�QX�ֲݻ��͎���{XEI�c{�?q���A�:�yE�}��TՂ��(d��W"���G�1[�����(?d���Vл��d�E�m�`�� ȱ\�y�J-�Y�pIz
ܮ�ݧ�"��2��U�b!Ή�:��l�~�!��B�	I�! �#O&      �   *   x�3�tL����,.)JL�/�2�t-.)M�L�+I����� �>
�     