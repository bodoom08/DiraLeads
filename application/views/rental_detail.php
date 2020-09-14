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

    <!-- =========================== Photoswipe ===================================================-->
    <link href="<?php echo site_url('assets/photoswipe/photoswipe.css')?>" rel="stylesheet" />
    <link href="<?php echo site_url('assets/photoswipe/default-skin/default-skin.css')?>" rel="stylesheet" />
    <!-- ========================== Custom Style ====================================== -->
    <link rel="stylesheet" href="<?php echo site_url('assets/css/properties.css') ?>">
    </link>
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/css/styles.css') ?>">
    </link>

    <!-- =================================== Availability Calendar ==============================================-->
    <style>
        .fc-content-skeleton tbody tr:first-child {
            height: unset;
        }

        .fc-content-skeleton tbody tr {
            height: 20px;
        }

        .property-calendar .pricing-text {
            margin-bottom: 10px;
        }

        .property-detail-capacity {
            margin-top: 10px;
        }

        .property-detail-capacity span {
            font-size: 20px;
        }

        .property-detail-capacity svg {
            width: 25px;
            height: 25px;
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
    <!-- ============================= Photoswipe Scripts ==================================================== -->
    <script src="<?php echo site_url('assets/photoswipe/photoswipe.min.js')?>"></script>
    <script src="<?php echo site_url('assets/photoswipe/photoswipe-ui-default.min.js')?>"></script>
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
                        $('.fc-widget-content[data-date="' + convert(day) + '"]').html(manualPriceHTML());
                    });

                    $('.fc-widget-content[data-date="' + convert(midd) + '"]').html(manualPriceHTML(detail.title));

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
                        $('.fc-widget-content[data-date="' + convert(day) + '"]').html(unavailablePriceHTML());
                    });

                    $('.fc-widget-content[data-date="' + convert(midd) + '"]').html(unavailablePriceHTML('unavailable'));
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
    <div id="property-load">
        <div class="spinner-border" role="status" id="property-load-spinner">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <div class="container mt-3" id="property-detail-body">
    <?php if ($property) { ?>
        
            <div class="property-image-board">
                <?php if (!isset($property->images) || count($property->images) == 0) { ?>
                    <div class="property-image-full">
                        <img src="<?php echo site_url('uploads/diraleads-logo.svg') ?>" class="w-100" />
                    </div>
                <?php } else if (count($property->images) == 1) { ?>
                    <div class="property-image-full">
                        <img src="<?php echo site_url('uploads/' . $property->images[0]['path']) ?>" class="w-100" onclick="openPhotoSwipe()" style="cursor: pointer;"/>
                    </div>
                <?php } else if (count($property->images) == 2) { ?>
                    <div class="property-image-medium pr-1">
                        <img src="<?php echo site_url('uploads/' . $property->images[0]['path']) ?>" onclick="openPhotoSwipe()" style="cursor: pointer;"/>
                    </div>
                    <div class="property-image-medium pl-1 d-none d-sm-flex">
                        <img src="<?php echo site_url('uploads/' . $property->images[1]['path']) ?>" onclick="openPhotoSwipe(1)" style="cursor: pointer;"/>
                    </div>
                <?php } else { ?>
                    <div class="property-image-big">
                        <img src="<?php echo site_url('uploads/' . $property->images[0]['path']) ?>" onclick="openPhotoSwipe()" style="cursor: pointer;"/>
                    </div>
                    <div class="property-image-small">
                        <img src="<?php echo site_url('uploads/' . $property->images[1]['path']) ?>" onclick="openPhotoSwipe(1)" style="cursor: pointer;"/>
                        <img src="<?php echo site_url('uploads/' . $property->images[2]['path']) ?>" onclick="openPhotoSwipe(2)" style="cursor: pointer;"/>
                    </div>
                <?php } ?>
                <?php if (isset($property->images) && count($property->images) > 0) { ?>
                    <button class="btn btn-outline-purple" onclick="openPhotoSwipe()">Show All Photos</button>
                <?php } ?>

            </div>
            <div class="row">
                <div class="col-sm-12 col-md-8">
                    <div class="property-detail-info">
                        <div class="property-info">
                            <p class="mb-2"><?php echo $property->title ?></p>
                            <h5><?php echo $property->street ?></h5>
                            <div class="property-detail-capacity">
                                <span><?php echo $property->type ?></span>
                                <span><svg class="svg" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.196 14.603h15.523v.027h1.995v10.64h-3.99v-4.017H9.196v4.017h-3.99V6.65h3.99v7.953zm2.109-1.968v-2.66h4.655v2.66h-4.655z" fill="#869099"></path>
                                    </svg>
                                    <?php echo $property->bedrooms ?> bd</span>
                                <span><svg class="svg" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M23.981 15.947H26.6v1.33a9.31 9.31 0 0 1-9.31 9.31h-2.66a9.31 9.31 0 0 1-9.31-9.31v-1.33h16.001V9.995a2.015 2.015 0 0 0-2.016-2.015h-.67c-.61 0-1.126.407-1.29.965a2.698 2.698 0 0 1 1.356 2.342H13.3a2.7 2.7 0 0 1 1.347-2.337 4.006 4.006 0 0 1 3.989-3.63h.67a4.675 4.675 0 0 1 4.675 4.675v5.952z" fill="#869099"></path>
                                    </svg><?php echo $property->bathrooms ?> ba</span>

                                <?php if ($property->florbas > 0) { ?>
                                    <span><svg class="svg" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.748 21.276l-3.093-3.097v3.097h3.093zm12.852 5.32H10.655v.004h-5.32v-.004H5.32v-5.32h.015V5.32L26.6 26.596z" fill="#869099"></path>
                                        </svg><?php echo $property->florbas ?> fl</span>
                                <?php } ?>
                            </div>
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
                            <h3 class="pricing-text">Availability</h3>
                            <h5 class="pricing-text">$<?php echo $property->days_price ? $property->days_price : 0 ?>/dy, $<?php echo $property->weekend_price ? $property->weekend_price : 0 ?>/wk</h5>
                            <?php if ($property->private_note != '') { ?>
                                <h6 class="pricing-text">Note: <?php echo $property->private_note; ?></h6>
                            <?php } ?>
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
    <?php } else { ?>
        <div style="text-align:center;margin-top:50px;">
            <h1>This rental does not exist.</h1>
        </div>
    <?php } ?>
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

    <!-- Root element of PhotoSwipe. Must have class pswp. -->
    <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
        
        <!-- Background of PhotoSwipe. 
             It's a separate element, as animating opacity is faster than rgba(). -->
        <div class="pswp__bg"></div>
    
        <!-- Slides wrapper with overflow:hidden. -->
        <div class="pswp__scroll-wrap">
    
            <!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory. -->
            <div class="pswp__container">
                <!-- don't modify these 3 pswp__item elements, data is added later on -->
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
            </div>
    
            <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
            <div class="pswp__ui pswp__ui--hidden">
    
                <div class="pswp__top-bar">
    
                    <!--  Controls are self-explanatory. Order can be changed. -->
    
                    <div class="pswp__counter"></div>
    
                    <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
    
                    <button class="pswp__button pswp__button--share" title="Share"></button>
    
                    <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
    
                    <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
    
                    <!-- Preloader demo https://codepen.io/dimsemenov/pen/yyBWoR -->
                    <!-- element will get class pswp__preloader--active when preloader is running -->
                    <div class="pswp__preloader">
                        <div class="pswp__preloader__icn">
                          <div class="pswp__preloader__cut">
                            <div class="pswp__preloader__donut"></div>
                          </div>
                        </div>
                    </div>
                </div>
    
                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                    <div class="pswp__share-tooltip"></div> 
                </div>
    
                <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
                </button>
    
                <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
                </button>
    
                <div class="pswp__caption">
                    <div class="pswp__caption__center"></div>
                </div>
    
              </div>
    
            </div>
    
    </div>
    
    <!-- ============================= Image Gallery LightBox ================================ -->
    
    <script>
        var images = `<?php echo $property->images && count($property->images) > 0 ? json_encode($property->images) : '[]'?>`;
        images = JSON.parse(images);

        var imageElements = [];
        document.getElementById('property-load').style.display = "flex";
        document.getElementById('property-detail-body').style.display = "none";

        images.forEach(image => {
            var img = new Image();
            img.src = `/uploads/${image.path}`;
            img.onload = function () {
                imageElements.push({
                    src: img.src,
                    w: this.width,
                    h: this.height
                });
            }
        });

        document.getElementById('property-load').style.display = "none";
        document.getElementById('property-detail-body').style.display = "block";
        
        var openPhotoSwipe = function(index = 0) {


            var pswpElement = document.querySelectorAll('.pswp')[0];
            
            // define options (if needed)
            var options = {
                    // history & focus options are disabled on CodePen        
                history: false,
                focus: false,
                index,

                showAnimationDuration: 0,
                hideAnimationDuration: 0
                
            };
            
            var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, imageElements, options);
            gallery.init();
        };
    </script>

    <!-- ================================= Loading Image Controller ============================== -->
    <!-- <script>
        function imageLoaded(element) {
            element.parentElement.children[0].style.display = "none";
            element.parentElement.children[1].style.display = "block";
        }
    </script> -->

</body>

</html>