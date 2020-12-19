<?php
?>

<!-- Top Bar -->
<nav class="navbar">

    <div class="container-fluid">
        <div class="navbar-header">


            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="{{ url('/') }}"><img class="application-logo" src=" {{ asset('/storage/files/logo/logo.png') }}" /></a>

        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
            
                <!-- Call Search -->
                    <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>
                


                    <li class="dropdown">
                        <a id="top-bar-notifications" href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">
                            <i class="material-icons">notifications</i>
                            <span id="top_bar_notifications_count" class="label-count bg-red"></span>
                        </a>
                        <ul id="notifications_dropdown" class="dropdown-menu">
                            <li class="header bg-red"></li>
                            <li class="body">
                                <ul id="top-bar-notifications-menu" class="menu">

                                    

                                </ul>
                            </li>
                            <li class="footer">
                                <a href="" class=" waves-effect waves-block"></a>
                            </li>
                        </ul>
                    </li>


            <!-- #END# Tasks -->
                <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
            </ul>
        </div>
    </div>
</nav>
<!-- #Top Bar -->