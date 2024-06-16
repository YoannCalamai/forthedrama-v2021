$(function() {




    $('body').on('click', '.button-delete', function (e) {
        e.preventDefault();
        var form = $(this).parents('form');
        swal({
            title: "Etes-vous sûr?",
            text: "Cet élément sera supprimé si vous confirmez",
            icon: "warning",
            buttons: [
                'Annuler',
                'Oui, supprimer'
            ],
            dangerMode: true,

        }).then( function(willDelete)  {
            if (willDelete == true) {
                form.submit();
            } else {

            }
        });
    });
    $('body').on('click', '.button-restore', function (e) {
        e.preventDefault();
        var form = $(this).parents('form');
        swal({
            title: "Etes-vous sûr?",
            text: "Cet élément sera restauré si vous confirmez",
            icon: "warning",
            buttons: [
                'Annuler',
                'Oui, restaurer'
            ],
            dangerMode: true,

        }).then( function(willDelete)  {
            if (willDelete == true) {
                form.submit();
            } else {

            }
        });
    });

    $('body').on('click', '.button-logout', function (e) {
        e.preventDefault();
        var form = $('#logout-form');
        swal({
            title: "Etes-vous sûr ?",
            text: "Merci de confirmer votre déconnexion",
            icon: "warning",
            buttons: [
                'Annuler',
                'Oui, me déconnecter'
            ],
            dangerMode: true,
        }).then( function(willDelete)  {
            if (willDelete == true) {
                form.submit();
            }
        });
    });

    $('.maxlength').maxlength({
        alwaysShow: true
    });

    $('.telephone').mask('99.99.99.99.99');

    $('.control-telephone').on('change', function(event){
        var input = $(this).val();
        var numberOfWords = input.split('.').length;
        console.log(numberOfWords );
        if(numberOfWords < 5 )
        {
            swal({
                title: 'Numéro de téléphone incorrect',
                text: "Merci de renseigner correctement le champ numéro de téléphone",
                type: 'error',
            });
            $(this).focus();
            return;
        }
    });


    $.datepicker.regional['fr'] = {clearText: 'Effacer', clearStatus: '',
        closeText: 'Fermer', closeStatus: 'Fermer sans modifier',
        prevText: '&lt;Préc', prevStatus: 'Voir le mois précédent',
        nextText: 'Suiv&gt;', nextStatus: 'Voir le mois suivant',
        currentText: 'Courant', currentStatus: 'Voir le mois courant',
        monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin',
            'Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
        monthNamesShort: ['Jan','Fév','Mar','Avr','Mai','Jun',
            'Jul','Aoû','Sep','Oct','Nov','Déc'],
        monthStatus: 'Voir un autre mois', yearStatus: 'Voir un autre année',
        weekHeader: 'Sm', weekStatus: '',
        dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
        dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
        dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
        dayStatus: 'Utiliser DD comme premier jour de la semaine', dateStatus: 'Choisir le DD, MM d',
        dateFormat: 'dd/mm/yy', firstDay: 0,
        initStatus: 'Choisir la date', isRTL: false};
    $.datepicker.setDefaults($.datepicker.regional['fr']);
    $(".date").datepicker().mask("99/99/9999");
    $(".date").keyup(function(e){
        if(46==e.keyCode || 8==e.keyCode || 9==e.keyCode){
            var $this = $(this);
            if($this.val() == "__/__/____")
                $this.val("");
        }
    });



});
