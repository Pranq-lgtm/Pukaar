<?php
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>404 — Page Not Found</title>
<style>
:root{--bg:#f4f7ff;--card:#fff;--ink:#101828;--muted:#667085;--accent:#3157d5;--soft:#e8edff;--border:#d9e0f2;}
*{box-sizing:border-box}html,body{margin:0;min-height:100%;font-family:Inter,ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;color:var(--ink)}
body{min-height:100vh;background:radial-gradient(circle at 15% 10%,#fff 0,transparent 32%),linear-gradient(135deg,#eef3ff,#f9fbff);display:flex;align-items:center;justify-content:center;padding:24px;overflow:hidden}
.page{width:min(1050px,100%);position:relative}.glow{position:absolute;width:280px;height:280px;border-radius:50%;background:#8da5ff33;filter:blur(30px);top:-100px;right:-80px;animation:float 6s ease-in-out infinite}
.card{position:relative;display:grid;grid-template-columns:1fr .85fr;gap:30px;background:#ffffffd9;border:1px solid var(--border);box-shadow:0 24px 70px #1b2d5a18;border-radius:32px;padding:clamp(28px,6vw,64px);backdrop-filter:blur(16px);overflow:hidden}
.brand{position:absolute;top:22px;left:28px}.brand img{width:130px;max-width:34vw;height:auto;display:block}
.code{font-size:clamp(76px,13vw,150px);line-height:.8;font-weight:900;letter-spacing:-.08em;color:var(--accent);margin:48px 0 22px;text-shadow:8px 8px 0 var(--soft)}
h1{font-size:clamp(30px,5vw,56px);line-height:1;margin:0 0 16px;letter-spacing:-.04em}p{font-size:17px;line-height:1.65;color:var(--muted);max-width:590px;margin:0 0 24px}.sarcasm{color:var(--ink);font-weight:700}
.actions{display:flex;flex-wrap:wrap;gap:12px}.btn{border:0;border-radius:14px;padding:13px 18px;font-weight:800;font-size:14px;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;justify-content:center;transition:.2s transform,.2s box-shadow}.btn:hover{transform:translateY(-3px);box-shadow:0 10px 25px #3157d52b}.primary{background:var(--accent);color:#fff}.secondary{background:var(--soft);color:var(--accent)}
.visual{display:flex;align-items:center;justify-content:center;min-height:340px;position:relative}.mascot{width:min(340px,75vw);height:auto;filter:drop-shadow(0 22px 18px #182a531c);animation:float 4.5s ease-in-out infinite;cursor:pointer;transition:transform .25s}.mascot:hover{transform:rotate(-3deg) scale(1.04)}
.speech{position:absolute;right:0;top:20px;background:#101828;color:#fff;border-radius:18px;padding:14px 17px;font-size:14px;font-weight:750;max-width:230px;box-shadow:0 12px 28px #10182822}.speech:after{content:"";position:absolute;bottom:-8px;left:35px;border-width:8px 8px 0;border-style:solid;border-color:#101828 transparent transparent}
.mini{margin-top:18px;font-size:12px;color:#98a2b3}.shake{animation:shake .45s ease}.confetti{position:fixed;pointer-events:none;font-size:22px;animation:fall 1.2s ease-out forwards}
@keyframes float{50%{transform:translateY(-12px) rotate(1deg)}}@keyframes shake{25%{transform:translateX(-7px)}50%{transform:translateX(7px)}75%{transform:translateX(-5px)}}@keyframes fall{to{transform:translate(var(--x),110vh) rotate(540deg);opacity:0}}
@media(max-width:760px){body{padding:14px;overflow:auto}.card{grid-template-columns:1fr;padding:28px;border-radius:24px}.brand{left:24px}.code{margin-top:64px}.visual{min-height:270px;order:-1}.speech{top:0;right:5%}.mascot{width:min(270px,65vw)}}
</style>
</head>
<body>
<main class="page"><div class="glow"></div><section class="card">
<div class="brand"><img src="/Assets/logo.png" alt="Logo"></div>
<div>
<div class="code">404</div>
<h1>Well, this is awkward.</h1>
<p>We looked everywhere. Behind the buttons. Under the menus. Even in the suspicious little corners of the internet.</p>
<p class="sarcasm">This page, however, has apparently decided to pursue a more independent lifestyle.</p>
<div class="actions"><a class="btn primary" href="/">Take me home</a><button class="btn secondary" id="back">Go back</button></div>
<div class="mini">Error 404 • The page you requested has left the building.</div>
</div>
<div class="visual"><div class="speech" id="speech">I checked. It's genuinely not here. 🙃</div><img class="mascot" id="mascot" src="/Assets/mascot.png" alt="Mascot"></div>
</section></main>
<script>
const mascot=document.getElementById('mascot'),speech=document.getElementById('speech');
mascot.addEventListener('click',()=>{mascot.classList.remove('shake');void mascot.offsetWidth;mascot.classList.add('shake');speech.textContent='Stop clicking me. I am also lost.'});
document.getElementById('back').addEventListener('click',()=>{if(history.length>1)history.back();else location.href='/'});
</script>
</body></html>
