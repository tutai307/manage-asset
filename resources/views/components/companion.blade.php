@props(['companion'])

{{--
    An original chibi character drawn in SVG, shaded with gradients for a soft 3D look. The call
    screen animates it through CSS only: `data-state` on an ancestor (idle | speaking | listening |
    thinking) and the `--mouth` custom property (0 closed … 1 open), driven by the voice's loudness.
    Gradient ids are unique per drawing, since one page can show the same character twice.
--}}
@php($id = 'cmp'.Illuminate\Support\Str::random(8))

<svg viewBox="0 0 200 200" role="img" aria-label="{{ $companion->name() }}" {{ $attributes->merge(['class' => 'cmp cmp-'.$companion->value]) }}>
    <defs>
        <filter id="{{ $id }}-blur" x="-20%" y="-50%" width="140%" height="200%"><feGaussianBlur stdDeviation="3.5" /></filter>
        <radialGradient id="{{ $id }}-eye" cx="38%" cy="32%" r="70%">
            <stop offset="0" stop-color="#4B5563" /><stop offset=".55" stop-color="#1F2937" /><stop offset="1" stop-color="#030712" />
        </radialGradient>
        <radialGradient id="{{ $id }}-blush" cx="50%" cy="50%" r="50%">
            <stop offset="0" stop-color="#FB7185" stop-opacity=".75" /><stop offset="1" stop-color="#FB7185" stop-opacity="0" />
        </radialGradient>
        <radialGradient id="{{ $id }}-mouth" cx="50%" cy="30%" r="70%">
            <stop offset="0" stop-color="#9F1239" /><stop offset="1" stop-color="#4C0519" />
        </radialGradient>
        <radialGradient id="{{ $id }}-shine" cx="50%" cy="50%" r="50%">
            <stop offset="0" stop-color="#fff" stop-opacity=".75" /><stop offset="1" stop-color="#fff" stop-opacity="0" />
        </radialGradient>
        @switch($companion)
            @case(App\Enums\Companion::Miu)
                <radialGradient id="{{ $id }}-skin" cx="34%" cy="26%" r="80%">
                    <stop offset="0" stop-color="#FFD9AE" /><stop offset=".5" stop-color="#FDA04E" /><stop offset="1" stop-color="#D9661C" />
                </radialGradient>
                <radialGradient id="{{ $id }}-cream" cx="45%" cy="30%" r="75%">
                    <stop offset="0" stop-color="#FFFFFF" /><stop offset="1" stop-color="#FCE7D2" />
                </radialGradient>
                <linearGradient id="{{ $id }}-inner" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0" stop-color="#FDA4AF" /><stop offset="1" stop-color="#FB7185" />
                </linearGradient>
                @break
            @case(App\Enums\Companion::Robo)
                <radialGradient id="{{ $id }}-skin" cx="32%" cy="24%" r="85%">
                    <stop offset="0" stop-color="#FFFFFF" /><stop offset=".45" stop-color="#DBE4EE" /><stop offset="1" stop-color="#8FA3B8" />
                </radialGradient>
                <linearGradient id="{{ $id }}-screen" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0" stop-color="#1E3A5F" /><stop offset="1" stop-color="#0B1220" />
                </linearGradient>
                <radialGradient id="{{ $id }}-glow" cx="50%" cy="40%" r="60%">
                    <stop offset="0" stop-color="#E0FBFF" /><stop offset=".5" stop-color="#5EEAD4" /><stop offset="1" stop-color="#06B6D4" />
                </radialGradient>
                <radialGradient id="{{ $id }}-bulb" cx="35%" cy="30%" r="70%">
                    <stop offset="0" stop-color="#FFE4E6" /><stop offset=".4" stop-color="#FB7185" /><stop offset="1" stop-color="#BE123C" />
                </radialGradient>
                <filter id="{{ $id }}-neon"><feGaussianBlur stdDeviation="2.2" result="b" /><feMerge><feMergeNode in="b" /><feMergeNode in="SourceGraphic" /></feMerge></filter>
                @break
            @case(App\Enums\Companion::Dino)
                <radialGradient id="{{ $id }}-skin" cx="34%" cy="26%" r="80%">
                    <stop offset="0" stop-color="#D9FBE5" /><stop offset=".5" stop-color="#5BE08F" /><stop offset="1" stop-color="#15924A" />
                </radialGradient>
                <radialGradient id="{{ $id }}-cream" cx="45%" cy="30%" r="75%">
                    <stop offset="0" stop-color="#FFFDF0" /><stop offset="1" stop-color="#FDE68A" />
                </radialGradient>
                <linearGradient id="{{ $id }}-spike" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0" stop-color="#FDBA74" /><stop offset="1" stop-color="#EA580C" />
                </linearGradient>
                @break
            @case(App\Enums\Companion::Oli)
                <radialGradient id="{{ $id }}-skin" cx="34%" cy="24%" r="85%">
                    <stop offset="0" stop-color="#E9CDA8" /><stop offset=".5" stop-color="#B07D52" /><stop offset="1" stop-color="#6E4A2E" />
                </radialGradient>
                <radialGradient id="{{ $id }}-cream" cx="45%" cy="30%" r="75%">
                    <stop offset="0" stop-color="#FFFBF3" /><stop offset="1" stop-color="#EFD9B8" />
                </radialGradient>
                <linearGradient id="{{ $id }}-beak" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0" stop-color="#FCD34D" /><stop offset="1" stop-color="#F59E0B" />
                </linearGradient>
                @break
        @endswitch
    </defs>

    <ellipse cx="100" cy="189" rx="50" ry="7" fill="#0F172A" opacity=".18" filter="url(#{{ $id }}-blur)" />

    <g class="cmp-bob">
        @switch($companion)
            @case(App\Enums\Companion::Miu)
                {{-- Miu: a cheerful orange kitten --}}
                <path class="cmp-tail" d="M132 172 C162 172 172 150 162 132" fill="none" stroke="url(#{{ $id }}-skin)" stroke-width="11" stroke-linecap="round" />
                <ellipse cx="100" cy="164" rx="36" ry="26" fill="url(#{{ $id }}-skin)" />
                <ellipse cx="100" cy="170" rx="20" ry="15" fill="url(#{{ $id }}-cream)" />
                <ellipse cx="84" cy="186" rx="11" ry="7" fill="url(#{{ $id }}-cream)" />
                <ellipse cx="116" cy="186" rx="11" ry="7" fill="url(#{{ $id }}-cream)" />
                <g class="cmp-head">
                    <path class="cmp-ear-l" d="M44 76 Q40 30 56 22 Q70 30 92 50 Z" fill="url(#{{ $id }}-skin)" />
                    <path d="M54 62 Q53 38 60 34 Q70 40 80 52 Z" fill="url(#{{ $id }}-inner)" />
                    <path class="cmp-ear-r" d="M156 76 Q160 30 144 22 Q130 30 108 50 Z" fill="url(#{{ $id }}-skin)" />
                    <path d="M146 62 Q147 38 140 34 Q130 40 120 52 Z" fill="url(#{{ $id }}-inner)" />
                    <ellipse cx="100" cy="92" rx="68" ry="58" fill="url(#{{ $id }}-skin)" />
                    <path d="M84 40 Q88 52 82 60 M100 36 L100 52 M116 40 Q112 52 118 60" stroke="#D9661C" stroke-width="5" stroke-linecap="round" fill="none" opacity=".7" />
                    <ellipse cx="74" cy="56" rx="22" ry="12" fill="url(#{{ $id }}-shine)" transform="rotate(-20 74 56)" />
                    <ellipse cx="100" cy="122" rx="30" ry="20" fill="url(#{{ $id }}-cream)" />
                    <g class="cmp-eye">
                        <ellipse cx="73" cy="96" rx="15" ry="18" fill="url(#{{ $id }}-eye)" />
                        <g class="cmp-pupil"><circle cx="78" cy="88" r="6" fill="#fff" /><circle cx="68" cy="104" r="2.6" fill="#fff" opacity=".85" /></g>
                    </g>
                    <g class="cmp-eye">
                        <ellipse cx="127" cy="96" rx="15" ry="18" fill="url(#{{ $id }}-eye)" />
                        <g class="cmp-pupil"><circle cx="132" cy="88" r="6" fill="#fff" /><circle cx="122" cy="104" r="2.6" fill="#fff" opacity=".85" /></g>
                    </g>
                    <ellipse cx="54" cy="118" rx="13" ry="8" fill="url(#{{ $id }}-blush)" />
                    <ellipse cx="146" cy="118" rx="13" ry="8" fill="url(#{{ $id }}-blush)" />
                    <path d="M95 112 Q100 109 105 112 Q103 117 100 118 Q97 117 95 112 Z" fill="#F472B6" />
                    <path d="M90 121 Q95 126 100 121 Q105 126 110 121" stroke="#9A3412" stroke-width="2.2" fill="none" stroke-linecap="round" />
                    <ellipse class="cmp-mouth" cx="100" cy="128" rx="7" ry="6" fill="url(#{{ $id }}-mouth)" />
                    <path d="M62 120 L38 116 M62 126 L40 130 M138 120 L162 116 M138 126 L160 130" stroke="#9A5B1E" stroke-width="1.8" stroke-linecap="round" opacity=".55" />
                </g>
                @break

            @case(App\Enums\Companion::Robo)
                {{-- Robo: a clumsy, friendly little robot --}}
                <rect x="70" y="146" width="60" height="40" rx="18" fill="url(#{{ $id }}-skin)" />
                <circle cx="100" cy="166" r="8" fill="url(#{{ $id }}-glow)" class="cmp-light" filter="url(#{{ $id }}-neon)" />
                <ellipse cx="62" cy="164" rx="9" ry="13" fill="url(#{{ $id }}-skin)" transform="rotate(20 62 164)" />
                <ellipse cx="138" cy="164" rx="9" ry="13" fill="url(#{{ $id }}-skin)" transform="rotate(-20 138 164)" />
                <g class="cmp-head">
                    <path d="M100 38 Q98 26 104 16" stroke="#94A3B8" stroke-width="4" fill="none" stroke-linecap="round" />
                    <circle cx="104" cy="14" r="8" fill="url(#{{ $id }}-bulb)" class="cmp-light" />
                    <circle cx="30" cy="96" r="13" fill="url(#{{ $id }}-skin)" />
                    <circle cx="170" cy="96" r="13" fill="url(#{{ $id }}-skin)" />
                    <circle cx="30" cy="96" r="5" fill="url(#{{ $id }}-glow)" />
                    <circle cx="170" cy="96" r="5" fill="url(#{{ $id }}-glow)" />
                    <rect x="34" y="36" width="132" height="112" rx="44" fill="url(#{{ $id }}-skin)" />
                    <rect x="48" y="52" width="104" height="80" rx="32" fill="url(#{{ $id }}-screen)" />
                    <ellipse cx="78" cy="62" rx="22" ry="7" fill="#fff" opacity=".14" />
                    <g class="cmp-eye" filter="url(#{{ $id }}-neon)">
                        <ellipse cx="76" cy="90" rx="11" ry="14" fill="url(#{{ $id }}-glow)" />
                        <circle class="cmp-pupil" cx="79" cy="85" r="3.6" fill="#fff" />
                    </g>
                    <g class="cmp-eye" filter="url(#{{ $id }}-neon)">
                        <ellipse cx="124" cy="90" rx="11" ry="14" fill="url(#{{ $id }}-glow)" />
                        <circle class="cmp-pupil" cx="127" cy="85" r="3.6" fill="#fff" />
                    </g>
                    <ellipse cx="58" cy="114" rx="9" ry="5" fill="url(#{{ $id }}-blush)" />
                    <ellipse cx="142" cy="114" rx="9" ry="5" fill="url(#{{ $id }}-blush)" />
                    <rect class="cmp-mouth" x="88" y="112" width="24" height="9" rx="4.5" fill="url(#{{ $id }}-glow)" filter="url(#{{ $id }}-neon)" />
                    <ellipse cx="66" cy="46" rx="20" ry="8" fill="url(#{{ $id }}-shine)" transform="rotate(-12 66 46)" />
                </g>
                @break

            @case(App\Enums\Companion::Dino)
                {{-- Dino: a silly, hungry baby dinosaur --}}
                <path d="M128 176 Q160 180 168 160 Q150 168 132 160 Z" fill="url(#{{ $id }}-skin)" />
                <ellipse cx="100" cy="164" rx="36" ry="27" fill="url(#{{ $id }}-skin)" />
                <ellipse cx="100" cy="170" rx="21" ry="17" fill="url(#{{ $id }}-cream)" />
                <ellipse cx="70" cy="156" rx="7" ry="10" fill="url(#{{ $id }}-skin)" transform="rotate(30 70 156)" />
                <ellipse cx="130" cy="156" rx="7" ry="10" fill="url(#{{ $id }}-skin)" transform="rotate(-30 130 156)" />
                <ellipse cx="84" cy="188" rx="12" ry="6" fill="url(#{{ $id }}-skin)" />
                <ellipse cx="116" cy="188" rx="12" ry="6" fill="url(#{{ $id }}-skin)" />
                <g class="cmp-head">
                    <path d="M66 46 Q72 22 82 38 Q90 14 100 34 Q110 14 118 38 Q128 22 134 46 Z" fill="url(#{{ $id }}-spike)" />
                    <ellipse cx="100" cy="94" rx="68" ry="58" fill="url(#{{ $id }}-skin)" />
                    <ellipse cx="74" cy="58" rx="22" ry="12" fill="url(#{{ $id }}-shine)" transform="rotate(-18 74 58)" />
                    <circle cx="140" cy="70" r="5" fill="#15924A" opacity=".35" /><circle cx="150" cy="86" r="3.5" fill="#15924A" opacity=".35" />
                    <g class="cmp-eye">
                        <ellipse cx="73" cy="92" rx="17" ry="19" fill="#fff" />
                        <ellipse cx="75" cy="95" rx="12" ry="14" fill="url(#{{ $id }}-eye)" />
                        <g class="cmp-pupil"><circle cx="79" cy="88" r="5" fill="#fff" /><circle cx="70" cy="101" r="2.2" fill="#fff" opacity=".85" /></g>
                    </g>
                    <g class="cmp-eye">
                        <ellipse cx="127" cy="92" rx="17" ry="19" fill="#fff" />
                        <ellipse cx="125" cy="95" rx="12" ry="14" fill="url(#{{ $id }}-eye)" />
                        <g class="cmp-pupil"><circle cx="129" cy="88" r="5" fill="#fff" /><circle cx="120" cy="101" r="2.2" fill="#fff" opacity=".85" /></g>
                    </g>
                    <ellipse cx="52" cy="120" rx="13" ry="8" fill="url(#{{ $id }}-blush)" />
                    <ellipse cx="148" cy="120" rx="13" ry="8" fill="url(#{{ $id }}-blush)" />
                    <circle cx="92" cy="114" r="2.4" fill="#166534" /><circle cx="108" cy="114" r="2.4" fill="#166534" />
                    <ellipse class="cmp-mouth" cx="100" cy="128" rx="16" ry="8" fill="url(#{{ $id }}-mouth)" />
                    <path d="M89 124 L92 130 L95 124 Z M105 124 L108 130 L111 124 Z" fill="#fff" />
                </g>
                @break

            @case(App\Enums\Companion::Oli)
                {{-- Oli: a kind, wise little owl with round glasses --}}
                <path class="cmp-wing-l" d="M42 116 Q20 150 48 176 Q58 146 56 116 Z" fill="url(#{{ $id }}-skin)" />
                <path class="cmp-wing-r" d="M158 116 Q180 150 152 176 Q142 146 144 116 Z" fill="url(#{{ $id }}-skin)" />
                <path d="M82 184 l-4 6 M88 184 v7 M94 184 l4 6 M106 184 l-4 6 M112 184 v7 M118 184 l4 6" stroke="#F59E0B" stroke-width="3.5" stroke-linecap="round" />
                <g class="cmp-head">
                    <path class="cmp-ear-l" d="M50 54 Q42 30 48 18 Q66 30 80 44 Z" fill="url(#{{ $id }}-skin)" />
                    <path class="cmp-ear-r" d="M150 54 Q158 30 152 18 Q134 30 120 44 Z" fill="url(#{{ $id }}-skin)" />
                    <ellipse cx="100" cy="112" rx="62" ry="74" fill="url(#{{ $id }}-skin)" />
                    <ellipse cx="72" cy="58" rx="22" ry="11" fill="url(#{{ $id }}-shine)" transform="rotate(-20 72 58)" />
                    <ellipse cx="100" cy="150" rx="36" ry="32" fill="url(#{{ $id }}-cream)" />
                    <path d="M86 142 q4 4 8 0 M106 142 q4 4 8 0 M96 158 q4 4 8 0" stroke="#C9A37A" stroke-width="2.5" fill="none" stroke-linecap="round" />
                    <path d="M100 116 Q72 124 52 104 Q50 70 74 64 Q92 62 100 78 Q108 62 126 64 Q150 70 148 104 Q128 124 100 116 Z" fill="url(#{{ $id }}-cream)" />
                    <g class="cmp-eye">
                        <ellipse cx="76" cy="92" rx="14" ry="16" fill="url(#{{ $id }}-eye)" />
                        <g class="cmp-pupil"><circle cx="81" cy="85" r="5.5" fill="#fff" /><circle cx="71" cy="99" r="2.4" fill="#fff" opacity=".85" /></g>
                    </g>
                    <g class="cmp-eye">
                        <ellipse cx="124" cy="92" rx="14" ry="16" fill="url(#{{ $id }}-eye)" />
                        <g class="cmp-pupil"><circle cx="129" cy="85" r="5.5" fill="#fff" /><circle cx="119" cy="99" r="2.4" fill="#fff" opacity=".85" /></g>
                    </g>
                    <circle cx="76" cy="92" r="23" fill="#fff" fill-opacity=".12" stroke="#4F46E5" stroke-width="4" />
                    <circle cx="124" cy="92" r="23" fill="#fff" fill-opacity=".12" stroke="#4F46E5" stroke-width="4" />
                    <path d="M97 90 Q100 86 103 90" stroke="#4F46E5" stroke-width="4" fill="none" stroke-linecap="round" />
                    <ellipse cx="54" cy="116" rx="10" ry="6" fill="url(#{{ $id }}-blush)" />
                    <ellipse cx="146" cy="116" rx="10" ry="6" fill="url(#{{ $id }}-blush)" />
                    <path d="M90 110 Q100 104 110 110 L100 122 Z" fill="url(#{{ $id }}-beak)" />
                    <path class="cmp-mouth" d="M93 119 L107 119 L100 128 Z" fill="#D97706" />
                </g>
                @break
        @endswitch
    </g>
</svg>
