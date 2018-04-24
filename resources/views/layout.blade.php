<!DOCTYPE html>
<!--[if IE 8]><html class="ie ie8"> <![endif]-->
<!--[if IE 9]><html class="ie ie9"> <![endif]-->
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="title" content="@yield('meta_title')">
    <meta name="description" content="@yield('meta_description')">
    @if (App::environment('development'))
    <meta name="robots" content="noindex, nofollow">
    @endif

    <meta itemprop="name" content="@yield('prop_title')">
    <meta itemprop="description" content="@yield('prop_description')">
    <meta itemprop="image" content="@yield('prop_image')">
    
    <script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "WebSite",
        "name": "Classrr",
        "url": "{{ route('homepage') }}"
    }
    </script>

    <meta property="og:title" content="@yield('og_title')">
    <meta property="og:description" content="@yield('og_description')">
    <meta property="og:url" content="@yield('og_url')">
    <meta property="og:image" content="@yield('og_image')">
    <meta property="og:site_name" content="Classrr">
    <meta property="og:type" content="website">

    @yield('additional_metas')

    @section('title_tag')
        <title>Classrr - @yield('title')</title>
    @show

    <!-- Favicons-->
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="{{ asset('img/apple-touch-icon-57x57-precomposed.png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="{{ asset('img/apple-touch-icon-72x72-precomposed.png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="{{ asset('img/apple-touch-icon-114x114-precomposed.png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="{{ asset('img/apple-touch-icon-144x144-precomposed.png') }}">

    <!-- CSS -->
    <link href="{{ asset('css/base.css') }}" rel="stylesheet">
    <link href="{{ asset('css/airdojo.css') }}" rel="stylesheet">
    <link href="{{ asset('css/date_time_picker.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.fileupload.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.cookiebar.css') }}" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.css" />
    <link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials-theme-flat.css" />
    <link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/fontawesome/4.7.0/css/font-awesome.min.css" />

    @yield('additional_styles')

    <!-- Google web fonts -->
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Gochi+Hand' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'>
    
    <!-- OpenSearch -->
    
    <link rel="search" type="application/opensearchdescription+xml" title="Classrr" href="/opensearch.xml">

    <!--[if lt IE 9]>
    <script src="{{ asset('js/html5shiv.min.js') }}"></script>
    <script src="{{ asset('js/respond.min.js') }}"></script>
    <![endif]-->

    <script>
        window.Laravel = {
            'csrfToken': '{{ csrf_token() }}'
        }
    </script>
    @if (App::environment('production'))
    {{-- Google Analytics --}}
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
        
        // Creates an adblock detection plugin.
        ga('provide', 'adblockTracker', function(tracker, opts) {
            var ad = document.createElement('ins');
            ad.className = 'AdSense';
            ad.style.display = 'block';
            ad.style.position = 'absolute';
            ad.style.top = '-1px';
            ad.style.height = '1px';
            document.body.appendChild(ad);
            tracker.set('dimension' + opts.dimensionIndex, !ad.clientHeight);
            document.body.removeChild(ad);
        });

        ga('create', 'UA-98664889-1', 'auto');
        ga('require', 'adblockTracker', {dimensionIndex: 1});
        ga('send', 'pageview');
    </script>
    <!-- Facebook Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
    n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
    document,'script','https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '740971052709658'); // Insert your pixel ID here.
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=740971052709658&ev=PageView&noscript=1"
    /></noscript>
    <!-- DO NOT MODIFY -->
    <!-- End Facebook Pixel Code -->
    <!-- DO NOT MODIFY -->
    <!-- Quora Pixel Code (JS Helper) -->
    <script>
    !function(q,e,v,n,t,s){if(q.qp) return; n=q.qp=function(){n.qp?n.qp.apply(n,arguments):n.queue.push(arguments);}; n.queue=[];t=document.createElement(e);t.async=!0;t.src=v; s=document.getElementsByTagName(e)[0]; s.parentNode.insertBefore(t,s);}(window, 'script', 'https://a.quora.com/qevents.js');
    qp('init', 'd57c80441b094015b8b55e858c0d2d7d');
    qp('track', 'ViewContent');
    </script>
    <noscript><img height="1" width="1" style="display:none" src="https://q.quora.com/_/ad/d57c80441b094015b8b55e858c0d2d7d/pixel?tag=ViewContent&noscript=1"/></noscript>
    <!-- End of Quora Pixel Code -->

    <link rel="manifest" href="/manifest.json" />
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
    <script>
        var OneSignal = window.OneSignal || [];
        OneSignal.push(function() {
            OneSignal.init({
                appId: "2f17b996-f54f-48df-a6b0-a6d60a6139e9",
            });
        });
    </script>
    @endif
    
</head>
<body>

<!--[if lte IE 8]>
<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a>.</p>
<![endif]-->


<div class="layer"></div>
<!-- Mobile menu overlay mask -->

<div id="vapp">
<!-- Header================================================== -->
<header>


    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-3">
                <div id="logo_home">
                    <h1><a href="{{ route('homepage') }}" title="Classrr">Classrr</a></h1>
                </div>
            </div>
            <nav class="col-md-9 col-sm-9 col-xs-9">
                <a class="cmn-toggle-switch cmn-toggle-switch__htx open_close" href="javascript:void(0);"><span>Menu mobile</span></a>
                <div class="main-menu">
                    <div id="header_menu">
                        <img src="{{ asset('img/logo_sticky-airdojo.png') }}" width="160" height="34" alt="Classrr" data-retina="true">
                    </div>
                    <a href="#" class="open_close" id="close_in"><i class="icon_set_1_icon-77"></i></a>
                    @include('shared.main_menu')

                </div><!-- End main-menu --><!-- End main-menu -->

            </nav>
        </div>
    </div><!-- container -->
</header><!-- End Header -->

@section('hero')
<section id="hero">
    <div class="intro_title hidden-xs hidden-sm">
        <h3 class="animated fadeInDown">@lang('home.tagline')</h3>
        <p class="animated fadeInDown">@lang('home.tagline_description')</p>
        {{--<a href="#" class="animated fadeInUp button_intro">View Tours</a> <a href="#" class="animated fadeInUp button_intro outline">View Tickets</a>--}}
    </div>
    @section('search_panel')
    <div id="search" class="hidden-lg hidden-md">
        <div class="tab-content">

            <div class="tab-pane active" id="transfers">
                <h3>@lang('home.tagline')<br />
                <small>@lang('home.tagline_description')</small></h3>
                @include('forms.search_panel')
            </div>

        </div>
    </div>

    <div id="search_bar_container" class="hidden-xs hidden-sm">
        <div class="container">
            <div id="search-bar-2">
                @include('forms.search_bar')
            </div>

        </div>
    </div><!-- /search_bar-->
    @show
</section><!-- End hero -->
@show

@yield('content')

</div><!-- end #vapp -->
@include('shared.footer')

<div id="toTop" class="hidden-xs"></div><!-- Back to top button -->


<!-- Common scripts -->
<script src="{{ asset('js/jquery-1.11.2.min.js') }}"></script>
<script type="text/javascript" src="{{ url('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
<script>
    (function($) {
        $.QueryString = (function(a) {
            if (a == "") return {};
            var b = {};
            for (var i = 0; i < a.length; ++i)
            {
                var p=a[i].split('=', 2);
                if (p.length != 2) continue;
                b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, " "));
            }
            return b;
        })(window.location.search.substr(1).split('&'))
    })(jQuery);
</script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/Sortable/1.4.2/Sortable.min.js"></script>
<script src="{{ asset('js/common_scripts_min.js') }}"></script>
<script src="{{ asset('js/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('js/functions.js') }}"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps_key') }}"></script>
@include('layouts.vuejs')
<script src="{{ asset('js/custom.js') }}"></script>
<script src="{{ asset('js/jquery.ddslick.js') }}"></script>
<script>
    //Search bar
    $(function () {
        "use strict";
        $("select.ddslick").each(function(){
            $(this).ddslick({
                showSelectedHTML: true
            });
        });
    });
</script>
<script>
$("#shareIcons").jsSocials({
    shareIn: "popup",
    showLabel: false,
    showCount: false,
    shares: ["facebook", "twitter", "googleplus", "email"]

});
</script>


@yield('additional_javascript')
<script src="https://cdn.jsdelivr.net/places.js/1/places.min.js"></script>
<script>
    var placesAutocomplete = places({
        container: document.querySelector('#search-where'),
        language: 'en',
        type: 'city'
    });
    var placesAutocompletePhone = places({
        container: document.querySelector('#search-where-phone'),
        language: 'en',
        type: 'city'
    });
</script>

<!-- Cookie bar script -->
<script src="{{ asset('js/jquery.cookiebar.js') }}"></script>
<script>
    $(document).ready(function(){
        'use strict';
        $.cookieBar({
            fixed: true
        });
        });
</script>

@unless (Auth::check())
<!-- Pop up script  -->
<script>var base_url = "{{ route('homepage') }}";</script>
{{--
<script type="text/javascript" src="{{ asset('js/pop_up.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/pop_up_func.js') }}"></script>
--}}
@else
<!-- Pop up script  -->
<script>var base_url = "{{ route('homepage') }}";</script>
@endif

<!-- Fixed sidebar -->
<script src="{{ asset('js/theia-sticky-sidebar.js') }}"></script>
<script>
    jQuery('#sidebar').theiaStickySidebar({
        additionalMarginTop: 80
    });
</script>
@include('shared.js-localization')

@yield('fbpixel')

@yield('customscript')

@if (App::environment('production'))
{{-- Clicky Analytics --}}
<script type="text/javascript">
var clicky_site_ids = clicky_site_ids || [];
clicky_site_ids.push(101058828);
(function() {
  var s = document.createElement('script');
  s.type = 'text/javascript';
  s.async = true;
  s.src = '//static.getclicky.com/js';
  ( document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0] ).appendChild( s );
})();
</script>
<noscript><p><img alt="Clicky" width="1" height="1" src="//in.getclicky.com/101058828ns.gif" /></p></noscript>
@endif

</body>
</html>