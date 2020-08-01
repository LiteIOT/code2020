<?php
session_start();


if (check_login() == 1) {

  $url = "main.html";
  if (isset($url)) {
    Header("HTTP/1.1 303 See Other");
    Header("Location: $url");
  }
  die(0);
} else {
  //222

}


function check_login()
{
  $Server = "127.0.0.1";
  $database = "xidian2020";
  $uid = "root";
  $pwd = "root";
  $table = "user";
  $link = mysqli_connect($Server, $uid, $pwd, $database);

  @$username = trim($_SESSION['user_name']);
  @$userpass = trim($_SESSION['user_pass']);

  if (strlen($username) == 0 || strlen($userpass) == 0) {
    return 0;
  }

  $sql = "SELECT * FROM $table where user_name=$username";

  $data = mysqli_query($link, $sql);

  if ($data === false) {
    die(print_r(mysqli_error($link), true));
  } else {
    $i = 0;
    $row = mysqli_fetch_array($data, MYSQLI_ASSOC);

    if ($row === NULL) {

      return 0;
    } else {
      $user_pass = $row['user_pass'];
      $user_name = $row['user_name'];

      if (($user_pass == $userpass) && ($user_name == $username)) {
        return 1;
      } else {
        return 0;
      }
      //print_r($row_req);       
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>应急救灾物资管理</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicons -->
  <link href="img/favicon.png" rel="icon">
  <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Montserrat:300,400,500,700" rel="stylesheet">

  <!-- Bootstrap CSS File -->
  <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Libraries CSS Files -->
  <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="lib/animate/animate.min.css" rel="stylesheet">
  <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
  <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="dist/eui/2.12.0/index.css">

</head>

<body>

  <!--==========================
  Header
  ============================-->
  <header id="header" class="fixed-top">
    <div class="container">

      <div class="logo float-left">
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <h1 class="text-light"><a href="#header"><span>NewBiz</span></a></h1> -->
        <a href="#intro" class="scrollto"><img src="img/logo.png" alt="" class="img-fluid"></a>
      </div>

      <nav class="main-nav float-right d-none d-lg-block">
        <ul>
          <li><a href="index.html">首页</a></li>
          <li><a href="donation.html">在线捐赠</a></li>
          <li><a href="requirement.html">发布需求</a></li>
          <li class="active"><a href="login.html">物资管理</a></li>
        </ul>
      </nav><!-- .main-nav -->

    </div>
  </header><!-- #header -->



  <main id="main">

    <!--==========================
      About Us Section
    ============================-->
    <section id="about">
      <div class="container" id="app">

        <header class="section-header">
          <p></p>
          <h3>用户登录</h3>
          <p></p>



          <div class="row counters">

            <div class="col-lg-3 col-6 text-center">

            </div>

            <div class="col-lg-6 col-12 text-left">
              <el-form :model="loginForm" ref="loginForm" :rules="rules" label-width="80px">
                <el-form-item label="用户名" required prop="username">
                  <el-input v-model="loginForm.username" placeholder="用户名"></el-input>
                </el-form-item>
                <el-form-item label="密码" required prop="userpass">
                  <el-input v-model="loginForm.userpass" placeholder="密码" show-password></el-input>
                </el-form-item>

                <el-form-item class="text-center">
                  <el-button type="primary" @click="onSubmit('loginForm')">登录</el-button>
                  &nbsp;
                </el-form-item>
                <el-form-item label="测试">
                  用户名123 密码321
                </el-form-item>
              </el-form>

            </div>

            <div class="col-lg-3 col-6 text-center">

            </div>



          </div>




        </header>



      </div>
    </section><!-- #about -->


  </main>

  <!--==========================
    Footer
  ============================-->
  <footer id="footer">


    <div class="container">
      <div class="copyright">
        <span>&copy; 2020 </span><br />
        All Rights Reserved
      </div>
    </div>
  </footer><!-- #footer -->

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <!-- Uncomment below i you want to use a preloader -->
  <!-- <div id="preloader"></div> -->

  <!-- JavaScript Libraries -->
  <script src="lib/jquery/jquery.min.js"></script>
  <script src="lib/jquery/jquery-migrate.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="lib/easing/easing.min.js"></script>
  <script src="lib/mobile-nav/mobile-nav.js"></script>
  <script src="lib/wow/wow.min.js"></script>
  <script src="lib/waypoints/waypoints.min.js"></script>
  <script src="lib/counterup/counterup.min.js"></script>
  <script src="lib/owlcarousel/owl.carousel.min.js"></script>
  <script src="lib/isotope/isotope.pkgd.min.js"></script>
  <script src="lib/lightbox/js/lightbox.min.js"></script>
  <!-- Contact Form JavaScript File -->
  <script src="contactform/contactform.js"></script>

  <!-- Template Main Javascript File -->
  <script src="js/main.js"></script>

  <!-- Bootstrap core JavaScript-->
  <script src="dist/vue.js"></script>
  <!-- import Vue before Element -->
  <script src="dist/eui/2.12.0/index.js"></script>
  <!-- Add this after vue.js -->
  <script src="dist/axios.min.js"></script>
  <script src="dist/vue-router.js"></script>
  <style>
    .el-input {
      border: 1px #000000;
      border-color: blue;
    }
  </style>
  <script>
    var api_url = "api.web.user.php";
    new Vue({
      el: '#app',
      data: function() {
        return {
          loginForm: {
            username: "",
            userpass: ""
          },
          rules: {
            username: [{
              required: true,
              message: '请输入用户名',
              trigger: 'blur'
            }],
            userpass: [{
              required: true,
              message: '请填密码',
              trigger: 'blur'
            }]
          }
        }
      },

      methods: {

        onSubmit(formName) {
          var that = this;
          that.$refs[formName].validate((valid) => {
            if (valid) {
              axios.get(api_url, {
                  params: {
                    action: 'login',
                    username: that.loginForm.username,
                    userpass: that.loginForm.userpass
                  }
                })
                .then(function(response) {
                  //JSON.parse(response.data);
                  console.log(response.data);
                  console.log(response.data['code']);
                  if (response.data['code'] == 1) {
                    //that.getList()
                    that.loginSuccess();
                    window.location.href = './main.html';
                  } else {
                    //that.loginForm.userpass = "";
                    that.loginFail();
                  }


                })
                .catch(function(error) {
                  console.log(error);
                });
            } else {
              console.log('error submit!!');
              return false;
            }
          });




        },

        loginSuccess() {
          this.$message({
            message: '登录成功',
            type: 'success'
          });
        },

        loginFail() {
          this.$message({
            message: '登录失败',
            type: 'error'
          });
        },

        addPost: function() {
          var that = this;

          axios.get(api_url, {
              params: {
                action: 'addPost',
                material: that.material,
                quantity: that.quantity,
                donor: that.donor,
                contact: that.contact,
                telephone: that.telephone,
                address: that.address
              }
            })
            .then(function(response) {
              //JSON.parse(response.data);
              console.log(response.data);
              console.log(response.data['code']);
              console.log(response.data);
              console.log(response.data['code']);
              if (response.data['code'] == 1) {
                //that.getList()
                that.showMeswsage();
                that.refreshForm()
                //window.location.href = './index.html';
              }


            })
            .catch(function(error) {
              console.log(error);
            });

        },

        delPost: function(note_id) {
          var that = this;
          axios.get(api_url, {
              params: {
                action: 'delPost',
                note_id: note_id
              }
            })
            .then(function(response) {
              if (response.data['code'] == 1) {
                that.getList()
                that.refreshForm()
                //window.location.href = './index.html';
              }


            })
            .catch(function(error) {
              console.log(error);
            });

        },

        showMeswsage: function() {
          this.$message({
            message: '提交成功，感谢您的支持~',
            type: 'success'
          });
        },

        editPost: function(index_id) {
          var that = this;
          that.editMode = true
          that.note_id = that.noteList[index_id].note_id;
          that.note_title = that.noteList[index_id].note_title;
          that.note_content = that.noteList[index_id].note_content;
          that.note_deadline = that.noteList[index_id].note_deadline;
          that.note_date = that.noteList[index_id].note_date;

        },

        updatePost: function(question_id) {
          var that = this;
          //console.log(post_id);
          //console.log(that.postList[0]);
          //title = that.postList[post_id].post_title;


          axios.get(api_url, {
              params: {
                action: 'updatePost',
                note_id: that.note_id,
                note_title: that.note_title,
                note_date: that.note_date,
                note_content: that.note_content,
                note_deadline: that.note_deadline,
              }
            })
            .then(function(response) {
              if (response.data['code'] == 1) {
                that.getList()

              }


            })
            .catch(function(error) {
              console.log(error);
            });

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
                that.noteList = response.data;
                console.log(that.noteList)
              }


            })
            .catch(function(error) {
              console.log(error);
            });

        },



        refreshForm: function() {
          var that = this;
          that.material = "";
          that.quantity = "";
          that.donor = "";
          that.contact = "";
          that.telephone = "";
          that.address = "";
        },



      },

      beforeCreate() {
        console.log("login");


        var that = this;

        axios.get(api_url, {
            params: {
              action: 'checkLogin',
            }
          })
          .then(function(response) {
            //JSON.parse(response.data);
            console.log(response.data);
            console.log(response.data['code']);
            if (response.data['code'] == 1) {
              //that.getList()
              //that.loginSuccess();
              window.location.href = './main.php';
            } else {
              //that.loginFail();
            }


          })
          .catch(function(error) {
            console.log(error);
          });
      }
    })
  </script>


</body>

</html>