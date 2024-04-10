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
    // Function to make AJAX call
    function makeAjaxCall() {
        var action = 'searchRecord';
        var filters = {};

        // Loop through each checkbox and add selected filters to the object
        $('.form_check_input').each(function () {
            filters[$(this).attr('id')] = $(this).is(':checked');
        });

        // Get selected salary range values
        var salaryFrom = $('#salaryFrom').val();
        var salaryTo = $('#salaryTo').val();

        // Add salary range filters to the object
        filters['salaryFrom'] = salaryFrom;
        filters['salaryTo'] = salaryTo;

        // Making an AJAX request
        $.ajax({
            url: "action.php", 
            method: "POST",
            data: { action: action, filters: filters }, // Data to be sent with the request
            success: function (data) {
                // Function to handle successful response
                $(".tab-content").html(data);                 
            },
            error: function (xhr, status, error) {
                // Function to handle errors
                console.error(xhr.responseText); 
            }
        });
    }

    // Call the AJAX function initially
    makeAjaxCall();

    // Call the AJAX function whenever the checkbox state changes
    $('.form_check_input').change(function () {
        makeAjaxCall();
    });

    // Call the AJAX function whenever the salary range changes
    $('#salaryFrom, #salaryTo').change(function () {
        makeAjaxCall();
    });
});
