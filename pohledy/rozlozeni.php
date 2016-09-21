<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <base href="<?= PATHBASE ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">-->
        <script src="jquery/jquery-1.9.1.min.js"></script>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="style.css">
        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>-->
        <script src="bootstrap/js/bootstrap.min.js"></script>

        <!--<link rel="stylesheet" href="jquery/base.css">-->
        <!--<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
        <title><?= $titulek ?></title>
    </head>
    <body>
        <script type="text/javascript">
            function confirmFunction() {
                var r = window.confirm('Opravdu chces zalohovat?');
                if (!r) {
                    window.location = "#";
                } else {
                    window.location = "zaloh";
                }
            }

        </script>

        <header>

            <nav class="navbar navbar-default">
                <div class="row">
                    <div class="container-fluid">
                        <div class="col-sm-2">
                            <div class="navbar-header">
                                <div class="navbar-brand hidden-xs" href="" style="position: absolute; top: 20px">#fandasoft</div>
                                <div class="navbar-brand hidden-sm hidden-md hidden-lg" href="">#fandasoft</div>
                            </div>
                        </div>
                        <div class="col-sm-8">

                            <div class="row">
                                <div class="col-lg-12">

                                    <ul class="nav navbar-nav">
                                        <li><a id="pridej" href="pridej">pridej</a></li>
                                        <li><a id="prehled" href="prehled">prehled</a></li>
                                        <li><a id="synchro" href="synchro">synchronizuj</a></li>
                                        <li><a id="vystav" href="vystav">vystav</a></li>
                                        <li><a id="inventura" href="inventura">inventura</a></li>
                                    </ul>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">

                                    <ul class="nav navbar-nav">
                                        <li><a id="logy" href="logy">zaznamy</a></li>
                                        <li><a id="zaloha" href="zaloh">zalohuj</a></li>
                                        <li><a id="navod" href="navod">navod</a></li>
                                        <?php
                                        if ((!isset($_SESSION['prihlasen']) || !$_SESSION['prihlasen'])) {
                                            ?>
                                            <li><a id="uzivatel" href="uzivatel">uzivatel</a></li>
                                            <?php
                                        } else {
                                            ?>
                                            <li class = "dropdown">
                                                <a id = "uzivatel" class = "dropdown-toggle" data-toggle = "dropdown" href = "#">uzivatel
                                                    <span class = "caret"></span>
                                                </a>
                                                <ul class = "dropdown-menu">
                                                    <li><a href = "uzivatel/pridej">pridej</a></li>
                                                    <li><a href = "uzivatel/odeber">odeber</a></li>
                                                    <li><a href = "uzivatel/odhlasit">logout</a></li>
                                                </ul>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class=" text-center" style = "float: right">Frantisek Jukl<br><span class = "glyphicon glyphicon-copyright-mark"></span> 2016<br></div>
                        </div>
                    </div>
                </div>






            </nav>
        </header>
        <article>
        <!--<style>
        /* The animation code */
        @keyframes example {
        from {background-color: yellow;
        }
        to {background-color: pink;
        }
        from {background-color: pink;
        }
        to {background-color: yellow;
        }
        }

        /* The element to apply the animation to */
        .a{
        background-color: yellow;
        animation-name: example;
        animation-duration: 4s;
        animation-iteration-count: infinite;
        }
        </style>
        <div class = "a" style = "font-size: xx-large; font-weight: 900; font-family: cursive; text-transform: uppercase; background-color: pink; color: red;"><center><strong>marunka je nejlepsi</strong></center></div> -->
            <?php
            $this->kontroler->vypisPohled();
            ?>
        </article>

        <script type="text/javascript">

            document.getElementById(<?php echo "'" . $this->kontroler->pohled . "'" ?>).className = 'active';
        </script>
    </body>

</html>
