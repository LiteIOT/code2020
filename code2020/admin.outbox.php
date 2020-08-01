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
                        <a href="./outbox.html">需求列表</a>
                    </li>
                </ol>

                <div class="card mb-3" v-if="editMode==false">
                    <div class="card-header">
                        <i class="fas fa-table"></i>
                        <!--跟踪管理-->

                        <el-row :gutter="20">
                            <el-col :span="2">
                                <div class="grid-content bg-purple"></div>
                            </el-col>
                            <el-col :span="6" align="center">
                                <div class="grid-content bg-purple">
                                    <el-input placeholder="搜索" v-model="search_value">
                                    </el-input>
                                </div>
                            </el-col>
                            <el-col :span="6">
                                <div class="grid-content bg-purple">
                                    <el-date-picker v-model="date_start" align="right" type="date" placeholder="开始日期" :picker-options="pickerOptions">
                                    </el-date-picker>
                                </div>
                            </el-col>
                            <el-col :span="6">
                                <div class="grid-content bg-purple">
                                    <el-date-picker v-model="date_end" align="right" type="date" placeholder="结束日期" :picker-options="pickerOptions">
                                    </el-date-picker>
                                </div>
                            </el-col>
                            <el-col :span="6" align="center">
                                <div class="grid-content bg-purple">
                                    <el-button type="primary">搜索
                                    </el-button>
                                </div>
                            </el-col>
                        </el-row>
                    </div>


                    <el-dialog title="物资清单" :visible.sync="detailDialogVisible" width="30%" :before-close="handleClose">

                        <h6>捐赠明细</h6>
                        <p><span>{{dataList[current_id].req_recipient }}</span>
                            <br />
                            <span>{{dataList[current_id].product_name }}</span>
                            <span>{{ dataList[current_id].sum_quantity }}{{ dataList[current_id].product_unit }}</span></p>
                        <h6>捐赠方</h6>
                        <div v-if="trackList.length > 0">
                            <div v-for="(item, index) in trackList">
                                <span>{{ item.dis_datetime }} {{ item.don_donor }} {{ item.dis_quantity }} {{ item.product_unit }}</span></p>
                            </div>
                        </div>
                        <div v-else>
                            暂无
                        </div>
                        <span slot="footer" class="dialog-footer">
                            <el-button @click="detailDialogVisible = false">确 定</el-button>
                        </span>
                    </el-dialog>

                    <div class="card-body" id="postlist">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <!--th>证据ID</th-->
                                        <th>需求方</th>
                                        <th>名称</th>
                                        <th>数量</th>
                                        <th>已接收</th>
                                        <th>详情</th>
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
                                        <td style="max-width:500px">{{ todo.req_recipient }}</td>
                                        <td>{{ todo.product_name }}</td>
                                        <td style="max-width:500px">{{ todo.req_quantity }}{{ todo.product_unit }}</td>

                                        <td style="max-width:500px">{{ (todo.sum_quantity>0)? (todo.sum_quantity + todo.product_unit):"暂无"}}</td>
                                        <td style="max-width:500px">
                                            <el-button type="primary" icon="el-icon-search" v-on:click="viewDetail(index)">详情
                                            </el-button>
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
    <script src="dist/eui/2.12.0/index.js"></script>
    <script src="dist/axios.min.js"></script>
    <script src="dist/vue-router.js"></script>
    <script>
        function getQueryString(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
            var r = window.location.search.substr(1).match(reg);
            if (r != null) return unescape(r[2]);
            return null;
        }


        var api_url = "api.admin.req.php"

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
                dataList: [],
                search_value: "",
                date_start: "",
                date_end: "",
                trackList: [],
                detailDialogVisible: false,
                current_id: 0
            },



            methods: {

                addLog: function() {
                    var that = this;
                    axios.get(api_url, {
                            params: {
                                action: "addLog",
                                doc_id: that.device_id,
                                log_title: that.log_title,
                                log_date: that.log_date
                                /*
                           doc_url: this.device_url,
                           doc_content: this.device_content,
                           doc_deadline: this.device_deadline,
                           doc_model: this.device_model
                            */

                            }
                        })
                        .then(function(response) {
                            //JSON.parse(response.data);
                            console.log(response.data);
                            console.log(response.data['code']);
                            if (response.data['code'] == 1) {
                                that.getLogList()
                                that.refreshLog()
                                //window.location.href = './index.html';
                            }


                        })
                        .catch(function(error) {
                            console.log(error);
                        });

                },

                handleClose: function() {
                    var that = this;
                    that.detailDialogVisible = false;
                },

                viewDetail: function(index_id) {
                    var that = this;
                    that.detailDialogVisible = true
                    that.current_id = index_id;
                    that.getTracking(that.dataList[index_id].req_id);
                },

                getTracking: function(donation_id) {
                    var that = this;
                    axios.get(api_url, {
                            params: {
                                action: 'getTracking',
                                req_id: donation_id
                            }
                        })
                        .then(function(response) {
                            if (response.status == 200) {
                                //post_list = response.data[0]
                                // console.log(post_list)
                                that.trackList = response.data;
                                console.log(that.trackList)
                            }


                        })
                        .catch(function(error) {
                            console.log(error);
                        });

                },


                searchDevice: function() {
                    var that = this;
                    //that.editMode = true


                },



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
                                action: 'listPost',
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