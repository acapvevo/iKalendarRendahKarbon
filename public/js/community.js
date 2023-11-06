

$('#community_identification_number').mask('000000d00d0000', {
    translation: {
        0: {
            pattern: /[0-9]/
        },
        d: {
            pattern: /[-]/,
            fallback: '-'
        }
    }
});
