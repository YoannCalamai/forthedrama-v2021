$(function() {
    $('#adresse_departement').on('change', function(){
        $("#adresse_region").val( $(this).find(':selected').attr('data-region'));
    })
    $('#departement_29').on('change', function(){
        $("#region_30").val( $(this).find(':selected').attr('data-region'));
    })
});