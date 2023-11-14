function initTelInput(ElId){
    const input = document.querySelector("[data-phone-input-id="+ ElId + "]");
    const intlTelInput = window.intlTelInputGlobals.getInstance(input);

    intlTelInput.setNumber($("#"+ ElId).val());
}

function resetTelInput(ElId){
    $("[data-phone-input-id="+ ElId + "]").val('');
}
