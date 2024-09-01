// Import FullCalendar core and the necessary plugins
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';

// Ensure the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function() {

    
    
    var calendarEl = document.getElementById('calendar');
    var internUrl = calendarEl.getAttribute('data-intern-url');
    var divisionUrl = calendarEl.getAttribute('data-division-url');
    var modal = document.getElementById('logbookModal');
    var eventsUrl = calendarEl.getAttribute('data-events-url');
    var createUrl = modal.getAttribute('data-events-url');
    var updateUrlBase = modal.getAttribute('data-patch-url');
    var storeUrl = modal.getAttribute('data-store-url');
    var eventEditUrlBase = modal.getAttribute('data-event-edit-url');
    
    // Fetch intern options via AJAX
    $.ajax({
        url: internUrl, // Replace with your actual endpoint to fetch interns
        method: 'GET',
        success: function(data) {
            console.log('Response Data:', data)
            var internFilter = document.getElementById('internFilter');
            internFilter.innerHTML = ''; // Clear current options
            data.forEach(function(intern) {
                var option = document.createElement('option');
                option.value = intern.id;
                option.textContent = intern.name;
                internFilter.appendChild(option);
            });
        },
        error: function() {
            console.error('Failed to load interns');
        }
    });

    // Fetch Division options via AJAX
    $.ajax({
        url: internUrl, // Replace with your actual endpoint to fetch interns
        method: 'GET',
        success: function(data) {
            console.log('Response Data:', data)
            var internFilter = document.getElementById('internFilter');
            internFilter.innerHTML = ''; // Clear current options
            data.forEach(function(intern) {
                var option = document.createElement('option');
                option.value = intern.id;
                option.textContent = intern.name;
                internFilter.appendChild(option);
            });
        },
        error: function() {
            console.error('Failed to load interns');
        }
    });


    const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
        initialView: 'timeGridWeek',
        eventColor: '#3788d8',
        selectable: true, 
        headerToolbar: {
            left: 'prev,next',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay' // user can switch between the two
        },
        events: function(fetchInfo, successCallback, failureCallback) {
            $.ajax({
                url: eventsUrl,
                data: {
                    start: fetchInfo.startStr,
                    end: fetchInfo.endStr
                },
                success: function(response) {
                    successCallback(response);
                },
                error: function(xhr) {
                    // Check if the response is in JSON format and contains the expected properties
                    let errorMessage = 'An error occurred';
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.message) {
                            errorMessage = response.message;
                        } else if (response.error) {
                            errorMessage = response.error;
                        }
                    } catch (e) {
                        errorMessage = xhr.statusText || errorMessage;
                    }

                    // Call the failureCallback with the error message
                    failureCallback({ message: errorMessage });
                }
            });
        },
        select: function(info) {
            if (calendar.view.type === 'timeGridWeek') {
                // console.log('Selected start: ' + info.startStr);
                // console.log('Selected end: ' + info.endStr);
                openModal(info.startStr);
            }
        },
        dateClick: function (info){
                console.log("date:". info);
                openModal(info.dateStr);
        },
        eventClick : function (info){
            var event = info.event;
            console.log(event);
            // console.log(event.start.toLocaleTimeString());
            // console.log(start_time);


            var editUrl = `${eventEditUrlBase}/${event.id}/edit`;
            var patchUrl = `${updateUrlBase}/${event.id}`;
            $.ajax({
                url : editUrl,
                type : "GET",
                success : function (response) {
                    console.log(response);
                    // Load the response into the modal
                    // document.getElementById('modal-content').innerHTML = response;
                    // If response is an element (e.g., a textarea element)
                    if (response instanceof HTMLElement) {
                        document.getElementById('modal-content').innerHTML = response.innerHTML;
                    } else {
                        document.getElementById('modal-content').innerHTML = response;
}
                    // Show the modal
                    modal.classList.remove('hidden');
                    document.getElementById('delete-event').classList.remove('hidden');

                    $('#logbook-form').on('submit', function(event) {
                        event.preventDefault(); // Prevent the default form submission
    
                        
                        var formData = $(this).serialize(); // Serialize form data
                        
                        var isCompletedCheckbox = $('#completedCheckbox');
                        console.log('Checkbox Element:', isCompletedCheckbox);
                        
                        var isCompleted = isCompletedCheckbox.is(':checked') ? 1 : 0;
                        formData += '&is_completed=' + isCompleted;
    
                        $.ajax({
                            url: patchUrl,
                            type: 'PATCH',
                            data: formData,
                            success: function(response) {
                                if (response.errors) {
                                    // Handle validation errors
                                    console.log(response.errors);
                                    // Display errors in the modal or elsewhere
                                } else if (response.success) {
                                    // Handle successful submission
                                    console.log(response.success);
                                    // Close the modal and/or update the UI as needed
                                    $('#logbookModal').addClass('hidden');
                                    calendar.refetchEvents();
                                }
                            },
                            error: function(xhr) {
                                console.error('Error:', xhr.responseText);
                            }
                        });
                    });

                    // Handle the delete button click event
            $('#delete-event').off('click').on('click', function() {
                var deleteUrl = `${eventEditUrlBase}/${event.id}`;
                if (confirm('Are you sure you want to delete this event?')) {
                    $.ajax({
                        url: deleteUrl, // Replace with your actual delete endpoint
                        type: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token for security
                        },
                        success: function(response) {
                            if (response.success) {
                                // Remove the event from the calendar
                                event.remove();
                                document.getElementById('logbookModal').classList.add('hidden');
                                calendar.refetchEvents(); // Hide the modal
                            } else {
                                alert('Failed to delete the event. Please try again.');
                            }
                        },
                        error: function(xhr) {
                            console.error('Error:', xhr.responseText);
                        }
                    });
                }
            });
                },
                
            })
        }
    })

    calendar.render();
    
    function openModal(dateTime) {
        // AJAX request to load modal content
        $.ajax({
            url: createUrl,
            type: "GET",
            data: { date: dateTime  },
            success: function(response) {
                // console.log('Response:', response);
                // Load the response into the modal
                document.getElementById('modal-content').innerHTML = response;

                // Show the modal
                modal.classList.remove('hidden');
                // Show the delete button since this is an edit

                $('#logbook-form').on('submit', function(event) {
                    event.preventDefault(); // Prevent the default form submission

                    
                    var formData = $(this).serialize(); // Serialize form data
                    
                    var isCompletedCheckbox = $('#completedCheckbox');
                        console.log('Checkbox Element:', isCompletedCheckbox);
                        
                    var isCompleted = isCompletedCheckbox.is(':checked') ? 1 : 0;
                    formData += '&is_completed=' + isCompleted;

                    $.ajax({
                        url: storeUrl,
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            if (response.errors) {
                                // Handle validation errors
                                console.log(response.errors);
                                // Display errors in the modal or elsewhere
                            } else if (response.success) {
                                // Handle successful submission
                                console.log(response.success);
                                // Close the modal and/or update the UI as needed
                                $('#logbookModal').addClass('hidden');
                                calendar.refetchEvents();
                            }
                        },
                        error: function(xhr) {
                            console.error('Error:', xhr.responseText);
                        }
                    });
                });
            },
            error: function(xhr) {
                alert('Failed to load the modal. Please try again.');
            }
        });
    }

    // Optionally, close the modal when clicking outside the modal content
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.classList.add('hidden');
        }
    });
  });

