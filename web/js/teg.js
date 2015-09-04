<script type="text/javascript">
    // realiza un seguimiento de cuántos campos de autores y palabras clave se han pintado
    var palabraCount = '{{ form.palabrasClave | length }}';
    var autoresCount = '{{ form.autores | length }}';

    jQuery(document).ready(function() {
        jQuery('#other-autor').click(
        	function() {
            alert("hola");
        		if(autoresCount < 2)
        		{
		            var autorList = jQuery('#autor-fields-list');
					var newWidget = autorList.attr('data-prototype');
		           	newWidget = newWidget.replace("__name__", autoresCount);
		            newWidget = newWidget.replace("__name__", autoresCount);
		            autoresCount++;

		            // crea un nuevo elemento lista y lo añade a la lista
		            var newLi = jQuery('<li id="2"></li>').html(newWidget);
		            newLi.appendTo(jQuery('#autor-fields-list'));
		            //cambiar nombre de etiqueta
		            $("#other-autor").text("Quitar Autor");
		            
		        }
		        else
		        {
		            autoresCount--;
		            $('#autor-fields-list #2').remove();
		           	
		           	//cambiar nombre de etiqueta
		            $("#other-autor").text("Agregar Autor");
		        }

	            return false;
	        }
	    );



	    jQuery('#add-another-word').click(
        	function() {
        
	            var palabraList = jQuery('#word-fields-list');
				var newWidget = palabraList.attr('data-prototype');
	           	newWidget = newWidget.replace("__name__", palabraCount);
	            newWidget = newWidget.replace("__name__", palabraCount);
	            palabraCount++;

	            // crea un nuevo elemento lista y lo añade a la lista
	            var newLi = jQuery('<li></li>').html(newWidget);
	            newLi.appendTo(jQuery('#word-fields-list'));

	            return false;
	        }
	    );
    })
</script>