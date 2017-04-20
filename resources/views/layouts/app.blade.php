<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>MovieList</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
        
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">
        <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Acme" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Amaranth" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Signika+Negative" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/css/dataTables.bootstrap4.min.css" rel="stylesheet"/> 
        <link href="{{ URL::asset('css/star-rating.css') }}" rel="stylesheet"/> 
        <link rel="stylesheet" href="{{ URL::asset('css/fa-animation.min.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/sweetalert.css') }}">

        
        <!-- jQuery & jQuery UI-->
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/themes/smoothness/jquery-ui.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
        
        <!-- JavaScripts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script> 
        <script src="{{ URL::asset('js/jquery.livequery.js') }}"></script>
        <script src="{{ URL::asset('js/star-rating.js') }}"></script>
        <script src="{{ URL::asset('js/readmore.js') }}"></script>
        <script src="{{ URL::asset('js/sweetalert.min.js') }}"></script>
        <script src="{{ URL::asset('js/jquery.jscroll.js') }}"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/jquery.dataTables.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.13/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/fixedcolumns/3.2.2/js/dataTables.fixedColumns.min.js"></script>

        
    </head>

    <script>
        $(document).ready(function() {

            function containsAll(needles, haystack){
                var check = true; 
                for(var i = 0 , len = needles.length; i < len; i++){
                    if($.inArray(needles[i], haystack) < 0) {
                        check = false;
                        break;
                    }
                    check = true;
                }

                return check;
            } 

            //Show movie poster and desc when hovering over row on top movie list
            $('.movie_row').on('mouseenter', function() {
                var movie_id = $(this).data('id');

                $('.h_' + movie_id).css({
                    'opacity': 1,
                    'visibility': 'visible'
                });   
            });

            $('.movie_row').on('mouseleave', function() {
                $('.hover-box').css({
                    'opacity': 0,
                    'visibility': 'hidden'
                });
            });

            $('.select2').select2(); 

            var movie_star = $('.newRating').html();
                review_star = $('.reviewRating').html();
                showRevStar = $('.star_rating').html();

            $("#movie-star").rating('update', movie_star);

            $("#review-star").rating('update', review_star);

            $('#review_rate').rating('update', showRevStar);

            $('.rev-star').livequery(function() {
                $(this).each(function() {
                    value = $(this).attr('id');

                    $(this).rating('update', value);
                }); 
            }) 

            $('#movie-star').on('rating.change', function(event, value, caption) {  
                var movie_id = $('.b-rev').data('id');
                    rating = value;

                $.ajax({
                    method: 'POST',
                    url: '/rating',
                    data: { 
                        '_token': '{{ csrf_token() }}',
                        'mid': movie_id,
                        'rating': rating 
                    }                    
                });
            }); 

            //Like movie
            $('#like_movie').on('click', function() {

                var movie_id = $('.b-rev').data('id');

                $.ajax({
                    method: 'POST',
                    url: '/showMovie/like',
                    data: { 
                        '_token': '{{ csrf_token() }}',
                        'mid': movie_id 
                    },
                    success: function(data) {
                        $('#like_movie').replaceWith('<span class="glyphicon glyphicon-heart red" aria-hidden="true"></span>');
                        $('.tooltip').css('display', 'none');
                        $('.glyphicon-heart').css('animation', 'heartbeat 0.8s');
                    }
                });
            })

            //Like review
            $('#like_review').on('click', function() {
                var movie_id = $('.star_rating').data('mid');
                    user_id = $('.star_rating').data('uid');
                    review_id = $('.star_rating').data('rid');

                $.ajax({
                    method: 'POST',
                    url: '/reviews/like',
                    data: { 
                        '_token': '{{ csrf_token() }}',
                        'mid': movie_id,
                        'uid': user_id,
                        'rid': review_id
                    },
                    success: function(data) {
                        $('#like_review').replaceWith('<span class="g glyphicon glyphicon-heart red" aria-hidden="true"></span>');
                        $('.tooltip').css('display', 'none');
                        $('.glyphicon-heart').css('animation', 'heartbeat 0.8s');
                    }
                });
            })

            //Browse - on hover show heart and title
            $(document).on('mouseover', '.search-item', function() {
                $(this).find('.addmovie').css('opacity', 1);
                $(this).find('.title').css('opacity', 1);
            });

            $(document).on('mouseout', '.search-item', function() {
                $(this).find('.addmovie').css('opacity', 0);
                $(this).find('.title').css('opacity', 0);
            });

            //Insert movie id into modal
            $('.heart').on('click', function() {
                var movie_id = $(this).data('id');
                $('.modal-body #mid').val(movie_id);
            });

            $('.b-rev').on('click', function() {
                var movie_id = $(this).data('id');
                $('.modal-body #mid2').val(movie_id);
            });

            $('.movie_row').on('click', function() {
                var movie_id = $(this).data('id');
                    movie_title = $(this).find('.m_title').html();
                    movie_score = $(this).find('.score').html();
                $('.modal-body #mid').val(movie_id);
                $('.modal-body #mid2').html(movie_id);
                $('.modal-body #l_title').html(movie_title);
                $('.modal-body #score').val(movie_score);
            });

            $('[data-toggle="tooltip"]').tooltip();

            //Show rest of text for movie review
            $('.right-middle').readmore();

            //Stay on selected panel after refresh (settings view)
            $(function() { 
                //for bootstrap 3 use 'shown.bs.tab' instead of 'shown' in the next line
                $('a[data-toggle="tab"]').on('click', function (e) {
                    //save the latest tab; use cookies if you like 'em better:
                    localStorage.setItem('lastTab', $(e.target).attr('href'));
                });

                //go to the latest tab, if it exists:
                var lastTab = localStorage.getItem('lastTab');

                if (lastTab) {
                    $('a[href="'+lastTab+'"]').click();
                }
            });

            //Searchbar for movielist
            $('#list_table').dataTable({
                "oLanguage": { 
                    "sSearch": "",
                    "sSearchPlaceholder": "Search..."
                }, 
                "paging" : false,
                "columnDefs": [ {
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                } ],
                "ordering" : false,
                "searching": true,
                "info" : false,
                "columns": [
                
                    {
                        "orderDataType": "dom-text-numeric",
                        "orderable": false
                    },
                    { 
                        "orderDataType": "dom-text-numeric",
                        "orderable": false
                    },
                    {
                        "orderDataType": "dom-text-numeric",
                        "orderable": false
                    },
                    {
                        "orderDataType": "dom-text-numeric",
                        "orderable": false
                    },
                    {
                        "orderDataType": "dom-text-numeric",
                        "orderable": false
                    },
                    {
                        "orderDataType": "dom-text-numeric",
                        "orderable": false
                    }
                ]
             
            }); 

            //Animated top header
            $(function(){
                $('.top-header').data('size','big');
            });

            $(window).scroll(function(){
                if($(document).scrollTop() > 0)
                {
                    if($('.top-header').data('size') == 'big')
                    {
                        $('.th-top').stop().animate({
                            top: '-50px'
                        },200);
                        $('.th-box').stop().animate({
                            top: '-10px'
                        },200);
                        $('.header-logo').stop().animate({
                            width: '50px',
                            height: '40px'
                        },200);
                        $('.top-header').data('size','small');
                        $('.top-header').stop().animate({
                            height:'50px'
                        },200);

                    }
                }
                else
                {
                    if($('.top-header').data('size') == 'small')
                    {
                        $('.th-top').stop().animate({
                            top: '0'
                        },200);
                        $('.th-box').stop().animate({
                            top: '0px'
                        },200);
                        $('.header-logo').stop().animate({
                            width: '70px',
                            height: '60px'
                        },200);
                        $('.top-header').data('size','big');
                        $('.top-header').stop().animate({
                            height:'100px'
                        },200);
                    }  
                }
            });

            //Browse all -- hide and show based on selected genre
            var genre = [];

            $('.genre').on('click', function() {

                var array = [];
                var clicks = $(this).data('clicks');

                if (!clicks) {

                    $(this).css('color', 'limegreen');

                    genre.push($(this).find('.genre-name').html());

                    $('.srch-box').each(function(e) {
                        array[e] = [];

                        $(this).find('.st-gnr').each(function(i) {    
                            array[e][i] = $(this).html();
                        });
                        
                    });

                    $('.srch-box').each(function(e) {  
                        $(this).find('.st-gnr').each(function() {        
                            if(containsAll(genre, array[e]) == true) {
                                $(this).closest($('.srch-box')).show();
                            } else {
                                $(this).closest($('.srch-box')).hide();
                            }
                        }); 
                    });
             

                } else {

                    $(this).css('color', 'black');

                    genre.splice( $.inArray($(this).find('.genre-name').html(), genre), 1 );     

                    $('.srch-box').each(function(e) {
                        array[e] = [];

                        $(this).find('.st-gnr').each(function(i) {    
                            array[e][i] = $(this).html();
                        });
                    });

                    $('.srch-box').each(function(e) {
                        $(this).find('.st-gnr').each(function() {     
                            if(containsAll(genre, array[e]) == true) {
                                $(this).closest($('.srch-box')).show();
                            } else {
                                $(this).closest($('.srch-box')).hide();
                            }
                        }); 
                    });

                }

                $(this).data("clicks", !clicks);
 

            });

            //Set name of uploaded avatar image to div
            $('.avatar-label').click(function() {
                
                $('#avatar').change(function() {
                    var filename = $('#avatar').val().split('\\').pop();
                    $('.avatar-label').html(filename);
                });
            });

            //Confirm modal for delete
            $('.del').on('click', function(e) {
                e.preventDefault(); // Prevent the href from redirecting directly
                var linkURL = $(this).attr("href");
                warnBeforeRedirect(linkURL);
            });

            function warnBeforeRedirect(linkURL) {
                swal({
                    title: "Are you sure?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false
                },
                function(isConfirm){
                    if(isConfirm) {
                       window.location.href = linkURL; 
                    }  
                });
            }

            //Infinite scroll for browse
            $('.browse_pgn').hide();
            $(function() {
                $('.fb2').jscroll({
                    autoTrigger: true,
                    padding: 0,
                    nextSelector: '.browse_pgn .pagination li.active + li a',
                    contentSelector: 'div.fb2',
                    callback: function() {
                        $('.browse_pgn').remove();
                    }
                });
            });

            //Infinite scroll for userlists
            $('.list_pgn').hide();
            $(function() {
                $('.userlists').jscroll({
                    autoTrigger: true,
                    padding: 0,
                    nextSelector: '.list_pgn .pagination li.active + li a',
                    contentSelector: 'div.userlists',
                    callback: function() {
                        $('.list_pgn').remove();
                    }
                });
            });    

            //Infinite scroll for movie reviews
            $('.rev_pgn').hide();
            $('.tvrev_pgn').hide();
            
            $('.rev-box').jscroll({
                autoTrigger: true,
                nextSelector: '.rev_pgn .pagination li.active + li a',
                contentSelector: 'div.rev-box',
                callback: function() {
                    $('.rev_pgn').remove();
                }
            });

            $('.tvrev-box').jscroll({
                autoTrigger: true,
                nextSelector: '.pagination li.active + li a', 
                contentSelector: 'div.tvrev-box',
                callback: function() {
                    $('.tvrev_pgn').remove();
                }
            });  

            /* Mobile header toggle */  
            $('.fa-bars').on('click', function() {
                $('.main-body').animate({
                    'left': '150px',
                });
                $('.mobile-header').animate({
                    'left': '150px',
                });
                $('.mobile-container').animate({
                    'left': '0px',
                });

                $(this).replaceWith('<i class="fa fa-times-circle-o fa-2x"></i>');
            });

            $('.bars').click(function() {
                var clicks = $(this).data('clicks');

                if (!clicks) {

                    $('.main-body').animate({
                        'left': '150px',
                    });
                    $('.mobile-header').animate({
                        'left': '150px',
                    });
                    $('.mobile-container').animate({
                        'left': '0px',
                    });
                    
                    $('body').css('overflow-x', 'hidden');
                    $( "<style>.main-body:after { content: ''; position: absolute; width: 100%; height: calc(100% + 100px); top: 0; left: 0; background: rgba(8,8,8,0.6); z-index: 100; }</style>" ).appendTo( ".myStyle" );

                    $(this).find('.fa').replaceWith('<i class="fa fa-times-circle-o fa-2x"></i>');

                } else {
                    
                    $('.main-body').animate({
                        'left': '0px',
                    });
                    $('.mobile-header').animate({
                        'left': '0px',
                    });
                    $('.mobile-container').animate({
                        'left': '-150px',
                    });
                   
                    $('body').css('overflow-x', 'visible');
                    $('.myStyle').empty();

                    $(this).find('.fa').replaceWith('<i class="fa fa-bars fa-2x"></i>');
                }

                $(this).data("clicks", !clicks);
                
            });           

        });


    </script>

    {{Html::style('css/main.css')}}

    <style>
        .main {
            @if(Sentinel::check())
            top: 100px;
            @endif
        }
        .footer {
            background-image: url({{ URL::asset('images/footer-bg.png') }});
            @if(Sentinel::check())
            top: 100px;
            @endif
        }
    </style>

    <body>
        <div class="myStyle"></div>

        <div class="main-container">
           
            <div class="left-header">

                @if(Sentinel::check())
                    @if(Sentinel::getUser()->avatar == null)
                        <img class="profile-img" src="{{ URL::asset('images/avatars/blank.png')}}">
                    @else
                        <img class="profile-img" src="{{ URL::asset('images/avatars/'.Sentinel::getUser()->avatar.'')}}">
                    @endif
                @else
                    <img class="profile-img" src="{{ URL::asset('images/avatars/blank.png')}}">
                @endif

                @if(Route::current()->getName() != 'login' && Route::current()->getName() != 'login-form')

                <ul class="list-menu">
                    <a href="{{ action('NewsController@index') }}"><li class="menu-link"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> <span class="menu-link-text">Home</span></li></a>

                    @if(Sentinel::check())
                        <a href="{{ action('MovieListController@index') }}"><li class="menu-link"><span class="glyphicon glyphicon-list" aria-hidden="true"></span> <span class="menu-link-text">Top List</span></li></a>
                    @endif

                    <a href="{{ action('BrowseController@index', ['year' => 'all']) }}"><li class="menu-link"><span class="glyphicon glyphicon-th" aria-hidden="true"></span> <span class="menu-link-text">Browse All</span></li></a>

                    @if(Sentinel::check())
                        <a href="{{ action('ProfileController@showAccount') }}"><li class="menu-link"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <span class="menu-link-text">Profile</span></li></a>
                    @endif

                    @if(Sentinel::check())
                        @if(Sentinel::getUser()->roles()->first() != null && Sentinel::getUser()->roles()->first()->slug == 'admin')
                            <a href="{{ action('MovieController@index') }}"><li class="menu-link"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> <span class="menu-link-text">Settings</span></li></a>
                        @endif
                    @endif
                </ul>

                @else

                <ul class="login-list-menu">

                    <a href="{{ url('login-page') }}"><li class="login-menu-link">
                        <div class="glyph"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></div>
                        <div class="lmi-txt">Login</div>
                    </li></a>

                    <a href="{{ url('/') }}"><li class="login-menu-link">
                        <div class="glyph"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></div>
                        <div class="lmi-txt">Home</div>
                    </li></a>

                    <a href="{{ action('BrowseController@index', ['year' => 'all']) }}"><li class="login-menu-link">
                        <div class="glyph"><span class="glyphicon glyphicon-th" aria-hidden="true"></span></div>
                        <div class="lmi-txt">Browse</div>
                    </li></a>

                </ul>
               
                @endif

                <img class="logo" src="{{ URL::asset('images/logo.png')}}">

            </div>

            <!-- Mobile site header-->
            <div class="mobile-header">
                <div class="bars"><i class="fa fa-bars fa-2x" aria-hidden="true"></i></div>
                @if(Sentinel::check())
                    <div class="logout">
                        <form action="{{ route('logout') }}" method="POST" id="logout-form">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <a href="#" onclick="document.getElementById('logout-form').submit()"><i class="fa fa-power-off fa-2x fa-btn" aria-hidden="true" ></i></a>
                            
                        </form> 
                    </div>
                @endif
            </div>

            <div class="mobile-container">
                <ul class="mobile-ul">
                    @if(Sentinel::check() == false)
                        <a href="{{ url('login-page') }}"><li>Login</li></a>
                    @endif
                    <a href="{{ action('NewsController@index') }}"><li>Home</li></a>
                    <a href="{{ action('BrowseController@index', ['year' => 'all']) }}"><li>Browse All</li></a>
                    @if(Sentinel::check())
                        <a href="{{ action('MovieListController@index') }}"><li>Top Lists</li></a>
                        <a href="{{ action('ProfileController@showAccount') }}"><li>Profile</li></a>
                    @endif
                    <a href="{{ action('ReviewController@index') }}"><li>Reviews</li></a>
                    <a href="{{ action('MovieListController@showUserlists') }}"><li>User Lists</li></a>
                    <a href="{{ url('info') }}"><li>Info</li></a>
                    @if(Sentinel::check())
                        @if(Sentinel::getUser()->roles()->first() != null && Sentinel::getUser()->roles()->first()->slug == 'admin')
                            <a href="{{ action('MovieController@index') }}"><li class="last">Settings</li></a>
                        @endif
                    @endif
                </ul>
            </div>   


            <div class="main-body">

                <div class="top-header">

                    <div class="col-md-8 col-md-offset-2 th-top">
                        <a class="th-top-txt" href="#">Support</a>
                        <a class="th-top-txt" href="#">Contact</a>
                        <a class="th-top-txt" href="#">API</a>
                    </div>

                    <div class="col-md-8 col-md-offset-2 th-box">
                        
                        <div class="header-box">

                            <img class="header-logo" src="{{ URL::asset('images/logo-clear.png') }}">

                            <ul class="header-list">
                                <a href="{{ url('news') }}"><li class="header-link"><i class="fa fa-globe fa-btn fa-2x" aria-hidden="true" ></i> <span class="header-link-text">News</span></li></a>
                                <a href="{{ action('MovieListController@showUserlists') }}"><li class="header-link"><i class="fa fa-list-ul fa-btn fa-2x" aria-hidden="true" ></i> <span class="header-link-text">User Lists</span></li></a>
                                <a href="{{ action('ReviewController@index') }}"><li class="header-link"><i class="fa fa-pencil-square-o fa-btn fa-2x" aria-hidden="true"></i> <span class="header-link-text">Reviews</span></li></a>
                                <a href="{{ url('info') }}"><li class="header-link"><i class="fa fa-info fa-btn fa-2x" aria-hidden="true" ></i> <span class="header-link-text">Info</span></li></a>
                            </ul>

                        </div> 

                        @if(Sentinel::check())
                            <div class="logout">
                                <form action="{{ route('logout') }}" method="POST" id="logout-form">

                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="username"><a class="user-txt" href="{{ action('ProfileController@showAccount') }}">{{ Sentinel::getUser()->username }}</a><a href="#" onclick="document.getElementById('logout-form').submit()"><i class="fa fa-power-off fa-2x fa-btn" aria-hidden="true" ></i></a></div>
                                    
                                </form> 
                            </div>
                        @endif

                    </div>
           
                </div>

                <div class="main">@yield('content')</div>

                @if(Route::current()->getName() != 'login-form')
                    <div class="footer">
                        <div class="f-logo"><img class="f-img" src="{{ URL::asset('images/logo.png') }}"></div>

                        <div class="f-info">
                            <div class="f-1">
                                <div class="f-title">INFO</div>
                                <div class="f-body">
                                    <ul class="f-list">
                                        <li>About Us</li>
                                        <li>Contact</li>
                                        <li>Help</li>
                                        <li></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="f-2">
                                <div class="f-title">COMMUNITY</div>
                                <div class="f-body">
                                     <ul class="f-list">
                                        <li><a href="//www.facebook.com">Facebook</a></li>
                                        <li><a href="//www.twitter.com">Twitter</a></li>
                                        <li><a href="//www.plus.google.com">Google+</a></li>
                                        <li><a href="//www.instagram.com">Instagram</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="f-3">
                                <div class="f-title">LEGAL</div>
                                <div class="f-body">
                                    <ul class="f-list">
                                        <li>Terms of Use</li>
                                        <li>Privacy Policy</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
            
        </div>

        {{Html::style('css/mobile.css')}}

    </body>
</html>
