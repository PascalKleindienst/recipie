<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <style>
            /* ! tailwindcss v3.4.1 | MIT License | https://tailwindcss.com */
            *,
            ::after,
            ::before {
                box-sizing: border-box;
                border-width: 0;
                border-style: solid;
                border-color: #e5e7eb;
            }
            ::after,
            ::before {
                --tw-content: '';
            }
            :host,
            html {
                line-height: 1.5;
                -webkit-text-size-adjust: 100%;
                -moz-tab-size: 4;
                tab-size: 4;
                font-family:
                    Figtree,
                    ui-sans-serif,
                    system-ui,
                    sans-serif,
                    Apple Color Emoji,
                    Segoe UI Emoji,
                    Segoe UI Symbol,
                    Noto Color Emoji;
                font-feature-settings: normal;
                font-variation-settings: normal;
                -webkit-tap-highlight-color: transparent;
            }
            body {
                margin: 0;
                line-height: inherit;
            }
            hr {
                height: 0;
                color: inherit;
                border-top-width: 1px;
            }
            abbr:where([title]) {
                -webkit-text-decoration: underline dotted;
                text-decoration: underline dotted;
            }
            h1,
            h2,
            h3,
            h4,
            h5,
            h6 {
                font-size: inherit;
                font-weight: inherit;
            }
            a {
                color: inherit;
                text-decoration: inherit;
            }
            b,
            strong {
                font-weight: bolder;
            }
            code,
            kbd,
            pre,
            samp {
                font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, 'Liberation Mono', 'Courier New', monospace;
                font-feature-settings: normal;
                font-variation-settings: normal;
                font-size: 1em;
            }
            small {
                font-size: 80%;
            }
            sub,
            sup {
                font-size: 75%;
                line-height: 0;
                position: relative;
                vertical-align: baseline;
            }
            sub {
                bottom: -0.25em;
            }
            sup {
                top: -0.5em;
            }
            table {
                text-indent: 0;
                border-color: inherit;
                border-collapse: collapse;
            }
            button,
            input,
            optgroup,
            select,
            textarea {
                font-family: inherit;
                font-feature-settings: inherit;
                font-variation-settings: inherit;
                font-size: 100%;
                font-weight: inherit;
                line-height: inherit;
                color: inherit;
                margin: 0;
                padding: 0;
            }
            button,
            select {
                text-transform: none;
            }
            [type='button'],
            [type='reset'],
            [type='submit'],
            button {
                -webkit-appearance: button;
                background-color: transparent;
                background-image: none;
            }
            :-moz-focusring {
                outline: auto;
            }
            :-moz-ui-invalid {
                box-shadow: none;
            }
            progress {
                vertical-align: baseline;
            }
            ::-webkit-inner-spin-button,
            ::-webkit-outer-spin-button {
                height: auto;
            }
            [type='search'] {
                -webkit-appearance: textfield;
                outline-offset: -2px;
            }
            ::-webkit-search-decoration {
                -webkit-appearance: none;
            }
            ::-webkit-file-upload-button {
                -webkit-appearance: button;
                font: inherit;
            }
            summary {
                display: list-item;
            }
            blockquote,
            dd,
            dl,
            figure,
            h1,
            h2,
            h3,
            h4,
            h5,
            h6,
            hr,
            p,
            pre {
                margin: 0;
            }
            fieldset {
                margin: 0;
                padding: 0;
            }
            legend {
                padding: 0;
            }
            menu,
            ol,
            ul {
                list-style: none;
                margin: 0;
                padding: 0;
            }
            dialog {
                padding: 0;
            }
            textarea {
                resize: vertical;
            }
            input::placeholder,
            textarea::placeholder {
                opacity: 1;
                color: #9ca3af;
            }
            [role='button'],
            button {
                cursor: pointer;
            }
            :disabled {
                cursor: default;
            }
            audio,
            canvas,
            embed,
            iframe,
            img,
            object,
            svg,
            video {
                display: block;
                vertical-align: middle;
            }
            img,
            video {
                max-width: 100%;
                height: auto;
            }
            [hidden] {
                display: none;
            }
        </style>

        <style>
            {{ \Illuminate\Support\Facades\Vite::content('resources/css/pdf.css') }}
        </style>
        @vite(['resources/css/pdf.css'])
    </head>
    <body class="">
        @if ($recipe->image)
            <div
                class="header"
                style="
                    background-image: url('data:image/jpg;base64,{{ base64_encode(\Illuminate\Support\Facades\Storage::disk('public')->get($recipe->image)) }}');
                    background-size: cover;
                    background-repeat: no-repeat;
                    background-position: center center;
                "
            ></div>
        @endif

        <div class="content">
            <h1 class="title">{{ $recipe->title }}</h1>
            <div class="description">
                {{ $recipe->description }}
            </div>

            <table class="meta">
                <tr>
                    @if ($recipe->cuisine)
                        <td class="meta__cuisine">
                            {{ __('recipe.fields.cuisine') }}
                            <div class="font-bold">{{ $recipe->cuisine }}</div>
                        </td>
                    @endif

                    <td class="meta__servings">
                        {{ __('recipe.fields.servings') }}
                        <div class="font-bold">{{ $recipe->servings }}</div>
                    </td>

                    <td class="meta__preptime">
                        {{ __('recipe.fields.preptime') }}
                        <div class="font-bold">{{ Number::format($recipe->preptime, locale: app()->getLocale()) }} min</div>
                    </td>

                    <td class="meta__cooktime">
                        {{ __('recipe.fields.cooktime') }}
                        <div class="font-bold">{{ Number::format($recipe->cooktime, locale: app()->getLocale()) }} min</div>
                    </td>

                    <td class="meta__difficulty">
                        {{ __('recipe.fields.difficulty') }}
                        <div class="font-bold">{{ $recipe->difficulty->label() }}</div>
                    </td>
                </tr>
            </table>

            <table class="main">
                <tr>
                    <td><h2>Zutaten</h2></td>
                    <td><h2>Schritte</h2></td>
                </tr>

                <tr>
                    <td class="valign-top gap-2-cols">
                        <table>
                            @foreach ($recipe->ingredients as $ingredient)
                                <tr>
                                    <td class="pr-2 pb-2 font-bold">{{ $ingredient->amount }}{{ $ingredient->unit }}</td>
                                    <td class="pr-2 pb-2">{{ $ingredient->name }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                    <td class="valign-top">
                        <ol>
                            @foreach ($recipe->instructions as $instruction)
                                <li>{{ $instruction->content }}</li>
                            @endforeach
                        </ol>
                    </td>
                </tr>
            </table>

            @if ($recipe->nutrients)
                <table class="nutrients">
                    <tr>
                        @foreach ($recipe->nutrients as $nutrient)
                            <td>
                                <div class="nutrients__label">
                                    {{ $nutrient->type->label() }}
                                </div>

                                <div class="nutrients__amount">
                                    {{ $nutrient->formatAmount() }}
                                </div>
                            </td>
                        @endforeach
                    </tr>
                </table>
            @endif
        </div>
    </body>
</html>
