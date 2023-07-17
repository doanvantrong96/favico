<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>
            Login - <?= Yii::$app->name ?>
        </title>
        <meta name="description" content="Login">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
        <!-- Call App Mode on ios devices -->
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <!-- Remove Tap Highlight on Windows Phone IE -->
        <meta name="msapplication-tap-highlight" content="no">
        <!-- base css -->
        <link rel="stylesheet" media="screen, print" href="/css/vendors.bundle.css">
        <link rel="stylesheet" media="screen, print" href="/css/app.bundle.css">
        <!-- Place favicon.ico in the root directory -->
        <link rel="shortcut icon" type="image/png" sizes="32x32" href="/img/favicon/favicon-32x32.png">
        <link rel="mask-icon" href="/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
        <!-- Optional: page related CSS-->
        <link rel="stylesheet" media="screen, print" href="/css/fa-brands.css">
    </head>
    <body>
        <div class="page-wrapper">
            <div class="page-inner bg-brand-gradient">
                <div class="page-content-wrapper bg-transparent m-0">
                    <div class="height-10 w-100 shadow-lg px-4 bg-brand-gradient">
                        <div class="d-flex align-items-center container p-0">
                            <div class="page-logo width-mobile-auto m-0 align-items-center justify-content-center p-0 bg-transparent bg-img-none shadow-0 height-9">
                                <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
                                    <img src="/img/logo.svg" alt="<?= Yii::$app->name ?>" aria-roledescription="logo" style="width:45px">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="flex-1" style="background: url(img/svg/pattern-1.svg) no-repeat center bottom fixed; background-size: cover;">
                        <div class="container py-4 py-lg-5 my-lg-5 px-4 px-sm-0">
                            <div class="row justify-content-center">
                                <div class="col-sm-12 col-md-6 col-lg-5 col-xl-5">
                                    <h1 class="text-white fw-300 mb-3 d-sm-block d-md-none text-center">
                                        Login
                                    </h1>
                                    <div class="card p-4 rounded-plus bg-faded">
                                        <?= $content ?>
                                    </div>
                                </div>
                            </div>
                            <div class="position-absolute pos-bottom pos-left pos-right p-3 text-center text-white">
                                2022 © <?= Yii::$app->name ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="/js/vendors.bundle.js"></script>
        <script src="/js/app.bundle.js"></script>
        <script type="text/javascript">
            $("#js-login-btn").click(function(event){
                var form = $("#js-login");
                
                if (form[0].checkValidity() === false){
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.addClass('was-validated');
                // Perform ajax submit here...
            });

        </script>
    </body>
</html>
