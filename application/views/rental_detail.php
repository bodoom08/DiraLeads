<html>

<head>
    <title><?php echo isset($title) && html_escape($title) != 'Home' ? html_escape($title) . ' | ' . html_escape(CFG_TITLE) : html_escape(CFG_TITLE); ?></title>
    <!-- ================================================================ -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <!-- ================================================================ -->
    <link rel="icon" href="assets/favicon.svg" sizes="any" type="image/svg+xml">
    <link rel="icon" type="image/png" href="assets/favicon.png" />
    <!-- ================================================================ -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <!-- ========================== FullCalendar Style ====================================== -->

    <link href="<?php echo site_url('assets/css/fullcalendar.css') ?>" rel="stylesheet" />
    <!-- ========================== Custom Style ====================================== -->
    <link rel="stylesheet" href="<?php echo site_url('assets/css/properties.css') ?>">
    </link>
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/css/styles.css') ?>">
    </link>


    <style>
        .fc-content-skeleton tbody tr:first-child {
            height: unset;
        }

        .fc-content-skeleton tbody tr {
            height: 20px;
        }
    </style>
    <!-- ====================================== Script ========================================== -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="<?php echo site_url('assets/js/moment.min.js') ?>"></script>
    <!-- ========================== Full Calendar ========================================== -->
    <script src='<?php echo site_url('assets/js/fullcalendar.js'); ?>'></script>
    <!-- <link rel="stylesheet" href="<?php echo site_url('assets/fullcalendar/main.css') ?>">
    </link>
    <script src="<?php echo site_url('assets/fullcalendar/main.js') ?>"></script> -->
    <!-- ========================== Google Map Scripts ================================= -->
    <!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPhDpAUyER52TsCsLFNOOxT_l5-y7e78A&libraries=places&callback=initMap"></script> -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyByMhYirwn_EOt2HPNbeWtVE-BVEypa6kI&language=en&libraries=places&callback=initMap"></script>

    <!-- ============================= Google Map Script ========================================== -->
    <script>
        function initMap(marker = {
            lat: 31.0461,
            lng: 34.08516
        }) {
            let coords = "<?php echo $property->coords ?>";
            let center = {
                ...marker
            };
            if (coords) {
                coords = JSON.parse(coords);
                center = {
                    lat: coords[0],
                    lng: coords[1]
                }
            }
            detailMap = new google.maps.Map(
                document.getElementById('detail-map'), {
                    zoom: 17,
                    center
                }
            );

            let newMarker = new google.maps.Marker({
                position: center,
                map: detailMap
            });
        }
    </script>

    <!-- =============================== Full Calendar Script ===================================== -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            //load prices
            var data = <?php echo json_encode($property); ?>;
            console.log("property", data);
            // set seasonal pricing data
            var isAnnual = <?php echo $property->is_annual; ?>;
            var seasonalPrice = "<?php echo $property->seasonal_price; ?>";
            console.log('is_annual', isAnnual);
            if (isAnnual == true) { // switch tab
                $('#season').val(seasonalPrice);
            } else {
                $('#session').val(seasonalPrice);
            }

            $('#days').val('<?php echo $property->days_price; ?>');
            $('#weekend').val('<?php echo $property->weekend_price; ?>');

            $('#weekendFrom').val('<?php echo $property->weekend_from; ?>');
            $('#weekendTo').val('<?php echo $property->weekend_to; ?>');
            $('#isOnlyWeekend').val('<?php echo $property->only_weekend; ?>');

            $('.blockDetail').val('<?php echo $property->blocked_date; ?>');
            $('.disableDetail').val('<?php echo $property->manual_booking; ?>');


            // var calendarEl = document.getElementById('availability-calendar');

            // var calendar = new FullCalendar.Calendar(calendarEl, {
            //     editable: false,
            //     selectable: true,
            //     businessHours: true,
            //     dayMaxEvents: true,
            //     headerToolbar: {
            //         start: 'title', // will normally be on the left. if RTL, will be on the right
            //         center: '',
            //         end: 'prev,next' // will normally be on the right. if RTL, will be on the left
            //     },
            //     titleFormat: {
            //         year: 'numeric',
            //         month: 'short'
            //     },
            //     events: {
            //         url: "https://www.hebcal.com/hebcal/?cfg=fc&v=1&maj=on&min=on&nx=on&year=now&month=x&ss=on&mf=on&d=on&s=on&lg=a",
            //         cache: true
            //     },
            // });

            // calendar.render();


            var d = moment().format('YYYY-MM-DD');

            $('#availability-calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month'
                    // right: 'month,agendaWeek'
                },
                defaultDate: d,
                defaultView: 'month',
                editable: false,
                selectable: true,
                fixedWeekCount: false,
                timeZone: 'local',
                events: {
                    url: "https://www.hebcal.com/hebcal/?cfg=fc&v=1&maj=on&min=on&nx=on&year=now&month=x&ss=on&mf=on&d=on&s=on&lg=a",
                    cache: true
                },
                viewRender: function(view, element) {
                    if (isAnnual == true) { // switch tab
                        renderCalendarPrice();
                    } else {
                        renderSession();
                    }

                }
            });

            function seasonalPriceHTML(price = '') {
                return '<p class="day-background season-background">' + price + '</p>';
            }

            function manualPriceHTML(price = '') {
                return '<p class="day-background manual-background">' + price + '</p>';
            }

            function weekendPriceHTML(price = '') {
                var result = '<p class="day-background weekend-background">' + price + '</p>';
                return result;
            }

            function unavailablePriceHTML(price = '') {
                var result = '<p class="day-background unavailable-background">' + price + '</p>';
                return result;
            }

            function convert(str) {
                var date = new Date(str);
                mnth = ("0" + (date.getMonth() + 1)).slice(-2);
                day = ("0" + date.getDate()).slice(-2);
                return [date.getFullYear(), mnth, day].join("-");
            }

            function updateDate(str) {
                var date = new Date(str);
                mnth = ("0" + (date.getMonth() + 1)).slice(-2);
                day = ("0" + date.getDate()).slice(-2);
                return [date.getFullYear(), mnth, day].join("-");
            }

            function converts(str) {
                var date = new Date(str);
                mnth = ("0" + (date.getMonth() + 1)).slice(-2);
                day = ("0" + date.getDate()).slice(-2);
                return [day, mnth, date.getFullYear()].join("/");
            }

            function renderCalendarPrice() {
                //clear calendar and cards
                $('.fc-bg td').html('');
                // render normal price
                var weekday = [];
                weekday.push($('.fc-day.fc-widget-content.fc-mon'));
                weekday.push($('.fc-day.fc-widget-content.fc-tue'));
                weekday.push($('.fc-day.fc-widget-content.fc-wed'));
                weekday.push($('.fc-day.fc-widget-content.fc-thu'));
                weekday.push($('.fc-day.fc-widget-content.fc-fri'));
                weekday.push($('.fc-day.fc-widget-content.fc-sat'));
                weekday.push($('.fc-day.fc-widget-content.fc-sun'));

                var day = $('#days').val();
                var weekend = $('#weekend').val();
                var weekly = $('#weekly').val();
                var monthly = $('#monthly').val();

                console.log(day, weekend, weekly, monthly);


                // if (weekend != '') {
                //     var week = '$' + weekend;
                // } else {
                //     var week = '';
                // }

                var week = weekend != '' ? '$' + weekend : '';

                // if (day != '') {
                //     var days = '$' + day;
                // } else {
                //     var days = '';
                // }

                var days = day != '' ? '$' + day : '';

                var weekendFrom = $('#weekendFrom').val();
                var weekendTo = $('#weekendTo').val();

                var midWeekend = Math.floor((parseInt(weekendTo) + parseInt(weekendFrom)) / 2) % 7;

                if ($('#isOnlyWeekend').val() == 'true') { // only available in weekend checked

                    weekday.forEach(day => {
                        day.html(unavailablePriceHTML());
                    });
                    weekday[1].html(unavailablePriceHTML('unavailable'));

                    if (week != '') {
                        for (var i = weekendFrom; i <= weekendTo; i++) {
                            weekday[i % 7].html(weekendPriceHTML());
                        }
                        weekday[midWeekend].html(weekendPriceHTML(week));
                    } else {
                        for (var i = weekendFrom; i <= weekendTo; i++) {
                            weekday[i % 7].html(days);
                        }
                    }
                } else {
                    weekday.forEach(day => {
                        day.html(days);
                    });

                    if (week != '') {
                        for (var i = weekendFrom; i <= weekendTo; i++) {
                            weekday[i % 7].html(weekendPriceHTML());
                        }
                        weekday[midWeekend].html(weekendPriceHTML(week));
                    } else {
                        for (var i = weekendFrom; i <= weekendTo; i++) {
                            weekday[i % 7].html(days);
                        }
                    }
                }


                //
                $('.seasonRule').html('');


                // set price in dates and render cards
                var seasonData = $('#season').val();
                var seasons = seasonData != '' ? seasonData.split('&') : [];
                seasons.forEach(season => {
                    var values = season.split('|');
                    var seasonID = values[0];
                    var title = values[1];
                    var startDate = new Date(values[2]);
                    var endDate = new Date(values[3]);
                    var seasonRate = values[4];
                    if (seasonRate == 'daily') {
                        var dayPrice = values[5];
                        var weekendPriceValue = values[6];
                        var isOnlyWeekend = values[7];
                        var weekendFrom = values[8];
                        var weekendTo = values[9];
                        var dailyPriceD = dayPrice != '' ? '$' + dayPrice : '';

                        console.log(dayPrice, weekendPriceValue, isOnlyWeekend, weekendFrom, weekendTo);
                        if (dayPrice) {
                            price = "Day: $" + dayPrice;
                            if (weekendPriceValue) {
                                if (isOnlyWeekend == 'true') {
                                    price = "Only Weekend: $" + weekendPriceValue;
                                } else {
                                    price += "  Weekend: $" + weekendPriceValue;
                                }
                            }
                        } else {
                            if (weekendPriceValue) {
                                price = "Weekend: $" + weekendPriceValue;
                            }
                        }
                        $('.seasonRule').append('<div class="sessionalRule sessionHide' + seasonID + '" style="background-color:#DCDCDC"><p>' + title + '</p><p>Season rate: ' + seasonRate + '</p><p>' + price + '</p><p>' + values[2] + ' - ' + values[3] + '</p><div class="season-action"><i class="fa fa-trash" data=' + seasonID + ' tab="1" aria-hidden="true"></i><span class="rulEdit" tab="1" data=' + seasonID + ' edit-id=' + seasonID + '>Edit</span></div><input type="hidden" class="rulname' + seasonID + '" value="' + title + '"><input type="hidden" class="rulStartDate' + seasonID + '" value="' + convert(startDate) + '"><input type="hidden" class="rulendDate' + seasonID + '" value="' + convert(endDate) + '"><input type="hidden" class="rulSeasonRate' + seasonID + '" value="' + seasonRate + '"><input type="hidden" class="rulDayPrice' + seasonID + '" value="' + dayPrice + '"><input type="hidden" class="rulWeekendPrice' + seasonID + '" value="' + weekendPriceValue + '"><input type="hidden" class="rulWeekendAval' + seasonID + '" value="' + isOnlyWeekend + '"><input type="hidden" class="rulWeekendStart' + seasonID + '" value="' + weekendFrom + '"><input type="hidden" class="rulWeekendEnd' + seasonID + '" value="' + weekendTo + '"></div>');
                    } else {
                        var fixedPrice = values[5];
                        var fixedPriceD = '$' + fixedPrice;
                        price = 'Fixed: $' + fixedPrice;
                        $('.seasonRule').append('<div class="sessionalRule sessionHide' + seasonID + '" style="background-color:#DCDCDC"><p>' + title + '</p><p>Season rate: ' + seasonRate + '</p><p>' + price + '</p><p>' + values[2] + ' - ' + values[3] + '</p><div class="season-action"><i class="fa fa-trash" data=' + seasonID + ' tab="1" aria-hidden="true"></i><span class="rulEdit" tab="1" data=' + seasonID + ' edit-id=' + seasonID + '>Edit</span></div><input type="hidden" class="rulname' + seasonID + '" value="' + title + '"><input type="hidden" class="rulStartDate' + seasonID + '" value="' + convert(startDate) + '"><input type="hidden" class="rulendDate' + seasonID + '" value="' + convert(endDate) + '"><input type="hidden" class="rulSeasonRate' + seasonID + '" value="' + seasonRate + '"><input type="hidden" class="rulPrice' + seasonID + '" value="' + fixedPrice + '"></div>');
                    }
                    console.log(values);
                    var middate = new Date((startDate.getTime() + endDate.getTime()) / 2);
                    var between = [];
                    var tempDate = startDate;
                    while (tempDate <= endDate) {
                        between.push(new Date(tempDate));
                        tempDate.setDate(tempDate.getDate() + 1);
                    }

                    if (seasonRate == 'daily') {
                        var weekday = [
                            [],
                            [],
                            [],
                            [],
                            [],
                            [],
                            []
                        ];
                        between.forEach(day => {
                            var dayObj = $('.fc-widget-content[data-date="' + convert(day) + '"]');
                            dayObj.html(dailyPriceD);
                            if (dayObj.hasClass('fc-mon')) {
                                weekday[0].push(dayObj);
                            } else if (dayObj.hasClass('fc-tue')) {
                                weekday[1].push(dayObj);
                            } else if (dayObj.hasClass('fc-wed')) {
                                weekday[2].push(dayObj);
                            } else if (dayObj.hasClass('fc-thu')) {
                                weekday[3].push(dayObj);
                            } else if (dayObj.hasClass('fc-fri')) {
                                weekday[4].push(dayObj);
                            } else if (dayObj.hasClass('fc-sat')) {
                                weekday[5].push(dayObj);
                            } else if (dayObj.hasClass('fc-sun')) {
                                weekday[6].push(dayObj);
                            }
                        });

                        var midWeekend = Math.floor((parseInt(weekendTo) + parseInt(weekendFrom)) / 2) % 7;
                        for (var i = weekendFrom; i <= weekendTo; i++) {
                            console.log(weekday[i % 7]);
                            weekday[i % 7].forEach(weekendDay => {
                                weekendDay.html('$' + weekendPriceValue);
                            })

                        }
                        // weekday[midWeekend].forEach(weekendDay => {
                        //     weekendDay.html(weekendPriceHTML(weekendPriceValue));
                        // });

                    } else {

                        between.forEach(day => {
                            $('.fc-widget-content[data-date="' + convert(day) + '"]').html(seasonalPriceHTML());
                        });
                        $('.fc-widget-content[data-date="' + convert(middate) + '"]').html(seasonalPriceHTML(fixedPriceD));
                    }
                });

                renderManualBooking();
                renderBlockDate();
            }

            function renderManualBooking() {
                let disableDetails = $('.disableDetail').val() == "" ? [] : JSON.parse($('.disableDetail').val());
                console.log("DisabledDatails: ", disableDetails)
                disableDetails.forEach(detail => {
                    let startd = new Date(detail.checkInDate);
                    let endd = new Date(detail.checkOutDate);

                    console.log("StartD: ", startd);
                    console.log("EndD: ", endd);
                    const midd = new Date((startd.getTime() + endd.getTime()) / 2);
                    let between = [];
                    while (startd <= endd) {
                        between.push(new Date(startd));
                        startd.setDate(startd.getDate() + 1);;
                    }

                    between.forEach(day => {
                        $('.fc-widget-content[data-date="' + convert(day) + '"]').html(manualPrice());
                    });

                    $('.fc-widget-content[data-date="' + convert(midd) + '"]').html(manualPrice(detail.title));

                })
            }

            function renderBlockDate() {
                let blockDetails = $('.blockDetail').val() == "" ? [] : JSON.parse($('.blockDetail').val());
                console.log("BlockDetails: ", blockDetails)
                blockDetails.forEach(detail => {
                    let startd = new Date(moment(detail.checkInDate).format("MM-DD-YYYY"));
                    let endd = new Date(moment(detail.checkOutDate).format("MM-DD-YYYY"));

                    console.log("StartD:", startd);
                    console.log("EndD: ", endd);
                    const midd = new Date((startd.getTime() + endd.getTime()) / 2);
                    let between = [];
                    while (startd <= endd) {
                        between.push(new Date(startd));
                        startd.setDate(startd.getDate() + 1);
                    }

                    // console.log("Between: ", between);

                    between.forEach(day => {
                        $('.fc-widget-content[data-date="' + convert(day) + '"]').html(unavailablePrice());
                    });

                    $('.fc-widget-content[data-date="' + convert(midd) + '"]').html(unavailablePrice('unavailable'));
                });
            }

            function renderSession() {
                //clear calendar and cards
                $('.fc-bg td').html('');

                $('.rule').html('');


                // set price in dates and render cards
                var seasonData = $('#session').val();
                var seasons = seasonData != '' ? seasonData.split('&') : [];
                console.log("renderSession", seasons);
                seasons.forEach(season => {
                    var values = season.split('|');
                    var seasonID = values[0];
                    var title = values[1];
                    var startDate = new Date(values[2]);
                    var endDate = new Date(values[3]);
                    var seasonRate = values[4];
                    if (seasonRate == 'daily') {
                        var dayPrice = values[5];
                        var weekendPriceValue = values[6];
                        var isOnlyWeekend = values[7];
                        var weekendFrom = values[8];
                        var weekendTo = values[9];
                        var dailyPriceD = dayPrice != '' ? '$' + dayPrice : '';

                        console.log(dayPrice, weekendPriceValue, isOnlyWeekend, weekendFrom, weekendTo);
                        if (dayPrice) {
                            price = "Day: $" + dayPrice;
                            if (weekendPriceValue) {
                                if (isOnlyWeekend == 'true') {
                                    price = "Only Weekend: $" + weekendPriceValue;
                                } else {
                                    price += "  Weekend: $" + weekendPriceValue;
                                }
                            }
                        } else {
                            if (weekendPriceValue) {
                                price = "Weekend: $" + weekendPriceValue;
                            }
                        }
                        $('.rule').append('<div class="sessionalRule sessionHide' + seasonID + '" style="background-color:#DCDCDC"><p>' + title + '</p><p>Season rate: ' + seasonRate + '</p><p>' + price + '</p><p>' + values[2] + ' - ' + values[3] + '</p><div class="season-action"><i class="fa fa-trash" data=' + seasonID + ' tab="2" aria-hidden="true"></i><span class="rulEdit" tab="2" data=' + seasonID + ' edit-id=' + seasonID + '>Edit</span></div><input type="hidden" class="rulname' + seasonID + '" value="' + title + '"><input type="hidden" class="rulStartDate' + seasonID + '" value="' + convert(startDate) + '"><input type="hidden" class="rulendDate' + seasonID + '" value="' + convert(endDate) + '"><input type="hidden" class="rulSeasonRate' + seasonID + '" value="' + seasonRate + '"><input type="hidden" class="rulDayPrice' + seasonID + '" value="' + dayPrice + '"><input type="hidden" class="rulWeekendPrice' + seasonID + '" value="' + weekendPriceValue + '"><input type="hidden" class="rulWeekendAval' + seasonID + '" value="' + isOnlyWeekend + '"><input type="hidden" class="rulWeekendStart' + seasonID + '" value="' + weekendFrom + '"><input type="hidden" class="rulWeekendEnd' + seasonID + '" value="' + weekendTo + '"></div>');
                    } else {
                        var fixedPrice = values[5];
                        var fixedPriceD = '$' + fixedPrice;
                        price = 'Fixed: $' + fixedPrice;
                        $('.rule').append('<div class="sessionalRule sessionHide' + seasonID + '" style="background-color:#DCDCDC"><p>' + title + '</p><p>Season rate: ' + seasonRate + '</p><p>' + price + '</p><p>' + values[2] + ' - ' + values[3] + '</p><div class="season-action"><i class="fa fa-trash" data=' + seasonID + ' tab="2" aria-hidden="true"></i><span class="rulEdit" tab="2" data=' + seasonID + ' edit-id=' + seasonID + '>Edit</span></div><input type="hidden" class="rulname' + seasonID + '" value="' + title + '"><input type="hidden" class="rulStartDate' + seasonID + '" value="' + convert(startDate) + '"><input type="hidden" class="rulendDate' + seasonID + '" value="' + convert(endDate) + '"><input type="hidden" class="rulSeasonRate' + seasonID + '" value="' + seasonRate + '"><input type="hidden" class="rulPrice' + seasonID + '" value="' + fixedPrice + '"></div>');
                    }
                    console.log(values);
                    var middate = new Date((startDate.getTime() + endDate.getTime()) / 2);
                    var between = [];
                    var tempDate = startDate;
                    while (tempDate <= endDate) {
                        between.push(new Date(tempDate));
                        tempDate.setDate(tempDate.getDate() + 1);
                    }

                    if (seasonRate == 'daily') {
                        var weekday = [
                            [],
                            [],
                            [],
                            [],
                            [],
                            [],
                            []
                        ];
                        between.forEach(day => {
                            var dayObj = $('.fc-widget-content[data-date="' + convert(day) + '"]');
                            dayObj.html(dailyPriceD);
                            if (dayObj.hasClass('fc-mon')) {
                                weekday[0].push(dayObj);
                            } else if (dayObj.hasClass('fc-tue')) {
                                weekday[1].push(dayObj);
                            } else if (dayObj.hasClass('fc-wed')) {
                                weekday[2].push(dayObj);
                            } else if (dayObj.hasClass('fc-thu')) {
                                weekday[3].push(dayObj);
                            } else if (dayObj.hasClass('fc-fri')) {
                                weekday[4].push(dayObj);
                            } else if (dayObj.hasClass('fc-sat')) {
                                weekday[5].push(dayObj);
                            } else if (dayObj.hasClass('fc-sun')) {
                                weekday[6].push(dayObj);
                            }
                        });

                        var midWeekend = Math.floor((parseInt(weekendTo) + parseInt(weekendFrom)) / 2) % 7;
                        for (var i = weekendFrom; i <= weekendTo; i++) {
                            console.log(weekday[i % 7]);
                            weekday[i % 7].forEach(weekendDay => {
                                weekendDay.html('$' + weekendPriceValue);
                            })
                        }
                        // weekday[midWeekend].forEach(weekendDay => {
                        //     weekendDay.html(weekendPrice(weekendPriceValue));
                        // });

                    } else {

                        between.forEach(day => {
                            $('.fc-widget-content[data-date="' + convert(day) + '"]').html(seasonalPrice());
                        });
                        $('.fc-widget-content[data-date="' + convert(middate) + '"]').html(seasonalPrice(fixedPriceD));
                    }
                });

                renderManualBooking();
                renderBlockDate();

            }
        });
    </script>
</head>

<body>
    <!-- ========================= HEADER ======================================= -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <a class="navbar-brand" href="<?php echo site_url() ?>">
            <img src="<?php echo site_url('uploads/diraleads-logo.svg') ?>" />
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <div class="ml-auto">
            </div>
            <ul class="navbar-nav navbar-right my-2 my-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Why DiraLeads</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="/renters">The Renter's View</a>
                        <a class="dropdown-item" href="/owners">The Owner's Perch</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/properties">View Rentals</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/property">List Your Rental</a>
                </li>
                <!-- ============================= Login ================================ -->
                <?php if (empty($_SESSION['id'])) { ?>
                    <li class="nav-item login">
                        <a class="nav-link" href="<?php echo site_url('login') ?>" style="color: #fff !important;">
                            <img src="<?php echo site_url('assets/images/login.png'); ?>"> Login / Signup
                        </a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="<?php echo site_url('/assets/img/avatar/user.png'); ?>" width="20" alt="avatar">
                            Hi, <?php echo explode(' ', $_SESSION['name'])[0]; ?>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="userDropdownMenuLink">
                            <a class="dropdown-item" href="<?php echo site_url('dashboard') ?>">Dashboard</a>
                            <a class="dropdown-item" href="<?php echo site_url('my_rentals') ?>">My Rentals</a>
                            <a class="dropdown-item" href="<?php echo site_url('subscription/user') ?>">My Subscriptions</a>
                            <a class="dropdown-item" href="<?php echo site_url('profile') ?>">My Profile</a>
                            <a class="dropdown-item" href="<?php echo site_url('login/logout') ?>">Logout</a>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>

    <!-- =============================== Property Detail View ============================================= -->
    <div class="container mt-3">
        <div class="property-board-image">
            <div id="property-detail-image" class="carousel slide property-detail-image-slider" data-ride="carousel">
                <?php if (!isset($property->images) || count($property->images) == 0) { ?>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="<?php echo site_url('uploads/diraleads-logo.svg') ?>" class="d-block w-100" />
                        </div>
                    </div>
                <?php } else { ?>

                    <ol class="carousel-indicators">
                        <?php foreach ($property->images as $index => $image) { ?>
                            <li data-target="#property-detail-image" data-slide-to="<?php echo $index ?>" class="<?php echo $index == 0 ? 'active' : '' ?>"></li>
                        <?php } ?>
                    </ol>
                    <div class="carousel-inner">
                        <?php foreach ($property->images as $index => $image) { ?>
                            <div class="carousel-item <?php echo $index == 0 ? 'active' : '' ?>">
                                <img src="<?php echo site_url('uploads/' . $image['path']) ?>" class="d-block w-100" />
                            </div>
                        <?php  } ?>
                    </div>
                <?php } ?>
                <a class="carousel-control-prev" href="#property-detail-image" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#property-detail-image" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <div class="property-detail-info">
                    <div class="property-info">
                        <h3>$<?php echo $property->days_price ? $property->days_price : 0 ?>/dy, $<?php echo $property->weekend_price ? $property->weekend_price : 0 ?>/wk</h3>
                        <p class="mb-2"><?php echo $property->title ?></p>
                        <h5><?php echo $property->street ?></h5>
                    </div>

                    <div class="property-description">
                        <h3>Description</h3>
                        <p style="overflow-wrap: break-word">
                            <?php echo $property->description ?>
                        </p>
                    </div>

                    <div class="property-amenities">
                        <h3>Amenities</h3>
                        <div class="row">
                            <?php foreach ($property->amenities as $amenity) { ?>
                                <div class="col-sm-6 col-md-4"><?php echo $amenity ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="property-calendar form-group">
                        <h3>Availability</h3>
                        <div id="availability-calendar"></div>
                    </div>

                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="property-contact-detail">
                    <form>
                        <h3>Contact</h3>
                        <div class="form-group">
                            <label for="property-host-name">Host Name: <?php echo $property->name; ?></label>
                            <!-- <input type="text" class="form-control" id="property-host-name" placeholder="Your Host Name" /> -->
                        </div>
                        <div class="form-group">
                            <label for="property-did-number">📱 Phone Number: <?php echo $property->number; ?></label>
                            <!-- <input type="text" class="form-control" id="property-did-number" placeholder="DID Number" /> -->
                        </div>
                        <div class="form-group">
                            <label for="property-contact-name">Name</label>
                            <input type="text" class="form-control" id="property-contact-name" placeholder="Your Name" />
                        </div>
                        <div class="form-group">
                            <label for="property-contact-email">Email</label>
                            <input type="email" class="form-control" id="property-contact-email" placeholder="Your Email" />
                        </div>
                        <div class="form-group">
                            <label for="property-contact-message">Message</label>
                            <textarea class="form-control" id="property-contact-message" placeholder="Message"></textarea>
                        </div>
                        <button class="btn btn-purple btn-block" type="submit">Send Message</button>
                    </form>

                    <div class="property-location">
                        <h3>Location</h3>
                        <div id="detail-map"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="session" value="" name="seasonal_price[session]">
    <input type="hidden" id="season" value="" name="seasonal_price[season]">
    <input type="hidden" name="is_annual" class="isAnnual" value="true" />
    <input type="hidden" name="manualBooking" class="disableDetail" value="[]" />
    <input type="hidden" name="blockedDate" class="blockDetail" value="[]" />
    <input type="hidden" id="days" class="datedays" />
    <input type="hidden" id="weekend" class="weekenddays" />
    <input type="hidden" id="isOnlyWeekend" />
    <input type="hidden" id="weekendFrom" />
    <input type="hidden" id="weekendTo" />

</body>

</html>