@component('mail::message')
# New Post Published: {{ $post->title }}

{{ $post->description }}

@component('mail::button', ['url' => route('posts.show', $post)])
View Post
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
