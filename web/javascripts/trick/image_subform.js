$(function(){

    /* 1. Le code ci-dessous permet d'insérer une nouvelle instance de ImageType au sein de TrickType */

    var $imagesContainer = $('#appbundle_trick_trick_images');
    var _prototype = $imagesContainer.data('prototype');
    var $btnAddImage = $('button.add-image');
    var $btnRemoveImage = $('<button class="remove-image btn btn-link btn-sm btn-block">Retirer</button>');

        /* 1.1 Ajouter un sous-formulaire image */
        $btnAddImage.click(function(){

            var imageTypeId = uniqid();
            var prototype = _prototype;
                prototype = $(_prototype.replace(/_FORM_TRICK_IMAGE_/g, imageTypeId));
                prototype.addClass('imageType').append( $btnRemoveImage.clone(true) );


            $imagesContainer.append( prototype );
            $(prototype).find('input[type=file]').click();

            return false;

        });

        /* 1.2 Retirer un sous formulaire */
        $btnRemoveImage.click(function(){

            $(this).parents('div.imageType').remove();

            return false;

        });

        /* 1.3 Retirer une image existante */
        $('button.remove-existing-image').click(function(){

            if(confirm("Confirmez-vous la suppression de cette image ?"))
            {
                $(this).parents('div.image').remove();
            }

            return false;

        });

    /** 1. Fin **/

})