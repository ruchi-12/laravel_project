@extends('layouts.admin')
@section('content')
<div class="content">
    @can('restaurant_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("admin.restaurant.create") }}">
                    {{ trans('global.add') }} {{ trans('global.restaurant.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="row">
        <div class="col-lg-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.restaurant.title_singular') }} {{ trans('global.list') }}
                </div>
                <div class="panel-body">

                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                        {{ trans('global.restaurant.fields.name') }}
                                    </th>
                                    <th>
                                        {{ trans('global.restaurant.fields.code') }}
                                    </th>
                                    <th>
                                        {{ trans('global.restaurant.fields.description') }}
                                    </th>
                                    <th>
                                        {{ trans('global.restaurant.fields.phone') }}
                                    </th>
                                    <th>
                                        {{ trans('global.restaurant.fields.email') }}
                                    </th>
                                    <th>
                                        {{ trans('global.restaurant.fields.image') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($restaurants as $key => $restaurant)
                                    <tr data-entry-id="{{ $restaurant->id }}">
                                        <td>

                                        </td>
                                        <td>
                                            {{ $restaurant->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $restaurant->code ?? '' }}
                                        </td>
                                        <td>
                                            {{ $restaurant->description ?? '' }}
                                        </td>
                                        <td>
                                            {{ $restaurant->phone ?? '' }}
                                        </td>
                                        <td>
                                            {{ $restaurant->email ?? '' }}
                                        </td>
                                        <td>
                                            <img src="{{asset('uploads/'.$restaurant->images->image)}}" height="50px" width="50px" alt="restaurant_image" />
                                            {{ $restaurant->images->image ?? '' }}
                                        </td>
                                        <td>
                                            @can('permission_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('admin.restaurant.show', $restaurant->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan
                                            @can('permission_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('admin.restaurant.edit', $restaurant->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan
                                            @can('permission_delete')
                                                <form action="{{ route('admin.restaurant.destroy', $restaurant->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                                </form>
                                            @endcan
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.restaurant.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('permission_delete')
  dtButtons.push(deleteButton)
@endcan

  $('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons })
})

</script>
@endsection