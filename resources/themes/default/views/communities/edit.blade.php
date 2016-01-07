@extends('layouts/master')

{{-- Page title --}}
@section('title')
     {{ trans('general.nav.create_community') }} ::
@parent
@stop


{{-- Page content --}}
@section('content')

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>


<!-- -->
			<section>
				<div class="container margin-top-20">
					<div class="row">

            <!-- payment form -->
            <form method="post" action="#" id="payment-form" enctype="multipart/form-data" autocomplete="off">
              {!! csrf_field() !!}

            <div class="col-md-10 col-md-offset-1">
              <h2 class="size-16">CREATE A COMMUNITY ON ANYSHA.RE</h2>
              <p class="text-muted">Maecenas metus nulla, commodo a sodales sed, dignissim pretium nunc. Nam et lacus neque. Ut enim massa, sodales tempor convallis et, iaculis ac massa.</p>
            </div>


						<!-- LEFT TEXT -->
						<div class="col-md-5 col-md-offset-1">

              <h2 class="size-16 uppercase">{{ trans('general.nav.create_community') }}</h2>

							<!-- Name -->
							<div class="form-group{{ $errors->first('name', ' has-error') }}">
								<label for="name"> Community Name *</label>
                  <input type="text" name="name" class="form-control" placeholder="My Awesome Community" required="" value="{{ old('name') }}">

                {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
							</div>

              <!-- Slug -->
							<div class="form-group{{ $errors->first('subdomain', ' has-error') }}">
                <label for="subdomain">Subdomain *</label>
								  <input type="text" name="subdomain" class="form-control" placeholder="awesome.anysha.re" required="" value="{{ old('subdomain') }}">
                {!! $errors->first('subdomain', '<span class="help-block">:message</span>') !!}
							</div>

              <!-- Type -->
              <div class="form-group{{ $errors->first('group_type', ' has-error') }}">
                <label for="group_type">
                  Community Type *</label>
                  {!! Form::community_types('group_type', Input::old('group_type', old('group_type'))) !!}
                  {!! $errors->first('group_type', '<span class="help-block">:message</span>') !!}
              </div>

              <!-- Theme -->
              <div class="form-group{{ $errors->first('theme', ' has-error') }}">
                <label for="theme">Theme *</label>
                  {{ Form::select('theme', $themes, old('theme'), array('class'=>'select2', 'style'=>'width:100%')) }}

              </div>

              <div class="form-group">
                <label for="cover_img">
                  Cover Image
									<input class="custom-file-upload" type="file" id="file" name="cover_img" data-btn-text="Cover Upload" />
									<small class="text-muted block">Max file size: 10Mb (gif/jpg/png)</small>
                </label>
                {!! $errors->first('cover_img', '<span class="help-block">:message</span>') !!}
							</div>

						</div>
						<!-- /LEFT TEXT -->

						<!-- PAYMENT -->
						<div class="col-md-5">
              <h2 class="size-16 uppercase">Payment Information</h2>

                <!-- Billing Name -->
								<div class="form-group col-md-6 col-sm-6">
									<label for="billing_name">Name on Card *</label>
									<input id="billing_name" name="billing_name" required="" type="text" class="form-control" data-stripe="name" placeholder="John Smith" />
								</div>

                <!-- Billing Email -->
								<div class="form-group col-md-6 col-sm-6">
									<label for="billing_email">Billing Email *  </label>
									<input id="billing_email" name="billing_email" type="email" class="form-control" placeholder="me@mycompany.com" data-stripe="email" />

								</div>


                  <!-- Subscription -->
                  <div class="form-group col-md-12 col-sm-12">
	                   <label for="cvc">Subscription Type *</label>
                      <select class="form-control" name="subscription_type">
                          <option value="MONTHLY-HUB-SUBSCRIPTION">Monthly ($1/month)</option>
                          <option value="ANNUAL-HUB-SUBSCRIPTION">Annual ($12/year)</option>
	                    </select>
                  </div>


                  <!-- Error box for payment errors -->
                  <div class="form-group col-md-12 payment-errors alert alert-mini alert-danger margin-bottom-10" style="display: none; margin-left: 15px;">
                  </div>


                		<div class="form-group col-md-12 col-sm-12" id="form-card-number">
                			<label for="card-number">Card Number *
                        <i class="fa fa-cc-visa help-text"></i>
                        <i class="fa fa-cc-amex"></i>
                        <i class="fa fa-cc-mastercard"></i>
                        <i class="fa fa-cc-diners-club"></i>
                        <i class="fa fa-cc-jcb"></i>
                        <i class="fa fa-cc-discover"></i>
                      </label>
										  <input id="card-number" type="text" class="card-number form-control" size="20" data-stripe="number" />
									    </div>


                      <div class="form-group col-md-3 col-sm-2">
    										<label for="exp_month">Month *</label>
    										<input id="exp_month" type="text" class="card-expiry-month form-control" placeholder="01" data-stripe="exp-month" />
                      </div>
                      <div class="form-group col-md-3 col-sm-3">
                          <label for="exp_year">Year *</label>
                          <input id="exp_year" type="text" class="card-expiry-year form-control" placeholder="{{ (date('Y') + 3) }}"  data-stripe="exp-year" />
									    </div>
    									<div class="form-group col-md-3 col-sm-3">
    										<label for="cvc">CVC *</label>
    										<input id="cvc" type="text" class="card-cvc form-control" placeholder="123" data-stripe="cvc" />
    									</div>

                      <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12 nomargin clearfix">
                          <button type="submit" class="btn btn-primary" id="create_community">Create Community</button>
                      </div>
                      <div class="form-group col-lg-8 col-md-8 col-sm-12 col-xs-12">
                          <div class="payment-errors-generic alert alert-mini alert-danger margin-bottom-30" style="display: none">
                              Something went wrong :(
                          </div>
                      </div>
								</div>
						</div>
            </form>
					</div>
				</div>
			</section>
			<!-- / -->

  @section('moar_scripts')

      <script type="text/javascript">
        // This identifies your website in the createToken call below
        Stripe.setPublishableKey('{{ Config::get('services.stripe.key') }}');
        // ...
      </script>

      <script>
      $(function(){

        $('#payment-form').submit(function(event) {
          var $form = $(this);

          // Disable the submit button to prevent repeated clicks
          $('#create_community').prop('disabled', true);

          Stripe.card.createToken({
          number: $('.card-number').val(),
          cvc: $('.card-cvc').val(),
          exp_month: $('.card-expiry-month').val(),
          exp_year: $('.card-expiry-year').val()
        }, stripeResponseHandler);

          // Prevent the form from submitting with the default action
          return false;
        });
      });



      function stripeResponseHandler(status, response) {
        var $form = $('#payment-form');
        //console.dir(response);


        if (response.error) {
          //alert(response.error.message);
          // Show the errors on the form
          $('.payment-errors').show().text(response.error.message);
          $('.payment-errors-generic').show();
          $('#create_community').prop('disabled', false);
        } else {
          // response contains id and card, which contains additional card details
          var token = response.id;
          // Insert the token into the form so it gets submitted to the server
          $form.append($('<input type="hidden" name="stripeToken" />').val(token));
          // and submit
          $form.get(0).submit();
        }

      };

      </script>

  @stop

@stop
