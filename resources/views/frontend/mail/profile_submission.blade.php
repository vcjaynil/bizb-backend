<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{trans('email.profile_submission.title')}}</div>

                <div class="card-body">

                    <p>{{trans('email.greetings',['name' => $user->name])}}</p>
                    <p>{{trans('email.profile_submission.text_1')}}</p><br>
                    <p>{{trans('email.profile_submission.text_2')}}</p>

                    <button>{!! trans('email.profile_submission.review_profile_button') !!}</button>
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