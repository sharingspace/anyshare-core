@extends('layouts.master')

{{-- Page title --}}
@section('title')
     {{ trans('general.nav.members') }} ::
@parent
@stop


@section('content')

<!-- -->
			<section>
				<div class="container margin-top-20">

					<!-- RIGHT -->
					<div class="col-lg-9 col-md-9 col-sm-8 col-lg-push-3 col-md-push-3 col-sm-push-4 margin-bottom-80">

						<ul class="nav nav-tabs nav-top-border">
							<li class="active"><a href="#info" data-toggle="tab">Personal Info</a></li>
              <li><a href="#social" data-toggle="tab">Social</a></li>
							<li><a href="#avatar" data-toggle="tab">Avatar</a></li>
							<li><a href="#password" data-toggle="tab">Password</a></li>
							<li><a href="#privacy" data-toggle="tab">Privacy</a></li>
						</ul>

						<div class="tab-content margin-top-20">


							<!-- PERSONAL INFO TAB -->
							<div class="tab-pane fade in active" id="info">

                <form role="form" method="post" action="{{ route('user.settings.save') }}">
                  {{ csrf_field() }}

                  <!-- Display Name -->
                  <div class="col-md-12 form-group {{ $errors->first('display_name', 'has-error') }}">
                     <label class="control-label" for="last_name">Display Name</label>
                      <input type="text" placeholder="Awesome66" class="form-control" name="display_name" value="{{ Input::old('display_name', Auth::user()->display_name) }}">
                      {!! $errors->first('display_name', '<span class="help-block">:message</span>') !!}
                  </div>

                  <!-- Email  -->
                  <div class="col-md-12 form-group {{ $errors->first('email', 'has-error') }}">
                     <label class="control-label" for="last_name">Email</label>
                      <input type="text" placeholder="you@example.com" class="form-control" name="email" value="{{ Input::old('email', Auth::user()->email) }}">
                      {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                  </div>

                  <!-- First Name -->
                  <div class="col-md-12 form-group {{ $errors->first('first_name', 'has-error') }}">
                     <label class="control-label" for="first_name">First Name</label>
                      <input type="text" placeholder="Felicia" class="form-control" name="first_name" value="{{ Input::old('first_name', Auth::user()->first_name) }}">
                      {!! $errors->first('first_name', '<span class="help-block">:message</span>') !!}
                  </div>

                  <!-- Last Name -->
                  <div class="col-md-12 form-group {{ $errors->first('last_name', 'has-error') }}">
                     <label class="control-label" for="last_name">Last Name</label>
                      <input type="text" placeholder="Doe" class="form-control" name="last_name" value="{{ Input::old('last_name', Auth::user()->last_name) }}">
                      {!! $errors->first('last_name', '<span class="help-block">:message</span>') !!}
                  </div>

                  <!-- About -->
                  <div class="col-md-12 form-group {{ $errors->first('bio', 'has-error') }}">
                     <label class="control-label" for="bio">About</label>
 										 <textarea class="form-control" rows="3" placeholder="About Me..." name="bio">{{ Input::old('bio', Auth::user()->bio) }}</textarea>
                      {!! $errors->first('bio', '<span class="help-block">:message</span>') !!}
                  </div>

                  <!-- Website -->
                  <div class="col-md-12 form-group {{ $errors->first('website', 'has-error') }}">
                     <label class="control-label" for="website">Website Url</label>
                      <input type="text" placeholder="http://www.yourwebsite.com" class="form-control" name="website" value="{{ Input::old('website', Auth::user()->website) }}">
                      {!! $errors->first('website', '<span class="help-block">:message</span>') !!}
                  </div>

									<div class="col-md-12 form-group">
										<button class="btn btn-primary"><i class="fa fa-check"></i> Save Changes </button>
									</div>

                </form>

							</div>
							<!-- /PERSONAL INFO TAB -->

              <!-- SOCIAL TAB -->
							<div class="tab-pane fade" id="social">

                <form role="form" method="post" action="{{ route('user.social.save') }}">
                  {{ csrf_field() }}

        					<div class="col-md-12">
                  	<h4>Social Links &amp; Connections</h4>
                  </div>

                  <div class="col-md-12 social">

                    <div class="col-md-7">
                      <div class="form-group {{ $errors->first('fb_url', 'has-error') }}">
                          <input type="text" placeholder="https://facebook.com/username" class="form-control" id="fb_url" name="fb_url" value="{{{ Input::old('fb_url', Auth::user()->fb_url) }}}">
                          <label for="facebookURL" class="fa fa-facebook-square fa-lg grey" rel="tooltip" title="Facebook"></label>
                      </div>
                    </div>  <!-- col-md-7 -->
                    <div class="col-sm-7">
                      {{ $errors->first('facebookURL', '<span class="help-block">:message</span>') }}
                    </div>

                    <div class="col-md-7">
                      <div class="form-group {{ $errors->first('twitter_url', 'has-error') }}">
                        <input type="text" placeholder="https://twitter.com/username" class="form-control" id="twitter_url" name="twitter_url" value="{{{ Input::old('twitter_url', Auth::user()->twitter_url) }}}">
                        <label for="twitter_url" class="fa fa-twitter-square fa-lg grey" rel="tooltip" title="Twitter"></label>
                      </div>
                    </div> <!-- col-md-7 -->

                    <div class="col-sm-7">
                      {{ $errors->first('twitter_url', '<span class="help-block">:message</span>') }}
                    </div>

                    <div class="col-md-7">
                      <div class="form-group {{ $errors->first('gplus_url', 'has-error') }}">
                        <input type="text" placeholder="https://plus.google.com/username" class="form-control" id="gplus_url" name="gplus_url" value="{{{ Input::old('gplus_url', Auth::user()->gplus_url) }}}">
                        <label for="gplus_url" class="fa fa-google-plus-square fa-lg grey" rel="tooltip" title="G+"></label>
                      </div>
                    </div> <!-- col-md-7 -->

                    <div class="col-sm-7">
                      {{ $errors->first('gplus_url', '<span class="help-block">:message</span>') }}
                    </div>


                    <div class="col-md-7">
                      <div class="form-group {{ $errors->first('pinterest_url', 'has-error') }}">
                        <input type="text" placeholder="https://pinterest.com/username" class="form-control" id="pinterestURL" name="pinterest_url" value="{{{ Input::old('pinterest_url', Auth::user()->pinterest_url) }}}">
                        <label for="pinterest_url" class="fa fa-pinterest-square fa-lg grey" rel="tooltip" title="Pinterest"></label>
                      </div>
                    </div> <!-- col-md-7 -->

                    <div class="col-sm-7">
                      {{ $errors->first('pinterest_url', '<span class="help-block">:message</span>') }}
                    </div>

                    <div class="col-md-7">
                      <div class="form-group {{ $errors->first('youtube_url', 'has-error') }}">
                        <input type="text" placeholder="https://youtube.com/username" class="form-control" id="youtube_url" name="youtube_url" value="{{{ Input::old('youtube_url', Auth::user()->youtube_url) }}}">
                        <label for="youtube_url" class="fa fa-youtube-square fa-lg grey" rel="tooltip" title="Youtube"></label>
                      </div>
                    </div> <!-- col-md-7 -->

                    <div class="col-sm-7">
                      {{ $errors->first('youtube_url', '<span class="help-block">:message</span>') }}
                    </div>


                    @if (Auth::user()->fb_user)
                      <div class=" col-sm-10" style="margin-top: -5px">
                        <div class="checkbox">
                          <label>
                            {{ Form::checkbox('post_to_fb', '1', Input::old('post_to_fb', Auth::user()->post_to_fb)) }} Post my tiles to my Facebook profile
                          </label>
                        </div>
                      </div> <!-- col-md-10 -->

                      <div class=" col-sm-10" style="margin-top: -5px">
                        <div class="checkbox">
                          <label>
                            {{ Form::checkbox('fave_to_fb', '1', Input::old('fave_to_fb', Auth::user()->fave_to_fb)) }}
                            Post my faves to my Facebook profile
                          </label>
                        </div>
                      </div> <!-- col-md-10 -->
                    @endif

                  </div> <!-- col-md-12 -->

                  <div class="col-md-12 form-group">
										<button class="btn btn-primary"><i class="fa fa-check"></i> Save Changes </button>
									</div>
              </form>

        			</div>
        							<!-- /SOCIAL TAB -->


							<!-- AVATAR TAB -->
							<div class="tab-pane fade" id="avatar">

									<div class="form-group">

										<div class="row">
											<div class="col-md-3 col-sm-4">

												<div class="thumbnail">
													<img class="img-responsive" src="{{ Auth::user()->gravatar() }}?s=300" alt="" />
												</div>

											</div>

											<div class="col-md-9 col-sm-8">

												<div class="sky-form nomargin">
													<label class="label">Select File</label>
													<label for="file" class="input input-file">
														<div class="button">
															<input type="file" id="file" onchange="this.parentNode.nextSibling.value = this.value">Browse
														</div><input type="text" readonly>
													</label>
												</div>

												<a href="#" class="btn btn-danger btn-xs noradius"><i class="fa fa-times"></i> Remove Avatar</a>

												<div class="clearfix margin-top-20">
													<span class="label label-warning">NOTE! </span>
													<p>
														Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt laoreet!
													</p>
												</div>

											</div>

										</div>

									</div>

                  <div class="col-md-12 form-group">
										<button class="btn btn-primary"><i class="fa fa-check"></i> Save Changes </button>
									</div>


							</div>
							<!-- /AVATAR TAB -->

							<!-- PASSWORD TAB -->
							<div class="tab-pane fade" id="password">
                <form role="form" method="post" action="{{ route('user.password.save') }}">
                  {{ csrf_field() }}

									<div class="form-group">
										<label class="control-label">Current Password</label>
										<input type="password" class="form-control" name="password">
									</div>
									<div class="form-group">
										<label class="control-label">New Password</label>
										<input type="password" class="form-control" name="new_password">
									</div>
									<div class="form-group">
										<label class="control-label">Re-type New Password</label>
										<input type="password" class="form-control" name="confirm_password">
									</div>

                  <div class="col-md-12 form-group">
										<button class="btn btn-primary"><i class="fa fa-check"></i> Save Changes </button>
									</div>
                </form>


							</div>
							<!-- /PASSWORD TAB -->

							<!-- PRIVACY TAB -->
							<div class="tab-pane fade" id="privacy">

								<form action="#" method="post">
									<div class="sky-form">

										<table class="table table-bordered table-striped">
											<tbody>
												<tr>
													<td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam.</td>
													<td>
														<div class="inline-group">
															<label class="radio nomargin-top nomargin-bottom">
																<input type="radio" name="radioOption" checked=""><i></i> Yes
															</label>

															<label class="radio nomargin-top nomargin-bottom">
																<input type="radio" name="radioOption" checked=""><i></i> No
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam.</td>
													<td>
														<label class="checkbox nomargin">
															<input type="checkbox" name="checkbox" checked=""><i></i> Yes
														</label>
													</td>
												</tr>
												<tr>
													<td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam.</td>
													<td>
														<label class="checkbox nomargin">
															<input type="checkbox" name="checkbox" checked=""><i></i> Yes
														</label>
													</td>
												</tr>
												<tr>
													<td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam.</td>
													<td>
														<label class="checkbox nomargin">
															<input type="checkbox" name="checkbox" checked=""><i></i> Yes
														</label>
													</td>
												</tr>
											</tbody>
										</table>

									</div>

                  <div class="col-md-12 form-group">
										<button class="btn btn-primary"><i class="fa fa-check"></i> Save Changes </button>
									</div>

								</form>

							</div>
							<!-- /PRIVACY TAB -->

						</div>

					</div>


					<!-- LEFT -->
					<div class="col-lg-3 col-md-3 col-sm-4 col-lg-pull-9 col-md-pull-9 col-sm-pull-8">

						<div class="thumbnail text-center">
							<img src="{{ Auth::user()->gravatar() }}?s=400" alt="" />
							<h2 class="size-18 margin-top-10 margin-bottom-0">{{ Auth::user()->getDisplayName() }}</h2>
							<h3 class="size-11 margin-top-0 margin-bottom-10 text-muted">{{ Auth::user()->location }}</h3>
						</div>

						<!-- completed -->
						<div class="margin-bottom-30">
							<label>88% completed profile</label>
							<div class="progress progress-xxs">
								<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100" style="width: 88%; min-width: 2em;"></div>
							</div>
						</div>
						<!-- /completed -->

						<!-- SIDE NAV -->
						<ul class="side-nav list-group margin-bottom-60" id="sidebar-nav">
							<li class="list-group-item"><a href="#"><i class="fa fa-eye"></i> SUBNAV</a></li>
							<li class="list-group-item"><a href="#"><i class="fa fa-comments-o"></i> SUBNAV</a></li>
							<li class="list-group-item"><a href="#"><i class="fa fa-history"></i> SUBNAV</a></li>
							<li class="list-group-item active"><a href="#"><i class="fa fa-gears"></i> SUBNAV</a></li>
						</ul>
						<!-- /SIDE NAV -->

						</div>

					</div>

				</div>
			</section>
			<!-- / -->

@stop
