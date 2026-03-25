<?php
// ============================================================
//  alumno.php — Portal del Alumno · CEPS
// ============================================================
require_once __DIR__ . '/includes/auth_check.php';
if (esAdmin()) { header('Location: index.php'); exit(); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CEPS — Mi Portal</title>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
/* ── Reset & base ── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { font-size: 14px; height: 100%; }
body {
  font-family: 'DM Sans', sans-serif;
  color: #1c1c2e;
  min-height: 100vh;
  background:
    radial-gradient(ellipse 80% 55% at 0% 0%,   rgba(255,200,180,.45) 0%, transparent 55%),
    radial-gradient(ellipse 65% 65% at 100% 0%,  rgba(180,210,245,.40) 0%, transparent 55%),
    radial-gradient(ellipse 60% 60% at 95% 100%, rgba(200,170,235,.38) 0%, transparent 55%),
    radial-gradient(ellipse 65% 50% at 0%  100%, rgba(255,225,160,.35) 0%, transparent 55%),
    radial-gradient(ellipse 50% 50% at 50%  50%, rgba(170,230,215,.20) 0%, transparent 60%),
    #f4f0fa;
  background-attachment: fixed;
}

/* ── Topbar ── */
.topbar {
  height: 62px;
  background: rgba(28, 22, 46, 0.92);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border-bottom: 1px solid rgba(255,255,255,0.08);
  display: flex; align-items: center;
  padding: 0 28px; gap: 14px;
  position: sticky; top: 0; z-index: 100;
}

.tb-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }

.tb-gem {
  width: 34px; height: 34px; border-radius: 10px;
  background: linear-gradient(135deg, #c77dcc, #7090d8);
  display: flex; align-items: center; justify-content: center;
  box-shadow: 0 3px 12px rgba(199,125,204,.40);
  flex-shrink: 0;
}
.tb-gem svg { color: white; }

.tb-rainbow {
  height: 2px; width: 28px; border-radius: 2px;
  background: linear-gradient(90deg,#f4a261,#e07090,#c77dcc,#7090d8,#60b8a8,#88c878);
  background-size: 200% 100%;
  animation: sF 5s linear infinite;
}
@keyframes sF { 0%{background-position:0%} 100%{background-position:200%} }

.tb-brand {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.05rem; font-weight: 500;
  color: rgba(230,220,255,.90);
}
.tb-brand em { font-style: italic; font-weight: 400; color: rgba(199,125,204,.85); }

.tb-sep { flex: 1; }

.tb-user {
  display: flex; align-items: center; gap: 8px;
  font-size: .78rem; font-weight: 500;
  color: rgba(200,190,230,.70);
}
.tb-avatar {
  width: 30px; height: 30px; border-radius: 50%;
  background: linear-gradient(135deg,#c77dcc,#7090d8);
  display: flex; align-items: center; justify-content: center;
  font-size: .75rem; font-weight: 700; color: white;
  flex-shrink: 0;
}

.btn-sal {
  padding: 6px 14px; background: transparent;
  border: 1px solid rgba(199,125,204,.28);
  border-radius: 100px;
  color: rgba(199,125,204,.70);
  font-family: 'DM Sans', sans-serif; font-size: .75rem;
  cursor: pointer; transition: all .2s; display: flex; align-items: center; gap: 5px;
}
.btn-sal:hover { background: rgba(199,125,204,.12); color: #c77dcc; border-color: rgba(199,125,204,.5); }
.btn-sal svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; }

/* ── Barra arcoíris ── */
.rainbow-bar {
  height: 3px;
  background: linear-gradient(90deg,#f4a261,#e07090,#c77dcc,#7090d8,#60b8a8,#88c878,#f4a261);
  background-size: 200% 100%;
  animation: sF 6s linear infinite;
}

/* ── Hero / Welcome ── */
.hero {
  padding: 36px 28px 28px;
  max-width: 960px; margin: 0 auto;
  display: flex; align-items: flex-start;
  justify-content: space-between; gap: 20px;
  flex-wrap: wrap;
}

.hero-text { flex: 1; min-width: 200px; }

.hero-eyebrow {
  font-size: .65rem; font-weight: 600; letter-spacing: .16em;
  text-transform: uppercase; color: #c77dcc;
  margin-bottom: .5rem; display: block;
}

.hero-name {
  font-family: 'Cormorant Garamond', serif;
  font-size: clamp(1.6rem, 4vw, 2.2rem);
  font-weight: 400; color: #1c1c2e; line-height: 1.2;
  margin-bottom: .4rem;
}
.hero-name em { font-style: italic; color: #9060c0; }

.hero-sub {
  font-size: .82rem; font-weight: 300;
  color: #6b6880; line-height: 1.6;
}

/* Stats */
.stats-row {
  display: flex; gap: 12px; flex-wrap: wrap;
}

.stat-card {
  background: rgba(255,255,255,.72);
  border: 1px solid rgba(255,255,255,.90);
  border-radius: 16px;
  padding: 14px 20px; min-width: 110px;
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  box-shadow: 0 4px 20px rgba(100,80,160,.07);
  position: relative; overflow: hidden;
}
.stat-card::before {
  content: ''; position: absolute;
  top: 0; left: 0; right: 0; height: 2px;
  border-radius: 16px 16px 0 0;
}
.stat-card.sc1::before { background: linear-gradient(90deg,#f4a261,#e07090); }
.stat-card.sc2::before { background: linear-gradient(90deg,#c77dcc,#7090d8); }
.stat-card.sc3::before { background: linear-gradient(90deg,#60b8a8,#88c878); }

.stat-v {
  font-family: 'Cormorant Garamond', serif;
  font-size: 2rem; font-weight: 500; line-height: 1;
  color: #1c1c2e; margin-bottom: 4px;
}
.stat-l {
  font-size: .62rem; font-weight: 600; letter-spacing: .12em;
  text-transform: uppercase; color: #9a90aa;
}

/* ── Main content ── */
.content {
  max-width: 960px; margin: 0 auto;
  padding: 0 28px 40px;
}

/* ── Nav tabs ── */
.nav-tabs {
  display: flex; gap: 4px;
  background: rgba(255,255,255,.55);
  border: 1px solid rgba(255,255,255,.80);
  padding: 4px; border-radius: 14px; margin-bottom: 22px;
  backdrop-filter: blur(16px);
  -webkit-backdrop-filter: blur(16px);
  box-shadow: 0 2px 12px rgba(100,80,160,.06);
}
.nav-tab {
  flex: 1; padding: 10px 8px;
  border: none; border-radius: 10px;
  font-family: 'DM Sans', sans-serif; font-size: .80rem; font-weight: 500;
  cursor: pointer; transition: all .22s;
  color: #8a8098; background: transparent;
  display: flex; align-items: center; justify-content: center; gap: 6px;
}
.nav-tab svg { width: 14px; height: 14px; flex-shrink: 0; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
.nav-tab.active {
  background: rgba(255,255,255,.90);
  color: #9060c0;
  box-shadow: 0 2px 10px rgba(140,100,190,.14);
  font-weight: 600;
}

/* ── Sections ── */
.section { display: none; }
.section.active { display: block; animation: fadeUp .28s ease; }
@keyframes fadeUp { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:translateY(0); } }

/* ── Cards ── */
.card {
  background: rgba(255,255,255,.72);
  border: 1px solid rgba(255,255,255,.90);
  border-radius: 18px; overflow: hidden;
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  box-shadow: 0 4px 24px rgba(100,80,160,.08);
  margin-bottom: 18px;
  position: relative;
}
.card::before {
  content: ''; position: absolute;
  top: 0; left: 0; right: 0; height: 3px;
  background: linear-gradient(90deg,#f4a261,#e07090,#c77dcc,#7090d8,#60b8a8,#88c878,#f4a261);
  background-size: 200% 100%;
  animation: sF 5s linear infinite;
}

.card-hd {
  padding: 15px 20px 13px;
  border-bottom: 1px solid rgba(140,100,190,.08);
  display: flex; align-items: center; justify-content: space-between;
  background: rgba(249,245,251,.50);
}
.card-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.05rem; font-weight: 500; color: #1c1c2e;
}
.card-body { padding: 20px; }

/* ── Botones ── */
.btn {
  display: inline-flex; align-items: center; gap: 6px;
  padding: 8px 18px; border-radius: 100px;
  font-family: 'DM Sans', sans-serif; font-size: .78rem;
  font-weight: 600; cursor: pointer; border: none;
  transition: all .2s; white-space: nowrap;
}
.btn svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2.2; stroke-linecap: round; }
.btn-primary {
  background: linear-gradient(135deg, #b070d0, #8090d0 50%, #60a8b8);
  background-size: 200% 100%; background-position: 0%;
  color: white;
  box-shadow: 0 4px 16px rgba(140,100,200,.28);
}
.btn-primary:hover { background-position: 100%; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(140,100,200,.38); }
.btn-ghost {
  background: rgba(255,255,255,.65); color: #6b5490;
  border: 1px solid rgba(140,100,190,.20);
}
.btn-ghost:hover { background: rgba(255,255,255,.90); border-color: rgba(199,125,204,.40); }
.btn-danger {
  background: rgba(220,80,80,.08); color: #a03030;
  border: 1px solid rgba(220,80,80,.18);
}
.btn-danger:hover { background: rgba(220,80,80,.90); color: white; }
.btn-sm { padding: 5px 13px; font-size: .72rem; }
.btn-xs { padding: 3px 10px; font-size: .68rem; }

/* ── Tabla ── */
.tw { overflow-x: auto; }
table { width: 100%; border-collapse: collapse; }
thead th {
  padding: 9px 16px; text-align: left;
  font-size: .60rem; font-weight: 700; letter-spacing: .14em;
  text-transform: uppercase; color: #9a90aa;
  border-bottom: 1.5px solid rgba(140,100,190,.10);
  background: rgba(249,245,251,.60);
}
tbody td {
  padding: 12px 16px; font-size: .82rem;
  border-bottom: 1px solid rgba(140,100,190,.06);
  vertical-align: middle;
}
tbody tr:last-child td { border-bottom: none; }
tbody tr:hover td { background: rgba(199,125,204,.05); }
.empty-row td {
  text-align: center; color: #9a90aa;
  padding: 32px; font-size: .82rem;
}

/* ── Badges ── */
.badge {
  display: inline-flex; align-items: center; gap: 4px;
  padding: 3px 10px; border-radius: 100px;
  font-size: .64rem; font-weight: 700;
}
.badge::before {
  content: ''; width: 5px; height: 5px;
  border-radius: 50%; background: currentColor; flex-shrink: 0;
}
.b-ok    { background: rgba(96,184,168,.15); color: #2a8070; }
.b-warn  { background: rgba(244,162,97,.15);  color: #b06020; }
.b-err   { background: rgba(220,80,80,.12);   color: #a03030; }
.b-purp  { background: rgba(199,125,204,.15); color: #9050a0; }
.b-blue  { background: rgba(112,144,216,.15); color: #3060a8; }

/* ── Formulario ── */
.fg { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.fgr { display: flex; flex-direction: column; gap: 5px; }
.fgr.full { grid-column: 1 / -1; }
.fgr label {
  font-size: .63rem; font-weight: 700;
  letter-spacing: .10em; text-transform: uppercase;
  color: #9a90aa;
}
.iw { position: relative; }
.ic {
  position: absolute; left: 12px; top: 50%;
  transform: translateY(-50%);
  color: #9a90aa; opacity: .5;
  pointer-events: none; transition: opacity .2s, color .2s;
  display: flex; align-items: center;
}
.ic svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 1.8; stroke-linecap: round; }
input, select, textarea {
  padding: 9px 12px 9px 36px;
  border: 1.5px solid rgba(140,100,190,.14);
  border-radius: 10px;
  font-family: 'DM Sans', sans-serif; font-size: .84rem; color: #1c1c2e;
  background: rgba(255,255,255,.78); outline: none;
  transition: all .2s; width: 100%;
}
input[type=date], input[type=time] { padding-left: 36px; }
select { padding-left: 36px; }
input:focus, select:focus, textarea:focus {
  border-color: #c77dcc;
  background: rgba(255,255,255,.97);
  box-shadow: 0 0 0 3px rgba(199,125,204,.12);
}
input::placeholder, textarea::placeholder { color: #c0b8d8; }
.iw:focus-within .ic { opacity: 1; color: #c77dcc; }
.f-act { display: flex; gap: 9px; justify-content: flex-end; margin-top: 18px; }
textarea { padding: 10px 12px; resize: vertical; min-height: 80px; }

/* ── Horarios ── */
.hs-grid { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 8px; }
.hs-btn {
  padding: 8px 16px; border-radius: 100px;
  font-size: .76rem; font-weight: 600; cursor: pointer;
  border: 1.5px solid rgba(140,100,190,.18);
  background: rgba(255,255,255,.70); color: #6b5490;
  transition: all .18s; font-family: 'DM Sans', sans-serif;
}
.hs-btn:hover, .hs-btn.sel {
  background: linear-gradient(135deg, #b070d0, #7090d8);
  color: white; border-color: transparent;
  box-shadow: 0 4px 14px rgba(140,100,200,.28);
}
.hs-btn.ocp {
  background: rgba(255,255,255,.35); color: #c0b8d8;
  border-style: dashed; cursor: not-allowed;
}
.hs-btn.ocp:hover { background: rgba(255,255,255,.35); color: #c0b8d8; border-color: rgba(140,100,190,.18); box-shadow: none; }

/* ── Modal ── */
.overlay {
  display: none; position: fixed; inset: 0;
  background: rgba(28,22,46,.55);
  backdrop-filter: blur(8px); z-index: 400;
  align-items: center; justify-content: center; padding: 20px;
}
.overlay.open { display: flex; animation: fdi .2s ease; }
@keyframes fdi { from{opacity:0;} to{opacity:1;} }

.modal {
  background: rgba(255,255,255,.95);
  border: 1px solid rgba(255,255,255,.95);
  border-radius: 20px; width: 100%; max-width: 460px;
  max-height: 88vh; overflow-y: auto;
  box-shadow: 0 24px 64px rgba(28,22,46,.22);
  animation: mdi .26s cubic-bezier(.34,1.36,.64,1);
  position: relative;
}
.modal::before {
  content: ''; position: absolute;
  top: 0; left: 0; right: 0; height: 3px;
  background: linear-gradient(90deg,#f4a261,#e07090,#c77dcc,#7090d8,#60b8a8,#88c878);
  border-radius: 20px 20px 0 0;
}
@keyframes mdi { from{opacity:0;transform:scale(.92) translateY(14px);} to{opacity:1;transform:scale(1) translateY(0);} }

.mhd {
  padding: 18px 22px 14px;
  border-bottom: 1px solid rgba(140,100,190,.08);
  display: flex; align-items: center; justify-content: space-between;
}
.m-title {
  font-family: 'Cormorant Garamond', serif;
  font-size: 1.1rem; font-weight: 500; color: #1c1c2e;
}
.m-close {
  width: 28px; height: 28px; border-radius: 50%;
  border: none; background: rgba(140,100,190,.08);
  cursor: pointer; display: flex; align-items: center; justify-content: center;
  color: #9a90aa; font-size: .85rem; transition: all .18s;
}
.m-close:hover { background: rgba(220,80,80,.12); color: #a03030; }
.mbody { padding: 18px 22px 22px; }

/* ── Toast ── */
.toast {
  position: fixed; bottom: 22px; right: 22px;
  padding: 11px 18px; border-radius: 100px;
  font-size: .80rem; font-weight: 600;
  display: none; align-items: center; gap: 8px;
  z-index: 500;
  box-shadow: 0 8px 28px rgba(28,22,46,.18);
  backdrop-filter: blur(12px);
}
#toast-ok {
  background: linear-gradient(135deg, #5a9e8a, #60b8a8);
  color: white;
}
#toast-error {
  background: linear-gradient(135deg, #c77dcc, #e07090);
  color: white;
}

/* ── Loading ── */
.spinner {
  width: 22px; height: 22px;
  border: 2.5px solid rgba(140,100,190,.15);
  border-top-color: #c77dcc;
  border-radius: 50%;
  animation: spin .7s linear infinite;
  margin: 0 auto 8px;
}
@keyframes spin { to{transform:rotate(360deg);} }
.loading { text-align: center; padding: 32px; color: #9a90aa; font-size: .82rem; }

/* ── Aviso info ── */
.info-box {
  background: rgba(112,144,216,.08);
  border: 1px solid rgba(112,144,216,.18);
  border-radius: 12px; padding: 12px 16px;
  font-size: .80rem; color: #3060a8; line-height: 1.6;
  display: flex; gap: 10px; align-items: flex-start;
}
.info-box svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; flex-shrink: 0; margin-top: 1px; }
.warn-box {
  background: rgba(220,80,80,.07);
  border: 1px solid rgba(220,80,80,.16);
  border-radius: 12px; padding: 12px 16px;
  font-size: .80rem; color: #a03030; line-height: 1.6;
  display: flex; gap: 10px; align-items: flex-start;
}
.warn-box svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; flex-shrink: 0; margin-top: 1px; }

/* ── Responsive ── */
@media (max-width: 680px) {
  .hero { flex-direction: column; padding: 24px 18px 20px; }
  .content { padding: 0 18px 32px; }
  .topbar { padding: 0 16px; }
  .fg { grid-template-columns: 1fr; }
  .nav-tab span { display: none; }
  .stats-row { gap: 8px; }
  .stat-card { padding: 12px 14px; min-width: 90px; }
}
</style>
</head>
<body>

<!-- ── Topbar ── -->
<div class="topbar">
  <a class="tb-logo" href="#">
    <div class="tb-gem">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M12 2C9 2 7 5 7 8c0 2.5 1 4.5 2.5 6L12 22l2.5-8C16 12.5 17 10.5 17 8c0-3-2-6-5-6z"/>
        <circle cx="12" cy="8" r="2" fill="white" stroke="none"/>
      </svg>
    </div>
    <div class="tb-rainbow"></div>
    <div class="tb-brand">CEPS — <em>Mi Portal</em></div>
  </a>
  <div class="tb-sep"></div>
  <div class="tb-user">
    <div class="tb-avatar" id="tb-initials">—</div>
    <span id="tb-nombre"><?= htmlspecialchars($usuarioNombre) ?></span>
  </div>
  <button class="btn-sal" onclick="cerrarSesion()">
    <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
    Salir
  </button>
</div>
<div class="rainbow-bar"></div>

<!-- ── Hero ── -->
<div class="hero">
  <div class="hero-text">
    <span class="hero-eyebrow">Centro de Psicología · UTN</span>
    <h1 class="hero-name">
      Hola, <em id="hero-nombre"><?= htmlspecialchars(explode(' ', $usuarioNombre)[0]) ?></em> 👋
    </h1>
    <p class="hero-sub">Bienvenida/o a tu portal personal del CEPS.<br>Aquí puedes gestionar tus citas y consultar tu historial.</p>
  </div>

  <div class="stats-row">
    <div class="stat-card sc1">
      <div class="stat-v" id="cnt-citas">—</div>
      <div class="stat-l">Mis Citas</div>
    </div>
    <div class="stat-card sc2">
      <div class="stat-v" id="cnt-sesiones">—</div>
      <div class="stat-l">Sesiones</div>
    </div>
    <div class="stat-card sc3">
      <div class="stat-v" id="cnt-asistidas">—</div>
      <div class="stat-l">Asistidas</div>
    </div>
  </div>
</div>

<!-- ── Contenido ── -->
<div class="content">

  <!-- Tabs -->
  <div class="nav-tabs">
    <button class="nav-tab active" onclick="showTab('citas', this)">
      <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
      <span>Mis Citas</span>
    </button>
    <button class="nav-tab" onclick="showTab('sesiones', this)">
      <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/></svg>
      <span>Mis Sesiones</span>
    </button>
    <button class="nav-tab" onclick="showTab('nueva-cita', this)">
      <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
      <span>Agendar Cita</span>
    </button>
  </div>

  <!-- ── MIS CITAS ── -->
  <section class="section active" id="s-citas">
    <div class="card">
      <div class="card-hd">
        <div class="card-title">Mis Citas Programadas</div>
        <button class="btn btn-primary btn-sm"
          onclick="showTab('nueva-cita', document.querySelectorAll('.nav-tab')[2])">
          <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Nueva Cita
        </button>
      </div>
      <div class="tw">
        <table id="tabla-mis-citas">
          <thead>
            <tr>
              <th>Fecha</th><th>Hora</th><th>Estado</th><th>Acción</th>
            </tr>
          </thead>
          <tbody>
            <tr class="empty-row">
              <td colspan="4">
                <div class="loading">
                  <div class="spinner"></div>
                  Cargando tus citas...
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- ── MIS SESIONES ── -->
  <section class="section" id="s-sesiones">
    <div class="card">
      <div class="card-hd">
        <div class="card-title">Mi Historial de Sesiones</div>
        <span style="font-size:.75rem;color:#9a90aa" id="lbl-total-ses"></span>
      </div>
      <div class="tw">
        <table id="tabla-mis-sesiones">
          <thead>
            <tr>
              <th>#</th><th>Fecha</th><th>Estado</th><th>Diagnóstico / Motivo</th><th>Notas</th>
            </tr>
          </thead>
          <tbody>
            <tr class="empty-row">
              <td colspan="5">
                <div class="loading">
                  <div class="spinner"></div>
                  Cargando historial...
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- ── AGENDAR CITA ── -->
  <section class="section" id="s-nueva-cita">
    <div class="card">
      <div class="card-hd">
        <div class="card-title">Agendar Nueva Cita</div>
      </div>
      <div class="card-body">

        <div class="info-box" style="margin-bottom:18px">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          Selecciona una fecha disponible y elige uno de los horarios que aparecerán abajo. El equipo CEPS confirmará tu cita a la brevedad.
        </div>

        <div class="fg">
          <div class="fgr">
            <label>Fecha deseada</label>
            <div class="iw">
              <span class="ic">
                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
              </span>
              <input type="date" id="nc-fecha" min="<?= date('Y-m-d') ?>"
                onchange="cargarHorariosAlumno(this.value)">
            </div>
          </div>
          <div class="fgr">
            <label>Hora seleccionada</label>
            <div class="iw">
              <span class="ic">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
              </span>
              <input type="time" id="nc-hora" readonly placeholder="Elige un horario de abajo">
            </div>
          </div>
          <div class="fgr full">
            <label>Horarios disponibles — toca para seleccionar</label>
            <div class="hs-grid" id="hs-grid-alumno">
              <p style="color:#9a90aa;font-size:.80rem;font-weight:300">
                Primero selecciona una fecha ↑
              </p>
            </div>
          </div>
        </div>

        <div class="f-act">
          <button class="btn btn-ghost" type="button"
            onclick="showTab('citas', document.querySelectorAll('.nav-tab')[0])">
            Cancelar
          </button>
          <button class="btn btn-primary" onclick="agendarCita()">
            <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            Confirmar Cita
          </button>
        </div>

      </div>
    </div>
  </section>

</div><!-- /content -->

<!-- ── Modal: Cancelar cita ── -->
<div class="overlay" id="ov-cancelar">
  <div class="modal">
    <div class="mhd">
      <div class="m-title">Cancelar Cita</div>
      <button class="m-close" onclick="closeM('cancelar')">✕</button>
    </div>
    <div class="mbody">
      <p style="font-size:.88rem;color:#4a4060;margin-bottom:14px;line-height:1.65">
        ¿Estás segura/o de que deseas cancelar esta cita?
      </p>
      <div class="warn-box" style="margin-bottom:16px">
        <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        Esta acción no se puede deshacer. Si necesitas atención, podrás solicitar una nueva cita.
      </div>
      <input type="hidden" id="folio-cancelar">
      <div class="f-act">
        <button class="btn btn-ghost" onclick="closeM('cancelar')">No, mantener</button>
        <button class="btn btn-danger" onclick="confirmarCancelar()">Sí, cancelar cita</button>
      </div>
    </div>
  </div>
</div>

<div class="toast" id="toast-ok"></div>
<div class="toast" id="toast-error"></div>

<script>
const MI_ID     = <?= json_encode($usuarioId) ?>;
const MI_NOMBRE = <?= json_encode($usuarioNombre) ?>;
const BASE      = '/ceps/api';

// ── Iniciales del avatar ─────────────────────────────────
(function(){
  const partes = MI_NOMBRE.trim().split(' ');
  const ini = (partes[0]?.[0] || '') + (partes[1]?.[0] || '');
  document.getElementById('tb-initials').textContent = ini.toUpperCase() || '?';
})();

// ── Utilidades ──────────────────────────────────────────
function toast(msg, ok = true) {
  const el = document.getElementById(ok ? 'toast-ok' : 'toast-error');
  el.innerHTML = `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
    ${ok ? '<polyline points="20 6 9 17 4 12"/>' : '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>'}
  </svg> ${msg}`;
  el.style.display = 'flex';
  setTimeout(() => el.style.display = 'none', 3800);
}

function fmtF(f) {
  if (!f) return '—';
  return new Date(f + 'T00:00:00').toLocaleDateString('es-MX',
    {day:'2-digit', month:'long', year:'numeric'});
}

async function apiFetch(url, method = 'GET', body = null) {
  const opts = { method, headers: { 'Content-Type': 'application/json' } };
  if (body) opts.body = JSON.stringify(body);
  const r = await fetch(BASE + url, opts);
  const j = await r.json();
  if (j.error) throw new Error(j.message || 'Error del servidor');
  return j.data;
}

function openM(id)  { document.getElementById('ov-' + id)?.classList.add('open'); }
function closeM(id) { document.getElementById('ov-' + id)?.classList.remove('open'); }

document.querySelectorAll('.overlay').forEach(o =>
  o.addEventListener('click', e => { if (e.target === o) o.classList.remove('open'); })
);

function cerrarSesion() {
  fetch(BASE + '/auth.php', { method: 'DELETE' })
    .finally(() => window.location.href = 'login.php');
}

// ── Tabs ────────────────────────────────────────────────
function showTab(id, btn) {
  document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
  document.querySelectorAll('.nav-tab').forEach(b => b.classList.remove('active'));
  document.getElementById('s-' + id)?.classList.add('active');
  if (btn) btn.classList.add('active');
  if (id === 'citas')    cargarMisCitas();
  if (id === 'sesiones') cargarMisSesiones();
}

// ── Mis Citas ────────────────────────────────────────────
async function cargarMisCitas() {
  const tbody = document.querySelector('#tabla-mis-citas tbody');
  tbody.innerHTML = '<tr class="empty-row"><td colspan="4"><div class="loading"><div class="spinner"></div>Cargando...</div></td></tr>';
  try {
    const citas = await apiFetch(`/citas.php?idUsuario=${MI_ID}`);
    tbody.innerHTML = '';
    document.getElementById('cnt-citas').textContent = citas.length;

    if (!citas.length) {
      tbody.innerHTML = `<tr class="empty-row"><td colspan="4">
        <div style="padding:24px 0">
          <div style="font-size:1.4rem;margin-bottom:8px">📅</div>
          No tienes citas programadas
          <br><a href="#" onclick="showTab('nueva-cita',document.querySelectorAll('.nav-tab')[2])"
            style="color:#9060c0;font-weight:600;font-size:.78rem;text-decoration:none">
            + Agendar una cita
          </a>
        </div>
      </td></tr>`;
      return;
    }

    const mapBadge = { Programada:'b-warn', Confirmada:'b-ok', Cancelada:'b-err', Completada:'b-purp' };
    citas.forEach(c => {
      const badge = mapBadge[c.Estado] || 'b-blue';
      tbody.insertAdjacentHTML('beforeend', `
        <tr>
          <td><strong>${fmtF(c.Fecha)}</strong></td>
          <td><span style="font-family:'Cormorant Garamond',serif;font-size:1rem;font-weight:500">${(c.Hora||'').substring(0,5)}</span></td>
          <td><span class="badge ${badge}">${c.Estado}</span></td>
          <td>
            ${(c.Estado === 'Programada' || c.Estado === 'Confirmada')
              ? `<button class="btn btn-danger btn-xs" onclick="pedirCancelar(${c.Folio})">Cancelar</button>`
              : '<span style="color:#c0b8d8;font-size:.75rem">—</span>'}
          </td>
        </tr>
      `);
    });
  } catch(e) { toast(e.message, false); }
}

function pedirCancelar(folio) {
  document.getElementById('folio-cancelar').value = folio;
  openM('cancelar');
}

async function confirmarCancelar() {
  const folio = document.getElementById('folio-cancelar').value;
  try {
    await apiFetch(`/citas.php?id=${folio}`, 'DELETE');
    toast('Cita cancelada correctamente');
    closeM('cancelar');
    cargarMisCitas();
  } catch(e) { toast(e.message, false); }
}

// ── Mis Sesiones ─────────────────────────────────────────
async function cargarMisSesiones() {
  const tbody = document.querySelector('#tabla-mis-sesiones tbody');
  tbody.innerHTML = '<tr class="empty-row"><td colspan="5"><div class="loading"><div class="spinner"></div>Cargando...</div></td></tr>';
  try {
    const ses = await apiFetch(`/sesiones.php?idUsuario=${MI_ID}`);
    tbody.innerHTML = '';
    document.getElementById('cnt-sesiones').textContent  = ses.length;
    const asistidas = ses.filter(s => s.Estado === 'Asistió').length;
    document.getElementById('cnt-asistidas').textContent = asistidas;
    document.getElementById('lbl-total-ses').textContent =
      `${ses.length} sesión${ses.length !== 1 ? 'es' : ''} · ${asistidas} asistida${asistidas !== 1 ? 's' : ''}`;

    if (!ses.length) {
      tbody.innerHTML = '<tr class="empty-row"><td colspan="5"><div style="padding:20px 0">📋 Aún no tienes sesiones registradas</div></td></tr>';
      return;
    }

    const mapBadge = { 'Asistió':'b-ok', 'Faltó':'b-err', 'Reprogramada':'b-warn' };
    ses.forEach(s => {
      const badge = mapBadge[s.Estado] || 'b-purp';
      tbody.insertAdjacentHTML('beforeend', `
        <tr>
          <td><span class="badge b-purp">${s.Numero_Sesion}</span></td>
          <td>${fmtF(s.Fecha)}</td>
          <td><span class="badge ${badge}">${s.Estado}</span></td>
          <td style="font-size:.80rem;color:#4a4060;max-width:180px">${s.Diagnostico || '<span style="color:#c0b8d8">—</span>'}</td>
          <td style="font-size:.76rem;color:#9a90aa;max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
            ${s.Notas || '<span style="color:#c0b8d8">—</span>'}
          </td>
        </tr>
      `);
    });
  } catch(e) { toast(e.message, false); }
}

// ── Horarios disponibles ──────────────────────────────────
let horarioSel = null;

async function cargarHorariosAlumno(fecha) {
  const cont = document.getElementById('hs-grid-alumno');
  if (!fecha) {
    cont.innerHTML = '<p style="color:#9a90aa;font-size:.80rem;font-weight:300">Selecciona una fecha primero ↑</p>';
    return;
  }
  cont.innerHTML = '<div class="spinner" style="width:20px;height:20px;margin:12px auto"></div>';
  document.getElementById('nc-hora').value = '';
  horarioSel = null;

  try {
    const slots = await apiFetch(`/calendario.php?fecha=${fecha}`);
    cont.innerHTML = '';
    if (!slots.length) {
      cont.innerHTML = '<p style="color:#9a90aa;font-size:.80rem;font-weight:300">No hay horarios disponibles para esta fecha</p>';
      return;
    }
    slots.forEach(s => {
      const ocp = s.disponible == 0;
      const btn = document.createElement('button');
      btn.className = 'hs-btn' + (ocp ? ' ocp' : '');
      btn.textContent = s.hora.substring(0, 5);
      if (!ocp) {
        btn.addEventListener('click', function() {
          document.querySelectorAll('.hs-btn').forEach(b => b.classList.remove('sel'));
          this.classList.add('sel');
          document.getElementById('nc-hora').value = s.hora.substring(0, 5);
          horarioSel = s;
        });
      }
      cont.appendChild(btn);
    });
  } catch(e) {
    cont.innerHTML = '<p style="color:#a03030;font-size:.80rem">Error al cargar horarios</p>';
  }
}

// ── Agendar cita ──────────────────────────────────────────
async function agendarCita() {
  const fecha = document.getElementById('nc-fecha').value;
  const hora  = document.getElementById('nc-hora').value;
  if (!fecha) { toast('Selecciona una fecha', false); return; }
  if (!hora)  { toast('Elige un horario de la lista', false); return; }

  try {
    await apiFetch('/citas.php', 'POST', {
      idUsuario: MI_ID,
      idHorario: horarioSel?.idHorario || null,
      Fecha:     fecha,
      Hora:      hora,
      Estado:    'Programada',
    });
    toast('¡Cita agendada! El equipo CEPS te confirmará pronto 🌿');
    document.getElementById('nc-fecha').value = '';
    document.getElementById('nc-hora').value  = '';
    document.getElementById('hs-grid-alumno').innerHTML =
      '<p style="color:#9a90aa;font-size:.80rem;font-weight:300">Selecciona una fecha ↑</p>';
    horarioSel = null;
    showTab('citas', document.querySelectorAll('.nav-tab')[0]);
  } catch(e) { toast(e.message, false); }
}

// ── Init ─────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
  cargarMisCitas();
  cargarMisSesiones();
});
</script>
</body>
</html>