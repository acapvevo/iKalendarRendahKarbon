function initSelectionCommunity(elId, modalId, url, locale, changeFunc){
    $(elId).select2({
        theme: 'bootstrap-5',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        ajax: {
            transport: function(params, success, failure) {
                axios({
                        method: 'get',
                        url: params.url,
                        params: params.data
                    })
                    .then(success)
                    .catch(failure)
            },
            url: url,
            dataType: 'json',
            delay: 250,
            cache: true,
            processResults: function(response) {
                return {
                    results: response.data.results,
                    pagination: response.data.pagination
                };
            },
        },
        templateResult: formatCommunityResult,
        templateSelection: formatCommunitySelection,
        allowClear: true,
        dropdownParent: $(modalId),
        matcher: formatCommunityMatcher,
        language: locale,
        minimumInputLength: 3,
    });

    $(elId).on('change', changeFunc);
}

function formatCommunityMatcher(params, data) {
    // If there are no search terms, return all of the data
    if ($.trim(params.term) === '') {
        return data;
    }

    // `params.term` should be the term that is used for searching
    // `data.text` is the text that is displayed for the data object
    if ((data.name.indexOf(params.term) > -1) || (data.username.indexOf(params.term) > -1)) {
        return data;
    }

    // Return `null` if the term should not be displayed
    return null;
}

function formatCommunitySelection(community) {
    return community.name != null ? community.name.toUpperCase() : community.username.toUpperCase();
}

function formatCommunityResult(community) {
    if (community.loading) {
        return community.text;
    }

    var image = imageDefault;
    if (community.image != null)
        image = communityPictureUrl + community.id;

    var name = community.username.toUpperCase();
    if (community.name != null)
        name = community.name.toUpperCase();

    var address = '<p></p>';
    if (community.address.line_1 && community.address.line_2 && community.address.postcode && community.address
        .city)
        address = `<p>
            ` + community.address.line_1 + `<br/>` +
        community.address.line_2 + `<br/>` +
        community.address.line_3 + `<br/>` +
        community.address.postcode + ` ` + community.address.city + `<br/>` +
        community.address.state + ` ` + community.address.country + `
        </p>`

    return $(
        `<div class="row">
            <div class="col-lg-3 d-flex justify-content-center align-items-center">
                <img width="50%" height="50%" class='img-fluid rounded-circle float-start' src='` +
        image + `' />
            </div>
            <div class="col-lg-9">
                <h6 class='py-3'><strong>` + name + `</strong></h6>
                ` + address + `
            </div>
        </div>`
    );
}
