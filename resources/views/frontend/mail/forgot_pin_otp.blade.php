<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Forgot pin OTP') }}</div>

                <div class="card-body">

                    <p>{{trans('email.forgot_pin.greetings',['name' => $user->name])}}</p>
                    <p>{{trans('email.forgot_pin.text_1')}}</p><br>
                    <p>{{trans('email.forgot_pin.text_2')}}</p><br>
                    <p>{{trans('email.forgot_pin.text_3')}}</p>
                    <button>{!! $otp !!}</button>

                </div>
                <div class="card-footer">
                    <p>{!! trans('email.footer_label.text_1') !!}</p><br>
                    <button>Social media buttons</button>
                    <p>{!! trans('email.footer_label.text_2') !!}</p><br>
                    <p>{!! trans('email.footer_label.text_3') !!}</p>
                </div>
            </div>
        </div>
    </div>
</div>
