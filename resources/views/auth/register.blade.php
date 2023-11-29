@extends('front.layouts.app')
@section('content')
    <section class="application">
        <div class="container">
            <h3 class="application__heading">🎅 Курс 🎅 <br> PHP | Laravel | CRM</h3>
            <form class="form application__form" action="{{ route('register.verify.sms') }}" method="POST" name="applicationForm">
                @csrf
                <span class="fas fa-user-circle form__icon form__icon_big"></span>
                <p class="form__txt">Login</p>
                <span class="fas fa-user form__icon form__icon_position"></span>
                <input class="form__field form__field_active" type="text" placeholder="Your Name *"
                       name="name" minlength="2" maxlength="40"
                       required>
                <br>
                <span class="fas fa-phone form__icon form__icon_position"></span>
                <input class="form__field form__field_active" type="tel" placeholder="Contact Number *" name="phone"
                       minlength="12" maxlength="24"
                       required>
                <br>
                @if(session('error'))
                    {{ session('error') }}
                @endif
                <button class="form__btn form__btn_hover" name="send" type="submit">Send</button>
            </form>
        </div>
    </section>
@endsection
