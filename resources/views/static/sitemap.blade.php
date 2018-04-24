<?xml version="1.0" encoding="UTF-8" ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ route('homepage') }}</loc>
    </url>
	<url>
        <loc>{{ route('about') }}</loc>
    </url>
	<url>
        <loc>{{ route('partners') }}</loc>
    </url>
	<url>
        <loc>{{ route('press') }}</loc>
    </url>
	<url>
        <loc>{{ route('story') }}</loc>
    </url>
	<url>
        <loc>{{ route('terms') }}</loc>
    </url>
	<url>
        <loc>{{ route('testimonials') }}</loc>
    </url>
	<url>
        <loc>{{ route('tips') }}</loc>
    </url>
	<url>
        <loc>{{ route('privacy') }}</loc>
    </url>
	<url>
        <loc>{{ route('movement') }}</loc>
    </url>
	<url>
        <loc>{{ route('get') }}</loc>
    </url>
	<url>
        <loc>{{ route('coverage') }}</loc>
    </url>
	<url>
        <loc>{{ url('/login') }}</loc>
    </url>
	<url>
        <loc>{{ url('/register') }}</loc>
    </url>
	<url>
        <loc>{{ url('/password/reset') }}</loc>
    </url>
    @foreach($classrooms as $classroom)
        <url>
            <loc>{{ route('homepage') }}/classroom/show/{{ $classroom->id }}</loc>
        </url>
    @endforeach
	@foreach($users as $user)
        <url>
            <loc>{{ route('homepage') }}/profile/{{ $user->profile_slug }}</loc>
        </url>
    @endforeach
</urlset>