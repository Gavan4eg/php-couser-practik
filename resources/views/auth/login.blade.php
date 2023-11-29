@extends('front.layouts.app')
@section('content')
    <main id="success-page">
        <section class="page-form">
            <div class="page-form__container">
                <div class="page-form__wrapper">
                    <form action="{{ route('auth.verify.sms') }}" method="POST" class="page-form__info form">
                        @csrf
                        <h3 class="form__title">Вхід</h3>
                        <div class="form__wrap">
                            <div class="form__item form__item--error">
                                <input data-error="Введіть номер телефону" data-required="phone" data-validate name="phone" type="tel" placeholder="Введіть номер телефону" class="form__input phone-mask">

                                @if(session('error'))

                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>

                                @endif
                            </div>
                        </div>

                        <button type="submit" class="form__button btn">Увійти</button>
                        <a href="{{ route('auth.register') }}" class="form__link">Зареєструватися</a>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection
