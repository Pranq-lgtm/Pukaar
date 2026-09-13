<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pukaar - Live Chat & Call</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/peerjs@1.5.1/dist/peerjs.min.js"></script>
    <style>
        .app-card {
            background: #FFFFFF;
            border-radius: 36px;
            box-shadow: 0 20px 60px -15px rgba(9, 44, 94, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.8);
        }
        #chatMessages::-webkit-scrollbar { width: 5px; }
        #chatMessages::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 9999px; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-3xl app-card p-6 flex flex-col h-[85vh] relative overflow-hidden">
        
        <!-- Header -->
        <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4 z-10">
            <div>
                <h1 class="text-lg font-extrabold text-[#092C5E] flex items-center gap-2">Pukaar Connect</h1>
                <p class="text-xs text-slate-500 font-medium">Your ID: <span id="my-id" class="font-bold text-emerald-600 cursor-pointer text-sm" title="Click to copy" onclick="navigator.clipboard.writeText(this.innerText); alert('ID Copied!')">Generating...</span></p>
            </div>

            <!-- Connection Controls -->
            <div class="flex items-center gap-2">
                <input type="text" id="target-id" placeholder="Enter 6-digit ID" maxlength="6" class="px-3 py-1.5 w-32 text-sm bg-slate-100 rounded-lg outline-none focus:ring-2 focus:ring-[#092C5E] text-center font-bold tracking-widest">
                <button onclick="connectPeer()" class="bg-[#092C5E] text-white text-xs font-bold px-4 py-2 rounded-lg hover:bg-blue-900 transition">Link</button>
                <button onclick="initiateCall()" id="btn-video" class="hidden bg-emerald-600 text-white text-xs font-bold px-4 py-2 rounded-lg hover:bg-emerald-700 transition flex items-center gap-1">
                    Call
                </button>
            </div>
        </div>

        <!-- Call Status Overlay (Ringing / Incoming) -->
        <div id="call-overlay" class="hidden absolute inset-0 bg-slate-900/90 z-50 flex-col items-center justify-center text-white backdrop-blur-sm transition-all">
            <div class="w-20 h-20 bg-emerald-500 rounded-full animate-pulse flex items-center justify-center mb-4 shadow-xl shadow-emerald-500/30">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            </div>
            <h2 id="call-status-text" class="text-xl font-bold mb-6">Calling...</h2>
            
            <div id="incoming-controls" class="hidden flex gap-4">
                <button onclick="acceptCall()" class="bg-emerald-500 hover:bg-emerald-400 px-6 py-3 rounded-xl font-bold shadow-lg">Accept</button>
                <button onclick="rejectCall()" class="bg-red-500 hover:bg-red-400 px-6 py-3 rounded-xl font-bold shadow-lg">Decline</button>
            </div>
            <div id="outgoing-controls" class="hidden flex gap-4">
                <button onclick="cancelOutgoingCall()" class="bg-red-500 hover:bg-red-400 px-6 py-3 rounded-xl font-bold shadow-lg">Cancel Call</button>
            </div>
        </div>

        <!-- Video Layer -->
        <div id="video-layer" class="hidden flex-col gap-2 mb-4 bg-slate-900 p-3 rounded-2xl transition-all">
            <div class="grid grid-cols-2 gap-2 h-48 sm:h-64">
                <div class="relative bg-black rounded-xl overflow-hidden shadow-inner">
                    <!-- muted for local to prevent echo -->
                    <video id="local-video" autoplay muted playsinline class="w-full h-full object-cover scale-x-[-1]"></video>
                    <span class="absolute bottom-2 left-2 bg-black/60 text-white px-2 py-1 rounded text-[10px]">You</span>
                </div>
                <div class="relative bg-black rounded-xl overflow-hidden shadow-inner border border-emerald-500/30">
                    <!-- NOT muted, playsinline required for mobile audio -->
                    <video id="remote-video" autoplay playsinline class="w-full h-full object-cover"></video>
                    <span class="absolute bottom-2 left-2 bg-black/60 text-white px-2 py-1 rounded text-[10px]">Them</span>
                </div>
            </div>
            
            <!-- Media Controls -->
            <div class="flex items-center justify-center gap-3 pt-2">
                <button onclick="toggleAudio()" id="btn-mute" class="w-10 h-10 bg-slate-700 hover:bg-slate-600 text-white rounded-full flex items-center justify-center transition" title="Toggle Audio">🎤</button>
                <button onclick="toggleVideo()" id="btn-cam" class="w-10 h-10 bg-slate-700 hover:bg-slate-600 text-white rounded-full flex items-center justify-center transition" title="Toggle Video">📷</button>
                <button onclick="endCall()" class="px-6 py-2 bg-red-500 hover:bg-red-600 text-white font-bold rounded-full transition shadow-lg shadow-red-500/20">End Call</button>
            </div>
        </div>

        <!-- Chat Area -->
        <div id="chatMessages" class="flex-1 overflow-y-auto space-y-3 pr-1 bg-slate-50/50 rounded-xl p-2 z-10">
            <div class="flex justify-center my-2">
                <span class="bg-slate-100 text-slate-500 text-[11px] font-semibold px-3 py-1 rounded-full">Waiting for connection...</span>
            </div>
        </div>

        <!-- Message Input -->
        <form onsubmit="sendTextMessage(event)" class="pt-4 mt-2 border-t border-slate-100 flex items-center gap-2 z-10">
            <!-- Hidden File Input -->
            <input type="file" id="file-input" accept="image/*" class="hidden" onchange="sendPhoto(event)">
            
            <!-- Attachment Button -->
            <button type="button" onclick="document.getElementById('file-input').click()" class="w-10 h-10 bg-slate-100 text-slate-600 rounded-xl flex items-center justify-center hover:bg-slate-200 transition" title="Send Photo">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
            </button>

            <input type="text" id="msg-input" placeholder="Type a message..." required class="flex-1 bg-[#F4F6F9] px-4 py-3 rounded-xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-[#092C5E]/20">
            
            <button type="submit" class="w-12 h-12 bg-[#092C5E] text-white rounded-xl flex items-center justify-center hover:bg-blue-900 transition shadow-md">
                <svg class="w-5 h-5 translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
            </button>
        </form>

    </div>

    <script>
        // Generate a random 6-digit number (between 100000 and 999999)
        const mySixDigitId = Math.floor(100000 + Math.random() * 900000).toString();
        
        // Initialize PeerJS with the custom 6-digit ID
        const peer = new Peer(mySixDigitId);

        let currentConn = null;
        let activeCall = null;
        let localStream = null;
        let connectedPeerId = null;
        let incomingCallObj = null;

        let isAudioMuted = false;
        let isVideoMuted = false;

        // 1. Initialize
        peer.on('open', (id) => {
            document.getElementById('my-id').innerText = id;
        });

        // 2. Chat Data Connection Handlers
        peer.on('connection', (conn) => {
            handleChatConnection(conn);
        });

        function connectPeer() {
            const target = document.getElementById('target-id').value;
            if (!target || target.length !== 6) return alert("Enter a valid 6-digit ID");
            handleChatConnection(peer.connect(target));
        }

        function handleChatConnection(conn) {
            currentConn = conn;
            conn.on('open', () => {
                connectedPeerId = conn.peer;
                document.getElementById('btn-video').classList.remove('hidden');
                appendMessage("System", "Linked! You can now chat or call.", "text");
            });
            conn.on('data', (data) => {
                if(data.type === 'text') appendMessage("Them", data.content, false, "text");
                if(data.type === 'photo') appendMessage("Them", data.content, false, "photo");
                
                // Signaling logic over data channel
                if(data.type === 'call_rejected') {
                    resetCallUI();
                    appendMessage("System", "Call was declined.", "text");
                }
                if(data.type === 'call_ended') {
                    endCall(false); // End without sending the signal again
                    appendMessage("System", "Call ended by remote user.", "text");
                }
            });
        }

        // 3. Text & Photo Sending
        function sendTextMessage(e) {
            e.preventDefault();
            const input = document.getElementById('msg-input');
            if (currentConn && currentConn.open) {
                currentConn.send({ type: 'text', content: input.value });
                appendMessage("You", input.value, true, "text");
                input.value = '';
            }
        }

        function sendPhoto(event) {
            const file = event.target.files[0];
            if (!file) return;
            if (file.size > 2 * 1024 * 1024) return alert("Please select an image smaller than 2MB");

            const reader = new FileReader();
            reader.onload = function(e) {
                const base64Image = e.target.result;
                if (currentConn && currentConn.open) {
                    currentConn.send({ type: 'photo', content: base64Image });
                    appendMessage("You", base64Image, true, "photo");
                } else {
                    alert("Link to a peer first!");
                }
            };
            reader.readAsDataURL(file);
        }

        // 4. Video Call Logic
        function initiateCall() {
            if (!connectedPeerId) return alert("Link to a peer first!");
            
            showOverlay("Calling...", false);

            navigator.mediaDevices.getUserMedia({ video: true, audio: true })
                .then(stream => {
                    setupLocalStream(stream);
                    activeCall = peer.call(connectedPeerId, stream);
                    handleCallEvents(activeCall);
                })
                .catch(err => {
                    resetCallUI();
                    alert("Microphone/Camera access denied.");
                });
        }

        peer.on('call', (call) => {
            incomingCallObj = call;
            showOverlay("Incoming Call...", true);
        });

        function acceptCall() {
            if (!incomingCallObj) return;
            navigator.mediaDevices.getUserMedia({ video: true, audio: true })
                .then(stream => {
                    setupLocalStream(stream);
                    incomingCallObj.answer(stream);
                    activeCall = incomingCallObj;
                    handleCallEvents(activeCall);
                    hideOverlay();
                    showVideoLayer();
                })
                .catch(err => alert("Need camera/mic permissions to accept."));
        }

        function rejectCall() {
            if (currentConn && currentConn.open) currentConn.send({ type: 'call_rejected' });
            resetCallUI();
            incomingCallObj = null;
        }

        function cancelOutgoingCall() {
            if (activeCall) activeCall.close();
            if (currentConn && currentConn.open) currentConn.send({ type: 'call_ended' });
            resetCallUI();
        }

        function endCall(sendSignal = true) {
            if (activeCall) activeCall.close();
            if (sendSignal && currentConn && currentConn.open) {
                currentConn.send({ type: 'call_ended' });
            }
            resetCallUI();
        }

        function handleCallEvents(call) {
            call.on('stream', (remoteStream) => {
                hideOverlay();
                showVideoLayer();
                const remoteVid = document.getElementById('remote-video');
                remoteVid.srcObject = remoteStream;
                // Force play to fix audio issues on some browsers
                remoteVid.play().catch(e => console.log("Play prevented:", e));
            });
            call.on('close', () => endCall(false));
        }

        // 5. Media Toggles
        function toggleAudio() {
            if(localStream) {
                isAudioMuted = !isAudioMuted;
                localStream.getAudioTracks()[0].enabled = !isAudioMuted;
                document.getElementById('btn-mute').style.backgroundColor = isAudioMuted ? '#ef4444' : '#334155'; // Red if muted
            }
        }

        function toggleVideo() {
            if(localStream) {
                isVideoMuted = !isVideoMuted;
                localStream.getVideoTracks()[0].enabled = !isVideoMuted;
                document.getElementById('btn-cam').style.backgroundColor = isVideoMuted ? '#ef4444' : '#334155';
            }
        }

        // 6. UI Helpers
        function setupLocalStream(stream) {
            localStream = stream;
            document.getElementById('local-video').srcObject = stream;
            // Reset toggles
            isAudioMuted = false;
            isVideoMuted = false;
            document.getElementById('btn-mute').style.backgroundColor = '#334155';
            document.getElementById('btn-cam').style.backgroundColor = '#334155';
        }

        function showOverlay(text, isIncoming) {
            document.getElementById('call-overlay').classList.remove('hidden');
            document.getElementById('call-overlay').classList.add('flex');
            document.getElementById('call-status-text').innerText = text;
            
            document.getElementById('incoming-controls').style.display = isIncoming ? 'flex' : 'none';
            document.getElementById('outgoing-controls').style.display = isIncoming ? 'none' : 'flex';
        }

        function hideOverlay() {
            document.getElementById('call-overlay').classList.add('hidden');
            document.getElementById('call-overlay').classList.remove('flex');
        }

        function showVideoLayer() {
            document.getElementById('video-layer').classList.remove('hidden');
            document.getElementById('video-layer').classList.add('flex');
        }

        function resetCallUI() {
            hideOverlay();
            document.getElementById('video-layer').classList.add('hidden');
            document.getElementById('video-layer').classList.remove('flex');
            
            if (localStream) {
                localStream.getTracks().forEach(track => track.stop());
                localStream = null;
            }
            activeCall = null;
        }

        function appendMessage(sender, content, isSelf, type) {
            const chatBox = document.getElementById('chatMessages');
            const wrapper = document.createElement('div');
            wrapper.className = `flex flex-col ${isSelf ? 'items-end' : sender === 'System' ? 'items-center' : 'items-start'} mb-3`;
            
            if (sender === 'System') {
                wrapper.innerHTML = `<span class="bg-slate-100 text-slate-500 text-[11px] font-semibold px-3 py-1 rounded-full">${content}</span>`;
            } else {
                let innerContent = type === 'text' 
                    ? `<div class="max-w-[78%] text-sm font-medium px-4 py-2.5 rounded-2xl shadow-sm break-words ${isSelf ? 'bg-[#092C5E] text-white rounded-tr-sm' : 'bg-white border border-slate-200 text-slate-800 rounded-tl-sm'}">${content}</div>`
                    : `<img src="${content}" class="max-w-[70%] rounded-xl shadow-sm border border-slate-200 cursor-pointer" onclick="window.open(this.src)">`;

                wrapper.innerHTML = `
                    <span class="text-[10px] font-bold text-slate-400 mb-1 px-1">${sender}</span>
                    ${innerContent}
                `;
            }
            chatBox.appendChild(wrapper);
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    </script>
</body>
</html>