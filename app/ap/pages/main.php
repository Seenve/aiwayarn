<?php
    $i = 0;
    $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `visits` ORDER BY `id` DESC LIMIT 0, 7");
    while($row = mysqli_fetch_assoc($query)) {
        $array[$i]['y'] = $row['hosts'];
        $date = strtotime($row['date']);
        $array[$i]['x'] = date("Y-m-d", $date);
        $i++;
    }
    $i = 0;

    $i = 0;
    $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `visits` ORDER BY `id` DESC LIMIT 0, 7");
    while($row = mysqli_fetch_assoc($query)) {

        $array2[$i]['y'] = $row['views'];
        $date = strtotime($row['date']);
        $array2[$i]['x'] = date("Y-m-d", $date);
        $i++;
    }
    $i = 0;
?>
<h1 class="h2">Статистика</h1>
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <div class="h2 mb-0 mr-3 text-primary"><?php echo $array2['0']['y']; ?></div>
                <div class="flex">
                    <h4 class="card-title">Просмотры</h4>
                    <p class="card-subtitle">За последние 7 дней</p>
                </div>
                <i class="material-icons text-muted ml-2">trending_up</i>
            </div>
            <div class="card-body">
                <div class="chart" style="height: 154px;">
                    <canvas id="iqChart2" class="chart-canvas"></canvas>
                </div>
            </div>
        </div>
    </div> 
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <div class="h2 mb-0 mr-3 text-primary"><?php echo $array['0']['y']; ?></div>
                <div class="flex">
                    <h4 class="card-title">Посещаемость</h4>
                    <p class="card-subtitle">За последние 7 дней</p>
                </div>
                <i class="material-icons text-muted ml-2">trending_up</i>
            </div>
            <div class="card-body">
                <div class="chart" style="height: 154px;">
                    <canvas id="iqChart" class="chart-canvas"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

function load_modules_main(){
    //$(document).ready(function(){
    console.log('modules: loaded');
    /*loadScript("assets/js/chartjs.js");
    loadScript("assets/js/nestable.js");*/

    // charts.js
    !function(t){var e={};function a(r){if(e[r])return e[r].exports;var o=e[r]={i:r,l:!1,exports:{}};return t[r].call(o.exports,o,o.exports,a),o.l=!0,o.exports}a.m=t,a.c=e,a.d=function(t,e,r){a.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:r})},a.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},a.t=function(t,e){if(1&e&&(t=a(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var r=Object.create(null);if(a.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var o in t)a.d(r,o,function(e){return t[e]}.bind(null,o));return r},a.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return a.d(e,"a",e),e},a.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},a.p="/",a(a.s=321)}({321:function(t,e,a){t.exports=a(322)},322:function(t,e,a){"use strict";a.r(e);a(323)},323:function(t,e){const a=(t,e)=>{for(var r in e)"object"!=typeof e[r]?t[r]=e[r]:a(t[r],e[r])},r=t=>{var e=t.data("add"),a=$(t.data("target")).data("chart");if(t.is(":checked")){!function t(e,a){for(var r in a)Array.isArray(a[r])?a[r].forEach(function(t){e[r].push(t)}):t(e[r],a[r])}(a,e)}else{!function t(e,a){for(var r in a)Array.isArray(a[r])?a[r].forEach(function(t){e[r].pop()}):t(e[r],a[r])}(a,e)}a.update()},o=t=>{var e=t.data("update"),r=$(t.data("target")).data("chart");if(a(r,e),void 0!==t.data("prefix")||void 0!==t.data("suffix")){let e=t.data("prefix")?t.data("prefix"):"",a=t.data("suffix")?t.data("suffix"):"";void 0!==r.options.scales&&(r.options.scales.yAxes[0].ticks.callback=function(t){if(!(t%10))return e+t+a}),r.options.tooltips.callbacks.label=function(t,r){var o=r.datasets[t.datasetIndex].label||"",n=t.yLabel||r.datasets[0].data[t.index],s="";return 1<r.datasets.length&&(s+='<span class="popover-body-label mr-auto">'+o+"</span>"),s+'<span class="popover-body-value">'+e+n+a+"</span>"}}r.update()},n={responsive:!0,maintainAspectRatio:!1,defaultColor:"dark"==settings.charts.colorScheme?settings.colors.gray[700]:settings.colors.gray[600],defaultFontColor:"dark"==settings.charts.colorScheme?settings.colors.gray[700]:settings.colors.gray[600],defaultFontFamily:settings.fonts.base,defaultFontSize:13,layout:{padding:0},legend:{display:!1,position:"bottom",labels:{usePointStyle:!0,padding:16}},elements:{point:{radius:0,backgroundColor:settings.colors.primary[500]},line:{tension:.4,borderWidth:3,borderColor:settings.colors.primary[500],backgroundColor:settings.colors.transparent,borderCapStyle:"rounded"},rectangle:{backgroundColor:settings.colors.primary[500]},arc:{backgroundColor:settings.colors.primary[500],borderColor:"dark"==settings.charts.colorScheme?settings.colors.gray[800]:settings.colors.white,borderWidth:4}},tooltips:{enabled:!1,mode:"index",intersect:!1,custom:function(t){var e=$("#chart-tooltip");if(e.length||(e=$('<div id="chart-tooltip" class="popover bs-popover-top" role="tooltip"></div>'),$("body").append(e)),0!==t.opacity){if(t.body){var a=t.title||[],r=t.body.map(function(t){return t.lines}),o="";o+='<div class="arrow"></div>',a.forEach(function(t){o+='<h3 class="popover-header text-center">'+t+"</h3>"}),r.forEach(function(e,a){var n='<span class="popover-body-indicator" style="background-color: '+t.labelColors[a].backgroundColor+'"></span>',s=1<r.length?"justify-content-left":"justify-content-center";o+='<div class="popover-body d-flex align-items-center '+s+'">'+n+e+"</div>"}),e.html(o)}var n=$(this._chart.canvas),s=(n.outerWidth(),n.outerHeight(),n.offset().top),i=n.offset().left,l=e.outerWidth(),c=e.outerHeight(),d=s+t.caretY-c-16,u=i+t.caretX-l/2;e.css({top:d+"px",left:u+"px",display:"block"})}else e.css("display","none")},callbacks:{label:function(t,e){var a=e.datasets[t.datasetIndex].label||"",r=t.yLabel,o="";return 1<e.datasets.length&&(o+='<span class="popover-body-label mr-auto">'+a+"</span>"),o+'<span class="popover-body-value">'+r+"</span>"}}}},s={cutoutPercentage:83,tooltips:{callbacks:{title:function(t,e){return e.labels[t[0].index]},label:function(t,e){return""+'<span class="popover-body-value">'+e.datasets[0].data[t.index]+"</span>"}}},legendCallback:function(t){var e=t.data,a="";return e.labels.forEach(function(t,r){var o=e.datasets[0].backgroundColor[r];a+='<span class="chart-legend-item">',a+='<i class="chart-legend-indicator" style="background-color: '+o+'"></i>',a+=t,a+="</span>"}),a}},i={settings:settings,init:()=>{a(Chart,{defaults:{global:n,doughnut:s}}),Chart.scaleService.updateScaleDefaults("linear",{gridLines:{borderDash:[2],borderDashOffset:[2],color:"dark"==settings.charts.colorScheme?settings.colors.gray[900]:settings.colors.gray[100],drawBorder:!1,drawTicks:!1,lineWidth:0,zeroLineWidth:0,zeroLineColor:"dark"==settings.charts.colorScheme?settings.colors.gray[900]:settings.colors.gray[100],zeroLineBorderDash:[2],zeroLineBorderDashOffset:[2]},ticks:{beginAtZero:!0,padding:10,callback:function(t){if(!(t%10))return t}}}),Chart.scaleService.updateScaleDefaults("category",{gridLines:{drawBorder:!1,drawOnChartArea:!1,drawTicks:!1},ticks:{padding:20},maxBarThickness:10}),$('[data-toggle="chart"]').on({change:function(){var t=$(this);t.is("[data-add]")&&r(t)},click:function(){var t=$(this);t.is("[data-update]")&&o(t)}})},add:r,update:o,create:(t,e="line",a={},r={})=>{var o=$(t),n=new Chart(o,{type:e,options:a,data:r});o.data("chart",n),o.data("chart-legend")&&(document.querySelector(o.data("chart-legend")).innerHTML=n.generateLegend())}};void 0!==window&&(window.Charts=i)}});
    
    moment.locale('ru');

    Charts.init();
    var earnings = <?php echo json_encode($array); ?>;
    var earnings2 = <?php echo json_encode($array2); ?>;

    var WeekIQChart = function(id, type = 'line', options = {}) {
        options = Chart.helpers.merge({
            elements: {
                point: {
                    pointStyle: 'circle',
                    radius: 4,
                    hoverRadius: 5,
                    backgroundColor: '#fff',
                    borderColor: '#1e90ff',
                    borderWidth: 2
                }
            },
            scales: {
                yAxes: [{
                    ticks: {
                        display: false
                    }
                }],
                xAxes: [{
                    gridLines: {
                        display: false
                    },
                    type: 'time',
                    distribution: 'series',
                    time: {
                        unit: 'day',
                        stepSize: 1,
                        autoSkip: false,
                        displayFormats: {
                            day: 'ddd'
                        }
                    }
                }]
            },
            tooltips: {
                callbacks: {
                    label: function(a, e) {
                        var t = e.datasets[a.datasetIndex].label || "",
                            o = a.yLabel,
                            r = "";
                        return 1 < e.datasets.length && (r += '<span class="popover-body-label mr-auto">' + t + "</span>"), r += '<span class="popover-body-value"><b>' + o + "</b> <small><i class='fa fa-user'></i></small></span>"
                    }
                }
            }
        }, options)

        var data = {

            datasets: [{
                label: "Visits",
                data: earnings,
                pointHoverBorderColor: '#000000',
                pointHoverBackgroundColor: '#ffffff',
                borderColor: [
                    '#4a77a8',
                ],
                borderWidth: 2
            }]
        }

        Charts.create(id, type, options, data)
    }

    WeekIQChart('#iqChart');

    var WeekIQChart2 = function(id, type = 'line', options = {}) {
        options = Chart.helpers.merge({
            elements: {
                point: {
                    pointStyle: 'circle',
                    radius: 4,
                    hoverRadius: 5,
                    backgroundColor: '#fff',
                    borderColor: '#1e90ff',
                    borderWidth: 2
                }
            },
            scales: {
                yAxes: [{
                    ticks: {
                        display: false
                    }
                }],
                xAxes: [{
                    gridLines: {
                        display: false
                    },
                    type: 'time',
                    distribution: 'series',
                    time: {
                        unit: 'day',
                        stepSize: 1,
                        autoSkip: false,
                        displayFormats: {
                            day: 'ddd'
                        }
                    }
                }]
            },
            tooltips: {
                callbacks: {
                    label: function(a, e) {
                        var t = e.datasets[a.datasetIndex].label || "",
                            o = a.yLabel,
                            r = "";
                        return 1 < e.datasets.length && (r += '<span class="popover-body-label mr-auto">' + t + "</span>"), r += '<span class="popover-body-value"><b>' + o + "</b> <small><i class='fa fa-search'></i></small></span>"
                    }
                }
            }
        }, options)

        var data = {
            datasets: [{
                label: "Views",
                data: earnings2,
                pointHoverBorderColor: '#000000',
                pointHoverBackgroundColor: '#ffffff',
                borderColor: [
                    '#4a77a8',
                ],
                borderWidth: 2
            }]
        }

        Charts.create(id, type, options, data)
    }

    WeekIQChart2('#iqChart2');

//});
}
</script>
<!--
<div class="card border-left-3 border-left-primary card-2by1">
    <div class="card-body">
        <div class="media flex-wrap align-items-center">
            <div class="media-left">
                <i class="material-icons text-muted-light">credit_card</i>
            </div>
            <div class="media-body" style="min-width: 180px">
                Обновление системы
            </div>
            <div class="media-right mt-2 mt-xs-plus-0">
                <a class="btn btn-success btn-sm" href="#">Обновить</a>
            </div>
        </div>
    </div>
</div>
-->
<!--<div class="card">
    <div class="card-header d-flex align-items-center">
        <div class="flex">
            <h4 class="card-title">Статистика</h4>
        </div>
        <div class="dropdown">
            <a href="/ap/?page=news&amp;id=add" data-pjax="content" data-caret="false">
                <i class="material-icons">add</i>
            </a>
        </div>
    </div>
</div>-->
<!--
<div class="row" style="display: none;">
    <div class="col-lg-7">

        <div class="card">
            <div class="card-header d-flex align-items-center">
                <div class="h2 mb-0 mr-3 text-primary">116</div>
                <div class="flex">
                    <h4 class="card-title">Angular</h4>
                    <p class="card-subtitle">Best score</p>
                </div>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle text-black-70" data-toggle="dropdown">Popular Topics</a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="" class="dropdown-item">Popular Topics</a>
                        <a href="" class="dropdown-item">Web Design</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart" style="height: 319px;">
                    <canvas id="topicIqChart" class="chart-canvas"></canvas>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="media align-items-center">
                    <div class="media-body">
                        <h4 class="card-title">Courses</h4>
                        <p class="card-subtitle">Your recent courses</p>
                    </div>
                    <div class="media-right">
                        <a class="btn btn-sm btn-primary" href="student-my-courses.html">My courses</a>
                    </div>
                </div>
            </div>



            <ul class="list-group list-group-fit mb-0" style="z-index: initial;">

                <li class="list-group-item" style="z-index: initial;">
                    <div class="d-flex align-items-center">
                        <a href="student-take-course.html" class="avatar avatar-4by3 avatar-sm mr-3">
                            <img src="assets/images/gulp.png" alt="course" class="avatar-img rounded">
                        </a>
                        <div class="flex">
                            <a href="student-take-course.html" class="text-body"><strong>Learn Vue.js Fundamentals</strong></a>
                            <div class="d-flex align-items-center">
                                <div class="progress" style="width: 100px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <small class="text-muted ml-2">25%</small>
                            </div>
                        </div>
                        <div class="dropdown ml-3">
                            <a href="#" class="dropdown-toggle text-muted" data-caret="false" data-toggle="dropdown">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="student-take-course.html">Continue</a>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="list-group-item" style="z-index: initial;">
                    <div class="d-flex align-items-center">
                        <a href="student-take-course.html" class="avatar avatar-4by3 avatar-sm mr-3">
                            <img src="assets/images/vuejs.png" alt="course" class="avatar-img rounded">
                        </a>
                        <div class="flex">
                            <a href="student-take-course.html" class="text-body"><strong>Angular in Steps</strong></a>
                            <div class="d-flex align-items-center">
                                <div class="progress" style="width: 100px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <small class="text-muted ml-2">100%</small>
                            </div>
                        </div>
                        <div class="dropdown ml-3">
                            <a href="#" class="dropdown-toggle text-muted" data-caret="false" data-toggle="dropdown">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="student-take-course.html">Continue</a>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="list-group-item" style="z-index: initial;">
                    <div class="d-flex align-items-center">
                        <a href="student-take-course.html" class="avatar avatar-4by3 avatar-sm mr-3">
                            <img src="assets/images/nodejs.png" alt="course" class="avatar-img rounded">
                        </a>
                        <div class="flex">
                            <a href="student-take-course.html" class="text-body"><strong>Bootstrap Foundations</strong></a>
                            <div class="d-flex align-items-center">
                                <div class="progress" style="width: 100px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <small class="text-muted ml-2">80%</small>
                            </div>
                        </div>
                        <div class="dropdown ml-3">
                            <a href="#" class="dropdown-toggle text-muted" data-caret="false" data-toggle="dropdown">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="student-take-course.html">Continue</a>
                            </div>
                        </div>
                    </div>
                </li>

            </ul>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="media align-items-center">
                    <div class="media-body">
                        <h4 class="card-title">Quizzes</h4>
                        <p class="card-subtitle">Your Performance</p>
                    </div>
                    <div class="media-right">
                        <a class="btn btn-sm btn-primary" href="#">Quiz results</a>
                    </div>
                </div>
            </div>


            <ul class="list-group list-group-fit mb-0">

                <li class="list-group-item">
                    <div class="media align-items-center">
                        <div class="media-body">
                            <a class="text-body" href="student-quiz-results.html"><strong>Title of quiz goes here?</strong></a><br>
                            <div class="d-flex align-items-center">
                                <small class="text-black-50 text-uppercase mr-2">Course</small>
                                <a href="student-take-course.html">Basics of HTML</a>
                            </div>
                        </div>
                        <div class="media-right text-center d-flex align-items-center">
                            <span class="text-black-50 mr-3">Good</span>
                            <h4 class="mb-0">5.8</h4>
                        </div>
                    </div>
                </li>

                <li class="list-group-item">
                    <div class="media align-items-center">
                        <div class="media-body">
                            <a class="text-body" href="student-quiz-results.html"><strong>Directives &amp; Routing</strong></a><br>
                            <div class="d-flex align-items-center">
                                <small class="text-black-50 text-uppercase mr-2">Course</small>
                                <a href="student-take-course.html">Angular in Steps</a>
                            </div>
                        </div>
                        <div class="media-right text-center d-flex align-items-center">
                            <span class="text-black-50 mr-3">Great</span>
                            <h4 class="mb-0 text-success">9.8</h4>
                        </div>
                    </div>
                </li>

                <li class="list-group-item">
                    <div class="media align-items-center">
                        <div class="media-body">
                            <a class="text-body" href="student-quiz-results.html"><strong>Responsive &amp; Retina</strong></a><br>
                            <div class="d-flex align-items-center">
                                <small class="text-black-50 text-uppercase mr-2">Course</small>
                                <a href="student-take-course.html">Bootstrap Foundations</a>
                            </div>
                        </div>
                        <div class="media-right text-center d-flex align-items-center">
                            <span class="text-black-50 mr-3">Failed</span>
                            <h4 class="mb-0 text-danger">2.8</h4>
                        </div>
                    </div>
                </li>

            </ul>
        </div>
    </div>
    <div class="col-lg-5">

        <div class="card">
            <div class="card-header d-flex align-items-center">
                <div class="h2 mb-0 mr-3 text-primary">432</div>
                <div class="flex">
                    <h4 class="card-title">Experience IQ</h4>
                    <p class="card-subtitle">4 days streak this week</p>
                </div>
                <i class="material-icons text-muted ml-2">trending_up</i>
            </div>
            <div class="card-body">
                <div class="chart" style="height: 154px;">
                    <canvas id="iqChart" class="chart-canvas"></canvas>
                </div>
            </div>
        </div>

        <div class="card card-2by1">
            <div class="card-header">
                <h4 class="card-title">Rewards</h4>
                <p class="card-subtitle">Your latest achievements</p>
            </div>
            <div class="card-body text-center">
                <div class="btn btn-primary btn-circle"><i class="material-icons">thumb_up</i></div>
                <div class="btn btn-danger btn-circle"><i class="material-icons">grade</i></div>
                <div class="btn btn-success btn-circle"><i class="material-icons">bubble_chart</i></div>
                <div class="btn btn-warning btn-circle"><i class="material-icons">keyboard_voice</i></div>
                <div class="btn btn-info btn-circle"><i class="material-icons">event_available</i></div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="media align-items-center">
                    <div class="media-body">
                        <h4 class="card-title">Forum Activity</h4>
                        <p class="card-subtitle">Latest forum topics &amp; replies</p>
                    </div>
                    <div class="media-right">
                        <a class="btn btn-sm btn-primary" href="student-forum.html"> <i class="material-icons">keyboard_arrow_right</i></a>
                    </div>
                </div>
            </div>





            <ul class="list-group list-group-fit">


                <li class="list-group-item forum-thread">
                    <div class="media align-items-center">
                        <div class="media-left">
                            <div class="forum-icon-wrapper">
                                <a href="student-forum-thread.html" class="forum-thread-icon">
                                    <i class="material-icons">description</i>
                                </a>
                                <a href="student-profile.html" class="forum-thread-user">
                                    <img src="assets/images/people/50/guy-1.jpg" alt="" width="20" class="rounded-circle">
                                </a>
                            </div>
                        </div>
                        <div class="media-body">
                            <div class="d-flex align-items-center">
                                <a href="student-profile.html" class="text-body"><strong>Luci Bryant</strong></a>
                                <small class="ml-auto text-muted">5 min ago</small>
                            </div>
                            <a class="text-black-70" href="student-forum-thread.html">Am I learning the right way?</a>
                        </div>
                    </div>
                </li>



                <li class="list-group-item forum-thread">
                    <div class="media align-items-center">
                        <div class="media-left">
                            <div class="forum-icon-wrapper">
                                <a href="student-forum-thread.html" class="forum-thread-icon">
                                    <i class="material-icons">description</i>
                                </a>
                                <a href="student-profile.html" class="forum-thread-user">
                                    <img src="assets/images/people/50/guy-2.jpg" alt="" width="20" class="rounded-circle">
                                </a>
                            </div>
                        </div>
                        <div class="media-body">
                            <div class="d-flex align-items-center">
                                <a href="student-profile.html" class="text-body"><strong>Magnus Goldsmith</strong></a>
                                <small class="ml-auto text-muted">7 min ago</small>
                            </div>
                            <a class="text-black-70" href="student-forum-thread.html">Can someone help me with the basic Setup?</a>
                        </div>
                    </div>
                </li>



                <li class="list-group-item forum-thread">
                    <div class="media align-items-center">
                        <div class="media-left">
                            <div class="forum-icon-wrapper">
                                <a href="student-forum-thread.html" class="forum-thread-icon">
                                    <i class="material-icons">description</i>
                                </a>
                                <a href="student-profile.html" class="forum-thread-user">
                                    <img src="assets/images/people/50/woman-1.jpg" alt="" width="20" class="rounded-circle">
                                </a>
                            </div>
                        </div>
                        <div class="media-body">
                            <div class="d-flex align-items-center">
                                <a href="student-profile.html" class="text-body"><strong>Katelyn Rankin</strong></a>
                                <small class="ml-auto text-muted">12 min ago</small>
                            </div>
                            <a class="text-black-70" href="student-forum-thread.html">I think this is the right way?</a>
                        </div>
                    </div>
                </li>


            </ul>
        </div>
    </div>
</div>
-->