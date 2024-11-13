@extends('layout')

@section('title')Go-Tver.ru.@endsection
@section('description')GoTver — Ваш путеводитель по Тверской области@endsection

@section('head-end')
@endsection

@section('body-end')

@endsection

@section('content')
    @include('blocks.navigator-location')
    @include('blocks.popular-touring', ['current_location' => $locations[0]])
    @include('blocks.popular-articles')
    @include('blocks.tag-search')
    <script>
        let auth = {{ Auth::check() ? 'true':'false' }};
        document.addEventListener('click', function(event) {
            if (event.target && event.target.closest('.navigator-location-item') ) {
                handleClick(event);
            }

            let btn = event.target.closest('.action-item')
            if(btn){
                actionFavorite(btn)

            }
        });

        function actionFavorite(btn){
            if(auth){
                    event.target?.closest('.item-favorite')?.classList?.toggle('is-favorite')
                    let item_id = btn.getAttribute('item-id')
                    let table_name = btn.getAttribute('table_name')
                    favorite(table_name, item_id)
                } else {
                    modals.open('login-to-account')
                }
        }

        let cancelTokenSource;
        let locationId = null;
        const controller = new AbortController();
        function handleClick(event) {
            controller.abort()
            document.querySelectorAll('.navigator-location-item').forEach(e => {
                e.classList.remove('is-active')
            });

            event.target?.closest('.navigator-location-item')?.classList?.add('is-active')
            locationId = event.target.closest('.navigator-location-item').getAttribute('location-id')
            let csrf = document.querySelector('meta[name="csrf-token"]').content;


            axios.post(`/l/${locationId}`, {
                headers: {
                    'X-CSRF-Token': csrf,
                    signal: controller.signal
                }
            })
            .then(res => {
                if (res.data) {
                    let oldElement = document.querySelector(".navigator-location");
                    if (oldElement) {
                        const tempContainer = document.createElement('div');
                        tempContainer.innerHTML = res.data.navigator_location;
                        oldElement.querySelector('div.main-title').innerHTML = tempContainer.querySelector('div.main-title').innerHTML
                        oldElement.querySelector('div.main-intro__info-wrapper').innerHTML = tempContainer.querySelector('div.main-intro__info-wrapper').innerHTML
                        oldElement.querySelector('div.swiper-wrapper').innerHTML = tempContainer.querySelector('div.swiper-wrapper').innerHTML
                        oldElement.querySelector('.main-intro__pictures div.swiper-wrapper').innerHTML = tempContainer.querySelector('.main-intro__pictures div.swiper-wrapper').innerHTML
                        oldElement.querySelector('div.swiper-wrapper[hub]').innerHTML = tempContainer.querySelector('div.swiper-wrapper[hub]').innerHTML
                        let container = document.createElement('div');
                        let count = oldElement.querySelectorAll('div.swiper-wrapper[hub] a').length
                        for (let i = 1; i <= count; i++) {
                            const span = document.createElement('span');
                            span.className = 'swiper-pagination-bullet';
                            span.tabIndex = 0;
                            span.role = 'button';
                            span.setAttribute('aria-label', `Go to slide ${i}`);
                            if(i == 1)
                                span.classList.add('swiper-pagination-bullet-active');
                            container.appendChild(span);
                        }

                        // window.swiper = new Swiper(document.querySelector('.main-intro__pictures'), {
                        //     slidesPerView: "auto",
                        //     speed:40,
                        //     autoplay: {
                        //       delay: 500,
                        //       stopOnLastSlide: false,
                        //     },
                        //     loop: true,
                        //     pagination: {
                        //       el: ".swiper-pagination",
                        //       type: "progressbar",
                        //     },
                        // });
                        // if(window.swiper)
                        //     window.swiper.destroy()
                        document.querySelector('.modal--main-slider .modal-main-slider__pagination').innerHTML = container.innerHTML
                    }
                    // oldElement = document.querySelector(".popular-touring");
                    // if (oldElement) {
                    //     const tempContainer = document.createElement('div');
                    //     tempContainer.innerHTML = res.data.popular_touring;
                    //     oldElement.querySelector('div.swiper-wrapper').innerHTML = tempContainer.querySelector('div.swiper-wrapper').innerHTML
                    //     oldElement.querySelector('.main-btn').href = tempContainer.querySelector('.main-btn').href
                    // }
                    oldElement = document.querySelector(".popular-articles");
                    if (oldElement) {
                        const tempContainer = document.createElement('div');
                        tempContainer.innerHTML = res.data.popular_articles;
                        oldElement.querySelector('div.swiper-wrapper').innerHTML = tempContainer.querySelector('div.swiper-wrapper').innerHTML
                        if(window.swiper)
                            window.swiper.destroy()
                        // var hasAutoplayClass = document.querySelector('.popular-articles__slider') ? document.querySelector('.popular-articles__slider').classList.contains('autoplay') : false;
                        // var hasAutoplayData = {loop: true, autoplay: { delay: 500, disableOnInteraction: false }}
                        // window.swiper = new Swiper(document.querySelector('.popular-articles__slider'), {
                        //     ...(hasAutoplayClass ? hasAutoplayData : {}),
                        //     speed:40,
                        //     autoplay: {
                        //       delay: 500,
                        //       stopOnLastSlide: false,
                        //     },
                        //     loop: true,
                        //     pagination: {
                        //       el: ".swiper-pagination",
                        //       type: "progressbar",
                        //     },
                        // });

                    }
                    oldElement = document.querySelector(".tag-search");
                    if (oldElement) {
                        const tempContainer = document.createElement('div');
                        tempContainer.innerHTML = res.data.tag_search;
                        oldElement.querySelector('div.tag-search__wrapper').innerHTML = tempContainer.querySelector('div.tag-search__wrapper').innerHTML
                    }
                    // oldElement = document.querySelector(".modal--main-slider");
                    // if (oldElement) {
                    //     const tempContainer = document.createElement('div');
                    //     tempContainer.innerHTML = res.data.main_slider;
                    //     oldElement.querySelector('div.swiper-wrapper[minihub]').innerHTML = tempContainer.querySelector('div.swiper-wrapper[minihub]').innerHTML
                    // }
                }
            })
            .catch((error)=>{
                console.error(error)
                // setTimeout(() => {
                //     if(locationId == event.target.closest('.navigator-location-item').getAttribute('location-id'))
                //         handleClick(event);
                // }, 1000);
            })
        }
    </script>
@endsection
