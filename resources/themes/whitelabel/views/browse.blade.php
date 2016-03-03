@extends('layouts.master')

@section('content')

<section class="container padding-top-0 browse_table">
<div class="row">

    <!-- Begin entries table -->
    <table class="table table-condensed"
    name="communityListings"
    id="table"
    data-url="{{ route('json.browse') }}"
    data-cookie="true"
    data-cookie-id-table="communityListingv1">
      <thead>
          <tr>
              <th data-sortable="true" data-field="post_type">{{ trans('general.entries.post_type') }}</th>
              <th data-sortable="true" data-field="title">{{ trans('general.entries.title') }}</th>
              <th data-sortable="true" data-field="author">{{ trans('general.entries.author') }}</th>
              <th data-sortable="true" data-field="location">{{ trans('general.entries.location') }}</th>
              <th data-sortable="true" data-field="created_at">{{ trans('general.entries.created_at') }}</th>
              <th data-sortable="false" data-field="actions"></th>
          </tr>
      </thead>
    </table>
    <!-- End entries table -->
  </div>
</section>


<script src="{{ asset('assets/js/bootstrap-table.js') }}"></script>
<script src="{{ asset('assets/js/extensions/cookie/bootstrap-table-cookie.js') }}"></script>
<script src="{{ asset('assets/js/extensions/mobile/bootstrap-table-mobile.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/bootstrap-table-export.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/tableExport.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/jquery.base64.js') }}"></script>
<script type="text/javascript">
  $('#table').bootstrapTable({
    classes: 'table table-responsive table-no-bordered',
    undefinedText: '',
    iconsPrefix: 'fa',
    showRefresh: true,
    search: true,
    pageSize: 20,
    pagination: true,
    sidePagination: 'server',
    sortable: true,
    cookie: true,
    mobileResponsive: true,
    showExport: true,
    showColumns: true,
    exportDataType: 'all',
    exportTypes: ['csv', 'txt','json', 'xml'],
    maintainSelected: true,
    paginationFirstText: "@lang('pagination.first')",
    paginationLastText: "@lang('pagination.last')",
    paginationPreText: "@lang('pagination.previous')",
    paginationNextText: "@lang('pagination.next')",
    pageList: ['10','25','50','100','150','200'],
    icons: {
        paginationSwitchDown: 'fa-caret-square-o-down',
        paginationSwitchUp: 'fa-caret-square-o-up',
        columns: 'fa-columns',
        refresh: 'fa-refresh'
    },

  });

$( document ).ready(function() {
  // we off screen the table headers as they are obvious. 
  $('table th').addClass('sr-only');
  $('table').on( "click", '[id^=delete_entry_]', function() {
    var entryID = $(this).attr('id').split('_')[2];
    
    // add a clas to the row so we can remove it on success
    $(this).closest('tr').addClass("remove_"+entryID);

    var CSRF_TOKEN = $('meta[name="ajax-csrf-token"]').attr('content');

    $.post(entryID+"/ajaxdelete",{_token: CSRF_TOKEN},function (replyData) {
      //console.log("delete success :-)  "+replyData.entry_id);
      if (replyData.success) {
        // remove row from table
        $('.remove_'+entryID).remove();
      } 
      else {
        //console.error('delete failed');
      }
    });
  });
})
</script>

@stop
