@extends('layouts.app')

@section('content')
<div class="container">
    
</div>

<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>

<script>
    var firebaseConfig = {
        apiKey: "AIzaSyBZJ_Oigbe4ewN8HXMibBtoVBQKXzkqi-8",
        authDomain: "musicas-pes.firebaseapp.com",
        databaseURL: 'https://musicas-pes.firebaseio.com',
        projectId: "musicas-pes",
        storageBucket: "musicas-pes.appspot.com",
        messagingSenderId: "872621681954",
        appId: "1:872621681954:web:e845f1d7053933818b497b",
        measurementId: "G-BXH4MFKH3M",
    };

    firebase.initializeApp(firebaseConfig);
    const messaging = getMessaging(firebaseApp);
    onMessage(messaging, (payload) => {
        console.log('Message received. ', payload);
    });

</script>
@endsection