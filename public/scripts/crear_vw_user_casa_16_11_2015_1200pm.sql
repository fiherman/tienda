create or REPLACE VIEW vw_user_casa AS 
 SELECT a.id,
    a.cas_id,
    a.ape_nom,
    a.usuario,
    a.fono,
    a.cad_lar,
    a.estado,
    b.cas_des
   FROM users a
     LEFT JOIN casas b ON a.cas_id::text = b.cas_id::text;


CREATE OR REPLACE VIEW vw_cliente_casa AS 
 SELECT 
    a.cli_id,
    a.cas_id,
    a.cli_ape,
    a.cli_nom,
    a.cli_dir,
    a.cli_dni,
    a.cli_movil,
    a.cli_fijo,
    a.cli_estado,
    a.cli_cad_lar,
    b.cas_des    
   FROM cliente a
     LEFT JOIN casas b on a.cas_id=b.cas_id


INSERT INTO prestamo(
            pmo_id, user_id, cli_id, pmo_pagado, pmo_num, pmo_num_prendas, 
            pmo_fch_reg, pmo_fch_up, pmo_ano_eje)
    VALUES ('P1', 1, 'C1', 'NO', 1, 4, 
            '12-12-2015 05:00:00', '12-12-2015 05:00:00', '2015');

INSERT INTO amortizar(
            amo_id, pmo_id, user_id, cli_id, amo_des, amo_monto, amo_moneda, 
            amo_fch_reg, amo_fch_up, amo_ano_eje)
    VALUES ('AMO1', 'PMO2', 1, 'C1', 'AMORTIZACION', 300.00, 'SOL', 
            '2015-11-24 14:44:54', '2015-11-24 14:44:54', '2015');