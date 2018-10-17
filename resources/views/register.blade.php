<?php
/**
 * Created by PhpStorm.
 * Copied from DoSmth/Northstar
 * User: yz
 * Date: 10/17/18
 * Time: 12:24 PM
 */

@extends('layouts.app', ['extended' => true])

@section('title', 'Create Account | DoSomething.org')

@section('content')
    <div class="container__block">
        <h2>{{ session('title', trans('auth.get_started.create_account')) }}</h2>
        <p>{{ session('callToAction', trans('auth.get_started.call_to_action')) }}
    </div>

    <div class="container__block">
        <ul class="form-actions -inline">
            <li>@include('auth.facebook')</li>
            <li><a href="{{ url('login') }}" class="button">{{ trans('auth.log_in.default') }}</a></li>
        </ul>
        <span class="divider"></span>
    </div>

    <div class="container__block -centered">
        @if (count($errors) > 0)
            <div class="validation-error fade-in-up">
                <h4>{{ trans('auth.validation.issues') }}</h4>
                <ul class="list -compacted">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="profile-registration-form" method="POST" action="{{ url('register') }}">
            <input name="_token" type="hidden" value="{{ csrf_token() }}">

            <div>
                <div class="form-item -reduced">
                    <label for="first_name" class="field-label">{{ trans('auth.fields.first_name') }}</label>
                    <input name="first_name" type="text" id="first_name" class="text-field required js-validate" placeholder="{{ trans('auth.validation.placeholder.call_you') }}" value="{{ old('first_name') }}" autofocus data-validate="first_name" data-validate-required />
                </div>

                <div class="form-item -reduced">
                    <label for="birthdate" class="field-label">{{ trans('auth.fields.birthday') }}</label>
                    <input name="birthdate" type="text" id="birthdate" class="text-field required js-validate" placeholder="{{ trans('auth.validation.placeholder.birthday') }}" value="{{ old('birthdate') }}" data-validate="birthday" data-validate-required />
                </div>
            </div>

            <div class="form-item">
                <label for="email" class="field-label">{{ trans('auth.fields.email') }}</label>
                <input name="email" type="text" id="email" class="text-field required js-validate" placeholder="puppet-sloth@example.org" value="{{ old('email') }}" data-validate="email" data-validate-required />
            </div>

            @if (App::getLocale() === 'en')
                <div class="form-item">
                    <label for="mobile" class="field-label">{{ trans('auth.fields.mobile') }} <em>{{ trans('auth.validation.optional') }}</em></label>
                    <input name="mobile" type="text" id="mobile" class="text-field js-validate" placeholder="(555) 555-5555" value="{{ old('mobile') }}" data-validate="phone" />
                </div>
                <div class="form-item">
                    <p class="footnote"><em>DoSomething.org will send you updates from our number, 38383. You can expect to receive up to 8 messages per month from us. Message and data rates may apply. Text <strong>HELP</strong> to 38383 for help. Text <strong>STOP</strong> to 38383 to opt out. Please review our <a href="https://www.dosomething.org/us/about/terms-service">Terms of Service​</a> and <a href="https://www.dosomething.org/us/about/privacy-policy">Privacy Policy</a> pages.
                            <br>
                            T-Mobile is not liable for delayed or undelivered messages.</em></p>
                </div>
            @endif

            <div class="form-item password-visibility">
                <label for="password" class="field-label">{{ trans('auth.fields.password') }}</label>
                <input name="password" type="password" id="password" class="text-field required js-validate" placeholder="{{ trans('auth.validation.placeholder.password') }}" data-validate="password" data-validate-required />
                <span class="password-visibility__toggle -hide"></span>
            </div>

            @if ($voter_reg_status_form === 'voter_form')
                <div class="form-item">
                    <label for="voter_registration_status" class="field-label">{{ "Are you registered to vote at your current address?"}}</label>
                    <div class="form-item -reduced">
                        <label class="option -radio">
                            <input type="radio" name="voter_registration_status" value="confirmed">
                            <span class="option__indicator"></span>
                            <span>Yes</span>
                        </label>
                    </div>
                    <div class="form-item -reduced">
                        <label class="option -radio">
                            <input type="radio" name="voter_registration_status" value="unregistered">
                            <span class="option__indicator"></span>
                            <span>No</span>
                        </label>
                    </div>
                    <div class="form-item -reduced">
                        <label class="option -radio">
                            <input type="radio" name="voter_registration_status" value="uncertain">
                            <span class="option__indicator"></span>
                            <span>I'm not sure</span>
                        </label>
                    </div>
                </div>
            @endif

            <div class="form-actions -padded -left">
                <input type="submit" id="register-submit" class="button" value="{{ trans('auth.log_in.submit') }}">
            </div>
        </form>
    </div>

    <div class="container__block -centered">
        <p class="footnote">{{ trans('auth.footnote.create') }} <a href="https://www.dosomething.org/us/about/terms-service">{{ trans('auth.footnote.terms_of_service') }}</a>
            &amp; <a href="https://www.dosomething.org/us/about/privacy-policy">{{ trans('auth.footnote.privacy_policy') }}</a> {{ trans('auth.footnote.messaging') }}</p>
    </div>

@stop
