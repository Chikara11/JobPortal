document.addEventListener('DOMContentLoaded', function () {
    const slider = document.getElementById('slider');
    const counter = document.getElementById('counter');

    // Set initial value to the midpoint
    const minValue = parseInt(slider.min, 10);
    const maxValue = parseInt(slider.max, 10);
    const midpoint = Math.floor((maxValue - minValue) / 2) + minValue;
    slider.value = midpoint;
    counter.textContent = midpoint;

    // Update counter when slider value changes
    slider.addEventListener('input', function () {
        counter.textContent = slider.value;
    });
});

$(document).ready(function () {
    // Add event listeners for filter elements
    $('#salaryFrom, #salaryTo, #permanent, #temporary, #contract, #full_time, #part_time, #home_work, #agency, #employer, #slider, #IT, #construcation, #engineering, #legal, #sales, #banking, #none, #bachelor, #graduate').on('change input', fetchData);
});

function fetchData() {
    // Collect filter data
    var salaryFrom = $('#salaryFrom').val();
    var salaryTo = $('#salaryTo').val();
    var permanentChecked = $('#permanent').is(':checked');
    var temporaryChecked = $('#temporary').is(':checked');
    var contractChecked = $('#contract').is(':checked');
    var fullTimeChecked = $('#full_time').is(':checked');
    var partTimeChecked = $('#part_time').is(':checked');
    var homeWorkChecked = $('#home_work').is(':checked');
    var agencyChecked = $('#agency').is(':checked');
    var employerChecked = $('#employer').is(':checked');
    var sliderValue = $('#slider').val();
    var ITChecked = $('#IT').is(':checked');
    var constructionChecked = $('#construcation').is(':checked');
    var engineeringChecked = $('#engineering').is(':checked');
    var legalChecked = $('#legal').is(':checked');
    var salesChecked = $('#sales').is(':checked');
    var bankingChecked = $('#banking').is(':checked');
    var noneChecked = $('#none').is(':checked');
    var bachelorChecked = $('#bachelor').is(':checked');
    var graduateChecked = $('#graduate').is(':checked');

    // Make AJAX request
    $.ajax({
        url: 'jobs.php',
        method: 'POST',
        data: {
            action: 'fetchData',
            salaryFrom: salaryFrom,
            salaryTo: salaryTo,
            permanent: permanentChecked,
            temporary: temporaryChecked,
            contract: contractChecked,
            fullTime: fullTimeChecked,
            partTime: partTimeChecked,
            homeWork: homeWorkChecked,
            agency: agencyChecked,
            employer: employerChecked,
            sliderValue: sliderValue,
            IT: ITChecked,
            construction: constructionChecked,
            engineering: engineeringChecked,
            legal: legalChecked,
            sales: salesChecked,
            banking: bankingChecked,
            none: noneChecked,
            bachelor: bachelorChecked,
            graduate: graduateChecked
        },
        success: function (data) {
            var posts = JSON.parse(data); // Parse the JSON data returned from the server
            var postList = '';
            for (var i = 0; i < posts.length; i++) {
                var post = posts[i];
                // Build the HTML for each post item
                var postItem = '<div class="job-item p-4 mb-4">' +
                    '<div class="row g-4">' +
                    '<div class="col-sm-12 col-md-8 d-flex align-items-center">' +
                    // Display job details here, modify as needed
                    '</div>' +
                    '<div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">' +
                    // Display buttons and other details here, modify as needed
                    '</div>' +
                    '</div>' +
                    '</div>';
                postList += postItem;
            }
            // Update job listing with fetched data
            $('#post_list').html(postList);
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText); // Log any errors to the console
        }
    });
}

