<!-- index.html -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Call Example</title>
</head>
<body>
    <h1>Video Call Example</h1>

    <video id="localVideo" autoplay playsinline></video>
    <video id="remoteVideo" autoplay playsinline></video>

    <button onclick="startVideoCall()">Start Video Call</button>

    <script>
        async function startVideoCall() {
            const userId = prompt('Enter your user ID:');
            const localStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
            document.getElementById('localVideo').srcObject = localStream;

            const configuration = { iceServers: [{ urls: 'stun:stun.l.google.com:19302' }] };
            const peerConnection = new RTCPeerConnection(configuration);

            localStream.getTracks().forEach(track => peerConnection.addTrack(track, localStream));

            const offer = await peerConnection.createOffer();
            await peerConnection.setLocalDescription(offer);

            await fetch('signaling.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'storeOffer', userId: userId, offer: offer }),
            });

            const remoteUserId = prompt('Enter the remote user ID:');
            const { offer: remoteOffer } = await fetch('signaling.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'getOffer', userId: remoteUserId }),
            }).then(response => response.json());

            await peerConnection.setRemoteDescription(new RTCSessionDescription(remoteOffer));

            const answer = await peerConnection.createAnswer();
            await peerConnection.setLocalDescription(answer);

            console.log('Video call established!');
        }
    </script>
</body>
</html>
