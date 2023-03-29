@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
                @include('sidebar',['user_messages'=>$user_messages])
        </div> 
        <div class="col-md-8"> 
            <div class="card">
                <div class="card-header">Chat ( <span id="usesr"></span> )</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div>
                             <div style="max-height:300px;height:300px;overflow-y: scroll;" >
                            <div chat-content id="ko">
                                    
                                </div>
                                
                            </div>
                         
                                   </div>
                         <form id="myForm" class="form-group"  style="margin-top: 20px">
                            <input type="hidden" name="message_id" id="messaged" value="" >
                            <div class="input-group">
                              <input type="text" name="message" autocomplete="off" chat-box class="form-control" placeholder="Type...">
                              <div class="input-group-prepend">
                                <button class="input-group-text" id="submitMessage">Send</button>
                              </div>
                            </div> 
                          </form>
                  
                </div>
            </div>
        </div>
    </div>
    
</div>

<script>
function message(id) 
    {
       console.log(id);
      var xhr = new XMLHttpRequest();
      xhr.open('GET','{{ url("json-response1") }}?user='+id,true);

      xhr.onload = function () {       
      var detail = JSON.parse(xhr.responseText);
    console.log(detail);
    document.getElementById('messaged').value=detail.message_info.id;
    document.getElementById('usesr').innerHTML=detail.user.name;
}
xhr.send();
}

</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#submitMessage').click(function(e) {
            e.preventDefault();
            $.ajaxSetup({
             headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            })
            $.ajax({
                url: "{{ url('storeConversations') }}",
                method: 'post',
                data: {
                    message_id: $('[name="message_id"]').val(),
                    message: $('[name="message"]').val()
                },
                success: function(result) {
                    // what should happen when success
                    $('[name="message"]').val('');
                    // console.log(result);
                }
            })
        })



        setInterval(function() {
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        var value = $('[name="message_id"]').val();
        var user = "{{Auth::user()->id}}";
        $.ajax({
            url: "{{ url('getConversations') }}",
            method: "get",
            data: {
                id: value
            },
            success: function(data){
                console.log('dfd');
                $('#ko').html('');
                console.log('dfdk');

                $.each(data, function(i, v) {
                    console.log('dfds');
                    $('#ko').append(`
                        <div class="card">
                        <div class="card-body ${(v.user_id == user) ? 'text-right' : '' }" >
                            <b>${v.user.name}</b> <br>
                            ${v.message} <br>
                            <i>${ new Date(v.created_at) }</i>
                       </div>
                       </div><br>
                        `);
                })
            }
        })
        }, 1000);
      

        



    })

</script>
@endsection
