<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Video SDK UI Toolkit JavaScript Sample</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="{{ static_asset('subadmin/favicon.ico') }}">

    <link rel="stylesheet" href="{{ static_asset('subadmin/@zoom/videosdk-ui-toolkit/dist/videosdk-ui-toolkit.css') }}">
    <link rel="stylesheet" href="{{ static_asset('subadmin/styles.css') }}">
    <input type="hidden" name="session_token" value="{{ $data->session_token}}" id="session_token">
    <input type="hidden" name="session_name" value="{{ $data->session_name}}" id="session_name">
    <input type="hidden" name="user_name" value="{{ $data->username}}" id="user_name">
    <script type="module">
        var link = "{{ static_asset('subadmin/@zoom/videosdk-ui-toolkit/index.js') }}";
        import uitoolkit from "{{ static_asset('subadmin/@zoom/videosdk-ui-toolkit/index.js') }}";

        var token = document.getElementById('session_token').value;
        var name = document.getElementById('session_name').value;
        var user_name = document.getElementById('user_name').value;
       

        var sessionContainer = document.getElementById('sessionContainer');
        var authEndpoint = 'https://redsparkte.a2hosted.com/';
        var config = {
            videoSDKJWT: token,
            sessionName: name,
            userName: user_name,
            sessionPasscode: '',
            features: ['video', 'audio', 'settings', 'users', 'chat', 'share']
        };
        var role = 0;

         window.joinSession = joinSession;

        function joinSession() {

            const div = document.getElementById("zoom-session");
            if (div) {
                div.style.display = "none";
            }

            uitoolkit.joinSession(sessionContainer, config);
            uitoolkit.onSessionClosed(sessionClosed);
        }

        var sessionClosed = (() => {
            console.log('session closed');
            uitoolkit.closeSession(sessionContainer);
            document.getElementById('join-flow').style.display = 'block';
        });
    </script>
</head>
<body>
    <main id="zoom-session">
        <div id="join-flow">
            <h1>Zoom Video SDK Sample JavaScript</h1>
            <p>User interface offered by the Video SDK UI Toolkit</p>
            <button onclick="joinSession()">Join Session</button>
        </div>
    </main>
    <div id='sessionContainer'></div>
</body>
</html>