@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-4">Login</h1>
    <div id="error-message" class="mb-4 text-red-500 w-full place-items-center aligh-center items-center justify-center">
        <p id="error-message-text"></p>
    </div>
    <form id="login-form" method="POST" action="{{ route('login') }}" class="max-w-md mx-auto">
        @csrf
        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email</label>
            <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        </div>
        <div class="mb-4">
            <label for="password" class="block text-gray-700">Password</label>
            <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        </div>
        <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Login <span class="fa fa-spinner fa-spin" id="loading" style="display: none;"></span></button>
    </form>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script>
    $(document).ready(function(){
        $('#login-form').on('submit', function(e){
            e.preventDefault();
            var formData = $(this).serialize();
            $('#loading').show();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function(response){
                    $('#loading').hide();
                    if(response.success){
                        window.location.href = response.redirect;   
                    }else{
                        $('#error-message').show();
                        $('#error-message-text').html(response.message);
                        // alert("error: "+response.message);
                        // setTimeout(function(){
                        //     $('#error-message').hide("slow");
                        // }, 3000);
                    }
                },
                error: function(xhr, status, error){
                    $('#loading').hide();
                    alert('An error occurred while logging in.');   
                }
            });
        });
    });
</script>