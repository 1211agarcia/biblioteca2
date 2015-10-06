$("[name='biblioteca_tegbundle_teg[published]']").bootstrapSwitch();
	
$('#biblioteca_tegbundle_teg_capitulos_0_file').fileinput({
    language: 'es',
    uploadUrl: '#',
    allowedFileExtensions : ['pdf'],
    showUpload: false,

});

jQuery(document).ready(function() {

    // realiza un seguimiento de cuántos campos de autores y palabras clave se han pintado
    var wordsCount = '{{ form.palabrasClave | length }}';
    var autoresCount = '{{ form.autores | length }}';

    $('#other-autor').click(
        function() {
            if(autoresCount == 1)
            {
                /* Get Object List Autor */
                var autorList = jQuery('#autor-fields-list');
                /* Get prototype li */
                var newWidget = autorList.attr('data-prototype');

                newWidget = newWidget.replace("__name__", autoresCount);
                newWidget = newWidget.replace("__name__", autoresCount);
                autoresCount++;

                // Crea un nuevo elemento lista
                var newLi = jQuery('<li id="2" class="input-group"></li>').html(newWidget);
                // El elemento lo añade a la lista
                newLi.appendTo(autorList);
                //cambiar nombre de etiqueta
                $("#other-autor").html("<span class='glyphicon glyphicon-remove-sign'></span> Quitar");
                $("#other-autor").attr("class", "input-group-addon btn btn-danger btn-sm");
                $("#other-autor").appendTo(newLi);
            }
            else
            {
                autoresCount--;
                
                //Cambiar nombre de etiqueta
                $("#other-autor").html("<span class='glyphicon glyphicon-plus-sign'></span> Agregar Autor");
                $("#other-autor").attr("class", "btn btn-success btn-sm");
                // Se mueve al ul
                $("#other-autor").appendTo("#form-autor");
                // Se remueve li 2
                $('#autor-fields-list #2').remove();
            }
            return false;
        }
    );

    $('#add-another-word').click( 
        function() {
			/* Get Object List Word */
            var wordList = jQuery('#word-fields-list');
        	
        	if(wordsCount == 3)
        	{
        		var remove_btn= jQuery('<a id="remove-word" name="remove-word"class="input-group-addon btn btn-danger btn-sm" href="#" ></a>');
        		remove_btn.html('<span class="glyphicon glyphicon-remove-sign"></span> Quitar');
        		remove_btn.click(
		  	     	function(){
		               	wordsCount--;
		            	
		                //Cambiar clase de li anterior
		                $('[id*="word-'+wordsCount+'"]').attr("class", "input-group");
		                // Se mueve al li anterior
		                $("#remove-word").appendTo($('[id*="word-'+wordsCount+'"]'));
		                // Se remueve li actual
		                $('[id*="word-'+(wordsCount+1)+'"]').remove();

		                if(wordsCount == 3)
		            	{
		            		$('#remove-word').remove();
		            	}
		            	return false;
		            }
    			);
        		remove_btn.appendTo(wordList);	
        	}
           
            /* Get prototype li */
            var newWidget = wordList.attr('data-prototype');

            newWidget = newWidget.replace("__name__", wordsCount);
            newWidget = newWidget.replace("__name__", wordsCount);
            
            // Cambia clase de li anterior

            $('[id*="word-'+wordsCount+'"]').attr("class", null);

            wordsCount++;

            // Crea un nuevo elemento lista
            var newLi = jQuery('<li id="word-'+wordsCount+'" class="input-group"></li>').html(newWidget);
            // El elemento lo añade a la lista
            newLi.appendTo(wordList);

            //Mover boton de quitar a nuevo objeto li
            $("#remove-word").appendTo(newLi);
            
            return false;
        }
    );

    // Generar Cota
    $('#biblioteca_tegbundle_teg_publicacion_year,#biblioteca_tegbundle_teg_escuela,#biblioteca_tegbundle_teg_cota_index').change(function(){
    
        if($('#biblioteca_tegbundle_teg_publicacion_year').val() == 0)
        {
            var prev_cota_year = "[Año de Publicación]";
        }
        else
        {
            var prev_cota_year = (("0" + ($('#biblioteca_tegbundle_teg_publicacion_year').val() % 100) ).slice (-2));
        }
    
        if($('#biblioteca_tegbundle_teg_escuela').val() == 0)
        {
            var prev_cota_escuela = "[Escuela]";
        }
        else
        {
            var prev_cota_escuela = $('#biblioteca_tegbundle_teg_escuela').val().charAt(0);
        }

        if($('#biblioteca_tegbundle_teg_cota_index').val() <= 0)
        {
            var prev_cota_index = "[indice]";
        }
        else
        {
            var prev_cota_index = (("0" + $('#biblioteca_tegbundle_teg_cota_index').val()).slice (-2));
        }
        
        $('#cota_escuela').text("D"+prev_cota_escuela);
        $('#cota_year').text(prev_cota_year);

        $('#biblioteca_tegbundle_teg_cota').val("D"+prev_cota_escuela+"-"+prev_cota_index+"-"+prev_cota_year);
    });

});
