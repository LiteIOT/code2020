<?php
include "common.check.php"
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>物资管理</title>

    <!-- Bootstrap core CSS-->
    <link type="text/css" rel="stylesheet" href="dist/bootstrap.min.css" />
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="dist/eui/2.12.0/index.css">

    <!-- PLUGINS CSS STYLE -->
</head>

<body id="page-top">
    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
        <a class="navbar-brand mr-1" href="index.html">捐赠物资管理</a>
        <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
            <i class="fas fa-bars"></i>
        </button>
        <!-- Navbar Search -->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group">

            </div>
        </form>
    </nav>

    <div id="wrapper">

        <!-- Sidebar -->
        <?php include "common.menu.php" ?>

        <div class="content-wrapper">
            <div class="content">
                <!-- Top Statistics -->
                <div class="row">
                    <div class="col-xl-3 col-sm-6">
                        <div class="card card-mini mb-4">
                            <div class="card-body">
                                <h2 class="mb-1">3,5030</h2>
                                <p>已调拨物资</p>
                                <div class="chartjs-wrapper">
                                    <canvas id="barChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card card-mini  mb-4">
                            <div class="card-body">
                                <h2 class="mb-1">9,503</h2>
                                <p>待调拨需求</p>
                                <div class="chartjs-wrapper">
                                    <canvas id="dual-line"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card card-mini mb-4">
                            <div class="card-body">
                                <h2 class="mb-1">1,503</h2>
                                <p>库存统计</p>
                                <div class="chartjs-wrapper">
                                    <canvas id="area-chart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card card-mini mb-4">
                            <div class="card-body">
                                <h2 class="mb-1">9,503</h2>
                                <p>待签收（在运物资）</p>
                                <div class="chartjs-wrapper">
                                    <canvas id="line"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xl-8 col-md-12">
                        <!-- Sales Graph -->
                        <div class="card card-default" data-scroll-height="675">
                            <div class="card-header">
                                <h3>捐款统计</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="linechart" class="chartjs"></canvas>
                            </div>
                            <div class="card-footer d-flex flex-wrap bg-white p-0">
                                <div class="col-6 px-0">
                                    <div class="text-center p-4">
                                        <h4 id="money_income_7days">0</h4>元
                                        <p class="mt-2">近7日捐赠资金</p>
                                    </div>
                                </div>
                                <div class="col-6 px-0">
                                    <div class="text-center p-4 border-left">
                                        <h4 id="money_expense_7days">0</h4>元
                                        <p class="mt-2">近7日支出金额</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-12">
                        <!-- Doughnut Chart -->
                        <div class="card card-default" data-scroll-height="675">
                            <div class="card-header justify-content-center">
                                <h3>急需物资分布</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="doChart"></canvas>
                            </div>
                            <!--a href="#" class="pb-5 d-block text-center text-muted"><i class="mdi mdi-download mr-2"></i> 下载详细报表</a-->
                            <div class="card-footer d-flex flex-wrap bg-white p-0">
                                <div class="col-12">
                                    <div class="py-4 px-4">
                                        <ul class="d-flex flex-column justify-content-between">
                                            <li id="req_index_0"></li>
                                            <li id="req_index_1"></li>
                                            <li id="req_index_2"></li>
                                            <li id="req_index_3"></li>
                                        </ul>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/plugins/charts/Chart.min.js"></script>
    <script src="assets/js/chart.js"></script>

    <script lang="javascript">
        function getRecentIncome() {
            //
            $.ajax({
                //请求方式
                dataType: "json", //返回格式为json
                async: true, //请求是否异步，默认为异步，这也是ajax重要特性

                type: "GET", //请求方式
                url: "api.admin.income.php",
                //数据，json字符串
                data: {
                    "action": "listRecent7Day",

                }, //参数值,
                //请求成功
                success: function(result) {
                    console.log("success");
                    console.log(result);
                    let sum = 0;
                    for (let i = 0; i < result.length; i++) {
                        sum += parseInt(result[i].income_sum);
                        chart3.data.labels[i] = result[i].income_date.substring(5, 10);
                        chart3.data.datasets[0].data[i] = parseInt(result[i].income_sum);
                    }

                    $("#money_income_7days").html(sum);

                    chart3.update();

                },
                //请求失败，包含具体的错误信息
                error: function(e) {
                    console.log(e.status);
                    console.log(e.responseText);
                }
            });
        }

        function getRecentExpense() {
            //
            $.ajax({
                //请求方式
                dataType: "json", //返回格式为json
                async: true, //请求是否异步，默认为异步，这也是ajax重要特性

                type: "GET", //请求方式
                url: "api.admin.expense.php",
                //数据，json字符串
                data: {
                    "action": "listRecent7Day",

                }, //参数值,
                //请求成功
                success: function(result) {
                    console.log("success");
                    console.log(result);
                    let sum = 0;
                    for (let i = 0; i < result.length; i++) {
                        sum += parseFloat(result[i].expense_sum);
                    }

                    $("#money_expense_7days").html(sum);

                    for (let i = 0; i < chart3.data.labels.length; i++) {
                        console.log(chart3.data.labels[i]);
                    }

                    // chart3.data.labels = "";
                    // chart3.data.datasets[0].date = "";

                },
                //请求失败，包含具体的错误信息
                error: function(e) {
                    console.log(e.status);
                    console.log(e.responseText);
                }
            });
        }

        function getMostReqirement() {
            //
            $.ajax({
                //请求方式
                dataType: "json", //返回格式为json
                async: true, //请求是否异步，默认为异步，这也是ajax重要特性

                type: "GET", //请求方式
                url: "api.admin.main.php",
                //数据，json字符串
                data: {
                    "action": "getMostReqirement",

                }, //参数值,
                //请求成功
                success: function(result) {
                    console.log("success");
                    console.log(result);
                    let sum = 0;
                    for (let i = 0; i < result.length; i++) {
                        // sum += parseFloat(result[i].expense_sum);
                        $('#req_index_'+i).html((i+1)+ '  ' + result[i].product_name);
                        
                        myDoughnutChart.data.labels[i] = result[i].product_name;
                        myDoughnutChart.data.datasets[0].data[i] = parseInt(result[i].req_sum);
                        
                    }
                    myDoughnutChart.update();



                },
                //请求失败，包含具体的错误信息
                error: function(e) {
                    console.log(e.status);
                    console.log(e.responseText);
                }
            });
        }





        /*======== 3. LINE CHART ========*/
        var chart3;
        var ctx = document.getElementById("linechart");
        if (ctx !== null) {
            chart3 = new Chart(ctx, {
                // The type of chart we want to create
                type: "line",

                // The data for our dataset
                data: {
                    labels: [

                    ],
                    datasets: [{
                        label: "",
                        backgroundColor: "transparent",
                        borderColor: "rgb(82, 136, 255)",
                        data: [

                        ],
                        lineTension: 0.3,
                        pointRadius: 5,
                        pointBackgroundColor: "rgba(255,255,255,1)",
                        pointHoverBackgroundColor: "rgba(255,255,255,1)",
                        pointBorderWidth: 2,
                        pointHoverRadius: 8,
                        pointHoverBorderWidth: 1
                    }]
                },

                // Configuration options go here
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    layout: {
                        padding: {
                            right: 10
                        }
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: false
                            }
                        }],
                        yAxes: [{
                            gridLines: {
                                display: true,
                                color: "#eee",
                                zeroLineColor: "#eee",
                            },
                            ticks: {
                                callback: function(value) {
                                    var ranges = [{
                                            divider: 1e6,
                                            suffix: "M"
                                        },
                                        {
                                            divider: 1e4,
                                            suffix: "k"
                                        }
                                    ];

                                    function formatNumber(n) {
                                        for (var i = 0; i < ranges.length; i++) {
                                            if (n >= ranges[i].divider) {
                                                return (
                                                    (n / ranges[i].divider).toString() + ranges[i].suffix
                                                );
                                            }
                                        }
                                        return n;
                                    }
                                    return formatNumber(value);
                                }
                            }
                        }]
                    },
                    tooltips: {
                        callbacks: {
                            title: function(tooltipItem, data) {
                                return data["labels"][tooltipItem[0]["index"]];
                            },
                            label: function(tooltipItem, data) {
                                return data["datasets"][0]["data"][tooltipItem["index"]] + "元";
                            }
                        },
                        responsive: true,
                        intersect: false,
                        enabled: true,
                        titleFontColor: "#888",
                        bodyFontColor: "#555",
                        titleFontSize: 12,
                        bodyFontSize: 18,
                        backgroundColor: "rgba(256,256,256,0.95)",
                        xPadding: 20,
                        yPadding: 10,
                        displayColors: false,
                        borderColor: "rgba(220, 220, 220, 0.9)",
                        borderWidth: 2,
                        caretSize: 10,
                        caretPadding: 15
                    }
                }
            });
        }

        $(function() {
            getRecentIncome();
            getRecentExpense();
            getMostReqirement();
        })


        var myDoughnutChart;
        /*======== 11. DOUGHNUT CHART ========*/
        var doughnut = document.getElementById("doChart");
        if (doughnut !== null) {
                myDoughnutChart = new Chart(doughnut, {
                type: "doughnut",
                data: {
                    labels: ["消毒酒精", "医用口罩", "医用防护服", "口罩N95"],
                    datasets: [{
                        label: ["completed", "unpaid", "pending", "canceled"],
                        data: [4100, 2500, 1800, 2300],
                        backgroundColor: ["#4c84ff", "#29cc97", "#8061ef", "#fec402"],
                        borderWidth: 1
                        // borderColor: ['#4c84ff','#29cc97','#8061ef','#fec402']
                        // hoverBorderColor: ['#4c84ff', '#29cc97', '#8061ef', '#fec402']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    cutoutPercentage: 75,
                    tooltips: {
                        callbacks: {
                            title: function(tooltipItem, data) {
                                return "急需 : " + data["labels"][tooltipItem[0]["index"]];
                            },
                            label: function(tooltipItem, data) {
                                return data["datasets"][0]["data"][tooltipItem["index"]];
                            }
                        },
                        titleFontColor: "#888",
                        bodyFontColor: "#555",
                        titleFontSize: 12,
                        bodyFontSize: 14,
                        backgroundColor: "rgba(256,256,256,0.95)",
                        displayColors: true,
                        borderColor: "rgba(220, 220, 220, 0.9)",
                        borderWidth: 2
                    }
                }
            });
        }
    </script>

</body>

</html>