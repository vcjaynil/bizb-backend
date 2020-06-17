<x-backend.layouts.simple>
    <!-- Page Content -->
    <div class="bg-image" style="background-image: url('assets/media/photos/photo22@2x.jpg');">
        <div class="row no-gutters bg-primary-op">
            <!-- Main Section -->
            <div class="hero-static col-md-6 d-flex align-items-center bg-white">
                <div class="p-3 w-100">
                    <!-- Header -->
                    <div class="mb-3 text-center">
                        <a class="link-fx font-w700 font-size-h1" href="{{ route('frontend.landing') }}">
                            <span class="text-dark">{{ config('app.name') }}</span>
                        </a>
                        <p class="text-uppercase font-w700 font-size-sm text-muted">Create New Account</p>
                    </div>
                    <!-- END Header -->

                    <!-- Sign In Form -->
                    <!-- jQuery Validation (.js-validation-signin class is initialized in js/pages/op_auth_signin.min.js which was auto compiled from _es6/pages/op_auth_signin.js) -->
                    <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
                    <div class="row no-gutters justify-content-center">
                        <div class="col-sm-8 col-xl-6">
                            <form  class="js-validation-signup" method="POST" action="{{ route('frontend.register') }}">
                                @csrf
                                <div class="py-3">
                                    <div class="form-group">
                                        <input id="name" type="text" class="form-control form-control-lg form-control-alt @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="{{ __('Name') }}">

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input id="email" type="email" class="form-control form-control-lg form-control-alt @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('E-Mail Address') }}">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input id="username" type="text" class="form-control form-control-lg form-control-alt @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" placeholder="{{ __('Username') }}">

                                        @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input id="password" type="password" class="form-control form-control-lg form-control-alt @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="{{ __('Password') }}">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input  id="password-confirm" type="password" class="form-control form-control-lg form-control-alt" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('Confirm Password') }}">
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox custom-control-primary">
                                            <input type="checkbox" class="custom-control-input" id="signup-terms" name="signup-terms">
                                            <label class="custom-control-label" for="signup-terms">I agree to Terms &amp; Conditions</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-block btn-hero-lg btn-hero-success">
                                        <i class="fa fa-fw fa-plus mr-1"></i> Sign Up
                                    </button>
                                    <p class="mt-3 mb-0 d-lg-flex justify-content-lg-between">
                                        <a class="btn btn-sm btn-light d-block d-lg-inline-block mb-1" href="{{ route('frontend.login') }}">
                                            <i class="fa fa-sign-in-alt text-muted mr-1"></i> Sign In
                                        </a>
                                        <a class="btn btn-sm btn-light d-block d-lg-inline-block mb-1" href="#" data-toggle="modal" data-target="#modal-terms">
                                            <i class="fa fa-book text-muted mr-1"></i> Read Terms
                                        </a>
                                    </p>
                                </div>
                                @if(env('SOCIAL_MEDIA_AUTH'))
                                    <div class="mb-3 text-center">
                                        <p class="text-uppercase font-w700 font-size-sm text-muted">OR</p>
                                    </div>
                                    <div class="form-group">
                                        <p class="mt-3 mb-0 d-lg-flex justify-content-lg-between">
                                            <a class="btn btn-sm btn-light d-block d-lg-inline-block mb-1" href="{{ route('frontend.social-media.login','facebook') }}">
                                                <i class="fab fa-facebook-square text-muted mr-1"></i>
                                            </a>
                                            <a class="btn btn-sm btn-light d-block d-lg-inline-block mb-1" href="{{ route('frontend.social-media.login','twitter') }}">
                                                <i class="fab fa-twitter text-muted mr-1"></i>
                                            </a>
                                            <a class="btn btn-sm btn-light d-block d-lg-inline-block mb-1" href="{{ route('frontend.social-media.login','linkedin') }}">
                                                <i class="fab fa-linkedin text-muted mr-1"></i>
                                            </a>
                                            <a class="btn btn-sm btn-light d-block d-lg-inline-block mb-1" href="{{ route('frontend.social-media.login','google') }}">
                                                <i class="fab fa-google text-muted mr-1"></i>
                                            </a>
                                        </p>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                    <!-- END Sign In Form -->
                </div>
            </div>
            <!-- END Main Section -->

            <!-- Meta Info Section -->
            <div class="hero-static col-md-6 d-none d-md-flex align-items-md-center justify-content-md-center text-md-center">
                <div class="p-3">
                    <p class="display-4 font-w700 text-white mb-3">
                        Welcome to {{ config('app.name') }}
                    </p>
                    <p class="font-size-lg font-w600 text-white-75 mb-0">
                        Copyright &copy; <span data-toggle="year-copy"></span>
                    </p>
                </div>
            </div>
            <!-- END Meta Info Section -->
        </div>
    </div>
    <!-- END Page Content -->

    <!-- Terms Modal -->
    <div class="modal fade" id="modal-terms" tabindex="-1" role="dialog" aria-labelledby="modal-terms" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Terms &amp; Conditions</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <p>Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet adipiscing luctus mauris adipiscing pretium eget fermentum, tristique lobortis est ut metus lobortis tortor tincidunt himenaeos habitant quis dictumst proin odio sagittis purus mi, nec taciti vestibulum quis in sit varius lorem sit metus mi.</p>
                        <p>Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet adipiscing luctus mauris adipiscing pretium eget fermentum, tristique lobortis est ut metus lobortis tortor tincidunt himenaeos habitant quis dictumst proin odio sagittis purus mi, nec taciti vestibulum quis in sit varius lorem sit metus mi.</p>
                        <p>Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet adipiscing luctus mauris adipiscing pretium eget fermentum, tristique lobortis est ut metus lobortis tortor tincidunt himenaeos habitant quis dictumst proin odio sagittis purus mi, nec taciti vestibulum quis in sit varius lorem sit metus mi.</p>
                        <p>Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet adipiscing luctus mauris adipiscing pretium eget fermentum, tristique lobortis est ut metus lobortis tortor tincidunt himenaeos habitant quis dictumst proin odio sagittis purus mi, nec taciti vestibulum quis in sit varius lorem sit metus mi.</p>
                        <p>Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet adipiscing luctus mauris adipiscing pretium eget fermentum, tristique lobortis est ut metus lobortis tortor tincidunt himenaeos habitant quis dictumst proin odio sagittis purus mi, nec taciti vestibulum quis in sit varius lorem sit metus mi.</p>
                    </div>
                    <div class="block-content block-content-full text-right bg-light">
                        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Done</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Terms Modal -->
</x-backend.layouts.simple>
