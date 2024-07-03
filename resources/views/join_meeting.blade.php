<!DOCTYPE html>

<head>
    <title>Zoom WebSDK CDN  </title>
    <meta charset="utf-8" />
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/3.1.2/css/bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/3.1.2/css/react-select.css" />
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="origin-trial" content="">
</head>

<body>
    <div class="row">
        <div class="col-sm-8">
            <div id="meetingSDKElement">
                <!-- Meeting SDK renders here when a user starts or joins a Zoom meeting -->
            </div>
        </div>
    </div>
    <!-- Dependencies for client view and component view -->
    <script type="text/javascript" src="https://source.zoom.us/3.1.2/lib/vendor/react.min.js"></script>
    <script type="text/javascript" src="https://source.zoom.us/3.1.2/lib/vendor/react-dom.min.js"></script>
    <script type="text/javascript" src="https://source.zoom.us/3.1.2/lib/vendor/redux.min.js"></script>
    <script type="text/javascript" src="https://source.zoom.us/3.1.2/lib/vendor/redux-thunk.min.js"></script>
    <script type="text/javascript" src="https://source.zoom.us/3.1.2/lib/vendor/lodash.min.js"></script>

    <!-- Choose between the client view or component view: -->

    <!-- CDN for client view -->
    <script type="text/javascript" src="https://source.zoom.us/zoom-meeting-3.1.2.min.js"></script>

    <!-- CDN for component view -->
    <script type="text/javascript" src="https://source.zoom.us/zoom-meeting-embedded-3.1.2.min.js"></script>

    <script>
        var signature = '';
        console.log("ZoomMtg.getWebSDKVersion", ZoomMtg.getWebSDKVersion());

        console.log("Meeting Number:", "{{ $meetingNumber }}");
        console.log("API Key:", "{{ $api_key }}");
        console.log("Role:", "{{ $role }}");
        console.log("password:", "{{ $passWord }}");
        console.log("Role:", "{{ $role }}");

        ZoomMtg.generateSDKSignature({
            meetingNumber: "{{ $meetingNumber }}",
            sdkKey: "{{ $api_key }}",
            sdkSecret: "{{ $api_secret }}",
            role: "{{ $role }}", //1=host,0=participant
            success: function(res) {
                console.log("signature", res);
                signature = res;
            },
        });

        ZoomMtg.preLoadWasm()
        ZoomMtg.prepareWebSDK()
        ZoomMtg.i18n.load('en-US')

        function beginJoin() {



            const zoomMeetingSDK = document.getElementById('zmmtg-root');
            ZoomMtg.init({
                leaveUrl: "{{ $url }}", // https://example.com/thanks-for-joining
                // disableCORP: !window.crossOriginIsolated, // default true
                // isSupportAV: true,
                // patchJsMedia: true,
                success: (success) => {
                    ZoomMtg.join({
                        sdkKey: "{{ $api_key }}",
                        signature: signature,
                        meetingNumber: "{{ $meetingNumber }}",
                        passWord: "{{ $passWord }}",
                        userName: "{{ $userName }}",
                        success: (success) => {
                            console.log("join meeting success");
                            console.log(success)
                        },
                        error: (error) => {
                            console.log(error)
                        }
                    })
                },
                error: (error) => {
                    console.log(error)
                }
            })

            ZoomMtg.inMeetingServiceListener("onUserJoin", function(data) {
                console.log("inMeetingServiceListener onUserJoin", data);
            });

            ZoomMtg.inMeetingServiceListener("onUserLeave", function(data) {
                console.log("inMeetingServiceListener onUserLeave", data);
            });

            ZoomMtg.inMeetingServiceListener("onUserIsInWaitingRoom", function(data) {
                console.log("inMeetingServiceListener onUserIsInWaitingRoom", data);
            });

            ZoomMtg.inMeetingServiceListener("onMeetingStatus", function(data) {
                console.log("inMeetingServiceListener onMeetingStatus", data);
            });
        }
        beginJoin();
    </script>
</body>

</html>
