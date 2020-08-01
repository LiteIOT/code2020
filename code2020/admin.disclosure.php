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

        <div id="content-wrapper">
            <div class="container-fluid" id="app">

                <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="./disclosure.html">接收列表</a>
                    </li>
                </ol>


                <div class="card mb-3" v-if="editMode==false">
                    <div class="card-header">
                        <i class="fas fa-table"></i>
                        物资列表</div>


                    <div class="card-body" id="postlist">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <!--th>证据ID</th-->
                                        <th>名称</th>
                                        <th>在库数量</th>
                                        <th>需求数量</th>
                                        <th>调拨</th>


                                    </tr>
                                </thead>
                                <!--tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>标题</th>
                                        <th>操作</th>
                                    </tr>
                                </tfoot-->
                                <tbody v-for="(todo, index) in dataList">
                                    <tr>
                                        <!--td>[{{ index+1 }}] </td-->
                                        <td>
                                            <!--{{ todo.post_id }}-->{{ todo.product_name }}</td>
                                        <td style="max-width:500px">{{ todo.product_remain }}{{ todo.product_unit }}</td>
                                        <td style="max-width:500px">{{ (todo.product_sum_req>0)?todo.product_sum_req:0 }}{{ todo.product_unit }}</td>
                                        <td style="max-width:500px"><a :href="'transfer.html?product_id='+todo.product_id">调拨</a></td>

                                        <td>

                                            <!--button type="button" class="btn btn-primary"
                                                v-on:click="viewDevice(todo.device_id)">
                                                详情
                                            </button-->
                                            <button type="button" class="btn btn-primary" v-on:click="signedEvidence(todo.trans_id)" v-if="todo.trans_signed==0">
                                                签收
                                            </button>
                                            <!--button type="button" class="btn btn-primary"
                                                v-on:click="editDevice(index)">
                                                退回
                                            </button-->
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer small text-muted"></div>
                </div>

            </div>
            <!-- /.container-fluid -->

            <!-- Sticky Footer -->
            <footer class="sticky-footer">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright © 2020</span>
                    </div>
                </div>
            </footer>

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

    <!-- Bootstrap core JavaScript-->
    <script src="dist/vue.js"></script>
    <!-- Add this after vue.js -->
    <script src="dist/axios.min.js"></script>
    <script src="dist/vue-router.js"></script>
    <script>
        function getQueryString(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
            var r = window.location.search.substr(1).match(reg);
            if (r != null) return unescape(r[2]);
            return null;
        }


        var api_url = "api.admin.product.php"

        let id = getQueryString('stu_id');

        console.log('createdList')

        var app5 = new Vue({
            el: '#app',
            data: {
                doc_id: 0,
                deviceList: [],
                doc_title: "",
                doc_content: "",
                doc_model: "",
                tipMessage: "",
                logList: [],
                editMode: false,
                log_date: "",
                dataList: []
            },

            methods: {

                refreshForm: function() {
                    var that = this;

                    that.editMode = false;


                },

                refreshLog: function() {
                    var that = this;

                    that.log_title = '';
                    that.log_date = todayTime();

                },

                getList: function() {
                    var that = this;
                    axios.get(api_url, {
                            params: {
                                action: 'listTranPost',
                                //post_id: this.post_id
                            }
                        })
                        .then(function(response) {
                            if (response.status == 200) {
                                //post_list = response.data[0]
                                // console.log(post_list)
                                that.dataList = response.data;
                                console.log(that.dataList)
                            }


                        })
                        .catch(function(error) {
                            console.log(error);
                        });

                },

                getDate: function(date) {
                    var now = new Date(date),
                        y = now.getFullYear(),
                        m = now.getMonth() + 1,
                        d = now.getDate();
                    return y + "-" + (m < 10 ? "0" + m : m) + "-" + (d < 10 ? "0" + d : d) + " " + now.toTimeString().substr(0, 8);
                }
            },

            created: function() {
                var that = this;
                that.getList()
            },
        })


        //获取当前日期 时间
        function todayTime() {
            var date = new Date();
            var curYear = date.getFullYear();
            var curMonth = date.getMonth() + 1;
            var curDate = date.getDate();
            if (curMonth < 10) {
                curMonth = '0' + curMonth;
            }
            if (curDate < 10) {
                curDate = '0' + curDate;
            }
            var curHours = date.getHours();
            var curMinutes = date.getMinutes();
            var curtime = curYear + ' 年 ' + curMonth + ' 月 ' + curDate + ' 日' + curHours + '时 ' + curMinutes + '分 ';
            return curtime;
        }
    </script>
</body>

</html>