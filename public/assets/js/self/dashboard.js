$(document).ready(function () {
    function filterEvents(title) {
        calendar.getEvents().forEach(function (event) {
            if (
                title === "" ||
                event.title.toLowerCase().includes(title.toLowerCase())
            ) {
                event.setProp("display", "auto");
            } else {
                event.setProp("display", "none");
            }
        });
    }

    function handleFilterChange(event) {
        var title = event.target.value;
        filterEvents(title);
    }

    var calendarEl = document.getElementById("kt_docs_fullcalendar_selectable");

    var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "filterDropdown dayGridMonth,timeGridWeek,timeGridDay",
        },
        customButtons: {
            filterDropdown: {
                text: "Filter",
                click: function () {
                    var filterDropdown =
                        document.querySelector(".filter-dropdown");
                    if (!filterDropdown) {
                        filterDropdown = document.createElement("select");
                        filterDropdown.classList.add(
                            "form-select",
                            "filter-dropdown"
                        );
                        filterDropdown.dataset.control = "select2";
                        filterDropdown.addEventListener(
                            "change",
                            handleFilterChange
                        );

                        // Populate the dropdown options
                        var allOption = document.createElement("option");
                        allOption.value = "";
                        allOption.text = "All";
                        filterDropdown.appendChild(allOption);

                        calendar.getEvents().forEach(function (event) {
                            var option = document.createElement("option");
                            option.value = event.title;
                            option.text = event.title;
                            filterDropdown.appendChild(option);
                        });

                        var calendarHeader =
                            calendarEl.querySelector(".fc-header-toolbar");
                        calendarHeader.appendChild(filterDropdown);
                    }
                },
            },
        },

        initialDate: new Date(),
        navLinks: true, // can click day/week names to navigate views
        selectable: true,
        selectMirror: true,

        // Create new event
        select: function (arg) {
            $.ajax({
                url: "/nurses_list", // Update the URL to match your Laravel route
                type: "GET",
                dataType: "json",
                success: function (response) {
                    var dropdownOptions = "";
                    response.forEach(function (nurse) {
                        dropdownOptions +=
                            '<option value="' +
                            nurse.name +
                            '">' +
                            nurse.name +
                            "</option>";
                    });

                    Swal.fire({
                        html:
                            '<div class="mb-5">Select Nurse:</div><select class="form-select" name="event_name" id="event-name">' +
                            dropdownOptions +
                            "</select>" +
                            '<div class="mb-5">Availability:</div>' +
                     '<input type="radio" name="availability" value="available"> Available' +
                     '<input type="radio" name="availability" value="unavailable"> Unavailable',
                        icon: "info",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "Yes, create it!",
                        cancelButtonText: "No, return",
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: "btn btn-active-light",
                        },
                    }).then(function (result) {
                        if (result.value) {
                            var selectElement = document.querySelector(
                                'select[name="event_name"]'
                            );
                            var selectedOption =
                                selectElement.options[
                                    selectElement.selectedIndex
                                ];
                            var title = selectedOption.value;
                            var backgroundColor;
                            var availability = getSelectedAvailability();
                    if (availability === 'available') {
                        backgroundColor = '#3db5a4'; // Set color for available nurse
                    } else if (availability === 'unavailable') {
                        backgroundColor = '#e66465'; // Set color for unavailable nurse
                    }
                            if (title) {
                                var eventData = {
                                    title: title,
                                    start: arg.start,
                                    end: arg.end,
                                    backgroundColor: backgroundColor ,
                                };
                                
                                saveEventToDatabase(eventData);
                            }
                            calendar.unselect();
                        } else if (result.dismiss === "cancel") {
                            Swal.fire({
                                text: "Date creation was declined!.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary",
                                },
                            });
                        }
                    });
                },
            });
        },

        // Delete event
        eventClick: function (arg) {
            Swal.fire({
                text: "Are you sure you want to delete?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, return",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light",
                },
            }).then(function (result) {
                if (result.value) {
                    // Send a DELETE request to the server
                    fetch("/delete_cal/" + arg.event.title, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": window.csrfToken,
                            "Content-Type": "application/json",
                            Accept: "application/json",
                        },
                    })
                        .then(function (response) {
                            if (response.ok) {
                                // Remove the event from the calendar after successful deletion
                                arg.event.remove();
                                Swal.fire({
                                    text: "Event deleted successfully!",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary",
                                    },
                                });
                            } else {
                                console.error("Error deleting event");
                            }
                        })
                        .catch(function (error) {
                            console.error("Error deleting event:", error);
                        });
                } else if (result.dismiss === "cancel") {
                    Swal.fire({
                        text: "Date was not deleted!",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        },
                    });
                }
            });
        },
        editable: true,
        dayMaxEvents: true, // allow "more" link when too many events
        events: "/get_dates_cal",
    });


    function getSelectedAvailability() {
        var radioButtons = document.getElementsByName('availability');
    
        for (var i = 0; i < radioButtons.length; i++) {
            if (radioButtons[i].checked) {
                return radioButtons[i].value;
            }
        }
    
        return null; // Return null if no radio button is selected
    }

    // Function to save the event data to the database
    function saveEventToDatabase(eventData) {
        // Make an AJAX request to your server-side code to store the eventData in the database
        // You can use libraries like jQuery or fetch to make the AJAX request
        // Example using jQuery.ajax:
        $.ajax({
            url: "/save-cal-event",
            method: "POST",
            data: eventData,
            success: function (data) {
                if (data.errors) {
                    $.each(data.errors, function (field, error) {
                        $("." + field + "-error").text(error[0]);
                    });

                    $("#kt_sign_in_submit").attr("data-kt-indicator", "off");
                    $("#kt_sign_in_submit").attr("disabled", false);
                } else if (data.logginError) {
                    toastr.error("Error", data.logginError);
                    $("#kt_sign_in_submit").attr("data-kt-indicator", "off");
                    $("#kt_sign_in_submit").attr("disabled", false);
                } else if (data.success) {
                    toastr.success("Successful", data.success);
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                }
            },
            error: function (error) {
                // Handle any errors that occur during the AJAX request
                console.error("Error saving event:", error);
            },
        });
    }

    calendar.render();

    $(document).on("submit", "#frmSearchLocationRN", function () {
        var formData = new FormData(this);

        $.ajax({
            type: "post",
            url: "search_area_rn",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $("#kt_sign_in_submit").attr("data-kt-indicator", "on");
                $("#kt_sign_in_submit").attr("disabled", true);
            },
            success: function (data) {
                if (data.errors) {
                    $.each(data.errors, function (field, error) {
                        $("." + field + "-error").text(error[0]);
                    });

                    $("#kt_sign_in_submit").attr("data-kt-indicator", "off");
                    $("#kt_sign_in_submit").attr("disabled", false);
                } else if (data.logginError) {
                    toastr.error("Error", data.logginError);
                    $("#kt_sign_in_submit").attr("data-kt-indicator", "off");
                    $("#kt_sign_in_submit").attr("disabled", false);
                } else {
                    $("#tblResult").html(data);
                    $("#kt_sign_in_submit").attr("data-kt-indicator", "off");
                    $("#kt_sign_in_submit").attr("disabled", false);
                }
            },
        });
    });
});
