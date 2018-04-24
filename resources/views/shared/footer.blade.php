<footer>
    <div class="container">
		<div class="row">
            <div class="col-md-12">
                <h3>@lang('footer.about_title')</h3>
				<span>@lang('footer.about_description1')</span>
				<br /><br /><span class="hidden-xs">@lang('footer.about_description2')</span>
            </div>
        </div><!-- End row -->
        <div class="row">
            <div class="col-md-4 col-sm-3">
                <h3>@lang('footer.help')</h3>
                {{--<a href="tel://004542344599" id="phone">+45 423 445 99</a>--}}
                <a href="mailto:contact@classrr.com" id="email_footer">contact@classrr.com</a>
            </div>
            <div class="col-md-3 col-sm-3">
                <h3>@lang('footer.learn_more')</h3>
                <ul>
                    <li><a href="{{ route('about') }}">@lang('footer.about_us')</a></li>
					<li><a href="https://www.classrr.com/support/community/">@lang('footer.community')</a></li>
					<li><a href="https://www.classrr.com/blog">@lang('footer.blog')</a></li>
                    <li><a href="https://www.classrr.com/support/">@lang('footer.help_support')</a></li>
					<li><a href="{{ route('diversity') }}">@lang('footer.diversity_belonging')</a></li>
					<li><a href="https://www.classrr.com/support/contact/">@lang('footer.contact')</a></li>
                    <li><a href="{{ route('terms') }}">@lang('footer.terms')</a></li>
					<li><a href="{{ route('privacy') }}">@lang('footer.privacy')</a></li>
                </ul>
            </div>
            <div class="col-md-3 col-sm-3">
                <h3>Discover</h3>
                <ul>
					<li><a href="{{ route('coverage') }}">@lang('footer.browse_classes')</a></li>
                    <li><a href="{{ route('partners') }}">@lang('footer.partners')</a></li>
                    <li><a href="{{ route('press') }}">@lang('footer.press')</a></li>
                    <li><a href="{{ route('story') }}">@lang('footer.story')</a></li>
					<li><a href="{{ route('referral_program') }}">@lang('footer.learning_credit')</a></li>
					<li><a href="{{ route('movement') }}">@lang('footer.global_movement')</a></li>
                    {{--<li><a href="{{ route('team') }}">Team</a></li>--}}
                    <li><a href="{{ route('testimonials') }}">@lang('footer.testimonials')</a></li>
                    <li><a href="{{ route('tips') }}">@lang('footer.trust_safety')</a></li>
					
                </ul>
            </div>
            <div class="col-md-2 col-sm-3">
                <h3>@lang('footer.settings')</h3>                
                <div class="styled-select">
                    <select class="form-control" name="lang" id="lang">
                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <option 
                            value="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" 
                            hreflang="{{ $localeCode }}"
                            {{ LaravelLocalization::getCurrentLocale() == $localeCode?'selected': '' }}
                        >
                            {{ $properties['native'] }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="styled-select">
                    <select class="form-control" name="currency" id="currency">
                        <option value="USD" selected>USD</option>
                    </select>
                </div>
            </div>
        </div><!-- End row -->
        <div class="row">
            <div class="col-md-12">
                <div id="social_footer">
                    <ul>
                        <li><a href="https://www.facebook.com/classrrcom" target="_blank"><i class="icon-facebook"></i></a></li>
                        <li><a href="https://www.instagram.com/classrr/" target="_blank"><i class="icon-instagram"></i></a></li>
						<li><a href="https://plus.google.com/114048851471639358939" target="_blank"><i class="icon-googleplus"></i></a></li>
						<li><a href="https://www.youtube.com/channel/UCa9Pv7ngvvmnezXicXay_RQ" target="_blank"><i class="icon-youtube"></i></a></li>
                        <li><a href="https://twitter.com/classrr" target="_blank"><i class="icon-twitter"></i></a></li>
                    </ul>
                    <p>© Classrr 2017. @lang('footer.copyright')</p>
                </div>
            </div>
        </div><!-- End row -->
    </div><!-- End container -->
</footer><!-- End footer -->