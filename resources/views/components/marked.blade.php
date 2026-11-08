@props(['text', 'marks' => true])

{{--
    Text with [marked] parts underlined, as in pronunciation questions: "b[oo]k". Escaped first.
    Pass :marks="false" for other question types, where square brackets are ordinary text.
--}}
<span {{ $attributes }}>{!! $marks ? preg_replace('/\[(.+?)\]/u', '<u class="decoration-2 underline-offset-4">$1</u>', e($text)) : e($text) !!}</span>
