@extends('layouts.master')

{{-- Page title --}}
@section('title')
  {{ trans('general.user.join_requests') }} ::
@parent
@stop


@section('content')


<div class="container">
	<div class="row">
    <div class="message1"></div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
        <div id="submission_error" style="display:none" >

        </div>
    </div> <!-- col 10 -->
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-top-20">
      <h1 class="margin-bottom-20  size-24 text-center">{{trans('general.user.join_requests')}}</h1>

      <div class="table-responsive">
        <table class="table table-condensed" id="requests">
          <thead>
            <tr>
              <th data-sortable="false" >Name</span></th>
              <th data-sortable="true" class="email">Email</th>
              <th data-sortable="true" class="message">Message</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($join_requests as $request)
              <tr id="request_{{$request->id}}">
                <td id="displayName_{{$request->id}}">{{$request->display_name}}</td>
                <td>{{$request->email}}</td>
                <td>{{$request->pivot['message']}}</td>
                <td>
                  <button class="button_accept smooth_font btn btn-light-colored btn-sm" data-userid="{{$request->id}}" data-communityid="{{$whitelabel_group->id}}">Accept</button>
                  <button class="button_reject smooth_font btn btn-dark-colored btn-sm margin-left-10" data-userid="{{$request->id}}" "data-communityid="{{$whitelabel_group->id}}">Decline</button></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
 	 </div> <!-- col-lg-10 -->
	</div> <!-- row -->
</div> <!-- #container -->
          {!! csrf_field() !!}

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/bootstrap-table.min.js" integrity="sha256-OOtvdnMykxjRaxLUcjV2WjcyuFITO+y7Lv+3wtGibNA=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/extensions/cookie/bootstrap-table-cookie.min.js" integrity="sha256-w/PfNZrLr3ZTIA39D8KQymSlThKrM6qPvWA6TYcWrX0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/extensions/mobile/bootstrap-table-mobile.min.js" integrity="sha256-+G625AaRHZS3EzbW/2aCeoTykr39OFPJFfDdB8s0WHI=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/extensions/export/bootstrap-table-export.min.js" integrity="sha256-Hn0j2CZE8BjcVTBcRLjiSJnLBMEHkdnsfDgYH3EAeVQ=" crossorigin="anonymous"></script>
<script src="{{ Helper::cdn('js/extensions/export/tableExport.js') }}"></script>
<script src="{{ Helper::cdn('js/extensions/export/jquery.base64.js') }}"></script>

<script type="text/javascript">
$(document).ready(function() {
  $('#members').bootstrapTable({
		classes: 'table table-responsive table-no-bordered',
    undefinedText: '',
    iconsPrefix: 'fa',
    showRefresh: false,
    search: false,
    pageSize: 20,
    pagination: true,
    sortable: true,
    mobileResponsive: true,
    formatShowingRows: function (pageFrom, pageTo, totalRows) {
      return 'Showing ' + pageFrom + ' to ' + pageTo + ' of ' + totalRows + ' requests';
    },
     icons: {
        paginationSwitchDown: 'fa-caret-square-o-down',
        paginationSwitchUp: 'fa-caret-square-o-up',
        columns: 'fa-columns',
        refresh: 'fa-refresh'
    }
  });

  $(".button_accept").on("click", function() {
    var user_id = $(this).attr('data-userid');
    var community_id = $(this).attr('data-communityid');
    var name = $('#displayName_'+user_id).text();
    accept(user_id, community_id, name);
  });

  function accept(user_id, community_id, name)
  {
    data={displayName:name, user_id:user_id};
    $.get("accept", data, function (replyData)
    {
      startLoader();

      if (replyData.success) {
        $(".message1").html('<div class="alert alert-success alert-dismissable fadeOut">\n\
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>\n\
                                <i class="fa fa-check"></i>\n\
                            <strong>Success:</strong> '+replyData.message+'\n\
                          </div>');
        $(".message1").show();
        // displayFlashMessage('success', replyData);

        // now remove this request entry from our table
        $('#request_'+replyData.user_id).fadeOut(600, function() {
          $(this).remove();
        });

        var numRequest = $('#numberRequests span').text() -1; 
        if (numRequest) {
          $('#numberRequests span').text(numRequest) ;
        }
        else {
          $('#numberRequests').hide();
        }
      } 
      else {
        $(".message1").html('<div class="alert alert-danger alert-dismissable">\n\
                            <button type="button" class="close" data-dismiss="alert">×</button>\n\
                            <i class="fa fa-exclamation-circle"></i>\n\
                            <strong>Error: </strong> '+replyData.message+'\n\
                          </div>');
        $(".message1").show();
        $('html,body').scrollTop(0);
        // displayFlashMessage('danger', replyData);
        // console.log("accept: fail");
      }
      closeLoader();
    }).fail(function (jqxhr,errorStatus) {
      console.log("fail");
      closeLoader();

    }).always(function() {
      closeLoader();

    });
  }

  $(".button_reject").on("click", function() {
    var user_id = $(this).attr('data-userid');
    var community_id = $(this).attr('data-communityid');
    var name = $('#displayName_'+user_id).text();
    reject(user_id, community_id, name);
  });

  function reject(user_id, community_id, name)
  {
    data={displayName:name, user_id:user_id};
    $.get("reject", data, function (replyData)
    {
      startLoader();
      if (replyData.success) {
        $(".message1").html('<div class="alert alert-success alert-dismissable fadeOut">\n\
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>\n\
                                <i class="fa fa-check"></i>\n\
                            <strong>Success:</strong> '+replyData.message+'\n\
                          </div>');
        $(".message1").show();
        // displayFlashMessage('success', replyData);

        // now remove this request entry from our table
        $('#request_'+replyData.user_id).fadeOut(600, function() {
          $(this).remove();
        });
        
        var numRequest = $('#numberRequests span').text() -1; 
        if (numRequest) {
          $('#numberRequests span').text(numRequest) ;
        }
        else {
          $('#numberRequests').hide();
        }
      } 
      else {
        $(".message1").html('<div class="alert alert-danger alert-dismissable">\n\
                            <button type="button" class="close" data-dismiss="alert">×</button>\n\
                            <i class="fa fa-exclamation-circle"></i>\n\
                            <strong>Error: </strong> '+replyData.message+'\n\
                          </div>');
        $(".message1").show();
        $('html,body').scrollTop(0);
        console.log("reject: fail");
      }
      closeLoader();
    }).fail(function (jqxhr,errorStatus) {
      console.log("reject: fail");
      closeLoader();
    }).always(function() {
      closeLoader();
    });
  }


  function displayFlashMessage(status, data)
  {
    if('success' == status ) {
      messageHTML ='<div class="alert alert-'+data.alert_class+' margin-top-3 margin-bottom-3"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="fa margin-right-10 fa-check"></i>'+data.message+'</div>';
    }
    else {
      messageHTML ='<div class="alert alert-error margin-top-3 margin-bottom-3"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="fa margin-right-10 fa-exclamation"></i></div>';
    }
    $('#submission_error').append(messageHTML);
    $('#submission_error').show();
  }

});
</script>

@stop
