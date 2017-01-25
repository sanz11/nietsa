-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-01-2017 a las 15:10:50
-- Versión del servidor: 10.1.16-MariaDB
-- Versión de PHP: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `osaerp_nippon`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `COMPROBANTE_DISPARADOR` (IN `CODIGO_FACTURA` INT(11))  BLOCK1:BEGIN
DECLARE CPP_Codigo INT(11); 
DECLARE CPC_TipoOperacion CHAR(1); 
DECLARE CPC_TipoDocumento CHAR(1); 
DECLARE PRESUP_Codigo INT(11); 
DECLARE OCOMP_Codigo INT(11); 
DECLARE COMPP_Codigo INT(11); 
DECLARE CPC_Serie CHAR(4); 
DECLARE CPC_Numero VARCHAR(11); 
DECLARE CLIP_Codigo INT(11); 
DECLARE PROVP_Codigo INT(11); 
DECLARE CPC_NombreAuxiliar VARCHAR(25); 
DECLARE USUA_Codigo INT(11); 
DECLARE MONED_Codigo INT(11); 
DECLARE FORPAP_Codigo INT(11); 
DECLARE CPC_subtotal DOUBLE(10,2); 
DECLARE CPC_descuento DOUBLE(10,2); 
DECLARE CPC_igv DOUBLE(10,2); 
DECLARE CPC_total DOUBLE(10,2); 
DECLARE CPC_subtotal_conigv DOUBLE(10,2); 
DECLARE CPC_descuento_conigv DOUBLE(10,2); 
DECLARE CPC_igv100 INT(11); 
DECLARE CPC_descuento100 INT(11); 
DECLARE GUIAREMP_Codigo INT(11); 
DECLARE CPC_GuiaRemCodigo VARCHAR(50); 
DECLARE CPC_DocuRefeCodigo VARCHAR(50); 
DECLARE CPC_Observacion TEXT; 
DECLARE CPC_ModoImpresion CHAR(1); 
DECLARE CPC_Fecha DATE; 
DECLARE CPC_Vendedor INT(11); 
DECLARE CPC_TDC DOUBLE(10,2); 
DECLARE CPC_FlagMueveStock CHAR(1); 
DECLARE GUIASAP_Codigo INT(11); 
DECLARE GUIAINP_Codigo INT(11); 
DECLARE USUA_anula INT(11); 
DECLARE CPC_FechaRegistro TIMESTAMP; 
DECLARE CPC_FechaModificacion DATETIME; 
DECLARE CPC_FlagEstado CHAR(1); 
DECLARE CPC_Hora TIME; 
DECLARE ALMAP_Codigo INT(11); 
DECLARE CPP_Codigo_Canje INT(11);
DECLARE CPC_NumeroAutomatico INT(1);

DECLARE FACTURA_CURSOR cursor for 
SELECT 
			  gs.CPP_Codigo AS CPP_Codigo,
			  gs.CPC_TipoOperacion AS CPC_TipoOperacion,
			  gs.CPC_TipoDocumento AS CPC_TipoDocumento,
			  gs.PRESUP_Codigo AS PRESUP_Codigo,
			  gs.OCOMP_Codigo AS OCOMP_Codigo,
			  gs.COMPP_Codigo AS COMPP_Codigo,
			  gs.CPC_Serie AS CPC_Serie,
			  gs.CPC_Numero AS CPC_Numero,
			  gs.CLIP_Codigo AS CLIP_Codigo,
			  gs.PROVP_Codigo AS PROVP_Codigo,
			  gs.CPC_NombreAuxiliar AS CPC_NombreAuxiliar,
			  gs.USUA_Codigo AS USUA_Codigo,
			  gs.MONED_Codigo AS MONED_Codigo,
			  gs.FORPAP_Codigo AS FORPAP_Codigo,
			  gs.CPC_subtotal AS CPC_subtotal,
			  gs.CPC_descuento AS CPC_descuento,
			  gs.CPC_igv AS CPC_igv,
			  gs.CPC_total AS CPC_total,
			  gs.CPC_subtotal_conigv AS CPC_subtotal_conigv,
			  gs.CPC_descuento_conigv AS CPC_descuento_conigv,
			  gs.CPC_igv100 AS CPC_igv100, 
			  gs.CPC_descuento100 AS CPC_descuento100,
			  gs.GUIAREMP_Codigo AS GUIAREMP_Codigo,
			  gs.CPC_GuiaRemCodigo AS CPC_GuiaRemCodigo,
			  gs.CPC_DocuRefeCodigo AS CPC_DocuRefeCodigo,
			  gs.CPC_Observacion AS CPC_Observacion,
			  gs.CPC_ModoImpresion AS CPC_ModoImpresion,
			  gs.CPC_Fecha AS CPC_Fecha,
			  gs.CPC_Vendedor AS CPC_Vendedor,
			  gs.CPC_TDC AS CPC_TDC,
			  gs.CPC_FlagMueveStock AS CPC_FlagMueveStock,
			  gs.GUIASAP_Codigo AS GUIASAP_Codigo,
			  gs.GUIAINP_Codigo AS GUIAINP_Codigo,
			  gs.USUA_anula AS USUA_anula,
			  gs.CPC_FechaRegistro AS CPC_FechaRegistro,
			  gs.CPC_FechaModificacion AS CPC_FechaModificacion,
			  gs.CPC_FlagEstado AS CPC_FlagEstado,
			  gs.CPC_Hora AS CPC_Hora,
			  gs.ALMAP_Codigo AS ALMAP_Codigo,
			  gs.CPP_Codigo_Canje AS CPP_Codigo_Canje,
			  gs.CPC_NumeroAutomatico AS CPC_NumeroAutomatico
FROM cji_comprobante gs WHERE gs.CPP_Codigo = CODIGO_FACTURA;

DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTAR = TRUE;
	OPEN FACTURA_CURSOR;
	LOOP1: LOOP
	FETCH FACTURA_CURSOR INTO 
			CPP_Codigo,
			  CPC_TipoOperacion,
			  CPC_TipoDocumento,
			  PRESUP_Codigo,
			  OCOMP_Codigo,
			  COMPP_Codigo,
			  CPC_Serie,
			  CPC_Numero,
			  CLIP_Codigo,
			  PROVP_Codigo,
			  CPC_NombreAuxiliar,
			  USUA_Codigo,
			  MONED_Codigo,
			  FORPAP_Codigo,
			  CPC_subtotal,
			  CPC_descuento,
			  CPC_igv,
			  CPC_total,
			  CPC_subtotal_conigv,
			  CPC_descuento_conigv,
			  CPC_igv100, 
			  CPC_descuento100,
			  GUIAREMP_Codigo,
			  CPC_GuiaRemCodigo,
			  CPC_DocuRefeCodigo,
			  CPC_Observacion,
			  CPC_ModoImpresion,
			  CPC_Fecha,
			  CPC_Vendedor,
			  CPC_TDC,
			  CPC_FlagMueveStock,
			  GUIASAP_Codigo,
			  GUIAINP_Codigo,
			  USUA_anula,
			  CPC_FechaRegistro,
			  CPC_FechaModificacion,
			  CPC_FlagEstado,
			  CPC_Hora,
			  ALMAP_Codigo,
			  CPP_Codigo_Canje,
			  CPC_NumeroAutomatico;
	IF @EJECUTAR THEN
		LEAVE LOOP1;
	END IF;
	SET CPC_Fecha=CURDATE();


		
		IF TRIM(CPC_FlagEstado)='1' THEN
			IF (GUIAREMP_Codigo IS NULL OR GUIAREMP_Codigo=0) THEN
				SELECT "NO INGRESO";
			ELSE
				
				SET @DOCUP_Codigo=(SELECT CD.DOCUP_Codigo FROM cji_documento CD WHERE CD.DOCUC_ABREVI=TRIM(CPC_TipoDocumento));
				SET @CUE_TipoCuenta='2';
				IF TRIM(CPC_TipoOperacion)='V' THEN
					SET @CUE_TipoCuenta='1';
				END IF;
				
				SET @CUE_FlagEstadoPago='V';
				SET @CUE_FechaCanc=NULL;
				IF FORPAP_Codigo=1 THEN
					SET @CUE_FlagEstadoPago='C';
					SET @CUE_FechaCanc=NOW();
				END IF;
				
				SET @CUE_Codigo=(SELECT CC.CUE_Codigo FROM cji_cuentas CC WHERE CC.CUE_CodDocumento=CPP_Codigo);
				
				IF (@CUE_Codigo IS NULL OR @CUE_Codigo=0) THEN
					CALL MANTENIMIENTO_CUENTA(@CUE_Codigo,@CUE_TipoCuenta,@DOCUP_Codigo,CPP_Codigo,MONED_Codigo,CPC_total,CPC_Fecha,@CUE_FlagEstadoPago,@CUE_FechaCanc,COMPP_Codigo,NOW(),NULL,1, 0, NULL, NULL, NULL, NULL, NULL);
				ELSE
					CALL MANTENIMIENTO_CUENTA (@CUE_Codigo,NULL,NULL,NULL,NULL,NULL,NULL,@CUE_FlagEstadoPago,@CUE_FechaCanc,NULL,NOW(),NULL,1, 1, NULL, NULL, NULL, NULL, NULL);

				END IF;
				SET @PAGC_Obs='SALIDA GENERADA';
				IF TRIM(CPC_TipoOperacion)='V' THEN
					SET @PAGC_Obs='INGRESO GENERADO';
				END IF;
				SET @PAGC_Obs=CONCAT(@PAGC_Obs,"AUTOMATICAMENTE POR EL PAGO AL CONTADO");

				SET @PAGC_TDC=(SELECT CT.TIPCAMC_FactorConversion FROM cji_tipocambio CT WHERE CT.TIPCAMC_Fecha=CPC_Fecha AND CT.TIPCAMC_MonedaDestino='2' AND CT.COMPP_Codigo=COMPP_Codigo AND CT.TIPCAMC_FlagEstado='1');
				IF FORPAP_Codigo=1 THEN
					SET @PAGP_Codigo='';
					CALL MANTENIMIENTO_PAGO(@PAGP_Codigo,@CUE_TipoCuenta,CPC_Fecha,CLIP_Codigo,PROVP_Codigo,@PAGC_TDC,CPC_total,MONED_Codigo,'1',NULL,NULL,NULL,NULL,NULL,NULL,'0',@PAGC_Obs,COMPP_Codigo,NULL,NULL,'1',0,NULL,NULL,NULL);
					CALL MANTENIMIENTO_CUENTAPAGO('',@CUE_Codigo,@PAGP_Codigo,@PAGC_TDC,CPC_total,MONED_Codigo,NULL,NULL,'1',0,NULL,NULL,NULL,NULL,NULL);
				END IF;
				LEAVE LOOP1;
			END IF;
			
		END IF;

		IF (CPC_FlagEstado='2' OR TRIM(CPC_TipoDocumento)='B') THEN
			SET @DOCUP_Codigo=(SELECT CD.DOCUP_Codigo FROM cji_documento CD WHERE CD.DOCUC_ABREVI=TRIM(CPC_TipoDocumento));
			
			SET @NUMERO=0;
			SET @NUMEROAUMENTADO =0;
			SET @SERIECOMPROBANTE=NULL; 
			IF CPC_NumeroAutomatico=1 THEN 
				SELECT CF.CONFIC_Numero,CF.CONFIC_Serie INTO @NUMERO,@SERIECOMPROBANTE
				FROM cji_configuracion CF WHERE CF.COMPP_Codigo=COMPP_Codigo AND CF.DOCUP_Codigo=@DOCUP_Codigo;
				SET @NUMEROAUMENTADO =LPAD(@NUMERO+1,LENGTH(@NUMERO),'0') ;
			ELSE
				SET @NUMEROAUMENTADO=CPC_Numero;
				SET @SERIECOMPROBANTE=CPC_Serie;
			END IF;
			
			
			SET @ESTADOACTUALIZAR ='1';
			IF TRIM(CPC_TipoOperacion)='V' THEN
				CALL MANTENIMIENTO_COMPROBANTE(CODIGO_FACTURA, NULL, NULL, NULL, NULL, NULL,@SERIECOMPROBANTE,@NUMEROAUMENTADO, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, @ESTADOACTUALIZAR, NULL, NULL, NULL, 1, NULL, NULL, NULL,NULL);
			END IF;
		
			
			IF TRIM(CPC_TipoOperacion)='V' AND CPC_NumeroAutomatico=1  THEN
				UPDATE  cji_configuracion CF SET CF.CONFIC_Numero=@NUMEROAUMENTADO WHERE CF.COMPP_Codigo=COMPP_Codigo AND  CF.DOCUP_Codigo=@DOCUP_Codigo;
			END IF;
			
			
			SET @CUE_TipoCuenta='2';
			IF TRIM(CPC_TipoOperacion)='V' THEN
				SET @CUE_TipoCuenta='1';
			END IF;
			
			SET @CUE_FlagEstadoPago='V';
			SET @CUE_FechaCanc=NULL;
			IF FORPAP_Codigo=1 THEN
				SET @CUE_FlagEstadoPago='C';
				SET @CUE_FechaCanc=NOW();
			END IF;
			
			SET @CUE_Codigo=(SELECT CC.CUE_Codigo FROM cji_cuentas CC WHERE CC.CUE_CodDocumento=CPP_Codigo);
			
			IF (@CUE_Codigo IS NULL OR @CUE_Codigo=0)THEN
				CALL MANTENIMIENTO_CUENTA (@CUE_Codigo,@CUE_TipoCuenta,@DOCUP_Codigo,CPP_Codigo,MONED_Codigo,CPC_total,CPC_Fecha,@CUE_FlagEstadoPago,@CUE_FechaCanc,COMPP_Codigo,NOW(),NULL,1, 0, NULL, NULL, NULL, NULL, NULL);
			ELSE
				CALL MANTENIMIENTO_CUENTA (@CUE_Codigo,NULL,NULL,NULL,NULL,NULL,NULL,@CUE_FlagEstadoPago,@CUE_FechaCanc,NULL,NOW(),NULL,1, 1, NULL, NULL, NULL, NULL, NULL);
			END IF;
			
			
			SET @PAGC_Obs='SALIDA GENERADA';
			IF TRIM(CPC_TipoOperacion)='V' THEN
				SET @PAGC_Obs='INGRESO GENERADO';
			END IF;
			SET @PAGC_Obs=CONCAT(@PAGC_Obs,"AUTOMATICAMENTE POR EL PAGO AL CONTADO");
			SET @PAGC_TDC=(SELECT CT.TIPCAMC_FactorConversion FROM cji_tipocambio CT WHERE CT.TIPCAMC_Fecha=CPC_Fecha AND CT.TIPCAMC_MonedaDestino='2' AND CT.COMPP_Codigo=COMPP_Codigo AND CT.TIPCAMC_FlagEstado='1');
			IF FORPAP_Codigo=1 THEN
				SET @PAGP_Codigo='';
				CALL MANTENIMIENTO_PAGO(@PAGP_Codigo,@CUE_TipoCuenta,CPC_Fecha,CLIP_Codigo,PROVP_Codigo,@PAGC_TDC,CPC_total,MONED_Codigo,'1',NULL,NULL,NULL,NULL,NULL,NULL,'0',@PAGC_Obs,COMPP_Codigo,NULL,NULL,'1',0,NULL,NULL,NULL);
				CALL MANTENIMIENTO_CUENTAPAGO('',@CUE_Codigo,@PAGP_Codigo,@PAGC_TDC,CPC_total,MONED_Codigo,NULL,NULL,'1',0,NULL,NULL,NULL,NULL,NULL);
			END IF;
			
			
			SET @COUNTGUIAREM=(SELECT COUNT(*) FROM cji_comprobante_guiarem CPBGR WHERE CPBGR.CPP_Codigo=CODIGO_FACTURA AND CPBGR.COMPGUI_FlagEstado!=3);
			
			IF (@COUNTGUIAREM IS NOT NULL AND @COUNTGUIAREM<>0) THEN
				CALL MANTENIMIENTO_COMPROBANTE(CODIGO_FACTURA, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0,0,0,NULL, NULL, NULL, @ESTADOACTUALIZAR, NULL, NULL, NULL, 1, NULL, NULL, NULL,NULL);
				LEAVE LOOP1;
			END IF;
			
			SET @NUMEROAUMENTADO=0;
			SET @CODIGODOCUMENTO=0;
			SET GUIASAP_Codigo='';
			SET GUIAINP_Codigo='';
			IF TRIM(CPC_TipoOperacion)='V' THEN 
				
				SET @CODIGODOCUMENTO=6;
				SET @NUMERO=(SELECT CF.CONFIC_Numero FROM cji_configuracion CF WHERE CF.COMPP_Codigo=COMPP_Codigo AND CF.DOCUP_Codigo=@CODIGODOCUMENTO);
				SET @NUMEROAUMENTADO =@NUMERO+1;
				
				CALL MANTENIMIENTO_GUIASA(GUIASAP_Codigo,1,CPC_TipoOperacion,ALMAP_Codigo,USUA_Codigo,CLIP_Codigo,NULL,@DOCUP_Codigo,CPC_Fecha,@NUMEROAUMENTADO,CPC_Observacion,NULL,NULL,'',NULL,NULL,NULL,NULL,1,1,0,NULL,NULL,NULL);
				SET CPC_FlagMueveStock=1;
			ELSE
				SET @CODIGODOCUMENTO=5;
				SET @NUMERO=(SELECT CF.CONFIC_Numero FROM cji_configuracion CF WHERE CF.COMPP_Codigo=COMPP_Codigo AND CF.DOCUP_Codigo=@CODIGODOCUMENTO);
				SET @NUMEROAUMENTADO=@NUMERO+1;
				
				CALL MANTENIMIENTO_GUIAIN(GUIAINP_Codigo,2,ALMAP_Codigo,USUA_Codigo,PROVP_Codigo,NULL,@DOCUP_Codigo,'',@NUMEROAUMENTADO,CPC_Fecha,'',CPC_Observacion,'','','','','',CURDATE(),NULL,1,1,0,NULL,NULL,NULL);
				SET CPC_FlagMueveStock=1;
			END IF;
			
			UPDATE  cji_configuracion CF SET CF.CONFIC_Numero=@NUMEROAUMENTADO WHERE CF.COMPP_Codigo=COMPP_Codigo AND  CF.DOCUP_Codigo=@CODIGODOCUMENTO;
			
			CALL MANTENIMIENTO_COMPROBANTE(CODIGO_FACTURA, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, CPC_FlagMueveStock,GUIASAP_Codigo,GUIAINP_Codigo,NULL, NULL, NULL, @ESTADOACTUALIZAR, NULL, NULL, NULL, 1, NULL, NULL, NULL,NULL);
			
			
			BLOCK12:BEGIN
				DECLARE D_PROD_Codigo INT(11);
				DECLARE D_UNDMED_Codigo INT(11);
				DECLARE D_CPDEC_Cantidad DOUBLE(10,2);
				DECLARE D_CPDEC_GenInd CHAR(1);
				DECLARE D_CPDEC_Pu_ConIgv DOUBLE(10,2);
				DECLARE D_CPDEC_Descripcion VARCHAR(150);
				DECLARE D_ALMAP_Codigo INT(11);
				DECLARE TOTALREGISTROD INT(11) DEFAULT (SELECT COUNT(*)	FROM cji_comprobantedetalle CCD	WHERE CCD.CPP_Codigo=CODIGO_FACTURA);
				DECLARE INDICEPOSICIOND INT(11) DEFAULT  0;
				DECLARE COMPROBANTED_CURSOR cursor for 
				SELECT 
				CCD.PROD_Codigo AS PROD_Codigo,
				CCD.UNDMED_Codigo AS UNDMED_Codigo,
				CCD.CPDEC_Cantidad AS CPDEC_Cantidad,
				CCD.CPDEC_GenInd AS CPDEC_GenInd,
				CCD.CPDEC_Pu_ConIgv AS CPDEC_Pu_ConIgv,
				CCD.CPDEC_Descripcion AS CPDEC_Descripcion,
				CCD.ALMAP_Codigo AS ALMAP_Codigo 
				FROM cji_comprobantedetalle CCD
				WHERE CCD.CPP_Codigo=CODIGO_FACTURA;
				DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTARDC1 = TRUE;
				OPEN COMPROBANTED_CURSOR;
				LOOP2: LOOP
				FETCH COMPROBANTED_CURSOR INTO D_PROD_Codigo,D_UNDMED_Codigo,D_CPDEC_Cantidad,D_CPDEC_GenInd,D_CPDEC_Pu_ConIgv,D_CPDEC_Descripcion,D_ALMAP_Codigo;
				
				IF INDICEPOSICIOND=TOTALREGISTROD THEN
					LEAVE LOOP2;
				END IF;

				IF TRIM(CPC_TipoOperacion)='V' THEN 
					
					CALL MANTENIMIENTO_GUIASADETALLE('',GUIASAP_Codigo,D_PROD_Codigo,D_UNDMED_Codigo ,D_CPDEC_GenInd,D_CPDEC_Cantidad,D_CPDEC_Pu_ConIgv,@CPDEC_Descripcion,NULL,NULL,1,0,NULL,NULL,NULL,D_ALMAP_Codigo);
					
					SET @PRODUNIC_flagPrincipal='';
					SET @PRODUNIC_Factor='';
					SELECT CPU.PRODUNIC_flagPrincipal,CPU.PRODUNIC_Factor INTO @PRODUNIC_flagPrincipal,@PRODUNIC_Factor
					FROM cji_productounidad CPU WHERE  CPU.PROD_Codigo=D_PROD_Codigo AND  CPU.UNDMED_Codigo=D_UNDMED_Codigo AND CPU.PRODUNIC_flagEstado=1;
					IF @PRODUNIC_flagPrincipal=0 THEN
						IF @PRODUNIC_Factor>0 THEN 
							SET D_CPDEC_Cantidad=D_CPDEC_Cantidad/@PRODUNIC_Factor;
							SET @ISDOUBLE=LOCATE('.',D_CPDEC_Cantidad);
							IF @ISDOUBLE<>0 THEN 
								SET D_CPDEC_Cantidad=ROUND(D_CPDEC_Cantidad, 3);
							END IF;
						END IF;
					END IF;
					
					SET @ALMPROD_Codigo=0;
					SET @ALMPROD_Stock='';
					SET @ALMPROD_CostoPromedio='';
					SET @CANTIDADTOTAL=0;
					SET @COSTOPROMEDIO=0;
					SELECT CAP.ALMPROD_Codigo,CAP.ALMPROD_Stock, CAP.ALMPROD_CostoPromedio INTO @ALMPROD_Codigo,@ALMPROD_Stock, @ALMPROD_CostoPromedio
					FROM cji_almacenproducto CAP WHERE CAP.ALMAC_Codigo=D_ALMAP_Codigo AND CAP.PROD_Codigo=D_PROD_Codigo;
					IF (@ALMPROD_Codigo IS NOT NULL AND  @ALMPROD_Codigo<>0) THEN
					
						IF D_CPDEC_Cantidad<>@ALMPROD_Stock THEN 
							SET @CANTIDADTOTAL=@ALMPROD_Stock-D_CPDEC_Cantidad; 
							SET @COSTOPROMEDIO=((@ALMPROD_Stock*@ALMPROD_CostoPromedio)-(D_CPDEC_Cantidad*D_CPDEC_Pu_ConIgv))/@CANTIDADTOTAL;
						END IF;
					
					
						CALL MANTENIMIENTO_ALMACENPRODUCTO(@ALMPROD_Codigo,D_ALMAP_Codigo,D_PROD_Codigo,COMPP_Codigo,@CANTIDADTOTAL,@COSTOPROMEDIO,NOW(),'',1,NULL,NULL,NULL);
					
						SET @PRODUCTOSTOCKINICIAL=(SELECT CP.PROD_Stock FROM cji_producto CP WHERE CP.PROD_Codigo=D_PROD_Codigo);
						CALL MANTENIMIENTO_PRODUCTO(D_PROD_Codigo, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, (@PRODUCTOSTOCKINICIAL-D_CPDEC_Cantidad), NULL, NULL, NULL, NULL, NULL, NULL, D_CPDEC_Pu_ConIgv, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL);
					
						
						SET @ISINVETARIADO=0;
						SET @ISINVETARIADO=(SELECT CIND.INVD_Codigo 
						FROM cji_inventariodetalle CIND
						INNER JOIN cji_inventario CIN ON CIN.INVE_Codigo=CIND.INVE_Codigo
						WHERE CIND.PROD_Codigo=D_PROD_Codigo  AND CIN.ALMAP_Codigo=D_ALMAP_Codigo
						AND CIND.INVD_FlagActivacion='1' ORDER BY CIND.INVD_Codigo DESC LIMIT 1 );
						
						
						IF (@ISINVETARIADO IS NOT NULL AND @ISINVETARIADO<>0) THEN 
						
							SET @TIPOVALORIZACION=(SELECT COMP.COMPC_TipoValorizacion FROM cji_compania COMP WHERE COMP.COMPP_Codigo=COMPP_Codigo);
							IF @TIPOVALORIZACION=0 THEN
								SET @COUNTAPL =(SELECT COUNT(*) FROM cji_almaprolote APL WHERE APL.COMPP_Codigo=COMPP_Codigo AND APL.ALMPROD_Codigo=@ALMPROD_Codigo ORDER BY APL.ALMALOTP_Codigo);
															
								BLOCK2:BEGIN
									DECLARE INDICE INT(11) DEFAULT 0;
									DECLARE CANTIDADTOTAL DOUBLE(10,2) DEFAULT 0;
									DECLARE HECHO INT(1) DEFAULT 0;
									DECLARE ALMALOTP_Codigo INT(11);
									DECLARE LOTP_Codigo INT(11);
									DECLARE ALMALOTC_Cantidad DOUBLE(10,2);
									DECLARE ALMALOTC_Costo DOUBLE(10,2);
									DECLARE ALMACENPROLOTE_CURSOR CURSOR FOR SELECT APL.ALMALOTP_Codigo,APL.LOTP_Codigo,APL.ALMALOTC_Cantidad,APL.ALMALOTC_Costo
									FROM cji_almaprolote APL WHERE APL.COMPP_Codigo=COMPP_Codigo AND APL.ALMPROD_Codigo=@ALMPROD_Codigo ORDER BY APL.ALMALOTP_Codigo;
									DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTAR2 = TRUE;
									OPEN ALMACENPROLOTE_CURSOR;
									LOOP21: LOOP
									FETCH ALMACENPROLOTE_CURSOR INTO ALMALOTP_Codigo,LOTP_Codigo,ALMALOTC_Cantidad,ALMALOTC_Costo;
									
									IF (ALMALOTP_Codigo IS NULL OR ALMALOTP_Codigo=0) THEN
										LEAVE LOOP21;
									END IF;
									
									
									IF @EJECUTAR2 THEN
										LEAVE LOOP21;
									END IF;
									SET INDICE=INDICE+1;
								
									
									IF D_CPDEC_Cantidad >= ALMALOTC_Cantidad  THEN 
										SET @TOTALROWS=@COUNTAPL;
										IF @TOTALROWS=INDICE THEN
											SET CANTIDADTOTAL=D_CPDEC_Cantidad;
											SET HECHO=1;
										ELSE
											SET CANTIDADTOTAL=ALMALOTC_Cantidad;
											SET D_CPDEC_Cantidad=D_CPDEC_Cantidad-ALMALOTC_Cantidad;
											SET HECHO=0;
										END IF;
									ELSE 
										SET CANTIDADTOTAL=D_CPDEC_Cantidad;
										SET HECHO=1;
									END IF;
									
										SET @ALMALOTC_Cantidad=0;
										SET @ALMALOTP_Codigo=0;
										SELECT APL.ALMALOTP_Codigo,APL.ALMALOTC_Cantidad INTO @ALMALOTP_Codigo,@ALMALOTC_Cantidad
										FROM cji_almaprolote APL WHERE APL.ALMPROD_Codigo=@ALMPROD_Codigo AND APL.COMPP_Codigo=COMPP_Codigo AND APL.LOTP_Codigo=LOTP_Codigo;
										
										SET @ALMALOTC_Cantidad=@ALMALOTC_Cantidad-CANTIDADTOTAL;
										CALL MANTENIMIENTO_ALMACENLOTE(@ALMALOTP_Codigo,NULL,NULL,NULL,@ALMALOTC_Cantidad,NULL,'',NULL,1,NULL,NULL,NULL);
										
										IF CANTIDADTOTAL<>0 THEN 
											SET @CPC_FechaHora=CONCAT(CPC_Fecha,' ',curTime());
											CALL MANTENIMIENTO_KARDEX('',COMPP_Codigo,D_PROD_Codigo,6,2,LOTP_Codigo,GUIASAP_Codigo,'2',@CPC_FechaHora,CANTIDADTOTAL,D_CPDEC_Pu_ConIgv,0,NULL,NULL,NULL,@ALMPROD_Codigo,1);					
										
											IF HECHO=1 THEN
												LEAVE LOOP21;
											END IF;
										END IF;
										
										
									END LOOP LOOP21;
									CLOSE ALMACENPROLOTE_CURSOR;
								END BLOCK2;				
							END IF;
						
						END IF;
						
						
					IF (D_CPDEC_GenInd IS NOT NULL AND D_CPDEC_GenInd='I') THEN 
						
						SET @COUNTASERIESV=(SELECT COUNT(*)
						FROM cji_serie SER  
						INNER JOIN cji_seriedocumento SERDOC ON SERDOC.SERIP_Codigo=SER.SERIP_Codigo
						WHERE  SERDOC.DOCUP_Codigo=@DOCUP_Codigo 
						AND SERDOC.SERDOC_NumeroRef=CODIGO_FACTURA AND SER.PROD_Codigo=D_PROD_Codigo AND SER.ALMAP_Codigo=D_ALMAP_Codigo);
										
						BLOCKSE1V:BEGIN
							DECLARE INDICESERV INT(11) DEFAULT 0;
							DECLARE SERIP_Codigo INT(11);
							DECLARE SERIC_Numero varchar(50);
							
							DECLARE SERIESV_CURSOR CURSOR FOR SELECT SER.SERIP_Codigo, SER.SERIC_Numero
							FROM cji_serie SER  
							INNER JOIN cji_seriedocumento SERDOC ON SERDOC.SERIP_Codigo=SER.SERIP_Codigo
							WHERE  SERDOC.DOCUP_Codigo=@DOCUP_Codigo 
							AND SERDOC.SERDOC_NumeroRef=CODIGO_FACTURA AND SER.PROD_Codigo=D_PROD_Codigo AND SER.ALMAP_Codigo=D_ALMAP_Codigo
							ORDER BY SER.SERIP_Codigo ASC;
							
							DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTARSERIE2V = TRUE;
							OPEN SERIESV_CURSOR;
							LOOPSE21V: LOOP
							FETCH SERIESV_CURSOR INTO SERIP_Codigo,SERIC_Numero;
									
							IF (SERIP_Codigo IS NULL OR SERIP_Codigo=0) THEN
								LEAVE LOOPSE21V;
							END IF;
							
							IF @EJECUTARSERIE2V THEN
								LEAVE LOOPSE21V;
							END IF;
							SET INDICESERV=INDICESERV+1;
							
							
							SET @SERMOVP_Codigo=NULL;
							SET @ALMPRODSERP_Codigo=NULL;
							CALL MANTENIMIENTO_SERIEMOVIMIENTO(@SERMOVP_Codigo,SERIP_Codigo,2,NULL,GUIASAP_Codigo,0);
							CALL MANTENIMIENTO_ALMACENPRODUCTOSERIE(@ALMPRODSERP_Codigo,@ALMPROD_Codigo,SERIP_Codigo,3);
							
							IF @COUNTASERIESV=INDICESERV THEN
								LEAVE LOOPSE21V;
							END IF;
							
							END LOOP LOOPSE21V;
							CLOSE SERIESV_CURSOR;
						END BLOCKSE1V;	
						
					END IF;
						
					END IF;
				END IF;
					
				IF TRIM(CPC_TipoOperacion)='C' THEN
					
					CALL MANTENIMIENTO_GUIAINDETALLE('',GUIAINP_Codigo,D_PROD_Codigo,D_UNDMED_Codigo ,D_CPDEC_GenInd,D_CPDEC_Cantidad,D_CPDEC_Pu_ConIgv,@CPDEC_Descripcion,NULL,NULL,1,0,NULL,NULL,NULL,D_ALMAP_Codigo);
					
					SET @COSTOPRODUCTO=D_CPDEC_Pu_ConIgv;
					IF  MONED_Codigo<>NULL && MONED_Codigo<>1 THEN
						SET @FACTORCONVERSION=(SELECT TC.TIPCAMC_FactorConversion FROM cji_tipocambio TC WHERE TC.TIPCAMC_MonedaOrigen=1 AND TIPCAMC_MonedaDestino=MONED_Codigo AND TC.COMPP_Codigo=COMPP_Codigo AND TIPCAMC_FlagEstado=1 ORDER BY TIPCAMP_Codigo DESC LIMIT 0,1); 
						IF (@FACTORCONVERSION<>NULL AND  @FACTORCONVERSION<>0) THEN
							SET @COSTOPRODUCTO=D_CPDEC_Pu_ConIgv*@FACTORCONVERSION;
						END IF;	
					END IF;
					
					SET @PRODUNIC_flagPrincipal='';
					SET @PRODUNIC_Factor='';
					SELECT CPU.PRODUNIC_flagPrincipal,CPU.PRODUNIC_Factor INTO @PRODUNIC_flagPrincipal,@PRODUNIC_Factor
					FROM cji_productounidad CPU WHERE  CPU.PROD_Codigo=D_PROD_Codigo AND  CPU.UNDMED_Codigo=D_UNDMED_Codigo AND CPU.PRODUNIC_flagEstado=1;
					IF @PRODUNIC_flagPrincipal=0 THEN
						IF @PRODUNIC_Factor>0 THEN 
							SET D_CPDEC_Cantidad=D_CPDEC_Cantidad/@PRODUNIC_Factor;
							SET @ISDOUBLE=LOCATE('.',D_CPDEC_Cantidad);
							IF @ISDOUBLE<>0 THEN 
								SET D_CPDEC_Cantidad=ROUND(D_CPDEC_Cantidad, 3);
							END IF;
						END IF;

					END IF;
					
					SET @ALMPROD_Codigo=0;
					SET @ALMPROD_Stock='';
					SET @ALMPROD_CostoPromedio='';
					SET @CANTIDADTOTAL=0;
					SET @COSTOPROMEDIO=0;
					SELECT CAP.ALMPROD_Codigo,CAP.ALMPROD_Stock, CAP.ALMPROD_CostoPromedio INTO @ALMPROD_Codigo,@ALMPROD_Stock, @ALMPROD_CostoPromedio
					FROM cji_almacenproducto CAP WHERE CAP.ALMAC_Codigo=D_ALMAP_Codigo AND CAP.PROD_Codigo=D_PROD_Codigo;
					IF (@ALMPROD_Codigo IS NOT NULL AND  @ALMPROD_Codigo<>0 )THEN
						SET @CANTIDADTOTAL=@ALMPROD_Stock+D_CPDEC_Cantidad;
						IF @CANTIDADTOTAL=0 THEN 
							SET @COSTOPROMEDIO=0;
						ELSE						
							SET @COSTOPROMEDIO=((@ALMPROD_Stock*@ALMPROD_CostoPromedio)+(D_CPDEC_Cantidad*D_CPDEC_Pu_ConIgv))/@CANTIDADTOTAL;
						END IF;
						
						CALL MANTENIMIENTO_ALMACENPRODUCTO(@ALMPROD_Codigo,D_ALMAP_Codigo,D_PROD_Codigo,COMPP_Codigo,@CANTIDADTOTAL,@COSTOPROMEDIO,NOW(),'',1,NULL,NULL,NULL);
					
						SET @PRODUCTOSTOCKINICIAL=(SELECT CP.PROD_Stock FROM cji_producto CP WHERE CP.PROD_Codigo=D_PROD_Codigo LIMIT 0,1);
						CALL MANTENIMIENTO_PRODUCTO(D_PROD_Codigo, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, (@PRODUCTOSTOCKINICIAL+D_CPDEC_Cantidad), NULL, NULL, NULL, NULL, NULL, NULL, @COSTOPRODUCTO, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL);
						
						
						SET @ISINVETARIADO=0;
						SET @ISINVETARIADO=(SELECT CIND.INVD_Codigo 
						FROM cji_inventariodetalle CIND
						INNER JOIN cji_inventario CIN ON CIN.INVE_Codigo=CIND.INVE_Codigo
						WHERE CIND.PROD_Codigo=D_PROD_Codigo  AND CIN.ALMAP_Codigo=D_ALMAP_Codigo
						AND CIND.INVD_FlagActivacion='1' ORDER BY CIND.INVD_Codigo DESC LIMIT 1  );
						
						
						
						IF (@ISINVETARIADO IS NOT NULL AND @ISINVETARIADO<>0) THEN 
							SET @LOTP_Codigo='';	
							CALL MANTENIMIENTO_LOTE(@LOTP_Codigo,D_PROD_Codigo,D_CPDEC_Cantidad,@COSTOPRODUCTO,GUIAINP_Codigo,NOW(),NULL,1,0,NULL,NULL,NULL);
							
							SET @ALMALOTC_Cantidad=0;
							SET @ALMALOTP_Codigo=0;

							SELECT APL.ALMALOTC_Cantidad , APL.ALMALOTP_Codigo INTO @ALMALOTC_Cantidad, @ALMALOTP_Codigo
							FROM cji_almaprolote APL WHERE APL.COMPP_Codigo=COMPP_Codigo AND APL.ALMPROD_Codigo=@ALMPROD_Codigo AND APL.LOTP_Codigo=@LOTP_Codigo LIMIT 0,1;
							
							
							IF (@ALMALOTP_Codigo IS NOT NULL AND @ALMALOTP_Codigo<>0) THEN
								CALL MANTENIMIENTO_ALMACENLOTE(@ALMALOTP_Codigo,NULL,
								NULL,NULL,(@ALMALOTC_Cantidad+D_CPDEC_Cantidad),@COSTOPRODUCTO,NOW(),1,1,NULL,NULL,NULL
								);
							ELSE
								CALL MANTENIMIENTO_ALMACENLOTE(@ALMALOTP_Codigo,@ALMPROD_Codigo,@LOTP_Codigo,COMPP_Codigo,D_CPDEC_Cantidad,@COSTOPRODUCTO,NOW(),1,0,NULL,NULL,NULL);
							END IF;
							SET @CPC_FechaHora=CONCAT(CPC_Fecha,' ',curTime());
							CALL MANTENIMIENTO_KARDEX('',COMPP_Codigo,D_PROD_Codigo,5,2,@LOTP_Codigo,GUIAINP_Codigo,'1',@CPC_FechaHora,D_CPDEC_Cantidad,@COSTOPRODUCTO,0,NULL,NULL,NULL,@ALMPROD_Codigo,1);
							
						END IF;
					
					ELSE
						SET @CANTIDADTOTAL=D_CPDEC_Cantidad;
						SET @COSTOPROMEDIO=@COSTOPRODUCTO;
						
						CALL MANTENIMIENTO_ALMACENPRODUCTO(@ALMPROD_Codigo,D_ALMAP_Codigo,D_PROD_Codigo,COMPP_Codigo,@CANTIDADTOTAL,@COSTOPROMEDIO,NOW(),'',0,NULL,NULL,NULL);
					END IF;
					
					
					IF (D_CPDEC_GenInd IS NOT NULL AND D_CPDEC_GenInd='I') THEN 
						
						SET @COUNTASERIES=(SELECT COUNT(*)
						FROM cji_serie SER  
						INNER JOIN cji_seriedocumento SERDOC ON SERDOC.SERIP_Codigo=SER.SERIP_Codigo
						WHERE  SERDOC.DOCUP_Codigo=@DOCUP_Codigo 
						AND SERDOC.SERDOC_NumeroRef=CODIGO_FACTURA AND SER.PROD_Codigo=D_PROD_Codigo AND SER.ALMAP_Codigo=D_ALMAP_Codigo);	
						
						BLOCKSE1:BEGIN
							DECLARE INDICESER INT(11) DEFAULT 0;
							DECLARE SERIP_Codigo INT(11);
							DECLARE SERIC_Numero varchar(50)	;
							DECLARE SERIES_CURSOR CURSOR FOR SELECT SER.SERIP_Codigo, SER.SERIC_Numero
							FROM cji_serie SER  
							INNER JOIN cji_seriedocumento SERDOC ON SERDOC.SERIP_Codigo=SER.SERIP_Codigo
							WHERE  SERDOC.DOCUP_Codigo=@DOCUP_Codigo 
							AND SERDOC.SERDOC_NumeroRef=CODIGO_FACTURA AND SER.PROD_Codigo=D_PROD_Codigo AND SER.ALMAP_Codigo=D_ALMAP_Codigo
							ORDER BY SER.SERIP_Codigo ASC;
							
							DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTARSERIE2 = TRUE;
							OPEN SERIES_CURSOR;
							LOOPSE21: LOOP
							FETCH SERIES_CURSOR INTO SERIP_Codigo,SERIC_Numero;
									
							IF (SERIP_Codigo IS NULL OR SERIP_Codigo=0) THEN
								LEAVE LOOPSE21;
							END IF;
							
							IF @EJECUTARSERIE2 THEN
								LEAVE LOOPSE21;
							END IF;
							SET INDICESER=INDICESER+1;
							
							
							SET @SERMOVP_Codigo=NULL;
							SET @ALMPRODSERP_Codigo=NULL;
							CALL MANTENIMIENTO_SERIEMOVIMIENTO(@SERMOVP_Codigo,SERIP_Codigo,1,GUIAINP_Codigo,NULL,0);
							CALL MANTENIMIENTO_ALMACENPRODUCTOSERIE(@ALMPRODSERP_Codigo,@ALMPROD_Codigo,SERIP_Codigo,0);
							
							IF @COUNTASERIES=INDICESER THEN
								LEAVE LOOPSE21;
							END IF;
							
							END LOOP LOOPSE21;
							CLOSE SERIES_CURSOR;
						END BLOCKSE1;	
						
					END IF;
					
					
				END IF;
				SET INDICEPOSICIOND=INDICEPOSICIOND+1;
				END LOOP LOOP2; 
				CLOSE COMPROBANTED_CURSOR;
			END BLOCK12;
			
			IF TRIM(CPC_TipoDocumento)<>'N' THEN 
				CALL CREACION_GUIA_INTERNA(CODIGO_FACTURA,@DOCUP_Codigo,CPC_TipoOperacion);
			END IF;
			
		END IF;
	
	END LOOP LOOP1; 
	CLOSE FACTURA_CURSOR;
END BLOCK1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `COMPROBANTE_DISPARADOR_MODIFICAR` (IN `CODIGO_FACTURA` INT(11))  BLOCK1:BEGIN
DECLARE CPP_Codigo INT(11); 
DECLARE CPC_TipoOperacion CHAR(1); 
DECLARE CPC_TipoDocumento CHAR(1); 
DECLARE PRESUP_Codigo INT(11); 
DECLARE OCOMP_Codigo INT(11); 
DECLARE COMPP_Codigo INT(11); 
DECLARE CPC_Serie CHAR(4); 
DECLARE CPC_Numero VARCHAR(11); 
DECLARE CLIP_Codigo INT(11); 
DECLARE PROVP_Codigo INT(11); 
DECLARE CPC_NombreAuxiliar VARCHAR(25); 
DECLARE USUA_Codigo INT(11); 
DECLARE MONED_Codigo INT(11); 
DECLARE FORPAP_Codigo INT(11); 
DECLARE CPC_subtotal DOUBLE(10,2); 
DECLARE CPC_descuento DOUBLE(10,2); 
DECLARE CPC_igv DOUBLE(10,2); 
DECLARE CPC_total DOUBLE(10,2); 
DECLARE CPC_subtotal_conigv DOUBLE(10,2); 
DECLARE CPC_descuento_conigv DOUBLE(10,2); 
DECLARE CPC_igv100 INT(11); 
DECLARE CPC_descuento100 INT(11); 
DECLARE GUIAREMP_Codigo INT(11); 
DECLARE CPC_GuiaRemCodigo VARCHAR(50); 
DECLARE CPC_DocuRefeCodigo VARCHAR(50); 
DECLARE CPC_Observacion TEXT; 
DECLARE CPC_ModoImpresion CHAR(1); 
DECLARE CPC_Fecha DATE; 
DECLARE CPC_Vendedor INT(11); 
DECLARE CPC_TDC DOUBLE(10,2); 
DECLARE CPC_FlagMueveStock CHAR(1); 
DECLARE GUIASAP_Codigo INT(11); 
DECLARE GUIAINP_Codigo INT(11); 
DECLARE USUA_anula INT(11); 
DECLARE CPC_FechaRegistro TIMESTAMP; 
DECLARE CPC_FechaModificacion DATETIME; 
DECLARE CPC_FlagEstado CHAR(1); 
DECLARE CPC_Hora TIME; 
DECLARE ALMAP_Codigo INT(11); 
DECLARE CPP_Codigo_Canje INT(11);
DECLARE CPC_NumeroAutomatico INT(1);

DECLARE SALIREJECUTAR INT(1) DEFAULT 0;

DECLARE FECHAKARDEXANTERIOR DATETIME;
DECLARE FACTURA_CURSOR cursor for 
SELECT 
			  gs.CPP_Codigo AS CPP_Codigo,
			  gs.CPC_TipoOperacion AS CPC_TipoOperacion,
			  gs.CPC_TipoDocumento AS CPC_TipoDocumento,
			  gs.PRESUP_Codigo AS PRESUP_Codigo,
			  gs.OCOMP_Codigo AS OCOMP_Codigo,
			  gs.COMPP_Codigo AS COMPP_Codigo,
			  gs.CPC_Serie AS CPC_Serie,
			  gs.CPC_Numero AS CPC_Numero,
			  gs.CLIP_Codigo AS CLIP_Codigo,
			  gs.PROVP_Codigo AS PROVP_Codigo,
			  gs.CPC_NombreAuxiliar AS CPC_NombreAuxiliar,
			  gs.USUA_Codigo AS USUA_Codigo,
			  gs.MONED_Codigo AS MONED_Codigo,
			  gs.FORPAP_Codigo AS FORPAP_Codigo,
			  gs.CPC_subtotal AS CPC_subtotal,
			  gs.CPC_descuento AS CPC_descuento,
			  gs.CPC_igv AS CPC_igv,
			  gs.CPC_total AS CPC_total,
			  gs.CPC_subtotal_conigv AS CPC_subtotal_conigv,
			  gs.CPC_descuento_conigv AS CPC_descuento_conigv,
			  gs.CPC_igv100 AS CPC_igv100, 
			  gs.CPC_descuento100 AS CPC_descuento100,
			  gs.GUIAREMP_Codigo AS GUIAREMP_Codigo,
			  gs.CPC_GuiaRemCodigo AS CPC_GuiaRemCodigo,
			  gs.CPC_DocuRefeCodigo AS CPC_DocuRefeCodigo,
			  gs.CPC_Observacion AS CPC_Observacion,
			  gs.CPC_ModoImpresion AS CPC_ModoImpresion,
			  gs.CPC_Fecha AS CPC_Fecha,
			  gs.CPC_Vendedor AS CPC_Vendedor,
			  gs.CPC_TDC AS CPC_TDC,
			  gs.CPC_FlagMueveStock AS CPC_FlagMueveStock,
			  gs.GUIASAP_Codigo AS GUIASAP_Codigo,
			  gs.GUIAINP_Codigo AS GUIAINP_Codigo,
			  gs.USUA_anula AS USUA_anula,
			  gs.CPC_FechaRegistro AS CPC_FechaRegistro,
			  gs.CPC_FechaModificacion AS CPC_FechaModificacion,
			  gs.CPC_FlagEstado AS CPC_FlagEstado,
			  gs.CPC_Hora AS CPC_Hora,
			  gs.ALMAP_Codigo AS ALMAP_Codigo,
			  gs.CPP_Codigo_Canje AS CPP_Codigo_Canje,
			  gs.CPC_NumeroAutomatico AS CPC_NumeroAutomatico
FROM cji_comprobante gs WHERE gs.CPP_Codigo = CODIGO_FACTURA;

DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTAR = TRUE;
	OPEN FACTURA_CURSOR;
	LOOP1MO: LOOP
	FETCH FACTURA_CURSOR INTO 
			CPP_Codigo,
			  CPC_TipoOperacion,
			  CPC_TipoDocumento,
			  PRESUP_Codigo,
			  OCOMP_Codigo,
			  COMPP_Codigo,
			  CPC_Serie,
			  CPC_Numero,
			  CLIP_Codigo,
			  PROVP_Codigo,
			  CPC_NombreAuxiliar,
			  USUA_Codigo,
			  MONED_Codigo,
			  FORPAP_Codigo,
			  CPC_subtotal,
			  CPC_descuento,
			  CPC_igv,
			  CPC_total,
			  CPC_subtotal_conigv,
			  CPC_descuento_conigv,
			  CPC_igv100, 
			  CPC_descuento100,
			  GUIAREMP_Codigo,
			  CPC_GuiaRemCodigo,
			  CPC_DocuRefeCodigo,
			  CPC_Observacion,
			  CPC_ModoImpresion,
			  CPC_Fecha,
			  CPC_Vendedor,
			  CPC_TDC,
			  CPC_FlagMueveStock,
			  GUIASAP_Codigo,
			  GUIAINP_Codigo,
			  USUA_anula,
			  CPC_FechaRegistro,
			  CPC_FechaModificacion,
			  CPC_FlagEstado,
			  CPC_Hora,
			  ALMAP_Codigo,
			  CPP_Codigo_Canje,
			  CPC_NumeroAutomatico;

	

	IF (CPP_Codigo IS NULL OR CPP_Codigo=0) THEN
		LEAVE LOOP1MO;
	END IF;
	
	IF SALIREJECUTAR=1 THEN
			LEAVE LOOP1MO;
	END IF;
	
		SET SALIREJECUTAR=1;
		IF (CPC_FlagEstado=1) THEN

			SET @DOCUP_Codigo=(SELECT CD.DOCUP_Codigo FROM cji_documento CD WHERE CD.DOCUC_ABREVI=TRIM(CPC_TipoDocumento));
			CALL MANTENIMIENTO_COMPROBANTE(CODIGO_FACTURA, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL,NULL);
			
			SET @CUE_TipoCuenta='2';
			IF TRIM(CPC_TipoOperacion)='V' THEN
				SET @CUE_TipoCuenta='1';
			END IF;
					
			
			SET @CUE_Codigo=(SELECT CC.CUE_Codigo FROM cji_cuentas CC WHERE CC.CUE_CodDocumento=CPP_Codigo AND CC.CUE_FlagEstado=1);

			IF (@CUE_Codigo IS NULL OR @CUE_Codigo=0) THEN 
				SELECT "ERROR NO TIENE CUENTAS";
				LEAVE LOOP1MO;
			ELSE
				
				SET @COUNTPAGOS=(SELECT COUNT(*) FROM cji_cuentaspago CP WHERE CP.CUE_Codigo=@CUE_Codigo  AND CP.CPAGC_FlagEstado='1');
				IF FORPAP_Codigo=1  THEN 
					IF (@COUNTPAGOS IS NULL OR @COUNTPAGOS=0) THEN
						SET @CUE_FlagEstadoPago='C';
						SET @CUE_FechaCanc=NOW();
						
						CALL MANTENIMIENTO_CUENTA (@CUE_Codigo,NULL,NULL,CPP_Codigo,MONED_Codigo,CPC_total,CPC_Fecha,@CUE_FlagEstadoPago,@CUE_FechaCanc,COMPP_Codigo,NOW(),NULL,1, 1, NULL, NULL, NULL, NULL, NULL);


						
						SET @PAGC_Obs='SALIDA GENERADA';
						IF TRIM(CPC_TipoOperacion)='V' THEN
							SET @PAGC_Obs='INGRESO GENERADO';
						END IF;
						SET @PAGC_Obs=CONCAT(@PAGC_Obs,"AUTOMATICAMENTE POR EL PAGO AL CONTADO");
						SET @PAGC_TDC=CPC_TDC;
						SET @PAGP_Codigo=0;
						CALL MANTENIMIENTO_PAGO(@PAGP_Codigo,@CUE_TipoCuenta,CPC_Fecha,CLIP_Codigo,PROVP_Codigo,@PAGC_TDC,CPC_total,MONED_Codigo,'1',NULL,NULL,NULL,NULL,NULL,NULL,'0',@PAGC_Obs,COMPP_Codigo,NULL,NULL,'1',0,NULL,NULL,NULL);
				
						CALL MANTENIMIENTO_CUENTAPAGO('',@CUE_Codigo,@PAGP_Codigo,@PAGC_TDC,CPC_total,MONED_Codigo,NULL,NULL,'1',0,NULL,NULL,NULL,NULL,NULL);
					ELSE
						
						SET @CUE_FlagEstadoPago=(SELECT CP.CUE_FlagEstadoPago FROM cji_cuentas CP WHERE CP.CUE_Codigo=@CUE_Codigo  AND CP.CUE_FlagEstado='1');
						IF (TRIM(@CUE_FlagEstadoPago)='C' AND @COUNTPAGOS=1)  THEN
							SET @CODIGOPAGO=0;
							SET @CODIGOCUENTASPAGO=0;
							SELECT CP.PAGP_Codigo , CP.CPAGP_Codigo INTO @CODIGOPAGO,@CODIGOCUENTASPAGO
							FROM cji_cuentaspago CP WHERE CP.CUE_Codigo=@CUE_Codigo  AND CP.CPAGC_FlagEstado='1' LIMIT 1;

							CALL MANTENIMIENTO_CUENTA (@CUE_Codigo,NULL,NULL,CPP_Codigo,MONED_Codigo,CPC_total,CPC_Fecha,@CUE_FlagEstadoPago,@CUE_FechaCanc,COMPP_Codigo,NOW(),NULL,1, 1, NULL, NULL, NULL, NULL, NULL);

							CALL MANTENIMIENTO_PAGO(@CODIGOPAGO,NULL,CPC_Fecha,NULL,NULL,@PAGC_TDC,CPC_total,MONED_Codigo,'1',NULL,NULL,NULL,NULL,NULL,NULL,'0',@PAGC_Obs,NULL,NULL,NULL,'1',1,NULL,NULL,NULL);

							CALL MANTENIMIENTO_CUENTAPAGO(@CODIGOCUENTASPAGO,NULL,NULL,NULL,CPC_total,NULL,NULL,NULL,'1',1,NULL,NULL,NULL,NULL,NULL);

						END IF;

					END IF;
				
				ELSE
					SET @CUE_FlagEstadoPago=(SELECT CP.CUE_FlagEstadoPago FROM cji_cuentas CP WHERE CP.CUE_Codigo=@CUE_Codigo  AND CP.CUE_FlagEstado='1');
					
					IF (TRIM(@CUE_FlagEstadoPago)='C' AND @COUNTPAGOS=1)  THEN
						SET @CUE_FlagEstadoPago='V';
						SET @CUE_FechaCanc='';
						
						CALL MANTENIMIENTO_CUENTA (@CUE_Codigo,NULL,NULL,CPP_Codigo,MONED_Codigo,CPC_total,CPC_Fecha,@CUE_FlagEstadoPago,@CUE_FechaCanc,COMPP_Codigo,NOW(),NULL,1, 1, NULL, NULL, NULL, NULL, NULL);
						
						SET @CUENTAPAGOID=0;
						SET @PAGOID=0;
						SELECT CP.CPAGP_Codigo,CP.PAGP_Codigo INTO  @CUENTAPAGOID , @PAGOID
						FROM cji_cuentaspago CP WHERE CP.CUE_Codigo=@CUE_Codigo  AND CP.CPAGC_FlagEstado=1;

						CALL MANTENIMIENTO_PAGO(@PAGOID,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0',2,NULL,NULL,NULL);

						CALL MANTENIMIENTO_CUENTAPAGO(@CUENTAPAGOID,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'0',2,NULL,NULL,NULL,NULL,NULL);
						
					ELSE
						
						CALL MANTENIMIENTO_CUENTA (@CUE_Codigo,NULL,NULL,CPP_Codigo,MONED_Codigo,CPC_total,CPC_Fecha,@CUE_FlagEstadoPago,@CUE_FechaCanc,COMPP_Codigo,NOW(),NULL,1, 1, NULL, NULL, NULL, NULL, NULL);
					END IF;	
					
				END IF;
			END IF;

			
			
			SET @COUNTGUIAREM=(SELECT COUNT(*) FROM cji_comprobante_guiarem CPBGR WHERE CPBGR.CPP_Codigo=CODIGO_FACTURA AND CPBGR.COMPGUI_FlagEstado!=3 AND CPBGR.COMPGUI_FlagEstado!=0);
			
			IF (@COUNTGUIAREM IS NOT NULL AND @COUNTGUIAREM<>0) THEN
				LEAVE LOOP1MO;
			END IF;
			


			
			IF TRIM(CPC_TipoOperacion)='V' THEN 
				
				CALL MANTENIMIENTO_GUIASA(GUIASAP_Codigo,1,CPC_TipoOperacion,ALMAP_Codigo,USUA_Codigo,CLIP_Codigo,NULL,@DOCUP_Codigo,CPC_Fecha,NULL,CPC_Observacion,NULL,NULL,'',NULL,NULL,NULL,NULL,1,1,1,NULL,NULL,NULL);
				SET CPC_FlagMueveStock=1;
			ELSE
				
				CALL MANTENIMIENTO_GUIAIN(GUIAINP_Codigo,2,ALMAP_Codigo,USUA_Codigo,PROVP_Codigo,NULL,@DOCUP_Codigo,'',NULL,CPC_Fecha,'',CPC_Observacion,'','','','','',CURDATE(),NULL,1,1,1,NULL,NULL,NULL);
				SET CPC_FlagMueveStock=1;
			END IF;
			
			CALL MANTENIMIENTO_COMPROBANTE(CODIGO_FACTURA, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL,NULL,NULL,NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL,NULL);
			SET @FECHAGUIASADETC=NULL;
			IF TRIM(CPC_TipoOperacion)='V' THEN
				
				BLOCKELIMINAR:BEGIN
				DECLARE A_GUIASADETP_Codigo INT(11);
				DECLARE A_UNDMED_Codigo INT(11);
				DECLARE A_PRODCTOP_Codigo INT(11);
				DECLARE A_GUIASADETC_Cantidad VARCHAR(45);
				DECLARE A_GUIASADETC_Costo VARCHAR(45);
				DECLARE A_GUIASADETC_GenInd CHAR(1);
				DECLARE A_GUIASADETC_FechaRegistro DATETIME;
				DECLARE D_ALMAP_Codigo INT(11);
				DECLARE GUIASADETALLE_CURSORELE CURSOR FOR SELECT 
				GSD.GUIASADETP_Codigo,	GSD.UNDMED_Codigo,	GSD.PRODCTOP_Codigo,GSD.GUIASADETC_Cantidad,		GSD.GUIASADETC_Costo, GSD.GUIASADETC_GenInd,GSD.GUIASADETC_FechaRegistro, GSD.ALMAP_Codigo 	FROM cji_guiasadetalle GSD WHERE GSD.GUIASAP_Codigo=GUIASAP_Codigo AND GSD.GUIASADETC_FlagEstado=1;
				DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTARGDE = TRUE;
					OPEN GUIASADETALLE_CURSORELE;
					LOOPGD: LOOP
					FETCH GUIASADETALLE_CURSORELE INTO A_GUIASADETP_Codigo,A_UNDMED_Codigo,	A_PRODCTOP_Codigo,A_GUIASADETC_Cantidad,A_GUIASADETC_Costo,A_GUIASADETC_GenInd,A_GUIASADETC_FechaRegistro,D_ALMAP_Codigo;

					IF @EJECUTARGDE THEN
						LEAVE LOOPGD;
					END IF;
					SET @FECHAGUIASADETC=A_GUIASADETC_FechaRegistro;
					CALL MANTENIMIENTO_GUIASADETALLE(A_GUIASADETP_Codigo,NULL,NULL,NULL ,NULL,NULL,NULL,NULL,NULL,NULL,0,2,NULL,NULL,NULL,NULL);
						
					
		
					
					SET @PRODUNIC_flagPrincipal='';
					SET @PRODUNIC_Factor='';
					SELECT CPU.PRODUNIC_flagPrincipal,CPU.PRODUNIC_Factor INTO @PRODUNIC_flagPrincipal,@PRODUNIC_Factor
					FROM cji_productounidad CPU WHERE  CPU.PROD_Codigo=A_PRODCTOP_Codigo AND  CPU.UNDMED_Codigo=A_UNDMED_Codigo AND CPU.PRODUNIC_flagEstado=1;
					
					IF @PRODUNIC_flagPrincipal=0 THEN
						IF @PRODUNIC_Factor>0 THEN 
							SET A_GUIASADETC_Cantidad=A_GUIASADETC_Cantidad/@PRODUNIC_Factor;
							SET @ISDOUBLE=LOCATE('.',A_GUIASADETC_Cantidad);
							IF @ISDOUBLE<>0 THEN 
								SET A_GUIASADETC_Cantidad=ROUND(A_GUIASADETC_Cantidad, 3);
							END IF;
						END IF;
					END IF;
					SET @ALMPROD_Codigo=0;
					SET @ALMPROD_Stock='';
					SET @ALMPROD_CostoPromedio='';
					SET @CANTIDADTOTAL=0;
					SET @COSTOPROMEDIO=0;
					SELECT CAP.ALMPROD_Codigo,CAP.ALMPROD_Stock, CAP.ALMPROD_CostoPromedio INTO @ALMPROD_Codigo,@ALMPROD_Stock, @ALMPROD_CostoPromedio
					FROM cji_almacenproducto CAP WHERE CAP.ALMAC_Codigo=D_ALMAP_Codigo AND CAP.PROD_Codigo=A_PRODCTOP_Codigo ORDER BY CAP.ALMPROD_Codigo DESC  LIMIT 1;
					IF (@ALMPROD_Codigo IS NOT NULL AND  @ALMPROD_Codigo<>0) THEN
						IF A_GUIASADETC_Cantidad<>@ALMPROD_Stock THEN 
							SET @CANTIDADTOTAL=@ALMPROD_Stock+A_GUIASADETC_Cantidad; 
							SET @COSTOPROMEDIO=((@ALMPROD_Stock*@ALMPROD_CostoPromedio)+(A_GUIASADETC_Cantidad*A_GUIASADETC_Costo))/@CANTIDADTOTAL;
						END IF;
						
						CALL MANTENIMIENTO_ALMACENPRODUCTO(@ALMPROD_Codigo,D_ALMAP_Codigo,A_PRODCTOP_Codigo,NULL,@CANTIDADTOTAL,@COSTOPROMEDIO,NOW(),'',1,NULL,NULL,NULL);

						SET @PRODUCTOSTOCKINICIAL=(SELECT CP.PROD_Stock FROM cji_producto CP WHERE CP.PROD_Codigo=A_PRODCTOP_Codigo);

						CALL MANTENIMIENTO_PRODUCTO(A_PRODCTOP_Codigo, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, (@PRODUCTOSTOCKINICIAL+A_GUIASADETC_Cantidad), NULL, NULL, NULL, NULL, NULL, NULL, A_GUIASADETC_Costo, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL);

						
						SET @ISINVETARIADO=0;
						SET @ISINVETARIADO=(SELECT CIND.INVD_Codigo 
						FROM cji_inventariodetalle CIND
						INNER JOIN cji_inventario CIN ON CIN.INVE_Codigo=CIND.INVE_Codigo
						WHERE CIND.PROD_Codigo=A_PRODCTOP_Codigo  AND CIN.ALMAP_Codigo=D_ALMAP_Codigo
						AND CIND.INVD_FlagActivacion='1' ORDER BY CIND.INVD_Codigo DESC LIMIT 1);
						
						
						IF (@ISINVETARIADO IS NOT NULL AND @ISINVETARIADO<>0) THEN 
							SET @TIPOVALORIZACION=(SELECT COMP.COMPC_TipoValorizacion FROM cji_compania COMP WHERE COMP.COMPP_Codigo=COMPP_Codigo);

							IF @TIPOVALORIZACION=0 THEN
								SET @COUNTAPL =(SELECT COUNT(*) FROM cji_almaprolote APL WHERE APL.COMPP_Codigo=COMPP_Codigo AND APL.ALMPROD_Codigo=@ALMPROD_Codigo ORDER BY APL.ALMALOTP_Codigo);

								BLOCK2K:BEGIN
									DECLARE INDICE INT(11) DEFAULT 0;
									DECLARE CANTIDADTOTAL DOUBLE(10,2) DEFAULT 0;
									DECLARE HECHO INT(1) DEFAULT 0;
									DECLARE ALMALOTP_Codigo INT(11);
									DECLARE LOTP_Codigo INT(11);
									DECLARE ALMALOTC_Cantidad DOUBLE(10,2);
									DECLARE ALMALOTC_Costo DOUBLE(10,2);
									DECLARE ALMACENPROLOTE_CURSOREL CURSOR FOR SELECT APL.ALMALOTP_Codigo,APL.LOTP_Codigo,APL.ALMALOTC_Cantidad,APL.ALMALOTC_Costo
									FROM cji_almaprolote APL WHERE APL.COMPP_Codigo=COMPP_Codigo AND APL.ALMPROD_Codigo=@ALMPROD_Codigo ORDER BY APL.ALMALOTP_Codigo;
									DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTAR2K = TRUE;
									OPEN ALMACENPROLOTE_CURSOREL;
									LOOP21K: LOOP
									FETCH ALMACENPROLOTE_CURSOREL INTO ALMALOTP_Codigo,LOTP_Codigo,ALMALOTC_Cantidad,ALMALOTC_Costo;
									
									IF @EJECUTAR2K THEN
										LEAVE LOOP21K;
									END IF;
									SET INDICE=INDICE+1;
								
									
									IF A_GUIASADETC_Cantidad >= ALMALOTC_Cantidad  THEN 
										SET @TOTALROWS=@COUNTAPL;
										IF @TOTALROWS=INDICE THEN
											SET CANTIDADTOTAL=A_GUIASADETC_Cantidad;
											SET HECHO=1;
										ELSE
											SET CANTIDADTOTAL=ALMALOTC_Cantidad;
											SET A_GUIASADETC_Cantidad=A_GUIASADETC_Cantidad+ALMALOTC_Cantidad;
											SET HECHO=0;
										END IF;
									ELSE 
										SET CANTIDADTOTAL=A_GUIASADETC_Cantidad;
										SET HECHO=1;
									END IF;
									SET @ALMALOTC_Cantidad=0;
									SET @ALMALOTP_Codigo=0;
									SELECT APL.ALMALOTP_Codigo,APL.ALMALOTC_Cantidad INTO @ALMALOTP_Codigo,@ALMALOTC_Cantidad
									FROM cji_almaprolote APL WHERE APL.ALMPROD_Codigo=@ALMPROD_Codigo AND APL.COMPP_Codigo=COMPP_Codigo AND APL.LOTP_Codigo=LOTP_Codigo LIMIT 0,1;
										
									SET @ALMALOTC_Cantidad=@ALMALOTC_Cantidad+CANTIDADTOTAL;
									CALL MANTENIMIENTO_ALMACENLOTE(@ALMALOTP_Codigo,NULL,NULL,NULL,@ALMALOTC_Cantidad,NULL,'',NULL,1,NULL,NULL,NULL);
									

									END LOOP LOOP21K;
									CLOSE ALMACENPROLOTE_CURSOREL;
								END BLOCK2K;				
							END IF;
							
						END IF;	
					END IF;
					END LOOP LOOPGD;
					CLOSE GUIASADETALLE_CURSORELE;
				END BLOCKELIMINAR;	
				
				
				SET FECHAKARDEXANTERIOR=(SELECT KD.KARD_Fecha FROM cji_kardex KD WHERE KD.KARDC_TipoIngreso='2' AND KD.KARDC_CodigoDoc=GUIASAP_Codigo LIMIT 1);
				IF (FECHAKARDEXANTERIOR IS NULL OR FECHAKARDEXANTERIOR='0000-00-00 00:00:00') THEN
						SET FECHAKARDEXANTERIOR=@FECHAGUIASADETC;
				END IF;
				
				DELETE FROM cji_kardex  WHERE KARDC_TipoIngreso='2' AND KARDC_CodigoDoc=GUIASAP_Codigo;
				DELETE AMPROSER FROM cji_seriemov AMPROSER WHERE AMPROSER.GUIASAP_Codigo=GUIASAP_Codigo;
				
				
			END IF;
			SET @FECHAGUIAINDETC=NULL;	
			IF TRIM(CPC_TipoOperacion)='C' THEN
				BLOCKELIMINARGID:BEGIN
				DECLARE A_GUIAINDETP_Codigo INT(11);
				DECLARE A_UNDMED_Codigo INT(11);
				DECLARE A_PRODCTOP_Codigo INT(11);
				DECLARE A_GUIAINDETC_Cantidad VARCHAR(45);
				DECLARE A_GUIAINDETC_Costo VARCHAR(45);
				DECLARE A_GUIIAINDETC_GenInd CHAR(1);
				DECLARE A_GUIAINDETC_FechaRegistro DATETIME;
				DECLARE D_ALMAP_Codigo INT(11);
				DECLARE GUIAINDETALLE_CURSOREL CURSOR FOR SELECT 
				GSD.GUIAINDETP_Codigo,	GSD.UNDMED_Codigo,	GSD.PRODCTOP_Codigo,GSD.GUIAINDETC_Cantidad,		GSD.GUIIAINDETC_GenInd, GSD.GUIIAINDETC_GenInd, GSD.GUIAINDETC_FechaRegistro,GSD.ALMAP_Codigo 	FROM cji_guiaindetalle GSD WHERE GSD.GUIAINP_Codigo=GUIAINP_Codigo AND GSD.GUIAINDETC_FlagEstado=1;
				DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTARGINDE = TRUE;
				OPEN GUIAINDETALLE_CURSOREL;
					LOOPGIND: LOOP
					FETCH GUIAINDETALLE_CURSOREL INTO A_GUIAINDETP_Codigo,A_UNDMED_Codigo,	A_PRODCTOP_Codigo,A_GUIAINDETC_Cantidad,A_GUIAINDETC_Costo,A_GUIIAINDETC_GenInd ,A_GUIAINDETC_FechaRegistro,D_ALMAP_Codigo ;

					IF @EJECUTARGINDE THEN
						LEAVE LOOPGIND;
					END IF;
					SET @FECHAGUIAINDETC=A_GUIAINDETC_FechaRegistro;
					CALL MANTENIMIENTO_GUIAINDETALLE(A_GUIAINDETP_Codigo,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,2,NULL,NULL,NULL,NULL);
					
					SET @COSTOPRODUCTO=A_GUIAINDETC_Costo;
					IF  MONED_Codigo<>NULL && MONED_Codigo<>1 THEN
						SET @FACTORCONVERSION=CPC_TDC; 
						IF (@FACTORCONVERSION<>NULL AND  @FACTORCONVERSION<>0) THEN
							SET @COSTOPRODUCTO=A_GUIAINDETC_Costo*@FACTORCONVERSION;
						END IF;	
					END IF;
					
					SET @PRODUNIC_flagPrincipal='';
					SET @PRODUNIC_Factor='';
					SELECT CPU.PRODUNIC_flagPrincipal,CPU.PRODUNIC_Factor INTO @PRODUNIC_flagPrincipal,@PRODUNIC_Factor
					FROM cji_productounidad CPU WHERE  CPU.PROD_Codigo=A_PRODCTOP_Codigo AND  CPU.UNDMED_Codigo=A_UNDMED_Codigo AND CPU.PRODUNIC_flagEstado=1 LIMIT 0,1;
					IF @PRODUNIC_flagPrincipal=0 THEN
						IF @PRODUNIC_Factor>0 THEN 
							SET A_GUIAINDETC_Cantidad=A_GUIAINDETC_Cantidad/@PRODUNIC_Factor;
							SET @ISDOUBLE=LOCATE('.',A_GUIAINDETC_Cantidad);
							IF @ISDOUBLE<>0 THEN 
								SET A_GUIAINDETC_Cantidad=ROUND(A_GUIAINDETC_Cantidad, 3);
							END IF;
						END IF;
					END IF;
					SET @ALMPROD_Codigo=0;
					SET @ALMPROD_Stock='';
					SET @ALMPROD_CostoPromedio='';
					SET @CANTIDADTOTAL=0;
					SET @COSTOPROMEDIO=0;
					SELECT CAP.ALMPROD_Codigo,CAP.ALMPROD_Stock, CAP.ALMPROD_CostoPromedio INTO @ALMPROD_Codigo,@ALMPROD_Stock, @ALMPROD_CostoPromedio
					FROM cji_almacenproducto CAP WHERE CAP.ALMAC_Codigo=D_ALMAP_Codigo AND CAP.PROD_Codigo=A_PRODCTOP_Codigo ORDER BY CAP.ALMPROD_Codigo DESC  LIMIT 0,1;
					
					IF (@ALMPROD_Codigo IS NOT NULL AND  @ALMPROD_Codigo<>0 )THEN
						SET @CANTIDADTOTAL=@ALMPROD_Stock-A_GUIAINDETC_Cantidad;
						IF @CANTIDADTOTAL=0 THEN 
							SET @COSTOPROMEDIO=0;
						ELSE						
							SET @COSTOPROMEDIO=((@ALMPROD_Stock*@ALMPROD_CostoPromedio)-(A_GUIAINDETC_Cantidad*A_GUIAINDETC_Costo))/@CANTIDADTOTAL;
						END IF;
						
						CALL MANTENIMIENTO_ALMACENPRODUCTO(@ALMPROD_Codigo,NULL,NULL,NULL,@CANTIDADTOTAL,@COSTOPROMEDIO,NOW(),'',1,NULL,NULL,NULL);
					
						SET @PRODUCTOSTOCKINICIAL=(SELECT CP.PROD_Stock FROM cji_producto CP WHERE CP.PROD_Codigo=A_PRODCTOP_Codigo LIMIT 0,1);
						CALL MANTENIMIENTO_PRODUCTO(A_PRODCTOP_Codigo, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, (@PRODUCTOSTOCKINICIAL-A_GUIAINDETC_Cantidad), NULL, NULL, NULL, NULL, NULL, NULL, @COSTOPRODUCTO, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL);

						
						SET @ISINVETARIADO=0;
						SET @ISINVETARIADO=(SELECT CIND.INVD_Codigo 
						FROM cji_inventariodetalle CIND
						INNER JOIN cji_inventario CIN ON CIN.INVE_Codigo=CIND.INVE_Codigo
						WHERE CIND.PROD_Codigo=A_PRODCTOP_Codigo  AND CIN.ALMAP_Codigo=D_ALMAP_Codigo
						AND CIND.INVD_FlagActivacion='1' ORDER BY CIND.INVD_Codigo DESC LIMIT 1 );
						
						
						IF (@ISINVETARIADO IS NOT NULL AND @ISINVETARIADO<>0) THEN 
							SET @LOTP_Codigo=(SELECT CL.LOTP_Codigo FROM cji_lote CL WHERE CL.GUIAINP_Codigo=GUIAINP_Codigo AND LOTC_FlagEstado=1 LIMIT 0,1);				
							CALL MANTENIMIENTO_LOTE(@LOTP_Codigo,NULL,NULL,NULL,NULL,NULL,NULL,0,2,NULL,NULL,NULL);

							SET @ALMALOTC_Cantidad=0;
							SET @ALMALOTP_Codigo=0;

							SELECT APL.ALMALOTC_Cantidad , APL.ALMALOTP_Codigo INTO @ALMALOTC_Cantidad, @ALMALOTP_Codigo FROM cji_almaprolote APL WHERE APL.COMPP_Codigo=COMPP_Codigo AND APL.ALMPROD_Codigo=@ALMPROD_Codigo AND APL.LOTP_Codigo=@LOTP_Codigo LIMIT 0,1;
							
							IF (@ALMALOTP_Codigo<>NULL AND @ALMALOTP_Codigo<>0) THEN
								CALL MANTENIMIENTO_ALMACENLOTE(@ALMALOTP_Codigo,NULL,
								NULL,NULL,(@ALMALOTC_Cantidad+A_GUIAINDETC_Cantidad),@COSTOPRODUCTO,NOW(),1,1,NULL,NULL,NULL
								);
							END IF;
						END IF;
					
					END IF;
					
					
					
					END LOOP LOOPGIND;
					CLOSE GUIAINDETALLE_CURSOREL;
				END BLOCKELIMINARGID;
				
					SET FECHAKARDEXANTERIOR=(SELECT KD.KARD_Fecha FROM cji_kardex KD WHERE KD.KARDC_TipoIngreso='1' AND KD.KARDC_CodigoDoc=GUIAINP_Codigo LIMIT 1);
					
					IF (FECHAKARDEXANTERIOR IS NULL OR FECHAKARDEXANTERIOR='0000-00-00 00:00:00') THEN
						SET FECHAKARDEXANTERIOR=@FECHAGUIAINDETC;
					END IF;
					
					DELETE FROM cji_kardex WHERE KARDC_TipoIngreso='1' AND KARDC_CodigoDoc=GUIAINP_Codigo;
					
					DELETE AMPROSER FROM cji_almacenproductoserie AMPROSER , cji_serie SER , cji_seriedocumento SERDOC  WHERE SER.SERIP_Codigo=AMPROSER.SERIP_Codigo AND SER.SERIP_Codigo=SERDOC.SERIP_Codigo  AND SERDOC.DOCUP_Codigo=@DOCUP_Codigo AND SERDOC.SERDOC_NumeroRef=CODIGO_FACTURA;
					DELETE AMPROSER FROM cji_seriemov AMPROSER WHERE AMPROSER.GUIAINP_Codigo=GUIAINP_Codigo;
			
			END IF;
			


			
			
			
			
			BLOCK12:BEGIN
				DECLARE D_PROD_Codigo INT(11);
				DECLARE D_UNDMED_Codigo INT(11);
				DECLARE D_CPDEC_Cantidad DOUBLE(10,2);
				DECLARE D_CPDEC_GenInd CHAR(1);
				DECLARE D_CPDEC_Pu_ConIgv DOUBLE(10,2);
				DECLARE D_CPDEC_Descripcion VARCHAR(150);
				DECLARE D_ALMAP_Codigo INT(11);
				DECLARE TOTALREGISTROD INT(11) DEFAULT (SELECT COUNT(*)	FROM cji_comprobantedetalle CCD	WHERE CCD.CPP_Codigo=CODIGO_FACTURA);
				DECLARE INDICEPOSICIOND INT(11) DEFAULT  0;
				DECLARE COMPROBANTED_CURSOR cursor for 
				SELECT 
				CCD.PROD_Codigo AS PROD_Codigo,
				CCD.UNDMED_Codigo AS UNDMED_Codigo,
				CCD.CPDEC_Cantidad AS CPDEC_Cantidad,
				CCD.CPDEC_GenInd AS CPDEC_GenInd,
				CCD.CPDEC_Pu_ConIgv AS CPDEC_Pu_ConIgv,
				CCD.CPDEC_Descripcion AS CPDEC_Descripcion,
				CCD.ALMAP_Codigo AS ALMAP_Codigo 
				FROM cji_comprobantedetalle CCD
				WHERE CCD.CPP_Codigo=CODIGO_FACTURA;
				DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTARDC1 = TRUE;
				OPEN COMPROBANTED_CURSOR;
				LOOP2: LOOP
				FETCH COMPROBANTED_CURSOR INTO D_PROD_Codigo,D_UNDMED_Codigo,D_CPDEC_Cantidad,D_CPDEC_GenInd,D_CPDEC_Pu_ConIgv,D_CPDEC_Descripcion,D_ALMAP_Codigo;
				
				IF INDICEPOSICIOND=TOTALREGISTROD THEN
					LEAVE LOOP2;
				END IF;

				IF TRIM(CPC_TipoOperacion)='V' THEN 
					
					CALL MANTENIMIENTO_GUIASADETALLE('',GUIASAP_Codigo,D_PROD_Codigo,D_UNDMED_Codigo ,D_CPDEC_GenInd,D_CPDEC_Cantidad,D_CPDEC_Pu_ConIgv,@CPDEC_Descripcion,NULL,NULL,1,0,NULL,NULL,NULL,D_ALMAP_Codigo);
					
					SET @PRODUNIC_flagPrincipal='';
					SET @PRODUNIC_Factor='';
					SELECT CPU.PRODUNIC_flagPrincipal,CPU.PRODUNIC_Factor INTO @PRODUNIC_flagPrincipal,@PRODUNIC_Factor
					FROM cji_productounidad CPU WHERE  CPU.PROD_Codigo=D_PROD_Codigo AND  CPU.UNDMED_Codigo=D_UNDMED_Codigo AND CPU.PRODUNIC_flagEstado=1;
					IF @PRODUNIC_flagPrincipal=0 THEN
						IF @PRODUNIC_Factor>0 THEN 
							SET D_CPDEC_Cantidad=D_CPDEC_Cantidad/@PRODUNIC_Factor;
							SET @ISDOUBLE=LOCATE('.',D_CPDEC_Cantidad);
							IF @ISDOUBLE<>0 THEN 
								SET D_CPDEC_Cantidad=ROUND(D_CPDEC_Cantidad, 3);
							END IF;
						END IF;
					END IF;
					
					SET @ALMPROD_Codigo=0;
					SET @ALMPROD_Stock='';
					SET @ALMPROD_CostoPromedio='';
					SET @CANTIDADTOTAL=0;
					SET @COSTOPROMEDIO=0;
					SELECT CAP.ALMPROD_Codigo,CAP.ALMPROD_Stock, CAP.ALMPROD_CostoPromedio INTO @ALMPROD_Codigo,@ALMPROD_Stock, @ALMPROD_CostoPromedio
					FROM cji_almacenproducto CAP WHERE CAP.ALMAC_Codigo=D_ALMAP_Codigo AND CAP.PROD_Codigo=D_PROD_Codigo;
					IF (@ALMPROD_Codigo IS NOT NULL AND  @ALMPROD_Codigo<>0) THEN
					
						IF D_CPDEC_Cantidad<>@ALMPROD_Stock THEN 
							SET @CANTIDADTOTAL=@ALMPROD_Stock-D_CPDEC_Cantidad; 
							SET @COSTOPROMEDIO=((@ALMPROD_Stock*@ALMPROD_CostoPromedio)-(D_CPDEC_Cantidad*D_CPDEC_Pu_ConIgv))/@CANTIDADTOTAL;
						END IF;
					
					
						CALL MANTENIMIENTO_ALMACENPRODUCTO(@ALMPROD_Codigo,D_ALMAP_Codigo,D_PROD_Codigo,COMPP_Codigo,@CANTIDADTOTAL,@COSTOPROMEDIO,NOW(),'',1,NULL,NULL,NULL);
					
						SET @PRODUCTOSTOCKINICIAL=(SELECT CP.PROD_Stock FROM cji_producto CP WHERE CP.PROD_Codigo=D_PROD_Codigo);
						CALL MANTENIMIENTO_PRODUCTO(D_PROD_Codigo, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, (@PRODUCTOSTOCKINICIAL-D_CPDEC_Cantidad), NULL, NULL, NULL, NULL, NULL, NULL, D_CPDEC_Pu_ConIgv, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL);
					
						
						SET @ISINVETARIADO=0;
						SET @ISINVETARIADO=(SELECT CIND.INVD_Codigo 
						FROM cji_inventariodetalle CIND
						INNER JOIN cji_inventario CIN ON CIN.INVE_Codigo=CIND.INVE_Codigo
						WHERE CIND.PROD_Codigo=D_PROD_Codigo  AND CIN.ALMAP_Codigo=D_ALMAP_Codigo
						AND CIND.INVD_FlagActivacion='1' ORDER BY CIND.INVD_Codigo DESC LIMIT 1 );
						
						
						IF (@ISINVETARIADO IS NOT NULL AND @ISINVETARIADO<>0) THEN 
						
							SET @TIPOVALORIZACION=(SELECT COMP.COMPC_TipoValorizacion FROM cji_compania COMP WHERE COMP.COMPP_Codigo=COMPP_Codigo);
							IF @TIPOVALORIZACION=0 THEN
								SET @COUNTAPL =(SELECT COUNT(*) FROM cji_almaprolote APL WHERE APL.COMPP_Codigo=COMPP_Codigo AND APL.ALMPROD_Codigo=@ALMPROD_Codigo ORDER BY APL.ALMALOTP_Codigo);
															
								BLOCK2:BEGIN
									DECLARE INDICE INT(11) DEFAULT 0;
									DECLARE CANTIDADTOTAL DOUBLE(10,2) DEFAULT 0;
									DECLARE HECHO INT(1) DEFAULT 0;
									DECLARE ALMALOTP_Codigo INT(11);
									DECLARE LOTP_Codigo INT(11);
									DECLARE ALMALOTC_Cantidad DOUBLE(10,2);
									DECLARE ALMALOTC_Costo DOUBLE(10,2);
									DECLARE ALMACENPROLOTE_CURSOR CURSOR FOR SELECT APL.ALMALOTP_Codigo,APL.LOTP_Codigo,APL.ALMALOTC_Cantidad,APL.ALMALOTC_Costo
									FROM cji_almaprolote APL WHERE APL.COMPP_Codigo=COMPP_Codigo AND APL.ALMPROD_Codigo=@ALMPROD_Codigo ORDER BY APL.ALMALOTP_Codigo;
									DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTAR2 = TRUE;
									OPEN ALMACENPROLOTE_CURSOR;
									LOOP21: LOOP
									FETCH ALMACENPROLOTE_CURSOR INTO ALMALOTP_Codigo,LOTP_Codigo,ALMALOTC_Cantidad,ALMALOTC_Costo;
									
									IF (ALMALOTP_Codigo IS NULL OR ALMALOTP_Codigo=0) THEN
										LEAVE LOOP21;
									END IF;
									
									
									IF @EJECUTAR2 THEN
										LEAVE LOOP21;
									END IF;
									SET INDICE=INDICE+1;
								
									
									IF D_CPDEC_Cantidad >= ALMALOTC_Cantidad  THEN 
										SET @TOTALROWS=@COUNTAPL;
										IF @TOTALROWS=INDICE THEN
											SET CANTIDADTOTAL=D_CPDEC_Cantidad;
											SET HECHO=1;
										ELSE
											SET CANTIDADTOTAL=ALMALOTC_Cantidad;
											SET D_CPDEC_Cantidad=D_CPDEC_Cantidad-ALMALOTC_Cantidad;
											SET HECHO=0;
										END IF;
									ELSE 
										SET CANTIDADTOTAL=D_CPDEC_Cantidad;
										SET HECHO=1;
									END IF;
									
										SET @ALMALOTC_Cantidad=0;
										SET @ALMALOTP_Codigo=0;
										SELECT APL.ALMALOTP_Codigo,APL.ALMALOTC_Cantidad INTO @ALMALOTP_Codigo,@ALMALOTC_Cantidad
										FROM cji_almaprolote APL WHERE APL.ALMPROD_Codigo=@ALMPROD_Codigo AND APL.COMPP_Codigo=COMPP_Codigo AND APL.LOTP_Codigo=LOTP_Codigo;
										
										SET @ALMALOTC_Cantidad=@ALMALOTC_Cantidad-CANTIDADTOTAL;
										CALL MANTENIMIENTO_ALMACENLOTE(@ALMALOTP_Codigo,NULL,NULL,NULL,@ALMALOTC_Cantidad,NULL,'',NULL,1,NULL,NULL,NULL);
										
										IF CANTIDADTOTAL<>0 THEN 
											CALL MANTENIMIENTO_KARDEX('',COMPP_Codigo,D_PROD_Codigo,6,2,LOTP_Codigo,GUIASAP_Codigo,'2',FECHAKARDEXANTERIOR,CANTIDADTOTAL,D_CPDEC_Pu_ConIgv,0,NULL,NULL,NULL,@ALMPROD_Codigo,1);					
										
											IF HECHO=1 THEN
												LEAVE LOOP21;
											END IF;
										END IF;
										
										
									END LOOP LOOP21;
									CLOSE ALMACENPROLOTE_CURSOR;
								END BLOCK2;				
							END IF;
						
						END IF;
						
						
					IF (D_CPDEC_GenInd IS NOT NULL AND D_CPDEC_GenInd='I') THEN 
						
						SET @COUNTASERIESV=(SELECT COUNT(*)
						FROM cji_serie SER  
						INNER JOIN cji_seriedocumento SERDOC ON SERDOC.SERIP_Codigo=SER.SERIP_Codigo
						WHERE  SERDOC.DOCUP_Codigo=@DOCUP_Codigo 
						AND SERDOC.SERDOC_NumeroRef=CODIGO_FACTURA AND SER.PROD_Codigo=D_PROD_Codigo AND SER.ALMAP_Codigo=D_ALMAP_Codigo);
										
						BLOCKSE1V:BEGIN
							DECLARE INDICESERV INT(11) DEFAULT 0;
							DECLARE SERIP_Codigo INT(11);
							DECLARE SERIC_Numero varchar(50);
							
							DECLARE SERIESV_CURSOR CURSOR FOR SELECT SER.SERIP_Codigo, SER.SERIC_Numero
							FROM cji_serie SER  
							INNER JOIN cji_seriedocumento SERDOC ON SERDOC.SERIP_Codigo=SER.SERIP_Codigo
							WHERE  SERDOC.DOCUP_Codigo=@DOCUP_Codigo 
							AND SERDOC.SERDOC_NumeroRef=CODIGO_FACTURA AND SER.PROD_Codigo=D_PROD_Codigo AND SER.ALMAP_Codigo=D_ALMAP_Codigo
							ORDER BY SER.SERIP_Codigo ASC;
							
							DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTARSERIE2V = TRUE;
							OPEN SERIESV_CURSOR;
							LOOPSE21V: LOOP
							FETCH SERIESV_CURSOR INTO SERIP_Codigo,SERIC_Numero;
									
							IF (SERIP_Codigo IS NULL OR SERIP_Codigo=0) THEN
								LEAVE LOOPSE21V;
							END IF;
							
							IF @EJECUTARSERIE2V THEN
								LEAVE LOOPSE21V;
							END IF;
							SET INDICESERV=INDICESERV+1;
							
							
							SET @SERMOVP_Codigo=NULL;
							SET @ALMPRODSERP_Codigo=NULL;
							CALL MANTENIMIENTO_SERIEMOVIMIENTO(@SERMOVP_Codigo,SERIP_Codigo,2,NULL,GUIASAP_Codigo,0);
							CALL MANTENIMIENTO_ALMACENPRODUCTOSERIE(@ALMPRODSERP_Codigo,@ALMPROD_Codigo,SERIP_Codigo,3);
							
							IF @COUNTASERIESV=INDICESERV THEN
								LEAVE LOOPSE21V;
							END IF;
							
							END LOOP LOOPSE21V;
							CLOSE SERIESV_CURSOR;
						END BLOCKSE1V;	
						
					END IF;
						
					END IF;
				END IF;
					
				IF TRIM(CPC_TipoOperacion)='C' THEN
					
					CALL MANTENIMIENTO_GUIAINDETALLE('',GUIAINP_Codigo,D_PROD_Codigo,D_UNDMED_Codigo ,D_CPDEC_GenInd,D_CPDEC_Cantidad,D_CPDEC_Pu_ConIgv,@CPDEC_Descripcion,NULL,NULL,1,0,NULL,NULL,NULL,D_ALMAP_Codigo);
					
					SET @COSTOPRODUCTO=D_CPDEC_Pu_ConIgv;
					IF  MONED_Codigo<>NULL && MONED_Codigo<>1 THEN
						SET @FACTORCONVERSION=(SELECT TC.TIPCAMC_FactorConversion FROM cji_tipocambio TC WHERE TC.TIPCAMC_MonedaOrigen=1 AND TIPCAMC_MonedaDestino=MONED_Codigo AND TC.COMPP_Codigo=COMPP_Codigo AND TIPCAMC_FlagEstado=1 ORDER BY TIPCAMP_Codigo DESC LIMIT 0,1); 
						IF (@FACTORCONVERSION<>NULL AND  @FACTORCONVERSION<>0) THEN
							SET @COSTOPRODUCTO=D_CPDEC_Pu_ConIgv*@FACTORCONVERSION;
						END IF;	
					END IF;
					
					SET @PRODUNIC_flagPrincipal='';
					SET @PRODUNIC_Factor='';
					SELECT CPU.PRODUNIC_flagPrincipal,CPU.PRODUNIC_Factor INTO @PRODUNIC_flagPrincipal,@PRODUNIC_Factor
					FROM cji_productounidad CPU WHERE  CPU.PROD_Codigo=D_PROD_Codigo AND  CPU.UNDMED_Codigo=D_UNDMED_Codigo AND CPU.PRODUNIC_flagEstado=1;
					IF @PRODUNIC_flagPrincipal=0 THEN
						IF @PRODUNIC_Factor>0 THEN 
							SET D_CPDEC_Cantidad=D_CPDEC_Cantidad/@PRODUNIC_Factor;
							SET @ISDOUBLE=LOCATE('.',D_CPDEC_Cantidad);
							IF @ISDOUBLE<>0 THEN 
								SET D_CPDEC_Cantidad=ROUND(D_CPDEC_Cantidad, 3);
							END IF;
						END IF;

					END IF;
					
					SET @ALMPROD_Codigo=0;
					SET @ALMPROD_Stock='';
					SET @ALMPROD_CostoPromedio='';
					SET @CANTIDADTOTAL=0;
					SET @COSTOPROMEDIO=0;
					SELECT CAP.ALMPROD_Codigo,CAP.ALMPROD_Stock, CAP.ALMPROD_CostoPromedio INTO @ALMPROD_Codigo,@ALMPROD_Stock, @ALMPROD_CostoPromedio
					FROM cji_almacenproducto CAP WHERE CAP.ALMAC_Codigo=D_ALMAP_Codigo AND CAP.PROD_Codigo=D_PROD_Codigo;
					IF (@ALMPROD_Codigo IS NOT NULL AND  @ALMPROD_Codigo<>0 )THEN
						SET @CANTIDADTOTAL=@ALMPROD_Stock+D_CPDEC_Cantidad;
						IF @CANTIDADTOTAL=0 THEN 
							SET @COSTOPROMEDIO=0;
						ELSE						
							SET @COSTOPROMEDIO=((@ALMPROD_Stock*@ALMPROD_CostoPromedio)+(D_CPDEC_Cantidad*D_CPDEC_Pu_ConIgv))/@CANTIDADTOTAL;
						END IF;
						
						CALL MANTENIMIENTO_ALMACENPRODUCTO(@ALMPROD_Codigo,D_ALMAP_Codigo,D_PROD_Codigo,COMPP_Codigo,@CANTIDADTOTAL,@COSTOPROMEDIO,NOW(),'',1,NULL,NULL,NULL);
					
						SET @PRODUCTOSTOCKINICIAL=(SELECT CP.PROD_Stock FROM cji_producto CP WHERE CP.PROD_Codigo=D_PROD_Codigo LIMIT 0,1);
						CALL MANTENIMIENTO_PRODUCTO(D_PROD_Codigo, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, (@PRODUCTOSTOCKINICIAL+D_CPDEC_Cantidad), NULL, NULL, NULL, NULL, NULL, NULL, @COSTOPRODUCTO, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL);
						
						
						SET @ISINVETARIADO=0;
						SET @ISINVETARIADO=(SELECT CIND.INVD_Codigo 
						FROM cji_inventariodetalle CIND
						INNER JOIN cji_inventario CIN ON CIN.INVE_Codigo=CIND.INVE_Codigo
						WHERE CIND.PROD_Codigo=D_PROD_Codigo  AND CIN.ALMAP_Codigo=D_ALMAP_Codigo
						AND CIND.INVD_FlagActivacion='1' ORDER BY CIND.INVD_Codigo DESC LIMIT 1  );
						
						
						
						IF (@ISINVETARIADO IS NOT NULL AND @ISINVETARIADO<>0) THEN 
							SET @LOTP_Codigo='';	
							CALL MANTENIMIENTO_LOTE(@LOTP_Codigo,D_PROD_Codigo,D_CPDEC_Cantidad,@COSTOPRODUCTO,GUIAINP_Codigo,NOW(),NULL,1,0,NULL,NULL,NULL);
							
							SET @ALMALOTC_Cantidad=0;
							SET @ALMALOTP_Codigo=0;

							SELECT APL.ALMALOTC_Cantidad , APL.ALMALOTP_Codigo INTO @ALMALOTC_Cantidad, @ALMALOTP_Codigo
							FROM cji_almaprolote APL WHERE APL.COMPP_Codigo=COMPP_Codigo AND APL.ALMPROD_Codigo=@ALMPROD_Codigo AND APL.LOTP_Codigo=@LOTP_Codigo LIMIT 0,1;
							
							
							IF (@ALMALOTP_Codigo IS NOT NULL AND @ALMALOTP_Codigo<>0) THEN
								CALL MANTENIMIENTO_ALMACENLOTE(@ALMALOTP_Codigo,NULL,
								NULL,NULL,(@ALMALOTC_Cantidad+D_CPDEC_Cantidad),@COSTOPRODUCTO,NOW(),1,1,NULL,NULL,NULL
								);
							ELSE
								CALL MANTENIMIENTO_ALMACENLOTE(@ALMALOTP_Codigo,@ALMPROD_Codigo,@LOTP_Codigo,COMPP_Codigo,D_CPDEC_Cantidad,@COSTOPRODUCTO,NOW(),1,0,NULL,NULL,NULL);
							END IF;
							
							CALL MANTENIMIENTO_KARDEX('',COMPP_Codigo,D_PROD_Codigo,5,2,@LOTP_Codigo,GUIAINP_Codigo,'1',FECHAKARDEXANTERIOR,D_CPDEC_Cantidad,@COSTOPRODUCTO,0,NULL,NULL,NULL,@ALMPROD_Codigo,1);
							
						END IF;
					
					ELSE
						SET @CANTIDADTOTAL=D_CPDEC_Cantidad;
						SET @COSTOPROMEDIO=@COSTOPRODUCTO;
						
						CALL MANTENIMIENTO_ALMACENPRODUCTO(@ALMPROD_Codigo,D_ALMAP_Codigo,D_PROD_Codigo,COMPP_Codigo,@CANTIDADTOTAL,@COSTOPROMEDIO,NOW(),'',0,NULL,NULL,NULL);
					END IF;
					
					
					IF (D_CPDEC_GenInd IS NOT NULL AND D_CPDEC_GenInd='I') THEN 
						
						SET @COUNTASERIES=(SELECT COUNT(*)
						FROM cji_serie SER  
						INNER JOIN cji_seriedocumento SERDOC ON SERDOC.SERIP_Codigo=SER.SERIP_Codigo
						WHERE  SERDOC.DOCUP_Codigo=@DOCUP_Codigo 
						AND SERDOC.SERDOC_NumeroRef=CODIGO_FACTURA AND SER.PROD_Codigo=D_PROD_Codigo AND SER.ALMAP_Codigo=D_ALMAP_Codigo);	
						
						BLOCKSE1:BEGIN
							DECLARE INDICESER INT(11) DEFAULT 0;
							DECLARE SERIP_Codigo INT(11);
							DECLARE SERIC_Numero varchar(50)	;
							DECLARE SERIES_CURSOR CURSOR FOR SELECT SER.SERIP_Codigo, SER.SERIC_Numero
							FROM cji_serie SER  
							INNER JOIN cji_seriedocumento SERDOC ON SERDOC.SERIP_Codigo=SER.SERIP_Codigo
							WHERE  SERDOC.DOCUP_Codigo=@DOCUP_Codigo 
							AND SERDOC.SERDOC_NumeroRef=CODIGO_FACTURA AND SER.PROD_Codigo=D_PROD_Codigo AND SER.ALMAP_Codigo=D_ALMAP_Codigo
							ORDER BY SER.SERIP_Codigo ASC;
							
							DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTARSERIE2 = TRUE;
							OPEN SERIES_CURSOR;
							LOOPSE21: LOOP
							FETCH SERIES_CURSOR INTO SERIP_Codigo,SERIC_Numero;
									
							IF (SERIP_Codigo IS NULL OR SERIP_Codigo=0) THEN
								LEAVE LOOPSE21;
							END IF;
							
							IF @EJECUTARSERIE2 THEN
								LEAVE LOOPSE21;
							END IF;
							SET INDICESER=INDICESER+1;
							
							
							SET @SERMOVP_Codigo=NULL;
							SET @ALMPRODSERP_Codigo=NULL;
							CALL MANTENIMIENTO_SERIEMOVIMIENTO(@SERMOVP_Codigo,SERIP_Codigo,1,GUIAINP_Codigo,NULL,0);
							CALL MANTENIMIENTO_ALMACENPRODUCTOSERIE(@ALMPRODSERP_Codigo,@ALMPROD_Codigo,SERIP_Codigo,0);
							
							IF @COUNTASERIES=INDICESER THEN
								LEAVE LOOPSE21;
							END IF;
							
							END LOOP LOOPSE21;
							CLOSE SERIES_CURSOR;
						END BLOCKSE1;	
						
					END IF;
					
					
				END IF;
				SET INDICEPOSICIOND=INDICEPOSICIOND+1;
				END LOOP LOOP2; 
				CLOSE COMPROBANTED_CURSOR;
			END BLOCK12;

			
			CALL CREACION_GUIA_INTERNA(CODIGO_FACTURA,@DOCUP_Codigo,CPC_TipoOperacion);
			
			
		END IF;
	
	END LOOP LOOP1MO; 
	CLOSE FACTURA_CURSOR;
END BLOCK1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `COMPROBANTE_GUIAREM_MODIFICAR` (IN `CODIGO_FACTURA` INT(11))  BLOCK1:BEGIN
DECLARE CPP_Codigo INT(11); 
DECLARE CPC_TipoOperacion CHAR(1); 
DECLARE CPC_TipoDocumento CHAR(1); 
DECLARE PRESUP_Codigo INT(11); 
DECLARE OCOMP_Codigo INT(11); 
DECLARE COMPP_Codigo INT(11); 
DECLARE CPC_Serie CHAR(4); 
DECLARE CPC_Numero VARCHAR(11); 
DECLARE CLIP_Codigo INT(11); 
DECLARE PROVP_Codigo INT(11); 
DECLARE CPC_NombreAuxiliar VARCHAR(25); 
DECLARE USUA_Codigo INT(11); 
DECLARE MONED_Codigo INT(11); 
DECLARE FORPAP_Codigo INT(11); 
DECLARE CPC_subtotal DOUBLE(10,2); 
DECLARE CPC_descuento DOUBLE(10,2); 
DECLARE CPC_igv DOUBLE(10,2); 
DECLARE CPC_total DOUBLE(10,2); 
DECLARE CPC_subtotal_conigv DOUBLE(10,2); 
DECLARE CPC_descuento_conigv DOUBLE(10,2); 
DECLARE CPC_igv100 INT(11); 
DECLARE CPC_descuento100 INT(11); 
DECLARE GUIAREMP_Codigo INT(11); 
DECLARE CPC_GuiaRemCodigo VARCHAR(50); 
DECLARE CPC_DocuRefeCodigo VARCHAR(50); 
DECLARE CPC_Observacion TEXT; 
DECLARE CPC_ModoImpresion CHAR(1); 
DECLARE CPC_Fecha DATE; 
DECLARE CPC_Vendedor INT(11); 
DECLARE CPC_TDC DOUBLE(10,2); 
DECLARE CPC_FlagMueveStock CHAR(1); 
DECLARE GUIASAP_Codigo INT(11); 
DECLARE GUIAINP_Codigo INT(11); 
DECLARE USUA_anula INT(11); 
DECLARE CPC_FechaRegistro TIMESTAMP; 
DECLARE CPC_FechaModificacion DATETIME; 
DECLARE CPC_FlagEstado CHAR(1); 
DECLARE CPC_Hora TIME; 
DECLARE ALMAP_Codigo INT(11); 
DECLARE CPP_Codigo_Canje INT(11);
DECLARE CPC_NumeroAutomatico INT(1)
;

DECLARE FACTURA_CURSORMODI cursor for 
SELECT 
			  gs.CPP_Codigo AS CPP_Codigo,
			  gs.CPC_TipoOperacion AS CPC_TipoOperacion,
			  gs.CPC_TipoDocumento AS CPC_TipoDocumento,
			  gs.PRESUP_Codigo AS PRESUP_Codigo,
			  gs.OCOMP_Codigo AS OCOMP_Codigo,
			  gs.COMPP_Codigo AS COMPP_Codigo,
			  gs.CPC_Serie AS CPC_Serie,
			  gs.CPC_Numero AS CPC_Numero,
			  gs.CLIP_Codigo AS CLIP_Codigo,
			  gs.PROVP_Codigo AS PROVP_Codigo,
			  gs.CPC_NombreAuxiliar AS CPC_NombreAuxiliar,
			  gs.USUA_Codigo AS USUA_Codigo,
			  gs.MONED_Codigo AS MONED_Codigo,
			  gs.FORPAP_Codigo AS FORPAP_Codigo,
			  gs.CPC_subtotal AS CPC_subtotal,
			  gs.CPC_descuento AS CPC_descuento,
			  gs.CPC_igv AS CPC_igv,
			  gs.CPC_total AS CPC_total,
			  gs.CPC_subtotal_conigv AS CPC_subtotal_conigv,
			  gs.CPC_descuento_conigv AS CPC_descuento_conigv,
			  gs.CPC_igv100 AS CPC_igv100, 
			  gs.CPC_descuento100 AS CPC_descuento100,
			  gs.GUIAREMP_Codigo AS GUIAREMP_Codigo,
			  gs.CPC_GuiaRemCodigo AS CPC_GuiaRemCodigo,
			  gs.CPC_DocuRefeCodigo AS CPC_DocuRefeCodigo,
			  gs.CPC_Observacion AS CPC_Observacion,
			  gs.CPC_ModoImpresion AS CPC_ModoImpresion,
			  gs.CPC_Fecha AS CPC_Fecha,
			  gs.CPC_Vendedor AS CPC_Vendedor,
			  gs.CPC_TDC AS CPC_TDC,
			  gs.CPC_FlagMueveStock AS CPC_FlagMueveStock,
			  gs.GUIASAP_Codigo AS GUIASAP_Codigo,
			  gs.GUIAINP_Codigo AS GUIAINP_Codigo,
			  gs.USUA_anula AS USUA_anula,
			  gs.CPC_FechaRegistro AS CPC_FechaRegistro,
			  gs.CPC_FechaModificacion AS CPC_FechaModificacion,
			  gs.CPC_FlagEstado AS CPC_FlagEstado,
			  gs.CPC_Hora AS CPC_Hora,
			  gs.ALMAP_Codigo AS ALMAP_Codigo,
			  gs.CPP_Codigo_Canje AS CPP_Codigo_Canje,
			  gs.CPC_NumeroAutomatico AS CPC_NumeroAutomatico
FROM cji_comprobante gs WHERE gs.CPP_Codigo = CODIGO_FACTURA;

DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTAR = TRUE;
	OPEN FACTURA_CURSORMODI;
	LOOP1: LOOP
	FETCH FACTURA_CURSORMODI INTO 
			CPP_Codigo,
			  CPC_TipoOperacion,
			  CPC_TipoDocumento,
			  PRESUP_Codigo,
			  OCOMP_Codigo,
			  COMPP_Codigo,
			  CPC_Serie,
			  CPC_Numero,
			  CLIP_Codigo,
			  PROVP_Codigo,
			  CPC_NombreAuxiliar,
			  USUA_Codigo,
			  MONED_Codigo,
			  FORPAP_Codigo,
			  CPC_subtotal,
			  CPC_descuento,
			  CPC_igv,
			  CPC_total,
			  CPC_subtotal_conigv,
			  CPC_descuento_conigv,
			  CPC_igv100, 
			  CPC_descuento100,
			  GUIAREMP_Codigo,
			  CPC_GuiaRemCodigo,
			  CPC_DocuRefeCodigo,
			  CPC_Observacion,
			  CPC_ModoImpresion,
			  CPC_Fecha,
			  CPC_Vendedor,
			  CPC_TDC,
			  CPC_FlagMueveStock,
			  GUIASAP_Codigo,
			  GUIAINP_Codigo,
			  USUA_anula,
			  CPC_FechaRegistro,
			  CPC_FechaModificacion,
			  CPC_FlagEstado,
			  CPC_Hora,
			  ALMAP_Codigo,
			  CPP_Codigo_Canje,
			  CPC_NumeroAutomatico;

	IF @EJECUTAR THEN
		LEAVE LOOP1;
	END IF;
	
		IF (CPC_FlagEstado='1' OR TRIM(CPC_TipoDocumento)='B') THEN
				
			IF (GUIAREMP_Codigo IS NOT NULL AND GUIAREMP_Codigo<>0 )  THEN
				LEAVE LOOP1;
			END IF;
			
			CALL COMPROBANTE_DISPARADOR_MODIFICAR(CODIGO_FACTURA);
			
			SET @SERIENUMEROCOMPROBANTE=CONCAT(CPC_Serie,"-",CPC_Numero);
			SET @CODIGOGUIAREM=(SELECT GREM.GUIAREMP_Codigo FROM cji_guiarem GREM WHERE GREM.GUIAREMC_NumeroRef=@SERIENUMEROCOMPROBANTE LIMIT 1);

			SELECT @CODIGOGUIAREM;

			IF (@CODIGOGUIAREM IS NULL  OR  @CODIGOGUIAREM=0) THEN
				LEAVE LOOP1;
			ELSE

				CALL MANTENIMIENTO_GUIAREM(@CODIGOGUIAREM,NULL,NULL,NULL,USUA_Codigo,MONED_Codigo,NULL,CLIP_Codigo,PROVP_Codigo,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,CPC_Observacion,NULL,NULL,NULL,NULL,NULL,NULL,CPC_subtotal,CPC_descuento,CPC_igv,CPC_total,CPC_igv100,CPC_descuento100,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,CPC_NumeroAutomatico);
				UPDATE 	cji_guiaremdetalle GREMD SET GREMD.GUIAREMDETC_FlagEstado='0'
				WHERE GREMD.GUIAREMP_Codigo=@CODIGOGUIAREM; 	
				
		
				BLOCK12:BEGIN
					DECLARE D_CPDEP_Codigo int(11);
					DECLARE D_CPP_Codigo int(11);
					DECLARE D_PROD_Codigo int(11);
					DECLARE D_CPDEC_GenInd char(1);
					DECLARE D_UNDMED_Codigo int(11);
					DECLARE D_CPDEC_Cantidad double;
					DECLARE D_CPDEC_Pu double;
					DECLARE D_CPDEC_Subtotal double;
					DECLARE D_CPDEC_Descuento double;
					DECLARE D_CPDEC_Igv double;
					DECLARE D_CPDEC_Total double;
					DECLARE D_CPDEC_Pu_ConIgv double;
					DECLARE D_CPDEC_Subtotal_ConIgv double;
					DECLARE D_CPDEC_Descuento_ConIgv double;
					DECLARE D_CPDEC_Igv100 int(11);
					DECLARE D_CPDEC_Descuento100 int(11);
					DECLARE D_CPDEC_Costo double;
					DECLARE D_CPDEC_Descripcion varchar(250);
					DECLARE D_CPDEC_Observacion varchar(250);
					DECLARE D_CPDEC_FechaRegistro timestamp;
					DECLARE D_CPDEC_FechaModificacion datetime;
					DECLARE D_CPDEC_FlagEstado char(1);
					DECLARE TOTALREGISTROD INT(11) DEFAULT (SELECT COUNT(*)	FROM cji_comprobantedetalle CCD	WHERE CCD.CPP_Codigo=CODIGO_FACTURA);
					DECLARE INDICEPOSICIOND INT(11) DEFAULT  0;
					DECLARE COMPROBANTED_CURSORMODI cursor for 
					SELECT 
					CCD.CPDEP_Codigo AS CPDEP_Codigo,
					CCD.CPP_Codigo AS CPP_Codigo,
					CCD.PROD_Codigo AS PROD_Codigo ,
					CCD.CPDEC_GenInd AS CPDEC_GenInd ,
					CCD.UNDMED_Codigo AS UNDMED_Codigo,
					CCD.CPDEC_Cantidad AS CPDEC_Cantidad ,
					CCD.CPDEC_Pu AS CPDEC_Pu ,
					CCD.CPDEC_Subtotal AS CPDEC_Subtotal ,
					CCD.CPDEC_Descuento AS CPDEC_Descuento ,
					CCD.CPDEC_Igv AS CPDEC_Igv ,
					CCD.CPDEC_Total AS CPDEC_Total ,
					CCD.CPDEC_Pu_ConIgv AS CPDEC_Pu_ConIgv,
					CCD.CPDEC_Subtotal_ConIgv AS CPDEC_Subtotal_ConIgv ,
					CCD.CPDEC_Descuento_ConIgv AS CPDEC_Descuento_ConIgv ,
					CCD.CPDEC_Igv100 AS CPDEC_Igv100 ,
					CCD.CPDEC_Descuento100 AS CPDEC_Descuento100 ,
					CCD.CPDEC_Costo  AS CPDEC_Costo,
					CCD.CPDEC_Descripcion AS CPDEC_Descripcion ,
					CCD.CPDEC_Observacion AS CPDEC_Observacion ,
					CCD.CPDEC_FechaRegistro AS CPDEC_FechaRegistro ,
					CCD.CPDEC_FechaModificacion AS CPDEC_FechaModificacion ,
					CCD.CPDEC_FlagEstado AS CPDEC_FlagEstado 
					FROM cji_comprobantedetalle CCD
					WHERE CCD.CPP_Codigo=CODIGO_FACTURA;
					DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTARDC1 = TRUE;
					OPEN COMPROBANTED_CURSORMODI;
					LOOP2: LOOP
					FETCH COMPROBANTED_CURSORMODI INTO 
					D_CPDEP_Codigo,
					D_CPP_Codigo,
					D_PROD_Codigo,
					D_CPDEC_GenInd,
					D_UNDMED_Codigo,
					D_CPDEC_Cantidad,
					D_CPDEC_Pu,
					D_CPDEC_Subtotal,
					D_CPDEC_Descuento,
					D_CPDEC_Igv,
					D_CPDEC_Total,
					D_CPDEC_Pu_ConIgv,
					D_CPDEC_Subtotal_ConIgv,
					D_CPDEC_Descuento_ConIgv,
					D_CPDEC_Igv100,
					D_CPDEC_Descuento100,
					D_CPDEC_Costo,
					D_CPDEC_Descripcion,
					D_CPDEC_Observacion,
					D_CPDEC_FechaRegistro,
					D_CPDEC_FechaModificacion,
					D_CPDEC_FlagEstado;
					
					IF (D_CPDEP_Codigo IS NULL OR D_CPDEP_Codigo=0)THEN
						LEAVE LOOP2;
						LEAVE LOOP1;
					END IF;

					IF INDICEPOSICIOND=TOTALREGISTROD THEN
						LEAVE LOOP2;
						LEAVE LOOP1;
					END IF;
					CALL MANTENIMIENTO_GUIAREMDETALLE('',D_PROD_Codigo,D_UNDMED_Codigo,@CODIGOGUIAREM,D_CPDEC_GenInd,D_CPDEC_Cantidad,D_CPDEC_Pu,D_CPDEC_Subtotal,D_CPDEC_Descuento,D_CPDEC_Igv,D_CPDEC_Total ,D_CPDEC_Pu_ConIgv,D_CPDEC_Igv100,D_CPDEC_Descuento100,D_CPDEC_Costo,NULL,NULL,D_CPDEC_Descripcion,NULL,NULL,'',1,0,NULL,NULL,NULL);
					
					SET INDICEPOSICIOND=INDICEPOSICIOND+1;
					END LOOP LOOP2; 
					CLOSE COMPROBANTED_CURSORMODI;
				END BLOCK12;
			END IF;
		END IF;
	END LOOP LOOP1; 
	CLOSE FACTURA_CURSORMODI;
END BLOCK1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CREACION_GUIA_INTERNA` (IN `CODIGOCOMPROBANTE` INT(11), IN `DOCUP_Codigo` INT(2), IN `CPC_TipoOperacion` VARCHAR(1))  BLOCKCGI:BEGIN
	DECLARE DC_ALMAP_Codigo INT(11); 
	DECLARE ALMACENDC_CURSOR cursor for 
	SELECT 	DISTINCT CBD.ALMAP_Codigo AS ALMAP_Codigo 
	FROM cji_comprobantedetalle CBD
	WHERE CBD.CPP_Codigo=CODIGOCOMPROBANTE;

	DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTARGIN = TRUE;
	
	
	
	DELETE CGR,GR,GRD,SD
	FROM cji_comprobante_guiarem AS CGR 
	INNER JOIN cji_guiarem AS GR ON  GR.GUIAREMP_Codigo=CGR.GUIAREMP_Codigo 
	INNER JOIN cji_guiaremdetalle AS GRD ON GRD.GUIAREMP_Codigo=GR.GUIAREMP_Codigo
	LEFT JOIN  cji_seriedocumento AS SD ON SD.SERDOC_NumeroRef=GR.GUIAREMP_Codigo AND SD.DOCUP_Codigo=10
	WHERE CGR.CPP_Codigo=CODIGOCOMPROBANTE;
	
	SET @TIPOOPERACION='';
	SET @NUMERACION=0;
	SELECT CP.CPC_TipoOperacion , CP.CPC_Numero INTO @TIPOOPERACION , @NUMERACION
	FROM cji_comprobante CP WHERE CP.CPP_Codigo=CODIGOCOMPROBANTE;
	
	OPEN ALMACENDC_CURSOR;
	LOOP1GIN: LOOP
	
	FETCH ALMACENDC_CURSOR INTO DC_ALMAP_Codigo;
	
	IF @EJECUTARGIN THEN
		LEAVE LOOP1GIN;
	END IF;
	
	
	SET @CPDEC_Subtotal=0;
	SET @CPDEC_Descuento=0;
	SET @CPDEC_Igv=0;
	SET @CPDEC_Total=0;
	SET @CPDEC_Descuento100=0;
	SET @CPC_Observacion='';
	SET @USUA_Codigo=0;
	SET @MONED_Codigo=0;
	SET @CLIP_Codigo=NULL;
	SET @PROVP_Codigo=NULL;
	SET @CPC_Fecha='';
	SET @CPC_igv100=0;
	SET @COMPP_Codigo=0;
	SELECT 
	SUM(CPDEC_Subtotal) ,
	SUM(CPDEC_Descuento) ,
	SUM(CPDEC_Igv),
	SUM(CPDEC_Total),
	SUM(CPDEC_Descuento100),
	CP.USUA_Codigo,
	CP.MONED_Codigo,
	CP.CLIP_Codigo,
	CP.PROVP_Codigo,
	CP.CPC_Fecha,
	CP.CPC_Observacion,
	CP.CPC_igv100,
	CP.COMPP_Codigo
	INTO 
	@CPDEC_Subtotal,
	@CPDEC_Descuento,
	@CPDEC_Igv,
	@CPDEC_Total,
	@CPDEC_Descuento100,
	@USUA_Codigo,
	@MONED_Codigo,
	@CLIP_Codigo,
	@PROVP_Codigo,
	@CPC_Fecha,
	@CPC_Observacion,
	@CPC_igv100,
	@COMPP_Codigo
	FROM cji_comprobantedetalle CPD
	INNER JOIN cji_comprobante CP ON CP.CPP_Codigo=CPD.CPP_Codigo
	WHERE CPD.CPP_Codigo=CODIGOCOMPROBANTE
	AND CPD.ALMAP_Codigo=DC_ALMAP_Codigo;
	
	
	SET @TIPOMOVIMIENTO=0;
	SET @GUIAREMC_Serie=0;
	SET @GUIAREMC_Numero=0;
	IF  @TIPOOPERACION='V' THEN
		SET @GUIAREMC_Serie=002;
		SET @TIPOMOVIMIENTO=2;
		SET @GUIAREMC_Numero=CONCAT(@NUMERACION,'02');
	ELSE
		SET @GUIAREMC_Serie=001;
		SET @TIPOMOVIMIENTO=1;
		SET @GUIAREMC_Numero=CONCAT(@NUMERACION,'01');
	END IF;
	SET @GUIAREMC_Numero=CONCAT(@GUIAREMC_Numero,DC_ALMAP_Codigo);
	
	SET @GUIAREMP_Codigo='';
	CALL MANTENIMIENTO_GUIAREM(
		@GUIAREMP_Codigo,
   		@TIPOOPERACION,
   		@TIPOMOVIMIENTO,
   		DC_ALMAP_Codigo,
   		@USUA_Codigo ,
   		@MONED_Codigo,
   		NULL,
   		@CLIP_Codigo,
   		@PROVP_Codigo,
   		'GENERRADO GUIA INTERNO',
   		NULL,
   		NULL,
   		NULL,
   		NULL,
   		NULL,
   		NULL,
   		NULL,
   		@CPC_Fecha,
   		NULL,
   		NULL,
   		@GUIAREMC_Serie,
   		@GUIAREMC_Numero,
   		NULL,
   		NULL,
   		NULL,
   		NULL,
   		@CPC_Observacion,
   		NULL,
   		NULL,
   		NULL,
   		NULL,
   		NULL,
   		NULL,
   		@CPDEC_Subtotal,
   		@CPDEC_Descuento,
   		@CPDEC_Igv,
   		@CPDEC_Total,
   		@CPC_igv100,
   		@CPDEC_Descuento100,
   		@COMPP_Codigo,
   		0,
   		NULL,
   		NOW(),
   		NULL,
   		2,
   		@TIPOOPERACION,
		0,NULL,NULL,NULL,1,NULL);
	
	
				BLOCK12:BEGIN
					DECLARE D_CPDEP_Codigo int(11);
					DECLARE D_CPP_Codigo int(11);
					DECLARE D_PROD_Codigo int(11);
					DECLARE D_CPDEC_GenInd char(1);
					DECLARE D_UNDMED_Codigo int(11);
					DECLARE D_CPDEC_Cantidad double;
					DECLARE D_CPDEC_Pu double;
					DECLARE D_CPDEC_Subtotal double;
					DECLARE D_CPDEC_Descuento double;
					DECLARE D_CPDEC_Igv double;
					DECLARE D_CPDEC_Total double;
					DECLARE D_CPDEC_Pu_ConIgv double;
					DECLARE D_CPDEC_Subtotal_ConIgv double;
					DECLARE D_CPDEC_Descuento_ConIgv double;
					DECLARE D_CPDEC_Igv100 int(11);
					DECLARE D_CPDEC_Descuento100 int(11);
					DECLARE D_CPDEC_Costo double;
					DECLARE D_CPDEC_Descripcion varchar(250);
					DECLARE D_CPDEC_Observacion varchar(250);
					DECLARE D_CPDEC_FechaRegistro timestamp;
					DECLARE D_CPDEC_FechaModificacion datetime;
					DECLARE D_CPDEC_FlagEstado char(1);
					DECLARE TOTALREGISTROD INT(11) DEFAULT (SELECT COUNT(*)	FROM cji_comprobantedetalle CCD	
					WHERE CCD.CPP_Codigo=CODIGOCOMPROBANTE AND CCD.ALMAP_Codigo=DC_ALMAP_Codigo);
					DECLARE INDICEPOSICIOND INT(11) DEFAULT  0;
					DECLARE COMPROBANTED_CURSORMODI cursor for 
					SELECT 
					CCD.CPDEP_Codigo AS CPDEP_Codigo,
					CCD.CPP_Codigo AS CPP_Codigo,
					CCD.PROD_Codigo AS PROD_Codigo ,
					CCD.CPDEC_GenInd AS CPDEC_GenInd ,
					CCD.UNDMED_Codigo AS UNDMED_Codigo,
					CCD.CPDEC_Cantidad AS CPDEC_Cantidad ,
					CCD.CPDEC_Pu AS CPDEC_Pu ,
					CCD.CPDEC_Subtotal AS CPDEC_Subtotal ,
					CCD.CPDEC_Descuento AS CPDEC_Descuento ,
					CCD.CPDEC_Igv AS CPDEC_Igv ,
					CCD.CPDEC_Total AS CPDEC_Total ,
					CCD.CPDEC_Pu_ConIgv AS CPDEC_Pu_ConIgv,
					CCD.CPDEC_Subtotal_ConIgv AS CPDEC_Subtotal_ConIgv ,
					CCD.CPDEC_Descuento_ConIgv AS CPDEC_Descuento_ConIgv ,
					CCD.CPDEC_Igv100 AS CPDEC_Igv100 ,
					CCD.CPDEC_Descuento100 AS CPDEC_Descuento100 ,
					CCD.CPDEC_Costo  AS CPDEC_Costo,
					CCD.CPDEC_Descripcion AS CPDEC_Descripcion ,
					CCD.CPDEC_Observacion AS CPDEC_Observacion ,
					CCD.CPDEC_FechaRegistro AS CPDEC_FechaRegistro ,
					CCD.CPDEC_FechaModificacion AS CPDEC_FechaModificacion ,
					CCD.CPDEC_FlagEstado AS CPDEC_FlagEstado 
					FROM cji_comprobantedetalle CCD
					WHERE CCD.CPP_Codigo=CODIGOCOMPROBANTE
					AND CCD.ALMAP_Codigo=DC_ALMAP_Codigo;
					DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTARDC1 = TRUE;
					OPEN COMPROBANTED_CURSORMODI;
					LOOP2: LOOP
					FETCH COMPROBANTED_CURSORMODI INTO 
					D_CPDEP_Codigo,
					D_CPP_Codigo,
					D_PROD_Codigo,
					D_CPDEC_GenInd,
					D_UNDMED_Codigo,
					D_CPDEC_Cantidad,
					D_CPDEC_Pu,
					D_CPDEC_Subtotal,
					D_CPDEC_Descuento,
					D_CPDEC_Igv,
					D_CPDEC_Total,
					D_CPDEC_Pu_ConIgv,
					D_CPDEC_Subtotal_ConIgv,
					D_CPDEC_Descuento_ConIgv,
					D_CPDEC_Igv100,
					D_CPDEC_Descuento100,
					D_CPDEC_Costo,
					D_CPDEC_Descripcion,
					D_CPDEC_Observacion,
					D_CPDEC_FechaRegistro,
					D_CPDEC_FechaModificacion,
					D_CPDEC_FlagEstado;
					
					IF (D_CPDEP_Codigo IS NULL OR D_CPDEP_Codigo=0)THEN
						LEAVE LOOP2;
					END IF;

					IF INDICEPOSICIOND=TOTALREGISTROD THEN
						LEAVE LOOP2;
					END IF;
					CALL MANTENIMIENTO_GUIAREMDETALLE('',D_PROD_Codigo,D_UNDMED_Codigo,@GUIAREMP_Codigo,D_CPDEC_GenInd,D_CPDEC_Cantidad,D_CPDEC_Pu,D_CPDEC_Subtotal,D_CPDEC_Descuento,D_CPDEC_Igv,D_CPDEC_Total ,D_CPDEC_Pu_ConIgv,D_CPDEC_Igv100,D_CPDEC_Descuento100,D_CPDEC_Costo,NULL,NULL,D_CPDEC_Descripcion,NULL,NULL,'',1,0,NULL,NULL,NULL,DC_ALMAP_Codigo);
					
					
					IF (D_CPDEC_GenInd IS NOT NULL AND D_CPDEC_GenInd='I') THEN 
						
						SET @COUNTASERIES=(SELECT COUNT(*)
						FROM cji_serie SER  
						INNER JOIN cji_seriedocumento SERDOC ON SERDOC.SERIP_Codigo=SER.SERIP_Codigo
						WHERE  SERDOC.DOCUP_Codigo=DOCUP_Codigo
						AND SERDOC.SERDOC_NumeroRef=CODIGOCOMPROBANTE AND SER.PROD_Codigo=D_PROD_Codigo AND SER.ALMAP_Codigo=DC_ALMAP_Codigo);	
						
						BLOCKSE1:BEGIN
							DECLARE INDICESER INT(11) DEFAULT 0;
							DECLARE SERIP_Codigo INT(11);
							DECLARE SERIC_Numero varchar(50)	;
							DECLARE SERIES_CURSOR CURSOR FOR SELECT SER.SERIP_Codigo, SER.SERIC_Numero
							FROM cji_serie SER  
							INNER JOIN cji_seriedocumento SERDOC ON SERDOC.SERIP_Codigo=SER.SERIP_Codigo
							WHERE  SERDOC.DOCUP_Codigo=DOCUP_Codigo 
							AND SERDOC.SERDOC_NumeroRef=CODIGOCOMPROBANTE AND SER.PROD_Codigo=D_PROD_Codigo AND SER.ALMAP_Codigo=DC_ALMAP_Codigo
							ORDER BY SER.SERIP_Codigo ASC;
							
							DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTARSERIE2 = TRUE;
							OPEN SERIES_CURSOR;
							LOOPSE21: LOOP
							FETCH SERIES_CURSOR INTO SERIP_Codigo,SERIC_Numero;
									
							IF (SERIP_Codigo IS NULL OR SERIP_Codigo=0) THEN
								LEAVE LOOPSE21;
							END IF;
							
							IF @EJECUTARSERIE2 THEN
								LEAVE LOOPSE21;
							END IF;
							SET INDICESER=INDICESER+1;
							
							SET @VALORTIPOOPERACION=1;
							IF (TRIM(CPC_TipoOperacion)='V')THEN
								SET @VALORTIPOOPERACION=2;
							END IF;
							
							CALL MANTENIMIENTO_SERIEDOCUMENTO('',SERIP_Codigo,10,@GUIAREMP_Codigo,@VALORTIPOOPERACION,'',1,0);
							
							IF @COUNTASERIES=INDICESER THEN
								LEAVE LOOPSE21;
							END IF;
							
							END LOOP LOOPSE21;
							CLOSE SERIES_CURSOR;
						END BLOCKSE1;	
						
					END IF;
					
					
					
					
					
					
					
					SET INDICEPOSICIOND=INDICEPOSICIOND+1;
					END LOOP LOOP2; 
					CLOSE COMPROBANTED_CURSORMODI;
				END BLOCK12;
	
	CALL 	MANTENIMIENTO_COMPROBANTE_GUIAREM('',CODIGOCOMPROBANTE,@GUIAREMP_Codigo,3,0);
	
	
	
	END LOOP LOOP1GIN; 
	CLOSE ALMACENDC_CURSOR;
END BLOCKCGI$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GUIAREM_COMPROBANTE_MODIFICAR` (IN `CODIGO_GUIAREM` INT(11))  BLOCKGC1:BEGIN
DECLARE GUIAREMP_Codigo int(11);
DECLARE GUIAREMC_TipoOperacion char(1);
DECLARE TIPOMOVP_Codigo int(11);
DECLARE ALMAP_Codigo int(11);
DECLARE USUA_Codigo int(11);
DECLARE MONED_Codigo int(11);
DECLARE DOCUP_Codigo int(11);
DECLARE CLIP_Codigo int(11);
DECLARE PROVP_Codigo int(11);
DECLARE GUIAREMC_PersReceNombre varchar(150);
DECLARE GUIAREMC_PersReceDNI char(8);
DECLARE EMPRP_Codigo int(11);
DECLARE GUIASAP_Codigo int(11);
DECLARE GUIAINP_Codigo int(11);
DECLARE PRESUP_Codigo int(11);
DECLARE OCOMP_Codigo int(11);
DECLARE GUIAREMC_OtroMotivo varchar(250);
DECLARE GUIAREMC_Fecha date;
DECLARE GUIAREMC_NumeroRef varchar(50);
DECLARE GUIAREMC_OCompra varchar(50);
DECLARE GUIAREMC_Serie varchar(10);
DECLARE GUIAREMC_Numero varchar(11);
DECLARE GUIAREMC_CodigoUsuario varchar(50);
DECLARE GUIAREMC_FechaTraslado date;
DECLARE GUIAREMC_PuntoPartida varchar(250);
DECLARE GUIAREMC_PuntoLlegada varchar(250);
DECLARE GUIAREMC_Observacion text;
DECLARE GUIAREMC_Marca varchar(100);
DECLARE GUIAREMC_Placa varchar(20);
DECLARE GUIAREMC_RegistroMTC varchar(20);
DECLARE GUIAREMC_Certificado varchar(100);
DECLARE GUIAREMC_Licencia varchar(100);
DECLARE GUIAREMC_NombreConductor varchar(150);
DECLARE GUIAREMC_subtotal double(10,2);
DECLARE GUIAREMC_descuento double(10,2);
DECLARE GUIAREMC_igv double(10,2);
DECLARE GUIAREMC_total double(10,2);
DECLARE GUIAREMC_igv100 int(11);
DECLARE GUIAREMC_descuento100 int(11);
DECLARE COMPP_Codigo int(11);
DECLARE GUIAREMC_FlagMueveStock char(1);
DECLARE USUA_Anula int(11);
DECLARE GUIAREMC_FechaRegistro timestamp;
DECLARE GUIAREMC_FechaModificacion datetime;
DECLARE GUIAREMC_FlagEstado char(1);
DECLARE CPC_TipoOperacion char(1);
DECLARE GUIAREMC_NumeroAutomatico char(1);

DECLARE GUIAREM_CURSOR CURSOR FOR 
	SELECT 
 		GR.GUIAREMP_Codigo AS GUIAREMP_Codigo ,
   		GR.GUIAREMC_TipoOperacion AS GUIAREMC_TipoOperacion,
   		GR.TIPOMOVP_Codigo AS TIPOMOVP_Codigo,
   		GR.ALMAP_Codigo AS ALMAP_Codigo,
   		GR.USUA_Codigo AS USUA_Codigo ,
   		GR.MONED_Codigo AS MONED_Codigo,
   		GR.DOCUP_Codigo AS DOCUP_Codigo,
   		GR.CLIP_Codigo AS CLIP_Codigo,
   		GR.PROVP_Codigo AS PROVP_Codigo,
   		GR.GUIAREMC_PersReceNombre AS GUIAREMC_PersReceNombre,
   		GR.GUIAREMC_PersReceDNI AS GUIAREMC_PersReceDNI,
   		GR.EMPRP_Codigo AS EMPRP_Codigo,
   		GR.GUIASAP_Codigo AS GUIASAP_Codigo,
   		GR.GUIAINP_Codigo AS GUIAINP_Codigo,
   		GR.PRESUP_Codigo AS PRESUP_Codigo,
   		GR.OCOMP_Codigo AS OCOMP_Codigo,
   		GR.GUIAREMC_OtroMotivo AS GUIAREMC_OtroMotivo,
   		GR.GUIAREMC_Fecha AS GUIAREMC_Fecha,
   		GR.GUIAREMC_NumeroRef AS GUIAREMC_NumeroRef ,
   		GR.GUIAREMC_OCompra AS GUIAREMC_OCompra,
   		GR.GUIAREMC_Serie AS GUIAREMC_Serie,
   		GR.GUIAREMC_Numero AS GUIAREMC_Numero,
   		GR.GUIAREMC_CodigoUsuario AS GUIAREMC_CodigoUsuario,
   		GR.GUIAREMC_FechaTraslado AS GUIAREMC_FechaTraslado,
   		GR.GUIAREMC_PuntoPartida AS GUIAREMC_PuntoPartida,
   		GR.GUIAREMC_PuntoLlegada AS GUIAREMC_PuntoLlegada,
   		GR.GUIAREMC_Observacion AS GUIAREMC_Observacion,
   		GR.GUIAREMC_Marca AS GUIAREMC_Marca,
   		GR.GUIAREMC_Placa AS GUIAREMC_Placa,
   		GR.GUIAREMC_RegistroMTC AS GUIAREMC_RegistroMTC,
   		GR.GUIAREMC_Certificado AS GUIAREMC_Certificado,
   		GR.GUIAREMC_Licencia AS GUIAREMC_Licencia,
   		GR.GUIAREMC_NombreConductor AS GUIAREMC_NombreConductor,
   		GR.GUIAREMC_subtotal AS GUIAREMC_subtotal,
   		GR.GUIAREMC_descuento AS GUIAREMC_descuento,
   		GR.GUIAREMC_igv AS GUIAREMC_igv,
   		GR.GUIAREMC_total AS GUIAREMC_total,
   		GR.GUIAREMC_igv100 AS GUIAREMC_igv100,
   		GR.GUIAREMC_descuento100 AS GUIAREMC_descuento100,
   		GR.COMPP_Codigo AS COMPP_Codigo,
   		GR.GUIAREMC_FlagMueveStock AS GUIAREMC_FlagMueveStock,
   		GR.USUA_Anula AS USUA_Anula,
   		GR.GUIAREMC_FechaRegistro AS GUIAREMC_FechaRegistro,
   		GR.GUIAREMC_FechaModificacion AS GUIAREMC_FechaModificacion,
   		GR.GUIAREMC_FlagEstado AS GUIAREMC_FlagEstado,
   		GR.CPC_TipoOperacion AS CPC_TipoOperacion,
   		GR.GUIAREMC_NumeroAutomatico AS GUIAREMC_NumeroAutomatico
   	FROM cji_guiarem GR WHERE GR.GUIAREMP_Codigo = CODIGO_GUIAREM;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTARGCM = TRUE;
		OPEN GUIAREM_CURSOR;
		LOOP1GCM: LOOP
		FETCH GUIAREM_CURSOR INTO 
			GUIAREMP_Codigo,
	   		GUIAREMC_TipoOperacion,
	   		TIPOMOVP_Codigo,
	   		ALMAP_Codigo,
	   		USUA_Codigo ,
	   		MONED_Codigo,
	   		DOCUP_Codigo,
	   		CLIP_Codigo,
	   		PROVP_Codigo,
	   		GUIAREMC_PersReceNombre,
	   		GUIAREMC_PersReceDNI,
	   		EMPRP_Codigo,
	   		GUIASAP_Codigo,
	   		GUIAINP_Codigo,
	   		PRESUP_Codigo,
	   		OCOMP_Codigo,
	   		GUIAREMC_OtroMotivo,
	   		GUIAREMC_Fecha,
	   		GUIAREMC_NumeroRef,
	   		GUIAREMC_OCompra,
	   		GUIAREMC_Serie,
	   		GUIAREMC_Numero,
	   		GUIAREMC_CodigoUsuario,
	   		GUIAREMC_FechaTraslado,
	   		GUIAREMC_PuntoPartida,
	   		GUIAREMC_PuntoLlegada,
	   		GUIAREMC_Observacion,
	   		GUIAREMC_Marca,
	   		GUIAREMC_Placa,
	   		GUIAREMC_RegistroMTC,
	   		GUIAREMC_Certificado,
	   		GUIAREMC_Licencia,
	   		GUIAREMC_NombreConductor,
	   		GUIAREMC_subtotal,
	   		GUIAREMC_descuento,
	   		GUIAREMC_igv,
	   		GUIAREMC_total,
	   		GUIAREMC_igv100,
	   		GUIAREMC_descuento100,
	   		COMPP_Codigo,
	   		GUIAREMC_FlagMueveStock,
	   		USUA_Anula,
	   		GUIAREMC_FechaRegistro,
	   		GUIAREMC_FechaModificacion,
	   		GUIAREMC_FlagEstado,
	   		CPC_TipoOperacion,
			GUIAREMC_NumeroAutomatico;

		IF (GUIAREMP_Codigo IS NULL OR GUIAREMP_Codigo=0) THEN
			LEAVE LOOP1GCM;
		END IF;
		
		IF @EJECUTARGCM THEN
			LEAVE LOOP1GCM;
		END IF;
		SET @FECHAACTUAL=CURDATE();
		IF GUIAREMC_FlagEstado='1' THEN
			SET GUIAREMC_FlagEstado=1;
			SET @FLAGCOMPROBANTE=NULL;
			SET @CODIGOCOMPROBANTE=NULL;
			SET @CPC_TipoDocumento=NULL;
			
			CALL GUIAREM_DISPARADOR_MODIFICAR(CODIGO_GUIAREM);
			
			
			
			SELECT CPG.CPP_Codigo, CPG.COMPGUI_FlagEstado ,CP.CPC_TipoDocumento  INTO @CODIGOCOMPROBANTE,@FLAGCOMPROBANTE,@CPC_TipoDocumento
			FROM cji_comprobante_guiarem CPG 
			INNER JOIN cji_comprobante  CP ON  CP.CPP_Codigo= CPG.CPP_Codigo
			WHERE CPG.GUIAREMP_Codigo=CODIGO_GUIAREM AND CPG.COMPGUI_FlagEstado!=0;
			
			
			IF (@CODIGOCOMPROBANTE IS NULL OR @CODIGOCOMPROBANTE=0) THEN
				LEAVE LOOP1GCM;
			ELSE
							
							
			
				SET @TOTAL_GUIAREMC_subtotal=0;
				SET @TOTAL_GUIAREMC_descuento=0;
				SET @TOTAL_GUIAREMC_igv=0;
				SET @TOTAL_GUIAREMC_total=0;
				SET @TOTAL_GUIAREMC_igv100=0;
				SET @TOTAL_GUIAREMC_descuento100=0;

				SELECT 
				SUM(GR.GUIAREMC_subtotal),
				SUM(GR.GUIAREMC_descuento),
				SUM(GR.GUIAREMC_igv),
				SUM(GR.GUIAREMC_total),
				SUM(GR.GUIAREMC_igv100),
				SUM(GR.GUIAREMC_descuento100)
				INTO
				@TOTAL_GUIAREMC_subtotal,
				@TOTAL_GUIAREMC_descuento,
				@TOTAL_GUIAREMC_igv,
				@TOTAL_GUIAREMC_total,
				@TOTAL_GUIAREMC_igv100,
				@TOTAL_GUIAREMC_descuento100
				FROM cji_comprobante_guiarem CPG
				INNER JOIN cji_guiarem GR ON  GR.GUIAREMP_Codigo=CPG.GUIAREMP_Codigo
				WHERE CPG.CPP_Codigo=@CODIGOCOMPROBANTE AND CPG.COMPGUI_FlagEstado!=0;
				
				
				
			
				
							
							
							
				CALL MANTENIMIENTO_COMPROBANTE(@CODIGOCOMPROBANTE,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,MONED_Codigo,NULL,@TOTAL_GUIAREMC_subtotal,@TOTAL_GUIAREMC_descuento,@TOTAL_GUIAREMC_igv,@TOTAL_GUIAREMC_total,NULL,NULL,@TOTAL_GUIAREMC_igv100,@TOTAL_GUIAREMC_descuento100,NULL,NULL,NULL,GUIAREMC_Observacion,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,ALMAP_Codigo,NULL,1,NULL,NULL,NULL,GUIAREMC_NumeroAutomatico);

				UPDATE 	cji_comprobantedetalle CPD	SET	CPD.CPDEC_FlagEstado='0',
				CPD.CPDEC_FechaModificacion=NOW()				 
				WHERE CPD.CPP_Codigo=@CODIGOCOMPROBANTE AND CPD.GUIAREMP_Codigo=CODIGO_GUIAREM;

				
				BLOCK12:BEGIN
					DECLARE   D_GUIAREMDETP_Codigo int(11);
					DECLARE   D_PRODCTOP_Codigo int(11);
					DECLARE   D_UNDMED_Codigo int(11);
					DECLARE   D_GUIAREMP_Codigo int(11);
					DECLARE   D_GUIAREMDETC_GenInd char(1);
					DECLARE   D_GUIAREMDETC_Cantidad varchar(45);
					DECLARE   D_GUIAREMDETC_Pu double;
					DECLARE   D_GUIAREMDETC_Subtotal double;
					DECLARE   D_GUIAREMDETC_Descuento double;
					DECLARE   D_GUIAREMDETC_Igv double;
					DECLARE   D_GUIAREMDETC_Total double;
					DECLARE   D_GUIAREMDETC_Pu_ConIgv double;
					DECLARE   D_GUIAREMDETC_Igv100 int(11);
					DECLARE   D_GUIAREMDETC_Descuento100 int(11);
					DECLARE   D_GUIAREMDETC_Costo double;
					DECLARE   D_GUIAREMDETC_Venta double;
					DECLARE   D_GUIAREMDETC_Peso double;
					DECLARE   D_GUIAREMDETC_Descripcion varchar(250);
					DECLARE   D_GUIAREMDETC_DireccionEntrega varchar(250);
					DECLARE   D_GUIAREMDETC_FechaRegistro timestamp;
					DECLARE   D_GUIAREMDET_FechaModificacion datetime;
					DECLARE   D_GUIAREMDETC_FlagEstado char(1);
					DECLARE   D_ALMAP_Codigo int(11);

					DECLARE TOTALREGISTROD INT(11) DEFAULT (SELECT COUNT(*)	FROM cji_guiaremdetalle CCD	WHERE CCD.GUIAREMP_Codigo=CODIGO_GUIAREM);
					DECLARE INDICEPOSICIOND INT(11) DEFAULT  0;
					DECLARE GUIAREMDETALLE_CURSOR cursor for 

					SELECT 
					CCD.GUIAREMDETP_Codigo AS D_GUIAREMDETP_Codigo,
					CCD.PRODCTOP_Codigo AS D_PRODCTOP_Codigo,
					CCD.UNDMED_Codigo AS D_UNDMED_Codigo,
					CCD.GUIAREMP_Codigo AS D_GUIAREMP_Codigo,
					CCD.GUIAREMDETC_GenInd AS D_GUIAREMDETC_GenInd,
					CCD.GUIAREMDETC_Cantidad AS D_GUIAREMDETC_Cantidad,
					CCD.GUIAREMDETC_Pu AS D_GUIAREMDETC_Pu,
					CCD.GUIAREMDETC_Subtotal AS D_GUIAREMDETC_Subtotal,
					CCD.GUIAREMDETC_Descuento AS D_GUIAREMDETC_Descuento,
					CCD.GUIAREMDETC_Igv AS D_GUIAREMDETC_Igv,
					CCD.GUIAREMDETC_Total AS D_GUIAREMDETC_Total,
					CCD.GUIAREMDETC_Pu_ConIgv AS D_GUIAREMDETC_Pu_ConIgv,
					CCD.GUIAREMDETC_Igv100 AS D_GUIAREMDETC_Igv100,
					CCD.GUIAREMDETC_Descuento100 AS D_GUIAREMDETC_Descuento100,
					CCD.GUIAREMDETC_Costo AS D_GUIAREMDETC_Costo,
					CCD.GUIAREMDETC_Venta AS D_GUIAREMDETC_Venta,
					CCD.GUIAREMDETC_Peso AS D_GUIAREMDETC_Peso,
					CCD.GUIAREMDETC_Descripcion AS D_GUIAREMDETC_Descripcion,
					CCD.GUIAREMDETC_DireccionEntrega AS D_GUIAREMDETC_DireccionEntrega,
					CCD.GUIAREMDETC_FechaRegistro AS D_GUIAREMDETC_FechaRegistro,
					CCD.GUIAREMDET_FechaModificacion AS D_GUIAREMDET_FechaModificacion,
					CCD.GUIAREMDETC_FlagEstado AS GUIAREMDETC_FlagEstado,
					CCD.ALMAP_Codigo AS ALMAP_Codigo

					FROM cji_guiaremdetalle CCD
					WHERE CCD.GUIAREMP_Codigo=CODIGO_GUIAREM;
					DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTARDC1 = TRUE;
					OPEN GUIAREMDETALLE_CURSOR;
					LOOP2: LOOP
					FETCH GUIAREMDETALLE_CURSOR INTO D_GUIAREMDETP_Codigo,
					D_PRODCTOP_Codigo,
					D_UNDMED_Codigo,
					D_GUIAREMP_Codigo,
					D_GUIAREMDETC_GenInd,
					D_GUIAREMDETC_Cantidad,
					D_GUIAREMDETC_Pu,
					D_GUIAREMDETC_Subtotal,
					D_GUIAREMDETC_Descuento,
					D_GUIAREMDETC_Igv,
					D_GUIAREMDETC_Total,
					D_GUIAREMDETC_Pu_ConIgv,
					D_GUIAREMDETC_Igv100,
					D_GUIAREMDETC_Descuento100,
					D_GUIAREMDETC_Costo,
					D_GUIAREMDETC_Venta,
					D_GUIAREMDETC_Peso,
					D_GUIAREMDETC_Descripcion,
					D_GUIAREMDETC_DireccionEntrega,
					D_GUIAREMDETC_FechaRegistro,
					D_GUIAREMDET_FechaModificacion,
					D_GUIAREMDETC_FlagEstado,
					D_ALMAP_Codigo;
					
					IF (D_GUIAREMDETP_Codigo IS NULL OR D_GUIAREMDETP_Codigo=0) THEN
						LEAVE LOOP2;
					END IF;
					
					IF INDICEPOSICIOND=TOTALREGISTROD THEN
						LEAVE LOOP2;
					END IF;

					
					CALL MANTENIMIENTO_COMPROBANTEDETALLE('',@CODIGOCOMPROBANTE,D_PRODCTOP_Codigo,D_GUIAREMDETC_GenInd,D_UNDMED_Codigo,D_GUIAREMDETC_Cantidad,D_GUIAREMDETC_Pu,D_GUIAREMDETC_Subtotal,D_GUIAREMDETC_Descuento,D_GUIAREMDETC_Igv,D_GUIAREMDETC_Total,D_GUIAREMDETC_Pu_ConIgv,NULL,NULL,D_GUIAREMDETC_Igv100,D_GUIAREMDETC_Descuento100,D_GUIAREMDETC_Costo,D_GUIAREMDETC_Descripcion,NULL,NULL,NULL,'1',0,NULL,NULL,NULL,D_ALMAP_Codigo,CODIGO_GUIAREM);
														
					
					SET INDICEPOSICIOND=INDICEPOSICIOND+1;
					END LOOP LOOP2; 
					CLOSE GUIAREMDETALLE_CURSOR;
				END BLOCK12;
				
				
				IF (@FLAGCOMPROBANTE IS NOT NULL AND @FLAGCOMPROBANTE<>0) THEN 
					CALL COMPROBANTE_DISPARADOR_MODIFICAR(@CODIGOCOMPROBANTE);
				END IF;
				
			END IF;
			
		ELSE
			SELECT "ERROR";
		END IF;
	END LOOP LOOP1GCM; 
	CLOSE GUIAREM_CURSOR;
END BLOCKGC1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GUIAREM_DISPARADOR` (IN `CODIGO_GUIAREM` INT(11))  BLOCK1:BEGIN
DECLARE GUIAREMP_Codigo int(11);
DECLARE GUIAREMC_TipoOperacion char(1);
DECLARE TIPOMOVP_Codigo int(11);
DECLARE ALMAP_Codigo int(11);
DECLARE USUA_Codigo int(11);
DECLARE MONED_Codigo int(11);
DECLARE DOCUP_Codigo int(11);
DECLARE CLIP_Codigo int(11);
DECLARE PROVP_Codigo int(11);
DECLARE GUIAREMC_PersReceNombre varchar(150);
DECLARE GUIAREMC_PersReceDNI char(8);
DECLARE EMPRP_Codigo int(11);
DECLARE GUIASAP_Codigo int(11);
DECLARE GUIAINP_Codigo int(11);
DECLARE PRESUP_Codigo int(11);
DECLARE OCOMP_Codigo int(11);
DECLARE GUIAREMC_OtroMotivo varchar(250);
DECLARE GUIAREMC_Fecha date;
DECLARE GUIAREMC_NumeroRef varchar(50);
DECLARE GUIAREMC_OCompra varchar(50);
DECLARE GUIAREMC_Serie varchar(10);
DECLARE GUIAREMC_Numero varchar(11);
DECLARE GUIAREMC_CodigoUsuario varchar(50);
DECLARE GUIAREMC_FechaTraslado date;
DECLARE GUIAREMC_PuntoPartida varchar(250);
DECLARE GUIAREMC_PuntoLlegada varchar(250);
DECLARE GUIAREMC_Observacion text;
DECLARE GUIAREMC_Marca varchar(100);
DECLARE GUIAREMC_Placa varchar(20);
DECLARE GUIAREMC_RegistroMTC varchar(20);
DECLARE GUIAREMC_Certificado varchar(100);
DECLARE GUIAREMC_Licencia varchar(100);
DECLARE GUIAREMC_NombreConductor varchar(150);
DECLARE GUIAREMC_subtotal double(10,2);
DECLARE GUIAREMC_descuento double(10,2);
DECLARE GUIAREMC_igv double(10,2);
DECLARE GUIAREMC_total double(10,2);
DECLARE GUIAREMC_igv100 int(11);
DECLARE GUIAREMC_descuento100 int(11);
DECLARE COMPP_Codigo int(11);
DECLARE GUIAREMC_FlagMueveStock char(1);
DECLARE USUA_Anula int(11);
DECLARE GUIAREMC_FechaRegistro timestamp;
DECLARE GUIAREMC_FechaModificacion datetime;
DECLARE GUIAREMC_FlagEstado char(1);
DECLARE CPC_TipoOperacion char(1);
DECLARE GUIAREMC_TipoGuia int(1);
DECLARE GUIAREMC_NumeroAutomatico int(1);
DECLARE GUIAREM_CURSOR CURSOR FOR 
	SELECT 
 		GR.GUIAREMP_Codigo AS GUIAREMP_Codigo ,
   		GR.GUIAREMC_TipoOperacion AS GUIAREMC_TipoOperacion,
   		GR.TIPOMOVP_Codigo AS TIPOMOVP_Codigo,
   		GR.ALMAP_Codigo AS ALMAP_Codigo,
   		GR.USUA_Codigo AS USUA_Codigo ,
   		GR.MONED_Codigo AS MONED_Codigo,
   		GR.DOCUP_Codigo AS DOCUP_Codigo,
   		GR.CLIP_Codigo AS CLIP_Codigo,
   		GR.PROVP_Codigo AS PROVP_Codigo,
   		GR.GUIAREMC_PersReceNombre AS GUIAREMC_PersReceNombre,
   		GR.GUIAREMC_PersReceDNI AS GUIAREMC_PersReceDNI,
   		GR.EMPRP_Codigo AS EMPRP_Codigo,
   		GR.GUIASAP_Codigo AS GUIASAP_Codigo,
   		GR.GUIAINP_Codigo AS GUIAINP_Codigo,
   		GR.PRESUP_Codigo AS PRESUP_Codigo,
   		GR.OCOMP_Codigo AS OCOMP_Codigo,
   		GR.GUIAREMC_OtroMotivo AS GUIAREMC_OtroMotivo,
   		GR.GUIAREMC_Fecha AS GUIAREMC_Fecha,
   		GR.GUIAREMC_NumeroRef AS GUIAREMC_NumeroRef ,
   		GR.GUIAREMC_OCompra AS GUIAREMC_OCompra,
   		GR.GUIAREMC_Serie AS GUIAREMC_Serie,
   		GR.GUIAREMC_Numero AS GUIAREMC_Numero,
   		GR.GUIAREMC_CodigoUsuario AS GUIAREMC_CodigoUsuario,
   		GR.GUIAREMC_FechaTraslado AS GUIAREMC_FechaTraslado,
   		GR.GUIAREMC_PuntoPartida AS GUIAREMC_PuntoPartida,
   		GR.GUIAREMC_PuntoLlegada AS GUIAREMC_PuntoLlegada,
   		GR.GUIAREMC_Observacion AS GUIAREMC_Observacion,
   		GR.GUIAREMC_Marca AS GUIAREMC_Marca,
   		GR.GUIAREMC_Placa AS GUIAREMC_Placa,
   		GR.GUIAREMC_RegistroMTC AS GUIAREMC_RegistroMTC,
   		GR.GUIAREMC_Certificado AS GUIAREMC_Certificado,
   		GR.GUIAREMC_Licencia AS GUIAREMC_Licencia,
   		GR.GUIAREMC_NombreConductor AS GUIAREMC_NombreConductor,
   		GR.GUIAREMC_subtotal AS GUIAREMC_subtotal,
   		GR.GUIAREMC_descuento AS GUIAREMC_descuento,
   		GR.GUIAREMC_igv AS GUIAREMC_igv,
   		GR.GUIAREMC_total AS GUIAREMC_total,
   		GR.GUIAREMC_igv100 AS GUIAREMC_igv100,
   		GR.GUIAREMC_descuento100 AS GUIAREMC_descuento100,
   		GR.COMPP_Codigo AS COMPP_Codigo,
   		GR.GUIAREMC_FlagMueveStock AS GUIAREMC_FlagMueveStock,
   		GR.USUA_Anula AS USUA_Anula,
   		GR.GUIAREMC_FechaRegistro AS GUIAREMC_FechaRegistro,
   		GR.GUIAREMC_FechaModificacion AS GUIAREMC_FechaModificacion,
   		GR.GUIAREMC_FlagEstado AS GUIAREMC_FlagEstado,
   		GR.CPC_TipoOperacion AS CPC_TipoOperacion,
		GR.GUIAREMC_TipoGuia AS GUIAREMC_TipoGuia,
		GR.GUIAREMC_NumeroAutomatico AS GUIAREMC_NumeroAutomatico
   	FROM cji_guiarem GR WHERE GR.GUIAREMP_Codigo = CODIGO_GUIAREM;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTAR = TRUE;
		OPEN GUIAREM_CURSOR;
		LOOP1: LOOP
		FETCH GUIAREM_CURSOR INTO 
			GUIAREMP_Codigo,
	   		GUIAREMC_TipoOperacion,
	   		TIPOMOVP_Codigo,
	   		ALMAP_Codigo,
	   		USUA_Codigo ,
	   		MONED_Codigo,
	   		DOCUP_Codigo,
	   		CLIP_Codigo,
	   		PROVP_Codigo,
	   		GUIAREMC_PersReceNombre,
	   		GUIAREMC_PersReceDNI,
	   		EMPRP_Codigo,
	   		GUIASAP_Codigo,
	   		GUIAINP_Codigo,
	   		PRESUP_Codigo,
	   		OCOMP_Codigo,
	   		GUIAREMC_OtroMotivo,
	   		GUIAREMC_Fecha,
	   		GUIAREMC_NumeroRef,
	   		GUIAREMC_OCompra,
	   		GUIAREMC_Serie,
	   		GUIAREMC_Numero,
	   		GUIAREMC_CodigoUsuario,
	   		GUIAREMC_FechaTraslado,
	   		GUIAREMC_PuntoPartida,
	   		GUIAREMC_PuntoLlegada,
	   		GUIAREMC_Observacion,
	   		GUIAREMC_Marca,
	   		GUIAREMC_Placa,
	   		GUIAREMC_RegistroMTC,
	   		GUIAREMC_Certificado,
	   		GUIAREMC_Licencia,
	   		GUIAREMC_NombreConductor,
	   		GUIAREMC_subtotal,
	   		GUIAREMC_descuento,
	   		GUIAREMC_igv,
	   		GUIAREMC_total,
	   		GUIAREMC_igv100,
	   		GUIAREMC_descuento100,
	   		COMPP_Codigo,
	   		GUIAREMC_FlagMueveStock,
	   		USUA_Anula,
	   		GUIAREMC_FechaRegistro,
	   		GUIAREMC_FechaModificacion,
	   		GUIAREMC_FlagEstado,
	   		CPC_TipoOperacion,
			GUIAREMC_TipoGuia,
			GUIAREMC_NumeroAutomatico
			;

		IF @EJECUTAR THEN
			LEAVE LOOP1;
		END IF;
		SET @FECHAACTUAL=CURDATE();
		

		
		IF  (GUIAREMC_TipoGuia IS NOT NULL AND GUIAREMC_TipoGuia=1) THEN
			LEAVE LOOP1;
		END IF;
		
		IF  (GUIAREMC_NumeroRef IS NOT NULL AND GUIAREMC_NumeroRef<>0 AND TRIM(GUIAREMC_NumeroRef)<>"") THEN
			LEAVE LOOP1;
		END IF;
		

		IF GUIAREMC_FlagEstado='2' THEN
			SET GUIAREMC_FlagEstado=1;
			SET @DOCUP_Codigo=10;
			SET @NUMEROAUMENTADO=0;
			SET @CODIGODOCUMENTO=0;
			SET @NUMEROAUMENTADO=0;
			SET @CODIGODOCUMENTO=0;
			SET GUIASAP_Codigo='';
			SET GUIAINP_Codigo='';
			IF TRIM(GUIAREMC_TipoOperacion)='V' THEN 
			
			SET @NUMEROGR=0;
			SET @NUMEROAUMENTADOGR=0;
			SET @SERIECGUIAREMGR=0;
			IF GUIAREMC_NumeroAutomatico=1 THEN 
				SELECT CF.CONFIC_Numero,CF.CONFIC_Serie INTO @NUMEROGR,@SERIECGUIAREMGR
				FROM cji_configuracion CF WHERE CF.COMPP_Codigo=COMPP_Codigo AND CF.DOCUP_Codigo=@DOCUP_Codigo;
				SET @NUMEROAUMENTADOGR =LPAD(@NUMEROGR+1,LENGTH(@NUMEROGR),'0');
			ELSE
				SET @NUMEROAUMENTADOGR=GUIAREMC_Numero;
				SET @SERIECGUIAREMGR=GUIAREMC_Serie;
			END IF;
			
			
			
			IF TRIM(GUIAREMC_TipoOperacion)='V' AND GUIAREMC_NumeroAutomatico=1  THEN
				UPDATE  cji_configuracion CF SET CF.CONFIC_Numero=@NUMEROAUMENTADOGR WHERE CF.COMPP_Codigo=COMPP_Codigo AND  CF.DOCUP_Codigo=@DOCUP_Codigo;
			END IF;
			
			
				SET @CODIGODOCUMENTO=6;
				SET @NUMERO=(SELECT CF.CONFIC_Numero FROM cji_configuracion CF WHERE CF.COMPP_Codigo=COMPP_Codigo AND CF.DOCUP_Codigo=@CODIGODOCUMENTO);
				SET @NUMEROAUMENTADO =@NUMERO+1;
				CALL MANTENIMIENTO_GUIASA(GUIASAP_Codigo,1,GUIAREMC_TipoOperacion,ALMAP_Codigo,USUA_Codigo,CLIP_Codigo,NULL,@DOCUP_Codigo,@FECHAACTUAL,@NUMEROAUMENTADO,GUIAREMC_Observacion,CONCAT(GUIAREMC_Marca," ",GUIAREMC_Placa),GUIAREMC_Certificado,
	   		GUIAREMC_Licencia,NULL,GUIAREMC_NombreConductor,NULL,NULL,0,1,0,NULL,NULL,NULL);
				
			ELSE
				SET @CODIGODOCUMENTO=5;
				SET @NUMERO=(SELECT CF.CONFIC_Numero FROM cji_configuracion CF WHERE CF.COMPP_Codigo=COMPP_Codigo AND CF.DOCUP_Codigo=@CODIGODOCUMENTO);
				SET @NUMEROAUMENTADO=@NUMERO+1;
				
				CALL MANTENIMIENTO_GUIAIN(GUIAINP_Codigo,2,ALMAP_Codigo,USUA_Codigo,PROVP_Codigo,OCOMP_Codigo,@DOCUP_Codigo,GUIAREMC_NumeroRef,@NUMEROAUMENTADO,@FECHAACTUAL,'',GUIAREMC_Observacion,CONCAT(GUIAREMC_Marca," ",GUIAREMC_Placa),GUIAREMC_Certificado,GUIAREMC_Licencia,'',GUIAREMC_NombreConductor,CURDATE(),NULL,0,1,0,NULL,NULL,NULL);
			END IF;

			
			UPDATE  cji_configuracion CF SET CF.CONFIC_Numero=@NUMEROAUMENTADO WHERE CF.COMPP_Codigo=COMPP_Codigo AND  CF.DOCUP_Codigo=@CODIGODOCUMENTO;
			
			CALL MANTENIMIENTO_GUIAREM(GUIAREMP_Codigo,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,GUIASAP_Codigo,GUIAINP_Codigo,NULL,NULL,NULL,NULL,NULL,NULL,@SERIECGUIAREMGR,@NUMEROAUMENTADOGR,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,GUIAREMC_FlagEstado,NULL,1,NULL,NULL,NULL,0,NULL);
			
			BLOCK12:BEGIN
				DECLARE D_PROD_Codigo INT(11);
				DECLARE D_UNDMED_Codigo INT(11);
				DECLARE D_CPDEC_Cantidad DOUBLE(10,2);
				DECLARE D_CPDEC_GenInd CHAR(1);
				DECLARE D_CPDEC_Pu_ConIgv DOUBLE(10,2);
				DECLARE D_CPDEC_Descripcion VARCHAR(150);
				DECLARE D_ALMAP_Codigo INT(11);
				DECLARE TOTALREGISTROD INT(11) DEFAULT (SELECT COUNT(*)	FROM cji_guiaremdetalle CCD	WHERE CCD.GUIAREMP_Codigo=CODIGO_GUIAREM);
				DECLARE INDICEPOSICIOND INT(11) DEFAULT  0;
				DECLARE GUIAREMDETALLE_CURSOR cursor for 
				SELECT 
				CCD.PRODCTOP_Codigo AS D_PROD_Codigo,
				CCD.UNDMED_Codigo AS D_UNDMED_Codigo,
				CCD.GUIAREMDETC_Cantidad AS D_CPDEC_Cantidad,
				CCD.GUIAREMDETC_GenInd AS D_CPDEC_GenInd,
				CCD.GUIAREMDETC_Pu_ConIgv AS D_CPDEC_Pu_ConIgv,
				CCD.GUIAREMDETC_Descripcion AS D_CPDEC_Descripcion,
				CCD.ALMAP_Codigo AS D_ALMAP_Codigo
				FROM cji_guiaremdetalle CCD
				WHERE CCD.GUIAREMP_Codigo=CODIGO_GUIAREM;
				DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTARDC1 = TRUE;
				OPEN GUIAREMDETALLE_CURSOR;
				LOOP2: LOOP
				FETCH GUIAREMDETALLE_CURSOR INTO D_PROD_Codigo,D_UNDMED_Codigo,D_CPDEC_Cantidad,D_CPDEC_GenInd,D_CPDEC_Pu_ConIgv,D_CPDEC_Descripcion,D_ALMAP_Codigo;
				
				IF INDICEPOSICIOND=TOTALREGISTROD THEN
					LEAVE LOOP2;
				END IF;

				IF TRIM(GUIAREMC_TipoOperacion)='V' THEN 
					CALL MANTENIMIENTO_GUIASADETALLE('',GUIASAP_Codigo,D_PROD_Codigo,D_UNDMED_Codigo ,D_CPDEC_GenInd,D_CPDEC_Cantidad,D_CPDEC_Pu_ConIgv,D_CPDEC_Descripcion,NULL,NULL,1,0,NULL,NULL,NULL,D_ALMAP_Codigo);
					
					SET @PRODUNIC_flagPrincipal='';
					SET @PRODUNIC_Factor='';
					SELECT CPU.PRODUNIC_flagPrincipal,CPU.PRODUNIC_Factor INTO @PRODUNIC_flagPrincipal,@PRODUNIC_Factor
					FROM cji_productounidad CPU WHERE  CPU.PROD_Codigo=D_PROD_Codigo AND  CPU.UNDMED_Codigo=D_UNDMED_Codigo AND CPU.PRODUNIC_flagEstado=1;
					IF @PRODUNIC_flagPrincipal=0 THEN
						IF @PRODUNIC_Factor>0 THEN 
							SET D_CPDEC_Cantidad=D_CPDEC_Cantidad/@PRODUNIC_Factor;
							SET @ISDOUBLE=LOCATE('.',D_CPDEC_Cantidad);
							IF @ISDOUBLE<>0 THEN 
								SET D_CPDEC_Cantidad=ROUND(D_CPDEC_Cantidad, 3);
							END IF;
						END IF;
					END IF;
					SET @ALMPROD_Codigo=0;
					SET @ALMPROD_Stock='';
					SET @ALMPROD_CostoPromedio='';
					SET @CANTIDADTOTAL=0;
					SET @COSTOPROMEDIO=0;
					SELECT CAP.ALMPROD_Codigo,CAP.ALMPROD_Stock, CAP.ALMPROD_CostoPromedio INTO @ALMPROD_Codigo,@ALMPROD_Stock, @ALMPROD_CostoPromedio
					FROM cji_almacenproducto CAP WHERE CAP.ALMAC_Codigo=D_ALMAP_Codigo AND CAP.PROD_Codigo=D_PROD_Codigo;
					IF @ALMPROD_Codigo IS NOT NULL THEN
						IF D_CPDEC_Cantidad<>@ALMPROD_Stock THEN 
							SET @CANTIDADTOTAL=@ALMPROD_Stock-D_CPDEC_Cantidad; 
							SET @COSTOPROMEDIO=((@ALMPROD_Stock*@ALMPROD_CostoPromedio)-(D_CPDEC_Cantidad*D_CPDEC_Pu_ConIgv))/@CANTIDADTOTAL;
						END IF;
					END IF;
					CALL MANTENIMIENTO_ALMACENPRODUCTO(@ALMPROD_Codigo,D_ALMAP_Codigo,D_PROD_Codigo,COMPP_Codigo,@CANTIDADTOTAL,@COSTOPROMEDIO,NOW(),'',1,NULL,NULL,NULL);
					
					SET @PRODUCTOSTOCKINICIAL=(SELECT CP.PROD_Stock FROM cji_producto CP WHERE CP.PROD_Codigo=D_PROD_Codigo);
					CALL MANTENIMIENTO_PRODUCTO(D_PROD_Codigo, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, (@PRODUCTOSTOCKINICIAL-D_CPDEC_Cantidad), NULL, NULL, NULL, NULL, NULL, NULL, D_CPDEC_Pu_ConIgv, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL);
					
					
					SET @ISINVETARIADO=0;
					SET @ISINVETARIADO=(SELECT CIND.INVD_Codigo 
						FROM cji_inventariodetalle CIND
						INNER JOIN cji_inventario CIN ON CIN.INVE_Codigo=CIND.INVE_Codigo
						WHERE CIND.PROD_Codigo=D_PROD_Codigo  AND CIN.ALMAP_Codigo=D_ALMAP_Codigo
						AND CIND.INVD_FlagActivacion='1' ORDER BY CIND.INVD_Codigo DESC LIMIT 1  );
					
					
					
					IF (@ISINVETARIADO IS NOT NULL AND @ISINVETARIADO<>0) THEN 
					
						SET @TIPOVALORIZACION=(SELECT COMP.COMPC_TipoValorizacion FROM cji_compania COMP WHERE COMP.COMPP_Codigo=COMPP_Codigo);
						IF @TIPOVALORIZACION=0 THEN
							SET @COUNTAPL =(SELECT COUNT(*) FROM cji_almaprolote APL WHERE APL.COMPP_Codigo=COMPP_Codigo AND APL.ALMPROD_Codigo=@ALMPROD_Codigo ORDER BY APL.ALMALOTP_Codigo);
							
							BLOCK2:BEGIN
								
								DECLARE INDICE INT(11) DEFAULT 0;
								DECLARE CANTIDADTOTAL DOUBLE(10,2) DEFAULT 0;
								DECLARE HECHO INT(1) DEFAULT 0;
								DECLARE ALMALOTP_Codigo INT(11);
								DECLARE LOTP_Codigo INT(11);
								DECLARE ALMALOTC_Cantidad DOUBLE(10,2);
								DECLARE ALMALOTC_Costo DOUBLE(10,2);
								DECLARE ALMACENPROLOTE_CURSOR CURSOR FOR SELECT APL.ALMALOTP_Codigo,APL.LOTP_Codigo,APL.ALMALOTC_Cantidad,APL.ALMALOTC_Costo
								FROM cji_almaprolote APL WHERE APL.COMPP_Codigo=COMPP_Codigo AND APL.ALMPROD_Codigo=@ALMPROD_Codigo ORDER BY APL.ALMALOTP_Codigo;
								DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTAR2 = TRUE;
								OPEN ALMACENPROLOTE_CURSOR;
								LOOP21: LOOP
								FETCH ALMACENPROLOTE_CURSOR INTO ALMALOTP_Codigo,LOTP_Codigo,ALMALOTC_Cantidad,ALMALOTC_Costo;
								
								IF (ALMALOTP_Codigo IS NULL OR ALMALOTP_Codigo=0) THEN
										LEAVE LOOP21;
									END IF;
									
								IF @EJECUTAR2 THEN
									LEAVE LOOP21;
								END IF;
								SET INDICE=INDICE+1;
							
								
								IF D_CPDEC_Cantidad >= ALMALOTC_Cantidad  THEN 
									SET @TOTALROWS=@COUNTAPL;
									IF @TOTALROWS=INDICE THEN
										SET CANTIDADTOTAL=D_CPDEC_Cantidad;
										SET HECHO=1;
									ELSE
										SET CANTIDADTOTAL=ALMALOTC_Cantidad;
										SET D_CPDEC_Cantidad=D_CPDEC_Cantidad-ALMALOTC_Cantidad;
										SET HECHO=0;
									END IF;
								ELSE 
									SET CANTIDADTOTAL=D_CPDEC_Cantidad;
									SET HECHO=1;
								END IF;
								
									SET @ALMALOTC_Cantidad=0;
									SET @ALMALOTP_Codigo=0;
									SELECT APL.ALMALOTP_Codigo,APL.ALMALOTC_Cantidad INTO @ALMALOTP_Codigo,@ALMALOTC_Cantidad
									FROM cji_almaprolote APL WHERE APL.ALMPROD_Codigo=@ALMPROD_Codigo AND APL.COMPP_Codigo=COMPP_Codigo AND APL.LOTP_Codigo=LOTP_Codigo;
									SET @ALMALOTC_Cantidad=@ALMALOTC_Cantidad-CANTIDADTOTAL;

									CALL MANTENIMIENTO_ALMACENLOTE(@ALMALOTP_Codigo,NULL,NULL,NULL,@ALMALOTC_Cantidad,NULL,'',NULL,1,NULL,NULL,NULL);

									IF CANTIDADTOTAL<>0 THEN 
										SET @CPC_FechaHora=CONCAT(@FECHAACTUAL,' ',curTime());
										CALL MANTENIMIENTO_KARDEX('',COMPP_Codigo,D_PROD_Codigo,6,1,LOTP_Codigo,GUIASAP_Codigo,'2',@CPC_FechaHora,CANTIDADTOTAL,D_CPDEC_Pu_ConIgv,0,NULL,NULL,NULL,@ALMPROD_Codigo,1);					
										
										IF HECHO=1 THEN
											LEAVE LOOP21;
										END IF;
									END IF;
								END LOOP LOOP21;
								CLOSE ALMACENPROLOTE_CURSOR;
							END BLOCK2;				
						END IF;
					END IF;
					
					
					
					IF (D_CPDEC_GenInd IS NOT NULL AND D_CPDEC_GenInd='I') THEN 
						
						SET @COUNTASERIESV=(SELECT COUNT(*)
						FROM cji_serie SER  
						INNER JOIN cji_seriedocumento SERDOC ON SERDOC.SERIP_Codigo=SER.SERIP_Codigo
						WHERE  SERDOC.DOCUP_Codigo=@DOCUP_Codigo 
						AND SERDOC.SERDOC_NumeroRef=CODIGO_GUIAREM AND SER.PROD_Codigo=D_PROD_Codigo AND SER.ALMAP_Codigo=D_ALMAP_Codigo);
										
						BLOCKSE1V:BEGIN
							DECLARE INDICESERV INT(11) DEFAULT 0;
							DECLARE SERIP_Codigo INT(11);
							DECLARE SERIC_Numero varchar(50);
							DECLARE SERIESV_CURSOR CURSOR FOR SELECT SER.SERIP_Codigo, SER.SERIC_Numero
							FROM cji_serie SER  
							INNER JOIN cji_seriedocumento SERDOC ON SERDOC.SERIP_Codigo=SER.SERIP_Codigo
							WHERE  SERDOC.DOCUP_Codigo=@DOCUP_Codigo 
							AND SERDOC.SERDOC_NumeroRef=CODIGO_GUIAREM AND SER.PROD_Codigo=D_PROD_Codigo AND SER.ALMAP_Codigo=D_ALMAP_Codigo
							ORDER BY SER.SERIP_Codigo ASC;
							
							DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTARSERIE2V = TRUE;
							OPEN SERIESV_CURSOR;
							LOOPSE21V: LOOP
							FETCH SERIESV_CURSOR INTO SERIP_Codigo,SERIC_Numero;
									
							IF (SERIP_Codigo IS NULL OR SERIP_Codigo=0) THEN
								LEAVE LOOPSE21V;
							END IF;
							
							IF @EJECUTARSERIE2V THEN
								LEAVE LOOPSE21V;
							END IF;
							SET INDICESERV=INDICESERV+1;
							
							
							SET @SERMOVP_Codigo=NULL;
							SET @ALMPRODSERP_Codigo=NULL;
							CALL MANTENIMIENTO_SERIEMOVIMIENTO(@SERMOVP_Codigo,SERIP_Codigo,2,NULL,GUIASAP_Codigo,0);
							CALL MANTENIMIENTO_ALMACENPRODUCTOSERIE(@ALMPRODSERP_Codigo,@ALMPROD_Codigo,SERIP_Codigo,3);
							
							IF @COUNTASERIESV=INDICESERV THEN
								LEAVE LOOPSE21V;
							END IF;
							
							END LOOP LOOPSE21V;
							CLOSE SERIESV_CURSOR;
						END BLOCKSE1V;	
						
					END IF;
					
					
				END IF;
					
				IF TRIM(GUIAREMC_TipoOperacion)='C' THEN
					
					CALL MANTENIMIENTO_GUIAINDETALLE('',GUIAINP_Codigo,D_PROD_Codigo,D_UNDMED_Codigo ,D_CPDEC_GenInd,D_CPDEC_Cantidad,D_CPDEC_Pu_ConIgv,D_CPDEC_Descripcion,NULL,NULL,1,0,NULL,NULL,NULL,D_ALMAP_Codigo);
					
					SET @COSTOPRODUCTO=D_CPDEC_Pu_ConIgv;
					IF  MONED_Codigo IS NOT NULL && MONED_Codigo<>1 THEN
						SET @FACTORCONVERSION=(SELECT TC.TIPCAMC_FactorConversion FROM cji_tipocambio TC WHERE TC.TIPCAMC_MonedaOrigen=1 AND TIPCAMC_MonedaDestino=MONED_Codigo AND TC.COMPP_Codigo=COMPP_Codigo AND TIPCAMC_FlagEstado=1 ORDER BY TIPCAMP_Codigo DESC LIMIT 0,1); 
						IF (@FACTORCONVERSION IS NOT NULL AND  @FACTORCONVERSION<>0) THEN
							SET @COSTOPRODUCTO=D_CPDEC_Pu_ConIgv*@FACTORCONVERSION;
						END IF;	
					END IF;
					
					SET @PRODUNIC_flagPrincipal='';
					SET @PRODUNIC_Factor='';
					SELECT CPU.PRODUNIC_flagPrincipal,CPU.PRODUNIC_Factor INTO @PRODUNIC_flagPrincipal,@PRODUNIC_Factor
					FROM cji_productounidad CPU WHERE  CPU.PROD_Codigo=D_PROD_Codigo AND  CPU.UNDMED_Codigo=D_UNDMED_Codigo AND CPU.PRODUNIC_flagEstado=1;
					IF @PRODUNIC_flagPrincipal=0 THEN
						IF @PRODUNIC_Factor>0 THEN 
							SET D_CPDEC_Cantidad=D_CPDEC_Cantidad/@PRODUNIC_Factor;
							SET @ISDOUBLE=LOCATE('.',D_CPDEC_Cantidad);
							IF @ISDOUBLE<>0 THEN 
								SET D_CPDEC_Cantidad=ROUND(D_CPDEC_Cantidad, 3);
							END IF;
						END IF;

					END IF;
					
					SET @ALMPROD_Codigo=0;
					SET @ALMPROD_Stock='';
					SET @ALMPROD_CostoPromedio='';
					SET @CANTIDADTOTAL=0;
					SET @COSTOPROMEDIO=0;
					SELECT CAP.ALMPROD_Codigo,CAP.ALMPROD_Stock, CAP.ALMPROD_CostoPromedio INTO @ALMPROD_Codigo,@ALMPROD_Stock, @ALMPROD_CostoPromedio
					FROM cji_almacenproducto CAP WHERE CAP.ALMAC_Codigo=D_ALMAP_Codigo AND CAP.PROD_Codigo=D_PROD_Codigo;
					IF @ALMPROD_Codigo IS NOT NULL THEN
						SET @CANTIDADTOTAL=@ALMPROD_Stock+D_CPDEC_Cantidad;
						IF @CANTIDADTOTAL=0 THEN 
							SET @COSTOPROMEDIO=0;
						ELSE						
							SET @COSTOPROMEDIO=((@ALMPROD_Stock*@ALMPROD_CostoPromedio)+(D_CPDEC_Cantidad*D_CPDEC_Pu_ConIgv))/@CANTIDADTOTAL;
						END IF;
						
						CALL MANTENIMIENTO_ALMACENPRODUCTO(@ALMPROD_Codigo,D_ALMAP_Codigo,D_PROD_Codigo,COMPP_Codigo,@CANTIDADTOTAL,@COSTOPROMEDIO,NOW(),'',1,NULL,NULL,NULL);
						
						SET @PRODUCTOSTOCKINICIAL=(SELECT CP.PROD_Stock FROM cji_producto CP WHERE CP.PROD_Codigo=D_PROD_Codigo LIMIT 0,1);
						CALL MANTENIMIENTO_PRODUCTO(D_PROD_Codigo, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, (@PRODUCTOSTOCKINICIAL+D_CPDEC_Cantidad), NULL, NULL, NULL, NULL, NULL, NULL, @COSTOPRODUCTO, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL);
						
						SET @ISINVETARIADO=0;
						SET @ISINVETARIADO=(SELECT CIND.INVD_Codigo 
						FROM cji_inventariodetalle CIND
						INNER JOIN cji_inventario CIN ON CIN.INVE_Codigo=CIND.INVE_Codigo
						WHERE CIND.PROD_Codigo=D_PROD_Codigo  AND CIN.ALMAP_Codigo=D_ALMAP_Codigo
						AND CIND.INVD_FlagActivacion='1' ORDER BY CIND.INVD_Codigo DESC LIMIT 1   );
						
						IF (@ISINVETARIADO IS NOT NULL AND @ISINVETARIADO<>0) THEN 
							SET @LOTP_Codigo='';				
							CALL MANTENIMIENTO_LOTE(@LOTP_Codigo,D_PROD_Codigo,D_CPDEC_Cantidad,@COSTOPRODUCTO,GUIAINP_Codigo,NOW(),NULL,1,0,NULL,NULL,NULL);
							
							SET @ALMALOTC_Cantidad=0;
							SET @ALMALOTP_Codigo=0;

							SELECT APL.ALMALOTC_Cantidad , APL.ALMALOTP_Codigo INTO @ALMALOTC_Cantidad, @ALMALOTP_Codigo
							FROM cji_almaprolote APL WHERE APL.COMPP_Codigo=COMPP_Codigo AND APL.ALMPROD_Codigo=@ALMPROD_Codigo AND APL.LOTP_Codigo=@LOTP_Codigo LIMIT 0,1;
							
							
							IF (@ALMALOTP_Codigo IS NOT NULL AND @ALMALOTP_Codigo<>0) THEN
								CALL MANTENIMIENTO_ALMACENLOTE(@ALMALOTP_Codigo,NULL,
								NULL,NULL,(@ALMALOTC_Cantidad+D_CPDEC_Cantidad),@COSTOPRODUCTO,NOW(),1,1,NULL,NULL,NULL
								);
							ELSE
								CALL MANTENIMIENTO_ALMACENLOTE(@ALMALOTP_Codigo,@ALMPROD_Codigo,@LOTP_Codigo,COMPP_Codigo,D_CPDEC_Cantidad,@COSTOPRODUCTO,NOW(),1,0,NULL,NULL,NULL);
							END IF;
								
							
							SET @CPC_FechaHora=CONCAT(@FECHAACTUAL,' ',curTime());
							
							CALL MANTENIMIENTO_KARDEX('',COMPP_Codigo,D_PROD_Codigo,5,1,@LOTP_Codigo,GUIAINP_Codigo,'1',@CPC_FechaHora,D_CPDEC_Cantidad,@COSTOPRODUCTO,0,NULL,NULL,NULL,@ALMPROD_Codigo,1);
						END IF;	
					
					
					ELSE
						SET @CANTIDADTOTAL=D_CPDEC_Cantidad;
						SET @COSTOPROMEDIO=@COSTOPRODUCTO;
						
						CALL MANTENIMIENTO_ALMACENPRODUCTO(@ALMPROD_Codigo,D_ALMAP_Codigo,D_PROD_Codigo,COMPP_Codigo,@CANTIDADTOTAL,@COSTOPROMEDIO,NOW(),'',1,NULL,NULL,NULL);
					END IF;
					
					
					
					IF (D_CPDEC_GenInd IS NOT NULL AND D_CPDEC_GenInd='I') THEN 
						
						SET @COUNTASERIES=(SELECT COUNT(*)
						FROM cji_serie SER  
						INNER JOIN cji_seriedocumento SERDOC ON SERDOC.SERIP_Codigo=SER.SERIP_Codigo
						WHERE  SERDOC.DOCUP_Codigo=@DOCUP_Codigo 
						AND SERDOC.SERDOC_NumeroRef=CODIGO_GUIAREM AND SER.PROD_Codigo=D_PROD_Codigo AND SER.ALMAP_Codigo=D_ALMAP_Codigo);
										
						BLOCKSE1:BEGIN
							DECLARE INDICESER INT(11) DEFAULT 0;
							DECLARE SERIP_Codigo INT(11);
							DECLARE SERIC_Numero varchar(50)	;
							DECLARE SERIES_CURSOR CURSOR FOR SELECT SER.SERIP_Codigo, SER.SERIC_Numero
							FROM cji_serie SER  
							INNER JOIN cji_seriedocumento SERDOC ON SERDOC.SERIP_Codigo=SER.SERIP_Codigo
							WHERE  SERDOC.DOCUP_Codigo=@DOCUP_Codigo 
							AND SERDOC.SERDOC_NumeroRef=CODIGO_GUIAREM AND SER.PROD_Codigo=D_PROD_Codigo AND SER.ALMAP_Codigo=D_ALMAP_Codigo
							ORDER BY SER.SERIP_Codigo ASC;
							DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTARSERIE2 = TRUE;
							OPEN SERIES_CURSOR;
							LOOPSE21: LOOP
							FETCH SERIES_CURSOR INTO SERIP_Codigo,SERIC_Numero;
									
							IF (SERIP_Codigo IS NULL OR SERIP_Codigo=0) THEN
								LEAVE LOOPSE21;
							END IF;
							
							IF @EJECUTARSERIE2 THEN
								LEAVE LOOPSE21;
							END IF;
							SET INDICESER=INDICESER+1;
							
							
							SET @SERMOVP_Codigo=NULL;
							SET @ALMPRODSERP_Codigo=NULL;
							CALL MANTENIMIENTO_SERIEMOVIMIENTO(@SERMOVP_Codigo,SERIP_Codigo,1,GUIAINP_Codigo,NULL,0);
							CALL MANTENIMIENTO_ALMACENPRODUCTOSERIE(@ALMPRODSERP_Codigo,@ALMPROD_Codigo,SERIP_Codigo,0);
							
							IF @COUNTASERIES=INDICESER THEN
								LEAVE LOOPSE21;
							END IF;
							
							END LOOP LOOPSE21;
							CLOSE SERIES_CURSOR;
						END BLOCKSE1;	
						
					END IF;
					
					
					
					
					
					
				END IF;
				SET INDICEPOSICIOND=INDICEPOSICIOND+1;
				END LOOP LOOP2; 
				CLOSE GUIAREMDETALLE_CURSOR;
			END BLOCK12;	

			
		ELSE
			SELECT "ERROR";
		END IF;
	END LOOP LOOP1; 
	CLOSE GUIAREM_CURSOR;
END BLOCK1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GUIAREM_DISPARADOR_MODIFICAR` (IN `CODIGO_GUIAREM` INT(11))  BLOCK1:BEGIN
DECLARE GUIAREMP_Codigo int(11);
DECLARE GUIAREMC_TipoOperacion char(1);
DECLARE TIPOMOVP_Codigo int(11);
DECLARE ALMAP_Codigo int(11);
DECLARE USUA_Codigo int(11);
DECLARE MONED_Codigo int(11);
DECLARE DOCUP_Codigo int(11);
DECLARE CLIP_Codigo int(11);
DECLARE PROVP_Codigo int(11);
DECLARE GUIAREMC_PersReceNombre varchar(150);
DECLARE GUIAREMC_PersReceDNI char(8);
DECLARE EMPRP_Codigo int(11);
DECLARE GUIASAP_Codigo int(11);
DECLARE GUIAINP_Codigo int(11);
DECLARE PRESUP_Codigo int(11);
DECLARE OCOMP_Codigo int(11);
DECLARE GUIAREMC_OtroMotivo varchar(250);
DECLARE GUIAREMC_Fecha date;
DECLARE GUIAREMC_NumeroRef varchar(50);
DECLARE GUIAREMC_OCompra varchar(50);
DECLARE GUIAREMC_Serie varchar(10);
DECLARE GUIAREMC_Numero varchar(11);
DECLARE GUIAREMC_CodigoUsuario varchar(50);
DECLARE GUIAREMC_FechaTraslado date;
DECLARE GUIAREMC_PuntoPartida varchar(250);
DECLARE GUIAREMC_PuntoLlegada varchar(250);
DECLARE GUIAREMC_Observacion text;
DECLARE GUIAREMC_Marca varchar(100);
DECLARE GUIAREMC_Placa varchar(20);
DECLARE GUIAREMC_RegistroMTC varchar(20);
DECLARE GUIAREMC_Certificado varchar(100);
DECLARE GUIAREMC_Licencia varchar(100);
DECLARE GUIAREMC_NombreConductor varchar(150);
DECLARE GUIAREMC_subtotal double(10,2);
DECLARE GUIAREMC_descuento double(10,2);
DECLARE GUIAREMC_igv double(10,2);
DECLARE GUIAREMC_total double(10,2);
DECLARE GUIAREMC_igv100 int(11);
DECLARE GUIAREMC_descuento100 int(11);
DECLARE COMPP_Codigo int(11);
DECLARE GUIAREMC_FlagMueveStock char(1);
DECLARE USUA_Anula int(11);
DECLARE GUIAREMC_FechaRegistro timestamp;
DECLARE GUIAREMC_FechaModificacion datetime;
DECLARE GUIAREMC_FlagEstado char(1);
DECLARE CPC_TipoOperacion char(1);
DECLARE GUIAREMC_NumeroAutomatico int(1);

DECLARE FECHAKARDEXANTERIOR DATETIME;
DECLARE GUIAREM_CURSOR CURSOR FOR 
	SELECT 
 		GR.GUIAREMP_Codigo AS GUIAREMP_Codigo ,
   		GR.GUIAREMC_TipoOperacion AS GUIAREMC_TipoOperacion,
   		GR.TIPOMOVP_Codigo AS TIPOMOVP_Codigo,
   		GR.ALMAP_Codigo AS ALMAP_Codigo,
   		GR.USUA_Codigo AS USUA_Codigo ,
   		GR.MONED_Codigo AS MONED_Codigo,
   		GR.DOCUP_Codigo AS DOCUP_Codigo,
   		GR.CLIP_Codigo AS CLIP_Codigo,
   		GR.PROVP_Codigo AS PROVP_Codigo,
   		GR.GUIAREMC_PersReceNombre AS GUIAREMC_PersReceNombre,
   		GR.GUIAREMC_PersReceDNI AS GUIAREMC_PersReceDNI,
   		GR.EMPRP_Codigo AS EMPRP_Codigo,
   		GR.GUIASAP_Codigo AS GUIASAP_Codigo,
   		GR.GUIAINP_Codigo AS GUIAINP_Codigo,
   		GR.PRESUP_Codigo AS PRESUP_Codigo,
   		GR.OCOMP_Codigo AS OCOMP_Codigo,
   		GR.GUIAREMC_OtroMotivo AS GUIAREMC_OtroMotivo,
   		GR.GUIAREMC_Fecha AS GUIAREMC_Fecha,
   		GR.GUIAREMC_NumeroRef AS GUIAREMC_NumeroRef ,
   		GR.GUIAREMC_OCompra AS GUIAREMC_OCompra,
   		GR.GUIAREMC_Serie AS GUIAREMC_Serie,
   		GR.GUIAREMC_Numero AS GUIAREMC_Numero,
   		GR.GUIAREMC_CodigoUsuario AS GUIAREMC_CodigoUsuario,
   		GR.GUIAREMC_FechaTraslado AS GUIAREMC_FechaTraslado,
   		GR.GUIAREMC_PuntoPartida AS GUIAREMC_PuntoPartida,
   		GR.GUIAREMC_PuntoLlegada AS GUIAREMC_PuntoLlegada,
   		GR.GUIAREMC_Observacion AS GUIAREMC_Observacion,
   		GR.GUIAREMC_Marca AS GUIAREMC_Marca,
   		GR.GUIAREMC_Placa AS GUIAREMC_Placa,
   		GR.GUIAREMC_RegistroMTC AS GUIAREMC_RegistroMTC,
   		GR.GUIAREMC_Certificado AS GUIAREMC_Certificado,
   		GR.GUIAREMC_Licencia AS GUIAREMC_Licencia,
   		GR.GUIAREMC_NombreConductor AS GUIAREMC_NombreConductor,
   		GR.GUIAREMC_subtotal AS GUIAREMC_subtotal,
   		GR.GUIAREMC_descuento AS GUIAREMC_descuento,
   		GR.GUIAREMC_igv AS GUIAREMC_igv,
   		GR.GUIAREMC_total AS GUIAREMC_total,
   		GR.GUIAREMC_igv100 AS GUIAREMC_igv100,
   		GR.GUIAREMC_descuento100 AS GUIAREMC_descuento100,
   		GR.COMPP_Codigo AS COMPP_Codigo,
   		GR.GUIAREMC_FlagMueveStock AS GUIAREMC_FlagMueveStock,
   		GR.USUA_Anula AS USUA_Anula,
   		GR.GUIAREMC_FechaRegistro AS GUIAREMC_FechaRegistro,
   		GR.GUIAREMC_FechaModificacion AS GUIAREMC_FechaModificacion,
   		GR.GUIAREMC_FlagEstado AS GUIAREMC_FlagEstado,
   		GR.CPC_TipoOperacion AS CPC_TipoOperacion,
   		GR.GUIAREMC_NumeroAutomatico AS GUIAREMC_NumeroAutomatico
   	FROM cji_guiarem GR WHERE GR.GUIAREMP_Codigo = CODIGO_GUIAREM;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTAR = TRUE;
		OPEN GUIAREM_CURSOR;
		LOOP1: LOOP
		FETCH GUIAREM_CURSOR INTO 
			GUIAREMP_Codigo,
	   		GUIAREMC_TipoOperacion,
	   		TIPOMOVP_Codigo,
	   		ALMAP_Codigo,
	   		USUA_Codigo ,
	   		MONED_Codigo,
	   		DOCUP_Codigo,
	   		CLIP_Codigo,
	   		PROVP_Codigo,
	   		GUIAREMC_PersReceNombre,
	   		GUIAREMC_PersReceDNI,
	   		EMPRP_Codigo,
	   		GUIASAP_Codigo,
	   		GUIAINP_Codigo,
	   		PRESUP_Codigo,
	   		OCOMP_Codigo,
	   		GUIAREMC_OtroMotivo,
	   		GUIAREMC_Fecha,
	   		GUIAREMC_NumeroRef,
	   		GUIAREMC_OCompra,
	   		GUIAREMC_Serie,
	   		GUIAREMC_Numero,
	   		GUIAREMC_CodigoUsuario,
	   		GUIAREMC_FechaTraslado,
	   		GUIAREMC_PuntoPartida,
	   		GUIAREMC_PuntoLlegada,
	   		GUIAREMC_Observacion,
	   		GUIAREMC_Marca,
	   		GUIAREMC_Placa,
	   		GUIAREMC_RegistroMTC,
	   		GUIAREMC_Certificado,
	   		GUIAREMC_Licencia,
	   		GUIAREMC_NombreConductor,
	   		GUIAREMC_subtotal,
	   		GUIAREMC_descuento,
	   		GUIAREMC_igv,
	   		GUIAREMC_total,
	   		GUIAREMC_igv100,
	   		GUIAREMC_descuento100,
	   		COMPP_Codigo,
	   		GUIAREMC_FlagMueveStock,
	   		USUA_Anula,
	   		GUIAREMC_FechaRegistro,
	   		GUIAREMC_FechaModificacion,
	   		GUIAREMC_FlagEstado,
	   		CPC_TipoOperacion,
			GUIAREMC_NumeroAutomatico;

		IF (GUIAREMP_Codigo IS NULL OR GUIAREMP_Codigo=0) THEN
			LEAVE LOOP1;
		END IF;
		
		IF @EJECUTAR THEN
			LEAVE LOOP1;
		END IF;
		SET @FECHAACTUAL=GUIAREMC_Fecha;
		
		IF GUIAREMC_FlagEstado='1' THEN
			SET GUIAREMC_FlagEstado=1;
			SET @DOCUP_Codigo=10;
			
			
			IF TRIM(GUIAREMC_TipoOperacion)='V' THEN 
				
				CALL MANTENIMIENTO_GUIASA(GUIASAP_Codigo,NULL,NULL,NULL,USUA_Codigo,NULL,NULL,NULL,@FECHAACTUAL,NULL,GUIAREMC_Observacion,CONCAT(GUIAREMC_Marca," ",GUIAREMC_Placa),GUIAREMC_Certificado,
	   			GUIAREMC_Licencia,NULL,GUIAREMC_NombreConductor,NULL,NULL,1,1,1,NULL,NULL,NULL);
				

			ELSE
				
				CALL MANTENIMIENTO_GUIAIN(GUIAINP_Codigo,TIPOMOVP_Codigo,ALMAP_Codigo,USUA_Codigo,NULL,OCOMP_Codigo,NULL,GUIAREMC_NumeroRef,NULL,@FECHAACTUAL,'',GUIAREMC_Observacion,CONCAT(GUIAREMC_Marca," ",GUIAREMC_Placa),GUIAREMC_Certificado,GUIAREMC_Licencia,'',GUIAREMC_NombreConductor,CURDATE(),NULL,1,1,1,NULL,NULL,NULL);


			END IF;
			CALL MANTENIMIENTO_GUIAREM(GUIAREMP_Codigo,NULL,TIPOMOVP_Codigo,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,GUIAREMC_FlagEstado,NULL,1,NULL,NULL,NULL,NULL,NULL);
			SET @FECHAGUIASADETC=NULL;
			IF TRIM(GUIAREMC_TipoOperacion)='V' THEN
				
				BLOCKELIMINAR:BEGIN
				DECLARE A_GUIASADETP_Codigo INT(11);
				DECLARE A_UNDMED_Codigo INT(11);
				DECLARE A_PRODCTOP_Codigo INT(11);
				DECLARE A_GUIASADETC_Cantidad VARCHAR(45);
				DECLARE A_GUIASADETC_Costo VARCHAR(45);
				DECLARE A_GUIASADETC_GenInd CHAR(1);
				DECLARE A_GUIASADETC_FechaRegistro DATETIME;
				DECLARE GUIASADETALLE_CURSOR CURSOR FOR SELECT 
				GSD.GUIASADETP_Codigo,	GSD.UNDMED_Codigo,	GSD.PRODCTOP_Codigo,GSD.GUIASADETC_Cantidad,		GSD.GUIASADETC_Costo, GSD.GUIASADETC_GenInd,GSD.GUIASADETC_FechaRegistro	FROM cji_guiasadetalle GSD WHERE GSD.GUIASAP_Codigo=GUIASAP_Codigo AND GSD.GUIASADETC_FlagEstado=1;
				DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTARGDE = TRUE;
					OPEN GUIASADETALLE_CURSOR;
					LOOPGD: LOOP
					FETCH GUIASADETALLE_CURSOR INTO A_GUIASADETP_Codigo,A_UNDMED_Codigo,	A_PRODCTOP_Codigo,A_GUIASADETC_Cantidad,A_GUIASADETC_Costo,A_GUIASADETC_GenInd,A_GUIASADETC_FechaRegistro;

					IF @EJECUTARGDE THEN
						LEAVE LOOPGD;
					END IF;
					SET @FECHAGUIASADETC=A_GUIASADETC_FechaRegistro;
					CALL MANTENIMIENTO_GUIASADETALLE(A_GUIASADETP_Codigo,NULL,NULL,NULL ,NULL,NULL,NULL,NULL,NULL,NULL,0,2,NULL,NULL,NULL,NULL);
					
					

					
					SET @PRODUNIC_flagPrincipal='';
					SET @PRODUNIC_Factor='';
					SELECT CPU.PRODUNIC_flagPrincipal,CPU.PRODUNIC_Factor INTO @PRODUNIC_flagPrincipal,@PRODUNIC_Factor
					FROM cji_productounidad CPU WHERE  CPU.PROD_Codigo=A_PRODCTOP_Codigo AND  CPU.UNDMED_Codigo=A_UNDMED_Codigo AND CPU.PRODUNIC_flagEstado=1;
					
					IF @PRODUNIC_flagPrincipal=0 THEN
						IF @PRODUNIC_Factor>0 THEN 
							SET A_GUIASADETC_Cantidad=A_GUIASADETC_Cantidad/@PRODUNIC_Factor;
							SET @ISDOUBLE=LOCATE('.',A_GUIASADETC_Cantidad);
							IF @ISDOUBLE<>0 THEN 
								SET A_GUIASADETC_Cantidad=ROUND(A_GUIASADETC_Cantidad, 3);
							END IF;
						END IF;
					END IF;
					
					SET @ALMPROD_Codigo=0;
					SET @ALMPROD_Stock='';
					SET @ALMPROD_CostoPromedio='';
					SET @CANTIDADTOTAL=0;
					SET @COSTOPROMEDIO=0;
					SELECT CAP.ALMPROD_Codigo,CAP.ALMPROD_Stock, CAP.ALMPROD_CostoPromedio INTO @ALMPROD_Codigo,@ALMPROD_Stock, @ALMPROD_CostoPromedio
					FROM cji_almacenproducto CAP WHERE CAP.ALMAC_Codigo=ALMAP_Codigo AND CAP.PROD_Codigo=A_PRODCTOP_Codigo ORDER BY CAP.ALMPROD_Codigo DESC LIMIT 1;
					IF @ALMPROD_Codigo IS NOT NULL THEN
						IF A_GUIASADETC_Cantidad<>@ALMPROD_Stock THEN 
							SET @CANTIDADTOTAL=@ALMPROD_Stock+A_GUIASADETC_Cantidad; 
							SET @COSTOPROMEDIO=((@ALMPROD_Stock*@ALMPROD_CostoPromedio)+(A_GUIASADETC_Cantidad*A_GUIASADETC_Costo))/@CANTIDADTOTAL;
						END IF;
					END IF;

					CALL MANTENIMIENTO_ALMACENPRODUCTO(@ALMPROD_Codigo,ALMAP_Codigo,A_PRODCTOP_Codigo,NULL,@CANTIDADTOTAL,@COSTOPROMEDIO,NOW(),'',1,NULL,NULL,NULL);
					SET @PRODUCTOSTOCKINICIAL=(SELECT CP.PROD_Stock FROM cji_producto CP WHERE CP.PROD_Codigo=A_PRODCTOP_Codigo);

					CALL MANTENIMIENTO_PRODUCTO(A_PRODCTOP_Codigo, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, (@PRODUCTOSTOCKINICIAL+A_GUIASADETC_Cantidad), NULL, NULL, NULL, NULL, NULL, NULL, A_GUIASADETC_Costo, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL);
					
					SET @ISINVETARIADO=0;
					SET @ISINVETARIADO=(SELECT CIND.INVD_Codigo FROM cji_inventariodetalle CIND WHERE CIND.PROD_Codigo=A_PRODCTOP_Codigo  AND CIND.INVD_FlagActivacion='1' ORDER BY CIND.INVD_Codigo DESC LIMIT 1 );
					
					IF (@ISINVETARIADO IS NOT NULL AND @ISINVETARIADO<>0) THEN 
						SET @TIPOVALORIZACION=(SELECT COMP.COMPC_TipoValorizacion FROM cji_compania COMP WHERE COMP.COMPP_Codigo=COMPP_Codigo);
						IF @TIPOVALORIZACION=0 THEN
							SET @COUNTAPL =(SELECT COUNT(*) FROM cji_almaprolote APL WHERE APL.COMPP_Codigo=COMPP_Codigo AND APL.ALMPROD_Codigo=@ALMPROD_Codigo ORDER BY APL.ALMALOTP_Codigo);


							BLOCK2K:BEGIN
								DECLARE INDICE INT(11) DEFAULT 0;
								DECLARE CANTIDADTOTAL DOUBLE(10,2) DEFAULT 0;
								DECLARE HECHO INT(1) DEFAULT 0;
								DECLARE ALMALOTP_Codigo INT(11);
								DECLARE LOTP_Codigo INT(11);
								DECLARE ALMALOTC_Cantidad DOUBLE(10,2);
								DECLARE ALMALOTC_Costo DOUBLE(10,2);
								DECLARE ALMACENPROLOTE_CURSOR CURSOR FOR SELECT APL.ALMALOTP_Codigo,APL.LOTP_Codigo,APL.ALMALOTC_Cantidad,APL.ALMALOTC_Costo
								FROM cji_almaprolote APL WHERE APL.COMPP_Codigo=COMPP_Codigo AND APL.ALMPROD_Codigo=@ALMPROD_Codigo ORDER BY APL.ALMALOTP_Codigo;
								DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTAR2K = TRUE;
								OPEN ALMACENPROLOTE_CURSOR;
								LOOP21K: LOOP
								FETCH ALMACENPROLOTE_CURSOR INTO ALMALOTP_Codigo,LOTP_Codigo,ALMALOTC_Cantidad,ALMALOTC_Costo;
								
								

								IF @EJECUTAR2K THEN
									LEAVE LOOP21K;
								END IF;
								SET INDICE=INDICE+1;
							
								
								IF A_GUIASADETC_Cantidad >= ALMALOTC_Cantidad  THEN 
									SET @TOTALROWS=@COUNTAPL;
									IF @TOTALROWS=INDICE THEN
										SET CANTIDADTOTAL=A_GUIASADETC_Cantidad;
										SET HECHO=1;
									ELSE
										SET CANTIDADTOTAL=ALMALOTC_Cantidad;
										SET A_GUIASADETC_Cantidad=A_GUIASADETC_Cantidad+ALMALOTC_Cantidad;
										SET HECHO=0;
									END IF;
								ELSE 
									SET CANTIDADTOTAL=A_GUIASADETC_Cantidad;
									SET HECHO=1;
								END IF;
								
								SET @ALMALOTC_Cantidad=0;
								SET @ALMALOTP_Codigo=0;
								SELECT APL.ALMALOTP_Codigo,APL.ALMALOTC_Cantidad INTO @ALMALOTP_Codigo,@ALMALOTC_Cantidad
								FROM cji_almaprolote APL WHERE APL.ALMPROD_Codigo=@ALMPROD_Codigo AND APL.COMPP_Codigo=COMPP_Codigo AND APL.LOTP_Codigo=LOTP_Codigo LIMIT 0,1;
									
								SET @ALMALOTC_Cantidad=@ALMALOTC_Cantidad+CANTIDADTOTAL;
								CALL MANTENIMIENTO_ALMACENLOTE(@ALMALOTP_Codigo,NULL,NULL,NULL,@ALMALOTC_Cantidad,NULL,'',NULL,1,NULL,NULL,NULL);
								

								END LOOP LOOP21K;
								CLOSE ALMACENPROLOTE_CURSOR;
							END BLOCK2K;				
						END IF;
					END IF;
					END LOOP LOOPGD;
					CLOSE GUIASADETALLE_CURSOR;
				END BLOCKELIMINAR;	
				SET FECHAKARDEXANTERIOR=(SELECT KD.KARD_Fecha FROM cji_kardex KD WHERE KD.KARDC_TipoIngreso='2' AND KD.KARDC_CodigoDoc=GUIASAP_Codigo LIMIT 1);
				IF (FECHAKARDEXANTERIOR IS NULL OR FECHAKARDEXANTERIOR='0000-00-00 00:00:00') THEN
						SET FECHAKARDEXANTERIOR=@FECHAGUIASADETC;
				END IF;
				DELETE FROM cji_kardex  WHERE KARDC_TipoIngreso='2' AND KARDC_CodigoDoc=GUIASAP_Codigo;
				
				DELETE AMPROSER FROM cji_seriemov AMPROSER WHERE AMPROSER.GUIASAP_Codigo=GUIASAP_Codigo;
			END IF;
			
			SET @FECHAGUIAINDETC=NULL;		
			IF TRIM(GUIAREMC_TipoOperacion)='C' THEN
				
				BLOCKELIMINARGID:BEGIN
				DECLARE A_GUIAINDETP_Codigo INT(11);
				DECLARE A_UNDMED_Codigo INT(11);
				DECLARE A_PRODCTOP_Codigo INT(11);
				DECLARE A_GUIAINDETC_Cantidad VARCHAR(45);
				DECLARE A_GUIAINDETC_Costo VARCHAR(45);
				DECLARE A_GUIIAINDETC_GenInd CHAR(1);
				DECLARE A_GUIAINDETC_FechaRegistro DATETIME;
				DECLARE GUIAINDETALLE_CURSOR CURSOR FOR SELECT 
				GSD.GUIAINDETP_Codigo,	GSD.UNDMED_Codigo,	GSD.PRODCTOP_Codigo,GSD.GUIAINDETC_Cantidad,GSD.GUIIAINDETC_GenInd, GSD.GUIIAINDETC_GenInd, GSD.GUIAINDETC_FechaRegistro	FROM cji_guiaindetalle GSD WHERE GSD.GUIAINP_Codigo=GUIAINP_Codigo AND GSD.GUIAINDETC_FlagEstado=1;
				DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTARGINDE = TRUE;
				OPEN GUIAINDETALLE_CURSOR;
					LOOPGIND: LOOP
					FETCH GUIAINDETALLE_CURSOR INTO A_GUIAINDETP_Codigo,A_UNDMED_Codigo,A_PRODCTOP_Codigo,A_GUIAINDETC_Cantidad,A_GUIAINDETC_Costo,A_GUIIAINDETC_GenInd,A_GUIAINDETC_FechaRegistro;

					IF @EJECUTARGINDE THEN
						LEAVE LOOPGIND;
					END IF;
					SET @FECHAGUIAINDETC=A_GUIAINDETC_FechaRegistro;
					CALL MANTENIMIENTO_GUIAINDETALLE(A_GUIAINDETP_Codigo,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,2,NULL,NULL,NULL,NULL);
					
					SET @COSTOPRODUCTO=A_GUIAINDETC_Costo;
					IF  MONED_Codigo IS NOT NULL && MONED_Codigo<>1 THEN
						SET @FACTORCONVERSION=(SELECT TC.TIPCAMC_FactorConversion FROM cji_tipocambio TC WHERE TC.TIPCAMC_Fecha=GUIAREMC_Fecha AND TC.COMPP_Codigo=COMPP_Codigo); 
						IF (@FACTORCONVERSION<>NULL AND  @FACTORCONVERSION<>0) THEN
							SET @COSTOPRODUCTO=A_GUIAINDETC_Costo*@FACTORCONVERSION;
						END IF;	
					END IF;
					
					SET @PRODUNIC_flagPrincipal='';
					SET @PRODUNIC_Factor='';
					SELECT CPU.PRODUNIC_flagPrincipal,CPU.PRODUNIC_Factor INTO @PRODUNIC_flagPrincipal,@PRODUNIC_Factor
					FROM cji_productounidad CPU WHERE  CPU.PROD_Codigo=A_PRODCTOP_Codigo AND  CPU.UNDMED_Codigo=A_UNDMED_Codigo AND CPU.PRODUNIC_flagEstado=1;
					IF @PRODUNIC_flagPrincipal=0 THEN
						IF @PRODUNIC_Factor>0 THEN 
							SET A_GUIAINDETC_Cantidad=A_GUIAINDETC_Cantidad/@PRODUNIC_Factor;
							SET @ISDOUBLE=LOCATE('.',A_GUIAINDETC_Cantidad);
							IF @ISDOUBLE<>0 THEN 
								SET A_GUIAINDETC_Cantidad=ROUND(A_GUIAINDETC_Cantidad, 3);
							END IF;
						END IF;
					END IF;

					SET @ALMPROD_Codigo=0;
					SET @ALMPROD_Stock='';
					SET @ALMPROD_CostoPromedio='';
					SET @CANTIDADTOTAL=0;
					SET @COSTOPROMEDIO=0;
					SELECT CAP.ALMPROD_Codigo,CAP.ALMPROD_Stock, CAP.ALMPROD_CostoPromedio INTO @ALMPROD_Codigo,@ALMPROD_Stock, @ALMPROD_CostoPromedio
					FROM cji_almacenproducto CAP WHERE CAP.ALMAC_Codigo=ALMAP_Codigo AND CAP.PROD_Codigo=A_PRODCTOP_Codigo ORDER BY CAP.ALMPROD_Codigo DESC LIMIT 1;
					
					IF @ALMPROD_Codigo IS NOT NULL THEN
						SET @CANTIDADTOTAL=@ALMPROD_Stock-A_GUIAINDETC_Cantidad;
						IF @CANTIDADTOTAL=0 THEN 
							SET @COSTOPROMEDIO=0;
						ELSE						
							SET @COSTOPROMEDIO=((@ALMPROD_Stock*@ALMPROD_CostoPromedio)-(A_GUIAINDETC_Cantidad*A_GUIAINDETC_Costo))/@CANTIDADTOTAL;
						END IF;
						
						CALL MANTENIMIENTO_ALMACENPRODUCTO(@ALMPROD_Codigo,NULL,NULL,NULL,@CANTIDADTOTAL,@COSTOPROMEDIO,NOW(),'',1,NULL,NULL,NULL);
					
						SET @PRODUCTOSTOCKINICIAL=(SELECT CP.PROD_Stock FROM cji_producto CP WHERE CP.PROD_Codigo=A_PRODCTOP_Codigo LIMIT 0,1);
						CALL MANTENIMIENTO_PRODUCTO(A_PRODCTOP_Codigo, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, (@PRODUCTOSTOCKINICIAL-A_GUIAINDETC_Cantidad), NULL, NULL, NULL, NULL, NULL, NULL, @COSTOPRODUCTO, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL);
						
						SET @ISINVETARIADO=0;
						SET @ISINVETARIADO=(SELECT CIND.INVD_Codigo FROM cji_inventariodetalle CIND WHERE CIND.PROD_Codigo=A_PRODCTOP_Codigo  AND CIND.INVD_FlagActivacion='1' ORDER BY CIND.INVD_Codigo DESC LIMIT 1 );
						
						
						IF (@ISINVETARIADO IS NOT NULL AND @ISINVETARIADO<>0) THEN 
							SET @LOTP_Codigo=(SELECT CL.LOTP_Codigo FROM cji_lote CL WHERE CL.GUIAINP_Codigo=GUIAINP_Codigo AND LOTC_FlagEstado=1);				
							CALL MANTENIMIENTO_LOTE(@LOTP_Codigo,NULL,NULL,NULL,NULL,NULL,NULL,0,2,NULL,NULL,NULL);

							SET @ALMALOTC_Cantidad=0;
							SET @ALMALOTP_Codigo=0;

							SELECT APL.ALMALOTC_Cantidad , APL.ALMALOTP_Codigo INTO @ALMALOTC_Cantidad, @ALMALOTP_Codigo FROM cji_almaprolote APL WHERE APL.COMPP_Codigo=COMPP_Codigo AND APL.ALMPROD_Codigo=@ALMPROD_Codigo AND APL.LOTP_Codigo=@LOTP_Codigo LIMIT 0,1;
							

							IF (@ALMALOTP_Codigo IS NOT NULL AND @ALMALOTP_Codigo<>0) THEN
								CALL MANTENIMIENTO_ALMACENLOTE(@ALMALOTP_Codigo,NULL,
								NULL,NULL,(@ALMALOTC_Cantidad+A_GUIAINDETC_Cantidad),@COSTOPRODUCTO,NOW(),1,1,NULL,NULL,NULL
								);
							END IF;
						END IF;
					
					
					END IF;
					END LOOP LOOPGIND;
					CLOSE GUIAINDETALLE_CURSOR;
				END BLOCKELIMINARGID;
				
					SET FECHAKARDEXANTERIOR=(SELECT KD.KARD_Fecha FROM cji_kardex KD WHERE KD.KARDC_TipoIngreso='1' AND KD.KARDC_CodigoDoc=GUIAINP_Codigo LIMIT 1);
					IF (FECHAKARDEXANTERIOR IS NULL OR FECHAKARDEXANTERIOR='0000-00-00 00:00:00') THEN
						SET FECHAKARDEXANTERIOR=@FECHAGUIAINDETC;
					END IF;
					DELETE FROM cji_kardex WHERE KARDC_TipoIngreso='1' AND KARDC_CodigoDoc=GUIAINP_Codigo;
								
					DELETE AMPROSER FROM cji_almacenproductoserie AMPROSER , cji_serie SER , cji_seriedocumento SERDOC  WHERE SER.SERIP_Codigo=AMPROSER.SERIP_Codigo AND SER.SERIP_Codigo=SERDOC.SERIP_Codigo  AND SERDOC.DOCUP_Codigo=@DOCUP_Codigo AND SERDOC.SERDOC_NumeroRef=GUIAREMP_Codigo;
					DELETE AMPROSER FROM cji_seriemov AMPROSER WHERE AMPROSER.GUIAINP_Codigo=GUIAINP_Codigo;
			
					
			END IF;
			

			BLOCK12:BEGIN
				DECLARE D_PROD_Codigo INT(11);
				DECLARE D_UNDMED_Codigo INT(11);
				DECLARE D_CPDEC_Cantidad DOUBLE(10,2);
				DECLARE D_CPDEC_GenInd CHAR(1);
				DECLARE D_CPDEC_Pu_ConIgv DOUBLE(10,2);
				DECLARE D_CPDEC_Descripcion VARCHAR(150);
				DECLARE D_ALMAP_Codigo INT(11);
				DECLARE TOTALREGISTROD INT(11) DEFAULT (SELECT COUNT(*)	FROM cji_guiaremdetalle CCD	WHERE CCD.GUIAREMP_Codigo=CODIGO_GUIAREM);
				DECLARE INDICEPOSICIOND INT(11) DEFAULT  0;
				DECLARE GUIAREMDETALLE_CURSOR cursor for 
				SELECT 
				CCD.PRODCTOP_Codigo AS D_PROD_Codigo,
				CCD.UNDMED_Codigo AS D_UNDMED_Codigo,
				CCD.GUIAREMDETC_Cantidad AS D_CPDEC_Cantidad,
				CCD.GUIAREMDETC_GenInd AS D_CPDEC_GenInd,
				CCD.GUIAREMDETC_Pu_ConIgv AS D_CPDEC_Pu_ConIgv,
				CCD.GUIAREMDETC_Descripcion AS D_CPDEC_Descripcion,
				CCD.ALMAP_Codigo AS D_ALMAP_Codigo
				FROM cji_guiaremdetalle CCD
				WHERE CCD.GUIAREMP_Codigo=CODIGO_GUIAREM;
				DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTARDC1 = TRUE;
				OPEN GUIAREMDETALLE_CURSOR;
				LOOP2: LOOP
				FETCH GUIAREMDETALLE_CURSOR INTO D_PROD_Codigo,D_UNDMED_Codigo,D_CPDEC_Cantidad,D_CPDEC_GenInd,D_CPDEC_Pu_ConIgv,D_CPDEC_Descripcion,D_ALMAP_Codigo;
				
				IF INDICEPOSICIOND=TOTALREGISTROD THEN
					LEAVE LOOP2;
				END IF;

				IF TRIM(GUIAREMC_TipoOperacion)='V' THEN 
					
					CALL MANTENIMIENTO_GUIASADETALLE('',GUIASAP_Codigo,D_PROD_Codigo,D_UNDMED_Codigo ,D_CPDEC_GenInd,D_CPDEC_Cantidad,D_CPDEC_Pu_ConIgv,D_CPDEC_Descripcion,NULL,NULL,1,0,NULL,NULL,NULL,D_ALMAP_Codigo);
					
					SET @PRODUNIC_flagPrincipal='';
					SET @PRODUNIC_Factor='';
					SELECT CPU.PRODUNIC_flagPrincipal,CPU.PRODUNIC_Factor INTO @PRODUNIC_flagPrincipal,@PRODUNIC_Factor
					FROM cji_productounidad CPU WHERE  CPU.PROD_Codigo=D_PROD_Codigo AND  CPU.UNDMED_Codigo=D_UNDMED_Codigo AND CPU.PRODUNIC_flagEstado=1;
					IF @PRODUNIC_flagPrincipal=0 THEN
						IF @PRODUNIC_Factor>0 THEN 
							SET D_CPDEC_Cantidad=D_CPDEC_Cantidad/@PRODUNIC_Factor;
							SET @ISDOUBLE=LOCATE('.',D_CPDEC_Cantidad);
							IF @ISDOUBLE<>0 THEN 
								SET D_CPDEC_Cantidad=ROUND(D_CPDEC_Cantidad, 3);
							END IF;
						END IF;
					END IF;
					
					SET @ALMPROD_Codigo=0;
					SET @ALMPROD_Stock='';

					SET @ALMPROD_CostoPromedio='';
					SET @CANTIDADTOTAL=0;
					SET @COSTOPROMEDIO=0;
					SELECT CAP.ALMPROD_Codigo,CAP.ALMPROD_Stock, CAP.ALMPROD_CostoPromedio INTO @ALMPROD_Codigo,@ALMPROD_Stock, @ALMPROD_CostoPromedio
					FROM cji_almacenproducto CAP WHERE CAP.ALMAC_Codigo=D_ALMAP_Codigo AND CAP.PROD_Codigo=D_PROD_Codigo;
					IF @ALMPROD_Codigo IS NOT NULL THEN
						IF D_CPDEC_Cantidad<>@ALMPROD_Stock THEN 
							SET @CANTIDADTOTAL=@ALMPROD_Stock-D_CPDEC_Cantidad; 
							SET @COSTOPROMEDIO=((@ALMPROD_Stock*@ALMPROD_CostoPromedio)-(D_CPDEC_Cantidad*D_CPDEC_Pu_ConIgv))/@CANTIDADTOTAL;
						END IF;
					END IF;
					
					CALL MANTENIMIENTO_ALMACENPRODUCTO(@ALMPROD_Codigo,D_ALMAP_Codigo,D_PROD_Codigo,COMPP_Codigo,@CANTIDADTOTAL,@COSTOPROMEDIO,NOW(),'',1,NULL,NULL,NULL);
					
					SET @PRODUCTOSTOCKINICIAL=(SELECT CP.PROD_Stock FROM cji_producto CP WHERE CP.PROD_Codigo=D_PROD_Codigo);
					CALL MANTENIMIENTO_PRODUCTO(D_PROD_Codigo, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, (@PRODUCTOSTOCKINICIAL-D_CPDEC_Cantidad), NULL, NULL, NULL, NULL, NULL, NULL, D_CPDEC_Pu_ConIgv, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL);
					
					SET @ISINVETARIADO=0;
					SET @ISINVETARIADO=(SELECT CIND.INVD_Codigo FROM cji_inventariodetalle CIND WHERE CIND.PROD_Codigo=D_PROD_Codigo  AND CIND.INVD_FlagActivacion='1' ORDER BY CIND.INVD_Codigo DESC LIMIT 1 );
					
					IF (@ISINVETARIADO IS NOT NULL AND @ISINVETARIADO<>0) THEN 
						SET @TIPOVALORIZACION=(SELECT COMP.COMPC_TipoValorizacion FROM cji_compania COMP WHERE COMP.COMPP_Codigo=COMPP_Codigo);
						IF @TIPOVALORIZACION=0 THEN
							SET @COUNTAPL =(SELECT COUNT(*) FROM cji_almaprolote APL WHERE APL.COMPP_Codigo=COMPP_Codigo AND APL.ALMPROD_Codigo=@ALMPROD_Codigo ORDER BY APL.ALMALOTP_Codigo);
							
							BLOCK2:BEGIN
								
								DECLARE INDICE INT(11) DEFAULT 0;
								DECLARE CANTIDADTOTAL DOUBLE(10,2) DEFAULT 0;
								DECLARE HECHO INT(1) DEFAULT 0;
								DECLARE ALMALOTP_Codigo INT(11);
								DECLARE LOTP_Codigo INT(11);
								DECLARE ALMALOTC_Cantidad DOUBLE(10,2);
								DECLARE ALMALOTC_Costo DOUBLE(10,2);
								DECLARE ALMACENPROLOTE_CURSOR CURSOR FOR SELECT APL.ALMALOTP_Codigo,APL.LOTP_Codigo,APL.ALMALOTC_Cantidad,APL.ALMALOTC_Costo
								FROM cji_almaprolote APL WHERE APL.COMPP_Codigo=COMPP_Codigo AND APL.ALMPROD_Codigo=@ALMPROD_Codigo ORDER BY APL.ALMALOTP_Codigo;
								DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTAR2 = TRUE;
								OPEN ALMACENPROLOTE_CURSOR;
								LOOP21: LOOP
								FETCH ALMACENPROLOTE_CURSOR INTO ALMALOTP_Codigo,LOTP_Codigo,ALMALOTC_Cantidad,ALMALOTC_Costo;
								
								IF @EJECUTAR2 THEN
									LEAVE LOOP21;
								END IF;
								SET INDICE=INDICE+1;
							
								
								IF D_CPDEC_Cantidad >= ALMALOTC_Cantidad  THEN 
									SET @TOTALROWS=@COUNTAPL;
									IF @TOTALROWS=INDICE THEN
										SET CANTIDADTOTAL=D_CPDEC_Cantidad;
										SET HECHO=1;
									ELSE
										SET CANTIDADTOTAL=ALMALOTC_Cantidad;
										SET D_CPDEC_Cantidad=D_CPDEC_Cantidad-ALMALOTC_Cantidad;
										SET HECHO=0;
									END IF;
								ELSE 
									SET CANTIDADTOTAL=D_CPDEC_Cantidad;
									SET HECHO=1;
								END IF;
								
									SET @ALMALOTC_Cantidad=0;
									SET @ALMALOTP_Codigo=0;
									SELECT APL.ALMALOTP_Codigo,APL.ALMALOTC_Cantidad INTO @ALMALOTP_Codigo,@ALMALOTC_Cantidad
									FROM cji_almaprolote APL WHERE APL.ALMPROD_Codigo=@ALMPROD_Codigo AND APL.COMPP_Codigo=COMPP_Codigo AND APL.LOTP_Codigo=LOTP_Codigo;
									

									SET @ALMALOTC_Cantidad=@ALMALOTC_Cantidad-CANTIDADTOTAL;

									CALL MANTENIMIENTO_ALMACENLOTE(@ALMALOTP_Codigo,NULL,NULL,NULL,@ALMALOTC_Cantidad,NULL,'',NULL,1,NULL,NULL,NULL);

									IF CANTIDADTOTAL<>0 THEN 
										CALL MANTENIMIENTO_KARDEX('',COMPP_Codigo,D_PROD_Codigo,6,1,LOTP_Codigo,GUIASAP_Codigo,'2',FECHAKARDEXANTERIOR,CANTIDADTOTAL,D_CPDEC_Pu_ConIgv,0,NULL,NULL,NULL,@ALMPROD_Codigo,1);					
										
										IF HECHO=1 THEN
											LEAVE LOOP21;
										END IF;
									END IF;
								END LOOP LOOP21;
								CLOSE ALMACENPROLOTE_CURSOR;
							END BLOCK2;				
						END IF;
					END IF;
					
					IF (D_CPDEC_GenInd IS NOT NULL AND D_CPDEC_GenInd='I') THEN 
						
						SET @COUNTASERIESV=(SELECT COUNT(*)
						FROM cji_serie SER  
						INNER JOIN cji_seriedocumento SERDOC ON SERDOC.SERIP_Codigo=SER.SERIP_Codigo
						WHERE  SERDOC.DOCUP_Codigo=@DOCUP_Codigo 
						AND SERDOC.SERDOC_NumeroRef=CODIGO_GUIAREM AND SER.PROD_Codigo=D_PROD_Codigo AND SER.ALMAP_Codigo=D_ALMAP_Codigo);
						
						BLOCKSE1V:BEGIN
							DECLARE INDICESERV INT(11) DEFAULT 0;
							DECLARE SERIP_Codigo INT(11);
							DECLARE SERIC_Numero varchar(50);
							DECLARE SERIESV_CURSOR CURSOR FOR SELECT SER.SERIP_Codigo, SER.SERIC_Numero
							FROM cji_serie SER  
							INNER JOIN cji_seriedocumento SERDOC ON SERDOC.SERIP_Codigo=SER.SERIP_Codigo
							WHERE  SERDOC.DOCUP_Codigo=@DOCUP_Codigo 
							AND SERDOC.SERDOC_NumeroRef=CODIGO_GUIAREM AND SER.PROD_Codigo=D_PROD_Codigo AND SER.ALMAP_Codigo=D_ALMAP_Codigo
							ORDER BY SER.SERIP_Codigo ASC;
							
							DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTARSERIE2V = TRUE;
							OPEN SERIESV_CURSOR;
							LOOPSE21V: LOOP
							FETCH SERIESV_CURSOR INTO SERIP_Codigo,SERIC_Numero;
									
							IF (SERIP_Codigo IS NULL OR SERIP_Codigo=0) THEN
								LEAVE LOOPSE21V;
							END IF;
							
							IF @EJECUTARSERIE2V THEN
								LEAVE LOOPSE21V;
							END IF;
							SET INDICESERV=INDICESERV+1;
							
							
							SET @SERMOVP_Codigo=NULL;
							SET @ALMPRODSERP_Codigo=NULL;
							CALL MANTENIMIENTO_SERIEMOVIMIENTO(@SERMOVP_Codigo,SERIP_Codigo,2,NULL,GUIASAP_Codigo,0);
							CALL MANTENIMIENTO_ALMACENPRODUCTOSERIE(@ALMPRODSERP_Codigo,@ALMPROD_Codigo,SERIP_Codigo,3);
							
							IF @COUNTASERIESV=INDICESERV THEN
								LEAVE LOOPSE21V;
							END IF;
							
							END LOOP LOOPSE21V;
							CLOSE SERIESV_CURSOR;
						END BLOCKSE1V;	
						
					END IF;
					
					
					
				END IF;
					
				IF TRIM(GUIAREMC_TipoOperacion)='C' THEN
					
					CALL MANTENIMIENTO_GUIAINDETALLE('',GUIAINP_Codigo,D_PROD_Codigo,D_UNDMED_Codigo ,D_CPDEC_GenInd,D_CPDEC_Cantidad,D_CPDEC_Pu_ConIgv,D_CPDEC_Descripcion,NULL,NULL,1,0,NULL,NULL,NULL,D_ALMAP_Codigo);
					
					SET @COSTOPRODUCTO=D_CPDEC_Pu_ConIgv;
					IF  MONED_Codigo<>NULL && MONED_Codigo<>1 THEN
						SET @FACTORCONVERSION=(SELECT TC.TIPCAMC_FactorConversion FROM cji_tipocambio TC WHERE TC.TIPCAMC_MonedaOrigen=1 AND TIPCAMC_MonedaDestino=MONED_Codigo AND TC.COMPP_Codigo=COMPP_Codigo AND TIPCAMC_FlagEstado=1 ORDER BY TIPCAMP_Codigo DESC LIMIT 0,1); 
						IF (@FACTORCONVERSION<>NULL AND  @FACTORCONVERSION<>0) THEN
							SET @COSTOPRODUCTO=D_CPDEC_Pu_ConIgv*@FACTORCONVERSION;
						END IF;	
					END IF;
					
					SET @PRODUNIC_flagPrincipal='';
					SET @PRODUNIC_Factor='';
					SELECT CPU.PRODUNIC_flagPrincipal,CPU.PRODUNIC_Factor INTO @PRODUNIC_flagPrincipal,@PRODUNIC_Factor
					FROM cji_productounidad CPU WHERE  CPU.PROD_Codigo=D_PROD_Codigo AND  CPU.UNDMED_Codigo=D_UNDMED_Codigo AND CPU.PRODUNIC_flagEstado=1;
					IF @PRODUNIC_flagPrincipal=0 THEN
						IF @PRODUNIC_Factor>0 THEN 
							SET D_CPDEC_Cantidad=D_CPDEC_Cantidad/@PRODUNIC_Factor;
							SET @ISDOUBLE=LOCATE('.',D_CPDEC_Cantidad);
							IF @ISDOUBLE<>0 THEN 
								SET D_CPDEC_Cantidad=ROUND(D_CPDEC_Cantidad, 3);
							END IF;
						END IF;

					END IF;
					
					SET @ALMPROD_Codigo=0;
					SET @ALMPROD_Stock='';
					SET @ALMPROD_CostoPromedio='';
					SET @CANTIDADTOTAL=0;
					SET @COSTOPROMEDIO=0;
					SELECT CAP.ALMPROD_Codigo,CAP.ALMPROD_Stock, CAP.ALMPROD_CostoPromedio INTO @ALMPROD_Codigo,@ALMPROD_Stock, @ALMPROD_CostoPromedio
					FROM cji_almacenproducto CAP WHERE CAP.ALMAC_Codigo=D_ALMAP_Codigo AND CAP.PROD_Codigo=D_PROD_Codigo;
					IF @ALMPROD_Codigo IS NOT NULL THEN
						SET @CANTIDADTOTAL=@ALMPROD_Stock+D_CPDEC_Cantidad;
						IF @CANTIDADTOTAL=0 THEN 
							SET @COSTOPROMEDIO=0;
						ELSE						
							SET @COSTOPROMEDIO=((@ALMPROD_Stock*@ALMPROD_CostoPromedio)+(D_CPDEC_Cantidad*D_CPDEC_Pu_ConIgv))/@CANTIDADTOTAL;
						END IF;
						
						CALL MANTENIMIENTO_ALMACENPRODUCTO(@ALMPROD_Codigo,D_ALMAP_Codigo,D_PROD_Codigo,COMPP_Codigo,@CANTIDADTOTAL,@COSTOPROMEDIO,NOW(),'',1,NULL,NULL,NULL);
						SET @PRODUCTOSTOCKINICIAL=(SELECT CP.PROD_Stock FROM cji_producto CP WHERE CP.PROD_Codigo=D_PROD_Codigo LIMIT 0,1);
						CALL MANTENIMIENTO_PRODUCTO(D_PROD_Codigo, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, (@PRODUCTOSTOCKINICIAL+D_CPDEC_Cantidad), NULL, NULL, NULL, NULL, NULL, NULL, @COSTOPRODUCTO, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL);
					
						
						SET @ISINVETARIADO=0;
						SET @ISINVETARIADO=(SELECT CIND.INVD_Codigo FROM cji_inventariodetalle CIND WHERE CIND.PROD_Codigo=D_PROD_Codigo  AND CIND.INVD_FlagActivacion='1' ORDER BY CIND.INVD_Codigo DESC LIMIT 1 );
						
						IF (@ISINVETARIADO IS NOT NULL AND @ISINVETARIADO<>0) THEN
							SET @LOTP_Codigo='';				
							CALL MANTENIMIENTO_LOTE(@LOTP_Codigo,D_PROD_Codigo,D_CPDEC_Cantidad,@COSTOPRODUCTO,GUIAINP_Codigo,NOW(),NULL,1,0,NULL,NULL,NULL);
							
							SET @ALMALOTC_Cantidad=0;
							SET @ALMALOTP_Codigo=0;

							SELECT APL.ALMALOTC_Cantidad , APL.ALMALOTP_Codigo INTO @ALMALOTC_Cantidad, @ALMALOTP_Codigo
							FROM cji_almaprolote APL WHERE APL.COMPP_Codigo=COMPP_Codigo AND APL.ALMPROD_Codigo=@ALMPROD_Codigo AND APL.LOTP_Codigo=@LOTP_Codigo LIMIT 0,1;
							
							
							IF (@ALMALOTP_Codigo IS NOT NULL AND @ALMALOTP_Codigo<>0) THEN
								CALL MANTENIMIENTO_ALMACENLOTE(@ALMALOTP_Codigo,NULL,
								NULL,NULL,(@ALMALOTC_Cantidad+D_CPDEC_Cantidad),@COSTOPRODUCTO,NOW(),1,1,NULL,NULL,NULL
								);
							ELSE
								CALL MANTENIMIENTO_ALMACENLOTE(@ALMALOTP_Codigo,@ALMPROD_Codigo,@LOTP_Codigo,COMPP_Codigo,D_CPDEC_Cantidad,@COSTOPRODUCTO,NOW(),1,0,NULL,NULL,NULL);
							END IF;
							
							CALL MANTENIMIENTO_KARDEX('',COMPP_Codigo,D_PROD_Codigo,5,1,@LOTP_Codigo,GUIAINP_Codigo,'1',FECHAKARDEXANTERIOR,D_CPDEC_Cantidad,@COSTOPRODUCTO,0,NULL,NULL,NULL,@ALMPROD_Codigo,1);
							
						END IF;
					ELSE
						SET @CANTIDADTOTAL=D_CPDEC_Cantidad;
						SET @COSTOPROMEDIO=@COSTOPRODUCTO;
						
						CALL MANTENIMIENTO_ALMACENPRODUCTO(@ALMPROD_Codigo,D_ALMAP_Codigo,D_PROD_Codigo,COMPP_Codigo,@CANTIDADTOTAL,@COSTOPROMEDIO,NOW(),'',1,NULL,NULL,NULL);
					END IF;
					
					
					IF (D_CPDEC_GenInd IS NOT NULL AND D_CPDEC_GenInd='I') THEN 
						
						SET @COUNTASERIES=(SELECT COUNT(*)
						FROM cji_serie SER  
						INNER JOIN cji_seriedocumento SERDOC ON SERDOC.SERIP_Codigo=SER.SERIP_Codigo
						WHERE  SERDOC.DOCUP_Codigo=@DOCUP_Codigo 
						AND SERDOC.SERDOC_NumeroRef=CODIGO_GUIAREM AND SER.PROD_Codigo=D_PROD_Codigo AND SER.ALMAP_Codigo=D_ALMAP_Codigo);
										
						BLOCKSE1:BEGIN
							DECLARE INDICESER INT(11) DEFAULT 0;
							DECLARE SERIP_Codigo INT(11);
							DECLARE SERIC_Numero varchar(50)	;
							DECLARE SERIES_CURSOR CURSOR FOR SELECT SER.SERIP_Codigo, SER.SERIC_Numero
							FROM cji_serie SER  
							INNER JOIN cji_seriedocumento SERDOC ON SERDOC.SERIP_Codigo=SER.SERIP_Codigo
							WHERE  SERDOC.DOCUP_Codigo=@DOCUP_Codigo 
							AND SERDOC.SERDOC_NumeroRef=CODIGO_GUIAREM AND SER.PROD_Codigo=D_PROD_Codigo AND SER.ALMAP_Codigo=D_ALMAP_Codigo
							ORDER BY SER.SERIP_Codigo ASC;
							DECLARE CONTINUE HANDLER FOR NOT FOUND SET @EJECUTARSERIE2 = TRUE;
							OPEN SERIES_CURSOR;
							LOOPSE21: LOOP
							FETCH SERIES_CURSOR INTO SERIP_Codigo,SERIC_Numero;
									
							IF (SERIP_Codigo IS NULL OR SERIP_Codigo=0) THEN
								LEAVE LOOPSE21;
							END IF;
							
							IF @EJECUTARSERIE2 THEN
								LEAVE LOOPSE21;
							END IF;
							SET INDICESER=INDICESER+1;
							
							
							SET @SERMOVP_Codigo=NULL;
							SET @ALMPRODSERP_Codigo=NULL;
							CALL MANTENIMIENTO_SERIEMOVIMIENTO(@SERMOVP_Codigo,SERIP_Codigo,1,GUIAINP_Codigo,NULL,0);
							CALL MANTENIMIENTO_ALMACENPRODUCTOSERIE(@ALMPRODSERP_Codigo,@ALMPROD_Codigo,SERIP_Codigo,0);
							
							IF @COUNTASERIES=INDICESER THEN
								LEAVE LOOPSE21;
							END IF;
							
							END LOOP LOOPSE21;
							CLOSE SERIES_CURSOR;
						END BLOCKSE1;	
						
					END IF;
					
					
				END IF;
				SET INDICEPOSICIOND=INDICEPOSICIOND+1;
				END LOOP LOOP2; 
				CLOSE GUIAREMDETALLE_CURSOR;
			END BLOCK12;	

			
		ELSE
			SELECT "ERROR";
		END IF;
	END LOOP LOOP1; 
	CLOSE GUIAREM_CURSOR;
END BLOCK1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MANTENIMIENTO_ALMACENLOTE` (INOUT `ALMALOTP_Codigo` INT(11), IN `ALMPROD_Codigo` INT(11), IN `LOTP_Codigo` INT(11), IN `COMPP_Codigo` INT(11), IN `ALMALOTC_Cantidad` DOUBLE, IN `ALMALOTC_Costo` DOUBLE, IN `ALMALOTC_FechaRegistro` TIMESTAMP, IN `ALMALOTC_FlagEstado` CHAR(1), IN `REALIZACION` INT, IN `USUARIO` INT, IN `FECHAINICIO` DATE, IN `FECHAFIN` DATE)  BEGIN
	IF REALIZACION=0  THEN
		INSERT INTO cji_almaprolote VALUES (
				0,
				ALMPROD_Codigo,
				LOTP_Codigo,
				COMPP_Codigo,
				ALMALOTC_Cantidad,
				ALMALOTC_Costo,
				NOW(),
				ALMALOTC_FlagEstado
		 );
		SET ALMALOTP_Codigo=last_insert_id();
	ELSEIF REALIZACION=1 THEN
		IF (ALMALOTP_Codigo IS NULL OR ALMALOTP_Codigo=0 ) THEN
        	SELECT "INGRESAR ALMALOTP_Codigo";
        ELSE	
            SET @SQLREALIZAR="UPDATE cji_almaprolote gs SET ";
            
			IF (ALMPROD_Codigo IS NULL OR ALMPROD_Codigo=0 ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.ALMPROD_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,ALMPROD_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (LOTP_Codigo IS NULL OR LOTP_Codigo=0 ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.LOTP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,LOTP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;

			IF (COMPP_Codigo IS NULL OR COMPP_Codigo=0 ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.COMPP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,COMPP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;

			IF (ALMALOTC_Cantidad IS NULL) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.ALMALOTC_Cantidad=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,ALMALOTC_Cantidad);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (ALMALOTC_Costo IS NULL) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.ALMALOTC_Costo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,ALMALOTC_Costo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (ALMALOTC_FlagEstado IS NULL OR TRIM(ALMALOTC_FlagEstado)="") THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.ALMALOTC_FlagEstado='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,ALMALOTC_FlagEstado);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
			
            SET @SQLREALIZAR=SUBSTRING(@SQLREALIZAR,1,CHARACTER_LENGTH(@SQLREALIZAR)-1);
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.ALMALOTP_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,ALMALOTP_Codigo);
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;
	ELSEIF REALIZACION=2 THEN
	
		IF (ALMALOTP_Codigo IS NULL OR ALMALOTP_Codigo=0 ) THEN
        	SELECT "INGRESAR ALMALOTP_Codigo";
        ELSE
            SET @SQLREALIZAR="UPDATE cji_almaprolote gs SET ";
            IF (ALMALOTC_FlagEstado IS NULL OR TRIM(ALMALOTC_FlagEstado)='')  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.ALMALOTC_FlagEstado='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(ALMALOTC_FlagEstado));
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
			
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.ALMALOTP_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,ALMALOTP_Codigo);
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;
		
	ELSEIF REALIZACION=3 THEN
		IF (ALMALOTP_Codigo IS NULL OR ALMALOTP_Codigo=0 ) THEN
        	SELECT "INGRESAR ALMALOTP_Codigo";
        ELSE	
			SELECT
					gs.ALMALOTP_Codigo AS ALMALOTP_Codigo,
					gs.ALMPROD_Codigo AS ALMPROD_Codigo,
					gs.LOTP_Codigo AS LOTP_Codigo,
					gs.COMPP_Codigo AS COMPP_Codigo,
					gs.ALMALOTC_Cantidad AS ALMALOTC_Cantidad,
					gs.ALMALOTC_Costo AS ALMALOTC_Costo,
					gs.ALMALOTC_FechaRegistro AS ALMALOTC_FechaRegistro,
					gs.ALMALOTC_FlagEstado AS ALMALOTC_FlagEstado
			FROM cji_almaprolote gs
			WHERE gs.ALMALOTP_Codigo=ALMALOTP_Codigo;
		END IF;
	ELSEIF REALIZACION=4 THEN
			SET @SQLREALIZAR="SELECT\r\n\t\t\t\t\tgs.ALMALOTP_Codigo AS ALMALOTP_Codigo,\r\n\t\t\t\t\tgs.ALMPROD_Codigo AS ALMPROD_Codigo,\r\n\t\t\t\t\tgs.LOTP_Codigo AS LOTP_Codigo,\r\n\t\t\t\t\tgs.COMPP_Codigo AS COMPP_Codigo,\r\n\t\t\t\t\tgs.ALMALOTC_Cantidad AS ALMALOTC_Cantidad,\r\n\t\t\t\t\tgs.ALMALOTC_Costo AS ALMALOTC_Costo,\r\n\t\t\t\t\tgs.ALMALOTC_FechaRegistro AS ALMALOTC_FechaRegistro,\r\n\t\t\t\t\tgs.ALMALOTC_FlagEstado AS ALMALOTC_FlagEstado\r\n\t\t\tFROM cji_almaprolote gs WHERE gs.ALMALOTC_FlagEstado!=0";
			
			IF (ALMPROD_Codigo IS NULL OR ALMPROD_Codigo=0 ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.ALMPROD_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,ALMPROD_Codigo);
            END IF;
			
			IF (LOTP_Codigo IS NULL OR LOTP_Codigo=0 ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.LOTP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,LOTP_Codigo);
            END IF;

			IF (COMPP_Codigo IS NULL OR COMPP_Codigo=0 ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.COMPP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,COMPP_Codigo);
            END IF;


			SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," ORDER BY gs.ALMALOTP_Codigo ASC;");
			
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MANTENIMIENTO_ALMACENPRODUCTO` (INOUT `ALMPROD_Codigo` INT(11), IN `ALMAC_Codigo` INT(11), IN `PROD_Codigo` INT(11), IN `COMPP_Codigo` INT(11), IN `ALMPROD_Stock` DOUBLE, IN `ALMPROD_CostoPromedio` DOUBLE, IN `ALMPROD_FechaRegistro` TIMESTAMP, IN `ALMPROD_FechaModificacion` DATETIME, IN `REALIZACION` INT, IN `USUARIO` INT, IN `FECHAINICIO` DATE, IN `FECHAFIN` DATE)  BEGIN
	IF REALIZACION=0  THEN
		INSERT INTO cji_almacenproducto VALUES (
				0,
				ALMAC_Codigo,
				PROD_Codigo,
				COMPP_Codigo,
				ALMPROD_Stock,
				ALMPROD_CostoPromedio,
				NOW(),
				ALMPROD_FechaModificacion
		 );
		SET ALMPROD_Codigo=last_insert_id();
	ELSEIF REALIZACION=1 THEN
		IF (ALMPROD_Codigo IS NULL OR ALMPROD_Codigo=0 ) THEN
        	SELECT "INGRESAR ALMPROD_Codigo";
        ELSE	
            SET @SQLREALIZAR="UPDATE cji_almacenproducto gs SET ";
            
			IF (ALMAC_Codigo IS NULL OR ALMAC_Codigo=0 ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.ALMAC_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,ALMAC_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (PROD_Codigo IS NULL OR PROD_Codigo=0 ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (COMPP_Codigo IS NULL OR COMPP_Codigo=0 ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE

				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.COMPP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,COMPP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (ALMPROD_Stock IS NULL) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.ALMPROD_Stock=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,ALMPROD_Stock);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
			IF (ALMPROD_CostoPromedio IS NULL) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.ALMPROD_CostoPromedio=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,ALMPROD_CostoPromedio);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;

			
			SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.ALMPROD_FechaModificacion='");
			SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,ALMPROD_FechaModificacion);
			SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            SET @SQLREALIZAR=SUBSTRING(@SQLREALIZAR,1,CHARACTER_LENGTH(@SQLREALIZAR)-1);
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.ALMPROD_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,ALMPROD_Codigo);
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;
	ELSEIF REALIZACION=2 THEN
			SELECT "FALTA IMPLEMENTAR";
	ELSEIF REALIZACION=3 THEN
		IF (ALMPROD_Codigo IS NULL OR ALMPROD_Codigo=0 ) THEN
        	SELECT "INGRESAR ALMPROD_Codigo";
        ELSE	
			SELECT
				gs.ALMPROD_Codigo AS ALMPROD_Codigo,
				gs.ALMAC_Codigo AS ALMAC_Codigo,
				gs.PROD_Codigo AS PROD_Codigo,
				gs.COMPP_Codigo AS COMPP_Codigo,
				gs.ALMPROD_Stock AS ALMPROD_Stock,
				gs.ALMPROD_CostoPromedio AS ALMPROD_CostoPromedio,
				gs.ALMPROD_FechaRegistro AS ALMPROD_FechaRegistro,
				gs.ALMPROD_FechaModificacion AS ALMPROD_FechaModificacion
			FROM cji_almacenproducto gs
			WHERE gs.ALMPROD_Codigo=ALMPROD_Codigo;
		END IF;
	ELSEIF REALIZACION=4 THEN
			SET @SQLREALIZAR="SELECT\r\n\t\t\t\tgs.ALMPROD_Codigo AS ALMPROD_Codigo,\r\n\t\t\t\tgs.ALMAC_Codigo AS ALMAC_Codigo,\r\n\t\t\t\tgs.PROD_Codigo AS PROD_Codigo,\r\n\t\t\t\tgs.COMPP_Codigo AS COMPP_Codigo,\r\n\t\t\t\tgs.ALMPROD_Stock AS ALMPROD_Stock,\r\n\t\t\t\tgs.ALMPROD_CostoPromedio AS ALMPROD_CostoPromedio,\r\n\t\t\t\tgs.ALMPROD_FechaRegistro AS ALMPROD_FechaRegistro,\r\n\t\t\t\tgs.ALMPROD_FechaModificacion AS ALMPROD_FechaModificacion\r\n\t\t\tFROM cji_almacenproducto gs WHERE";
			
			IF (ALMPROD_Codigo IS NULL OR ALMPROD_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.ALMPROD_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,ALMPROD_Codigo);
            END IF;
			
			IF (ALMAC_Codigo IS NULL OR ALMAC_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.ALMAC_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,ALMAC_Codigo);
            END IF;
			
			IF (PROD_Codigo IS NULL OR PROD_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_Codigo);
            END IF;
			
			IF (COMPP_Codigo IS NULL OR COMPP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.COMPP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,COMPP_Codigo);
            END IF;
			
			
			
			IF (FECHAINICIO IS NULL OR TRIM(FECHAINICIO)='0000-00-00' )   THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.ALMPROD_FechaRegistro>='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAINICIO);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
            IF (FECHAFIN IS NULL OR TRIM(FECHAFIN)='0000-00-00')  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.ALMPROD_FechaRegistro<='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAFIN);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
			SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," ORDER BY gs.ALMPROD_Codigo ASC;");
			
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
	
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MANTENIMIENTO_ALMACENPRODUCTOSERIE` (INOUT `ALMPRODSERP_Codigo` INT(11), IN `ALMPROD_Codigo` INT(11), IN `SERIP_Codigo` INT(11), IN `REALIZACION` INT(11))  BLOCK1:
BEGIN
	IF REALIZACION=0  THEN
		INSERT INTO cji_almacenproductoserie VALUES (
				  0,
				  ALMPROD_Codigo,
				  SERIP_Codigo,
				  NOW(),
				  0,
				  '',
				  1
		 );
		SET ALMPRODSERP_Codigo=last_insert_id();
	ELSEIF REALIZACION=1 THEN
		SELECT "IMPLEMENTAR";
	ELSEIF REALIZACION=2 THEN
		SELECT "IMPLEMENTAR";
		
	ELSEIF REALIZACION=3 THEN
		IF (SERIP_Codigo IS NOT NULL AND SERIP_Codigo<>0) THEN 
			UPDATE cji_almacenproductoserie ALPS 
			SET ALPS.ALMPRODSERC_FlagEstado=2
			WHERE ALPS.SERIP_Codigo=SERIP_Codigo
			AND ALPS.ALMPRODSERC_FlagEstado=1;
		END IF;
	END IF;
END BLOCK1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MANTENIMIENTO_COMPROBANTE` (IN `CPP_Codigo` INT(11), IN `CPC_TipoOperacion` CHAR(1), IN `CPC_TipoDocumento` CHAR(1), IN `PRESUP_Codigo` INT(11), IN `OCOMP_Codigo` INT(11), IN `COMPP_Codigo` INT(11), IN `CPC_Serie` CHAR(4), IN `CPC_Numero` VARCHAR(11), IN `CLIP_Codigo` INT(11), IN `PROVP_Codigo` INT(11), IN `CPC_NombreAuxiliar` VARCHAR(25), IN `USUA_Codigo` INT(11), IN `MONED_Codigo` INT(11), IN `FORPAP_Codigo` INT(11), IN `CPC_subtotal` DOUBLE(10,2), IN `CPC_descuento` DOUBLE(10,2), IN `CPC_igv` DOUBLE(10,2), IN `CPC_total` DOUBLE(10,2), IN `CPC_subtotal_conigv` DOUBLE(10,2), IN `CPC_descuento_conigv` DOUBLE(10,2), IN `CPC_igv100` INT(11), IN `CPC_descuento100` INT(11), IN `GUIAREMP_Codigo` INT(11), IN `CPC_GuiaRemCodigo` VARCHAR(50), IN `CPC_DocuRefeCodigo` VARCHAR(50), IN `CPC_Observacion` TEXT, IN `CPC_ModoImpresion` CHAR(1), IN `CPC_Fecha` DATE, IN `CPC_Vendedor` INT(11), IN `CPC_TDC` DOUBLE(10,2), IN `CPC_FlagMueveStock` CHAR(1), IN `GUIASAP_Codigo` INT(11), IN `GUIAINP_Codigo` INT(11), IN `USUA_anula` INT(11), IN `CPC_FechaRegistro` TIMESTAMP, IN `CPC_FechaModificacion` DATETIME, IN `CPC_FlagEstado` CHAR(1), IN `CPC_Hora` TIME, IN `ALMAP_Codigo` INT(11), IN `CPP_Codigo_Canje` INT(11), IN `REALIZACION` INT, IN `USUARIO` INT, IN `FECHAINICIO` DATE, IN `FECHAFIN` DATE, IN `CPC_NumeroAutomatico` INT)  BEGIN
  IF REALIZACION=0 THEN
  INSERT INTO cji_comprobante VALUES (
		  0,
	      CPC_TipoOperacion,
		  CPC_TipoDocumento,
		  PRESUP_Codigo,
	      OCOMP_Codigo,
		  COMPP_Codigo,
		  CPC_Serie,
		  CPC_Numero,
		  CLIP_Codigo,
		  PROVP_Codigo,
		  CPC_NombreAuxiliar,
		  USUA_Codigo,
		  MONED_Codigo,
		  FORPAP_Codigo,
		  CPC_subtotal,
		  CPC_descuento,
		  CPC_igv,
		  CPC_total,
		  CPC_subtotal_conigv,
		  CPC_descuento_conigv,
		  CPC_igv100,
		  CPC_descuento100,
		  GUIAREMP_Codigo,
		  CPC_GuiaRemCodigo,
		  CPC_DocuRefeCodigo,
		  CPC_Observacion,
		  CPC_ModoImpresion,
		  CPC_Fecha,
		  CPC_Vendedor,
		  CPC_TDC,
		  CPC_FlagMueveStock,
		  GUIASAP_Codigo,
		  GUIAINP_Codigo,
		  USUA_anula,
		  CURDATE(),
		  CPC_FechaModificacion,
		  CPC_FlagEstado,
		  CPC_Hora,
		  ALMAP_Codigo,
		  CPP_Codigo_Canje,
		  CPC_NumeroAutomatico
		  );
  
  
	
	ELSEIF REALIZACION=1 THEN
		IF (CPP_Codigo IS NULL OR CPP_Codigo=0 ) THEN
        	SELECT "INGRESAR CPP_Codigo";
        ELSE	
			SET @SQLREALIZAR="UPDATE cji_comprobante gs SET ";
		
			IF (CPC_TipoOperacion IS NULL OR TRIM(CPC_TipoOperacion)="")  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_TipoOperacion='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(CPC_TipoOperacion));
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
			
			IF (CPC_TipoDocumento IS NULL OR TRIM(CPC_TipoDocumento)="")  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_TipoDocumento='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(CPC_TipoDocumento));
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
			
			IF (PRESUP_Codigo IS NULL OR PRESUP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PRESUP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PRESUP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
		
			IF (OCOMP_Codigo IS NULL OR OCOMP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.OCOMP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,OCOMP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
		
			IF (COMPP_Codigo IS NULL OR COMPP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.COMPP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,COMPP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
		
			IF (CPC_Serie IS NULL OR TRIM(CPC_Serie)="")  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_Serie='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(CPC_Serie));
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
		
			IF (CPC_Numero IS NULL OR TRIM(CPC_Numero)="")  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_Numero='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(CPC_Numero));
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
			
			IF (CLIP_Codigo IS NULL OR CLIP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CLIP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CLIP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (PROVP_Codigo IS NULL OR PROVP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROVP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROVP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (CPC_NombreAuxiliar IS NULL OR TRIM(CPC_NombreAuxiliar)="")  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_NombreAuxiliar='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(CPC_NombreAuxiliar));
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
			
			IF (USUA_Codigo IS NULL OR USUA_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.USUA_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,USUA_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (MONED_Codigo IS NULL OR MONED_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.MONED_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,MONED_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (FORPAP_Codigo IS NULL OR FORPAP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.FORPAP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FORPAP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (CPC_subtotal IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_subtotal=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_subtotal);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (CPC_descuento IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_descuento=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_descuento);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (CPC_igv IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_igv=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_igv);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (CPC_total IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_total=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_total);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (CPC_subtotal_conigv IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_subtotal_conigv=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_subtotal_conigv);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (CPC_descuento_conigv IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_descuento_conigv=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_descuento_conigv);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (CPC_igv100 IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_igv100=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_igv100);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (CPC_descuento100 IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_descuento100=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_descuento100);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;

			IF (GUIAREMP_Codigo IS NULL OR GUIAREMP_Codigo=0 )  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;

			IF (CPC_GuiaRemCodigo IS NULL OR TRIM(CPC_GuiaRemCodigo)="" )  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_GuiaRemCodigo='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_GuiaRemCodigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
			
			IF (CPC_DocuRefeCodigo IS NULL OR TRIM(CPC_DocuRefeCodigo)="" )  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_DocuRefeCodigo='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_DocuRefeCodigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
			
			IF (CPC_Observacion IS NULL OR TRIM(CPC_Observacion)="" )  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_Observacion='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_Observacion);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
			
			IF (CPC_ModoImpresion IS NULL OR TRIM(CPC_ModoImpresion)="" )  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_ModoImpresion='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_ModoImpresion);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
			
			IF (CPC_Fecha IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_Fecha='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_Fecha);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;

			IF (CPC_Vendedor IS NULL OR CPC_Vendedor=0 )  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_Vendedor=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_Vendedor);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (CPC_TDC IS NULL OR CPC_TDC=0 )  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_TDC=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_TDC);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;

			IF (CPC_FlagMueveStock IS NULL OR TRIM(CPC_FlagMueveStock)="" )  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_FlagMueveStock='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_FlagMueveStock);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
			
			IF (GUIASAP_Codigo IS NULL OR GUIASAP_Codigo=0 )  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASAP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASAP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (GUIAINP_Codigo IS NULL OR GUIAINP_Codigo=0 )  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (USUA_anula IS NULL OR USUA_anula=0 )  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.USUA_anula=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,USUA_anula);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;

			IF (CPC_FechaRegistro IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_FechaRegistro='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_FechaRegistro);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
			
			
			SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_FechaModificacion='");
			SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,now());
			SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            
			IF (CPC_FlagEstado IS NULL OR TRIM(CPC_FlagEstado)="" )  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_FlagEstado='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_FlagEstado);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;

			IF (CPC_Hora IS NULL )  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_Hora='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_Hora);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;

			IF (ALMAP_Codigo IS NULL OR ALMAP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.ALMAP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,ALMAP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (CPP_Codigo_Canje IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPP_Codigo_Canje=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPP_Codigo_Canje);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (CPC_NumeroAutomatico IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_NumeroAutomatico=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_NumeroAutomatico);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			
			
			SET @SQLREALIZAR=SUBSTRING(@SQLREALIZAR,1,CHARACTER_LENGTH(@SQLREALIZAR)-1);
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.CPP_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPP_Codigo);
           
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
		END IF;
		
	ELSEIF REALIZACION=2 THEN
   		IF (CPP_Codigo IS NULL OR CPP_Codigo=0 ) THEN
        	SELECT "INGRESAR CPP_Codigo";
        ELSE
            SET @SQLREALIZAR="UPDATE cji_comprobante gs SET ";
            IF (CPC_FlagEstado IS NULL OR TRIM(CPC_FlagEstado)='')  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_FlagEstado='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(CPC_FlagEstado));
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_FechaModificacion='");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,NOW());
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.CPP_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPP_Codigo);
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;
		
		ELSEIF REALIZACION=3 THEN     
        IF (CPP_Codigo IS NULL OR CPP_Codigo=0 ) THEN
        	SELECT "INGRESAR CPP_Codigo";
        ELSE
            SELECT  gs.CPP_Codigo AS CPP_Codigo,
			  gs.CPC_TipoOperacion AS CPC_TipoOperacion,
			  gs.CPC_TipoDocumento AS CPC_TipoDocumento,
			  gs.PRESUP_Codigo AS PRESUP_Codigo,
			  gs.OCOMP_Codigo AS OCOMP_Codigo,
			  gs.COMPP_Codigo AS COMPP_Codigo,
			  gs.CPC_Serie AS CPC_Serie,
			  gs.CPC_Numero AS CPC_Numero,
			  gs.CLIP_Codigo AS CLIP_Codigo,
			  gs.PROVP_Codigo AS PROVP_Codigo,
			  gs.CPC_NombreAuxiliar AS CPC_NombreAuxiliar,
			  gs.USUA_Codigo AS USUA_Codigo,
			  gs.MONED_Codigo AS MONED_Codigo,
			  gs.FORPAP_Codigo AS FORPAP_Codigo,
			  gs.CPC_subtotal AS CPC_subtotal,
			  gs.CPC_descuento AS CPC_descuento,
			  gs.CPC_igv AS CPC_igv,
			  gs.CPC_total AS CPC_total,
			  gs.CPC_subtotal_conigv AS CPC_subtotal_conigv,
			  gs.CPC_descuento_conigv AS CPC_descuento_conigv,
			  gs.CPC_igv100 AS CPC_igv100, 
			  gs.CPC_descuento100 AS CPC_descuento100,
			  gs.GUIAREMP_Codigo AS GUIAREMP_Codigo,
			  gs.CPC_GuiaRemCodigo AS CPC_GuiaRemCodigo,
			  gs.CPC_DocuRefeCodigo AS CPC_DocuRefeCodigo,
			  gs.CPC_Observacion AS CPC_Observacion,
			  gs.CPC_ModoImpresion AS CPC_ModoImpresion,
			  gs.CPC_Fecha AS CPC_Fecha,
			  gs.CPC_Vendedor AS CPC_Vendedor,
			  gs.CPC_TDC AS CPC_TDC,
			  gs.CPC_FlagMueveStock AS CPC_FlagMueveStock,
			  gs.GUIASAP_Codigo AS GUIASAP_Codigo,
			  gs.GUIAINP_Codigo AS GUIAINP_Codigo,
			  gs.USUA_anula AS USUA_anula,
			  gs.CPC_FechaRegistro AS CPC_FechaRegistro,
			  gs.CPC_FechaModificacion AS CPC_FechaModificacion,
			  gs.CPC_FlagEstado AS CPC_FlagEstado,
			  gs.CPC_Hora AS CPC_Hora,
			  gs.ALMAP_Codigo AS ALMAP_Codigo,
			  gs.CPP_Codigo_Canje AS CPP_Codigo_Canje
            FROM cji_comprobante gs
            WHERE gs.CPP_Codigo=CPP_Codigo;
     	END IF;  
		
		ELSEIF REALIZACION=4 THEN     
        
           SET @SQLREALIZAR="SELECT \r\n              gs.CPP_Codigo AS CPP_Codigo,\r\n\t\t\t  gs.CPC_TipoOperacion AS CPC_TipoOperacion ,\r\n\t\t\t  gs.CPC_TipoDocumento AS CPC_TipoDocumento ,\r\n\t\t\t  gs.PRESUP_Codigo AS PRESUP_Codigo,\r\n\t\t\t  gs.OCOMP_Codigo AS OCOMP_Codigo,\r\n\t\t\t  gs.COMPP_Codigo AS COMPP_Codigo,\r\n\t\t\t  gs.CPC_Serie AS CPC_Serie,\r\n\t\t\t  gs.CPC_Numero AS CPC_Numero,\r\n\t\t\t  gs.CLIP_Codigo AS CLIP_Codigo,\r\n\t\t\t  gs.PROVP_Codigo AS PROVP_Codigo,\r\n\t\t\t  gs.CPC_NombreAuxiliar AS CPC_NombreAuxiliar,\r\n\t\t\t  gs.USUA_Codigo AS USUA_Codigo,\r\n\t\t\t  gs.MONED_Codigo AS MONED_Codigo,\r\n\t\t\t  gs.FORPAP_Codigo AS FORPAP_Codigo,\r\n\t\t\t  gs.CPC_subtotal AS CPC_subtotal,\r\n\t\t\t  gs.CPC_descuento AS CPC_descuento,\r\n\t\t\t  gs.CPC_igv AS CPC_igv,\r\n\t\t\t  gs.CPC_total AS CPC_total,\r\n\t\t\t  gs.CPC_subtotal_conigv AS CPC_subtotal_conigv,\r\n\t\t\t  gs.CPC_descuento_conigv AS CPC_descuento_conigv,\r\n\t\t\t  gs.CPC_igv100 AS CPC_igv100, \r\n\t\t\t  gs.CPC_descuento100 AS CPC_descuento100,\r\n\t\t\t  gs.GUIAREMP_Codigo AS GUIAREMP_Codigo,\r\n\t\t\t  gs.CPC_GuiaRemCodigo AS CPC_GuiaRemCodigo,\r\n\t\t\t  gs.CPC_DocuRefeCodigo AS CPC_DocuRefeCodigo,\r\n\t\t\t  gs.CPC_Observacion AS CPC_Observacion,\r\n\t\t\t  gs.CPC_ModoImpresion AS CPC_ModoImpresion,\r\n\t\t\t  gs.CPC_Fecha AS CPC_Fecha,\r\n\t\t\t  gs.CPC_Vendedor AS CPC_Vendedor,\r\n\t\t\t  gs.CPC_TDC AS CPC_TDC,\r\n\t\t\t  gs.CPC_FlagMueveStock AS CPC_FlagMueveStock,\r\n\t\t\t  gs.GUIASAP_Codigo AS GUIASAP_Codigo,\r\n\t\t\t  gs.GUIAINP_Codigo AS GUIAINP_Codigo,\r\n\t\t\t  gs.USUA_anula AS USUA_anula,\r\n\t\t\t  gs.CPC_FechaRegistro AS CPC_FechaRegistro,\r\n\t\t\t  gs.CPC_FechaModificacion AS CPC_FechaModificacion,\r\n\t\t\t  gs.CPC_FlagEstado AS CPC_FlagEstado,\r\n\t\t\t  gs.CPC_Hora AS CPC_Hora,\r\n\t\t\t  gs.ALMAP_Codigo AS ALMAP_Codigo,\r\n\t\t\t  gs.CPP_Codigo_Canje AS CPP_Codigo_Canje\r\n            FROM cji_comprobante gs\r\n            WHERE gs.CPC_FlagEstado !=0 ";
			
			
			
			
			IF (CPC_TipoOperacion IS NULL OR TRIM(CPC_TipoOperacion)="")  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_TipoOperacion='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(CPC_TipoOperacion));
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;
			
			IF (CPC_TipoDocumento IS NULL OR TRIM(CPC_TipoDocumento)="")  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_TipoDocumento='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(CPC_TipoDocumento));
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;
			
			IF (PRESUP_Codigo IS NULL OR PRESUP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PRESUP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PRESUP_Codigo);
            END IF;
		
			IF (OCOMP_Codigo IS NULL OR OCOMP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.OCOMP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,OCOMP_Codigo);
            END IF;
		
			IF (COMPP_Codigo IS NULL OR COMPP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.COMPP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,COMPP_Codigo);
            END IF;
		
			IF (CPC_Serie IS NULL OR TRIM(CPC_Serie)="")  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_Serie='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(CPC_Serie));
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;
		
			IF (CPC_Numero IS NULL OR TRIM(CPC_Numero)="")  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_Numero='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(CPC_Numero));
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;
			
			IF (CLIP_Codigo IS NULL OR CLIP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CLIP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CLIP_Codigo);
            END IF;
			
			IF (PROVP_Codigo IS NULL OR PROVP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROVP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROVP_Codigo);
            END IF;
			
			IF (CPC_NombreAuxiliar IS NULL OR TRIM(CPC_NombreAuxiliar)="")  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"UPPER(gs.CPC_NombreAuxiliar) LIKE '%");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,UPPER(CPC_NombreAuxiliar));
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"%' ");
            END IF;
			
			IF (USUA_Codigo IS NULL OR USUA_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.USUA_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,USUA_Codigo);
            END IF;
			
			IF (MONED_Codigo IS NULL OR MONED_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.MONED_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,MONED_Codigo);
            END IF;
			
			IF (FORPAP_Codigo IS NULL OR FORPAP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.FORPAP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FORPAP_Codigo);
            END IF;
			
			
			

			IF (GUIAREMP_Codigo IS NULL OR GUIAREMP_Codigo=0 )  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMP_Codigo);
            END IF;

			IF (CPC_GuiaRemCodigo IS NULL OR TRIM(CPC_GuiaRemCodigo)="" )  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_GuiaRemCodigo='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_GuiaRemCodigo);
            END IF;
			
			IF (CPC_DocuRefeCodigo IS NULL OR TRIM(CPC_DocuRefeCodigo)="" )  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_DocuRefeCodigo='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_DocuRefeCodigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;
			
			IF (CPC_Observacion IS NULL OR TRIM(CPC_Observacion)="" )  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"UPPER(gs.CPC_Observacion) LIKE '%");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,UPPER(CPC_Observacion));
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"%' ");
            END IF;
			
			IF (CPC_ModoImpresion IS NULL OR TRIM(CPC_ModoImpresion)="" )  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_ModoImpresion='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_ModoImpresion);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;
			
			
			IF (FECHAINICIO IS NULL OR TRIM(FECHAINICIO)='0000-00-00')  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_Fecha>='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAINICIO);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
            IF (FECHAFIN IS NULL OR TRIM(FECHAFIN)='0000-00-00')  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_Fecha<='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAFIN);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
			
			IF (CPC_Vendedor IS NULL OR CPC_Vendedor=0 )  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_Vendedor=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_Vendedor);
            END IF;
			
			IF (CPC_TDC IS NULL OR CPC_TDC=0 )  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_TDC=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_TDC);
            END IF;

			IF (CPC_FlagMueveStock IS NULL OR TRIM(CPC_FlagMueveStock)="" )  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPC_FlagMueveStock='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPC_FlagMueveStock);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;
			
			IF (GUIASAP_Codigo IS NULL OR GUIASAP_Codigo=0 )  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASAP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASAP_Codigo);
            END IF;
			
			IF (GUIAINP_Codigo IS NULL OR GUIAINP_Codigo=0 )  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINP_Codigo);
            END IF;
			
			IF (USUA_anula IS NULL OR USUA_anula=0 )  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.USUA_anula=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,USUA_anula);
            END IF;
	


			IF (ALMAP_Codigo IS NULL OR ALMAP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.ALMAP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,ALMAP_Codigo);
            END IF;
			
			IF (CPP_Codigo_Canje IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPP_Codigo_Canje=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPP_Codigo_Canje);
            END IF;
			
			SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," ORDER BY gs.CPP_Codigo ASC;");
			
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
      
  END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MANTENIMIENTO_COMPROBANTEDETALLE` (IN `CPDEP_Codigo` INT(11), IN `CPP_Codigo` INT(11), IN `PROD_Codigo` INT(11), IN `CPDEC_GenInd` CHAR(1), IN `UNDMED_Codigo` INT(11), IN `CPDEC_Cantidad` DOUBLE, IN `CPDEC_Pu` DOUBLE, IN `CPDEC_Subtotal` DOUBLE, IN `CPDEC_Descuento` DOUBLE, IN `CPDEC_Igv` DOUBLE, IN `CPDEC_Total` DOUBLE, IN `CPDEC_Pu_ConIgv` DOUBLE, IN `CPDEC_Subtotal_ConIgv` DOUBLE, IN `CPDEC_Descuento_ConIgv` DOUBLE, IN `CPDEC_Igv100` INT(11), IN `CPDEC_Descuento100` INT(11), IN `CPDEC_Costo` DOUBLE, IN `CPDEC_Descripcion` VARCHAR(250), IN `CPDEC_Observacion` VARCHAR(250), IN `CPDEC_FechaRegistro` TIMESTAMP, IN `CPDEC_FechaModificacion` DATETIME, IN `CPDEC_FlagEstado` CHAR(1), IN `REALIZACION` INT, IN `USUARIO` INT, IN `FECHAINICIO` DATE, IN `FECHAFIN` DATE, IN `ALMAP_Codigo` INT(11), IN `GUIAREMP_Codigo` INT(11))  BEGIN
	IF REALIZACION=0 THEN
		INSERT INTO cji_comprobantedetalle VALUES (   
			0,
			CPP_Codigo,
			PROD_Codigo,
			CPDEC_GenInd,
			UNDMED_Codigo,
			CPDEC_Cantidad,
			CPDEC_Pu,
			CPDEC_Subtotal,
			CPDEC_Descuento,
			CPDEC_Igv,
			CPDEC_Total,
			CPDEC_Pu_ConIgv,
			CPDEC_Subtotal_ConIgv,
			CPDEC_Descuento_ConIgv,
			CPDEC_Igv100,
			CPDEC_Descuento100,
			CPDEC_Costo,
			CPDEC_Descripcion,
			CPDEC_Observacion,
			CPDEC_FechaRegistro,
			CPDEC_FechaModificacion,
			CPDEC_FlagEstado,
			ALMAP_Codigo,
			GUIAREMP_Codigo
			);
		
	ELSEIF REALIZACION=1 THEN
		IF (CPDEP_Codigo IS NULL OR CPDEP_Codigo=0 ) THEN
        	SELECT "INGRESAR CPDEP_Codigo";
        ELSE	
			SET @SQLREALIZAR="UPDATE cji_comprobantedetalle gs SET ";
			
			IF (CPP_Codigo IS NULL OR CPP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
			ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (PROD_Codigo IS NULL OR PROD_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
			ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			
			IF (CPDEC_GenInd IS NULL OR TRIM(CPDEC_GenInd)="")  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
			ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_GenInd='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_GenInd);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
			
			
			IF (UNDMED_Codigo IS NULL OR UNDMED_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
			ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.UNDMED_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,UNDMED_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (CPDEC_Cantidad IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
			ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_Cantidad=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_Cantidad);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (CPDEC_Pu IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
			ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_Pu=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_Pu);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			
			IF (CPDEC_Subtotal IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
			ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_Subtotal=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_Subtotal);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			
			IF (CPDEC_Descuento IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
			ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_Descuento=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_Descuento);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (CPDEC_Igv IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
			ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_Igv=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_Igv);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;			

			IF (CPDEC_Total IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
			ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_Total=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_Total);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;			
			
			IF (CPDEC_Pu_ConIgv IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
			ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_Pu_ConIgv=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_Pu_ConIgv);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;			
			
			IF (CPDEC_Subtotal_ConIgv IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
			ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_Subtotal_ConIgv=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_Subtotal_ConIgv);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (CPDEC_Descuento_ConIgv IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
			ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_Descuento_ConIgv=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_Descuento_ConIgv);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;

IF (CPDEC_Igv100 IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
			ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_Igv100=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_Igv100);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (CPDEC_Descuento100 IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
			ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_Descuento100=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_Descuento100);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;

IF (CPDEC_Costo IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
			ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_Costo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_Costo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
IF (CPDEC_Descripcion IS NULL OR TRIM(CPDEC_Descripcion)="")  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
			ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_Descripcion='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_Descripcion);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
		
			IF (CPDEC_Observacion IS NULL OR TRIM(CPDEC_Observacion)="")  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
			ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_Observacion='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_Observacion);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
						
			SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_FechaModificacion='");
			SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,NOW());
			SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            
			IF (CPDEC_FlagEstado IS NULL OR TRIM(CPDEC_FlagEstado)="")  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
			ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_FlagEstado='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_FlagEstado);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;

	SET @SQLREALIZAR=SUBSTRING(@SQLREALIZAR,1,CHARACTER_LENGTH(@SQLREALIZAR)-1);
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.CPDEP_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEP_Codigo);
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
		END IF;
	ELSEIF REALIZACION=2 THEN
			IF (CPDEP_Codigo IS NULL OR CPDEP_Codigo=0 ) THEN
				SELECT "INGRESAR CPDEP_Codigo";
			ELSE
				SET @SQLREALIZAR="UPDATE cji_comprobantedetalle gs SET ";
				IF (CPDEC_FlagEstado IS NULL OR TRIM(CPDEC_FlagEstadoo)='')  THEN
					SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
				ELSE
					SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_FlagEstado='");
					SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(CPDEC_FlagEstado));
					SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
				END IF;
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_FechaModificacion='");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,NOW());
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.CPDEP_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEP_Codigo);
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;
	ELSEIF REALIZACION=3 THEN
		IF (CPDEP_Codigo IS NULL OR CPDEP_Codigo=0 ) THEN
        	SELECT "INGRESAR CPDEP_Codigo";
        ELSE
			SELECT    
			gs.CPDEP_Codigo AS CPDEP_Codigo,
			gs.CPP_Codigo AS CPP_Codigo,
			gs.PROD_Codigo AS PROD_Codigo,
			gs.CPDEC_GenInd AS CPDEC_GenInd,
			gs.UNDMED_Codigo AS UNDMED_Codigo,
			gs.CPDEC_Cantidad AS CPDEC_Cantidad,
			gs.CPDEC_Pu AS CPDEC_Pu,
			gs.CPDEC_Subtotal AS CPDEC_Subtotal,
			gs.CPDEC_Descuento AS CPDEC_Descuento,
			gs.CPDEC_Igv AS CPDEC_Igv,
			gs.CPDEC_Total AS CPDEC_Total,
			gs.CPDEC_Pu_ConIgv AS CPDEC_Pu_ConIgv,
			gs.CPDEC_Subtotal_ConIgv AS CPDEC_Subtotal_ConIgv,
			gs.CPDEC_Descuento_ConIgv AS CPDEC_Descuento_ConIgv,
			gs.CPDEC_Igv100 AS CPDEC_Igv100,
			gs.CPDEC_Descuento100 AS CPDEC_Descuento100,
			gs.CPDEC_Costo AS CPDEC_Costo,
			gs.CPDEC_Descripcion AS CPDEC_Descripcion,
			gs.CPDEC_Observacion AS CPDEC_Observacion,
			gs.CPDEC_FechaRegistro AS CPDEC_FechaRegistro,
			gs.CPDEC_FechaModificacion AS CPDEC_FechaModificacion,
			gs.CPDEC_FlagEstado AS CPDEC_FlagEstado
			FROM cji_comprobantedetalle gs
			WHERE gs.CPDEP_Codigo=CPDEP_Codigo;
		END IF;
	ELSEIF REALIZACION=4 THEN
		
		SET @SQLREALIZAR="SELECT    \r\n\t\t\tgs.CPDEP_Codigo AS CPDEP_Codigo,\r\n\t\t\tgs.CPP_Codigo AS CPP_Codigo,\r\n\t\t\tgs.PROD_Codigo AS PROD_Codigo,\r\n\t\t\tgs.CPDEC_GenInd AS CPDEC_GenInd,\r\n\t\t\tgs.UNDMED_Codigo AS UNDMED_Codigo,\r\n\t\t\tgs.CPDEC_Cantidad AS CPDEC_Cantidad,\r\n\t\t\tgs.CPDEC_Pu AS CPDEC_Pu,\r\n\t\t\tgs.CPDEC_Subtotal AS CPDEC_Subtotal,\r\n\t\t\tgs.CPDEC_Descuento AS CPDEC_Descuento,\r\n\t\t\tgs.CPDEC_Igv AS CPDEC_Igv,\r\n\t\t\tgs.CPDEC_Total AS CPDEC_Total,\r\n\t\t\tgs.CPDEC_Pu_ConIgv AS CPDEC_Pu_ConIgv,\r\n\t\t\tgs.CPDEC_Subtotal_ConIgv AS CPDEC_Subtotal_ConIgv,\r\n\t\t\tgs.CPDEC_Descuento_ConIgv AS CPDEC_Descuento_ConIgv,\r\n\t\t\tgs.CPDEC_Igv100 AS CPDEC_Igv100,\r\n\t\t\tgs.CPDEC_Descuento100 AS CPDEC_Descuento100,\r\n\t\t\tgs.CPDEC_Costo AS CPDEC_Costo,\r\n\t\t\tgs.CPDEC_Descripcion AS CPDEC_Descripcion,\r\n\t\t\tgs.CPDEC_Observacion AS CPDEC_Observacion,\r\n\t\t\tgs.CPDEC_FechaRegistro AS CPDEC_FechaRegistro,\r\n\t\t\tgs.CPDEC_FechaModificacion AS CPDEC_FechaModificacion,\r\n\t\t\tgs.CPDEC_FlagEstado AS CPDEC_FlagEstado\r\n\t\t\tFROM cji_comprobantedetalle gs WHERE gs.CPDEC_FlagEstado!=0";
			
		IF (CPP_Codigo IS NULL OR CPP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
			ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPP_Codigo);
            END IF;
			
			IF (PROD_Codigo IS NULL OR PROD_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
			ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_Codigo);
			END IF;
			
			
			IF (CPDEC_GenInd IS NULL OR TRIM(CPDEC_GenInd)="")  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
			ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_GenInd='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_GenInd);
			END IF;
			
			
			IF (UNDMED_Codigo IS NULL OR UNDMED_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
			ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.UNDMED_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,UNDMED_Codigo);
			END IF;
			

			IF (CPDEC_Descripcion IS NULL OR TRIM(CPDEC_Descripcion)="")  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
			ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_Descripcion LIKE '%");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_Descripcion);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"%'");
            END IF;
		
			IF (CPDEC_Observacion IS NULL OR TRIM(CPDEC_Observacion)="")  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
			ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_Observacion LIKE '%");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPDEC_Observacion);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"%'");
            END IF;
						
			
            IF (FECHAINICIO IS NULL OR TRIM(FECHAINICIO)='0000-00-00')  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_FechaRegistro>='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAINICIO);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
            IF (FECHAFIN IS NULL OR TRIM(FECHAFIN)='0000-00-00')  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPDEC_FechaRegistro<='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAFIN);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
			
			SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," ORDER BY gs.CPDEP_Codigo ASC;");

            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
				
	END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MANTENIMIENTO_COMPROBANTE_GUIAREM` (IN `COMPGUI_Codigo` INT(11), IN `CPP_Codigo` INT(11), IN `GUIAREMP_Codigo` INT(11), IN `COMPGUI_FlagEstado` INT(2), IN `REALIZACION` INT)  BEGIN
	IF REALIZACION=0 THEN
		INSERT INTO cji_comprobante_guiarem VALUES (
			  0,
			  CPP_Codigo,
			  GUIAREMP_Codigo,
			  3,
			  NOW()
		 );
	ELSEIF REALIZACION=1 THEN
		SELECT "IMPLEMENTAR";
	ELSEIF REALIZACION=2 THEN
   		IF (COMPGUI_Codigo IS NULL OR COMPGUI_Codigo=0 ) THEN
        	SELECT "INGRESAR COMPGUI_Codigo";
        ELSE
            SET @SQLREALIZAR="UPDATE cji_comprobante_guiarem gs SET ";
            IF (COMPGUI_FlagEstado IS NULL OR TRIM(COMPGUI_FlagEstado)='')  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.COMPGUI_FlagEstado='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(COMPGUI_FlagEstado));
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;
         
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.COMPGUI_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,COMPGUI_Codigo);
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;
	END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MANTENIMIENTO_CUENTA` (INOUT `CUE_Codigo` INT(11), IN `CUE_TipoCuenta` INT(11), IN `DOCUP_Codigo` INT(1), IN `CUE_CodDocumento` INT(11), IN `MONED_Codigo` INT(11), IN `CUE_Monto` DOUBLE, IN `CUE_FechaOper` DATE, IN `CUE_FlagEstadoPago` VARCHAR(1), IN `CUE_FechaCanc` DATE, IN `COMPP_Codigo` INT(11), IN `CUE_FechaRegistro` TIMESTAMP, IN `CUE_FechaModificacion` DATETIME, IN `CUE_FlagEstado` VARCHAR(1), IN `REALIZACION` INT, IN `USUARIO` INT, IN `FECHAINICIO` DATE, IN `FECHAFIN` DATE, IN `FECHAINICIOC` DATE, IN `FECHAFINC` DATE)  BEGIN
	IF REALIZACION=0 THEN
		INSERT INTO cji_cuentas VALUES (
			0,
			CUE_TipoCuenta,
			DOCUP_Codigo,
			CUE_CodDocumento,
			MONED_Codigo,
			CUE_Monto,
			CUE_FechaOper,
			CUE_FlagEstadoPago,
			CUE_FechaCanc,
			COMPP_Codigo,
			NOW(),
			CUE_FechaModificacion,
			CUE_FlagEstado
		 );
		SET CUE_Codigo=last_insert_id();
	ELSEIF REALIZACION=1 THEN
		IF (CUE_Codigo IS NULL OR CUE_Codigo=0 ) THEN
        	SELECT "INGRESAR CUE_Codigo";
        ELSE	
			SET @SQLREALIZAR="UPDATE cji_cuentas gs SET ";
			
			IF (CUE_TipoCuenta IS NULL OR CUE_TipoCuenta=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_TipoCuenta=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CUE_TipoCuenta);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
			
			IF (DOCUP_Codigo IS NULL OR DOCUP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.DOCUP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,DOCUP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
			
			IF (CUE_CodDocumento IS NULL OR CUE_CodDocumento=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_CodDocumento=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CUE_CodDocumento);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
			
			IF (MONED_Codigo IS NULL OR MONED_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.MONED_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,MONED_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;

			IF (CUE_Monto IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_Monto=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CUE_Monto);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
			
			IF (CUE_FechaOper IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_FechaOper='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CUE_FechaOper);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"', ");
            END IF;

			IF (CUE_FlagEstadoPago IS NULL OR TRIM(CUE_FlagEstadoPago)="")  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_FlagEstadoPago='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(CUE_FlagEstadoPago));
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"', ");
            END IF;
			
			IF (CUE_FechaCanc IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_FechaCanc='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CUE_FechaCanc);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"', ");
            END IF;

			IF (COMPP_Codigo IS NULL OR COMPP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.COMPP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,COMPP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
			
			SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_FechaModificacion='");
			SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,NOW());
			SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"', ");

			IF (CUE_FlagEstado IS NULL OR TRIM(CUE_FlagEstado)="")  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_FlagEstado='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(CUE_FlagEstado));
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
			
			SET @SQLREALIZAR=SUBSTRING(@SQLREALIZAR,1,CHARACTER_LENGTH(@SQLREALIZAR)-1);
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.CUE_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CUE_Codigo);
            
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;
	ELSEIF REALIZACION=2 THEN
   		IF (CUE_Codigo IS NULL OR CUE_Codigo=0 ) THEN
        	SELECT "INGRESAR CUE_Codigo";
        ELSE
            SET @SQLREALIZAR="UPDATE cji_cuentas gs SET ";
            IF (CUE_FlagEstado IS NULL OR TRIM(CUE_FlagEstado)='')  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_FlagEstado='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(CUE_FlagEstado));
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_FechaModificacion='");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,NOW());
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.CUE_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CUE_Codigo);
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;
		
		ELSEIF REALIZACION=3 THEN     
        IF (CUE_Codigo IS NULL OR CUE_Codigo=0 ) THEN
        	SELECT "INGRESAR CUE_Codigo";
        ELSE
            SELECT  gs.CUE_Codigo AS CUE_Codigo,
					gs.CUE_TipoCuenta AS CUE_TipoCuenta,
					gs.DOCUP_Codigo AS DOCUP_Codigo,
					gs.CUE_CodDocumento AS CUE_CodDocumento,
					gs.MONED_Codigo AS MONED_Codigo,
					gs.CUE_Monto AS CUE_Monto,
					gs.CUE_FechaOper AS CUE_FechaOper,
					gs.CUE_FlagEstadoPago AS CUE_FlagEstadoPago,
					gs.CUE_FechaCanc AS CUE_FechaCanc,
					gs.COMPP_Codigo AS COMPP_Codigo,
					gs.CUE_FechaRegistro AS CUE_FechaRegistro,
					gs.CUE_FechaModificacion AS CUE_FechaModificacion,
					gs.CUE_FlagEstado AS CUE_FlagEstado
            FROM cji_cuentas gs
            WHERE gs.CUE_Codigo=CUE_Codigo;
     	END IF;  
		ELSEIF REALIZACION=4 THEN  
			SET @SQLREALIZAR="SELECT \r\n\t\t\t\t\tgs.CUE_Codigo AS CUE_Codigo,\r\n\t\t\t\t\tgs.CUE_TipoCuenta AS CUE_TipoCuenta,\r\n\t\t\t\t\tgs.DOCUP_Codigo AS DOCUP_Codigo,\r\n\t\t\t\t\tgs.CUE_CodDocumento AS CUE_CodDocumento,\r\n\t\t\t\t\tgs.MONED_Codigo AS MONED_Codigo,\r\n\t\t\t\t\tgs.CUE_Monto AS CUE_Monto,\r\n\t\t\t\t\tgs.CUE_FechaOper AS CUE_FechaOper,\r\n\t\t\t\t\tgs.CUE_FlagEstadoPago AS CUE_FlagEstadoPago,\r\n\t\t\t\t\tgs.CUE_FechaCanc AS CUE_FechaCanc,\r\n\t\t\t\t\tgs.COMPP_Codigo AS COMPP_Codigo,\r\n\t\t\t\t\tgs.CUE_FechaRegistro AS CUE_FechaRegistro,\r\n\t\t\t\t\tgs.CUE_FechaModificacion AS CUE_FechaModificacion,\r\n\t\t\t\t\tgs.CUE_FlagEstado AS CUE_FlagEstado\r\n\t\t\tFROM cji_cuentas gs\r\n\t\t\tWHERE gs.CUE_FlagEstado !=0 ";
			
			IF (CUE_TipoCuenta IS NULL OR CUE_TipoCuenta=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_TipoCuenta=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CUE_TipoCuenta);
            END IF;
			
			IF (DOCUP_Codigo IS NULL OR DOCUP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.DOCUP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,DOCUP_Codigo);
            END IF;
			
			IF (CUE_CodDocumento IS NULL OR CUE_CodDocumento=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_CodDocumento=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CUE_CodDocumento);
            END IF;
			
			IF (MONED_Codigo IS NULL OR MONED_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.MONED_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,MONED_Codigo);
            END IF;

			
			IF (FECHAINICIO IS NULL OR TRIM(FECHAINICIO)='0000-00-00' )   THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_FechaOper>='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAINICIO);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
            IF (FECHAFIN IS NULL OR TRIM(FECHAFIN)='0000-00-00')  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_FechaOper<='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAFIN);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
					
			IF (CUE_FlagEstadoPago IS NULL OR TRIM(CUE_FlagEstadoPago)="")  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_FlagEstadoPago='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(CUE_FlagEstadoPago));
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"'");
            END IF;
			
			IF (FECHAINICIOC IS NULL OR TRIM(FECHAINICIOC)='0000-00-00' )   THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_FechaCanc>='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAINICIOC);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
            IF (FECHAFINC IS NULL OR TRIM(FECHAFINC)='0000-00-00')  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_FechaCanc<='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAFINC);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
			
			
			IF (COMPP_Codigo IS NULL OR COMPP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.COMPP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,COMPP_Codigo);
            END IF;
			
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," ORDER BY gs.CUE_Codigo=");
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
		
END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MANTENIMIENTO_CUENTAPAGO` (IN `CPAGP_Codigo` INT(11), IN `CUE_Codigo` INT(11), IN `PAGP_Codigo` INT(11), IN `CPAGC_TDC` DOUBLE(10,2), IN `CPAGC_Monto` DOUBLE, IN `MONED_Codigo` INT(11), IN `CPAGC_FechaRegistro` TIMESTAMP, IN `CPAGC_FechaModificacion` DATETIME, IN `CPAGC_FlagEstado` VARCHAR(1), IN `REALIZACION` INT, IN `USUARIO` INT, IN `FECHAINICIO` DATE, IN `FECHAFIN` DATE, IN `FECHAINICIOC` DATE, IN `FECHAFINC` DATE)  BEGIN
	IF REALIZACION=0 THEN
		INSERT INTO cji_cuentaspago VALUES (
		0,
  		CUE_Codigo ,
  		PAGP_Codigo,
  		CPAGC_TDC,
  		CPAGC_Monto,
  		MONED_Codigo,
  		NOW(),
  		'',
  		CPAGC_FlagEstado
		 );
		
	ELSEIF REALIZACION=1 THEN
		IF (CPAGP_Codigo IS NULL OR CPAGP_Codigo=0 ) THEN
        	SELECT "INGRESAR CPAGP_Codigo";
        ELSE	
			SET @SQLREALIZAR="UPDATE cji_cuentaspago gs SET ";
			
			IF (CUE_Codigo IS NULL OR CUE_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CUE_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (PAGP_Codigo IS NULL OR PAGP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (CPAGC_TDC IS NULL OR CPAGC_TDC=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPAGC_TDC=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPAGC_TDC);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (CPAGC_Monto IS NULL OR CPAGC_Monto=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPAGC_Monto=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPAGC_Monto);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;

			IF (MONED_Codigo IS NULL OR MONED_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.MONED_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,MONED_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (CPAGC_FechaRegistro IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPAGC_FechaRegistro='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPAGC_FechaRegistro);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;

			IF (CPAGC_FechaModificacion IS NULL OR TRIM(CPAGC_FechaModificacion)="")  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPAGC_FechaModificacion='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(CPAGC_FechaModificacion));
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
			
			IF (CPAGC_FlagEstado IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPAGC_FlagEstado='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPAGC_FlagEstado);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;

			SET @SQLREALIZAR=SUBSTRING(@SQLREALIZAR,1,CHARACTER_LENGTH(@SQLREALIZAR)-1);
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.CPAGP_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPAGP_Codigo);
            
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;

	ELSEIF REALIZACION=2 THEN
   		IF (CPAGP_Codigo IS NULL OR CPAGP_Codigo=0 ) THEN
        	SELECT "INGRESAR CPAGP_Codigo";
        ELSE
            SET @SQLREALIZAR="UPDATE cji_cuentaspago gs SET ";
            IF (CPAGC_FlagEstado IS NULL OR TRIM(CPAGC_FlagEstado)='')  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPAGC_FlagEstado='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(CPAGC_FlagEstado));
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPAGC_FechaModificacion='");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,NOW());
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.CPAGP_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPAGP_Codigo);
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;
		
		ELSEIF REALIZACION=3 THEN     
        IF (CPAGP_Codigo IS NULL OR CPAGP_Codigo=0 ) THEN
        	SELECT "INGRESAR CPAGP_Codigo";
        ELSE
            SELECT  gs.CPAGP_Codigo AS CPAGP_Codigo,
  					gs.CUE_Codigo AS CUE_Codigo,
  					gs.PAGP_Codigo AS PAGP_Codigo,
  					gs.CPAGC_TDC AS CPAGC_TDC,
  					gs.CPAGC_Monto AS CPAGC_Monto,
  					gs.MONED_Codigo AS MONED_Codigo,
  					gs.CPAGC_FechaRegistro AS CPAGC_FechaRegistro,
  					gs.CPAGC_FechaModificacion AS CPAGC_FechaModificacion,
  					gs.CPAGC_FlagEstado AS CPAGC_FlagEstado
            FROM cji_cuentaspago gs
            WHERE gs.CPAGP_Codigo=CPAGP_Codigo;
     	END IF;  
		ELSEIF REALIZACION=4 THEN  
			SET @SQLREALIZAR="SELECT \r\n\t\t\t\t\tgs.CPAGP_Codigo AS CPAGP_Codigo,\r\n  \t\t\t\t\tgs.CUE_Codigo AS CUE_Codigo,\r\n  \t\t\t\t\tgs.PAGP_Codigo AS PAGP_Codigo,\r\n  \t\t\t\t\tgs.CPAGC_TDC AS CPAGC_TDC,\r\n  \t\t\t\t\tgs.CPAGC_Monto AS CPAGC_Monto,\r\n  \t\t\t\t\tgs.MONED_Codigo AS MONED_Codigo,\r\n  \t\t\t\t\tgs.CPAGC_FechaRegistro AS CPAGC_FechaRegistro,\r\n  \t\t\t\t\tgs.CPAGC_FechaModificacion AS CPAGC_FechaModificacion,\r\n  \t\t\t\t\tgs.CPAGC_FlagEstado AS CPAGC_FlagEstado\r\n\t\t\tFROM cji_cuentaspago gs\r\n\t\t\tWHERE gs.CPAGC_FlagEstado !=0 ";
			
			IF (CUE_Codigo IS NULL OR CUE_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CUE_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CUE_Codigo);
            END IF;
			
			IF (PAGP_Codigo IS NULL OR PAGP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGP_Codigo);
            END IF;
			
			IF (CPAGC_TDC IS NULL OR CPAGC_TDC=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPAGC_TDC=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPAGC_TDC);
            END IF;
			
			IF (CPAGC_Monto IS NULL OR CPAGC_Monto=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPAGC_Monto=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CPAGC_Monto);
            END IF;

            IF (MONED_Codigo IS NULL OR MONED_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.MONED_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,MONED_Codigo);
            END IF;
			
			IF (FECHAINICIO IS NULL OR TRIM(FECHAINICIO)='0000-00-00' )   THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPAGC_FechaRegistro>='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAINICIO);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
            IF (FECHAFIN IS NULL OR TRIM(FECHAFIN)='0000-00-00')  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CPAGC_FechaRegistro<='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAFIN);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
			
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," ORDER BY gs.CPAGP_Codigo=");
            
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
		
END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MANTENIMIENTO_GUIAIN` (INOUT `GUIAINP_Codigo` INT(11), IN `TIPOMOVP_Codigo` INT(11), IN `ALMAP_Codigo` INT(11), IN `USUA_Codigo` INT(11), IN `PROVP_Codigo` INT(11), IN `OCOMP_Codigo` INT(11), IN `DOCUP_Codigo` INT(11), IN `GUIAINC_NumeroRef` VARCHAR(50), IN `GUIAINC_Numero` VARCHAR(10), IN `GUIAINC_Fecha` DATE, IN `GUIAINC_FechaEmision` DATETIME, IN `GUIAINC_Observacion` VARCHAR(45), IN `GUIAINC_MarcaPlaca` VARCHAR(100), IN `GUIAINC_Certificado` VARCHAR(100), IN `GUIAINC_Licencia` VARCHAR(100), IN `GUIAINC_RucTransportista` VARCHAR(11), IN `GUIAINC_NombreTransportista` VARCHAR(150), IN `GUIAINC_FechaRegistro` TIMESTAMP, IN `GUIAINC_FechaModificacion` DATETIME, IN `GUIAINC_Automatico` INT(11), IN `GUIAINC_FlagEstado` CHAR(1), IN `REALIZACION` INT, IN `USUARIO` INT, IN `FECHAINICIO` DATE, IN `FECHAFIN` DATE)  BEGIN
   IF REALIZACION=0 THEN
     INSERT INTO cji_guiain VALUES (   
          0, 
          TIPOMOVP_Codigo, 
          ALMAP_Codigo, 
          USUA_Codigo, 
          PROVP_Codigo, 
          OCOMP_Codigo, 
          DOCUP_Codigo, 
          GUIAINC_NumeroRef, 
          GUIAINC_Numero, 
          GUIAINC_Fecha, 
          GUIAINC_FechaEmision, 
          GUIAINC_Observacion, 
          GUIAINC_MarcaPlaca, 
          GUIAINC_Certificado, 
          GUIAINC_Licencia, 
          GUIAINC_RucTransportista, 
          GUIAINC_NombreTransportista, 
          CURDATE(), 
          GUIAINC_FechaModificacion, 
          GUIAINC_Automatico, 
          GUIAINC_FlagEstado );
   SET GUIAINP_Codigo=last_insert_id();
   ELSEIF REALIZACION=1 THEN
		IF (GUIAINP_Codigo IS NULL OR GUIAINP_Codigo=0 ) THEN
        	SELECT "INGRESAR GUIAINP_Codigo";
        ELSE	
            SET @SQLREALIZAR="UPDATE cji_guiain gs SET ";
            IF (TIPOMOVP_Codigo IS NULL OR TIPOMOVP_Codigo=0 ) THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.TIPOMOVP_Codigo=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TIPOMOVP_Codigo);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            IF (ALMAP_Codigo IS NULL OR ALMAP_Codigo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.ALMAP_Codigo=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,ALMAP_Codigo);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            IF (USUA_Codigo IS NULL OR USUA_Codigo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.USUA_Codigo=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,USUA_Codigo);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;   
            IF (PROVP_Codigo IS NULL OR PROVP_Codigo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROVP_Codigo=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROVP_Codigo);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;    		
			IF (OCOMP_Codigo IS NULL OR OCOMP_Codigo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.OCOMP_Codigo=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,OCOMP_Codigo);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            IF (DOCUP_Codigo IS NULL OR DOCUP_Codigo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.DOCUP_Codigo=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,DOCUP_Codigo);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;    		
			IF (GUIAINC_NumeroRef IS NULL OR TRIM(GUIAINC_NumeroRef)="")  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINC_NumeroRef='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINC_NumeroRef);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;  
            IF (GUIAINC_Fecha IS NULL)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINC_Fecha='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINC_Fecha);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;   
			IF (GUIAINC_FechaEmision IS NULL)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINC_FechaEmision='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINC_FechaEmision);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF; 
            IF (GUIAINC_Numero IS NULL OR TRIM(GUIAINC_Numero)="")  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINC_Numero='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINC_Numero);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;   
            IF (GUIAINC_Observacion IS NULL OR TRIM(GUIAINC_Observacion)="")  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINC_Observacion='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINC_Observacion);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;   
            IF (GUIAINC_MarcaPlaca IS NULL OR TRIM(GUIAINC_MarcaPlaca)="")  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINC_MarcaPlaca='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINC_MarcaPlaca);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;   
            IF (GUIAINC_Certificado IS NULL OR TRIM(GUIAINC_Certificado)="")  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINC_Certificado='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINC_Certificado);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF; 
            IF (GUIAINC_Licencia IS NULL OR TRIM(GUIAINC_Licencia)="")  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINC_Licencia='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINC_Licencia);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF; 
            IF (GUIAINC_RucTransportista IS NULL OR TRIM(GUIAINC_RucTransportista)="")  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINC_RucTransportista='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINC_RucTransportista);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF; 
            IF (GUIAINC_NombreTransportista IS NULL OR TRIM(GUIAINC_NombreTransportista)="")  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINC_NombreTransportista='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINC_NombreTransportista);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINC_FechaModificacion='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CURDATE());
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            IF (GUIAINC_Automatico IS NULL OR GUIAINC_Automatico=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINC_Automatico=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINC_Automatico);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            IF (GUIAINC_FlagEstado IS NULL OR TRIM(GUIAINC_FlagEstado)='')  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINC_FlagEstado='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINC_FlagEstado);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            SET @SQLREALIZAR=SUBSTRING(@SQLREALIZAR,1,CHARACTER_LENGTH(@SQLREALIZAR)-1);
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.GUIAINP_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINP_Codigo);
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;
   ELSEIF REALIZACION=2 THEN
   		IF (GUIAINP_Codigo IS NULL OR GUIAINP_Codigo=0 ) THEN
        	SELECT "INGRESAR GUIAINP_Codigo";
        ELSE
            SET @SQLREALIZAR="UPDATE cji_guiain gs SET ";
            IF (GUIAINC_FlagEstado IS NULL OR TRIM(GUIAINC_FlagEstado)='')  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINC_FlagEstado='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(GUIAINC_FlagEstado));
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINC_FechaModificacion='");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CURDATE());
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.GUIAINP_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINP_Codigo);
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;
    ELSEIF REALIZACION=3 THEN     
        IF (GUIAINP_Codigo IS NULL OR GUIAINP_Codigo=0 ) THEN
        	SELECT "INGRESAR GUIAINP_Codigo";
        ELSE
            SELECT 
                gs.GUIAINP_Codigo AS GUIAINP_Codigo,
                gs.TIPOMOVP_Codigo AS TIPOMOVP_Codigo,
                gs.ALMAP_Codigo AS ALMAP_Codigo ,
                gs.USUA_Codigo AS USUA_Codigo,
                gs.PROVP_Codigo AS PROVP_Codigo,
				gs.OCOMP_Codigo AS OCOMP_Codigo,
                gs.DOCUP_Codigo AS DOCUP_Codigo,
				gs.GUIAINC_NumeroRef AS GUIAINC_NumeroRef,
                gs.GUIAINC_Fecha AS GUIAINC_Fecha,
				gs.GUIAINC_FechaEmision AS GUIAINC_FechaEmision,
                gs.GUIAINC_Numero AS GUIAINC_Numero,
                gs.GUIAINC_Observacion AS GUIAINC_Observacion,
                gs.GUIAINC_MarcaPlaca AS GUIAINC_MarcaPlaca,
                gs.GUIAINC_Certificado AS GUIAINC_Certificado,
                gs.GUIAINC_Licencia AS GUIAINC_Licencia,
                gs.GUIAINC_RucTransportista AS GUIAINC_RucTransportista,
                gs.GUIAINC_NombreTransportista AS GUIAINC_NombreTransportista,
                gs.GUIAINC_FechaRegistro AS GUIAINC_FechaRegistro,
                gs.GUIAINC_FechaModificacion AS GUIAINC_FechaModificacion,
                gs.GUIAINC_Automatico As GUIAINC_Automatico,
                gs.GUIAINC_FlagEstado AS GUIAINC_FlagEstado

            FROM cji_guiain gs
            WHERE gs.GUIAINP_Codigo=GUIAINP_Codigo;
     	END IF;  
         ELSEIF REALIZACION=4 THEN     
             SET @SQLREALIZAR="SELECT          gs.GUIAINP_Codigo AS GUIAINP_Codigo, gs.TIPOMOVP_Codigo AS TIPOMOVP_Codigo,gs.ALMAP_Codigo AS ALMAP_Codigo , gs.USUA_Codigo AS USUA_Codigo, gs.PROVP_Codigo AS PROVP_Codigo, gs.OCOMP_Codigo AS OCOMP_Codigo,gs.DOCUP_Codigo AS DOCUP_Codigo, gs.GUIAINC_NumeroRef AS GUIAINC_NumeroRef, gs.GUIAINC_Fecha AS GUIAINC_Fecha, gs.GUIAINC_FechaEmision AS GUIAINC_FechaEmision, gs.GUIAINC_Numero AS GUIAINC_Numero, gs.GUIAINC_Observacion AS GUIAINC_Observacion, gs.GUIAINC_MarcaPlaca AS GUIAINC_MarcaPlaca, gs.GUIAINC_Certificado AS GUIAINC_Certificado, gs.GUIAINC_Licencia AS GUIAINC_Licencia, gs.GUIAINC_RucTransportista AS GUIAINC_RucTransportista, gs.GUIAINC_NombreTransportista AS GUIAINC_NombreTransportista,         gs.GUIAINC_FechaRegistro AS GUIAINC_FechaRegistro,         gs.GUIAINC_FechaModificacion AS GUIAINC_FechaModificacion,   gs.GUIAINC_Automatico As GUIAINC_Automatico,           gs.GUIAINC_FlagEstado AS GUIAINC_FlagEstado    FROM cji_guiain gs WHERE gs.GUIAINC_FlagEstado !=0 ";
            IF (TIPOMOVP_Codigo IS NULL OR TIPOMOVP_Codigo=0 ) THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.TIPOMOVP_Codigo=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TIPOMOVP_Codigo);
            END IF;
            IF (ALMAP_Codigo IS NULL OR ALMAP_Codigo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.ALMAP_Codigo=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,ALMAP_Codigo);
            END IF;
            IF (USUA_Codigo IS NULL OR USUA_Codigo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.USUA_Codigo=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,USUA_Codigo);
            END IF;   
            IF (PROVP_Codigo IS NULL OR PROVP_Codigo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROVP_Codigo=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROVP_Codigo);
            END IF; 
			IF (OCOMP_Codigo IS NULL OR OCOMP_Codigo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.OCOMP_Codigo=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,OCOMP_Codigo);
            END IF; 
            IF (DOCUP_Codigo IS NULL OR DOCUP_Codigo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.DOCUP_Codigo=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,DOCUP_Codigo);
            END IF;    
			IF (GUIAINC_NumeroRef IS NULL OR TRIM(GUIAINC_NumeroRef)="")  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");	
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINC_NumeroRef='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINC_NumeroRef);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
             IF (FECHAINICIO IS NULL OR TRIM(FECHAINICIO)='0000-00-00' )  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINC_Fecha>='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAINICIO);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
            IF (FECHAFIN IS NULL OR TRIM(FECHAFIN)='0000-00-00')  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINC_Fecha<='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAFIN);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
            IF (GUIAINC_Numero IS NULL OR TRIM(GUIAINC_Numero)="")  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");	
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINC_Numero='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINC_Numero);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;   
            IF (GUIAINC_MarcaPlaca IS NULL OR TRIM(GUIAINC_MarcaPlaca)="")  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINC_MarcaPlaca='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINC_MarcaPlaca);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;   
            IF (GUIAINC_Certificado IS NULL OR TRIM(GUIAINC_Certificado)="")  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
			 SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINC_Certificado='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINC_Certificado);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF; 
            IF (GUIAINC_Licencia IS NULL OR TRIM(GUIAINC_Licencia)="")  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINC_Licencia='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINC_Licencia);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"'");
            END IF; 


            IF (GUIAINC_RucTransportista IS NULL OR TRIM(GUIAINC_RucTransportista)="")  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINC_RucTransportista='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINC_RucTransportista);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF; 
            IF (GUIAINC_NombreTransportista IS NULL OR TRIM(GUIAINC_NombreTransportista)="")  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
			 SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"UPPER(gs.GUIAINC_NombreTransportista) LIKE '%");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,UPPER(GUIAINC_NombreTransportista));
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," %' ");
            END IF;
            IF (GUIAINC_Automatico IS NULL OR GUIAINC_Automatico=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINC_Automatico=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINC_Automatico);
            END IF;


            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," ORDER BY gs.GUIAINP_Codigo ASC;");
			
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
   END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MANTENIMIENTO_GUIAINDETALLE` (IN `GUIAINDETP_Codigo` INT(11), IN `GUIAINP_Codigo` INT(11), IN `PRODCTOP_Codigo` INT(11), IN `UNDMED_Codigo` INT(11), IN `GUIIAINDETC_GenInd` CHAR(1), IN `GUIAINDETC_Cantidad` DOUBLE, IN `GUIAINDETC_Costo` DOUBLE, IN `GUIAINDETC_Descripcion` VARCHAR(300), IN `GUIAINDETC_FechaRegistro` TIMESTAMP, IN `GUIAINDET_FechaModificacion` DATETIME, IN `GUIAINDETC_FlagEstado` CHAR(1), IN `REALIZACION` INT, IN `USUARIO` INT, IN `FECHAINICIO` DATE, IN `FECHAFIN` DATE, IN `ALMAP_Codigo` INT(11))  BEGIN
   IF REALIZACION=0 THEN
     INSERT INTO cji_guiaindetalle VALUES (   
			0,
			GUIAINP_Codigo,
			PRODCTOP_Codigo,
			UNDMED_Codigo ,
			GUIIAINDETC_GenInd,
		    GUIAINDETC_Cantidad,
		    GUIAINDETC_Costo,
		    GUIAINDETC_Descripcion,
		    GUIAINDETC_FechaRegistro,
		    GUIAINDET_FechaModificacion,
		    GUIAINDETC_FlagEstado,
			ALMAP_Codigo);
   
   ELSEIF REALIZACION=1 THEN
		IF (GUIAINDETP_Codigo IS NULL OR GUIAINDETP_Codigo=0 ) THEN
        	SELECT "INGRESAR GUIAINDETP_Codigo";
        ELSE	
           SET @SQLREALIZAR="UPDATE cji_guiaindetalle gs SET ";
            
		  
            IF (GUIAINP_Codigo IS NULL OR GUIAINP_Codigo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINP_Codigo=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINP_Codigo);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
            IF (PRODCTOP_Codigo IS NULL OR PRODCTOP_Codigo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PRODCTOP_Codigo=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PRODCTOP_Codigo);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;   
			
            IF (UNDMED_Codigo IS NULL OR UNDMED_Codigo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.UNDMED_Codigo=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,UNDMED_Codigo);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;    		
			
			IF (GUIIAINDETC_GenInd IS NULL OR TRIM(GUIIAINDETC_GenInd)='' ) THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIIAINDETC_GenInd='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIIAINDETC_GenInd);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
			
			IF (GUIAINDETC_Cantidad IS NULL OR GUIAINDETC_Cantidad=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINDETC_Cantidad=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINDETC_Cantidad);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
            IF (GUIAINDETC_Costo IS NULL OR GUIAINDETC_Costo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINDETC_Costo=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINDETC_Costo);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;    
			
			IF (GUIAINDETC_Descripcion IS NULL OR TRIM(GUIAINDETC_Descripcion)="")  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINDETC_Descripcion='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINDETC_Descripcion);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;  
			
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINDET_FechaModificacion='");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CURDATE());
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
          			
            IF (GUIAINDETC_FlagEstado IS NULL OR TRIM(GUIAINDETC_FlagEstado)='')  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINDETC_FlagEstado='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINDETC_FlagEstado);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
			
			IF (ALMAP_Codigo IS NOT NULL AND TRIM(ALMAP_Codigo)<>'')  THEN
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.ALMAP_Codigo=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,ALMAP_Codigo);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
            SET @SQLREALIZAR=SUBSTRING(@SQLREALIZAR,1,CHARACTER_LENGTH(@SQLREALIZAR)-1);
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.GUIAINDETP_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINDETP_Codigo);
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;
		
   ELSEIF REALIZACION=2 THEN
   		IF (GUIAINDETP_Codigo IS NULL OR GUIAINDETP_Codigo=0 ) THEN
        	SELECT "INGRESAR GUIAINDETP_Codigo";
        ELSE
            SET @SQLREALIZAR="UPDATE cji_guiaindetalle gs SET ";
            IF (GUIAINDETC_FlagEstado IS NULL OR TRIM(GUIAINDETC_FlagEstado)='')  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINDETC_FlagEstado='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(GUIAINDETC_FlagEstado));
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINDET_FechaModificacion='");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CURDATE());
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.GUIAINDETP_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINDETP_Codigo);
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;
		
    ELSEIF REALIZACION=3 THEN     
        IF (GUIAINDETP_Codigo IS NULL OR GUIAINDETP_Codigo=0 ) THEN
        	SELECT "INGRESAR GUIAINDETP_Codigo";
        ELSE
            SELECT 
                gs.GUIAINDETP_Codigo AS GUIAINDETP_Codigo,
				gs.GUIAINP_Codigo AS GUIAINP_Codigo,
				gs.PRODCTOP_Codigo AS PRODCTOP_Codigo,
				gs.UNDMED_Codigo AS UNDMED_Codigo,
				gs.GUIIAINDETC_GenInd AS GUIIAINDETC_GenInd,
				gs.GUIAINDETC_Cantidad AS GUIAINDETC_Cantidad,
				gs.GUIAINDETC_Costo AS GUIAINDETC_Costo,
				gs.GUIAINDETC_Descripcion AS GUIAINDETC_Descripcion,
				gs.GUIAINDETC_FechaRegistro AS GUIAINDETC_FechaRegistro,
				gs.GUIAINDET_FechaModificacion AS GUIAINDET_FechaModificacion,
				gs.GUIAINDETC_FlagEstado AS GUIAINDETC_FlagEstado,
				gs.ALMAP_Codigo AS ALMAP_Codigo
            FROM cji_guiaindetalle gs
            WHERE gs.GUIAINDETP_Codigo=GUIAINDETP_Codigo;
     	END IF;  
		
        ELSEIF REALIZACION=4 THEN     
             SET @SQLREALIZAR="SELECT  gs.GUIAINDETP_Codigo AS GUIAINDETP_Codigo, gs.GUIAINP_Codigo AS GUIAINP_Codigo, gs.PRODCTOP_Codigo AS PRODCTOP_Codigo, gs.UNDMED_Codigo AS UNDMED_Codigo, gs.GUIIAINDETC_GenInd AS GUIIAINDETC_GenInd, gs.GUIAINDETC_Cantidad AS GUIAINDETC_Cantidad, gs.GUIAINDETC_Costo AS GUIAINDETC_Costo, gs.GUIAINDETC_Descripcion AS GUIAINDETC_Descripcion, gs.GUIAINDETC_FechaRegistro AS GUIAINDETC_FechaRegistro, gs.GUIAINDET_FechaModificacion AS GUIAINDET_FechaModificacion, gs.GUIAINDETC_FlagEstado AS GUIAINDETC_FlagEstado FROM cji_guiaindetalle gs WHERE gs.GUIAINDETC_FlagEstado !=0 ";
				
          
		  IF (GUIAINP_Codigo IS NULL OR GUIAINP_Codigo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINP_Codigo);
            END IF;
			
            IF (PRODCTOP_Codigo IS NULL OR PRODCTOP_Codigo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PRODCTOP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PRODCTOP_Codigo);
            END IF;   
			
            IF (UNDMED_Codigo IS NULL OR UNDMED_Codigo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.UNDMED_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,UNDMED_Codigo);
            END IF;    		
			
			IF (GUIIAINDETC_GenInd IS NULL OR TRIM(GUIIAINDETC_GenInd)='' ) THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIIAINDETC_GenInd='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIIAINDETC_GenInd);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;
			
			IF (GUIAINDETC_Cantidad IS NULL OR GUIAINDETC_Cantidad=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINDETC_Cantidad=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINDETC_Cantidad);
            END IF;
			
            IF (GUIAINDETC_Costo IS NULL OR GUIAINDETC_Costo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINDETC_Costo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINDETC_Costo);
            END IF;    
			
			IF (GUIAINDETC_Descripcion IS NULL OR TRIM(GUIAINDETC_Descripcion)="")  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"UPPER(gs.GUIAINDETC_Descripcion) LIKE '%");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,UPPER(GUIAINDETC_Descripcion));
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"%' ");
            END IF;  
			
            IF (FECHAINICIO IS NULL OR TRIM(FECHAINICIO)='0000-00-00' )  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINDETC_FechaRegistro>='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAINICIO);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
            IF (FECHAFIN IS NULL OR TRIM(FECHAFIN)='0000-00-00')  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINDETC_FechaRegistro<='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAFIN);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
			
			IF (ALMAP_Codigo IS NOT NULL AND TRIM(ALMAP_Codigo)<>'')  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.ALMAP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,ALMAP_Codigo);
            END IF;

            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," ORDER BY gs.GUIAINP_Codigo ASC;");
			
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
   END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MANTENIMIENTO_GUIAREM` (INOUT `GUIAREMP_Codigo` INT(11), IN `GUIAREMC_TipoOperacion` CHAR(1), IN `TIPOMOVP_Codigo` INT(11), IN `ALMAP_Codigo` INT(11), IN `USUA_Codigo` INT(11), IN `MONED_Codigo` INT(11), IN `DOCUP_Codigo` INT(11), IN `CLIP_Codigo` INT(11), IN `PROVP_Codigo` INT(11), IN `GUIAREMC_PersReceNombre` VARCHAR(150), IN `GUIAREMC_PersReceDNI` CHAR(8), IN `EMPRP_Codigo` INT(11), IN `GUIASAP_Codigo` INT(11), IN `GUIAINP_Codigo` INT(11), IN `PRESUP_Codigo` INT(11), IN `OCOMP_Codigo` INT(11), IN `GUIAREMC_OtroMotivo` VARCHAR(250), IN `GUIAREMC_Fecha` DATE, IN `GUIAREMC_NumeroRef` VARCHAR(50), IN `GUIAREMC_OCompra` VARCHAR(50), IN `GUIAREMC_Serie` VARCHAR(10), IN `GUIAREMC_Numero` VARCHAR(11), IN `GUIAREMC_CodigoUsuario` VARCHAR(50), IN `GUIAREMC_FechaTraslado` DATE, IN `GUIAREMC_PuntoPartida` VARCHAR(250), IN `GUIAREMC_PuntoLlegada` VARCHAR(250), IN `GUIAREMC_Observacion` TEXT, IN `GUIAREMC_Marca` VARCHAR(100), IN `GUIAREMC_Placa` VARCHAR(20), IN `GUIAREMC_RegistroMTC` VARCHAR(20), IN `GUIAREMC_Certificado` VARCHAR(100), IN `GUIAREMC_Licencia` VARCHAR(100), IN `GUIAREMC_NombreConductor` VARCHAR(150), IN `GUIAREMC_subtotal` DOUBLE(10,2), IN `GUIAREMC_descuento` DOUBLE(10,2), IN `GUIAREMC_igv` DOUBLE(10,2), IN `GUIAREMC_total` DOUBLE(10,2), IN `GUIAREMC_igv100` INT(11), IN `GUIAREMC_descuento100` INT(11), IN `COMPP_Codigo` INT(11), IN `GUIAREMC_FlagMueveStock` CHAR(1), IN `USUA_Anula` INT(11), IN `GUIAREMC_FechaRegistro` TIMESTAMP, IN `GUIAREMC_FechaModificacion` DATETIME, IN `GUIAREMC_FlagEstado` CHAR(1), IN `CPC_TipoOperacion` CHAR(1), IN `REALIZACION` INT, IN `USUARIO` INT, IN `FECHAINICIO` DATE, IN `FECHAFIN` DATE, IN `GUIAREMC_TipoGuia` INT(1), IN `GUIAREMC_NumeroAutomatico` INT)  BEGIN
	IF REALIZACION=0 THEN
		INSERT INTO cji_guiarem VALUES (
		0,
   		GUIAREMC_TipoOperacion,
   		TIPOMOVP_Codigo,
   		ALMAP_Codigo,
   		USUA_Codigo ,
   		MONED_Codigo,
   		DOCUP_Codigo,
   		CLIP_Codigo,
   		PROVP_Codigo,
   		GUIAREMC_PersReceNombre,
   		GUIAREMC_PersReceDNI,
   		EMPRP_Codigo,
   		GUIASAP_Codigo,
   		GUIAINP_Codigo,
   		PRESUP_Codigo,
   		OCOMP_Codigo,
   		GUIAREMC_OtroMotivo,
   		GUIAREMC_Fecha,
   		GUIAREMC_NumeroRef,
   		GUIAREMC_OCompra,
   		GUIAREMC_Serie,
   		GUIAREMC_Numero,
   		GUIAREMC_CodigoUsuario,
   		GUIAREMC_FechaTraslado,
   		GUIAREMC_PuntoPartida,
   		GUIAREMC_PuntoLlegada,
   		GUIAREMC_Observacion,
   		GUIAREMC_Marca,
   		GUIAREMC_Placa,
   		GUIAREMC_RegistroMTC,
   		GUIAREMC_Certificado,
   		GUIAREMC_Licencia,
   		GUIAREMC_NombreConductor,
   		GUIAREMC_subtotal,
   		GUIAREMC_descuento,
   		GUIAREMC_igv,
   		GUIAREMC_total,
   		GUIAREMC_igv100,
   		GUIAREMC_descuento100,
   		COMPP_Codigo,
   		GUIAREMC_FlagMueveStock,
   		USUA_Anula,
   		GUIAREMC_FechaRegistro,
   		GUIAREMC_FechaModificacion,
   		GUIAREMC_FlagEstado,
   		CPC_TipoOperacion,
        GUIAREMC_TipoGuia,
		GUIAREMC_NumeroAutomatico
			 );
         SET GUIAREMP_Codigo=last_insert_id();
	ELSEIF REALIZACION=1 THEN
		IF (GUIAREMP_Codigo IS NULL OR GUIAREMP_Codigo=0 ) THEN
        	SELECT "INGRESAR GUIAREMP_Codigo";
        ELSE	
			SET @SQLREALIZAR="UPDATE cji_guiarem gs SET ";

			IF (GUIAREMC_TipoOperacion IS NULL OR GUIAREMC_TipoOperacion=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMC_TipoOperacion=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMC_TipoOperacion);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (TIPOMOVP_Codigo IS NULL OR TIPOMOVP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.TIPOMOVP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TIPOMOVP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            

            IF (ALMAP_Codigo IS NULL OR ALMAP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.ALMAP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,ALMAP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            	
            IF (USUA_Codigo IS NULL OR USUA_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.USUA_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,USUA_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (MONED_Codigo IS NULL OR MONED_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.MONED_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,MONED_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (DOCUP_Codigo IS NULL OR DOCUP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.DOCUP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,DOCUP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (CLIP_Codigo IS NULL OR CLIP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CLIP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CLIP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (PROVP_Codigo IS NULL OR PROVP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROVP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROVP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (GUIAREMC_PersReceNombre IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMC_PersReceNombre='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMC_PersReceNombre);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (GUIAREMC_PersReceDNI IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMC_PersReceDNI='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMC_PersReceDNI);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;

            IF (EMPRP_Codigo IS NULL OR EMPRP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.EMPRP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,EMPRP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (GUIASAP_Codigo IS NULL OR GUIASAP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASAP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASAP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;

            IF (GUIAINP_Codigo IS NULL OR GUIAINP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (PRESUP_Codigo IS NULL OR PRESUP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PRESUP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PRESUP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (OCOMP_Codigo IS NULL OR OCOMP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.OCOMP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,OCOMP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;

            IF (GUIAREMC_OtroMotivo IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMC_OtroMotivo='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMC_OtroMotivo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (GUIAREMC_Fecha IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMC_Fecha='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMC_Fecha);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (GUIAREMC_NumeroRef IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMC_NumeroRef='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMC_NumeroRef);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (GUIAREMC_OCompra IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMC_OCompra='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMC_OCompra);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (GUIAREMC_Serie IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMC_Serie='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMC_Serie);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (GUIAREMC_Numero IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMC_Numero='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMC_Numero);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (GUIAREMC_CodigoUsuario IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMC_CodigoUsuario='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMC_CodigoUsuario);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (GUIAREMC_FechaTraslado IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMC_FechaTraslado='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMC_FechaTraslado);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (GUIAREMC_PuntoPartida IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMC_PuntoPartida='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMC_PuntoPartida);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (GUIAREMC_PuntoLlegada IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMC_PuntoLlegada='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMC_PuntoLlegada);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (GUIAREMC_Observacion IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMC_Observacion='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMC_Observacion);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (GUIAREMC_Marca IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMC_Marca='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMC_Marca);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (GUIAREMC_Placa IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMC_Placa='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMC_Placa);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (GUIAREMC_RegistroMTC IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMC_RegistroMTC='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMC_RegistroMTC);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (GUIAREMC_Certificado IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMC_Certificado='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMC_Certificado);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (GUIAREMC_Licencia IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMC_Licencia='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMC_Licencia);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (GUIAREMC_NombreConductor IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMC_NombreConductor='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMC_NombreConductor);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;

            IF (GUIAREMC_subtotal IS NULL OR GUIAREMC_subtotal=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMC_subtotal=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMC_subtotal);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (GUIAREMC_descuento IS NULL OR GUIAREMC_descuento=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMC_descuento=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMC_descuento);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (GUIAREMC_igv IS NULL OR GUIAREMC_igv=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMC_igv=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMC_igv);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;

            IF (GUIAREMC_total IS NULL OR GUIAREMC_total=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMC_total=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMC_total);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (GUIAREMC_igv100 IS NULL OR GUIAREMC_igv100=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMC_igv100=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMC_igv100);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (GUIAREMC_descuento100 IS NULL OR GUIAREMC_descuento100=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMC_descuento100=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMC_descuento100);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;

            IF (COMPP_Codigo IS NULL OR COMPP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.COMPP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,COMPP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            
            IF (GUIAREMC_FlagMueveStock IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMC_FlagMueveStock='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMC_FlagMueveStock);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            
            IF (USUA_Anula IS NULL OR USUA_Anula=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.USUA_Anula=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,USUA_Anula);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
          

            
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMC_FechaModificacion='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,NOW());
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
           
            
            IF (GUIAREMC_FlagEstado IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMC_FlagEstado='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMC_FlagEstado);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");        
            END IF;
			
			IF (GUIAREMC_NumeroAutomatico IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMC_NumeroAutomatico=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMC_NumeroAutomatico);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");        
            END IF;
			
			
            
            SET @SQLREALIZAR=SUBSTRING(@SQLREALIZAR,1,CHARACTER_LENGTH(@SQLREALIZAR)-1);
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.GUIAREMP_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMP_Codigo);
            
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;
    ELSEIF REALIZACION=2 THEN
   		IF (GUIAREMP_Codigo IS NULL OR GUIAREMP_Codigo=0) THEN
        	SELECT "INGRESAR GUIAREMP_Codigo";
        ELSE
            SET @SQLREALIZAR="UPDATE cji_guiarem gs SET ";
            IF (GUIAREMC_FlagEstado IS NULL OR TRIM(GUIAREMC_FlagEstado)='')  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMC_FlagEstado='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(GUIAREMC_FlagEstado));
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMC_FechaModificacion='");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,NOW());
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.GUIAREMP_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMP_Codigo);
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;

    ELSEIF REALIZACION=3 THEN     
        IF (GUIAREMP_Codigo IS NULL OR GUIAREMP_Codigo=0 ) THEN
        	SELECT "INGRESAR GUIAREMP_Codigo";
        ELSE
            SELECT  gs.GUIAREMP_Codigo AS GUIAREMP_Codigo,
   		gs.GUIAREMC_TipoOperacion AS GUIAREMC_TipoOperacion,
   		gs.TIPOMOVP_Codigo AS TIPOMOVP_Codigo,
   		gs.ALMAP_Codigo AS ALMAP_Codigo,
   		gs.USUA_Codigo AS USUA_Codigo ,
   		gs.MONED_Codigo AS MONED_Codigo,
   		gs.DOCUP_Codigo AS DOCUP_Codigo,
   		gs.CLIP_Codigo AS CLIP_Codigo,
   		gs.PROVP_Codigo AS PROVP_Codigo,
   		gs.GUIAREMC_PersReceNombre AS GUIAREMC_PersReceNombre,
   		gs.GUIAREMC_PersReceDNI AS GUIAREMC_PersReceDNI,
   		gs.EMPRP_Codigo AS EMPRP_Codigo,
   		gs.GUIASAP_Codigo AS GUIASAP_Codigo,
   		gs.GUIAINP_Codigo AS GUIAINP_Codigo,
   		gs.PRESUP_Codigo AS PRESUP_Codigo,
   		gs.OCOMP_Codigo AS OCOMP_Codigo,
   		gs.GUIAREMC_OtroMotivo AS GUIAREMC_OtroMotivo,
   		gs.GUIAREMC_Fecha AS GUIAREMC_Fecha,
   		gs.GUIAREMC_NumeroRef AS GUIAREMC_NumeroRef,
   		gs.GUIAREMC_OCompra AS GUIAREMC_OCompra,
   		gs.GUIAREMC_Serie AS GUIAREMC_Serie,
   		gs.GUIAREMC_Numero AS GUIAREMC_Numero,
   		gs.GUIAREMC_CodigoUsuario AS GUIAREMC_CodigoUsuario,
   		gs.GUIAREMC_FechaTraslado AS GUIAREMC_FechaTraslado,
   		gs.GUIAREMC_PuntoPartida AS GUIAREMC_PuntoPartida,
   		gs.GUIAREMC_PuntoLlegada AS GUIAREMC_PuntoLlegada,
   		gs.GUIAREMC_Observacion AS GUIAREMC_Observacion,
   		gs.GUIAREMC_Marca AS GUIAREMC_Marca,
   		gs.GUIAREMC_Placa AS GUIAREMC_Placa,
   		gs.GUIAREMC_RegistroMTC AS GUIAREMC_RegistroMTC,
   		gs.GUIAREMC_Certificado AS GUIAREMC_Certificado,
   		gs.GUIAREMC_Licencia AS GUIAREMC_Licencia,
   		gs.GUIAREMC_NombreConductor AS GUIAREMC_NombreConductor,
   		gs.GUIAREMC_subtotal AS GUIAREMC_subtotal,
   		gs.GUIAREMC_descuento AS GUIAREMC_descuento,
   		gs.GUIAREMC_igv AS GUIAREMC_igv,
   		gs.GUIAREMC_total AS GUIAREMC_total,
   		gs.GUIAREMC_igv100 AS GUIAREMC_igv100,
   		gs.GUIAREMC_descuento100 AS GUIAREMC_descuento100,
   		gs.COMPP_Codigo AS COMPP_Codigo,
   		gs.GUIAREMC_FlagMueveStock AS GUIAREMC_FlagMueveStock,
   		gs.USUA_Anula AND USUA_Anula,
   		gs.GUIAREMC_FechaRegistro AS GUIAREMC_FechaRegistro,
   		gs.GUIAREMC_FechaModificacion AS GUIAREMC_FechaModificacion,
   		gs.GUIAREMC_FlagEstado AS GUIAREMC_FlagEstado,
   		gs.CPC_TipoOperacion AS CPC_TipoOperacion
            FROM cji_guiarem gs
            WHERE gs.GUIAREMP_Codigo=GUIAREMP_Codigo;
     	END IF;
    ELSEIF REALIZACION=4 THEN  
			SET @SQLREALIZAR="SELECT \r\n\t\t\t\t\tgs.GUIAREMP_Codigo AS GUIAREMP_Codigo,\r\n   \t\tgs.GUIAREMC_TipoOperacion AS GUIAREMC_TipoOperacion,\r\n   \t\tgs.TIPOMOVP_Codigo AS TIPOMOVP_Codigo,\r\n   \t\tgs.ALMAP_Codigo AS ALMAP_Codigo,\r\n   \t\tgs.USUA_Codigo AS USUA_Codigo ,\r\n   \t\tgs.MONED_Codigo AS,MONED_Codigo\r\n   \t\tgs.DOCUP_Codigo AS DOCUP_Codigo,\r\n   \t\tgs.CLIP_Codigo AS CLIP_Codigo,\r\n   \t\tgs.PROVP_Codigo AS PROVP_Codigo,\r\n   \t\tgs.GUIAREMC_PersReceNombre AS GUIAREMC_PersReceNombre,\r\n   \t\tgs.GUIAREMC_PersReceDNI AS GUIAREMC_PersReceDNI,\r\n   \t\tgs.EMPRP_Codigo AS EMPRP_Codigo,\r\n   \t\tgs.GUIASAP_Codigo AS GUIASAP_Codigo,\r\n   \t\tgs.GUIAINP_Codigo AS GUIAINP_Codigo,\r\n   \t\tgs.PRESUP_Codigo AS PRESUP_Codigo,\r\n   \t\tgs.OCOMP_Codigo AS OCOMP_Codigo,\r\n   \t\tgs.GUIAREMC_OtroMotivo AS GUIAREMC_OtroMotivo,\r\n   \t\tgs.GUIAREMC_Fecha AS GUIAREMC_Fecha,\r\n   \t\tgs.GUIAREMC_NumeroRef AS GUIAREMC_NumeroRef,\r\n   \t\tgs.GUIAREMC_OCompra AS GUIAREMC_OCompra,\r\n   \t\tgs.GUIAREMC_Serie AS GUIAREMC_Serie,\r\n   \t\tgs.GUIAREMC_Numero AS GUIAREMC_Numero,\r\n   \t\tgs.GUIAREMC_CodigoUsuario AS GUIAREMC_CodigoUsuario,\r\n   \t\tgs.GUIAREMC_FechaTraslado AS GUIAREMC_FechaTraslado,\r\n   \t\tgs.GUIAREMC_PuntoPartida AS GUIAREMC_PuntoPartida,\r\n   \t\tgs.GUIAREMC_PuntoLlegada AS GUIAREMC_PuntoLlegada,\r\n   \t\tgs.GUIAREMC_Observacion AS GUIAREMC_Observacion,\r\n   \t\tgs.GUIAREMC_Marca AS GUIAREMC_Marca,\r\n   \t\tgs.GUIAREMC_Placa AS GUIAREMC_Placa,\r\n   \t\tgs.GUIAREMC_RegistroMTC AS GUIAREMC_RegistroMTC,\r\n   \t\tgs.GUIAREMC_Certificado AS GUIAREMC_Certificado,\r\n   \t\tgs.GUIAREMC_Licencia AS GUIAREMC_Licencia\r\n   \t\tgs.GUIAREMC_NombreConductor AS GUIAREMC_NombreConductor,\r\n   \t\tgs.GUIAREMC_subtotal AS GUIAREMC_subtotal,\r\n   \t\tgs.GUIAREMC_descuento AS GUIAREMC_descuento,\r\n   \t\tgs.GUIAREMC_igv AS GUIAREMC_igv,\r\n   \t\tgs.GUIAREMC_total AS GUIAREMC_total,\r\n   \t\tgs.GUIAREMC_igv100 AS GUIAREMC_igv100,\r\n   \t\tgs.GUIAREMC_descuento100 AS GUIAREMC_descuento100,\r\n   \t\tgs.COMPP_Codigo AS COMPP_Codigo,\r\n   \t\tgs.GUIAREMC_FlagMueveStock AS GUIAREMC_FlagMueveStock,\r\n   \t\tgs.USUA_Anula AND USUA_Anula,\r\n   \t\tgs.GUIAREMC_FechaRegistro AS GUIAREMC_FechaRegistro,\r\n   \t\tgs.GUIAREMC_FechaModificacion AS GUIAREMC_FechaModificacion,\r\n   \t\tgs.GUIAREMC_FlagEstado AS GUIAREMC_FlagEstado,\r\n   \t\tgs.CPC_TipoOperacion AS CPC_TipoOperacion\r\n\t\t\tFROM cji_guiarem gs\r\n\t\t\tWHERE gs.GUIAREMP_Codigo !=0 ";
			
			IF (GUIAREMC_TipoOperacion IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
            	SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMC_TipoOperacion='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMC_TipoOperacion);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;
            
            
            
            IF (GUIAREMC_FlagEstado IS NULL)  THEN
            	SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
			ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMC_FlagEstado='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMC_FlagEstado);
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
				
            END IF;  
			
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," ORDER BY gs.GUIAREMP_Codigo=");
            
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
		
END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MANTENIMIENTO_GUIAREMDETALLE` (IN `GUIAREMDETP_Codigo` INT(11), IN `RODCTOP_Codigo` INT(11), IN `UNDMED_Codigo` INT(11), IN `GUIAREMP_Codigo` INT(11), IN `GUIAREMDETC_GenInd` CHAR(1), IN `GUIAREMDETC_Cantidad` VARCHAR(45), IN `GUIAREMDETC_Pu` DOUBLE, IN `GUIAREMDETC_Subtotal` DOUBLE, IN `GUIAREMDETC_Descuento` DOUBLE, IN `GUIAREMDETC_Igv` DOUBLE, IN `GUIAREMDETC_Total` DOUBLE, IN `GUIAREMDETC_Pu_ConIgv` DOUBLE, IN `GUIAREMDETC_Igv100` INT(11), IN `GUIAREMDETC_Descuento100` INT(11), IN `GUIAREMDETC_Costo` DOUBLE, IN `GUIAREMDETC_Venta` DOUBLE, IN `GUIAREMDETC_Peso` DOUBLE, IN `GUIAREMDETC_Descripcion` VARCHAR(250), IN `GUIAREMDETC_DireccionEntrega` VARCHAR(250), IN `GUIAREMDETC_FechaRegistro` TIMESTAMP, IN `GUIAREMDET_FechaModificacion` DATETIME, IN `GUIAREMDETC_FlagEstado` CHAR(1), IN `REALIZACION` INT, IN `USUARIO` INT, IN `FECHAINICIO` DATE, IN `FECHAFIN` DATE, IN `ALMAP_Codigo` INT(11))  BEGIN
	IF REALIZACION=0 THEN
		INSERT INTO cji_guiaremdetalle VALUES (
		0,
  		RODCTOP_Codigo,
  		UNDMED_Codigo,
  		GUIAREMP_Codigo,
  		GUIAREMDETC_GenInd,
  		GUIAREMDETC_Cantidad,
  		GUIAREMDETC_Pu,
  		GUIAREMDETC_Subtotal,
  		GUIAREMDETC_Descuento,
  		GUIAREMDETC_Igv,
  		GUIAREMDETC_Total,
  		GUIAREMDETC_Pu_ConIgv,
  		GUIAREMDETC_Igv100,
  		GUIAREMDETC_Descuento100,
  		GUIAREMDETC_Costo,
  		GUIAREMDETC_Venta,
  		GUIAREMDETC_Peso,
  		GUIAREMDETC_Descripcion,
  		GUIAREMDETC_DireccionEntrega,
  		GUIAREMDETC_FechaRegistro,
  		GUIAREMDET_FechaModificacion,
  		GUIAREMDETC_FlagEstado,
        ALMAP_Codigo
		 );
		
	ELSEIF REALIZACION=1 THEN
		IF (GUIAREMDETP_Codigo IS NULL OR GUIAREMDETP_Codigo=0 ) THEN
        	SELECT "INGRESAR GUIAREMDETP_Codigo";
        ELSE	
			SET @SQLREALIZAR="UPDATE cji_guiaremdetalle gs SET ";

			IF (GUIAREMDETP_Codigo IS NULL OR GUIAREMDETP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMDETP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMDETP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;	
            
            IF (RODCTOP_Codigo IS NULL OR RODCTOP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.RODCTOP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,RODCTOP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;	
            
            IF (UNDMED_Codigo IS NULL OR UNDMED_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.UNDMED_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,UNDMED_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
            
            IF (GUIAREMP_Codigo IS NULL OR GUIAREMP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
			
			IF (GUIAREMDETC_GenInd IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMDETC_GenInd='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMDETC_GenInd);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"', ");
            END IF;
            
            IF (GUIAREMDETC_Cantidad IS NULL OR GUIAREMDETC_Cantidad=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMDETC_Cantidad=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMDETC_Cantidad);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;

            IF (GUIAREMDETC_Pu IS NULL OR GUIAREMDETC_Pu=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMDETC_Pu=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMDETC_Pu);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
            
            IF (GUIAREMDETC_Subtotal IS NULL OR GUIAREMDETC_Subtotal=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMDETC_Subtotal=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMDETC_Subtotal);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
            
            IF (GUIAREMDETC_Descuento IS NULL OR GUIAREMDETC_Descuento=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMDETC_Descuento=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMDETC_Descuento);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;

            IF (GUIAREMDETC_Igv IS NULL OR GUIAREMDETC_Igv=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMDETC_Igv=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMDETC_Igv);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
            
            IF (GUIAREMDETC_Total IS NULL OR GUIAREMDETC_Total=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMDETC_Total=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMDETC_Total);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
            
            IF (GUIAREMDETC_Pu_ConIgv IS NULL OR GUIAREMDETC_Pu_ConIgv=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMDETC_Pu_ConIgv=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMDETC_Pu_ConIgv);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;

            IF (GUIAREMDETC_Igv100 IS NULL OR GUIAREMDETC_Igv100=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMDETC_Igv100=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMDETC_Igv100);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
            
            IF (GUIAREMDETC_Descuento100 IS NULL OR GUIAREMDETC_Descuento100=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMDETC_Descuento100=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMDETC_Descuento100);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;

            IF (GUIAREMDETC_Costo IS NULL OR GUIAREMDETC_Costo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMDETC_Costo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMDETC_Costo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
            
            IF (GUIAREMDETC_Venta IS NULL OR GUIAREMDETC_Venta=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMDETC_Venta=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMDETC_Venta);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
            
            IF (GUIAREMDETC_Peso IS NULL OR GUIAREMDETC_Peso=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMDETC_Peso=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMDETC_Peso);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
            
            IF (GUIAREMDETC_Descripcion IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMDETC_Descripcion='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMDETC_Descripcion);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"', ");
            END IF;
            
            IF (GUIAREMDETC_DireccionEntrega IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMDETC_DireccionEntrega='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMDETC_DireccionEntrega);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"', ");
            END IF;
            
            IF (GUIAREMDETC_FechaRegistro IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMDETC_FechaRegistro='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMDETC_FechaRegistro);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"', ");
            END IF;
            
            IF (GUIAREMDET_FechaModificacion IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMDET_FechaModificacion='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMDET_FechaModificacion);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"', ");
            END IF;
            
            IF (GUIAREMDETC_FlagEstado IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMDETC_FlagEstado='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMDETC_FlagEstado);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"', ");
            END IF;


			SET @SQLREALIZAR=SUBSTRING(@SQLREALIZAR,1,CHARACTER_LENGTH(@SQLREALIZAR)-1);
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.GUIAREMDETP_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMDETP_Codigo);
            
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;

	ELSEIF REALIZACION=2 THEN
   		IF (GUIAREMDETP_Codigo IS NULL OR GUIAREMDETP_Codigo=0 ) THEN
        	SELECT "INGRESAR GUIAREMDETP_Codigo";
        ELSE
            SET @SQLREALIZAR="UPDATE cji_guiaremdetalle gs SET ";
            IF (GUIAREMDETC_FlagEstado IS NULL OR TRIM(GUIAREMDETC_FlagEstado)='')  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMDETC_FlagEstado='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(GUIAREMDETC_FlagEstado));
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMDET_FechaModificacion='");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,NOW());
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.GUIAREMDETP_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMDETP_Codigo);
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;
		
		ELSEIF REALIZACION=3 THEN     
        IF (GUIAREMDETP_Codigo IS NULL OR GUIAREMDETP_Codigo=0 ) THEN
        	SELECT "INGRESAR GUIAREMDETP_Codigo";
        ELSE
            SELECT  gs.GUIAREMDETP_Codigo AS GUIAREMDETP_Codigo,
  					gs.RODCTOP_Codigo AS RODCTOP_Codigo,
  					gs.UNDMED_Codigo AS UNDMED_Codigo,
  					gs.GUIAREMP_Codigo AS GUIAREMP_Codigo,
  					gs.GUIAREMDETC_GenInd AS GUIAREMDETC_GenInd,
  					gs.GUIAREMDETC_Cantidad AS GUIAREMDETC_Cantidad,
  					gs.GUIAREMDETC_Pu AS GUIAREMDETC_Pu,
  					gs.GUIAREMDETC_Subtotal AS GUIAREMDETC_Subtotal,
  					gs.GUIAREMDETC_Descuento AS GUIAREMDETC_Descuento,
  					gs.GUIAREMDETC_Igv AS GUIAREMDETC_Igv,
  					gs.GUIAREMDETC_Total AS GUIAREMDETC_Total,
  					gs.GUIAREMDETC_Pu_ConIgv AS GUIAREMDETC_Pu_ConIgv,
  					gs.GUIAREMDETC_Igv100 AS GUIAREMDETC_Igv100,
  					gs.GUIAREMDETC_Descuento100 AS GUIAREMDETC_Descuento100,
  					gs.GUIAREMDETC_Costo AS GUIAREMDETC_Costo,
  					gs.GUIAREMDETC_Venta AS GUIAREMDETC_Venta,
  					gs.GUIAREMDETC_Peso AS GUIAREMDETC_Peso,
  					gs.GUIAREMDETC_Descripcion AS GUIAREMDETC_Descripcion,
  					gs.GUIAREMDETC_DireccionEntrega AS GUIAREMDETC_DireccionEntrega,
  					gs.GUIAREMDETC_FechaRegistro AS GUIAREMDETC_FechaRegistro,
  					gs.GUIAREMDET_FechaModificacion AS GUIAREMDET_FechaModificacion,
  					gs.GUIAREMDETC_FlagEstado AS GUIAREMDETC_FlagEstado 
            FROM cji_guiaremdetalle gs
            WHERE gs.GUIAREMDETP_Codigo=GUIAREMDETP_Codigo;
     	END IF;  
		ELSEIF REALIZACION=4 THEN  
			SET @SQLREALIZAR="SELECT \r\n\t\t\t\t\tgs.GUIAREMDETP_Codigo,\r\n  \t\t\t\t\tgs.RODCTOP_Codigo,\r\n  \t\t\t\t\tgs.UNDMED_Codigo,\r\n  \t\t\t\t\tgs.GUIAREMP_Codigo,\r\n  \t\t\t\t\tgs.GUIAREMDETC_GenInd,\r\n  \t\t\t\t\tgs.GUIAREMDETC_Cantidad,\r\n  \t\t\t\t\tgs.GUIAREMDETC_Pu,\r\n  \t\t\t\t\tgs.GUIAREMDETC_Subtotal,\r\n  \t\t\t\t\tgs.GUIAREMDETC_Descuento,\r\n  \t\t\t\t\tgs.GUIAREMDETC_Igv,\r\n  \t\t\t\t\tgs.GUIAREMDETC_Total,\r\n  \t\t\t\t\tgs.GUIAREMDETC_Pu_ConIgv,\r\n  \t\t\t\t\tgs.GUIAREMDETC_Igv100,\r\n  \t\t\t\t\tgs.GUIAREMDETC_Descuento100,\r\n  \t\t\t\t\tgs.GUIAREMDETC_Costo,\r\n  \t\t\t\t\tgs.GUIAREMDETC_Venta,\r\n  \t\t\t\t\tgs.GUIAREMDETC_Peso,\r\n  \t\t\t\t\tgs.GUIAREMDETC_Descripcion,\r\n  \t\t\t\t\tgs.GUIAREMDETC_DireccionEntrega,\r\n  \t\t\t\t\tgs.GUIAREMDETC_FechaRegistro,\r\n  \t\t\t\t\tgs.GUIAREMDET_FechaModificacion,\r\n  \t\t\t\t\tgs.GUIAREMDETC_FlagEstado\r\n\t\t\tFROM cji_guiaremdetalle gs\r\n\t\t\tWHERE gs.GUIAREMDETC_FlagEstado !=0 ";
			
			IF (GUIAREMDETP_Codigo IS NULL OR GUIAREMDETP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMDETP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMDETP_Codigo);
            END IF;
			
			IF (RODCTOP_Codigo IS NULL OR RODCTOP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.RODCTOP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,RODCTOP_Codigo);
            END IF;
			
			IF (UNDMED_Codigo IS NULL OR UNDMED_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.UNDMED_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,UNDMED_Codigo);
            END IF;
			
			IF (GUIAREMP_Codigo IS NULL OR GUIAREMP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMP_Codigo);
            END IF;

            IF (GUIAREMDETC_GenInd IS NULL OR GUIAREMDETC_GenInd=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMDETC_GenInd=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAREMDETC_GenInd);
            END IF;
			
			IF (FECHAINICIO IS NULL OR TRIM(FECHAINICIO)='0000-00-00' )   THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMDETC_FechaRegistro>='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAINICIO);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
            IF (FECHAFIN IS NULL OR TRIM(FECHAFIN)='0000-00-00')  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAREMDETC_FechaRegistro<='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAFIN);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
			
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," ORDER BY gs.GUIAREMDETP_Codigo=");
            
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
		
END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MANTENIMIENTO_GUIASA` (INOUT `GUIASAP_Codigo` INT(11), IN `TIPOMOVP_Codigo` INT(11), IN `GUIASAC_TipoOperacion` CHAR(1), IN `ALMAP_Codigo` INT(11), IN `USUA_Codigo` INT(11), IN `CLIP_Codigo` INT(11), IN `PROVP_Codigo` INT(11), IN `DOCUP_Codigo` INT(11), IN `GUIASAC_Fecha` DATE, IN `GUIASAC_Numero` VARCHAR(10), IN `GUIASAC_Observacion` VARCHAR(45), IN `GUIASAC_MarcaPlaca` VARCHAR(100), IN `GUIASAC_Certificado` VARCHAR(100), IN `GUIASAC_Licencia` VARCHAR(100), IN `GUIASAC_RucTransportista` CHAR(11), IN `GUIASAC_NombreTransportista` VARCHAR(150), IN `GUIASAC_FechaRegistro` TIMESTAMP, IN `GUIASAC_FechaModificacion` DATETIME, IN `GUIASAC_Automatico` INT(11), IN `GUIASAC_FlagEstado` CHAR(1), IN `REALIZACION` INT, IN `USUARIO` INT, IN `FECHAINICIO` DATE, IN `FECHAFIN` DATE)  BEGIN
	
   IF REALIZACION=0 THEN
     INSERT INTO cji_guiasa VALUES ( 
           	0,
  			TIPOMOVP_Codigo,
  			GUIASAC_TipoOperacion,
  			ALMAP_Codigo,
  			USUA_Codigo,
  			CLIP_Codigo,
  			PROVP_Codigo,
  			DOCUP_Codigo,
  			GUIASAC_Fecha,
  			GUIASAC_Numero,
  			GUIASAC_Observacion,
  			GUIASAC_MarcaPlaca,
  			GUIASAC_Certificado,
  			GUIASAC_Licencia,
  			GUIASAC_RucTransportista,
  			GUIASAC_NombreTransportista,
  			CURDATE(),
  			GUIASAC_FechaModificacion,
  			GUIASAC_Automatico,
  			GUIASAC_FlagEstado
     );
   SET GUIASAP_Codigo=last_insert_id();
   ELSEIF REALIZACION=1 THEN
		IF (GUIASAP_Codigo IS NULL OR GUIASAP_Codigo=0 ) THEN
        	SELECT "INGRESAR GUIASAP_Codigo";
        ELSE	
            SET @SQLREALIZAR="UPDATE cji_guiasa gs SET ";


            IF (TIPOMOVP_Codigo IS NULL OR TIPOMOVP_Codigo=0 ) THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.TIPOMOVP_Codigo=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TIPOMOVP_Codigo);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;

            IF (GUIASAC_TipoOperacion IS NULL OR TRIM(GUIASAC_TipoOperacion)='' ) THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASAC_TipoOperacion='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASAC_TipoOperacion);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;


            IF (ALMAP_Codigo IS NULL OR ALMAP_Codigo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.ALMAP_Codigo=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,ALMAP_Codigo);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;


            IF (USUA_Codigo IS NULL OR USUA_Codigo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.USUA_Codigo=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,USUA_Codigo);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;   


            IF (CLIP_Codigo IS NULL OR CLIP_Codigo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CLIP_Codigo=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CLIP_Codigo);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;  


            IF (PROVP_Codigo IS NULL OR PROVP_Codigo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROVP_Codigo=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROVP_Codigo);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;    		


            IF (DOCUP_Codigo IS NULL OR DOCUP_Codigo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.DOCUP_Codigo=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,DOCUP_Codigo);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;    		


            IF (GUIASAC_Fecha IS NULL)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASAC_Fecha='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASAC_Fecha);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;   


            IF (GUIASAC_Numero IS NULL OR TRIM(GUIASAC_Numero)="")  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASAC_Numero='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASAC_Numero);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;   


            IF (GUIASAC_Observacion IS NULL OR TRIM(GUIASAC_Observacion)="")  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASAC_Observacion='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASAC_Observacion);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;   


            IF (GUIASAC_MarcaPlaca IS NULL OR TRIM(GUIASAC_MarcaPlaca)="")  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASAC_MarcaPlaca='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASAC_MarcaPlaca);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;   


            IF (GUIASAC_Certificado IS NULL OR TRIM(GUIASAC_Certificado)="")  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASAC_Certificado='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASAC_Certificado);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF; 


            IF (GUIASAC_Licencia IS NULL OR TRIM(GUIASAC_Licencia)="")  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASAC_Licencia='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASAC_Licencia);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF; 


            IF (GUIASAC_RucTransportista IS NULL OR TRIM(GUIASAC_RucTransportista)="")  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASAC_RucTransportista='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASAC_RucTransportista);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF; 


            IF (GUIASAC_NombreTransportista IS NULL OR TRIM(GUIASAC_NombreTransportista)="")  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASAC_NombreTransportista='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASAC_NombreTransportista);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;


             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASAC_FechaModificacion='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CURDATE());
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");


            IF (GUIASAC_Automatico IS NULL OR GUIASAC_Automatico=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASAC_Automatico=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASAC_Automatico);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;


            IF (GUIASAC_FlagEstado IS NULL OR TRIM(GUIASAC_FlagEstado)='')  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASAC_FlagEstado='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASAC_FlagEstado);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;


            SET @SQLREALIZAR=SUBSTRING(@SQLREALIZAR,1,CHARACTER_LENGTH(@SQLREALIZAR)-1);
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.GUIASAP_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASAP_Codigo);

            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;
    
   ELSEIF REALIZACION=2 THEN
   		IF (GUIASAP_Codigo IS NULL OR GUIASAP_Codigo=0 ) THEN
        	SELECT "INGRESAR GUIASAP_Codigo";
        ELSE
            SET @SQLREALIZAR="UPDATE cji_guiasa gs SET ";
            IF (GUIASAC_FlagEstado IS NULL OR TRIM(GUIASAC_FlagEstado)='')  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASAC_FlagEstado='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(GUIASAC_FlagEstado));
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;

            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASAC_FechaModificacion='");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CURDATE());
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");

            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.GUIASAP_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASAP_Codigo);

            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;
        
        
    ELSEIF REALIZACION=3 THEN     
        IF (GUIASAP_Codigo IS NULL OR GUIASAP_Codigo=0 ) THEN
        	SELECT "INGRESAR GUIASAP_Codigo";
        ELSE
            SELECT 
                gs.GUIASAP_Codigo AS GUIASAP_Codigo,
                gs.TIPOMOVP_Codigo AS TIPOMOVP_Codigo,
                gs.GUIASAC_TipoOperacion AS GUIASAC_TipoOperacion,
                gs.ALMAP_Codigo AS ALMAP_Codigo ,
                gs.USUA_Codigo AS USUA_Codigo,
                gs.CLIP_Codigo AS CLIP_Codigo,
                gs.PROVP_Codigo AS PROVP_Codigo,
                gs.DOCUP_Codigo AS DOCUP_Codigo,
                gs.GUIASAC_Fecha AS GUIASAC_Fecha,
                gs.GUIASAC_Numero AS GUIASAC_Numero,
                gs.GUIASAC_Observacion AS GUIASAC_Observacion,
                gs.GUIASAC_MarcaPlaca AS GUIASAC_MarcaPlaca,
                gs.GUIASAC_Certificado AS GUIASAC_Certificado,
                gs.GUIASAC_Licencia AS GUIASAC_Licencia,
                gs.GUIASAC_RucTransportista AS GUIASAC_RucTransportista,
                gs.GUIASAC_NombreTransportista AS GUIASAC_NombreTransportista,
                gs.GUIASAC_FechaRegistro AS GUIASAC_FechaRegistro,
                gs.GUIASAC_FechaModificacion AS GUIASAC_FechaModificacion,
                gs.GUIASAC_Automatico As GUIASAC_Automatico,
                gs.GUIASAC_FlagEstado AS GUIASAC_FlagEstado

            FROM cji_guiasa gs
            WHERE gs.GUIASAP_Codigo=GUIASAP_Codigo;
     	END IF;  
        
        
         ELSEIF REALIZACION=4 THEN     
         
             SET @SQLREALIZAR="SELECT                gs.GUIASAP_Codigo AS GUIASAP_Codigo,               gs.TIPOMOVP_Codigo AS TIPOMOVP_Codigo,              gs.GUIASAC_TipoOperacion AS GUIASAC_TipoOperacion,               gs.ALMAP_Codigo AS ALMAP_Codigo ,                gs.USUA_Codigo AS USUA_Codigo,                gs.CLIP_Codigo AS CLIP_Codigo,                gs.PROVP_Codigo AS PROVP_Codigo,              gs.DOCUP_Codigo AS DOCUP_Codigo,               gs.GUIASAC_Fecha AS GUIASAC_Fecha,               gs.GUIASAC_Numero AS GUIASAC_Numero,              gs.GUIASAC_Observacion AS GUIASAC_Observacion,               gs.GUIASAC_MarcaPlaca AS GUIASAC_MarcaPlaca,                gs.GUIASAC_Certificado AS GUIASAC_Certificado,               gs.GUIASAC_Licencia AS GUIASAC_Licencia,                gs.GUIASAC_RucTransportista AS GUIASAC_RucTransportista,               gs.GUIASAC_NombreTransportista AS GUIASAC_NombreTransportista,             gs.GUIASAC_FechaRegistro AS GUIASAC_FechaRegistro,                gs.GUIASAC_FechaModificacion AS GUIASAC_FechaModificacion,                gs.GUIASAC_Automatico As GUIASAC_Automatico,               gs.GUIASAC_FlagEstado AS GUIASAC_FlagEstado            FROM cji_guiasa gs WHERE gs.GUIASAC_FlagEstado !=0 ";


            IF (TIPOMOVP_Codigo IS NULL OR TIPOMOVP_Codigo=0 ) THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.TIPOMOVP_Codigo=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TIPOMOVP_Codigo);
            END IF;

            IF (GUIASAC_TipoOperacion IS NULL OR TRIM(GUIASAC_TipoOperacion)='' ) THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASAC_TipoOperacion='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASAC_TipoOperacion);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;


            IF (ALMAP_Codigo IS NULL OR ALMAP_Codigo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.ALMAP_Codigo=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,ALMAP_Codigo);
            END IF;


            IF (USUA_Codigo IS NULL OR USUA_Codigo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.USUA_Codigo=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,USUA_Codigo);
            END IF;   


            IF (CLIP_Codigo IS NULL OR CLIP_Codigo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CLIP_Codigo=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CLIP_Codigo);
            END IF;  


            IF (PROVP_Codigo IS NULL OR PROVP_Codigo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROVP_Codigo=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROVP_Codigo);
            END IF;    		


            IF (DOCUP_Codigo IS NULL OR DOCUP_Codigo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.DOCUP_Codigo=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,DOCUP_Codigo);
            END IF;    		


             IF (FECHAINICIO IS NULL OR TRIM(FECHAINICIO)='0000-00-00')  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASAC_Fecha>='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAINICIO);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;   
            
            
            IF (FECHAFIN IS NULL OR TRIM(FECHAFIN)='0000-00-00')  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASAC_Fecha<='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAFIN);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  


            IF (GUIASAC_Numero IS NULL OR TRIM(GUIASAC_Numero)="")  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");	
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASAC_Numero='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASAC_Numero);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;   


            IF (GUIASAC_MarcaPlaca IS NULL OR TRIM(GUIASAC_MarcaPlaca)="")  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASAC_MarcaPlaca='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASAC_MarcaPlaca);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;   


            IF (GUIASAC_Certificado IS NULL OR TRIM(GUIASAC_Certificado)="")  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASAC_Certificado='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASAC_Certificado);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF; 


            IF (GUIASAC_Licencia IS NULL OR TRIM(GUIASAC_Licencia)="")  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASAC_Licencia='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASAC_Licencia);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"'");
            END IF; 


            IF (GUIASAC_RucTransportista IS NULL OR TRIM(GUIASAC_RucTransportista)="")  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASAC_RucTransportista='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASAC_RucTransportista);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF; 


            IF (GUIASAC_NombreTransportista IS NULL OR TRIM(GUIASAC_NombreTransportista)="")  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"UPPER(gs.GUIASAC_NombreTransportista) LIKE '%");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,UPPER(GUIASAC_NombreTransportista));
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," %' ");
            END IF;


            IF (GUIASAC_Automatico IS NULL OR GUIASAC_Automatico=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASAC_Automatico=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASAC_Automatico);
            END IF;


          

            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," ORDER BY gs.GUIASAP_Codigo");

            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
     	
        
        
        
   END IF;
   
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MANTENIMIENTO_GUIASADETALLE` (IN `GUIASADETP_Codigo` INT(11), IN `GUIASAP_Codigo` INT(11), IN `PRODCTOP_Codigo` INT(11), IN `UNDMED_Codigo` INT(11), IN `GUIASADETC_GenInd` CHAR(1), IN `GUIASADETC_Cantidad` DOUBLE, IN `GUIASADETC_Costo` DOUBLE, IN `GUIASADETC_Descripcion` VARCHAR(300), IN `GUIASADETC_FechaRegistro` TIMESTAMP, IN `GUIASADET_FechaModificacion` DATETIME, IN `GUIASADETC_FlagEstado` CHAR(1), IN `REALIZACION` INT, IN `USUARIO` INT, IN `FECHAINICIO` DATE, IN `FECHAFIN` DATE, IN `ALMAP_Codigo` INT(11))  BEGIN
   IF REALIZACION=0 THEN
     INSERT INTO cji_guiasadetalle VALUES (   
			0,
			GUIASAP_Codigo,
			PRODCTOP_Codigo,
			UNDMED_Codigo ,
			GUIASADETC_GenInd,
		    GUIASADETC_Cantidad,
		    GUIASADETC_Costo,
		    GUIASADETC_Descripcion,
		    GUIASADETC_FechaRegistro,
		    GUIASADET_FechaModificacion,
		    GUIASADETC_FlagEstado,
			ALMAP_Codigo
			);
   
   ELSEIF REALIZACION=1 THEN
		IF (GUIASADETP_Codigo IS NULL OR GUIASADETP_Codigo=0 ) THEN
        	SELECT "INGRESAR GUIASADETP_Codigo";
        ELSE	
           SET @SQLREALIZAR="UPDATE cji_guiasadetalle gs SET ";
            
		  
            IF (GUIASAP_Codigo IS NULL OR GUIASAP_Codigo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASAP_Codigo=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASAP_Codigo);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
            IF (PRODCTOP_Codigo IS NULL OR PRODCTOP_Codigo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PRODCTOP_Codigo=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PRODCTOP_Codigo);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;   
			
            IF (UNDMED_Codigo IS NULL OR UNDMED_Codigo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.UNDMED_Codigo=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,UNDMED_Codigo);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;    		
			
			IF (GUIASADETC_GenInd IS NULL OR TRIM(GUIASADETC_GenInd)='' ) THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASADETC_GenInd='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASADETC_GenInd);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
			
			IF (GUIASADETC_Cantidad IS NULL OR GUIASADETC_Cantidad=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASADETC_Cantidad=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASADETC_Cantidad);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
            IF (GUIASADETC_Costo IS NULL OR GUIASADETC_Costo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASADETC_Costo=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASADETC_Costo);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;    
			
			IF (GUIASADETC_Descripcion IS NULL OR TRIM(GUIASADETC_Descripcion)="")  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASADETC_Descripcion='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASADETC_Descripcion);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;  
			
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASADET_FechaModificacion='");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CURDATE());
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
          			
            IF (GUIASADETC_FlagEstado IS NULL OR TRIM(GUIASADETC_FlagEstado)='')  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASADETC_FlagEstado='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASADETC_FlagEstado);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
			
			 
            IF (ALMAP_Codigo IS NOT NULL AND TRIM(ALMAP_Codigo)<>'')  THEN
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.ALMAP_Codigo=");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,ALMAP_Codigo);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			
			
            SET @SQLREALIZAR=SUBSTRING(@SQLREALIZAR,1,CHARACTER_LENGTH(@SQLREALIZAR)-1);
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.GUIASADETP_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASADETP_Codigo);
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;
		
   ELSEIF REALIZACION=2 THEN
   		IF (GUIASADETP_Codigo IS NULL OR GUIASADETP_Codigo=0 ) THEN
        	SELECT "INGRESAR GUIASADETP_Codigo";
        ELSE
            SET @SQLREALIZAR="UPDATE cji_guiasadetalle gs SET ";
            IF (GUIASADETC_FlagEstado IS NULL OR TRIM(GUIASADETC_FlagEstado)='')  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASADETC_FlagEstado='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(GUIASADETC_FlagEstado));
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASADET_FechaModificacion='");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CURDATE());
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.GUIASADETP_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASADETP_Codigo);
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;
		
    ELSEIF REALIZACION=3 THEN     
        IF (GUIASADETP_Codigo IS NULL OR GUIASADETP_Codigo=0 ) THEN
        	SELECT "INGRESAR GUIASADETP_Codigo";
        ELSE
            SELECT 
                gs.GUIASADETP_Codigo AS GUIASADETP_Codigo,
				gs.GUIASAP_Codigo AS GUIASAP_Codigo,
				gs.PRODCTOP_Codigo AS PRODCTOP_Codigo,
				gs.UNDMED_Codigo AS UNDMED_Codigo,
				gs.GUIASADETC_GenInd AS GUIASADETC_GenInd,
				gs.GUIASADETC_Cantidad AS GUIASADETC_Cantidad,
				gs.GUIASADETC_Costo AS GUIASADETC_Costo,
				gs.GUIASADETC_Descripcion AS GUIASADETC_Descripcion,
				gs.GUIASADETC_FechaRegistro AS GUIASADETC_FechaRegistro,
				gs.GUIASADET_FechaModificacion AS GUIASADET_FechaModificacion,
				gs.GUIASADETC_FlagEstado AS GUIASADETC_FlagEstado,
				gs.ALMAP_Codigo AS ALMAP_Codigo
            FROM cji_guiasadetalle gs
            WHERE gs.GUIASADETP_Codigo=GUIASADETP_Codigo;
     	END IF;  
		
        ELSEIF REALIZACION=4 THEN     
             SET @SQLREALIZAR="gs.GUIASADETP_Codigo AS GUIASADETP_Codigo,\r\n\t\t\t\tgs.GUIASAP_Codigo AS GUIASAP_Codigo,\r\n\t\t\t\tgs.PRODCTOP_Codigo AS PRODCTOP_Codigo,\r\n\t\t\t\tgs.UNDMED_Codigo AS UNDMED_Codigo,\r\n\t\t\t\tgs.GUIASADETC_GenInd AS GUIASADETC_GenInd,\r\n\t\t\t\tgs.GUIASADETC_Cantidad AS GUIASADETC_Cantidad,\r\n\t\t\t\tgs.GUIASADETC_Costo AS GUIASADETC_Costo,\r\n\t\t\t\tgs.GUIASADETC_Descripcion AS GUIASADETC_Descripcion,\r\n\t\t\t\tgs.GUIASADETC_FechaRegistro AS GUIASADETC_FechaRegistro,\r\n\t\t\t\tgs.GUIASADET_FechaModificacion AS GUIASADET_FechaModificacion,\r\n\t\t\t\tgs.GUIASADETC_FlagEstado AS GUIASADETC_FlagEstado\r\n\t\t\t\tFROM cji_guiasadetalle gs WHERE gs.GUIASADETC_FlagEstado !=0 ";
				
          
		  IF (GUIASAP_Codigo IS NULL OR GUIASAP_Codigo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASAP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASAP_Codigo);
            END IF;
			
            IF (PRODCTOP_Codigo IS NULL OR PRODCTOP_Codigo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PRODCTOP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PRODCTOP_Codigo);
            END IF;   
			
            IF (UNDMED_Codigo IS NULL OR UNDMED_Codigo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.UNDMED_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,UNDMED_Codigo);
            END IF;    		
			
			IF (GUIASADETC_GenInd IS NULL OR TRIM(GUIASADETC_GenInd)='' ) THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASADETC_GenInd='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASADETC_GenInd);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;
			
			IF (GUIASADETC_Cantidad IS NULL OR GUIASADETC_Cantidad=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASADETC_Cantidad=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASADETC_Cantidad);
            END IF;
			
            IF (GUIASADETC_Costo IS NULL OR GUIASADETC_Costo=0)  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASADETC_Costo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIASADETC_Costo);
            END IF;    
			
			IF (GUIASADETC_Descripcion IS NULL OR TRIM(GUIASADETC_Descripcion)="")  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"UPPER(gs.GUIASADETC_Descripcion) LIKE %");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,UPPER(GUIASADETC_Descripcion));
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"% ");
            END IF;  
			
            IF (FECHAINICIO IS NULL OR TRIM(FECHAINICIO)='0000-00-00')  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASADETC_FechaRegistro>='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAINICIO);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
            IF (FECHAFIN IS NULL OR TRIM(FECHAFIN)='0000-00-00')  THEN
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIASADETC_FechaRegistro<='");
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAFIN);
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
			
			IF (ALMAP_Codigo IS NOT NULL AND TRIM(ALMAP_Codigo)<>'')  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.ALMAP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,ALMAP_Codigo);
            END IF;

            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," ORDER BY gs.GUIASAP_Codigo ASC;");
			
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
   END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MANTENIMIENTO_KARDEX` (IN `KARDP_Codigo` INT(11), IN `COMPP_Codigo` INT(11), IN `PROD_Codigo` INT(11), IN `DOCUP_Codigo` INT(11), IN `TIPOMOVP_Codigo` INT(11), IN `LOTP_Codigo` INT(11), IN `KARDC_CodigoDoc` VARCHAR(50), IN `KARDC_TipoIngreso` CHAR(1), IN `KARD_Fecha` DATETIME, IN `KARDC_Cantidad` DOUBLE, IN `KARDC_Costo` DOUBLE, IN `REALIZACION` INT, IN `USUARIO` INT, IN `FECHAINICIO` DATE, IN `FECHAFIN` DATE, IN `ALMPROD_Codigo` INT(11), IN `KARDP_FlagEstado` CHAR(1))  BEGIN
	IF REALIZACION=0  THEN
		INSERT INTO cji_kardex VALUES (
				0,
				COMPP_Codigo,
				PROD_Codigo,
				DOCUP_Codigo,
				TIPOMOVP_Codigo,
				LOTP_Codigo,
				KARDC_CodigoDoc,
				KARDC_TipoIngreso,
				KARD_Fecha,
				KARDC_Cantidad,
				KARDC_Costo,
            	ALMPROD_Codigo,
            	1
		 );
		
	ELSEIF REALIZACION=1 THEN
		IF (KARDP_Codigo IS NULL OR KARDP_Codigo=0 ) THEN
        	SELECT "INGRESAR KARDP_Codigo";
        ELSE	
            SET @SQLREALIZAR="UPDATE cji_kardex gs SET ";
            
			IF (COMPP_Codigo IS NULL OR COMPP_Codigo=0 ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.COMPP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,COMPP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (PROD_Codigo IS NULL OR PROD_Codigo=0 ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (DOCUP_Codigo IS NULL OR DOCUP_Codigo=0 ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.DOCUP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,DOCUP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (TIPOMOVP_Codigo IS NULL OR TIPOMOVP_Codigo=0 ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.TIPOMOVP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TIPOMOVP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (LOTP_Codigo IS NULL OR LOTP_Codigo=0 ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.LOTP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,LOTP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (KARDC_CodigoDoc IS NULL OR KARDC_CodigoDoc=0 ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.KARDC_CodigoDoc=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,KARDC_CodigoDoc);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (KARDC_TipoIngreso IS NULL OR TRIM(KARDC_TipoIngreso)="" ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.KARDC_TipoIngreso='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,KARDC_TipoIngreso);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
			
			IF (KARD_Fecha IS NULL OR KARD_Fecha="0000-00-00" ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.KARD_Fecha='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,KARD_Fecha);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;

			IF (KARDC_Cantidad IS NULL) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.KARDC_Cantidad=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,KARDC_Cantidad);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (KARDC_Costo IS NULL) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.KARDC_Costo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,KARDC_Costo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
            SET @SQLREALIZAR=SUBSTRING(@SQLREALIZAR,1,CHARACTER_LENGTH(@SQLREALIZAR)-1);
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.KARDP_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,KARDP_Codigo);
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;
	ELSEIF REALIZACION=2 THEN
	
		IF (KARDP_Codigo IS NULL OR KARDP_Codigo=0 ) THEN
        	SELECT "INGRESAR KARDP_Codigo";
        ELSE
            SET @SQLREALIZAR="DELETE FROM cji_kardex gs ";
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.KARDP_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,KARDP_Codigo);
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;
		
	ELSEIF REALIZACION=3 THEN
		IF (KARDP_Codigo IS NULL OR KARDP_Codigo=0 ) THEN
        	SELECT "INGRESAR KARDP_Codigo";
        ELSE	
			SELECT
					gs.KARDP_Codigo AS KARDP_Codigo,
					gs.COMPP_Codigo AS COMPP_Codigo,
					gs.PROD_Codigo AS PROD_Codigo,
					gs.DOCUP_Codigo AS DOCUP_Codigo,
					gs.TIPOMOVP_Codigo AS TIPOMOVP_Codigo,
					gs.LOTP_Codigo AS LOTP_Codigo,
					gs.KARDC_CodigoDoc AS KARDC_CodigoDoc,
					gs.KARDC_TipoIngreso AS KARDC_TipoIngreso,
					gs.KARD_Fecha AS KARD_Fecha,
					gs.KARDC_Cantidad AS KARDC_Cantidad,
					gs.KARDC_Costo AS KARDC_Costo
			FROM cji_kardex gs
			WHERE gs.KARDP_Codigo=KARDP_Codigo;
		END IF;
	ELSEIF REALIZACION=4 THEN
			SET @SQLREALIZAR="SELECT\r\n\t\t\t\t\tgs.KARDP_Codigo AS KARDP_Codigo,\r\n\t\t\t\t\tgs.COMPP_Codigo AS COMPP_Codigo,\r\n\t\t\t\t\tgs.PROD_Codigo AS PROD_Codigo,\r\n\t\t\t\t\tgs.DOCUP_Codigo AS DOCUP_Codigo,\r\n\t\t\t\t\tgs.TIPOMOVP_Codigo AS TIPOMOVP_Codigo,\r\n\t\t\t\t\tgs.LOTP_Codigo AS LOTP_Codigo,\r\n\t\t\t\t\tgs.KARDC_CodigoDoc AS KARDC_CodigoDoc,\r\n\t\t\t\t\tgs.KARDC_TipoIngreso AS KARDC_TipoIngreso,\r\n\t\t\t\t\tgs.KARD_Fecha AS KARD_Fecha,\r\n\t\t\t\t\tgs.KARDC_Cantidad AS KARDC_Cantidad,\r\n\t\t\t\t\tgs.KARDC_Costo AS KARDC_Costo\r\n\t\t\tFROM cji_kardex gs WHERE gs.COMPP_Codigo!=NULL";
			
			IF (COMPP_Codigo IS NULL OR COMPP_Codigo=0 ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.COMPP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,COMPP_Codigo);
            END IF;
			
			IF (PROD_Codigo IS NULL OR PROD_Codigo=0 ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_Codigo);
            END IF;
			
			IF (DOCUP_Codigo IS NULL OR DOCUP_Codigo=0 ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.DOCUP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,DOCUP_Codigo);
            END IF;
			
			IF (TIPOMOVP_Codigo IS NULL OR TIPOMOVP_Codigo=0 ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.TIPOMOVP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TIPOMOVP_Codigo);
            END IF;
			
			IF (LOTP_Codigo IS NULL OR LOTP_Codigo=0 ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.LOTP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,LOTP_Codigo);
            END IF;
			
			IF (KARDC_CodigoDoc IS NULL OR KARDC_CodigoDoc=0 ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.KARDC_CodigoDoc=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,KARDC_CodigoDoc);
            END IF;
			
			IF (KARDC_TipoIngreso IS NULL OR TRIM(KARDC_TipoIngreso)="" ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.KARDC_TipoIngreso='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,KARDC_TipoIngreso);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
			END IF;
			
			
			IF (FECHAINICIO IS NULL OR TRIM(FECHAINICIO)='0000-00-00' )   THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.KARD_Fecha>='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAINICIO);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
            IF (FECHAFINC IS NULL OR TRIM(FECHAFINC)='0000-00-00')  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.KARD_Fecha<='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAFIN);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
			
			
			SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," ORDER BY gs.KARDP_Codigo ASC;");
			
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MANTENIMIENTO_LOTE` (INOUT `LOTP_Codigo` INT(11), IN `PROD_Codigo` INT(11), IN `LOTC_Cantidad` DOUBLE, IN `LOTC_Costo` DOUBLE, IN `GUIAINP_Codigo` INT(11), IN `LOTC_FechaRegistro` TIMESTAMP, IN `LOTC_FechaModificacion` DATETIME, IN `LOTC_FlagEstado` CHAR(1), IN `REALIZACION` INT, IN `USUARIO` INT, IN `FECHAINICIO` DATE, IN `FECHAFIN` DATE)  BEGIN
	IF REALIZACION=0  THEN
		INSERT INTO cji_lote VALUES (
				  0,
				  PROD_Codigo,
				  LOTC_Cantidad,
				  LOTC_Costo,
				  GUIAINP_Codigo,
				  NOW(),
				  '',
				  LOTC_FlagEstado
		 );
		SET LOTP_Codigo=last_insert_id();
	ELSEIF REALIZACION=1 THEN
		IF (LOTP_Codigo IS NULL OR LOTP_Codigo=0 ) THEN
        	SELECT "INGRESAR LOTP_Codigo";
        ELSE	
            SET @SQLREALIZAR="UPDATE cji_lote gs SET ";
            
			IF (PROD_Codigo IS NULL OR PROD_Codigo=0 ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (LOTC_Cantidad IS NULL) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.LOTC_Cantidad=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,LOTC_Cantidad);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (LOTC_Costo IS NULL) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.LOTC_Costo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,LOTC_Costo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (GUIAINP_Codigo IS NULL OR GUIAINP_Codigo=0) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.LOTC_FechaModificacion='");
			SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,NOW());
			SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
			IF (LOTC_FlagEstado IS NULL OR TRIM(LOTC_FlagEstado)="") THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.LOTC_FlagEstado='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,LOTC_FlagEstado);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
			
            SET @SQLREALIZAR=SUBSTRING(@SQLREALIZAR,1,CHARACTER_LENGTH(@SQLREALIZAR)-1);
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.LOTP_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,LOTP_Codigo);
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;
	ELSEIF REALIZACION=2 THEN
	
		IF (LOTP_Codigo IS NULL OR LOTP_Codigo=0 ) THEN
        	SELECT "INGRESAR LOTP_Codigo";
        ELSE
            SET @SQLREALIZAR="UPDATE cji_lote gs SET ";
            IF (LOTC_FlagEstado IS NULL OR TRIM(LOTC_FlagEstado)='')  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.LOTC_FlagEstado='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(LOTC_FlagEstado));
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.LOTC_FechaModificacion='");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,NOW());
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.LOTP_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,LOTP_Codigo);
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;
		
	ELSEIF REALIZACION=3 THEN
		IF (LOTP_Codigo IS NULL OR LOTP_Codigo=0 ) THEN
        	SELECT "INGRESAR LOTP_Codigo";
        ELSE	
			SELECT
				  gs.LOTP_Codigo AS LOTP_Codigo,
				  gs.PROD_Codigo AS PROD_Codigo,
				  gs.LOTC_Cantidad AS LOTC_Cantidad,
				  gs.LOTC_Costo AS LOTC_Costo,
				  gs.GUIAINP_Codigo AS GUIAINP_Codigo,
				  gs.LOTC_FechaRegistro AS LOTC_FechaRegistro,
				  gs.LOTC_FechaModificacion AS LOTC_FechaModificacion,
				  gs.LOTC_FlagEstado AS LOTC_FlagEstado
			FROM cji_lote gs
			WHERE gs.LOTP_Codigo=LOTP_Codigo;
		END IF;
	ELSEIF REALIZACION=4 THEN
			SET @SQLREALIZAR="SELECT\r\n\t\t\t\t\tgs.LOTP_Codigo AS LOTP_Codigo,\r\n\t\t\t\t  gs.PROD_Codigo AS PROD_Codigo,\r\n\t\t\t\t  gs.LOTC_Cantidad AS LOTC_Cantidad,\r\n\t\t\t\t  gs.LOTC_Costo AS LOTC_Costo,\r\n\t\t\t\t  gs.GUIAINP_Codigo AS GUIAINP_Codigo,\r\n\t\t\t\t  gs.LOTC_FechaRegistro AS LOTC_FechaRegistro,\r\n\t\t\t\t  gs.LOTC_FechaModificacion AS LOTC_FechaModificacion,\r\n\t\t\t\t  gs.LOTC_FlagEstado AS LOTC_FlagEstado\r\n\t\t\tFROM cji_lote gs WHERE gs.LOTC_FlagEstado!=0";
			
			
			
			IF (PROD_Codigo IS NULL OR PROD_Codigo=0 ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_Codigo);
            END IF;
			
			IF (GUIAINP_Codigo IS NULL OR GUIAINP_Codigo=0) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.GUIAINP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,GUIAINP_Codigo);
            END IF;
			
			IF (FECHAINICIO IS NULL OR TRIM(FECHAINICIO)='0000-00-00' )  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.LOTC_FechaRegistro>='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAINICIO);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
            IF (FECHAFIN IS NULL OR TRIM(FECHAFIN)='0000-00-00')  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.LOTC_FechaRegistro<='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAFIN);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
					
			SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," ORDER BY gs.LOTP_Codigo ASC;");
			
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
	
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MANTENIMIENTO_PAGO` (INOUT `PAGP_Codigo` INT(11), IN `PAGC_TipoCuenta` INT(11), IN `PAGC_FechaOper` DATE, IN `CLIP_Codigo` INT(11), IN `PROVP_Codigo` INT(11), IN `PAGC_TDC` DOUBLE(10,2), IN `PAGC_Monto` DOUBLE, IN `MONED_Codigo` INT(11), IN `PAGC_FormaPago` INT(11), IN `PAGC_DepoNro` VARCHAR(50), IN `PAGC_DepoCta` VARCHAR(50), IN `CHEP_Codigo` INT(11), IN `PAGC_Factura` INT(11), IN `PAGC_NotaCredito` INT(11), IN `PAGC_DescObs` TEXT, IN `PAGC_Saldo` DOUBLE(10,2), IN `PAGC_Obs` TEXT, IN `COMPP_Codigo` INT(11), IN `PAGC_FechaRegistro` TIMESTAMP, IN `PAGC_FechaModificacion` DATETIME, IN `PAGC_FlagEstado` VARCHAR(1), IN `REALIZACION` INT, IN `USUARIO` INT, IN `FECHAINICIO` DATE, IN `FECHAFIN` DATE)  BEGIN
	IF REALIZACION=0 THEN
		INSERT INTO cji_pago VALUES (
			  0,
			  PAGC_TipoCuenta,
			  PAGC_FechaOper,
			  CLIP_Codigo,
			  PROVP_Codigo,
			  PAGC_TDC,
			  PAGC_Monto,
			  MONED_Codigo,
			  PAGC_FormaPago,
			  PAGC_DepoNro,
			  PAGC_DepoCta,
			  CHEP_Codigo,
			  PAGC_Factura,
			  PAGC_NotaCredito,
			  PAGC_DescObs,
			  PAGC_Saldo,
			  PAGC_Obs,
			  COMPP_Codigo,
			  NOW(),
			  PAGC_FechaModificacion,
			  PAGC_FlagEstado
		 );
		SET PAGP_Codigo=last_insert_id();
	ELSEIF REALIZACION=1 THEN
		IF (PAGP_Codigo IS NULL OR PAGP_Codigo=0 ) THEN
        	SELECT "INGRESAR PAGP_Codigo";
        ELSE	
			SET @SQLREALIZAR="UPDATE cji_pago gs SET ";
			
			IF (PAGC_TipoCuenta IS NULL OR PAGC_TipoCuenta=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_TipoCuenta=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGC_TipoCuenta);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
			
			IF (PAGC_FechaOper IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_FechaOper='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGC_FechaOper);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"', ");
            END IF;
			
			IF (CLIP_Codigo IS NULL OR CLIP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CLIP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CLIP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
			
			IF (PROVP_Codigo IS NULL OR PROVP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROVP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROVP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;

			IF (PAGC_TDC IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_TDC=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGC_TDC);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
			
			IF (PAGC_Monto IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_Monto=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGC_Monto);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;

			IF (MONED_Codigo IS NULL OR MONED_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.MONED_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,MONED_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
			
			IF (PAGC_FormaPago IS NULL OR PAGC_FormaPago=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_FormaPago=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGC_FormaPago);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
			
			IF (PAGC_DepoNro IS NULL OR TRIM(PAGC_DepoNro)="")  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_DepoNro='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGC_DepoNro);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"', ");
            END IF;
			
			IF (PAGC_DepoCta IS NULL OR TRIM(PAGC_DepoCta)="")  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_DepoCta='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGC_DepoCta);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"', ");
            END IF;
			
			IF (CHEP_Codigo IS NULL OR CHEP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CHEP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CHEP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
			
			IF (PAGC_Factura IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_Factura=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGC_Factura);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
			
			IF (PAGC_NotaCredito IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_NotaCredito=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGC_NotaCredito);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;

			IF (PAGC_DescObs IS NULL OR TRIM(PAGC_DescObs)="")  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_DescObs='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGC_DescObs);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"', ");
            END IF;
			
			IF (PAGC_Saldo IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_Saldo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGC_Saldo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
			
			IF (PAGC_Obs IS NULL OR TRIM(PAGC_Obs)="")  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_Obs='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGC_Obs);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"', ");
            END IF;
			
			IF (COMPP_Codigo IS NULL OR COMPP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.COMPP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,COMPP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,", ");
            END IF;
			
			SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_FechaModificacion='");
			SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,NOW());
			SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"', ");

			IF (PAGC_FlagEstado IS NULL OR TRIM(PAGC_FlagEstado)="")  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_FlagEstado='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(PAGC_FlagEstado));
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF; 
			SET @SQLREALIZAR=SUBSTRING(@SQLREALIZAR,1,CHARACTER_LENGTH(@SQLREALIZAR)-1);
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.PAGP_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGP_Codigo);
            
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;
	ELSEIF REALIZACION=2 THEN
   		IF (PAGP_Codigo IS NULL OR PAGP_Codigo=0 ) THEN
        	SELECT "INGRESAR PAGP_Codigo";
        ELSE
            SET @SQLREALIZAR="UPDATE cji_pago gs SET ";
            IF (PAGC_FlagEstado IS NULL OR TRIM(PAGC_FlagEstado)='')  THEN
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_FlagEstado='");
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TRIM(PAGC_FlagEstado));
                SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_FechaModificacion='");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,NOW());
             SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.PAGP_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGP_Codigo);
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
        END IF;
		
		ELSEIF REALIZACION=3 THEN     
        IF (PAGP_Codigo IS NULL OR PAGP_Codigo=0 ) THEN
        	SELECT "INGRESAR PAGP_Codigo";
        ELSE
            SELECT  
			  gs.PAGP_Codigo AS PAGP_Codigo,
			  gs.PAGC_TipoCuenta AS PAGC_TipoCuenta,
			  gs.PAGC_FechaOper AS PAGC_FechaOper,
			  gs.CLIP_Codigo AS CLIP_Codigo,
			  gs.PROVP_Codigo AS PROVP_Codigo,
			  gs.PAGC_TDC AS PAGC_TDC,
			  gs.PAGC_Monto AS PAGC_Monto,
			  gs.MONED_Codigo AS MONED_Codigo,
			  gs.PAGC_FormaPago AS PAGC_FormaPago,
			  gs.PAGC_DepoNro AS PAGC_DepoNro,
			  gs.PAGC_DepoCta AS PAGC_DepoCta,
			  gs.CHEP_Codigo AS CHEP_Codigo,
			  gs.PAGC_Factura AS PAGC_Factura,
			  gs.PAGC_NotaCredito AS PAGC_NotaCredito,
			  gs.PAGC_DescObs AS PAGC_DescObs,
			  gs.PAGC_Saldo AS PAGC_Saldo, 
			  gs.PAGC_Obs AS PAGC_Obs,
			  gs.COMPP_Codigo AS COMPP_Codigo,
			  gs.PAGC_FechaRegistro AS PAGC_FechaRegistro,
			  gs.PAGC_FechaModificacion AS PAGC_FechaModificacion,
			  gs.PAGC_FlagEstado AS PAGC_FlagEstado
            FROM cji_pago gs
            WHERE gs.PAGP_Codigo=PAGP_Codigo;
     	END IF;  
		ELSEIF REALIZACION=4 THEN  
			SET @SQLREALIZAR="SELECT \r\n\t\t\t\t\tgs.PAGP_Codigo AS PAGP_Codigo,\r\n\t\t\t\t\tgs.PAGC_TipoCuenta AS PAGC_TipoCuenta,\r\n\t\t\t\t\tgs.PAGC_FechaOper AS PAGC_FechaOper,\r\n\t\t\t\t\tgs.CLIP_Codigo AS CLIP_Codigo,\r\n\t\t\t\t\tgs.PROVP_Codigo AS PROVP_Codigo,\r\n\t\t\t\t\tgs.PAGC_TDC AS PAGC_TDC,\r\n\t\t\t\t\tgs.PAGC_Monto AS PAGC_Monto,\r\n\t\t\t\t\tgs.MONED_Codigo AS MONED_Codigo,\r\n\t\t\t\t\tgs.PAGC_FormaPago AS PAGC_FormaPago,\r\n\t\t\t\t\tgs.PAGC_DepoNro AS PAGC_DepoNro,\r\n\t\t\t\t\tgs.PAGC_DepoCta AS PAGC_DepoCta,\r\n\t\t\t\t\tgs.CHEP_Codigo AS CHEP_Codigo,\r\n\t\t\t\t\tgs.PAGC_Factura AS PAGC_Factura,\r\n\t\t\t\t\tgs.PAGC_NotaCredito AS PAGC_NotaCredito,\r\n\t\t\t\t\tgs.PAGC_DescObs AS PAGC_DescObs,\r\n\t\t\t\t\tgs.PAGC_Saldo AS PAGC_Saldo, \r\n\t\t\t\t\tgs.PAGC_Obs AS PAGC_Obs,\r\n\t\t\t\t\tgs.COMPP_Codigo AS COMPP_Codigo,\r\n\t\t\t\t\tgs.PAGC_FechaRegistro AS PAGC_FechaRegistro,\r\n\t\t\t\t\tgs.PAGC_FechaModificacion AS PAGC_FechaModificacion,\r\n\t\t\t\t\tgs.PAGC_FlagEstado AS PAGC_FlagEstado\r\n            FROM cji_pago gs\r\n\t\t\tWHERE gs.PAGC_FlagEstado !=0 ";
			
			
			
			
			
			IF (PAGC_TipoCuenta IS NULL OR PAGC_TipoCuenta=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_TipoCuenta=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGC_TipoCuenta);
            END IF;
			
			
			IF (FECHAINICIO IS NULL OR TRIM(FECHAINICIO)='0000-00-00' )   THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_FechaOper>='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAINICIO);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;  
            IF (FECHAFIN IS NULL OR TRIM(FECHAFIN)='0000-00-00')  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_FechaOper<='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FECHAFIN);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"' ");
            END IF;
			
			
			IF (CLIP_Codigo IS NULL OR CLIP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CLIP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CLIP_Codigo);
            END IF;
			
			IF (PROVP_Codigo IS NULL OR PROVP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROVP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROVP_Codigo);
            END IF;

			IF (PAGC_TDC IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_TDC=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGC_TDC);
            END IF;
			

			IF (MONED_Codigo IS NULL OR MONED_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.MONED_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,MONED_Codigo);
            END IF;

			
			
			IF (PAGC_FormaPago IS NULL OR PAGC_FormaPago=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_FormaPago=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGC_FormaPago);
            END IF;
			
			IF (PAGC_DepoNro IS NULL OR TRIM(PAGC_DepoNro)="")  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"UPPER(gs.PAGC_DepoNro) LIKE '%");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,UPPER(PAGC_DepoNro));
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"%', ");
            END IF;
			
			
			
			IF (CHEP_Codigo IS NULL OR CHEP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.CHEP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,CHEP_Codigo);
            END IF;
			
			IF (PAGC_Factura IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_Factura=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGC_Factura);
            END IF;
			
			IF (PAGC_NotaCredito IS NULL)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PAGC_NotaCredito=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PAGC_NotaCredito);
            END IF;

			
			IF (COMPP_Codigo IS NULL OR COMPP_Codigo=0)  THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," AND ");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.COMPP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,COMPP_Codigo);
            END IF;
			
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," ORDER BY gs.PAGP_Codigo=");
            
            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;

	END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MANTENIMIENTO_PRODUCTO` (IN `PROD_Codigo` INT(11), IN `PROD_FlagBienServicio` CHAR(1), IN `FAMI_Codigo` INT(11), IN `TIPPROD_Codigo` INT(11), IN `MARCP_Codigo` INT(11), IN `LINP_Codigo` INT(11), IN `FABRIP_Codigo` INT(11), IN `PROD_PadreCodigo` INT(11), IN `PROD_Nombre` VARCHAR(100), IN `PROD_NombreCorto` VARCHAR(50), IN `PROD_DescripcionBreve` VARCHAR(200), IN `PROD_EspecificacionPDF` VARCHAR(100), IN `PROD_Comentario` TEXT, IN `PROD_Stock` DOUBLE, IN `PROD_StockMinimo` DOUBLE, IN `PROD_StockMaximo` DOUBLE, IN `PROD_CodigoInterno` VARCHAR(100), IN `PROD_CodigoUsuario` VARCHAR(50), IN `PROD_Imagen` VARCHAR(100), IN `PROD_CostoPromedio` DOUBLE, IN `PROD_UltimoCosto` DOUBLE, IN `PROD_Modelo` VARCHAR(150), IN `PROD_Presentacion` VARCHAR(150), IN `PROD_GenericoIndividual` CHAR(1), IN `PROD_FechaUltimaCompra` DATETIME, IN `PROD_FechaRegistro` TIMESTAMP, IN `PROD_FechaModificacion` DATETIME, IN `PROD_FlagActivo` CHAR(1), IN `PROD_FlagEstado` CHAR(1), IN `PROP_Codigo` INT(11), IN `PROD_CodigoOriginal` VARCHAR(50), IN `REALIZACION` INT, IN `USUARIO` INT, IN `FECHAINICIO` DATE, IN `FECHAFIN` DATE)  BEGIN
	IF REALIZACION=0  THEN
    	SELECT "FALTA IMPLEMENTAR";
	ELSEIF REALIZACION=1 THEN
    	IF (PROD_Codigo IS NULL OR PROD_Codigo=0 ) THEN
        	SELECT "INGRESAR PROD_Codigo";
        ELSE	
            SET @SQLREALIZAR="UPDATE cji_producto gs SET ";

			IF (PROD_FlagBienServicio IS NULL OR TRIM(PROD_FlagBienServicio)='' ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_FlagBienServicio='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_FlagBienServicio);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
			
			IF (FAMI_Codigo IS NULL OR FAMI_Codigo=0 ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.FAMI_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FAMI_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (TIPPROD_Codigo IS NULL OR TIPPROD_Codigo=0 ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.TIPPROD_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,TIPPROD_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;

			IF (MARCP_Codigo IS NULL OR MARCP_Codigo=0 ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.MARCP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,MARCP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (LINP_Codigo IS NULL OR LINP_Codigo=0 ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.LINP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,LINP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (FABRIP_Codigo IS NULL OR FABRIP_Codigo=0 ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.FABRIP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,FABRIP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (PROD_PadreCodigo IS NULL OR PROD_PadreCodigo=0 ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_PadreCodigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_PadreCodigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (PROD_Nombre IS NULL OR TRIM(PROD_Nombre)='' ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_Nombre='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_Nombre);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
			
			IF (PROD_NombreCorto IS NULL OR TRIM(PROD_NombreCorto)='' ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_NombreCorto='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_NombreCorto);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;

			IF (PROD_DescripcionBreve IS NULL OR TRIM(PROD_DescripcionBreve)='' ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_DescripcionBreve='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_DescripcionBreve);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
			
			IF (PROD_EspecificacionPDF IS NULL OR TRIM(PROD_EspecificacionPDF)='' ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_EspecificacionPDF='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_EspecificacionPDF);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
			
			IF (PROD_Comentario IS NULL OR TRIM(PROD_Comentario)='' ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_Comentario='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_Comentario);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
			
			IF (PROD_Stock IS NULL OR PROD_Stock=0 ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_Stock=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_Stock);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (PROD_StockMinimo IS NULL OR PROD_StockMinimo=0 ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_StockMinimo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_StockMinimo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (PROD_StockMaximo IS NULL OR PROD_StockMaximo=0 ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_StockMaximo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_StockMaximo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (PROD_CodigoInterno IS NULL OR TRIM(PROD_CodigoInterno)='' ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_CodigoInterno='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_CodigoInterno);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
			
			IF (PROD_CodigoUsuario IS NULL OR TRIM(PROD_CodigoUsuario)='' ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_CodigoUsuario='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_CodigoUsuario);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;

			IF (PROD_Imagen IS NULL OR TRIM(PROD_Imagen)='' ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_Imagen='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_Imagen);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
			
			IF (PROD_CostoPromedio IS NULL OR PROD_CostoPromedio=0 ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_CostoPromedio=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_CostoPromedio);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;

			IF (PROD_UltimoCosto IS NULL OR PROD_UltimoCosto=0 ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_UltimoCosto=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_UltimoCosto);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (PROD_Modelo IS NULL OR TRIM(PROD_Modelo)='' ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_Modelo='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_Modelo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
			
			IF (PROD_Presentacion IS NULL OR TRIM(PROD_Presentacion)='' ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_Presentacion='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_Presentacion);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
			
			IF (PROD_GenericoIndividual IS NULL OR TRIM(PROD_GenericoIndividual)='' ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_GenericoIndividual='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_GenericoIndividual);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
			
			IF (PROD_FechaUltimaCompra IS NULL OR PROD_FechaUltimaCompra='' ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_FechaUltimaCompra='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_FechaUltimaCompra);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;

			IF (PROD_FlagActivo IS NULL OR PROD_FlagActivo='' ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_FlagActivo='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_FlagActivo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
			
			IF (PROD_FlagEstado IS NULL OR PROD_FlagEstado='' ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_FlagEstado='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_FlagEstado);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;
			
			IF (PROP_Codigo IS NULL OR PROP_Codigo=0 ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROP_Codigo=");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROP_Codigo);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,",");
            END IF;
			
			IF (PROD_CodigoOriginal IS NULL OR TRIM(PROD_CodigoOriginal)='' ) THEN
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"");
            ELSE
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_CodigoOriginal='");
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_CodigoOriginal);
				SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
            END IF;

			SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"gs.PROD_FechaModificacion='");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,NOW());
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,"',");
			
			SET @SQLREALIZAR=SUBSTRING(@SQLREALIZAR,1,CHARACTER_LENGTH(@SQLREALIZAR)-1);
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR," WHERE gs.PROD_Codigo=");
            SET @SQLREALIZAR=CONCAT(@SQLREALIZAR,PROD_Codigo);

            PREPARE STMT FROM @SQLREALIZAR; 
            EXECUTE STMT; 
            DEALLOCATE PREPARE STMT;
			
		END IF;
	ELSEIF REALIZACION=2 THEN
    	SELECT "FALTA IMPLEMENTAR";
	ELSEIF REALIZACION=3 THEN
		IF (PROD_Codigo IS NULL OR PROD_Codigo=0 ) THEN
        	SELECT "INGRESAR PROD_Codigo";
        ELSE	
			SELECT
			  gs.PROD_Codigo AS PROD_Codigo,
			  gs.PROD_FlagBienServicio AS PROD_FlagBienServicio,
			  gs.FAMI_Codigo AS FAMI_Codigo,
			  gs.TIPPROD_Codigo AS TIPPROD_Codigo,
			  gs.MARCP_Codigo AS MARCP_Codigo,
			  gs.LINP_Codigo AS LINP_Codigo,
			  gs.FABRIP_Codigo AS FABRIP_Codigo,
			  gs.PROD_PadreCodigo AS PROD_PadreCodigo,
			  gs.PROD_Nombre AS PROD_Nombre,
			  gs.PROD_NombreCorto AS PROD_NombreCorto,
			  gs.PROD_DescripcionBreve AS PROD_DescripcionBreve,
			  gs.PROD_EspecificacionPDF AS PROD_EspecificacionPDF,
			  gs.PROD_Comentario AS PROD_Comentario,
			  gs.PROD_Stock AS PROD_Stock,
			  gs.PROD_StockMinimo AS PROD_StockMinimo,
			  gs.PROD_StockMaximo AS PROD_StockMaximo,
			  gs.PROD_CodigoInterno AS PROD_CodigoInterno,
			  gs.PROD_CodigoUsuario AS PROD_CodigoUsuario,
			  gs.PROD_Imagen AS PROD_Imagen,
			  gs.PROD_CostoPromedio AS PROD_CostoPromedio,
			  gs.PROD_UltimoCosto AS PROD_UltimoCosto,
			  gs.PROD_Modelo AS PROD_Modelo,
			  gs.PROD_Presentacion AS PROD_Presentacion,
			  gs.PROD_GenericoIndividual AS PROD_GenericoIndividual,
			  gs.PROD_FechaUltimaCompra AS PROD_FechaUltimaCompra,
			  gs.PROD_FechaRegistro AS PROD_FechaRegistro,
			  gs.PROD_FechaModificacion AS PROD_FechaModificacion,
			  gs.PROD_FlagActivo AS PROD_FlagActivo,
			  gs.PROD_FlagEstado AS PROD_FlagEstado,
			  gs.PROP_Codigo AS PROP_Codigo,
			  gs.PROD_CodigoOriginal AS PROD_CodigoOriginal
			FROM cji_producto gs
			WHERE gs.PROD_Codigo=PROD_Codigo;
		END IF;
	ELSEIF REALIZACION=4 THEN
    SELECT "FALTA IMPLEMENTAR";
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MANTENIMIENTO_SERIEDOCUMENTO` (IN `SERDOC_Codigo` INT(11), IN `SERIP_Codigo` INT(11), IN `DOCUP_Codigo` INT(2), IN `SERDOC_NumeroRef` INT(11), IN `TIPOMOV_Tipo` CHAR(1), IN `SERDOC_FechaRegistro` TIMESTAMP, IN `SERDOC_FlagEstado` CHAR(1), IN `REALIZACION` INT(1))  BEGIN
	IF REALIZACION=0  THEN
		INSERT INTO cji_seriedocumento VALUES (
				  0,
				  SERIP_Codigo,
				  DOCUP_Codigo,
				  SERDOC_NumeroRef,
				  TIPOMOV_Tipo,
				  NOW(),
				  SERDOC_FlagEstado
		 );
		SET SERDOC_Codigo=last_insert_id();
	ELSEIF REALIZACION=1 THEN
		SELECT "IMPLEMENTAR";
	ELSEIF REALIZACION=2 THEN
		SELECT "IMPLEMENTAR";
	ELSEIF REALIZACION=3 THEN
		SELECT "IMPLEMENTAR";
	END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `MANTENIMIENTO_SERIEMOVIMIENTO` (INOUT `SERMOVP_Codigo` INT(11), IN `SERIP_Codigo` INT(11), IN `SERMOVP_TipoMov` CHAR(1), IN `GUIAINP_Codigo` INT(11), IN `GUIASAP_Codigo` INT(11), IN `REALIZACION` INT(2))  BLOCK1:
BEGIN
	IF REALIZACION=0  THEN
		INSERT INTO cji_seriemov VALUES (
				  0,
				  SERIP_Codigo,
				  SERMOVP_TipoMov,
				  GUIAINP_Codigo,
				  GUIASAP_Codigo,
				  NOW(),
				  SERMOVC_FechaModificacion
		 );
		SET SERMOVP_Codigo=last_insert_id();
	ELSEIF REALIZACION=1 THEN
		SELECT "IMPLEMENTAR";
	ELSEIF REALIZACION=2 THEN
		SELECT "IMPLEMENTAR";
	ELSEIF REALIZACION=3 THEN
		SELECT "IMPLEMENTAR";
	END IF;
END BLOCK1$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_almacen`
--

CREATE TABLE `cji_almacen` (
  `ALMAP_Codigo` int(11) NOT NULL,
  `TIPALM_Codigo` int(11) NOT NULL,
  `EESTABP_Codigo` int(11) NOT NULL,
  `CENCOSP_Codigo` int(11) NOT NULL,
  `ALMAC_Descripcion` varchar(250) DEFAULT NULL,
  `ALMAC_Direccion` varchar(250) DEFAULT NULL,
  `ALMAC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ALMAC_FechaModificacion` datetime DEFAULT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `ALMAC_FlagEstado` char(1) DEFAULT '1',
  `ALMAC_CodigoUsuario` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_almacen`
--

INSERT INTO `cji_almacen` (`ALMAP_Codigo`, `TIPALM_Codigo`, `EESTABP_Codigo`, `CENCOSP_Codigo`, `ALMAC_Descripcion`, `ALMAC_Direccion`, `ALMAC_FechaRegistro`, `ALMAC_FechaModificacion`, `COMPP_Codigo`, `ALMAC_FlagEstado`, `ALMAC_CodigoUsuario`) VALUES
(3, 3, 1, 4, 'ALMACEN PRINCIPAL', 'ALMACEN PRINCIPAL', '2013-03-21 03:32:53', NULL, 1, '1', ''),
(4, 3, 1, 1, 'ALMACEN PRUEBA 02', NULL, '2016-10-29 21:15:21', NULL, 1, '1', '012451'),
(5, 1, 1, 1, 'ALMACEN 03', NULL, '2016-12-10 01:24:17', NULL, 1, '1', '451414'),
(6, 3, 28, 1, 'JUAN', 'JUAN ', '2016-12-24 03:52:11', NULL, 2, '1', ''),
(7, 3, 29, 1, '', 'FLORES', '2016-12-26 20:16:09', NULL, 3, '1', ''),
(8, 3, 33, 1, 'AAAAAAAA', 'DFGFDGDGDFGDFG', '2016-12-29 03:31:22', NULL, 4, '1', ''),
(9, 3, 1, 1, 'RIMAC', NULL, '2017-01-06 22:09:38', NULL, 1, '1', '001'),
(10, 3, 1, 1, 'TIENDA', NULL, '2017-01-06 22:09:52', NULL, 1, '1', '002');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_almacenproducto`
--

CREATE TABLE `cji_almacenproducto` (
  `ALMPROD_Codigo` int(11) NOT NULL,
  `ALMAC_Codigo` int(11) DEFAULT NULL,
  `PROD_Codigo` int(11) DEFAULT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `ALMPROD_Stock` double DEFAULT '0',
  `ALMPROD_CostoPromedio` double NOT NULL,
  `ALMPROD_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ALMPROD_FechaModificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_almacenproducto`
--

INSERT INTO `cji_almacenproducto` (`ALMPROD_Codigo`, `ALMAC_Codigo`, `PROD_Codigo`, `COMPP_Codigo`, `ALMPROD_Stock`, `ALMPROD_CostoPromedio`, `ALMPROD_FechaRegistro`, `ALMPROD_FechaModificacion`) VALUES
(3, 5, 3, 1, 6, 19.333333333333332, '2017-01-23 21:09:58', '0000-00-00 00:00:00'),
(4, 5, 4, 1, 6, 11.166666666666666, '2017-01-23 21:10:28', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_almacenproductoserie`
--

CREATE TABLE `cji_almacenproductoserie` (
  `ALMPRODSERP_Codigo` int(11) NOT NULL,
  `ALMPROD_Codigo` int(11) NOT NULL,
  `SERIP_Codigo` int(11) NOT NULL,
  `ALMPRODSERC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ALMPRODSERC_Seleccion` varchar(1) NOT NULL,
  `ALMPRODSERC_FechaSeleccion` datetime NOT NULL,
  `ALMPRODSERC_FlagEstado` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_almacenproductoserie`
--

INSERT INTO `cji_almacenproductoserie` (`ALMPRODSERP_Codigo`, `ALMPROD_Codigo`, `SERIP_Codigo`, `ALMPRODSERC_FechaRegistro`, `ALMPRODSERC_Seleccion`, `ALMPRODSERC_FechaSeleccion`, `ALMPRODSERC_FlagEstado`) VALUES
(28, 3, 33, '2017-01-23 21:09:58', '1', '2017-01-23 05:01:09', '1'),
(29, 3, 34, '2017-01-23 21:09:58', '1', '2017-01-23 05:01:54', '1'),
(30, 3, 35, '2017-01-23 21:09:58', '1', '2017-01-23 05:01:54', '1'),
(31, 3, 36, '2017-01-23 21:09:58', '1', '2017-01-23 05:01:54', '1'),
(32, 3, 37, '2017-01-23 21:09:58', '1', '2017-01-23 05:01:54', '1'),
(33, 4, 38, '2017-01-23 21:10:29', '1', '2017-01-23 05:01:09', '1'),
(34, 4, 39, '2017-01-23 21:10:29', '1', '2017-01-23 05:01:33', '1'),
(35, 4, 40, '2017-01-23 21:10:29', '1', '2017-01-23 05:01:55', '1'),
(36, 4, 41, '2017-01-23 21:10:29', '1', '2017-01-23 05:01:59', '1'),
(37, 4, 42, '2017-01-23 21:10:29', '1', '2017-01-23 04:01:29', '1'),
(38, 3, 43, '2017-01-23 21:13:42', '1', '2017-01-23 05:01:44', '1'),
(39, 3, 44, '2017-01-23 21:13:42', '1', '2017-01-23 05:01:54', '1'),
(40, 3, 45, '2017-01-23 21:13:42', '1', '2017-01-23 05:01:54', '1'),
(41, 3, 46, '2017-01-23 21:18:27', '1', '2017-01-23 05:01:16', '1'),
(42, 3, 47, '2017-01-23 21:18:27', '1', '2017-01-23 05:01:44', '1'),
(43, 3, 48, '2017-01-23 21:18:27', '1', '2017-01-23 05:01:44', '1'),
(44, 3, 49, '2017-01-23 21:18:27', '1', '2017-01-23 05:01:43', '1'),
(45, 3, 50, '2017-01-23 21:18:27', '1', '2017-01-23 05:01:54', '1'),
(46, 3, 51, '2017-01-23 21:18:27', '1', '2017-01-23 05:01:44', '1'),
(47, 4, 52, '2017-01-23 21:20:07', '1', '2017-01-23 05:01:24', '1'),
(48, 4, 53, '2017-01-23 21:20:07', '1', '2017-01-23 05:01:59', '1'),
(49, 4, 54, '2017-01-23 21:20:07', '1', '2017-01-24 10:01:44', '2'),
(50, 4, 55, '2017-01-23 21:20:07', '1', '2017-01-23 05:01:32', '1'),
(51, 4, 56, '2017-01-23 21:20:07', '1', '2017-01-23 05:01:09', '1'),
(52, 3, 57, '2017-01-23 21:20:07', '1', '2017-01-23 05:01:29', '1'),
(53, 3, 58, '2017-01-23 21:20:07', '1', '2017-01-23 05:01:44', '1'),
(54, 3, 59, '2017-01-23 21:20:07', '1', '2017-01-23 05:01:44', '1'),
(55, 3, 60, '2017-01-24 15:34:55', '1', '2017-01-24 10:01:05', '2'),
(56, 3, 61, '2017-01-24 15:34:55', '1', '2017-01-24 10:01:05', '2'),
(57, 3, 62, '2017-01-24 15:34:55', '1', '2017-01-24 10:01:06', '2'),
(58, 3, 63, '2017-01-24 15:34:56', '1', '2017-01-24 10:01:07', '2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_almaprolote`
--

CREATE TABLE `cji_almaprolote` (
  `ALMALOTP_Codigo` int(11) NOT NULL,
  `ALMPROD_Codigo` int(11) NOT NULL,
  `LOTP_Codigo` int(11) NOT NULL,
  `COMPP_Codigo` int(11) DEFAULT '0',
  `ALMALOTC_Cantidad` double DEFAULT '0',
  `ALMALOTC_Costo` double DEFAULT '0',
  `ALMALOTC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ALMALOTC_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_almaprolote`
--

INSERT INTO `cji_almaprolote` (`ALMALOTP_Codigo`, `ALMPROD_Codigo`, `LOTP_Codigo`, `COMPP_Codigo`, `ALMALOTC_Cantidad`, `ALMALOTC_Costo`, `ALMALOTC_FechaRegistro`, `ALMALOTC_FlagEstado`) VALUES
(10, 3, 146, 1, 0, 20, '2017-01-23 21:09:58', '1'),
(11, 4, 147, 1, 0, 10, '2017-01-23 22:37:02', '1'),
(12, 3, 148, 1, 0, 3, '2017-01-23 21:33:37', '1'),
(13, 3, 149, 1, 0, 6, '2017-01-23 21:48:03', '1'),
(14, 4, 150, 1, 0, 9, '2017-01-24 15:34:16', '1'),
(15, 3, 151, 1, 0, 3, '2017-01-23 22:35:45', '1'),
(16, 4, 152, 1, 5, 9, '2017-01-23 21:20:22', '1'),
(17, 3, 153, 1, 2, 3, '2017-01-24 15:36:23', '1'),
(18, 3, 154, 1, 4, 199, '2017-01-24 15:34:55', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_area`
--

CREATE TABLE `cji_area` (
  `AREAP_Codigo` int(11) NOT NULL,
  `AREAC_Descripcion` varchar(150) DEFAULT NULL,
  `AREAC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `AREAC_FechaModificacion` datetime DEFAULT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `AREAC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cji_area`
--

INSERT INTO `cji_area` (`AREAP_Codigo`, `AREAC_Descripcion`, `AREAC_FechaRegistro`, `AREAC_FechaModificacion`, `COMPP_Codigo`, `AREAC_FlagEstado`) VALUES
(1, 'ALMACEN', '2010-12-14 10:02:47', NULL, 1, '1'),
(2, 'COMPRAS', '2010-12-22 00:25:30', NULL, 1, '1'),
(3, 'VENTAS', '2010-12-30 00:38:17', NULL, 1, '1'),
(4, 'CONTABILIDAD', '2010-12-30 00:45:40', NULL, 1, '1'),
(5, 'ADMINISTRACION', '2010-12-30 00:46:18', NULL, 1, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_atributo`
--

CREATE TABLE `cji_atributo` (
  `ATRIB_Codigo` int(11) NOT NULL,
  `ATRIB_FlagBienServicio` char(1) NOT NULL DEFAULT 'B' COMMENT 'B: Bien, S: Servicio',
  `ATRIB_Descripcion` varchar(150) DEFAULT NULL,
  `ATRIB_TipoAtributo` int(1) DEFAULT NULL COMMENT '1::Numerico,2::Date,3::String',
  `ATRIB_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ATRIB_FechaModificacion` datetime DEFAULT NULL,
  `ATRIB_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_atributo`
--

INSERT INTO `cji_atributo` (`ATRIB_Codigo`, `ATRIB_FlagBienServicio`, `ATRIB_Descripcion`, `ATRIB_TipoAtributo`, `ATRIB_FechaRegistro`, `ATRIB_FechaModificacion`, `ATRIB_FlagEstado`) VALUES
(1, 'B', 'PESO', 1, '2011-01-05 01:08:49', NULL, '1'),
(2, 'B', 'TAMANO', 1, '2011-01-05 01:08:59', NULL, '1'),
(3, 'B', 'COLOR', 3, '2011-01-05 01:09:13', NULL, '1'),
(4, 'B', 'POTENCIA', 1, '2011-01-05 01:09:33', NULL, '1'),
(5, 'B', 'MODELO', 3, '2011-01-05 01:13:33', NULL, '1'),
(6, 'B', 'DIAMETRO EXTERIOR', 1, '2011-01-13 20:44:01', NULL, '1'),
(7, 'B', 'DIAMETRO INTERIOR', 1, '2011-01-10 10:03:32', NULL, '1'),
(8, 'B', 'ESPESOR DE PARED', 1, '2011-01-10 10:03:58', NULL, '1'),
(9, 'B', 'PRESION', 1, '2011-01-10 10:03:58', NULL, '1'),
(10, 'B', 'TOLERANCIA ESPESOR', 1, '2011-01-10 10:42:54', NULL, '1'),
(11, 'B', 'PESO TEORICO', 1, '2011-01-10 10:42:54', NULL, '1'),
(12, 'B', 'SISTEMA INGLES', 1, '2011-01-10 10:43:08', NULL, '1'),
(13, 'B', 'MODELO', 1, '2011-01-18 22:39:06', NULL, '1'),
(14, 'S', 'TIEMPO', 1, '2012-09-25 16:36:34', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_banco`
--

CREATE TABLE `cji_banco` (
  `BANP_Codigo` int(11) NOT NULL,
  `BANC_Nombre` varchar(100) NOT NULL,
  `BANC_Siglas` varchar(20) NOT NULL,
  `BANC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `BANC_FechaModificacion` datetime DEFAULT NULL,
  `BANC_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_banco`
--

INSERT INTO `cji_banco` (`BANP_Codigo`, `BANC_Nombre`, `BANC_Siglas`, `BANC_FechaRegistro`, `BANC_FechaModificacion`, `BANC_FlagEstado`) VALUES
(1, 'BANCO DE CREDITO', 'BCP', '2012-11-02 04:07:47', NULL, '1'),
(2, 'BANCO CONTINENTAL', 'BBVA', '2012-11-02 04:07:47', NULL, '1'),
(3, 'INTERBANK', 'INTERBANK', '2012-11-02 04:08:11', NULL, '1'),
(4, 'SCOTIABANK', 'SCOTIABANK', '2014-11-02 04:08:11', NULL, '1'),
(5, 'HSBC', 'HSBC', '2014-11-02 04:08:11', NULL, '1'),
(6, 'CITIBANK', 'CITIBANK', '2014-11-02 04:08:11', NULL, '1'),
(7, 'BANCO DE LA NACION', 'BANCO DE LA NACION', '2014-11-02 04:08:11', NULL, '1'),
(8, 'BANCO INTERAMERICANO DE FINANZAS', 'BANBIF', '2014-11-02 04:08:11', NULL, '1'),
(9, 'BANCO DE COMERCIO', 'BANCO DE COMERCIO', '2014-11-02 04:08:11', NULL, '1'),
(10, 'BANCO FINANCIERO', 'BANCO FINANCIERO', '2014-11-02 04:08:11', NULL, '1'),
(11, 'MIBANCO', 'MIBANCO', '2014-11-02 04:08:11', NULL, '1'),
(12, 'BANCO GNB PERU', 'BANCO GNB PERU', '2014-11-02 04:08:11', NULL, '1'),
(13, 'BANCO FALABELLA', 'BANCO FALABELLA', '2014-11-02 04:08:11', NULL, '1'),
(14, 'BANCO RIPLEY', 'BANCO RIPLEY', '2014-11-02 04:08:11', NULL, '1'),
(15, 'BANCO SANTANDER PERU', 'BANCO SANTANDER PERU', '2014-11-02 04:08:11', NULL, '1'),
(16, 'BANCO AZTECA', 'BANCO AZTECA', '2014-11-02 04:08:11', NULL, '1'),
(17, 'Deutsche Bank', 'Deutsche Bank', '2014-11-02 04:08:11', NULL, '1'),
(18, 'BANCO CENCOSUD', 'BANCO CENCOSUD', '2014-11-02 04:08:11', NULL, '1'),
(19, 'ICBC Perú Bank', 'ICBC Perú Bank', '2014-11-02 04:08:11', NULL, '1'),
(20, 'AGROBANCO', 'AGROBANCO', '2014-11-02 04:08:11', NULL, '1'),
(21, 'COFIDE', 'COFIDE', '2014-11-02 04:08:11', NULL, '1'),
(22, 'FONDO MIVIVIENDA', 'FONDO MIVIVIENDA', '2014-11-02 04:08:11', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_bancocta`
--

CREATE TABLE `cji_bancocta` (
  `CTAP_Codigo` int(11) NOT NULL,
  `BANP_Codigo` int(11) NOT NULL,
  `CTAC_Nro` varchar(50) NOT NULL,
  `CTAC_Tipo` varchar(1) NOT NULL COMMENT 'S: Soles; D: Dólares',
  `CTAC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CTAC_FechaModificacion` datetime DEFAULT NULL,
  `CTAC_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_caja`
--

CREATE TABLE `cji_caja` (
  `CAJA_Codigo` int(11) NOT NULL,
  `CAJA_Nombre` varchar(200) NOT NULL,
  `tipCa_codigo` int(11) NOT NULL,
  `CAJA_Observaciones` varchar(200) NOT NULL,
  `CAJA_tipo` char(1) NOT NULL,
  `USUA_Codigo` int(11) NOT NULL,
  `CAJA_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CAJA_FechaModificacion` datetime NOT NULL,
  `CAJA_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `CAJA_CodigoUsuario` int(11) DEFAULT NULL,
  `CODIGO_Directorio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_cajamovimiento`
--

CREATE TABLE `cji_cajamovimiento` (
  `CAJAMOV_Codigo` int(11) NOT NULL,
  `CAJA_Codigo` int(11) NOT NULL,
  `RESPMOV_Codigo` int(11) NOT NULL,
  `CAJAMOV_TipoRespo` int(11) NOT NULL COMMENT 'TipoCaja:10;Directivo:20;Proveedor:30;Cliente:40',
  `CUNTCONTBL_Codigo_G` int(11) NOT NULL,
  `CUNTCONTBL_Codigo_B` int(11) NOT NULL,
  `CUENT_Codigo_G` int(11) NOT NULL,
  `CUENT_Codigo_B` int(11) NOT NULL,
  `MONED_Codigo_G` int(11) NOT NULL,
  `MONED_Codigo_B` int(11) NOT NULL,
  `cajamov_monto` int(11) NOT NULL,
  `CAJAMOV_Monto_B` varchar(200) NOT NULL,
  `CAJAMOV_Monto_G` varchar(200) NOT NULL,
  `CAJAMOV_MovDinero` int(1) NOT NULL COMMENT '1::INGRESO, 2 :SALIDA',
  `CAJAMOV_FormaPago_G` int(11) NOT NULL COMMENT '1:Efectivo ; 2:Deposito',
  `CAJAMOV_FormaPago_B` int(11) NOT NULL,
  `cajamov_tipbenefi` char(1) NOT NULL,
  `CAJAMOV_FechaSistema` datetime NOT NULL,
  `CAJAMOV_FechaRecep` datetime NOT NULL,
  `CAJAMOV_Justificacion` varchar(200) NOT NULL,
  `CAJAMOV_Observacion` varchar(200) NOT NULL,
  `CAJAMOV_TipInicio` int(1) NOT NULL,
  `CAJAMOV_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CAJAMOV_FechaModificacion` datetime NOT NULL,
  `CAJAMOV_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `CAJAMOV_DescripFlagEstado` varchar(250) NOT NULL,
  `CAJAMOV_CodigoUsuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cji_cajamovimiento`
--

INSERT INTO `cji_cajamovimiento` (`CAJAMOV_Codigo`, `CAJA_Codigo`, `RESPMOV_Codigo`, `CAJAMOV_TipoRespo`, `CUNTCONTBL_Codigo_G`, `CUNTCONTBL_Codigo_B`, `CUENT_Codigo_G`, `CUENT_Codigo_B`, `MONED_Codigo_G`, `MONED_Codigo_B`, `cajamov_monto`, `CAJAMOV_Monto_B`, `CAJAMOV_Monto_G`, `CAJAMOV_MovDinero`, `CAJAMOV_FormaPago_G`, `CAJAMOV_FormaPago_B`, `cajamov_tipbenefi`, `CAJAMOV_FechaSistema`, `CAJAMOV_FechaRecep`, `CAJAMOV_Justificacion`, `CAJAMOV_Observacion`, `CAJAMOV_TipInicio`, `CAJAMOV_FechaRegistro`, `CAJAMOV_FechaModificacion`, `CAJAMOV_FlagEstado`, `CAJAMOV_DescripFlagEstado`, `CAJAMOV_CodigoUsuario`) VALUES
(15, 29, 42, 10, 0, 1, 0, 0, 0, 1, 0, '951951', '', 2, 0, 1, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'ASDASD', 'DFGDFG', 0, '2016-12-28 22:11:00', '0000-00-00 00:00:00', '1', '', 1),
(16, 30, 43, 20, 1, 0, 0, 0, 2, 0, 0, '', '1452', 1, 1, 0, '', '2014-06-28 00:00:00', '0000-00-00 00:00:00', 'ASASAS', 'FFFFF', 0, '2016-12-28 22:11:53', '0000-00-00 00:00:00', '0', '', 1),
(17, 31, 44, 30, 0, 1, 49, 55, 0, 1, 0, '1452', '', 2, 0, 2, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'ASDASD', 'DFDFG', 0, '2016-12-28 22:12:43', '0000-00-00 00:00:00', '0', '', 1),
(18, 31, 45, 40, 1, 0, 54, 55, 2, 0, 0, '', '145222', 1, 2, 0, '', '2002-06-23 00:00:00', '0000-00-00 00:00:00', 'ASDASDS', 'DSDFSDFSDF', 0, '2016-12-28 22:13:19', '0000-00-00 00:00:00', '0', '', 1),
(19, 29, 46, 10, 0, 1, 55, 55, 0, 1, 0, '2500', '', 2, 0, 2, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'asdasd', 'dfsdfs', 0, '2016-12-28 22:18:33', '0000-00-00 00:00:00', '1', '', 1),
(20, 30, 47, 40, 0, 1, 52, 59, 0, 1, 0, '1234', '', 2, 0, 2, '', '2013-10-29 00:00:00', '0000-00-00 00:00:00', 'asdasd', 'dsfsdf', 0, '2016-12-28 22:23:15', '0000-00-00 00:00:00', '1', '', 1),
(21, 32, 48, 30, 1, 0, 0, 0, 1, 0, 0, '', ' 1231313', 1, 1, 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'ASDASD', 'ASDASDASDASD', 0, '2016-12-30 03:54:47', '0000-00-00 00:00:00', '1', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_caja_chekera`
--

CREATE TABLE `cji_caja_chekera` (
  `CAJCHEK_Codigo` int(20) NOT NULL,
  `CAJCHEK_Descripcion` varchar(200) NOT NULL,
  `CAJA_Codigo` int(11) NOT NULL,
  `CHEK_Codigo` int(11) NOT NULL,
  `TIPOING_Codigo` int(11) NOT NULL,
  `CAJCHEK_FlagEstado` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_caja_cuenta`
--

CREATE TABLE `cji_caja_cuenta` (
  `CAJCUENT_Codigo` int(20) NOT NULL,
  `CAJA_Codigo` int(11) NOT NULL,
  `CUENT_Codigo` int(11) NOT NULL,
  `TIPOING_Codigo` int(11) NOT NULL,
  `CAJCUENT_LIMITE` varchar(20) NOT NULL,
  `CAJCUENT_FlagEstado` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_cargo`
--

CREATE TABLE `cji_cargo` (
  `CARGP_Codigo` int(11) NOT NULL,
  `CARGC_Descripcion` varchar(150) DEFAULT NULL,
  `CARGC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CARGC_FechaModificacion` datetime DEFAULT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `CARGC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cji_cargo`
--

INSERT INTO `cji_cargo` (`CARGP_Codigo`, `CARGC_Descripcion`, `CARGC_FechaRegistro`, `CARGC_FechaModificacion`, `COMPP_Codigo`, `CARGC_FlagEstado`) VALUES
(1, 'ADMINISTRADOR', '2013-03-19 01:45:19', NULL, 1, '1'),
(2, 'VENDEDOR', '2013-03-19 01:48:06', NULL, 1, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_categoriapublicacion`
--

CREATE TABLE `cji_categoriapublicacion` (
  `CATPUBP_Codigo` int(11) NOT NULL,
  `CATPUBC_Descripcion` varchar(100) NOT NULL,
  `CATPUBC_Orden` int(11) NOT NULL DEFAULT '0',
  `CATPUBC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CATPUBC_FechaModificacion` datetime DEFAULT NULL,
  `CATPUBC_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_centrocosto`
--

CREATE TABLE `cji_centrocosto` (
  `CENCOSP_Codigo` int(11) NOT NULL,
  `CENCOSC_Descripcion` varchar(250) DEFAULT NULL,
  `CENCOSC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CENCOSC_FechaModificacion` datetime DEFAULT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `CENCOSC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_centrocosto`
--

INSERT INTO `cji_centrocosto` (`CENCOSP_Codigo`, `CENCOSC_Descripcion`, `CENCOSC_FechaRegistro`, `CENCOSC_FechaModificacion`, `COMPP_Codigo`, `CENCOSC_FlagEstado`) VALUES
(1, 'FINANZAS', '2011-01-14 20:12:33', NULL, 1, '1'),
(2, 'GERENCIA GENERAL', '2011-01-14 20:12:33', NULL, 1, '1'),
(3, 'ADMINISTRACION', '2011-01-14 20:12:33', NULL, 1, '1'),
(4, 'VENTAS', '2011-01-14 20:12:33', NULL, 1, '1'),
(5, 'CONTABILIDAD', '2011-01-14 20:12:33', NULL, 1, '1'),
(6, 'COMPRAS', '2011-01-14 20:12:33', NULL, 1, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_chekera`
--

CREATE TABLE `cji_chekera` (
  `CHEK_Codigo` int(11) NOT NULL,
  `SERIP_Codigo` varchar(20) DEFAULT NULL,
  `CHEK_Numero` varchar(10) NOT NULL,
  `CUENT_Codigo` int(11) DEFAULT NULL,
  `EMPRP_Codigo` int(11) DEFAULT NULL,
  `PERSP_Codigo` int(11) DEFAULT NULL,
  `CHEK_FechaRegistro` date DEFAULT NULL,
  `CHEK_FechaModificacion` date DEFAULT NULL,
  `CHEK_UsuarioRegistro` int(11) DEFAULT NULL,
  `CHEK_UsuarioModificado` int(11) DEFAULT NULL,
  `CHEK_FlagEstado` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_cheque`
--

CREATE TABLE `cji_cheque` (
  `CHEP_Codigo` int(11) NOT NULL,
  `CHEC_Nro` varchar(50) NOT NULL,
  `CHEC_FEmis` date NOT NULL,
  `CHEC_FVenc` date NOT NULL,
  `CHEC_FlagCobro` varchar(1) NOT NULL DEFAULT '0',
  `CHEC_FCobro` date DEFAULT NULL,
  `CHEC_ObsCobro` text,
  `CHEC_FlagDeposito` char(1) NOT NULL DEFAULT '0',
  `CHEC_FDeposito` date DEFAULT NULL,
  `CHEC_CtaDeposito` int(11) DEFAULT NULL,
  `CHEC_ObsDeposito` text,
  `COMPP_Codigo` int(11) NOT NULL,
  `CHEC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CHEC_FechaModificacion` datetime DEFAULT NULL,
  `CHEC_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_ciiu`
--

CREATE TABLE `cji_ciiu` (
  `CIIUP_Codigo` int(11) NOT NULL,
  `CIIU_CodDivision` varchar(15) DEFAULT NULL,
  `CIIU_CodGrupo` varchar(15) DEFAULT NULL,
  `CIIU_CodClase` varchar(15) DEFAULT NULL,
  `CIIU_Descripcion` varchar(250) DEFAULT NULL,
  `CIIU_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CIIU_FechaModificacion` datetime DEFAULT NULL,
  `CIIU_FlagEstado` char(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_ciiu`
--

INSERT INTO `cji_ciiu` (`CIIUP_Codigo`, `CIIU_CodDivision`, `CIIU_CodGrupo`, `CIIU_CodClase`, `CIIU_Descripcion`, `CIIU_FechaRegistro`, `CIIU_FechaModificacion`, `CIIU_FlagEstado`) VALUES
(0, NULL, NULL, NULL, NULL, '2013-03-16 03:08:04', NULL, '0'),
(1, NULL, NULL, NULL, NULL, '2010-12-17 20:33:03', NULL, '0'),
(100, '1', '0', '0', 'AGRICULTURA, GANADERIA, CAZA Y ACTIVIDADES DE TIPO SERVICIO CONEXAS', '2010-12-31 02:07:29', NULL, '0'),
(110, '1', '1', '0', 'CULTIVOS EN GENERAL CULTIVO DE PRODUCTOS DE MERCADO HORTICULTURA', '2010-12-31 02:07:29', NULL, '0'),
(111, '1', '1', '1', 'CULTIVO DE CEREALES Y OTROS CULTIVOS N.C.P', '2010-12-31 02:07:29', NULL, '0'),
(112, '1', '1', '2', 'CULTIVO DE HORTALIZAS Y LEGUMBRES ESPECIALIDAD HORTICOLAS Y PRODUCTOS DE VIVEROS', '2010-12-31 02:07:29', NULL, '0'),
(113, '1', '1', '3', 'CULTIVO DE FRUTAS, NUECES, PLANTAS DE SUS HOJAS O FRUTO SE PREPARA BEBIDAS, ESP', '2010-12-31 02:07:29', NULL, '0'),
(120, '1', '2', '0', 'CRIA DE ANIMALES', '2010-12-31 02:07:29', NULL, '0'),
(121, '1', '2', '1', 'CRIA DE GANADO VACUNO, OVEJAS, CABRAS, CABALLOS, ETC.', '2010-12-31 02:07:29', NULL, '0'),
(122, '1', '2', '2', 'CRIA DE OTROS ANIMALES ELABORACION DE PRODUCTOS ANIMALES N.C.P.', '2010-12-31 02:07:29', NULL, '0'),
(130, '1', '3', '0', 'CULTIVO DE PRODUCTOS AGRICOLAS EN COMBINACION CON CRIA DE ANIMAL', '2010-12-31 02:07:29', NULL, '0'),
(140, '1', '4', '0', 'ACTIVIDADES DE SERVICIOS AGRICOLAS Y GANADERAS EXCEPTO ACTIVIDADES VETERINARIAS', '2010-12-31 02:07:29', NULL, '0'),
(150, '1', '5', '0', 'CAZA ORDINARIA Y MEDIANTE TRAMPAS, Y REPOBLACION DE ANIMAL Y ACTV. SERV. CONEXAS', '2010-12-31 02:07:29', NULL, '0'),
(200, '2', '0', '0', 'SILVICULTURA, EXTRACCION DE MADERA Y ACTIVIDAD DE SERVICIO CONEXAS', '2010-12-31 02:07:29', NULL, '0'),
(500, '5', '0', '0', 'PESCA,EXPLOTACION CRIADEROS DE PECES Y GRANJAS PISCIC., ACTV. DE SERV. PESQUEROS', '2010-12-31 02:07:29', NULL, '0'),
(1000, '10', '0', '0', 'EXTRACCION DE CARBON Y LIGNITO EXTRACCION DE TURBA', '2010-12-31 02:07:29', NULL, '0'),
(1010, '10', '1', '0', 'EXTRACCION Y AGLOMERACION DE CARBON DE PIEDRA', '2010-12-31 02:07:29', NULL, '0'),
(1020, '10', '2', '0', 'EXTRACCION Y AGLOMERACION DE LIGNITO', '2010-12-31 02:07:29', NULL, '0'),
(1030, '10', '3', '0', 'EXTRACCION Y AGLOMERACION DE TURBA', '2010-12-31 02:07:29', NULL, '0'),
(1100, '11', '0', '0', 'EXTRAC. DE PETROLEO Y GAS NATURAL ACTIV. DE SERVICIOS RELACIONADAS CON EXTRAC.', '2010-12-31 02:07:29', NULL, '0'),
(1110, '11', '1', '0', 'EXTRAC.DE PETROLEO CRUDO Y GAS NATURAL', '2010-12-31 02:07:29', NULL, '0'),
(1120, '11', '2', '0', 'ACTIV. DE SERV. RELACIONADOS CON EXTRACCION DE PETROLEO Y GAS, EXC. ACTV. PROSPE', '2010-12-31 02:07:29', NULL, '0'),
(1200, '12', '0', '0', 'EXTRACCION DE MINERALES DE URANIO Y TORIO', '2010-12-31 02:07:29', NULL, '0'),
(1300, '13', '0', '0', 'EXTRACCION DE MINERALES METALIFEROS', '2010-12-31 02:07:29', NULL, '0'),
(1310, '13', '1', '0', 'EXTRACCION DE MINERALES DE HIERRO', '2010-12-31 02:07:29', NULL, '0'),
(1320, '13', '2', '0', 'EXTRACCION DE MINERALES METALIFEROS NO FERROSOS', '2010-12-31 02:07:29', NULL, '0'),
(1400, '14', '0', '0', 'EXPLOTACION DE OTRAS MINAS Y CANTERAS', '2010-12-31 02:07:29', NULL, '0'),
(1410, '14', '1', '0', 'EXTRACCION DE PIEDRA, ARENA Y ARCILLA', '2010-12-31 02:07:29', NULL, '0'),
(1420, '14', '2', '0', 'EXPLOTACION DE MINAS Y CANTERAS N.C.P.', '2010-12-31 02:07:29', NULL, '0'),
(1421, '14', '2', '1', 'EXTRACCION DE MINERALES PARA FABRIC. ABONOS Y PRODUCTOS QUIMICOS', '2010-12-31 02:07:29', NULL, '0'),
(1422, '14', '2', '2', 'EXTRACCION DE SAL', '2010-12-31 02:07:29', NULL, '0'),
(1429, '14', '2', '9', 'EXPLOT. DE OTRAS MINAS Y CANTERAS N.C.P.', '2010-12-31 02:07:29', NULL, '0'),
(1500, '15', '0', '0', 'ELABORACION DE PRODUCTOS ALIMENTICIOS Y BEBIDAS', '2010-12-31 02:07:29', NULL, '0'),
(1510, '15', '1', '0', 'PRODDUCCION, PROCESAMIENTO Y CONSERVACION DE CARNE, PESCADO, FRUTAS, LEGUMBRES', '2010-12-31 02:07:29', NULL, '0'),
(1511, '15', '1', '1', 'PRODUCCION, PROCESAMIENTO Y CONSERVACION DE CARNE Y PRODUCTOS CARNICOS', '2010-12-31 02:07:29', NULL, '0'),
(1512, '15', '1', '2', 'ELABORACION Y CONSERVACION DE PESCADO Y PRODUCTOS DE PESCADO', '2010-12-31 02:07:29', NULL, '0'),
(1513, '15', '1', '3', 'ELABORACION Y CONSERVACION DE FRUTAS, LEGUMBRES Y HORTALIZAS', '2010-12-31 02:07:29', NULL, '0'),
(1514, '15', '1', '4', 'ELABORACION ACEITES Y GRASAS ORIGEN VEGETAL Y ANIMAL', '2010-12-31 02:07:29', NULL, '0'),
(1515, '15', '1', '5', 'ELABORACION DE ACEITE DE PESCADO', '2010-12-31 02:07:29', NULL, '0'),
(1520, '15', '2', '0', 'ELABORACION DE PRODUCTOS LACTEOS', '2010-12-31 02:07:29', NULL, '0'),
(1530, '15', '3', '0', 'ELABOR. DE PROD. DE MOLINERIA, ALMIDONES Y  DERIVADOS Y ALIMENTOS PREPARADOS', '2010-12-31 02:07:29', NULL, '0'),
(1531, '15', '3', '1', 'ELABORACION DE PRODUCTOS DE MOLINERIA', '2010-12-31 02:07:29', NULL, '0'),
(1532, '15', '3', '2', 'ELABORACION ALMIDONES Y PRODUCTOS DERIVADOS', '2010-12-31 02:07:29', NULL, '0'),
(1533, '15', '3', '3', 'ELABORACION DE ALIMENTOS PREPARADOS PARA ANIMALES', '2010-12-31 02:07:29', NULL, '0'),
(1540, '15', '4', '0', 'COMPLETAR DESCRIPCION', '2010-12-31 02:07:29', NULL, '0'),
(1541, '15', '4', '1', 'ELABORACION DE PRODUCTOS DE PANADERIA', '2010-12-31 02:07:29', NULL, '0'),
(1542, '15', '4', '2', 'ELABORACION DE AZUCAR', '2010-12-31 02:07:29', NULL, '0'),
(1543, '15', '4', '3', 'ELABORACION DE CACAO, CHOCOLATE, PRODUCTOS CONFITERIA', '2010-12-31 02:07:29', NULL, '0'),
(1544, '15', '4', '4', 'ELAB. MACARRONES, FIDEOS, ALCUZCUZ Y PROD. FARINACEOS', '2010-12-31 02:07:29', NULL, '0'),
(1549, '15', '4', '9', 'ELABORACION OTROS PRODUCTOS ALIMENT. N. C. P.', '2010-12-31 02:07:29', NULL, '0'),
(1550, '15', '5', '0', 'ELABORACION DE BEBIDAS', '2010-12-31 02:07:29', NULL, '0'),
(1551, '15', '5', '1', 'DESTILACION RECTIF.Y MEZCLA DE BEBIDAS ALCOH., PROD. ALCOHOL ETILICO DE SUS. FER', '2010-12-31 02:07:29', NULL, '0'),
(1552, '15', '5', '2', 'ELABORACION DE VINOS', '2010-12-31 02:07:29', NULL, '0'),
(1553, '15', '5', '3', 'ELABORACION DE BEBIDAS MALTEADAS Y DE MALTA', '2010-12-31 02:07:29', NULL, '0'),
(1554, '15', '5', '4', 'ELABORACION DE BEBIDAS NO ALCOHOLICAS, AGUAS MINERALES', '2010-12-31 02:07:29', NULL, '0'),
(1600, '16', '0', '0', 'ELABORACION DE PRODUCTOS DE TABACO', '2010-12-31 02:07:29', NULL, '0'),
(1700, '17', '0', '0', 'FABRICACION DE PRODUCTOS TEXTILES', '2010-12-31 02:07:29', NULL, '0'),
(1710, '17', '1', '0', 'HILATURA, TEJEDURA Y ACABADO DE PRODUCTOS TEXTILES', '2010-12-31 02:07:29', NULL, '0'),
(1711, '17', '1', '1', 'PREPARACION E HILATURA DE FIBRAS TEXTILES ,TEJEDURA', '2010-12-31 02:07:29', NULL, '0'),
(1712, '17', '1', '2', 'ACABADO DE PRODUCTOS TEXTILES', '2010-12-31 02:07:29', NULL, '0'),
(1720, '17', '2', '0', 'FABRICACION DE OTROS PRODUCTOS TEXTILES', '2010-12-31 02:07:29', NULL, '0'),
(1721, '17', '2', '1', 'FABRICACION DE ARTICULOS CONFECCIONADOS DE MATERIAS TEXTILES EXCP PREND.DE VESTI', '2010-12-31 02:07:29', NULL, '0'),
(1722, '17', '2', '2', 'FABRICACION DE TAPICES Y ALFOMBRAS', '2010-12-31 02:07:29', NULL, '0'),
(1723, '17', '2', '3', 'FABRICACION DE CUERDAS, CORDELES, BRAMANTES Y REDES', '2010-12-31 02:07:29', NULL, '0'),
(1729, '17', '2', '9', 'FABRICACION DE OTROS PRODUCTOS TEXTILES N.C.P.', '2010-12-31 02:07:29', NULL, '0'),
(1730, '17', '3', '0', 'FABRICACION DE TEJIDOS Y ARTICULOS PUNTO Y GANCHILLO', '2010-12-31 02:07:29', NULL, '0'),
(1800, '18', '0', '0', 'FABRICACION DE PRENDAS DE VESTIR ADOBO Y TEÃIDO DE PIELES', '2010-12-31 02:07:29', NULL, '0'),
(1810, '18', '1', '0', 'FABRICACION PRENDAS DE VESTIR EXCEPTO PRENDAS DE PIEL', '2010-12-31 02:07:29', NULL, '0'),
(1820, '18', '2', '0', 'ADOBO, TEÃIDO DE PIELES, FABRICACION DE ARTICULOS DE PIEL', '2010-12-31 02:07:29', NULL, '0'),
(1900, '19', '0', '0', 'CURTIDO Y ADOBO DE CUEROS FAB. DE MALETAS, ART. TALABARTERIA Y CALZADO', '2010-12-31 02:07:29', NULL, '0'),
(1910, '19', '1', '0', 'CURTIDO Y ADOBO DE CUEROS FAB. DE MALETAS, ART. TALABARTERIA Y GUARNICIONERIA', '2010-12-31 02:07:29', NULL, '0'),
(1911, '19', '1', '1', 'CURTIDO Y ADOBO DE CUEROS', '2010-12-31 02:07:29', NULL, '0'),
(1912, '19', '1', '2', 'FABRICACION MALETAS, BOLSOS MANO Y ART. SIMILARES, Y DE TALABARTERIA Y GUARNI.', '2010-12-31 02:07:29', NULL, '0'),
(1920, '19', '2', '0', 'FABRICACION DE CALZADO', '2010-12-31 02:07:29', NULL, '0'),
(2000, '20', '0', '0', 'PROD.DE MADERA, FAB. PRODUCTOS DE MADERA,CORCHO,PAJA,MATER. TRENSABLE EXC.MUEBLE', '2010-12-31 02:07:29', NULL, '0'),
(2010, '20', '1', '0', 'ASERRADO Y ACEPILLADURA DE MADERA', '2010-12-31 02:07:29', NULL, '0'),
(2020, '20', '2', '0', 'FABRICACION DE PRODUCTOS DE MADERA, CORCHO, PAJA Y MATERIALES TRENZABLES', '2010-12-31 02:07:29', NULL, '0'),
(2021, '20', '2', '1', 'FABRICACION DE HOJAS DE MADERA PARA ENCHAPADO FAB.TABLEROS CONTRACHAP. LAMINADO', '2010-12-31 02:07:29', NULL, '0'),
(2022, '20', '2', '2', 'FABRICACION DE PARTES PIEZAS DE CARPINTERIA, PARA EDIFICIOS Y CONSTRUCCION', '2010-12-31 02:07:29', NULL, '0'),
(2023, '20', '2', '3', 'FABRICACION DE RECIPIENTES DE MADERA', '2010-12-31 02:07:29', NULL, '0'),
(2029, '20', '2', '9', 'FABRICACION DE OTROS PRODUCTOS DE MADERA, CORCHO, PAJA Y MATERIAL TRENZABLE', '2010-12-31 02:07:29', NULL, '0'),
(2100, '21', '0', '0', 'FABRICACION DE PAPEL Y DE PRODUCTOS DE PAPEL', '2010-12-31 02:07:29', NULL, '0'),
(2101, '21', '0', '1', 'FABRICACION DE PASTA DE MADERA, PAPEL Y CARTON', '2010-12-31 02:07:29', NULL, '0'),
(2102, '21', '0', '2', 'FABRICACION DE PAPEL, CARTON ONDULADO Y DE ENVASE DE PAPEL Y CARTON', '2010-12-31 02:07:29', NULL, '0'),
(2109, '21', '0', '9', 'FABRICACION DE OTROS ARTICULOS DE PAPEL Y CARTON', '2010-12-31 02:07:29', NULL, '0'),
(2200, '22', '0', '0', 'ACTIVIDADES DE EDICION E IMPRESION Y DE REPRODUCCION DE GRABACIONES', '2010-12-31 02:07:29', NULL, '0'),
(2210, '22', '1', '0', 'ACTIVIDADES DE EDICION', '2010-12-31 02:07:29', NULL, '0'),
(2211, '22', '1', '1', 'EDICION DE LIBROS, FOLLETOS, PARTITURAS Y OTRAS', '2010-12-31 02:07:29', NULL, '0'),
(2212, '22', '1', '2', 'EDICION DE PERIODICOS, REVISTAS Y PUBLICACIONES PERIODICAS', '2010-12-31 02:07:29', NULL, '0'),
(2213, '22', '1', '3', 'EDICION DE GRABACIONES', '2010-12-31 02:07:29', NULL, '0'),
(2219, '22', '1', '9', 'OTRAS ACTIVIDADES DE EDICION', '2010-12-31 02:07:29', NULL, '0'),
(2220, '22', '2', '0', 'ACTIVIDADES DE IMPRESION Y ACTIVIDADES DE SERVICIOS CONEXAS', '2010-12-31 02:07:29', NULL, '0'),
(2221, '22', '2', '1', 'ACTIVIDADES DE IMPRESION', '2010-12-31 02:07:29', NULL, '0'),
(2222, '22', '2', '2', 'ACTIVIDADES SERVICIOS RELACIONADOS CON LA IMPRESION', '2010-12-31 02:07:29', NULL, '0'),
(2230, '22', '3', '0', 'REPRODUCCION DE GRABACIONES', '2010-12-31 02:07:29', NULL, '0'),
(2300, '23', '0', '0', 'FABRICACION DE COQUE, PRODUCTOS DE LA REFINACION DEL PETROLEO Y COMBUSTIBLE NUCL', '2010-12-31 02:07:29', NULL, '0'),
(2310, '23', '1', '0', 'FABRICACION PRODUCTOS DE HORNOS DE COQUE', '2010-12-31 02:07:29', NULL, '0'),
(2320, '23', '2', '0', 'FABRICACION PRODUCTOS DE LA REFINACION DEL PETROLEO', '2010-12-31 02:07:29', NULL, '0'),
(2330, '23', '3', '0', 'ELABORACION DE COMBUSTIBLE NUCLEAR', '2010-12-31 02:07:29', NULL, '0'),
(2400, '24', '0', '0', 'FABRICACION DE SUSTANCIAS Y PRODUCTOS QUIMICOS', '2010-12-31 02:07:29', NULL, '0'),
(2410, '24', '1', '0', 'FABRICACION DE SUSTANCIAS QUIMICAS BASICAS', '2010-12-31 02:07:29', NULL, '0'),
(2411, '24', '1', '1', 'FABRICACION SUSTANCIAS QUIMICAS BASICAS, EXC. ABONOS', '2010-12-31 02:07:29', NULL, '0'),
(2412, '24', '1', '2', 'FABRICACION DE ABONOS Y COMPUESTOS DE NITROGENO', '2010-12-31 02:07:29', NULL, '0'),
(2413, '24', '1', '3', 'FABRICACION DE PLASTICOS EN FORMAS PRIMARIAS Y CAUCHO', '2010-12-31 02:07:29', NULL, '0'),
(2420, '24', '2', '0', 'FABRICACION DE OTROS PRODUCTOS QUIMICOS', '2010-12-31 02:07:29', NULL, '0'),
(2421, '24', '2', '1', 'FABRICACION DE PLAGUlCIDAS, OTROS PRODUCTOS QUIMICOS DE USO AGROPECUARIO', '2010-12-31 02:07:29', NULL, '0'),
(2422, '24', '2', '2', 'FABRICACION DE PINTURAS, BARNICES Y PRODUCTOS DE REVESTIMIENTO, TINRA IMPRENTA', '2010-12-31 02:07:29', NULL, '0'),
(2423, '24', '2', '3', 'FABRICACION PROD. FARMACEUTICOS, SUSTANCIAS QUIMICAS MEDICINALES, PROD.BOTANICOS', '2010-12-31 02:07:29', NULL, '0'),
(2424, '24', '2', '4', 'FAB. JABONES Y DETERGENTES, PREPARADOS PARA LIMPIAR, PULIR,PERFUMES,PROD.TOCADOR', '2010-12-31 02:07:29', NULL, '0'),
(2429, '24', '2', '9', 'FABRICA DE OTROS PRODUCTOS QUIMICOS N.C.P.', '2010-12-31 02:07:29', NULL, '0'),
(2430, '24', '3', '0', 'FABRICACION DE FIBRAS MANUFACTURADAS', '2010-12-31 02:07:29', NULL, '0'),
(2500, '25', '0', '0', 'FABRICACION DE PRODUCTOS DE CAUCHO Y PLASTICO', '2010-12-31 02:07:29', NULL, '0'),
(2510, '25', '1', '0', 'FABRICACION DE PRODUCTOS DE CAUCHO', '2010-12-31 02:07:29', NULL, '0'),
(2511, '25', '1', '1', 'FABRICA DE CUBIERTAS, CAMARAS CAUCHO REENCAUCHADO', '2010-12-31 02:07:29', NULL, '0'),
(2519, '25', '1', '9', 'FABRICACION DE OTROS PRODUCTOS DE CAUCHO', '2010-12-31 02:07:29', NULL, '0'),
(2520, '25', '2', '0', 'FABRICACION DE PRODUCTOS DE PLASTICO', '2010-12-31 02:07:29', NULL, '0'),
(2600, '26', '0', '0', 'FABRICACION DE OTROS PRODUCTOS MINERALES NO METALICOS', '2010-12-31 02:07:29', NULL, '0'),
(2610, '26', '1', '0', 'FABRICACION DE VIDRIO Y PRODUCTOS DE VIDRIO', '2010-12-31 02:07:29', NULL, '0'),
(2690, '26', '9', '0', 'FABRICACION DE PRODUCTOS MINERALES NO METALICOS N.C.P.', '2010-12-31 02:07:29', NULL, '0'),
(2691, '26', '9', '1', 'FABRICACION DE PRODUCTOS DE CERAMICA NO REFRACTARIA PARA USO NO ESTRUCTURAL', '2010-12-31 02:07:29', NULL, '0'),
(2692, '26', '9', '2', 'FABRICACION DE PRODUCTOS DE CERAMICA REFRACTARIA', '2010-12-31 02:07:29', NULL, '0'),
(2693, '26', '9', '3', 'FABRICACION DE PROD. ARCILLA, CERAMICA NO REFRACTARIAS PARA USO ESTRUCTURAL', '2010-12-31 02:07:29', NULL, '0'),
(2694, '26', '9', '4', 'FABRICACION DE CEMENTO, CAL Y YESO', '2010-12-31 02:07:29', NULL, '0'),
(2695, '26', '9', '5', 'FABRIC. ARTICULOS DE HORMIGON, CEMENTO Y YESO', '2010-12-31 02:07:29', NULL, '0'),
(2696, '26', '9', '6', 'CORTE, TALLADO Y ACABADO DE LA PIEDRA', '2010-12-31 02:07:29', NULL, '0'),
(2699, '26', '9', '9', 'FABRICACION DE OTROS PRODUCTOS MINERALES NO METALICOS N.C.P.', '2010-12-31 02:07:29', NULL, '0'),
(2700, '27', '0', '0', 'FABRICACION DE METALES COMUNES', '2010-12-31 02:07:29', NULL, '0'),
(2710, '27', '1', '0', 'INDUSTRIAS BASICAS DE HIERRO Y DE ACERO', '2010-12-31 02:07:29', NULL, '0'),
(2720, '27', '2', '0', 'FABRICACION DE PRODUCTOS PRIMARIOS DE METALES PRECIOSOS Y NO FERROSOS', '2010-12-31 02:07:29', NULL, '0'),
(2730, '27', '3', '0', 'FUNDICION DE METALES', '2010-12-31 02:07:29', NULL, '0'),
(2731, '27', '3', '1', 'FUNDICION DE HIERRO Y ACERO', '2010-12-31 02:07:29', NULL, '0'),
(2732, '27', '3', '2', 'FUNDICION DE METALES NO FERROSOS', '2010-12-31 02:07:29', NULL, '0'),
(2800, '28', '0', '0', 'FABRICACION DE PRODUCTOS ELABORADOS DE METAL, EXCEPTO MAQUINARIA Y EQUIPO', '2010-12-31 02:07:29', NULL, '0'),
(2810, '28', '1', '0', 'FAB. DE PROD. METALICOS PARA USO ESTRUCTURAL, TANQUES,DEPOSITOS Y GENRADS. VAPOR', '2010-12-31 02:07:29', NULL, '0'),
(2811, '28', '1', '1', 'FABRICACION DE PRODUCTOS METALICOS PARA USO ESTRUCTURAL', '2010-12-31 02:07:29', NULL, '0'),
(2812, '28', '1', '2', 'FABRICACION DE TANQUES, DEPOSITOS Y RECIPIENTES DE METAL', '2010-12-31 02:07:29', NULL, '0'),
(2813, '28', '1', '3', 'FABRICA DE GENERADORES DE VAPOR, EXCEPTO CALDERAS AGUA PARA CALEFACCION CENTRAL', '2010-12-31 02:07:29', NULL, '0'),
(2890, '28', '9', '0', 'FABRICACION DE OTROS PRODUCTOS ELAB. DE METAL, ACTIV. DE SERV. Y TRAB. DE METAL', '2010-12-31 02:07:29', NULL, '0'),
(2891, '28', '9', '1', 'FORJA, PRENSADO, ESTAMPADO, LAMINADO DE METAL', '2010-12-31 02:07:29', NULL, '0'),
(2892, '28', '9', '2', 'TRATAMIENTO, REVESTIMIENTO DE METALES, OBRAS DE ING. MECANICA, POR RETRIB. CONTR', '2010-12-31 02:07:29', NULL, '0'),
(2893, '28', '9', '3', 'FABRICACION DE ART. DE CUCHILLERIA, HERRAMIENTAS DE MANO Y ART. FERRETERIA', '2010-12-31 02:07:29', NULL, '0'),
(2899, '28', '9', '9', 'FABRICACION DE OTROS PRODUCTOS ELABORADOS DE METAL N.C.P.', '2010-12-31 02:07:29', NULL, '0'),
(2900, '29', '0', '0', 'FABRICACION DE MAQUINARIA Y EQUIPO N.C.P.', '2010-12-31 02:07:29', NULL, '0'),
(2910, '29', '1', '0', 'FABRICACION DE MAQUINARIA DE USO GENERAL', '2010-12-31 02:07:29', NULL, '0'),
(2911, '29', '1', '1', 'FABRICACION DE MOTORES, TURBINAS EXCEP.DE MOTORES PARA AERONAVES, VEHICL. AUTOM.', '2010-12-31 02:07:29', NULL, '0'),
(2912, '29', '1', '2', 'FABRICACION DE BOMBAS, COMPRESORES, GRIFOS Y VALVULAS', '2010-12-31 02:07:29', NULL, '0'),
(2913, '29', '1', '3', 'FABRICACION DE COJINETES, ENGRANAJES, PIEZAS DE TRANSMISION', '2010-12-31 02:07:29', NULL, '0'),
(2914, '29', '1', '4', 'FABRICACION DE HORNOS, HOGUERAS Y QUEMADORES', '2010-12-31 02:07:29', NULL, '0'),
(2915, '29', '1', '5', 'FABRICACION DE EQUIPO DE ELEVACION Y MANIPULACION', '2010-12-31 02:07:29', NULL, '0'),
(2919, '29', '1', '9', 'FABRICACION DE OTROS TIPOS DE MAQUINA DE USO GENERAL', '2010-12-31 02:07:29', NULL, '0'),
(2920, '29', '2', '0', 'FABRICACION DE MAQUINARIA DE USO ESPECIAL', '2010-12-31 02:07:29', NULL, '0'),
(2921, '29', '2', '1', 'FABRICACION DE MAQUNARIA AGROPECUARIA Y FORESTAL', '2010-12-31 02:07:29', NULL, '0'),
(2922, '29', '2', '2', 'FABRICACION DE MAQUINAS HERRAMIENTA', '2010-12-31 02:07:29', NULL, '0'),
(2923, '29', '2', '3', 'FABRICACION DE MAQUINARIA PARA LA METALURGIA', '2010-12-31 02:07:29', NULL, '0'),
(2924, '29', '2', '4', 'FABRICACION DE MAQUINAS PARA LA EXPLOTACION DE MINAS, CANTERAS Y CONSTRUCCION', '2010-12-31 02:07:29', NULL, '0'),
(2925, '29', '2', '5', 'FABRICACION DE MAQUINA PARA LA ELABORACION DE ALIMENTOS, BEBIDAS Y TABACOS', '2010-12-31 02:07:29', NULL, '0'),
(2926, '29', '2', '6', 'FABRICACION DE MAQUINAS PARA LA ELAB. DE PRODUCTOS TEXTILES, PRENDAS DE VESTIR', '2010-12-31 02:07:29', NULL, '0'),
(2927, '29', '2', '7', 'FABRICACION DE ARMAS Y MUNICIONES', '2010-12-31 02:07:29', NULL, '0'),
(2929, '29', '2', '9', 'FABRICACION DE OTROS TIPOS DE MAQUINARIA DE USO ESPECIAL', '2010-12-31 02:07:29', NULL, '0'),
(2930, '29', '3', '0', 'FABRICACION DE APARATOS DE USO DOMESTICO N.C.P', '2010-12-31 02:07:29', NULL, '0'),
(3000, '30', '0', '0', 'FABRICACION DE MAQUINA DE OFICINA, CONTABILIDAD E INFORMATICA', '2010-12-31 02:07:29', NULL, '0'),
(3100, '31', '0', '0', 'FABRICACION DE MAQUINARIA Y APARATOS ELECTRICOS N.C.P.', '2010-12-31 02:07:29', NULL, '0'),
(3110, '31', '1', '0', 'FABRICACION DE MOTORES, GENERADORES Y TRANSFORMADORES ELECTRICOS', '2010-12-31 02:07:29', NULL, '0'),
(3120, '31', '2', '0', 'FABRICACION APARATOS  DE DISTRIBUCION Y CONTROL ENERGIA ELECTRICA', '2010-12-31 02:07:29', NULL, '0'),
(3130, '31', '3', '0', 'FABRICACION DE HILOS Y CABLES AISLADOS', '2010-12-31 02:07:29', NULL, '0'),
(3140, '31', '4', '0', 'FABRICACION DE ACUMULADORES DE PILAS Y BATERIAS PRIMARIAS', '2010-12-31 02:07:29', NULL, '0'),
(3150, '31', '5', '0', 'FABRICACION DE LAMPARAS ELECTRICAS Y EQUIPO DE ILUMINACION', '2010-12-31 02:07:29', NULL, '0'),
(3190, '31', '9', '0', 'FABRICA DE OTROS TIPOS DE EQUIPO ELECTRICO N.C.P.', '2010-12-31 02:07:29', NULL, '0'),
(3200, '32', '0', '0', 'FABRICACION DE EQUIPO Y APARATOS DE RADIO, TELEVISION Y COMUNICACIONES', '2010-12-31 02:07:29', NULL, '0'),
(3210, '32', '1', '0', 'FABRICACION DE TUBOS, VALVULAS Y OTROS COMPONENTES ELECTRONICOS', '2010-12-31 02:07:29', NULL, '0'),
(3220, '32', '2', '0', 'FABRICACION DE TRANSMISORES DE RADIO, TV Y TELEGRAFIA', '2010-12-31 02:07:29', NULL, '0'),
(3230, '32', '3', '0', 'FABRICACION DE EQUIPO Y APARATOS DE RADIO, TELEVISION Y COMUNICACIONES, CONEXOS', '2010-12-31 02:07:29', NULL, '0'),
(3300, '33', '0', '0', 'FABRICACION DE INSTRUMENTOS MEDICOS, OPTICOS Y DE PRECISION Y FABR. DE RELOJES', '2010-12-31 02:07:29', NULL, '0'),
(3310, '33', '1', '0', 'FAB. DE APARATOS E INSTR. MEDICOS Y APARATOS PARA MEDIR, VERIFICAR, NAVEGAR, ETC', '2010-12-31 02:07:29', NULL, '0'),
(3311, '33', '1', '1', 'FABRICA DE EQUIPO MEDICO Y QUIRURGICO Y DE APARATO ORTOPEDICO', '2010-12-31 02:07:29', NULL, '0'),
(3312, '33', '1', '2', 'FAB. DE INSTR.Y APARATOS PARA MEDIR,VERIFICAR,ENSAYAR,NAVEGAR  EXCP.DE PROD. IND', '2010-12-31 02:07:29', NULL, '0'),
(3313, '33', '1', '3', 'FABRICACION DE EQUIPO DE CONTROL DE PROCESOS INDUSTRIALES', '2010-12-31 02:07:29', NULL, '0'),
(3320, '33', '2', '0', 'FABRICA DE INSTRUM. DE OPTICA Y EQ.FOTOGRAFICO', '2010-12-31 02:07:29', NULL, '0'),
(3330, '33', '3', '0', 'FABRICACION DE RELOJES', '2010-12-31 02:07:29', NULL, '0'),
(3400, '34', '0', '0', 'FABRICACION DE VEHICULOS AUTOMOTORES, REMOLQUES Y SEMIRREMOLQUES', '2010-12-31 02:07:29', NULL, '0'),
(3410, '34', '1', '0', 'FABRICACION DE VEHICULOS AUTOMOTORES', '2010-12-31 02:07:29', NULL, '0'),
(3420, '34', '2', '0', 'FABRICA DE CARROCERIAS PARA VEHICULO  AUTOMOTORES, REMOLQUES, SEMIREMOLQUES', '2010-12-31 02:07:29', NULL, '0'),
(3430, '34', '3', '0', 'FABRICA DE PARTES, PIEZAS Y ACCES. VEHIC. AUTOMOTORES Y SUS MOTORES', '2010-12-31 02:07:29', NULL, '0'),
(3500, '35', '0', '0', 'FABRICACION DE OTROS TIPOS DE EQUIPO DE TRANSPORTE', '2010-12-31 02:07:29', NULL, '0'),
(3510, '35', '1', '0', 'CONSTRUCCION Y REPARACION DE BUQUES Y OTRAS EMBARCACIONES', '2010-12-31 02:07:29', NULL, '0'),
(3511, '35', '1', '1', 'CONSTRUCCION Y REPARACION DE BUQUES', '2010-12-31 02:07:29', NULL, '0'),
(3512, '35', '1', '2', 'CONSTRUCCION Y REPARACION DE EMBARCACIONES DE RECREO Y DEPORTE', '2010-12-31 02:07:29', NULL, '0'),
(3520, '35', '2', '0', 'FABRICACION DE LOCOMOTORAS Y DE MATERIAL RODANTE PARA FERROCARILES Y TRANVIA', '2010-12-31 02:07:29', NULL, '0'),
(3530, '35', '3', '0', 'FABRICACION DE AERONAVES Y NAVES ESPACIALES', '2010-12-31 02:07:29', NULL, '0'),
(3590, '35', '9', '0', 'FABRICACION DE OTROS TIPOS DE EQUIPO DE TRANSPORTE N.C.P.', '2010-12-31 02:07:29', NULL, '0'),
(3591, '35', '9', '1', 'FABRICACION DE MOTOCICLETAS', '2010-12-31 02:07:29', NULL, '0'),
(3592, '35', '9', '2', 'FABRICACION DE BICICLETAS  Y SILLONES DE RUEDAS PARA INVALIDOS', '2010-12-31 02:07:29', NULL, '0'),
(3599, '35', '9', '9', 'FABRICA DE OTROS TIPOS EQUIPO DE TRANSPORTE N.C.P.', '2010-12-31 02:07:29', NULL, '0'),
(3600, '36', '0', '0', 'FABRICACION DE MUEBLES, INDUSTRIAS, MANUFACTURERAS N.C.P.', '2010-12-31 02:07:29', NULL, '0'),
(3610, '36', '1', '0', 'FABRICACION DE MUEBLES', '2010-12-31 02:07:29', NULL, '0'),
(3690, '36', '9', '0', 'INDUSTRIAS MANUFACTURERAS N.C.P.', '2010-12-31 02:07:29', NULL, '0'),
(3691, '36', '9', '1', 'FABRICACION DE JOYAS Y ARTICULOS CONEXOS', '2010-12-31 02:07:29', NULL, '0'),
(3692, '36', '9', '2', 'FABRICACION DE INSTRUMENTOS DE MUSICA', '2010-12-31 02:07:29', NULL, '0'),
(3693, '36', '9', '3', 'FABRICACION DE ARTICULOS DE DEPORTE', '2010-12-31 02:07:29', NULL, '0'),
(3694, '36', '9', '4', 'FABRICACION DE JUEGOS Y JUGUETES', '2010-12-31 02:07:29', NULL, '0'),
(3699, '36', '9', '9', 'OTRAS INDUSTRIAS MANUFACTURERAS N.C.P.', '2010-12-31 02:07:29', NULL, '0'),
(3700, '37', '0', '0', 'RECICLAMIENTO', '2010-12-31 02:07:29', NULL, '0'),
(3710, '37', '1', '0', 'RECICLAMIENTO DE DESPERDICIOS Y DESECHOS METALICOS', '2010-12-31 02:07:29', NULL, '0'),
(3720, '37', '2', '0', 'RECICLAMIENTO DE DESPERDICIOS Y DESECHOS NO METALICOS', '2010-12-31 02:07:29', NULL, '0'),
(4000, '40', '0', '0', 'SUMINISTRO DE ELECTRICIDAD, GAS, VAPOR Y AGUA CALIENTE', '2010-12-31 02:07:29', NULL, '0'),
(4010, '40', '1', '0', 'GENERACION, CAPTACION Y DISTRIBUCION DE ENERGIA ELECTRICA', '2010-12-31 02:07:29', NULL, '0'),
(4020, '40', '2', '0', 'FABRICACION DE GAS DISTRIBUCION DE COMBUSTIBLES GASEOSOS POR TUBERIAS', '2010-12-31 02:07:29', NULL, '0'),
(4030, '40', '3', '0', 'SUMINISTRO DE VAPOR Y AGUA CALIENTE', '2010-12-31 02:07:29', NULL, '0'),
(4100, '41', '0', '0', 'CAPTACION, DEPURACION Y DISTRIBUCION DE AGUA', '2010-12-31 02:07:29', NULL, '0'),
(4500, '45', '0', '0', 'CONSTRUCCION', '2010-12-31 02:07:29', NULL, '0'),
(4510, '45', '1', '0', 'PREPARACION DEL TERRENO', '2010-12-31 02:07:29', NULL, '0'),
(4520, '45', '2', '0', 'CONSTRUCCION DE EDIFICIOS COMPLETOS Y PARTES DE EDIFICIOS OBRAS DE INGEN. CIVIL', '2010-12-31 02:07:29', NULL, '0'),
(4530, '45', '3', '0', 'ACONDICIONAMIENTO DE EDIFICIOS', '2010-12-31 02:07:29', NULL, '0'),
(4540, '45', '4', '0', 'TERMINACION DE EDIFICIOS', '2010-12-31 02:07:29', NULL, '0'),
(4550, '45', '5', '0', 'ALQUILER DE EQUIPO DE CONSTRUCCION Y DEMOLICION DOTADO CON OPERARIOS', '2010-12-31 02:07:29', NULL, '0'),
(5000, '50', '0', '0', 'VENTA, MANTENIMIENTO Y REPA. DE VEHIC. AUTOMOTORES Y MOTOS, VENTA MENOR COMBUST.', '2010-12-31 02:07:29', NULL, '0'),
(5010, '50', '1', '0', 'VENTA DE VEHICULOS AUTOMOTORES', '2010-12-31 02:07:29', NULL, '0'),
(5020, '50', '2', '0', 'MANTENIMIENTO Y REPARACION VEHICULOS AUTOMOTORES', '2010-12-31 02:07:29', NULL, '0'),
(5030, '50', '3', '0', 'VENTA DE PARTES, PIEZAS Y ACCESORIOS DE VEHICULOS AUTOMOTORES', '2010-12-31 02:07:29', NULL, '0'),
(5040, '50', '4', '0', 'VENTA, MANTENIMIENTO Y REPARACION DE MOTOCICLETAS', '2010-12-31 02:07:29', NULL, '0'),
(5050, '50', '5', '0', 'VENTA AL POR MENOR DE COMBUSTIBLE PARA AUTOMOTORES', '2010-12-31 02:07:29', NULL, '0'),
(5100, '51', '0', '0', 'VENTA AL POR MAYOR Y EN COMISION, EXCEPTO COMERCIO DE VEHICULOS AUTOMOTORES', '2010-12-31 02:07:29', NULL, '0'),
(5110, '51', '1', '0', 'VENTA AL POR MAYOR A CAMBIO RETRIBUCION O POR CONTRATA', '2010-12-31 02:07:29', NULL, '0'),
(5120, '51', '2', '0', 'VENTAS AL MAYOR DE MATERIAS PRIMAS AGROP. ANIMALES VIVOS, ALIMENTOS, BEBIDAS', '2010-12-31 02:07:29', NULL, '0'),
(5121, '51', '2', '1', 'VENTA AL POR MAYOR DE MATERIA PRIMA AGROPECUARIA, ANIMALES VIVOS', '2010-12-31 02:07:29', NULL, '0'),
(5122, '51', '2', '2', 'VENTA AL POR MAYOR ALIMENTOS BEBIDAS Y TABACO', '2010-12-31 02:07:29', NULL, '0'),
(5130, '51', '3', '0', 'VENTA AL POR MAYOR DE ENSERES DOMESTICOS', '2010-12-31 02:07:29', NULL, '0'),
(5131, '51', '3', '1', 'VENTA AL POR MAYOR PRODUCTOS TEXTILES, PRENDAS DE VESTIR, CALZADO', '2010-12-31 02:07:29', NULL, '0'),
(5139, '51', '3', '9', 'VENTA AL POR MAYOR DE OTROS ENSERES DOMESTICOS', '2010-12-31 02:07:29', NULL, '0'),
(5140, '51', '4', '0', 'VENTA AL MAYOR DE PRODUCTOS, INTERMEDIOS, DESPERDICIOS Y DESECHOS NO AGROPEC.', '2010-12-31 02:07:29', NULL, '0'),
(5141, '51', '4', '1', 'VTA. AL POR MAYOR COMBUSTIBLES SOLIDOS, LIQUIDOS Y GASEOSOS Y  PROD. CONEXOS', '2010-12-31 02:07:29', NULL, '0'),
(5142, '51', '4', '2', 'VENTA AL POR MAYOR DE METALES Y MINERALES METALIFEROS', '2010-12-31 02:07:29', NULL, '0'),
(5143, '51', '4', '3', 'VENTA AL POR MAYOR DE MATERIALES DE CONSTRUCCION, FERRETERIA., FONT.Y CALEFAC.', '2010-12-31 02:07:29', NULL, '0'),
(5149, '51', '4', '9', 'VENTA AL POR MAYOR OTROS PRODUCTOS INTERMEDIOS, DESPERDICIOS Y DESECHOS', '2010-12-31 02:07:29', NULL, '0'),
(5150, '51', '5', '0', 'VENTA AL POR MAYOR DE MAQUIN., EQUIPO Y MATER.', '2010-12-31 02:07:29', NULL, '0'),
(5190, '51', '9', '0', 'VENTA AL POR MAYOR DE OTROS PRODUCTOS', '2010-12-31 02:07:29', NULL, '0'),
(5200, '52', '0', '0', 'COMERCIO AL POR MENOR, EXCEPTO VEHIC. AUTOMOTORES, MOTOS Y REPARACION DE ENSERES', '2010-12-31 02:07:29', NULL, '0'),
(5210, '52', '1', '0', 'COMERCIO AL POR MENOR NO ESPECIALIZADO EN ALMACENES', '2010-12-31 02:07:29', NULL, '0'),
(5211, '52', '1', '1', 'VENTA AL POR MENOR EN ALMACENES NO ESPECIALIZADOS', '2010-12-31 02:07:29', NULL, '0'),
(5219, '52', '1', '9', 'VENTA AL POR MENOR DE OTROS PRODUCTOS EN ALMACENES NO ESPECIALIZADOS', '2010-12-31 02:07:29', NULL, '0'),
(5220, '52', '2', '0', 'VENTA AL POR MENOR DE ALIMENTOS, BEBIDAS Y TABACO  EN ALMACENES NO ESPECIALIZADO', '2010-12-31 02:07:29', NULL, '0'),
(5230, '52', '3', '0', 'COMERCIO AL POR MENOR DE OTROS PRODUCTOS NUEVOS EN ALMACENES ESPECIALIZADOS', '2010-12-31 02:07:29', NULL, '0'),
(5231, '52', '3', '1', 'VENTA POR MENOR DE PRODUC. FARMACEUTICOS Y MEDICINALES, COSMETICOS Y ART.TOCADOR', '2010-12-31 02:07:29', NULL, '0'),
(5232, '52', '3', '2', 'VENTA AL POR MENOR DE PRODUCTOS TEXTILES PRENDAS DE VESTIR CALZADO, ART. CUERO', '2010-12-31 02:07:29', NULL, '0'),
(5233, '52', '3', '3', 'VENTA AL POR MENOR APARATOS, ARTICULOS Y EQUIPO DE USO DOMESTICO', '2010-12-31 02:07:29', NULL, '0'),
(5234, '52', '3', '4', 'VENTA AL POR MENOR DE ARTICULOS DE FERRETERIA. PINTURA Y VIDRIO', '2010-12-31 02:07:29', NULL, '0'),
(5239, '52', '3', '9', 'VENTA AL POR MENOR DE OTROS PRODUCTOS EN ALMACENES ESPECIALIZADOS', '2010-12-31 02:07:29', NULL, '0'),
(5240, '52', '4', '0', 'VENTA POR MENOR EN ALMACENES DE ARTICULOS USADOS', '2010-12-31 02:07:29', NULL, '0'),
(5250, '52', '5', '0', 'COMERCIO AL POR MENOR NO REALIZADO EN ALMACENES', '2010-12-31 02:07:29', NULL, '0'),
(5251, '52', '5', '1', 'VENTA POR MENOR DE CASAS DE VENTA POR CORREO', '2010-12-31 02:07:29', NULL, '0'),
(5252, '52', '5', '2', 'VENTA POR MENOR DE PRODUCTOS EN PUESTO DE MERCADO', '2010-12-31 02:07:29', NULL, '0'),
(5259, '52', '5', '9', 'OTROS TIPOS DE VENTA POR MENOR NO REALIZADO EN ALMACENES', '2010-12-31 02:07:29', NULL, '0'),
(5260, '52', '6', '0', 'REPARACION DE EFECTOS PERSONALES Y ENSERES DOMESTICOS', '2010-12-31 02:07:29', NULL, '0'),
(5500, '55', '0', '0', 'HOTELES Y RESTAURANTES', '2010-12-31 02:07:29', NULL, '0'),
(5510, '55', '1', '0', 'HOTELES, CAMPAMENTOS Y OTROS TIPOS HOSPED.TEMPORAL', '2010-12-31 02:07:29', NULL, '0'),
(5520, '55', '2', '0', 'RESTAURANTES, BARES Y CANTINAS', '2010-12-31 02:07:29', NULL, '0'),
(6000, '60', '0', '0', 'TRANSPORTE POR VIA TERRESTRE, TRANSPORTE POR TUBERIAS', '2010-12-31 02:07:29', NULL, '0'),
(6010, '60', '1', '0', 'TRANSPORTE POR VIA FERREA', '2010-12-31 02:07:29', NULL, '0'),
(6020, '60', '2', '0', 'OTROS TIPOS DE TRANSPORTE POR VIA TERRESTRE', '2010-12-31 02:07:29', NULL, '0'),
(6021, '60', '2', '1', 'OTROS TIPOS TRANSPORTE REGULAR DE PASAJEROS POR VIA TERRESTRE', '2010-12-31 02:07:29', NULL, '0'),
(6022, '60', '2', '2', 'OTROS TIPOS TRANSPORTE NO REGULAR DE PASAJEROS VIA TERRESTRE', '2010-12-31 02:07:29', NULL, '0'),
(6023, '60', '2', '3', 'TRANSPORTE DE CARGA POR CARRETERA', '2010-12-31 02:07:29', NULL, '0'),
(6030, '60', '3', '0', 'TRANSPORTE POR TUBERIAS', '2010-12-31 02:07:29', NULL, '0'),
(6100, '61', '0', '0', 'TRANSPORTE POR VIA ACUATICA', '2010-12-31 02:07:29', NULL, '0'),
(6110, '61', '1', '0', 'TRANSPORTE MARITIMO Y DE CABOTAJE', '2010-12-31 02:07:29', NULL, '0'),
(6120, '61', '2', '0', 'TRANSPORTE POR VIAS DE NAVEGACION INTERIORES', '2010-12-31 02:07:29', NULL, '0'),
(6200, '62', '0', '0', 'TRANSPORTE POR VIA AEREA', '2010-12-31 02:07:29', NULL, '0'),
(6210, '62', '1', '0', 'TRANSPORTE REGULAR POR VIA AEREA', '2010-12-31 02:07:29', NULL, '0'),
(6220, '62', '2', '0', 'TRANSPORTE NO REGULAR POR VIA AEREA', '2010-12-31 02:07:29', NULL, '0'),
(6300, '63', '0', '0', 'ACTIV. DE TRANSP. COMPLEMENTARIAS Y AUXILIARES, ACTIVIDADES DE AGENCIAS DE VIAJE', '2010-12-31 02:07:29', NULL, '0'),
(6301, '63', '0', '1', 'MANIPULACION DE LA CARGA', '2010-12-31 02:07:29', NULL, '0'),
(6302, '63', '0', '2', 'ALMACENAMIENTO Y DEPOSITO', '2010-12-31 02:07:29', NULL, '0'),
(6303, '63', '0', '3', 'OTRAS ACTIVIDADES DE TRANSPORTES COMPLEMENTARIAS', '2010-12-31 02:07:29', NULL, '0'),
(6304, '63', '0', '4', 'ACTIVIDADES DE AGENCIAS DE VIAJES Y ORGANIZACION DE EXCURSIONES', '2010-12-31 02:07:29', NULL, '0'),
(6309, '63', '0', '9', 'ACTIVIDADES DE OTRAS AGENCIAS DE TRANSPORTE', '2010-12-31 02:07:29', NULL, '0'),
(6400, '64', '0', '0', 'CORREO Y TELECOMUNICACIONES', '2010-12-31 02:07:29', NULL, '0'),
(6410, '64', '1', '0', 'ACTIVIDADES POSTALES Y DE CORREO', '2010-12-31 02:07:29', NULL, '0'),
(6411, '64', '1', '1', 'ACTIVIDADES POSTALES NACIONALES', '2010-12-31 02:07:29', NULL, '0'),
(6412, '64', '1', '2', 'ACTIVIDADES DE CORREO DISTINTAS DE LAS ACTIVIDADES POSTALES NACIONALES', '2010-12-31 02:07:29', NULL, '0'),
(6420, '64', '2', '0', 'TELECOMUNICACIONES', '2010-12-31 02:07:29', NULL, '0'),
(6500, '65', '0', '0', 'INTERMEDIACION FINANCIERA, EXCEPTO FINANCIACION DE PLANES DE SEGUROS Y PENSIONES', '2010-12-31 02:07:29', NULL, '0'),
(6510, '65', '1', '0', 'INTERMEDIACION MONETARIA', '2010-12-31 02:07:29', NULL, '0'),
(6511, '65', '1', '1', 'BANCA CENTRAL', '2010-12-31 02:07:29', NULL, '0'),
(6519, '65', '1', '9', 'OTROS TIPOS DE INTERMEDIACION MONETARIA', '2010-12-31 02:07:29', NULL, '0'),
(6590, '65', '9', '0', 'OTROS TIPOS DE INTERMEDIACION FINANCIERA', '2010-12-31 02:07:29', NULL, '0'),
(6591, '65', '9', '1', 'ARRENDAMIENTO FINANCIERO', '2010-12-31 02:07:29', NULL, '0'),
(6592, '65', '9', '2', 'OTROS TIPOS DE CREDITO', '2010-12-31 02:07:29', NULL, '0'),
(6599, '65', '9', '9', 'OTROS TIPOS DE INTERMEDIACION FINANCIERA N.C.P', '2010-12-31 02:07:29', NULL, '0'),
(6600, '66', '0', '0', 'FINANCIACION DE PLANES DE SEGUROS Y DE PENSIONES, EXCP. LOS PLANES DEL IPSS', '2010-12-31 02:07:29', NULL, '0'),
(6601, '66', '0', '1', 'PLANES DE SEGUROS DE VIDA', '2010-12-31 02:07:29', NULL, '0'),
(6602, '66', '0', '2', 'PLANES DE PENSIONES', '2010-12-31 02:07:29', NULL, '0'),
(6603, '66', '0', '3', 'PLANES DE SEGUROS GENERALES', '2010-12-31 02:07:29', NULL, '0'),
(6711, '67', '1', '1', 'ADMINISTRACION DE MERCADOS FINANCIEROS', '2010-12-31 02:07:29', NULL, '0'),
(6712, '67', '1', '2', 'ACTIVIDADES BURSATILES', '2010-12-31 02:07:29', NULL, '0'),
(6719, '67', '1', '9', 'ACTIVIDADES AUXILIARES DE LA INTERMEDIACION FINANCIERA  N.C.P.', '2010-12-31 02:07:29', NULL, '0'),
(6720, '67', '2', '0', 'ACTIVIDADES AUXILIARES FINANCIACION DE PLANES SEGUROS Y PENSIONES', '2010-12-31 02:07:29', NULL, '0'),
(7000, '70', '0', '0', 'ACTIVIDADES INMOBILIARIAS', '2010-12-31 02:07:29', NULL, '0'),
(7010, '70', '1', '0', 'ACTIVIDADES INMOBILIARIAS CON BIENES PROPIOS O ARRENDADOS', '2010-12-31 02:07:29', NULL, '0'),
(7020, '70', '2', '0', 'ACTIVIDADES INMOBILIARIAS REALIZADAS A CAMBIO DE UNA RETRIBUCION O POR CONTRATA', '2010-12-31 02:07:29', NULL, '0'),
(7100, '71', '0', '0', 'ALQUILER DE MAQUINARIA Y EQUIPO SIN OPERARIOS Y DE EFECTOS PERSONALES Y ENSERES', '2010-12-31 02:07:29', NULL, '0'),
(7110, '71', '1', '0', 'ALQUILER DE EQUIPO DE TRANSPORTE', '2010-12-31 02:07:29', NULL, '0'),
(7111, '71', '1', '1', 'ALQUILER DE EQUIPO DE TRANSPORTE POR VIA TERRESTRE', '2010-12-31 02:07:29', NULL, '0'),
(7112, '71', '1', '2', 'ALQUILER DE EQUIPO DE TRANSPORTE POR VIA ACUATICA', '2010-12-31 02:07:29', NULL, '0'),
(7113, '71', '1', '3', 'ALQUILER DE EQUIPO DE TRANSPORTE POR VIA AEREA', '2010-12-31 02:07:29', NULL, '0'),
(7120, '71', '2', '0', 'ALQUILER DE OTROS TIPOS DE MAQUINARIA Y EQUIPO', '2010-12-31 02:07:29', NULL, '0'),
(7121, '71', '2', '1', 'ALQUILER DE MAQUINARIA Y EQUIPO AGROPECUARIO', '2010-12-31 02:07:29', NULL, '0'),
(7122, '71', '2', '2', 'ALQUILER DE MAQUINARIA Y EQUIPO DE CONSTRUCCION', '2010-12-31 02:07:29', NULL, '0'),
(7123, '71', '2', '3', 'ALQUILER DE MAQUINARIA Y EQ. DE OFICINA (INCLUSO COMPUTADORAS)', '2010-12-31 02:07:29', NULL, '0'),
(7129, '71', '2', '9', 'ALQ.DE OTROS TIPOS DE MAQUINARIA Y EQUIPO  N.C.P.', '2010-12-31 02:07:29', NULL, '0'),
(7130, '71', '3', '0', 'ALQUILER DE EFECTOS PERSONALES Y ENSERES DOMESTICOS', '2010-12-31 02:07:29', NULL, '0'),
(7200, '72', '0', '0', 'INFORMATICA Y ACTIVIDADES CONEXAS', '2010-12-31 02:07:29', NULL, '0'),
(7210, '72', '1', '0', 'CONSULTORES EN EQUIPO DE INFORMATICA', '2010-12-31 02:07:29', NULL, '0'),
(7220, '72', '2', '0', 'CONSULTORES EN PROGRAMAS DE INFORMATICA Y SUMINISTROS', '2010-12-31 02:07:29', NULL, '0'),
(7230, '72', '3', '0', 'PROCESAMIENTO DE DATOS', '2010-12-31 02:07:29', NULL, '0'),
(7240, '72', '4', '0', 'ACTIVIDADES RELACIONADAS CON BASES DE DATOS', '2010-12-31 02:07:29', NULL, '0'),
(7250, '72', '5', '0', 'MANTENIMIENTO Y REPARACION DE MAQUINA DE OFICINA E INFORMATICA', '2010-12-31 02:07:29', NULL, '0'),
(7290, '72', '9', '0', 'OTRAS ACTIVIDADES DE INFORMATICA', '2010-12-31 02:07:29', NULL, '0'),
(7300, '73', '0', '0', 'INVESTIGACION Y DESARROLLO', '2010-12-31 02:07:29', NULL, '0'),
(7310, '73', '1', '0', 'INVESTIGACION Y DESARROLLO DE LAS CIENCIAS NATURALES E INGENIERIA', '2010-12-31 02:07:29', NULL, '0'),
(7320, '73', '2', '0', 'INVESTIGACION Y DESARROLLO DE LAS CIENCIAS SOCIALES Y HUMANIDADES.', '2010-12-31 02:07:29', NULL, '0'),
(7400, '74', '0', '0', 'OTRAS ACTIVIDADES EMPRESARIALES', '2010-12-31 02:07:29', NULL, '0'),
(7410, '74', '1', '0', 'ACTIV. JURIDICAS, DE CONTABILIDAD, Y AUDITORIAASESORAMIENTO A EMP. EN TRIB. ETC', '2010-12-31 02:07:29', NULL, '0'),
(7411, '74', '1', '1', 'ACTIVIDADES JURIDICAS', '2010-12-31 02:07:29', NULL, '0'),
(7412, '74', '1', '2', 'ACTIVIDADES DE CONTABILIDAD, Y AUDITORIA ASESORAMIENTO TRIBUTARIO', '2010-12-31 02:07:29', NULL, '0'),
(7413, '74', '1', '3', 'INVESTIGACION DE MERCADO Y REALIZACION DE ENCUESTAS DE OPINION PUBLICA', '2010-12-31 02:07:29', NULL, '0'),
(7414, '74', '1', '4', 'ACTIVIDADES DE ASESORAMIENTO EMPRESARIAL Y EN MATERIA DE GESTION', '2010-12-31 02:07:29', NULL, '0'),
(7420, '74', '2', '0', 'ACTIVIDADES DE ARQUITECTURA E INGENIERIA Y OTRAS ACTIVIDADES TECNICAS', '2010-12-31 02:07:29', NULL, '0'),
(7421, '74', '2', '1', 'ACTIVIDADES DE ARQUITECTURA E INGENIERIA Y ASESORAMIENTO TECNICO', '2010-12-31 02:07:29', NULL, '0'),
(7422, '74', '2', '2', 'ENSAYOS Y ANALISIS TECNICOS', '2010-12-31 02:07:29', NULL, '0'),
(7430, '74', '3', '0', 'PUBLICIDAD', '2010-12-31 02:07:29', NULL, '0'),
(7490, '74', '9', '0', 'ACTIVIDADES EMPRESARIALES N.C.P.', '2010-12-31 02:07:29', NULL, '0'),
(7491, '74', '9', '1', 'OBTENCION Y DOTACION DE PERSONAL', '2010-12-31 02:07:29', NULL, '0'),
(7492, '74', '9', '2', 'ACTIVIDADES DE INVESTIGACION Y SEGURIDAD', '2010-12-31 02:07:29', NULL, '0'),
(7493, '74', '9', '3', 'ACTIVIDADES DE LIMPIEZA DE EDIFICIOS', '2010-12-31 02:07:29', NULL, '0'),
(7494, '74', '9', '4', 'ACTIVIDADES DE FOTOGRAFIA', '2010-12-31 02:07:29', NULL, '0'),
(7495, '74', '9', '5', 'ACTIVIDADES DE ENVASE Y EMPAQUE', '2010-12-31 02:07:29', NULL, '0'),
(7499, '74', '9', '9', 'OTRAS ACTIVIDADES EMPRESARIALES N.C.P.', '2010-12-31 02:07:29', NULL, '0'),
(7500, '75', '0', '0', 'ADMINISTRACION PUBLICA Y DEFENSA, PLANES DE SEGURS. SOCIAL DE AFILIACION OBLIG.', '2010-12-31 02:07:29', NULL, '0'),
(7510, '75', '1', '0', 'ADMINISTRACION DEL ESTADO Y APLICACION DE LA POLITICA ECON. Y SOCIAL DE LA COMU.', '2010-12-31 02:07:29', NULL, '0'),
(7511, '75', '1', '1', 'ACTIVIDADES DE LA ADMINISTRACION PUBLICA EN GENERAL', '2010-12-31 02:07:29', NULL, '0'),
(7512, '75', '1', '2', 'REGUL.ACTIVIDADES DE ORGAN.PRESTAN SERVICIOS', '2010-12-31 02:07:29', NULL, '0'),
(7513, '75', '1', '3', 'REGULAC. Y FACILITAC. DE LA ACTIVIDAD ECONOM.', '2010-12-31 02:07:29', NULL, '0'),
(7514, '75', '1', '4', 'ACTIVIDADES AUXLIARES DE TIPO SERVICIO PARA ADM. PUBLICA GENERAL', '2010-12-31 02:07:29', NULL, '0'),
(7520, '75', '2', '0', 'PRESTACION DE SERVICIOS A LA COMUNIDAD EN GENERAL', '2010-12-31 02:07:29', NULL, '0'),
(7521, '75', '2', '1', 'RELACIONES EXTERIORES', '2010-12-31 02:07:29', NULL, '0'),
(7522, '75', '2', '2', 'ACTIVIDADES DE DEFENSA', '2010-12-31 02:07:29', NULL, '0'),
(7523, '75', '2', '3', 'ACTIVIDADES DE MANTENIMIENTO DEL ORDEN PUBLICO', '2010-12-31 02:07:29', NULL, '0'),
(7530, '75', '3', '0', 'ACTIVIDADES DE PLANES DE SEGURIDAD SOCIAL, AFILIACION OBLIGATORIA', '2010-12-31 02:07:29', NULL, '0'),
(8000, '80', '0', '0', 'ENSEÃANZA', '2010-12-31 02:07:29', NULL, '0'),
(8010, '80', '1', '0', 'ENSEÃANZA PRIMARIA', '2010-12-31 02:07:29', NULL, '0'),
(8020, '80', '2', '0', 'ENSEÃANZA SECUNDARIA', '2010-12-31 02:07:29', NULL, '0'),
(8021, '80', '2', '1', 'ENSEÃANZA SECUNDARIA DE FORMACION GENERAL', '2010-12-31 02:07:29', NULL, '0'),
(8022, '80', '2', '2', 'ENSEÃANZA SECUNDARIA DE FORMACION TECNICA Y PROFESIONAL', '2010-12-31 02:07:29', NULL, '0'),
(8030, '80', '3', '0', 'ENSEÃANZA SUPERIOR', '2010-12-31 02:07:29', NULL, '0'),
(8090, '80', '9', '0', 'EDUCACION DE ADULTOS Y OTROS TIPOS DE ENSEÃANZA', '2010-12-31 02:07:29', NULL, '0'),
(8500, '85', '0', '0', 'ACTIVIDADES DE SERVICIOS SOCIALES Y DE SALUD', '2010-12-31 02:07:29', NULL, '0'),
(8510, '85', '1', '0', 'ACTIVIDADES RELACIONADAS CON LA SALUD HUMANA', '2010-12-31 02:07:29', NULL, '0'),
(8511, '85', '1', '1', 'ACTIVIDADES DE HOSPITALES', '2010-12-31 02:07:29', NULL, '0'),
(8512, '85', '1', '2', 'ACTIVIDADES DE MEDICOS Y ODONTOLOGOS', '2010-12-31 02:07:29', NULL, '0'),
(8519, '85', '1', '9', 'OTRAS ACTIV.RELACIONADAS CON LA SALUD HUMANA', '2010-12-31 02:07:29', NULL, '0'),
(8520, '85', '2', '0', 'ACTIVIDADES VETERINARIAS', '2010-12-31 02:07:29', NULL, '0'),
(8530, '85', '3', '0', 'ACTIVIDADES DE SERVICIOS SOCIALES', '2010-12-31 02:07:29', NULL, '0'),
(8531, '85', '3', '1', 'SERVICIOS SOCIALES CON ALOJAMIENTO', '2010-12-31 02:07:29', NULL, '0'),
(8532, '85', '3', '2', 'SERVICIOS SOCIALES SIN ALOJAMIENTO', '2010-12-31 02:07:29', NULL, '0'),
(9000, '90', '0', '0', 'ELIMINACION DE DESPERDICIOS Y DE AGUAS RESIDUALES Y SANEAMIENTO,  ACTIVIDADES SIMILARES', '2010-12-31 02:07:29', NULL, '0'),
(9100, '91', '0', '0', 'ACTIVIDADES DE ASOCIACIONES N.C.P.', '2010-12-31 02:07:29', NULL, '0'),
(9110, '91', '1', '0', 'ACTIVIDADES DE ORGANIZACIONES EMPRESARIALES,PROFESIONALES Y DE EMPLEADORES', '2010-12-31 02:07:29', NULL, '0'),
(9111, '91', '1', '1', 'ACTIV.DE ORGANIZACION EMPRESARIAL Y EMPLEADORES', '2010-12-31 02:07:29', NULL, '0'),
(9112, '91', '1', '2', 'ACTIVIDADES DE ORGANIZACIONES PROFESIONALES', '2010-12-31 02:07:29', NULL, '0'),
(9120, '91', '2', '0', 'ACTIVIDADES DE SINDICATOS', '2010-12-31 02:07:29', NULL, '0'),
(9190, '91', '9', '0', 'ACTIVIDADES DE OTRAS ASOCIACIONES', '2010-12-31 02:07:29', NULL, '0'),
(9191, '91', '9', '1', 'ACTIVIDADES DE ORGANIZACIONES RELIGIOSAS', '2010-12-31 02:07:29', NULL, '0'),
(9192, '91', '9', '2', 'ACTIVIDADES DE ORGANIZACIONES POLITICAS', '2010-12-31 02:07:29', NULL, '0'),
(9199, '91', '9', '9', 'ACTIVIDADES DE OTRAS ASOCIACIONES N.C.P.', '2010-12-31 02:07:29', NULL, '0'),
(9200, '92', '0', '0', 'ACTIVIDADES DE ESPARCIMIENTO Y ACTIVIDADES CULTURALES Y DEPORTIVAS', '2010-12-31 02:07:29', NULL, '0'),
(9210, '92', '1', '0', 'ACTIV. DE CINEMATOGRAFIA, RADIO Y TELEVISION Y OTRAS ACTIVIDADES DE ENTRETENIM.', '2010-12-31 02:07:29', NULL, '0'),
(9211, '92', '1', '1', 'PRODUCCION Y DISTRIB. DE FILMES Y VIDEOCINTAS', '2010-12-31 02:07:29', NULL, '0'),
(9212, '92', '1', '2', 'EXHIBICION DE FILMES Y VIDEOCINTAS', '2010-12-31 02:07:29', NULL, '0'),
(9213, '92', '1', '3', 'ACTIVIDADES DE RADIO Y TELEVISION', '2010-12-31 02:07:29', NULL, '0'),
(9214, '92', '1', '4', 'ACTIVIDADES TEATRALES Y MUSICALES', '2010-12-31 02:07:29', NULL, '0'),
(9219, '92', '1', '9', 'OTRAS ACTIVIDADES DE ENTRETENIMIENTO N.C.P', '2010-12-31 02:07:29', NULL, '0'),
(9220, '92', '2', '0', 'ACTIVIDADES DE AGENCIAS DE NOTICIAS', '2010-12-31 02:07:29', NULL, '0'),
(9230, '92', '3', '0', 'ACTIVIDADES DE BIBLIOTECAS, ARCHIVOS Y MUSEOS Y OTRAS ACTIVIDADES CULTURALES', '2010-12-31 02:07:29', NULL, '0'),
(9231, '92', '3', '1', 'ACTIVIDADES DE BIBLIOTECAS Y ARCHIVOS', '2010-12-31 02:07:29', NULL, '0'),
(9232, '92', '3', '2', 'ACTIVIDADES DE MUSEOS Y PRESERVACION DE LUGARES Y EDIFICIOS HISTORICOS', '2010-12-31 02:07:29', NULL, '0'),
(9233, '92', '3', '3', 'ACTIVIDADES DE JARDINES BOTANICOS, ZOOLOGICOS Y PARQUE NACIONAL', '2010-12-31 02:07:29', NULL, '0'),
(9240, '92', '4', '0', 'ACTIVIDADES DEPORTIVAS Y OTRAS ACTIVIDADES DE ESPARCIMIENTO', '2010-12-31 02:07:29', NULL, '0'),
(9241, '92', '4', '1', 'ACTIVIDADES DEPORTIVAS', '2010-12-31 02:07:29', NULL, '0'),
(9249, '92', '4', '9', 'OTRAS ACTIVIDADES DE ESPARCIMIENTO', '2010-12-31 02:07:29', NULL, '0'),
(9300, '93', '0', '0', 'OTRAS ACTIVIDADES DE SERVICIOS', '2010-12-31 02:07:29', NULL, '0'),
(9301, '93', '0', '1', 'LAVADO Y LIMPIEZA DE PRENDAS DE TELA Y DE PIEL', '2010-12-31 02:07:29', NULL, '0'),
(9302, '93', '0', '2', 'PELUQUERIA Y OTROS TRATAMIENTOS DE BELLEZA', '2010-12-31 02:07:29', NULL, '0'),
(9303, '93', '0', '3', 'POMPAS FUNEBRES Y ACTIVIDADES CONEXAS', '2010-12-31 02:07:29', NULL, '0'),
(9309, '93', '0', '9', 'OTRAS ACTIVIDADES DE TIPO SERVICIO N.C.P', '2010-12-31 02:07:29', NULL, '0'),
(9500, '95', '0', '0', 'HOGARES PRIVADOS CON SERVICIO DOMESTICO', '2010-12-31 02:07:29', NULL, '0'),
(9900, '99', '0', '0', 'ORGANIZACIONES Y ORGANOS EXTRATERRITORIALES', '2010-12-31 02:07:29', NULL, '0'),
(9990, '99', '9', '0', 'OTRAS ACTIVIDADES NO ESPECIFICADAS', '2010-12-31 02:07:29', NULL, '0'),
(9999, '99', '9', '9', 'OTRAS ACTIVIDADES NO CLASIFICAD.EN OTRA PARTE', '2010-12-31 02:07:29', NULL, '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_cliente`
--

CREATE TABLE `cji_cliente` (
  `CLIP_Codigo` int(11) NOT NULL,
  `EMPRP_Codigo` int(11) NOT NULL,
  `PERSP_Codigo` int(11) NOT NULL,
  `CLIC_FechaRegistro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `CLIC_FechaModificacion` datetime DEFAULT NULL,
  `CLIC_TipoPersona` char(1) DEFAULT NULL,
  `TIPCLIP_Codigo` int(11) DEFAULT NULL,
  `FORPAP_Codigo` int(11) DEFAULT NULL,
  `CLIC_flagCalifica` int(11) NOT NULL COMMENT '0:Excelente; 1:bueno; 2:regular; 3:malo; 4:negativo',
  `CLIC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cji_cliente`
--

INSERT INTO `cji_cliente` (`CLIP_Codigo`, `EMPRP_Codigo`, `PERSP_Codigo`, `CLIC_FechaRegistro`, `CLIC_FechaModificacion`, `CLIC_TipoPersona`, `TIPCLIP_Codigo`, `FORPAP_Codigo`, `CLIC_flagCalifica`, `CLIC_FlagEstado`) VALUES
(4, 208, 0, '2017-01-23 21:15:00', NULL, '1', 0, NULL, 0, '1'),
(5, 0, 16, '2017-01-24 17:00:32', NULL, '0', 0, NULL, 0, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_clientecompania`
--

CREATE TABLE `cji_clientecompania` (
  `CLIP_Codigo` int(11) NOT NULL,
  `COMPP_Codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_clientecompania`
--

INSERT INTO `cji_clientecompania` (`CLIP_Codigo`, `COMPP_Codigo`) VALUES
(4, 1),
(5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_compadocumenitem`
--

CREATE TABLE `cji_compadocumenitem` (
  `COMPADOCUITEM_Codigo` int(11) NOT NULL,
  `COMPADOCUITEM_Descripcion` varchar(250) DEFAULT NULL,
  `COMPADOCUITEM_Abreviatura` varchar(250) DEFAULT NULL,
  `COMPADOCUITEM_Valor` varchar(250) DEFAULT NULL,
  `COMPADOCUITEM_UsuCrea` varchar(220) DEFAULT NULL,
  `COMPADOCUITEM_UsuModi` varchar(220) DEFAULT NULL,
  `COMPADOCUITEM_FechaModi` datetime DEFAULT NULL,
  `COMPADOCUITEM_FechaIng` datetime DEFAULT NULL,
  `COMPADOCUITEM_Estado` char(1) DEFAULT NULL,
  `DOCUITEM_Codigo` int(11) NOT NULL,
  `COMPCONFIDOCP_Codigo` int(11) NOT NULL,
  `COMPADOCUITEM_Width` double DEFAULT NULL,
  `COMPADOCUITEM_Height` double DEFAULT NULL,
  `COMPADOCUITEM_Activacion` varchar(200) DEFAULT NULL,
  `COMPADOCUITEM_PosicionX` double DEFAULT NULL,
  `COMPADOCUITEM_PosicionY` double DEFAULT NULL,
  `COMPADOCUITEM_Variable` varchar(200) DEFAULT NULL,
  `COMPADOCUITEM_TamanioLetra` int(11) DEFAULT NULL,
  `COMPADOCUITEM_TipoLetra` varchar(250) DEFAULT NULL,
  `COMPADOCUITEM_Nombre` varchar(50) DEFAULT NULL,
  `COMPADOCUITEM_Listado` int(1) NOT NULL,
  `COMPADOCUITEM_VGrupo` varchar(50) NOT NULL,
  `COMPADOCUITEM_Alineamiento` varchar(2) NOT NULL,
  `COMPADOCUITEM_Convertiraletras` int(2) NOT NULL COMMENT 'el numero debe ser convertido a letra'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cji_compadocumenitem`
--

INSERT INTO `cji_compadocumenitem` (`COMPADOCUITEM_Codigo`, `COMPADOCUITEM_Descripcion`, `COMPADOCUITEM_Abreviatura`, `COMPADOCUITEM_Valor`, `COMPADOCUITEM_UsuCrea`, `COMPADOCUITEM_UsuModi`, `COMPADOCUITEM_FechaModi`, `COMPADOCUITEM_FechaIng`, `COMPADOCUITEM_Estado`, `DOCUITEM_Codigo`, `COMPCONFIDOCP_Codigo`, `COMPADOCUITEM_Width`, `COMPADOCUITEM_Height`, `COMPADOCUITEM_Activacion`, `COMPADOCUITEM_PosicionX`, `COMPADOCUITEM_PosicionY`, `COMPADOCUITEM_Variable`, `COMPADOCUITEM_TamanioLetra`, `COMPADOCUITEM_TipoLetra`, `COMPADOCUITEM_Nombre`, `COMPADOCUITEM_Listado`, `COMPADOCUITEM_VGrupo`, `COMPADOCUITEM_Alineamiento`, `COMPADOCUITEM_Convertiraletras`) VALUES
(71, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-11 21:52:23', '1', 9, 9, 63, 20, '0', 43, 472, 'CANTIDAD', 8, 'arial', 'Cantidad', 0, '', 'L', 0),
(72, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-11 21:52:23', '1', 9, 9, 20, 20, '1', 129, 12, 'variable', 8, 'arial', 'DestinoNombre', 0, '', 'L', 0),
(73, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-11 21:52:23', '1', 9, 9, 20, 20, '1', 199, 20, 'variable', 8, 'arial', 'DestinoRuc', 0, '', 'L', 0),
(74, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-11 21:52:23', '1', 9, 9, 183, 34, '0', 64, 300, 'FECHAEMI', 14, 'arial', 'FechaEmision', 0, '', 'C', 0),
(75, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-11 21:52:23', '1', 9, 9, 20, 20, '1', 290, 6, 'variable', 8, 'arial', 'FechaRecepcion', 0, '', 'L', 0),
(76, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-11 21:52:23', '1', 9, 9, 350, 10, '0', 203, 474, 'NOMBREP', 8, 'arial', 'DescripcionProducto', 0, '', 'L', 0),
(77, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-11 21:52:23', '1', 9, 9, 80, 21, '0', 569, 473, 'PUNIT', 8, 'arial', 'PrecioUnitario', 0, '', 'L', 0),
(78, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-11 21:52:23', '1', 9, 9, 132, 24, '0', 11, 87, 'IMPORTEP', 8, 'arial', 'ImporteProducto', 0, '', 'L', 0),
(79, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-11 21:52:23', '1', 9, 9, 85, 20, '0', 662, 473, 'TOTALP', 8, 'arial', 'TotalProducto', 0, '', 'L', 0),
(80, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-11 21:52:23', '1', 9, 9, 121, 20, '1', 399, 43, 'variable', 8, 'arial', 'NroOrdenVenta', 0, '', 'L', 0),
(81, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-11 21:52:23', '1', 9, 9, 89, 17, '1', 530, 47, 'variable', 8, 'arial', 'Vendedor', 0, '', 'L', 0),
(82, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-11 21:52:23', '1', 9, 9, 123, 34, '1', 330, 297, 'variable', 8, 'arial', 'GuiaRemision', 0, '', 'L', 0),
(83, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-11 21:52:23', '1', 9, 9, 126, 23, '1', 254, 41, 'SUBTOTAL', 8, 'arial', 'SubTotal', 0, '', 'L', 0),
(84, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-11 21:52:23', '1', 9, 9, 58, 15, '1', 627, 48, 'IGV', 8, 'arial', 'IGV', 0, '', 'L', 0),
(85, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-11 21:52:23', '1', 9, 9, 80, 40, '0', 664, 853, 'TOTAL', 8, 'arial', 'Total', 0, '', 'L', 0),
(86, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-11 21:52:23', '1', 9, 9, 436, 20, '0', 117, 815, 'MONTOLET', 8, 'arial', 'MontoEnLetras', 0, '', 'L', 1),
(87, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-23 20:36:08', '1', 10, 10, 365, 10, '0', 65, 127, 'NOMBRE', 8, 'arial', 'Nombre', 0, '', 'L', 0),
(88, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-23 20:36:08', '1', 10, 10, 380, 10, '0', 50, 160, 'RUC', 8, 'arial', 'Ruc', 0, '', 'L', 0),
(89, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-23 20:36:08', '1', 10, 10, 355, 10, '0', 77, 144, 'DIRECCION', 8, 'arial', 'Direccion', 0, '', 'L', 0),
(90, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-23 20:36:08', '1', 10, 10, 58, 10, '0', 477, 490, 'CANTIDAD', 8, 'arial', 'Cantidad', 0, 'grupo', 'L', 0),
(91, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-23 20:36:08', '1', 10, 10, 288, 10, '0', 91, 365, 'DESTINO', 8, 'arial', 'DestinoNombre', 0, '', 'L', 0),
(92, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-23 20:36:08', '1', 10, 10, 176, 38, '0', 293, 488, 'NUEVOSS', 8, 'arial', 'DestinoRuc', 0, 'grupo2', 'L', 0),
(93, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-23 20:36:08', '1', 10, 10, 266, 12, '1', 107, 189, 'variable', 8, 'arial', 'FechaEmision', 0, '', 'L', 0),
(94, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-23 20:36:08', '1', 10, 10, 211, 10, '1', 162, 208, 'variable', 8, 'arial', 'FechaRecepcion', 0, '', 'L', 0),
(95, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-23 20:36:08', '1', 10, 10, 270, 35, '0', 19, 489, 'DESCRIP', 8, 'arial', 'DescripcionProducto', 0, 'grupo', 'L', 0),
(96, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-23 20:36:08', '1', 10, 10, 220, 12, '0', 512, 401, 'INSCRIPCIO', 8, 'arial', 'PrecioUnitario', 0, '', 'L', 0),
(97, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-23 20:36:08', '1', 10, 10, 306, 12, '0', 428, 384, 'PLACASS', 8, 'arial', 'ImporteProducto', 0, '', 'L', 0),
(98, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-23 20:36:08', '1', 10, 10, 236, 11, '0', 495, 367, 'MARCAVIHEC', 8, 'arial', 'TotalProducto', 0, '', 'L', 0),
(99, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-23 20:36:08', '1', 10, 10, 304, 10, '1', 71, 223, 'variable', 8, 'arial', 'NroOrdenVenta', 0, '', 'L', 0),
(100, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-23 20:36:09', '1', 10, 10, 304, 10, '0', 70, 240, 'VENDEDOR', 8, 'arial', 'Vendedor', 0, '', 'L', 0),
(101, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-23 20:36:09', '1', 10, 10, 146, 16, '0', 561, 135, 'GUIA', 12, 'arial', 'GuiaRemision', 0, '', 'L', 0),
(102, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-23 20:36:09', '1', 10, 10, 314, 11, '0', 61, 304, 'CONDUCTOR2', 8, 'arial', 'SubTotal', 0, '', 'L', 0),
(103, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-23 20:36:09', '1', 10, 10, 219, 10, '0', 510, 418, 'LICENCIACO', 8, 'arial', 'IGV', 0, '', 'L', 0),
(104, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-23 20:36:09', '1', 10, 10, 287, 12, '0', 89, 348, 'PUNTOPARTI', 8, 'arial', 'Total', 0, '', 'L', 0),
(105, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-23 20:36:09', '1', 10, 10, 288, 15, '1', 438, 176, 'variable', 8, 'arial', 'MontoEnLetras', 0, '', 'L', 1),
(106, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:05', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Nombre', 0, '', 'L', 0),
(107, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:05', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Ruc', 0, '', 'L', 0),
(108, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:05', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Direccion', 0, '', 'L', 0),
(109, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:05', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Cantidad', 0, '', 'L', 0),
(110, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:05', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DestinoNombre', 0, '', 'L', 0),
(111, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:05', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DestinoRuc', 0, '', 'L', 0),
(112, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:05', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'FechaEmision', 0, '', 'L', 0),
(113, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:05', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'FechaRecepcion', 0, '', 'L', 0),
(114, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:05', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DescripcionProducto', 0, '', 'L', 0),
(115, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:06', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'PrecioUnitario', 0, '', 'L', 0),
(116, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:06', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'ImporteProducto', 0, '', 'L', 0),
(117, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:06', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'TotalProducto', 0, '', 'L', 0),
(118, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:06', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'NroOrdenVenta', 0, '', 'L', 0),
(119, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:06', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Vendedor', 0, '', 'L', 0),
(120, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:06', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'GuiaRemision', 0, '', 'L', 0),
(121, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:06', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'SubTotal', 0, '', 'L', 0),
(122, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:06', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'IGV', 0, '', 'L', 0),
(123, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:06', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Total', 0, '', 'L', 0),
(124, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:06', '1', 1, 1, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'MontoEnLetras', 0, '', 'L', 1),
(125, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:19', '1', 2, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Nombre', 0, '', 'L', 0),
(126, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:19', '1', 2, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Ruc', 0, '', 'L', 0),
(127, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:19', '1', 2, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Direccion', 0, '', 'L', 0),
(128, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:19', '1', 2, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Cantidad', 0, '', 'L', 0),
(129, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:19', '1', 2, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DestinoNombre', 0, '', 'L', 0),
(130, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:19', '1', 2, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DestinoRuc', 0, '', 'L', 0),
(131, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:19', '1', 2, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'FechaEmision', 0, '', 'L', 0),
(132, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:19', '1', 2, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'FechaRecepcion', 0, '', 'L', 0),
(133, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:19', '1', 2, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DescripcionProducto', 0, '', 'L', 0),
(134, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:19', '1', 2, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'PrecioUnitario', 0, '', 'L', 0),
(135, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:19', '1', 2, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'ImporteProducto', 0, '', 'L', 0),
(136, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:19', '1', 2, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'TotalProducto', 0, '', 'L', 0),
(137, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:20', '1', 2, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'NroOrdenVenta', 0, '', 'L', 0),
(138, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:20', '1', 2, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Vendedor', 0, '', 'L', 0),
(139, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:20', '1', 2, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'GuiaRemision', 0, '', 'L', 0),
(140, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:20', '1', 2, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'SubTotal', 0, '', 'L', 0),
(141, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:20', '1', 2, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'IGV', 0, '', 'L', 0),
(142, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:20', '1', 2, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Total', 0, '', 'L', 0),
(143, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:09:20', '1', 2, 2, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'MontoEnLetras', 0, '', 'L', 1),
(144, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:45', '1', 3, 3, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Nombre', 0, '', 'L', 0),
(145, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:45', '1', 3, 3, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Ruc', 0, '', 'L', 0),
(146, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:45', '1', 3, 3, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Direccion', 0, '', 'L', 0),
(147, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:45', '1', 3, 3, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Cantidad', 0, '', 'L', 0),
(148, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:45', '1', 3, 3, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DestinoNombre', 0, '', 'L', 0),
(149, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:45', '1', 3, 3, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DestinoRuc', 0, '', 'L', 0),
(150, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:45', '1', 3, 3, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'FechaEmision', 0, '', 'L', 0),
(151, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:45', '1', 3, 3, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'FechaRecepcion', 0, '', 'L', 0),
(152, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:45', '1', 3, 3, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DescripcionProducto', 0, '', 'L', 0),
(153, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:45', '1', 3, 3, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'PrecioUnitario', 0, '', 'L', 0),
(154, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:46', '1', 3, 3, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'ImporteProducto', 0, '', 'L', 0),
(155, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:46', '1', 3, 3, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'TotalProducto', 0, '', 'L', 0),
(156, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:46', '1', 3, 3, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'NroOrdenVenta', 0, '', 'L', 0),
(157, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:46', '1', 3, 3, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Vendedor', 0, '', 'L', 0),
(158, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:46', '1', 3, 3, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'GuiaRemision', 0, '', 'L', 0),
(159, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:46', '1', 3, 3, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'SubTotal', 0, '', 'L', 0),
(160, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:46', '1', 3, 3, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'IGV', 0, '', 'L', 0),
(161, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:46', '1', 3, 3, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Total', 0, '', 'L', 0),
(162, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:46', '1', 3, 3, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'MontoEnLetras', 0, '', 'L', 1),
(163, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:58', '1', 4, 4, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Nombre', 0, '', 'L', 0),
(164, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:58', '1', 4, 4, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Ruc', 0, '', 'L', 0),
(165, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:58', '1', 4, 4, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Direccion', 0, '', 'L', 0),
(166, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:58', '1', 4, 4, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Cantidad', 0, '', 'L', 0),
(167, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:58', '1', 4, 4, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DestinoNombre', 0, '', 'L', 0),
(168, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:58', '1', 4, 4, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DestinoRuc', 0, '', 'L', 0),
(169, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:58', '1', 4, 4, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'FechaEmision', 0, '', 'L', 0),
(170, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:58', '1', 4, 4, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'FechaRecepcion', 0, '', 'L', 0),
(171, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:58', '1', 4, 4, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DescripcionProducto', 0, '', 'L', 0),
(172, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:58', '1', 4, 4, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'PrecioUnitario', 0, '', 'L', 0),
(173, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:58', '1', 4, 4, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'ImporteProducto', 0, '', 'L', 0),
(174, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:58', '1', 4, 4, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'TotalProducto', 0, '', 'L', 0),
(175, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:58', '1', 4, 4, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'NroOrdenVenta', 0, '', 'L', 0),
(176, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:58', '1', 4, 4, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Vendedor', 0, '', 'L', 0),
(177, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:58', '1', 4, 4, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'GuiaRemision', 0, '', 'L', 0),
(178, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:58', '1', 4, 4, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'SubTotal', 0, '', 'L', 0),
(179, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:58', '1', 4, 4, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'IGV', 0, '', 'L', 0),
(180, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:59', '1', 4, 4, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Total', 0, '', 'L', 0),
(181, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:26:59', '1', 4, 4, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'MontoEnLetras', 0, '', 'L', 1),
(182, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:27:49', '1', 5, 5, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Nombre', 0, '', 'L', 0),
(183, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:27:49', '1', 5, 5, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Ruc', 0, '', 'L', 0),
(184, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:27:49', '1', 5, 5, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Direccion', 0, '', 'L', 0),
(185, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:27:49', '1', 5, 5, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Cantidad', 0, '', 'L', 0),
(186, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:27:49', '1', 5, 5, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DestinoNombre', 0, '', 'L', 0),
(187, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:27:49', '1', 5, 5, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DestinoRuc', 0, '', 'L', 0),
(188, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:27:49', '1', 5, 5, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'FechaEmision', 0, '', 'L', 0),
(189, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:27:49', '1', 5, 5, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'FechaRecepcion', 0, '', 'L', 0),
(190, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:27:49', '1', 5, 5, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DescripcionProducto', 0, '', 'L', 0),
(191, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:27:49', '1', 5, 5, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'PrecioUnitario', 0, '', 'L', 0),
(192, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:27:49', '1', 5, 5, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'ImporteProducto', 0, '', 'L', 0),
(193, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:27:49', '1', 5, 5, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'TotalProducto', 0, '', 'L', 0),
(194, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:27:49', '1', 5, 5, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'NroOrdenVenta', 0, '', 'L', 0),
(195, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:27:49', '1', 5, 5, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Vendedor', 0, '', 'L', 0),
(196, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:27:49', '1', 5, 5, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'GuiaRemision', 0, '', 'L', 0),
(197, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:27:50', '1', 5, 5, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'SubTotal', 0, '', 'L', 0),
(198, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:27:50', '1', 5, 5, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'IGV', 0, '', 'L', 0),
(199, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:27:50', '1', 5, 5, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Total', 0, '', 'L', 0),
(200, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:27:50', '1', 5, 5, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'MontoEnLetras', 0, '', 'L', 1),
(201, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:28:23', '1', 6, 6, 353, 11, '0', 67, 125, 'variable', 8, 'arial', 'Nombre', 0, '', 'L', 0),
(202, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:28:23', '1', 6, 6, 143, 20, '0', 59, 1074, 'variable', 8, 'arial', 'Ruc', 0, '', 'L', 0),
(203, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:28:24', '1', 6, 6, 73, 14, '0', 65, 1039, 'variable', 8, 'arial', 'Direccion', 0, '', 'L', 0),
(204, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:28:24', '1', 6, 6, 59, 18, '0', 477, 490, 'variable', 8, 'arial', 'Cantidad', 0, '', 'L', 0),
(205, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:28:24', '1', 6, 6, 349, 10, '0', 73, 143, 'variable', 8, 'arial', 'DestinoNombre', 0, '', 'L', 0),
(206, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:28:24', '1', 6, 6, 369, 10, '0', 53, 159, 'variable', 8, 'arial', 'DestinoRuc', 0, '', 'L', 0),
(207, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:28:24', '1', 6, 6, 268, 12, '0', 107, 189, 'variable', 8, 'arial', 'FechaEmision', 0, '', 'L', 0),
(208, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:28:24', '1', 6, 6, 215, 10, '0', 160, 207, 'variable', 8, 'arial', 'FechaRecepcion', 0, '', 'L', 0),
(209, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:28:24', '1', 6, 6, 431, 10, '0', 27, 491, 'variable', 8, 'arial', 'DescripcionProducto', 0, '', 'L', 0),
(210, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:28:24', '1', 6, 6, 130, 20, '0', 162, 1039, 'variable', 8, 'arial', 'PrecioUnitario', 0, '', 'L', 0),
(211, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:28:24', '1', 6, 6, 119, 20, '0', 306, 1041, 'variable', 8, 'arial', 'ImporteProducto', 0, '', 'L', 0),
(212, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:28:24', '1', 6, 6, 80, 20, '0', 436, 1041, 'variable', 8, 'arial', 'TotalProducto', 0, '', 'L', 0),
(213, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:28:24', '1', 6, 6, 114, 12, '0', 71, 222, 'variable', 8, 'arial', 'NroOrdenVenta', 0, '', 'L', 0),
(214, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:28:24', '1', 6, 6, 304, 11, '0', 72, 241, 'variable', 8, 'arial', 'Vendedor', 0, '', 'L', 0),
(215, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:28:24', '1', 6, 6, 138, 25, '0', 571, 130, 'variable', 20, 'arial', 'GuiaRemision', 0, '', 'L', 0),
(216, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:28:24', '1', 6, 6, 68, 21, '0', 227, 1079, 'variable', 8, 'arial', 'SubTotal', 0, '', 'L', 0),
(217, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:28:24', '1', 6, 6, 63, 20, '0', 536, 1042, 'variable', 8, 'arial', 'IGV', 0, '', 'L', 0),
(218, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:28:24', '1', 6, 6, 86, 17, '0', 610, 1044, 'variable', 8, 'arial', 'Total', 0, '', 'L', 0),
(219, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 18:28:24', '1', 6, 6, 60, 25, '0', 315, 1078, 'variable', 8, 'arial', 'MontoEnLetras', 0, '', 'L', 1),
(220, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:28:42', '1', 7, 7, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Nombre', 0, '', 'L', 0),
(221, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:28:42', '1', 7, 7, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Ruc', 0, '', 'L', 0),
(222, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:28:42', '1', 7, 7, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Direccion', 0, '', 'L', 0),
(223, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:28:42', '1', 7, 7, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Cantidad', 0, '', 'L', 0),
(224, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:28:42', '1', 7, 7, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DestinoNombre', 0, '', 'L', 0),
(225, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:28:42', '1', 7, 7, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DestinoRuc', 0, '', 'L', 0),
(226, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:28:42', '1', 7, 7, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'FechaEmision', 0, '', 'L', 0),
(227, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:28:42', '1', 7, 7, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'FechaRecepcion', 0, '', 'L', 0),
(228, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:28:43', '1', 7, 7, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DescripcionProducto', 0, '', 'L', 0),
(229, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:28:43', '1', 7, 7, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'PrecioUnitario', 0, '', 'L', 0),
(230, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:28:43', '1', 7, 7, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'ImporteProducto', 0, '', 'L', 0),
(231, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:28:43', '1', 7, 7, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'TotalProducto', 0, '', 'L', 0),
(232, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:28:43', '1', 7, 7, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'NroOrdenVenta', 0, '', 'L', 0),
(233, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:28:43', '1', 7, 7, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Vendedor', 0, '', 'L', 0),
(234, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:28:43', '1', 7, 7, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'GuiaRemision', 0, '', 'L', 0),
(235, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:28:43', '1', 7, 7, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'SubTotal', 0, '', 'L', 0),
(236, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:28:43', '1', 7, 7, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'IGV', 0, '', 'L', 0),
(237, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:28:43', '1', 7, 7, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Total', 0, '', 'L', 0),
(238, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:28:43', '1', 7, 7, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'MontoEnLetras', 0, '', 'L', 1),
(239, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 20:23:20', '1', 11, 11, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Nombre', 0, '', 'L', 0),
(240, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 20:23:20', '1', 11, 11, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Ruc', 0, '', 'L', 0),
(241, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 20:23:21', '1', 11, 11, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Direccion', 0, '', 'L', 0),
(242, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 20:23:21', '1', 11, 11, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Cantidad', 0, '', 'L', 0),
(243, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 20:23:21', '1', 11, 11, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DestinoNombre', 0, '', 'L', 0),
(244, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 20:23:21', '1', 11, 11, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DestinoRuc', 0, '', 'L', 0),
(245, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 20:23:21', '1', 11, 11, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'FechaEmision', 0, '', 'L', 0),
(246, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 20:23:21', '1', 11, 11, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'FechaRecepcion', 0, '', 'L', 0),
(247, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 20:23:21', '1', 11, 11, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DescripcionProducto', 0, '', 'L', 0),
(248, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 20:23:21', '1', 11, 11, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'PrecioUnitario', 0, '', 'L', 0),
(249, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 20:23:21', '1', 11, 11, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'ImporteProducto', 0, '', 'L', 0),
(250, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 20:23:21', '1', 11, 11, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'TotalProducto', 0, '', 'L', 0),
(251, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 20:23:21', '1', 11, 11, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'NroOrdenVenta', 0, '', 'L', 0),
(252, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 20:23:21', '1', 11, 11, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Vendedor', 0, '', 'L', 0),
(253, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 20:23:21', '1', 11, 11, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'GuiaRemision', 0, '', 'L', 0),
(254, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 20:23:21', '1', 11, 11, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'SubTotal', 0, '', 'L', 0),
(255, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 20:23:21', '1', 11, 11, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'IGV', 0, '', 'L', 0),
(256, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 20:23:21', '1', 11, 11, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Total', 0, '', 'L', 0),
(257, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 20:23:21', '1', 11, 11, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'MontoEnLetras', 0, '', 'L', 1),
(258, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 21:59:25', '1', 12, 12, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Nombre', 0, '', 'L', 0),
(259, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 21:59:25', '1', 12, 12, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Ruc', 0, '', 'L', 0),
(260, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 21:59:25', '1', 12, 12, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Direccion', 0, '', 'L', 0),
(261, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 21:59:25', '1', 12, 12, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Cantidad', 0, '', 'L', 0),
(262, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 21:59:25', '1', 12, 12, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DestinoNombre', 0, '', 'L', 0),
(263, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 21:59:25', '1', 12, 12, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DestinoRuc', 0, '', 'L', 0),
(264, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 21:59:25', '1', 12, 12, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'FechaEmision', 0, '', 'L', 0),
(265, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 21:59:25', '1', 12, 12, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'FechaRecepcion', 0, '', 'L', 0),
(266, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 21:59:25', '1', 12, 12, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DescripcionProducto', 0, '', 'L', 0),
(267, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 21:59:25', '1', 12, 12, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'PrecioUnitario', 0, '', 'L', 0),
(268, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 21:59:25', '1', 12, 12, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'ImporteProducto', 0, '', 'L', 0),
(269, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 21:59:25', '1', 12, 12, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'TotalProducto', 0, '', 'L', 0),
(270, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 21:59:25', '1', 12, 12, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'NroOrdenVenta', 0, '', 'L', 0),
(271, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 21:59:25', '1', 12, 12, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Vendedor', 0, '', 'L', 0),
(272, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 21:59:25', '1', 12, 12, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'GuiaRemision', 0, '', 'L', 0),
(273, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 21:59:25', '1', 12, 12, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'SubTotal', 0, '', 'L', 0),
(274, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 21:59:25', '1', 12, 12, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'IGV', 0, '', 'L', 0),
(275, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 21:59:25', '1', 12, 12, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Total', 0, '', 'L', 0),
(276, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-07 21:59:26', '1', 12, 12, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'MontoEnLetras', 0, '', 'L', 1),
(277, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-15 21:38:40', '1', 13, 13, 238, 10, '0', 16, 59, 'variable', 8, 'arial', 'Nombre', 0, '', 'L', 0),
(278, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-15 21:38:40', '1', 13, 13, 120, 10, '0', 664, 56, 'variable', 8, 'arial', 'Ruc', 0, '', 'L', 0),
(279, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-15 21:38:40', '1', 13, 13, 240, 10, '0', 15, 76, 'variable', 8, 'arial', 'Direccion', 0, '', 'L', 0),
(280, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-15 21:38:40', '1', 13, 13, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Cantidad', 0, '', 'L', 0),
(281, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-15 21:38:40', '1', 13, 13, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DestinoNombre', 0, '', 'L', 0),
(282, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-15 21:38:40', '1', 13, 13, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DestinoRuc', 0, '', 'L', 0),
(283, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-15 21:38:40', '1', 13, 13, 85, 10, '0', 800, 55, 'variable', 8, 'arial', 'FechaEmision', 0, '', 'L', 0),
(284, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-15 21:38:40', '1', 13, 13, 20, 20, '1', 20, 20, 'variable', 8, 'arial', 'FechaRecepcion', 0, '', 'L', 0),
(285, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-15 21:38:40', '1', 13, 13, 323, 20, '0', 230, 146, 'variable', 8, 'arial', 'DescripcionProducto', 0, '', 'L', 0),
(286, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-15 21:38:41', '1', 13, 13, 82, 20, '0', 567, 145, 'variable', 8, 'arial', 'PrecioUnitario', 0, '', 'L', 0),
(287, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-15 21:38:41', '1', 13, 13, 75, 20, '0', 669, 144, 'variable', 8, 'arial', 'ImporteProducto', 0, '', 'L', 0),
(288, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-15 21:38:41', '1', 13, 13, 106, 20, '0', 755, 143, 'variable', 8, 'arial', 'TotalProducto', 0, '', 'L', 0),
(289, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-15 21:38:41', '1', 13, 13, 321, 32, '0', 296, 7, 'variable', 8, 'arial', 'NroOrdenVenta', 0, '', 'L', 0),
(290, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-15 21:38:41', '1', 13, 13, 221, 10, '0', 664, 74, 'variable', 8, 'arial', 'Vendedor', 0, '', 'L', 0),
(291, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-15 21:38:41', '1', 13, 13, 41, 31, '1', 857, 0, 'variable', 8, 'arial', 'GuiaRemision', 0, '', 'L', 0),
(292, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-15 21:38:41', '1', 13, 13, 86, 20, '0', 706, 463, 'variable', 8, 'arial', 'SubTotal', 0, '', 'L', 0),
(293, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-15 21:38:41', '1', 13, 13, 205, 18, '0', 654, 491, 'variable', 8, 'arial', 'IGV', 0, '', 'L', 0),
(294, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-15 21:38:41', '1', 13, 13, 121, 20, '0', 701, 518, 'variable', 8, 'arial', 'Total', 0, '', 'L', 0),
(295, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-15 21:38:41', '1', 13, 13, 375, 17, '0', 50, 501, 'variable', 8, 'arial', 'MontoEnLetras', 0, '', 'L', 1),
(296, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 20:27:18', '1', 14, 14, 377, 12, '0', 58, 118, 'NOMBRE', 8, 'arial', 'Nombre', 0, '', 'L', 0),
(297, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 20:27:18', '1', 14, 14, 125, 13, '0', 58, 134, 'RUC', 8, 'arial', 'Ruc', 0, '', 'L', 0),
(298, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 20:27:18', '1', 14, 14, 377, 10, '0', 58, 149, 'DIRECCION', 8, 'arial', 'Direccion', 0, '', 'L', 0),
(299, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 20:27:18', '1', 14, 14, 59, 20, '0', 430, 276, 'CANTIDAD', 8, 'arial', 'Cantidad', 0, 'grupo', 'L', 0),
(300, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 20:27:18', '1', 14, 14, 70, 20, '1', 364, 82, 'variable', 8, 'arial', 'DestinoNombre', 0, '', 'L', 0),
(301, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 20:27:18', '1', 14, 14, 96, 15, '1', 348, 62, 'variable', 8, 'arial', 'DestinoRuc', 0, '', 'L', 0),
(302, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 20:27:18', '1', 14, 14, 111, 15, '0', 20, 233, 'FECHAEMI', 8, 'arial', 'FechaEmision', 0, '', 'L', 0),
(303, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 20:27:18', '1', 14, 14, 122, 20, '1', 323, 35, 'variable', 8, 'arial', 'FechaRecepcion', 0, '', 'L', 0),
(304, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 20:27:18', '1', 14, 14, 323, 10, '0', 100, 277, 'NOMBREP', 8, 'arial', 'DescripcionProducto', 0, 'grupo', 'L', 0),
(305, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 20:27:18', '1', 14, 14, 79, 18, '0', 549, 278, 'PUNIT', 8, 'arial', 'PrecioUnitario', 0, 'grupo', 'L', 0),
(306, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 20:27:18', '1', 14, 14, 97, 21, '0', 456, 35, 'IMPORTEP', 8, 'arial', 'ImporteProducto', 0, '', 'L', 0),
(307, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 20:27:18', '1', 14, 14, 35, 20, '0', 652, 277, 'TOTALP', 8, 'arial', 'TotalProducto', 0, 'grupo', 'L', 0),
(308, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 20:27:18', '1', 14, 14, 20, 20, '1', 20, 20, 'variable', 8, 'arial', 'NroOrdenVenta', 0, '', 'L', 0),
(309, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 20:27:18', '1', 14, 14, 20, 20, '1', 20, 20, 'variable', 8, 'arial', 'Vendedor', 0, '', 'L', 0),
(310, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 20:27:18', '1', 14, 14, 20, 20, '1', 20, 20, 'variable', 8, 'arial', 'GuiaRemision', 0, '', 'L', 0),
(311, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 20:27:18', '1', 14, 14, 139, 21, '0', 327, 837, 'SUBTOTAL', 8, 'arial', 'SubTotal', 0, '', 'L', 0),
(312, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 20:27:18', '1', 14, 14, 144, 23, '0', 472, 837, 'IGV', 8, 'arial', 'IGV', 0, '', 'L', 0),
(313, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 20:27:18', '1', 14, 14, 143, 21, '0', 624, 839, 'TOTAL', 8, 'arial', 'Total', 0, '', 'L', 0),
(314, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 20:27:18', '1', 14, 14, 718, 16, '0', 37, 788, 'MONTOLETRA', 8, 'arial', 'MontoEnLetras', 0, '', 'L', 1),
(315, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:29:16', '1', 15, 15, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Nombre', 0, '', 'L', 0),
(316, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:29:16', '1', 15, 15, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Ruc', 0, '', 'L', 0),
(317, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:29:16', '1', 15, 15, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Direccion', 0, '', 'L', 0),
(318, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:29:16', '1', 15, 15, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Cantidad', 0, '', 'L', 0),
(319, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:29:16', '1', 15, 15, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DestinoNombre', 0, '', 'L', 0),
(320, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:29:16', '1', 15, 15, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DestinoRuc', 0, '', 'L', 0),
(321, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:29:16', '1', 15, 15, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'FechaEmision', 0, '', 'L', 0),
(322, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:29:16', '1', 15, 15, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'FechaRecepcion', 0, '', 'L', 0),
(323, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:29:16', '1', 15, 15, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'DescripcionProducto', 0, '', 'L', 0),
(324, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:29:16', '1', 15, 15, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'PrecioUnitario', 0, '', 'L', 0),
(325, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:29:16', '1', 15, 15, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'ImporteProducto', 0, '', 'L', 0),
(326, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:29:16', '1', 15, 15, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'TotalProducto', 0, '', 'L', 0),
(327, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:29:16', '1', 15, 15, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'NroOrdenVenta', 0, '', 'L', 0),
(328, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:29:16', '1', 15, 15, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Vendedor', 0, '', 'L', 0),
(329, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:29:16', '1', 15, 15, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'GuiaRemision', 0, '', 'L', 0),
(330, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:29:16', '1', 15, 15, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'SubTotal', 0, '', 'L', 0),
(331, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:29:16', '1', 15, 15, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'IGV', 0, '', 'L', 0),
(332, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:29:16', '1', 15, 15, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'Total', 0, '', 'L', 0),
(333, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-11-24 22:29:16', '1', 15, 15, 20, 20, '0', 20, 20, 'variable', 8, 'arial', 'MontoEnLetras', 0, '', 'L', 1),
(334, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-16 22:22:24', '1', 8, 8, 377, 12, '0', 58, 118, 'NOMBRE', 8, 'arial', 'Nombre', 0, '', 'L', 0),
(335, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-16 22:22:24', '1', 8, 8, 125, 13, '0', 58, 134, 'RUC', 8, 'arial', 'Ruc', 0, '', 'L', 0),
(336, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-16 22:22:24', '1', 8, 8, 377, 10, '0', 58, 149, 'DIRECCION', 6, 'arial', 'Direccion', 0, '', 'L', 0),
(337, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-16 22:22:24', '1', 8, 8, 59, 20, '0', 430, 276, 'CANTIDAD', 8, 'arial', 'Cantidad', 0, 'grupo', 'L', 0),
(338, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-16 22:22:24', '1', 8, 8, 70, 20, '1', 364, 82, 'variable', 8, 'arial', 'DestinoNombre', 0, '', 'L', 0),
(339, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-16 22:22:24', '1', 8, 8, 96, 15, '1', 348, 62, 'variable', 8, 'arial', 'DestinoRuc', 0, '', 'L', 0),
(340, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-16 22:22:24', '1', 8, 8, 111, 15, '0', 20, 233, 'FECHAEMI', 8, 'arial', 'FechaEmision', 0, '', 'L', 0),
(341, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-16 22:22:24', '1', 8, 8, 122, 20, '1', 323, 35, 'variable', 8, 'arial', 'FechaRecepcion', 0, '', 'L', 0),
(342, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-16 22:22:24', '1', 8, 8, 322, 10, '0', 100, 277, 'NOMBREP', 8, 'arial', 'DescripcionProducto', 0, 'grupo', 'L', 0),
(343, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-16 22:22:24', '1', 8, 8, 79, 18, '0', 549, 278, 'PUNIT', 8, 'arial', 'PrecioUnitario', 0, 'grupo', 'L', 0),
(344, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-16 22:22:24', '1', 8, 8, 97, 21, '1', 456, 35, 'variable', 8, 'arial', 'ImporteProducto', 0, '', 'L', 0),
(345, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-16 22:22:24', '1', 8, 8, 114, 20, '0', 652, 277, 'TOTALP', 8, 'arial', 'TotalProducto', 0, 'grupo', 'L', 0),
(346, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-16 22:22:25', '1', 8, 8, 105, 14, '1', 444, 237, 'variable', 8, 'arial', 'NroOrdenVenta', 0, '', 'L', 0),
(347, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-16 22:22:25', '1', 8, 8, 174, 15, '0', 682, 238, 'VENDEDOR', 7, 'arial', 'Vendedor', 0, '', 'L', 0),
(348, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-16 22:22:25', '1', 8, 8, 291, 20, '1', 469, 195, 'variable', 8, 'arial', 'GuiaRemision', 0, '', 'L', 0),
(349, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-16 22:22:25', '1', 8, 8, 139, 21, '0', 327, 837, 'SUBTOTAL', 8, 'arial', 'SubTotal', 0, '', 'L', 0),
(350, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-16 22:22:25', '1', 8, 8, 144, 23, '0', 472, 837, 'IGV', 8, 'arial', 'IGV', 0, '', 'L', 0);
INSERT INTO `cji_compadocumenitem` (`COMPADOCUITEM_Codigo`, `COMPADOCUITEM_Descripcion`, `COMPADOCUITEM_Abreviatura`, `COMPADOCUITEM_Valor`, `COMPADOCUITEM_UsuCrea`, `COMPADOCUITEM_UsuModi`, `COMPADOCUITEM_FechaModi`, `COMPADOCUITEM_FechaIng`, `COMPADOCUITEM_Estado`, `DOCUITEM_Codigo`, `COMPCONFIDOCP_Codigo`, `COMPADOCUITEM_Width`, `COMPADOCUITEM_Height`, `COMPADOCUITEM_Activacion`, `COMPADOCUITEM_PosicionX`, `COMPADOCUITEM_PosicionY`, `COMPADOCUITEM_Variable`, `COMPADOCUITEM_TamanioLetra`, `COMPADOCUITEM_TipoLetra`, `COMPADOCUITEM_Nombre`, `COMPADOCUITEM_Listado`, `COMPADOCUITEM_VGrupo`, `COMPADOCUITEM_Alineamiento`, `COMPADOCUITEM_Convertiraletras`) VALUES
(351, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-16 22:22:25', '1', 8, 8, 143, 21, '0', 624, 839, 'TOTAL', 8, 'arial', 'Total', 0, '', 'L', 0),
(352, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-16 22:22:25', '1', 8, 8, 718, 16, '0', 37, 788, 'MONTOLETRA', 8, 'arial', 'MontoEnLetras', 0, '', 'L', 1),
(353, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-16 22:22:25', '1', 8, 8, 143, 21, '0', 16, 833, 'FORMAPA', 8, 'arial', 'FormaDePago', 0, '', 'L', 0),
(354, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-16 22:22:25', '1', 8, 8, 105, 15, '0', 568, 237, 'MONEDA', 8, 'arial', 'Moneda', 0, '', 'L', 0),
(355, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-16 22:22:25', '1', 8, 8, 145, 18, '0', 581, 134, 'COMPROBANTE', 12, 'arial', 'Comprobante', 0, '', 'L', 0),
(356, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-16 22:22:25', '1', 8, 8, 44, 19, '0', 497, 276, 'UNIDAD', 6, 'arial', 'UnidadMedida', 0, 'grupo', 'L', 0),
(357, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-23 20:36:09', '1', 10, 10, 360, 46, '0', 17, 408, 'OBSERVACIO', 8, 'arial', 'Comprobante', 0, '', 'L', 0),
(358, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-23 20:36:09', '1', 10, 10, 95, 15, '0', 542, 488, 'UNIDAD', 8, 'arial', 'UnidadMedida', 0, 'grupo', 'L', 0),
(359, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-11 21:52:23', '1', 9, 9, 455, 33, '0', 106, 351, 'NOMBRE', 8, 'arial', 'Nombre', 0, '', 'L', 0),
(360, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-11 21:52:23', '1', 9, 9, 114, 10, '1', 574, 149, 'RUC', 10, 'arial', 'Ruc', 0, '', 'L', 0),
(361, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-11 21:52:23', '1', 9, 9, 644, 27, '0', 108, 401, 'DIRECCION', 8, 'arial', 'Direccion', 0, '', 'L', 0),
(362, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-11 21:52:23', '1', 9, 9, 72, 10, '1', 508, 78, 'FORMAPA', 8, 'arial', 'FormaDePago', 0, '', 'L', 0),
(363, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-11 21:52:23', '1', 9, 9, 72, 10, '1', 417, 71, 'MONEDA', 8, 'arial', 'Moneda', 0, '', 'L', 0),
(364, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-11 21:52:23', '1', 9, 9, 157, 32, '0', 569, 279, 'COMPROBANTE', 8, 'arial', 'Comprobante', 0, '', 'L', 0),
(365, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-11 21:52:23', '1', 9, 9, 72, 10, '0', 122, 473, 'UNIDAD', 8, 'arial', 'UnidadMedida', 0, '', 'L', 0),
(368, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 20:27:18', '1', 14, 14, 143, 21, '0', 16, 833, 'FORMAPA', 8, 'arial', 'FormaDePago', 0, '', 'L', 0),
(369, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 20:27:18', '1', 14, 14, 105, 15, '0', 568, 237, 'MONEDA', 8, 'arial', 'Moneda', 0, '', 'L', 0),
(370, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 20:27:19', '1', 14, 14, 145, 18, '0', 581, 134, 'COMPROBANTE', 12, 'arial', 'Comprobante', 0, '', 'L', 0),
(371, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2017-01-12 20:27:19', '1', 14, 14, 44, 19, '0', 497, 276, 'UNIDAD', 6, 'arial', 'UnidadMedida', 0, 'grupo', 'L', 0),
(372, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-15 21:38:41', '1', 13, 13, 95, 20, '0', 129, 146, 'variable', 8, 'arial', 'MarcaProducto', 0, '', 'L', 0),
(373, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-15 21:38:41', '1', 13, 13, 382, 10, '0', 48, 578, 'variable', 8, 'arial', 'TiempoEntrega', 0, '', 'L', 0),
(374, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-15 21:38:41', '1', 13, 13, 381, 10, '0', 48, 597, 'variable', 8, 'arial', 'Garantia', 0, '', 'L', 0),
(375, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-15 21:38:41', '1', 13, 13, 386, 10, '0', 46, 618, 'variable', 8, 'arial', 'Validez', 0, '', 'L', 0),
(376, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-15 21:38:41', '1', 13, 13, 52, 20, '0', 20, 20, 'variable', 8, 'arial', 'Observacion', 0, '', 'L', 0),
(377, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-15 21:38:41', '1', 13, 13, 241, 10, '0', 14, 95, 'contacto', 8, 'arial', 'Contacto', 0, '', 'L', 0),
(378, '', '', '', 'PERSONA PRINCIPAL ', '', '0000-00-00 00:00:00', '2016-12-15 21:38:41', '1', 13, 13, 250, 10, '0', 49, 559, 'formapago', 8, 'arial', 'FormaPago', 0, '', 'L', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_compania`
--

CREATE TABLE `cji_compania` (
  `COMPP_Codigo` int(11) NOT NULL,
  `EMPRP_Codigo` int(11) NOT NULL,
  `EESTABP_Codigo` int(11) NOT NULL DEFAULT '0',
  `COMPC_Logo` varchar(250) NOT NULL,
  `COMPC_TipoValorizacion` char(1) NOT NULL DEFAULT '0' COMMENT '0:FIFO, 1:LIFO',
  `COMPC_FlagEstado` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_compania`
--

INSERT INTO `cji_compania` (`COMPP_Codigo`, `EMPRP_Codigo`, `EESTABP_Codigo`, `COMPC_Logo`, `COMPC_TipoValorizacion`, `COMPC_FlagEstado`) VALUES
(1, 1, 1, 'Mi loguito', '0', 1),
(2, 1, 2, '', '0', 1),
(3, 1, 40, '', '0', 1),
(4, 1, 41, '', '0', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_companiaconfidocumento`
--

CREATE TABLE `cji_companiaconfidocumento` (
  `COMPCONFIDOCP_Codigo` int(11) NOT NULL,
  `COMPCONFIP_Codigo` int(11) NOT NULL,
  `DOCUP_Codigo` int(11) NOT NULL,
  `COMPCONFIDOCP_Tipo` char(1) NOT NULL DEFAULT '1' COMMENT '1: código númerico secuencial, 2: serie y número secuencial, 3: código propio',
  `COMPCONFIDOCP_Serie` varchar(10) DEFAULT NULL,
  `COMPCONFIDOCP_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `COMPCONFIDOCP_FechaModificacion` datetime DEFAULT NULL,
  `COMPCONFIDOCP_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `COMPCONFIDOCP_Imagen` varchar(255) DEFAULT NULL,
  `COMPCONFIDOCP_ImagenCompra` varchar(255) DEFAULT NULL,
  `COMPCONFIDOCP_PosicionGeneralX` int(3) DEFAULT NULL,
  `COMPCONFIDOCP_PosicionGeneralY` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_companiaconfidocumento`
--

INSERT INTO `cji_companiaconfidocumento` (`COMPCONFIDOCP_Codigo`, `COMPCONFIP_Codigo`, `DOCUP_Codigo`, `COMPCONFIDOCP_Tipo`, `COMPCONFIDOCP_Serie`, `COMPCONFIDOCP_FechaRegistro`, `COMPCONFIDOCP_FechaModificacion`, `COMPCONFIDOCP_FlagEstado`, `COMPCONFIDOCP_Imagen`, `COMPCONFIDOCP_ImagenCompra`, `COMPCONFIDOCP_PosicionGeneralX`, `COMPCONFIDOCP_PosicionGeneralY`) VALUES
(1, 1, 1, '1', NULL, '2011-09-23 21:04:06', NULL, '1', NULL, '0', 0, 0),
(2, 1, 2, '1', NULL, '2011-09-23 21:04:06', NULL, '1', NULL, '0', 0, 0),
(3, 1, 3, '1', NULL, '2011-09-23 21:04:17', NULL, '1', NULL, '0', 0, 0),
(4, 1, 4, '1', NULL, '2011-09-23 21:04:17', NULL, '1', 'guia1.jpg', 'guia1.jpg', 0, 0),
(5, 1, 5, '1', NULL, '2011-09-23 21:04:28', NULL, '1', 'guia1.jpg', 'guia1.jpg', 0, 0),
(6, 1, 6, '1', NULL, '2011-09-23 21:04:28', NULL, '1', 'guia1.jpg', 'guiacompra.jpg', 0, 0),
(7, 1, 7, '1', NULL, '2011-09-23 21:04:37', NULL, '1', NULL, '0', 0, 0),
(8, 1, 8, '1', NULL, '2011-09-23 21:04:37', NULL, '1', 'factura_sjservi.jpg', 'factura_sjservicompra.jpg', 10, 10),
(9, 1, 9, '1', NULL, '2011-09-23 21:05:03', NULL, '1', 'boleta.jpg', 'boleta_proveedor.jpg', 45, 60),
(10, 1, 10, '2', '009', '2011-09-23 21:05:03', NULL, '1', 'guia1.jpg', 'guiacompra.jpg', 0, 0),
(11, 1, 11, '1', NULL, '2011-09-23 21:05:30', NULL, '1', 'notacredito.jpg', '0', 0, 0),
(12, 1, 12, '1', NULL, '2011-09-23 21:05:30', NULL, '1', 'notadebito.jpg', '0', 0, 0),
(13, 1, 13, '1', NULL, '2011-09-23 21:05:38', NULL, '1', NULL, '0', 0, 0),
(14, 1, 14, '1', NULL, '2011-09-23 21:05:38', NULL, '1', 'notacredito.jpg', 'comprobantecompra.jpg', 0, 0),
(15, 1, 15, '2', '001', '2012-11-21 17:19:20', NULL, '1', NULL, '0', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_companiaconfiguracion`
--

CREATE TABLE `cji_companiaconfiguracion` (
  `COMPCONFIP_Codigo` int(11) NOT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `COMPCONFIC_Igv` int(11) NOT NULL DEFAULT '18',
  `COMPCONFIC_PrecioContieneIgv` char(1) NOT NULL DEFAULT '1' COMMENT '1: Los precios de los artículos contienne IGV, 0: No',
  `COMPCONFIC_DeterminaPrecio` char(1) NOT NULL DEFAULT '0' COMMENT '0: Los árticulos tienen un único precio, 1: El precio depende del tipo de cliente, 2: El precio depende de la tienda, 3: El precio depedente de la combinación de las dos últimas',
  `COMPCONFIC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `COMPCONFIC_FechaModificacion` datetime DEFAULT NULL,
  `COMPCONFIC_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `COMPCONFIC_Cliente` char(1) NOT NULL COMMENT '1 = compartir, 0 = no compartir',
  `COMPCONFIC_Proveedor` char(1) NOT NULL COMMENT '1 = compartir, 0 = no compartir',
  `COMPCONFIC_Producto` char(1) NOT NULL COMMENT '1 = compartir, 0 = no compartir',
  `COMPCONFIC_Familia` char(1) NOT NULL COMMENT '1 = compartir, 0 = no compartir',
  `COMPCONFIC_StockComprobante` char(1) DEFAULT NULL COMMENT '0: no mueve stock; 1: mueve stock',
  `COMPCONFIC_StockGuia` char(1) DEFAULT '1' COMMENT '0: no mueve stock; 1: mueve stock',
  `COMPCONFIC_InventarioInicial` char(1) NOT NULL DEFAULT '0' COMMENT '0:deshabilitado el llenado de inventario por menu articulos; 1: habilitado llenado de inventario por aticulo.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_companiaconfiguracion`
--

INSERT INTO `cji_companiaconfiguracion` (`COMPCONFIP_Codigo`, `COMPP_Codigo`, `COMPCONFIC_Igv`, `COMPCONFIC_PrecioContieneIgv`, `COMPCONFIC_DeterminaPrecio`, `COMPCONFIC_FechaRegistro`, `COMPCONFIC_FechaModificacion`, `COMPCONFIC_FlagEstado`, `COMPCONFIC_Cliente`, `COMPCONFIC_Proveedor`, `COMPCONFIC_Producto`, `COMPCONFIC_Familia`, `COMPCONFIC_StockComprobante`, `COMPCONFIC_StockGuia`, `COMPCONFIC_InventarioInicial`) VALUES
(1, 1, 18, '1', '2', '2011-07-15 17:46:52', NULL, '1', '0', '0', '0', '0', '1', '1', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_comparativo`
--

CREATE TABLE `cji_comparativo` (
  `COMP_Codigo` int(11) NOT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `COMP_FechaRegistro` datetime NOT NULL,
  `COMP_FechaModificacion` datetime NOT NULL,
  `COMP_Observacion` text NOT NULL,
  `COMC_FlagEstado` char(1) NOT NULL DEFAULT 'A',
  `PEDIP_Codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_comparativo`
--

INSERT INTO `cji_comparativo` (`COMP_Codigo`, `COMPP_Codigo`, `COMP_FechaRegistro`, `COMP_FechaModificacion`, `COMP_Observacion`, `COMC_FlagEstado`, `PEDIP_Codigo`) VALUES
(1, 1, '2016-12-29 04:02:48', '0000-00-00 00:00:00', '', 'C', 3),
(2, 1, '2016-12-29 04:56:09', '0000-00-00 00:00:00', '', 'C', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_comparativodetalle`
--

CREATE TABLE `cji_comparativodetalle` (
  `CUACOMP_Codigo` int(11) NOT NULL,
  `PRESUP_Codigo` int(11) NOT NULL,
  `CUACOMC_Ganador` tinyint(1) NOT NULL,
  `CUACOMC_Observacion` text,
  `COMP_Codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_comparativodetalle`
--

INSERT INTO `cji_comparativodetalle` (`CUACOMP_Codigo`, `PRESUP_Codigo`, `CUACOMC_Ganador`, `CUACOMC_Observacion`, `COMP_Codigo`) VALUES
(1, 9, 1, '', 2),
(2, 10, 1, '', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_comprobante`
--

CREATE TABLE `cji_comprobante` (
  `CPP_Codigo` int(11) NOT NULL,
  `CPC_TipoOperacion` char(1) NOT NULL DEFAULT 'V' COMMENT 'V: venta, C: compra',
  `CPC_TipoDocumento` char(1) NOT NULL DEFAULT 'F' COMMENT 'F: factura, B: boleta, N: nunguno de los dos',
  `PRESUP_Codigo` int(11) DEFAULT NULL,
  `OCOMP_Codigo` int(11) DEFAULT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `CPC_Serie` char(6) NOT NULL,
  `CPC_Numero` int(11) NOT NULL,
  `CLIP_Codigo` int(11) DEFAULT NULL,
  `PROVP_Codigo` int(11) DEFAULT NULL,
  `CPC_NombreAuxiliar` varchar(25) DEFAULT 'cliente',
  `USUA_Codigo` int(11) NOT NULL,
  `MONED_Codigo` int(11) NOT NULL DEFAULT '1',
  `FORPAP_Codigo` int(11) DEFAULT NULL,
  `CPC_subtotal` double(10,2) DEFAULT NULL,
  `CPC_descuento` double(10,2) DEFAULT NULL,
  `CPC_igv` double(10,2) DEFAULT NULL,
  `CPC_total` double(10,2) NOT NULL DEFAULT '0.00',
  `CPC_subtotal_conigv` double(10,2) DEFAULT NULL COMMENT 'Para que pueda ser usado como una boleta',
  `CPC_descuento_conigv` double(10,2) DEFAULT NULL COMMENT 'Para que pueda ser usado como una boleta',
  `CPC_igv100` int(11) NOT NULL DEFAULT '0',
  `CPC_descuento100` int(11) NOT NULL DEFAULT '0',
  `GUIAREMP_Codigo` int(11) DEFAULT NULL,
  `CPC_GuiaRemCodigo` varchar(50) DEFAULT NULL,
  `CPC_DocuRefeCodigo` varchar(50) DEFAULT NULL,
  `CPC_Observacion` text,
  `CPC_ModoImpresion` char(1) NOT NULL DEFAULT '1',
  `CPC_Fecha` date NOT NULL,
  `CPC_Vendedor` int(11) DEFAULT NULL,
  `CPC_TDC` double(10,2) DEFAULT NULL,
  `CPC_FlagMueveStock` char(1) NOT NULL DEFAULT '0',
  `GUIASAP_Codigo` int(11) DEFAULT NULL,
  `GUIAINP_Codigo` int(11) DEFAULT NULL,
  `USUA_anula` int(11) DEFAULT NULL,
  `CPC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CPC_FechaModificacion` datetime DEFAULT NULL,
  `CPC_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `CPC_Hora` time NOT NULL,
  `ALMAP_Codigo` int(11) NOT NULL,
  `CPP_Codigo_Canje` int(11) DEFAULT '0',
  `CPC_NumeroAutomatico` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_comprobante`
--

INSERT INTO `cji_comprobante` (`CPP_Codigo`, `CPC_TipoOperacion`, `CPC_TipoDocumento`, `PRESUP_Codigo`, `OCOMP_Codigo`, `COMPP_Codigo`, `CPC_Serie`, `CPC_Numero`, `CLIP_Codigo`, `PROVP_Codigo`, `CPC_NombreAuxiliar`, `USUA_Codigo`, `MONED_Codigo`, `FORPAP_Codigo`, `CPC_subtotal`, `CPC_descuento`, `CPC_igv`, `CPC_total`, `CPC_subtotal_conigv`, `CPC_descuento_conigv`, `CPC_igv100`, `CPC_descuento100`, `GUIAREMP_Codigo`, `CPC_GuiaRemCodigo`, `CPC_DocuRefeCodigo`, `CPC_Observacion`, `CPC_ModoImpresion`, `CPC_Fecha`, `CPC_Vendedor`, `CPC_TDC`, `CPC_FlagMueveStock`, `GUIASAP_Codigo`, `GUIAINP_Codigo`, `USUA_anula`, `CPC_FechaRegistro`, `CPC_FechaModificacion`, `CPC_FlagEstado`, `CPC_Hora`, `ALMAP_Codigo`, `CPP_Codigo_Canje`, `CPC_NumeroAutomatico`) VALUES
(6, 'C', 'F', NULL, NULL, 1, '658', 8568, 0, 12, 'cliente', 1, 1, 1, 7.63, 0.00, 1.37, 9.00, NULL, NULL, 18, 0, NULL, '', '', '', '2', '2017-01-23', 0, 6.00, '1', NULL, 145, NULL, '2017-01-23 21:13:39', '2017-01-23 16:13:42', '1', '16:13:39', 5, 0, 0),
(7, 'V', 'F', NULL, NULL, 1, '004', 636, 4, 0, 'cliente', 1, 1, 1, 7.63, 0.00, 1.37, 9.00, NULL, NULL, 18, 0, NULL, '', '', '', '2', '2017-01-23', 0, 6.00, '1', 5, NULL, NULL, '2017-01-23 21:17:11', '2017-01-23 17:49:09', '1', '16:17:11', 5, 0, 1),
(8, 'C', 'F', NULL, NULL, 1, '676', 7567, 0, 12, 'cliente', 1, 1, 1, 30.51, 0.00, 5.49, 36.00, NULL, NULL, 18, 0, NULL, '', '', '', '2', '2017-01-23', 0, 6.00, '1', NULL, 146, NULL, '2017-01-23 21:18:23', '2017-01-23 16:18:27', '1', '16:18:23', 5, 0, 0),
(9, 'C', 'F', NULL, NULL, 1, '796', 696, 0, 12, 'cliente', 1, 1, 1, 45.76, 0.00, 8.24, 54.00, NULL, NULL, 18, 0, NULL, '', '', '', '2', '2017-01-23', 0, 6.00, '1', NULL, 147, NULL, '2017-01-23 21:20:03', '2017-01-23 16:20:21', '1', '16:20:03', 5, 0, 0),
(10, 'V', 'F', NULL, NULL, 1, '004', 637, 4, 0, 'cliente', 1, 1, 1, 53.39, 0.00, 9.61, 63.00, NULL, NULL, 18, 0, NULL, '', '', '', '2', '2017-01-23', 0, 6.00, '1', 6, NULL, NULL, '2017-01-23 21:33:33', '2017-01-23 17:47:55', '1', '16:33:33', 5, 0, 1),
(11, 'V', 'F', NULL, NULL, 1, '004', 638, 4, 0, 'cliente', 1, 1, 1, 10.17, 0.00, 1.83, 12.00, NULL, NULL, 18, 0, NULL, '', '', '', '2', '2017-01-23', 15, 6.00, '1', 7, NULL, NULL, '2017-01-23 21:48:00', '2017-01-23 17:47:45', '1', '16:48:00', 5, 0, 1),
(12, 'V', 'F', NULL, NULL, 1, '004', 639, 4, 0, 'cliente', 1, 1, 1, 5.08, 0.00, 0.92, 6.00, NULL, NULL, 18, 0, NULL, '', '', '', '2', '2017-01-23', 15, 6.00, '1', 8, NULL, NULL, '2017-01-23 22:36:52', '2017-01-23 17:37:02', '1', '17:36:52', 5, 0, 1),
(13, 'V', 'F', NULL, NULL, 1, '004', 640, 4, 0, 'cliente', 1, 1, 1, 10.17, 0.00, 1.83, 12.00, NULL, NULL, 18, 0, NULL, '', '', '', '2', '2017-01-24', 0, 5.00, '1', 9, NULL, NULL, '2017-01-24 15:34:12', '2017-01-24 10:34:16', '1', '10:34:12', 5, 0, 1),
(14, 'C', 'F', NULL, NULL, 1, '687', 687, 0, 12, 'cliente', 1, 1, 1, 674.58, 0.00, 121.42, 796.00, NULL, NULL, 18, 0, NULL, '', '', '', '2', '2017-01-24', 0, 5.00, '1', NULL, 148, NULL, '2017-01-24 15:34:51', '2017-01-24 10:34:55', '1', '10:34:51', 5, 0, 0),
(15, 'V', 'F', NULL, NULL, 1, '004', 641, 4, 0, 'cliente', 1, 1, 1, 562.71, 0.00, 101.29, 664.00, NULL, NULL, 18, 0, NULL, '', '', '', '2', '2017-01-24', 0, 5.00, '1', 10, NULL, NULL, '2017-01-24 15:36:19', '2017-01-24 10:36:22', '1', '10:36:19', 5, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_comprobantedetalle`
--

CREATE TABLE `cji_comprobantedetalle` (
  `CPDEP_Codigo` int(11) NOT NULL,
  `CPP_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `CPDEC_GenInd` char(1) DEFAULT NULL,
  `UNDMED_Codigo` int(11) DEFAULT NULL,
  `CPDEC_Cantidad` double DEFAULT '0',
  `CPDEC_Pu` double DEFAULT NULL,
  `CPDEC_Subtotal` double DEFAULT NULL,
  `CPDEC_Descuento` double DEFAULT NULL,
  `CPDEC_Igv` double DEFAULT NULL,
  `CPDEC_Total` double NOT NULL DEFAULT '0',
  `CPDEC_Pu_ConIgv` double DEFAULT NULL COMMENT 'Para que pueda ser usado como detalle de una boleta',
  `CPDEC_Subtotal_ConIgv` double DEFAULT NULL COMMENT 'Para que pueda ser usado como detalle de una boleta',
  `CPDEC_Descuento_ConIgv` double DEFAULT NULL COMMENT 'Para que pueda ser usado como detalle de una boleta',
  `CPDEC_Igv100` int(11) DEFAULT '0',
  `CPDEC_Descuento100` int(11) DEFAULT '0',
  `CPDEC_Costo` double DEFAULT NULL,
  `CPDEC_Descripcion` varchar(250) DEFAULT NULL,
  `CPDEC_Observacion` varchar(250) DEFAULT NULL,
  `CPDEC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CPDEC_FechaModificacion` datetime DEFAULT NULL,
  `CPDEC_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `ALMAP_Codigo` int(11) NOT NULL,
  `GUIAREMP_Codigo` int(11) NOT NULL COMMENT 'si el producto esta asociado a una guiaremision  de diferente almacenes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_comprobantedetalle`
--

INSERT INTO `cji_comprobantedetalle` (`CPDEP_Codigo`, `CPP_Codigo`, `PROD_Codigo`, `CPDEC_GenInd`, `UNDMED_Codigo`, `CPDEC_Cantidad`, `CPDEC_Pu`, `CPDEC_Subtotal`, `CPDEC_Descuento`, `CPDEC_Igv`, `CPDEC_Total`, `CPDEC_Pu_ConIgv`, `CPDEC_Subtotal_ConIgv`, `CPDEC_Descuento_ConIgv`, `CPDEC_Igv100`, `CPDEC_Descuento100`, `CPDEC_Costo`, `CPDEC_Descripcion`, `CPDEC_Observacion`, `CPDEC_FechaRegistro`, `CPDEC_FechaModificacion`, `CPDEC_FlagEstado`, `ALMAP_Codigo`, `GUIAREMP_Codigo`) VALUES
(15, 6, 3, 'I', 4, 3, 2.5424, 7.6272, 0, 1.3728, 9, 3, NULL, NULL, 18, 0, 3, 'CELULAR NUEVO', '', '2017-01-23 21:13:39', NULL, '1', 5, 0),
(16, 7, 3, 'I', 4, 1, 3.3898, 3.3898, 0, 0.6102, 4, 4, NULL, NULL, 18, 0, 0, 'CELULAR NUEVO', '', '2017-01-23 21:17:11', NULL, '1', 5, 0),
(17, 7, 4, 'I', 4, 1, 4.2373, 4.2373, 0, 0.7627, 5, 5, NULL, NULL, 18, 0, 0, 'CELULAR NUEVO12_DOS', '', '2017-01-23 21:17:11', NULL, '1', 5, 0),
(18, 8, 3, 'I', 4, 6, 5.0847, 30.5082, 0, 5.4918, 36, 6, NULL, NULL, 18, 0, 6, 'CELULAR NUEVO', '', '2017-01-23 21:18:23', NULL, '1', 5, 0),
(19, 9, 4, 'I', 4, 5, 7.6271, 38.1355, 0, 6.8645, 45, 9, NULL, NULL, 18, 0, 9, 'CELULAR NUEVO12_DOS', '', '2017-01-23 21:20:03', NULL, '1', 5, 0),
(20, 9, 3, 'I', 4, 3, 2.5424, 7.6272, 0, 1.3728, 9, 3, NULL, NULL, 18, 0, 3, 'CELULAR NUEVO', '', '2017-01-23 21:20:04', NULL, '1', 5, 0),
(21, 10, 3, 'I', 4, 7, 7.6271, 53.3897, 0, 9.6103, 63, 9, NULL, NULL, 18, 0, 0, 'CELULAR NUEVO', '', '2017-01-23 21:33:33', NULL, '1', 5, 0),
(22, 11, 3, 'I', 4, 3, 3.3898, 10.1694, 0, 1.8306, 12, 4, NULL, NULL, 18, 0, 0, 'CELULAR NUEVO', '', '2017-01-23 21:48:00', NULL, '1', 5, 0),
(23, 12, 4, 'I', 4, 2, 2.5424, 5.0848, 0, 0.9152, 6, 3, NULL, NULL, 18, 0, 0, 'CELULAR NUEVO12_DOS', '', '2017-01-23 22:36:52', NULL, '1', 5, 0),
(24, 13, 4, 'I', 4, 1, 10.1695, 10.1695, 0, 1.8305, 12, 12, NULL, NULL, 18, 0, 0, 'CELULAR NUEVO12_DOS', '', '2017-01-24 15:34:12', NULL, '1', 5, 0),
(25, 14, 3, 'I', 4, 4, 168.6441, 674.5764, 0, 121.4236, 796, 199, NULL, NULL, 18, 0, 199, 'CELULAR NUEVO', '', '2017-01-24 15:34:51', NULL, '1', 5, 0),
(26, 15, 3, 'I', 4, 4, 140.678, 562.712, 0, 101.288, 664, 166, NULL, NULL, 18, 0, 0, 'CELULAR NUEVO', '', '2017-01-24 15:36:19', NULL, '1', 5, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_comprobante_guiarem`
--

CREATE TABLE `cji_comprobante_guiarem` (
  `COMPGUI_Codigo` int(11) NOT NULL,
  `CPP_Codigo` int(11) NOT NULL COMMENT 'Codigo del comprobante',
  `GUIAREMP_Codigo` int(11) NOT NULL COMMENT 'Codigo de Guia remision',
  `COMPGUI_FlagEstado` int(2) NOT NULL,
  `COMPGU_FechaRegistro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cji_comprobante_guiarem`
--

INSERT INTO `cji_comprobante_guiarem` (`COMPGUI_Codigo`, `CPP_Codigo`, `GUIAREMP_Codigo`, `COMPGUI_FlagEstado`, `COMPGU_FechaRegistro`) VALUES
(12, 6, 217, 3, '2017-01-23 16:13:42'),
(14, 8, 219, 3, '2017-01-23 16:18:28'),
(16, 9, 221, 3, '2017-01-23 16:20:22'),
(20, 12, 225, 3, '2017-01-23 17:37:02'),
(22, 11, 227, 3, '2017-01-23 17:47:46'),
(23, 10, 228, 3, '2017-01-23 17:47:55'),
(24, 7, 229, 3, '2017-01-23 17:49:10'),
(25, 13, 230, 3, '2017-01-24 10:34:17'),
(26, 14, 231, 3, '2017-01-24 10:34:56'),
(27, 15, 232, 3, '2017-01-24 10:36:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_condicionentrega`
--

CREATE TABLE `cji_condicionentrega` (
  `CONENP_Codigo` int(11) NOT NULL,
  `CONENC_Descripcion` varchar(250) DEFAULT NULL,
  `CONENC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CONENC_FechaModificacion` datetime DEFAULT NULL,
  `CONENC_FlagEstado` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_condicionentrega`
--

INSERT INTO `cji_condicionentrega` (`CONENP_Codigo`, `CONENC_Descripcion`, `CONENC_FechaRegistro`, `CONENC_FechaModificacion`, `CONENC_FlagEstado`) VALUES
(1, 'INMEDIATA', '2011-01-14 20:07:07', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_configuracion`
--

CREATE TABLE `cji_configuracion` (
  `CONFIP_Codigo` int(11) NOT NULL,
  `DOCUP_Codigo` int(11) NOT NULL,
  `CONFIC_Serie` char(10) DEFAULT NULL,
  `CONFIC_Numero` char(11) DEFAULT NULL,
  `CONFIC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `COMPP_Codigo` int(11) NOT NULL,
  `CONFIC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_configuracion`
--

INSERT INTO `cji_configuracion` (`CONFIP_Codigo`, `DOCUP_Codigo`, `CONFIC_Serie`, `CONFIC_Numero`, `CONFIC_FechaRegistro`, `COMPP_Codigo`, `CONFIC_FlagEstado`) VALUES
(2, 1, '001', '00875', '2011-01-14 20:42:57', 1, '1'),
(3, 2, '002', '0087', '2011-01-14 20:43:07', 1, '1'),
(4, 3, '003', '84', '2011-01-14 20:43:21', 1, '1'),
(5, 5, '006', '359', '2011-01-14 20:43:45', 1, '1'),
(6, 6, '007', '306', '2011-01-14 20:43:54', 1, '1'),
(7, 7, '008', '0054', '2011-01-14 20:44:21', 1, '1'),
(8, 4, '004', '0089', '2011-01-14 20:44:36', 1, '1'),
(9, 9, '0011', '111', '2011-01-14 20:44:52', 1, '1'),
(10, 8, '004', '641', '2011-01-14 20:45:02', 1, '1'),
(11, 10, '005', '333352', '2011-01-14 20:45:19', 1, '1'),
(12, 11, '0013', '0098', '2011-01-14 20:45:37', 1, '1'),
(13, 12, '014', '0096', '2011-01-14 20:46:07', 1, '1'),
(14, 13, '005', '000017', '2011-08-09 19:48:10', 1, '1'),
(15, 14, '010', '0136', '2011-08-11 19:04:29', 1, '1'),
(16, 15, '005', '454517', '2012-02-09 22:43:22', 1, '1'),
(32, 16, '001', '2517', '2014-04-10 06:25:35', 1, '1'),
(33, 1, NULL, '0', '2016-11-14 22:21:48', 2, '1'),
(34, 2, NULL, '0', '2016-11-14 22:21:48', 2, '1'),
(35, 3, NULL, '0', '2016-11-14 22:21:48', 2, '1'),
(36, 5, NULL, '0', '2016-11-14 22:21:48', 2, '1'),
(37, 6, NULL, '0', '2016-11-14 22:21:48', 2, '1'),
(38, 7, NULL, '0', '2016-11-14 22:21:48', 2, '1'),
(39, 4, NULL, '0', '2016-11-14 22:21:48', 2, '1'),
(40, 9, NULL, '0', '2016-11-14 22:21:48', 2, '1'),
(41, 8, NULL, '0', '2016-11-14 22:21:48', 2, '1'),
(42, 10, NULL, '0', '2016-11-14 22:21:48', 2, '1'),
(43, 11, NULL, '0', '2016-11-14 22:21:48', 2, '1'),
(44, 12, NULL, '0', '2016-11-14 22:21:48', 2, '1'),
(45, 13, NULL, '0', '2016-11-14 22:21:48', 2, '1'),
(46, 14, NULL, '0', '2016-11-14 22:21:48', 2, '1'),
(47, 15, NULL, '0', '2016-11-14 22:21:48', 2, '1'),
(48, 1, NULL, '0', '2016-11-15 22:12:46', 3, '1'),
(49, 2, NULL, '0', '2016-11-15 22:12:46', 3, '1'),
(50, 3, NULL, '0', '2016-11-15 22:12:46', 3, '1'),
(51, 5, NULL, '0', '2016-11-15 22:12:46', 3, '1'),
(52, 6, NULL, '0', '2016-11-15 22:12:46', 3, '1'),
(53, 7, NULL, '0', '2016-11-15 22:12:46', 3, '1'),
(54, 4, NULL, '0', '2016-11-15 22:12:46', 3, '1'),
(55, 9, NULL, '0', '2016-11-15 22:12:46', 3, '1'),
(56, 8, NULL, '0', '2016-11-15 22:12:46', 3, '1'),
(57, 10, NULL, '0', '2016-11-15 22:12:46', 3, '1'),
(58, 11, NULL, '0', '2016-11-15 22:12:46', 3, '1'),
(59, 12, NULL, '0', '2016-11-15 22:12:46', 3, '1'),
(60, 13, NULL, '0', '2016-11-15 22:12:46', 3, '1'),
(61, 14, NULL, '0', '2016-11-15 22:12:46', 3, '1'),
(62, 15, NULL, '0', '2016-11-15 22:12:46', 3, '1'),
(63, 1, NULL, '0', '2016-12-24 03:52:11', 2, '1'),
(64, 2, NULL, '0', '2016-12-24 03:52:11', 2, '1'),
(65, 3, NULL, '0', '2016-12-24 03:52:11', 2, '1'),
(66, 5, NULL, '0', '2016-12-24 03:52:11', 2, '1'),
(67, 6, NULL, '0', '2016-12-24 03:52:11', 2, '1'),
(68, 7, NULL, '0', '2016-12-24 03:52:11', 2, '1'),
(69, 4, NULL, '0', '2016-12-24 03:52:11', 2, '1'),
(70, 9, NULL, '0', '2016-12-24 03:52:11', 2, '1'),
(71, 8, NULL, '0', '2016-12-24 03:52:11', 2, '1'),
(72, 10, NULL, '0', '2016-12-24 03:52:11', 2, '1'),
(73, 11, NULL, '0', '2016-12-24 03:52:11', 2, '1'),
(74, 12, NULL, '0', '2016-12-24 03:52:11', 2, '1'),
(75, 13, NULL, '0', '2016-12-24 03:52:11', 2, '1'),
(76, 14, NULL, '0', '2016-12-24 03:52:11', 2, '1'),
(77, 15, NULL, '0', '2016-12-24 03:52:11', 2, '1'),
(78, 1, NULL, '0', '2016-12-26 20:16:09', 3, '1'),
(79, 2, NULL, '0', '2016-12-26 20:16:09', 3, '1'),
(80, 3, NULL, '0', '2016-12-26 20:16:09', 3, '1'),
(81, 5, NULL, '0', '2016-12-26 20:16:09', 3, '1'),
(82, 6, NULL, '0', '2016-12-26 20:16:09', 3, '1'),
(83, 7, NULL, '0', '2016-12-26 20:16:09', 3, '1'),
(84, 4, NULL, '0', '2016-12-26 20:16:09', 3, '1'),
(85, 9, NULL, '0', '2016-12-26 20:16:09', 3, '1'),
(86, 8, NULL, '0', '2016-12-26 20:16:09', 3, '1'),
(87, 10, NULL, '0', '2016-12-26 20:16:09', 3, '1'),
(88, 11, NULL, '0', '2016-12-26 20:16:09', 3, '1'),
(89, 12, NULL, '0', '2016-12-26 20:16:09', 3, '1'),
(90, 13, NULL, '0', '2016-12-26 20:16:09', 3, '1'),
(91, 14, NULL, '0', '2016-12-26 20:16:09', 3, '1'),
(92, 15, NULL, '0', '2016-12-26 20:16:09', 3, '1'),
(93, 1, NULL, '0', '2016-12-29 03:31:22', 4, '1'),
(94, 2, NULL, '0', '2016-12-29 03:31:22', 4, '1'),
(95, 3, NULL, '0', '2016-12-29 03:31:22', 4, '1'),
(96, 5, NULL, '0', '2016-12-29 03:31:22', 4, '1'),
(97, 6, NULL, '0', '2016-12-29 03:31:22', 4, '1'),
(98, 7, NULL, '0', '2016-12-29 03:31:22', 4, '1'),
(99, 4, NULL, '0', '2016-12-29 03:31:22', 4, '1'),
(100, 9, NULL, '0', '2016-12-29 03:31:22', 4, '1'),
(101, 8, NULL, '0', '2016-12-29 03:31:22', 4, '1'),
(102, 10, NULL, '0', '2016-12-29 03:31:22', 4, '1'),
(103, 11, NULL, '0', '2016-12-29 03:31:22', 4, '1'),
(104, 12, NULL, '0', '2016-12-29 03:31:22', 4, '1'),
(105, 13, NULL, '0', '2016-12-29 03:31:22', 4, '1'),
(106, 14, NULL, '0', '2016-12-29 03:31:22', 4, '1'),
(107, 15, NULL, '0', '2016-12-29 03:31:22', 4, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_correlativo`
--

CREATE TABLE `cji_correlativo` (
  `CORRP_Codigo` int(11) NOT NULL,
  `CORRC_Siglas` varchar(10) DEFAULT NULL,
  `CORRC_Numero` int(11) DEFAULT NULL,
  `CORRC_Descripcion` varchar(250) DEFAULT NULL,
  `CORRC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CORRC_FechaModificacion` datetime DEFAULT NULL,
  `CORRC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_correlativo`
--

INSERT INTO `cji_correlativo` (`CORRP_Codigo`, `CORRC_Siglas`, `CORRC_Numero`, `CORRC_Descripcion`, `CORRC_FechaRegistro`, `CORRC_FechaModificacion`, `CORRC_FlagEstado`) VALUES
(1, 'OI', 0, 'ORDEN DE INGRESO', '2011-01-14 20:42:23', NULL, '1'),
(2, 'OP', 0, 'ORDEN DE PEDIDO', '2011-01-14 20:42:57', NULL, '1'),
(3, 'COT', 0, 'COTIZACION', '2011-01-14 20:43:07', NULL, '1'),
(4, 'OC', 0, 'ORDEN DE COMPRA', '2011-01-14 20:43:21', NULL, '1'),
(5, 'GI', 0, 'GUIA DE INGRESO', '2011-01-14 20:43:45', NULL, '1'),
(6, 'GS', 0, 'GUIA DE SALIDA', '2011-01-14 20:43:54', NULL, '1'),
(7, 'VS', 0, 'VALE DE SALIDA', '2011-01-14 20:44:21', NULL, '1'),
(8, 'INV', 0, 'INVENTARIO', '2011-01-14 20:44:36', NULL, '1'),
(9, 'BOL', 0, 'BOLETA DE VENTA', '2011-01-14 20:44:52', NULL, '1'),
(10, 'FAC', 0, 'FACTURA', '2011-01-14 20:45:02', NULL, '1'),
(11, 'GR', 0, 'GUIA DE REMISION', '2011-01-14 20:45:19', NULL, '1'),
(12, 'NC', 0, 'NOTA DE CREDITO', '2011-01-14 20:45:37', NULL, '1'),
(13, 'ND', 0, 'NOTA DE DEBITO', '2011-01-14 20:46:07', NULL, '1'),
(14, 'LC', 0, 'LETRA DE CAMBIO', '2014-04-10 06:24:14', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_correoenviar`
--

CREATE TABLE `cji_correoenviar` (
  `CE_Codigo` int(11) NOT NULL,
  `PRESUP_Codigo` int(11) NOT NULL,
  `USUA_Codigo` int(11) NOT NULL,
  `CE_FechaEnvio` date NOT NULL,
  `CE_CorreoRemitente` varchar(250) NOT NULL,
  `CE_CorreoReceptor` varchar(250) NOT NULL,
  `CE_NombreRemitente` varchar(250) NOT NULL,
  `CE_NombreReceptor` varchar(250) NOT NULL,
  `CE_Mensaje` varchar(250) NOT NULL,
  `CE_Excel` int(11) NOT NULL,
  `CE_Pdf` int(11) NOT NULL,
  `CE_Estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_cotizacion`
--

CREATE TABLE `cji_cotizacion` (
  `COTIP_Codigo` int(11) NOT NULL,
  `PEDIP_Codigo` int(11) NOT NULL,
  `COTIC_Numero` int(11) NOT NULL,
  `COTIC_Serie` char(3) NOT NULL,
  `PROVP_Codigo` int(11) DEFAULT NULL,
  `FORPAP_Codigo` int(11) DEFAULT NULL,
  `CONENP_Codigo` int(11) DEFAULT NULL,
  `USUA_Codigo` int(11) DEFAULT NULL,
  `CENCOSP_Codigo` int(11) DEFAULT NULL,
  `ALMAP_Codigo` int(11) NOT NULL,
  `COTIC_Observacion` varchar(250) DEFAULT NULL,
  `COTIC_TiempoOferta` int(11) DEFAULT NULL,
  `COTIC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `COTIC_FechaModificacion` datetime DEFAULT NULL,
  `COTIC_FlagCompra` char(1) DEFAULT '0',
  `COTIC_FlagIngreso` char(1) DEFAULT '0',
  `COMPP_Codigo` int(11) NOT NULL,
  `COTIC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_cotizaciondetalle`
--

CREATE TABLE `cji_cotizaciondetalle` (
  `COTDEP_Codigo` int(10) NOT NULL,
  `COTIP_Codigo` int(11) NOT NULL,
  `PEDIP_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `UNDMED_Codigo` int(11) NOT NULL,
  `COTDEC_Cantidad` double DEFAULT NULL,
  `COTDEC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `COTDEC_FechaModificacion` datetime DEFAULT NULL,
  `COTDEC_Observacion` varchar(250) DEFAULT NULL,
  `COTDEC_FlagOcompra` char(1) DEFAULT '0',
  `COTDEC_FlagIngreso` char(1) DEFAULT '0',
  `COTDEC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_cuentacontable`
--

CREATE TABLE `cji_cuentacontable` (
  `CUNTCONTBL_Codigo` int(11) NOT NULL,
  `CUNTCONTBL_Descripcion` varchar(200) NOT NULL,
  `CUNTCONTBL_Abreviatura` varchar(200) NOT NULL,
  `CUNTCONTBL_Nombre` varchar(200) NOT NULL,
  `CUNTCONTBL_CodigoPadre` int(11) NOT NULL,
  `CUNTCONTBL_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CUNTCONTBL_FechaModificacion` datetime NOT NULL,
  `CUNTCONTBL_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `CUNTCONTBL_CodigoUsuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cji_cuentacontable`
--

INSERT INTO `cji_cuentacontable` (`CUNTCONTBL_Codigo`, `CUNTCONTBL_Descripcion`, `CUNTCONTBL_Abreviatura`, `CUNTCONTBL_Nombre`, `CUNTCONTBL_CodigoPadre`, `CUNTCONTBL_FechaRegistro`, `CUNTCONTBL_FechaModificacion`, `CUNTCONTBL_FlagEstado`, `CUNTCONTBL_CodigoUsuario`) VALUES
(1, 'Alimentacion', '', 'Alimentacion', 0, '2016-12-12 22:54:44', '0000-00-00 00:00:00', '1', 1),
(2, 'Vacaciones', '', 'Vacaciones', 0, '2016-12-12 22:54:44', '0000-00-00 00:00:00', '1', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_cuentas`
--

CREATE TABLE `cji_cuentas` (
  `CUE_Codigo` int(11) NOT NULL,
  `CUE_TipoCuenta` int(11) NOT NULL COMMENT '1: Cuenta por cobrar, 2: Cuenta por pagar',
  `DOCUP_Codigo` int(1) NOT NULL,
  `CUE_CodDocumento` int(11) NOT NULL COMMENT 'Código del documento (factura, boleta, etc)',
  `MONED_Codigo` int(11) NOT NULL,
  `CUE_Monto` double NOT NULL,
  `CUE_FechaOper` date DEFAULT NULL,
  `CUE_FlagEstadoPago` varchar(1) NOT NULL DEFAULT 'V' COMMENT 'V: No pago nada, A: avance, C: cancelado',
  `CUE_FechaCanc` date DEFAULT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `CUE_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CUE_FechaModificacion` datetime DEFAULT NULL,
  `CUE_FlagEstado` varchar(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_cuentas`
--

INSERT INTO `cji_cuentas` (`CUE_Codigo`, `CUE_TipoCuenta`, `DOCUP_Codigo`, `CUE_CodDocumento`, `MONED_Codigo`, `CUE_Monto`, `CUE_FechaOper`, `CUE_FlagEstadoPago`, `CUE_FechaCanc`, `COMPP_Codigo`, `CUE_FechaRegistro`, `CUE_FechaModificacion`, `CUE_FlagEstado`) VALUES
(6, 2, 8, 6, 1, 9, '2017-01-23', 'C', '2017-01-23', 1, '2017-01-23 21:13:41', NULL, '1'),
(7, 1, 8, 7, 1, 9, '2017-01-23', 'C', '2017-01-23', 1, '2017-01-23 21:17:14', '2017-01-23 17:49:09', '1'),
(8, 2, 8, 8, 1, 36, '2017-01-23', 'C', '2017-01-23', 1, '2017-01-23 21:18:26', NULL, '1'),
(9, 2, 8, 9, 1, 54, '2017-01-23', 'C', '2017-01-23', 1, '2017-01-23 21:20:06', '2017-01-23 16:20:21', '1'),
(10, 1, 8, 10, 1, 63, '2017-01-23', 'C', '2017-01-23', 1, '2017-01-23 21:33:36', '2017-01-23 17:47:54', '1'),
(11, 1, 8, 11, 1, 12, '2017-01-23', 'C', '2017-01-23', 1, '2017-01-23 21:48:03', '2017-01-23 17:47:45', '1'),
(12, 1, 8, 12, 1, 6, '2017-01-23', 'C', '2017-01-23', 1, '2017-01-23 22:37:01', NULL, '1'),
(13, 1, 8, 13, 1, 12, '2017-01-24', 'C', '2017-01-24', 1, '2017-01-24 15:34:16', NULL, '1'),
(14, 2, 8, 14, 1, 796, '2017-01-24', 'C', '2017-01-24', 1, '2017-01-24 15:34:54', NULL, '1'),
(15, 1, 8, 15, 1, 664, '2017-01-24', 'C', '2017-01-24', 1, '2017-01-24 15:36:22', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_cuentasempresas`
--

CREATE TABLE `cji_cuentasempresas` (
  `CUENT_Codigo` int(11) NOT NULL,
  `EMPRE_Codigo` int(11) DEFAULT NULL,
  `PERSP_Codigo` int(11) DEFAULT NULL,
  `BANP_Codigo` int(11) DEFAULT NULL,
  `MONED_Codigo` int(11) DEFAULT NULL,
  `CUENT_NumeroEmpresa` varchar(100) DEFAULT NULL,
  `CUENT_Titular` varchar(100) DEFAULT NULL,
  `CUENT_TipoCuenta` char(1) DEFAULT NULL COMMENT '1 Ahorros2 Corriente',
  `CUENT_TipoPersona` char(1) DEFAULT NULL,
  `CUENT_FechaRegistro` date DEFAULT NULL,
  `CUENT_FechaModificacion` datetime DEFAULT NULL,
  `CUENT_UsuarioRegistro` int(11) DEFAULT NULL,
  `CUENT_Oficina` varchar(50) NOT NULL,
  `CUENT_Sectoriza` varchar(50) NOT NULL,
  `CUENT_Interbancaria` varchar(50) NOT NULL,
  `CUENT_UsuarioModificaion` int(11) DEFAULT NULL,
  `CUENT_FlagEstado` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_cuentaspago`
--

CREATE TABLE `cji_cuentaspago` (
  `CPAGP_Codigo` int(11) NOT NULL,
  `CUE_Codigo` int(11) NOT NULL,
  `PAGP_Codigo` int(11) NOT NULL,
  `CPAGC_TDC` double(10,2) NOT NULL,
  `CPAGC_Monto` double NOT NULL,
  `MONED_Codigo` int(11) NOT NULL,
  `CPAGC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CPAGC_FechaModificacion` datetime NOT NULL,
  `CPAGC_FlagEstado` varchar(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_cuentaspago`
--

INSERT INTO `cji_cuentaspago` (`CPAGP_Codigo`, `CUE_Codigo`, `PAGP_Codigo`, `CPAGC_TDC`, `CPAGC_Monto`, `MONED_Codigo`, `CPAGC_FechaRegistro`, `CPAGC_FechaModificacion`, `CPAGC_FlagEstado`) VALUES
(5, 6, 5, 6.00, 9, 1, '2017-01-23 21:13:41', '0000-00-00 00:00:00', '1'),
(6, 7, 6, 6.00, 9, 1, '2017-01-23 21:17:14', '0000-00-00 00:00:00', '1'),
(7, 8, 7, 6.00, 36, 1, '2017-01-23 21:18:26', '0000-00-00 00:00:00', '1'),
(8, 9, 8, 6.00, 54, 1, '2017-01-23 21:20:06', '0000-00-00 00:00:00', '1'),
(9, 10, 9, 6.00, 63, 1, '2017-01-23 21:33:37', '0000-00-00 00:00:00', '1'),
(10, 11, 10, 6.00, 12, 1, '2017-01-23 21:48:03', '0000-00-00 00:00:00', '1'),
(11, 12, 11, 6.00, 6, 1, '2017-01-23 22:37:02', '0000-00-00 00:00:00', '1'),
(12, 13, 12, 5.00, 12, 1, '2017-01-24 15:34:16', '0000-00-00 00:00:00', '1'),
(13, 14, 13, 5.00, 796, 1, '2017-01-24 15:34:54', '0000-00-00 00:00:00', '1'),
(14, 15, 14, 5.00, 664, 1, '2017-01-24 15:36:22', '0000-00-00 00:00:00', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_direccion`
--

CREATE TABLE `cji_direccion` (
  `DIRECC_Codigo` int(11) UNSIGNED NOT NULL,
  `DIRECC_Descrip` varchar(200) NOT NULL,
  `DIRECC_Referen` varchar(200) NOT NULL,
  `UBIGP_Domicilio` char(6) NOT NULL,
  `PROYP_Codigo` int(11) NOT NULL,
  `DIRECC_Mapa` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `DIRECC_StreetView` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `DIRECC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DIRECC_FechaModificacion` datetime DEFAULT NULL,
  `DIRECC_FlagEstado` char(1) DEFAULT NULL,
  `DIRECC_FlagUno` char(1) DEFAULT NULL,
  `DIRECC_FlagDos` char(1) DEFAULT NULL,
  `DIRECC_CodigoUsuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_directivo`
--

CREATE TABLE `cji_directivo` (
  `DIREP_Codigo` int(11) NOT NULL,
  `EMPRP_Codigo` int(11) NOT NULL,
  `PERSP_Codigo` int(11) NOT NULL,
  `CARGP_Codigo` int(11) NOT NULL,
  `DIREC_FechaInicio` date NOT NULL,
  `DIREC_FechaFin` date NOT NULL,
  `DIREC_NroContrato` varchar(100) CHARACTER SET utf8 NOT NULL,
  `DIREC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DIREC_FechaModificacion` datetime DEFAULT NULL,
  `DIREC_FlagEstado` char(1) DEFAULT '1',
  `DIREC_Imagen` varchar(250) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cji_directivo`
--

INSERT INTO `cji_directivo` (`DIREP_Codigo`, `EMPRP_Codigo`, `PERSP_Codigo`, `CARGP_Codigo`, `DIREC_FechaInicio`, `DIREC_FechaFin`, `DIREC_NroContrato`, `DIREC_FechaRegistro`, `DIREC_FechaModificacion`, `DIREC_FlagEstado`, `DIREC_Imagen`) VALUES
(33, 1, 15, 2, '2017-01-23', '2017-01-23', '55', '2017-01-23 22:33:39', NULL, '1', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_documento`
--

CREATE TABLE `cji_documento` (
  `DOCUP_Codigo` int(11) NOT NULL,
  `DOCUC_Descripcion` varchar(250) DEFAULT '0',
  `DOCUC_Inicial` varchar(25) NOT NULL,
  `DOCUC_FlagComprobante` char(1) NOT NULL DEFAULT '0',
  `DOCUC_FlagEstado` int(1) DEFAULT '1',
  `DOCUC_ABREVI` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_documento`
--

INSERT INTO `cji_documento` (`DOCUP_Codigo`, `DOCUC_Descripcion`, `DOCUC_Inicial`, `DOCUC_FlagComprobante`, `DOCUC_FlagEstado`, `DOCUC_ABREVI`) VALUES
(1, 'ORDEN DE PEDIDO', 'O.P.', '0', 1, ''),
(2, 'COTIZACION', 'Cot.', '0', 1, ''),
(3, 'ORDEN DE COMPRA', 'O.C.', '0', 1, ''),
(4, 'INVENTARIO', 'Inv.', '0', 1, ''),
(5, 'GUIA DE INGRESO', 'C.Ing.', '0', 1, ''),
(6, 'GUIA DE SALIDA', 'C.Sa.', '0', 1, ''),
(7, 'VALE DE SALIDA', '', '0', 1, ''),
(8, 'FACTURA', 'Fact.', '1', 1, 'F'),
(9, 'BOLETA', 'Bol.', '1', 1, 'B'),
(10, 'GUIA DE REMISION', 'G.Rem.', '0', 1, 'GR'),
(11, 'NOTA DE CREDITO', 'N.C.', '0', 1, ''),
(12, 'NOTA DE DEBITO', 'N.D.', '0', 1, ''),
(13, 'PRESUPUESTO', 'Pres.', '0', 1, ''),
(14, 'COMPROBANTE GENERAL', 'Comp', '0', 1, 'N'),
(15, 'GUIA DE TRANSFERENCIA', 'G.T.', '0', 1, ''),
(16, 'LETRA DE CAMBIO', 'L.C.', '0', 1, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_documentoitem`
--

CREATE TABLE `cji_documentoitem` (
  `DOCUITEM_Codigo` int(11) NOT NULL,
  `ITEM_Codigo` int(11) NOT NULL,
  `DOCUP_Codigo` int(11) NOT NULL,
  `DOCUITEM_Width` double DEFAULT NULL,
  `DOCUITEM_Height` double DEFAULT NULL,
  `DOCUITEM_Activacion` char(1) DEFAULT NULL,
  `DOCUITEM_PosicionX` double DEFAULT NULL,
  `DOCUITEM_PosicionY` double DEFAULT NULL,
  `DOCUITEM_Estado` char(1) DEFAULT NULL,
  `DOCUITEM_Variable` varchar(250) DEFAULT NULL,
  `DOCUITEM_TamanioLetra` int(11) DEFAULT NULL,
  `DOCUITEM_TipoLetra` varchar(250) DEFAULT NULL,
  `COMPADOCUITEM_VGrupo` varchar(50) NOT NULL,
  `COMPADOCUITEM_Alineamiento` varchar(2) NOT NULL,
  `COMPADOCUITEM_Activacion` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cji_documentoitem`
--

INSERT INTO `cji_documentoitem` (`DOCUITEM_Codigo`, `ITEM_Codigo`, `DOCUP_Codigo`, `DOCUITEM_Width`, `DOCUITEM_Height`, `DOCUITEM_Activacion`, `DOCUITEM_PosicionX`, `DOCUITEM_PosicionY`, `DOCUITEM_Estado`, `DOCUITEM_Variable`, `DOCUITEM_TamanioLetra`, `DOCUITEM_TipoLetra`, `COMPADOCUITEM_VGrupo`, `COMPADOCUITEM_Alineamiento`, `COMPADOCUITEM_Activacion`) VALUES
(11, 8, 9, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(12, 9, 9, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(13, 10, 9, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(14, 11, 9, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(15, 12, 9, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(16, 13, 9, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(17, 14, 9, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(18, 15, 9, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(19, 16, 9, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(20, 17, 9, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(21, 18, 9, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(22, 19, 9, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(23, 20, 9, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(24, 21, 9, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(25, 22, 9, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(26, 23, 9, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(43, 2, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(44, 3, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(45, 6, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(46, 8, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(47, 9, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(48, 10, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(49, 11, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(50, 12, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(51, 13, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(52, 14, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(53, 15, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(54, 16, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(55, 17, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(56, 18, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(57, 19, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(58, 20, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(59, 21, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(60, 22, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(61, 23, 10, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(62, 2, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(63, 3, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(64, 6, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(65, 8, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(66, 9, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(67, 10, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(68, 11, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(69, 12, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(70, 13, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(71, 14, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(72, 15, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(73, 16, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(74, 17, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(75, 18, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(76, 19, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(77, 20, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(78, 21, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(79, 22, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(80, 23, 1, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(81, 2, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(82, 3, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(83, 6, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(84, 8, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(85, 9, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(86, 10, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(87, 11, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(88, 12, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(89, 13, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(90, 14, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(91, 15, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(92, 16, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(93, 17, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(94, 18, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(95, 19, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(96, 20, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(97, 21, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(98, 22, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(99, 23, 2, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(100, 2, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(101, 3, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(102, 6, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(103, 8, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(104, 9, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(105, 10, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(106, 11, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(107, 12, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(108, 13, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(109, 14, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(110, 15, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(111, 16, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(112, 17, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(113, 18, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(114, 19, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(115, 20, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(116, 21, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(117, 22, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(118, 23, 3, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(119, 2, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(120, 3, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(121, 6, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(122, 8, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(123, 9, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(124, 10, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(125, 11, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(126, 12, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(127, 13, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(128, 14, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(129, 15, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(130, 16, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(131, 17, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(132, 18, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(133, 19, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(134, 20, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(135, 21, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(136, 22, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(137, 23, 4, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(138, 2, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(139, 3, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(140, 6, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(141, 8, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(142, 9, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(143, 10, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(144, 11, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(145, 12, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(146, 13, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(147, 14, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(148, 15, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(149, 16, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(150, 17, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(151, 18, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(152, 19, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(153, 20, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(154, 21, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(155, 22, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(156, 23, 5, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(157, 2, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(158, 3, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(159, 6, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(160, 8, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(161, 9, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(162, 10, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(163, 11, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(164, 12, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(165, 13, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(166, 14, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(167, 15, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(168, 16, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(169, 17, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(170, 18, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(171, 19, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(172, 20, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(173, 21, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(174, 22, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(175, 23, 6, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(176, 2, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(177, 3, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(178, 6, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(179, 8, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(180, 9, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(181, 10, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(182, 11, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(183, 12, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(184, 13, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(185, 14, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(186, 15, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(187, 16, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(188, 17, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(189, 18, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(190, 19, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(191, 20, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(192, 21, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(193, 22, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(194, 23, 7, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(195, 2, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(196, 3, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(197, 6, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(198, 8, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(199, 9, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(200, 10, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(201, 11, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(202, 12, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(203, 13, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(204, 14, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(205, 15, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(206, 16, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(207, 17, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(208, 18, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(209, 19, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(210, 20, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(211, 21, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(212, 22, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(213, 23, 11, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(214, 2, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(215, 3, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(216, 6, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(217, 8, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(218, 9, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(219, 10, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(220, 11, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(221, 12, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(222, 13, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(223, 14, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(224, 15, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(225, 16, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(226, 17, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(227, 18, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(228, 19, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(229, 20, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(230, 21, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(231, 22, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(232, 23, 12, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(233, 2, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(234, 3, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(235, 6, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(236, 8, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(237, 9, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(238, 10, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(239, 11, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(240, 12, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(241, 13, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(242, 14, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(243, 15, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(244, 16, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(245, 17, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(246, 18, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(247, 19, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(248, 20, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(249, 21, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(250, 22, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(251, 23, 13, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(252, 2, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(253, 3, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(254, 6, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(255, 8, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(256, 9, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(257, 10, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(258, 11, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(259, 12, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(260, 13, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(261, 14, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(262, 15, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(263, 16, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(264, 17, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(265, 18, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(266, 19, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(267, 20, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(268, 21, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(269, 22, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(270, 23, 14, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(271, 2, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(272, 3, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(273, 6, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(274, 8, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(275, 9, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(276, 10, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(277, 11, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(278, 12, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(279, 13, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(280, 14, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(281, 15, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(282, 16, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(283, 17, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(284, 18, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(285, 19, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(286, 20, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(287, 21, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(288, 22, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(289, 23, 15, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(290, 2, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(291, 3, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(292, 6, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(293, 8, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(294, 9, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(295, 10, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(296, 11, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(297, 12, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(298, 13, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(299, 14, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(300, 15, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(301, 16, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(302, 17, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(303, 18, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(304, 19, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(305, 20, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(306, 21, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(307, 22, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(308, 23, 16, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(309, 2, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(310, 3, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(311, 6, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(312, 8, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(313, 9, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(314, 10, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(315, 11, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(316, 12, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(317, 13, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(318, 14, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(319, 15, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(320, 16, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(321, 17, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(322, 18, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(323, 19, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(324, 20, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(325, 21, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(326, 22, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL),
(327, 23, 8, 20, 20, '1', 20, 20, '1', 'variable', 8, 'arial', '', '', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_documentosentenica`
--

CREATE TABLE `cji_documentosentenica` (
  `DOCSENT_Codigo` int(11) NOT NULL,
  `DOCSENT_Tipo` int(1) NOT NULL,
  `DOCSENT_Select` longtext NOT NULL,
  `DOCSENT_CodigoRelacion` varchar(50) NOT NULL,
  `COMPCONFIDOCP_Codigo` int(11) NOT NULL,
  `DOCSENT_VariableCodigoRelacion` varchar(50) NOT NULL,
  `DOCSENT_VariableGrupo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cji_documentosentenica`
--

INSERT INTO `cji_documentosentenica` (`DOCSENT_Codigo`, `DOCSENT_Tipo`, `DOCSENT_Select`, `DOCSENT_CodigoRelacion`, `COMPCONFIDOCP_Codigo`, `DOCSENT_VariableCodigoRelacion`, `DOCSENT_VariableGrupo`) VALUES
(595, 1, 'select c.CPP_Codigo, c.CLIP_Codigo as CCLIENTE,\nc.CPC_total as TOTAL, c.CPC_total  as MONTOLETRA , c.CPC_igv as IGV, c.CPC_subtotal as SUBTOTAL, c.CPC_Fecha as FECHAEMI, c.FORPAP_Codigo, c.MONED_Codigo, CONCAT (c.CPC_Serie,'' '',c.CPC_Numero) as COMPROBANTE\n from cji_comprobante c where CPP_Codigo=$CodigoPrincipal', '', 9, '$CodigoPrincipal', ''),
(596, 2, 'SELECT und.UNDMED_Descripcion as UNIDAD , cd.CPDEC_Cantidad as CANTIDAD, cd.CPDEC_Total as TOTALP, cd.CPDEC_Pu as PUNIT, cd.CPDEC_Descripcion as NOMBREP, cd.UNDMED_Codigo as UCODIGO FROM cji_comprobantedetalle cd INNER JOIN cji_unidadmedida und ON und.UNDMED_Codigo=cd.UNDMED_Codigo WHERE cd.CPP_Codigo=$ccomp', 'CPP_Codigo', 9, '$ccomp', ''),
(597, 2, 'SELECT fp.FORPAC_Descripcion as FORMAPA FROM cji_formapago fp WHERE fp.FORPAP_Codigo= $forpap', 'FORPAP_Codigo', 9, '$forpap', ''),
(598, 2, 'SELECT mo.MONED_Descripcion as MONEDA FROM cji_moneda mo WHERE mo.MONED_Codigo = $monedcodigo', 'MONED_Codigo', 9, '$monedcodigo', ''),
(599, 2, 'SELECT c.CPC_TipoOperacion, c.CLIP_Codigo, c.PROVP_Codigo , CASE c.CPC_TipoOperacion WHEN ''V'' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,'' '',pe.PERSC_ApellidoPaterno,'' '',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.PROVP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,'' '',pe.PERSC_ApellidoPaterno,'' '',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PROVP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo ) END as NOMBRE, CASE c.CPC_TipoOperacion WHEN ''V'' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo= pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo ) END as DIRECCION, CASE c.CPC_TipoOperacion WHEN ''V'' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END as RUC FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo )END as RUC FROM cji_comprobante c WHERE c.CPP_Codigo=$ccliente', 'CPP_Codigo', 9, '$ccliente', ''),
(615, 1, 'select c.CPP_Codigo, c.CLIP_Codigo as CCLIENTE,\nc.CPC_total as TOTAL, c.CPC_total  as MONTOLETRA , c.CPC_igv as IGV, c.CPC_subtotal as SUBTOTAL, c.CPC_Fecha as FECHAEMI, c.FORPAP_Codigo, c.MONED_Codigo, CONCAT (c.CPC_Serie,'' '',c.CPC_Numero) as COMPROBANTE\n from cji_comprobante c where CPP_Codigo=$CodigoPrincipal', '', 14, '$CodigoPrincipal', ''),
(616, 2, 'SELECT c.CPC_TipoOperacion, c.CLIP_Codigo, c.PROVP_Codigo , CASE c.CPC_TipoOperacion WHEN ''V'' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,'' '',pe.PERSC_ApellidoPaterno,'' '',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.PROVP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,'' '',pe.PERSC_ApellidoPaterno,'' '',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PROVP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo ) END as NOMBRE, CASE c.CPC_TipoOperacion WHEN ''V'' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo= pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo ) END as DIRECCION, CASE c.CPC_TipoOperacion WHEN ''V'' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END as RUC FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo )END as RUC FROM cji_comprobante c WHERE c.CPP_Codigo=$ccliente', 'CPP_Codigo', 14, '$ccliente', ''),
(617, 2, 'SELECT und.UNDMED_Descripcion as UNIDAD , cd.CPDEC_Cantidad as CANTIDAD, cd.CPDEC_Total as TOTALP, cd.CPDEC_Pu as PUNIT, cd.CPDEC_Descripcion as NOMBREP, cd.UNDMED_Codigo as UCODIGO FROM cji_comprobantedetalle cd INNER JOIN cji_unidadmedida und ON und.UNDMED_Codigo=cd.UNDMED_Codigo WHERE cd.CPP_Codigo=$ccomp', 'CPP_Codigo', 14, '$ccomp', 'grupo'),
(618, 2, 'SELECT fp.FORPAC_Descripcion as FORMAPA FROM cji_formapago fp WHERE fp.FORPAP_Codigo= $forpap', 'FORPAP_Codigo', 14, '$forpap', ''),
(619, 2, 'SELECT mo.MONED_Descripcion as MONEDA FROM cji_moneda mo WHERE mo.MONED_Codigo = $monedcodigo', 'MONED_Codigo', 14, '$monedcodigo', ''),
(654, 1, 'select c.CPP_Codigo, c.CLIP_Codigo as CCLIENTE,CPC_Vendedor as CCVendedor,\nc.CPC_total as TOTAL, c.CPC_total  as MONTOLETRA , c.CPC_igv as IGV, c.CPC_subtotal as SUBTOTAL, c.CPC_Fecha as FECHAEMI, c.FORPAP_Codigo, c.MONED_Codigo, CONCAT (c.CPC_Serie,'' '',c.CPC_Numero) as COMPROBANTE\n from cji_comprobante c where CPP_Codigo=$CodigoPrincipal', '', 8, '$CodigoPrincipal', ''),
(655, 2, 'SELECT und.UNDMED_Descripcion as UNIDAD , cd.CPDEC_Cantidad as CANTIDAD, cd.CPDEC_Total as TOTALP, cd.CPDEC_Pu as PUNIT, cd.CPDEC_Descripcion as NOMBREP, cd.UNDMED_Codigo as UCODIGO FROM cji_comprobantedetalle cd INNER JOIN cji_unidadmedida und ON und.UNDMED_Codigo=cd.UNDMED_Codigo WHERE cd.CPP_Codigo=$ccomp', 'CPP_Codigo', 8, '$ccomp', 'grupo'),
(656, 2, 'SELECT fp.FORPAC_Descripcion as FORMAPA FROM cji_formapago fp WHERE fp.FORPAP_Codigo= $forpap', 'FORPAP_Codigo', 8, '$forpap', ''),
(657, 2, 'SELECT mo.MONED_Descripcion as MONEDA FROM cji_moneda mo WHERE mo.MONED_Codigo = $monedcodigo', 'MONED_Codigo', 8, '$monedcodigo', ''),
(658, 2, 'SELECT c.CPC_TipoOperacion, c.CLIP_Codigo, c.PROVP_Codigo , CASE c.CPC_TipoOperacion WHEN ''V'' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,'' '',pe.PERSC_ApellidoPaterno,'' '',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.PROVP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,'' '',pe.PERSC_ApellidoPaterno,'' '',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PROVP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo ) END as NOMBRE, CASE c.CPC_TipoOperacion WHEN ''V'' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo= pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo ) END as DIRECCION, CASE c.CPC_TipoOperacion WHEN ''V'' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END as RUC FROM cji_cliente cl WHERE cl.CLIP_Codigo=c.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = c.PROVP_Codigo )END as RUC FROM cji_comprobante c WHERE c.CPP_Codigo=$ccliente', 'CPP_Codigo', 8, '$ccliente', ''),
(659, 2, 'SELECT p.PERSC_Nombre as VENDEDOR\nFROM cji_usuario u  JOIN cji_persona p on p.PERSP_Codigo=u.PERSP_Codigo\nWHERE  p.PERSP_Codigo=$vendedor', 'CCVendedor', 8, '$vendedor', ''),
(799, 1, 'SELECT GUIAREMC_PuntoPartida as PUNTOPARTI,\ng.GUIAREMP_Codigo,\n CONCAT(g.GUIAREMC_Serie,  '' '',  g.GUIAREMC_Numero\n  ) AS GUIA,\n  g.GUIAREMC_PuntoLlegada AS DESTINO,\n  g.CLIP_Codigo AS CODCLIEG,\n  GUIAREMC_Marca AS MARCAVIHEC,\n  GUIAREMC_Placa AS PLACASS,\n  GUIAREMC_RegistroMTC,\n  GUIAREMC_Certificado,\n  GUIAREMC_Licencia AS LICENCIACO,\n  GUIAREMC_NombreConductor AS CONDUCTOR2,\n  GUIAREMC_Observacion AS OBSERVACIO\nFROM\n  cji_guiarem g\nWHERE\n  g.GUIAREMP_Codigo =$CodigoPrincipal', '', 10, '$CodigoPrincipal', ''),
(800, 2, 'SELECT gd.GUIAREMDETC_Descripcion as DESCRIP, gd.GUIAREMDETC_Cantidad as CANTIDAD, gd.PRODCTOP_Codigo as PRODCOD, und.UNDMED_Descripcion as UNIDAD from cji_guiaremdetalle gd INNER JOIN cji_unidadmedida und ON und.UNDMED_Codigo=gd.UNDMED_Codigo WHERE gd.GUIAREMP_Codigo= $guiaremcod\n', 'GUIAREMP_Codigo', 10, '$guiaremcod', 'grupo'),
(801, 2, 'SELECT g.CPC_TipoOperacion, g.CLIP_Codigo, g.PROVP_Codigo , CASE g.GUIAREMC_TipoOperacion WHEN ''V'' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,'' '',pe.PERSC_ApellidoPaterno,'' '',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=g.CLIP_Codigo ) ELSE ( SELECT CASE pro.PROVP_Codigo WHEN 0 THEN (SELECT CONCAT (pe.PERSC_Nombre,'' '',pe.PERSC_ApellidoPaterno,'' '',pe.PERSC_ApellidoMaterno) FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PROVP_Codigo ) ELSE (SELECT emp.EMPRC_RazonSocial FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = g.PROVP_Codigo ) END as NOMBRE, CASE g.CPC_TipoOperacion WHEN ''V'' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END FROM cji_cliente cl WHERE cl.CLIP_Codigo=g.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Direccion FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Direccion FROM cji_empresa emp WHERE emp.EMPRP_Codigo= pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = g.PROVP_Codigo ) END as DIRECCION, CASE g.CPC_TipoOperacion WHEN ''V'' THEN ( SELECT CASE cl.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = cl.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=cl.EMPRP_Codigo) END as RUC FROM cji_cliente cl WHERE cl.CLIP_Codigo=g.CLIP_Codigo ) ELSE ( SELECT CASE pro.EMPRP_Codigo WHEN 0 THEN (SELECT pe.PERSC_Ruc FROM cji_persona pe WHERE pe.PERSP_Codigo = pro.PERSP_Codigo ) ELSE (SELECT emp.EMPRC_Ruc FROM cji_empresa emp WHERE emp.EMPRP_Codigo=pro.EMPRP_Codigo) END FROM cji_proveedor pro WHERE pro.PROVP_Codigo = g.PROVP_Codigo )END as RUC FROM cji_guiarem g WHERE g.GUIAREMP_Codigo = $ccliente', 'GUIAREMP_Codigo', 10, '$ccliente', ''),
(802, 2, 'SELECT PROD_Codigo as PRODCODSERIE, GROUP_CONCAT( SERIC_Numero) as NUEVOSS FROM cji_serie s JOIN cji_seriedocumento cd on cd.SERIP_Codigo=s.SERIP_Codigo WHERE cd.DOCUP_Codigo=10 AND SERDOC_NumeroRef=$variableNuevo\n', 'GUIAREMP_Codigo', 10, '$variableNuevo', 'grupo2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_emprarea`
--

CREATE TABLE `cji_emprarea` (
  `EAREAP_Codigo` int(11) NOT NULL,
  `AREAP_Codigo` int(11) NOT NULL,
  `EMPRP_Codigo` int(11) NOT NULL,
  `DIREP_Codigo` int(11) NOT NULL,
  `EAREAC_Descripcion` varchar(45) DEFAULT NULL,
  `EAREAC_FechaRegistro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `EAREAC_FechaModificacion` datetime DEFAULT NULL,
  `EAREAC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cji_emprarea`
--

INSERT INTO `cji_emprarea` (`EAREAP_Codigo`, `AREAP_Codigo`, `EMPRP_Codigo`, `DIREP_Codigo`, `EAREAC_Descripcion`, `EAREAC_FechaRegistro`, `EAREAC_FechaModificacion`, `EAREAC_FlagEstado`) VALUES
(1, 1, 1155, 6, '::OPBSERVACION::', '2016-11-16 01:28:17', NULL, '0'),
(2, 5, 174, 9, '::OBSERVACION::', '2016-12-22 19:48:54', NULL, '1'),
(3, 1, 178, 15, '::OPBSERVACION::', '2016-12-24 03:04:22', NULL, '1'),
(4, 5, 179, 16, '::OBSERVACION::', '2016-12-24 03:07:06', NULL, '1'),
(5, 3, 179, 17, '::OBSERVACION::', '2016-12-24 03:09:51', NULL, '1'),
(6, 5, 181, 19, '::OBSERVACION::', '2016-12-29 03:26:49', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_emprcontacto`
--

CREATE TABLE `cji_emprcontacto` (
  `ECONP_Contacto` int(11) NOT NULL,
  `EMPRP_Codigo` int(11) NOT NULL,
  `PERSP_Contacto` int(11) NOT NULL DEFAULT '0',
  `ECONC_Descripcion` varchar(250) DEFAULT NULL,
  `ECONC_Telefono` varchar(50) DEFAULT NULL,
  `ECONC_Movil` varchar(50) DEFAULT NULL,
  `ECONC_Fax` varchar(50) DEFAULT NULL,
  `ECONC_Email` varchar(45) DEFAULT NULL,
  `ECONC_Persona` int(11) DEFAULT NULL,
  `ECONC_TipoContacto` char(1) NOT NULL DEFAULT '1' COMMENT '0:: Persona , 1:: Empresa',
  `ECONC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ECONC_FechaModificacion` datetime DEFAULT NULL,
  `ECONC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_empresa`
--

CREATE TABLE `cji_empresa` (
  `EMPRP_Codigo` int(11) NOT NULL,
  `CIIUP_Codigo` int(11) NOT NULL DEFAULT '0',
  `TIPCOD_Codigo` int(11) NOT NULL DEFAULT '1',
  `SECCOMP_Codigo` int(11) DEFAULT NULL,
  `EMPRC_Ruc` varchar(11) DEFAULT NULL,
  `EMPRC_RazonSocial` varchar(150) DEFAULT NULL,
  `EMPRC_Telefono` varchar(50) DEFAULT NULL,
  `EMPRC_Movil` varchar(50) DEFAULT NULL,
  `EMPRC_Fax` varchar(50) DEFAULT NULL,
  `EMPRC_Web` varchar(250) DEFAULT NULL,
  `EMPRC_Email` varchar(250) DEFAULT NULL,
  `EMPRC_CtaCteSoles` varchar(50) DEFAULT NULL,
  `EMPRC_CtaCteDolares` varchar(50) DEFAULT NULL,
  `EMPRC_FechaRegistro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `EMPRC_FechaModificacion` datetime DEFAULT NULL,
  `EMPRC_FlagEstado` char(1) DEFAULT '1',
  `EMPRC_Direccion` varchar(350) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cji_empresa`
--

INSERT INTO `cji_empresa` (`EMPRP_Codigo`, `CIIUP_Codigo`, `TIPCOD_Codigo`, `SECCOMP_Codigo`, `EMPRC_Ruc`, `EMPRC_RazonSocial`, `EMPRC_Telefono`, `EMPRC_Movil`, `EMPRC_Fax`, `EMPRC_Web`, `EMPRC_Email`, `EMPRC_CtaCteSoles`, `EMPRC_CtaCteDolares`, `EMPRC_FechaRegistro`, `EMPRC_FechaModificacion`, `EMPRC_FlagEstado`, `EMPRC_Direccion`) VALUES
(1, 0, 1, NULL, '0000000000', 'EMPRESA PRINCIPALES', '', '', '', 'www.web.com', 'ventas@correo.com', '', '', '0000-00-00 00:00:00', NULL, '1', ''),
(207, 0, 1, 5, '78484848454', 'NUEVO PROVEEDOR', '', '', '', '', '', '', '', '2017-01-23 21:12:49', NULL, '1', ''),
(208, 0, 1, 5, '45745754745', 'NUEVO PROVEEDOR', '', '', '', '', '', '', '', '2017-01-23 21:15:00', NULL, '1', 'nuevo lima lima');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_empresatipoproveedor`
--

CREATE TABLE `cji_empresatipoproveedor` (
  `EMPTIPOP_Codigo` int(11) NOT NULL,
  `FAMI_Codigo` int(11) NOT NULL,
  `PROVP_Codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_emprestablecimiento`
--

CREATE TABLE `cji_emprestablecimiento` (
  `EESTABP_Codigo` int(11) NOT NULL,
  `TESTP_Codigo` int(11) NOT NULL,
  `EMPRP_Codigo` int(11) NOT NULL,
  `UBIGP_Codigo` char(6) NOT NULL,
  `EESTABC_Descripcion` varchar(150) DEFAULT NULL,
  `EESTAC_Direccion` varchar(200) DEFAULT NULL,
  `EESTABC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `EESTABC_FechaModificacion` datetime DEFAULT NULL,
  `EESTABC_FlagTipo` char(1) DEFAULT '0' COMMENT '1::Principal, 0::Secundarios',
  `EESTABC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cji_emprestablecimiento`
--

INSERT INTO `cji_emprestablecimiento` (`EESTABP_Codigo`, `TESTP_Codigo`, `EMPRP_Codigo`, `UBIGP_Codigo`, `EESTABC_Descripcion`, `EESTAC_Direccion`, `EESTABC_FechaRegistro`, `EESTABC_FechaModificacion`, `EESTABC_FlagTipo`, `EESTABC_FlagEstado`) VALUES
(1, 1, 1, '150101', 'PRINCIPAL', 'DIRECCION PRINCIPAL', '2016-10-15 04:08:51', NULL, '1', '1'),
(2, 1, 1, '150101', 'PRINCIPAL DATA', 'DIRECCION PRINCIPAL', '2016-10-15 04:08:51', NULL, '1', '1'),
(58, 1, 207, '150102', 'PRINCIPAL', 'LIMA LIMA', '2017-01-23 21:12:49', NULL, '1', '1'),
(59, 1, 208, '150103', 'PRINCIPAL', 'NUEVO LIMA LIMA', '2017-01-23 21:15:00', NULL, '1', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_entregacliente`
--

CREATE TABLE `cji_entregacliente` (
  `ENTRECLI_Codigo` int(11) NOT NULL,
  `GARAN_Codigo` int(11) DEFAULT NULL,
  `EMPRP_Codigo` int(11) DEFAULT NULL,
  `COMPP_Codigo` int(11) DEFAULT NULL,
  `CLIP_Codigo` int(11) NOT NULL,
  `ENTRECLI_Descripcion` varchar(250) DEFAULT NULL,
  `ENTRECLI_Observacion` varchar(350) DEFAULT NULL,
  `ENTRECLI_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ENTRECLI_TipoSolucion` varchar(150) DEFAULT NULL,
  `ENTRECLI_CodigoProducto` varchar(150) DEFAULT NULL,
  `ENTRECLI_NombreProducto` varchar(150) DEFAULT NULL,
  `ENTRECLI_FechaModificacion` datetime DEFAULT NULL,
  `ENTRECLI_FlagEstado` varchar(1) DEFAULT '1',
  `ENTRECLI_NumeroCredito` int(30) NOT NULL,
  `ENTRECLI_SerieCredito` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_envioproveedor`
--

CREATE TABLE `cji_envioproveedor` (
  `ENVIPRO_Codigo` int(11) NOT NULL,
  `GARAN_Codigo` int(11) DEFAULT NULL,
  `EMPRP_Codigo` int(11) DEFAULT NULL,
  `COMPP_Codigo` int(11) DEFAULT NULL,
  `PROVP_Codigo` int(11) DEFAULT NULL,
  `ENVIPRO_Descripcion` varchar(250) DEFAULT NULL,
  `ENVIPRO_Observacion` varchar(350) DEFAULT NULL,
  `ENVIPRO_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ENVIPRO_FechaModificacion` datetime DEFAULT NULL,
  `ENVIPRO_FlagEstado` varchar(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_estadocivil`
--

CREATE TABLE `cji_estadocivil` (
  `ESTCP_Codigo` int(11) NOT NULL,
  `ESTCC_Descripcion` varchar(150) DEFAULT NULL,
  `ESTCC_FechaRegistro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ESTCC_FechaModificacion` datetime DEFAULT NULL,
  `ESTCC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cji_estadocivil`
--

INSERT INTO `cji_estadocivil` (`ESTCP_Codigo`, `ESTCC_Descripcion`, `ESTCC_FechaRegistro`, `ESTCC_FechaModificacion`, `ESTCC_FlagEstado`) VALUES
(1, 'SOLTERO', '2010-12-15 02:05:18', NULL, '1'),
(2, 'CASADO', '2010-12-15 02:05:27', NULL, '1'),
(3, 'VIUDO', '2010-12-15 02:05:33', NULL, '1'),
(4, 'DIVORCIADO', '2010-12-15 02:05:39', NULL, '1'),
(5, 'CONVIVIENTE', '2010-12-15 02:05:45', NULL, '1'),
(7, 'NO REGISTRADO', '2010-12-24 19:05:42', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_fabricante`
--

CREATE TABLE `cji_fabricante` (
  `FABRIP_Codigo` int(11) NOT NULL,
  `FABRIC_Descripcion` varchar(150) DEFAULT NULL,
  `FABRIC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `FABRIC_FechaModificacion` datetime DEFAULT NULL,
  `FABRIC_FlagEstado` char(1) DEFAULT '1',
  `FABRIC_CodigoUsuario` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_familia`
--

CREATE TABLE `cji_familia` (
  `FAMI_Codigo` int(11) NOT NULL,
  `FAMI_FlagBienServicio` char(1) NOT NULL DEFAULT 'B' COMMENT 'B: Bien, S: Servicio',
  `FAMI_Descripcion` varchar(350) DEFAULT NULL,
  `FAMI_Codigo2` int(11) DEFAULT NULL,
  `FAMI_CodigoInterno` char(3) DEFAULT NULL,
  `FAMI_CodigoUsuario` varchar(20) DEFAULT NULL,
  `FAMI_Numeracion` int(11) DEFAULT '0',
  `FAMI_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `FAMI_FechaModificacion` datetime DEFAULT NULL,
  `FAMI_FlagEstado` char(1) DEFAULT '1',
  `FAMI_IMAGEN` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_familia`
--

INSERT INTO `cji_familia` (`FAMI_Codigo`, `FAMI_FlagBienServicio`, `FAMI_Descripcion`, `FAMI_Codigo2`, `FAMI_CodigoInterno`, `FAMI_CodigoUsuario`, `FAMI_Numeracion`, `FAMI_FechaRegistro`, `FAMI_FechaModificacion`, `FAMI_FlagEstado`, `FAMI_IMAGEN`) VALUES
(28, 'B', 'NUEVO MARCA', 0, '001', '545', 2, '2017-01-23 20:05:44', NULL, '1', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_familiacompania`
--

CREATE TABLE `cji_familiacompania` (
  `FAMI_Codigo` int(11) NOT NULL,
  `COMPP_Codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_familiacompania`
--

INSERT INTO `cji_familiacompania` (`FAMI_Codigo`, `COMPP_Codigo`) VALUES
(28, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_flujocaja`
--

CREATE TABLE `cji_flujocaja` (
  `FLUCAJ_Codigo` int(11) NOT NULL,
  `CUE_Codigo` int(1) NOT NULL,
  `FLUCAJ_FechaOperacion` date NOT NULL,
  `MONED_Codigo` int(11) NOT NULL,
  `FLUCAJ_Importe` double(10,2) NOT NULL,
  `FLUCAJ_TDC` double(10,2) NOT NULL,
  `FORPAP_Codigo` int(11) DEFAULT NULL,
  `FLUCAJ_NumeroDoc` varchar(50) DEFAULT NULL,
  `FLUCAJ_Observacion` varchar(250) DEFAULT NULL,
  `FLUCAJ_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `FLUCAJ_FechaModificacion` datetime DEFAULT NULL,
  `FLUCAJ_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_formapago`
--

CREATE TABLE `cji_formapago` (
  `FORPAP_Codigo` int(11) NOT NULL,
  `FORPAC_Descripcion` varchar(250) DEFAULT NULL,
  `FORPAC_Orden` int(11) NOT NULL DEFAULT '0',
  `FORPAC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `FORPAC_FechaModificacion` datetime DEFAULT NULL,
  `FORPAC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_formapago`
--

INSERT INTO `cji_formapago` (`FORPAP_Codigo`, `FORPAC_Descripcion`, `FORPAC_Orden`, `FORPAC_FechaRegistro`, `FORPAC_FechaModificacion`, `FORPAC_FlagEstado`) VALUES
(1, 'CONTADO', 0, '2013-03-22 12:53:10', NULL, '1'),
(2, 'CREDITO', 0, '2013-03-22 12:53:10', NULL, '1'),
(3, 'CREDITO A 15 DIAS', 0, '2013-07-19 08:22:14', NULL, '1'),
(5, 'CREDITO A 30 DIAS', 0, '2013-07-19 08:22:47', NULL, '1'),
(6, 'CREDITO A 45 DIAS', 0, '2013-08-03 02:00:59', NULL, '1'),
(7, 'CREDITO A 60 DIAS', 0, '2014-05-21 07:45:38', NULL, '1'),
(8, 'CREDITO A 90 DIAS', 0, '2014-05-21 07:46:08', NULL, '1'),
(9, 'CRÉDITO A 70 DIAS', 0, '2016-01-17 08:23:16', NULL, '1'),
(10, 'CREDITO A 7 DIAS', 0, '2016-04-28 09:10:54', NULL, '1'),
(11, 'CONTADO EFECTIVO', 0, '2016-04-28 09:11:28', NULL, '1'),
(12, 'CONTADO BANCO', 0, '2016-04-28 09:11:42', NULL, '1'),
(13, 'LETRA A 30 DIAS', 0, '2016-04-28 09:21:51', NULL, '1'),
(15, 'LETRA A 60 DIAS', 0, '2016-04-28 09:24:01', NULL, '1'),
(16, 'LETRA A 45 DIAS', 0, '2016-04-28 09:27:09', NULL, '1'),
(17, 'LETRA A 50 DIAS', 0, '2016-04-28 09:27:53', NULL, '1'),
(18, 'LETRA A 40 DIAS', 0, '2016-04-28 09:28:33', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_garantia`
--

CREATE TABLE `cji_garantia` (
  `GARAN_Codigo` int(11) NOT NULL,
  `CLIP_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `CPP_Codigo` int(11) DEFAULT NULL,
  `EMPRP_Codigo` int(11) DEFAULT NULL,
  `COMPP_Codigo` int(11) DEFAULT NULL,
  `GARAN_Descripcion` varchar(150) DEFAULT NULL,
  `GARAN_Nombrecontacto` varchar(150) DEFAULT NULL,
  `GARAN_Nextel` varchar(50) DEFAULT NULL,
  `GARAN_Telefono` varchar(50) DEFAULT NULL,
  `GARAN_Celular` varchar(50) DEFAULT NULL,
  `GARAN_Email` varchar(250) DEFAULT NULL,
  `GARAN_DescripcionAccesorios` varchar(500) DEFAULT NULL,
  `GARAN_DescripcionFalla` varchar(500) DEFAULT NULL,
  `GARAN_Comentario` varchar(500) DEFAULT NULL,
  `GARAN_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `GARAN_FechaModificacion` datetime DEFAULT NULL,
  `GARAN_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `GARAN_Estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_guiain`
--

CREATE TABLE `cji_guiain` (
  `GUIAINP_Codigo` int(11) NOT NULL,
  `TIPOMOVP_Codigo` int(11) NOT NULL,
  `ALMAP_Codigo` int(11) NOT NULL,
  `USUA_Codigo` int(11) NOT NULL,
  `PROVP_Codigo` int(11) DEFAULT NULL,
  `OCOMP_Codigo` int(11) DEFAULT NULL,
  `DOCUP_Codigo` int(11) NOT NULL,
  `GUIAINC_NumeroRef` varchar(50) NOT NULL,
  `GUIAINC_Numero` varchar(10) DEFAULT NULL,
  `GUIAINC_Fecha` date DEFAULT NULL,
  `GUIAINC_FechaEmision` datetime NOT NULL,
  `GUIAINC_Observacion` varchar(45) DEFAULT NULL,
  `GUIAINC_MarcaPlaca` varchar(100) NOT NULL,
  `GUIAINC_Certificado` varchar(100) NOT NULL,
  `GUIAINC_Licencia` varchar(100) NOT NULL,
  `GUIAINC_RucTransportista` varchar(11) NOT NULL,
  `GUIAINC_NombreTransportista` varchar(150) NOT NULL,
  `GUIAINC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `GUIAINC_FechaModificacion` datetime DEFAULT NULL,
  `GUIAINC_Automatico` int(11) DEFAULT '0',
  `GUIAINC_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_guiain`
--

INSERT INTO `cji_guiain` (`GUIAINP_Codigo`, `TIPOMOVP_Codigo`, `ALMAP_Codigo`, `USUA_Codigo`, `PROVP_Codigo`, `OCOMP_Codigo`, `DOCUP_Codigo`, `GUIAINC_NumeroRef`, `GUIAINC_Numero`, `GUIAINC_Fecha`, `GUIAINC_FechaEmision`, `GUIAINC_Observacion`, `GUIAINC_MarcaPlaca`, `GUIAINC_Certificado`, `GUIAINC_Licencia`, `GUIAINC_RucTransportista`, `GUIAINC_NombreTransportista`, `GUIAINC_FechaRegistro`, `GUIAINC_FechaModificacion`, `GUIAINC_Automatico`, `GUIAINC_FlagEstado`) VALUES
(143, 2, 5, 1, NULL, NULL, 4, '32', '354', '2017-01-23', '0000-00-00 00:00:00', '', '', '', '', '', '', '2017-01-23 21:09:58', NULL, 1, '1'),
(144, 2, 5, 1, NULL, NULL, 4, '32', '355', '2017-01-23', '0000-00-00 00:00:00', '', '', '', '', '', '', '2017-01-23 21:10:28', NULL, 1, '1'),
(145, 2, 5, 1, 12, NULL, 8, '', '356', '2017-01-23', '0000-00-00 00:00:00', '', '', '', '', '', '', '2017-01-23 05:00:00', NULL, 1, '1'),
(146, 2, 5, 1, 12, NULL, 8, '', '357', '2017-01-23', '0000-00-00 00:00:00', '', '', '', '', '', '', '2017-01-23 05:00:00', NULL, 1, '1'),
(147, 2, 5, 1, 12, NULL, 8, '', '358', '2017-01-23', '0000-00-00 00:00:00', '', '', '', '', '', '', '2017-01-23 05:00:00', '2017-01-23 00:00:00', 1, '1'),
(148, 2, 5, 1, 12, NULL, 8, '', '359', '2017-01-24', '0000-00-00 00:00:00', '', '', '', '', '', '', '2017-01-24 05:00:00', NULL, 1, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_guiaindetalle`
--

CREATE TABLE `cji_guiaindetalle` (
  `GUIAINDETP_Codigo` int(11) NOT NULL,
  `GUIAINP_Codigo` int(11) NOT NULL,
  `PRODCTOP_Codigo` int(11) NOT NULL,
  `UNDMED_Codigo` int(11) DEFAULT NULL,
  `GUIIAINDETC_GenInd` char(1) DEFAULT 'I' COMMENT 'G:Generico; I indiviual',
  `GUIAINDETC_Cantidad` double DEFAULT '0',
  `GUIAINDETC_Costo` double DEFAULT '0',
  `GUIAINDETC_Descripcion` varchar(300) DEFAULT NULL,
  `GUIAINDETC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `GUIAINDET_FechaModificacion` datetime DEFAULT NULL,
  `GUIAINDETC_FlagEstado` char(1) DEFAULT NULL,
  `ALMAP_Codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_guiaindetalle`
--

INSERT INTO `cji_guiaindetalle` (`GUIAINDETP_Codigo`, `GUIAINP_Codigo`, `PRODCTOP_Codigo`, `UNDMED_Codigo`, `GUIIAINDETC_GenInd`, `GUIAINDETC_Cantidad`, `GUIAINDETC_Costo`, `GUIAINDETC_Descripcion`, `GUIAINDETC_FechaRegistro`, `GUIAINDET_FechaModificacion`, `GUIAINDETC_FlagEstado`, `ALMAP_Codigo`) VALUES
(174, 143, 3, 8, 'I', 0, 20, 'G', '2017-01-23 21:09:58', NULL, NULL, 5),
(175, 144, 4, 8, 'I', 0, 10, 'G', '2017-01-23 21:10:29', NULL, NULL, 5),
(176, 145, 3, 4, 'I', 3, 3, NULL, '2017-01-23 21:13:42', NULL, '1', 5),
(177, 146, 3, 4, 'I', 6, 6, NULL, '2017-01-23 21:18:27', NULL, '1', 5),
(178, 147, 4, 4, 'I', 5, 9, NULL, '2017-01-23 21:20:06', '2017-01-23 00:00:00', '0', 5),
(179, 147, 3, 4, 'I', 3, 3, NULL, '2017-01-23 21:20:07', '2017-01-23 00:00:00', '0', 5),
(180, 147, 4, 4, 'I', 5, 9, NULL, '2017-01-23 21:20:21', NULL, '1', 5),
(181, 147, 3, 4, 'I', 3, 3, NULL, '2017-01-23 21:20:22', NULL, '1', 5),
(182, 148, 3, 4, 'I', 4, 199, NULL, '2017-01-24 15:34:55', NULL, '1', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_guiarem`
--

CREATE TABLE `cji_guiarem` (
  `GUIAREMP_Codigo` int(11) NOT NULL,
  `GUIAREMC_TipoOperacion` char(1) NOT NULL DEFAULT 'V',
  `TIPOMOVP_Codigo` int(11) NOT NULL,
  `ALMAP_Codigo` int(11) DEFAULT NULL,
  `USUA_Codigo` int(11) NOT NULL,
  `MONED_Codigo` int(11) DEFAULT NULL,
  `DOCUP_Codigo` int(11) DEFAULT NULL COMMENT 'Documento Referencia',
  `CLIP_Codigo` int(11) DEFAULT NULL,
  `PROVP_Codigo` int(11) DEFAULT NULL,
  `GUIAREMC_PersReceNombre` varchar(150) DEFAULT NULL,
  `GUIAREMC_PersReceDNI` char(8) DEFAULT NULL,
  `EMPRP_Codigo` int(11) DEFAULT NULL COMMENT 'Empresa de Transporte',
  `GUIASAP_Codigo` int(11) DEFAULT NULL,
  `GUIAINP_Codigo` int(11) DEFAULT NULL,
  `PRESUP_Codigo` int(11) DEFAULT NULL,
  `OCOMP_Codigo` int(11) DEFAULT NULL,
  `GUIAREMC_OtroMotivo` varchar(250) DEFAULT NULL,
  `GUIAREMC_Fecha` date NOT NULL,
  `GUIAREMC_NumeroRef` varchar(50) DEFAULT NULL,
  `GUIAREMC_OCompra` varchar(50) DEFAULT NULL,
  `GUIAREMC_Serie` varchar(10) DEFAULT NULL,
  `GUIAREMC_Numero` varchar(11) DEFAULT NULL,
  `GUIAREMC_CodigoUsuario` varchar(50) DEFAULT NULL,
  `GUIAREMC_FechaTraslado` date DEFAULT NULL,
  `GUIAREMC_PuntoPartida` varchar(250) DEFAULT NULL,
  `GUIAREMC_PuntoLlegada` varchar(250) DEFAULT NULL,
  `GUIAREMC_Observacion` text,
  `GUIAREMC_Marca` varchar(100) DEFAULT NULL,
  `GUIAREMC_Placa` varchar(20) DEFAULT NULL,
  `GUIAREMC_RegistroMTC` varchar(20) DEFAULT NULL,
  `GUIAREMC_Certificado` varchar(100) DEFAULT NULL,
  `GUIAREMC_Licencia` varchar(100) DEFAULT NULL,
  `GUIAREMC_NombreConductor` varchar(150) DEFAULT NULL,
  `GUIAREMC_subtotal` double(10,2) NOT NULL DEFAULT '0.00',
  `GUIAREMC_descuento` double(10,2) NOT NULL DEFAULT '0.00',
  `GUIAREMC_igv` double(10,2) NOT NULL DEFAULT '0.00',
  `GUIAREMC_total` double(10,2) NOT NULL DEFAULT '0.00',
  `GUIAREMC_igv100` int(11) NOT NULL DEFAULT '0',
  `GUIAREMC_descuento100` int(11) NOT NULL DEFAULT '0',
  `COMPP_Codigo` int(11) NOT NULL,
  `GUIAREMC_FlagMueveStock` char(1) NOT NULL DEFAULT '0',
  `USUA_Anula` int(11) DEFAULT NULL,
  `GUIAREMC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `GUIAREMC_FechaModificacion` datetime DEFAULT NULL,
  `GUIAREMC_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `CPC_TipoOperacion` char(1) NOT NULL DEFAULT 'V',
  `GUIAREMC_TipoGuia` int(1) NOT NULL,
  `GUIAREMC_NumeroAutomatico` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_guiarem`
--

INSERT INTO `cji_guiarem` (`GUIAREMP_Codigo`, `GUIAREMC_TipoOperacion`, `TIPOMOVP_Codigo`, `ALMAP_Codigo`, `USUA_Codigo`, `MONED_Codigo`, `DOCUP_Codigo`, `CLIP_Codigo`, `PROVP_Codigo`, `GUIAREMC_PersReceNombre`, `GUIAREMC_PersReceDNI`, `EMPRP_Codigo`, `GUIASAP_Codigo`, `GUIAINP_Codigo`, `PRESUP_Codigo`, `OCOMP_Codigo`, `GUIAREMC_OtroMotivo`, `GUIAREMC_Fecha`, `GUIAREMC_NumeroRef`, `GUIAREMC_OCompra`, `GUIAREMC_Serie`, `GUIAREMC_Numero`, `GUIAREMC_CodigoUsuario`, `GUIAREMC_FechaTraslado`, `GUIAREMC_PuntoPartida`, `GUIAREMC_PuntoLlegada`, `GUIAREMC_Observacion`, `GUIAREMC_Marca`, `GUIAREMC_Placa`, `GUIAREMC_RegistroMTC`, `GUIAREMC_Certificado`, `GUIAREMC_Licencia`, `GUIAREMC_NombreConductor`, `GUIAREMC_subtotal`, `GUIAREMC_descuento`, `GUIAREMC_igv`, `GUIAREMC_total`, `GUIAREMC_igv100`, `GUIAREMC_descuento100`, `COMPP_Codigo`, `GUIAREMC_FlagMueveStock`, `USUA_Anula`, `GUIAREMC_FechaRegistro`, `GUIAREMC_FechaModificacion`, `GUIAREMC_FlagEstado`, `CPC_TipoOperacion`, `GUIAREMC_TipoGuia`, `GUIAREMC_NumeroAutomatico`) VALUES
(217, 'C', 1, 5, 1, 1, NULL, NULL, 12, 'GENERRADO GUIA INTERNO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-01-23', NULL, NULL, '1', '8568015', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 7.63, 0.00, 1.37, 9.00, 18, 0, 1, '0', NULL, '2017-01-23 21:13:42', NULL, '2', 'C', 1, NULL),
(219, 'C', 1, 5, 1, 1, NULL, NULL, 12, 'GENERRADO GUIA INTERNO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-01-23', NULL, NULL, '1', '7567015', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 30.51, 0.00, 5.49, 36.00, 18, 0, 1, '0', NULL, '2017-01-23 21:18:27', NULL, '2', 'C', 1, NULL),
(221, 'C', 1, 5, 1, 1, NULL, NULL, 12, 'GENERRADO GUIA INTERNO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-01-23', NULL, NULL, '1', '696015', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 45.76, 0.00, 8.24, 54.00, 18, 0, 1, '0', NULL, '2017-01-23 21:20:22', NULL, '2', 'C', 1, NULL),
(225, 'V', 2, 5, 1, 1, NULL, 4, NULL, 'GENERRADO GUIA INTERNO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-01-23', NULL, NULL, '2', '639025', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 5.08, 0.00, 0.92, 6.00, 18, 0, 1, '0', NULL, '2017-01-23 22:37:02', NULL, '2', 'V', 1, NULL),
(227, 'V', 2, 5, 1, 1, NULL, 4, NULL, 'GENERRADO GUIA INTERNO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-01-23', NULL, NULL, '2', '638025', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 10.17, 0.00, 1.83, 12.00, 18, 0, 1, '0', NULL, '2017-01-23 22:47:45', NULL, '2', 'V', 1, NULL),
(228, 'V', 2, 5, 1, 1, NULL, 4, NULL, 'GENERRADO GUIA INTERNO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-01-23', NULL, NULL, '2', '637025', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 53.39, 0.00, 9.61, 63.00, 18, 0, 1, '0', NULL, '2017-01-23 22:47:55', NULL, '2', 'V', 1, NULL),
(229, 'V', 2, 5, 1, 1, NULL, 4, NULL, 'GENERRADO GUIA INTERNO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-01-23', NULL, NULL, '2', '636025', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 7.63, 0.00, 1.37, 9.00, 18, 0, 1, '0', NULL, '2017-01-23 22:49:10', NULL, '2', 'V', 1, NULL),
(230, 'V', 2, 5, 1, 1, NULL, 4, NULL, 'GENERRADO GUIA INTERNO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-01-24', NULL, NULL, '2', '640025', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 10.17, 0.00, 1.83, 12.00, 18, 0, 1, '0', NULL, '2017-01-24 15:34:17', NULL, '2', 'V', 1, NULL),
(231, 'C', 1, 5, 1, 1, NULL, NULL, 12, 'GENERRADO GUIA INTERNO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-01-24', NULL, NULL, '1', '687015', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 674.58, 0.00, 121.42, 796.00, 18, 0, 1, '0', NULL, '2017-01-24 15:34:56', NULL, '2', 'C', 1, NULL),
(232, 'V', 2, 5, 1, 1, NULL, 4, NULL, 'GENERRADO GUIA INTERNO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-01-24', NULL, NULL, '2', '641025', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, 562.71, 0.00, 101.29, 664.00, 18, 0, 1, '0', NULL, '2017-01-24 15:36:23', NULL, '2', 'V', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_guiaremdetalle`
--

CREATE TABLE `cji_guiaremdetalle` (
  `GUIAREMDETP_Codigo` int(11) NOT NULL,
  `PRODCTOP_Codigo` int(11) NOT NULL,
  `UNDMED_Codigo` int(11) DEFAULT NULL,
  `GUIAREMP_Codigo` int(11) NOT NULL,
  `GUIAREMDETC_GenInd` char(1) NOT NULL DEFAULT 'I' COMMENT 'G:Generico; I indiviual',
  `GUIAREMDETC_Cantidad` varchar(45) NOT NULL DEFAULT '0',
  `GUIAREMDETC_Pu` double NOT NULL DEFAULT '0',
  `GUIAREMDETC_Subtotal` double NOT NULL DEFAULT '0',
  `GUIAREMDETC_Descuento` double NOT NULL DEFAULT '0',
  `GUIAREMDETC_Igv` double NOT NULL DEFAULT '0',
  `GUIAREMDETC_Total` double NOT NULL DEFAULT '0',
  `GUIAREMDETC_Pu_ConIgv` double NOT NULL DEFAULT '0',
  `GUIAREMDETC_Igv100` int(11) NOT NULL DEFAULT '0',
  `GUIAREMDETC_Descuento100` int(11) NOT NULL DEFAULT '0',
  `GUIAREMDETC_Costo` double DEFAULT NULL,
  `GUIAREMDETC_Venta` double DEFAULT NULL,
  `GUIAREMDETC_Peso` double DEFAULT NULL,
  `GUIAREMDETC_Descripcion` varchar(250) DEFAULT NULL,
  `GUIAREMDETC_DireccionEntrega` varchar(250) DEFAULT NULL,
  `GUIAREMDETC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `GUIAREMDET_FechaModificacion` datetime DEFAULT NULL,
  `GUIAREMDETC_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `ALMAP_Codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_guiaremdetalle`
--

INSERT INTO `cji_guiaremdetalle` (`GUIAREMDETP_Codigo`, `PRODCTOP_Codigo`, `UNDMED_Codigo`, `GUIAREMP_Codigo`, `GUIAREMDETC_GenInd`, `GUIAREMDETC_Cantidad`, `GUIAREMDETC_Pu`, `GUIAREMDETC_Subtotal`, `GUIAREMDETC_Descuento`, `GUIAREMDETC_Igv`, `GUIAREMDETC_Total`, `GUIAREMDETC_Pu_ConIgv`, `GUIAREMDETC_Igv100`, `GUIAREMDETC_Descuento100`, `GUIAREMDETC_Costo`, `GUIAREMDETC_Venta`, `GUIAREMDETC_Peso`, `GUIAREMDETC_Descripcion`, `GUIAREMDETC_DireccionEntrega`, `GUIAREMDETC_FechaRegistro`, `GUIAREMDET_FechaModificacion`, `GUIAREMDETC_FlagEstado`, `ALMAP_Codigo`) VALUES
(307, 3, 4, 217, 'I', '3', 2.5424, 7.6272, 0, 1.3728, 9, 3, 18, 0, 3, NULL, NULL, 'CELULAR NUEVO', NULL, '2017-01-23 21:13:42', '0000-00-00 00:00:00', '1', 5),
(310, 3, 4, 219, 'I', '6', 5.0847, 30.5082, 0, 5.4918, 36, 6, 18, 0, 6, NULL, NULL, 'CELULAR NUEVO', NULL, '2017-01-23 21:18:27', '0000-00-00 00:00:00', '1', 5),
(313, 4, 4, 221, 'I', '5', 7.6271, 38.1355, 0, 6.8645, 45, 9, 18, 0, 9, NULL, NULL, 'CELULAR NUEVO12_DOS', NULL, '2017-01-23 21:20:22', '0000-00-00 00:00:00', '1', 5),
(314, 3, 4, 221, 'I', '3', 2.5424, 7.6272, 0, 1.3728, 9, 3, 18, 0, 3, NULL, NULL, 'CELULAR NUEVO', NULL, '2017-01-23 21:20:22', '0000-00-00 00:00:00', '1', 5),
(318, 4, 4, 225, 'I', '2', 2.5424, 5.0848, 0, 0.9152, 6, 3, 18, 0, 0, NULL, NULL, 'CELULAR NUEVO12_DOS', NULL, '2017-01-23 22:37:02', '0000-00-00 00:00:00', '1', 5),
(320, 3, 4, 227, 'I', '3', 3.3898, 10.1694, 0, 1.8306, 12, 4, 18, 0, 0, NULL, NULL, 'CELULAR NUEVO', NULL, '2017-01-23 22:47:46', '0000-00-00 00:00:00', '1', 5),
(321, 3, 4, 228, 'I', '7', 7.6271, 53.3897, 0, 9.6103, 63, 9, 18, 0, 0, NULL, NULL, 'CELULAR NUEVO', NULL, '2017-01-23 22:47:55', '0000-00-00 00:00:00', '1', 5),
(322, 3, 4, 229, 'I', '1', 3.3898, 3.3898, 0, 0.6102, 4, 4, 18, 0, 0, NULL, NULL, 'CELULAR NUEVO', NULL, '2017-01-23 22:49:10', '0000-00-00 00:00:00', '1', 5),
(323, 4, 4, 229, 'I', '1', 4.2373, 4.2373, 0, 0.7627, 5, 5, 18, 0, 0, NULL, NULL, 'CELULAR NUEVO12_DOS', NULL, '2017-01-23 22:49:10', '0000-00-00 00:00:00', '1', 5),
(324, 4, 4, 230, 'I', '1', 10.1695, 10.1695, 0, 1.8305, 12, 12, 18, 0, 0, NULL, NULL, 'CELULAR NUEVO12_DOS', NULL, '2017-01-24 15:34:17', '0000-00-00 00:00:00', '1', 5),
(325, 3, 4, 231, 'I', '4', 168.6441, 674.5764, 0, 121.4236, 796, 199, 18, 0, 199, NULL, NULL, 'CELULAR NUEVO', NULL, '2017-01-24 15:34:56', '0000-00-00 00:00:00', '1', 5),
(326, 3, 4, 232, 'I', '4', 140.678, 562.712, 0, 101.288, 664, 166, 18, 0, 0, NULL, NULL, 'CELULAR NUEVO', NULL, '2017-01-24 15:36:23', '0000-00-00 00:00:00', '1', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_guiasa`
--

CREATE TABLE `cji_guiasa` (
  `GUIASAP_Codigo` int(11) NOT NULL,
  `TIPOMOVP_Codigo` int(11) NOT NULL,
  `GUIASAC_TipoOperacion` char(1) NOT NULL DEFAULT 'V',
  `ALMAP_Codigo` int(11) DEFAULT NULL,
  `USUA_Codigo` int(11) NOT NULL,
  `CLIP_Codigo` int(11) DEFAULT NULL,
  `PROVP_Codigo` int(11) DEFAULT NULL,
  `DOCUP_Codigo` int(11) DEFAULT NULL,
  `GUIASAC_Fecha` date DEFAULT NULL,
  `GUIASAC_Numero` varchar(10) DEFAULT NULL,
  `GUIASAC_Observacion` varchar(45) DEFAULT NULL,
  `GUIASAC_MarcaPlaca` varchar(100) DEFAULT NULL,
  `GUIASAC_Certificado` varchar(100) DEFAULT NULL,
  `GUIASAC_Licencia` varchar(100) NOT NULL,
  `GUIASAC_RucTransportista` char(11) DEFAULT NULL,
  `GUIASAC_NombreTransportista` varchar(150) DEFAULT NULL,
  `GUIASAC_FechaRegistro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `GUIASAC_FechaModificacion` datetime DEFAULT NULL,
  `GUIASAC_Automatico` int(11) DEFAULT '0',
  `GUIASAC_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_guiasa`
--

INSERT INTO `cji_guiasa` (`GUIASAP_Codigo`, `TIPOMOVP_Codigo`, `GUIASAC_TipoOperacion`, `ALMAP_Codigo`, `USUA_Codigo`, `CLIP_Codigo`, `PROVP_Codigo`, `DOCUP_Codigo`, `GUIASAC_Fecha`, `GUIASAC_Numero`, `GUIASAC_Observacion`, `GUIASAC_MarcaPlaca`, `GUIASAC_Certificado`, `GUIASAC_Licencia`, `GUIASAC_RucTransportista`, `GUIASAC_NombreTransportista`, `GUIASAC_FechaRegistro`, `GUIASAC_FechaModificacion`, `GUIASAC_Automatico`, `GUIASAC_FlagEstado`) VALUES
(5, 1, 'V', 5, 1, 4, NULL, 8, '2017-01-23', '301', '', NULL, NULL, '', NULL, NULL, '2017-01-23 05:00:00', '2017-01-23 00:00:00', 1, '1'),
(6, 1, 'V', 5, 1, 4, NULL, 8, '2017-01-23', '302', '', NULL, NULL, '', NULL, NULL, '2017-01-23 05:00:00', '2017-01-23 00:00:00', 1, '1'),
(7, 1, 'V', 5, 1, 4, NULL, 8, '2017-01-23', '303', '', NULL, NULL, '', NULL, NULL, '2017-01-23 05:00:00', '2017-01-23 00:00:00', 1, '1'),
(8, 1, 'V', 5, 1, 4, NULL, 8, '2017-01-23', '304', '', NULL, NULL, '', NULL, NULL, '2017-01-23 05:00:00', NULL, 1, '1'),
(9, 1, 'V', 5, 1, 4, NULL, 8, '2017-01-24', '305', '', NULL, NULL, '', NULL, NULL, '2017-01-24 05:00:00', NULL, 1, '1'),
(10, 1, 'V', 5, 1, 4, NULL, 8, '2017-01-24', '306', '', NULL, NULL, '', NULL, NULL, '2017-01-24 05:00:00', NULL, 1, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_guiasadetalle`
--

CREATE TABLE `cji_guiasadetalle` (
  `GUIASADETP_Codigo` int(11) NOT NULL,
  `GUIASAP_Codigo` int(11) NOT NULL,
  `PRODCTOP_Codigo` int(11) NOT NULL,
  `UNDMED_Codigo` int(11) DEFAULT NULL,
  `GUIASADETC_GenInd` char(1) DEFAULT 'I' COMMENT 'G:Generico; I indiviual',
  `GUIASADETC_Cantidad` varchar(45) DEFAULT NULL,
  `GUIASADETC_Costo` varchar(45) DEFAULT NULL,
  `GUIASADETC_Descripcion` varchar(300) DEFAULT NULL,
  `GUIASADETC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `GUIASADET_FechaModificacion` datetime DEFAULT NULL,
  `GUIASADETC_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `ALMAP_Codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_guiasadetalle`
--

INSERT INTO `cji_guiasadetalle` (`GUIASADETP_Codigo`, `GUIASAP_Codigo`, `PRODCTOP_Codigo`, `UNDMED_Codigo`, `GUIASADETC_GenInd`, `GUIASADETC_Cantidad`, `GUIASADETC_Costo`, `GUIASADETC_Descripcion`, `GUIASADETC_FechaRegistro`, `GUIASADET_FechaModificacion`, `GUIASADETC_FlagEstado`, `ALMAP_Codigo`) VALUES
(7, 5, 3, 4, 'I', '1', '4', NULL, '2017-01-23 21:17:15', '2017-01-23 00:00:00', '0', 5),
(8, 5, 4, 4, 'I', '1', '5', NULL, '2017-01-23 21:17:15', '2017-01-23 00:00:00', '0', 5),
(9, 6, 3, 4, 'I', '7', '9', NULL, '2017-01-23 21:33:37', '2017-01-23 00:00:00', '0', 5),
(10, 7, 3, 4, 'I', '3', '4', NULL, '2017-01-23 21:48:03', '2017-01-23 00:00:00', '0', 5),
(11, 7, 3, 4, 'I', '3', '4', NULL, '2017-01-23 22:35:45', '2017-01-23 00:00:00', '0', 5),
(12, 8, 4, 4, 'I', '2', '3', NULL, '2017-01-23 22:37:02', NULL, '1', 5),
(13, 7, 3, 4, 'I', '3', '4', NULL, '2017-01-23 22:47:35', '2017-01-23 00:00:00', '0', 5),
(14, 7, 3, 4, 'I', '3', '4', NULL, '2017-01-23 22:47:45', NULL, '1', 5),
(15, 6, 3, 4, 'I', '7', '9', NULL, '2017-01-23 22:47:55', NULL, '1', 5),
(16, 5, 3, 4, 'I', '1', '4', NULL, '2017-01-23 22:49:09', NULL, '1', 5),
(17, 5, 4, 4, 'I', '1', '5', NULL, '2017-01-23 22:49:10', NULL, '1', 5),
(18, 9, 4, 4, 'I', '1', '12', NULL, '2017-01-24 15:34:16', NULL, '1', 5),
(19, 10, 3, 4, 'I', '4', '166', NULL, '2017-01-24 15:36:22', NULL, '1', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_guiatrans`
--

CREATE TABLE `cji_guiatrans` (
  `GTRANP_Codigo` int(11) NOT NULL,
  `GTRANC_Serie` varchar(10) DEFAULT NULL,
  `GTRANC_Numero` varchar(11) DEFAULT NULL,
  `GTRANC_CodigoUsuario` varchar(50) DEFAULT NULL,
  `GTRANC_AlmacenOrigen` int(11) NOT NULL,
  `GTRANC_AlmacenDestino` int(11) NOT NULL,
  `GTRANC_PersonalRecep` int(11) NOT NULL,
  `GTRANC_Fecha` date NOT NULL,
  `GTRANC_Observacion` text,
  `COMPP_Codigo` int(11) NOT NULL,
  `GUIASAP_Codigo` int(11) NOT NULL,
  `GUIAINP_Codigo` int(11) NOT NULL,
  `USUA_Codigo` int(11) NOT NULL,
  `GTRANC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `GTRANC_FechaModificacion` datetime DEFAULT NULL,
  `GTRANC_EstadoTrans` int(11) NOT NULL COMMENT '0: pendiente; 1:asignado; 2:cancelado',
  `GTRANC_FlagEstado` varchar(1) NOT NULL DEFAULT '1',
  `EMPRP_Codigo` int(11) DEFAULT NULL,
  `GTRANC_Placa` varchar(64) DEFAULT NULL,
  `GTRANC_Licencia` varchar(64) DEFAULT NULL,
  `GTRANC_Chofer` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_guiatransdetalle`
--

CREATE TABLE `cji_guiatransdetalle` (
  `GTRANDETP_Codigo` int(11) NOT NULL,
  `GTRANP_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `UNDMED_Codigo` int(11) DEFAULT NULL,
  `GTRANDETC_GenInd` varchar(1) DEFAULT 'I',
  `GTRANDETC_Cantidad` int(11) NOT NULL,
  `GTRANDETC_Costo` varchar(21) DEFAULT NULL,
  `GTRANDETC_Descripcion` varchar(250) DEFAULT NULL,
  `GTRANDETC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `GTRANDETC_FechaModificacion` datetime DEFAULT NULL,
  `GTRANDETC_FlagEstado` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_inventario`
--

CREATE TABLE `cji_inventario` (
  `INVE_Codigo` int(11) NOT NULL,
  `INVE_Titulo` varchar(500) NOT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `INVE_Serie` int(11) NOT NULL,
  `INVE_Numero` int(11) NOT NULL,
  `ALMAP_Codigo` int(11) NOT NULL,
  `INVE_FechaInicio` date NOT NULL,
  `INVE_FechaFin` date NOT NULL,
  `INVE_FechaRegistro` date NOT NULL,
  `INVE_FechaModificacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `INVE_FlagEstado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cji_inventario`
--

INSERT INTO `cji_inventario` (`INVE_Codigo`, `INVE_Titulo`, `COMPP_Codigo`, `INVE_Serie`, `INVE_Numero`, `ALMAP_Codigo`, `INVE_FechaInicio`, `INVE_FechaFin`, `INVE_FechaRegistro`, `INVE_FechaModificacion`, `INVE_FlagEstado`) VALUES
(32, 'nuevo inventario', 1, 4, 89, 5, '2017-01-23', '0000-00-00', '0000-00-00', '2017-01-23 21:09:20', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_inventariodetalle`
--

CREATE TABLE `cji_inventariodetalle` (
  `INVD_Codigo` int(11) NOT NULL,
  `INVE_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `INVD_Cantidad` decimal(10,2) NOT NULL,
  `INVD_Pcosto` double DEFAULT '0',
  `INVD_FechaRegistro` date NOT NULL,
  `INVD_FechaModificacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `INVD_FlagActivacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cji_inventariodetalle`
--

INSERT INTO `cji_inventariodetalle` (`INVD_Codigo`, `INVE_Codigo`, `PROD_Codigo`, `INVD_Cantidad`, `INVD_Pcosto`, `INVD_FechaRegistro`, `INVD_FechaModificacion`, `INVD_FlagActivacion`) VALUES
(61, 32, 3, '5.00', 20, '2017-01-23', '2017-01-23 21:09:58', 1),
(62, 32, 4, '5.00', 10, '2017-01-23', '2017-01-23 21:10:29', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_item`
--

CREATE TABLE `cji_item` (
  `ITEM_Codigo` int(11) NOT NULL,
  `ITEM_Descripcion` varchar(250) DEFAULT NULL,
  `ITEM_Abreviatura` varchar(250) DEFAULT NULL,
  `ITEM_Valor` varchar(250) DEFAULT NULL,
  `ITEM_UsuCrea` varchar(220) DEFAULT NULL,
  `ITEM_UsuModi` varchar(220) DEFAULT NULL,
  `ITEM_FechaModi` datetime DEFAULT NULL,
  `ITEM_FechaIngr` datetime DEFAULT NULL,
  `ITEM_Estado` char(1) DEFAULT NULL,
  `ITEM_Nombre` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cji_item`
--

INSERT INTO `cji_item` (`ITEM_Codigo`, `ITEM_Descripcion`, `ITEM_Abreviatura`, `ITEM_Valor`, `ITEM_UsuCrea`, `ITEM_UsuModi`, `ITEM_FechaModi`, `ITEM_FechaIngr`, `ITEM_Estado`, `ITEM_Nombre`) VALUES
(2, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'Nombre'),
(3, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'Ruc'),
(6, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'Direccion'),
(8, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'Cantidad'),
(9, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'DestinoNombre'),
(10, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'DestinoRuc'),
(11, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'FechaEmision'),
(12, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'FechaRecepcion'),
(13, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'DescripcionProducto'),
(14, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'PrecioUnitario'),
(15, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'ImporteProducto'),
(16, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'TotalProducto'),
(17, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'NroOrdenVenta'),
(18, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'Vendedor'),
(19, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'GuiaRemision'),
(20, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'SubTotal'),
(21, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'IGV'),
(22, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'Total'),
(23, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'MontoEnLetras'),
(24, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'FormaDePago'),
(25, NULL, NULL, NULL, 'UsuarioAdministrador', NULL, NULL, '2016-10-20 00:00:00', '1', 'Moneda');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_kardex`
--

CREATE TABLE `cji_kardex` (
  `KARDP_Codigo` int(11) NOT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL DEFAULT '0',
  `DOCUP_Codigo` int(11) DEFAULT NULL,
  `TIPOMOVP_Codigo` int(11) DEFAULT NULL,
  `LOTP_Codigo` int(11) DEFAULT NULL,
  `KARDC_CodigoDoc` varchar(50) DEFAULT NULL,
  `KARDC_TipoIngreso` char(1) DEFAULT NULL COMMENT '''1 Ingreso, 2 Salida''',
  `KARD_Fecha` datetime NOT NULL,
  `KARDC_Cantidad` double DEFAULT '0',
  `KARDC_Costo` double DEFAULT '0',
  `ALMPROD_Codigo` int(11) NOT NULL,
  `KARDP_FlagEstado` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_kardex`
--

INSERT INTO `cji_kardex` (`KARDP_Codigo`, `COMPP_Codigo`, `PROD_Codigo`, `DOCUP_Codigo`, `TIPOMOVP_Codigo`, `LOTP_Codigo`, `KARDC_CodigoDoc`, `KARDC_TipoIngreso`, `KARD_Fecha`, `KARDC_Cantidad`, `KARDC_Costo`, `ALMPROD_Codigo`, `KARDP_FlagEstado`) VALUES
(352, 1, 3, 4, NULL, NULL, '32', '3', '2017-01-23 04:01:58', 5, 20, 3, '1'),
(353, 1, 3, 5, 2, 146, '143', '1', '2017-01-23 00:00:00', 0, 20, 3, '1'),
(354, 1, 4, 4, NULL, NULL, '32', '3', '2017-01-23 04:01:28', 5, 10, 4, '1'),
(355, 1, 4, 5, 2, 147, '144', '1', '2017-01-23 00:00:00', 0, 10, 4, '1'),
(356, 1, 3, 5, 2, 148, '145', '1', '2017-01-23 16:13:42', 3, 3, 3, '1'),
(359, 1, 3, 5, 2, 149, '146', '1', '2017-01-23 16:18:27', 6, 6, 3, '1'),
(362, 1, 4, 5, 2, 152, '147', '1', '2017-01-23 16:20:06', 5, 9, 4, '1'),
(363, 1, 3, 5, 2, 153, '147', '1', '2017-01-23 16:20:06', 3, 3, 3, '1'),
(370, 1, 4, 6, 2, 147, '8', '2', '2017-01-23 17:37:02', -1, 3, 4, '1'),
(371, 1, 4, 6, 2, 150, '8', '2', '2017-01-23 17:37:02', 3, 3, 4, '1'),
(373, 1, 3, 6, 2, 153, '7', '2', '2017-01-23 16:48:03', 3, 4, 3, '1'),
(374, 1, 3, 6, 2, 153, '6', '2', '2017-01-23 16:33:37', 7, 9, 3, '1'),
(375, 1, 3, 6, 2, 153, '5', '2', '2017-01-23 16:17:15', 1, 4, 3, '1'),
(376, 1, 4, 6, 2, 150, '5', '2', '2017-01-23 16:17:15', 1, 5, 4, '1'),
(377, 1, 4, 6, 2, 150, '9', '2', '2017-01-24 10:34:16', 1, 12, 4, '1'),
(378, 1, 3, 5, 2, 154, '148', '1', '2017-01-24 10:34:55', 4, 199, 3, '1'),
(379, 1, 3, 6, 2, 153, '10', '2', '2017-01-24 10:36:23', 4, 166, 3, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_letra`
--

CREATE TABLE `cji_letra` (
  `LET_Codigo` int(11) NOT NULL,
  `LET_TipoOperacion` char(1) NOT NULL DEFAULT 'V' COMMENT 'V: venta, C: compra',
  `LET_TipoDocumento` char(1) NOT NULL DEFAULT 'F' COMMENT 'F: factura, B: boleta, N: nunguno de los dos',
  `PRESUP_Codigo` int(11) DEFAULT NULL,
  `OCOMP_Codigo` int(11) DEFAULT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `LET_Serie` char(4) NOT NULL,
  `LET_Numero` varchar(11) NOT NULL,
  `CLIP_Codigo` int(11) DEFAULT NULL,
  `CLIPDOS_Codigo` int(11) DEFAULT NULL,
  `CLIPTRES_Codigo` int(11) DEFAULT NULL,
  `PROVP_Codigo` int(11) DEFAULT NULL,
  `PROVPDOS_Codigo` int(11) DEFAULT NULL,
  `PROVPTRES_Codigo` int(11) DEFAULT NULL,
  `LET_NombreAuxiliar` varchar(25) DEFAULT 'cliente',
  `USUA_Codigo` int(11) NOT NULL,
  `MONED_Codigo` int(11) NOT NULL DEFAULT '1',
  `FORPAP_Codigo` int(11) DEFAULT NULL,
  `LET_subtotal` double(10,2) DEFAULT NULL,
  `LET_descuento` double(10,2) DEFAULT NULL,
  `LET_igv` double(10,2) DEFAULT NULL,
  `LET_total` double(10,2) NOT NULL DEFAULT '0.00',
  `LET_subtotal_conigv` double(10,2) DEFAULT NULL COMMENT 'Para que pueda ser usado como una boleta',
  `LET_descuento_conigv` double(10,2) DEFAULT NULL COMMENT 'Para que pueda ser usado como una boleta',
  `LET_igv100` int(11) NOT NULL DEFAULT '0',
  `LET_descuento100` int(11) NOT NULL DEFAULT '0',
  `GUIAREMP_Codigo` int(11) DEFAULT NULL,
  `LET_GuiaRemCodigo` varchar(50) DEFAULT NULL,
  `LET_DocuRefeCodigo` varchar(50) DEFAULT NULL,
  `LET_Observacion` varchar(250) DEFAULT NULL,
  `LET_ModoImpresion` char(1) NOT NULL DEFAULT '1',
  `LET_Fecha` date NOT NULL,
  `LET_FechaVenc` date NOT NULL,
  `LET_Vendedor` int(11) DEFAULT NULL,
  `LET_TDC` double(10,2) DEFAULT NULL,
  `LET_FlagMueveStock` char(1) NOT NULL DEFAULT '0',
  `GUIASAP_Codigo` int(11) DEFAULT NULL,
  `GUIAINP_Codigo` int(11) DEFAULT NULL,
  `USUA_anula` int(11) DEFAULT NULL,
  `LET_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `LET_FechaModificacion` datetime DEFAULT NULL,
  `LET_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `LET_Hora` time NOT NULL,
  `ALMAP_Codigo` int(11) NOT NULL,
  `LET_Codigo_Canje` int(11) DEFAULT '0',
  `LET_Banco` int(11) DEFAULT '0',
  `LET_Representante` varchar(200) DEFAULT NULL,
  `LET_Oficina` varchar(200) DEFAULT NULL,
  `LET_NumeroCuenta` varchar(200) DEFAULT NULL,
  `LET_DC` varchar(200) DEFAULT NULL,
  `LET_Direccion` varchar(200) DEFAULT NULL,
  `LET_Ubigeo` varchar(200) DEFAULT NULL,
  `LET_DireccionPago` varchar(200) DEFAULT NULL,
  `LET_UbigeoPago` varchar(200) DEFAULT NULL,
  `LET_CuentaBanco` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_linea`
--

CREATE TABLE `cji_linea` (
  `LINP_Codigo` int(11) NOT NULL,
  `LINC_CodigoUsuario` varchar(20) DEFAULT NULL,
  `LINC_Descripcion` varchar(150) DEFAULT NULL,
  `LINC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `LINC_FechaModificacion` datetime DEFAULT NULL,
  `LINC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_log`
--

CREATE TABLE `cji_log` (
  `LOGP_Codigo` int(11) NOT NULL,
  `LOGC_Tabla` varchar(35) NOT NULL,
  `LOGC_Registro` int(11) NOT NULL,
  `LOGC_Categoria` varchar(20) NOT NULL,
  `LOGC_Valor` varchar(25) NOT NULL,
  `LOGC_Fecha` datetime NOT NULL,
  `USUA_Codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_lote`
--

CREATE TABLE `cji_lote` (
  `LOTP_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `LOTC_Cantidad` double NOT NULL DEFAULT '0',
  `LOTC_Costo` double NOT NULL DEFAULT '0',
  `GUIAINP_Codigo` int(11) NOT NULL,
  `LOTC_FechaRegistro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `LOTC_FechaModificacion` datetime DEFAULT NULL,
  `LOTC_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_lote`
--

INSERT INTO `cji_lote` (`LOTP_Codigo`, `PROD_Codigo`, `LOTC_Cantidad`, `LOTC_Costo`, `GUIAINP_Codigo`, `LOTC_FechaRegistro`, `LOTC_FechaModificacion`, `LOTC_FlagEstado`) VALUES
(146, 3, 0, 20, 143, '2017-01-23 21:09:58', NULL, '1'),
(147, 4, 0, 10, 144, '2017-01-23 21:10:29', NULL, '1'),
(148, 3, 3, 3, 145, '2017-01-23 21:13:42', '0000-00-00 00:00:00', '1'),
(149, 3, 6, 6, 146, '2017-01-23 21:18:27', '0000-00-00 00:00:00', '1'),
(150, 4, 5, 9, 147, '2017-01-23 21:20:06', '2017-01-23 16:20:21', '0'),
(151, 3, 3, 3, 147, '2017-01-23 21:20:07', '2017-01-23 16:20:21', '0'),
(152, 4, 5, 9, 147, '2017-01-23 21:20:22', '0000-00-00 00:00:00', '1'),
(153, 3, 3, 3, 147, '2017-01-23 21:20:22', '0000-00-00 00:00:00', '1'),
(154, 3, 4, 199, 148, '2017-01-24 15:34:55', '0000-00-00 00:00:00', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_loteprorrateo`
--

CREATE TABLE `cji_loteprorrateo` (
  `LOTPROP_Codigo` int(11) NOT NULL,
  `LOTP_Codigo` int(11) NOT NULL,
  `LOTPROC_CostoAnterior` double NOT NULL,
  `LOTPROC_CantActual` int(11) NOT NULL,
  `LOTPROC_Fecha` date NOT NULL,
  `LOTPROC_Tipo` int(11) NOT NULL,
  `LOTPROC_CantidadAdi` int(11) DEFAULT NULL,
  `LOTPROC_Valor` double DEFAULT NULL,
  `LOTPROC_Obs` text,
  `LOTPROC_CostoNuevo` double NOT NULL,
  `GUIAREMDETP_Codigo` int(11) DEFAULT NULL,
  `CPDEP_Codigo` int(11) DEFAULT NULL,
  `LOTPROC_FlagRecepProdu` char(1) NOT NULL,
  `LOTPROC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `LOTPROC_FechaModificacion` datetime DEFAULT NULL,
  `LOTPROC_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_marca`
--

CREATE TABLE `cji_marca` (
  `MARCP_Codigo` int(11) NOT NULL,
  `MARCC_CodigoUsuario` varchar(20) DEFAULT NULL,
  `MARCC_Descripcion` varchar(150) DEFAULT NULL,
  `MARCC_Imagen` varchar(100) DEFAULT NULL,
  `MARCC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `MARCC_FechaModificacion` datetime DEFAULT NULL,
  `MARCC_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_marca`
--

INSERT INTO `cji_marca` (`MARCP_Codigo`, `MARCC_CodigoUsuario`, `MARCC_Descripcion`, `MARCC_Imagen`, `MARCC_FechaRegistro`, `MARCC_FechaModificacion`, `MARCC_FlagEstado`) VALUES
(7, '', 'NUEVA MARCA', '', '2017-01-23 20:05:25', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_menu`
--

CREATE TABLE `cji_menu` (
  `MENU_Codigo` int(11) NOT NULL,
  `MENU_Codigo_Padre` int(11) NOT NULL DEFAULT '0',
  `MENU_Descripcion` varchar(150) DEFAULT NULL,
  `MENU_Url` varchar(250) DEFAULT NULL,
  `MENU_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `MENU_FechaModificacion` datetime DEFAULT NULL,
  `MENU_OrderBy` int(3) NOT NULL,
  `MENU_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_menu`
--

INSERT INTO `cji_menu` (`MENU_Codigo`, `MENU_Codigo_Padre`, `MENU_Descripcion`, `MENU_Url`, `MENU_FechaRegistro`, `MENU_FechaModificacion`, `MENU_OrderBy`, `MENU_FlagEstado`) VALUES
(2, 0, 'Principal', NULL, '2011-02-18 07:46:23', NULL, 0, '1'),
(3, 0, 'Almacen', NULL, '2011-02-18 07:46:23', NULL, 0, '1'),
(4, 0, 'Ventas', NULL, '2011-05-28 13:18:51', NULL, 0, '1'),
(5, 0, 'Compras', NULL, '2015-07-24 11:23:45', NULL, 0, '1'),
(6, 0, 'Tesoreria', NULL, '2012-09-19 14:59:53', NULL, 0, '1'),
(7, 0, 'Mantenimientos', NULL, '2010-12-28 23:21:18', NULL, 0, '1'),
(8, 0, 'Base de Datos', NULL, '2016-11-11 20:12:47', NULL, 0, '1'),
(9, 0, 'Reportes', '', '2011-07-23 20:45:23', NULL, 0, '1'),
(10, 2, 'Proveedores', 'compras/proveedor/proveedores', '2015-07-31 03:36:06', NULL, 0, '1'),
(11, 2, 'Clientes', 'ventas/cliente/clientes', '2011-07-05 17:27:03', NULL, 0, '1'),
(12, 3, 'Artículos', 'almacen/producto/productos/B', '2017-01-23 21:04:44', NULL, 1, '1'),
(13, 3, 'Familias de Artí­culos', 'almacen/familia/familias/B', '2017-01-23 21:04:50', NULL, 3, '1'),
(14, 3, 'C.Ingreso', 'almacen/guiain/listar', '2017-01-23 21:06:34', NULL, 18, '1'),
(15, 3, 'C.Salida', 'almacen/guiasa/listar', '2017-01-23 21:06:30', NULL, 16, '1'),
(16, 4, 'Guia de Remision Venta', 'almacen/guiarem/listar/V', '2017-01-23 20:59:05', NULL, 2, '1'),
(17, 4, 'Presupuestos', 'ventas/presupuesto/presupuestos', '2017-01-23 20:59:33', NULL, 6, '1'),
(18, 4, 'Facturas', 'ventas/comprobante/comprobantes/V/F', '2017-01-23 20:59:15', NULL, 3, '1'),
(19, 5, 'Solicitudes de Cotizaciones', 'compras/cotizaciones/presupuestos', '2017-01-23 21:03:18', NULL, 15, '1'),
(20, 5, 'Ordenes de Compras', 'compras/ocompra/ocompras', '2017-01-23 21:01:13', NULL, 1, '1'),
(21, 6, 'Cuentas por Cobrar', 'tesoreria/cuentas/listar/1', '2012-10-11 15:51:03', NULL, 0, '1'),
(22, 6, 'Cuentas por Pagar', 'tesoreria/cuentas/listar/2', '2015-10-23 05:59:48', NULL, 0, '1'),
(23, 6, 'Caja Diaria', 'tesoreria/caja/cajas', '2016-11-17 00:21:41', NULL, 0, '1'),
(24, 6, 'Libro Diario', NULL, '2016-09-20 02:12:32', NULL, 0, '1'),
(25, 7, 'Configuracion del sistema', 'maestros/configuracion/editar_configuracion', '2011-07-05 17:44:39', NULL, 0, '1'),
(26, 7, 'Cargos', 'maestros/cargo/cargos', '2011-07-05 17:44:39', NULL, 0, '1'),
(27, 7, 'Areas', 'maestros/area/areas', '2011-07-05 17:45:34', NULL, 0, '1'),
(28, 7, 'Usuarios', 'seguridad/usuario/usuarios', '2011-07-05 17:45:34', NULL, 0, '1'),
(29, 7, 'Establecimientos', 'maestros/establecimiento/establecimientos', '2016-09-21 19:45:30', NULL, 0, '1'),
(30, 7, 'Almacenes', 'almacen/almacen/listar', '2016-09-21 19:45:22', NULL, 0, '1'),
(31, 7, 'Unidad Medida', 'almacen/unidadmedida/listar', '2011-07-05 17:46:54', NULL, 0, '1'),
(32, 7, 'Forma de pago', 'maestros/formapago/listar', '2011-07-05 17:46:54', NULL, 0, '1'),
(33, 7, 'Fabricante', 'almacen/fabricante/listar', '2011-07-05 17:47:33', NULL, 0, '1'),
(34, 7, 'Marca', 'almacen/marca/listar', '2011-07-05 17:47:33', NULL, 0, '1'),
(35, 7, 'Lí­nea', 'almacen/linea/listar', '2017-01-11 21:37:45', NULL, 0, '1'),
(36, 8, 'Subir en Excel', 'basedatos/basedatos/basedatos_principal', '2016-11-24 20:31:32', NULL, 0, '1'),
(37, 3, 'Tipos de Artículo', 'almacen/tipoproducto/tipoproductos/B', '2017-01-23 21:06:28', NULL, 14, '1'),
(38, 5, 'Seguimiento de O. de Compras', 'compras/ocompra/ocompras/0/C/1', '2017-01-23 21:02:31', NULL, 6, '1'),
(39, 3, 'Stock almacen', 'almacen/almacenproducto/listar', '2017-01-23 21:05:01', NULL, 2, '1'),
(40, 3, 'Kardex producto', 'almacen/kardex/listar', '2017-01-23 21:05:14', NULL, 4, '1'),
(42, 9, 'AlmacÃ©n', NULL, '2016-09-21 19:47:05', NULL, 0, '1'),
(43, 9, 'Ventas', 'ventas/comprobante/reportes', '2016-09-21 19:47:03', NULL, 0, '1'),
(44, 9, 'Compras', 'compras/ocompra/reportes', '2016-09-21 19:47:02', NULL, 0, '1'),
(45, 9, 'TesorerÃ­a', NULL, '2016-09-21 19:46:59', NULL, 0, '1'),
(46, 7, 'Categorí­as de Clientes', 'ventas/tipocliente/listar', '2017-01-11 21:38:01', NULL, 0, '1'),
(47, 2, 'Personas', 'maestros/persona/personas', '2016-09-21 19:46:56', NULL, 0, '1'),
(48, 2, 'Empresas', 'maestros/empresa/empresas', '2016-09-21 19:46:54', NULL, 0, '1'),
(49, 7, 'Roles', 'seguridad/rol/listar', '2011-07-27 17:34:21', NULL, 0, '1'),
(50, 6, 'Tipo de Cambio Divisa', 'maestros/tipocambio/listar', '2016-08-19 02:49:24', NULL, 0, '1'),
(51, 7, 'Proyectos', 'maestros/proyecto/proyectos', '2016-09-21 19:46:51', NULL, 0, '1'),
(52, 4, 'Boletas', 'ventas/comprobante/comprobantes/V/B', '2017-01-23 20:59:21', NULL, 4, '1'),
(53, 4, 'Comprobantes', 'ventas/comprobante/comprobantes/V/N', '2017-01-23 20:59:25', NULL, 5, '1'),
(54, 5, 'Facturas', 'ventas/comprobante/comprobantes/C/F', '2017-01-23 21:01:28', NULL, 3, '1'),
(55, 5, 'Boletas', 'ventas/comprobante/comprobantes/C/B', '2017-01-23 21:01:55', NULL, 4, '1'),
(56, 5, 'Comprobantes', 'ventas/comprobante/comprobantes/C/N', '2017-01-23 21:02:00', NULL, 5, '1'),
(57, 4, 'Ordenes de Venta', 'compras/ocompra/ocompras/0/V', '2017-01-23 20:58:57', NULL, 1, '1'),
(58, 5, 'Guía de  Remisión Compra', 'almacen/guiarem/listar/C', '2017-01-23 21:01:20', NULL, 2, '1'),
(59, 5, 'Tipos de Proveedor', 'almacen/tipoproveedor/familias', '2017-01-23 21:02:37', NULL, 7, '0'),
(60, 4, 'Seguimiento de Ordenes de Venta', 'compras/ocompra/ocompras/0/V/1', '2017-01-23 20:59:40', NULL, 7, '1'),
(61, 5, 'Pedidos', 'compras/pedido/pedidos', '2017-01-23 21:02:41', NULL, 8, '1'),
(62, 5, 'Cotizaciones', 'compras/presupuesto/presupuestos', '2017-01-23 21:02:44', NULL, 9, '1'),
(63, 5, 'Cuadros Comparativos', 'compras/cuadrocom/cuadros', '2017-01-23 21:02:48', NULL, 10, '1'),
(64, 3, 'Servicios', 'almacen/producto/productos/S', '2017-01-23 21:05:21', NULL, 6, '1'),
(65, 3, 'Tipo de Servicio', 'almacen/tipoproducto/tipoproductos/S', '2017-01-23 21:05:25', NULL, 7, '1'),
(66, 3, 'Familias de Servicios', 'almacen/familia/familias/S', '2017-01-23 21:06:25', NULL, 13, '1'),
(67, 9, 'Ventas por Vendedor', 'reportes/ventas/filtroVendedor', '2012-10-02 12:20:04', NULL, 0, '1'),
(68, 9, 'Ventas por Marca', 'reportes/ventas/filtroMarca', '2016-09-21 19:46:26', NULL, 0, '1'),
(69, 9, 'Ventas por Familia', 'reportes/ventas/filtroFamilia', '2016-09-21 19:46:22', NULL, 0, '1'),
(70, 9, 'Ventas Diario', 'reportes/ventas/filtroDiario', '2012-10-02 12:20:04', NULL, 0, '1'),
(71, 3, 'Stock General', 'almacen/almacenproducto/listar_general', '2017-01-23 21:06:21', NULL, 12, '1'),
(72, 6, 'Cheques', 'tesoreria/cheque/listar/', '2016-09-21 19:46:20', NULL, 0, '1'),
(73, 9, 'Planilla Cobranza', 'reportes/cobros/planilla', '2016-09-21 19:46:16', NULL, 0, '1'),
(74, 3, 'G. Tranferencia', 'almacen/guiatrans/listar	', '2017-01-23 21:06:17', NULL, 11, '0'),
(75, 9, 'Reporte de Ganancias', 'reportes/ventas/ganancia', '2016-09-21 19:46:12', NULL, 0, '1'),
(76, 3, 'Artí­culos - Precio de Venta', 'almacen/producto/productos_precios', '2017-01-23 21:06:02', NULL, 10, '1'),
(77, 9, 'Estado de Cuenta', 'reportes/ventas/estado_cuenta	', '2016-09-21 19:46:04', NULL, 0, '1'),
(78, 3, 'Envio Proveedor', 'almacen/envioproveedor/listar ', '2017-01-23 21:05:57', NULL, 0, '0'),
(79, 3, 'Recepcion Proveedor', 'almacen/recepcionproveedor/listar  ', '2017-01-23 21:05:52', NULL, 0, '0'),
(80, 3, 'Entrega Cliente', 'almacen/entregacliente/listar  ', '2017-01-23 21:05:44', NULL, 0, '0'),
(81, 3, 'Garantia', 'almacen/garantia/listar  ', '2017-01-23 21:05:36', NULL, 9, '1'),
(82, 4, 'Nota de Credito', 'ventas/notacredito/comprobantes/V/F', '2017-01-23 20:59:43', NULL, 8, '1'),
(83, 5, 'Nota de Credito', 'ventas/notacredito/comprobantes/C/F', '2017-01-23 21:02:51', NULL, 11, '1'),
(84, 7, 'Usuarios Web', 'seguridad/impactousuario/listar', '2013-01-05 14:33:45', NULL, 0, '1'),
(85, 9, 'Valorizacion Actual', 'reportes/valorizacion/valor', '2016-09-21 19:45:47', NULL, 0, '1'),
(86, 9, 'Reporte de Ventas', 'reportes/rventas/reporte_ventas', '2013-01-28 20:00:00', NULL, 0, '1'),
(87, 2, 'Personal', 'maestros/directivo/directivos', '2015-07-16 01:36:37', NULL, 0, '1'),
(88, 9, 'Valorizacion x Producto', 'reportes/valorizacion/valorizacion_producto', '2016-09-21 19:45:45', NULL, 0, '1'),
(89, 9, 'Ventas del dia', 'reportes/ventas/ventasdiario', '2013-04-06 05:41:41', NULL, 0, '1'),
(90, 3, 'Ingreso de Inventario', 'almacen/inventario/listar', '2017-01-23 21:05:31', NULL, 8, '1'),
(91, 0, 'Contabilidad', '', '2016-09-21 19:45:40', NULL, 0, '1'),
(92, 0, 'Contabilidad', '', '2016-09-21 19:45:38', NULL, 0, '1'),
(93, 0, 'Contabilidad', '', '2016-04-06 00:47:19', NULL, 0, '1'),
(94, 93, 'Registro de Compras', 'reportes/ventas/registro_ventas/C', '2013-05-10 16:26:00', NULL, 0, '1'),
(95, 93, 'Registro de Ventas', 'reportes/ventas/registro_ventas/V', '2013-05-10 16:26:19', NULL, 0, '1'),
(96, 4, 'Letra de Cambio', 'ventas/letracambio/comprobantes/V/F', '2017-01-23 20:59:47', NULL, 9, '1'),
(97, 5, 'Letra de Cambio', 'ventas/letracambio/comprobantes/C/F', '2017-01-23 21:02:54', NULL, 12, '1'),
(98, 4, 'Nota de Debito', 'ventas/notacredito/comprobantes/V/B', '2017-01-23 20:59:50', NULL, 10, '1'),
(99, 5, 'Nota de Debito Compra', 'ventas/notacredito/comprobantes/C/B', '2017-01-23 21:03:00', NULL, 13, '1'),
(100, 7, 'Terminales', 'maestros/terminal/terminales', '2016-10-28 01:44:21', NULL, 0, '1'),
(101, 6, 'Tipo Caja', 'tesoreria/tipocaja/tipocajas', '2016-11-11 03:40:18', NULL, 0, '1'),
(102, 7, 'Configuracion Impresion', 'maestros/configuracionimpresion/configuracion_index', '2016-10-28 01:44:21', NULL, 0, '1'),
(103, 6, 'Caja Movimiento', 'tesoreria/movimiento/movimientos/0', '2016-12-12 21:00:22', NULL, 0, '1'),
(104, 7, 'Sector comercia', 'maestros/comercial/sector_comercial', '2017-01-13 14:38:07', NULL, 0, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_moneda`
--

CREATE TABLE `cji_moneda` (
  `MONED_Codigo` int(11) NOT NULL,
  `MONED_Descripcion` varchar(250) DEFAULT NULL,
  `MONED_Simbolo` varchar(100) NOT NULL,
  `MONED_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `MONED_FechaModificacion` datetime DEFAULT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `MONED_Orden` int(11) NOT NULL DEFAULT '0',
  `MONED_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_moneda`
--

INSERT INTO `cji_moneda` (`MONED_Codigo`, `MONED_Descripcion`, `MONED_Simbolo`, `MONED_FechaRegistro`, `MONED_FechaModificacion`, `COMPP_Codigo`, `MONED_Orden`, `MONED_FlagEstado`) VALUES
(1, 'SOLES', 'S/.', '2011-01-11 23:13:10', NULL, 1, 1, '1'),
(2, 'DOLARES AMERICANOS', 'US$', '2011-01-11 23:13:18', NULL, 1, 2, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_nacionalidad`
--

CREATE TABLE `cji_nacionalidad` (
  `NACP_Codigo` int(11) NOT NULL,
  `NACC_Descripcion` varchar(150) DEFAULT NULL,
  `NACC_FechaRegistro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `NACC_FechaModificacion` datetime DEFAULT NULL,
  `NACC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cji_nacionalidad`
--

INSERT INTO `cji_nacionalidad` (`NACP_Codigo`, `NACC_Descripcion`, `NACC_FechaRegistro`, `NACC_FechaModificacion`, `NACC_FlagEstado`) VALUES
(1, 'BOUVET ISLAND', '2010-12-15 01:53:48', NULL, '1'),
(2, 'COTE D IVOIRE', '2010-12-15 01:53:48', NULL, '1'),
(3, 'FALKLAND ISLANDS (MALVINAS)', '2010-12-15 01:53:48', NULL, '1'),
(4, 'FRANCE, METROPOLITAN', '2010-12-15 01:53:48', NULL, '1'),
(5, 'FRENCH SOUTHERN TERRITORIES', '2010-12-15 01:53:48', NULL, '1'),
(6, 'HEARD AND MC DONALD ISLANDS', '2010-12-15 01:53:48', NULL, '1'),
(7, 'MAYOTTE', '2010-12-15 01:53:48', NULL, '1'),
(8, 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', '2010-12-15 01:53:48', NULL, '1'),
(9, 'SVALBARD AND JAN MAYEN ISLANDS', '2010-12-15 01:53:48', NULL, '1'),
(10, 'UNITED STATES MINOR OUTLYING ISLANDS', '2010-12-15 01:53:48', NULL, '1'),
(11, 'OTROS PAISES O LUGARES', '2010-12-15 01:53:48', NULL, '1'),
(12, 'AFGANISTAN', '2010-12-15 01:53:48', NULL, '1'),
(13, 'ALBANIA', '2010-12-15 01:53:48', NULL, '1'),
(14, 'ALDERNEY', '2010-12-15 01:53:48', NULL, '1'),
(15, 'ALEMANIA', '2010-12-15 01:53:48', NULL, '1'),
(16, 'ARMENIA', '2010-12-15 01:53:48', NULL, '1'),
(17, 'ARUBA', '2010-12-15 01:53:48', NULL, '1'),
(18, 'ASCENCION', '2010-12-15 01:53:48', NULL, '1'),
(19, 'BOSNIA-HERZEGOVINA', '2010-12-15 01:53:48', NULL, '1'),
(20, 'BURKINA FASO', '2010-12-15 01:53:48', NULL, '1'),
(21, 'ANDORRA', '2010-12-15 01:53:48', NULL, '1'),
(22, 'ANGOLA', '2010-12-15 01:53:48', NULL, '1'),
(23, 'ANGUILLA', '2010-12-15 01:53:48', NULL, '1'),
(24, 'ANTIGUA Y BARBUDA', '2010-12-15 01:53:48', NULL, '1'),
(25, 'ANTILLAS HOLANDESAS', '2010-12-15 01:53:48', NULL, '1'),
(26, 'ARABIA SAUDITA', '2010-12-15 01:53:48', NULL, '1'),
(27, 'ARGELIA', '2010-12-15 01:53:48', NULL, '1'),
(28, 'ARGENTINA', '2010-12-15 01:53:48', NULL, '1'),
(29, 'AUSTRALIA', '2010-12-15 01:53:48', NULL, '1'),
(30, 'AUSTRIA', '2010-12-15 01:53:48', NULL, '1'),
(31, 'AZERBAIJÃN', '2010-12-15 01:53:48', NULL, '1'),
(32, 'BAHAMAS', '2010-12-15 01:53:48', NULL, '1'),
(33, 'BAHREIN', '2010-12-15 01:53:48', NULL, '1'),
(34, 'BANGLA DESH', '2010-12-15 01:53:48', NULL, '1'),
(35, 'BARBADOS', '2010-12-15 01:53:48', NULL, '1'),
(36, 'BÃ‰LGICA', '2010-12-15 01:53:48', NULL, '1'),
(37, 'BELICE', '2010-12-15 01:53:48', NULL, '1'),
(38, 'BERMUDAS', '2010-12-15 01:53:48', NULL, '1'),
(39, 'BELARUS', '2010-12-15 01:53:48', NULL, '1'),
(40, 'MYANMAR', '2010-12-15 01:53:48', NULL, '1'),
(41, 'BOLIVIA', '2010-12-15 01:53:48', NULL, '1'),
(42, 'BOTSWANA', '2010-12-15 01:53:48', NULL, '1'),
(43, 'BRASIL', '2010-12-15 01:53:48', NULL, '1'),
(44, 'BRUNEI DARUSSALAM', '2010-12-15 01:53:48', NULL, '1'),
(45, 'BULGARIA', '2010-12-15 01:53:48', NULL, '1'),
(46, 'BURUNDI', '2010-12-15 01:53:48', NULL, '1'),
(47, 'BUTÃN', '2010-12-15 01:53:48', NULL, '1'),
(48, 'CABO VERDE', '2010-12-15 01:53:48', NULL, '1'),
(49, 'CAIMÃN, ISLAS', '2010-12-15 01:53:48', NULL, '1'),
(50, 'CAMBOYA', '2010-12-15 01:53:48', NULL, '1'),
(51, 'CAMERÃšN, REPUBLICA UNIDA DEL', '2010-12-15 01:53:48', NULL, '1'),
(52, 'CAMPIONE D TALIA', '2010-12-15 01:53:48', NULL, '1'),
(53, 'CANADÃ', '2010-12-15 01:53:48', NULL, '1'),
(54, 'CANAL (NORMANDAS), ISLAS', '2010-12-15 01:53:48', NULL, '1'),
(55, 'CANTÃ“N Y ENDERBURRY', '2010-12-15 01:53:48', NULL, '1'),
(56, 'SANTA SEDE', '2010-12-15 01:53:48', NULL, '1'),
(57, 'COCOS (KEELING),ISLAS', '2010-12-15 01:53:48', NULL, '1'),
(58, 'COLOMBIA', '2010-12-15 01:53:48', NULL, '1'),
(59, 'COMORAS', '2010-12-15 01:53:48', NULL, '1'),
(60, 'CONGO', '2010-12-15 01:53:48', NULL, '1'),
(61, 'COOK, ISLAS', '2010-12-15 01:53:48', NULL, '1'),
(62, 'COREA (NORTE), REPUBLICA POPULAR DEMOCRATICA DE', '2010-12-15 01:53:48', NULL, '1'),
(63, 'COREA (SUR), REPUBLICA DE', '2010-12-15 01:53:48', NULL, '1'),
(64, 'COSTA DE MARFIL', '2010-12-15 01:53:48', NULL, '1'),
(65, 'COSTA RICA', '2010-12-15 01:53:48', NULL, '1'),
(66, 'CROACIA', '2010-12-15 01:53:48', NULL, '1'),
(67, 'CUBA', '2010-12-15 01:53:48', NULL, '1'),
(68, 'CHAD', '2010-12-15 01:53:48', NULL, '1'),
(69, 'CHECOSLOVAQUIA', '2010-12-15 01:53:48', NULL, '1'),
(70, 'CHILE', '2010-12-15 01:53:48', NULL, '1'),
(71, 'CHINA', '2010-12-15 01:53:48', NULL, '1'),
(72, 'TAIWAN (FORMOSA)', '2010-12-15 01:53:48', NULL, '1'),
(73, 'CHIPRE', '2010-12-15 01:53:48', NULL, '1'),
(74, 'BENIN', '2010-12-15 01:53:48', NULL, '1'),
(75, 'DINAMARCA', '2010-12-15 01:53:48', NULL, '1'),
(76, 'DOMINICA', '2010-12-15 01:53:48', NULL, '1'),
(77, 'ECUADOR', '2010-12-15 01:53:48', NULL, '1'),
(78, 'EGIPTO', '2010-12-15 01:53:48', NULL, '1'),
(79, 'EL SALVADOR', '2010-12-15 01:53:48', NULL, '1'),
(80, 'ERITREA', '2010-12-15 01:53:48', NULL, '1'),
(81, 'EMIRATOS ARABES UNIDOS', '2010-12-15 01:53:48', NULL, '1'),
(82, 'ESPANA', '2010-12-15 01:53:48', NULL, '1'),
(83, 'ESLOVAQUIA', '2010-12-15 01:53:48', NULL, '1'),
(84, 'ESLOVENIA', '2010-12-15 01:53:48', NULL, '1'),
(85, 'ESTADOS UNIDOS', '2010-12-15 01:53:48', NULL, '1'),
(86, 'ESTONIA', '2010-12-15 01:53:48', NULL, '1'),
(87, 'ETIOPIA', '2010-12-15 01:53:48', NULL, '1'),
(88, 'FEROE, ISLAS', '2010-12-15 01:53:48', NULL, '1'),
(89, 'FILIPINAS', '2010-12-15 01:53:48', NULL, '1'),
(90, 'FINLANDIA', '2010-12-15 01:53:48', NULL, '1'),
(91, 'FRANCIA', '2010-12-15 01:53:48', NULL, '1'),
(92, 'GABON', '2010-12-15 01:53:48', NULL, '1'),
(93, 'GAMBIA', '2010-12-15 01:53:48', NULL, '1'),
(94, 'GAZA Y JERICO', '2010-12-15 01:53:48', NULL, '1'),
(95, 'GEORGIA', '2010-12-15 01:53:48', NULL, '1'),
(96, 'GHANA', '2010-12-15 01:53:48', NULL, '1'),
(97, 'GIBRALTAR', '2010-12-15 01:53:48', NULL, '1'),
(98, 'GRANADA', '2010-12-15 01:53:48', NULL, '1'),
(99, 'GRECIA', '2010-12-15 01:53:48', NULL, '1'),
(100, 'GROENLANDIA', '2010-12-15 01:53:48', NULL, '1'),
(101, 'GUADALUPE', '2010-12-15 01:53:48', NULL, '1'),
(102, 'GUAM', '2010-12-15 01:53:48', NULL, '1'),
(103, 'GUATEMALA', '2010-12-15 01:53:48', NULL, '1'),
(104, 'GUAYANA FRANCESA', '2010-12-15 01:53:48', NULL, '1'),
(105, 'GUERNSEY', '2010-12-15 01:53:48', NULL, '1'),
(106, 'GUINEA', '2010-12-15 01:53:48', NULL, '1'),
(107, 'GUINEA ECUATORIAL', '2010-12-15 01:53:48', NULL, '1'),
(108, 'GUINEA-BISSAU', '2010-12-15 01:53:48', NULL, '1'),
(109, 'GUYANA', '2010-12-15 01:53:48', NULL, '1'),
(110, 'HAITI', '2010-12-15 01:53:48', NULL, '1'),
(111, 'HONDURAS', '2010-12-15 01:53:48', NULL, '1'),
(112, 'HONDURAS BRITANICAS', '2010-12-15 01:53:48', NULL, '1'),
(113, 'HONG KONG', '2010-12-15 01:53:48', NULL, '1'),
(114, 'HUNGRIA', '2010-12-15 01:53:48', NULL, '1'),
(115, 'INDIA', '2010-12-15 01:53:48', NULL, '1'),
(116, 'INDONESIA', '2010-12-15 01:53:48', NULL, '1'),
(117, 'IRAK', '2010-12-15 01:53:48', NULL, '1'),
(118, 'IRAN, REPUBLICA ISLAMICA DEL', '2010-12-15 01:53:48', NULL, '1'),
(119, 'IRLANDA (EIRE)', '2010-12-15 01:53:48', NULL, '1'),
(120, 'ISLA AZORES', '2010-12-15 01:53:48', NULL, '1'),
(121, 'ISLA DEL MAN', '2010-12-15 01:53:48', NULL, '1'),
(122, 'ISLANDIA', '2010-12-15 01:53:48', NULL, '1'),
(123, 'ISLAS CANARIAS', '2010-12-15 01:53:48', NULL, '1'),
(124, 'ISLAS DE CHRISTMAS', '2010-12-15 01:53:48', NULL, '1'),
(125, 'ISLAS QESHM', '2010-12-15 01:53:48', NULL, '1'),
(126, 'ISRAEL', '2010-12-15 01:53:48', NULL, '1'),
(127, 'ITALIA', '2010-12-15 01:53:48', NULL, '1'),
(128, 'JAMAICA', '2010-12-15 01:53:48', NULL, '1'),
(129, 'JONSTON, ISLAS', '2010-12-15 01:53:48', NULL, '1'),
(130, 'JAPON', '2010-12-15 01:53:48', NULL, '1'),
(131, 'JERSEY', '2010-12-15 01:53:48', NULL, '1'),
(132, 'JORDANIA', '2010-12-15 01:53:48', NULL, '1'),
(133, 'KAZAJSTAN', '2010-12-15 01:53:48', NULL, '1'),
(134, 'KENIA', '2010-12-15 01:53:48', NULL, '1'),
(135, 'KIRIBATI', '2010-12-15 01:53:48', NULL, '1'),
(136, 'KIRGUIZISTAN', '2010-12-15 01:53:48', NULL, '1'),
(137, 'KUWAIT', '2010-12-15 01:53:48', NULL, '1'),
(138, 'LABUN', '2010-12-15 01:53:48', NULL, '1'),
(139, 'LAOS, REPUBLICA POPULAR DEMOCRATICA DE', '2010-12-15 01:53:48', NULL, '1'),
(140, 'LESOTHO', '2010-12-15 01:53:48', NULL, '1'),
(141, 'LETONIA', '2010-12-15 01:53:48', NULL, '1'),
(142, 'LIBANO', '2010-12-15 01:53:48', NULL, '1'),
(143, 'LIBERIA', '2010-12-15 01:53:48', NULL, '1'),
(144, 'LIBIA', '2010-12-15 01:53:48', NULL, '1'),
(145, 'LIECHTENSTEIN', '2010-12-15 01:53:48', NULL, '1'),
(146, 'LITUANIA', '2010-12-15 01:53:48', NULL, '1'),
(147, 'LUXEMBURGO', '2010-12-15 01:53:48', NULL, '1'),
(148, 'MACAO', '2010-12-15 01:53:48', NULL, '1'),
(149, 'MACEDONIA', '2010-12-15 01:53:48', NULL, '1'),
(150, 'MADAGASCAR', '2010-12-15 01:53:48', NULL, '1'),
(151, 'MADEIRA', '2010-12-15 01:53:48', NULL, '1'),
(152, 'MALAYSIA', '2010-12-15 01:53:48', NULL, '1'),
(153, 'MALAWI', '2010-12-15 01:53:48', NULL, '1'),
(154, 'MALDIVAS', '2010-12-15 01:53:48', NULL, '1'),
(155, 'MALI', '2010-12-15 01:53:48', NULL, '1'),
(156, 'MALTA', '2010-12-15 01:53:48', NULL, '1'),
(157, 'MARIANAS DEL NORTE, ISLAS', '2010-12-15 01:53:48', NULL, '1'),
(158, 'MARSHALL, ISLAS', '2010-12-15 01:53:48', NULL, '1'),
(159, 'MARRUECOS', '2010-12-15 01:53:48', NULL, '1'),
(160, 'MARTINICA', '2010-12-15 01:53:48', NULL, '1'),
(161, 'MAURICIO', '2010-12-15 01:53:48', NULL, '1'),
(162, 'MAURITANIA', '2010-12-15 01:53:48', NULL, '1'),
(163, 'MEXICO', '2010-12-15 01:53:48', NULL, '1'),
(164, 'MICRONESIA, ESTADOS FEDERADOS DE', '2010-12-15 01:53:48', NULL, '1'),
(165, 'MIDWAY ISLAS', '2010-12-15 01:53:48', NULL, '1'),
(166, 'MOLDAVIA', '2010-12-15 01:53:48', NULL, '1'),
(167, 'MONGOLIA', '2010-12-15 01:53:48', NULL, '1'),
(168, 'MONACO', '2010-12-15 01:53:48', NULL, '1'),
(169, 'MONTSERRAT, ISLA', '2010-12-15 01:53:48', NULL, '1'),
(170, 'MOZAMBIQUE', '2010-12-15 01:53:48', NULL, '1'),
(171, 'NAMIBIA', '2010-12-15 01:53:48', NULL, '1'),
(172, 'NAURU', '2010-12-15 01:53:48', NULL, '1'),
(173, 'NAVIDAD (CHRISTMAS), ISLA', '2010-12-15 01:53:48', NULL, '1'),
(174, 'NEPAL', '2010-12-15 01:53:48', NULL, '1'),
(175, 'NICARAGUA', '2010-12-15 01:53:48', NULL, '1'),
(176, 'NIGER', '2010-12-15 01:53:48', NULL, '1'),
(177, 'NIGERIA', '2010-12-15 01:53:48', NULL, '1'),
(178, 'NIUE, ISLA', '2010-12-15 01:53:48', NULL, '1'),
(179, 'NORFOLK, ISLA', '2010-12-15 01:53:48', NULL, '1'),
(180, 'NORUEGA', '2010-12-15 01:53:48', NULL, '1'),
(181, 'NUEVA CALEDONIA', '2010-12-15 01:53:48', NULL, '1'),
(182, 'PAPUASIA NUEVA GUINEA', '2010-12-15 01:53:48', NULL, '1'),
(183, 'NUEVA ZELANDA', '2010-12-15 01:53:48', NULL, '1'),
(184, 'VANUATU', '2010-12-15 01:53:48', NULL, '1'),
(185, 'OMAN', '2010-12-15 01:53:48', NULL, '1'),
(186, 'PACIFICO, ISLAS DEL', '2010-12-15 01:53:48', NULL, '1'),
(187, 'PAISES BAJOS', '2010-12-15 01:53:48', NULL, '1'),
(188, 'PAKISTAN', '2010-12-15 01:53:48', NULL, '1'),
(189, 'PALAU, ISLAS', '2010-12-15 01:53:48', NULL, '1'),
(190, 'TERRITORIO AUTONOMO DE PALESTINA.', '2010-12-15 01:53:48', NULL, '1'),
(191, 'PANAMA', '2010-12-15 01:53:48', NULL, '1'),
(192, 'PARAGUAY', '2010-12-15 01:53:48', NULL, '1'),
(193, 'PERÃš', '2010-12-15 01:53:48', NULL, '1'),
(194, 'PITCAIRN, ISLA', '2010-12-15 01:53:48', NULL, '1'),
(195, 'POLINESIA FRANCESA', '2010-12-15 01:53:48', NULL, '1'),
(196, 'POLONIA', '2010-12-15 01:53:48', NULL, '1'),
(197, 'PORTUGAL', '2010-12-15 01:53:48', NULL, '1'),
(198, 'PUERTO RICO', '2010-12-15 01:53:48', NULL, '1'),
(199, 'QATAR', '2010-12-15 01:53:48', NULL, '1'),
(200, 'REINO UNIDO', '2010-12-15 01:53:48', NULL, '1'),
(201, 'ESCOCIA', '2010-12-15 01:53:48', NULL, '1'),
(202, 'REPUBLICA ARABE UNIDA', '2010-12-15 01:53:48', NULL, '1'),
(203, 'REPUBLICA CENTROAFRICANA', '2010-12-15 01:53:48', NULL, '1'),
(204, 'REPUBLICA CHECA', '2010-12-15 01:53:48', NULL, '1'),
(205, 'REPUBLICA DE SWAZILANDIA', '2010-12-15 01:53:48', NULL, '1'),
(206, 'REPUBLICA DE TUNEZ', '2010-12-15 01:53:48', NULL, '1'),
(207, 'REPUBLICA DOMINICANA', '2010-12-15 01:53:48', NULL, '1'),
(208, 'REUNION', '2010-12-15 01:53:48', NULL, '1'),
(209, 'ZIMBABWE', '2010-12-15 01:53:48', NULL, '1'),
(210, 'RUMANIA', '2010-12-15 01:53:48', NULL, '1'),
(211, 'RUANDA', '2010-12-15 01:53:48', NULL, '1'),
(212, 'RUSIA', '2010-12-15 01:53:48', NULL, '1'),
(213, 'SALOMON, ISLAS', '2010-12-15 01:53:48', NULL, '1'),
(214, 'SAHARA OCCIDENTAL', '2010-12-15 01:53:48', NULL, '1'),
(215, 'SAMOA OCCIDENTAL', '2010-12-15 01:53:48', NULL, '1'),
(216, 'SAMOA NORTEAMERICANA', '2010-12-15 01:53:48', NULL, '1'),
(217, 'SAN CRISTOBAL Y NIEVES', '2010-12-15 01:53:48', NULL, '1'),
(218, 'SAN MARINO', '2010-12-15 01:53:48', NULL, '1'),
(219, 'SAN PEDRO Y MIQUELON', '2010-12-15 01:53:48', NULL, '1'),
(220, 'SAN VICENTE Y LAS GRANADINAS', '2010-12-15 01:53:48', NULL, '1'),
(221, 'SANTA ELENA', '2010-12-15 01:53:48', NULL, '1'),
(222, 'SANTA LUCIA', '2010-12-15 01:53:48', NULL, '1'),
(223, 'SANTO TOME Y PRINCIPE', '2010-12-15 01:53:48', NULL, '1'),
(224, 'SENEGAL', '2010-12-15 01:53:48', NULL, '1'),
(225, 'SEYCHELLES', '2010-12-15 01:53:48', NULL, '1'),
(226, 'SIERRA LEONA', '2010-12-15 01:53:48', NULL, '1'),
(227, 'SINGAPUR', '2010-12-15 01:53:48', NULL, '1'),
(228, 'SIRIA, REPUBLICA ARABE DE', '2010-12-15 01:53:48', NULL, '1'),
(229, 'SOMALIA', '2010-12-15 01:53:48', NULL, '1'),
(230, 'SRI LANKA', '2010-12-15 01:53:48', NULL, '1'),
(231, 'SUDAFRICA, REPUBLICA DE', '2010-12-15 01:53:48', NULL, '1'),
(232, 'SUDAN', '2010-12-15 01:53:48', NULL, '1'),
(233, 'SUECIA', '2010-12-15 01:53:48', NULL, '1'),
(234, 'SUIZA', '2010-12-15 01:53:48', NULL, '1'),
(235, 'SURINAM', '2010-12-15 01:53:48', NULL, '1'),
(236, 'SAWSILANDIA', '2010-12-15 01:53:48', NULL, '1'),
(237, 'TADJIKISTAN', '2010-12-15 01:53:48', NULL, '1'),
(238, 'TAILANDIA', '2010-12-15 01:53:48', NULL, '1'),
(239, 'TANZANIA, REPUBLICA UNIDA DE', '2010-12-15 01:53:48', NULL, '1'),
(240, 'DJIBOUTI', '2010-12-15 01:53:48', NULL, '1'),
(241, 'TERRITORIO ANTARTICO BRITANICO', '2010-12-15 01:53:48', NULL, '1'),
(242, 'TERRITORIO BRITANICO DEL OCEANO INDICO', '2010-12-15 01:53:48', NULL, '1'),
(243, 'TIMOR DEL ESTE', '2010-12-15 01:53:48', NULL, '1'),
(244, 'TOGO', '2010-12-15 01:53:48', NULL, '1'),
(245, 'TOKELAU', '2010-12-15 01:53:48', NULL, '1'),
(246, 'TONGA', '2010-12-15 01:53:48', NULL, '1'),
(247, 'TRINIDAD Y TOBAGO', '2010-12-15 01:53:48', NULL, '1'),
(248, 'TRISTAN DA CUNHA', '2010-12-15 01:53:48', NULL, '1'),
(249, 'TUNICIA', '2010-12-15 01:53:48', NULL, '1'),
(250, 'TURCAS Y CAICOS, ISLAS', '2010-12-15 01:53:48', NULL, '1'),
(251, 'TURKMENISTAN', '2010-12-15 01:53:48', NULL, '1'),
(252, 'TURQUIA', '2010-12-15 01:53:48', NULL, '1'),
(253, 'TUVALU', '2010-12-15 01:53:48', NULL, '1'),
(254, 'UCRANIA', '2010-12-15 01:53:48', NULL, '1'),
(255, 'UGANDA', '2010-12-15 01:53:48', NULL, '1'),
(256, 'URSS', '2010-12-15 01:53:48', NULL, '1'),
(257, 'URUGUAY', '2010-12-15 01:53:48', NULL, '1'),
(258, 'UZBEKISTAN', '2010-12-15 01:53:48', NULL, '1'),
(259, 'VENEZUELA', '2010-12-15 01:53:48', NULL, '1'),
(260, 'VIET NAM', '2010-12-15 01:53:48', NULL, '1'),
(261, 'VIETNAM (DEL NORTE)', '2010-12-15 01:53:48', NULL, '1'),
(262, 'VIRGENES, ISLAS (BRITANICAS)', '2010-12-15 01:53:48', NULL, '1'),
(263, 'VIRGENES, ISLAS (NORTEAMERICANAS)', '2010-12-15 01:53:48', NULL, '1'),
(264, 'FIJI', '2010-12-15 01:53:48', NULL, '1'),
(265, 'WAKE, ISLA', '2010-12-15 01:53:48', NULL, '1'),
(266, 'WALLIS Y FORTUNA, ISLAS', '2010-12-15 01:53:48', NULL, '1'),
(267, 'YEMEN', '2010-12-15 01:53:48', NULL, '1'),
(268, 'YUGOSLAVIA', '2010-12-15 01:53:48', NULL, '1'),
(269, 'ZAIRE', '2010-12-15 01:53:48', NULL, '1'),
(270, 'ZAMBIA', '2010-12-15 01:53:48', NULL, '1'),
(271, 'ZONA DEL CANAL DE PANAMA', '2010-12-15 01:53:48', NULL, '1'),
(272, 'ZONA LIBRE OSTRAVA', '2010-12-15 01:53:48', NULL, '1'),
(273, 'ZONA NEUTRAL (PALESTINA)', '2010-12-15 01:53:48', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_nota`
--

CREATE TABLE `cji_nota` (
  `CRED_Codigo` int(11) NOT NULL,
  `CRED_TipoOperacion` char(1) NOT NULL DEFAULT 'V' COMMENT 'V: venta, C: compra',
  `CRED_TipoDocumento_inicio` char(1) DEFAULT NULL COMMENT 'F: factura, B: boleta, N:comprobante, A: nunguno de los dos',
  `COMPP_Codigo` int(11) NOT NULL,
  `CRED_Serie` char(10) NOT NULL,
  `CRED_Numero` varchar(11) NOT NULL,
  `CLIP_Codigo` int(11) DEFAULT NULL,
  `PROVP_Codigo` int(11) DEFAULT NULL,
  `USUA_Codigo` int(11) NOT NULL,
  `MONED_Codigo` int(11) NOT NULL DEFAULT '1',
  `CRED_subtotal` double(10,2) DEFAULT NULL,
  `CRED_descuento` double(10,2) DEFAULT NULL,
  `CRED_igv` double(10,2) DEFAULT NULL,
  `CRED_total` double(10,2) NOT NULL DEFAULT '0.00',
  `CRED_subtotal_conigv` double(10,2) DEFAULT NULL COMMENT 'Para que pueda ser usado como una boleta',
  `CRED_descuento_conigv` double(10,2) DEFAULT NULL COMMENT 'Para que pueda ser usado como una boleta',
  `CRED_igv100` int(11) NOT NULL DEFAULT '0',
  `CRED_descuento100` int(11) NOT NULL DEFAULT '0',
  `DOCUP_Codigo` int(11) DEFAULT NULL,
  `CRED_Observacion` varchar(250) DEFAULT NULL,
  `CRED_Fecha` date NOT NULL,
  `CRED_Vendedor` int(11) DEFAULT NULL,
  `CRED_TDC` double(10,2) DEFAULT NULL,
  `CRED_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CRED_FechaModificacion` datetime DEFAULT NULL,
  `CRED_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `CRED_TipoNota` char(1) NOT NULL COMMENT 'C: Nota creadiro, D: Nota Debito',
  `CRED_ComproInicio` int(11) DEFAULT NULL,
  `CRED_TipoDocumento_fin` char(1) DEFAULT NULL COMMENT 'F: factura, B: boleta, C:comprobante, N: nunguno de los dos',
  `CRED_ComproFin` int(11) DEFAULT NULL,
  `CRED_Flag` int(11) DEFAULT NULL COMMENT 'Programacion',
  `CRED_NumeroInicio` varchar(200) DEFAULT NULL COMMENT 'Serie y Numero Comp. Inicio',
  `CRED_NumeroFin` varchar(200) DEFAULT NULL COMMENT 'Serie y Numero Comp. Fin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_notadetalle`
--

CREATE TABLE `cji_notadetalle` (
  `CREDET_Codigo` int(11) NOT NULL,
  `CRED_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `CREDET_GenInd` char(1) NOT NULL DEFAULT 'I',
  `UNDMED_Codigo` int(11) DEFAULT NULL,
  `CREDET_Cantidad` int(11) NOT NULL DEFAULT '0',
  `CREDET_Pu` double DEFAULT NULL,
  `CREDET_Subtotal` double DEFAULT NULL,
  `CREDET_Descuento` double DEFAULT NULL,
  `CREDET_Igv` double DEFAULT NULL,
  `CREDET_Total` double NOT NULL DEFAULT '0',
  `CREDET_Pu_ConIgv` double DEFAULT NULL COMMENT 'Para que pueda ser usado como detalle de una boleta',
  `CREDET_Subtotal_ConIgv` double DEFAULT NULL COMMENT 'Para que pueda ser usado como detalle de una boleta',
  `CREDET_Descuento_ConIgv` double DEFAULT NULL COMMENT 'Para que pueda ser usado como detalle de una boleta',
  `CREDET_Igv100` int(11) DEFAULT '0',
  `CREDET_Descuento100` int(11) DEFAULT '0',
  `CREDET_Costo` double DEFAULT NULL,
  `CREDET_Descripcion` varchar(250) DEFAULT NULL,
  `CREDET_Observacion` varchar(250) DEFAULT NULL,
  `CREDET_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREDET_FechaModificacion` datetime DEFAULT NULL,
  `CREDET_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_ocompradetalle`
--

CREATE TABLE `cji_ocompradetalle` (
  `OCOMDEP_Codigo` int(11) NOT NULL,
  `OCOMP_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `OCOMDEC_GenInd` char(1) NOT NULL,
  `UNDMED_Codigo` int(11) DEFAULT NULL,
  `OCOMDEC_Pu` double NOT NULL DEFAULT '0',
  `OCOMDEC_Igv100` int(11) NOT NULL DEFAULT '0',
  `OCOMDEC_Descuento100` int(11) NOT NULL DEFAULT '0',
  `OCOMDEC_Cantidad` double DEFAULT '0',
  `OCOMDEC_Subtotal` double NOT NULL DEFAULT '0',
  `OCOMDEC_Descuento` double NOT NULL DEFAULT '0',
  `OCOMDEC_Descuento2` double NOT NULL DEFAULT '0',
  `OCOMDEC_Igv` double NOT NULL DEFAULT '0',
  `OCOMDEC_Total` double NOT NULL DEFAULT '0',
  `OCOMDEC_Pu_ConIgv` double NOT NULL,
  `OCOMDEC_Costo` double DEFAULT NULL,
  `OCOMDEC_Descripcion` varchar(250) DEFAULT NULL,
  `OCOMDEC_Observacion` varchar(250) DEFAULT NULL,
  `OCOMDEC_FechaModificacion` datetime DEFAULT NULL,
  `OCOMDEC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `OCOMDEC_FlagIngreso` char(1) NOT NULL DEFAULT '0',
  `OCOMDEC_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_ordencompra`
--

CREATE TABLE `cji_ordencompra` (
  `OCOMP_Codigo` int(11) NOT NULL,
  `OCOMC_TipoOperacion` char(1) NOT NULL DEFAULT 'C' COMMENT 'V: venta, C: compra',
  `PRESUP_Codigo` int(11) DEFAULT NULL,
  `COTIP_Codigo` int(11) DEFAULT NULL,
  `PEDIP_Codigo` int(11) DEFAULT NULL,
  `OCOMC_Serie` char(3) NOT NULL,
  `OCOMC_Numero` int(11) NOT NULL,
  `OCOMC_CodigoUsuario` varchar(50) DEFAULT NULL,
  `OCOMC_descuento100` int(11) NOT NULL DEFAULT '0',
  `OCOMC_igv100` int(11) NOT NULL DEFAULT '0',
  `OCOMC_percepcion100` double NOT NULL,
  `CLIP_Codigo` int(11) DEFAULT NULL,
  `PROVP_Codigo` int(11) DEFAULT NULL,
  `USUA_Codigo` int(11) NOT NULL,
  `CENCOSP_Codigo` int(11) NOT NULL,
  `MONED_Codigo` int(11) NOT NULL DEFAULT '1',
  `FORPAP_Codigo` int(11) DEFAULT NULL,
  `ALMAP_Codigo` int(11) DEFAULT NULL,
  `OCOMC_subtotal` double(10,2) NOT NULL DEFAULT '0.00',
  `OCOMC_descuento` double(10,2) NOT NULL DEFAULT '0.00',
  `OCOMC_igv` double(10,2) NOT NULL DEFAULT '0.00',
  `OCOMC_percepcion` double(10,2) NOT NULL DEFAULT '0.00',
  `OCOMC_total` double(10,2) NOT NULL DEFAULT '0.00',
  `OCOMC_CtaCteSoles` varchar(50) DEFAULT NULL,
  `OCOMC_CtaCteDolares` varchar(50) DEFAULT NULL,
  `OCOMC_Observacion` varchar(250) DEFAULT NULL,
  `OCOMC_EnvioDireccion` varchar(250) DEFAULT NULL,
  `OCOMC_FactDireccion` varchar(250) DEFAULT NULL,
  `OCOMC_PersonaAutorizada` varchar(250) DEFAULT NULL,
  `OCOMC_Fecha` date NOT NULL,
  `OCOMC_FechaEntrega` date DEFAULT NULL,
  `OCOMC_NumeroFactura` int(11) DEFAULT NULL,
  `OCOMC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `OCOMC_FechaModificacion` datetime DEFAULT NULL,
  `OCOMC_FlagIngreso` char(1) NOT NULL DEFAULT '0',
  `OCOMC_Personal` int(11) DEFAULT NULL,
  `OCOMC_MiPersonal` int(11) DEFAULT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `OCOMC_FlagAprobado` char(1) NOT NULL DEFAULT '0' COMMENT '0: No evaluado, 1: aprobado, 2: desaprobado',
  `OCOMC_FlagMueveStock` char(1) NOT NULL DEFAULT '0',
  `GUIASAP_Codigo` int(11) DEFAULT NULL,
  `OCOMC_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `OCOMC_FlagTerminado` char(1) NOT NULL DEFAULT '0' COMMENT '0 = NO TERMINADO, 1=TERMINADO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_pago`
--

CREATE TABLE `cji_pago` (
  `PAGP_Codigo` int(11) NOT NULL,
  `PAGC_TipoCuenta` int(11) NOT NULL COMMENT '1: Cuenta por cobrar, 2: Cuenta por pagar',
  `PAGC_FechaOper` date NOT NULL,
  `CLIP_Codigo` int(11) DEFAULT NULL,
  `PROVP_Codigo` int(11) DEFAULT NULL,
  `PAGC_TDC` double(10,2) NOT NULL,
  `PAGC_Monto` double NOT NULL,
  `MONED_Codigo` int(11) NOT NULL,
  `PAGC_FormaPago` int(11) NOT NULL,
  `PAGC_DepoNro` varchar(50) DEFAULT NULL,
  `PAGC_DepoCta` varchar(50) DEFAULT NULL,
  `CHEP_Codigo` int(11) DEFAULT NULL,
  `PAGC_Factura` int(11) DEFAULT NULL,
  `PAGC_NotaCredito` int(11) DEFAULT NULL,
  `PAGC_DescObs` text,
  `PAGC_Saldo` double(10,2) NOT NULL DEFAULT '0.00',
  `PAGC_Obs` text,
  `COMPP_Codigo` int(11) NOT NULL,
  `PAGC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PAGC_FechaModificacion` datetime DEFAULT NULL,
  `PAGC_FlagEstado` varchar(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_pago`
--

INSERT INTO `cji_pago` (`PAGP_Codigo`, `PAGC_TipoCuenta`, `PAGC_FechaOper`, `CLIP_Codigo`, `PROVP_Codigo`, `PAGC_TDC`, `PAGC_Monto`, `MONED_Codigo`, `PAGC_FormaPago`, `PAGC_DepoNro`, `PAGC_DepoCta`, `CHEP_Codigo`, `PAGC_Factura`, `PAGC_NotaCredito`, `PAGC_DescObs`, `PAGC_Saldo`, `PAGC_Obs`, `COMPP_Codigo`, `PAGC_FechaRegistro`, `PAGC_FechaModificacion`, `PAGC_FlagEstado`) VALUES
(5, 2, '2017-01-23', NULL, 12, 6.00, 9, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'SALIDA GENERADAAUTOMATICAMENTE POR EL PAGO AL CONTADO', 1, '2017-01-23 21:13:41', NULL, '1'),
(6, 1, '2017-01-23', 4, NULL, 6.00, 9, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'INGRESO GENERADOAUTOMATICAMENTE POR EL PAGO AL CONTADO', 1, '2017-01-23 21:17:14', '2017-01-23 17:49:09', '1'),
(7, 2, '2017-01-23', NULL, 12, 6.00, 36, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'SALIDA GENERADAAUTOMATICAMENTE POR EL PAGO AL CONTADO', 1, '2017-01-23 21:18:26', NULL, '1'),
(8, 2, '2017-01-23', NULL, 12, 6.00, 54, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'SALIDA GENERADAAUTOMATICAMENTE POR EL PAGO AL CONTADO', 1, '2017-01-23 21:20:06', '2017-01-23 16:20:21', '1'),
(9, 1, '2017-01-23', 4, NULL, 6.00, 63, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'INGRESO GENERADOAUTOMATICAMENTE POR EL PAGO AL CONTADO', 1, '2017-01-23 21:33:36', '2017-01-23 17:47:54', '1'),
(10, 1, '2017-01-23', 4, NULL, 6.00, 12, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'INGRESO GENERADOAUTOMATICAMENTE POR EL PAGO AL CONTADO', 1, '2017-01-23 21:48:03', '2017-01-23 17:47:45', '1'),
(11, 1, '2017-01-23', 4, NULL, 6.00, 6, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'INGRESO GENERADOAUTOMATICAMENTE POR EL PAGO AL CONTADO', 1, '2017-01-23 22:37:01', NULL, '1'),
(12, 1, '2017-01-24', 4, NULL, 5.00, 12, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'INGRESO GENERADOAUTOMATICAMENTE POR EL PAGO AL CONTADO', 1, '2017-01-24 15:34:16', NULL, '1'),
(13, 2, '2017-01-24', NULL, 12, 5.00, 796, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'SALIDA GENERADAAUTOMATICAMENTE POR EL PAGO AL CONTADO', 1, '2017-01-24 15:34:54', NULL, '1'),
(14, 1, '2017-01-24', 4, NULL, 5.00, 664, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'INGRESO GENERADOAUTOMATICAMENTE POR EL PAGO AL CONTADO', 1, '2017-01-24 15:36:22', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_pedido`
--

CREATE TABLE `cji_pedido` (
  `PEDIP_Codigo` int(11) NOT NULL,
  `PEDIC_Numero` int(11) DEFAULT NULL,
  `CENCOST_Codigo` int(11) DEFAULT NULL,
  `USUA_Codigo` int(11) DEFAULT NULL,
  `USUA_Responsable` int(11) DEFAULT NULL,
  `PEDIC_Observacion` varchar(250) DEFAULT NULL,
  `PEDIC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PEDIC_FechaModificacion` datetime DEFAULT NULL,
  `PEDIC_FlagCotizado` char(1) DEFAULT '0',
  `PEDIC_FlagCompra` char(1) DEFAULT '0',
  `PEDIC_FlagIngreso` char(1) DEFAULT '0',
  `COMPP_Codigo` int(11) NOT NULL,
  `PEDIC_FlagEstado` char(1) DEFAULT '1',
  `PEDIC_Tipo` char(1) NOT NULL DEFAULT 'I',
  `DOCUP_Codigo` int(11) NOT NULL,
  `PEDIC_NumRefe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_pedidodetalle`
--

CREATE TABLE `cji_pedidodetalle` (
  `PEDIDETP_Codigo` int(11) NOT NULL,
  `PEDIP_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `UNDMED_Codigo` int(11) NOT NULL,
  `PEDIDETC_Cantidad` double DEFAULT NULL,
  `PEDIDETC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PEDIDETC_FechaModificacion` datetime DEFAULT NULL,
  `PEDIDETC_Observacion` varchar(250) DEFAULT NULL,
  `PEDIDETC_FlagCotizado` char(1) DEFAULT '0',
  `PEDIDETC_FlagCompra` char(1) DEFAULT '0',
  `PEDIDETC_FlagIngreso` char(1) DEFAULT '0',
  `PEDIDETC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_permiso`
--

CREATE TABLE `cji_permiso` (
  `PERM_Codigo` int(11) NOT NULL,
  `ROL_Codigo` int(11) NOT NULL,
  `MENU_Codigo` int(11) NOT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `PERM_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_permiso`
--

INSERT INTO `cji_permiso` (`PERM_Codigo`, `ROL_Codigo`, `MENU_Codigo`, `COMPP_Codigo`, `PERM_FlagEstado`) VALUES
(103, 4, 10, 1, '1'),
(104, 4, 2, 1, '1'),
(105, 4, 11, 1, '1'),
(106, 4, 47, 1, '1'),
(107, 4, 48, 1, '1'),
(108, 4, 87, 1, '1'),
(109, 4, 12, 1, '1'),
(110, 4, 3, 1, '1'),
(111, 4, 13, 1, '1'),
(112, 4, 14, 1, '1'),
(113, 4, 15, 1, '1'),
(114, 4, 37, 1, '1'),
(115, 4, 39, 1, '1'),
(116, 4, 40, 1, '1'),
(117, 4, 64, 1, '1'),
(118, 4, 65, 1, '1'),
(119, 4, 66, 1, '1'),
(120, 4, 71, 1, '1'),
(121, 4, 74, 1, '1'),
(122, 4, 76, 1, '1'),
(123, 4, 78, 1, '1'),
(124, 4, 79, 1, '1'),
(125, 4, 80, 1, '1'),
(126, 4, 81, 1, '1'),
(127, 4, 90, 1, '1'),
(128, 4, 16, 1, '1'),
(129, 4, 4, 1, '1'),
(130, 4, 17, 1, '1'),
(131, 4, 18, 1, '1'),
(132, 4, 52, 1, '1'),
(133, 4, 53, 1, '1'),
(134, 4, 57, 1, '1'),
(135, 4, 60, 1, '1'),
(136, 4, 82, 1, '1'),
(137, 4, 96, 1, '1'),
(138, 4, 98, 1, '1'),
(139, 4, 19, 1, '1'),
(140, 4, 5, 1, '1'),
(141, 4, 20, 1, '1'),
(142, 4, 38, 1, '1'),
(143, 4, 54, 1, '1'),
(144, 4, 55, 1, '1'),
(145, 4, 56, 1, '1'),
(146, 4, 58, 1, '1'),
(147, 4, 59, 1, '1'),
(148, 4, 61, 1, '1'),
(149, 4, 62, 1, '1'),
(150, 4, 63, 1, '1'),
(151, 4, 83, 1, '1'),
(152, 4, 97, 1, '1'),
(153, 4, 99, 1, '1'),
(154, 4, 21, 1, '1'),
(155, 4, 6, 1, '1'),
(156, 4, 22, 1, '1'),
(157, 4, 23, 1, '1'),
(158, 4, 24, 1, '1'),
(159, 4, 50, 1, '1'),
(160, 4, 72, 1, '1'),
(161, 4, 101, 1, '1'),
(162, 4, 103, 1, '1'),
(163, 4, 25, 1, '1'),
(164, 4, 7, 1, '1'),
(165, 4, 26, 1, '1'),
(166, 4, 27, 1, '1'),
(167, 4, 28, 1, '1'),
(168, 4, 29, 1, '1'),
(169, 4, 30, 1, '1'),
(170, 4, 31, 1, '1'),
(171, 4, 32, 1, '1'),
(172, 4, 33, 1, '1'),
(173, 4, 34, 1, '1'),
(174, 4, 35, 1, '1'),
(175, 4, 46, 1, '1'),
(176, 4, 49, 1, '1'),
(177, 4, 51, 1, '1'),
(178, 4, 84, 1, '1'),
(179, 4, 100, 1, '1'),
(180, 4, 102, 1, '1'),
(181, 4, 104, 1, '1'),
(182, 4, 36, 1, '1'),
(183, 4, 8, 1, '1'),
(184, 4, 42, 1, '1'),
(185, 4, 9, 1, '1'),
(186, 4, 43, 1, '1'),
(187, 4, 44, 1, '1'),
(188, 4, 45, 1, '1'),
(189, 4, 67, 1, '1'),
(190, 4, 68, 1, '1'),
(191, 4, 69, 1, '1'),
(192, 4, 70, 1, '1'),
(193, 4, 73, 1, '1'),
(194, 4, 75, 1, '1'),
(195, 4, 77, 1, '1'),
(196, 4, 85, 1, '1'),
(197, 4, 86, 1, '1'),
(198, 4, 88, 1, '1'),
(199, 4, 89, 1, '1'),
(200, 4, 94, 1, '1'),
(201, 4, 93, 1, '1'),
(202, 4, 95, 1, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_persona`
--

CREATE TABLE `cji_persona` (
  `PERSP_Codigo` int(11) NOT NULL,
  `UBIGP_LugarNacimiento` char(6) NOT NULL,
  `UBIGP_Domicilio` char(6) NOT NULL,
  `ESTCP_EstadoCivil` int(11) DEFAULT NULL,
  `NACP_Nacionalidad` int(11) NOT NULL,
  `PERSC_TipoDocIdentidad` int(11) DEFAULT NULL,
  `PERSC_Nombre` varchar(150) DEFAULT NULL,
  `PERSC_ApellidoPaterno` varchar(150) DEFAULT NULL,
  `PERSC_ApellidoMaterno` varchar(150) DEFAULT NULL,
  `PERSC_Ruc` varchar(11) DEFAULT NULL,
  `PERSC_NumeroDocIdentidad` varchar(50) DEFAULT NULL,
  `PERSC_FechaNac` date NOT NULL,
  `PERSC_Direccion` varchar(250) DEFAULT NULL,
  `PERSC_Telefono` varchar(20) DEFAULT NULL,
  `PERSC_Movil` varchar(20) DEFAULT NULL,
  `PERSC_Fax` varchar(20) DEFAULT NULL,
  `PERSC_Email` varchar(200) DEFAULT NULL,
  `PERSC_Domicilio` varchar(250) DEFAULT NULL,
  `PERSC_Web` varchar(250) DEFAULT NULL,
  `PERSC_Sexo` char(2) DEFAULT NULL,
  `PERSC_CtaCteSoles` varchar(50) DEFAULT NULL,
  `PERSC_CtaCteDolares` varchar(50) DEFAULT NULL,
  `PERSC_FechaRegistro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `PERSC_FechaModificacion` datetime DEFAULT NULL,
  `PERSC_FlagEstado` char(1) DEFAULT '1',
  `PERSC_FechaNacz` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cji_persona`
--

INSERT INTO `cji_persona` (`PERSP_Codigo`, `UBIGP_LugarNacimiento`, `UBIGP_Domicilio`, `ESTCP_EstadoCivil`, `NACP_Nacionalidad`, `PERSC_TipoDocIdentidad`, `PERSC_Nombre`, `PERSC_ApellidoPaterno`, `PERSC_ApellidoMaterno`, `PERSC_Ruc`, `PERSC_NumeroDocIdentidad`, `PERSC_FechaNac`, `PERSC_Direccion`, `PERSC_Telefono`, `PERSC_Movil`, `PERSC_Fax`, `PERSC_Email`, `PERSC_Domicilio`, `PERSC_Web`, `PERSC_Sexo`, `PERSC_CtaCteSoles`, `PERSC_CtaCteDolares`, `PERSC_FechaRegistro`, `PERSC_FechaModificacion`, `PERSC_FlagEstado`, `PERSC_FechaNacz`) VALUES
(1, '010000', '010100', 1, 3, 1, 'PERSONA PRINCIPAL', NULL, NULL, NULL, NULL, '0000-00-00', NULL, NULL, NULL, NULL, 'irrsac@ventas.com', NULL, NULL, NULL, NULL, NULL, '2013-03-21 08:20:56', NULL, '1', '0000-00-00'),
(2, '010000', '010116', 1, 3, 1, 'EDSON', 'ORTIZ', 'RAMIREZ', '12345678910', '88888888', '0000-00-00', 'JR.LAS RIMARINAS 638', '', '', '', '', 'JR.LAS RIMARINAS 638', '', '0', NULL, NULL, '2013-03-21 03:20:56', NULL, '0', '0000-00-00'),
(15, '150104', '150100', 0, 193, 1, 'JUAN PEREZ', 'PEREZ', 'MAYTA', '', '75675685', '0000-00-00', 'GG GG ', '6564456456', '', '', '', 'GG GG ', '', '0', NULL, NULL, '2017-01-23 22:33:39', NULL, '1', '2017-01-23'),
(16, '150104', '150108', 4, 174, 1, 'CLIENTE JURID', 'APELLI1', 'APELID2', '', '77777777', '0000-00-00', 'LIEMA D', '', '', '', '', 'LIEMA D', '', '0', NULL, NULL, '2017-01-24 17:00:32', NULL, '1', '0000-00-00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_plantilla`
--

CREATE TABLE `cji_plantilla` (
  `PLANT_Codigo` int(11) NOT NULL,
  `ATRIB_Codigo` int(11) DEFAULT NULL,
  `TIPPROD_Codigo` int(11) DEFAULT NULL,
  `PRODTIP_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PRODTIP_FechaModificacion` datetime DEFAULT NULL,
  `PLANT_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_presupuesto`
--

CREATE TABLE `cji_presupuesto` (
  `PRESUP_Codigo` int(11) NOT NULL,
  `PRESUC_TipoDocumento` char(1) NOT NULL DEFAULT 'F',
  `COMPP_Codigo` int(11) NOT NULL DEFAULT '0',
  `PRESUC_Serie` varchar(10) DEFAULT '003',
  `PRESUC_Numero` int(11) DEFAULT NULL,
  `PRESUC_CodigoUsuario` varchar(50) DEFAULT NULL,
  `CLIP_Codigo` int(11) DEFAULT NULL,
  `PRESUC_NombreAuxiliar` varchar(25) DEFAULT 'CLIENTE',
  `USUA_Codigo` int(11) NOT NULL,
  `MONED_Codigo` int(11) NOT NULL DEFAULT '1',
  `FORPAP_Codigo` int(11) DEFAULT NULL,
  `PRESUC_subtotal` double(10,2) DEFAULT NULL,
  `PRESUC_descuento` double(10,2) DEFAULT NULL,
  `PRESUC_igv` double(10,2) DEFAULT NULL,
  `PRESUC_total` double(10,2) NOT NULL DEFAULT '0.00',
  `PRESUC_subtotal_conigv` double(10,2) DEFAULT NULL COMMENT 'Para que pueda ser usado como una boleta',
  `PRESUC_descuento_conigv` double(10,2) DEFAULT NULL COMMENT 'Para que pueda ser usado como una boleta',
  `PRESUC_igv100` int(11) NOT NULL DEFAULT '0',
  `PRESUC_descuento100` int(11) NOT NULL DEFAULT '0',
  `PRESUC_Observacion` varchar(250) DEFAULT NULL,
  `PERSP_Codigo` int(11) DEFAULT NULL,
  `AREAP_Codigo` int(11) DEFAULT NULL,
  `PRESUC_VendedorPersona` int(11) DEFAULT NULL,
  `PRESUC_VenedorArea` int(11) DEFAULT NULL,
  `PRESUC_LugarEntrega` varchar(250) DEFAULT NULL,
  `PRESUC_TiempoEntrega` varchar(100) DEFAULT NULL,
  `PRESUC_Garantia` varchar(100) DEFAULT NULL,
  `PRESUC_Validez` varchar(100) DEFAULT NULL,
  `PRESUC_ModoImpresion` char(1) NOT NULL DEFAULT '1',
  `PRESUC_Fecha` date NOT NULL,
  `PRESUC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PRESUC_FechaModificacion` datetime DEFAULT NULL,
  `PRESUC_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `CPC_TipoOperacion` char(1) NOT NULL DEFAULT 'P' COMMENT 'P: Presupuesto, C : Cotizacion',
  `PEDIP_Codigo` int(11) DEFAULT NULL,
  `PROVP_Codigo` int(11) DEFAULT NULL,
  `PRESUP_Seleccion` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_presupuestodetalle`
--

CREATE TABLE `cji_presupuestodetalle` (
  `PRESDEP_Codigo` int(11) NOT NULL,
  `PRESUP_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `UNDMED_Codigo` int(11) DEFAULT NULL,
  `PRESDEC_Cantidad` double DEFAULT '0',
  `PRESDEC_Pu` double DEFAULT NULL,
  `PRESDEC_Subtotal` double DEFAULT NULL,
  `PRESDEC_Descuento` double DEFAULT NULL,
  `PRESDEC_Igv` double DEFAULT NULL,
  `PRESDEC_Total` double NOT NULL DEFAULT '0',
  `PRESDEC_Pu_ConIgv` double NOT NULL DEFAULT '0' COMMENT 'Para que pueda ser usado como detalle de una boleta',
  `PRESDEC_Subtotal_ConIgv` double DEFAULT NULL COMMENT 'Para que pueda ser usado como detalle de una boleta',
  `PRESDEC_Descuento_ConIgv` double DEFAULT NULL COMMENT 'Para que pueda ser usado como detalle de una boleta',
  `PRESDEC_Igv100` int(11) DEFAULT '0',
  `PRESDEC_Descuento100` int(11) DEFAULT '0',
  `PRESDEC_Descripcion` varchar(250) DEFAULT NULL,
  `PRESDEC_Observacion` varchar(250) DEFAULT NULL,
  `PRESDEC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PRESDEC_FechaModificacion` datetime DEFAULT NULL,
  `PRESDEC_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_procedencia`
--

CREATE TABLE `cji_procedencia` (
  `PROP_Codigo` int(11) NOT NULL,
  `PROC_Descripcion` varchar(50) DEFAULT NULL,
  `PROC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PROC_FechaModificacion` datetime DEFAULT NULL,
  `PROC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_producto`
--

CREATE TABLE `cji_producto` (
  `PROD_Codigo` int(11) NOT NULL,
  `PROD_FlagBienServicio` char(1) NOT NULL DEFAULT 'B' COMMENT 'B: Bien, S: Servicio',
  `FAMI_Codigo` int(11) DEFAULT NULL,
  `TIPPROD_Codigo` int(11) DEFAULT NULL,
  `MARCP_Codigo` int(11) DEFAULT NULL,
  `LINP_Codigo` int(11) DEFAULT NULL,
  `FABRIP_Codigo` int(11) DEFAULT NULL,
  `PROD_PadreCodigo` int(11) DEFAULT NULL,
  `PROD_Nombre` varchar(300) DEFAULT NULL,
  `PROD_NombreCorto` varchar(300) DEFAULT NULL,
  `PROD_DescripcionBreve` varchar(200) DEFAULT NULL,
  `PROD_EspecificacionPDF` varchar(100) DEFAULT NULL,
  `PROD_Comentario` text,
  `PROD_Stock` double DEFAULT '0',
  `PROD_StockMinimo` double NOT NULL DEFAULT '0',
  `PROD_StockMaximo` double NOT NULL DEFAULT '0',
  `PROD_CodigoInterno` varchar(100) DEFAULT NULL,
  `PROD_CodigoUsuario` varchar(50) DEFAULT NULL,
  `PROD_Imagen` varchar(100) DEFAULT NULL,
  `PROD_CostoPromedio` double DEFAULT '0',
  `PROD_UltimoCosto` double DEFAULT '0',
  `PROD_Modelo` varchar(150) DEFAULT NULL,
  `PROD_Presentacion` varchar(150) DEFAULT NULL,
  `PROD_GenericoIndividual` char(1) DEFAULT NULL COMMENT 'G: producto de tipo genérico  (no va a tener número de serie), I: producto de tipo individual (va a tener número de serie)',
  `PROD_FechaUltimaCompra` datetime DEFAULT NULL,
  `PROD_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PROD_FechaModificacion` datetime DEFAULT NULL,
  `PROD_FlagActivo` char(1) DEFAULT '1',
  `PROD_FlagEstado` char(1) DEFAULT '1',
  `PROP_Codigo` int(11) DEFAULT NULL,
  `PROD_CodigoOriginal` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_producto`
--

INSERT INTO `cji_producto` (`PROD_Codigo`, `PROD_FlagBienServicio`, `FAMI_Codigo`, `TIPPROD_Codigo`, `MARCP_Codigo`, `LINP_Codigo`, `FABRIP_Codigo`, `PROD_PadreCodigo`, `PROD_Nombre`, `PROD_NombreCorto`, `PROD_DescripcionBreve`, `PROD_EspecificacionPDF`, `PROD_Comentario`, `PROD_Stock`, `PROD_StockMinimo`, `PROD_StockMaximo`, `PROD_CodigoInterno`, `PROD_CodigoUsuario`, `PROD_Imagen`, `PROD_CostoPromedio`, `PROD_UltimoCosto`, `PROD_Modelo`, `PROD_Presentacion`, `PROD_GenericoIndividual`, `PROD_FechaUltimaCompra`, `PROD_FechaRegistro`, `PROD_FechaModificacion`, `PROD_FlagActivo`, `PROD_FlagEstado`, `PROP_Codigo`, `PROD_CodigoOriginal`) VALUES
(3, 'B', 28, NULL, 7, NULL, NULL, NULL, 'CELULAR NUEVO', 'CELULAR NUEVO', NULL, '', NULL, 6, 0, 0, '001.001', '1', '', 0, 166, '', NULL, 'I', NULL, '2017-01-23 20:06:09', '2017-01-24 10:36:23', '1', '1', NULL, ''),
(4, 'B', 28, NULL, 7, NULL, NULL, NULL, 'CELULAR NUEVO12_DOS', 'CELULAR NUEVO12_DOS', NULL, '', NULL, 6, 0, 0, '001.002', '2', '', 0, 12, '', NULL, 'I', NULL, '2017-01-23 20:06:40', '2017-01-24 10:34:16', '1', '1', NULL, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_productoatributo`
--

CREATE TABLE `cji_productoatributo` (
  `PRODATRIB_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `ATRIB_Codigo` int(11) NOT NULL,
  `PRODATRIB_Numerico` double DEFAULT NULL,
  `PRODATRIB_Date` datetime DEFAULT NULL,
  `PRODATRIB_String` varchar(250) DEFAULT NULL,
  `PRODATRIB_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PRODATRIB_FechaModificacion` datetime DEFAULT NULL,
  `PRODATRIB_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_productocompania`
--

CREATE TABLE `cji_productocompania` (
  `PROD_Codigo` int(11) DEFAULT NULL,
  `COMPP_Codigo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cji_productocompania`
--

INSERT INTO `cji_productocompania` (`PROD_Codigo`, `COMPP_Codigo`) VALUES
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(4, 1),
(4, 2),
(4, 3),
(4, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_productoprecio`
--

CREATE TABLE `cji_productoprecio` (
  `PRODPREP_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `TIPCLIP_Codigo` int(11) DEFAULT '0',
  `EESTABP_Codigo` int(11) DEFAULT '0',
  `MONED_Codigo` int(11) DEFAULT NULL,
  `PRODUNIP_Codigo` int(11) DEFAULT NULL,
  `PRODPREC_PorcGanancia` double DEFAULT NULL,
  `PRODPREC_Precio` double DEFAULT NULL,
  `PRODPREC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PRODPREC_FechaModificacion` datetime DEFAULT NULL,
  `PRODPREC_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_productoproveedor`
--

CREATE TABLE `cji_productoproveedor` (
  `PRODPROVP_Codigo` int(11) NOT NULL,
  `PROVP_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `PRODPROVC_FechaRegistro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `PRODPROVC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_productopublicacion`
--

CREATE TABLE `cji_productopublicacion` (
  `PRODPUBP_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `CATPUBP_Codigo` int(11) NOT NULL,
  `PRODPUBC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PRODPUBC_FechaModificacion` datetime DEFAULT NULL,
  `PRODPUBC_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `CATE_Codigo` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_productounidad`
--

CREATE TABLE `cji_productounidad` (
  `PRODUNIP_Codigo` int(11) NOT NULL,
  `UNDMED_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `PRODUNIC_Factor` varchar(250) DEFAULT NULL,
  `PRODUNIC_flagPrincipal` char(1) DEFAULT '0',
  `PRODUNIC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PRODUNIC_FechaModificacion` datetime DEFAULT NULL,
  `PRODUNIC_flagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_productounidad`
--

INSERT INTO `cji_productounidad` (`PRODUNIP_Codigo`, `UNDMED_Codigo`, `PROD_Codigo`, `PRODUNIC_Factor`, `PRODUNIC_flagPrincipal`, `PRODUNIC_FechaRegistro`, `PRODUNIC_FechaModificacion`, `PRODUNIC_flagEstado`) VALUES
(3, 4, 3, '1', '1', '2017-01-23 20:06:09', NULL, '1'),
(4, 4, 4, '1', '1', '2017-01-23 20:06:40', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_proveedor`
--

CREATE TABLE `cji_proveedor` (
  `PROVP_Codigo` int(11) NOT NULL,
  `PERSP_Codigo` int(11) NOT NULL,
  `EMPRP_Codigo` int(11) NOT NULL,
  `PROVC_FechaRegistro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `PROVC_FechaModificacion` datetime DEFAULT NULL,
  `PROVC_TipoPersona` char(1) DEFAULT NULL COMMENT '0::Persona Natural, 1 :Persona Juridica',
  `PROVC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cji_proveedor`
--

INSERT INTO `cji_proveedor` (`PROVP_Codigo`, `PERSP_Codigo`, `EMPRP_Codigo`, `PROVC_FechaRegistro`, `PROVC_FechaModificacion`, `PROVC_TipoPersona`, `PROVC_FlagEstado`) VALUES
(12, 0, 207, '2017-01-23 21:12:49', NULL, '1', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_proveedorcompania`
--

CREATE TABLE `cji_proveedorcompania` (
  `PROVP_Codigo` int(11) NOT NULL,
  `COMPP_Codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_proveedorcompania`
--

INSERT INTO `cji_proveedorcompania` (`PROVP_Codigo`, `COMPP_Codigo`) VALUES
(12, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_proveedormarca`
--

CREATE TABLE `cji_proveedormarca` (
  `EMPMARP_Codigo` int(11) NOT NULL,
  `EMPRP_Codigo` int(11) NOT NULL,
  `MARCP_Codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_proyecto`
--

CREATE TABLE `cji_proyecto` (
  `PROYP_Codigo` int(11) NOT NULL,
  `PROYC_Nombre` varchar(50) NOT NULL,
  `PROYC_Descripcion` text,
  `PROYC_FechaInicio` date DEFAULT NULL,
  `PROYC_FechaFin` date DEFAULT NULL,
  `DIREP_Codigo` int(11) DEFAULT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `PROYC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `PROYC_FechaModificacion` datetime DEFAULT NULL,
  `PROYC_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `PROYC_CodigoUsuario` int(11) NOT NULL,
  `EMPRP_Codigo` int(11) NOT NULL,
  `DIRECC_Codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_recepcionproveedor`
--

CREATE TABLE `cji_recepcionproveedor` (
  `RECEPRO_Codigo` int(11) NOT NULL,
  `GARAN_Codigo` int(11) DEFAULT NULL,
  `EMPRP_Codigo` int(11) DEFAULT NULL,
  `COMPP_Codigo` int(11) DEFAULT NULL,
  `PROVP_Codigo` int(11) DEFAULT NULL,
  `RECEPRO_Descripcion` varchar(250) DEFAULT NULL,
  `RECEPRO_Observacion` varchar(350) DEFAULT NULL,
  `RECEPRO_TipoSolucion` varchar(150) DEFAULT NULL,
  `RECEPRO_CodigoProducto` varchar(150) DEFAULT NULL,
  `RECEPRO_NombreProducto` varchar(150) DEFAULT NULL,
  `RECEPRO_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `RECEPRO_FechaModificacion` datetime DEFAULT NULL,
  `RECEPRO_FlagEstado` varchar(1) DEFAULT '1',
  `RECEPRO_NumeroCredito` int(30) NOT NULL,
  `RECEPRO_SerieCredito` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_reponsblmoviminto`
--

CREATE TABLE `cji_reponsblmoviminto` (
  `RESPNMOV_Codigo` int(11) NOT NULL,
  `DIREP_Codigo` varchar(200) NOT NULL,
  `CLIP_Codigo` int(11) NOT NULL,
  `PROVP_Codigo` int(11) NOT NULL,
  `CAJA_Codigo` int(11) NOT NULL,
  `RESPNMOV_TipBenefi` char(1) NOT NULL COMMENT 'GIRADOR: G ; BENEFICIARIO : B',
  `RESPNMOV_FechaIngreso` datetime NOT NULL,
  `RESPNMOV_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `RESPNMOV_FechaModificacion` datetime NOT NULL,
  `RESPNMOV_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `RESPNMOV_CodigoUsuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cji_reponsblmoviminto`
--

INSERT INTO `cji_reponsblmoviminto` (`RESPNMOV_Codigo`, `DIREP_Codigo`, `CLIP_Codigo`, `PROVP_Codigo`, `CAJA_Codigo`, `RESPNMOV_TipBenefi`, `RESPNMOV_FechaIngreso`, `RESPNMOV_FechaRegistro`, `RESPNMOV_FechaModificacion`, `RESPNMOV_FlagEstado`, `RESPNMOV_CodigoUsuario`) VALUES
(42, '', 0, 0, 31, 'B', '0000-00-00 00:00:00', '2016-12-28 22:11:00', '0000-00-00 00:00:00', '1', 1),
(43, '549', 0, 0, 0, 'G', '2014-06-28 00:00:00', '2016-12-28 22:11:53', '0000-00-00 00:00:00', '1', 1),
(44, '', 0, 935, 0, 'B', '0000-00-00 00:00:00', '2016-12-28 22:12:43', '0000-00-00 00:00:00', '1', 1),
(45, '', 2463, 0, 0, 'G', '2002-06-23 00:00:00', '2016-12-28 22:13:19', '0000-00-00 00:00:00', '1', 1),
(46, '', 0, 0, 29, 'B', '0000-00-00 00:00:00', '2016-12-28 22:18:33', '0000-00-00 00:00:00', '1', 1),
(47, '', 2464, 0, 0, 'B', '2013-10-29 00:00:00', '2016-12-28 22:23:15', '0000-00-00 00:00:00', '1', 1),
(48, '', 0, 938, 0, 'G', '0000-00-00 00:00:00', '2016-12-30 03:54:47', '0000-00-00 00:00:00', '1', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_rol`
--

CREATE TABLE `cji_rol` (
  `ROL_Codigo` int(11) NOT NULL,
  `ROL_Descripcion` varchar(150) DEFAULT NULL,
  `ROL_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ROL_FechaModificacion` datetime DEFAULT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `ROL_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_rol`
--

INSERT INTO `cji_rol` (`ROL_Codigo`, `ROL_Descripcion`, `ROL_FechaRegistro`, `ROL_FechaModificacion`, `COMPP_Codigo`, `ROL_FlagEstado`) VALUES
(1, 'VENDEDOR', '2013-01-26 21:00:11', NULL, 1, '1'),
(2, 'CONTABILIDAD', '2013-03-12 11:24:02', NULL, 1, '1'),
(3, 'ALMACEN', '2013-01-31 20:25:11', NULL, 1, '1'),
(4, 'ADMINISTRADOR', '2012-11-28 00:34:18', NULL, 1, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_sectorcomercial`
--

CREATE TABLE `cji_sectorcomercial` (
  `SECCOMP_Codigo` int(11) NOT NULL,
  `SECCOMC_Descripcion` varchar(200) NOT NULL,
  `SECCOMC_FechaRegistro` date DEFAULT NULL,
  `SECCOMC_FechaModificacion` datetime DEFAULT NULL,
  `SECCOMC_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_sectorcomercial`
--

INSERT INTO `cji_sectorcomercial` (`SECCOMP_Codigo`, `SECCOMC_Descripcion`, `SECCOMC_FechaRegistro`, `SECCOMC_FechaModificacion`, `SECCOMC_FlagEstado`) VALUES
(1, 'TRANSPORTE', '2013-04-15', NULL, '1'),
(2, 'MADERA', '2013-04-15', NULL, '1'),
(3, 'METALMECANICA', '2014-05-28', NULL, '1'),
(4, 'NNNN', '2017-01-13', NULL, '1'),
(5, 'AAAAA', '2017-01-16', NULL, '1'),
(6, 'EDITANDO', '2017-01-16', NULL, '1'),
(7, 'NUEVO', '2017-01-16', NULL, '1'),
(8, 'DATA ATDATDTASDDAS', '2017-01-16', NULL, '0'),
(9, 'NUEVO DE LOS NUEVO', '2017-01-16', NULL, '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_serie`
--

CREATE TABLE `cji_serie` (
  `SERIP_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `SERIC_Numero` varchar(50) DEFAULT NULL,
  `SERIC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `SERIC_FechaModificacion` datetime DEFAULT NULL,
  `SERIC_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `ALMAP_Codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_serie`
--

INSERT INTO `cji_serie` (`SERIP_Codigo`, `PROD_Codigo`, `SERIC_Numero`, `SERIC_FechaRegistro`, `SERIC_FechaModificacion`, `SERIC_FlagEstado`, `ALMAP_Codigo`) VALUES
(33, 3, '45454564564', '2017-01-23 21:09:51', NULL, '1', 5),
(34, 3, '44444555', '2017-01-23 21:09:51', NULL, '1', 5),
(35, 3, '77777', '2017-01-23 21:09:51', NULL, '1', 5),
(36, 3, '88888', '2017-01-23 21:09:51', NULL, '1', 5),
(37, 3, '55555', '2017-01-23 21:09:51', NULL, '1', 5),
(38, 4, '787787878', '2017-01-23 21:10:24', NULL, '1', 5),
(39, 4, '555445445', '2017-01-23 21:10:24', NULL, '1', 5),
(40, 4, '5554555', '2017-01-23 21:10:24', NULL, '1', 5),
(41, 4, '888877887', '2017-01-23 21:10:24', NULL, '1', 5),
(42, 4, '6666', '2017-01-23 21:10:24', NULL, '1', 5),
(43, 3, '546546546', '2017-01-23 21:13:39', NULL, '1', 5),
(44, 3, '6565465', '2017-01-23 21:13:39', NULL, '1', 5),
(45, 3, '11111', '2017-01-23 21:13:39', NULL, '1', 5),
(46, 3, '454545', '2017-01-23 21:18:24', NULL, '1', 5),
(47, 3, '54654665465', '2017-01-23 21:18:24', NULL, '1', 5),
(48, 3, '45465646546', '2017-01-23 21:18:24', NULL, '1', 5),
(49, 3, '23168498465', '2017-01-23 21:18:24', NULL, '1', 5),
(50, 3, '233333', '2017-01-23 21:18:24', NULL, '1', 5),
(51, 3, '555', '2017-01-23 21:18:24', NULL, '1', 5),
(52, 4, '4565', '2017-01-23 21:20:03', '2017-01-23 16:20:20', '1', 5),
(53, 4, '4548', '2017-01-23 21:20:03', '2017-01-23 16:20:20', '1', 5),
(54, 4, '45545', '2017-01-23 21:20:03', '2017-01-23 16:20:20', '1', 5),
(55, 4, '8778', '2017-01-23 21:20:04', '2017-01-23 16:20:20', '1', 5),
(56, 4, '1125', '2017-01-23 21:20:04', '2017-01-23 16:20:20', '1', 5),
(57, 3, '898778', '2017-01-23 21:20:04', '2017-01-23 16:20:20', '1', 5),
(58, 3, '745445', '2017-01-23 21:20:04', '2017-01-23 16:20:21', '1', 5),
(59, 3, '452121', '2017-01-23 21:20:04', '2017-01-23 16:20:21', '1', 5),
(60, 3, '222222222222222222', '2017-01-24 15:34:51', NULL, '1', 5),
(61, 3, '3333333333333333333333', '2017-01-24 15:34:52', NULL, '1', 5),
(62, 3, '44444444444444444444', '2017-01-24 15:34:52', NULL, '1', 5),
(63, 3, '555555555555555', '2017-01-24 15:34:52', NULL, '1', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_seriedocumento`
--

CREATE TABLE `cji_seriedocumento` (
  `SERDOC_Codigo` int(11) NOT NULL,
  `SERIP_Codigo` int(11) NOT NULL,
  `DOCUP_Codigo` int(2) NOT NULL,
  `SERDOC_NumeroRef` int(11) NOT NULL,
  `TIPOMOV_Tipo` char(1) NOT NULL COMMENT '1:Ingreso, 2:Salida',
  `SERDOC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `SERDOC_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_seriedocumento`
--

INSERT INTO `cji_seriedocumento` (`SERDOC_Codigo`, `SERIP_Codigo`, `DOCUP_Codigo`, `SERDOC_NumeroRef`, `TIPOMOV_Tipo`, `SERDOC_FechaRegistro`, `SERDOC_FlagEstado`) VALUES
(85, 33, 4, 32, '1', '2017-01-23 21:09:51', '1'),
(86, 34, 4, 32, '1', '2017-01-23 21:09:51', '1'),
(87, 35, 4, 32, '1', '2017-01-23 21:09:51', '1'),
(88, 36, 4, 32, '1', '2017-01-23 21:09:51', '1'),
(89, 37, 4, 32, '1', '2017-01-23 21:09:51', '1'),
(90, 38, 4, 32, '1', '2017-01-23 21:10:24', '1'),
(91, 39, 4, 32, '1', '2017-01-23 21:10:24', '1'),
(92, 40, 4, 32, '1', '2017-01-23 21:10:24', '1'),
(93, 41, 4, 32, '1', '2017-01-23 21:10:24', '1'),
(94, 42, 4, 32, '1', '2017-01-23 21:10:24', '1'),
(95, 43, 8, 6, '1', '2017-01-23 21:13:39', '1'),
(96, 44, 8, 6, '1', '2017-01-23 21:13:39', '1'),
(97, 45, 8, 6, '1', '2017-01-23 21:13:39', '1'),
(98, 43, 10, 217, '1', '2017-01-23 21:13:42', '1'),
(99, 44, 10, 217, '1', '2017-01-23 21:13:42', '1'),
(100, 45, 10, 217, '1', '2017-01-23 21:13:42', '1'),
(105, 46, 8, 8, '1', '2017-01-23 21:18:24', '1'),
(106, 47, 8, 8, '1', '2017-01-23 21:18:24', '1'),
(107, 48, 8, 8, '1', '2017-01-23 21:18:24', '1'),
(108, 49, 8, 8, '1', '2017-01-23 21:18:24', '1'),
(109, 50, 8, 8, '1', '2017-01-23 21:18:24', '1'),
(110, 51, 8, 8, '1', '2017-01-23 21:18:24', '1'),
(111, 46, 10, 219, '1', '2017-01-23 21:18:27', '1'),
(112, 47, 10, 219, '1', '2017-01-23 21:18:27', '1'),
(113, 48, 10, 219, '1', '2017-01-23 21:18:27', '1'),
(114, 49, 10, 219, '1', '2017-01-23 21:18:28', '1'),
(115, 50, 10, 219, '1', '2017-01-23 21:18:28', '1'),
(116, 51, 10, 219, '1', '2017-01-23 21:18:28', '1'),
(161, 54, 8, 13, '2', '2017-01-24 15:34:13', '1'),
(162, 54, 10, 230, '2', '2017-01-24 15:34:17', '1'),
(163, 60, 8, 14, '1', '2017-01-24 15:34:51', '1'),
(164, 61, 8, 14, '1', '2017-01-24 15:34:52', '1'),
(165, 62, 8, 14, '1', '2017-01-24 15:34:52', '1'),
(166, 63, 8, 14, '1', '2017-01-24 15:34:52', '1'),
(167, 60, 10, 231, '1', '2017-01-24 15:34:56', '1'),
(168, 61, 10, 231, '1', '2017-01-24 15:34:56', '1'),
(169, 62, 10, 231, '1', '2017-01-24 15:34:56', '1'),
(170, 63, 10, 231, '1', '2017-01-24 15:34:56', '1'),
(171, 60, 8, 15, '2', '2017-01-24 15:36:19', '1'),
(172, 61, 8, 15, '2', '2017-01-24 15:36:19', '1'),
(173, 62, 8, 15, '2', '2017-01-24 15:36:19', '1'),
(174, 63, 8, 15, '2', '2017-01-24 15:36:19', '1'),
(175, 60, 10, 232, '2', '2017-01-24 15:36:23', '1'),
(176, 61, 10, 232, '2', '2017-01-24 15:36:23', '1'),
(177, 62, 10, 232, '2', '2017-01-24 15:36:23', '1'),
(178, 63, 10, 232, '2', '2017-01-24 15:36:23', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_seriemov`
--

CREATE TABLE `cji_seriemov` (
  `SERMOVP_Codigo` int(11) NOT NULL,
  `SERIP_Codigo` int(11) NOT NULL,
  `SERMOVP_TipoMov` char(1) NOT NULL COMMENT '1: Ingreso, 2:Salida',
  `GUIAINP_Codigo` int(11) DEFAULT NULL,
  `GUIASAP_Codigo` int(11) DEFAULT NULL,
  `SERMOVC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `SERMOVC_FechaModificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_seriemov`
--

INSERT INTO `cji_seriemov` (`SERMOVP_Codigo`, `SERIP_Codigo`, `SERMOVP_TipoMov`, `GUIAINP_Codigo`, `GUIASAP_Codigo`, `SERMOVC_FechaRegistro`, `SERMOVC_FechaModificacion`) VALUES
(38, 33, '1', 143, NULL, '2017-01-23 09:01:58', NULL),
(39, 34, '1', 143, NULL, '2017-01-23 09:01:58', NULL),
(40, 35, '1', 143, NULL, '2017-01-23 09:01:58', NULL),
(41, 36, '1', 143, NULL, '2017-01-23 09:01:58', NULL),
(42, 37, '1', 143, NULL, '2017-01-23 09:01:58', NULL),
(43, 38, '1', 144, NULL, '2017-01-23 09:01:29', NULL),
(44, 39, '1', 144, NULL, '2017-01-23 09:01:29', NULL),
(45, 40, '1', 144, NULL, '2017-01-23 09:01:29', NULL),
(46, 41, '1', 144, NULL, '2017-01-23 09:01:29', NULL),
(47, 42, '1', 144, NULL, '2017-01-23 09:01:29', NULL),
(48, 43, '1', 145, NULL, '2017-01-23 21:13:42', NULL),
(49, 44, '1', 145, NULL, '2017-01-23 21:13:42', NULL),
(50, 45, '1', 145, NULL, '2017-01-23 21:13:42', NULL),
(53, 46, '1', 146, NULL, '2017-01-23 21:18:27', NULL),
(54, 47, '1', 146, NULL, '2017-01-23 21:18:27', NULL),
(55, 48, '1', 146, NULL, '2017-01-23 21:18:27', NULL),
(56, 49, '1', 146, NULL, '2017-01-23 21:18:27', NULL),
(57, 50, '1', 146, NULL, '2017-01-23 21:18:27', NULL),
(58, 51, '1', 146, NULL, '2017-01-23 21:18:27', NULL),
(80, 54, '2', NULL, 9, '2017-01-24 15:34:17', NULL),
(81, 60, '1', 148, NULL, '2017-01-24 15:34:55', NULL),
(82, 61, '1', 148, NULL, '2017-01-24 15:34:55', NULL),
(83, 62, '1', 148, NULL, '2017-01-24 15:34:55', NULL),
(84, 63, '1', 148, NULL, '2017-01-24 15:34:55', NULL),
(85, 60, '2', NULL, 10, '2017-01-24 15:36:23', NULL),
(86, 61, '2', NULL, 10, '2017-01-24 15:36:23', NULL),
(87, 62, '2', NULL, 10, '2017-01-24 15:36:23', NULL),
(88, 63, '2', NULL, 10, '2017-01-24 15:36:23', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_terminal`
--

CREATE TABLE `cji_terminal` (
  `TERMINAL_Codigo` int(11) UNSIGNED NOT NULL,
  `ARDUINO_Codigo` int(11) NOT NULL,
  `PROYP_Codigo` int(11) NOT NULL,
  `DIRECC_Codigo` int(11) NOT NULL,
  `TERMINAL_Nombre` varchar(200) NOT NULL,
  `TERMINAL_Modelo` varchar(200) NOT NULL,
  `TERMINAL_Serie` text NOT NULL,
  `TERMINAL_NroLed` int(20) NOT NULL,
  `TERMINAL_Mapa` text NOT NULL,
  `TERMINAL_StreetView` text NOT NULL,
  `TERMINAL_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `TERMINAL_FechaModificacion` datetime DEFAULT NULL,
  `TERMINAL_FlagEstado` char(1) DEFAULT NULL,
  `TERMINAL_FlagUno` char(1) DEFAULT NULL,
  `TERMINAL_FlagDos` char(1) DEFAULT NULL,
  `TERMINAL_CodigoUsuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_tipdocumento`
--

CREATE TABLE `cji_tipdocumento` (
  `TIPDOCP_Codigo` int(11) NOT NULL,
  `TIPDOCC_Descripcion` varchar(150) DEFAULT NULL,
  `TIPOCC_Inciales` varchar(150) DEFAULT NULL,
  `TIPOCC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TIPOCC_FechaModificacion` datetime DEFAULT NULL,
  `TIPOCC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_tipdocumento`
--

INSERT INTO `cji_tipdocumento` (`TIPDOCP_Codigo`, `TIPDOCC_Descripcion`, `TIPOCC_Inciales`, `TIPOCC_FechaRegistro`, `TIPOCC_FechaModificacion`, `TIPOCC_FlagEstado`) VALUES
(1, 'Documento Nacional de Identidad', 'D.N.I.', '2010-12-17 20:49:54', NULL, '1'),
(2, 'Carnet de Extranjeria', 'C.E.', '2010-12-17 20:49:58', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_tipoalmacen`
--

CREATE TABLE `cji_tipoalmacen` (
  `TIPALMP_Codigo` int(11) NOT NULL,
  `TIPALM_Descripcion` varchar(250) DEFAULT NULL,
  `TIPALM_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TIPALM_FechaModificacion` datetime DEFAULT NULL,
  `TIPALM_flagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_tipoalmacen`
--

INSERT INTO `cji_tipoalmacen` (`TIPALMP_Codigo`, `TIPALM_Descripcion`, `TIPALM_FechaRegistro`, `TIPALM_FechaModificacion`, `TIPALM_flagEstado`) VALUES
(1, 'ALMACEN DE PRODUCTOS TERMINADOS', '2011-01-14 20:25:33', NULL, '1'),
(2, 'ALMACEN DE PRODUCTOS EN PROCESO', '2011-01-14 20:25:44', NULL, '1'),
(3, 'ALMACEN DE MERCADERIAS', '2011-01-14 20:25:55', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_tipocaja`
--

CREATE TABLE `cji_tipocaja` (
  `tipCa_codigo` int(11) NOT NULL,
  `tipCa_Descripcion` varchar(100) DEFAULT NULL,
  `tipCa_Abreviaturas` char(2) DEFAULT NULL,
  `tipCa_Tipo` char(1) DEFAULT NULL,
  `UsuarioRegistro` varchar(100) DEFAULT NULL,
  `UsuarioModificado` varchar(100) DEFAULT NULL,
  `tipCa_fechaModificacion` date DEFAULT NULL,
  `tipCa_FechaRegsitro` date DEFAULT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `tipCa_FlagEstado` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cji_tipocaja`
--

INSERT INTO `cji_tipocaja` (`tipCa_codigo`, `tipCa_Descripcion`, `tipCa_Abreviaturas`, `tipCa_Tipo`, `UsuarioRegistro`, `UsuarioModificado`, `tipCa_fechaModificacion`, `tipCa_FechaRegsitro`, `COMPP_Codigo`, `tipCa_FlagEstado`) VALUES
(1, 'TRE', 'FS', '1', 'PERSONA PRINCIPAL ', NULL, NULL, '2017-01-24', 1, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_tipocambio`
--

CREATE TABLE `cji_tipocambio` (
  `TIPCAMP_Codigo` int(11) NOT NULL,
  `TIPCAMC_MonedaOrigen` int(11) NOT NULL,
  `TIPCAMC_MonedaDestino` int(11) NOT NULL,
  `TIPCAMC_Fecha` date NOT NULL,
  `TIPCAMC_FactorConversion` double(10,2) NOT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `TIPCAMC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TIPCAMC_FechaModificacion` datetime DEFAULT NULL,
  `TIPCAMC_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_tipocambio`
--

INSERT INTO `cji_tipocambio` (`TIPCAMP_Codigo`, `TIPCAMC_MonedaOrigen`, `TIPCAMC_MonedaDestino`, `TIPCAMC_Fecha`, `TIPCAMC_FactorConversion`, `COMPP_Codigo`, `TIPCAMC_FechaRegistro`, `TIPCAMC_FechaModificacion`, `TIPCAMC_FlagEstado`) VALUES
(346, 1, 2, '2017-01-23', 6.00, 1, '2017-01-23 20:04:43', NULL, '1'),
(347, 1, 2, '2017-01-24', 5.00, 6, '2017-01-24 15:17:09', NULL, '1'),
(348, 1, 2, '2017-01-24', 5.00, 5, '2017-01-24 15:17:09', NULL, '1'),
(349, 1, 2, '2017-01-24', 5.00, 2, '2017-01-24 15:17:09', NULL, '1'),
(350, 1, 2, '2017-01-24', 5.00, 1, '2017-01-24 15:17:09', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_tipocliente`
--

CREATE TABLE `cji_tipocliente` (
  `TIPCLIP_Codigo` int(11) NOT NULL,
  `TIPCLIC_Descripcion` varchar(150) NOT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `TIPCLIC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TIPCLIC_FechaModificacion` datetime DEFAULT NULL,
  `TIPCLIC_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_tipocliente`
--

INSERT INTO `cji_tipocliente` (`TIPCLIP_Codigo`, `TIPCLIC_Descripcion`, `COMPP_Codigo`, `TIPCLIC_FechaRegistro`, `TIPCLIC_FechaModificacion`, `TIPCLIC_FlagEstado`) VALUES
(1, 'CLIENTE PRECIO 1', 1, '2011-07-15 01:37:31', NULL, '1'),
(2, 'CLIENTE PRECIO 2', 1, '2011-07-15 01:37:31', NULL, '1'),
(3, 'CLIENTE PRECIO 3', 1, '2012-11-18 02:46:59', NULL, '1'),
(4, 'CLIENTE PRECIO 4', 1, '2012-11-18 02:47:03', NULL, '1'),
(5, 'CLIENTE PRECIO 5', 1, '2012-11-18 02:47:07', NULL, '1'),
(6, 'CLIENTE PRECIO 6', 1, '2016-12-06 19:54:26', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_tipocodigo`
--

CREATE TABLE `cji_tipocodigo` (
  `TIPCOD_Codigo` int(11) NOT NULL,
  `TIPCOD_Descripcion` varchar(150) DEFAULT NULL,
  `TIPCOD_Inciales` varchar(150) DEFAULT NULL,
  `TIPCOD_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TIPCOD_FechaModificacion` datetime DEFAULT NULL,
  `TIPCOD_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_tipocodigo`
--

INSERT INTO `cji_tipocodigo` (`TIPCOD_Codigo`, `TIPCOD_Descripcion`, `TIPCOD_Inciales`, `TIPCOD_FechaRegistro`, `TIPCOD_FechaModificacion`, `TIPCOD_FlagEstado`) VALUES
(1, 'Registro Unico de Contribuyente', 'R.U.C.', '2011-07-06 00:32:59', NULL, '1'),
(2, NULL, 'N.I.C.', '2011-07-06 00:32:59', NULL, '1'),
(3, 'OTROS', 'OTROS', '2016-11-28 19:32:53', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_tipoestablecimiento`
--

CREATE TABLE `cji_tipoestablecimiento` (
  `TESTP_Codigo` int(11) NOT NULL,
  `TESTC_Descripcion` varchar(150) DEFAULT NULL,
  `TESTC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TESTC_FechaModificacion` datetime DEFAULT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `TESTC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cji_tipoestablecimiento`
--

INSERT INTO `cji_tipoestablecimiento` (`TESTP_Codigo`, `TESTC_Descripcion`, `TESTC_FechaRegistro`, `TESTC_FechaModificacion`, `COMPP_Codigo`, `TESTC_FlagEstado`) VALUES
(1, 'Domicilio Legal', '2010-12-15 07:33:12', NULL, 1, '1'),
(2, 'Local Comercial o de Serv.', '2010-12-30 20:28:04', NULL, 1, '1'),
(3, 'Oficina Administrativa', '2015-11-05 02:06:16', NULL, 1, '1'),
(4, 'Sucursal', '2015-11-05 02:08:06', NULL, 1, '1'),
(5, 'Agencia', '2015-11-05 02:08:28', NULL, 1, '1'),
(6, 'Depósito (Almacén)', '2015-11-12 01:28:58', NULL, 1, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_tipomovimiento`
--

CREATE TABLE `cji_tipomovimiento` (
  `TIPOMOVP_Codigo` int(11) NOT NULL,
  `TIPOMOVC_Descripcion` varchar(100) DEFAULT NULL,
  `TIPOMOVC_Tipo` char(1) NOT NULL COMMENT '1:Ingreso, 2:Salida',
  `TIPOMOVC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `TIPOMOVC_FlagEstado` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_tipomovimiento`
--

INSERT INTO `cji_tipomovimiento` (`TIPOMOVP_Codigo`, `TIPOMOVC_Descripcion`, `TIPOMOVC_Tipo`, `TIPOMOVC_FechaRegistro`, `TIPOMOVC_FlagEstado`) VALUES
(1, 'VENTA', '2', '2011-09-17 23:24:45', '1'),
(2, 'VENTA SUJETA A CONF. DEL COMPRADOR', '2', '2013-02-12 08:38:06', '1'),
(3, 'COMPRA', '2', '2013-02-12 08:38:06', '1'),
(4, 'CONSIGNACION', '2', '2011-09-18 01:50:46', '1'),
(5, 'DEVOLUCION', '2', '2011-09-17 23:24:45', '1'),
(6, 'TRASL. ENTRE ESTAB. DE LA MISMA EMPRESA', '2', '2011-09-18 01:50:46', '1'),
(7, 'TRASL. DE BIENES PARA TRANSF.', '2', '2013-02-12 08:38:06', '1'),
(8, 'RECOJO DE BIENES', '2', '2011-09-18 01:50:46', '1'),
(9, 'TRASL. POR EMISOR ITINERANTE DE COMPRO', '2', '2013-02-12 08:38:06', '1'),
(10, 'TRASL. ZONA PRIMARIA', '2', '2011-09-18 01:50:46', '1'),
(11, 'IMPORTACION', '2', '2011-09-17 23:24:45', '1'),
(12, 'EXPORTACION', '2', '2011-09-17 23:24:45', '1'),
(13, 'OTROS', '2', '2013-02-12 08:38:06', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_tipoproducto`
--

CREATE TABLE `cji_tipoproducto` (
  `TIPPROD_Codigo` int(11) NOT NULL,
  `TIPPROD_FlagBienServicio` char(1) NOT NULL DEFAULT 'B' COMMENT 'B: Bien, S: Servicio',
  `TIPPROD_Descripcion` varchar(250) DEFAULT NULL,
  `TIPPROD_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TIPPROD_FechaModificacion` datetime DEFAULT NULL,
  `TIPPROD_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_tipoproveedor`
--

CREATE TABLE `cji_tipoproveedor` (
  `FAMI_Codigo` int(11) NOT NULL,
  `FAMI_Descripcion` varchar(350) DEFAULT NULL,
  `FAMI_Codigo2` int(11) DEFAULT NULL,
  `FAMI_CodigoInterno` char(3) DEFAULT NULL,
  `FAMI_CodigoUsuario` varchar(20) DEFAULT NULL,
  `FAMI_Numeracion` int(11) DEFAULT '0',
  `FAMI_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `FAMI_FechaModificacion` datetime DEFAULT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `FAMI_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_ubigeo`
--

CREATE TABLE `cji_ubigeo` (
  `UBIGP_Codigo` int(11) NOT NULL,
  `UBIGC_CodDpto` char(2) DEFAULT NULL,
  `UBIGC_CodProv` char(2) DEFAULT NULL,
  `UBIGC_CodDist` char(2) DEFAULT NULL,
  `UBIGC_Descripcion` varchar(150) DEFAULT NULL,
  `UBIGC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UBIGC_FechaModificacion` datetime DEFAULT NULL,
  `UBIGC_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cji_ubigeo`
--

INSERT INTO `cji_ubigeo` (`UBIGP_Codigo`, `UBIGC_CodDpto`, `UBIGC_CodProv`, `UBIGC_CodDist`, `UBIGC_Descripcion`, `UBIGC_FechaRegistro`, `UBIGC_FechaModificacion`, `UBIGC_FlagEstado`) VALUES
(1, '00', '00', '00', 'NO DEFINIDO', '2010-12-16 00:13:00', NULL, '1'),
(10000, '01', '00', '00', 'AMAZONAS', '2010-12-15 01:58:44', NULL, '1'),
(10100, '01', '01', '00', 'CHACHAPOYAS', '2010-12-15 01:58:44', NULL, '1'),
(10101, '01', '01', '01', 'CHACHAPOYAS', '2010-12-15 01:58:44', NULL, '1'),
(10102, '01', '01', '02', 'ASUNCION', '2010-12-15 01:58:44', NULL, '1'),
(10103, '01', '01', '03', 'BALSAS', '2010-12-15 01:58:44', NULL, '1'),
(10104, '01', '01', '04', 'CHETO', '2010-12-15 01:58:44', NULL, '1'),
(10105, '01', '01', '05', 'CHILIQUIN', '2010-12-15 01:58:44', NULL, '1'),
(10106, '01', '01', '06', 'CHUQUIBAMBA', '2010-12-15 01:58:44', NULL, '1'),
(10107, '01', '01', '07', 'GRANADA', '2010-12-15 01:58:44', NULL, '1'),
(10108, '01', '01', '08', 'HUANCAS', '2010-12-15 01:58:44', NULL, '1'),
(10109, '01', '01', '09', 'LA JALCA', '2010-12-15 01:58:44', NULL, '1'),
(10110, '01', '01', '10', 'LEIMEBAMBA', '2010-12-15 01:58:44', NULL, '1'),
(10111, '01', '01', '11', 'LEVANTO', '2010-12-15 01:58:44', NULL, '1'),
(10112, '01', '01', '12', 'MAGDALENA', '2010-12-15 01:58:44', NULL, '1'),
(10113, '01', '01', '13', 'MARISCAL CASTILLA', '2010-12-15 01:58:44', NULL, '1'),
(10114, '01', '01', '14', 'MOLINOPAMPA', '2010-12-15 01:58:44', NULL, '1'),
(10115, '01', '01', '15', 'MONTEVIDEO', '2010-12-15 01:58:44', NULL, '1'),
(10116, '01', '01', '16', 'OLLEROS', '2010-12-15 01:58:44', NULL, '1'),
(10117, '01', '01', '17', 'QUINJALCA', '2010-12-15 01:58:44', NULL, '1'),
(10118, '01', '01', '18', 'SAN FRANCISCO DE DAGUAS', '2010-12-15 01:58:44', NULL, '1'),
(10119, '01', '01', '19', 'SAN ISIDRO DE MAINO', '2010-12-15 01:58:44', NULL, '1'),
(10120, '01', '01', '20', 'SOLOCO', '2010-12-15 01:58:44', NULL, '1'),
(10121, '01', '01', '21', 'SONCHE', '2010-12-15 01:58:44', NULL, '1'),
(10200, '01', '02', '00', 'BAGUA', '2010-12-15 01:58:44', NULL, '1'),
(10201, '01', '02', '01', 'BAGUA', '2010-12-15 01:58:44', NULL, '1'),
(10202, '01', '02', '02', 'ARAMANGO', '2010-12-15 01:58:44', NULL, '1'),
(10203, '01', '02', '03', 'COPALLIN', '2010-12-15 01:58:44', NULL, '1'),
(10204, '01', '02', '04', 'EL PARCO', '2010-12-15 01:58:44', NULL, '1'),
(10205, '01', '02', '05', 'IMAZA', '2010-12-15 01:58:44', NULL, '1'),
(10206, '01', '02', '06', 'LA PECA', '2010-12-15 01:58:44', NULL, '1'),
(10300, '01', '03', '00', 'BONGARA', '2010-12-15 01:58:44', NULL, '1'),
(10301, '01', '03', '01', 'JUMBILLA', '2010-12-15 01:58:44', NULL, '1'),
(10302, '01', '03', '02', 'CHISQUILLA', '2010-12-15 01:58:44', NULL, '1'),
(10303, '01', '03', '03', 'CHURUJA', '2010-12-15 01:58:44', NULL, '1'),
(10304, '01', '03', '04', 'COROSHA', '2010-12-15 01:58:44', NULL, '1'),
(10305, '01', '03', '05', 'CUISPES', '2010-12-15 01:58:44', NULL, '1'),
(10306, '01', '03', '06', 'FLORIDA', '2010-12-15 01:58:44', NULL, '1'),
(10307, '01', '03', '07', 'JAZAN', '2010-12-15 01:58:44', NULL, '1'),
(10308, '01', '03', '08', 'RECTA', '2010-12-15 01:58:44', NULL, '1'),
(10309, '01', '03', '09', 'SAN CARLOS', '2010-12-15 01:58:44', NULL, '1'),
(10310, '01', '03', '10', 'SHIPASBAMBA', '2010-12-15 01:58:44', NULL, '1'),
(10311, '01', '03', '11', 'VALERA', '2010-12-15 01:58:44', NULL, '1'),
(10312, '01', '03', '12', 'YAMBRASBAMBA', '2010-12-15 01:58:44', NULL, '1'),
(10400, '01', '04', '00', 'CONDORCANQUI', '2010-12-15 01:58:44', NULL, '1'),
(10401, '01', '04', '01', 'NIEVA', '2010-12-15 01:58:44', NULL, '1'),
(10402, '01', '04', '02', 'EL CENEPA', '2010-12-15 01:58:44', NULL, '1'),
(10403, '01', '04', '03', 'RIO SANTIAGO', '2010-12-15 01:58:44', NULL, '1'),
(10500, '01', '05', '00', 'LUYA', '2010-12-15 01:58:44', NULL, '1'),
(10501, '01', '05', '01', 'LAMUD', '2010-12-15 01:58:44', NULL, '1'),
(10502, '01', '05', '02', 'CAMPORREDONDO', '2010-12-15 01:58:44', NULL, '1'),
(10503, '01', '05', '03', 'COCABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(10504, '01', '05', '04', 'COLCAMAR', '2010-12-15 01:58:44', NULL, '1'),
(10505, '01', '05', '05', 'CONILA', '2010-12-15 01:58:44', NULL, '1'),
(10506, '01', '05', '06', 'INGUILPATA', '2010-12-15 01:58:44', NULL, '1'),
(10507, '01', '05', '07', 'LONGUITA', '2010-12-15 01:58:44', NULL, '1'),
(10508, '01', '05', '08', 'LONYA CHICO', '2010-12-15 01:58:44', NULL, '1'),
(10509, '01', '05', '09', 'LUYA', '2010-12-15 01:58:44', NULL, '1'),
(10510, '01', '05', '10', 'LUYA VIEJO', '2010-12-15 01:58:44', NULL, '1'),
(10511, '01', '05', '11', 'MARIA', '2010-12-15 01:58:44', NULL, '1'),
(10512, '01', '05', '12', 'OCALLI', '2010-12-15 01:58:44', NULL, '1'),
(10513, '01', '05', '13', 'OCUMAL', '2010-12-15 01:58:44', NULL, '1'),
(10514, '01', '05', '14', 'PISUQUIA', '2010-12-15 01:58:44', NULL, '1'),
(10515, '01', '05', '15', 'PROVIDENCIA', '2010-12-15 01:58:44', NULL, '1'),
(10516, '01', '05', '16', 'SAN CRISTOBAL', '2010-12-15 01:58:44', NULL, '1'),
(10517, '01', '05', '17', 'SAN FRANCISCO DEL YESO', '2010-12-15 01:58:44', NULL, '1'),
(10518, '01', '05', '18', 'SAN JERONIMO', '2010-12-15 01:58:44', NULL, '1'),
(10519, '01', '05', '19', 'SAN JUAN DE LOPECANCHA', '2010-12-15 01:58:44', NULL, '1'),
(10520, '01', '05', '20', 'SANTA CATALINA', '2010-12-15 01:58:44', NULL, '1'),
(10521, '01', '05', '21', 'SANTO TOMAS', '2010-12-15 01:58:44', NULL, '1'),
(10522, '01', '05', '22', 'TINGO', '2010-12-15 01:58:44', NULL, '1'),
(10523, '01', '05', '23', 'TRITA', '2010-12-15 01:58:44', NULL, '1'),
(10600, '01', '06', '00', 'RODRIGUEZ DE MENDOZA', '2010-12-15 01:58:44', NULL, '1'),
(10601, '01', '06', '01', 'SAN NICOLAS', '2010-12-15 01:58:44', NULL, '1'),
(10602, '01', '06', '02', 'CHIRIMOTO', '2010-12-15 01:58:44', NULL, '1'),
(10603, '01', '06', '03', 'COCHAMAL', '2010-12-15 01:58:44', NULL, '1'),
(10604, '01', '06', '04', 'HUAMBO', '2010-12-15 01:58:44', NULL, '1'),
(10605, '01', '06', '05', 'LIMABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(10606, '01', '06', '06', 'LONGAR', '2010-12-15 01:58:44', NULL, '1'),
(10607, '01', '06', '07', 'MARISCAL BENAVIDES', '2010-12-15 01:58:44', NULL, '1'),
(10608, '01', '06', '08', 'MILPUC', '2010-12-15 01:58:44', NULL, '1'),
(10609, '01', '06', '09', 'OMIA', '2010-12-15 01:58:44', NULL, '1'),
(10610, '01', '06', '10', 'SANTA ROSA', '2010-12-15 01:58:44', NULL, '1'),
(10611, '01', '06', '11', 'TOTORA', '2010-12-15 01:58:44', NULL, '1'),
(10612, '01', '06', '12', 'VISTA ALEGRE', '2010-12-15 01:58:44', NULL, '1'),
(10700, '01', '07', '00', 'UTCUBAMBA', '2010-12-15 01:58:44', NULL, '1'),
(10701, '01', '07', '01', 'BAGUA GRANDE', '2010-12-15 01:58:44', NULL, '1'),
(10702, '01', '07', '02', 'CAJARURO', '2010-12-15 01:58:44', NULL, '1'),
(10703, '01', '07', '03', 'CUMBA', '2010-12-15 01:58:44', NULL, '1'),
(10704, '01', '07', '04', 'EL MILAGRO', '2010-12-15 01:58:44', NULL, '1'),
(10705, '01', '07', '05', 'JAMALCA', '2010-12-15 01:58:44', NULL, '1'),
(10706, '01', '07', '06', 'LONYA GRANDE', '2010-12-15 01:58:44', NULL, '1'),
(10707, '01', '07', '07', 'YAMON', '2010-12-15 01:58:44', NULL, '1'),
(20000, '02', '00', '00', 'ANCASH', '2010-12-15 01:58:44', NULL, '1'),
(20100, '02', '01', '00', 'HUARAZ', '2010-12-15 01:58:44', NULL, '1'),
(20101, '02', '01', '01', 'HUARAZ', '2010-12-15 01:58:44', NULL, '1'),
(20102, '02', '01', '02', 'COCHABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(20103, '02', '01', '03', 'COLCABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(20104, '02', '01', '04', 'HUANCHAY', '2010-12-15 01:58:44', NULL, '1'),
(20105, '02', '01', '05', 'INDEPENDENCIA', '2010-12-15 01:58:44', NULL, '1'),
(20106, '02', '01', '06', 'JANGAS', '2010-12-15 01:58:44', NULL, '1'),
(20107, '02', '01', '07', 'LA LIBERTAD', '2010-12-15 01:58:44', NULL, '1'),
(20108, '02', '01', '08', 'OLLEROS', '2010-12-15 01:58:44', NULL, '1'),
(20109, '02', '01', '09', 'PAMPAS', '2010-12-15 01:58:44', NULL, '1'),
(20110, '02', '01', '10', 'PARIACOTO', '2010-12-15 01:58:44', NULL, '1'),
(20111, '02', '01', '11', 'PIRA', '2010-12-15 01:58:44', NULL, '1'),
(20112, '02', '01', '12', 'TARICA', '2010-12-15 01:58:44', NULL, '1'),
(20200, '02', '02', '00', 'AIJA', '2010-12-15 01:58:44', NULL, '1'),
(20201, '02', '02', '01', 'AIJA', '2010-12-15 01:58:44', NULL, '1'),
(20202, '02', '02', '02', 'CORIS', '2010-12-15 01:58:44', NULL, '1'),
(20203, '02', '02', '03', 'HUACLLAN', '2010-12-15 01:58:44', NULL, '1'),
(20204, '02', '02', '04', 'LA MERCED', '2010-12-15 01:58:44', NULL, '1'),
(20205, '02', '02', '05', 'SUCCHA', '2010-12-15 01:58:44', NULL, '1'),
(20300, '02', '03', '00', 'ANTONIO RAYMONDI', '2010-12-15 01:58:44', NULL, '1'),
(20301, '02', '03', '01', 'LLAMELLIN', '2010-12-15 01:58:44', NULL, '1'),
(20302, '02', '03', '02', 'ACZO', '2010-12-15 01:58:44', NULL, '1'),
(20303, '02', '03', '03', 'CHACCHO', '2010-12-15 01:58:44', NULL, '1'),
(20304, '02', '03', '04', 'CHINGAS', '2010-12-15 01:58:44', NULL, '1'),
(20305, '02', '03', '05', 'MIRGAS', '2010-12-15 01:58:44', NULL, '1'),
(20306, '02', '03', '06', 'SAN JUAN DE RONTOY', '2010-12-15 01:58:44', NULL, '1'),
(20400, '02', '04', '00', 'ASUNCION', '2010-12-15 01:58:44', NULL, '1'),
(20401, '02', '04', '01', 'CHACAS', '2010-12-15 01:58:44', NULL, '1'),
(20402, '02', '04', '02', 'ACOCHACA', '2010-12-15 01:58:44', NULL, '1'),
(20500, '02', '05', '00', 'BOLOGNESI', '2010-12-15 01:58:44', NULL, '1'),
(20501, '02', '05', '01', 'CHIQUIAN', '2010-12-15 01:58:44', NULL, '1'),
(20502, '02', '05', '02', 'ABELARDO PARDO LEZAMETA', '2010-12-15 01:58:44', NULL, '1'),
(20503, '02', '05', '03', 'ANTONIO RAYMONDI', '2010-12-15 01:58:44', NULL, '1'),
(20504, '02', '05', '04', 'AQUIA', '2010-12-15 01:58:44', NULL, '1'),
(20505, '02', '05', '05', 'CAJACAY', '2010-12-15 01:58:44', NULL, '1'),
(20506, '02', '05', '06', 'CANIS', '2010-12-15 01:58:44', NULL, '1'),
(20507, '02', '05', '07', 'COLQUIOC', '2010-12-15 01:58:44', NULL, '1'),
(20508, '02', '05', '08', 'HUALLANCA', '2010-12-15 01:58:44', NULL, '1'),
(20509, '02', '05', '09', 'HUASTA', '2010-12-15 01:58:44', NULL, '1'),
(20510, '02', '05', '10', 'HUAYLLACAYAN', '2010-12-15 01:58:44', NULL, '1'),
(20511, '02', '05', '11', 'LA PRIMAVERA', '2010-12-15 01:58:44', NULL, '1'),
(20512, '02', '05', '12', 'MANGAS', '2010-12-15 01:58:44', NULL, '1'),
(20513, '02', '05', '13', 'PACLLON', '2010-12-15 01:58:44', NULL, '1'),
(20514, '02', '05', '14', 'SAN MIGUEL DE CORPANQUI', '2010-12-15 01:58:44', NULL, '1'),
(20515, '02', '05', '15', 'TICLLOS', '2010-12-15 01:58:44', NULL, '1'),
(20600, '02', '06', '00', 'CARHUAZ', '2010-12-15 01:58:44', NULL, '1'),
(20601, '02', '06', '01', 'CARHUAZ', '2010-12-15 01:58:44', NULL, '1'),
(20602, '02', '06', '02', 'ACOPAMPA', '2010-12-15 01:58:44', NULL, '1'),
(20603, '02', '06', '03', 'AMASHCA', '2010-12-15 01:58:44', NULL, '1'),
(20604, '02', '06', '04', 'ANTA', '2010-12-15 01:58:44', NULL, '1'),
(20605, '02', '06', '05', 'ATAQUERO', '2010-12-15 01:58:44', NULL, '1'),
(20606, '02', '06', '06', 'MARCARA', '2010-12-15 01:58:44', NULL, '1'),
(20607, '02', '06', '07', 'PARIAHUANCA', '2010-12-15 01:58:44', NULL, '1'),
(20608, '02', '06', '08', 'SAN MIGUEL DE ACO', '2010-12-15 01:58:44', NULL, '1'),
(20609, '02', '06', '09', 'SHILLA', '2010-12-15 01:58:44', NULL, '1'),
(20610, '02', '06', '10', 'TINCO', '2010-12-15 01:58:44', NULL, '1'),
(20611, '02', '06', '11', 'YUNGAR', '2010-12-15 01:58:44', NULL, '1'),
(20700, '02', '07', '00', 'CARLOS FERMIN FITZCARRALD', '2010-12-15 01:58:44', NULL, '1'),
(20701, '02', '07', '01', 'SAN LUIS', '2010-12-15 01:58:44', NULL, '1'),
(20702, '02', '07', '02', 'SAN NICOLAS', '2010-12-15 01:58:44', NULL, '1'),
(20703, '02', '07', '03', 'YAUYA', '2010-12-15 01:58:44', NULL, '1'),
(20800, '02', '08', '00', 'CASMA', '2010-12-15 01:58:44', NULL, '1'),
(20801, '02', '08', '01', 'CASMA', '2010-12-15 01:58:44', NULL, '1'),
(20802, '02', '08', '02', 'BUENA VISTA ALTA', '2010-12-15 01:58:44', NULL, '1'),
(20803, '02', '08', '03', 'COMANDANTE NOEL', '2010-12-15 01:58:44', NULL, '1'),
(20804, '02', '08', '04', 'YAUTAN', '2010-12-15 01:58:44', NULL, '1'),
(20900, '02', '09', '00', 'CORONGO', '2010-12-15 01:58:44', NULL, '1'),
(20901, '02', '09', '01', 'CORONGO', '2010-12-15 01:58:44', NULL, '1'),
(20902, '02', '09', '02', 'ACO', '2010-12-15 01:58:44', NULL, '1'),
(20903, '02', '09', '03', 'BAMBAS', '2010-12-15 01:58:44', NULL, '1'),
(20904, '02', '09', '04', 'CUSCA', '2010-12-15 01:58:44', NULL, '1'),
(20905, '02', '09', '05', 'LA PAMPA', '2010-12-15 01:58:44', NULL, '1'),
(20906, '02', '09', '06', 'YANAC', '2010-12-15 01:58:44', NULL, '1'),
(20907, '02', '09', '07', 'YUPAN', '2010-12-15 01:58:44', NULL, '1'),
(21000, '02', '10', '00', 'HUARI', '2010-12-15 01:58:44', NULL, '1'),
(21001, '02', '10', '01', 'HUARI', '2010-12-15 01:58:44', NULL, '1'),
(21002, '02', '10', '02', 'ANRA', '2010-12-15 01:58:44', NULL, '1'),
(21003, '02', '10', '03', 'CAJAY', '2010-12-15 01:58:44', NULL, '1'),
(21004, '02', '10', '04', 'CHAVIN DE HUANTAR', '2010-12-15 01:58:44', NULL, '1'),
(21005, '02', '10', '05', 'HUACACHI', '2010-12-15 01:58:44', NULL, '1'),
(21006, '02', '10', '06', 'HUACCHIS', '2010-12-15 01:58:44', NULL, '1'),
(21007, '02', '10', '07', 'HUACHIS', '2010-12-15 01:58:44', NULL, '1'),
(21008, '02', '10', '08', 'HUANTAR', '2010-12-15 01:58:44', NULL, '1'),
(21009, '02', '10', '09', 'MASIN', '2010-12-15 01:58:44', NULL, '1'),
(21010, '02', '10', '10', 'PAUCAS', '2010-12-15 01:58:44', NULL, '1'),
(21011, '02', '10', '11', 'PONTO', '2010-12-15 01:58:44', NULL, '1'),
(21012, '02', '10', '12', 'RAHUAPAMPA', '2010-12-15 01:58:44', NULL, '1'),
(21013, '02', '10', '13', 'RAPAYAN', '2010-12-15 01:58:44', NULL, '1'),
(21014, '02', '10', '14', 'SAN MARCOS', '2010-12-15 01:58:44', NULL, '1'),
(21015, '02', '10', '15', 'SAN PEDRO DE CHANA', '2010-12-15 01:58:44', NULL, '1'),
(21016, '02', '10', '16', 'UCO', '2010-12-15 01:58:44', NULL, '1'),
(21100, '02', '11', '00', 'HUARMEY', '2010-12-15 01:58:44', NULL, '1'),
(21101, '02', '11', '01', 'HUARMEY', '2010-12-15 01:58:44', NULL, '1'),
(21102, '02', '11', '02', 'COCHAPETI', '2010-12-15 01:58:44', NULL, '1'),
(21103, '02', '11', '03', 'CULEBRAS', '2010-12-15 01:58:44', NULL, '1'),
(21104, '02', '11', '04', 'HUAYAN', '2010-12-15 01:58:44', NULL, '1'),
(21105, '02', '11', '05', 'MALVAS', '2010-12-15 01:58:44', NULL, '1'),
(21200, '02', '12', '00', 'HUAYLAS', '2010-12-15 01:58:44', NULL, '1'),
(21201, '02', '12', '01', 'CARAZ', '2010-12-15 01:58:44', NULL, '1'),
(21202, '02', '12', '02', 'HUALLANCA', '2010-12-15 01:58:44', NULL, '1'),
(21203, '02', '12', '03', 'HUATA', '2010-12-15 01:58:44', NULL, '1'),
(21204, '02', '12', '04', 'HUAYLAS', '2010-12-15 01:58:44', NULL, '1'),
(21205, '02', '12', '05', 'MATO', '2010-12-15 01:58:44', NULL, '1'),
(21206, '02', '12', '06', 'PAMPAROMAS', '2010-12-15 01:58:44', NULL, '1'),
(21207, '02', '12', '07', 'PUEBLO LIBRE', '2010-12-15 01:58:44', NULL, '1'),
(21208, '02', '12', '08', 'SANTA CRUZ', '2010-12-15 01:58:44', NULL, '1'),
(21209, '02', '12', '09', 'SANTO TORIBIO', '2010-12-15 01:58:44', NULL, '1'),
(21210, '02', '12', '10', 'YURACMARCA', '2010-12-15 01:58:44', NULL, '1'),
(21300, '02', '13', '00', 'MARISCAL LUZURIAGA', '2010-12-15 01:58:44', NULL, '1'),
(21301, '02', '13', '01', 'PISCOBAMBA', '2010-12-15 01:58:44', NULL, '1'),
(21302, '02', '13', '02', 'CASCA', '2010-12-15 01:58:44', NULL, '1'),
(21303, '02', '13', '03', 'ELEAZAR GUZMAN BARRON', '2010-12-15 01:58:44', NULL, '1'),
(21304, '02', '13', '04', 'FIDEL OLIVAS ESCUDERO', '2010-12-15 01:58:44', NULL, '1'),
(21305, '02', '13', '05', 'LLAMA', '2010-12-15 01:58:44', NULL, '1'),
(21306, '02', '13', '06', 'LLUMPA', '2010-12-15 01:58:44', NULL, '1'),
(21307, '02', '13', '07', 'LUCMA', '2010-12-15 01:58:44', NULL, '1'),
(21308, '02', '13', '08', 'MUSGA', '2010-12-15 01:58:44', NULL, '1'),
(21400, '02', '14', '00', 'OCROS', '2010-12-15 01:58:44', NULL, '1'),
(21401, '02', '14', '01', 'OCROS', '2010-12-15 01:58:44', NULL, '1'),
(21402, '02', '14', '02', 'ACAS', '2010-12-15 01:58:44', NULL, '1'),
(21403, '02', '14', '03', 'CAJAMARQUILLA', '2010-12-15 01:58:44', NULL, '1'),
(21404, '02', '14', '04', 'CARHUAPAMPA', '2010-12-15 01:58:44', NULL, '1'),
(21405, '02', '14', '05', 'COCHAS', '2010-12-15 01:58:44', NULL, '1'),
(21406, '02', '14', '06', 'CONGAS', '2010-12-15 01:58:44', NULL, '1'),
(21407, '02', '14', '07', 'LLIPA', '2010-12-15 01:58:44', NULL, '1'),
(21408, '02', '14', '08', 'SAN CRISTOBAL DE RAJAN', '2010-12-15 01:58:44', NULL, '1'),
(21409, '02', '14', '09', 'SAN PEDRO', '2010-12-15 01:58:44', NULL, '1'),
(21410, '02', '14', '10', 'SANTIAGO DE CHILCAS', '2010-12-15 01:58:44', NULL, '1'),
(21500, '02', '15', '00', 'PALLASCA', '2010-12-15 01:58:44', NULL, '1'),
(21501, '02', '15', '01', 'CABANA', '2010-12-15 01:58:44', NULL, '1'),
(21502, '02', '15', '02', 'BOLOGNESI', '2010-12-15 01:58:44', NULL, '1'),
(21503, '02', '15', '03', 'CONCHUCOS', '2010-12-15 01:58:44', NULL, '1'),
(21504, '02', '15', '04', 'HUACASCHUQUE', '2010-12-15 01:58:44', NULL, '1'),
(21505, '02', '15', '05', 'HUANDOVAL', '2010-12-15 01:58:44', NULL, '1'),
(21506, '02', '15', '06', 'LACABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(21507, '02', '15', '07', 'LLAPO', '2010-12-15 01:58:44', NULL, '1'),
(21508, '02', '15', '08', 'PALLASCA', '2010-12-15 01:58:44', NULL, '1'),
(21509, '02', '15', '09', 'PAMPAS', '2010-12-15 01:58:44', NULL, '1'),
(21510, '02', '15', '10', 'SANTA ROSA', '2010-12-15 01:58:44', NULL, '1'),
(21511, '02', '15', '11', 'TAUCA', '2010-12-15 01:58:44', NULL, '1'),
(21600, '02', '16', '00', 'POMABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(21601, '02', '16', '01', 'POMABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(21602, '02', '16', '02', 'HUAYLLAN', '2010-12-15 01:58:44', NULL, '1'),
(21603, '02', '16', '03', 'PAROBAMBA', '2010-12-15 01:58:44', NULL, '1'),
(21604, '02', '16', '04', 'QUINUABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(21700, '02', '17', '00', 'RECUAY', '2010-12-15 01:58:44', NULL, '1'),
(21701, '02', '17', '01', 'RECUAY', '2010-12-15 01:58:44', NULL, '1'),
(21702, '02', '17', '02', 'CATAC', '2010-12-15 01:58:44', NULL, '1'),
(21703, '02', '17', '03', 'COTAPARACO', '2010-12-15 01:58:44', NULL, '1'),
(21704, '02', '17', '04', 'HUAYLLAPAMPA', '2010-12-15 01:58:44', NULL, '1'),
(21705, '02', '17', '05', 'LLACLLIN', '2010-12-15 01:58:44', NULL, '1'),
(21706, '02', '17', '06', 'MARCA', '2010-12-15 01:58:44', NULL, '1'),
(21707, '02', '17', '07', 'PAMPAS CHICO', '2010-12-15 01:58:44', NULL, '1'),
(21708, '02', '17', '08', 'PARARIN', '2010-12-15 01:58:44', NULL, '1'),
(21709, '02', '17', '09', 'TAPACOCHA', '2010-12-15 01:58:44', NULL, '1'),
(21710, '02', '17', '10', 'TICAPAMPA', '2010-12-15 01:58:44', NULL, '1'),
(21800, '02', '18', '00', 'SANTA', '2010-12-15 01:58:44', NULL, '1'),
(21801, '02', '18', '01', 'CHIMBOTE', '2010-12-15 01:58:44', NULL, '1'),
(21802, '02', '18', '02', 'CACERES DEL PERU', '2010-12-15 01:58:44', NULL, '1'),
(21803, '02', '18', '03', 'COISHCO', '2010-12-15 01:58:44', NULL, '1'),
(21804, '02', '18', '04', 'MACATE', '2010-12-15 01:58:44', NULL, '1'),
(21805, '02', '18', '05', 'MORO', '2010-12-15 01:58:44', NULL, '1'),
(21806, '02', '18', '06', 'NEPEÃ‘A', '2010-12-15 01:58:44', NULL, '1'),
(21807, '02', '18', '07', 'SAMANCO', '2010-12-15 01:58:44', NULL, '1'),
(21808, '02', '18', '08', 'SANTA', '2010-12-15 01:58:44', NULL, '1'),
(21809, '02', '18', '09', 'NUEVO CHIMBOTE', '2010-12-15 01:58:44', NULL, '1'),
(21900, '02', '19', '00', 'SIHUAS', '2010-12-15 01:58:44', NULL, '1'),
(21901, '02', '19', '01', 'SIHUAS', '2010-12-15 01:58:44', NULL, '1'),
(21902, '02', '19', '02', 'ACOBAMBA', '2010-12-15 01:58:44', NULL, '1'),
(21903, '02', '19', '03', 'ALFONSO UGARTE', '2010-12-15 01:58:44', NULL, '1'),
(21904, '02', '19', '04', 'CASHAPAMPA', '2010-12-15 01:58:44', NULL, '1'),
(21905, '02', '19', '05', 'CHINGALPO', '2010-12-15 01:58:44', NULL, '1'),
(21906, '02', '19', '06', 'HUAYLLABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(21907, '02', '19', '07', 'QUICHES', '2010-12-15 01:58:44', NULL, '1'),
(21908, '02', '19', '08', 'RAGASH', '2010-12-15 01:58:44', NULL, '1'),
(21909, '02', '19', '09', 'SAN JUAN', '2010-12-15 01:58:44', NULL, '1'),
(21910, '02', '19', '10', 'SICSIBAMBA', '2010-12-15 01:58:44', NULL, '1'),
(22000, '02', '20', '00', 'YUNGAY', '2010-12-15 01:58:44', NULL, '1'),
(22001, '02', '20', '01', 'YUNGAY', '2010-12-15 01:58:44', NULL, '1'),
(22002, '02', '20', '02', 'CASCAPARA', '2010-12-15 01:58:44', NULL, '1'),
(22003, '02', '20', '03', 'MANCOS', '2010-12-15 01:58:44', NULL, '1'),
(22004, '02', '20', '04', 'MATACOTO', '2010-12-15 01:58:44', NULL, '1'),
(22005, '02', '20', '05', 'QUILLO', '2010-12-15 01:58:44', NULL, '1'),
(22006, '02', '20', '06', 'RANRAHIRCA', '2010-12-15 01:58:44', NULL, '1'),
(22007, '02', '20', '07', 'SHUPLUY', '2010-12-15 01:58:44', NULL, '1'),
(22008, '02', '20', '08', 'YANAMA', '2010-12-15 01:58:44', NULL, '1'),
(30000, '03', '00', '00', 'APURIMAC', '2010-12-15 01:58:44', NULL, '1'),
(30100, '03', '01', '00', 'ABANCAY', '2010-12-15 01:58:44', NULL, '1'),
(30101, '03', '01', '01', 'ABANCAY', '2010-12-15 01:58:44', NULL, '1'),
(30102, '03', '01', '02', 'CHACOCHE', '2010-12-15 01:58:44', NULL, '1'),
(30103, '03', '01', '03', 'CIRCA', '2010-12-15 01:58:44', NULL, '1'),
(30104, '03', '01', '04', 'CURAHUASI', '2010-12-15 01:58:44', NULL, '1'),
(30105, '03', '01', '05', 'HUANIPACA', '2010-12-15 01:58:44', NULL, '1'),
(30106, '03', '01', '06', 'LAMBRAMA', '2010-12-15 01:58:44', NULL, '1'),
(30107, '03', '01', '07', 'PICHIRHUA', '2010-12-15 01:58:44', NULL, '1'),
(30108, '03', '01', '08', 'SAN PEDRO DE CACHORA', '2010-12-15 01:58:44', NULL, '1'),
(30109, '03', '01', '09', 'TAMBURCO', '2010-12-15 01:58:44', NULL, '1'),
(30200, '03', '02', '00', 'ANDAHUAYLAS', '2010-12-15 01:58:44', NULL, '1'),
(30201, '03', '02', '01', 'ANDAHUAYLAS', '2010-12-15 01:58:44', NULL, '1'),
(30202, '03', '02', '02', 'ANDARAPA', '2010-12-15 01:58:44', NULL, '1'),
(30203, '03', '02', '03', 'CHIARA', '2010-12-15 01:58:44', NULL, '1'),
(30204, '03', '02', '04', 'HUANCARAMA', '2010-12-15 01:58:44', NULL, '1'),
(30205, '03', '02', '05', 'HUANCARAY', '2010-12-15 01:58:44', NULL, '1'),
(30206, '03', '02', '06', 'HUAYANA', '2010-12-15 01:58:44', NULL, '1'),
(30207, '03', '02', '07', 'KISHUARA', '2010-12-15 01:58:44', NULL, '1'),
(30208, '03', '02', '08', 'PACOBAMBA', '2010-12-15 01:58:44', NULL, '1'),
(30209, '03', '02', '09', 'PACUCHA', '2010-12-15 01:58:44', NULL, '1'),
(30210, '03', '02', '10', 'PAMPACHIRI', '2010-12-15 01:58:44', NULL, '1'),
(30211, '03', '02', '11', 'POMACOCHA', '2010-12-15 01:58:44', NULL, '1'),
(30212, '03', '02', '12', 'SAN ANTONIO DE CACHI', '2010-12-15 01:58:44', NULL, '1'),
(30213, '03', '02', '13', 'SAN JERONIMO', '2010-12-15 01:58:44', NULL, '1'),
(30214, '03', '02', '14', 'SAN MIGUEL DE CHACCRAMPA', '2010-12-15 01:58:44', NULL, '1'),
(30215, '03', '02', '15', 'SANTA MARIA DE CHICMO', '2010-12-15 01:58:44', NULL, '1'),
(30216, '03', '02', '16', 'TALAVERA', '2010-12-15 01:58:44', NULL, '1'),
(30217, '03', '02', '17', 'TUMAY HUARACA', '2010-12-15 01:58:44', NULL, '1'),
(30218, '03', '02', '18', 'TURPO', '2010-12-15 01:58:44', NULL, '1'),
(30219, '03', '02', '19', 'KAQUIABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(30300, '03', '03', '00', 'ANTABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(30301, '03', '03', '01', 'ANTABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(30302, '03', '03', '02', 'EL ORO', '2010-12-15 01:58:44', NULL, '1'),
(30303, '03', '03', '03', 'HUAQUIRCA', '2010-12-15 01:58:44', NULL, '1'),
(30304, '03', '03', '04', 'JUAN ESPINOZA MEDRANO', '2010-12-15 01:58:44', NULL, '1'),
(30305, '03', '03', '05', 'OROPESA', '2010-12-15 01:58:44', NULL, '1'),
(30306, '03', '03', '06', 'PACHACONAS', '2010-12-15 01:58:44', NULL, '1'),
(30307, '03', '03', '07', 'SABAINO', '2010-12-15 01:58:44', NULL, '1'),
(30400, '03', '04', '00', 'AYMARAES', '2010-12-15 01:58:44', NULL, '1'),
(30401, '03', '04', '01', 'CHALHUANCA', '2010-12-15 01:58:44', NULL, '1'),
(30402, '03', '04', '02', 'CAPAYA', '2010-12-15 01:58:44', NULL, '1'),
(30403, '03', '04', '03', 'CARAYBAMBA', '2010-12-15 01:58:44', NULL, '1'),
(30404, '03', '04', '04', 'CHAPIMARCA', '2010-12-15 01:58:44', NULL, '1'),
(30405, '03', '04', '05', 'COLCABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(30406, '03', '04', '06', 'COTARUSE', '2010-12-15 01:58:44', NULL, '1'),
(30407, '03', '04', '07', 'HUAYLLO', '2010-12-15 01:58:44', NULL, '1'),
(30408, '03', '04', '08', 'JUSTO APU SAHUARAURA', '2010-12-15 01:58:44', NULL, '1'),
(30409, '03', '04', '09', 'LUCRE', '2010-12-15 01:58:44', NULL, '1'),
(30410, '03', '04', '10', 'POCOHUANCA', '2010-12-15 01:58:44', NULL, '1'),
(30411, '03', '04', '11', 'SAN JUAN DE CHACÃ‘A', '2010-12-15 01:58:44', NULL, '1'),
(30412, '03', '04', '12', 'SAÃ‘AYCA', '2010-12-15 01:58:44', NULL, '1'),
(30413, '03', '04', '13', 'SORAYA', '2010-12-15 01:58:44', NULL, '1'),
(30414, '03', '04', '14', 'TAPAIRIHUA', '2010-12-15 01:58:44', NULL, '1'),
(30415, '03', '04', '15', 'TINTAY', '2010-12-15 01:58:44', NULL, '1'),
(30416, '03', '04', '16', 'TORAYA', '2010-12-15 01:58:44', NULL, '1'),
(30417, '03', '04', '17', 'YANACA', '2010-12-15 01:58:44', NULL, '1'),
(30500, '03', '05', '00', 'COTABAMBAS', '2010-12-15 01:58:44', NULL, '1'),
(30501, '03', '05', '01', 'TAMBOBAMBA', '2010-12-15 01:58:44', NULL, '1'),
(30502, '03', '05', '02', 'COTABAMBAS', '2010-12-15 01:58:44', NULL, '1'),
(30503, '03', '05', '03', 'COYLLURQUI', '2010-12-15 01:58:44', NULL, '1'),
(30504, '03', '05', '04', 'HAQUIRA', '2010-12-15 01:58:44', NULL, '1'),
(30505, '03', '05', '05', 'MARA', '2010-12-15 01:58:44', NULL, '1'),
(30506, '03', '05', '06', 'CHALLHUAHUACHO', '2010-12-15 01:58:44', NULL, '1'),
(30600, '03', '06', '00', 'CHINCHEROS', '2010-12-15 01:58:44', NULL, '1'),
(30601, '03', '06', '01', 'CHINCHEROS', '2010-12-15 01:58:44', NULL, '1'),
(30602, '03', '06', '02', 'ANCO_HUALLO', '2010-12-15 01:58:44', NULL, '1'),
(30603, '03', '06', '03', 'COCHARCAS', '2010-12-15 01:58:44', NULL, '1'),
(30604, '03', '06', '04', 'HUACCANA', '2010-12-15 01:58:44', NULL, '1'),
(30605, '03', '06', '05', 'OCOBAMBA', '2010-12-15 01:58:44', NULL, '1'),
(30606, '03', '06', '06', 'ONGOY', '2010-12-15 01:58:44', NULL, '1'),
(30607, '03', '06', '07', 'URANMARCA', '2010-12-15 01:58:44', NULL, '1'),
(30608, '03', '06', '08', 'RANRACANCHA', '2010-12-15 01:58:44', NULL, '1'),
(30700, '03', '07', '00', 'GRAU', '2010-12-15 01:58:44', NULL, '1'),
(30701, '03', '07', '01', 'CHUQUIBAMBILLA', '2010-12-15 01:58:44', NULL, '1'),
(30702, '03', '07', '02', 'CURPAHUASI', '2010-12-15 01:58:44', NULL, '1'),
(30703, '03', '07', '03', 'GAMARRA', '2010-12-15 01:58:44', NULL, '1'),
(30704, '03', '07', '04', 'HUAYLLATI', '2010-12-15 01:58:44', NULL, '1'),
(30705, '03', '07', '05', 'MAMARA', '2010-12-15 01:58:44', NULL, '1'),
(30706, '03', '07', '06', 'MICAELA BASTIDAS', '2010-12-15 01:58:44', NULL, '1'),
(30707, '03', '07', '07', 'PATAYPAMPA', '2010-12-15 01:58:44', NULL, '1'),
(30708, '03', '07', '08', 'PROGRESO', '2010-12-15 01:58:44', NULL, '1'),
(30709, '03', '07', '09', 'SAN ANTONIO', '2010-12-15 01:58:44', NULL, '1'),
(30710, '03', '07', '10', 'SANTA ROSA', '2010-12-15 01:58:44', NULL, '1'),
(30711, '03', '07', '11', 'TURPAY', '2010-12-15 01:58:44', NULL, '1'),
(30712, '03', '07', '12', 'VILCABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(30713, '03', '07', '13', 'VIRUNDO', '2010-12-15 01:58:44', NULL, '1'),
(30714, '03', '07', '14', 'CURASCO', '2010-12-15 01:58:44', NULL, '1'),
(40000, '04', '00', '00', 'AREQUIPA', '2010-12-15 01:58:44', NULL, '1'),
(40100, '04', '01', '00', 'AREQUIPA', '2010-12-15 01:58:44', NULL, '1'),
(40101, '04', '01', '01', 'AREQUIPA', '2010-12-15 01:58:44', NULL, '1'),
(40102, '04', '01', '02', 'ALTO SELVA ALEGRE', '2010-12-15 01:58:44', NULL, '1'),
(40103, '04', '01', '03', 'CAYMA', '2010-12-15 01:58:44', NULL, '1'),
(40104, '04', '01', '04', 'CERRO COLORADO', '2010-12-15 01:58:44', NULL, '1'),
(40105, '04', '01', '05', 'CHARACATO', '2010-12-15 01:58:44', NULL, '1'),
(40106, '04', '01', '06', 'CHIGUATA', '2010-12-15 01:58:44', NULL, '1'),
(40107, '04', '01', '07', 'JACOBO HUNTER', '2010-12-15 01:58:44', NULL, '1'),
(40108, '04', '01', '08', 'LA JOYA', '2010-12-15 01:58:44', NULL, '1'),
(40109, '04', '01', '09', 'MARIANO MELGAR', '2010-12-15 01:58:44', NULL, '1'),
(40110, '04', '01', '10', 'MIRAFLORES', '2010-12-15 01:58:44', NULL, '1'),
(40111, '04', '01', '11', 'MOLLEBAYA', '2010-12-15 01:58:44', NULL, '1'),
(40112, '04', '01', '12', 'PAUCARPATA', '2010-12-15 01:58:44', NULL, '1'),
(40113, '04', '01', '13', 'POCSI', '2010-12-15 01:58:44', NULL, '1'),
(40114, '04', '01', '14', 'POLOBAYA', '2010-12-15 01:58:44', NULL, '1'),
(40115, '04', '01', '15', 'QUEQUEÃ‘A', '2010-12-15 01:58:44', NULL, '1'),
(40116, '04', '01', '16', 'SABANDIA', '2010-12-15 01:58:44', NULL, '1'),
(40117, '04', '01', '17', 'SACHACA', '2010-12-15 01:58:44', NULL, '1'),
(40118, '04', '01', '18', 'SAN JUAN DE SIGUAS', '2010-12-15 01:58:44', NULL, '1'),
(40119, '04', '01', '19', 'SAN JUAN DE TARUCANI', '2010-12-15 01:58:44', NULL, '1'),
(40120, '04', '01', '20', 'SANTA ISABEL DE SIGUAS', '2010-12-15 01:58:44', NULL, '1'),
(40121, '04', '01', '21', 'SANTA RITA DE SIGUAS', '2010-12-15 01:58:44', NULL, '1'),
(40122, '04', '01', '22', 'SOCABAYA', '2010-12-15 01:58:44', NULL, '1'),
(40123, '04', '01', '23', 'TIABAYA', '2010-12-15 01:58:44', NULL, '1'),
(40124, '04', '01', '24', 'UCHUMAYO', '2010-12-15 01:58:44', NULL, '1'),
(40125, '04', '01', '25', 'VITOR', '2010-12-15 01:58:44', NULL, '1'),
(40126, '04', '01', '26', 'YANAHUARA', '2010-12-15 01:58:44', NULL, '1'),
(40127, '04', '01', '27', 'YARABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(40128, '04', '01', '28', 'YURA', '2010-12-15 01:58:44', NULL, '1'),
(40129, '04', '01', '29', 'JOSE LUIS BUSTAMANTE Y RIVERO', '2010-12-15 01:58:44', NULL, '1'),
(40200, '04', '02', '00', 'CAMANA', '2010-12-15 01:58:44', NULL, '1'),
(40201, '04', '02', '01', 'CAMANA', '2010-12-15 01:58:44', NULL, '1'),
(40202, '04', '02', '02', 'JOSE MARIA QUIMPER', '2010-12-15 01:58:44', NULL, '1'),
(40203, '04', '02', '03', 'MARIANO NICOLAS VALCARCEL', '2010-12-15 01:58:44', NULL, '1'),
(40204, '04', '02', '04', 'MARISCAL CACERES', '2010-12-15 01:58:44', NULL, '1'),
(40205, '04', '02', '05', 'NICOLAS DE PIEROLA', '2010-12-15 01:58:44', NULL, '1'),
(40206, '04', '02', '06', 'OCOÃ‘A', '2010-12-15 01:58:44', NULL, '1'),
(40207, '04', '02', '07', 'QUILCA', '2010-12-15 01:58:44', NULL, '1'),
(40208, '04', '02', '08', 'SAMUEL PASTOR', '2010-12-15 01:58:44', NULL, '1'),
(40300, '04', '03', '00', 'CARAVELI', '2010-12-15 01:58:44', NULL, '1'),
(40301, '04', '03', '01', 'CARAVELI', '2010-12-15 01:58:44', NULL, '1'),
(40302, '04', '03', '02', 'ACARI', '2010-12-15 01:58:44', NULL, '1'),
(40303, '04', '03', '03', 'ATICO', '2010-12-15 01:58:44', NULL, '1'),
(40304, '04', '03', '04', 'ATIQUIPA', '2010-12-15 01:58:44', NULL, '1'),
(40305, '04', '03', '05', 'BELLA UNION', '2010-12-15 01:58:44', NULL, '1'),
(40306, '04', '03', '06', 'CAHUACHO', '2010-12-15 01:58:44', NULL, '1'),
(40307, '04', '03', '07', 'CHALA', '2010-12-15 01:58:44', NULL, '1'),
(40308, '04', '03', '08', 'CHAPARRA', '2010-12-15 01:58:44', NULL, '1'),
(40309, '04', '03', '09', 'HUANUHUANU', '2010-12-15 01:58:44', NULL, '1'),
(40310, '04', '03', '10', 'JAQUI', '2010-12-15 01:58:44', NULL, '1'),
(40311, '04', '03', '11', 'LOMAS', '2010-12-15 01:58:44', NULL, '1'),
(40312, '04', '03', '12', 'QUICACHA', '2010-12-15 01:58:44', NULL, '1'),
(40313, '04', '03', '13', 'YAUCA', '2010-12-15 01:58:44', NULL, '1'),
(40400, '04', '04', '00', 'CASTILLA', '2010-12-15 01:58:44', NULL, '1'),
(40401, '04', '04', '01', 'APLAO', '2010-12-15 01:58:44', NULL, '1'),
(40402, '04', '04', '02', 'ANDAGUA', '2010-12-15 01:58:44', NULL, '1'),
(40403, '04', '04', '03', 'AYO', '2010-12-15 01:58:44', NULL, '1'),
(40404, '04', '04', '04', 'CHACHAS', '2010-12-15 01:58:44', NULL, '1'),
(40405, '04', '04', '05', 'CHILCAYMARCA', '2010-12-15 01:58:44', NULL, '1'),
(40406, '04', '04', '06', 'CHOCO', '2010-12-15 01:58:44', NULL, '1'),
(40407, '04', '04', '07', 'HUANCARQUI', '2010-12-15 01:58:44', NULL, '1'),
(40408, '04', '04', '08', 'MACHAGUAY', '2010-12-15 01:58:44', NULL, '1'),
(40409, '04', '04', '09', 'ORCOPAMPA', '2010-12-15 01:58:44', NULL, '1'),
(40410, '04', '04', '10', 'PAMPACOLCA', '2010-12-15 01:58:44', NULL, '1'),
(40411, '04', '04', '11', 'TIPAN', '2010-12-15 01:58:44', NULL, '1'),
(40412, '04', '04', '12', 'UÃ‘ON', '2010-12-15 01:58:44', NULL, '1'),
(40413, '04', '04', '13', 'URACA', '2010-12-15 01:58:44', NULL, '1'),
(40414, '04', '04', '14', 'VIRACO', '2010-12-15 01:58:44', NULL, '1'),
(40500, '04', '05', '00', 'CAYLLOMA', '2010-12-15 01:58:44', NULL, '1'),
(40501, '04', '05', '01', 'CHIVAY', '2010-12-15 01:58:44', NULL, '1'),
(40502, '04', '05', '02', 'ACHOMA', '2010-12-15 01:58:44', NULL, '1'),
(40503, '04', '05', '03', 'CABANACONDE', '2010-12-15 01:58:44', NULL, '1'),
(40504, '04', '05', '04', 'CALLALLI', '2010-12-15 01:58:44', NULL, '1'),
(40505, '04', '05', '05', 'CAYLLOMA', '2010-12-15 01:58:44', NULL, '1'),
(40506, '04', '05', '06', 'COPORAQUE', '2010-12-15 01:58:44', NULL, '1'),
(40507, '04', '05', '07', 'HUAMBO', '2010-12-15 01:58:44', NULL, '1'),
(40508, '04', '05', '08', 'HUANCA', '2010-12-15 01:58:44', NULL, '1'),
(40509, '04', '05', '09', 'ICHUPAMPA', '2010-12-15 01:58:44', NULL, '1'),
(40510, '04', '05', '10', 'LARI', '2010-12-15 01:58:44', NULL, '1'),
(40511, '04', '05', '11', 'LLUTA', '2010-12-15 01:58:44', NULL, '1'),
(40512, '04', '05', '12', 'MACA', '2010-12-15 01:58:44', NULL, '1'),
(40513, '04', '05', '13', 'MADRIGAL', '2010-12-15 01:58:44', NULL, '1'),
(40514, '04', '05', '14', 'SAN ANTONIO DE CHUCA', '2010-12-15 01:58:44', NULL, '1'),
(40515, '04', '05', '15', 'SIBAYO', '2010-12-15 01:58:44', NULL, '1'),
(40516, '04', '05', '16', 'TAPAY', '2010-12-15 01:58:44', NULL, '1'),
(40517, '04', '05', '17', 'TISCO', '2010-12-15 01:58:44', NULL, '1'),
(40518, '04', '05', '18', 'TUTI', '2010-12-15 01:58:44', NULL, '1'),
(40519, '04', '05', '19', 'YANQUE', '2010-12-15 01:58:44', NULL, '1'),
(40520, '04', '05', '20', 'MAJES', '2010-12-15 01:58:44', NULL, '1'),
(40600, '04', '06', '00', 'CONDESUYOS', '2010-12-15 01:58:44', NULL, '1'),
(40601, '04', '06', '01', 'CHUQUIBAMBA', '2010-12-15 01:58:44', NULL, '1'),
(40602, '04', '06', '02', 'ANDARAY', '2010-12-15 01:58:44', NULL, '1'),
(40603, '04', '06', '03', 'CAYARANI', '2010-12-15 01:58:44', NULL, '1'),
(40604, '04', '06', '04', 'CHICHAS', '2010-12-15 01:58:44', NULL, '1'),
(40605, '04', '06', '05', 'IRAY', '2010-12-15 01:58:44', NULL, '1'),
(40606, '04', '06', '06', 'RIO GRANDE', '2010-12-15 01:58:44', NULL, '1'),
(40607, '04', '06', '07', 'SALAMANCA', '2010-12-15 01:58:44', NULL, '1'),
(40608, '04', '06', '08', 'YANAQUIHUA', '2010-12-15 01:58:44', NULL, '1'),
(40700, '04', '07', '00', 'ISLAY', '2010-12-15 01:58:44', NULL, '1'),
(40701, '04', '07', '01', 'MOLLENDO', '2010-12-15 01:58:44', NULL, '1'),
(40702, '04', '07', '02', 'COCACHACRA', '2010-12-15 01:58:44', NULL, '1'),
(40703, '04', '07', '03', 'DEAN VALDIVIA', '2010-12-15 01:58:44', NULL, '1'),
(40704, '04', '07', '04', 'ISLAY', '2010-12-15 01:58:44', NULL, '1'),
(40705, '04', '07', '05', 'MEJIA', '2010-12-15 01:58:44', NULL, '1'),
(40706, '04', '07', '06', 'PUNTA DE BOMBON', '2010-12-15 01:58:44', NULL, '1'),
(40800, '04', '08', '00', 'LA UNION', '2010-12-15 01:58:44', NULL, '1'),
(40801, '04', '08', '01', 'COTAHUASI', '2010-12-15 01:58:44', NULL, '1'),
(40802, '04', '08', '02', 'ALCA', '2010-12-15 01:58:44', NULL, '1'),
(40803, '04', '08', '03', 'CHARCANA', '2010-12-15 01:58:44', NULL, '1'),
(40804, '04', '08', '04', 'HUAYNACOTAS', '2010-12-15 01:58:44', NULL, '1'),
(40805, '04', '08', '05', 'PAMPAMARCA', '2010-12-15 01:58:44', NULL, '1'),
(40806, '04', '08', '06', 'PUYCA', '2010-12-15 01:58:44', NULL, '1'),
(40807, '04', '08', '07', 'QUECHUALLA', '2010-12-15 01:58:44', NULL, '1'),
(40808, '04', '08', '08', 'SAYLA', '2010-12-15 01:58:44', NULL, '1'),
(40809, '04', '08', '09', 'TAURIA', '2010-12-15 01:58:44', NULL, '1'),
(40810, '04', '08', '10', 'TOMEPAMPA', '2010-12-15 01:58:44', NULL, '1'),
(40811, '04', '08', '11', 'TORO', '2010-12-15 01:58:44', NULL, '1'),
(50000, '05', '00', '00', 'AYACUCHO', '2010-12-15 01:58:44', NULL, '1'),
(50100, '05', '01', '00', 'HUAMANGA', '2010-12-15 01:58:44', NULL, '1'),
(50101, '05', '01', '01', 'AYACUCHO', '2010-12-15 01:58:44', NULL, '1'),
(50102, '05', '01', '02', 'ACOCRO', '2010-12-15 01:58:44', NULL, '1'),
(50103, '05', '01', '03', 'ACOS VINCHOS', '2010-12-15 01:58:44', NULL, '1'),
(50104, '05', '01', '04', 'CARMEN ALTO', '2010-12-15 01:58:44', NULL, '1'),
(50105, '05', '01', '05', 'CHIARA', '2010-12-15 01:58:44', NULL, '1'),
(50106, '05', '01', '06', 'OCROS', '2010-12-15 01:58:44', NULL, '1'),
(50107, '05', '01', '07', 'PACAYCASA', '2010-12-15 01:58:44', NULL, '1'),
(50108, '05', '01', '08', 'QUINUA', '2010-12-15 01:58:44', NULL, '1'),
(50109, '05', '01', '09', 'SAN JOSE DE TICLLAS', '2010-12-15 01:58:44', NULL, '1'),
(50110, '05', '01', '10', 'SAN JUAN BAUTISTA', '2010-12-15 01:58:44', NULL, '1'),
(50111, '05', '01', '11', 'SANTIAGO DE PISCHA', '2010-12-15 01:58:44', NULL, '1'),
(50112, '05', '01', '12', 'SOCOS', '2010-12-15 01:58:44', NULL, '1'),
(50113, '05', '01', '13', 'TAMBILLO', '2010-12-15 01:58:44', NULL, '1'),
(50114, '05', '01', '14', 'VINCHOS', '2010-12-15 01:58:44', NULL, '1'),
(50115, '05', '01', '15', 'JESUS NAZARENO', '2010-12-15 01:58:44', NULL, '1'),
(50200, '05', '02', '00', 'CANGALLO', '2010-12-15 01:58:44', NULL, '1'),
(50201, '05', '02', '01', 'CANGALLO', '2010-12-15 01:58:44', NULL, '1'),
(50202, '05', '02', '02', 'CHUSCHI', '2010-12-15 01:58:44', NULL, '1'),
(50203, '05', '02', '03', 'LOS MOROCHUCOS', '2010-12-15 01:58:44', NULL, '1'),
(50204, '05', '02', '04', 'MARIA PARADO DE BELLIDO', '2010-12-15 01:58:44', NULL, '1'),
(50205, '05', '02', '05', 'PARAS', '2010-12-15 01:58:44', NULL, '1'),
(50206, '05', '02', '06', 'TOTOS', '2010-12-15 01:58:44', NULL, '1'),
(50300, '05', '03', '00', 'HUANCA SANCOS', '2010-12-15 01:58:44', NULL, '1'),
(50301, '05', '03', '01', 'SANCOS', '2010-12-15 01:58:44', NULL, '1'),
(50302, '05', '03', '02', 'CARAPO', '2010-12-15 01:58:44', NULL, '1'),
(50303, '05', '03', '03', 'SACSAMARCA', '2010-12-15 01:58:44', NULL, '1'),
(50304, '05', '03', '04', 'SANTIAGO DE LUCANAMARCA', '2010-12-15 01:58:44', NULL, '1'),
(50400, '05', '04', '00', 'HUANTA', '2010-12-15 01:58:44', NULL, '1'),
(50401, '05', '04', '01', 'HUANTA', '2010-12-15 01:58:44', NULL, '1'),
(50402, '05', '04', '02', 'AYAHUANCO', '2010-12-15 01:58:44', NULL, '1'),
(50403, '05', '04', '03', 'HUAMANGUILLA', '2010-12-15 01:58:44', NULL, '1'),
(50404, '05', '04', '04', 'IGUAIN', '2010-12-15 01:58:44', NULL, '1'),
(50405, '05', '04', '05', 'LURICOCHA', '2010-12-15 01:58:44', NULL, '1'),
(50406, '05', '04', '06', 'SANTILLANA', '2010-12-15 01:58:44', NULL, '1'),
(50407, '05', '04', '07', 'SIVIA', '2010-12-15 01:58:44', NULL, '1'),
(50408, '05', '04', '08', 'LLOCHEGUA', '2010-12-15 01:58:44', NULL, '1'),
(50500, '05', '05', '00', 'LA MAR', '2010-12-15 01:58:44', NULL, '1'),
(50501, '05', '05', '01', 'SAN MIGUEL', '2010-12-15 01:58:44', NULL, '1'),
(50502, '05', '05', '02', 'ANCO', '2010-12-15 01:58:44', NULL, '1'),
(50503, '05', '05', '03', 'AYNA', '2010-12-15 01:58:44', NULL, '1'),
(50504, '05', '05', '04', 'CHILCAS', '2010-12-15 01:58:44', NULL, '1'),
(50505, '05', '05', '05', 'CHUNGUI', '2010-12-15 01:58:44', NULL, '1'),
(50506, '05', '05', '06', 'LUIS CARRANZA', '2010-12-15 01:58:44', NULL, '1'),
(50507, '05', '05', '07', 'SANTA ROSA', '2010-12-15 01:58:44', NULL, '1'),
(50508, '05', '05', '08', 'TAMBO', '2010-12-15 01:58:44', NULL, '1'),
(50600, '05', '06', '00', 'LUCANAS', '2010-12-15 01:58:44', NULL, '1'),
(50601, '05', '06', '01', 'PUQUIO', '2010-12-15 01:58:44', NULL, '1'),
(50602, '05', '06', '02', 'AUCARA', '2010-12-15 01:58:44', NULL, '1'),
(50603, '05', '06', '03', 'CABANA', '2010-12-15 01:58:44', NULL, '1'),
(50604, '05', '06', '04', 'CARMEN SALCEDO', '2010-12-15 01:58:44', NULL, '1'),
(50605, '05', '06', '05', 'CHAVIÃ‘A', '2010-12-15 01:58:44', NULL, '1'),
(50606, '05', '06', '06', 'CHIPAO', '2010-12-15 01:58:44', NULL, '1'),
(50607, '05', '06', '07', 'HUAC-HUAS', '2010-12-15 01:58:44', NULL, '1'),
(50608, '05', '06', '08', 'LARAMATE', '2010-12-15 01:58:44', NULL, '1'),
(50609, '05', '06', '09', 'LEONCIO PRADO', '2010-12-15 01:58:44', NULL, '1'),
(50610, '05', '06', '10', 'LLAUTA', '2010-12-15 01:58:44', NULL, '1'),
(50611, '05', '06', '11', 'LUCANAS', '2010-12-15 01:58:44', NULL, '1'),
(50612, '05', '06', '12', 'OCAÃ‘A', '2010-12-15 01:58:44', NULL, '1'),
(50613, '05', '06', '13', 'OTOCA', '2010-12-15 01:58:44', NULL, '1'),
(50614, '05', '06', '14', 'SAISA', '2010-12-15 01:58:44', NULL, '1'),
(50615, '05', '06', '15', 'SAN CRISTOBAL', '2010-12-15 01:58:44', NULL, '1'),
(50616, '05', '06', '16', 'SAN JUAN', '2010-12-15 01:58:44', NULL, '1'),
(50617, '05', '06', '17', 'SAN PEDRO', '2010-12-15 01:58:44', NULL, '1'),
(50618, '05', '06', '18', 'SAN PEDRO DE PALCO', '2010-12-15 01:58:44', NULL, '1'),
(50619, '05', '06', '19', 'SANCOS', '2010-12-15 01:58:44', NULL, '1'),
(50620, '05', '06', '20', 'SANTA ANA DE HUAYCAHUACHO', '2010-12-15 01:58:44', NULL, '1'),
(50621, '05', '06', '21', 'SANTA LUCIA', '2010-12-15 01:58:44', NULL, '1'),
(50700, '05', '07', '00', 'PARINACOCHAS', '2010-12-15 01:58:44', NULL, '1'),
(50701, '05', '07', '01', 'CORACORA', '2010-12-15 01:58:44', NULL, '1'),
(50702, '05', '07', '02', 'CHUMPI', '2010-12-15 01:58:44', NULL, '1'),
(50703, '05', '07', '03', 'CORONEL CASTAÃ‘EDA', '2010-12-15 01:58:44', NULL, '1'),
(50704, '05', '07', '04', 'PACAPAUSA', '2010-12-15 01:58:44', NULL, '1'),
(50705, '05', '07', '05', 'PULLO', '2010-12-15 01:58:44', NULL, '1'),
(50706, '05', '07', '06', 'PUYUSCA', '2010-12-15 01:58:44', NULL, '1'),
(50707, '05', '07', '07', 'SAN FRANCISCO DE RAVACAYCO', '2010-12-15 01:58:44', NULL, '1'),
(50708, '05', '07', '08', 'UPAHUACHO', '2010-12-15 01:58:44', NULL, '1'),
(50800, '05', '08', '00', 'PAUCAR DEL SARA SARA', '2010-12-15 01:58:44', NULL, '1'),
(50801, '05', '08', '01', 'PAUSA', '2010-12-15 01:58:44', NULL, '1'),
(50802, '05', '08', '02', 'COLTA', '2010-12-15 01:58:44', NULL, '1'),
(50803, '05', '08', '03', 'CORCULLA', '2010-12-15 01:58:44', NULL, '1'),
(50804, '05', '08', '04', 'LAMPA', '2010-12-15 01:58:44', NULL, '1'),
(50805, '05', '08', '05', 'MARCABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(50806, '05', '08', '06', 'OYOLO', '2010-12-15 01:58:44', NULL, '1'),
(50807, '05', '08', '07', 'PARARCA', '2010-12-15 01:58:44', NULL, '1'),
(50808, '05', '08', '08', 'SAN JAVIER DE ALPABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(50809, '05', '08', '09', 'SAN JOSE DE USHUA', '2010-12-15 01:58:44', NULL, '1'),
(50810, '05', '08', '10', 'SARA SARA', '2010-12-15 01:58:44', NULL, '1'),
(50900, '05', '09', '00', 'SUCRE', '2010-12-15 01:58:44', NULL, '1'),
(50901, '05', '09', '01', 'QUEROBAMBA', '2010-12-15 01:58:44', NULL, '1'),
(50902, '05', '09', '02', 'BELEN', '2010-12-15 01:58:44', NULL, '1'),
(50903, '05', '09', '03', 'CHALCOS', '2010-12-15 01:58:44', NULL, '1'),
(50904, '05', '09', '04', 'CHILCAYOC', '2010-12-15 01:58:44', NULL, '1'),
(50905, '05', '09', '05', 'HUACAÃ‘A', '2010-12-15 01:58:44', NULL, '1'),
(50906, '05', '09', '06', 'MORCOLLA', '2010-12-15 01:58:44', NULL, '1'),
(50907, '05', '09', '07', 'PAICO', '2010-12-15 01:58:44', NULL, '1'),
(50908, '05', '09', '08', 'SAN PEDRO DE LARCAY', '2010-12-15 01:58:44', NULL, '1'),
(50909, '05', '09', '09', 'SAN SALVADOR DE QUIJE', '2010-12-15 01:58:44', NULL, '1'),
(50910, '05', '09', '10', 'SANTIAGO DE PAUCARAY', '2010-12-15 01:58:44', NULL, '1'),
(50911, '05', '09', '11', 'SORAS', '2010-12-15 01:58:44', NULL, '1'),
(51000, '05', '10', '00', 'VICTOR FAJARDO', '2010-12-15 01:58:44', NULL, '1'),
(51001, '05', '10', '01', 'HUANCAPI', '2010-12-15 01:58:44', NULL, '1'),
(51002, '05', '10', '02', 'ALCAMENCA', '2010-12-15 01:58:44', NULL, '1'),
(51003, '05', '10', '03', 'APONGO', '2010-12-15 01:58:44', NULL, '1'),
(51004, '05', '10', '04', 'ASQUIPATA', '2010-12-15 01:58:44', NULL, '1'),
(51005, '05', '10', '05', 'CANARIA', '2010-12-15 01:58:44', NULL, '1'),
(51006, '05', '10', '06', 'CAYARA', '2010-12-15 01:58:44', NULL, '1'),
(51007, '05', '10', '07', 'COLCA', '2010-12-15 01:58:44', NULL, '1'),
(51008, '05', '10', '08', 'HUAMANQUIQUIA', '2010-12-15 01:58:44', NULL, '1'),
(51009, '05', '10', '09', 'HUANCARAYLLA', '2010-12-15 01:58:44', NULL, '1'),
(51010, '05', '10', '10', 'HUAYA', '2010-12-15 01:58:44', NULL, '1'),
(51011, '05', '10', '11', 'SARHUA', '2010-12-15 01:58:44', NULL, '1'),
(51012, '05', '10', '12', 'VILCANCHOS', '2010-12-15 01:58:44', NULL, '1'),
(51100, '05', '11', '00', 'VILCAS HUAMAN', '2010-12-15 01:58:44', NULL, '1'),
(51101, '05', '11', '01', 'VILCAS HUAMAN', '2010-12-15 01:58:44', NULL, '1'),
(51102, '05', '11', '02', 'ACCOMARCA', '2010-12-15 01:58:44', NULL, '1'),
(51103, '05', '11', '03', 'CARHUANCA', '2010-12-15 01:58:44', NULL, '1'),
(51104, '05', '11', '04', 'CONCEPCION', '2010-12-15 01:58:44', NULL, '1'),
(51105, '05', '11', '05', 'HUAMBALPA', '2010-12-15 01:58:44', NULL, '1'),
(51106, '05', '11', '06', 'INDEPENDENCIA', '2010-12-15 01:58:44', NULL, '1'),
(51107, '05', '11', '07', 'SAURAMA', '2010-12-15 01:58:44', NULL, '1'),
(51108, '05', '11', '08', 'VISCHONGO', '2010-12-15 01:58:44', NULL, '1'),
(60000, '06', '00', '00', 'CAJAMARCA', '2010-12-15 01:58:44', NULL, '1'),
(60100, '06', '01', '00', 'CAJAMARCA', '2010-12-15 01:58:44', NULL, '1'),
(60101, '06', '01', '01', 'CAJAMARCA', '2010-12-15 01:58:44', NULL, '1'),
(60102, '06', '01', '02', 'ASUNCION', '2010-12-15 01:58:44', NULL, '1'),
(60103, '06', '01', '03', 'CHETILLA', '2010-12-15 01:58:44', NULL, '1'),
(60104, '06', '01', '04', 'COSPAN', '2010-12-15 01:58:44', NULL, '1'),
(60105, '06', '01', '05', 'ENCAÃ‘ADA', '2010-12-15 01:58:44', NULL, '1'),
(60106, '06', '01', '06', 'JESUS', '2010-12-15 01:58:44', NULL, '1'),
(60107, '06', '01', '07', 'LLACANORA', '2010-12-15 01:58:44', NULL, '1'),
(60108, '06', '01', '08', 'LOS BAÃ‘OS DEL INCA', '2010-12-15 01:58:44', NULL, '1'),
(60109, '06', '01', '09', 'MAGDALENA', '2010-12-15 01:58:44', NULL, '1'),
(60110, '06', '01', '10', 'MATARA', '2010-12-15 01:58:44', NULL, '1'),
(60111, '06', '01', '11', 'NAMORA', '2010-12-15 01:58:44', NULL, '1'),
(60112, '06', '01', '12', 'SAN JUAN', '2010-12-15 01:58:44', NULL, '1'),
(60200, '06', '02', '00', 'CAJABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(60201, '06', '02', '01', 'CAJABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(60202, '06', '02', '02', 'CACHACHI', '2010-12-15 01:58:44', NULL, '1'),
(60203, '06', '02', '03', 'CONDEBAMBA', '2010-12-15 01:58:44', NULL, '1'),
(60204, '06', '02', '04', 'SITACOCHA', '2010-12-15 01:58:44', NULL, '1'),
(60300, '06', '03', '00', 'CELENDIN', '2010-12-15 01:58:44', NULL, '1'),
(60301, '06', '03', '01', 'CELENDIN', '2010-12-15 01:58:44', NULL, '1'),
(60302, '06', '03', '02', 'CHUMUCH', '2010-12-15 01:58:44', NULL, '1'),
(60303, '06', '03', '03', 'CORTEGANA', '2010-12-15 01:58:44', NULL, '1'),
(60304, '06', '03', '04', 'HUASMIN', '2010-12-15 01:58:44', NULL, '1'),
(60305, '06', '03', '05', 'JORGE CHAVEZ', '2010-12-15 01:58:44', NULL, '1'),
(60306, '06', '03', '06', 'JOSE GALVEZ', '2010-12-15 01:58:44', NULL, '1'),
(60307, '06', '03', '07', 'MIGUEL IGLESIAS', '2010-12-15 01:58:44', NULL, '1'),
(60308, '06', '03', '08', 'OXAMARCA', '2010-12-15 01:58:44', NULL, '1'),
(60309, '06', '03', '09', 'SOROCHUCO', '2010-12-15 01:58:44', NULL, '1'),
(60310, '06', '03', '10', 'SUCRE', '2010-12-15 01:58:44', NULL, '1'),
(60311, '06', '03', '11', 'UTCO', '2010-12-15 01:58:44', NULL, '1'),
(60312, '06', '03', '12', 'LA LIBERTAD DE PALLAN', '2010-12-15 01:58:44', NULL, '1'),
(60400, '06', '04', '00', 'CHOTA', '2010-12-15 01:58:44', NULL, '1'),
(60401, '06', '04', '01', 'CHOTA', '2010-12-15 01:58:44', NULL, '1'),
(60402, '06', '04', '02', 'ANGUIA', '2010-12-15 01:58:44', NULL, '1'),
(60403, '06', '04', '03', 'CHADIN', '2010-12-15 01:58:44', NULL, '1'),
(60404, '06', '04', '04', 'CHIGUIRIP', '2010-12-15 01:58:44', NULL, '1'),
(60405, '06', '04', '05', 'CHIMBAN', '2010-12-15 01:58:44', NULL, '1'),
(60406, '06', '04', '06', 'CHOROPAMPA', '2010-12-15 01:58:44', NULL, '1'),
(60407, '06', '04', '07', 'COCHABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(60408, '06', '04', '08', 'CONCHAN', '2010-12-15 01:58:44', NULL, '1'),
(60409, '06', '04', '09', 'HUAMBOS', '2010-12-15 01:58:44', NULL, '1'),
(60410, '06', '04', '10', 'LAJAS', '2010-12-15 01:58:44', NULL, '1'),
(60411, '06', '04', '11', 'LLAMA', '2010-12-15 01:58:44', NULL, '1'),
(60412, '06', '04', '12', 'MIRACOSTA', '2010-12-15 01:58:44', NULL, '1'),
(60413, '06', '04', '13', 'PACCHA', '2010-12-15 01:58:44', NULL, '1'),
(60414, '06', '04', '14', 'PION', '2010-12-15 01:58:44', NULL, '1'),
(60415, '06', '04', '15', 'QUEROCOTO', '2010-12-15 01:58:44', NULL, '1'),
(60416, '06', '04', '16', 'SAN JUAN DE LICUPIS', '2010-12-15 01:58:44', NULL, '1'),
(60417, '06', '04', '17', 'TACABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(60418, '06', '04', '18', 'TOCMOCHE', '2010-12-15 01:58:44', NULL, '1'),
(60419, '06', '04', '19', 'CHALAMARCA', '2010-12-15 01:58:44', NULL, '1'),
(60500, '06', '05', '00', 'CONTUMAZA', '2010-12-15 01:58:44', NULL, '1'),
(60501, '06', '05', '01', 'CONTUMAZA', '2010-12-15 01:58:44', NULL, '1'),
(60502, '06', '05', '02', 'CHILETE', '2010-12-15 01:58:44', NULL, '1'),
(60503, '06', '05', '03', 'CUPISNIQUE', '2010-12-15 01:58:44', NULL, '1'),
(60504, '06', '05', '04', 'GUZMANGO', '2010-12-15 01:58:44', NULL, '1'),
(60505, '06', '05', '05', 'SAN BENITO', '2010-12-15 01:58:44', NULL, '1'),
(60506, '06', '05', '06', 'SANTA CRUZ DE TOLED', '2010-12-15 01:58:44', NULL, '1'),
(60507, '06', '05', '07', 'TANTARICA', '2010-12-15 01:58:44', NULL, '1'),
(60508, '06', '05', '08', 'YONAN', '2010-12-15 01:58:44', NULL, '1'),
(60600, '06', '06', '00', 'CUTERVO', '2010-12-15 01:58:44', NULL, '1'),
(60601, '06', '06', '01', 'CUTERVO', '2010-12-15 01:58:44', NULL, '1'),
(60602, '06', '06', '02', 'CALLAYUC', '2010-12-15 01:58:44', NULL, '1'),
(60603, '06', '06', '03', 'CHOROS', '2010-12-15 01:58:44', NULL, '1'),
(60604, '06', '06', '04', 'CUJILLO', '2010-12-15 01:58:44', NULL, '1'),
(60605, '06', '06', '05', 'LA RAMADA', '2010-12-15 01:58:44', NULL, '1'),
(60606, '06', '06', '06', 'PIMPINGOS', '2010-12-15 01:58:44', NULL, '1'),
(60607, '06', '06', '07', 'QUEROCOTILLO', '2010-12-15 01:58:44', NULL, '1'),
(60608, '06', '06', '08', 'SAN ANDRES DE CUTERVO', '2010-12-15 01:58:44', NULL, '1'),
(60609, '06', '06', '09', 'SAN JUAN DE CUTERVO', '2010-12-15 01:58:44', NULL, '1'),
(60610, '06', '06', '10', 'SAN LUIS DE LUCMA', '2010-12-15 01:58:44', NULL, '1'),
(60611, '06', '06', '11', 'SANTA CRUZ', '2010-12-15 01:58:44', NULL, '1'),
(60612, '06', '06', '12', 'SANTO DOMINGO DE LA CAPILLA', '2010-12-15 01:58:44', NULL, '1'),
(60613, '06', '06', '13', 'SANTO TOMAS', '2010-12-15 01:58:44', NULL, '1'),
(60614, '06', '06', '14', 'SOCOTA', '2010-12-15 01:58:44', NULL, '1'),
(60615, '06', '06', '15', 'TORIBIO CASANOVA', '2010-12-15 01:58:44', NULL, '1'),
(60700, '06', '07', '00', 'HUALGAYOC', '2010-12-15 01:58:44', NULL, '1'),
(60701, '06', '07', '01', 'BAMBAMARCA', '2010-12-15 01:58:44', NULL, '1'),
(60702, '06', '07', '02', 'CHUGUR', '2010-12-15 01:58:44', NULL, '1'),
(60703, '06', '07', '03', 'HUALGAYOC', '2010-12-15 01:58:44', NULL, '1'),
(60800, '06', '08', '00', 'JAEN', '2010-12-15 01:58:44', NULL, '1');
INSERT INTO `cji_ubigeo` (`UBIGP_Codigo`, `UBIGC_CodDpto`, `UBIGC_CodProv`, `UBIGC_CodDist`, `UBIGC_Descripcion`, `UBIGC_FechaRegistro`, `UBIGC_FechaModificacion`, `UBIGC_FlagEstado`) VALUES
(60801, '06', '08', '01', 'JAEN', '2010-12-15 01:58:44', NULL, '1'),
(60802, '06', '08', '02', 'BELLAVISTA', '2010-12-15 01:58:44', NULL, '1'),
(60803, '06', '08', '03', 'CHONTALI', '2010-12-15 01:58:44', NULL, '1'),
(60804, '06', '08', '04', 'COLASAY', '2010-12-15 01:58:44', NULL, '1'),
(60805, '06', '08', '05', 'HUABAL', '2010-12-15 01:58:44', NULL, '1'),
(60806, '06', '08', '06', 'LAS PIRIAS', '2010-12-15 01:58:44', NULL, '1'),
(60807, '06', '08', '07', 'POMAHUACA', '2010-12-15 01:58:44', NULL, '1'),
(60808, '06', '08', '08', 'PUCARA', '2010-12-15 01:58:44', NULL, '1'),
(60809, '06', '08', '09', 'SALLIQUE', '2010-12-15 01:58:44', NULL, '1'),
(60810, '06', '08', '10', 'SAN FELIPE', '2010-12-15 01:58:44', NULL, '1'),
(60811, '06', '08', '11', 'SAN JOSE DEL ALTO', '2010-12-15 01:58:44', NULL, '1'),
(60812, '06', '08', '12', 'SANTA ROSA', '2010-12-15 01:58:44', NULL, '1'),
(60900, '06', '09', '00', 'SAN IGNACIO', '2010-12-15 01:58:44', NULL, '1'),
(60901, '06', '09', '01', 'SAN IGNACIO', '2010-12-15 01:58:44', NULL, '1'),
(60902, '06', '09', '02', 'CHIRINOS', '2010-12-15 01:58:44', NULL, '1'),
(60903, '06', '09', '03', 'HUARANGO', '2010-12-15 01:58:44', NULL, '1'),
(60904, '06', '09', '04', 'LA COIPA', '2010-12-15 01:58:44', NULL, '1'),
(60905, '06', '09', '05', 'NAMBALLE', '2010-12-15 01:58:44', NULL, '1'),
(60906, '06', '09', '06', 'SAN JOSE DE LOURDES', '2010-12-15 01:58:44', NULL, '1'),
(60907, '06', '09', '07', 'TABACONAS', '2010-12-15 01:58:44', NULL, '1'),
(61000, '06', '10', '00', 'SAN MARCOS', '2010-12-15 01:58:44', NULL, '1'),
(61001, '06', '10', '01', 'PEDRO GALVEZ', '2010-12-15 01:58:44', NULL, '1'),
(61002, '06', '10', '02', 'CHANCAY', '2010-12-15 01:58:44', NULL, '1'),
(61003, '06', '10', '03', 'EDUARDO VILLANUEVA', '2010-12-15 01:58:44', NULL, '1'),
(61004, '06', '10', '04', 'GREGORIO PITA', '2010-12-15 01:58:44', NULL, '1'),
(61005, '06', '10', '05', 'ICHOCAN', '2010-12-15 01:58:44', NULL, '1'),
(61006, '06', '10', '06', 'JOSE MANUEL QUIROZ', '2010-12-15 01:58:44', NULL, '1'),
(61007, '06', '10', '07', 'JOSE SABOGAL', '2010-12-15 01:58:44', NULL, '1'),
(61100, '06', '11', '00', 'SAN MIGUEL', '2010-12-15 01:58:44', NULL, '1'),
(61101, '06', '11', '01', 'SAN MIGUEL', '2010-12-15 01:58:44', NULL, '1'),
(61102, '06', '11', '02', 'BOLIVAR', '2010-12-15 01:58:44', NULL, '1'),
(61103, '06', '11', '03', 'CALQUIS', '2010-12-15 01:58:44', NULL, '1'),
(61104, '06', '11', '04', 'CATILLUC', '2010-12-15 01:58:44', NULL, '1'),
(61105, '06', '11', '05', 'EL PRADO', '2010-12-15 01:58:44', NULL, '1'),
(61106, '06', '11', '06', 'LA FLORIDA', '2010-12-15 01:58:44', NULL, '1'),
(61107, '06', '11', '07', 'LLAPA', '2010-12-15 01:58:44', NULL, '1'),
(61108, '06', '11', '08', 'NANCHOC', '2010-12-15 01:58:44', NULL, '1'),
(61109, '06', '11', '09', 'NIEPOS', '2010-12-15 01:58:44', NULL, '1'),
(61110, '06', '11', '10', 'SAN GREGORIO', '2010-12-15 01:58:44', NULL, '1'),
(61111, '06', '11', '11', 'SAN SILVESTRE DE COCHAN', '2010-12-15 01:58:44', NULL, '1'),
(61112, '06', '11', '12', 'TONGOD', '2010-12-15 01:58:44', NULL, '1'),
(61113, '06', '11', '13', 'UNION AGUA BLANCA', '2010-12-15 01:58:44', NULL, '1'),
(61200, '06', '12', '00', 'SAN PABLO', '2010-12-15 01:58:44', NULL, '1'),
(61201, '06', '12', '01', 'SAN PABLO', '2010-12-15 01:58:44', NULL, '1'),
(61202, '06', '12', '02', 'SAN BERNARDINO', '2010-12-15 01:58:44', NULL, '1'),
(61203, '06', '12', '03', 'SAN LUIS', '2010-12-15 01:58:44', NULL, '1'),
(61204, '06', '12', '04', 'TUMBADEN', '2010-12-15 01:58:44', NULL, '1'),
(61300, '06', '13', '00', 'SANTA CRUZ', '2010-12-15 01:58:44', NULL, '1'),
(61301, '06', '13', '01', 'SANTA CRUZ', '2010-12-15 01:58:44', NULL, '1'),
(61302, '06', '13', '02', 'ANDABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(61303, '06', '13', '03', 'CATACHE', '2010-12-15 01:58:44', NULL, '1'),
(61304, '06', '13', '04', 'CHANCAYBAÃ‘OS', '2010-12-15 01:58:44', NULL, '1'),
(61305, '06', '13', '05', 'LA ESPERANZA', '2010-12-15 01:58:44', NULL, '1'),
(61306, '06', '13', '06', 'NINABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(61307, '06', '13', '07', 'PULAN', '2010-12-15 01:58:44', NULL, '1'),
(61308, '06', '13', '08', 'SAUCEPAMPA', '2010-12-15 01:58:44', NULL, '1'),
(61309, '06', '13', '09', 'SEXI', '2010-12-15 01:58:44', NULL, '1'),
(61310, '06', '13', '10', 'UTICYACU', '2010-12-15 01:58:44', NULL, '1'),
(61311, '06', '13', '11', 'YAUYUCAN', '2010-12-15 01:58:44', NULL, '1'),
(70000, '07', '00', '00', 'CALLAO', '2010-12-15 01:58:44', NULL, '1'),
(70100, '07', '01', '00', 'CALLAO', '2010-12-15 01:58:44', NULL, '1'),
(70101, '07', '01', '01', 'CALLAO', '2010-12-15 01:58:44', NULL, '1'),
(70102, '07', '01', '02', 'BELLAVISTA', '2010-12-15 01:58:44', NULL, '1'),
(70103, '07', '01', '03', 'CARMEN DE LA LEGUA REYNOSO', '2010-12-15 01:58:44', NULL, '1'),
(70104, '07', '01', '04', 'LA PERLA', '2010-12-15 01:58:44', NULL, '1'),
(70105, '07', '01', '05', 'LA PUNTA', '2010-12-15 01:58:44', NULL, '1'),
(70106, '07', '01', '06', 'VENTANILLA', '2010-12-15 01:58:44', NULL, '1'),
(80000, '08', '00', '00', 'CUSCO', '2010-12-15 01:58:44', NULL, '1'),
(80100, '08', '01', '00', 'CUSCO', '2010-12-15 01:58:44', NULL, '1'),
(80101, '08', '01', '01', 'CUSCO', '2010-12-15 01:58:44', NULL, '1'),
(80102, '08', '01', '02', 'CCORCA', '2010-12-15 01:58:44', NULL, '1'),
(80103, '08', '01', '03', 'POROY', '2010-12-15 01:58:44', NULL, '1'),
(80104, '08', '01', '04', 'SAN JERONIMO', '2010-12-15 01:58:44', NULL, '1'),
(80105, '08', '01', '05', 'SAN SEBASTIAN', '2010-12-15 01:58:44', NULL, '1'),
(80106, '08', '01', '06', 'SANTIAGO', '2010-12-15 01:58:44', NULL, '1'),
(80107, '08', '01', '07', 'SAYLLA', '2010-12-15 01:58:44', NULL, '1'),
(80108, '08', '01', '08', 'WANCHAQ', '2010-12-15 01:58:44', NULL, '1'),
(80200, '08', '02', '00', 'ACOMAYO', '2010-12-15 01:58:44', NULL, '1'),
(80201, '08', '02', '01', 'ACOMAYO', '2010-12-15 01:58:44', NULL, '1'),
(80202, '08', '02', '02', 'ACOPIA', '2010-12-15 01:58:44', NULL, '1'),
(80203, '08', '02', '03', 'ACOS', '2010-12-15 01:58:44', NULL, '1'),
(80204, '08', '02', '04', 'MOSOC LLACTA', '2010-12-15 01:58:44', NULL, '1'),
(80205, '08', '02', '05', 'POMACANCHI', '2010-12-15 01:58:44', NULL, '1'),
(80206, '08', '02', '06', 'RONDOCAN', '2010-12-15 01:58:44', NULL, '1'),
(80207, '08', '02', '07', 'SANGARARA', '2010-12-15 01:58:44', NULL, '1'),
(80300, '08', '03', '00', 'ANTA', '2010-12-15 01:58:44', NULL, '1'),
(80301, '08', '03', '01', 'ANTA', '2010-12-15 01:58:44', NULL, '1'),
(80302, '08', '03', '02', 'ANCAHUASI', '2010-12-15 01:58:44', NULL, '1'),
(80303, '08', '03', '03', 'CACHIMAYO', '2010-12-15 01:58:44', NULL, '1'),
(80304, '08', '03', '04', 'CHINCHAYPUJIO', '2010-12-15 01:58:44', NULL, '1'),
(80305, '08', '03', '05', 'HUAROCONDO', '2010-12-15 01:58:44', NULL, '1'),
(80306, '08', '03', '06', 'LIMATAMBO', '2010-12-15 01:58:44', NULL, '1'),
(80307, '08', '03', '07', 'MOLLEPATA', '2010-12-15 01:58:44', NULL, '1'),
(80308, '08', '03', '08', 'PUCYURA', '2010-12-15 01:58:44', NULL, '1'),
(80309, '08', '03', '09', 'ZURITE', '2010-12-15 01:58:44', NULL, '1'),
(80400, '08', '04', '00', 'CALCA', '2010-12-15 01:58:44', NULL, '1'),
(80401, '08', '04', '01', 'CALCA', '2010-12-15 01:58:44', NULL, '1'),
(80402, '08', '04', '02', 'COYA', '2010-12-15 01:58:44', NULL, '1'),
(80403, '08', '04', '03', 'LAMAY', '2010-12-15 01:58:44', NULL, '1'),
(80404, '08', '04', '04', 'LARES', '2010-12-15 01:58:44', NULL, '1'),
(80405, '08', '04', '05', 'PISAC', '2010-12-15 01:58:44', NULL, '1'),
(80406, '08', '04', '06', 'SAN SALVADOR', '2010-12-15 01:58:44', NULL, '1'),
(80407, '08', '04', '07', 'TARAY', '2010-12-15 01:58:44', NULL, '1'),
(80408, '08', '04', '08', 'YANATILE', '2010-12-15 01:58:44', NULL, '1'),
(80500, '08', '05', '00', 'CANAS', '2010-12-15 01:58:44', NULL, '1'),
(80501, '08', '05', '01', 'YANAOCA', '2010-12-15 01:58:44', NULL, '1'),
(80502, '08', '05', '02', 'CHECCA', '2010-12-15 01:58:44', NULL, '1'),
(80503, '08', '05', '03', 'KUNTURKANKI', '2010-12-15 01:58:44', NULL, '1'),
(80504, '08', '05', '04', 'LANGUI', '2010-12-15 01:58:44', NULL, '1'),
(80505, '08', '05', '05', 'LAYO', '2010-12-15 01:58:44', NULL, '1'),
(80506, '08', '05', '06', 'PAMPAMARCA', '2010-12-15 01:58:44', NULL, '1'),
(80507, '08', '05', '07', 'QUEHUE', '2010-12-15 01:58:44', NULL, '1'),
(80508, '08', '05', '08', 'TUPAC AMARU', '2010-12-15 01:58:44', NULL, '1'),
(80600, '08', '06', '00', 'CANCHIS', '2010-12-15 01:58:44', NULL, '1'),
(80601, '08', '06', '01', 'SICUANI', '2010-12-15 01:58:44', NULL, '1'),
(80602, '08', '06', '02', 'CHECACUPE', '2010-12-15 01:58:44', NULL, '1'),
(80603, '08', '06', '03', 'COMBAPATA', '2010-12-15 01:58:44', NULL, '1'),
(80604, '08', '06', '04', 'MARANGANI', '2010-12-15 01:58:44', NULL, '1'),
(80605, '08', '06', '05', 'PITUMARCA', '2010-12-15 01:58:44', NULL, '1'),
(80606, '08', '06', '06', 'SAN PABLO', '2010-12-15 01:58:44', NULL, '1'),
(80607, '08', '06', '07', 'SAN PEDRO', '2010-12-15 01:58:44', NULL, '1'),
(80608, '08', '06', '08', 'TINTA', '2010-12-15 01:58:44', NULL, '1'),
(80700, '08', '07', '00', 'CHUMBIVILCAS', '2010-12-15 01:58:44', NULL, '1'),
(80701, '08', '07', '01', 'SANTO TOMAS', '2010-12-15 01:58:44', NULL, '1'),
(80702, '08', '07', '02', 'CAPACMARCA', '2010-12-15 01:58:44', NULL, '1'),
(80703, '08', '07', '03', 'CHAMACA', '2010-12-15 01:58:44', NULL, '1'),
(80704, '08', '07', '04', 'COLQUEMARCA', '2010-12-15 01:58:44', NULL, '1'),
(80705, '08', '07', '05', 'LIVITACA', '2010-12-15 01:58:44', NULL, '1'),
(80706, '08', '07', '06', 'LLUSCO', '2010-12-15 01:58:44', NULL, '1'),
(80707, '08', '07', '07', 'QUIÃ‘OTA', '2010-12-15 01:58:44', NULL, '1'),
(80708, '08', '07', '08', 'VELILLE', '2010-12-15 01:58:44', NULL, '1'),
(80800, '08', '08', '00', 'ESPINAR', '2010-12-15 01:58:44', NULL, '1'),
(80801, '08', '08', '01', 'ESPINAR', '2010-12-15 01:58:44', NULL, '1'),
(80802, '08', '08', '02', 'CONDOROMA', '2010-12-15 01:58:44', NULL, '1'),
(80803, '08', '08', '03', 'COPORAQUE', '2010-12-15 01:58:44', NULL, '1'),
(80804, '08', '08', '04', 'OCORURO', '2010-12-15 01:58:44', NULL, '1'),
(80805, '08', '08', '05', 'PALLPATA', '2010-12-15 01:58:44', NULL, '1'),
(80806, '08', '08', '06', 'PICHIGUA', '2010-12-15 01:58:44', NULL, '1'),
(80807, '08', '08', '07', 'SUYCKUTAMBO', '2010-12-15 01:58:44', NULL, '1'),
(80808, '08', '08', '08', 'ALTO PICHIGUA', '2010-12-15 01:58:44', NULL, '1'),
(80900, '08', '09', '00', 'LA CONVENCION', '2010-12-15 01:58:44', NULL, '1'),
(80901, '08', '09', '01', 'SANTA ANA', '2010-12-15 01:58:44', NULL, '1'),
(80902, '08', '09', '02', 'ECHARATE', '2010-12-15 01:58:44', NULL, '1'),
(80903, '08', '09', '03', 'HUAYOPATA', '2010-12-15 01:58:44', NULL, '1'),
(80904, '08', '09', '04', 'MARANURA', '2010-12-15 01:58:44', NULL, '1'),
(80905, '08', '09', '05', 'OCOBAMBA', '2010-12-15 01:58:44', NULL, '1'),
(80906, '08', '09', '06', 'QUELLOUNO', '2010-12-15 01:58:44', NULL, '1'),
(80907, '08', '09', '07', 'KIMBIRI', '2010-12-15 01:58:44', NULL, '1'),
(80908, '08', '09', '08', 'SANTA TERESA', '2010-12-15 01:58:44', NULL, '1'),
(80909, '08', '09', '09', 'VILCABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(80910, '08', '09', '10', 'PICHARI', '2010-12-15 01:58:44', NULL, '1'),
(81000, '08', '10', '00', 'PARURO', '2010-12-15 01:58:44', NULL, '1'),
(81001, '08', '10', '01', 'PARURO', '2010-12-15 01:58:44', NULL, '1'),
(81002, '08', '10', '02', 'ACCHA', '2010-12-15 01:58:44', NULL, '1'),
(81003, '08', '10', '03', 'CCAPI', '2010-12-15 01:58:44', NULL, '1'),
(81004, '08', '10', '04', 'COLCHA', '2010-12-15 01:58:44', NULL, '1'),
(81005, '08', '10', '05', 'HUANOQUITE', '2010-12-15 01:58:44', NULL, '1'),
(81006, '08', '10', '06', 'OMACHA', '2010-12-15 01:58:44', NULL, '1'),
(81007, '08', '10', '07', 'PACCARITAMBO', '2010-12-15 01:58:44', NULL, '1'),
(81008, '08', '10', '08', 'PILLPINTO', '2010-12-15 01:58:44', NULL, '1'),
(81009, '08', '10', '09', 'YAURISQUE', '2010-12-15 01:58:44', NULL, '1'),
(81100, '08', '11', '00', 'PAUCARTAMBO', '2010-12-15 01:58:44', NULL, '1'),
(81101, '08', '11', '01', 'PAUCARTAMBO', '2010-12-15 01:58:44', NULL, '1'),
(81102, '08', '11', '02', 'CAICAY', '2010-12-15 01:58:44', NULL, '1'),
(81103, '08', '11', '03', 'CHALLABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(81104, '08', '11', '04', 'COLQUEPATA', '2010-12-15 01:58:44', NULL, '1'),
(81105, '08', '11', '05', 'HUANCARANI', '2010-12-15 01:58:44', NULL, '1'),
(81106, '08', '11', '06', 'KOSÃ‘IPATA', '2010-12-15 01:58:44', NULL, '1'),
(81200, '08', '12', '00', 'QUISPICANCHI', '2010-12-15 01:58:44', NULL, '1'),
(81201, '08', '12', '01', 'URCOS', '2010-12-15 01:58:44', NULL, '1'),
(81202, '08', '12', '02', 'ANDAHUAYLILLAS', '2010-12-15 01:58:44', NULL, '1'),
(81203, '08', '12', '03', 'CAMANTI', '2010-12-15 01:58:44', NULL, '1'),
(81204, '08', '12', '04', 'CCARHUAYO', '2010-12-15 01:58:44', NULL, '1'),
(81205, '08', '12', '05', 'CCATCA', '2010-12-15 01:58:44', NULL, '1'),
(81206, '08', '12', '06', 'CUSIPATA', '2010-12-15 01:58:44', NULL, '1'),
(81207, '08', '12', '07', 'HUARO', '2010-12-15 01:58:44', NULL, '1'),
(81208, '08', '12', '08', 'LUCRE', '2010-12-15 01:58:44', NULL, '1'),
(81209, '08', '12', '09', 'MARCAPATA', '2010-12-15 01:58:44', NULL, '1'),
(81210, '08', '12', '10', 'OCONGATE', '2010-12-15 01:58:44', NULL, '1'),
(81211, '08', '12', '11', 'OROPESA', '2010-12-15 01:58:44', NULL, '1'),
(81212, '08', '12', '12', 'QUIQUIJANA', '2010-12-15 01:58:44', NULL, '1'),
(81300, '08', '13', '00', 'URUBAMBA', '2010-12-15 01:58:44', NULL, '1'),
(81301, '08', '13', '01', 'URUBAMBA', '2010-12-15 01:58:44', NULL, '1'),
(81302, '08', '13', '02', 'CHINCHERO', '2010-12-15 01:58:44', NULL, '1'),
(81303, '08', '13', '03', 'HUAYLLABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(81304, '08', '13', '04', 'MACHUPICCHU', '2010-12-15 01:58:44', NULL, '1'),
(81305, '08', '13', '05', 'MARAS', '2010-12-15 01:58:44', NULL, '1'),
(81306, '08', '13', '06', 'OLLANTAYTAMBO', '2010-12-15 01:58:44', NULL, '1'),
(81307, '08', '13', '07', 'YUCAY', '2010-12-15 01:58:44', NULL, '1'),
(90000, '09', '00', '00', 'HUANCAVELICA', '2010-12-15 01:58:44', NULL, '1'),
(90100, '09', '01', '00', 'HUANCAVELICA', '2010-12-15 01:58:44', NULL, '1'),
(90101, '09', '01', '01', 'HUANCAVELICA', '2010-12-15 01:58:44', NULL, '1'),
(90102, '09', '01', '02', 'ACOBAMBILLA', '2010-12-15 01:58:44', NULL, '1'),
(90103, '09', '01', '03', 'ACORIA', '2010-12-15 01:58:44', NULL, '1'),
(90104, '09', '01', '04', 'CONAYCA', '2010-12-15 01:58:44', NULL, '1'),
(90105, '09', '01', '05', 'CUENCA', '2010-12-15 01:58:44', NULL, '1'),
(90106, '09', '01', '06', 'HUACHOCOLPA', '2010-12-15 01:58:44', NULL, '1'),
(90107, '09', '01', '07', 'HUAYLLAHUARA', '2010-12-15 01:58:44', NULL, '1'),
(90108, '09', '01', '08', 'IZCUCHACA', '2010-12-15 01:58:44', NULL, '1'),
(90109, '09', '01', '09', 'LARIA', '2010-12-15 01:58:44', NULL, '1'),
(90110, '09', '01', '10', 'MANTA', '2010-12-15 01:58:44', NULL, '1'),
(90111, '09', '01', '11', 'MARISCAL CACERES', '2010-12-15 01:58:44', NULL, '1'),
(90112, '09', '01', '12', 'MOYA', '2010-12-15 01:58:44', NULL, '1'),
(90113, '09', '01', '13', 'NUEVO OCCORO', '2010-12-15 01:58:44', NULL, '1'),
(90114, '09', '01', '14', 'PALCA', '2010-12-15 01:58:44', NULL, '1'),
(90115, '09', '01', '15', 'PILCHACA', '2010-12-15 01:58:44', NULL, '1'),
(90116, '09', '01', '16', 'VILCA', '2010-12-15 01:58:44', NULL, '1'),
(90117, '09', '01', '17', 'YAULI', '2010-12-15 01:58:44', NULL, '1'),
(90118, '09', '01', '18', 'ASCENSION', '2010-12-15 01:58:44', NULL, '1'),
(90119, '09', '01', '19', 'HUANDO', '2010-12-15 01:58:44', NULL, '1'),
(90200, '09', '02', '00', 'ACOBAMBA', '2010-12-15 01:58:44', NULL, '1'),
(90201, '09', '02', '01', 'ACOBAMBA', '2010-12-15 01:58:44', NULL, '1'),
(90202, '09', '02', '02', 'ANDABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(90203, '09', '02', '03', 'ANTA', '2010-12-15 01:58:44', NULL, '1'),
(90204, '09', '02', '04', 'CAJA', '2010-12-15 01:58:44', NULL, '1'),
(90205, '09', '02', '05', 'MARCAS', '2010-12-15 01:58:44', NULL, '1'),
(90206, '09', '02', '06', 'PAUCARA', '2010-12-15 01:58:44', NULL, '1'),
(90207, '09', '02', '07', 'POMACOCHA', '2010-12-15 01:58:44', NULL, '1'),
(90208, '09', '02', '08', 'ROSARIO', '2010-12-15 01:58:44', NULL, '1'),
(90300, '09', '03', '00', 'ANGARAES', '2010-12-15 01:58:44', NULL, '1'),
(90301, '09', '03', '01', 'LIRCAY', '2010-12-15 01:58:44', NULL, '1'),
(90302, '09', '03', '02', 'ANCHONGA', '2010-12-15 01:58:44', NULL, '1'),
(90303, '09', '03', '03', 'CALLANMARCA', '2010-12-15 01:58:44', NULL, '1'),
(90304, '09', '03', '04', 'CCOCHACCASA', '2010-12-15 01:58:44', NULL, '1'),
(90305, '09', '03', '05', 'CHINCHO', '2010-12-15 01:58:44', NULL, '1'),
(90306, '09', '03', '06', 'CONGALLA', '2010-12-15 01:58:44', NULL, '1'),
(90307, '09', '03', '07', 'HUANCA-HUANCA', '2010-12-15 01:58:44', NULL, '1'),
(90308, '09', '03', '08', 'HUAYLLAY GRANDE', '2010-12-15 01:58:44', NULL, '1'),
(90309, '09', '03', '09', 'JULCAMARCA', '2010-12-15 01:58:44', NULL, '1'),
(90310, '09', '03', '10', 'SAN ANTONIO DE ANTAPARCO', '2010-12-15 01:58:44', NULL, '1'),
(90311, '09', '03', '11', 'SANTO TOMAS DE PATA', '2010-12-15 01:58:44', NULL, '1'),
(90312, '09', '03', '12', 'SECCLLA', '2010-12-15 01:58:44', NULL, '1'),
(90400, '09', '04', '00', 'CASTROVIRREYNA', '2010-12-15 01:58:44', NULL, '1'),
(90401, '09', '04', '01', 'CASTROVIRREYNA', '2010-12-15 01:58:44', NULL, '1'),
(90402, '09', '04', '02', 'ARMA', '2010-12-15 01:58:44', NULL, '1'),
(90403, '09', '04', '03', 'AURAHUA', '2010-12-15 01:58:44', NULL, '1'),
(90404, '09', '04', '04', 'CAPILLAS', '2010-12-15 01:58:44', NULL, '1'),
(90405, '09', '04', '05', 'CHUPAMARCA', '2010-12-15 01:58:44', NULL, '1'),
(90406, '09', '04', '06', 'COCAS', '2010-12-15 01:58:44', NULL, '1'),
(90407, '09', '04', '07', 'HUACHOS', '2010-12-15 01:58:44', NULL, '1'),
(90408, '09', '04', '08', 'HUAMATAMBO', '2010-12-15 01:58:44', NULL, '1'),
(90409, '09', '04', '09', 'MOLLEPAMPA', '2010-12-15 01:58:44', NULL, '1'),
(90410, '09', '04', '10', 'SAN JUAN', '2010-12-15 01:58:44', NULL, '1'),
(90411, '09', '04', '11', 'SANTA ANA', '2010-12-15 01:58:44', NULL, '1'),
(90412, '09', '04', '12', 'TANTARA', '2010-12-15 01:58:44', NULL, '1'),
(90413, '09', '04', '13', 'TICRAPO', '2010-12-15 01:58:44', NULL, '1'),
(90500, '09', '05', '00', 'CHURCAMPA', '2010-12-15 01:58:44', NULL, '1'),
(90501, '09', '05', '01', 'CHURCAMPA', '2010-12-15 01:58:44', NULL, '1'),
(90502, '09', '05', '02', 'ANCO', '2010-12-15 01:58:44', NULL, '1'),
(90503, '09', '05', '03', 'CHINCHIHUASI', '2010-12-15 01:58:44', NULL, '1'),
(90504, '09', '05', '04', 'EL CARMEN', '2010-12-15 01:58:44', NULL, '1'),
(90505, '09', '05', '05', 'LA MERCED', '2010-12-15 01:58:44', NULL, '1'),
(90506, '09', '05', '06', 'LOCROJA', '2010-12-15 01:58:44', NULL, '1'),
(90507, '09', '05', '07', 'PAUCARBAMBA', '2010-12-15 01:58:44', NULL, '1'),
(90508, '09', '05', '08', 'SAN MIGUEL DE MAYOCC', '2010-12-15 01:58:44', NULL, '1'),
(90509, '09', '05', '09', 'SAN PEDRO DE CORIS', '2010-12-15 01:58:44', NULL, '1'),
(90510, '09', '05', '10', 'PACHAMARCA', '2010-12-15 01:58:44', NULL, '1'),
(90600, '09', '06', '00', 'HUAYTARA', '2010-12-15 01:58:44', NULL, '1'),
(90601, '09', '06', '01', 'HUAYTARA', '2010-12-15 01:58:44', NULL, '1'),
(90602, '09', '06', '02', 'AYAVI', '2010-12-15 01:58:44', NULL, '1'),
(90603, '09', '06', '03', 'CORDOVA', '2010-12-15 01:58:44', NULL, '1'),
(90604, '09', '06', '04', 'HUAYACUNDO ARMA', '2010-12-15 01:58:44', NULL, '1'),
(90605, '09', '06', '05', 'LARAMARCA', '2010-12-15 01:58:44', NULL, '1'),
(90606, '09', '06', '06', 'OCOYO', '2010-12-15 01:58:44', NULL, '1'),
(90607, '09', '06', '07', 'PILPICHACA', '2010-12-15 01:58:44', NULL, '1'),
(90608, '09', '06', '08', 'QUERCO', '2010-12-15 01:58:44', NULL, '1'),
(90609, '09', '06', '09', 'QUITO-ARMA', '2010-12-15 01:58:44', NULL, '1'),
(90610, '09', '06', '10', 'SAN ANTONIO DE CUSICANCHA', '2010-12-15 01:58:44', NULL, '1'),
(90611, '09', '06', '11', 'SAN FRANCISCO DE SANGAYAICO', '2010-12-15 01:58:44', NULL, '1'),
(90612, '09', '06', '12', 'SAN ISIDRO', '2010-12-15 01:58:44', NULL, '1'),
(90613, '09', '06', '13', 'SANTIAGO DE CHOCORVOS', '2010-12-15 01:58:44', NULL, '1'),
(90614, '09', '06', '14', 'SANTIAGO DE QUIRAHUARA', '2010-12-15 01:58:44', NULL, '1'),
(90615, '09', '06', '15', 'SANTO DOMINGO DE CAPILLAS', '2010-12-15 01:58:44', NULL, '1'),
(90616, '09', '06', '16', 'TAMBO', '2010-12-15 01:58:44', NULL, '1'),
(90700, '09', '07', '00', 'TAYACAJA', '2010-12-15 01:58:44', NULL, '1'),
(90701, '09', '07', '01', 'PAMPAS', '2010-12-15 01:58:44', NULL, '1'),
(90702, '09', '07', '02', 'ACOSTAMBO', '2010-12-15 01:58:44', NULL, '1'),
(90703, '09', '07', '03', 'ACRAQUIA', '2010-12-15 01:58:44', NULL, '1'),
(90704, '09', '07', '04', 'AHUAYCHA', '2010-12-15 01:58:44', NULL, '1'),
(90705, '09', '07', '05', 'COLCABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(90706, '09', '07', '06', 'DANIEL HERNANDEZ', '2010-12-15 01:58:44', NULL, '1'),
(90707, '09', '07', '07', 'HUACHOCOLPA', '2010-12-15 01:58:44', NULL, '1'),
(90709, '09', '07', '09', 'HUARIBAMBA', '2010-12-15 01:58:44', NULL, '1'),
(90710, '09', '07', '10', 'Ã‘AHUIMPUQUIO', '2010-12-15 01:58:44', NULL, '1'),
(90711, '09', '07', '11', 'PAZOS', '2010-12-15 01:58:44', NULL, '1'),
(90713, '09', '07', '13', 'QUISHUAR', '2010-12-15 01:58:44', NULL, '1'),
(90714, '09', '07', '14', 'SALCABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(90715, '09', '07', '15', 'SALCAHUASI', '2010-12-15 01:58:44', NULL, '1'),
(90716, '09', '07', '16', 'SAN MARCOS DE ROCCHAC', '2010-12-15 01:58:44', NULL, '1'),
(90717, '09', '07', '17', 'SURCUBAMBA', '2010-12-15 01:58:44', NULL, '1'),
(90718, '09', '07', '18', 'TINTAY PUNCU', '2010-12-15 01:58:44', NULL, '1'),
(100000, '10', '00', '00', 'HUANUCO', '2010-12-15 01:58:44', NULL, '1'),
(100100, '10', '01', '00', 'HUANUCO', '2010-12-15 01:58:44', NULL, '1'),
(100101, '10', '01', '01', 'HUANUCO', '2010-12-15 01:58:44', NULL, '1'),
(100102, '10', '01', '02', 'AMARILIS', '2010-12-15 01:58:44', NULL, '1'),
(100103, '10', '01', '03', 'CHINCHAO', '2010-12-15 01:58:44', NULL, '1'),
(100104, '10', '01', '04', 'CHURUBAMBA', '2010-12-15 01:58:44', NULL, '1'),
(100105, '10', '01', '05', 'MARGOS', '2010-12-15 01:58:44', NULL, '1'),
(100106, '10', '01', '06', 'QUISQUI', '2010-12-15 01:58:44', NULL, '1'),
(100107, '10', '01', '07', 'SAN FRANCISCO DE CAYRAN', '2010-12-15 01:58:44', NULL, '1'),
(100108, '10', '01', '08', 'SAN PEDRO DE CHAULAN', '2010-12-15 01:58:44', NULL, '1'),
(100109, '10', '01', '09', 'SANTA MARIA DEL VALLE', '2010-12-15 01:58:44', NULL, '1'),
(100110, '10', '01', '10', 'YARUMAYO', '2010-12-15 01:58:44', NULL, '1'),
(100111, '10', '01', '11', 'PILLCO MARCA', '2010-12-15 01:58:44', NULL, '1'),
(100200, '10', '02', '00', 'AMBO', '2010-12-15 01:58:44', NULL, '1'),
(100201, '10', '02', '01', 'AMBO', '2010-12-15 01:58:44', NULL, '1'),
(100202, '10', '02', '02', 'CAYNA', '2010-12-15 01:58:44', NULL, '1'),
(100203, '10', '02', '03', 'COLPAS', '2010-12-15 01:58:44', NULL, '1'),
(100204, '10', '02', '04', 'CONCHAMARCA', '2010-12-15 01:58:44', NULL, '1'),
(100205, '10', '02', '05', 'HUACAR', '2010-12-15 01:58:44', NULL, '1'),
(100206, '10', '02', '06', 'SAN FRANCISCO', '2010-12-15 01:58:44', NULL, '1'),
(100207, '10', '02', '07', 'SAN RAFAEL', '2010-12-15 01:58:44', NULL, '1'),
(100208, '10', '02', '08', 'TOMAY KICHWA', '2010-12-15 01:58:44', NULL, '1'),
(100300, '10', '03', '00', 'DOS DE MAYO', '2010-12-15 01:58:44', NULL, '1'),
(100301, '10', '03', '01', 'LA UNION', '2010-12-15 01:58:44', NULL, '1'),
(100307, '10', '03', '07', 'CHUQUIS', '2010-12-15 01:58:44', NULL, '1'),
(100311, '10', '03', '11', 'MARIAS', '2010-12-15 01:58:44', NULL, '1'),
(100313, '10', '03', '13', 'PACHAS', '2010-12-15 01:58:44', NULL, '1'),
(100316, '10', '03', '16', 'QUIVILLA', '2010-12-15 01:58:44', NULL, '1'),
(100317, '10', '03', '17', 'RIPAN', '2010-12-15 01:58:44', NULL, '1'),
(100321, '10', '03', '21', 'SHUNQUI', '2010-12-15 01:58:44', NULL, '1'),
(100322, '10', '03', '22', 'SILLAPATA', '2010-12-15 01:58:44', NULL, '1'),
(100323, '10', '03', '23', 'YANAS', '2010-12-15 01:58:44', NULL, '1'),
(100400, '10', '04', '00', 'HUACAYBAMBA', '2010-12-15 01:58:44', NULL, '1'),
(100401, '10', '04', '01', 'HUACAYBAMBA', '2010-12-15 01:58:44', NULL, '1'),
(100402, '10', '04', '02', 'CANCHABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(100403, '10', '04', '03', 'COCHABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(100404, '10', '04', '04', 'PINRA', '2010-12-15 01:58:44', NULL, '1'),
(100500, '10', '05', '00', 'HUAMALIES', '2010-12-15 01:58:44', NULL, '1'),
(100501, '10', '05', '01', 'LLATA', '2010-12-15 01:58:44', NULL, '1'),
(100502, '10', '05', '02', 'ARANCAY', '2010-12-15 01:58:44', NULL, '1'),
(100503, '10', '05', '03', 'CHAVIN DE PARIARCA', '2010-12-15 01:58:44', NULL, '1'),
(100504, '10', '05', '04', 'JACAS GRANDE', '2010-12-15 01:58:44', NULL, '1'),
(100505, '10', '05', '05', 'JIRCAN', '2010-12-15 01:58:44', NULL, '1'),
(100506, '10', '05', '06', 'MIRAFLORES', '2010-12-15 01:58:44', NULL, '1'),
(100507, '10', '05', '07', 'MONZON', '2010-12-15 01:58:44', NULL, '1'),
(100508, '10', '05', '08', 'PUNCHAO', '2010-12-15 01:58:44', NULL, '1'),
(100509, '10', '05', '09', 'PUÃ‘OS', '2010-12-15 01:58:44', NULL, '1'),
(100510, '10', '05', '10', 'SINGA', '2010-12-15 01:58:44', NULL, '1'),
(100511, '10', '05', '11', 'TANTAMAYO', '2010-12-15 01:58:44', NULL, '1'),
(100600, '10', '06', '00', 'LEONCIO PRADO', '2010-12-15 01:58:44', NULL, '1'),
(100601, '10', '06', '01', 'RUPA-RUPA', '2010-12-15 01:58:44', NULL, '1'),
(100602, '10', '06', '02', 'DANIEL ALOMIAS ROBLES', '2010-12-15 01:58:44', NULL, '1'),
(100603, '10', '06', '03', 'HERMILIO VALDIZAN', '2010-12-15 01:58:44', NULL, '1'),
(100604, '10', '06', '04', 'JOSE CRESPO Y CASTILLO', '2010-12-15 01:58:44', NULL, '1'),
(100605, '10', '06', '05', 'LUYANDO', '2010-12-15 01:58:44', NULL, '1'),
(100606, '10', '06', '06', 'MARIANO DAMASO BERAUN', '2010-12-15 01:58:44', NULL, '1'),
(100700, '10', '07', '00', 'MARAÃ‘ON', '2010-12-15 01:58:44', NULL, '1'),
(100701, '10', '07', '01', 'HUACRACHUCO', '2010-12-15 01:58:44', NULL, '1'),
(100702, '10', '07', '02', 'CHOLON', '2010-12-15 01:58:44', NULL, '1'),
(100703, '10', '07', '03', 'SAN BUENAVENTURA', '2010-12-15 01:58:44', NULL, '1'),
(100800, '10', '08', '00', 'PACHITEA', '2010-12-15 01:58:44', NULL, '1'),
(100801, '10', '08', '01', 'PANAO', '2010-12-15 01:58:44', NULL, '1'),
(100802, '10', '08', '02', 'CHAGLLA', '2010-12-15 01:58:44', NULL, '1'),
(100803, '10', '08', '03', 'MOLINO', '2010-12-15 01:58:44', NULL, '1'),
(100804, '10', '08', '04', 'UMARI', '2010-12-15 01:58:44', NULL, '1'),
(100900, '10', '09', '00', 'PUERTO INCA', '2010-12-15 01:58:44', NULL, '1'),
(100901, '10', '09', '01', 'PUERTO INCA', '2010-12-15 01:58:44', NULL, '1'),
(100902, '10', '09', '02', 'CODO DEL POZUZO', '2010-12-15 01:58:44', NULL, '1'),
(100903, '10', '09', '03', 'HONORIA', '2010-12-15 01:58:44', NULL, '1'),
(100904, '10', '09', '04', 'TOURNAVISTA', '2010-12-15 01:58:44', NULL, '1'),
(100905, '10', '09', '05', 'YUYAPICHIS', '2010-12-15 01:58:44', NULL, '1'),
(101000, '10', '10', '00', 'LAURICOCHA', '2010-12-15 01:58:44', NULL, '1'),
(101001, '10', '10', '01', 'JESUS', '2010-12-15 01:58:44', NULL, '1'),
(101002, '10', '10', '02', 'BAÃ‘OS', '2010-12-15 01:58:44', NULL, '1'),
(101003, '10', '10', '03', 'JIVIA', '2010-12-15 01:58:44', NULL, '1'),
(101004, '10', '10', '04', 'QUEROPALCA', '2010-12-15 01:58:44', NULL, '1'),
(101005, '10', '10', '05', 'RONDOS', '2010-12-15 01:58:44', NULL, '1'),
(101006, '10', '10', '06', 'SAN FRANCISCO DE ASIS', '2010-12-15 01:58:44', NULL, '1'),
(101007, '10', '10', '07', 'SAN MIGUEL DE CAURI', '2010-12-15 01:58:44', NULL, '1'),
(101100, '10', '11', '00', 'YAROWILCA', '2010-12-15 01:58:44', NULL, '1'),
(101101, '10', '11', '01', 'CHAVINILLO', '2010-12-15 01:58:44', NULL, '1'),
(101102, '10', '11', '02', 'CAHUAC', '2010-12-15 01:58:44', NULL, '1'),
(101103, '10', '11', '03', 'CHACABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(101104, '10', '11', '04', 'APARICIO POMARES', '2010-12-15 01:58:44', NULL, '1'),
(101105, '10', '11', '05', 'JACAS CHICO', '2010-12-15 01:58:44', NULL, '1'),
(101106, '10', '11', '06', 'OBAS', '2010-12-15 01:58:44', NULL, '1'),
(101107, '10', '11', '07', 'PAMPAMARCA', '2010-12-15 01:58:44', NULL, '1'),
(101108, '10', '11', '08', 'CHORAS', '2010-12-15 01:58:44', NULL, '1'),
(110000, '11', '00', '00', 'ICA', '2010-12-15 01:58:44', NULL, '1'),
(110100, '11', '01', '00', 'ICA', '2010-12-15 01:58:44', NULL, '1'),
(110101, '11', '01', '01', 'ICA', '2010-12-15 01:58:44', NULL, '1'),
(110102, '11', '01', '02', 'LA TINGUIÃ‘A', '2010-12-15 01:58:44', NULL, '1'),
(110103, '11', '01', '03', 'LOS AQUIJES', '2010-12-15 01:58:44', NULL, '1'),
(110104, '11', '01', '04', 'OCUCAJE', '2010-12-15 01:58:44', NULL, '1'),
(110105, '11', '01', '05', 'PACHACUTEC', '2010-12-15 01:58:44', NULL, '1'),
(110106, '11', '01', '06', 'PARCONA', '2010-12-15 01:58:44', NULL, '1'),
(110107, '11', '01', '07', 'PUEBLO NUEVO', '2010-12-15 01:58:44', NULL, '1'),
(110108, '11', '01', '08', 'SALAS', '2010-12-15 01:58:44', NULL, '1'),
(110109, '11', '01', '09', 'SAN JOSE DE LOS MOLINOS', '2010-12-15 01:58:44', NULL, '1'),
(110110, '11', '01', '10', 'SAN JUAN BAUTISTA', '2010-12-15 01:58:44', NULL, '1'),
(110111, '11', '01', '11', 'SANTIAGO', '2010-12-15 01:58:44', NULL, '1'),
(110112, '11', '01', '12', 'SUBTANJALLA', '2010-12-15 01:58:44', NULL, '1'),
(110113, '11', '01', '13', 'TATE', '2010-12-15 01:58:44', NULL, '1'),
(110114, '11', '01', '14', 'YAUCA DEL ROSARIO', '2010-12-15 01:58:44', NULL, '1'),
(110200, '11', '02', '00', 'CHINCHA', '2010-12-15 01:58:44', NULL, '1'),
(110201, '11', '02', '01', 'CHINCHA ALTA', '2010-12-15 01:58:44', NULL, '1'),
(110202, '11', '02', '02', 'ALTO LARAN', '2010-12-15 01:58:44', NULL, '1'),
(110203, '11', '02', '03', 'CHAVIN', '2010-12-15 01:58:44', NULL, '1'),
(110204, '11', '02', '04', 'CHINCHA BAJA', '2010-12-15 01:58:44', NULL, '1'),
(110205, '11', '02', '05', 'EL CARMEN', '2010-12-15 01:58:44', NULL, '1'),
(110206, '11', '02', '06', 'GROCIO PRADO', '2010-12-15 01:58:44', NULL, '1'),
(110207, '11', '02', '07', 'PUEBLO NUEVO', '2010-12-15 01:58:44', NULL, '1'),
(110208, '11', '02', '08', 'SAN JUAN DE YANAC', '2010-12-15 01:58:44', NULL, '1'),
(110209, '11', '02', '09', 'SAN PEDRO DE HUACARPANA', '2010-12-15 01:58:44', NULL, '1'),
(110210, '11', '02', '10', 'SUNAMPE', '2010-12-15 01:58:44', NULL, '1'),
(110211, '11', '02', '11', 'TAMBO DE MORA', '2010-12-15 01:58:44', NULL, '1'),
(110300, '11', '03', '00', 'NAZCA', '2010-12-15 01:58:44', NULL, '1'),
(110301, '11', '03', '01', 'NAZCA', '2010-12-15 01:58:44', NULL, '1'),
(110302, '11', '03', '02', 'CHANGUILLO', '2010-12-15 01:58:44', NULL, '1'),
(110303, '11', '03', '03', 'EL INGENIO', '2010-12-15 01:58:44', NULL, '1'),
(110304, '11', '03', '04', 'MARCONA', '2010-12-15 01:58:44', NULL, '1'),
(110305, '11', '03', '05', 'VISTA ALEGRE', '2010-12-15 01:58:44', NULL, '1'),
(110400, '11', '04', '00', 'PALPA', '2010-12-15 01:58:44', NULL, '1'),
(110401, '11', '04', '01', 'PALPA', '2010-12-15 01:58:44', NULL, '1'),
(110402, '11', '04', '02', 'LLIPATA', '2010-12-15 01:58:44', NULL, '1'),
(110403, '11', '04', '03', 'RIO GRANDE', '2010-12-15 01:58:44', NULL, '1'),
(110404, '11', '04', '04', 'SANTA CRUZ', '2010-12-15 01:58:44', NULL, '1'),
(110405, '11', '04', '05', 'TIBILLO', '2010-12-15 01:58:44', NULL, '1'),
(110500, '11', '05', '00', 'PISCO', '2010-12-15 01:58:44', NULL, '1'),
(110501, '11', '05', '01', 'PISCO', '2010-12-15 01:58:44', NULL, '1'),
(110502, '11', '05', '02', 'HUANCANO', '2010-12-15 01:58:44', NULL, '1'),
(110503, '11', '05', '03', 'HUMAY', '2010-12-15 01:58:44', NULL, '1'),
(110504, '11', '05', '04', 'INDEPENDENCIA', '2010-12-15 01:58:44', NULL, '1'),
(110505, '11', '05', '05', 'PARACAS', '2010-12-15 01:58:44', NULL, '1'),
(110506, '11', '05', '06', 'SAN ANDRES', '2010-12-15 01:58:44', NULL, '1'),
(110507, '11', '05', '07', 'SAN CLEMENTE', '2010-12-15 01:58:44', NULL, '1'),
(110508, '11', '05', '08', 'TUPAC AMARU INCA', '2010-12-15 01:58:44', NULL, '1'),
(120000, '12', '00', '00', 'JUNIN', '2010-12-15 01:58:44', NULL, '1'),
(120100, '12', '01', '00', 'HUANCAYO', '2010-12-15 01:58:44', NULL, '1'),
(120101, '12', '01', '01', 'HUANCAYO', '2010-12-15 01:58:44', NULL, '1'),
(120104, '12', '01', '04', 'CARHUACALLANGA', '2010-12-15 01:58:44', NULL, '1'),
(120105, '12', '01', '05', 'CHACAPAMPA', '2010-12-15 01:58:44', NULL, '1'),
(120106, '12', '01', '06', 'CHICCHE', '2010-12-15 01:58:44', NULL, '1'),
(120107, '12', '01', '07', 'CHILCA', '2010-12-15 01:58:44', NULL, '1'),
(120108, '12', '01', '08', 'CHONGOS ALTO', '2010-12-15 01:58:44', NULL, '1'),
(120111, '12', '01', '11', 'CHUPURO', '2010-12-15 01:58:44', NULL, '1'),
(120112, '12', '01', '12', 'COLCA', '2010-12-15 01:58:44', NULL, '1'),
(120113, '12', '01', '13', 'CULLHUAS', '2010-12-15 01:58:44', NULL, '1'),
(120114, '12', '01', '14', 'EL TAMBO', '2010-12-15 01:58:44', NULL, '1'),
(120116, '12', '01', '16', 'HUACRAPUQUIO', '2010-12-15 01:58:44', NULL, '1'),
(120117, '12', '01', '17', 'HUALHUAS', '2010-12-15 01:58:44', NULL, '1'),
(120119, '12', '01', '19', 'HUANCAN', '2010-12-15 01:58:44', NULL, '1'),
(120120, '12', '01', '20', 'HUASICANCHA', '2010-12-15 01:58:44', NULL, '1'),
(120121, '12', '01', '21', 'HUAYUCACHI', '2010-12-15 01:58:44', NULL, '1'),
(120122, '12', '01', '22', 'INGENIO', '2010-12-15 01:58:44', NULL, '1'),
(120124, '12', '01', '24', 'PARIAHUANCA', '2010-12-15 01:58:44', NULL, '1'),
(120125, '12', '01', '25', 'PILCOMAYO', '2010-12-15 01:58:44', NULL, '1'),
(120126, '12', '01', '26', 'PUCARA', '2010-12-15 01:58:44', NULL, '1'),
(120127, '12', '01', '27', 'QUICHUAY', '2010-12-15 01:58:44', NULL, '1'),
(120128, '12', '01', '28', 'QUILCAS', '2010-12-15 01:58:44', NULL, '1'),
(120129, '12', '01', '29', 'SAN AGUSTIN', '2010-12-15 01:58:44', NULL, '1'),
(120130, '12', '01', '30', 'SAN JERONIMO DE TUNAN', '2010-12-15 01:58:44', NULL, '1'),
(120132, '12', '01', '32', 'SAÃ‘O', '2010-12-15 01:58:44', NULL, '1'),
(120133, '12', '01', '33', 'SAPALLANGA', '2010-12-15 01:58:44', NULL, '1'),
(120134, '12', '01', '34', 'SICAYA', '2010-12-15 01:58:44', NULL, '1'),
(120135, '12', '01', '35', 'SANTO DOMINGO DE ACOBAMBA', '2010-12-15 01:58:44', NULL, '1'),
(120136, '12', '01', '36', 'VIQUES', '2010-12-15 01:58:44', NULL, '1'),
(120200, '12', '02', '00', 'CONCEPCION', '2010-12-15 01:58:44', NULL, '1'),
(120201, '12', '02', '01', 'CONCEPCION', '2010-12-15 01:58:44', NULL, '1'),
(120202, '12', '02', '02', 'ACO', '2010-12-15 01:58:44', NULL, '1'),
(120203, '12', '02', '03', 'ANDAMARCA', '2010-12-15 01:58:44', NULL, '1'),
(120204, '12', '02', '04', 'CHAMBARA', '2010-12-15 01:58:44', NULL, '1'),
(120205, '12', '02', '05', 'COCHAS', '2010-12-15 01:58:44', NULL, '1'),
(120206, '12', '02', '06', 'COMAS', '2010-12-15 01:58:44', NULL, '1'),
(120207, '12', '02', '07', 'HEROINAS TOLEDO', '2010-12-15 01:58:44', NULL, '1'),
(120208, '12', '02', '08', 'MANZANARES', '2010-12-15 01:58:44', NULL, '1'),
(120209, '12', '02', '09', 'MARISCAL CASTILLA', '2010-12-15 01:58:44', NULL, '1'),
(120210, '12', '02', '10', 'MATAHUASI', '2010-12-15 01:58:44', NULL, '1'),
(120211, '12', '02', '11', 'MITO', '2010-12-15 01:58:44', NULL, '1'),
(120212, '12', '02', '12', 'NUEVE DE JULIO', '2010-12-15 01:58:44', NULL, '1'),
(120213, '12', '02', '13', 'ORCOTUNA', '2010-12-15 01:58:44', NULL, '1'),
(120214, '12', '02', '14', 'SAN JOSE DE QUERO', '2010-12-15 01:58:44', NULL, '1'),
(120215, '12', '02', '15', 'SANTA ROSA DE OCOPA', '2010-12-15 01:58:44', NULL, '1'),
(120300, '12', '03', '00', 'CHANCHAMAYO', '2010-12-15 01:58:44', NULL, '1'),
(120301, '12', '03', '01', 'CHANCHAMAYO', '2010-12-15 01:58:44', NULL, '1'),
(120302, '12', '03', '02', 'PERENE', '2010-12-15 01:58:44', NULL, '1'),
(120303, '12', '03', '03', 'PICHANAQUI', '2010-12-15 01:58:44', NULL, '1'),
(120304, '12', '03', '04', 'SAN LUIS DE SHUARO', '2010-12-15 01:58:44', NULL, '1'),
(120305, '12', '03', '05', 'SAN RAMON', '2010-12-15 01:58:44', NULL, '1'),
(120306, '12', '03', '06', 'VITOC', '2010-12-15 01:58:44', NULL, '1'),
(120400, '12', '04', '00', 'JAUJA', '2010-12-15 01:58:44', NULL, '1'),
(120401, '12', '04', '01', 'JAUJA', '2010-12-15 01:58:44', NULL, '1'),
(120402, '12', '04', '02', 'ACOLLA', '2010-12-15 01:58:44', NULL, '1'),
(120403, '12', '04', '03', 'APATA', '2010-12-15 01:58:44', NULL, '1'),
(120404, '12', '04', '04', 'ATAURA', '2010-12-15 01:58:44', NULL, '1'),
(120405, '12', '04', '05', 'CANCHAYLLO', '2010-12-15 01:58:44', NULL, '1'),
(120406, '12', '04', '06', 'CURICACA', '2010-12-15 01:58:44', NULL, '1'),
(120407, '12', '04', '07', 'EL MANTARO', '2010-12-15 01:58:44', NULL, '1'),
(120408, '12', '04', '08', 'HUAMALI', '2010-12-15 01:58:44', NULL, '1'),
(120409, '12', '04', '09', 'HUARIPAMPA', '2010-12-15 01:58:44', NULL, '1'),
(120410, '12', '04', '10', 'HUERTAS', '2010-12-15 01:58:44', NULL, '1'),
(120411, '12', '04', '11', 'JANJAILLO', '2010-12-15 01:58:44', NULL, '1'),
(120412, '12', '04', '12', 'JULCAN', '2010-12-15 01:58:44', NULL, '1'),
(120413, '12', '04', '13', 'LEONOR ORDOÃ‘EZ', '2010-12-15 01:58:44', NULL, '1'),
(120414, '12', '04', '14', 'LLOCLLAPAMPA', '2010-12-15 01:58:44', NULL, '1'),
(120415, '12', '04', '15', 'MARCO', '2010-12-15 01:58:44', NULL, '1'),
(120416, '12', '04', '16', 'MASMA', '2010-12-15 01:58:44', NULL, '1'),
(120417, '12', '04', '17', 'MASMA CHICCHE', '2010-12-15 01:58:44', NULL, '1'),
(120418, '12', '04', '18', 'MOLINOS', '2010-12-15 01:58:44', NULL, '1'),
(120419, '12', '04', '19', 'MONOBAMBA', '2010-12-15 01:58:44', NULL, '1'),
(120420, '12', '04', '20', 'MUQUI', '2010-12-15 01:58:44', NULL, '1'),
(120421, '12', '04', '21', 'MUQUIYAUYO', '2010-12-15 01:58:44', NULL, '1'),
(120422, '12', '04', '22', 'PACA', '2010-12-15 01:58:44', NULL, '1'),
(120423, '12', '04', '23', 'PACCHA', '2010-12-15 01:58:44', NULL, '1'),
(120424, '12', '04', '24', 'PANCAN', '2010-12-15 01:58:44', NULL, '1'),
(120425, '12', '04', '25', 'PARCO', '2010-12-15 01:58:44', NULL, '1'),
(120426, '12', '04', '26', 'POMACANCHA', '2010-12-15 01:58:44', NULL, '1'),
(120427, '12', '04', '27', 'RICRAN', '2010-12-15 01:58:44', NULL, '1'),
(120428, '12', '04', '28', 'SAN LORENZO', '2010-12-15 01:58:44', NULL, '1'),
(120429, '12', '04', '29', 'SAN PEDRO DE CHUNAN', '2010-12-15 01:58:44', NULL, '1'),
(120430, '12', '04', '30', 'SAUSA', '2010-12-15 01:58:44', NULL, '1'),
(120431, '12', '04', '31', 'SINCOS', '2010-12-15 01:58:44', NULL, '1'),
(120432, '12', '04', '32', 'TUNAN MARCA', '2010-12-15 01:58:44', NULL, '1'),
(120433, '12', '04', '33', 'YAULI', '2010-12-15 01:58:44', NULL, '1'),
(120434, '12', '04', '34', 'YAUYOS', '2010-12-15 01:58:44', NULL, '1'),
(120500, '12', '05', '00', 'JUNIN', '2010-12-15 01:58:44', NULL, '1'),
(120501, '12', '05', '01', 'JUNIN', '2010-12-15 01:58:44', NULL, '1'),
(120502, '12', '05', '02', 'CARHUAMAYO', '2010-12-15 01:58:44', NULL, '1'),
(120503, '12', '05', '03', 'ONDORES', '2010-12-15 01:58:44', NULL, '1'),
(120504, '12', '05', '04', 'ULCUMAYO', '2010-12-15 01:58:44', NULL, '1'),
(120600, '12', '06', '00', 'SATIPO', '2010-12-15 01:58:44', NULL, '1'),
(120601, '12', '06', '01', 'SATIPO', '2010-12-15 01:58:44', NULL, '1'),
(120602, '12', '06', '02', 'COVIRIALI', '2010-12-15 01:58:44', NULL, '1'),
(120603, '12', '06', '03', 'LLAYLLA', '2010-12-15 01:58:44', NULL, '1'),
(120604, '12', '06', '04', 'MAZAMARI', '2010-12-15 01:58:44', NULL, '1'),
(120605, '12', '06', '05', 'PAMPA HERMOSA', '2010-12-15 01:58:44', NULL, '1'),
(120606, '12', '06', '06', 'PANGOA', '2010-12-15 01:58:44', NULL, '1'),
(120607, '12', '06', '07', 'RIO NEGRO', '2010-12-15 01:58:44', NULL, '1'),
(120608, '12', '06', '08', 'RIO TAMBO', '2010-12-15 01:58:44', NULL, '1'),
(120700, '12', '07', '00', 'TARMA', '2010-12-15 01:58:44', NULL, '1'),
(120701, '12', '07', '01', 'TARMA', '2010-12-15 01:58:44', NULL, '1'),
(120702, '12', '07', '02', 'ACOBAMBA', '2010-12-15 01:58:44', NULL, '1'),
(120703, '12', '07', '03', 'HUARICOLCA', '2010-12-15 01:58:44', NULL, '1'),
(120704, '12', '07', '04', 'HUASAHUASI', '2010-12-15 01:58:44', NULL, '1'),
(120705, '12', '07', '05', 'LA UNION', '2010-12-15 01:58:44', NULL, '1'),
(120706, '12', '07', '06', 'PALCA', '2010-12-15 01:58:44', NULL, '1'),
(120707, '12', '07', '07', 'PALCAMAYO', '2010-12-15 01:58:44', NULL, '1'),
(120708, '12', '07', '08', 'SAN PEDRO DE CAJAS', '2010-12-15 01:58:44', NULL, '1'),
(120709, '12', '07', '09', 'TAPO', '2010-12-15 01:58:44', NULL, '1'),
(120800, '12', '08', '00', 'YAULI', '2010-12-15 01:58:44', NULL, '1'),
(120801, '12', '08', '01', 'LA OROYA', '2010-12-15 01:58:44', NULL, '1'),
(120802, '12', '08', '02', 'CHACAPALPA', '2010-12-15 01:58:44', NULL, '1'),
(120803, '12', '08', '03', 'HUAY-HUAY', '2010-12-15 01:58:44', NULL, '1'),
(120804, '12', '08', '04', 'MARCAPOMACOCHA', '2010-12-15 01:58:44', NULL, '1'),
(120805, '12', '08', '05', 'MOROCOCHA', '2010-12-15 01:58:44', NULL, '1'),
(120806, '12', '08', '06', 'PACCHA', '2010-12-15 01:58:44', NULL, '1'),
(120807, '12', '08', '07', 'SANTA BARBARA DE CARHUACAYAN', '2010-12-15 01:58:44', NULL, '1'),
(120808, '12', '08', '08', 'SANTA ROSA DE SACCO', '2010-12-15 01:58:44', NULL, '1'),
(120809, '12', '08', '09', 'SUITUCANCHA', '2010-12-15 01:58:44', NULL, '1'),
(120810, '12', '08', '10', 'YAULI', '2010-12-15 01:58:44', NULL, '1'),
(120900, '12', '09', '00', 'CHUPACA', '2010-12-15 01:58:44', NULL, '1'),
(120901, '12', '09', '01', 'CHUPACA', '2010-12-15 01:58:44', NULL, '1'),
(120902, '12', '09', '02', 'AHUAC', '2010-12-15 01:58:44', NULL, '1'),
(120903, '12', '09', '03', 'CHONGOS BAJO', '2010-12-15 01:58:44', NULL, '1'),
(120904, '12', '09', '04', 'HUACHAC', '2010-12-15 01:58:44', NULL, '1'),
(120905, '12', '09', '05', 'HUAMANCACA CHICO', '2010-12-15 01:58:44', NULL, '1'),
(120906, '12', '09', '06', 'SAN JUAN DE YSCOS', '2010-12-15 01:58:44', NULL, '1'),
(120907, '12', '09', '07', 'SAN JUAN DE JARPA', '2010-12-15 01:58:44', NULL, '1'),
(120908, '12', '09', '08', 'TRES DE DICIEMBRE', '2010-12-15 01:58:44', NULL, '1'),
(120909, '12', '09', '09', 'YANACANCHA', '2010-12-15 01:58:44', NULL, '1'),
(130000, '13', '00', '00', 'LA LIBERTAD', '2010-12-15 01:58:44', NULL, '1'),
(130100, '13', '01', '00', 'TRUJILLO', '2010-12-15 01:58:44', NULL, '1'),
(130101, '13', '01', '01', 'TRUJILLO', '2010-12-15 01:58:44', NULL, '1'),
(130102, '13', '01', '02', 'EL PORVENIR', '2010-12-15 01:58:44', NULL, '1'),
(130103, '13', '01', '03', 'FLORENCIA DE MORA', '2010-12-15 01:58:44', NULL, '1'),
(130104, '13', '01', '04', 'HUANCHACO', '2010-12-15 01:58:44', NULL, '1'),
(130105, '13', '01', '05', 'LA ESPERANZA', '2010-12-15 01:58:44', NULL, '1'),
(130106, '13', '01', '06', 'LAREDO', '2010-12-15 01:58:44', NULL, '1'),
(130107, '13', '01', '07', 'MOCHE', '2010-12-15 01:58:44', NULL, '1'),
(130108, '13', '01', '08', 'POROTO', '2010-12-15 01:58:44', NULL, '1'),
(130109, '13', '01', '09', 'SALAVERRY', '2010-12-15 01:58:44', NULL, '1'),
(130110, '13', '01', '10', 'SIMBAL', '2010-12-15 01:58:44', NULL, '1'),
(130111, '13', '01', '11', 'VICTOR LARCO HERRERA', '2010-12-15 01:58:44', NULL, '1'),
(130200, '13', '02', '00', 'ASCOPE', '2010-12-15 01:58:44', NULL, '1'),
(130201, '13', '02', '01', 'ASCOPE', '2010-12-15 01:58:44', NULL, '1'),
(130202, '13', '02', '02', 'CHICAMA', '2010-12-15 01:58:44', NULL, '1'),
(130203, '13', '02', '03', 'CHOCOPE', '2010-12-15 01:58:44', NULL, '1'),
(130204, '13', '02', '04', 'MAGDALENA DE CAO', '2010-12-15 01:58:44', NULL, '1'),
(130205, '13', '02', '05', 'PAIJAN', '2010-12-15 01:58:44', NULL, '1'),
(130206, '13', '02', '06', 'RAZURI', '2010-12-15 01:58:44', NULL, '1'),
(130207, '13', '02', '07', 'SANTIAGO DE CAO', '2010-12-15 01:58:44', NULL, '1'),
(130208, '13', '02', '08', 'CASA GRANDE', '2010-12-15 01:58:44', NULL, '1'),
(130300, '13', '03', '00', 'BOLIVAR', '2010-12-15 01:58:44', NULL, '1'),
(130301, '13', '03', '01', 'BOLIVAR', '2010-12-15 01:58:44', NULL, '1'),
(130302, '13', '03', '02', 'BAMBAMARCA', '2010-12-15 01:58:44', NULL, '1'),
(130303, '13', '03', '03', 'CONDORMARCA', '2010-12-15 01:58:44', NULL, '1'),
(130304, '13', '03', '04', 'LONGOTEA', '2010-12-15 01:58:44', NULL, '1'),
(130305, '13', '03', '05', 'UCHUMARCA', '2010-12-15 01:58:44', NULL, '1'),
(130306, '13', '03', '06', 'UCUNCHA', '2010-12-15 01:58:44', NULL, '1'),
(130400, '13', '04', '00', 'CHEPEN', '2010-12-15 01:58:44', NULL, '1'),
(130401, '13', '04', '01', 'CHEPEN', '2010-12-15 01:58:44', NULL, '1'),
(130402, '13', '04', '02', 'PACANGA', '2010-12-15 01:58:44', NULL, '1'),
(130403, '13', '04', '03', 'PUEBLO NUEVO', '2010-12-15 01:58:44', NULL, '1'),
(130500, '13', '05', '00', 'JULCAN', '2010-12-15 01:58:44', NULL, '1'),
(130501, '13', '05', '01', 'JULCAN', '2010-12-15 01:58:44', NULL, '1'),
(130502, '13', '05', '02', 'CALAMARCA', '2010-12-15 01:58:44', NULL, '1'),
(130503, '13', '05', '03', 'CARABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(130504, '13', '05', '04', 'HUASO', '2010-12-15 01:58:44', NULL, '1'),
(130600, '13', '06', '00', 'OTUZCO', '2010-12-15 01:58:44', NULL, '1'),
(130601, '13', '06', '01', 'OTUZCO', '2010-12-15 01:58:44', NULL, '1'),
(130602, '13', '06', '02', 'AGALLPAMPA', '2010-12-15 01:58:44', NULL, '1'),
(130604, '13', '06', '04', 'CHARAT', '2010-12-15 01:58:44', NULL, '1'),
(130605, '13', '06', '05', 'HUARANCHAL', '2010-12-15 01:58:44', NULL, '1'),
(130606, '13', '06', '06', 'LA CUESTA', '2010-12-15 01:58:44', NULL, '1'),
(130608, '13', '06', '08', 'MACHE', '2010-12-15 01:58:44', NULL, '1'),
(130610, '13', '06', '10', 'PARANDAY', '2010-12-15 01:58:44', NULL, '1'),
(130611, '13', '06', '11', 'SALPO', '2010-12-15 01:58:44', NULL, '1'),
(130613, '13', '06', '13', 'SINSICAP', '2010-12-15 01:58:44', NULL, '1'),
(130614, '13', '06', '14', 'USQUIL', '2010-12-15 01:58:44', NULL, '1'),
(130700, '13', '07', '00', 'PACASMAYO', '2010-12-15 01:58:44', NULL, '1'),
(130701, '13', '07', '01', 'SAN PEDRO DE LLOC', '2010-12-15 01:58:44', NULL, '1'),
(130702, '13', '07', '02', 'GUADALUPE', '2010-12-15 01:58:44', NULL, '1'),
(130703, '13', '07', '03', 'JEQUETEPEQUE', '2010-12-15 01:58:44', NULL, '1'),
(130704, '13', '07', '04', 'PACASMAYO', '2010-12-15 01:58:44', NULL, '1'),
(130705, '13', '07', '05', 'SAN JOSE', '2010-12-15 01:58:44', NULL, '1'),
(130800, '13', '08', '00', 'PATAZ', '2010-12-15 01:58:44', NULL, '1'),
(130801, '13', '08', '01', 'TAYABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(130802, '13', '08', '02', 'BULDIBUYO', '2010-12-15 01:58:44', NULL, '1'),
(130803, '13', '08', '03', 'CHILLIA', '2010-12-15 01:58:44', NULL, '1'),
(130804, '13', '08', '04', 'HUANCASPATA', '2010-12-15 01:58:44', NULL, '1'),
(130805, '13', '08', '05', 'HUAYLILLAS', '2010-12-15 01:58:44', NULL, '1'),
(130806, '13', '08', '06', 'HUAYO', '2010-12-15 01:58:44', NULL, '1'),
(130807, '13', '08', '07', 'ONGON', '2010-12-15 01:58:44', NULL, '1'),
(130808, '13', '08', '08', 'PARCOY', '2010-12-15 01:58:44', NULL, '1'),
(130809, '13', '08', '09', 'PATAZ', '2010-12-15 01:58:44', NULL, '1'),
(130810, '13', '08', '10', 'PIAS', '2010-12-15 01:58:44', NULL, '1'),
(130811, '13', '08', '11', 'SANTIAGO DE CHALLAS', '2010-12-15 01:58:44', NULL, '1'),
(130812, '13', '08', '12', 'TAURIJA', '2010-12-15 01:58:44', NULL, '1'),
(130813, '13', '08', '13', 'URPAY', '2010-12-15 01:58:44', NULL, '1'),
(130900, '13', '09', '00', 'SANCHEZ CARRION', '2010-12-15 01:58:44', NULL, '1'),
(130901, '13', '09', '01', 'HUAMACHUCO', '2010-12-15 01:58:44', NULL, '1'),
(130902, '13', '09', '02', 'CHUGAY', '2010-12-15 01:58:44', NULL, '1'),
(130903, '13', '09', '03', 'COCHORCO', '2010-12-15 01:58:44', NULL, '1'),
(130904, '13', '09', '04', 'CURGOS', '2010-12-15 01:58:44', NULL, '1'),
(130905, '13', '09', '05', 'MARCABAL', '2010-12-15 01:58:44', NULL, '1'),
(130906, '13', '09', '06', 'SANAGORAN', '2010-12-15 01:58:44', NULL, '1'),
(130907, '13', '09', '07', 'SARIN', '2010-12-15 01:58:44', NULL, '1'),
(130908, '13', '09', '08', 'SARTIMBAMBA', '2010-12-15 01:58:44', NULL, '1'),
(131000, '13', '10', '00', 'SANTIAGO DE CHUCO', '2010-12-15 01:58:44', NULL, '1'),
(131001, '13', '10', '01', 'SANTIAGO DE CHUCO', '2010-12-15 01:58:44', NULL, '1'),
(131002, '13', '10', '02', 'ANGASMARCA', '2010-12-15 01:58:44', NULL, '1'),
(131003, '13', '10', '03', 'CACHICADAN', '2010-12-15 01:58:44', NULL, '1'),
(131004, '13', '10', '04', 'MOLLEBAMBA', '2010-12-15 01:58:44', NULL, '1'),
(131005, '13', '10', '05', 'MOLLEPATA', '2010-12-15 01:58:44', NULL, '1'),
(131006, '13', '10', '06', 'QUIRUVILCA', '2010-12-15 01:58:44', NULL, '1'),
(131007, '13', '10', '07', 'SANTA CRUZ DE CHUCA', '2010-12-15 01:58:44', NULL, '1'),
(131008, '13', '10', '08', 'SITABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(131100, '13', '11', '00', 'GRAN CHIMU', '2010-12-15 01:58:44', NULL, '1'),
(131101, '13', '11', '01', 'CASCAS', '2010-12-15 01:58:44', NULL, '1'),
(131102, '13', '11', '02', 'LUCMA', '2010-12-15 01:58:44', NULL, '1'),
(131103, '13', '11', '03', 'COMPIN', '2010-12-15 01:58:44', NULL, '1'),
(131104, '13', '11', '04', 'SAYAPULLO', '2010-12-15 01:58:44', NULL, '1'),
(131200, '13', '12', '00', 'VIRU', '2010-12-15 01:58:44', NULL, '1'),
(131201, '13', '12', '01', 'VIRU', '2010-12-15 01:58:44', NULL, '1'),
(131202, '13', '12', '02', 'CHAO', '2010-12-15 01:58:44', NULL, '1'),
(131203, '13', '12', '03', 'GUADALUPITO', '2010-12-15 01:58:44', NULL, '1'),
(140000, '14', '00', '00', 'LAMBAYEQUE', '2010-12-15 01:58:44', NULL, '1'),
(140100, '14', '01', '00', 'CHICLAYO', '2010-12-15 01:58:44', NULL, '1'),
(140101, '14', '01', '01', 'CHICLAYO', '2010-12-15 01:58:44', NULL, '1'),
(140102, '14', '01', '02', 'CHONGOYAPE', '2010-12-15 01:58:44', NULL, '1'),
(140103, '14', '01', '03', 'ETEN', '2010-12-15 01:58:44', NULL, '1'),
(140104, '14', '01', '04', 'ETEN PUERTO', '2010-12-15 01:58:44', NULL, '1'),
(140105, '14', '01', '05', 'JOSE LEONARDO ORTIZ', '2010-12-15 01:58:44', NULL, '1'),
(140106, '14', '01', '06', 'LA VICTORIA', '2010-12-15 01:58:44', NULL, '1'),
(140107, '14', '01', '07', 'LAGUNAS', '2010-12-15 01:58:44', NULL, '1'),
(140108, '14', '01', '08', 'MONSEFU', '2010-12-15 01:58:44', NULL, '1'),
(140109, '14', '01', '09', 'NUEVA ARICA', '2010-12-15 01:58:44', NULL, '1'),
(140110, '14', '01', '10', 'OYOTUN', '2010-12-15 01:58:44', NULL, '1'),
(140111, '14', '01', '11', 'PICSI', '2010-12-15 01:58:44', NULL, '1'),
(140112, '14', '01', '12', 'PIMENTEL', '2010-12-15 01:58:44', NULL, '1'),
(140113, '14', '01', '13', 'REQUE', '2010-12-15 01:58:44', NULL, '1'),
(140114, '14', '01', '14', 'SANTA ROSA', '2010-12-15 01:58:44', NULL, '1'),
(140115, '14', '01', '15', 'SAÃ‘A', '2010-12-15 01:58:44', NULL, '1'),
(140116, '14', '01', '16', 'CAYALTI', '2010-12-15 01:58:44', NULL, '1'),
(140117, '14', '01', '17', 'PATAPO', '2010-12-15 01:58:44', NULL, '1'),
(140118, '14', '01', '18', 'POMALCA', '2010-12-15 01:58:44', NULL, '1'),
(140119, '14', '01', '19', 'PUCALA', '2010-12-15 01:58:44', NULL, '1'),
(140120, '14', '01', '20', 'TUMAN', '2010-12-15 01:58:44', NULL, '1'),
(140200, '14', '02', '00', 'FERREÃ‘AFE', '2010-12-15 01:58:44', NULL, '1'),
(140201, '14', '02', '01', 'FERREÃ‘AFE', '2010-12-15 01:58:44', NULL, '1'),
(140202, '14', '02', '02', 'CAÃ‘ARIS', '2010-12-15 01:58:44', NULL, '1'),
(140203, '14', '02', '03', 'INCAHUASI', '2010-12-15 01:58:44', NULL, '1'),
(140204, '14', '02', '04', 'MANUEL ANTONIO MESONES MURO', '2010-12-15 01:58:44', NULL, '1');
INSERT INTO `cji_ubigeo` (`UBIGP_Codigo`, `UBIGC_CodDpto`, `UBIGC_CodProv`, `UBIGC_CodDist`, `UBIGC_Descripcion`, `UBIGC_FechaRegistro`, `UBIGC_FechaModificacion`, `UBIGC_FlagEstado`) VALUES
(140205, '14', '02', '05', 'PITIPO', '2010-12-15 01:58:44', NULL, '1'),
(140206, '14', '02', '06', 'PUEBLO NUEVO', '2010-12-15 01:58:44', NULL, '1'),
(140300, '14', '03', '00', 'LAMBAYEQUE', '2010-12-15 01:58:44', NULL, '1'),
(140301, '14', '03', '01', 'LAMBAYEQUE', '2010-12-15 01:58:44', NULL, '1'),
(140302, '14', '03', '02', 'CHOCHOPE', '2010-12-15 01:58:44', NULL, '1'),
(140303, '14', '03', '03', 'ILLIMO', '2010-12-15 01:58:44', NULL, '1'),
(140304, '14', '03', '04', 'JAYANCA', '2010-12-15 01:58:44', NULL, '1'),
(140305, '14', '03', '05', 'MOCHUMI', '2010-12-15 01:58:44', NULL, '1'),
(140306, '14', '03', '06', 'MORROPE', '2010-12-15 01:58:44', NULL, '1'),
(140307, '14', '03', '07', 'MOTUPE', '2010-12-15 01:58:44', NULL, '1'),
(140308, '14', '03', '08', 'OLMOS', '2010-12-15 01:58:44', NULL, '1'),
(140309, '14', '03', '09', 'PACORA', '2010-12-15 01:58:44', NULL, '1'),
(140310, '14', '03', '10', 'SALAS', '2010-12-15 01:58:44', NULL, '1'),
(140311, '14', '03', '11', 'SAN JOSE', '2010-12-15 01:58:44', NULL, '1'),
(140312, '14', '03', '12', 'TUCUME', '2010-12-15 01:58:44', NULL, '1'),
(150000, '15', '00', '00', 'LIMA', '2010-12-15 01:58:44', NULL, '1'),
(150100, '15', '01', '00', 'LIMA', '2010-12-15 01:58:44', NULL, '1'),
(150101, '15', '01', '01', 'LIMA', '2010-12-15 01:58:44', NULL, '1'),
(150102, '15', '01', '02', 'ANCON', '2010-12-15 01:58:44', NULL, '1'),
(150103, '15', '01', '03', 'ATE', '2010-12-15 01:58:44', NULL, '1'),
(150104, '15', '01', '04', 'BARRANCO', '2010-12-15 01:58:44', NULL, '1'),
(150105, '15', '01', '05', 'BREÃ‘A', '2010-12-15 01:58:44', NULL, '1'),
(150106, '15', '01', '06', 'CARABAYLLO', '2010-12-15 01:58:44', NULL, '1'),
(150107, '15', '01', '07', 'CHACLACAYO', '2010-12-15 01:58:44', NULL, '1'),
(150108, '15', '01', '08', 'CHORRILLOS', '2010-12-15 01:58:44', NULL, '1'),
(150109, '15', '01', '09', 'CIENEGUILLA', '2010-12-15 01:58:44', NULL, '1'),
(150110, '15', '01', '10', 'COMAS', '2010-12-15 01:58:44', NULL, '1'),
(150111, '15', '01', '11', 'EL AGUSTINO', '2010-12-15 01:58:44', NULL, '1'),
(150112, '15', '01', '12', 'INDEPENDENCIA', '2010-12-15 01:58:44', NULL, '1'),
(150113, '15', '01', '13', 'JESUS MARIA', '2010-12-15 01:58:44', NULL, '1'),
(150114, '15', '01', '14', 'LA MOLINA', '2010-12-15 01:58:44', NULL, '1'),
(150115, '15', '01', '15', 'LA VICTORIA', '2010-12-15 01:58:44', NULL, '1'),
(150116, '15', '01', '16', 'LINCE', '2010-12-15 01:58:44', NULL, '1'),
(150117, '15', '01', '17', 'LOS OLIVOS', '2010-12-15 01:58:44', NULL, '1'),
(150118, '15', '01', '18', 'LURIGANCHO', '2010-12-15 01:58:44', NULL, '1'),
(150119, '15', '01', '19', 'LURIN', '2010-12-15 01:58:44', NULL, '1'),
(150120, '15', '01', '20', 'MAGDALENA DEL MAR', '2010-12-15 01:58:44', NULL, '1'),
(150121, '15', '01', '21', 'MAGDALENA VIEJA', '2010-12-15 01:58:44', NULL, '1'),
(150122, '15', '01', '22', 'MIRAFLORES', '2010-12-15 01:58:44', NULL, '1'),
(150123, '15', '01', '23', 'PACHACAMAC', '2010-12-15 01:58:44', NULL, '1'),
(150124, '15', '01', '24', 'PUCUSANA', '2010-12-15 01:58:44', NULL, '1'),
(150125, '15', '01', '25', 'PUENTE PIEDRA', '2010-12-15 01:58:44', NULL, '1'),
(150126, '15', '01', '26', 'PUNTA HERMOSA', '2010-12-15 01:58:44', NULL, '1'),
(150127, '15', '01', '27', 'PUNTA NEGRA', '2010-12-15 01:58:44', NULL, '1'),
(150128, '15', '01', '28', 'RIMAC', '2010-12-15 01:58:44', NULL, '1'),
(150129, '15', '01', '29', 'SAN BARTOLO', '2010-12-15 01:58:44', NULL, '1'),
(150130, '15', '01', '30', 'SAN BORJA', '2010-12-15 01:58:44', NULL, '1'),
(150131, '15', '01', '31', 'SAN ISIDRO', '2010-12-15 01:58:44', NULL, '1'),
(150132, '15', '01', '32', 'SAN JUAN DE LURIGANCHO', '2010-12-15 01:58:44', NULL, '1'),
(150133, '15', '01', '33', 'SAN JUAN DE MIRAFLORES', '2010-12-15 01:58:44', NULL, '1'),
(150134, '15', '01', '34', 'SAN LUIS', '2010-12-15 01:58:44', NULL, '1'),
(150135, '15', '01', '35', 'SAN MARTIN DE PORRES', '2010-12-15 01:58:44', NULL, '1'),
(150136, '15', '01', '36', 'SAN MIGUEL', '2010-12-15 01:58:44', NULL, '1'),
(150137, '15', '01', '37', 'SANTA ANITA', '2010-12-15 01:58:44', NULL, '1'),
(150138, '15', '01', '38', 'SANTA MARIA DEL MAR', '2010-12-15 01:58:44', NULL, '1'),
(150139, '15', '01', '39', 'SANTA ROSA', '2010-12-15 01:58:44', NULL, '1'),
(150140, '15', '01', '40', 'SANTIAGO DE SURCO', '2010-12-15 01:58:44', NULL, '1'),
(150141, '15', '01', '41', 'SURQUILLO', '2010-12-15 01:58:44', NULL, '1'),
(150142, '15', '01', '42', 'VILLA EL SALVADOR', '2010-12-15 01:58:44', NULL, '1'),
(150143, '15', '01', '43', 'VILLA MARIA DEL TRIUNFO', '2010-12-15 01:58:44', NULL, '1'),
(150200, '15', '02', '00', 'BARRANCA', '2010-12-15 01:58:44', NULL, '1'),
(150201, '15', '02', '01', 'BARRANCA', '2010-12-15 01:58:44', NULL, '1'),
(150202, '15', '02', '02', 'PARAMONGA', '2010-12-15 01:58:44', NULL, '1'),
(150203, '15', '02', '03', 'PATIVILCA', '2010-12-15 01:58:44', NULL, '1'),
(150204, '15', '02', '04', 'SUPE', '2010-12-15 01:58:44', NULL, '1'),
(150205, '15', '02', '05', 'SUPE PUERTO', '2010-12-15 01:58:44', NULL, '1'),
(150300, '15', '03', '00', 'CAJATAMBO', '2010-12-15 01:58:44', NULL, '1'),
(150301, '15', '03', '01', 'CAJATAMBO', '2010-12-15 01:58:44', NULL, '1'),
(150302, '15', '03', '02', 'COPA', '2010-12-15 01:58:44', NULL, '1'),
(150303, '15', '03', '03', 'GORGOR', '2010-12-15 01:58:44', NULL, '1'),
(150304, '15', '03', '04', 'HUANCAPON', '2010-12-15 01:58:44', NULL, '1'),
(150305, '15', '03', '05', 'MANAS', '2010-12-15 01:58:44', NULL, '1'),
(150400, '15', '04', '00', 'CANTA', '2010-12-15 01:58:44', NULL, '1'),
(150401, '15', '04', '01', 'CANTA', '2010-12-15 01:58:44', NULL, '1'),
(150402, '15', '04', '02', 'ARAHUAY', '2010-12-15 01:58:44', NULL, '1'),
(150403, '15', '04', '03', 'HUAMANTANGA', '2010-12-15 01:58:44', NULL, '1'),
(150404, '15', '04', '04', 'HUAROS', '2010-12-15 01:58:44', NULL, '1'),
(150405, '15', '04', '05', 'LACHAQUI', '2010-12-15 01:58:44', NULL, '1'),
(150406, '15', '04', '06', 'SAN BUENAVENTURA', '2010-12-15 01:58:44', NULL, '1'),
(150407, '15', '04', '07', 'SANTA ROSA DE QUIVES', '2010-12-15 01:58:44', NULL, '1'),
(150500, '15', '05', '00', 'CAÃ‘ETE', '2010-12-15 01:58:44', NULL, '1'),
(150501, '15', '05', '01', 'SAN VICENTE DE CAÃ‘ETE', '2010-12-15 01:58:44', NULL, '1'),
(150502, '15', '05', '02', 'ASIA', '2010-12-15 01:58:44', NULL, '1'),
(150503, '15', '05', '03', 'CALANGO', '2010-12-15 01:58:44', NULL, '1'),
(150504, '15', '05', '04', 'CERRO AZUL', '2010-12-15 01:58:44', NULL, '1'),
(150505, '15', '05', '05', 'CHILCA', '2010-12-15 01:58:44', NULL, '1'),
(150506, '15', '05', '06', 'COAYLLO', '2010-12-15 01:58:44', NULL, '1'),
(150507, '15', '05', '07', 'IMPERIAL', '2010-12-15 01:58:44', NULL, '1'),
(150508, '15', '05', '08', 'LUNAHUANA', '2010-12-15 01:58:44', NULL, '1'),
(150509, '15', '05', '09', 'MALA', '2010-12-15 01:58:44', NULL, '1'),
(150510, '15', '05', '10', 'NUEVO IMPERIAL', '2010-12-15 01:58:44', NULL, '1'),
(150511, '15', '05', '11', 'PACARAN', '2010-12-15 01:58:44', NULL, '1'),
(150512, '15', '05', '12', 'QUILMANA', '2010-12-15 01:58:44', NULL, '1'),
(150513, '15', '05', '13', 'SAN ANTONIO', '2010-12-15 01:58:44', NULL, '1'),
(150514, '15', '05', '14', 'SAN LUIS', '2010-12-15 01:58:44', NULL, '1'),
(150515, '15', '05', '15', 'SANTA CRUZ DE FLORES', '2010-12-15 01:58:44', NULL, '1'),
(150516, '15', '05', '16', 'ZUÃ‘IGA', '2010-12-15 01:58:44', NULL, '1'),
(150600, '15', '06', '00', 'HUARAL', '2010-12-15 01:58:44', NULL, '1'),
(150601, '15', '06', '01', 'HUARAL', '2010-12-15 01:58:44', NULL, '1'),
(150602, '15', '06', '02', 'ATAVILLOS ALTO', '2010-12-15 01:58:44', NULL, '1'),
(150603, '15', '06', '03', 'ATAVILLOS BAJO', '2010-12-15 01:58:44', NULL, '1'),
(150604, '15', '06', '04', 'AUCALLAMA', '2010-12-15 01:58:44', NULL, '1'),
(150605, '15', '06', '05', 'CHANCAY', '2010-12-15 01:58:44', NULL, '1'),
(150606, '15', '06', '06', 'IHUARI', '2010-12-15 01:58:44', NULL, '1'),
(150607, '15', '06', '07', 'LAMPIAN', '2010-12-15 01:58:44', NULL, '1'),
(150608, '15', '06', '08', 'PACARAOS', '2010-12-15 01:58:44', NULL, '1'),
(150609, '15', '06', '09', 'SAN MIGUEL DE ACOS', '2010-12-15 01:58:44', NULL, '1'),
(150610, '15', '06', '10', 'SANTA CRUZ DE ANDAMARCA', '2010-12-15 01:58:44', NULL, '1'),
(150611, '15', '06', '11', 'SUMBILCA', '2010-12-15 01:58:44', NULL, '1'),
(150612, '15', '06', '12', 'VEINTISIETE DE NOVIEMBRE', '2010-12-15 01:58:44', NULL, '1'),
(150700, '15', '07', '00', 'HUAROCHIRI', '2010-12-15 01:58:44', NULL, '1'),
(150701, '15', '07', '01', 'MATUCANA', '2010-12-15 01:58:44', NULL, '1'),
(150702, '15', '07', '02', 'ANTIOQUIA', '2010-12-15 01:58:44', NULL, '1'),
(150703, '15', '07', '03', 'CALLAHUANCA', '2010-12-15 01:58:44', NULL, '1'),
(150704, '15', '07', '04', 'CARAMPOMA', '2010-12-15 01:58:44', NULL, '1'),
(150705, '15', '07', '05', 'CHICLA', '2010-12-15 01:58:44', NULL, '1'),
(150706, '15', '07', '06', 'CUENCA', '2010-12-15 01:58:44', NULL, '1'),
(150707, '15', '07', '07', 'HUACHUPAMPA', '2010-12-15 01:58:44', NULL, '1'),
(150708, '15', '07', '08', 'HUANZA', '2010-12-15 01:58:44', NULL, '1'),
(150709, '15', '07', '09', 'HUAROCHIRI', '2010-12-15 01:58:44', NULL, '1'),
(150710, '15', '07', '10', 'LAHUAYTAMBO', '2010-12-15 01:58:44', NULL, '1'),
(150711, '15', '07', '11', 'LANGA', '2010-12-15 01:58:44', NULL, '1'),
(150712, '15', '07', '12', 'LARAOS', '2010-12-15 01:58:44', NULL, '1'),
(150713, '15', '07', '13', 'MARIATANA', '2010-12-15 01:58:44', NULL, '1'),
(150714, '15', '07', '14', 'RICARDO PALMA', '2010-12-15 01:58:44', NULL, '1'),
(150715, '15', '07', '15', 'SAN ANDRES DE TUPICOCHA', '2010-12-15 01:58:44', NULL, '1'),
(150716, '15', '07', '16', 'SAN ANTONIO', '2010-12-15 01:58:44', NULL, '1'),
(150717, '15', '07', '17', 'SAN BARTOLOME', '2010-12-15 01:58:44', NULL, '1'),
(150718, '15', '07', '18', 'SAN DAMIAN', '2010-12-15 01:58:44', NULL, '1'),
(150719, '15', '07', '19', 'SAN JUAN DE IRIS', '2010-12-15 01:58:44', NULL, '1'),
(150720, '15', '07', '20', 'SAN JUAN DE TANTARANCHE', '2010-12-15 01:58:44', NULL, '1'),
(150721, '15', '07', '21', 'SAN LORENZO DE QUINTI', '2010-12-15 01:58:44', NULL, '1'),
(150722, '15', '07', '22', 'SAN MATEO', '2010-12-15 01:58:44', NULL, '1'),
(150723, '15', '07', '23', 'SAN MATEO DE OTAO', '2010-12-15 01:58:44', NULL, '1'),
(150724, '15', '07', '24', 'SAN PEDRO DE CASTA', '2010-12-15 01:58:44', NULL, '1'),
(150725, '15', '07', '25', 'SAN PEDRO DE HUANCAYRE', '2010-12-15 01:58:44', NULL, '1'),
(150726, '15', '07', '26', 'SANGALLAYA', '2010-12-15 01:58:44', NULL, '1'),
(150727, '15', '07', '27', 'SANTA CRUZ DE COCACHACRA', '2010-12-15 01:58:44', NULL, '1'),
(150728, '15', '07', '28', 'SANTA EULALIA', '2010-12-15 01:58:44', NULL, '1'),
(150729, '15', '07', '29', 'SANTIAGO DE ANCHUCAYA', '2010-12-15 01:58:44', NULL, '1'),
(150730, '15', '07', '30', 'SANTIAGO DE TUNA', '2010-12-15 01:58:44', NULL, '1'),
(150731, '15', '07', '31', 'SANTO DOMINGO DE LOS OLLEROS', '2010-12-15 01:58:44', NULL, '1'),
(150732, '15', '07', '32', 'SURCO', '2010-12-15 01:58:44', NULL, '1'),
(150800, '15', '08', '00', 'HUAURA', '2010-12-15 01:58:44', NULL, '1'),
(150801, '15', '08', '01', 'HUACHO', '2010-12-15 01:58:44', NULL, '1'),
(150802, '15', '08', '02', 'AMBAR', '2010-12-15 01:58:44', NULL, '1'),
(150803, '15', '08', '03', 'CALETA DE CARQUIN', '2010-12-15 01:58:44', NULL, '1'),
(150804, '15', '08', '04', 'CHECRAS', '2010-12-15 01:58:44', NULL, '1'),
(150805, '15', '08', '05', 'HUALMAY', '2010-12-15 01:58:44', NULL, '1'),
(150806, '15', '08', '06', 'HUAURA', '2010-12-15 01:58:44', NULL, '1'),
(150807, '15', '08', '07', 'LEONCIO PRADO', '2010-12-15 01:58:44', NULL, '1'),
(150808, '15', '08', '08', 'PACCHO', '2010-12-15 01:58:44', NULL, '1'),
(150809, '15', '08', '09', 'SANTA LEONOR', '2010-12-15 01:58:44', NULL, '1'),
(150810, '15', '08', '10', 'SANTA MARIA', '2010-12-15 01:58:44', NULL, '1'),
(150811, '15', '08', '11', 'SAYAN', '2010-12-15 01:58:44', NULL, '1'),
(150812, '15', '08', '12', 'VEGUETA', '2010-12-15 01:58:44', NULL, '1'),
(150900, '15', '09', '00', 'OYON', '2010-12-15 01:58:44', NULL, '1'),
(150901, '15', '09', '01', 'OYON', '2010-12-15 01:58:44', NULL, '1'),
(150902, '15', '09', '02', 'ANDAJES', '2010-12-15 01:58:44', NULL, '1'),
(150903, '15', '09', '03', 'CAUJUL', '2010-12-15 01:58:44', NULL, '1'),
(150904, '15', '09', '04', 'COCHAMARCA', '2010-12-15 01:58:44', NULL, '1'),
(150905, '15', '09', '05', 'NAVAN', '2010-12-15 01:58:44', NULL, '1'),
(150906, '15', '09', '06', 'PACHANGARA', '2010-12-15 01:58:44', NULL, '1'),
(151000, '15', '10', '00', 'YAUYOS', '2010-12-15 01:58:44', NULL, '1'),
(151001, '15', '10', '01', 'YAUYOS', '2010-12-15 01:58:44', NULL, '1'),
(151002, '15', '10', '02', 'ALIS', '2010-12-15 01:58:44', NULL, '1'),
(151003, '15', '10', '03', 'AYAUCA', '2010-12-15 01:58:44', NULL, '1'),
(151004, '15', '10', '04', 'AYAVIRI', '2010-12-15 01:58:44', NULL, '1'),
(151005, '15', '10', '05', 'AZANGARO', '2010-12-15 01:58:44', NULL, '1'),
(151006, '15', '10', '06', 'CACRA', '2010-12-15 01:58:44', NULL, '1'),
(151007, '15', '10', '07', 'CARANIA', '2010-12-15 01:58:44', NULL, '1'),
(151008, '15', '10', '08', 'CATAHUASI', '2010-12-15 01:58:44', NULL, '1'),
(151009, '15', '10', '09', 'CHOCOS', '2010-12-15 01:58:44', NULL, '1'),
(151010, '15', '10', '10', 'COCHAS', '2010-12-15 01:58:44', NULL, '1'),
(151011, '15', '10', '11', 'COLONIA', '2010-12-15 01:58:44', NULL, '1'),
(151012, '15', '10', '12', 'HONGOS', '2010-12-15 01:58:44', NULL, '1'),
(151013, '15', '10', '13', 'HUAMPARA', '2010-12-15 01:58:44', NULL, '1'),
(151014, '15', '10', '14', 'HUANCAYA', '2010-12-15 01:58:44', NULL, '1'),
(151015, '15', '10', '15', 'HUANGASCAR', '2010-12-15 01:58:44', NULL, '1'),
(151016, '15', '10', '16', 'HUANTAN', '2010-12-15 01:58:44', NULL, '1'),
(151017, '15', '10', '17', 'HUAÃ‘EC', '2010-12-15 01:58:44', NULL, '1'),
(151018, '15', '10', '18', 'LARAOS', '2010-12-15 01:58:44', NULL, '1'),
(151019, '15', '10', '19', 'LINCHA', '2010-12-15 01:58:44', NULL, '1'),
(151020, '15', '10', '20', 'MADEAN', '2010-12-15 01:58:44', NULL, '1'),
(151021, '15', '10', '21', 'MIRAFLORES', '2010-12-15 01:58:44', NULL, '1'),
(151022, '15', '10', '22', 'OMAS', '2010-12-15 01:58:44', NULL, '1'),
(151023, '15', '10', '23', 'PUTINZA', '2010-12-15 01:58:44', NULL, '1'),
(151024, '15', '10', '24', 'QUINCHES', '2010-12-15 01:58:44', NULL, '1'),
(151025, '15', '10', '25', 'QUINOCAY', '2010-12-15 01:58:44', NULL, '1'),
(151026, '15', '10', '26', 'SAN JOAQUIN', '2010-12-15 01:58:44', NULL, '1'),
(151027, '15', '10', '27', 'SAN PEDRO DE PILAS', '2010-12-15 01:58:44', NULL, '1'),
(151028, '15', '10', '28', 'TANTA', '2010-12-15 01:58:44', NULL, '1'),
(151029, '15', '10', '29', 'TAURIPAMPA', '2010-12-15 01:58:44', NULL, '1'),
(151030, '15', '10', '30', 'TOMAS', '2010-12-15 01:58:44', NULL, '1'),
(151031, '15', '10', '31', 'TUPE', '2010-12-15 01:58:44', NULL, '1'),
(151032, '15', '10', '32', 'VIÃ‘AC', '2010-12-15 01:58:44', NULL, '1'),
(151033, '15', '10', '33', 'VITIS', '2010-12-15 01:58:44', NULL, '1'),
(160000, '16', '00', '00', 'LORETO', '2010-12-15 01:58:44', NULL, '1'),
(160100, '16', '01', '00', 'MAYNAS', '2010-12-15 01:58:44', NULL, '1'),
(160101, '16', '01', '01', 'IQUITOS', '2010-12-15 01:58:44', NULL, '1'),
(160102, '16', '01', '02', 'ALTO NANAY', '2010-12-15 01:58:44', NULL, '1'),
(160103, '16', '01', '03', 'FERNANDO LORES', '2010-12-15 01:58:44', NULL, '1'),
(160104, '16', '01', '04', 'INDIANA', '2010-12-15 01:58:44', NULL, '1'),
(160105, '16', '01', '05', 'LAS AMAZONAS', '2010-12-15 01:58:44', NULL, '1'),
(160106, '16', '01', '06', 'MAZAN', '2010-12-15 01:58:44', NULL, '1'),
(160107, '16', '01', '07', 'NAPO', '2010-12-15 01:58:44', NULL, '1'),
(160108, '16', '01', '08', 'PUNCHANA', '2010-12-15 01:58:44', NULL, '1'),
(160109, '16', '01', '09', 'PUTUMAYO', '2010-12-15 01:58:44', NULL, '1'),
(160110, '16', '01', '10', 'TORRES CAUSANA', '2010-12-15 01:58:44', NULL, '1'),
(160112, '16', '01', '12', 'BELEN', '2010-12-15 01:58:44', NULL, '1'),
(160113, '16', '01', '13', 'SAN JUAN BAUTISTA', '2010-12-15 01:58:44', NULL, '1'),
(160114, '16', '01', '14', 'TENIENTE MANUEL CLAVERO', '2010-12-15 01:58:44', NULL, '1'),
(160200, '16', '02', '00', 'ALTO AMAZONAS', '2010-12-15 01:58:44', NULL, '1'),
(160201, '16', '02', '01', 'YURIMAGUAS', '2010-12-15 01:58:44', NULL, '1'),
(160202, '16', '02', '02', 'BALSAPUERTO', '2010-12-15 01:58:44', NULL, '1'),
(160205, '16', '02', '05', 'JEBEROS', '2010-12-15 01:58:44', NULL, '1'),
(160206, '16', '02', '06', 'LAGUNAS', '2010-12-15 01:58:44', NULL, '1'),
(160210, '16', '02', '10', 'SANTA CRUZ', '2010-12-15 01:58:44', NULL, '1'),
(160211, '16', '02', '11', 'TENIENTE CESAR LOPEZ ROJAS', '2010-12-15 01:58:44', NULL, '1'),
(160300, '16', '03', '00', 'LORETO', '2010-12-15 01:58:44', NULL, '1'),
(160301, '16', '03', '01', 'NAUTA', '2010-12-15 01:58:44', NULL, '1'),
(160302, '16', '03', '02', 'PARINARI', '2010-12-15 01:58:44', NULL, '1'),
(160303, '16', '03', '03', 'TIGRE', '2010-12-15 01:58:44', NULL, '1'),
(160304, '16', '03', '04', 'TROMPETEROS', '2010-12-15 01:58:44', NULL, '1'),
(160305, '16', '03', '05', 'URARINAS', '2010-12-15 01:58:44', NULL, '1'),
(160400, '16', '04', '00', 'MARISCAL RAMON CASTILLA', '2010-12-15 01:58:44', NULL, '1'),
(160401, '16', '04', '01', 'RAMON CASTILLA', '2010-12-15 01:58:44', NULL, '1'),
(160402, '16', '04', '02', 'PEBAS', '2010-12-15 01:58:44', NULL, '1'),
(160403, '16', '04', '03', 'YAVARI', '2010-12-15 01:58:44', NULL, '1'),
(160404, '16', '04', '04', 'SAN PABLO', '2010-12-15 01:58:44', NULL, '1'),
(160500, '16', '05', '00', 'REQUENA', '2010-12-15 01:58:44', NULL, '1'),
(160501, '16', '05', '01', 'REQUENA', '2010-12-15 01:58:44', NULL, '1'),
(160502, '16', '05', '02', 'ALTO TAPICHE', '2010-12-15 01:58:44', NULL, '1'),
(160503, '16', '05', '03', 'CAPELO', '2010-12-15 01:58:44', NULL, '1'),
(160504, '16', '05', '04', 'EMILIO SAN MARTIN', '2010-12-15 01:58:44', NULL, '1'),
(160505, '16', '05', '05', 'MAQUIA', '2010-12-15 01:58:44', NULL, '1'),
(160506, '16', '05', '06', 'PUINAHUA', '2010-12-15 01:58:44', NULL, '1'),
(160507, '16', '05', '07', 'SAQUENA', '2010-12-15 01:58:44', NULL, '1'),
(160508, '16', '05', '08', 'SOPLIN', '2010-12-15 01:58:44', NULL, '1'),
(160509, '16', '05', '09', 'TAPICHE', '2010-12-15 01:58:44', NULL, '1'),
(160510, '16', '05', '10', 'JENARO HERRERA', '2010-12-15 01:58:44', NULL, '1'),
(160511, '16', '05', '11', 'YAQUERANA', '2010-12-15 01:58:44', NULL, '1'),
(160600, '16', '06', '00', 'UCAYALI', '2010-12-15 01:58:44', NULL, '1'),
(160601, '16', '06', '01', 'CONTAMANA', '2010-12-15 01:58:44', NULL, '1'),
(160602, '16', '06', '02', 'INAHUAYA', '2010-12-15 01:58:44', NULL, '1'),
(160603, '16', '06', '03', 'PADRE MARQUEZ', '2010-12-15 01:58:44', NULL, '1'),
(160604, '16', '06', '04', 'PAMPA HERMOSA', '2010-12-15 01:58:44', NULL, '1'),
(160605, '16', '06', '05', 'SARAYACU', '2010-12-15 01:58:44', NULL, '1'),
(160606, '16', '06', '06', 'VARGAS GUERRA', '2010-12-15 01:58:44', NULL, '1'),
(160700, '16', '07', '00', 'DATEM DEL MARAÃ‘ON', '2010-12-15 01:58:44', NULL, '1'),
(160701, '16', '07', '01', 'BARRANCA', '2010-12-15 01:58:44', NULL, '1'),
(160702, '16', '07', '02', 'CAHUAPANAS', '2010-12-15 01:58:44', NULL, '1'),
(160703, '16', '07', '03', 'MANSERICHE', '2010-12-15 01:58:44', NULL, '1'),
(160704, '16', '07', '04', 'MORONA', '2010-12-15 01:58:44', NULL, '1'),
(160705, '16', '07', '05', 'PASTAZA', '2010-12-15 01:58:44', NULL, '1'),
(160706, '16', '07', '06', 'ANDOAS', '2010-12-15 01:58:44', NULL, '1'),
(170000, '17', '00', '00', 'MADRE DE DIOS', '2010-12-15 01:58:44', NULL, '1'),
(170100, '17', '01', '00', 'TAMBOPATA', '2010-12-15 01:58:44', NULL, '1'),
(170101, '17', '01', '01', 'TAMBOPATA', '2010-12-15 01:58:44', NULL, '1'),
(170102, '17', '01', '02', 'INAMBARI', '2010-12-15 01:58:44', NULL, '1'),
(170103, '17', '01', '03', 'LAS PIEDRAS', '2010-12-15 01:58:44', NULL, '1'),
(170104, '17', '01', '04', 'LABERINTO', '2010-12-15 01:58:44', NULL, '1'),
(170200, '17', '02', '00', 'MANU', '2010-12-15 01:58:44', NULL, '1'),
(170201, '17', '02', '01', 'MANU', '2010-12-15 01:58:44', NULL, '1'),
(170202, '17', '02', '02', 'FITZCARRALD', '2010-12-15 01:58:44', NULL, '1'),
(170203, '17', '02', '03', 'MADRE DE DIOS', '2010-12-15 01:58:44', NULL, '1'),
(170204, '17', '02', '04', 'HUEPETUHE', '2010-12-15 01:58:44', NULL, '1'),
(170300, '17', '03', '00', 'TAHUAMANU', '2010-12-15 01:58:44', NULL, '1'),
(170301, '17', '03', '01', 'IÃ‘APARI', '2010-12-15 01:58:44', NULL, '1'),
(170302, '17', '03', '02', 'IBERIA', '2010-12-15 01:58:44', NULL, '1'),
(170303, '17', '03', '03', 'TAHUAMANU', '2010-12-15 01:58:44', NULL, '1'),
(180000, '18', '00', '00', 'MOQUEGUA', '2010-12-15 01:58:44', NULL, '1'),
(180100, '18', '01', '00', 'MARISCAL NIETO', '2010-12-15 01:58:44', NULL, '1'),
(180101, '18', '01', '01', 'MOQUEGUA', '2010-12-15 01:58:44', NULL, '1'),
(180102, '18', '01', '02', 'CARUMAS', '2010-12-15 01:58:44', NULL, '1'),
(180103, '18', '01', '03', 'CUCHUMBAYA', '2010-12-15 01:58:44', NULL, '1'),
(180104, '18', '01', '04', 'SAMEGUA', '2010-12-15 01:58:44', NULL, '1'),
(180105, '18', '01', '05', 'SAN CRISTOBAL', '2010-12-15 01:58:44', NULL, '1'),
(180106, '18', '01', '06', 'TORATA', '2010-12-15 01:58:44', NULL, '1'),
(180200, '18', '02', '00', 'GENERAL SANCHEZ CERRO', '2010-12-15 01:58:44', NULL, '1'),
(180201, '18', '02', '01', 'OMATE', '2010-12-15 01:58:44', NULL, '1'),
(180202, '18', '02', '02', 'CHOJATA', '2010-12-15 01:58:44', NULL, '1'),
(180203, '18', '02', '03', 'COALAQUE', '2010-12-15 01:58:44', NULL, '1'),
(180204, '18', '02', '04', 'ICHUÃ‘A', '2010-12-15 01:58:44', NULL, '1'),
(180205, '18', '02', '05', 'LA CAPILLA', '2010-12-15 01:58:44', NULL, '1'),
(180206, '18', '02', '06', 'LLOQUE', '2010-12-15 01:58:44', NULL, '1'),
(180207, '18', '02', '07', 'MATALAQUE', '2010-12-15 01:58:44', NULL, '1'),
(180208, '18', '02', '08', 'PUQUINA', '2010-12-15 01:58:44', NULL, '1'),
(180209, '18', '02', '09', 'QUINISTAQUILLAS', '2010-12-15 01:58:44', NULL, '1'),
(180210, '18', '02', '10', 'UBINAS', '2010-12-15 01:58:44', NULL, '1'),
(180211, '18', '02', '11', 'YUNGA', '2010-12-15 01:58:44', NULL, '1'),
(180300, '18', '03', '00', 'ILO', '2010-12-15 01:58:44', NULL, '1'),
(180301, '18', '03', '01', 'ILO', '2010-12-15 01:58:44', NULL, '1'),
(180302, '18', '03', '02', 'EL ALGARROBAL', '2010-12-15 01:58:44', NULL, '1'),
(180303, '18', '03', '03', 'PACOCHA', '2010-12-15 01:58:44', NULL, '1'),
(190000, '19', '00', '00', 'PASCO', '2010-12-15 01:58:44', NULL, '1'),
(190100, '19', '01', '00', 'PASCO', '2010-12-15 01:58:44', NULL, '1'),
(190101, '19', '01', '01', 'CHAUPIMARCA', '2010-12-15 01:58:44', NULL, '1'),
(190102, '19', '01', '02', 'HUACHON', '2010-12-15 01:58:44', NULL, '1'),
(190103, '19', '01', '03', 'HUARIACA', '2010-12-15 01:58:44', NULL, '1'),
(190104, '19', '01', '04', 'HUAYLLAY', '2010-12-15 01:58:44', NULL, '1'),
(190105, '19', '01', '05', 'NINACACA', '2010-12-15 01:58:44', NULL, '1'),
(190106, '19', '01', '06', 'PALLANCHACRA', '2010-12-15 01:58:44', NULL, '1'),
(190107, '19', '01', '07', 'PAUCARTAMBO', '2010-12-15 01:58:44', NULL, '1'),
(190108, '19', '01', '08', 'SAN FRANCISCO DE ASIS DE YARUSYACAN', '2010-12-15 01:58:44', NULL, '1'),
(190109, '19', '01', '09', 'SIMON BOLIVAR', '2010-12-15 01:58:44', NULL, '1'),
(190110, '19', '01', '10', 'TICLACAYAN', '2010-12-15 01:58:44', NULL, '1'),
(190111, '19', '01', '11', 'TINYAHUARCO', '2010-12-15 01:58:44', NULL, '1'),
(190112, '19', '01', '12', 'VICCO', '2010-12-15 01:58:44', NULL, '1'),
(190113, '19', '01', '13', 'YANACANCHA', '2010-12-15 01:58:44', NULL, '1'),
(190200, '19', '02', '00', 'DANIEL ALCIDES CARRION', '2010-12-15 01:58:44', NULL, '1'),
(190201, '19', '02', '01', 'YANAHUANCA', '2010-12-15 01:58:44', NULL, '1'),
(190202, '19', '02', '02', 'CHACAYAN', '2010-12-15 01:58:44', NULL, '1'),
(190203, '19', '02', '03', 'GOYLLARISQUIZGA', '2010-12-15 01:58:44', NULL, '1'),
(190204, '19', '02', '04', 'PAUCAR', '2010-12-15 01:58:44', NULL, '1'),
(190205, '19', '02', '05', 'SAN PEDRO DE PILLAO', '2010-12-15 01:58:44', NULL, '1'),
(190206, '19', '02', '06', 'SANTA ANA DE TUSI', '2010-12-15 01:58:44', NULL, '1'),
(190207, '19', '02', '07', 'TAPUC', '2010-12-15 01:58:44', NULL, '1'),
(190208, '19', '02', '08', 'VILCABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(190300, '19', '03', '00', 'OXAPAMPA', '2010-12-15 01:58:44', NULL, '1'),
(190301, '19', '03', '01', 'OXAPAMPA', '2010-12-15 01:58:44', NULL, '1'),
(190302, '19', '03', '02', 'CHONTABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(190303, '19', '03', '03', 'HUANCABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(190304, '19', '03', '04', 'PALCAZU', '2010-12-15 01:58:44', NULL, '1'),
(190305, '19', '03', '05', 'POZUZO', '2010-12-15 01:58:44', NULL, '1'),
(190306, '19', '03', '06', 'PUERTO BERMUDEZ', '2010-12-15 01:58:44', NULL, '1'),
(190307, '19', '03', '07', 'VILLA RICA', '2010-12-15 01:58:44', NULL, '1'),
(200000, '20', '00', '00', 'PIURA', '2010-12-15 01:58:44', NULL, '1'),
(200100, '20', '01', '00', 'PIURA', '2010-12-15 01:58:44', NULL, '1'),
(200101, '20', '01', '01', 'PIURA', '2010-12-15 01:58:44', NULL, '1'),
(200104, '20', '01', '04', 'CASTILLA', '2010-12-15 01:58:44', NULL, '1'),
(200105, '20', '01', '05', 'CATACAOS', '2010-12-15 01:58:44', NULL, '1'),
(200107, '20', '01', '07', 'CURA MORI', '2010-12-15 01:58:44', NULL, '1'),
(200108, '20', '01', '08', 'EL TALLAN', '2010-12-15 01:58:44', NULL, '1'),
(200109, '20', '01', '09', 'LA ARENA', '2010-12-15 01:58:44', NULL, '1'),
(200110, '20', '01', '10', 'LA UNION', '2010-12-15 01:58:44', NULL, '1'),
(200111, '20', '01', '11', 'LAS LOMAS', '2010-12-15 01:58:44', NULL, '1'),
(200114, '20', '01', '14', 'TAMBO GRANDE', '2010-12-15 01:58:44', NULL, '1'),
(200200, '20', '02', '00', 'AYABACA', '2010-12-15 01:58:44', NULL, '1'),
(200201, '20', '02', '01', 'AYABACA', '2010-12-15 01:58:44', NULL, '1'),
(200202, '20', '02', '02', 'FRIAS', '2010-12-15 01:58:44', NULL, '1'),
(200203, '20', '02', '03', 'JILILI', '2010-12-15 01:58:44', NULL, '1'),
(200204, '20', '02', '04', 'LAGUNAS', '2010-12-15 01:58:44', NULL, '1'),
(200205, '20', '02', '05', 'MONTERO', '2010-12-15 01:58:44', NULL, '1'),
(200206, '20', '02', '06', 'PACAIPAMPA', '2010-12-15 01:58:44', NULL, '1'),
(200207, '20', '02', '07', 'PAIMAS', '2010-12-15 01:58:44', NULL, '1'),
(200208, '20', '02', '08', 'SAPILLICA', '2010-12-15 01:58:44', NULL, '1'),
(200209, '20', '02', '09', 'SICCHEZ', '2010-12-15 01:58:44', NULL, '1'),
(200210, '20', '02', '10', 'SUYO', '2010-12-15 01:58:44', NULL, '1'),
(200300, '20', '03', '00', 'HUANCABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(200301, '20', '03', '01', 'HUANCABAMBA', '2010-12-15 01:58:44', NULL, '1'),
(200302, '20', '03', '02', 'CANCHAQUE', '2010-12-15 01:58:44', NULL, '1'),
(200303, '20', '03', '03', 'EL CARMEN DE LA FRONTERA', '2010-12-15 01:58:44', NULL, '1'),
(200304, '20', '03', '04', 'HUARMACA', '2010-12-15 01:58:44', NULL, '1'),
(200305, '20', '03', '05', 'LALAQUIZ', '2010-12-15 01:58:44', NULL, '1'),
(200306, '20', '03', '06', 'SAN MIGUEL DE EL FAIQUE', '2010-12-15 01:58:44', NULL, '1'),
(200307, '20', '03', '07', 'SONDOR', '2010-12-15 01:58:44', NULL, '1'),
(200308, '20', '03', '08', 'SONDORILLO', '2010-12-15 01:58:44', NULL, '1'),
(200400, '20', '04', '00', 'MORROPON', '2010-12-15 01:58:44', NULL, '1'),
(200401, '20', '04', '01', 'CHULUCANAS', '2010-12-15 01:58:44', NULL, '1'),
(200402, '20', '04', '02', 'BUENOS AIRES', '2010-12-15 01:58:44', NULL, '1'),
(200403, '20', '04', '03', 'CHALACO', '2010-12-15 01:58:44', NULL, '1'),
(200404, '20', '04', '04', 'LA MATANZA', '2010-12-15 01:58:44', NULL, '1'),
(200405, '20', '04', '05', 'MORROPON', '2010-12-15 01:58:44', NULL, '1'),
(200406, '20', '04', '06', 'SALITRAL', '2010-12-15 01:58:44', NULL, '1'),
(200407, '20', '04', '07', 'SAN JUAN DE BIGOTE', '2010-12-15 01:58:44', NULL, '1'),
(200408, '20', '04', '08', 'SANTA CATALINA DE MOSSA', '2010-12-15 01:58:44', NULL, '1'),
(200409, '20', '04', '09', 'SANTO DOMINGO', '2010-12-15 01:58:44', NULL, '1'),
(200410, '20', '04', '10', 'YAMANGO', '2010-12-15 01:58:44', NULL, '1'),
(200500, '20', '05', '00', 'PAITA', '2010-12-15 01:58:44', NULL, '1'),
(200501, '20', '05', '01', 'PAITA', '2010-12-15 01:58:44', NULL, '1'),
(200502, '20', '05', '02', 'AMOTAPE', '2010-12-15 01:58:44', NULL, '1'),
(200503, '20', '05', '03', 'ARENAL', '2010-12-15 01:58:44', NULL, '1'),
(200504, '20', '05', '04', 'COLAN', '2010-12-15 01:58:44', NULL, '1'),
(200505, '20', '05', '05', 'LA HUACA', '2010-12-15 01:58:44', NULL, '1'),
(200506, '20', '05', '06', 'TAMARINDO', '2010-12-15 01:58:44', NULL, '1'),
(200507, '20', '05', '07', 'VICHAYAL', '2010-12-15 01:58:44', NULL, '1'),
(200600, '20', '06', '00', 'SULLANA', '2010-12-15 01:58:44', NULL, '1'),
(200601, '20', '06', '01', 'SULLANA', '2010-12-15 01:58:44', NULL, '1'),
(200602, '20', '06', '02', 'BELLAVISTA', '2010-12-15 01:58:44', NULL, '1'),
(200603, '20', '06', '03', 'IGNACIO ESCUDERO', '2010-12-15 01:58:44', NULL, '1'),
(200604, '20', '06', '04', 'LANCONES', '2010-12-15 01:58:44', NULL, '1'),
(200605, '20', '06', '05', 'MARCAVELICA', '2010-12-15 01:58:44', NULL, '1'),
(200606, '20', '06', '06', 'MIGUEL CHECA', '2010-12-15 01:58:44', NULL, '1'),
(200607, '20', '06', '07', 'QUERECOTILLO', '2010-12-15 01:58:44', NULL, '1'),
(200608, '20', '06', '08', 'SALITRAL', '2010-12-15 01:58:44', NULL, '1'),
(200700, '20', '07', '00', 'TALARA', '2010-12-15 01:58:44', NULL, '1'),
(200701, '20', '07', '01', 'PARIÃ‘AS', '2010-12-15 01:58:44', NULL, '1'),
(200702, '20', '07', '02', 'EL ALTO', '2010-12-15 01:58:44', NULL, '1'),
(200703, '20', '07', '03', 'LA BREA', '2010-12-15 01:58:44', NULL, '1'),
(200704, '20', '07', '04', 'LOBITOS', '2010-12-15 01:58:44', NULL, '1'),
(200705, '20', '07', '05', 'LOS ORGANOS', '2010-12-15 01:58:44', NULL, '1'),
(200706, '20', '07', '06', 'MANCORA', '2010-12-15 01:58:44', NULL, '1'),
(200800, '20', '08', '00', 'SECHURA', '2010-12-15 01:58:44', NULL, '1'),
(200801, '20', '08', '01', 'SECHURA', '2010-12-15 01:58:44', NULL, '1'),
(200802, '20', '08', '02', 'BELLAVISTA DE LA UNION', '2010-12-15 01:58:44', NULL, '1'),
(200803, '20', '08', '03', 'BERNAL', '2010-12-15 01:58:44', NULL, '1'),
(200804, '20', '08', '04', 'CRISTO NOS VALGA', '2010-12-15 01:58:44', NULL, '1'),
(200805, '20', '08', '05', 'VICE', '2010-12-15 01:58:44', NULL, '1'),
(200806, '20', '08', '06', 'RINCONADA LLICUAR', '2010-12-15 01:58:44', NULL, '1'),
(210000, '21', '00', '00', 'PUNO', '2010-12-15 01:58:44', NULL, '1'),
(210100, '21', '01', '00', 'PUNO', '2010-12-15 01:58:44', NULL, '1'),
(210101, '21', '01', '01', 'PUNO', '2010-12-15 01:58:44', NULL, '1'),
(210102, '21', '01', '02', 'ACORA', '2010-12-15 01:58:44', NULL, '1'),
(210103, '21', '01', '03', 'AMANTANI', '2010-12-15 01:58:44', NULL, '1'),
(210104, '21', '01', '04', 'ATUNCOLLA', '2010-12-15 01:58:44', NULL, '1'),
(210105, '21', '01', '05', 'CAPACHICA', '2010-12-15 01:58:44', NULL, '1'),
(210106, '21', '01', '06', 'CHUCUITO', '2010-12-15 01:58:44', NULL, '1'),
(210107, '21', '01', '07', 'COATA', '2010-12-15 01:58:44', NULL, '1'),
(210108, '21', '01', '08', 'HUATA', '2010-12-15 01:58:44', NULL, '1'),
(210109, '21', '01', '09', 'MAÃ‘AZO', '2010-12-15 01:58:44', NULL, '1'),
(210110, '21', '01', '10', 'PAUCARCOLLA', '2010-12-15 01:58:44', NULL, '1'),
(210111, '21', '01', '11', 'PICHACANI', '2010-12-15 01:58:44', NULL, '1'),
(210112, '21', '01', '12', 'PLATERIA', '2010-12-15 01:58:44', NULL, '1'),
(210113, '21', '01', '13', 'SAN ANTONIO', '2010-12-15 01:58:44', NULL, '1'),
(210114, '21', '01', '14', 'TIQUILLACA', '2010-12-15 01:58:44', NULL, '1'),
(210115, '21', '01', '15', 'VILQUE', '2010-12-15 01:58:44', NULL, '1'),
(210200, '21', '02', '00', 'AZANGARO', '2010-12-15 01:58:44', NULL, '1'),
(210201, '21', '02', '01', 'AZANGARO', '2010-12-15 01:58:44', NULL, '1'),
(210202, '21', '02', '02', 'ACHAYA', '2010-12-15 01:58:44', NULL, '1'),
(210203, '21', '02', '03', 'ARAPA', '2010-12-15 01:58:44', NULL, '1'),
(210204, '21', '02', '04', 'ASILLO', '2010-12-15 01:58:44', NULL, '1'),
(210205, '21', '02', '05', 'CAMINACA', '2010-12-15 01:58:44', NULL, '1'),
(210206, '21', '02', '06', 'CHUPA', '2010-12-15 01:58:44', NULL, '1'),
(210207, '21', '02', '07', 'JOSE DOMINGO CHOQUEHUANCA', '2010-12-15 01:58:44', NULL, '1'),
(210208, '21', '02', '08', 'MUÃ‘ANI', '2010-12-15 01:58:44', NULL, '1'),
(210209, '21', '02', '09', 'POTONI', '2010-12-15 01:58:44', NULL, '1'),
(210210, '21', '02', '10', 'SAMAN', '2010-12-15 01:58:44', NULL, '1'),
(210211, '21', '02', '11', 'SAN ANTON', '2010-12-15 01:58:44', NULL, '1'),
(210212, '21', '02', '12', 'SAN JOSE', '2010-12-15 01:58:44', NULL, '1'),
(210213, '21', '02', '13', 'SAN JUAN DE SALINAS', '2010-12-15 01:58:44', NULL, '1'),
(210214, '21', '02', '14', 'SANTIAGO DE PUPUJA', '2010-12-15 01:58:44', NULL, '1'),
(210215, '21', '02', '15', 'TIRAPATA', '2010-12-15 01:58:44', NULL, '1'),
(210300, '21', '03', '00', 'CARABAYA', '2010-12-15 01:58:44', NULL, '1'),
(210301, '21', '03', '01', 'MACUSANI', '2010-12-15 01:58:44', NULL, '1'),
(210302, '21', '03', '02', 'AJOYANI', '2010-12-15 01:58:44', NULL, '1'),
(210303, '21', '03', '03', 'AYAPATA', '2010-12-15 01:58:44', NULL, '1'),
(210304, '21', '03', '04', 'COASA', '2010-12-15 01:58:44', NULL, '1'),
(210305, '21', '03', '05', 'CORANI', '2010-12-15 01:58:44', NULL, '1'),
(210306, '21', '03', '06', 'CRUCERO', '2010-12-15 01:58:44', NULL, '1'),
(210307, '21', '03', '07', 'ITUATA', '2010-12-15 01:58:44', NULL, '1'),
(210308, '21', '03', '08', 'OLLACHEA', '2010-12-15 01:58:44', NULL, '1'),
(210309, '21', '03', '09', 'SAN GABAN', '2010-12-15 01:58:44', NULL, '1'),
(210310, '21', '03', '10', 'USICAYOS', '2010-12-15 01:58:44', NULL, '1'),
(210400, '21', '04', '00', 'CHUCUITO', '2010-12-15 01:58:44', NULL, '1'),
(210401, '21', '04', '01', 'JULI', '2010-12-15 01:58:44', NULL, '1'),
(210402, '21', '04', '02', 'DESAGUADERO', '2010-12-15 01:58:44', NULL, '1'),
(210403, '21', '04', '03', 'HUACULLANI', '2010-12-15 01:58:44', NULL, '1'),
(210404, '21', '04', '04', 'KELLUYO', '2010-12-15 01:58:44', NULL, '1'),
(210405, '21', '04', '05', 'PISACOMA', '2010-12-15 01:58:44', NULL, '1'),
(210406, '21', '04', '06', 'POMATA', '2010-12-15 01:58:44', NULL, '1'),
(210407, '21', '04', '07', 'ZEPITA', '2010-12-15 01:58:44', NULL, '1'),
(210500, '21', '05', '00', 'EL COLLAO', '2010-12-15 01:58:44', NULL, '1'),
(210501, '21', '05', '01', 'ILAVE', '2010-12-15 01:58:44', NULL, '1'),
(210502, '21', '05', '02', 'CAPAZO', '2010-12-15 01:58:44', NULL, '1'),
(210503, '21', '05', '03', 'PILCUYO', '2010-12-15 01:58:44', NULL, '1'),
(210504, '21', '05', '04', 'SANTA ROSA', '2010-12-15 01:58:44', NULL, '1'),
(210505, '21', '05', '05', 'CONDURIRI', '2010-12-15 01:58:44', NULL, '1'),
(210600, '21', '06', '00', 'HUANCANE', '2010-12-15 01:58:44', NULL, '1'),
(210601, '21', '06', '01', 'HUANCANE', '2010-12-15 01:58:44', NULL, '1'),
(210602, '21', '06', '02', 'COJATA', '2010-12-15 01:58:44', NULL, '1'),
(210603, '21', '06', '03', 'HUATASANI', '2010-12-15 01:58:44', NULL, '1'),
(210604, '21', '06', '04', 'INCHUPALLA', '2010-12-15 01:58:44', NULL, '1'),
(210605, '21', '06', '05', 'PUSI', '2010-12-15 01:58:44', NULL, '1'),
(210606, '21', '06', '06', 'ROSASPATA', '2010-12-15 01:58:44', NULL, '1'),
(210607, '21', '06', '07', 'TARACO', '2010-12-15 01:58:44', NULL, '1'),
(210608, '21', '06', '08', 'VILQUE CHICO', '2010-12-15 01:58:44', NULL, '1'),
(210700, '21', '07', '00', 'LAMPA', '2010-12-15 01:58:44', NULL, '1'),
(210701, '21', '07', '01', 'LAMPA', '2010-12-15 01:58:44', NULL, '1'),
(210702, '21', '07', '02', 'CABANILLA', '2010-12-15 01:58:44', NULL, '1'),
(210703, '21', '07', '03', 'CALAPUJA', '2010-12-15 01:58:44', NULL, '1'),
(210704, '21', '07', '04', 'NICASIO', '2010-12-15 01:58:44', NULL, '1'),
(210705, '21', '07', '05', 'OCUVIRI', '2010-12-15 01:58:44', NULL, '1'),
(210706, '21', '07', '06', 'PALCA', '2010-12-15 01:58:44', NULL, '1'),
(210707, '21', '07', '07', 'PARATIA', '2010-12-15 01:58:44', NULL, '1'),
(210708, '21', '07', '08', 'PUCARA', '2010-12-15 01:58:44', NULL, '1'),
(210709, '21', '07', '09', 'SANTA LUCIA', '2010-12-15 01:58:44', NULL, '1'),
(210710, '21', '07', '10', 'VILAVILA', '2010-12-15 01:58:44', NULL, '1'),
(210800, '21', '08', '00', 'MELGAR', '2010-12-15 01:58:44', NULL, '1'),
(210801, '21', '08', '01', 'AYAVIRI', '2010-12-15 01:58:44', NULL, '1'),
(210802, '21', '08', '02', 'ANTAUTA', '2010-12-15 01:58:44', NULL, '1'),
(210803, '21', '08', '03', 'CUPI', '2010-12-15 01:58:44', NULL, '1'),
(210804, '21', '08', '04', 'LLALLI', '2010-12-15 01:58:44', NULL, '1'),
(210805, '21', '08', '05', 'MACARI', '2010-12-15 01:58:44', NULL, '1'),
(210806, '21', '08', '06', 'NUÃ‘OA', '2010-12-15 01:58:44', NULL, '1'),
(210807, '21', '08', '07', 'ORURILLO', '2010-12-15 01:58:44', NULL, '1'),
(210808, '21', '08', '08', 'SANTA ROSA', '2010-12-15 01:58:44', NULL, '1'),
(210809, '21', '08', '09', 'UMACHIRI', '2010-12-15 01:58:44', NULL, '1'),
(210900, '21', '09', '00', 'MOHO', '2010-12-15 01:58:44', NULL, '1'),
(210901, '21', '09', '01', 'MOHO', '2010-12-15 01:58:44', NULL, '1'),
(210902, '21', '09', '02', 'CONIMA', '2010-12-15 01:58:44', NULL, '1'),
(210903, '21', '09', '03', 'HUAYRAPATA', '2010-12-15 01:58:44', NULL, '1'),
(210904, '21', '09', '04', 'TILALI', '2010-12-15 01:58:44', NULL, '1'),
(211000, '21', '10', '00', 'SAN ANTONIO DE PUTINA', '2010-12-15 01:58:44', NULL, '1'),
(211001, '21', '10', '01', 'PUTINA', '2010-12-15 01:58:44', NULL, '1'),
(211002, '21', '10', '02', 'ANANEA', '2010-12-15 01:58:44', NULL, '1'),
(211003, '21', '10', '03', 'PEDRO VILCA APAZA', '2010-12-15 01:58:44', NULL, '1'),
(211004, '21', '10', '04', 'QUILCAPUNCU', '2010-12-15 01:58:44', NULL, '1'),
(211005, '21', '10', '05', 'SINA', '2010-12-15 01:58:44', NULL, '1'),
(211100, '21', '11', '00', 'SAN ROMAN', '2010-12-15 01:58:44', NULL, '1'),
(211101, '21', '11', '01', 'JULIACA', '2010-12-15 01:58:44', NULL, '1'),
(211102, '21', '11', '02', 'CABANA', '2010-12-15 01:58:44', NULL, '1'),
(211103, '21', '11', '03', 'CABANILLAS', '2010-12-15 01:58:44', NULL, '1'),
(211104, '21', '11', '04', 'CARACOTO', '2010-12-15 01:58:44', NULL, '1'),
(211200, '21', '12', '00', 'SANDIA', '2010-12-15 01:58:44', NULL, '1'),
(211201, '21', '12', '01', 'SANDIA', '2010-12-15 01:58:44', NULL, '1'),
(211202, '21', '12', '02', 'CUYOCUYO', '2010-12-15 01:58:44', NULL, '1'),
(211203, '21', '12', '03', 'LIMBANI', '2010-12-15 01:58:44', NULL, '1'),
(211204, '21', '12', '04', 'PATAMBUCO', '2010-12-15 01:58:44', NULL, '1'),
(211205, '21', '12', '05', 'PHARA', '2010-12-15 01:58:44', NULL, '1'),
(211206, '21', '12', '06', 'QUIACA', '2010-12-15 01:58:44', NULL, '1'),
(211207, '21', '12', '07', 'SAN JUAN DEL ORO', '2010-12-15 01:58:44', NULL, '1'),
(211208, '21', '12', '08', 'YANAHUAYA', '2010-12-15 01:58:44', NULL, '1'),
(211209, '21', '12', '09', 'ALTO INAMBARI', '2010-12-15 01:58:44', NULL, '1'),
(211210, '21', '12', '10', 'SAN PEDRO DE PUTINA PUNCO', '2010-12-15 01:58:44', NULL, '1'),
(211300, '21', '13', '00', 'YUNGUYO', '2010-12-15 01:58:44', NULL, '1'),
(211301, '21', '13', '01', 'YUNGUYO', '2010-12-15 01:58:44', NULL, '1'),
(211302, '21', '13', '02', 'ANAPIA', '2010-12-15 01:58:44', NULL, '1'),
(211303, '21', '13', '03', 'COPANI', '2010-12-15 01:58:44', NULL, '1'),
(211304, '21', '13', '04', 'CUTURAPI', '2010-12-15 01:58:44', NULL, '1'),
(211305, '21', '13', '05', 'OLLARAYA', '2010-12-15 01:58:44', NULL, '1'),
(211306, '21', '13', '06', 'TINICACHI', '2010-12-15 01:58:44', NULL, '1'),
(211307, '21', '13', '07', 'UNICACHI', '2010-12-15 01:58:44', NULL, '1'),
(220000, '22', '00', '00', 'SAN MARTIN', '2010-12-15 01:58:44', NULL, '1'),
(220100, '22', '01', '00', 'MOYOBAMBA', '2010-12-15 01:58:44', NULL, '1'),
(220101, '22', '01', '01', 'MOYOBAMBA', '2010-12-15 01:58:44', NULL, '1'),
(220102, '22', '01', '02', 'CALZADA', '2010-12-15 01:58:44', NULL, '1'),
(220103, '22', '01', '03', 'HABANA', '2010-12-15 01:58:44', NULL, '1'),
(220104, '22', '01', '04', 'JEPELACIO', '2010-12-15 01:58:44', NULL, '1'),
(220105, '22', '01', '05', 'SORITOR', '2010-12-15 01:58:44', NULL, '1'),
(220106, '22', '01', '06', 'YANTALO', '2010-12-15 01:58:44', NULL, '1'),
(220200, '22', '02', '00', 'BELLAVISTA', '2010-12-15 01:58:44', NULL, '1'),
(220201, '22', '02', '01', 'BELLAVISTA', '2010-12-15 01:58:44', NULL, '1'),
(220202, '22', '02', '02', 'ALTO BIAVO', '2010-12-15 01:58:44', NULL, '1'),
(220203, '22', '02', '03', 'BAJO BIAVO', '2010-12-15 01:58:44', NULL, '1'),
(220204, '22', '02', '04', 'HUALLAGA', '2010-12-15 01:58:44', NULL, '1'),
(220205, '22', '02', '05', 'SAN PABLO', '2010-12-15 01:58:44', NULL, '1'),
(220206, '22', '02', '06', 'SAN RAFAEL', '2010-12-15 01:58:44', NULL, '1'),
(220300, '22', '03', '00', 'EL DORADO', '2010-12-15 01:58:44', NULL, '1'),
(220301, '22', '03', '01', 'SAN JOSE DE SISA', '2010-12-15 01:58:44', NULL, '1'),
(220302, '22', '03', '02', 'AGUA BLANCA', '2010-12-15 01:58:44', NULL, '1'),
(220303, '22', '03', '03', 'SAN MARTIN', '2010-12-15 01:58:44', NULL, '1'),
(220304, '22', '03', '04', 'SANTA ROSA', '2010-12-15 01:58:44', NULL, '1'),
(220305, '22', '03', '05', 'SHATOJA', '2010-12-15 01:58:44', NULL, '1'),
(220400, '22', '04', '00', 'HUALLAGA', '2010-12-15 01:58:44', NULL, '1'),
(220401, '22', '04', '01', 'SAPOSOA', '2010-12-15 01:58:44', NULL, '1'),
(220402, '22', '04', '02', 'ALTO SAPOSOA', '2010-12-15 01:58:44', NULL, '1'),
(220403, '22', '04', '03', 'EL ESLABON', '2010-12-15 01:58:44', NULL, '1'),
(220404, '22', '04', '04', 'PISCOYACU', '2010-12-15 01:58:44', NULL, '1'),
(220405, '22', '04', '05', 'SACANCHE', '2010-12-15 01:58:44', NULL, '1'),
(220406, '22', '04', '06', 'TINGO DE SAPOSOA', '2010-12-15 01:58:44', NULL, '1'),
(220500, '22', '05', '00', 'LAMAS', '2010-12-15 01:58:44', NULL, '1'),
(220501, '22', '05', '01', 'LAMAS', '2010-12-15 01:58:44', NULL, '1'),
(220502, '22', '05', '02', 'ALONSO DE ALVARADO', '2010-12-15 01:58:44', NULL, '1'),
(220503, '22', '05', '03', 'BARRANQUITA', '2010-12-15 01:58:44', NULL, '1'),
(220504, '22', '05', '04', 'CAYNARACHI', '2010-12-15 01:58:44', NULL, '1'),
(220505, '22', '05', '05', 'CUÃ‘UMBUQUI', '2010-12-15 01:58:44', NULL, '1'),
(220506, '22', '05', '06', 'PINTO RECODO', '2010-12-15 01:58:44', NULL, '1'),
(220507, '22', '05', '07', 'RUMISAPA', '2010-12-15 01:58:44', NULL, '1'),
(220508, '22', '05', '08', 'SAN ROQUE DE CUMBAZA', '2010-12-15 01:58:44', NULL, '1'),
(220509, '22', '05', '09', 'SHANAO', '2010-12-15 01:58:44', NULL, '1'),
(220510, '22', '05', '10', 'TABALOSOS', '2010-12-15 01:58:44', NULL, '1'),
(220511, '22', '05', '11', 'ZAPATERO', '2010-12-15 01:58:44', NULL, '1'),
(220600, '22', '06', '00', 'MARISCAL CACERES', '2010-12-15 01:58:44', NULL, '1'),
(220601, '22', '06', '01', 'JUANJUI', '2010-12-15 01:58:44', NULL, '1'),
(220602, '22', '06', '02', 'CAMPANILLA', '2010-12-15 01:58:44', NULL, '1'),
(220603, '22', '06', '03', 'HUICUNGO', '2010-12-15 01:58:44', NULL, '1'),
(220604, '22', '06', '04', 'PACHIZA', '2010-12-15 01:58:44', NULL, '1'),
(220605, '22', '06', '05', 'PAJARILLO', '2010-12-15 01:58:44', NULL, '1'),
(220700, '22', '07', '00', 'PICOTA', '2010-12-15 01:58:44', NULL, '1'),
(220701, '22', '07', '01', 'PICOTA', '2010-12-15 01:58:44', NULL, '1'),
(220702, '22', '07', '02', 'BUENOS AIRES', '2010-12-15 01:58:44', NULL, '1'),
(220703, '22', '07', '03', 'CASPISAPA', '2010-12-15 01:58:44', NULL, '1'),
(220704, '22', '07', '04', 'PILLUANA', '2010-12-15 01:58:44', NULL, '1'),
(220705, '22', '07', '05', 'PUCACACA', '2010-12-15 01:58:44', NULL, '1'),
(220706, '22', '07', '06', 'SAN CRISTOBAL', '2010-12-15 01:58:44', NULL, '1'),
(220707, '22', '07', '07', 'SAN HILARION', '2010-12-15 01:58:44', NULL, '1'),
(220708, '22', '07', '08', 'SHAMBOYACU', '2010-12-15 01:58:44', NULL, '1'),
(220709, '22', '07', '09', 'TINGO DE PONASA', '2010-12-15 01:58:44', NULL, '1'),
(220710, '22', '07', '10', 'TRES UNIDOS', '2010-12-15 01:58:44', NULL, '1'),
(220800, '22', '08', '00', 'RIOJA', '2010-12-15 01:58:44', NULL, '1'),
(220801, '22', '08', '01', 'RIOJA', '2010-12-15 01:58:44', NULL, '1'),
(220802, '22', '08', '02', 'AWAJUN', '2010-12-15 01:58:44', NULL, '1'),
(220803, '22', '08', '03', 'ELIAS SOPLIN VARGAS', '2010-12-15 01:58:44', NULL, '1'),
(220804, '22', '08', '04', 'NUEVA CAJAMARCA', '2010-12-15 01:58:44', NULL, '1'),
(220805, '22', '08', '05', 'PARDO MIGUEL', '2010-12-15 01:58:44', NULL, '1'),
(220806, '22', '08', '06', 'POSIC', '2010-12-15 01:58:44', NULL, '1'),
(220807, '22', '08', '07', 'SAN FERNANDO', '2010-12-15 01:58:44', NULL, '1'),
(220808, '22', '08', '08', 'YORONGOS', '2010-12-15 01:58:44', NULL, '1'),
(220809, '22', '08', '09', 'YURACYACU', '2010-12-15 01:58:44', NULL, '1'),
(220900, '22', '09', '00', 'SAN MARTIN', '2010-12-15 01:58:44', NULL, '1'),
(220901, '22', '09', '01', 'TARAPOTO', '2010-12-15 01:58:44', NULL, '1'),
(220902, '22', '09', '02', 'ALBERTO LEVEAU', '2010-12-15 01:58:44', NULL, '1'),
(220903, '22', '09', '03', 'CACATACHI', '2010-12-15 01:58:44', NULL, '1'),
(220904, '22', '09', '04', 'CHAZUTA', '2010-12-15 01:58:44', NULL, '1'),
(220905, '22', '09', '05', 'CHIPURANA', '2010-12-15 01:58:44', NULL, '1'),
(220906, '22', '09', '06', 'EL PORVENIR', '2010-12-15 01:58:44', NULL, '1'),
(220907, '22', '09', '07', 'HUIMBAYOC', '2010-12-15 01:58:44', NULL, '1'),
(220908, '22', '09', '08', 'JUAN GUERRA', '2010-12-15 01:58:44', NULL, '1'),
(220909, '22', '09', '09', 'LA BANDA DE SHILCAYO', '2010-12-15 01:58:44', NULL, '1'),
(220910, '22', '09', '10', 'MORALES', '2010-12-15 01:58:44', NULL, '1'),
(220911, '22', '09', '11', 'PAPAPLAYA', '2010-12-15 01:58:44', NULL, '1'),
(220912, '22', '09', '12', 'SAN ANTONIO', '2010-12-15 01:58:44', NULL, '1'),
(220913, '22', '09', '13', 'SAUCE', '2010-12-15 01:58:44', NULL, '1'),
(220914, '22', '09', '14', 'SHAPAJA', '2010-12-15 01:58:44', NULL, '1'),
(221000, '22', '10', '00', 'TOCACHE', '2010-12-15 01:58:44', NULL, '1'),
(221001, '22', '10', '01', 'TOCACHE', '2010-12-15 01:58:44', NULL, '1'),
(221002, '22', '10', '02', 'NUEVO PROGRESO', '2010-12-15 01:58:44', NULL, '1'),
(221003, '22', '10', '03', 'POLVORA', '2010-12-15 01:58:44', NULL, '1'),
(221004, '22', '10', '04', 'SHUNTE', '2010-12-15 01:58:44', NULL, '1'),
(221005, '22', '10', '05', 'UCHIZA', '2010-12-15 01:58:44', NULL, '1'),
(230000, '23', '00', '00', 'TACNA', '2010-12-15 01:58:44', NULL, '1'),
(230100, '23', '01', '00', 'TACNA', '2010-12-15 01:58:44', NULL, '1'),
(230101, '23', '01', '01', 'TACNA', '2010-12-15 01:58:44', NULL, '1'),
(230102, '23', '01', '02', 'ALTO DE LA ALIANZA', '2010-12-15 01:58:44', NULL, '1'),
(230103, '23', '01', '03', 'CALANA', '2010-12-15 01:58:44', NULL, '1'),
(230104, '23', '01', '04', 'CIUDAD NUEVA', '2010-12-15 01:58:44', NULL, '1'),
(230105, '23', '01', '05', 'INCLAN', '2010-12-15 01:58:44', NULL, '1'),
(230106, '23', '01', '06', 'PACHIA', '2010-12-15 01:58:44', NULL, '1'),
(230107, '23', '01', '07', 'PALCA', '2010-12-15 01:58:44', NULL, '1'),
(230108, '23', '01', '08', 'POCOLLAY', '2010-12-15 01:58:44', NULL, '1'),
(230109, '23', '01', '09', 'SAMA', '2010-12-15 01:58:44', NULL, '1'),
(230110, '23', '01', '10', 'CORONEL GREGORIO ALBARRACIN LANCHIPA', '2010-12-15 01:58:44', NULL, '1'),
(230200, '23', '02', '00', 'CANDARAVE', '2010-12-15 01:58:44', NULL, '1'),
(230201, '23', '02', '01', 'CANDARAVE', '2010-12-15 01:58:44', NULL, '1'),
(230202, '23', '02', '02', 'CAIRANI', '2010-12-15 01:58:44', NULL, '1'),
(230203, '23', '02', '03', 'CAMILACA', '2010-12-15 01:58:44', NULL, '1'),
(230204, '23', '02', '04', 'CURIBAYA', '2010-12-15 01:58:44', NULL, '1'),
(230205, '23', '02', '05', 'HUANUARA', '2010-12-15 01:58:44', NULL, '1'),
(230206, '23', '02', '06', 'QUILAHUANI', '2010-12-15 01:58:44', NULL, '1'),
(230300, '23', '03', '00', 'JORGE BASADRE', '2010-12-15 01:58:44', NULL, '1'),
(230301, '23', '03', '01', 'LOCUMBA', '2010-12-15 01:58:44', NULL, '1'),
(230302, '23', '03', '02', 'ILABAYA', '2010-12-15 01:58:44', NULL, '1'),
(230303, '23', '03', '03', 'ITE', '2010-12-15 01:58:44', NULL, '1'),
(230400, '23', '04', '00', 'TARATA', '2010-12-15 01:58:44', NULL, '1'),
(230401, '23', '04', '01', 'TARATA', '2010-12-15 01:58:44', NULL, '1'),
(230402, '23', '04', '02', 'HEROES ALBARRACIN', '2010-12-15 01:58:44', NULL, '1'),
(230403, '23', '04', '03', 'ESTIQUE', '2010-12-15 01:58:44', NULL, '1'),
(230404, '23', '04', '04', 'ESTIQUE-PAMPA', '2010-12-15 01:58:44', NULL, '1'),
(230405, '23', '04', '05', 'SITAJARA', '2010-12-15 01:58:44', NULL, '1'),
(230406, '23', '04', '06', 'SUSAPAYA', '2010-12-15 01:58:44', NULL, '1'),
(230407, '23', '04', '07', 'TARUCACHI', '2010-12-15 01:58:44', NULL, '1'),
(230408, '23', '04', '08', 'TICACO', '2010-12-15 01:58:44', NULL, '1'),
(240000, '24', '00', '00', 'TUMBES', '2010-12-15 01:58:44', NULL, '1'),
(240100, '24', '01', '00', 'TUMBES', '2010-12-15 01:58:44', NULL, '1'),
(240101, '24', '01', '01', 'TUMBES', '2010-12-15 01:58:44', NULL, '1'),
(240102, '24', '01', '02', 'CORRALES', '2010-12-15 01:58:44', NULL, '1'),
(240103, '24', '01', '03', 'LA CRUZ', '2010-12-15 01:58:44', NULL, '1'),
(240104, '24', '01', '04', 'PAMPAS DE HOSPITAL', '2010-12-15 01:58:44', NULL, '1'),
(240105, '24', '01', '05', 'SAN JACINTO', '2010-12-15 01:58:44', NULL, '1'),
(240106, '24', '01', '06', 'SAN JUAN DE LA VIRGEN', '2010-12-15 01:58:44', NULL, '1'),
(240200, '24', '02', '00', 'CONTRALMIRANTE VILLAR', '2010-12-15 01:58:44', NULL, '1'),
(240201, '24', '02', '01', 'ZORRITOS', '2010-12-15 01:58:44', NULL, '1'),
(240202, '24', '02', '02', 'CASITAS', '2010-12-15 01:58:44', NULL, '1'),
(240203, '24', '02', '03', 'CANOAS DE PUNTA SAL', '2010-12-15 01:58:44', NULL, '1'),
(240300, '24', '03', '00', 'ZARUMILLA', '2010-12-15 01:58:44', NULL, '1'),
(240301, '24', '03', '01', 'ZARUMILLA', '2010-12-15 01:58:44', NULL, '1'),
(240302, '24', '03', '02', 'AGUAS VERDES', '2010-12-15 01:58:44', NULL, '1'),
(240303, '24', '03', '03', 'MATAPALO', '2010-12-15 01:58:44', NULL, '1'),
(240304, '24', '03', '04', 'PAPAYAL', '2010-12-15 01:58:44', NULL, '1'),
(250000, '25', '00', '00', 'UCAYALI', '2010-12-15 01:58:44', NULL, '1'),
(250100, '25', '01', '00', 'CORONEL PORTILLO', '2010-12-15 01:58:44', NULL, '1'),
(250101, '25', '01', '01', 'CALLERIA', '2010-12-15 01:58:44', NULL, '1'),
(250102, '25', '01', '02', 'CAMPOVERDE', '2010-12-15 01:58:44', NULL, '1'),
(250103, '25', '01', '03', 'IPARIA', '2010-12-15 01:58:44', NULL, '1'),
(250104, '25', '01', '04', 'MASISEA', '2010-12-15 01:58:44', NULL, '1'),
(250105, '25', '01', '05', 'YARINACOCHA', '2010-12-15 01:58:44', NULL, '1'),
(250106, '25', '01', '06', 'NUEVA REQUENA', '2010-12-15 01:58:44', NULL, '1'),
(250107, '25', '01', '07', 'MANANTAY', '2010-12-15 01:58:44', NULL, '1'),
(250200, '25', '02', '00', 'ATALAYA', '2010-12-15 01:58:44', NULL, '1'),
(250201, '25', '02', '01', 'RAYMONDI', '2010-12-15 01:58:44', NULL, '1'),
(250202, '25', '02', '02', 'SEPAHUA', '2010-12-15 01:58:44', NULL, '1'),
(250203, '25', '02', '03', 'TAHUANIA', '2010-12-15 01:58:44', NULL, '1'),
(250204, '25', '02', '04', 'YURUA', '2010-12-15 01:58:44', NULL, '1'),
(250300, '25', '03', '00', 'PADRE ABAD', '2010-12-15 01:58:44', NULL, '1'),
(250301, '25', '03', '01', 'PADRE ABAD', '2010-12-15 01:58:44', NULL, '1'),
(250302, '25', '03', '02', 'IRAZOLA', '2010-12-15 01:58:44', NULL, '1'),
(250303, '25', '03', '03', 'CURIMANA', '2010-12-15 01:58:44', NULL, '1'),
(250400, '25', '04', '00', 'PURUS', '2010-12-15 01:58:44', NULL, '1'),
(250401, '25', '04', '01', 'PURUS', '2010-12-15 01:58:44', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_unidadmedida`
--

CREATE TABLE `cji_unidadmedida` (
  `UNDMED_Codigo` int(11) NOT NULL,
  `UNDMED_Descripcion` varchar(250) DEFAULT NULL,
  `UNDMED_Simbolo` varchar(30) DEFAULT NULL,
  `UNDMED_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UNDMED_FechaModificacion` datetime DEFAULT NULL,
  `UNDMED_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_unidadmedida`
--

INSERT INTO `cji_unidadmedida` (`UNDMED_Codigo`, `UNDMED_Descripcion`, `UNDMED_Simbolo`, `UNDMED_FechaRegistro`, `UNDMED_FechaModificacion`, `UNDMED_FlagEstado`) VALUES
(1, 'PLANCH', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(2, 'PLANCHA', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(3, 'LAMINA', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(4, 'UNID', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(5, 'GALON', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(7, '1/4 GALON', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(8, 'UNIDAD', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(9, '1 CTO.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(10, 'MILLAR/CAJA', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(11, 'METRO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(12, 'PLIEGO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(13, 'VARILLA', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(14, 'JUEGO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(15, '1/2 MILLAR/CAJA', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(16, 'MILLAR', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(17, 'PZA', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(18, 'CIENTO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(19, '1/2 CTO.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(21, 'LITRO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(22, 'PAR', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(24, '1/2 PLANCHA', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(26, '2 CTO.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(28, '2 CTO  CAJA', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(29, 'FRASCO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(30, 'BALDE', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(33, '1 CTO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(34, '1/8 GALON', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(35, '1/4 KG.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(36, 'PCH', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(37, 'PIE2', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(38, '1/2 PLANCH', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(39, '1.5 CTO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(40, 'BOLSA', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(41, '1/2 MILLAR.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(44, '1 CIENTO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(45, 'CAJA', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(46, '1/4 PLANCHA', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(49, 'PUERTA', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(51, 'PZA.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(52, 'PIES', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(53, 'PAQUETE', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(54, 'PIE', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(55, 'PIEZ', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(57, 'METRO.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(58, '1/4 CIENTO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(59, 'GALON.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(60, '1/4 GLN.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(61, '1/4  GLN.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(62, 'CHISGUETE', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(63, 'KILO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(64, 'PLANCHA 1/2', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(66, '1 KG', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(67, 'PLANCA', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(68, '1/4 GALON.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(70, 'CTO.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(72, 'MILLAR CAJA', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(73, 'PARDAD', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(74, 'TARRO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(77, '1/2.PLANCHA', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(78, 'PIEZA', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(79, 'CIENTO.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(80, '1/2 PLANCHA.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(81, '1/2PLANCHA', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(82, '1/4PLANCHA', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(83, '1/2 VARILLA', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(84, 'KGR', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(86, '1/2 PLANCHA.-', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(87, 'CTO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(88, '2 CTO/CAJA', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(89, '2 CTO CAJA', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(91, '1/2MILLAR', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(92, '1CIENTO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(93, '2 CIENTO CAJA', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(95, '2 CIENTOS', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(97, 'TABLA PINO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(98, '1/2 PLAN', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(99, '2 CTO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(101, '1CTO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(102, '1 CTO CAJA', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(103, 'METRO CUA', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1'),
(104, '1/2CTO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_usuario`
--

CREATE TABLE `cji_usuario` (
  `USUA_Codigo` int(11) NOT NULL,
  `PERSP_Codigo` int(11) NOT NULL,
  `ROL_Codigo` int(11) NOT NULL,
  `USUA_usuario` varchar(20) DEFAULT NULL,
  `USUA_Password` varchar(50) DEFAULT NULL,
  `USUA_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `USUA_FechaModificacion` datetime DEFAULT NULL,
  `USUA_FlagEstado` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_usuario`
--

INSERT INTO `cji_usuario` (`USUA_Codigo`, `PERSP_Codigo`, `ROL_Codigo`, `USUA_usuario`, `USUA_Password`, `USUA_FechaRegistro`, `USUA_FechaModificacion`, `USUA_FlagEstado`) VALUES
(1, 1, 4, 'ADMINISTRADOR', 'e10adc3949ba59abbe56e057f20f883e', '2016-11-30 02:57:32', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_usuario_compania`
--

CREATE TABLE `cji_usuario_compania` (
  `USUCOMP_Codigo` int(11) NOT NULL,
  `USUA_Codigo` int(11) NOT NULL,
  `COMPP_Codigo` int(11) NOT NULL,
  `ROL_Codigo` int(11) NOT NULL,
  `CARGP_Codigo` int(10) NOT NULL,
  `USUCOMC_Default` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cji_usuario_compania`
--

INSERT INTO `cji_usuario_compania` (`USUCOMP_Codigo`, `USUA_Codigo`, `COMPP_Codigo`, `ROL_Codigo`, `CARGP_Codigo`, `USUCOMC_Default`) VALUES
(1, 1, 1, 4, 1, 1),
(2, 1, 2, 4, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cji_usuario_terminal`
--

CREATE TABLE `cji_usuario_terminal` (
  `USUTERMINAL_Codigo` int(11) NOT NULL,
  `USUA_Codigo` int(11) NOT NULL,
  `ROL_Codigo` int(11) NOT NULL,
  `TERMINAL_Codigo` int(11) NOT NULL,
  `USUTERMINAL_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `USUTERMINAL_FechaModificacion` datetime NOT NULL,
  `USUTERMINAL_FlagEstado` char(1) NOT NULL DEFAULT '1',
  `USUTERMINAL_CodigoUsuario` int(11) DEFAULT NULL,
  `USUTERMINAL_Default` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `impactousuario`
--

CREATE TABLE `impactousuario` (
  `id` int(11) NOT NULL,
  `usuario` varchar(25) CHARACTER SET utf8 NOT NULL,
  `password` varchar(25) CHARACTER SET utf8 NOT NULL,
  `fecharegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fechamodificacion` date NOT NULL,
  `flagestado` char(1) CHARACTER SET utf8 NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `impacto_documento`
--

CREATE TABLE `impacto_documento` (
  `IMPDOC_Codigo` int(11) NOT NULL,
  `IMPDOC_Nombre` varchar(500) CHARACTER SET utf8 NOT NULL,
  `IMPDOC_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `impacto_publicacion`
--

CREATE TABLE `impacto_publicacion` (
  `IMPPUB_Codigo` int(11) NOT NULL,
  `PROD_Codigo` int(11) NOT NULL,
  `IMPPUB_Descripcion` text,
  `IMPPUB_FechaRegistro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `IMPPUB_FechaModificacion` datetime DEFAULT NULL,
  `IMPPUB_FlagEstado` char(1) DEFAULT '1',
  `SEC_Codigo` int(11) NOT NULL,
  `SEC_Descripcion` varchar(100) DEFAULT NULL,
  `COL1_FIL1` varchar(100) DEFAULT NULL,
  `COL1_FIL2` varchar(100) DEFAULT NULL,
  `COL1_FIL3` varchar(100) DEFAULT NULL,
  `COL1_FIL4` varchar(100) DEFAULT NULL,
  `COL1_FIL5` varchar(100) DEFAULT NULL,
  `COL2_FIL1` varchar(100) DEFAULT NULL,
  `COL2_FIL2` varchar(100) DEFAULT NULL,
  `COL2_FIL3` varchar(100) DEFAULT NULL,
  `COL2_FIL4` varchar(100) DEFAULT NULL,
  `COL2_FIL5` varchar(100) DEFAULT NULL,
  `IMAGEN_1` varchar(500) DEFAULT NULL,
  `IMAGEN_2` varchar(100) DEFAULT NULL,
  `IMAGEN_3` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cji_almacen`
--
ALTER TABLE `cji_almacen`
  ADD PRIMARY KEY (`ALMAP_Codigo`),
  ADD KEY `FK_cji_almacen_cji_tipoalmacen` (`TIPALM_Codigo`),
  ADD KEY `FK_cji_almacen_cji_centrocosto` (`CENCOSP_Codigo`),
  ADD KEY `COMPP_Codigo` (`COMPP_Codigo`),
  ADD KEY `EESTABP_Codigo` (`EESTABP_Codigo`);

--
-- Indices de la tabla `cji_almacenproducto`
--
ALTER TABLE `cji_almacenproducto`
  ADD PRIMARY KEY (`ALMPROD_Codigo`),
  ADD KEY `FK_cji_almacenproducto_cji_almacen` (`ALMAC_Codigo`),
  ADD KEY `FK_cji_almacenproducto_cji_producto` (`PROD_Codigo`),
  ADD KEY `FK_cji_almacenproducto_cji_compania` (`COMPP_Codigo`);

--
-- Indices de la tabla `cji_almacenproductoserie`
--
ALTER TABLE `cji_almacenproductoserie`
  ADD PRIMARY KEY (`ALMPRODSERP_Codigo`),
  ADD KEY `fk_cji_almacenproductoserie_cji_almacenproducto1` (`ALMPROD_Codigo`),
  ADD KEY `fk_cji_almacenproductoserie_cji_serie1` (`SERIP_Codigo`);

--
-- Indices de la tabla `cji_almaprolote`
--
ALTER TABLE `cji_almaprolote`
  ADD PRIMARY KEY (`ALMALOTP_Codigo`),
  ADD KEY `fk_cji_almaprolote_cji_almacenproducto1` (`ALMPROD_Codigo`),
  ADD KEY `fk_cji_almaprolote_cji_lote1` (`LOTP_Codigo`),
  ADD KEY `FK_cji_almaprolote_cji_compania` (`COMPP_Codigo`);

--
-- Indices de la tabla `cji_area`
--
ALTER TABLE `cji_area`
  ADD PRIMARY KEY (`AREAP_Codigo`),
  ADD KEY `COMPP_Codigo` (`COMPP_Codigo`);

--
-- Indices de la tabla `cji_atributo`
--
ALTER TABLE `cji_atributo`
  ADD PRIMARY KEY (`ATRIB_Codigo`);

--
-- Indices de la tabla `cji_banco`
--
ALTER TABLE `cji_banco`
  ADD PRIMARY KEY (`BANP_Codigo`);

--
-- Indices de la tabla `cji_bancocta`
--
ALTER TABLE `cji_bancocta`
  ADD PRIMARY KEY (`CTAP_Codigo`);

--
-- Indices de la tabla `cji_caja`
--
ALTER TABLE `cji_caja`
  ADD PRIMARY KEY (`CAJA_Codigo`);

--
-- Indices de la tabla `cji_cajamovimiento`
--
ALTER TABLE `cji_cajamovimiento`
  ADD PRIMARY KEY (`CAJAMOV_Codigo`);

--
-- Indices de la tabla `cji_caja_chekera`
--
ALTER TABLE `cji_caja_chekera`
  ADD PRIMARY KEY (`CAJCHEK_Codigo`);

--
-- Indices de la tabla `cji_caja_cuenta`
--
ALTER TABLE `cji_caja_cuenta`
  ADD PRIMARY KEY (`CAJCUENT_Codigo`);

--
-- Indices de la tabla `cji_cargo`
--
ALTER TABLE `cji_cargo`
  ADD PRIMARY KEY (`CARGP_Codigo`),
  ADD KEY `COMPP_Codigo` (`COMPP_Codigo`);

--
-- Indices de la tabla `cji_categoriapublicacion`
--
ALTER TABLE `cji_categoriapublicacion`
  ADD PRIMARY KEY (`CATPUBP_Codigo`);

--
-- Indices de la tabla `cji_centrocosto`
--
ALTER TABLE `cji_centrocosto`
  ADD PRIMARY KEY (`CENCOSP_Codigo`),
  ADD KEY `COMPP_Codigo` (`COMPP_Codigo`);

--
-- Indices de la tabla `cji_chekera`
--
ALTER TABLE `cji_chekera`
  ADD PRIMARY KEY (`CHEK_Codigo`);

--
-- Indices de la tabla `cji_cheque`
--
ALTER TABLE `cji_cheque`
  ADD PRIMARY KEY (`CHEP_Codigo`);

--
-- Indices de la tabla `cji_ciiu`
--
ALTER TABLE `cji_ciiu`
  ADD PRIMARY KEY (`CIIUP_Codigo`);

--
-- Indices de la tabla `cji_cliente`
--
ALTER TABLE `cji_cliente`
  ADD PRIMARY KEY (`CLIP_Codigo`),
  ADD KEY `fk_CJ_CLIENTE_CJ_EMPRESA1` (`EMPRP_Codigo`),
  ADD KEY `fk_CJ_CLIENTE_CJ_PERSONA1` (`PERSP_Codigo`),
  ADD KEY `fk_CJ_CLIENTE_CJ_TIPOCLIENTE` (`TIPCLIP_Codigo`),
  ADD KEY `FORPAP_Codigo` (`FORPAP_Codigo`);

--
-- Indices de la tabla `cji_clientecompania`
--
ALTER TABLE `cji_clientecompania`
  ADD PRIMARY KEY (`CLIP_Codigo`,`COMPP_Codigo`),
  ADD KEY `COMPP_Codigo` (`COMPP_Codigo`);

--
-- Indices de la tabla `cji_compadocumenitem`
--
ALTER TABLE `cji_compadocumenitem`
  ADD PRIMARY KEY (`COMPADOCUITEM_Codigo`);

--
-- Indices de la tabla `cji_compania`
--
ALTER TABLE `cji_compania`
  ADD PRIMARY KEY (`COMPP_Codigo`),
  ADD KEY `FK_cji_compania_cji_empresa` (`EMPRP_Codigo`),
  ADD KEY `EESTABP_Codigo` (`EESTABP_Codigo`);

--
-- Indices de la tabla `cji_companiaconfidocumento`
--
ALTER TABLE `cji_companiaconfidocumento`
  ADD PRIMARY KEY (`COMPCONFIDOCP_Codigo`),
  ADD KEY `DOCUP_Codigo` (`DOCUP_Codigo`),
  ADD KEY `COMPCONFIP_Codigo` (`COMPCONFIP_Codigo`);

--
-- Indices de la tabla `cji_companiaconfiguracion`
--
ALTER TABLE `cji_companiaconfiguracion`
  ADD PRIMARY KEY (`COMPCONFIP_Codigo`),
  ADD UNIQUE KEY `COMPP_Codigo` (`COMPP_Codigo`);

--
-- Indices de la tabla `cji_comparativo`
--
ALTER TABLE `cji_comparativo`
  ADD PRIMARY KEY (`COMP_Codigo`);

--
-- Indices de la tabla `cji_comparativodetalle`
--
ALTER TABLE `cji_comparativodetalle`
  ADD PRIMARY KEY (`CUACOMP_Codigo`);

--
-- Indices de la tabla `cji_comprobante`
--
ALTER TABLE `cji_comprobante`
  ADD PRIMARY KEY (`CPP_Codigo`),
  ADD KEY `FK_cji_factura_cji_presupuesto` (`PRESUP_Codigo`),
  ADD KEY `FK_cji_factura_cji_compania` (`COMPP_Codigo`),
  ADD KEY `FK_cji_factura_cji_cliente` (`CLIP_Codigo`),
  ADD KEY `FK_cji_factura_cji_usuario` (`USUA_Codigo`),
  ADD KEY `FK_cji_factura_cji_moneda` (`MONED_Codigo`),
  ADD KEY `FK_cji_factura_cji_formapago` (`FORPAP_Codigo`),
  ADD KEY `FK_cji_comprobante_proveedor` (`PROVP_Codigo`),
  ADD KEY `FK_cji_comprobante_ocompra` (`OCOMP_Codigo`),
  ADD KEY `GUIAREMP_Codigo` (`GUIAREMP_Codigo`),
  ADD KEY `CPC_Vendedor` (`CPC_Vendedor`),
  ADD KEY `GUIASAP_Codigo` (`GUIASAP_Codigo`),
  ADD KEY `GUIAINP_Codigo` (`GUIAINP_Codigo`);

--
-- Indices de la tabla `cji_comprobantedetalle`
--
ALTER TABLE `cji_comprobantedetalle`
  ADD PRIMARY KEY (`CPDEP_Codigo`),
  ADD KEY `FK_Reference_64` (`PROD_Codigo`),
  ADD KEY `FK_cji_facturadetalle_cji_unidadmedida` (`UNDMED_Codigo`),
  ADD KEY `CPP_Codigo` (`CPP_Codigo`);

--
-- Indices de la tabla `cji_comprobante_guiarem`
--
ALTER TABLE `cji_comprobante_guiarem`
  ADD PRIMARY KEY (`COMPGUI_Codigo`);

--
-- Indices de la tabla `cji_condicionentrega`
--
ALTER TABLE `cji_condicionentrega`
  ADD PRIMARY KEY (`CONENP_Codigo`);

--
-- Indices de la tabla `cji_configuracion`
--
ALTER TABLE `cji_configuracion`
  ADD PRIMARY KEY (`CONFIP_Codigo`),
  ADD KEY `FK_cji_correlativo_cji_documento` (`DOCUP_Codigo`),
  ADD KEY `FK_cji_correlativo_cji_compania` (`COMPP_Codigo`);

--
-- Indices de la tabla `cji_correlativo`
--
ALTER TABLE `cji_correlativo`
  ADD PRIMARY KEY (`CORRP_Codigo`);

--
-- Indices de la tabla `cji_correoenviar`
--
ALTER TABLE `cji_correoenviar`
  ADD PRIMARY KEY (`CE_Codigo`);

--
-- Indices de la tabla `cji_cotizacion`
--
ALTER TABLE `cji_cotizacion`
  ADD PRIMARY KEY (`COTIP_Codigo`),
  ADD KEY `FK_Reference_39` (`PEDIP_Codigo`),
  ADD KEY `FK_Reference_41` (`PROVP_Codigo`),
  ADD KEY `FK_Reference_42` (`FORPAP_Codigo`),
  ADD KEY `FK_Reference_43` (`CONENP_Codigo`),
  ADD KEY `FK_Reference_44` (`USUA_Codigo`),
  ADD KEY `FK_Reference_51` (`CENCOSP_Codigo`),
  ADD KEY `FK_cji_cotizacion_cji_cotizacion` (`COMPP_Codigo`),
  ADD KEY `FK_cji_cotizacion_cji_almacen` (`ALMAP_Codigo`);

--
-- Indices de la tabla `cji_cotizaciondetalle`
--
ALTER TABLE `cji_cotizaciondetalle`
  ADD PRIMARY KEY (`COTDEP_Codigo`),
  ADD KEY `FK_Reference_46` (`PROD_Codigo`),
  ADD KEY `FK_cji_cotizaciondetalle_cji_unidadmedida` (`UNDMED_Codigo`),
  ADD KEY `FK_cji_cotizaciondetalle_cotizacion` (`COTIP_Codigo`);

--
-- Indices de la tabla `cji_cuentacontable`
--
ALTER TABLE `cji_cuentacontable`
  ADD PRIMARY KEY (`CUNTCONTBL_Codigo`);

--
-- Indices de la tabla `cji_cuentas`
--
ALTER TABLE `cji_cuentas`
  ADD PRIMARY KEY (`CUE_Codigo`),
  ADD KEY `DOCUP_Codigo` (`DOCUP_Codigo`);

--
-- Indices de la tabla `cji_cuentasempresas`
--
ALTER TABLE `cji_cuentasempresas`
  ADD PRIMARY KEY (`CUENT_Codigo`);

--
-- Indices de la tabla `cji_cuentaspago`
--
ALTER TABLE `cji_cuentaspago`
  ADD PRIMARY KEY (`CPAGP_Codigo`);

--
-- Indices de la tabla `cji_direccion`
--
ALTER TABLE `cji_direccion`
  ADD PRIMARY KEY (`DIRECC_Codigo`),
  ADD KEY `UBIGP_Domicilio` (`UBIGP_Domicilio`),
  ADD KEY `PROYP_Codigo` (`PROYP_Codigo`);

--
-- Indices de la tabla `cji_directivo`
--
ALTER TABLE `cji_directivo`
  ADD PRIMARY KEY (`DIREP_Codigo`),
  ADD KEY `fk_CJ_DIRECTIVO_CJ_EMPRESA1` (`EMPRP_Codigo`),
  ADD KEY `fk_CJ_DIRECTIVO_CJ_PERSONA1` (`PERSP_Codigo`),
  ADD KEY `fk_CJ_DIRECTIVO_CJ_CARGO1` (`CARGP_Codigo`);

--
-- Indices de la tabla `cji_documento`
--
ALTER TABLE `cji_documento`
  ADD PRIMARY KEY (`DOCUP_Codigo`);

--
-- Indices de la tabla `cji_documentoitem`
--
ALTER TABLE `cji_documentoitem`
  ADD PRIMARY KEY (`DOCUITEM_Codigo`);

--
-- Indices de la tabla `cji_documentosentenica`
--
ALTER TABLE `cji_documentosentenica`
  ADD PRIMARY KEY (`DOCSENT_Codigo`);

--
-- Indices de la tabla `cji_emprarea`
--
ALTER TABLE `cji_emprarea`
  ADD PRIMARY KEY (`EAREAP_Codigo`),
  ADD KEY `fk_CJ_EMPAREA_CJ_AREA1` (`AREAP_Codigo`),
  ADD KEY `fk_CJ_EMPAREA_CJ_EMPRESA1` (`EMPRP_Codigo`),
  ADD KEY `fk_CJ_EMPAREA_CJ_DIRECTIVO1` (`DIREP_Codigo`);

--
-- Indices de la tabla `cji_emprcontacto`
--
ALTER TABLE `cji_emprcontacto`
  ADD PRIMARY KEY (`ECONP_Contacto`),
  ADD KEY `fk_CJ_EMPRCONTACTO_CJ_EMPRESA1` (`EMPRP_Codigo`),
  ADD KEY `FK_cji_emprcontacto_cji_persona` (`ECONC_Persona`);

--
-- Indices de la tabla `cji_empresa`
--
ALTER TABLE `cji_empresa`
  ADD PRIMARY KEY (`EMPRP_Codigo`),
  ADD KEY `FK_cji_empresa_cji_ciiu` (`CIIUP_Codigo`),
  ADD KEY `FK_cji_empresa_cji_tipocodigo` (`TIPCOD_Codigo`),
  ADD KEY `SECCOMP_Codigo` (`SECCOMP_Codigo`);

--
-- Indices de la tabla `cji_empresatipoproveedor`
--
ALTER TABLE `cji_empresatipoproveedor`
  ADD PRIMARY KEY (`EMPTIPOP_Codigo`);

--
-- Indices de la tabla `cji_emprestablecimiento`
--
ALTER TABLE `cji_emprestablecimiento`
  ADD PRIMARY KEY (`EESTABP_Codigo`),
  ADD KEY `fk_CJ_EMPRESTABLECIMIENTO_CJ_TIPOESTABLECIMIENTO1` (`TESTP_Codigo`),
  ADD KEY `fk_CJ_EMPRESTABLECIMIENTO_CJ_EMPRESA1` (`EMPRP_Codigo`),
  ADD KEY `fk_CJ_EMPRESTABLECIMIENTO_CJ_UBIGEO1` (`UBIGP_Codigo`);

--
-- Indices de la tabla `cji_entregacliente`
--
ALTER TABLE `cji_entregacliente`
  ADD PRIMARY KEY (`ENTRECLI_Codigo`),
  ADD KEY `FK_cji_entregacliente_cji_garantia` (`GARAN_Codigo`),
  ADD KEY `FK_cji_entregacliente_cji_empresa` (`EMPRP_Codigo`),
  ADD KEY `FK_cji_entregacliente_cji_compania` (`COMPP_Codigo`),
  ADD KEY `FK_cji_entregacliente_cji_cliente` (`CLIP_Codigo`);

--
-- Indices de la tabla `cji_envioproveedor`
--
ALTER TABLE `cji_envioproveedor`
  ADD PRIMARY KEY (`ENVIPRO_Codigo`),
  ADD KEY `FK_cji_envioproveedor_cji_garantia` (`GARAN_Codigo`),
  ADD KEY `FK_cji_envioproveedor_cji_empresa` (`EMPRP_Codigo`),
  ADD KEY `FK_cji_envioproveedor_cji_compania` (`COMPP_Codigo`),
  ADD KEY `FK_cji_envioproveedor_cji_proveedor` (`PROVP_Codigo`);

--
-- Indices de la tabla `cji_estadocivil`
--
ALTER TABLE `cji_estadocivil`
  ADD PRIMARY KEY (`ESTCP_Codigo`);

--
-- Indices de la tabla `cji_fabricante`
--
ALTER TABLE `cji_fabricante`
  ADD PRIMARY KEY (`FABRIP_Codigo`);

--
-- Indices de la tabla `cji_familia`
--
ALTER TABLE `cji_familia`
  ADD PRIMARY KEY (`FAMI_Codigo`);

--
-- Indices de la tabla `cji_familiacompania`
--
ALTER TABLE `cji_familiacompania`
  ADD PRIMARY KEY (`FAMI_Codigo`,`COMPP_Codigo`),
  ADD KEY `COMPP_Codigo` (`COMPP_Codigo`);

--
-- Indices de la tabla `cji_flujocaja`
--
ALTER TABLE `cji_flujocaja`
  ADD PRIMARY KEY (`FLUCAJ_Codigo`),
  ADD KEY `CUE_Codigo` (`CUE_Codigo`),
  ADD KEY `FORPAP_Codigo` (`FORPAP_Codigo`),
  ADD KEY `MONED_Codigo` (`MONED_Codigo`);

--
-- Indices de la tabla `cji_formapago`
--
ALTER TABLE `cji_formapago`
  ADD PRIMARY KEY (`FORPAP_Codigo`);

--
-- Indices de la tabla `cji_garantia`
--
ALTER TABLE `cji_garantia`
  ADD PRIMARY KEY (`GARAN_Codigo`),
  ADD KEY `FK_cji_garantia_cji_cliente` (`CLIP_Codigo`),
  ADD KEY `FK_cji_garantia_cji_empresa` (`EMPRP_Codigo`),
  ADD KEY `FK_cji_garantia_cji_compania` (`COMPP_Codigo`),
  ADD KEY `FK_cji_garantia_cji_producto` (`PROD_Codigo`),
  ADD KEY `FK_cji_garantia_cji_comprobante` (`CPP_Codigo`);

--
-- Indices de la tabla `cji_guiain`
--
ALTER TABLE `cji_guiain`
  ADD PRIMARY KEY (`GUIAINP_Codigo`),
  ADD KEY `fk_almacen` (`ALMAP_Codigo`),
  ADD KEY `fk_usuario` (`USUA_Codigo`),
  ADD KEY `fk_cji_guiain_cji_tipomovimiento1` (`TIPOMOVP_Codigo`),
  ADD KEY `FK_cji_guiain_cji_ordencompra` (`OCOMP_Codigo`),
  ADD KEY `FK_cji_guiain_cji_proveedor` (`PROVP_Codigo`),
  ADD KEY `DOCUP_Codigo` (`DOCUP_Codigo`);

--
-- Indices de la tabla `cji_guiaindetalle`
--
ALTER TABLE `cji_guiaindetalle`
  ADD PRIMARY KEY (`GUIAINDETP_Codigo`),
  ADD KEY `fk_cji_guiaindetalle_cji_guiain1` (`GUIAINP_Codigo`),
  ADD KEY `fk_cji_guiaindetalle_cji_producto` (`PRODCTOP_Codigo`),
  ADD KEY `fk_cji_guiaindetalle_cji_unidadmedida` (`UNDMED_Codigo`);

--
-- Indices de la tabla `cji_guiarem`
--
ALTER TABLE `cji_guiarem`
  ADD PRIMARY KEY (`GUIAREMP_Codigo`),
  ADD KEY `index2` (`ALMAP_Codigo`),
  ADD KEY `fk_usuario` (`USUA_Codigo`),
  ADD KEY `fk_cji_guiain_cji_tipomovimiento1` (`TIPOMOVP_Codigo`),
  ADD KEY `fk_cji_guiain_cji_documento1` (`DOCUP_Codigo`),
  ADD KEY `fk_cji_guiarem_cji_cliente1` (`CLIP_Codigo`),
  ADD KEY `fk_cji_guiarem_cji_guiasa` (`GUIASAP_Codigo`),
  ADD KEY `EMPRP_Codigo` (`EMPRP_Codigo`),
  ADD KEY `COMPP_Codigo` (`COMPP_Codigo`),
  ADD KEY `MONED_Codigo` (`MONED_Codigo`),
  ADD KEY `PRESUP_Codigo` (`PRESUP_Codigo`),
  ADD KEY `PROVP_Codigo` (`PROVP_Codigo`),
  ADD KEY `GUIAINP_Codigo` (`GUIAINP_Codigo`),
  ADD KEY `OCOMP_Codigo` (`OCOMP_Codigo`);

--
-- Indices de la tabla `cji_guiaremdetalle`
--
ALTER TABLE `cji_guiaremdetalle`
  ADD PRIMARY KEY (`GUIAREMDETP_Codigo`),
  ADD KEY `fk_cji_guiaindetalle_cji_producto` (`PRODCTOP_Codigo`),
  ADD KEY `fk_cji_unidadmedida` (`UNDMED_Codigo`),
  ADD KEY `fk_cji_guiaremdetalle_cji_guiarem1` (`GUIAREMP_Codigo`);

--
-- Indices de la tabla `cji_guiasa`
--
ALTER TABLE `cji_guiasa`
  ADD PRIMARY KEY (`GUIASAP_Codigo`),
  ADD KEY `index2` (`ALMAP_Codigo`),
  ADD KEY `fk_usuario` (`USUA_Codigo`),
  ADD KEY `fk_cji_guiain_cji_tipomovimiento1` (`TIPOMOVP_Codigo`),
  ADD KEY `fk_cji_guiasa_cji_cliente1` (`CLIP_Codigo`),
  ADD KEY `DOCUP_Codigo` (`DOCUP_Codigo`);

--
-- Indices de la tabla `cji_guiasadetalle`
--
ALTER TABLE `cji_guiasadetalle`
  ADD PRIMARY KEY (`GUIASADETP_Codigo`),
  ADD KEY `fk_cji_guiaindetalle_cji_producto` (`PRODCTOP_Codigo`),
  ADD KEY `fk_cji_unidadmedida` (`UNDMED_Codigo`),
  ADD KEY `fk_cji_guiaindetalle_copy1_cji_guiasa1` (`GUIASAP_Codigo`);

--
-- Indices de la tabla `cji_guiatrans`
--
ALTER TABLE `cji_guiatrans`
  ADD PRIMARY KEY (`GTRANP_Codigo`);

--
-- Indices de la tabla `cji_guiatransdetalle`
--
ALTER TABLE `cji_guiatransdetalle`
  ADD PRIMARY KEY (`GTRANDETP_Codigo`);

--
-- Indices de la tabla `cji_inventario`
--
ALTER TABLE `cji_inventario`
  ADD PRIMARY KEY (`INVE_Codigo`);

--
-- Indices de la tabla `cji_inventariodetalle`
--
ALTER TABLE `cji_inventariodetalle`
  ADD PRIMARY KEY (`INVD_Codigo`);

--
-- Indices de la tabla `cji_item`
--
ALTER TABLE `cji_item`
  ADD PRIMARY KEY (`ITEM_Codigo`);

--
-- Indices de la tabla `cji_kardex`
--
ALTER TABLE `cji_kardex`
  ADD PRIMARY KEY (`KARDP_Codigo`),
  ADD KEY `FK_cji_kardex_cji_producto` (`PROD_Codigo`),
  ADD KEY `COMPP_Codigo` (`COMPP_Codigo`),
  ADD KEY `fk_cji_kardex_cji_documento1` (`DOCUP_Codigo`),
  ADD KEY `fk_cji_kardex_cji_tipomovimiento1` (`TIPOMOVP_Codigo`),
  ADD KEY `fk_cji_kardex_cji_lote` (`LOTP_Codigo`);

--
-- Indices de la tabla `cji_letra`
--
ALTER TABLE `cji_letra`
  ADD PRIMARY KEY (`LET_Codigo`),
  ADD KEY `FK_cji_letra_cji_proveedor` (`PROVP_Codigo`),
  ADD KEY `FK_cji_letra_cji_guiasa` (`GUIASAP_Codigo`),
  ADD KEY `FK_cji_letra_cji_guiain` (`GUIAINP_Codigo`),
  ADD KEY `FK_cji_letra_cji_presupuesto` (`PRESUP_Codigo`),
  ADD KEY `FK_cji_letra_cji_ordencompra` (`OCOMP_Codigo`),
  ADD KEY `FK_cji_letra_cji_guiarem` (`GUIAREMP_Codigo`),
  ADD KEY `FK_cji_letra_cji_directivo` (`LET_Vendedor`),
  ADD KEY `FK_cji_letra_cji_cliente` (`CLIP_Codigo`),
  ADD KEY `FK_cji_letra_cji_compania` (`COMPP_Codigo`),
  ADD KEY `FK_cji_letra_cji_formapago` (`FORPAP_Codigo`),
  ADD KEY `FK_cji_letra_cji_moneda` (`MONED_Codigo`),
  ADD KEY `FK_cji_letra_cji_usuario` (`USUA_Codigo`);

--
-- Indices de la tabla `cji_linea`
--
ALTER TABLE `cji_linea`
  ADD PRIMARY KEY (`LINP_Codigo`);

--
-- Indices de la tabla `cji_log`
--
ALTER TABLE `cji_log`
  ADD PRIMARY KEY (`LOGP_Codigo`);

--
-- Indices de la tabla `cji_lote`
--
ALTER TABLE `cji_lote`
  ADD PRIMARY KEY (`LOTP_Codigo`),
  ADD KEY `fk_cji_lote_cji_producto1` (`PROD_Codigo`),
  ADD KEY `GUIAINP_Codigo` (`GUIAINP_Codigo`);

--
-- Indices de la tabla `cji_loteprorrateo`
--
ALTER TABLE `cji_loteprorrateo`
  ADD PRIMARY KEY (`LOTPROP_Codigo`),
  ADD KEY `LOTP_Codigo` (`LOTP_Codigo`);

--
-- Indices de la tabla `cji_marca`
--
ALTER TABLE `cji_marca`
  ADD PRIMARY KEY (`MARCP_Codigo`);

--
-- Indices de la tabla `cji_menu`
--
ALTER TABLE `cji_menu`
  ADD PRIMARY KEY (`MENU_Codigo`);

--
-- Indices de la tabla `cji_moneda`
--
ALTER TABLE `cji_moneda`
  ADD PRIMARY KEY (`MONED_Codigo`),
  ADD KEY `COMPP_Codigo` (`COMPP_Codigo`);

--
-- Indices de la tabla `cji_nacionalidad`
--
ALTER TABLE `cji_nacionalidad`
  ADD PRIMARY KEY (`NACP_Codigo`);

--
-- Indices de la tabla `cji_nota`
--
ALTER TABLE `cji_nota`
  ADD PRIMARY KEY (`CRED_Codigo`),
  ADD KEY `FK_cji_credito_cji_compania` (`COMPP_Codigo`),
  ADD KEY `FK_cji_credito_cji_cliente` (`CLIP_Codigo`),
  ADD KEY `FK_cji_credito_cji_usuario` (`USUA_Codigo`),
  ADD KEY `FK_cji_credito_cji_moneda` (`MONED_Codigo`),
  ADD KEY `FK_cji_credito_proveedor` (`PROVP_Codigo`),
  ADD KEY `CRED_Vendedor` (`CRED_Vendedor`);

--
-- Indices de la tabla `cji_notadetalle`
--
ALTER TABLE `cji_notadetalle`
  ADD PRIMARY KEY (`CREDET_Codigo`),
  ADD KEY `FK_Reference_64` (`PROD_Codigo`),
  ADD KEY `FK_cji_facturadetalle_cji_unidadmedida` (`UNDMED_Codigo`),
  ADD KEY `CRED_Codigo` (`CRED_Codigo`);

--
-- Indices de la tabla `cji_ocompradetalle`
--
ALTER TABLE `cji_ocompradetalle`
  ADD PRIMARY KEY (`OCOMDEP_Codigo`),
  ADD KEY `FK_Reference_52` (`OCOMP_Codigo`),
  ADD KEY `FK_Reference_53` (`PROD_Codigo`),
  ADD KEY `FK_cji_ocompradetalle_cji_unidadmedida` (`UNDMED_Codigo`);

--
-- Indices de la tabla `cji_ordencompra`
--
ALTER TABLE `cji_ordencompra`
  ADD PRIMARY KEY (`OCOMP_Codigo`),
  ADD KEY `FK_Reference_40` (`COTIP_Codigo`),
  ADD KEY `FK_Reference_47` (`PROVP_Codigo`),
  ADD KEY `FK_Reference_48` (`USUA_Codigo`),
  ADD KEY `FK_Reference_50` (`CENCOSP_Codigo`),
  ADD KEY `FK_Reference_54` (`MONED_Codigo`),
  ADD KEY `FK_cji_ordencompra_cji_ordencompra` (`COMPP_Codigo`),
  ADD KEY `FORPAP_Codigo` (`FORPAP_Codigo`),
  ADD KEY `ALMAP_Codigo` (`ALMAP_Codigo`),
  ADD KEY `FK_cji_ordencompra_pedido` (`PEDIP_Codigo`),
  ADD KEY `OCOMC_Comprador` (`OCOMC_MiPersonal`),
  ADD KEY `OCOMC_Personal` (`OCOMC_Personal`),
  ADD KEY `GUIASAP_Codigo` (`GUIASAP_Codigo`);

--
-- Indices de la tabla `cji_pago`
--
ALTER TABLE `cji_pago`
  ADD PRIMARY KEY (`PAGP_Codigo`);

--
-- Indices de la tabla `cji_pedido`
--
ALTER TABLE `cji_pedido`
  ADD PRIMARY KEY (`PEDIP_Codigo`),
  ADD KEY `FK_Reference_34` (`CENCOST_Codigo`),
  ADD KEY `FK_Reference_35` (`USUA_Codigo`),
  ADD KEY `FK_Reference_36` (`USUA_Responsable`),
  ADD KEY `FK_cji_pedido_cji_compania` (`COMPP_Codigo`),
  ADD KEY `DOCUP_Codigo` (`DOCUP_Codigo`);

--
-- Indices de la tabla `cji_pedidodetalle`
--
ALTER TABLE `cji_pedidodetalle`
  ADD PRIMARY KEY (`PEDIDETP_Codigo`,`PEDIP_Codigo`,`PROD_Codigo`),
  ADD KEY `FK_Reference_37` (`PEDIP_Codigo`),
  ADD KEY `FK_Reference_38` (`PROD_Codigo`),
  ADD KEY `FK_cji_pedidodetalle_cji_unidadmedida` (`UNDMED_Codigo`);

--
-- Indices de la tabla `cji_permiso`
--
ALTER TABLE `cji_permiso`
  ADD PRIMARY KEY (`PERM_Codigo`),
  ADD UNIQUE KEY `ROL_Codigo_MENU_Codigo` (`ROL_Codigo`,`MENU_Codigo`),
  ADD KEY `FK_cji_permiso_cji_menu` (`MENU_Codigo`),
  ADD KEY `COMPP_Codigo` (`COMPP_Codigo`);

--
-- Indices de la tabla `cji_persona`
--
ALTER TABLE `cji_persona`
  ADD PRIMARY KEY (`PERSP_Codigo`),
  ADD KEY `fk_CJ_PERSONA_CJ_UBIGEO` (`UBIGP_LugarNacimiento`),
  ADD KEY `fk_CJ_PERSONA_CJ_UBIGEO1` (`UBIGP_Domicilio`),
  ADD KEY `fk_CJ_PERSONA_CJ_ESTADOCIVIL1` (`ESTCP_EstadoCivil`),
  ADD KEY `fk_CJ_PERSONA_CJ_NACIONALIDAD1` (`NACP_Nacionalidad`),
  ADD KEY `FK_cji_persona_cji_tipdocumento` (`PERSC_TipoDocIdentidad`);

--
-- Indices de la tabla `cji_plantilla`
--
ALTER TABLE `cji_plantilla`
  ADD PRIMARY KEY (`PLANT_Codigo`),
  ADD UNIQUE KEY `ATRIB_Codigo_TIPPROD_Codigo` (`ATRIB_Codigo`,`TIPPROD_Codigo`),
  ADD KEY `FK_cji_plantilla_cji_tipoproducto` (`TIPPROD_Codigo`);

--
-- Indices de la tabla `cji_presupuesto`
--
ALTER TABLE `cji_presupuesto`
  ADD PRIMARY KEY (`PRESUP_Codigo`),
  ADD KEY `FK_cji_factura_cji_compania` (`COMPP_Codigo`),
  ADD KEY `FK_cji_factura_cji_cliente` (`CLIP_Codigo`),
  ADD KEY `FK_cji_factura_cji_usuario` (`USUA_Codigo`),
  ADD KEY `FK_cji_factura_cji_moneda` (`MONED_Codigo`),
  ADD KEY `FK_cji_factura_cji_formapago` (`FORPAP_Codigo`),
  ADD KEY `PERSP_Codigo` (`PERSP_Codigo`),
  ADD KEY `AREAP_Codigo` (`AREAP_Codigo`),
  ADD KEY `PRESUC_VenedorArea` (`PRESUC_VenedorArea`),
  ADD KEY `PRESUC_VendedorPersona` (`PRESUC_VendedorPersona`);

--
-- Indices de la tabla `cji_presupuestodetalle`
--
ALTER TABLE `cji_presupuestodetalle`
  ADD PRIMARY KEY (`PRESDEP_Codigo`),
  ADD KEY `FK_cji_presupuestodetalle_presu` (`PRESUP_Codigo`),
  ADD KEY `FK_cji_presupuestodetalle_prod` (`PROD_Codigo`),
  ADD KEY `FK_cji_presupuestodetalle_unidad` (`UNDMED_Codigo`);

--
-- Indices de la tabla `cji_procedencia`
--
ALTER TABLE `cji_procedencia`
  ADD PRIMARY KEY (`PROP_Codigo`);

--
-- Indices de la tabla `cji_producto`
--
ALTER TABLE `cji_producto`
  ADD PRIMARY KEY (`PROD_Codigo`),
  ADD KEY `FK_cji_producto_cji_familia` (`FAMI_Codigo`),
  ADD KEY `FK_cji_producto_cji_tipoproducto` (`TIPPROD_Codigo`),
  ADD KEY `MARCP_Codigo` (`MARCP_Codigo`),
  ADD KEY `LINP_Codigo` (`LINP_Codigo`),
  ADD KEY `FABRIP_Codigo` (`FABRIP_Codigo`),
  ADD KEY `PROD_PadreCodigo` (`PROD_PadreCodigo`);

--
-- Indices de la tabla `cji_productoatributo`
--
ALTER TABLE `cji_productoatributo`
  ADD PRIMARY KEY (`PRODATRIB_Codigo`),
  ADD KEY `FK_cji_productoatributo_cji_producto` (`PROD_Codigo`),
  ADD KEY `FK_cji_productoatributo_cji_atributo` (`ATRIB_Codigo`);

--
-- Indices de la tabla `cji_productoprecio`
--
ALTER TABLE `cji_productoprecio`
  ADD PRIMARY KEY (`PRODPREP_Codigo`),
  ADD UNIQUE KEY `PROD_Codigo` (`PROD_Codigo`,`TIPCLIP_Codigo`,`EESTABP_Codigo`,`MONED_Codigo`,`PRODUNIP_Codigo`),
  ADD KEY `FK_cji_productoprecio_tipocliente` (`TIPCLIP_Codigo`),
  ADD KEY `FK_cji_productoprecio_empresaestableci` (`EESTABP_Codigo`),
  ADD KEY `FK_cji_productoprecio_moneda` (`MONED_Codigo`),
  ADD KEY `FK_cji_productoprecio_produni` (`PRODUNIP_Codigo`);

--
-- Indices de la tabla `cji_productoproveedor`
--
ALTER TABLE `cji_productoproveedor`
  ADD PRIMARY KEY (`PRODPROVP_Codigo`),
  ADD KEY `fk_cji_productoproveedor_cji_producto1` (`PROD_Codigo`),
  ADD KEY `fk_cji_productoproveedor_cji_proveedor1` (`PROVP_Codigo`);

--
-- Indices de la tabla `cji_productopublicacion`
--
ALTER TABLE `cji_productopublicacion`
  ADD PRIMARY KEY (`PRODPUBP_Codigo`);

--
-- Indices de la tabla `cji_productounidad`
--
ALTER TABLE `cji_productounidad`
  ADD PRIMARY KEY (`PRODUNIP_Codigo`),
  ADD UNIQUE KEY `PROD_Codigo` (`PROD_Codigo`,`PRODUNIC_Factor`),
  ADD KEY `FK_Reference_61` (`UNDMED_Codigo`);

--
-- Indices de la tabla `cji_proveedor`
--
ALTER TABLE `cji_proveedor`
  ADD PRIMARY KEY (`PROVP_Codigo`),
  ADD KEY `fk_CJ_PROVEEDOR_CJ_PERSONA1` (`PERSP_Codigo`),
  ADD KEY `fk_CJ_PROVEEDOR_CJ_EMPRESA1` (`EMPRP_Codigo`);

--
-- Indices de la tabla `cji_proveedorcompania`
--
ALTER TABLE `cji_proveedorcompania`
  ADD PRIMARY KEY (`PROVP_Codigo`,`COMPP_Codigo`),
  ADD KEY `COMPP_Codigo` (`COMPP_Codigo`);

--
-- Indices de la tabla `cji_proveedormarca`
--
ALTER TABLE `cji_proveedormarca`
  ADD PRIMARY KEY (`EMPMARP_Codigo`);

--
-- Indices de la tabla `cji_proyecto`
--
ALTER TABLE `cji_proyecto`
  ADD PRIMARY KEY (`PROYP_Codigo`),
  ADD KEY `COMPP_Codigo` (`COMPP_Codigo`),
  ADD KEY `DIREP_Codigo` (`DIREP_Codigo`),
  ADD KEY `PROYC_CodigoUsuario` (`PROYC_CodigoUsuario`),
  ADD KEY `DIRECC_Codigo` (`DIRECC_Codigo`);

--
-- Indices de la tabla `cji_recepcionproveedor`
--
ALTER TABLE `cji_recepcionproveedor`
  ADD PRIMARY KEY (`RECEPRO_Codigo`),
  ADD KEY `FK_cji_recepcionproveedor_cji_garantia` (`GARAN_Codigo`),
  ADD KEY `FK_cji_recepcionproveedor_cji_empresa` (`EMPRP_Codigo`),
  ADD KEY `FK_cji_recepcionproveedor_cji_compania` (`COMPP_Codigo`),
  ADD KEY `FK_cji_garantia_cji_proveedor` (`PROVP_Codigo`);

--
-- Indices de la tabla `cji_reponsblmoviminto`
--
ALTER TABLE `cji_reponsblmoviminto`
  ADD PRIMARY KEY (`RESPNMOV_Codigo`);

--
-- Indices de la tabla `cji_rol`
--
ALTER TABLE `cji_rol`
  ADD PRIMARY KEY (`ROL_Codigo`),
  ADD KEY `COMPP_Codigo` (`COMPP_Codigo`);

--
-- Indices de la tabla `cji_sectorcomercial`
--
ALTER TABLE `cji_sectorcomercial`
  ADD PRIMARY KEY (`SECCOMP_Codigo`);

--
-- Indices de la tabla `cji_serie`
--
ALTER TABLE `cji_serie`
  ADD PRIMARY KEY (`SERIP_Codigo`),
  ADD KEY `fk_cji_serie_cji_producto1` (`PROD_Codigo`);

--
-- Indices de la tabla `cji_seriedocumento`
--
ALTER TABLE `cji_seriedocumento`
  ADD PRIMARY KEY (`SERDOC_Codigo`);

--
-- Indices de la tabla `cji_seriemov`
--
ALTER TABLE `cji_seriemov`
  ADD PRIMARY KEY (`SERMOVP_Codigo`),
  ADD KEY `SERIP_Codigo` (`SERIP_Codigo`),
  ADD KEY `GUIAINP_Codigo` (`GUIAINP_Codigo`),
  ADD KEY `GUIASAP_Codigo` (`GUIASAP_Codigo`);

--
-- Indices de la tabla `cji_terminal`
--
ALTER TABLE `cji_terminal`
  ADD PRIMARY KEY (`TERMINAL_Codigo`);

--
-- Indices de la tabla `cji_tipdocumento`
--
ALTER TABLE `cji_tipdocumento`
  ADD PRIMARY KEY (`TIPDOCP_Codigo`);

--
-- Indices de la tabla `cji_tipoalmacen`
--
ALTER TABLE `cji_tipoalmacen`
  ADD PRIMARY KEY (`TIPALMP_Codigo`);

--
-- Indices de la tabla `cji_tipocaja`
--
ALTER TABLE `cji_tipocaja`
  ADD PRIMARY KEY (`tipCa_codigo`);

--
-- Indices de la tabla `cji_tipocambio`
--
ALTER TABLE `cji_tipocambio`
  ADD PRIMARY KEY (`TIPCAMP_Codigo`),
  ADD KEY `FK_cji_tipocambio_moneda1` (`TIPCAMC_MonedaOrigen`),
  ADD KEY `FK_cji_tipocambio_conmpania` (`COMPP_Codigo`);

--
-- Indices de la tabla `cji_tipocliente`
--
ALTER TABLE `cji_tipocliente`
  ADD PRIMARY KEY (`TIPCLIP_Codigo`),
  ADD KEY `FK_cji_tipocliente_compania` (`COMPP_Codigo`);

--
-- Indices de la tabla `cji_tipocodigo`
--
ALTER TABLE `cji_tipocodigo`
  ADD PRIMARY KEY (`TIPCOD_Codigo`);

--
-- Indices de la tabla `cji_tipoestablecimiento`
--
ALTER TABLE `cji_tipoestablecimiento`
  ADD PRIMARY KEY (`TESTP_Codigo`),
  ADD KEY `COMPP_Codigo` (`COMPP_Codigo`);

--
-- Indices de la tabla `cji_tipomovimiento`
--
ALTER TABLE `cji_tipomovimiento`
  ADD PRIMARY KEY (`TIPOMOVP_Codigo`);

--
-- Indices de la tabla `cji_tipoproducto`
--
ALTER TABLE `cji_tipoproducto`
  ADD PRIMARY KEY (`TIPPROD_Codigo`);

--
-- Indices de la tabla `cji_tipoproveedor`
--
ALTER TABLE `cji_tipoproveedor`
  ADD PRIMARY KEY (`FAMI_Codigo`);

--
-- Indices de la tabla `cji_ubigeo`
--
ALTER TABLE `cji_ubigeo`
  ADD PRIMARY KEY (`UBIGP_Codigo`);

--
-- Indices de la tabla `cji_unidadmedida`
--
ALTER TABLE `cji_unidadmedida`
  ADD PRIMARY KEY (`UNDMED_Codigo`);

--
-- Indices de la tabla `cji_usuario`
--
ALTER TABLE `cji_usuario`
  ADD PRIMARY KEY (`USUA_Codigo`),
  ADD KEY `FK_cji_usuario_cji_persona` (`PERSP_Codigo`),
  ADD KEY `FK_cji_usuario_cji_rol` (`ROL_Codigo`);

--
-- Indices de la tabla `cji_usuario_compania`
--
ALTER TABLE `cji_usuario_compania`
  ADD PRIMARY KEY (`USUCOMP_Codigo`),
  ADD KEY `USUA_Codigo` (`USUA_Codigo`),
  ADD KEY `COMPP_Codigo` (`COMPP_Codigo`),
  ADD KEY `ROL_Codigo` (`ROL_Codigo`),
  ADD KEY `CARGP_Codigo` (`CARGP_Codigo`);

--
-- Indices de la tabla `cji_usuario_terminal`
--
ALTER TABLE `cji_usuario_terminal`
  ADD PRIMARY KEY (`USUTERMINAL_Codigo`);

--
-- Indices de la tabla `impactousuario`
--
ALTER TABLE `impactousuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `impacto_documento`
--
ALTER TABLE `impacto_documento`
  ADD PRIMARY KEY (`IMPDOC_Codigo`);

--
-- Indices de la tabla `impacto_publicacion`
--
ALTER TABLE `impacto_publicacion`
  ADD PRIMARY KEY (`IMPPUB_Codigo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cji_almacen`
--
ALTER TABLE `cji_almacen`
  MODIFY `ALMAP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `cji_almacenproducto`
--
ALTER TABLE `cji_almacenproducto`
  MODIFY `ALMPROD_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `cji_almacenproductoserie`
--
ALTER TABLE `cji_almacenproductoserie`
  MODIFY `ALMPRODSERP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT de la tabla `cji_almaprolote`
--
ALTER TABLE `cji_almaprolote`
  MODIFY `ALMALOTP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT de la tabla `cji_area`
--
ALTER TABLE `cji_area`
  MODIFY `AREAP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `cji_atributo`
--
ALTER TABLE `cji_atributo`
  MODIFY `ATRIB_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `cji_banco`
--
ALTER TABLE `cji_banco`
  MODIFY `BANP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT de la tabla `cji_bancocta`
--
ALTER TABLE `cji_bancocta`
  MODIFY `CTAP_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_caja`
--
ALTER TABLE `cji_caja`
  MODIFY `CAJA_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_cajamovimiento`
--
ALTER TABLE `cji_cajamovimiento`
  MODIFY `CAJAMOV_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT de la tabla `cji_caja_chekera`
--
ALTER TABLE `cji_caja_chekera`
  MODIFY `CAJCHEK_Codigo` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_caja_cuenta`
--
ALTER TABLE `cji_caja_cuenta`
  MODIFY `CAJCUENT_Codigo` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_cargo`
--
ALTER TABLE `cji_cargo`
  MODIFY `CARGP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `cji_categoriapublicacion`
--
ALTER TABLE `cji_categoriapublicacion`
  MODIFY `CATPUBP_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_centrocosto`
--
ALTER TABLE `cji_centrocosto`
  MODIFY `CENCOSP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `cji_chekera`
--
ALTER TABLE `cji_chekera`
  MODIFY `CHEK_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_cheque`
--
ALTER TABLE `cji_cheque`
  MODIFY `CHEP_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_ciiu`
--
ALTER TABLE `cji_ciiu`
  MODIFY `CIIUP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000;
--
-- AUTO_INCREMENT de la tabla `cji_cliente`
--
ALTER TABLE `cji_cliente`
  MODIFY `CLIP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `cji_compadocumenitem`
--
ALTER TABLE `cji_compadocumenitem`
  MODIFY `COMPADOCUITEM_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=379;
--
-- AUTO_INCREMENT de la tabla `cji_compania`
--
ALTER TABLE `cji_compania`
  MODIFY `COMPP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `cji_companiaconfidocumento`
--
ALTER TABLE `cji_companiaconfidocumento`
  MODIFY `COMPCONFIDOCP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT de la tabla `cji_companiaconfiguracion`
--
ALTER TABLE `cji_companiaconfiguracion`
  MODIFY `COMPCONFIP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `cji_comparativo`
--
ALTER TABLE `cji_comparativo`
  MODIFY `COMP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `cji_comparativodetalle`
--
ALTER TABLE `cji_comparativodetalle`
  MODIFY `CUACOMP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `cji_comprobante`
--
ALTER TABLE `cji_comprobante`
  MODIFY `CPP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT de la tabla `cji_comprobantedetalle`
--
ALTER TABLE `cji_comprobantedetalle`
  MODIFY `CPDEP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT de la tabla `cji_comprobante_guiarem`
--
ALTER TABLE `cji_comprobante_guiarem`
  MODIFY `COMPGUI_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT de la tabla `cji_condicionentrega`
--
ALTER TABLE `cji_condicionentrega`
  MODIFY `CONENP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `cji_configuracion`
--
ALTER TABLE `cji_configuracion`
  MODIFY `CONFIP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;
--
-- AUTO_INCREMENT de la tabla `cji_correlativo`
--
ALTER TABLE `cji_correlativo`
  MODIFY `CORRP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `cji_correoenviar`
--
ALTER TABLE `cji_correoenviar`
  MODIFY `CE_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_cotizacion`
--
ALTER TABLE `cji_cotizacion`
  MODIFY `COTIP_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_cotizaciondetalle`
--
ALTER TABLE `cji_cotizaciondetalle`
  MODIFY `COTDEP_Codigo` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_cuentacontable`
--
ALTER TABLE `cji_cuentacontable`
  MODIFY `CUNTCONTBL_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `cji_cuentas`
--
ALTER TABLE `cji_cuentas`
  MODIFY `CUE_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT de la tabla `cji_cuentasempresas`
--
ALTER TABLE `cji_cuentasempresas`
  MODIFY `CUENT_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_cuentaspago`
--
ALTER TABLE `cji_cuentaspago`
  MODIFY `CPAGP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `cji_direccion`
--
ALTER TABLE `cji_direccion`
  MODIFY `DIRECC_Codigo` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_directivo`
--
ALTER TABLE `cji_directivo`
  MODIFY `DIREP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT de la tabla `cji_documento`
--
ALTER TABLE `cji_documento`
  MODIFY `DOCUP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT de la tabla `cji_documentoitem`
--
ALTER TABLE `cji_documentoitem`
  MODIFY `DOCUITEM_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=328;
--
-- AUTO_INCREMENT de la tabla `cji_documentosentenica`
--
ALTER TABLE `cji_documentosentenica`
  MODIFY `DOCSENT_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=803;
--
-- AUTO_INCREMENT de la tabla `cji_emprarea`
--
ALTER TABLE `cji_emprarea`
  MODIFY `EAREAP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `cji_emprcontacto`
--
ALTER TABLE `cji_emprcontacto`
  MODIFY `ECONP_Contacto` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_empresa`
--
ALTER TABLE `cji_empresa`
  MODIFY `EMPRP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=209;
--
-- AUTO_INCREMENT de la tabla `cji_empresatipoproveedor`
--
ALTER TABLE `cji_empresatipoproveedor`
  MODIFY `EMPTIPOP_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_emprestablecimiento`
--
ALTER TABLE `cji_emprestablecimiento`
  MODIFY `EESTABP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT de la tabla `cji_entregacliente`
--
ALTER TABLE `cji_entregacliente`
  MODIFY `ENTRECLI_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_envioproveedor`
--
ALTER TABLE `cji_envioproveedor`
  MODIFY `ENVIPRO_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_estadocivil`
--
ALTER TABLE `cji_estadocivil`
  MODIFY `ESTCP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `cji_fabricante`
--
ALTER TABLE `cji_fabricante`
  MODIFY `FABRIP_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_familia`
--
ALTER TABLE `cji_familia`
  MODIFY `FAMI_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT de la tabla `cji_flujocaja`
--
ALTER TABLE `cji_flujocaja`
  MODIFY `FLUCAJ_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_formapago`
--
ALTER TABLE `cji_formapago`
  MODIFY `FORPAP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT de la tabla `cji_garantia`
--
ALTER TABLE `cji_garantia`
  MODIFY `GARAN_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_guiain`
--
ALTER TABLE `cji_guiain`
  MODIFY `GUIAINP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;
--
-- AUTO_INCREMENT de la tabla `cji_guiaindetalle`
--
ALTER TABLE `cji_guiaindetalle`
  MODIFY `GUIAINDETP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;
--
-- AUTO_INCREMENT de la tabla `cji_guiarem`
--
ALTER TABLE `cji_guiarem`
  MODIFY `GUIAREMP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=233;
--
-- AUTO_INCREMENT de la tabla `cji_guiaremdetalle`
--
ALTER TABLE `cji_guiaremdetalle`
  MODIFY `GUIAREMDETP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=327;
--
-- AUTO_INCREMENT de la tabla `cji_guiasa`
--
ALTER TABLE `cji_guiasa`
  MODIFY `GUIASAP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `cji_guiasadetalle`
--
ALTER TABLE `cji_guiasadetalle`
  MODIFY `GUIASADETP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT de la tabla `cji_guiatrans`
--
ALTER TABLE `cji_guiatrans`
  MODIFY `GTRANP_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_guiatransdetalle`
--
ALTER TABLE `cji_guiatransdetalle`
  MODIFY `GTRANDETP_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_inventario`
--
ALTER TABLE `cji_inventario`
  MODIFY `INVE_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT de la tabla `cji_inventariodetalle`
--
ALTER TABLE `cji_inventariodetalle`
  MODIFY `INVD_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT de la tabla `cji_item`
--
ALTER TABLE `cji_item`
  MODIFY `ITEM_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT de la tabla `cji_kardex`
--
ALTER TABLE `cji_kardex`
  MODIFY `KARDP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=380;
--
-- AUTO_INCREMENT de la tabla `cji_letra`
--
ALTER TABLE `cji_letra`
  MODIFY `LET_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_linea`
--
ALTER TABLE `cji_linea`
  MODIFY `LINP_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_log`
--
ALTER TABLE `cji_log`
  MODIFY `LOGP_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_lote`
--
ALTER TABLE `cji_lote`
  MODIFY `LOTP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;
--
-- AUTO_INCREMENT de la tabla `cji_loteprorrateo`
--
ALTER TABLE `cji_loteprorrateo`
  MODIFY `LOTPROP_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_marca`
--
ALTER TABLE `cji_marca`
  MODIFY `MARCP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `cji_menu`
--
ALTER TABLE `cji_menu`
  MODIFY `MENU_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;
--
-- AUTO_INCREMENT de la tabla `cji_moneda`
--
ALTER TABLE `cji_moneda`
  MODIFY `MONED_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `cji_nacionalidad`
--
ALTER TABLE `cji_nacionalidad`
  MODIFY `NACP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=274;
--
-- AUTO_INCREMENT de la tabla `cji_nota`
--
ALTER TABLE `cji_nota`
  MODIFY `CRED_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_notadetalle`
--
ALTER TABLE `cji_notadetalle`
  MODIFY `CREDET_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_ocompradetalle`
--
ALTER TABLE `cji_ocompradetalle`
  MODIFY `OCOMDEP_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_ordencompra`
--
ALTER TABLE `cji_ordencompra`
  MODIFY `OCOMP_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_pago`
--
ALTER TABLE `cji_pago`
  MODIFY `PAGP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `cji_pedido`
--
ALTER TABLE `cji_pedido`
  MODIFY `PEDIP_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_pedidodetalle`
--
ALTER TABLE `cji_pedidodetalle`
  MODIFY `PEDIDETP_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_permiso`
--
ALTER TABLE `cji_permiso`
  MODIFY `PERM_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=203;
--
-- AUTO_INCREMENT de la tabla `cji_persona`
--
ALTER TABLE `cji_persona`
  MODIFY `PERSP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT de la tabla `cji_plantilla`
--
ALTER TABLE `cji_plantilla`
  MODIFY `PLANT_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_presupuesto`
--
ALTER TABLE `cji_presupuesto`
  MODIFY `PRESUP_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_presupuestodetalle`
--
ALTER TABLE `cji_presupuestodetalle`
  MODIFY `PRESDEP_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_procedencia`
--
ALTER TABLE `cji_procedencia`
  MODIFY `PROP_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_producto`
--
ALTER TABLE `cji_producto`
  MODIFY `PROD_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `cji_productoatributo`
--
ALTER TABLE `cji_productoatributo`
  MODIFY `PRODATRIB_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_productoprecio`
--
ALTER TABLE `cji_productoprecio`
  MODIFY `PRODPREP_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_productoproveedor`
--
ALTER TABLE `cji_productoproveedor`
  MODIFY `PRODPROVP_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_productopublicacion`
--
ALTER TABLE `cji_productopublicacion`
  MODIFY `PRODPUBP_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_productounidad`
--
ALTER TABLE `cji_productounidad`
  MODIFY `PRODUNIP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `cji_proveedor`
--
ALTER TABLE `cji_proveedor`
  MODIFY `PROVP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `cji_proveedormarca`
--
ALTER TABLE `cji_proveedormarca`
  MODIFY `EMPMARP_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_proyecto`
--
ALTER TABLE `cji_proyecto`
  MODIFY `PROYP_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_recepcionproveedor`
--
ALTER TABLE `cji_recepcionproveedor`
  MODIFY `RECEPRO_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_reponsblmoviminto`
--
ALTER TABLE `cji_reponsblmoviminto`
  MODIFY `RESPNMOV_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT de la tabla `cji_rol`
--
ALTER TABLE `cji_rol`
  MODIFY `ROL_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `cji_sectorcomercial`
--
ALTER TABLE `cji_sectorcomercial`
  MODIFY `SECCOMP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `cji_serie`
--
ALTER TABLE `cji_serie`
  MODIFY `SERIP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT de la tabla `cji_seriedocumento`
--
ALTER TABLE `cji_seriedocumento`
  MODIFY `SERDOC_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;
--
-- AUTO_INCREMENT de la tabla `cji_seriemov`
--
ALTER TABLE `cji_seriemov`
  MODIFY `SERMOVP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;
--
-- AUTO_INCREMENT de la tabla `cji_terminal`
--
ALTER TABLE `cji_terminal`
  MODIFY `TERMINAL_Codigo` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_tipdocumento`
--
ALTER TABLE `cji_tipdocumento`
  MODIFY `TIPDOCP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `cji_tipoalmacen`
--
ALTER TABLE `cji_tipoalmacen`
  MODIFY `TIPALMP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `cji_tipocaja`
--
ALTER TABLE `cji_tipocaja`
  MODIFY `tipCa_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `cji_tipocambio`
--
ALTER TABLE `cji_tipocambio`
  MODIFY `TIPCAMP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=351;
--
-- AUTO_INCREMENT de la tabla `cji_tipocliente`
--
ALTER TABLE `cji_tipocliente`
  MODIFY `TIPCLIP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `cji_tipocodigo`
--
ALTER TABLE `cji_tipocodigo`
  MODIFY `TIPCOD_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `cji_tipoestablecimiento`
--
ALTER TABLE `cji_tipoestablecimiento`
  MODIFY `TESTP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `cji_tipomovimiento`
--
ALTER TABLE `cji_tipomovimiento`
  MODIFY `TIPOMOVP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `cji_tipoproducto`
--
ALTER TABLE `cji_tipoproducto`
  MODIFY `TIPPROD_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_tipoproveedor`
--
ALTER TABLE `cji_tipoproveedor`
  MODIFY `FAMI_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cji_ubigeo`
--
ALTER TABLE `cji_ubigeo`
  MODIFY `UBIGP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=250402;
--
-- AUTO_INCREMENT de la tabla `cji_unidadmedida`
--
ALTER TABLE `cji_unidadmedida`
  MODIFY `UNDMED_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;
--
-- AUTO_INCREMENT de la tabla `cji_usuario`
--
ALTER TABLE `cji_usuario`
  MODIFY `USUA_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `cji_usuario_compania`
--
ALTER TABLE `cji_usuario_compania`
  MODIFY `USUCOMP_Codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `cji_usuario_terminal`
--
ALTER TABLE `cji_usuario_terminal`
  MODIFY `USUTERMINAL_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `impactousuario`
--
ALTER TABLE `impactousuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `impacto_documento`
--
ALTER TABLE `impacto_documento`
  MODIFY `IMPDOC_Codigo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `impacto_publicacion`
--
ALTER TABLE `impacto_publicacion`
  MODIFY `IMPPUB_Codigo` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
