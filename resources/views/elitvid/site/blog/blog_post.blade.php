@extends('layouts.elitvid.elitvid')

@section('content')
    <main>
        @include('includes.elitvid.popup_call')
        @include('includes.elitvid.popup_application')
        @include('includes.elitvid.breadcrumbs')
        @foreach($blog as $item)
            <section class="produce">
                <div class="description">
                    <div class="description-text">
                        <h1>{{$item->title}}</h1>
                    </div>
                </div>
                <div class="blok_news">
                    <style>
                        h3 {
                            font-size: 1em;
                            font-family: "Merriweather";
                            text-transform: uppercase;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            font-weight: normal;
                            padding: 0.25em 0em;
                        }

                        .decorative_elements > h3 {
                            font-size: 1.75em;
                            font-family: "Merriweather";
                            text-transform: uppercase;
                            display: block;
                            padding: 0;
                        }

                        main .navigation a button {
                            color: #FFFFFF;
                            margin-top: 1.5em;
                            width: 22.9375em;
                            height: 3.875em;
                            padding: 0.625em 0;
                            border-radius: 8px;
                            border: 1px solid #979797;
                            background: #22242A;
                            cursor: pointer;
                            transition: 0.2s;
                            text-transform: uppercase;
                        }

                        main .navigation a button:hover {
                            background-color: #FFFFFF;
                            color: #1A1B20;
                        }

                        h1 {
                            padding-top: 0.6em;
                        }

                        .produce {
                            padding: 3.75em 0 0 0;
                        }

                        .article .article__image img {
                            width: 100%;
                        }

                        main .decorative_elements .lines-decor {
                            margin-left: 22.5em;

                            .vertical-line--decor {
                                left: 60em;
                            }
                        }

                        @media (max-width: 640px) {

                            main .decorative_elements .lines-decor {
                                margin-left: 20em;
                            }

                            main .navigation h3 {
                                font-size: 0.9em;
                            }

                            main .navigation a button {
                                width: 15em;
                                height: 3em;
                            }

                        }

                        @media (max-width: 480px) {

                            main .navigation h3 {
                                font-size: 0.75em;
                            }

                            main .navigation a button {
                                width: 14em;
                                height: 3em;
                            }
                        }

                        @media (max-width: 425px) {

                            main .navigation {
                                display: block;

                                h3 a {
                                    width: 100%;

                                    button {
                                        width: 100%;
                                        height: 4em;
                                    }
                                }
                            }
                        }


                        @media (max-width: 375px) {
                            main .decorative_elements .lines-decor {
                                margin-left: 17em;
                            }
                        }

                    </style>
                    <div class="article">
                        <div class="article__image">
{{--                            <img src="{{asset('storage/'.str_replace('public/','',$item->main_image))}}" alt="Фотография cтатьи">--}}
                            <img src="{{asset('storage/'.str_replace('public/','',$blog->main_image))}}" alt="Фотография cтатьи">
                        </div>
                        <p class="text__h3">{{$item->created_at}}</p>
                    </div>
                </div>
            </section>
            <section class="decorative_elements">
                <div class="lines-decor">
                    <div class="vertical-line--decor"></div>
                    <div class="horizontal-line--decor"></div>
                    <div class="vertical-line-2--decor"></div>
                </div>
            </section>
            <section class="decorative_elements">
                {!! $item->content !!}
            </section>

        @endforeach
        <section class="navigation">
            @if($prevPost)
            <h3>
                <a href="{{route('show_blog_post', ['id' => $prevPost->id])}}">
                    <button>Предыдущая статья</button>
                </a>
            </h3>
            @endif
            @if($nextPost)
            <h3>
                <a href="{{route('show_blog_post', ['id' => $nextPost->id])}}">
                    <button>Следующая статья</button>
                </a>
            </h3>
            @endif
        </section>
    </main>
@endsection
