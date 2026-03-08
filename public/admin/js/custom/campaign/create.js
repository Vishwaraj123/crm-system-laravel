// Define the countContact function
function countContact(url, data) {
    axios.get(url, {
        params: data
    })
    .then(response => {
        let total = response.data;
        $('#total-display').text(total);
    })
    .catch(error => {
        toastr.error(error.message);
    });
}
$(document).ready(function() {
    let contact_list_id = $('#contact_list_id').val();
    let segment_id = $('#segment_id').val();
    let country_id = $('#country_id').val();
    let pipeline_id = $('#pipeline_id').val();
    let stage_id = $('#stage_id').val();
    let data = {
        contact_list_id: contact_list_id,
        segment_id: segment_id,
        country_id: country_id,
        pipeline_id: pipeline_id,
        stage_id: stage_id
    };
    countContact(contact_count_url, data);
});
$('#contact_list_id, #segment_id, #country_id, #pipeline_id,#stage_id').on('change', function(e) {
    let contact_list_id = $('#contact_list_id').val();
    let segment_id = $('#segment_id').val();
    let country_id = $('#country_id').val();
    let pipeline_id = $('#pipeline_id').val();
    let stage_id = $('#stage_id').val();
    let data = {
        contact_list_id: contact_list_id,
        segment_id: segment_id,
        country_id: country_id,
        pipeline_id: pipeline_id,
        stage_id: stage_id
    };
    countContact(contact_count_url, data);
});
