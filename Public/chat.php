<?php 
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include __DIR__ . '/./header.php'; 
?>

<script src="https://unpkg.com/peerjs@1.5.1/dist/peerjs.min.js"></script>

<style>
    .app-card { background: #FFFFFF; border-radius: 36px; box-shadow: 0 20px 60px -15px rgba(9, 44, 94, 0.12); border: 1px solid rgba(255, 255, 255, 0.8); }
    #chatMessages::-webkit-scrollbar { width: 5px; }
    #chatMessages::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 9999px; }
</style>

<main class="min-h-[calc(100vh-80px)] p-4 md:p-8 flex items-center justify-center relative overflow-hidden">
    <div class="absolute w-[800px] h-[800px] rounded-full bg-gradient-to-tr from-blue-100/50 to-slate-100/40 pointer-events-none -z-10 blur-3xl"></div>

    <div class="w-full max-w-2xl app-card p-6 flex flex-col h-[75vh] md:h-[80vh] relative overflow-hidden">
        
        <!-- Chat Setup Header -->
        <div id="chat-setup" class="flex flex-col h-full justify-center text-center px-4">
            <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 border border-blue-100">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
            </div>
            <h2 class="text-2xl font-black text-[#092C5E] mb-2">Connect to an NGO</h2>
            <p class="text-sm font-medium text-slate-500 mb-8 max-w-md mx-auto">Select the nature of your emergency. We will alert available NGOs in this category to join your secure channel. Your camera is disabled by default.</p>
            
            <div class="space-y-4 max-w-sm mx-auto w-full">
                <!-- CUSTOM SMOOTH DROPDOWN WITH DEEP BLUE SELECTOR -->
                <div class="relative w-full text-left" id="custom-dropdown-container">
                    <!-- Hidden select element for PeerJS compatibility -->
                    <select id="chat-category" class="hidden">
                        <option value="" disabled selected>Select Category...</option>
                        <option value="education">Education & Child Welfare</option>
                        <option value="healthcare">Healthcare & Medical Relief</option>
                        <option value="environment">Environment & Sustainability</option>
                        <option value="women_empowerment">Women Helpline</option>
                        <option value="disaster_relief">Disaster Relief</option>
                    </select>

                    <!-- Custom Dropdown Trigger Button -->
                    <button type="button" onclick="toggleCustomDropdown()" class="w-full bg-slate-50 border border-slate-200 text-sm font-bold text-slate-700 pl-5 pr-5 py-3.5 rounded-full flex items-center justify-between focus:outline-none focus:border-[#092C5E] focus:ring-4 focus:ring-[#092C5E]/10 transition-all shadow-sm">
                        <span id="dropdown-selected-text" class="text-slate-400">Select Category...</span>
                        <svg id="dropdown-arrow" class="w-4 h-4 text-slate-500 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Custom Rounded Dropdown Menu -->
                    <div id="dropdown-menu" class="hidden absolute left-0 right-0 bottom-full mb-2 bg-white border border-slate-100 rounded-2xl shadow-2xl py-2 z-50 overflow-hidden text-left transition-all duration-200">
                        <div onclick="selectOption('education', 'Education & Child Welfare')" class="px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-[#092C5E] hover:text-white cursor-pointer transition-colors">Education & Child Welfare</div>
                        <div onclick="selectOption('healthcare', 'Healthcare & Medical Relief')" class="px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-[#092C5E] hover:text-white cursor-pointer transition-colors">Healthcare & Medical Relief</div>
                        <div onclick="selectOption('environment', 'Environment & Sustainability')" class="px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-[#092C5E] hover:text-white cursor-pointer transition-colors">Environment & Sustainability</div>
                        <div onclick="selectOption('women_empowerment', 'Women Helpline')" class="px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-[#092C5E] hover:text-white cursor-pointer transition-colors">Women Helpline</div>
                        <div onclick="selectOption('disaster_relief', 'Disaster Relief')" class="px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-[#092C5E] hover:text-white cursor-pointer transition-colors">Disaster Relief</div>
                    </div>
                </div>

                <button onclick="requestNGOChat()" class="w-full py-4 bg-[#092C5E] text-white font-bold text-sm rounded-full shadow-lg hover:bg-blue-900 transition-all">
                    Request Secure Connection
                </button>
            </div>
        </div>

        <!-- Active Chat Interface -->
        <div id="chat-interface" class="hidden flex-col h-full">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4 z-10">
                <div>
                    <h1 class="text-lg font-extrabold text-[#092C5E] flex items-center gap-2">Secure Connection</h1>
                    <p class="text-xs text-slate-500 font-medium">Your ID: <span id="my-id" class="font-bold text-emerald-600">Generating...</span></p>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="initiateCall()" id="btn-video" class="hidden bg-emerald-600 text-white text-xs font-bold px-4 py-2 rounded-lg hover:bg-emerald-700 transition flex items-center gap-1">
                        Start Call
                    </button>
                </div>
            </div>

            <!-- Call Status Overlay -->
            <div id="call-overlay" class="hidden absolute inset-0 bg-slate-900/95 z-50 flex-col items-center justify-center text-white backdrop-blur-md transition-all rounded-3xl">
                <h2 id="call-status-text" class="text-xl font-bold mb-6">Connecting Call...</h2>
                <div id="incoming-controls" class="hidden flex gap-4">
                    <button onclick="acceptCall()" class="bg-emerald-500 hover:bg-emerald-400 px-6 py-3 rounded-xl font-bold">Accept</button>
                    <button onclick="rejectCall()" class="bg-red-500 hover:bg-red-400 px-6 py-3 rounded-xl font-bold">Decline</button>
                </div>
                <div id="outgoing-controls" class="hidden flex gap-4">
                    <button onclick="cancelOutgoingCall()" class="bg-red-500 hover:bg-red-400 px-6 py-3 rounded-xl font-bold">Cancel Call</button>
                </div>
            </div>

            <!-- Video Layer -->
            <div id="video-layer" class="hidden flex-col gap-2 mb-4 bg-slate-900 p-3 rounded-2xl transition-all">
                <div class="grid grid-cols-2 gap-2 h-32 sm:h-48">
                    <div class="relative bg-black rounded-xl overflow-hidden shadow-inner">
                        <video id="local-video" autoplay muted playsinline class="w-full h-full object-cover scale-x-[-1]"></video>
                        <span class="absolute bottom-2 left-2 bg-black/60 text-white px-2 py-1 rounded text-[10px]">You (Camera Off)</span>
                    </div>
                    <div class="relative bg-black rounded-xl overflow-hidden shadow-inner border border-emerald-500/30">
                        <video id="remote-video" autoplay playsinline class="w-full h-full object-cover"></video>
                        <span class="absolute bottom-2 left-2 bg-black/60 text-white px-2 py-1 rounded text-[10px]">Responder</span>
                    </div>
                </div>
                
                <div class="flex items-center justify-center gap-3 pt-2">
                    <button onclick="toggleAudio()" id="btn-mute" class="w-10 h-10 bg-slate-700 text-white rounded-full flex items-center justify-center transition">🎤</button>
                    <button onclick="toggleVideo()" id="btn-cam" class="w-10 h-10 bg-red-500 text-white rounded-full flex items-center justify-center transition">📷</button>
                    <button onclick="endCall()" class="px-6 py-2 bg-red-500 text-white font-bold rounded-full transition">End Call</button>
                </div>
            </div>

            <!-- Chat Area -->
            <div id="chatMessages" class="flex-1 overflow-y-auto space-y-3 pr-1 bg-slate-50/50 rounded-xl p-2 z-10">
                <div class="flex justify-center my-2">
                    <span class="bg-slate-200 text-slate-600 text-[11px] font-bold px-4 py-1.5 rounded-full">Waiting for an NGO Responder to connect...</span>
                </div>
            </div>

            <!-- Message Input -->
            <form onsubmit="sendTextMessage(event)" class="pt-4 mt-2 border-t border-slate-100 flex items-center gap-2 z-10">
                <input type="file" id="file-input" accept="image/*" class="hidden" onchange="sendPhoto(event)">
                <button type="button" onclick="document.getElementById('file-input').click()" class="w-10 h-10 bg-slate-100 text-slate-600 rounded-xl flex items-center justify-center hover:bg-slate-200 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                </button>
                <input type="text" id="msg-input" placeholder="Type a message..." required class="flex-1 bg-[#F4F6F9] px-4 py-3 rounded-xl text-sm font-medium focus:outline-none focus:ring-2 focus:ring-[#092C5E]/20">
                <button type="submit" class="w-12 h-12 bg-[#092C5E] text-white rounded-xl flex items-center justify-center hover:bg-blue-900 transition shadow-md">
                    <svg class="w-5 h-5 translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                </button>
            </form>
        </div>
    </div>
</main>

<script>
    // --- CUSTOM DROPDOWN INTERACTION LOGIC ---
    function toggleCustomDropdown() {
        const menu = document.getElementById('dropdown-menu');
        const arrow = document.getElementById('dropdown-arrow');
        menu.classList.toggle('hidden');
        arrow.classList.toggle('rotate-180');
    }

    function selectOption(value, text) {
        const hiddenSelect = document.getElementById('chat-category');
        const displayText = document.getElementById('dropdown-selected-text');
        
        hiddenSelect.value = value;
        displayText.innerText = text;
        displayText.classList.remove('text-slate-400');
        displayText.classList.add('text-slate-700');
        
        toggleCustomDropdown();
    }

    window.addEventListener('click', function(e) {
        const container = document.getElementById('custom-dropdown-container');
        if (container && !container.contains(e.target)) {
            document.getElementById('dropdown-menu')?.classList.add('hidden');
            document.getElementById('dropdown-arrow')?.classList.remove('rotate-180');
        }
    });

    // --- PEERJS CHAT LOGIC ---
    let peer = null;
    let currentConn = null;
    let activeCall = null;
    let localStream = null;
    let connectedPeerId = null;
    let incomingCallObj = null;

    let isAudioMuted = false;
    let isVideoMuted = true; // Camera OFF by default

    function requestNGOChat() {
        const category = document.getElementById('chat-category').value;
        if (!category) return alert("Please select a category first.");

        document.getElementById('chat-setup').classList.add('hidden');
        document.getElementById('chat-interface').classList.remove('hidden');
        document.getElementById('chat-interface').classList.add('flex');

        const mySixDigitId = Math.floor(100000 + Math.random() * 900000).toString();
        peer = new Peer(mySixDigitId);

        peer.on('open', (id) => {
            document.getElementById('my-id').innerText = id;
            console.log(`Alerting NGOs in category [${category}] to connect to ID: ${id}`);
        });

        peer.on('connection', (conn) => { handleChatConnection(conn); });
        peer.on('call', (call) => {
            incomingCallObj = call;
            showOverlay("Incoming Call from NGO...", true);
        });
    }

    function handleChatConnection(conn) {
        currentConn = conn;
        conn.on('open', () => {
            connectedPeerId = conn.peer;
            document.getElementById('btn-video').classList.remove('hidden');
            document.getElementById('chatMessages').innerHTML = ''; 
            appendMessage("System", "NGO Responder has joined the secure chat.", "text");
        });
        conn.on('data', (data) => {
            if(data.type === 'text') appendMessage("Responder", data.content, false, "text");
            if(data.type === 'photo') appendMessage("Responder", data.content, false, "photo");
            if(data.type === 'call_rejected') { resetCallUI(); appendMessage("System", "Call was declined.", "text"); }
            if(data.type === 'call_ended') { endCall(false); appendMessage("System", "Call ended by responder.", "text"); }
        });
    }

    function sendTextMessage(e) {
        e.preventDefault();
        const input = document.getElementById('msg-input');
        if (currentConn && currentConn.open) {
            currentConn.send({ type: 'text', content: input.value });
            appendMessage("You", input.value, true, "text");
            input.value = '';
        } else {
            alert("Waiting for an NGO to connect.");
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
            } else { alert("Waiting for an NGO to connect."); }
        };
        reader.readAsDataURL(file);
    }

    function initiateCall() {
        if (!connectedPeerId) return alert("Waiting for an NGO to connect.");
        showOverlay("Calling NGO...", false);

        navigator.mediaDevices.getUserMedia({ video: true, audio: true })
            .then(stream => {
                setupLocalStream(stream);
                activeCall = peer.call(connectedPeerId, stream);
                handleCallEvents(activeCall);
            }).catch(err => { resetCallUI(); alert("Microphone access denied."); });
    }

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
            }).catch(err => alert("Need microphone permissions to accept."));
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
        if (sendSignal && currentConn && currentConn.open) currentConn.send({ type: 'call_ended' });
        resetCallUI();
    }

    function handleCallEvents(call) {
        call.on('stream', (remoteStream) => {
            hideOverlay(); showVideoLayer();
            const remoteVid = document.getElementById('remote-video');
            remoteVid.srcObject = remoteStream;
            remoteVid.play().catch(e => console.log("Play prevented:", e));
        });
        call.on('close', () => endCall(false));
    }

    function setupLocalStream(stream) {
        localStream = stream;
        document.getElementById('local-video').srcObject = stream;
        isVideoMuted = true;
        isAudioMuted = false;
        localStream.getVideoTracks()[0].enabled = false;
        document.getElementById('btn-mute').style.backgroundColor = '#334155';
        document.getElementById('btn-cam').style.backgroundColor = '#ef4444'; 
    }

    function toggleAudio() {
        if(localStream) {
            isAudioMuted = !isAudioMuted;
            localStream.getAudioTracks()[0].enabled = !isAudioMuted;
            document.getElementById('btn-mute').style.backgroundColor = isAudioMuted ? '#ef4444' : '#334155';
        }
    }

    function toggleVideo() {
        if(localStream) {
            isVideoMuted = !isVideoMuted;
            localStream.getVideoTracks()[0].enabled = !isVideoMuted;
            document.getElementById('btn-cam').style.backgroundColor = isVideoMuted ? '#ef4444' : '#334155';
            document.getElementById('local-video').nextElementSibling.innerText = isVideoMuted ? "You (Camera Off)" : "You";
        }
    }

    function showOverlay(text, isIncoming) {
        const overlay = document.getElementById('call-overlay');
        overlay.classList.remove('hidden'); overlay.classList.add('flex');
        document.getElementById('call-status-text').innerText = text;
        document.getElementById('incoming-controls').style.display = isIncoming ? 'flex' : 'none';
        document.getElementById('outgoing-controls').style.display = isIncoming ? 'none' : 'flex';
    }

    function hideOverlay() {
        const overlay = document.getElementById('call-overlay');
        overlay.classList.add('hidden'); overlay.classList.remove('flex');
    }

    function showVideoLayer() {
        const layer = document.getElementById('video-layer');
        layer.classList.remove('hidden'); layer.classList.add('flex');
    }

    function resetCallUI() {
        hideOverlay();
        const layer = document.getElementById('video-layer');
        layer.classList.add('hidden'); layer.classList.remove('flex');
        if (localStream) { localStream.getTracks().forEach(t => t.stop()); localStream = null; }
        activeCall = null;
    }

    function appendMessage(sender, content, isSelf, type) {
        const chatBox = document.getElementById('chatMessages');
        const wrapper = document.createElement('div');
        wrapper.className = `flex flex-col ${isSelf ? 'items-end' : sender === 'System' ? 'items-center' : 'items-start'} mb-3`;
        
        if (sender === 'System') {
            wrapper.innerHTML = `<span class="bg-slate-200 text-slate-600 text-[11px] font-bold px-4 py-1.5 rounded-full">${content}</span>`;
        } else {
            let innerContent = type === 'text' 
                ? `<div class="max-w-[85%] text-sm font-medium px-4 py-2.5 rounded-2xl shadow-sm break-words ${isSelf ? 'bg-[#092C5E] text-white rounded-tr-sm' : 'bg-white border border-slate-200 text-slate-800 rounded-tl-sm'}">${content}</div>`
                : `<img src="${content}" class="max-w-[70%] rounded-xl shadow-sm border border-slate-200 cursor-pointer" onclick="window.open(this.src)">`;

            wrapper.innerHTML = `<span class="text-[10px] font-bold text-slate-400 mb-1 px-1">${sender}</span>${innerContent}`;
        }
        chatBox.appendChild(wrapper);
        chatBox.scrollTop = chatBox.scrollHeight;
    }
</script>

<?php include __DIR__ . '/../footer.php'; ?>