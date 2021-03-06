@extends('admin.layout.app')

@section('title-page')
<title>{{__('home.Tags')}}</title>
@endsection

@section('extra-css-header')
     <link href="/admin/theme/plugins/sweetalert/sweetalert.css" rel="stylesheet" /> 
@endsection

@section('content')
<ol class="breadcrumb breadcrumb-col-cyan">
    <li><a href="{{route('home')}}"><i class="material-icons">home</i>  {{__('home.Home')}}</a></li>
    <li class="active"><i class="material-icons">filter_vintage</i>  {{__('home.Tags')}}</li>
</ol>

  <div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    {{__('home.TAGS')}}
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right js-sweetalert-asiye">
                            <li>
                            <a  href="javascript:void(0);" class="btn bg-green waves-effec" id="create-new-value" data-toggle="modal">
                                <i class="material-icons">add_circle</i>
                                {{__('home.New Tag')}}
                            </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable align-center" id="data-table">
                        <thead>
                            <tr>
                                <th>{{__('home.id')}}</th>
                                <th>{{__('home.Title')}}</th>
                                <th>{{__('home.Slug')}}</th>
                                <th>{{__('home.Action')}}</th>
                            </tr>
                        </thead>
                      
                        <tbody id="values-crud">
                            @foreach ($tags as $u_info)
                            <tr id="value_id_{{ $u_info->id }}">
                                <td id="index">{{ $loop->iteration }}</td>
                                <td><a href="javascript:void(0)" data-id="{{ $u_info->id }}" id="show-value">{{ $u_info->title }}</a></td>
                                <td>{{ $u_info->slug }}</td>
                                <td>
                                    <a href="javascript:void(0)" id="edit-value" data-id="{{ $u_info->id }}" class="btn bg-blue btn-circle waves-effect waves-circle waves-float">
                                        <i class="material-icons">mode_edit</i>
                                    </a>&nbsp;
                                    <a href="javascript:void(0)" id="delete-value" data-id="{{ $u_info->id }}"  class="btn bg-red btn-circle waves-effect waves-circle waves-float">
                                    <i class="material-icons">delete_forever</i>
                                    </a>
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




@endsection
@section('modal')
    <div class="modal fade" id="ajax-crud-modal"  tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="alert" id="msg_div" style="display:none">
                    <span id="res_message"></span>
                  </div>
                <h4 class="modal-title" id="valueCrudModal">Modal title</h4>
            </div>
            <form id="valueForm" name="valueForm">
                <div class="modal-body">
                    <div class="col-sm-12">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control" id="title" name="title" placeholder="Title">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control" id="slug" name="slug" placeholder="Slug">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group form-float">
                            <input type="hidden" class="form-control" id="value_id" name="value_id">
                        </div>
                    </div>
                
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btn-save" value="SAVE RECORD" class="btn btn-link waves-effect">SAVE RECORD</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
@section('extra-script-footer')
    <!-- SweetAlert Plugin Js -->
    <script src="/admin/theme/plugins/sweetalert/sweetalert.min.js"></script>
    <!-- dialog Plugin Js -->
    <script src="/admin/theme/js/pages/ui/dialogs.js"></script>

    <script>
        $(document).ready(function () {
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          /*  When value click add value button */
          $('#create-new-value').click(function () {
            $('#valueForm')[0].reset();
            $('#msg_div').empty();
            $('#msg_div').removeClass('alert-danger');
            $('#msg_div').removeClass('alert-success');
            $('#btn-save').val("create-value");
            $('#btn-save').html("{{__('home.SAVE RECORD')}}");
            $('#btn-save').attr("disabled", false);
            $('#title').val();
            $('#valueForm').trigger("reset");
            $('#valueCrudModal').html("{{__('home.add new information')}}");
            $('#ajax-crud-modal').modal('show');
          });
       
         /* When click edit value */
        $('body').on('click', '#edit-value', function () {
            var value_id = $(this).data('id');
            $.get("{{ url('manage/tag')}}"+'/' + value_id +'/edit', function (data) {
                $('#msg_div').empty();
                $('#msg_div').removeClass('alert-danger');
                $('#valueCrudModal').html("{{__('home.edit information')}}");
                $('#btn-save').val("edit-value");
                $('#msg_div').removeClass('alert-danger');
                $('#msg_div').removeClass('alert-success');
                $('#btn-save').html("{{__('home.EDIT RECORD')}}");
                $('#ajax-crud-modal').modal('show');
                $('#value_id').val(data.id);
                $('#slug').val(data.slug);
                $('#title').val(data.title);
            })
        
        });

         /* When click show value */
         $('body').on('click', '#show-value', function () {
            var value_id = $(this).data('id');
            $.get("{{ url('manage/tag')}}"+'/' + value_id +'/edit', function (data) {
                swal({
                    title: "<span style=\"color: #607D8B\"><span style=\"color: #00BCD4\">Id : </span>" + data.id + "</span>",
                    text: "<div style=\"color: #607D8B\"><span style=\"color: #00BCD4\">Title : </span>" + data.title + "</div><div style=\"color: #607D8B\"><span style=\"color: #00BCD4\">Slug : </span>" + data.slug + "</div>",
                    html: true
                });
                $('#value_id').val(data.id);
                $('#slug').val(data.slug);
                $('#title').val(data.title);
            })
        
        });
         //delete value 
        $('body').on('click', '#delete-value', function () {
            var value_id = $(this).data("id");
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ url('manage/tag')}}"+'/'+value_id,
                        success: function (data) {
                            $("#value_id_" + value_id).remove();
                            swal("Deleted!", "Your imaginary file has been deleted.", "success");
                            // setTimeout(function(){
                            //     location.reload(true);
                            // }, 1000); 
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                } else {
                    swal("Cancelled", "Your imaginary file is safe :)", "error");
                }
            });
        });
       


       if ($("#valueForm").length > 0) {
            $("#valueForm").validate({
            submitHandler: function(form) {
            var actionType = $('#btn-save').val();
            $('#btn-save').html("{{__('home.send')}}");
            $('#btn-save').attr("disabled", true);
            $.ajax({
                data: $('#valueForm').serialize(),
                url: "{{ route('tag.store')}}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $('#msg_div').empty();
              if(data.arr.status){
                  $('#msg_div').removeClass('alert-danger');
                  $('#msg_div').show();
                  $('#res_message').show();
              }else{
                  $('#msg_div').addClass('alert-danger');
                  $('#btn-save').attr("disabled", false);
                  $('#btn-save').html("{{__('home.SAVE RECORD')}}");
                  $('#msg_div').show();
                  $('#res_message').show();
                  jQuery('.alert-danger').append('<p>'+"{{__('home.error')}}"+'</p>');
                  jQuery.each(data.errors, function(key, value){
                    jQuery('.alert-danger').show();
                    jQuery('.alert-danger').append('<p>'+value+'</p>');
                });
              }
            var value = '<tr id="value_id_' + data.tag.id + '"><td>' + data.tag.id + '</td><td> <a id="show-value" data-id="' + data.tag.id + '" href="javascript:void(0)' + data.tag.id + '">' + data.tag.title + '</a></td><td>'+ data.tag.slug + '</td>';                                                      
            value += '<td><a href="javascript:void(0)" id="edit-value" data-id="' + data.tag.id + '" class="btn bg-blue btn-circle waves-effect waves-circle waves-float"><i class="material-icons">mode_edit</i></a> &nbsp;';
            value += ' <a href="javascript:void(0)" id="delete-value" data-id="' + data.tag.id + '" class="btn bg-red btn-circle waves-effect waves-circle waves-float"><i class="material-icons">delete_forever</i></a></td></tr>';
                
            if (actionType == "create-value") {
                $('#values-crud').prepend(value);
            } else {
                $("#value_id_" + data.tag.id).replaceWith(value);
            }
            $('#valueForm').trigger("reset");
            $('#msg_div').addClass('alert-success');
            $('#msg_div').show();
            $('#res_message').show();
            $('#btn-save').html("{{__('home.SAVED')}}");
            jQuery('.alert-success').append('<p>'+"{{__('home.success')}}"+'</p>');
            swal("{{__('home.success')}}", "{{__('home.DONE!')}}", "success");
            setTimeout(function(){
                $('#ajax-crud-modal').modal('hide');
                window.location.reload();
                }, 2000);    
            },
            error: function (data) {
                console.log('Error:', data);
                $('#btn-save').html("{{__('home.error')}}");
            }
            });
          }
        })
      }
         
    });  
      </script>
    
   
@endsection