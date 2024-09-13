@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                @hasrole('admin')
                @unless(auth()->user()->telegram_id)
                    <h3>Telegram Auth</h3>
                    <script async src="https://telegram.org/js/telegram-widget.js?22"
                            data-telegram-login="{{ config('services.telegram-bot-api.bot') }}"
                            data-size="medium"
                            data-radius="5"
                            data-auth-url="{{ route('callbacks.telegram') }}"
                            data-request-access="write">
                    </script>
                @endunless
                @endhasrole
            </div>
        </div>
    </div>
@endsection
