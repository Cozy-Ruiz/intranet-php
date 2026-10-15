// JavaScript Document
$(this.document).ready(function(e) {
	$("#radar_reloj").hide();
		$("#radar_lupa").hide();
		$("#radar_tablero").hide();
		$("#radar_tools").hide();
		
	function ocultar(){
		$("#radar_reloj").hide();
		$("#radar_lupa").hide();
		$("#radar_tablero").hide();
		$("#radar_tools").hide();
		
	}
	
	ocultar();
	
	var menu=$("ul.lista_menu a");
    menu.click(function(){
			
			if($($(this).attr("name")).is(":visible")){
					$($(this).attr("name")).hide("blind",500);
				
			}else{
				ocultar();
			
			$($(this).attr("name")).show("blind",500);
			}
	
	});
		
		
		
		
		
		/*	$($(this).attr("name")).stop(false,true);
			
		$($(this).attr("name")).show("blind",500);
		
	},function(){
			$($(this).attr("name")).stop(false,true);
		//hideOptions($(this));
		$($(this).attr("name")).hide("blind",500);
	});*/
	/*
	var menu=$("ul.lista_menu a");
    menu.click(function(){
		$($(this).attr("name")).stop(false,true);
		$($(this).attr("name")).show("blind",500);
		//displayOptions($(this).eq());
		
		
	});
	
	menu(function(){
		$($(this).attr("name")).stop(false,true);
		//hideOptions($(this));
		$($(this).attr("name")).hide("drop",500);
	});
	
	function displayOptions(e){  
    e.show();  
}  
//funcion que OCULTA los elementos del menu  
function hideOptions(e){  
    e.find("li").hide();  
    e.find("li.active").show();  
}  
	*/
	
	
});