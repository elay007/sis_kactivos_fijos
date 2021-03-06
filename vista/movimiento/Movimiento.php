<?php
/**
*@package pXP
*@file gen-Movimiento.php
*@author  (admin)
*@date 22-10-2015 20:42:41
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Movimiento=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Movimiento.superclass.constructor.call(this,config);
		//Add report button
        this.addButton('btnReporte',{
            text :'Reporte',
            iconCls : 'bpdf32',
            disabled: true,
            handler : this.onButtonReport,
            tooltip : '<b>Reporte de Movimiennto</b><br/><b>Reporte de Movimiento efectuado y su detalle</b>'
        });
        
         this.addButton('btnReporteDep',{
            text :'Det. Dep',
            iconCls : 'bpdf32',
            disabled: true,
            handler : this.onButtonReportDepreciacion,
            tooltip : '<b>Reporte Depreciación</b><br/><b>Reprote que detalla la depreciación del movimiento</b>'
        });
        
        
		
		
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_movimiento'
			},
			type:'Field',
			form:true 
		},
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'cod_movimiento'
			},
			type:'Field',
			form:true 
		},
		{
			config: {
				name: 'id_cat_movimiento',
				fieldLabel: 'Proceso',
				anchor: '95%',
				tinit: false,
				allowBlank: false,
				origen: 'CATALOGO',
				gdisplayField: 'movimiento',
				hiddenName: 'id_cat_movimiento',
				gwidth: 55,
				baseParams:{
						cod_subsistema:'KAF',
						catalogo_tipo:'tmovimiento__id_cat_movimiento'
				},
				renderer: function (value,p,record) {
					var result;
					result = "<div style='text-align:center'><img src = '../../../lib/imagenes/" + record.data.icono +"'align='center' width='24' height='24' title='"+record.data.movimiento+"'/></div>";
					return result;
				},
				valueField: 'id_catalogo'
			},
			type: 'ComboRec',
			id_grupo: 0,
			filters:{pfiltro:'cat.descripcion',type:'string'},
			grid: true,
			form: true
		},
		{
			config:{
				name: 'num_tramite',
				fieldLabel: 'Fecha',
				allowBlank: true,
				anchor: '80%',
				gwidth: 210,
				maxLength:200,
				disabled: true,
				renderer: function(value,p,record){
					/*var fecha = new Date(record.data['fecha_mov'].dateFormat('d/m/Y'));
					console.log('xxxxxxx',fecha.toString());*/
					return '<tpl for="."><div class="x-combo-list-item"><p><b>Fecha: </b> '+record.data['fecha_mov'].dateFormat('d/m/Y')+'</p><p><b>Tramite: </b> <font color="blue">'+record.data['num_tramite']+'</font></p><p><b>Estado: </b>'+record.data['estado']+'</p></div></tpl>';

				}
			},
			type:'TextField',
			filters:{pfiltro:'mov.num_tramite',type:'string'},
			id_grupo:0,
			grid:true,
			form:false,
			bottom_filter:true
		},
		{
			config:{
				name: 'estado',
				fieldLabel: 'Estado',
				allowBlank: true,
				anchor: '80%',
				gwidth: 90,
				maxLength:15,
				disabled: true,
				renderer: function (value,p,record) {
					var result;
					//if(value == "Borrador") {
						result = "<div style='text-align:center'><img src = '../../../lib/imagenes/"+record.data.icono_estado+"' align='center' width='18' height='18' title='"+record.data.estado+"'/><br><u>"+record.data.estado+"</u></div>";
					//}
					return result;
				}
			},
			type:'TextField',
			filters:{pfiltro:'mov.estado',type:'string'},
			id_grupo:0,
			grid:false,
			form:true,
			bottom_filter:true
		},
		{
			config:{
				name: 'fecha_mov',
				fieldLabel: 'Fecha',
				allowBlank: false,
				anchor: '80%',
				gwidth: 70,
				format: 'd/m/Y', 
				renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
				type:'DateField',
				filters:{pfiltro:'mov.fecha_mov',type:'date'},
				id_grupo:0,
				grid:false,
				form:true
		},
		{
			config : {
				name : 'id_depto',
				fieldLabel : 'Dpto.',
				allowBlank : false,
				emptyText : 'Departamento...',
				store : new Ext.data.JsonStore({
					url : '../../sis_parametros/control/Depto/listarDepto',
					id : 'id_depto',
					root : 'datos',
					sortInfo : {
						field : 'nombre',
						direction : 'ASC'
					},
					totalProperty : 'total',
					fields : ['id_depto', 'nombre', 'codigo'],
					remoteSort : true,
					baseParams : {
						par_filtro : 'DEPPTO.nombre#DEPPTO.codigo',
						modulo: 'KAF'
					}
				}),
				valueField : 'id_depto',
				displayField : 'nombre',
				gdisplayField : 'depto',
				tpl : '<tpl for="."><div class="x-combo-list-item"><p>Nombre: {nombre}</p><p>Código: {codigo}</p></div></tpl>',
				hiddenName : 'id_depto',
				forceSelection : true,
				typeAhead : false,
				triggerAction : 'all',
				lazyRender : true,
				mode : 'remote',
				pageSize : 10,
				queryDelay : 1000,
				anchor : '95%',
				gwidth : 250,
				minChars : 2,
				renderer : function(value, p, record) {
					//return String.format('{0}', record.data['depto']);
					var desc;
					if(record.data['cod_movimiento']=='transf'){
						desc='<tpl for="."><div class="x-combo-list-item"><p><b>Dpto.:</b> '+record.data['depto']+'</p><p><b>De:</b> <font color="blue">'+record.data['desc_funcionario2']+'</font></p><p><b>A:</b> <u><font color="green">'+record.data['funcionario_dest']+'</u></font></p></div></tpl>';
					} else if(record.data['cod_movimiento']=='asig'){
						desc='<tpl for="."><div class="x-combo-list-item"><p><b>Dpto.:</b> '+record.data['depto']+'</p><p><b>A:</b> <u><font color="green">'+record.data['desc_funcionario2']+'</u></font></p></div></tpl>';
					} else {
						desc='<tpl for="."><div class="x-combo-list-item"><p><b>Dpto.:</b> '+record.data['depto']+'</p></div></tpl>';
					}
					return desc; 
				}
			},
			type : 'ComboBox',
			id_grupo : 0,
			filters : {
				pfiltro : 'dep.nombre',
				type : 'string'
			},
			grid : true,
			form : true
		},
		{
			config:{
				name: 'glosa',
				fieldLabel: 'Glosa',
				allowBlank: false,
				anchor: '95%',
				gwidth: 350,
				maxLength:200
			},
			type:'TextArea',
			filters:{pfiltro:'mov.glosa',type:'string'},
			id_grupo:0,
			grid:true,
			form:true,
			bottom_filter:true
		},
		{
			config:{
				name: 'fecha_hasta',
				fieldLabel: 'Fecha Hasta',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				format: 'd/m/Y', 
				hidden: true,
				renderer:function (value,p,record){return value?value.dateFormat('d/m/Y'):''}
			},
				type:'DateField',
				filters:{pfiltro:'mov.fecha_hasta',type:'date'},
				id_grupo:0,
				grid:true,
				form:true
		},
		{
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_proceso_wf'
			},
			type:'Field',
			form:true 
		},
		{
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_estado_wf'
			},
			type:'Field',
			form:true 
		},
		{
   			config:{
       		    name:'id_funcionario',
       		    hiddenName: 'id_funcionario',
   				origen:'FUNCIONARIO',
   				fieldLabel:'Funcionario',
   				allowBlank:true,
                gwidth:200,
   				valueField: 'id_funcionario',
   			    gdisplayField: 'desc_funcionario2',
   			    baseParams: { fecha: new Date()},
   			    hidden: true,
      			renderer:function(value, p, record){return String.format('{0}', record.data['desc_funcionario2']);},
       	     },
   			type:'ComboRec',//ComboRec
   			id_grupo:0,
   			filters:{pfiltro:'fun.desc_funcionario2',type:'string'},
   		    grid:true,
   			form:true,
   			bottom_filter:true
		},
		{
   			config:{
       		    name:'id_persona',
       		    hiddenName: 'id_persona',
   				origen:'PERSONA',
   				fieldLabel:'Custodio?',
   				allowBlank:true,
                gwidth:200,
   				valueField: 'id_persona',
   			    gdisplayField: 'custodio',
   			    hidden: true,
      			renderer:function(value, p, record){return String.format('{0}', record.data['custodio']);},
       	     },
   			type:'ComboRec',//ComboRec
   			id_grupo:0,
   			filters:{pfiltro:'per.nombre_completo2',type:'string'},
   		    grid:true,
   			form:true
		},
		{
			config: {
				name: 'id_oficina',
				fieldLabel: 'Oficina',
				allowBlank: true,
				emptyText: 'Elija una opción...',
				hidden: true,
				store: new Ext.data.JsonStore({
                    url: '../../sis_organigrama/control/Oficina/listarOficina',
                    id: 'id_oficina',
                    root: 'datos',
                    fields: ['id_oficina','codigo','nombre'],
                    totalProperty: 'total',
                    sortInfo: {
                        field: 'codigo',
                        direction: 'ASC'
                    },
                    baseParams:{par_filtro:'ofi.codigo#ofi.nombre'}
                }),
				valueField: 'id_oficina',
				displayField: 'nombre',
				gdisplayField: 'oficina',
				hiddenName: 'id_oficina',
				forceSelection: false,
				typeAhead: false,
				triggerAction: 'all',
				lazyRender: true,
				mode: 'remote',
				pageSize: 15,
				queryDelay: 1000,
				anchor: '95%',
				gwidth: 150,
				minChars: 2,
				renderer : function(value, p, record) {
					return String.format('{0}', record.data['oficina']);
				}
			},
			type: 'ComboBox',
			id_grupo: 0,
			filters: {pfiltro: 'ofi.nombre',type: 'string'},
			grid: true,
			form: true
		},
		{
			config:{
				name: 'direccion',
				fieldLabel: 'Direccion',
				allowBlank: true,
				anchor: '95%',
				gwidth: 100,
				maxLength:500,
				hidden: true
			},
				type:'TextArea',
				filters:{pfiltro:'mov.direccion',type:'string'},
				id_grupo:0,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'codigo',
				fieldLabel: 'Codigo',
				allowBlank: true,
				gwidth: 100,
				hidden: true
			},
				type:'TextField',
				filters:{pfiltro:'mov.codigo',type:'string'},
				id_grupo:0,
				grid:true,
				form:true
		},
		{
			config: {
				name: 'id_deposito',
				fieldLabel: 'Deposito',
				allowBlank: true,
				emptyText: 'Elija una opción...',
				hidden: true,
				store: new Ext.data.JsonStore({
                    url: '../../sis_kactivos_fijos/control/Deposito/listarDeposito',
                    id: 'id_deposito',
                    root: 'datos',
                    fields: ['id_deposito','codigo','nombre'],
                    totalProperty: 'total',
                    sortInfo: {
                        field: 'codigo',
                        direction: 'ASC'
                    },
                    baseParams:{par_filtro:'dep.codigo#dep.nombre'}
                    
                }),
				valueField: 'id_deposito',
				displayField: 'nombre',
				gdisplayField: 'deposito',
				hiddenName: 'id_deposito',
				forceSelection: false,
				typeAhead: false,
				triggerAction: 'all',
				lazyRender: true,
				mode: 'remote',
				pageSize: 15,
				queryDelay: 1000,
				anchor: '95%',
				gwidth: 150,
				minChars: 2,
				renderer : function(value, p, record) {
					return String.format('{0}', record.data['deposito']);
				}
			},
			type: 'ComboBox',
			id_grupo: 0,
			filters: {pfiltro: 'depo.nombre',type: 'string'},
			grid: true,
			form: true
		},
		{
			config : {
				name : 'id_depto_dest',
				fieldLabel : 'Depto. Destino',
				allowBlank : true,
				emptyText : 'Departamento...',
				store : new Ext.data.JsonStore({
					url : '../../sis_parametros/control/Depto/listarDepto',
					id : 'id_depto',
					root : 'datos',
					sortInfo : {
						field : 'nombre',
						direction : 'ASC'
					},
					totalProperty : 'total',
					fields : ['id_depto', 'nombre', 'codigo'],
					remoteSort : true,
					baseParams : {
						par_filtro : 'DEPPTO.nombre#DEPPTO.codigo',
						modulo: 'KAF'
					}
				}),
				valueField : 'id_depto',
				displayField : 'nombre',
				gdisplayField : 'depto_dest',
				tpl : '<tpl for="."><div class="x-combo-list-item"><p>Nombre: {nombre}</p><p>Código: {codigo}</p></div></tpl>',
				hiddenName : 'id_depto_dest',
				forceSelection : true,
				typeAhead : false,
				triggerAction : 'all',
				lazyRender : true,
				mode : 'remote',
				pageSize : 10,
				queryDelay : 1000,
				anchor : '95%',
				gwidth : 200,
				minChars : 2,
				renderer : function(value, p, record) {
					return String.format('{0}', record.data['depto_dest']);
				},
				hidden: true
			},
			type : 'ComboBox',
			id_grupo : 0,
			filters : {
				pfiltro : 'depdest.nombre',
				type : 'string'
			},
			grid : true,
			form : true
		},
		{
			config: {
				name: 'id_deposito_dest',
				fieldLabel: 'Deposito Destino',
				allowBlank: true,
				emptyText: 'Elija una opción...',
				hidden: true,
				store: new Ext.data.JsonStore({
                    url: '../../sis_kactivos_fijos/control/Deposito/listarDeposito',
                    id: 'id_deposito',
                    root: 'datos',
                    fields: ['id_deposito','codigo','nombre'],
                    totalProperty: 'total',
                    sortInfo: {
                        field: 'codigo',
                        direction: 'ASC'
                    },
                    baseParams:{
                        start: 0,
                        limit: 10,
                        sort: 'codigo',
                        dir: 'ASC',
                        id_depto: 0
                    }
                }),
				valueField: 'id_deposito',
				displayField: 'nombre',
				gdisplayField: 'deposito_dest',
				hiddenName: 'id_deposito_dest',
				forceSelection: false,
				typeAhead: false,
				triggerAction: 'all',
				lazyRender: true,
				mode: 'remote',
				pageSize: 15,
				queryDelay: 1000,
				anchor: '95%',
				gwidth: 150,
				minChars: 2,
				renderer : function(value, p, record) {
					return String.format('{0}', record.data['deposito_dest']);
				}
			},
			type: 'ComboBox',
			id_grupo: 0,
			filters: {pfiltro: 'depo.nombre',type: 'string'},
			grid: true,
			form: true
		},
		{
   			config:{
       		    name:'id_funcionario_dest',
       		    hiddenName: 'id_funcionario_dest',
   				origen:'FUNCIONARIO',
   				fieldLabel:'Funcionario Dest.',
   				allowBlank:true,
                gwidth:200,
   				valueField: 'id_funcionario',
   			    gdisplayField: 'funcionario_dest',
   			    baseParams: { fecha: new Date()},
   			    hidden: true,
      			renderer:function(value, p, record){return String.format('{0}', record.data['desc_funcionario2']);},
       	     },
   			type:'ComboRec',//ComboRec
   			id_grupo:0,
   			filters:{pfiltro:'fundest.desc_funcionario2',type:'string'},
   		    grid:true,
   			form:true,
   			bottom_filter:true
		},
		{
			config : {
				name : 'id_movimiento_motivo',
				fieldLabel : 'Motivo',
				allowBlank : true,
				emptyText : 'Motivo...',
				store : new Ext.data.JsonStore({
					url : '../../sis_kactivos_fijos/control/MovimientoMotivo/listarMovimientoMotivo',
					id : 'id_movimiento_motivo',
					root : 'datos',
					sortInfo : {
						field : 'motivo',
						direction : 'ASC'
					},
					totalProperty : 'total',
					fields : ['id_movimiento_motivo', 'motivo'],
					remoteSort : true,
					baseParams : {
						par_filtro : 'motivo',
						modulo: 'KAF'
					}
				}),
				valueField : 'id_movimiento_motivo',
				displayField : 'motivo',
				gdisplayField : 'motivo',
				//tpl : '<tpl for="."><div class="x-combo-list-item"><p>Nombre: {motivo}</p></div></tpl>',
				hiddenName : 'id_movimiento_motivo',
				forceSelection : true,
				typeAhead : false,
				triggerAction : 'all',
				lazyRender : true,
				mode : 'remote',
				pageSize : 10,
				queryDelay : 1000,
				anchor : '95%',
				gwidth : 200,
				minChars : 2,
				renderer : function(value, p, record) {
					return String.format('{0}', record.data['movimiento_motivo']);
				},
				hidden: true
			},
			type : 'ComboBox',
			id_grupo : 0,
			filters : {
				pfiltro : 'mmov.motivo',
				type : 'string'
			},
			grid : true,
			form : true
		},
		{
			config:{
				name: 'estado_reg',
				fieldLabel: 'Estado Reg.',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:10
			},
				type:'TextField',
				filters:{pfiltro:'mov.estado_reg',type:'string'},
				id_grupo:0,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'id_usuario_ai',
				fieldLabel: '',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'mov.id_usuario_ai',type:'numeric'},
				id_grupo:0,
				grid:false,
				form:false
		},
		{
			config:{
				name: 'usr_reg',
				fieldLabel: 'Creado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'usu1.cuenta',type:'string'},
				id_grupo:0,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'fecha_reg',
				fieldLabel: 'Fecha creación',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'mov.fecha_reg',type:'date'},
				id_grupo:0,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'usuario_ai',
				fieldLabel: 'Funcionaro AI',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:300
			},
				type:'TextField',
				filters:{pfiltro:'mov.usuario_ai',type:'string'},
				id_grupo:0,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'fecha_mod',
				fieldLabel: 'Fecha Modif.',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'mov.fecha_mod',type:'date'},
				id_grupo:0,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'usr_mod',
				fieldLabel: 'Modificado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'usu2.cuenta',type:'string'},
				id_grupo:0,
				grid:true,
				form:false
		}
	],
	tam_pag:50,	
	title:'Movimiento de Activos Fijos',
	ActSave:'../../sis_kactivos_fijos/control/Movimiento/insertarMovimiento',
	ActDel:'../../sis_kactivos_fijos/control/Movimiento/eliminarMovimiento',
	ActList:'../../sis_kactivos_fijos/control/Movimiento/listarMovimiento',
	id_store:'id_movimiento',
	fields: [
		{name:'id_movimiento', type: 'numeric'},
		{name:'direccion', type: 'string'},
		{name:'fecha_hasta', type: 'date',dateFormat:'Y-m-d'},
		{name:'id_cat_movimiento', type: 'numeric'},
		{name:'fecha_mov', type: 'date',dateFormat:'Y-m-d'},
		{name:'id_depto', type: 'numeric'},
		{name:'id_proceso_wf', type: 'numeric'},
		{name:'id_estado_wf', type: 'numeric'},
		{name:'glosa', type: 'string'},
		{name:'id_funcionario', type: 'numeric'},
		{name:'estado', type: 'string'},
		{name:'id_oficina', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'num_tramite', type: 'string'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'movimiento', type: 'string'},
		{name:'cod_movimiento', type: 'string'},
		{name:'icono', type: 'string'},
		{name:'depto', type: 'string'},
		{name:'cod_depto', type: 'string'},
		{name:'id_responsable_depto', type: 'numeric'},
		{name:'id_persona', type: 'numeric'},
		{name:'responsable_depto', type: 'string'},
		{name:'custodio', type: 'string'},
		{name:'icono_estado', type: 'string'},
		{name:'codigo', type: 'string'},
		{name:'id_deposito', type: 'numeric'},
		{name:'id_depto_dest', type: 'numeric'},
		{name:'id_deposito_dest', type: 'numeric'},
		{name:'id_funcionario_dest', type: 'numeric'},
		{name:'id_movimiento_motivo', type: 'numeric'},
		{name:'deposito', type: 'string'},
		{name:'depto_dest', type: 'string'},
		{name:'deposito_dest', type: 'string'},
		{name:'funcionario_dest', type: 'string'},
		{name:'motivo', type: 'string'},
		{name:'desc_funcionario2', type: 'string'}
	],
	sortInfo:{
		field: 'id_movimiento',
		direction: 'DESC'
	},
	onButtonReport:function(){
	    var rec=this.sm.getSelected();
	    Phx.CP.loadingShow();
        Ext.Ajax.request({
            url:'../../sis_kactivos_fijos/control/Movimiento/generarReporteMovimiento',
            params:{'id_movimiento':rec.data.id_movimiento},
            success: this.successExport,
            failure: this.conexionFailure,
            timeout:this.timeout,
            scope:this
        });  
	},
	
	onButtonReportDepreciacion:function(){
	    var rec=this.sm.getSelected();
	    Phx.CP.loadingShow();
        Ext.Ajax.request({
            url:'../../sis_kactivos_fijos/control/Movimiento/generarReporteDepreciacion',
            params:{'id_movimiento':rec.data.id_movimiento, fecha_hasta: rec.data.fecha_mov},
            success: this.successExport,
            failure: this.conexionFailure,
            timeout:this.timeout,
            scope:this
        });  
	}

})
</script>
		
		