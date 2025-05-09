/**
 * Buchstabenkonfigurator - Admin 
 */
(function($) {
    'use strict';
    
    console.log('Admin script loaded!');
    
    // Funktion zum Aktualisieren der Buchstabenvorschau
    function updateLetterPreview() {
        var letter = $('#bk_letter').val() || 'A';
        var color = $('#bk_color').val() || '#4a6da7';
        var material = $('#bk_material').val();
        
        console.log('Updating preview:', letter, color, material);
        
        // Buchstabe aktualisieren
        $('.bk-letter-preview').text(letter);
        
        // Farbe aktualisieren
        $('.bk-letter-preview').css('color', color);
        
        // Material-Effekt aktualisieren
        if (material === 'glanzend') {
            $('.bk-letter-preview').addClass('glanzend-effect');
        } else {
            $('.bk-letter-preview').removeClass('glanzend-effect');
        }
    }
    
    // Dokument bereit
    $(document).ready(function() {
        console.log('Document ready!');
        
        // Event-Listener für Farbfamilien-Auswahl mit Delegierung
        $(document).on('change', '#color-family-select', function() {
            console.log('Color family changed:', $(this).val());
            var selectedFamily = $(this).val();
            $('.color-palette').hide();
            $('.color-palette[data-family="' + selectedFamily + '"]').show();
        });
        
        // Event-Listener für Farboptionen mit Delegierung
        $(document).on('click', '.color-option', function() {
            console.log('Color option clicked');
            var color = $(this).data('color');
            console.log('Selected color:', color);
            
            // Farbe in das Hidden-Feld schreiben
            $('#bk_color').val(color);
            
            // UI aktualisieren
            $('.color-option').removeClass('active');
            $(this).addClass('active');
            $('.selected-color-info .color-preview').css('background-color', color);
            $('.selected-color-info .color-code').text(color);
            
            // Vorschau aktualisieren
            updateLetterPreview();
        });
        
        // Event-Listener für das Buchstabenfeld mit Delegierung
        $(document).on('input', '#bk_letter', function() {
            console.log('Letter input changed:', $(this).val());
            // Nur ein Buchstabe erlaubt (A-Z)
            var value = $(this).val().toUpperCase();
            if (value.length > 0) {
                value = value.match(/[A-Z]/) ? value.match(/[A-Z]/)[0] : 'A';
            }
            $(this).val(value);
            
            // Vorschau aktualisieren
            updateLetterPreview();
        });
        
        // Event-Listener für das Material-Dropdown mit Delegierung
        $(document).on('change', '#bk_material', function() {
            console.log('Material changed:', $(this).val());
            updateLetterPreview();
        });
        
        // Initiale Vorschau aktualisieren
        updateLetterPreview();
    });
})(jQuery);