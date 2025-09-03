<x-guest-layout title="Signup" bodyClass="page-signup">
                <h1 class="auth-page-title">Signup</h1>

                <form action="{{ route('signup.store') }}" method="post">
                    @csrf
                    <div class="form-group @error('name') has-error @enderror">
                        <input type="text" placeholder="Name" name="name"
                        value="{{ old('name') }}" />
                        <div class="error-message">{{ $errors->first('name') }}</div>
                    </div>
                    <div class="form-group @error('email') has-error @enderror">
                        <input type="email" placeholder="Your Email" name="email"
                        value="{{ old('email') }}" />
                        <div class="error-message">{{ $errors->first('email') }}</div>
                    </div>
                    <div class="form-group @error('phone') has-error @enderror">
                        <input type="text" placeholder="Phone" name="phone"
                        value="{{ old('phone') }}" />
                        <div class="error-message">{{ $errors->first('phone') }}</div>
                    </div>
                    <hr />
                    <div class="form-group @error('password') has-error @enderror">
                        <input type="password" placeholder="Your Password" name="password" />
                        <div class="error-message">{{ $errors->first('password') }}</div>
                    </div>
                    <div class="form-group @error('password') has-error @enderror">
                        <input type="password" placeholder="Repeat Password" name="password_confirmation" />
                        <div class="error-message">{{ $errors->first('password') }}</div>
                    </div>

                    <button class="btn btn-primary btn-login w-full">Register</button>
                </form>
                    <x-slot:footerLink>
                        <div class="login-text-dont-have-account">
                            Already have an account? -
                            <a href="{{ route('login') }}"> Click here to login </a>
                        </div>
                    </x-slot:footerLink>
</x-guest-layout>



