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
                        <a href="./analysis.html">调拨列表</a>
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
                                    <el-button type="primary" v-on:click="onSearch">搜索
                                    </el-button>
                                </div>
                            </el-col>
                        </el-row>
                    </div>


                    <div class="card-body" id="postlist">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <!--th>证据ID</th-->
                                        <th>日期</th>
                                        <th>名称</th>
                                        <th>数量</th>
                                        <th>接收方</th>

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
                                        <td style="max-width:500px">{{ todo.tran_datetime }}</td>
                                        <td>
                                            <!--{{ todo.post_id }}-->{{ todo.product_name }}</td>
                                        <td style="max-width:500px">{{ todo.tran_quantity}}</td>
                                        <td style="max-width:500px">{{ todo.req_recipient }}

                                            <el-steps :active="parseInt(todo.tran_status)" :space="100" finish-status="success">
                                                <el-step title="已调拨"></el-step>
                                                <el-step title="运输中"></el-step>
                                                <el-step title="已接收"></el-step>
                                            </el-steps>
                                        </td>

                                        <td style="max-width:500px">
                                            <el-button type="primary" icon="el-icon-search" @click="openMessageBox">详情
                                            </el-button>

                                        </td>

                                    </tr>
                                </tbody>
                            </table>

                            <el-dialog title="跟踪信息" :visible.sync="dialogVisible" width="30%" :before-close="handleClose">
                                <div class="block">
                                    <el-timeline>
                                        <el-timeline-item v-for="(activity, index) in activities" :key="index" :icon="activity.icon" :type="activity.type" :color="activity.color" :size="activity.size" :timestamp="activity.timestamp">
                                            {{activity.content}}
                                        </el-timeline-item>
                                    </el-timeline>
                                </div>
                                <span slot="footer" class="dialog-footer">

                                    <el-button type="primary" @click="dialogVisible = false">确 定</el-button>
                                </span>
                            </el-dialog>


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
    <!-- import Vue before Element -->
    <script src="dist/eui/2.12.0/index.js"></script>
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


        var api_url = "api.admin.analysis.php"

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
                dialogVisible: false,
                search_value: "",
                date_start: "",
                date_end: "",
                activities: [{
                    content: '调拨物流',
                    timestamp: '2020-02-09 23:16',
                    size: 'large',
                    type: 'primary',
                    icon: 'el-icon-more'
                }, {
                    content: '出库',
                    timestamp: '2020-02-10 04:23',
                    color: '#0bbd87'
                }, {
                    content: '抵达武汉',
                    timestamp: '2020-02-11 15:46',
                    size: 'large'
                }, {
                    content: '到达协和医院',
                    timestamp: '2020-02-11 17:05'
                }]
            },



            methods: {

                openMessageBox: function() {
                    var that = this;
                    that.dialogVisible = true;
                    /*this.$alert('<strong>这是 <i>HTML</i> 片段</strong>', 'HTML 片段', {
                        dangerouslyUseHTMLString: true
                    });
                    */
                },

                handleClose: function() {
                    var that = this;
                    that.dialogVisible = false;
                    /*this.$alert('<strong>这是 <i>HTML</i> 片段</strong>', 'HTML 片段', {
                        dangerouslyUseHTMLString: true
                    });
                    */
                },

                pickerOptions: function() {
                    var that = this;
                    that.dialogVisible = true;
                    /*this.$alert('<strong>这是 <i>HTML</i> 片段</strong>', 'HTML 片段', {
                        dangerouslyUseHTMLString: true
                    });
                    */
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

                onSearch: function() {
                    var that = this;
                    axios.get(api_url, {
                            params: {
                                action: 'onSearch',
                                search_value: that.search_value
                            }
                        })
                        .then(function(response) {
                            if (response.status == 200) {
                                //post_list = response.data[0]
                                // console.log(post_list)
                                that.dataList = response.data;
                                console.log(that.dataList)
                                that.open2();
                            }


                        })
                        .catch(function(error) {
                            console.log(error);
                        });

                },

            },

            created: function() {
                var that = this;
                that.getList()
            },
        })

    </script>
</body>

</html>