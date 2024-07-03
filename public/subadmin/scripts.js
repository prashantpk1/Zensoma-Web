import uitoolkit from './@zoom/videosdk-ui-toolkit/index.js'

var sessionContainer = document.getElementById('sessionContainer')
var authEndpoint = 'https://redsparkte.a2hosted.com/zoom'
var config = {
    videoSDKJWT: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiI3V3Q2UEtpd1RBQ0dPX0R2c1ZycXZBIiwiaWF0IjoxNzE5MjIzMjc4LCJleHAiOjE3MTkyMzA0Nzh9.FjOi5nzynvFNPchzTiLImDC_yGEFPzu--2FWDONvNbg',
    sessionName: 'le land',
    userName: 'nunu',
    sessionPasscode: 'nunu2.0',
    features: ['video', 'audio', 'settings', 'users', 'chat', 'share']
};
var role = 1

window.getVideoSDKJWT = getVideoSDKJWT

function getVideoSDKJWT() {
    document.getElementById('join-flow').style.display = 'none'

    fetch(authEndpoint, {
        method: 'POST',
        body: JSON.stringify({
            sessionName:  config.sessionName,
            role: role,
        })
    }).then((response) => {
        return response.json()
    }).then((data) => {
        if(data.signature) {
            console.log(data.signature)
            config.videoSDKJWT = data.signature
            joinSession()
        } else {
            console.log(data)
        }
    }).catch((error) => {
        console.log(error)
    })
}

function joinSession() {
    uitoolkit.joinSession(sessionContainer, config)

    uitoolkit.onSessionClosed(sessionClosed)
}

var sessionClosed = (() => {
    console.log('session closed')
    uitoolkit.closeSession(sessionContainer)

    document.getElementById('join-flow').style.display = 'block'
})