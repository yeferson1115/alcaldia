@extends('layouts.app')

@section('title', 'Acuerdos de Pago')
@section('page_title', 'Acuerdos de Pago')

@section('content')
<div id="chat-box">
    @foreach ($messages as $message)
        <p>{{ $message->message }}</p>
    @endforeach
</div>

<input type="text" id="message" placeholder="Escribe un mensaje">
<button id="send">Enviar</button>




@endsection

@push('scripts')
<script>
    document.getElementById('send').addEventListener('click', function() {
        let message = document.getElementById('message').value;
        fetch('{{ route("chat.storeMessage", $chat->id) }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
            body: JSON.stringify({ message: message })
        }).then(response => response.json())
          .then(data => { document.getElementById('chat-box').innerHTML += `<p>${data.message}</p>`; });
    });

    setInterval(() => {
        fetch('{{ route("chat.show", $chat->id) }}')
            .then(response => response.text())
            .then(html => {
                document.getElementById('chat-box').innerHTML = html;
            });
    }, 3000);
</script>
@endpush