@extends('layouts.master')

@section('content')


<section class="container padding-top-0 browse_table">
<div class="row">
  <h1 class="margin-bottom-0 size-24 text-center">{{ trans('general.messages.message_from', ['name' => $message->sender->getDisplayName() ]) }}</h1>

  <!-- post -->
  <div class="clearfix margin-bottom-60">

    <div class="border-bottom-1 border-top-1 padding-10">
      <span class="pull-right size-11 margin-top-3 text-muted">{{ $message->created_at->format('M i, Y h:iA') }}</span>
      <strong>{{ $message->sender->getDisplayName()  }}</strong></a>
    </div>

    <div class="block-review-content">

      <div class="block-review-body">

        <div class="block-review-avatar text-center">
          <div class="push-bit">
            <a href="{{ route('user.profile', $message->sender->id) }}">
              <img src="{{ $message->sender->gravatar() }}" width="100" alt="avatar">
            </a>
          </div>

        </div>
        {!!  Helper::parseText($message->message) !!}
      </div>

    </div>

  </div>
  <!-- /post -->


  <!-- reply -->
  <div class="clearfix margin-bottom-60">

    <div class="border-bottom-1 border-top-1 padding-10">
      <span class="pull-right size-11 margin-top-3 text-muted">today</span>
      <strong>LEAVE A REPLY</strong></a>
    </div>

    <form id="offerForm" class="block-review-content">
      {!! csrf_field() !!}

      <div class="clearfix margin-top-30 margin-bottom-20">
        <div class="alert alert-dismissable" style="display: none;" id="offerStatusbox">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <i class="fa fa-exclamation-circle"></i>
          <strong id="offerStatusText"></strong><span id="offerStatus"></span>
        </div> <!-- alert -->
        
        <textarea class="summernote form-control" data-height="200" data-lang="en-US" name="message"></textarea>
      </div>

      <button class="btn btn-3d btn-sm btn-reveal btn-teal">
        <i class="fa fa-check"></i>
        <span>SUBMIT POST</span>
      </button>


    </form>

  </div>
  <!-- /reply -->

  </div>
</section>


<script>
  $(document).ready(function () {

    $("#offerForm").submit(function(){
      $('#offerStatusbox').hide();
      $('#offerStatusText').html('');
      $('#offerStatus').html('');
      $('#offerStatusbox').removeClass('alert alert-success alert-danger');

      $.ajax({
        type: "POST",
        url: "{{ route('messages.create.save', $message->entry->id) }}",
        data: $('#offerForm').serialize(),

        success: function(data){

          $('#offerStatusbox').show();

          if (data.success) {
            $('#offerStatusbox').addClass('alert alert-success');
            $('#offerStatusText').html('Success!');
            $('#offerStatus').html(data.success.message);

          } else {
            $('#offerStatusbox').addClass('alert alert-danger');
            $('#offerStatusText').html('Error: ');
            $('#offerStatus').html(data.error.message[0]);
          }

        },
        error: function(data){
          alert("failure");
        }
      });
      return false;
    });
  });
</script>

@stop
