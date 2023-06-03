var NameDocumentType = (function() {

    return function NameDocumentType(code_document_type) {
        var name = '';
        switch (code_document_type) {
            case '1': name = "DNI"; break;
            case '6': name = "RUC"; break;
            case '4': name = "CARNET EXT."; break;
            case '7': name = "PASAPORTE"; break;
            case '0': name = "OTROS"; break;
            
            
            default: name = ''; break;
        }

        return name;
    };

})();

var CodeInvoice = (function() {

    return function CodeInvoice(code_invoice) {
        var code = '';
        switch (code_invoice) {
            case '01': code = "FT"; break;
            case '03': code = "BT"; break;
            case '07': code = "NC"; break;
            case '08': code = "ND"; break;
            case '09': code = "GR"; break;
            case '31': code = "GRT"; break;
            case 'NE': code = "NE"; break;
            case 'NS': code = "NS"; break;
            case 'NV': code = "NV"; break;
            case '00': code = "OT"; break;
            case 'NR': code = "NR"; break;
            case 'CS': code = "CS"; break;
            case 'GC': code = "GC"; break;
            case 'AT': code = "AT"; break;
            case 'NA': code = "NA"; break;
            case 'NP': code = "NP"; break;
            case 'GD': code = "GD"; break;
            default: code = ''; break;
        }

        return code;
    };

})();

var NameInvoice = (function() {

    return function NameInvoice(code_invoice) {
        var name = '';
        switch (code_invoice) {
            case '00' : name = "Otros"; break;
            case '01' : name = "Factura"; break;
            case '03' : name = "Boleta de Venta"; break;
            case '04' : name = "Liquidación de Compra"; break;
            case '07' : name = "Nota de Crédito"; break;
            case '08' : name = "Nota de Débito"; break;
            case '09' : name = "Guía Rem Rem"; break;
            case '12' : name = "Ticket o cinta emitido por máquina registradora"; break;
            case '21' : name = "Conocimiento de embarque por el servicio de transporte de carga marítima"; break;
            case '22' : name = "Comprobante por Operaciones No Habituales"; break;
            case '31' : name = "Guía de Remisión - Transportista"; break;
            case '50' : name = "Declaración Única de Aduanas - Importación definitiva"; break;
            case '52' : name = "Despacho Simplificado - Importación Simplificada"; break;
            case '91' : name = "Comprobante de No Domiciliado"; break;
            case 'GC' : name = "Guía de Credito"; break; 
            case 'NR' : name = "Nota de Requerimiento"; break; 
            case 'AT' : name = "Asisencia Técnica"; break; 
            case 'CT' : name = "Cotización "; break; 
            case 'PF' : name = "Proforma"; break; 
            case 'NS' : name = "Nota de Salida"; break; 
            case 'NE' : name = "Nota de Entrada"; break; 
            case 'NV' : name = "Nota de Venta"; break; 
            case 'NP' : name = "Nota de Pago"; break; 
            case 'NA' : name = "Nota de Almacen"; break; 
            case 'NS' : name = "Nota de Servicio"; break; 
            case 'GD' : name = "Guía de Despacho"; break; 
            default: name = ''; break;
        }

        return toLowerCase(name);
    };

})();



var NameOperationType = (function() {

    return function NameOperationType(code_operation_type) {
        var name = '';
        switch (code_operation_type) {
            case '01' : name =  "Venta Nacional"; break;
            case '02' : name =  "Compra Nacional"; break;
            case '03' : name =  "Consignación Recibida"; break;
            case '04' : name =  "Consignación Entregada"; break;
            case '05' : name =  "Devolución Recibida"; break;
            case '06' : name =  "Devolución Entregada"; break;
            case '07' : name =  "Bonificación"; break;
            case '08' : name =  "Premio"; break;
            case '09' : name =  "Donación"; break;
            case '10' : name =  "Salida A Producción"; break;
            case '11' : name =  "Transferencia Entre Almacenes "; break;
            case '12' : name =  "Retiro"; break;
            case '13' : name =  "Mermas"; break;
            case '14' : name =  "Desmedros"; break;
            case '15' : name =  "Destrucción"; break;
            case '16' : name =  "Saldo Inicial"; break;
            case '17' : name =  "Exportación"; break;
            case '18' : name =  "Importación"; break;
            case '19' : name =  "Entrada De Producción"; break;
            case '20' : name =  "Entrada Por Devolución De Producción"; break;
            case '21' : name =  "Transferencia Entre Almacenes"; break;
            case '22' : name =  "Entrada Por Identificación Erronea"; break;
            case '23' : name =  "Salida Por Identificación Erronea"; break;
            case '24' : name =  "Entrada Por Devolución Del Cliente"; break;
            case '25' : name =  "Salida Por Devolución Al Proveedor"; break;
            case '26' : name =  "Entrada Para Servicio De Producción"; break;
            case '27' : name =  "Salida Por Servicio De Producción"; break;
            case '28' : name =  "Ajuste Por Diferencia De Inventario"; break;
            case '29' : name =  "Entrada De Bienes En Préstamo"; break;
            case '30' : name =  "Salida De Bienes En Préstamo"; break;
            case '31' : name =  "Entrada De Bienes En Custodia"; break;
            case '32' : name =  "Salida De Bienes En Custodia"; break;
            case '33' : name =  "Muestras Médicas"; break;
            case '34' : name =  "Publicidad"; break;
            case '35' : name =  "Gastos De Representación"; break;
            case '36' : name =  "Retiro Para Entrega A Trabajadores"; break;
            case '37' : name =  "Retiro Por Convenio Colectivo"; break;
            case '38' : name =  "Retiro Por Sustitución De Bien Siniestrado"; break;
            case '91' : name =  "Otros 1"; break;
            case '92' : name =  "Otros 2"; break;
            case '93' : name =  "Otros 3 "; break;
            case '94' : name =  "Otros 4"; break;
            case '99' : name =  "Otros"; break;

            default: name = ''; break;
        }

        return (name);
    };
})();


var NameMethodPayment = (function() {

    return function NameMethodPayment(code_method_payment) {
        var name = '';
        switch (code_method_payment) {
            case '001': name = 'DEPÓSITO EN CUENTA'; break;
            case '003': name = 'TRANSFERENCIA DE FONDOS'; break;
            case '004': name = 'ORDEN DE PAGO'; break;
            case '005': name = 'TARJETA DE DÉBITO'; break;
            case '006': name = 'TARJETA DE CRÉDITO'; break;
            case '007': name = 'CHEQUES"'; break;
            case '008': name = 'EFECTIVO'; break;
            case '009': name = 'EFECTIVO, EN LOS DEMÁS CASOS'; break;
            case '101': name = 'TRANSFERENCIAS - COMERCIO EXTERIOR'; break;
            case '102': name = 'CHEQUES BANCARIOS  - COMERCIO EXTERIOR'; break;
            default: name = ''; break;
        }

        return (name);
    };
})();


var NameReasonNCD = (function() {

    return function NameReasonNCD(type_invoice,code) {
        var name = '';
       
        if (type_invoice == "07") {
            switch (code) {
                case '01' : name = "Anulación de la operación"; break;
                case '02' : name = "Anulación por error en el RUC"; break;
                case '03' : name = "Corrección por error en la descripción"; break;
                case '04' : name = "Descuento global"; break;
                case '05' : name = "Descuento por ítem"; break;
                case '06' : name = "Devolución total"; break;
                case '07' : name = "Devolución por ítem"; break;
                case '08' : name = "Bonificación"; break;
                case '09' : name = "Disminución en el valor"; break;
                case '10' : name = "Otros Conceptos "; break;
                default: name = ''; break;
            }
            return name;
        }
        if (type_invoice == "08") {
            switch (code) {
                case '01' : name = "Intereses por mora"; break;
                case '02' : name = "Aumento en el valor"; break;
                case '03' : name = "Penalidades/ otros conceptos"; break;
                default: name = ''; break;
            }
            return name;
        }
    };
})();

var NameBank = (function() {

    return function NameBank(code) {
        var name = '';
        switch (code) {
            case '001': name = 'BANCO CENTRAL DE RESERVA DEL PERU'; break;
            case '002': name = 'BANCO DE CREDITO DEL PERU'; break;
            case '003': name = 'BANCO INTERNACIONAL DEL PERU'; break;
            case '005': name = 'BANCO LATINO'; break;
            case '007': name = 'BANCO CITIBANK N.A.'; break;
            case '008': name = 'BANCO STANDARD CHARTERED'; break;
            case '009': name = 'BCO.SCOTIABANK PERU SAA (ANTES WIESE SUDAMERIS)'; break;
            case '011': name = 'BANCO CONTINENTAL'; break;
            case '018': name = 'BANCO DE LA NACION'; break;
            case '023': name = 'BANCO COMERCIO'; break;
            case '026': name = 'BANCO NORBANK'; break;
            case '037': name = 'BANCO DEL PROGRESO'; break;
            case '038': name = 'BANCO INTERAMERICANO DE FINANZAS'; break;
            case '041': name = 'BANCO SUDAMERICANO'; break;
            case '043': name = 'BANCO DEL TRABAJO'; break;
            case '044': name = 'BANCO SOLVENTA'; break;
            case '045': name = 'BANCO SERBANCO'; break;
            case '046': name = 'BANK BOSTON N.A. SUCURSAL DEL PERU'; break;
            case '047': name = 'ORION CORPORACION DE CREDITO'; break;
            case '048': name = 'BANCO NUEVO PAIS'; break;
            case '049': name = 'MIBANCO'; break;
            case '050': name = 'BANQUE NATIONALE DE PARIS - ANDES S.A.'; break;
            case '053': name = 'BANCO HSBC'; break;
            case '056': name = 'BANCO SANTANDER PERU S.A.'; break;
            case '071': name = 'CORPORACION FINANCIERA DE DESARROLLO - COFIDE'; break;
            case '083': name = 'SOLUCION - FINANCIERA DE CREDITO DEL PERU'; break;
            case '086': name = 'FINANDAEWOO S.A.'; break;
            case '087': name = 'FINANCIERA C.M.R.'; break;
            case '088': name = 'VOLVO FINANCE PERU'; break;
            case '089': name = 'FINANCIERA CORDILLERA S.A.'; break;
            case '091': name = 'GENERALI PERU CIA. SEGUROS'; break;
            case '092': name = 'LA VITALICIA'; break;
            case '093': name = 'REASEGURADORA PERUANA'; break;
            case '094': name = 'SEGUROS LA FENIX PERUANA'; break;
            case '095': name = 'SECREX  CIA. SEGUROS'; break;
            case '099': name = 'OTROS'; break;
            default: name = ''; break;
        }
        return name;
     
    };
})();

var NameUnitMeasure = (function() {

    return function NameUnitMeasure(code) {
        var name = '';
        switch (code) {
            case '4A': name = 'BOBINAS'; break;
            case 'BJ': name = 'BALDE'; break;
            case 'BLL': name = 'BARRILES'; break;
            case 'BG': name = 'BOLSA'; break;
            case 'BO': name = 'BOTELLAS'; break;
            case 'BX': name = 'CAJA'; break;
            case 'CMK': name = 'CENTIMETRO CUADRADO'; break;
            case 'CMQ': name = 'CENTIMETRO CUBICO'; break;
            case 'CMT': name = 'CENTIMETRO LINEAL'; break;
            case 'CEN': name = 'CIENTO DE UNIDADES'; break;
            case 'CY': name = 'CILINDRO'; break;
            case 'DZN': name = 'DOCENA'; break;
            case 'DZP': name = 'DOCENA POR 10**6'; break;
            case 'BE': name = 'FARDO'; break;
            case 'GLI': name = 'GALON INGLES (4,545956L)'; break;
            case 'GRM': name = 'GRAMO'; break;
            case 'KGM': name = 'KILOGRAMO'; break;
            case 'CA': name = 'LATAS'; break;
            case 'LBR': name = 'LIBRAS'; break;
            case 'LTR': name = 'LITRO'; break;
            case 'MTR': name = 'METRO'; break;
            case 'MGM': name = 'MILIGRAMOS'; break;
            case 'MIL': name = 'MILLARES'; break;
            case 'UM': name = 'MILLON DE UNIDADES'; break;
            case 'ONZ': name = 'ONZAS'; break;
            case 'PF': name = 'PALETAS'; break;
            case 'PK': name = 'PAQUETE'; break;
            case 'GRM': name = 'GRAMO'; break;
            case 'PR': name = 'PAR'; break;
            case 'FOT': name = 'PIES'; break;
            case 'FTK': name = 'PIES CUADRADOS'; break;
            case 'FTQ': name = 'PIES CUBICOS'; break;
            case 'C62': name = 'PIEZAS'; break;
            case 'NIU': name = 'UNIDAD (BIENES) '; break;
            case 'ZZ': name = 'UNIDAD (SERVICIOS)'; break;
            case 'GRM': name = 'US GALON (3,7843 L)'; break;
            case 'GLL': name = 'GRAMO'; break;
            default: name = ''; break;
        }
        return (name);
    };
})();


var NameMonth = (function() {

    return function NameMonth(code) {
        var name = '';
        switch (code) {
            case '01': name = 'Enero'; break;
            case '02': name = 'Febrero'; break;
            case '03': name = 'Marzo'; break;
            case '04': name = 'Abril'; break;
            case '05': name = 'Mayo'; break;
            case '06': name = 'Junio'; break;
            case '07': name = 'Julio'; break;
            case '08': name = 'Agosto'; break;
            case '09': name = 'Septiembre'; break;
            case '10': name = 'Octubre'; break;
            case '11': name = 'Noviembre'; break;
            case '12': name = 'Diciembre'; break;
            default: name = ''; break;
        }
        return (name);
    };
})();



export default {NameDocumentType,CodeInvoice,NameInvoice,NameOperationType,NameMethodPayment,NameReasonNCD,NameBank,NameUnitMeasure,NameMonth}