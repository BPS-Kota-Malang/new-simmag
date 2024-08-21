// Import FullCalendar core and the necessary plugins
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';

// Ensure the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var modal = document.getElementById('logbookModal');
    var eventsUrl = calendarEl.getAttribute('data-events-url');
    var createUrl = modal.getAttribute('data-events-url');
    var storeUrl = modal.getAttribute('data-store-url');

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
            console.log(info.event.title);
            // openModal(i);
        }
    })

    calendar.render();
    
    function openModal( dateTime) {
        // AJAX request to load modal content
        $.ajax({
            url: createUrl,
            type: "GET",
            data: { date: dateTime  },
            success: function(response) {
                // Load the response into the modal
                document.getElementById('modal-content').innerHTML = response;

                // Show the modal
                modal.classList.remove('hidden');

                $('#logbook-form').on('submit', function(event) {
                    event.preventDefault(); // Prevent the default form submission

                    
                    var formData = $(this).serialize(); // Serialize form data
                    
                    // var isCompleted = $('#completedCheckbox').is(':checked') ? 1 : 0;
                    // formData += '&is_completed=' + isCompleted;

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

