@extends('layouts.elitvid.elitvid')

@section('content')
    <main>
        @include('includes.elitvid.popup_call')
        @include('includes.elitvid.popup_application')
        @include('includes.elitvid.breadcrumbs')
        <section class="produce">
            <div class="description">
                <div class="description-text">
                    <h1>Новости</h1>
                </div>
            </div>
            @foreach($blogs as $blog)
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

                        .text__h3 {
                            text-transform: none;
                            font-size: 1.5em;
                        }

                        main .produce a {
                            display: flex;
                            justify-content: start;
                            align-items: center;
                        }

                        h3 button {
                            font-family: "Montserrat-Medium";
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

                        main .produce .blok_news {
                            display: grid;
                            grid-column-gap: 2.5em;
                            grid-row-gap: 2.5em;
                            grid-template-columns: repeat(auto-fill, minmax(22.5em, 1fr));
                            margin-top: 3em;

                            .news {
                                display: flex;
                                flex-direction: column;
                                /* height: 22.5em; */
                                width: 22.5em;
                                justify-self: center;
                            }
                        }

                        @media (max-width: 640px) {

                            main .produce .blok_news {
                                display: flex;
                                flex-direction: column;
                                align-items: center;
                                justify-content: center;
                                margin-top: 0em;


                                .news {
                                    display: flex;
                                    flex-direction: column;
                                    /* align-items: center; */
                                    justify-content: center;
                                    margin-top: 0em;
                                    width: 33em;
                                    /* height: 37em; */

                                    a {
                                        width: 100%;

                                        button {
                                            width: 100%;
                                        }
                                    }

                                    img {
                                        width: 37em;
                                    }
                                }
                            }
                        }

                        @media (max-width: 480px) {

                            body main .produce .blok_news {
                                grid-row-gap: 4.5em;

                                .news {
                                    width: 100%;
                                    height: 100%;

                                    img {
                                        width: 100%;
                                    }

                                    .text__h3 {
                                        font-size: 2em;
                                    }
                                }
                            }
                        }
                    </style>
                    <div class="news">
                        <div class="direction__image">
                            <a href="#">
                                <img src="{{asset('storage/'.str_replace('public/','',$blog->main_image))}}"
                                     alt="Фотография cтатьи">
                            </a>
                        </div>
                        <a href="#">
                            <h3 class="text__h3">{{$blog->title}}</h3>
                        </a>
                        <p>{{$blog->description}}</p>
                        <h3><a href="{{route('show_blog_post', ['id' => $blog->id])}}">
                                <button>Читать далее</button>
                            </a>
                        </h3>
                    </div>
                </div>
            @endforeach
        </section>
    </main>
@endsection
