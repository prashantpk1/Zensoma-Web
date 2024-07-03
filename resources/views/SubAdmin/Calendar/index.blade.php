@extends('Admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Calender Basic</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">
                                <svg class="stroke-icon">
                                    <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                </svg></a></li>
                        {{-- <li class="breadcrumb-item active">Calender</li> --}}

                        <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"
                            data-bs-target="#addslot"><i class="fa fa-plus" aria-hidden="true"></i> Add
                            New</button>

                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid calendar-basic">
        <div class="card">
            <div class="card-body">
                <div class="row" id="wrap">
                    <div class="col-xxl-0 box-col-12 d-none">
                        <div class="md-sidebar-aside job-left-aside custom-scrollbar">
                            <div id="external-events">
                                <div id="external-events-list">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-12 box-col-12">
                    <div class="calendar-default" id="calendar-container">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    <!----  check new model ---->
    <div class="modal fade modal-bookmark" id="addslot" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        @include('SubAdmin.Calendar.createslot')
    </div>
    <!-----  end check nem model --->

    <!-- Container-fluid Ends-->
@endsection

@section('script')
    <script>
        (function() {
            document.addEventListener("DOMContentLoaded", function() {
                /* initialize the external events
                  -----------------------------------------------------------------*/

                var containerEl = document.getElementById("external-events-list");
                new FullCalendar.Draggable(containerEl, {
                    itemSelector: ".fc-event",
                    eventData: function(eventEl) {
                        return {
                            title: eventEl.innerText.trim(),
                        };
                    },
                });


                var calendarEl = document.getElementById("calendar");
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    headerToolbar: {
                        left: "prev,next today",
                        center: "title",
                        right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek",
                    },
                    initialView: "dayGridMonth",
                    initialDate: "{{ $formattedDate }}",
                    navLinks: true, // can click day/week names to navigate views
                    editable: true,
                    selectable: true,
                    nowIndicator: true,
                    // dayMaxEvents: true, // allow "more" link when too many events
                    events: [
                        @foreach ($data as $date)
                            {
                                title: "{{ $date['title'] }}",
                                start: "{{ $date['date'] }}",
                            },
                        @endforeach
                    ],
                    dateClick: function(info) {

                        const currentDate = new Date();
                        const year = currentDate.getFullYear();
                        const month = String(currentDate.getMonth() + 1).padStart(2, '0');
                        const day = String(currentDate.getDate()).padStart(2, '0');
                        const formattedDate = `${year}-${month}-${day}`;



                        var clickedDate = info.date;

                        // Convert the date to a string or use it as needed
                        var dateString = clickedDate.toISOString();

                        var dateOnly = dateString.split('T')[0];

                        var dateObject = new Date(dateOnly);

                        // Add one day
                        dateObject.setDate(dateObject.getDate() + 1);

                        // Get the updated date in ISO format
                        var updatedDateString = dateObject.toISOString().split('T')[0];

                        if (formattedDate <= updatedDateString) {

                            //open model
                            $("#multiple-date-custom").val("");

                            $("#multiple-date-custom").val(updatedDateString);

                            $('#addslot').modal('show');
                            //open model end

                        } else {
                            show_toster("For previous date you are not able to add slot")
                        }





                    },
                    editable: true,
                    droppable: true, // this allows things to be dropped onto the calendar
                    drop: function(arg) {
                        // is the "remove after drop" checkbox checked?
                        if (document.getElementById("drop-remove").checked) {
                            // if so, remove the element from the "Draggable Events" list
                            arg.draggedEl.parentNode.removeChild(arg.draggedEl);
                        }
                    },
                });
                calendar.render();
            });
        })();



        $(document).ready(function() {

            //add slot submit
            $("#slot-frm").submit(function(event) {
                event.preventDefault();


                // for button
                jQuery('.btn-custom').addClass('disabled');
                jQuery('.icon').removeClass('d-none');

                var frm = this;
                var method = "POST";
                var url = $(this).attr('action');
                var formData = new FormData(frm);
                    $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    processData: false,
                    contentType: false,
                        success: function(response) {

                                    show_toster(response.success)
                                    $("#is_close").click();
                                    location.reload();
                                    frm.reset();


                                    // for button
                                    jQuery('.btn-custom').removeClass('disabled');
                                    jQuery('.icon').addClass('d-none');

                        },

                    error: function(xhr) {
                        var errors = xhr.responseJSON;
                        $.each(errors.errors, function(key, value) {
                            console.log(key);
                            var ele = "#" + key;
                            toastr.error(value);
                        });
                         // for button
                         jQuery('.btn-custom').removeClass('disabled');
                         jQuery('.icon').addClass('d-none');


                    },


                });



            });
            //add slot submit end





        });
    </script>
@endsection
