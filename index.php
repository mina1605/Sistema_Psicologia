<?php require_once __DIR__ . '/includes/auth_check.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8"/><meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<title>CEPS — Panel de Gestión</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
<style>html{height:100%;}

*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
html{font-size:14px;}
:root{
  --sw:260px;--th:52px;
  /* Paleta emocional vibrante */
  --joy:   #F9A825;
  --love:  #E91E8C;
  --trust: #9C27B0;
  --calm:  #1976D2;
  --hope:  #00897B;
  --vibe:  #43A047;
  --energy:#E53935;
  /* Tipografía e tinta — alto contraste, elegante */
  --ink:   #18181f;   /* casi negro cálido */
  --ink-s: #2d2d3a;
  --ink-m: #4a4a5a;
  --ink-mu:#6e6e82;
  /* Fondos */
  --bg:#f5f2fc;--bg-s:#ede8f8;--white:#ffffff;
  --border:rgba(120,80,180,.16);--border-s:rgba(120,80,180,.09);
  --accent:#8e24aa;--accent-d:#6a0080;--accent-l:#ce93d8;
  --sh-xs:0 2px 8px rgba(60,30,100,.08);
  --sh-sm:0 4px 18px rgba(60,30,100,.11);
  --sh-md:0 10px 36px rgba(60,30,100,.14);
  --sh-lg:0 24px 64px rgba(60,30,100,.20);
  --r:14px;--r-sm:9px;--r-lg:22px;
}

/* ── Fuentes: Plus Jakarta Sans para cuerpo (legible, moderna, elegante)
         + Playfair Display para títulos (elegante, carácter) ── */
body{
  font-family:'Plus Jakarta Sans',sans-serif;
  color:var(--ink);
  line-height:1.6;
  display:flex;
  height:100vh;
  background:
    radial-gradient(ellipse 80% 55% at 0% 0%,   rgba(255,200,180,.45) 0%,transparent 55%),
    radial-gradient(ellipse 65% 65% at 100% 0%,  rgba(180,210,245,.42) 0%,transparent 55%),
    radial-gradient(ellipse 60% 60% at 95% 100%, rgba(200,170,235,.38) 0%,transparent 55%),
    radial-gradient(ellipse 65% 50% at 0%  100%, rgba(255,225,160,.35) 0%,transparent 55%),
    radial-gradient(ellipse 50% 50% at 50%  50%, rgba(170,230,215,.22) 0%,transparent 60%),
    #f5f2fc;
  animation:bgP 16s ease-in-out infinite alternate;
}
@keyframes bgP{
  0%  {filter:hue-rotate(0deg)  saturate(1)   brightness(1);}
  50% {filter:hue-rotate(6deg)  saturate(1.04)brightness(1.01);}
  100%{filter:hue-rotate(-5deg) saturate(1)   brightness(1);}
}

/* Dots flotantes */
.dots-bg{position:fixed;inset:0;pointer-events:none;overflow:hidden;z-index:0;}
.fd{position:absolute;border-radius:50%;animation:fD linear infinite;opacity:0;}
@keyframes fD{
  0%  {transform:translateY(105vh)scale(.6);opacity:0;}
  8%  {opacity:.75;}92%{opacity:.70;}
  100%{transform:translateY(-8vh)scale(1.1);opacity:0;}
}

/* ═══════════════════════════════
   SIDEBAR
═══════════════════════════════ */
.sidebar{
  width:var(--sw);height:100vh;
  position:fixed;top:0;left:0;
  background:linear-gradient(170deg,#0f0720 0%,#1a0d35 50%,#120a28 100%);
  display:flex;flex-direction:column;z-index:200;overflow:hidden;
}
.sidebar::before{
  content:'';position:absolute;top:-80px;right:-80px;width:260px;height:260px;border-radius:50%;
  background:radial-gradient(circle,rgba(233,30,140,.16),transparent 70%);pointer-events:none;
}
.sidebar::after{
  content:'';position:absolute;bottom:-60px;left:-60px;width:200px;height:200px;border-radius:50%;
  background:radial-gradient(circle,rgba(25,118,210,.14),transparent 70%);pointer-events:none;
}

.sb-spectrum{
  height:4px;width:100%;flex-shrink:0;
  background:linear-gradient(90deg,#F9A825,#E91E8C,#9C27B0,#1976D2,#00897B,#43A047,#E53935,#F9A825);
  background-size:200% 100%;animation:specFlow 4s linear infinite;
}
@keyframes specFlow{0%{background-position:0%}100%{background-position:200%}}

.brand{
  padding:18px 16px 15px;border-bottom:1px solid rgba(255,255,255,.07);
  display:flex;align-items:center;gap:12px;position:relative;z-index:1;
}
.brand-logo{
  width:44px;height:44px;border-radius:14px;overflow:hidden;flex-shrink:0;
  background:rgba(255,255,255,.08);display:flex;align-items:center;justify-content:center;
  box-shadow:0 2px 14px rgba(233,30,140,.22);
}
.brand-logo img{width:100%;height:100%;object-fit:contain;}
/* Nombre en sidebar — Playfair elegante */
.brand-txt .nm{
  font-family:'Playfair Display',serif;
  font-size:1.1rem;color:rgba(255,255,255,.94);font-weight:600;
  letter-spacing:.01em;
}
.brand-txt .sb{font-size:.56rem;color:rgba(233,30,140,.42);letter-spacing:.16em;text-transform:uppercase;margin-top:2px;font-family:'Plus Jakarta Sans',sans-serif;}

.nav-scroll{flex:1;overflow-y:auto;padding:8px 0;position:relative;z-index:1;min-height:0;}
.nav-scroll::-webkit-scrollbar{width:3px;}
.nav-scroll::-webkit-scrollbar-thumb{background:rgba(200,150,220,.20);border-radius:3px;}

.nav-label{
  padding:14px 18px 4px;
  font-size:.53rem;font-weight:700;letter-spacing:.26em;text-transform:uppercase;
  color:rgba(255,255,255,.22);font-family:'Plus Jakarta Sans',sans-serif;
}
.nav-btn{
  width:100%;display:flex;align-items:center;gap:10px;
  padding:9px 18px;border:none;background:transparent;
  /* Texto sidebar: blanco con buena opacidad */
  color:rgba(255,255,255,.52);
  font-family:'Plus Jakarta Sans',sans-serif;font-size:.83rem;font-weight:500;
  cursor:pointer;transition:all .2s;position:relative;text-align:left;
}
.nav-btn .ic{
  width:30px;height:30px;border-radius:var(--r-sm);
  display:flex;align-items:center;justify-content:center;
  background:rgba(255,255,255,.05);flex-shrink:0;transition:all .22s;
}
.nav-btn:hover{color:rgba(255,255,255,.88);}
.nav-btn:hover .ic{background:rgba(255,255,255,.10);}
.nav-btn.active{color:white;background:rgba(255,255,255,.09);font-weight:600;}
.nav-btn.active .ic{background:linear-gradient(135deg,#9C27B0,#E91E8C);box-shadow:0 3px 14px rgba(156,39,176,.45);}
.nav-btn.active::before{
  content:'';position:absolute;left:0;top:50%;transform:translateY(-50%);
  width:3px;height:22px;border-radius:0 4px 4px 0;
  background:linear-gradient(180deg,#9C27B0,#E91E8C);
}
.nav-btn[data-sec="usuarios"].active   .ic{background:linear-gradient(135deg,#1976D2,#9C27B0);box-shadow:0 3px 14px rgba(25,118,210,.45);}
.nav-btn[data-sec="usuarios"].active::before{background:linear-gradient(180deg,#1976D2,#9C27B0);}
.nav-btn[data-sec="citas"].active      .ic{background:linear-gradient(135deg,#F9A825,#E91E8C);box-shadow:0 3px 14px rgba(249,168,37,.45);}
.nav-btn[data-sec="citas"].active::before{background:linear-gradient(180deg,#F9A825,#E91E8C);}
.nav-btn[data-sec="sesiones"].active   .ic{background:linear-gradient(135deg,#00897B,#1976D2);box-shadow:0 3px 14px rgba(0,137,123,.45);}
.nav-btn[data-sec="sesiones"].active::before{background:linear-gradient(180deg,#00897B,#1976D2);}
.nav-btn[data-sec="expedientes"].active .ic{background:linear-gradient(135deg,#43A047,#00897B);box-shadow:0 3px 14px rgba(67,160,71,.45);}
.nav-btn[data-sec="expedientes"].active::before{background:linear-gradient(180deg,#43A047,#00897B);}
.nav-btn[data-sec="canalizaciones"].active .ic{background:linear-gradient(135deg,#E53935,#F9A825);box-shadow:0 3px 14px rgba(229,57,53,.45);}
.nav-btn[data-sec="canalizaciones"].active::before{background:linear-gradient(180deg,#E53935,#F9A825);}
.nav-btn[data-sec="reportes"].active   .ic{background:linear-gradient(135deg,#F9A825,#43A047);box-shadow:0 3px 14px rgba(249,168,37,.45);}
.nav-btn[data-sec="reportes"].active::before{background:linear-gradient(180deg,#F9A825,#43A047);}

.nav-badge{margin-left:auto;background:#E91E8C;color:white;font-size:.56rem;font-weight:700;padding:2px 7px;border-radius:20px;}

.sb-emotions{padding:10px 18px 12px;border-top:1px solid rgba(255,255,255,.06);margin-top:6px;}
.sb-emo-label{font-size:.52rem;font-weight:700;letter-spacing:.18em;text-transform:uppercase;color:rgba(255,255,255,.18);display:block;margin-bottom:8px;font-family:'Plus Jakarta Sans',sans-serif;}
.sb-emo-dots{display:flex;gap:7px;align-items:center;}
.emod{border-radius:50%;animation:emoP ease-in-out infinite alternate;cursor:default;transition:transform .2s;}
.emod:hover{transform:scale(1.6);}
@keyframes emoP{from{opacity:.5;transform:scale(1);}to{opacity:1;transform:scale(1.2);}}

.sb-foot{flex-shrink:0;padding:10px 13px;border-top:1px solid rgba(255,255,255,.07);background:rgba(0,0,0,.18);position:relative;z-index:1;}
.user-row{display:flex;align-items:center;gap:10px;background:rgba(255,255,255,.06);border-radius:14px;padding:9px 12px;}
.user-av{
  width:34px;height:34px;border-radius:50%;flex-shrink:0;
  background:linear-gradient(135deg,#9C27B0,#E91E8C);
  display:flex;align-items:center;justify-content:center;
  font-family:'Playfair Display',serif;font-size:.84rem;color:white;
  box-shadow:0 2px 10px rgba(156,39,176,.38);
}
.user-nm{font-size:.80rem;color:rgba(255,255,255,.90);font-weight:600;line-height:1.2;}
.user-rl{font-size:.61rem;color:rgba(255,255,255,.35);}
.btn-out{margin-left:auto;background:transparent;border:none;color:rgba(255,255,255,.30);cursor:pointer;font-size:.72rem;padding:5px 8px;border-radius:7px;transition:all .2s;}
.btn-out:hover{background:rgba(233,30,140,.20);color:#E91E8C;}

/* ═══════════════════════════════
   MAIN + TOPBAR
═══════════════════════════════ */
.main{margin-left:var(--sw);flex:1;display:flex;flex-direction:column;height:100vh;overflow:hidden;}

.topbar{
  height:var(--th);flex-shrink:0;
  background:rgba(245,242,252,.90);
  backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px);
  border-bottom:1px solid rgba(120,80,180,.14);
  display:flex;align-items:center;gap:12px;padding:0 22px;
  position:relative;z-index:100;
}
.tb-wrap{flex:1;}
/* Título topbar en Playfair */
.tb-title{
  font-family:'Playfair Display',serif;
  font-size:1.18rem;color:var(--ink);font-weight:600;
}
.tb-crumb{font-size:.70rem;color:var(--ink-mu);margin-top:1px;}
.tb-search{
  display:flex;align-items:center;gap:8px;
  background:rgba(255,255,255,.78);border:1.5px solid rgba(120,80,180,.18);
  border-radius:12px;padding:7px 14px;min-width:195px;transition:all .2s;
}
.tb-search:focus-within{border-color:var(--trust);background:white;box-shadow:0 0 0 3px rgba(156,39,176,.12);}
.tb-search svg{color:var(--ink-mu);flex-shrink:0;}
.tb-search input{
  border:none;background:transparent;outline:none;
  font-family:'Plus Jakarta Sans',sans-serif;font-size:.82rem;
  color:var(--ink);width:100%;
}
.tb-search input::placeholder{color:var(--ink-mu);}
.tb-spectrum{
  height:3px;position:absolute;bottom:0;left:0;right:0;
  background:linear-gradient(90deg,#F9A825,#E91E8C,#9C27B0,#1976D2,#00897B,#43A047,#F9A825);
  background-size:200% 100%;animation:specFlow 5s linear infinite;opacity:.65;
}

/* ═══════════════════════════════
   BOTONES
═══════════════════════════════ */
.btn{display:inline-flex;align-items:center;gap:6px;padding:8px 18px;border-radius:var(--r-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:.82rem;font-weight:600;cursor:pointer;border:none;transition:all .22s;white-space:nowrap;letter-spacing:.01em;}
.btn-primary{background:linear-gradient(135deg,#9C27B0,#E91E8C);color:white;box-shadow:0 4px 14px rgba(156,39,176,.38);}
.btn-primary:hover{transform:translateY(-2px);box-shadow:0 8px 22px rgba(156,39,176,.48);}
.btn-accent{background:linear-gradient(135deg,#1976D2,#00897B);color:white;box-shadow:0 4px 12px rgba(25,118,210,.32);}
.btn-accent:hover{transform:translateY(-1px);}
.btn-ghost{background:rgba(255,255,255,.75);color:var(--ink-m);border:1.5px solid rgba(120,80,180,.20);}
.btn-ghost:hover{background:white;border-color:rgba(156,39,176,.35);color:var(--accent-d);}
.btn-danger{background:rgba(229,57,53,.10);color:#c62828;border:1px solid rgba(229,57,53,.22);}
.btn-danger:hover{background:#E53935;color:white;}
.btn-gold{background:linear-gradient(135deg,#F9A825,#FB8C00);color:white;box-shadow:0 4px 12px rgba(249,168,37,.36);}
.btn-gold:hover{transform:translateY(-1px);}
.btn-sm{padding:5px 12px;font-size:.74rem;}
.btn-xs{padding:3px 8px;font-size:.69rem;}

/* ═══════════════════════════════
   CONTENIDO
═══════════════════════════════ */
.content{flex:1;overflow-y:auto;padding:20px 22px;min-height:0;}
.section{display:none;}.section.active{display:block;animation:fadeUp .28s ease;}
@keyframes fadeUp{from{opacity:0;transform:translateY(8px);}to{opacity:1;transform:translateY(0);}}
.sh{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:22px;gap:12px;}
/* Heading secciones en Playfair */
.sh h2{
  font-family:'Playfair Display',serif;
  font-size:1.6rem;font-weight:600;color:var(--ink);letter-spacing:-.01em;
}
.sh p{font-size:.80rem;color:var(--ink-mu);margin-top:3px;}
.sh-r{display:flex;gap:9px;align-items:center;flex-shrink:0;}

/* STAT CARDS */
.stats-row{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:22px;}
.stat-card{
  background:rgba(255,255,255,.78);
  backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);
  border-radius:var(--r-lg);padding:18px 20px;
  border:1px solid rgba(255,255,255,.92);
  box-shadow:var(--sh-sm);position:relative;overflow:hidden;transition:all .25s;cursor:default;
}
.stat-card:hover{transform:translateY(-4px);box-shadow:var(--sh-md);}
.stat-card::before{content:'';position:absolute;top:0;left:0;right:0;height:4px;border-radius:var(--r-lg) var(--r-lg) 0 0;}
.s1::before{background:linear-gradient(90deg,#9C27B0,#E91E8C);}
.s2::before{background:linear-gradient(90deg,#F9A825,#E91E8C);}
.s3::before{background:linear-gradient(90deg,#E91E8C,#9C27B0);}
.s4::before{background:linear-gradient(90deg,#1976D2,#00897B);}
.stat-card::after{content:'';position:absolute;top:-20px;right:-20px;width:80px;height:80px;border-radius:50%;opacity:.25;transition:all .3s;}
.stat-card:hover::after{width:100px;height:100px;opacity:.35;}
.s1::after{background:#9C27B0;}.s2::after{background:#F9A825;}.s3::after{background:#E91E8C;}.s4::after{background:#1976D2;}
.stat-ic{width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;margin-bottom:12px;}
.s1 .stat-ic{background:rgba(156,39,176,.14);color:#7b1fa2;}
.s2 .stat-ic{background:rgba(249,168,37,.18);color:#e65100;}
.s3 .stat-ic{background:rgba(233,30,140,.12);color:#ad1457;}
.s4 .stat-ic{background:rgba(25,118,210,.14);color:#0d47a1;}
/* Número en Playfair */
.stat-lbl{font-size:.62rem;font-weight:700;letter-spacing:.13em;text-transform:uppercase;color:var(--ink-mu);margin-bottom:4px;}
.stat-val{font-family:'Playfair Display',serif;font-size:2.2rem;color:var(--ink);line-height:1;margin-bottom:5px;font-weight:700;}
.stat-sub{font-size:.71rem;color:var(--ink-mu);}

/* CARDS */
.card{
  background:rgba(255,255,255,.78);
  backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);
  border-radius:var(--r-lg);border:1px solid rgba(255,255,255,.92);
  box-shadow:var(--sh-sm);overflow:hidden;
}
.card-hd{
  padding:14px 20px;border-bottom:1px solid rgba(120,80,180,.09);
  display:flex;align-items:center;justify-content:space-between;gap:8px;
  background:rgba(255,255,255,.55);position:relative;
}
.card-hd::after{
  content:'';position:absolute;bottom:0;left:0;right:0;height:2px;
  background:linear-gradient(90deg,#F9A825,#E91E8C,#9C27B0,#1976D2,#00897B,#43A047);
  background-size:200% 100%;animation:specFlow 7s linear infinite;opacity:.45;
}
/* Título card en Playfair */
.card-title{
  font-family:'Playfair Display',serif;
  font-size:1rem;color:var(--ink);font-weight:600;
}
.card-body{padding:18px 20px;}

/* TABLAS */
.tw{overflow-x:auto;}
table{width:100%;border-collapse:collapse;}
thead th{
  padding:9px 14px;text-align:left;
  font-size:.60rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;
  color:var(--ink-m);  /* más oscuro que antes */
  border-bottom:2px solid rgba(120,80,180,.14);
  background:rgba(237,232,248,.55);white-space:nowrap;
}
tbody td{
  padding:11px 14px;font-size:.84rem;
  color:var(--ink);  /* negro cálido — máxima legibilidad */
  border-bottom:1px solid rgba(120,80,180,.07);vertical-align:middle;
}
tbody tr:last-child td{border-bottom:none;}
tbody tr:hover td{background:rgba(156,39,176,.04);}
.empty-row td{text-align:center;color:var(--ink-mu);padding:28px;font-size:.82rem;}

/* AVATARES */
.av{width:30px;height:30px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-family:'Playfair Display',serif;font-size:.72rem;font-weight:700;flex-shrink:0;}
.av-a{background:rgba(156,39,176,.18);color:#6a0080;}
.av-b{background:rgba(249,168,37,.22);color:#b26a00;}
.av-c{background:rgba(233,30,140,.16);color:#880E4F;}
.av-d{background:rgba(25,118,210,.18);color:#0D47A1;}
.av-e{background:rgba(0,137,123,.18);color:#004D40;}
.pc{display:flex;align-items:center;gap:8px;}
.pi .n{font-weight:600;font-size:.84rem;color:var(--ink);}
.pi .s{font-size:.67rem;color:var(--ink-mu);}

/* BADGES */
.badge{display:inline-flex;align-items:center;gap:3px;padding:2px 9px;border-radius:20px;font-size:.66rem;font-weight:700;}
.badge::before{content:'';width:4px;height:4px;border-radius:50%;background:currentColor;flex-shrink:0;}
.b-ok  {background:rgba(0,137,123,.14);color:#00695c;}
.b-warn{background:rgba(249,168,37,.18);color:#e65100;}
.b-err {background:rgba(233,30,140,.12);color:#880E4F;}
.b-info{background:rgba(25,118,210,.14);color:#0D47A1;}
.b-purp{background:rgba(156,39,176,.14);color:#6A0080;}
.b-gold{background:rgba(249,168,37,.18);color:#b26a00;}

/* PILLS */
.pills{display:flex;gap:3px;background:rgba(237,232,248,.65);padding:3px;border-radius:10px;}
.pill{padding:5px 12px;border-radius:7px;border:none;font-family:'Plus Jakarta Sans',sans-serif;font-size:.74rem;font-weight:600;cursor:pointer;transition:all .18s;color:var(--ink-mu);background:transparent;}
.pill.active{background:rgba(255,255,255,.92);color:var(--accent-d);box-shadow:var(--sh-xs);}

/* FORMS */
.fg{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
.fgr{display:flex;flex-direction:column;gap:5px;}
.fgr.full{grid-column:1/-1;}
.fgr label{font-size:.64rem;font-weight:700;letter-spacing:.10em;text-transform:uppercase;color:var(--ink-m);}
input,select,textarea{
  padding:9px 12px;border:1.5px solid rgba(120,80,180,.18);border-radius:var(--r-sm);
  font-family:'Plus Jakarta Sans',sans-serif;font-size:.83rem;
  color:var(--ink);background:rgba(255,255,255,.80);
  outline:none;transition:all .2s;width:100%;
}
input:focus,select:focus,textarea:focus{border-color:var(--trust);background:white;box-shadow:0 0 0 3px rgba(156,39,176,.12);}
input::placeholder,textarea::placeholder{color:var(--ink-mu);}
textarea{resize:vertical;min-height:70px;}
.f-act{display:flex;gap:9px;justify-content:flex-end;margin-top:16px;}

/* GRIDS */
.g2{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;}
.g3{display:grid;grid-template-columns:2fr 1fr;gap:16px;margin-bottom:16px;}

/* TIMELINE */
.tl{display:flex;flex-direction:column;}
.tl-it{display:flex;gap:10px;padding:11px 0 11px 18px;border-left:2px solid rgba(120,80,180,.18);margin-left:8px;position:relative;}
.tl-it::before{content:'';position:absolute;left:-7px;top:16px;width:12px;height:12px;border-radius:50%;background:linear-gradient(135deg,#9C27B0,#E91E8C);border:2px solid white;box-shadow:0 2px 6px rgba(156,39,176,.30);}
.tl-d{font-size:.64rem;color:var(--ink-mu);min-width:56px;font-weight:700;padding-top:1px;}
.tl-t{font-weight:600;font-size:.82rem;color:var(--ink);margin-bottom:2px;}
.tl-n{font-size:.75rem;color:var(--ink-m);line-height:1.55;}

/* CALENDARIO */
.cal-wrap{display:grid;grid-template-columns:1fr 265px;gap:14px;}
.week-cal{background:rgba(255,255,255,.78);backdrop-filter:blur(16px);border-radius:var(--r-lg);border:1px solid rgba(255,255,255,.92);box-shadow:var(--sh-sm);overflow:hidden;}
.wk-head{display:grid;grid-template-columns:50px repeat(5,1fr);border-bottom:1px solid rgba(120,80,180,.12);background:rgba(237,232,248,.55);}
.wk-dl{padding:9px 4px;text-align:center;font-size:.61rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-m);border-right:1px solid rgba(120,80,180,.08);}
.wk-dl.hoy{color:#6A0080;background:rgba(156,39,176,.10);}
.wk-dl .dn{display:block;font-family:'Playfair Display',serif;font-size:1.05rem;font-weight:600;color:inherit;line-height:1.1;margin-top:2px;}
.wk-body{display:grid;grid-template-columns:50px repeat(5,1fr);max-height:380px;overflow-y:auto;}
.tc{border-right:1px solid rgba(120,80,180,.08);}
.tcc{height:52px;display:flex;align-items:flex-start;justify-content:center;padding-top:5px;font-size:.59rem;color:var(--ink-mu);border-bottom:1px solid rgba(120,80,180,.08);font-weight:700;}
.dc{border-right:1px solid rgba(120,80,180,.08);}
.sc{height:52px;border-bottom:1px solid rgba(120,80,180,.08);padding:3px;cursor:pointer;transition:background .14s;}
.sc:hover{background:rgba(156,39,176,.08);}
.ev{width:100%;height:100%;border-radius:6px;padding:2px 5px;font-size:.61rem;display:flex;flex-direction:column;justify-content:center;gap:1px;overflow:hidden;}
.ev-a{background:rgba(156,39,176,.14);border-left:3px solid #9C27B0;color:#4a148c;}
.ev-nm{font-weight:700;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
.hs-panel{background:rgba(255,255,255,.78);backdrop-filter:blur(16px);border-radius:var(--r-lg);border:1px solid rgba(255,255,255,.92);box-shadow:var(--sh-sm);overflow:hidden;}
.hs-slots{padding:9px;display:flex;flex-wrap:wrap;gap:5px;max-height:270px;overflow-y:auto;}
.hs{padding:6px 10px;border-radius:7px;font-size:.72rem;font-weight:600;cursor:pointer;border:1.5px solid rgba(120,80,180,.18);background:rgba(255,255,255,.65);color:var(--ink-m);transition:all .18s;}
.hs:hover,.hs.sel{background:linear-gradient(135deg,#9C27B0,#E91E8C);color:white;border-color:transparent;box-shadow:0 3px 12px rgba(156,39,176,.38);}
.hs.ocp{background:rgba(237,232,248,.5);color:var(--ink-mu);border-style:dashed;cursor:not-allowed;}
.hs.ocp:hover{background:rgba(237,232,248,.5);color:var(--ink-mu);border-color:rgba(120,80,180,.18);box-shadow:none;}

/* EXPEDIENTES */
.exp-layout{display:grid;grid-template-columns:265px 1fr;gap:14px;}
.exp-list{background:rgba(255,255,255,.78);backdrop-filter:blur(16px);border-radius:var(--r-lg);border:1px solid rgba(255,255,255,.92);box-shadow:var(--sh-sm);overflow:hidden;}
.exp-pi{display:flex;align-items:center;gap:9px;padding:10px 14px;cursor:pointer;border-bottom:1px solid rgba(120,80,180,.08);transition:all .18s;}
.exp-pi:last-child{border-bottom:none;}
.exp-pi:hover{background:rgba(156,39,176,.06);}
.exp-pi.sel{background:rgba(156,39,176,.10);border-right:3px solid #9C27B0;}
.exp-pi .n{font-weight:600;font-size:.82rem;color:var(--ink);}
.exp-pi .m{font-size:.66rem;color:var(--ink-mu);margin-top:1px;}
.exp-detail{background:rgba(255,255,255,.78);backdrop-filter:blur(16px);border-radius:var(--r-lg);border:1px solid rgba(255,255,255,.92);box-shadow:var(--sh-sm);overflow:hidden;}
.etabs{display:flex;border-bottom:1px solid rgba(120,80,180,.10);background:rgba(237,232,248,.45);padding:0 4px;}
.etab{padding:10px 15px;border:none;background:transparent;font-family:'Plus Jakarta Sans',sans-serif;font-size:.77rem;font-weight:600;color:var(--ink-mu);cursor:pointer;border-bottom:2px solid transparent;margin-bottom:-1px;transition:all .18s;}
.etab:hover{color:var(--accent-d);}
.etab.active{color:#9C27B0;border-bottom-color:#9C27B0;}
.etab-body{display:none;padding:18px 20px;}
.etab-body.active{display:block;animation:fadeUp .2s ease;}

/* CANALIZACIONES */
.canal-card{background:rgba(255,255,255,.78);backdrop-filter:blur(12px);border-radius:var(--r);border:1px solid rgba(255,255,255,.92);padding:13px 15px;margin-bottom:9px;transition:all .2s;position:relative;overflow:hidden;}
.canal-card::before{content:'';position:absolute;left:0;top:0;bottom:0;width:4px;background:linear-gradient(180deg,#E91E8C,#9C27B0);}
.canal-card:hover{box-shadow:var(--sh-sm);transform:translateX(2px);}
.canal-inst{font-weight:700;font-size:.83rem;color:var(--accent-d);margin-bottom:2px;}
.canal-meta{font-size:.70rem;color:var(--ink-mu);}
.canal-motivo{font-size:.77rem;color:var(--ink-m);margin-top:4px;line-height:1.55;}

/* REPORTES */
.bar-r{display:flex;align-items:center;gap:9px;margin-bottom:9px;}
.bar-l{font-size:.71rem;font-weight:700;color:var(--ink-m);min-width:76px;text-align:right;}
.bar-t{flex:1;height:26px;background:rgba(237,232,248,.6);border-radius:7px;overflow:hidden;}
.bar-f{height:100%;border-radius:7px;display:flex;align-items:center;justify-content:flex-end;padding-right:8px;font-size:.63rem;font-weight:700;color:white;min-width:22px;}
.bf-a{background:linear-gradient(90deg,#9C27B0,#E91E8C);}
.bf-b{background:linear-gradient(90deg,#F9A825,#FB8C00);}
.bf-c{background:linear-gradient(90deg,#E91E8C,#9C27B0);}
.donut-row{display:flex;align-items:center;justify-content:center;gap:24px;}
.leg-wrap{display:flex;flex-direction:column;gap:10px;}
.leg-r{display:flex;align-items:center;gap:8px;font-size:.80rem;}
.leg-dot{width:10px;height:10px;border-radius:50%;flex-shrink:0;}
.leg-v{font-weight:700;color:var(--ink);}
.leg-p{color:var(--ink-mu);font-size:.69rem;}

/* MODAL */
.overlay{display:none;position:fixed;inset:0;background:rgba(15,7,32,.75);backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px);z-index:9999;align-items:center;justify-content:center;padding:20px;}
.overlay.open{display:flex;animation:fdi .22s ease;will-change:transform;}
@keyframes fdi{from{opacity:0;}to{opacity:1;}}
.modal{background:rgba(255,255,255,.92);backdrop-filter:blur(24px);border-radius:24px;width:100%;max-width:540px;max-height:90vh;overflow-y:auto;box-shadow:var(--sh-lg);border:1px solid rgba(255,255,255,.95);animation:mdi .28s cubic-bezier(.34,1.36,.64,1);position:relative;}
.modal-lg{max-width:620px;}
@keyframes mdi{from{opacity:0;transform:scale(.92) translateY(12px);}to{opacity:1;transform:scale(1) translateY(0);}}
.mhd{padding:18px 22px 14px;border-bottom:1px solid rgba(120,80,180,.10);display:flex;align-items:center;justify-content:space-between;background:rgba(245,242,252,.75);position:relative;}
.mhd::before{content:'';position:absolute;top:0;left:0;right:0;height:4px;border-radius:24px 24px 0 0;background:linear-gradient(90deg,#F9A825,#E91E8C,#9C27B0,#1976D2,#00897B,#43A047,#F9A825);background-size:200% 100%;animation:specFlow 4s linear infinite;}
/* Modal title en Playfair */
.m-title{font-family:'Playfair Display',serif;font-size:1.12rem;color:var(--ink);font-weight:600;}
.m-close{width:28px;height:28px;border-radius:50%;border:none;background:rgba(237,232,248,.8);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:.84rem;color:var(--ink-mu);transition:all .18s;}
.m-close:hover{background:rgba(233,30,140,.14);color:#E91E8C;}
.mbody{padding:18px 22px 22px;}
.info-chip{background:rgba(156,39,176,.10);border:1px solid rgba(156,39,176,.22);border-radius:9px;padding:9px 13px;margin-bottom:13px;font-size:.79rem;color:#6A0080;font-weight:500;}

/* TOASTS */
.toast{position:fixed;bottom:22px;right:22px;padding:11px 18px;border-radius:12px;font-size:.83rem;font-weight:600;display:none;align-items:center;gap:9px;z-index:500;box-shadow:var(--sh-md);max-width:310px;}
#toast-ok   {background:linear-gradient(135deg,#00897B,#43A047);color:white;}
#toast-error{background:linear-gradient(135deg,#E91E8C,#9C27B0);color:white;}

/* LOADING */
.loading{text-align:center;padding:28px;color:var(--ink-mu);font-size:.81rem;}
.spinner{width:26px;height:26px;border:3px solid rgba(156,39,176,.20);border-top-color:#9C27B0;border-radius:50%;animation:spin .7s linear infinite;margin:0 auto 8px;}
@keyframes spin{to{transform:rotate(360deg);}}

@media(max-width:1100px){.stats-row{grid-template-columns:repeat(2,1fr);}.g2,.g3,.cal-wrap,.exp-layout{grid-template-columns:1fr;}.fg{grid-template-columns:1fr;}}
@media print{
  .sidebar,.topbar,.btn,.pills,.sh-r,#dots-bg,.nav-badge,.agenda-tabs,.etabs{display:none !important;}
  .main{margin-left:0 !important;padding:0 !important;}
  body{background:white !important;}
  .section{display:none !important;}
  #s-reportes{display:block !important;}
  .stats-row{display:flex !important;flex-wrap:wrap;gap:8px;}
  .stat-card{border:1px solid #ccc !important;box-shadow:none !important;break-inside:avoid;page-break-inside:avoid;}
  .card{box-shadow:none !important;border:1px solid #ddd !important;break-inside:avoid;page-break-inside:avoid;margin-bottom:12px;}
  .tw{overflow:visible !important;max-height:none !important;}
  table{width:100% !important;border-collapse:collapse;}
  th,td{border:1px solid #ccc !important;padding:4px 6px !important;font-size:10px !important;}
  .donut-row svg{width:80px !important;height:80px !important;}
  h2{font-size:14px !important;}
  .g2{display:block !important;}
  @page{margin:1.5cm;}
}
::-webkit-scrollbar{width:4px;height:4px;}
::-webkit-scrollbar-track{background:transparent;}
::-webkit-scrollbar-thumb{background:rgba(156,39,176,.30);border-radius:4px;}

/* ── Agenda tabs ── */
.agenda-tabs{display:flex;gap:4px;background:rgba(237,232,248,.6);padding:4px;border-radius:12px;margin-bottom:16px;width:fit-content;}
.atab{display:flex;align-items:center;gap:7px;padding:8px 18px;border:none;background:transparent;border-radius:9px;font-family:'Plus Jakarta Sans',sans-serif;font-size:.80rem;font-weight:600;color:var(--ink-mu);cursor:pointer;transition:all .2s;}
.atab:hover{color:var(--ink);}
.atab.active{background:white;color:var(--accent-d);box-shadow:0 2px 8px rgba(80,50,130,.10);}
.atab-body{animation:fadeUp .25s ease;}

/* ── Horarios toolbar ── */
.hor-toolbar{display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;gap:12px;flex-wrap:wrap;}
.hor-nav{display:flex;align-items:center;gap:8px;}
.hora-add-wrap{display:flex;align-items:center;gap:6px;}

/* ── Leyenda ── */
.hor-leyenda{display:flex;gap:10px;margin-bottom:12px;flex-wrap:wrap;}
.hor-ley-item{font-size:.70rem;font-weight:600;padding:3px 10px;border-radius:6px;border:1.5px solid;}
.hor-ley-item.libre  {background:rgba(25,118,210,.10);border-color:rgba(25,118,210,.30);color:#0D47A1;}
.hor-ley-item.ocupado{background:rgba(233,30,140,.08);border-color:rgba(233,30,140,.25);color:#880E4F;}
.hor-ley-item.sel    {background:rgba(67,160,71,.14);border-color:rgba(67,160,71,.35);color:#2E7D32;}
.hor-ley-item.vacio  {background:rgba(237,232,248,.5);border-color:rgba(120,80,180,.15);color:var(--ink-mu);}

/* ── Grilla semanal ── */
.hor-grid-card{overflow:visible;}
.hor-week-grid{overflow-x:auto;}
.hor-table{width:100%;border-collapse:collapse;min-width:620px;}

/* Cabecera días */
.hor-table thead th{
  padding:10px 8px;
  text-align:center;
  font-size:.65rem;font-weight:700;letter-spacing:.10em;text-transform:uppercase;
  color:var(--ink-m);
  background:rgba(237,232,248,.55);
  border-bottom:2px solid rgba(120,80,180,.14);
  border-right:1px solid rgba(120,80,180,.08);
  position:sticky;top:0;z-index:2;
}
.hor-table thead th:first-child{
  width:72px;text-align:center;background:rgba(237,232,248,.55);
  border-right:2px solid rgba(120,80,180,.14);
}
.hor-table thead th.hoy-col{
  background:rgba(156,39,176,.10);color:#6A0080;
}
/* Numero del día */
.hor-dn{display:block;font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:600;color:inherit;line-height:1.1;margin-top:2px;}
.hor-table thead th.hoy-col .hor-dn{
  background:#9C27B0;color:white;
  border-radius:50%;width:30px;height:30px;
  display:inline-flex;align-items:center;justify-content:center;
  margin:2px auto 0;font-size:.9rem;
}

/* Columna hora */
.hor-table td.hora-col{
  font-size:.70rem;font-weight:700;color:var(--ink-mu);
  text-align:center;padding:0 6px;
  border-right:2px solid rgba(120,80,180,.14);
  border-bottom:1px solid rgba(120,80,180,.06);
  background:rgba(237,232,248,.30);
  white-space:nowrap;
  position:relative;
}
/* Botón eliminar hora */
.hor-table td.hora-col .del-hora{
  display:none;position:absolute;right:2px;top:50%;transform:translateY(-50%);
  background:none;border:none;color:var(--energy);cursor:pointer;font-size:.75rem;padding:0 2px;
}
.hor-table tr:hover td.hora-col .del-hora{display:block;}

/* Celdas de slot */
.hor-table td.slot-cel{
  height:46px;padding:4px;
  border-bottom:1px solid rgba(120,80,180,.06);
  border-right:1px solid rgba(120,80,180,.06);
  cursor:pointer;
  transition:background .12s;
  position:relative;
}
.hor-table td.slot-cel:hover{background:rgba(156,39,176,.06);}

/* Chip dentro del slot */
.slot-chip{
  width:100%;height:100%;border-radius:7px;
  display:flex;align-items:center;justify-content:center;
  font-size:.68rem;font-weight:600;
  border:1.5px solid transparent;
  transition:all .15s;
  user-select:none;
}
.slot-chip.vacio{background:transparent;border-color:transparent;}
.slot-chip.sel{
  background:rgba(67,160,71,.16);border-color:rgba(67,160,71,.40);color:#2E7D32;
}
.slot-chip.libre{
  background:rgba(25,118,210,.12);border-color:rgba(25,118,210,.30);color:#0D47A1;
}
.slot-chip.ocupado{
  background:rgba(233,30,140,.10);border-color:rgba(233,30,140,.28);color:#880E4F;
  cursor:not-allowed;
}
.slot-chip.libre:hover{background:rgba(229,57,53,.12);border-color:rgba(229,57,53,.35);color:#B71C1C;}

/* Tooltip ocupado */
.slot-chip.ocupado::after{
  content:'Con cita';position:absolute;bottom:105%;left:50%;transform:translateX(-50%);
  background:#1c1c2e;color:white;font-size:.62rem;padding:3px 7px;border-radius:5px;
  white-space:nowrap;pointer-events:none;opacity:0;transition:opacity .15s;
}
.slot-chip.ocupado:hover::after{opacity:1;}

/* ── Modal confirmación ── */
#ov-confirm .modal{animation:mdi .22s cubic-bezier(.34,1.36,.64,1);}

</style>
</head>
<body>

<!-- ════ SIDEBAR ════ -->
<aside class="sidebar">
  <div class="sb-spectrum"></div>
  <div class="brand">
    <div class="brand-logo">
      <img src="data:image/png;base64,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" alt="CEPS" onerror="this.style.display='none'"/>
    </div>
    <div class="brand-txt">
      <div class="nm">CEPS</div>
      <div class="sb">Centro Psicología · UTN</div>
    </div>
  </div>

  <div class="nav-scroll">
    <div class="nav-label">Inicio</div>
    <button class="nav-btn active" data-sec="dashboard">
      <span class="ic"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg></span>
      Inicio
    </button>
    <div class="nav-label">Gestión</div>
    <button class="nav-btn" data-sec="usuarios">
      <span class="ic"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="9" cy="7" r="4"/><path d="M3 21v-2a4 4 0 014-4h4a4 4 0 014 4v2"/><path d="M16 3a4 4 0 010 8"/><path d="M21 21v-2a4 4 0 00-3-3.87"/></svg></span>
      Alumnos
    </button>
    <button class="nav-btn" data-sec="citas">
      <span class="ic"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg></span>
      Citas &amp; Agenda
      <span class="nav-badge" id="badge-citas">0</span>
    </button>
    <button class="nav-btn" data-sec="sesiones">
      <span class="ic"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14,2 14,8 20,8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg></span>
      Sesiones
    </button>
    <button class="nav-btn" data-sec="expedientes">
      <span class="ic"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg></span>
      Expedientes
    </button>
    <button class="nav-btn" data-sec="canalizaciones">
      <span class="ic"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></span>
      Canalizaciones
    </button>
    <div class="nav-label">Análisis</div>
    <button class="nav-btn" data-sec="reportes">
      <span class="ic"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></span>
      Reportes
    </button>
    <div class="sb-emotions">
      <span class="sb-emo-label">Emociones</span>
      <div class="sb-emo-dots">
        <div class="emod" style="width:9px;height:9px;background:#F9A825;animation-delay:0s;"    title="Alegría"></div>
        <div class="emod" style="width:9px;height:9px;background:#E91E8C;animation-delay:.22s;"  title="Amor"></div>
        <div class="emod" style="width:9px;height:9px;background:#9C27B0;animation-delay:.44s;"  title="Confianza"></div>
        <div class="emod" style="width:9px;height:9px;background:#1976D2;animation-delay:.66s;"  title="Calma"></div>
        <div class="emod" style="width:9px;height:9px;background:#00897B;animation-delay:.88s;"  title="Esperanza"></div>
        <div class="emod" style="width:9px;height:9px;background:#43A047;animation-delay:1.1s;"  title="Energía"></div>
      </div>
    </div>
  </div>

  <div class="sb-foot">
    <div class="user-row">
      <div class="user-av" id="sb-av"><?= strtoupper(mb_substr($usuarioNombre, 0, 1)) ?></div>
      <div>
        <div class="user-nm"><?= htmlspecialchars($usuarioNombre) ?></div>
        <div class="user-rl"><?= $usuarioRol === 'admin' ? 'Psicóloga / Admin' : 'Alumno' ?></div>
      </div>
      <button class="btn-out" onclick="cerrarSesion()" title="Cerrar sesión">Salir</button>
    </div>
  </div>
</aside>

<!-- ════ MAIN ════ -->
<main class="main">
  <div class="topbar">
    <div class="tb-wrap">
      <div class="tb-title" id="tb-title">Inicio</div>
      <div class="tb-crumb" id="tb-crumb">Centro de Psicología CEPS</div>
    </div>
    <div class="tb-spectrum"></div>
  </div>

  <div class="content">

    <!-- DASHBOARD -->
    <section class="section active" id="s-dashboard">
      <div class="sh">
        <div>
          <h2>Bienvenida, <?= htmlspecialchars(explode(' ',$usuarioNombre)[0]) ?></h2>
          <p id="dash-fecha">Cargando...</p>
        </div>
      </div>
      <div class="stats-row">
        <div class="stat-card s1"><div class="stat-ic"><svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="9" cy="7" r="4"/><path d="M3 21v-2a4 4 0 014-4h4a4 4 0 014 4v2"/></svg></div><div class="stat-lbl">Alumnos</div><div class="stat-val" id="stat-alumnos">—</div><div class="stat-sub">Registrados</div></div>
        <div class="stat-card s2"><div class="stat-ic"><svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg></div><div class="stat-lbl">Citas Hoy</div><div class="stat-val" id="stat-citas">—</div><div class="stat-sub">Programadas</div></div>
        <div class="stat-card s3"><div class="stat-ic"><svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></div><div class="stat-lbl">Sesiones Mes</div><div class="stat-val" id="stat-sesiones">—</div><div class="stat-sub">Este mes</div></div>
        <div class="stat-card s4"><div class="stat-ic"><svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div><div class="stat-lbl">Canalizaciones</div><div class="stat-val" id="stat-canal">—</div><div class="stat-sub">Total</div></div>
      </div>
      <div class="g3">
        <div class="card">
          <div class="card-hd"><div class="card-title">Citas de Hoy</div><button class="btn btn-ghost btn-sm" onclick="nav('citas')">Ver agenda →</button></div>
          <div class="tw"><table id="tabla-dashboard"><thead><tr><th>Alumno</th><th>Matrícula</th><th>Hora</th><th>Carrera</th><th>Estado</th><th></th></tr></thead><tbody><tr class="empty-row"><td colspan="6"><div class="spinner"></div>Cargando...</td></tr></tbody></table></div>
        </div>
        <div class="card">
          <div class="card-hd"><div class="card-title">Actividad Reciente</div></div>
          <div class="card-body" style="padding-top:10px"><div class="tl" id="dash-tl"><div class="tl-it"><div class="tl-d">—</div><div><div class="spinner" style="width:13px;height:13px;margin:0"></div></div></div></div></div>
        </div>
      </div>
    </section>

    <!-- ALUMNOS -->
    <section class="section" id="s-usuarios">
      <div class="sh">
        <div class="sh-r"><button class="btn btn-primary" onclick="openM('nuevo-alumno')">+ Nuevo Alumno</button></div>
      </div>
      <div class="card">
        <div class="card-hd">
          <div class="pills" id="pills-alumnos">
            <button class="pill active" onclick="filtrarAlumnos('',this)">Todos</button>
            <button class="pill" onclick="filtrarAlumnos('Matutino',this)">Matutino</button>
            <button class="pill" onclick="filtrarAlumnos('Vespertino',this)">Vespertino</button>
          </div>
          <div class="tb-search" style="min-width:0;width:180px">
            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            <input type="text" id="bus-alumnos" placeholder="Nombre, matrícula...">
          </div>
        </div>
        <div class="tw"><table id="tabla-alumnos"><thead><tr><th>Alumno</th><th>Matricula</th><th>Genero</th><th>Carrera</th><th>Cuatri</th><th>Grupo</th><th>Turno</th><th>No.Sesiones</th><th>Estado</th><th></th></tr></thead><tbody><tr class="empty-row"><td colspan="10"><div class="spinner"></div>Cargando...</td></tr></tbody></table></div>
      </div>
    </section>

    <!-- CITAS -->
    <section class="section" id="s-citas">
      <div class="sh">
        <div>
          <h2>Agenda &amp; Citas</h2>
          <p>Define tus horarios de atención y gestiona las citas</p>
        </div>
        <div class="sh-r">
          <button class="btn btn-primary" onclick="openM('nueva-cita')">
            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Nueva Cita
          </button>
        </div>
      </div>

      <!-- TABS -->
      <div class="agenda-tabs">
        <button class="atab active" onclick="switchAgendaTab('horarios',this)" id="atab-horarios">
          <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg>
          Horarios de Atención
        </button>
        <button class="atab" onclick="switchAgendaTab('citas',this)" id="atab-citas">
          <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
          Citas Agendadas
        </button>
      </div>

      <!-- ── TAB: HORARIOS DE ATENCIÓN ── -->
      <div id="tab-horarios" class="atab-body active">

        <!-- Toolbar superior -->
        <div class="hor-toolbar">
          <div class="hor-nav">
            <button class="btn btn-ghost btn-sm" onclick="semanaAnterior()">◂ Ant.</button>
            <span id="hor-semana-label" style="font-size:.84rem;font-weight:600;color:var(--ink);min-width:180px;text-align:center;"></span>
            <button class="btn btn-ghost btn-sm" onclick="semanaSiguiente()">Sig. ▸</button>
            <button class="btn btn-ghost btn-sm" onclick="irHoy()">Hoy</button>
          </div>
          <div style="display:flex;gap:8px;align-items:center;">
            <!-- Agregar hora personalizada -->
            <div class="hora-add-wrap">
              <input type="time" id="hora-nueva-input" step="900"
                style="padding:6px 10px;border:1.5px solid rgba(120,80,180,.20);border-radius:9px;font-family:'Plus Jakarta Sans',sans-serif;font-size:.80rem;color:var(--ink);background:rgba(255,255,255,.80);outline:none;width:110px;">
              <button class="btn btn-accent btn-sm" onclick="agregarHoraColumna()">+ Hora</button>
            </div>
            <button class="btn btn-primary btn-sm" onclick="guardarHorariosSemana()">
              <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
              Guardar selección
            </button>
          </div>
        </div>

        <!-- Leyenda -->
        <div class="hor-leyenda">
          <span class="hor-ley-item libre">Disponible</span>
          <span class="hor-ley-item ocupado">Con cita</span>
          <span class="hor-ley-item sel">Seleccionado para agregar</span>
          <span class="hor-ley-item vacio">Sin horario</span>
        </div>

        <!-- Grilla de semana interactiva -->
        <div class="card hor-grid-card">
          <div id="hor-week-grid" class="hor-week-grid">
            <div class="loading"><div class="spinner"></div>Cargando horarios...</div>
          </div>
        </div>

      </div>

      <!-- ── TAB: CITAS AGENDADAS ── -->
      <div id="tab-citas-lista" class="atab-body" style="display:none;">
        <div class="card">
          <div class="card-hd">
            <div class="card-title">Citas Agendadas</div>
            <div class="pills">
              <button class="pill active" onclick="filtrarCitas('',this)">Todas</button>
              <button class="pill" onclick="filtrarCitas('Programada',this)">Programadas</button>
              <button class="pill" onclick="filtrarCitas('Confirmada',this)">Confirmadas</button>
              <button class="pill" onclick="filtrarCitas('Cancelada',this)">Canceladas</button>
            </div>
          </div>
          <div class="tw">
            <table id="tabla-citas">
              <thead><tr><th>Folio</th><th>Alumno</th><th>Matrícula</th><th>Fecha</th><th>Hora</th><th>Estado</th><th>Acciones</th></tr></thead>
              <tbody><tr class="empty-row"><td colspan="7"><div class="spinner"></div>Cargando...</td></tr></tbody>
            </table>
          </div>
        </div>
      </div>

    </section>

    <!-- SESIONES -->
    <section class="section" id="s-sesiones">
      <div class="sh">
        <div><h2>Registro de Sesiones</h2><p>Historial clínico de atenciones</p></div>
        <div class="sh-r"><button class="btn btn-primary" onclick="openM('reg-sesion')">+ Registrar Sesión</button></div>
      </div>
      <div class="card">
        <div class="card-hd"><div class="pills"><button class="pill active" onclick="filtrarSesiones('',this)">Todas</button><button class="pill" onclick="filtrarSesiones('Asistió',this)">Asistió</button><button class="pill" onclick="filtrarSesiones('Faltó',this)">Faltó</button><button class="pill" onclick="filtrarSesiones('Reprogramada',this)">Reprogramada</button></div></div>
        <div class="tw"><table id="tabla-sesiones"><thead><tr><th>Folio</th><th>Alumno</th><th>Matrícula</th><th>Sesión #</th><th>Fecha</th><th>Estado</th><th>Diagnóstico</th><th></th></tr></thead><tbody><tr class="empty-row"><td colspan="8"><div class="spinner"></div>Cargando...</td></tr></tbody></table></div>
      </div>
    </section>

    <!-- EXPEDIENTES -->
    <section class="section" id="s-expedientes">
      <div class="sh">
        <div><h2>Expedientes Clínicos</h2><p>Un expediente por alumno</p></div>
        <div class="sh-r"><button class="btn btn-primary" onclick="openM('nuevo-alumno')">+ Nuevo Expediente</button></div>
      </div>
      <div class="exp-layout">
        <div class="exp-list">
          <div class="card-hd"><div class="card-title">Pacientes</div></div>
          <div style="padding:6px 9px;border-bottom:1px solid var(--border-s)">
            <input type="text" placeholder="🔍 Buscar..." style="font-size:.77rem;padding:5px 9px">
          </div>
          <div id="exp-list"><div class="loading"><div class="spinner"></div></div></div>
        </div>
        <div class="exp-detail">
          <div class="card-hd" style="background:linear-gradient(135deg,rgba(199,125,204,.08),rgba(112,144,216,.06))">
            <div style="display:flex;align-items:center;gap:10px">
              <div class="av av-a" style="width:40px;height:40px;font-size:.88rem" id="exp-av">?</div>
              <div>
                <div style="font-family:'Cormorant Garamond',serif;font-size:.98rem;color:var(--ink)" id="exp-name">Selecciona un alumno</div>
                <div style="font-size:.65rem;color:var(--ink-mu)" id="exp-meta">—</div>
              </div>
            </div>
            <div style="display:flex;gap:6px">
              <button class="btn btn-ghost btn-sm" onclick="abrirEditarExpediente()">Editar</button>
              <button class="btn btn-primary btn-sm" onclick="openM('reg-sesion')">+ Sesión</button>
              <button class="btn btn-gold btn-sm" id="btn-gen-exp" onclick="generarExpediente()">🖨 Expediente</button>
            </div>
          </div>
          <div class="etabs">
            <button class="etab active" onclick="showTab('gen',this)">General</button>
            <button class="etab" onclick="showTab('his',this)">Historial</button>
            <button class="etab" onclick="showTab('not',this)">Notas</button>
          </div>
          <div class="etab-body active" id="tab-gen">
            <div class="fg" style="margin-bottom:10px">
              <div class="fgr"><label>Matrícula</label><input id="exp-mat" readonly placeholder="—"></div>
              <div class="fgr"><label>Edad</label><input id="exp-edad" readonly placeholder="—"></div>
              <div class="fgr"><label>Sexo</label><input id="exp-sex" readonly placeholder="—"></div>
              <div class="fgr"><label>Carrera</label><input id="exp-car" readonly placeholder="—"></div>
              <div class="fgr"><label>Cuatrimestre</label><input id="exp-cuat" readonly placeholder="—"></div>
              <div class="fgr"><label>Turno</label><input id="exp-tur" readonly placeholder="—"></div>
              <div class="fgr"><label>Grupo</label><input id="exp-gru" readonly placeholder="—"></div>
              <div class="fgr"><label>Teléfono</label><input id="exp-tel" readonly placeholder="—"></div>
              <div class="fgr full"><label>Correo</label><input id="exp-cor" readonly placeholder="—"></div>
              <div class="fgr"><label>Estado Civil</label><input id="exp-ec" readonly placeholder="—"></div>
              <div class="fgr"><label>Ocupación</label><input id="exp-oc" readonly placeholder="—"></div>
              <div class="fgr"><label>Integrantes familia</label><input id="exp-nif" readonly placeholder="—"></div>
              <div class="fgr"><label>Fecha creación</label><input id="exp-fc" readonly placeholder="—"></div>
              <div class="fgr"><label>Total sesiones</label><input id="exp-ses" readonly placeholder="—"></div>
              <div class="fgr"><label>Sesiones asistidas</label><input id="exp-asist" readonly placeholder="—"></div>
              <div class="fgr"><label>Última sesión</label><input id="exp-ult" readonly placeholder="—"></div>
            </div>
          </div>
          <div class="etab-body" id="tab-his">
            <div class="tl" id="exp-his-list"><div class="loading"><div class="spinner"></div>Selecciona un alumno</div></div>
          </div>
          <div class="etab-body" id="tab-not">
            <div class="fgr" style="margin-bottom:9px"><label>Nueva nota clínica</label><textarea rows="3" placeholder="Observaciones de la sesión..."></textarea></div>
            <button class="btn btn-primary btn-sm">Guardar nota</button>
          </div>
        </div>
      </div>
    </section>

    <!-- CANALIZACIONES -->
    <section class="section" id="s-canalizaciones">
      <div class="sh">
        <div><h2>Canalizaciones</h2><p>Derivaciones a instituciones externas</p></div>
        <div class="sh-r"><button class="btn btn-primary" onclick="openM('canalizar')">+ Nueva</button></div>
      </div>
      <div class="g2">
        <div id="lista-canal"><div class="loading"><div class="spinner"></div></div></div>
        <div class="card">
          <div class="card-hd"><div class="card-title">Por Institución</div></div>
          <div class="card-body">
            <div class="bar-r"><div class="bar-l">CIJ</div><div class="bar-t"><div class="bar-f bf-a" id="b-cij" style="width:0%">0</div></div></div>
            <div class="bar-r"><div class="bar-l">Inst. Mujer</div><div class="bar-t"><div class="bar-f bf-b" id="b-mujer" style="width:0%">0</div></div></div>
            <div class="bar-r"><div class="bar-l">UNABIA</div><div class="bar-t"><div class="bar-f bf-c" id="b-unabia" style="width:0%">0</div></div></div>
            <div class="bar-r"><div class="bar-l">F.Daniela</div><div class="bar-t"><div class="bar-f bf-a" id="b-fdaniela" style="width:0%">0</div></div></div>
            <div class="bar-r"><div class="bar-l">Otra</div><div class="bar-t"><div class="bar-f bf-b" id="b-otra" style="width:0%">0</div></div></div>
          </div>
        </div>
      </div>
    </section>

    <!-- REPORTES -->
    <section class="section" id="s-reportes">
      <div class="sh">
        <div><h2>Reporte Mensual</h2><p>Sesiones · Nuevos alumnos · Distribución por sexo</p></div>
        <div class="sh-r">
          <input type="month" id="mes-rep" style="padding:5px 10px;border-radius:6px;border:1.5px solid var(--border);font-family:'DM Sans',sans-serif;font-size:.78rem" onchange="cargarReportes(this.value)">
          <button class="btn btn-gold btn-sm" onclick="imprimirReporte()">🖨 PDF</button>
          <button class="btn btn-accent btn-sm" onclick="descargarExcel()">📊 Excel F06</button>
        </div>
      </div>
      <div class="stats-row">
        <div class="stat-card s1"><div class="stat-ic"><svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></div><div class="stat-lbl">Total Sesiones</div><div class="stat-val" id="rep-tot">—</div></div>
        <div class="stat-card s2"><div class="stat-ic"><svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="9" cy="7" r="4"/><path d="M3 21v-2a4 4 0 014-4h4a4 4 0 014 4v2"/></svg></div><div class="stat-lbl">Nuevos Alumnos</div><div class="stat-val" id="rep-nue">—</div></div>
        <div class="stat-card s3"><div class="stat-ic"><svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="5"/><path d="M3 21a9 9 0 0118 0"/></svg></div><div class="stat-lbl">Femenino</div><div class="stat-val" id="rep-fem">—</div></div>
        <div class="stat-card s4"><div class="stat-ic"><svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="9" cy="7" r="4"/><path d="M3 21v-2a4 4 0 014-4h4a4 4 0 014 4v2"/></svg></div><div class="stat-lbl">Masculino</div><div class="stat-val" id="rep-mas">—</div></div>
      </div>
      <div class="g2">
        <div class="card">
          <div class="card-hd"><div class="card-title">Alumnos Nuevos del Mes</div></div>
          <div class="tw" style="max-height:280px;overflow-y:auto;"><table id="tabla-nuevos"><thead><tr><th>Alumno</th><th>Matrícula</th><th>Sexo</th><th>Carrera</th><th>Grupo</th><th>Primera Sesión</th></tr></thead><tbody><tr class="empty-row"><td colspan="6">Selecciona un mes</td></tr></tbody></table></div>
        </div>
        <div class="card">
          <div class="card-hd"><div class="card-title">Distribución por Sexo</div></div>
          <div class="card-body">
            <div class="donut-row">
              <svg id="donut-svg" width="118" height="118" viewBox="0 0 118 118">
                <circle cx="59" cy="59" r="42" fill="none" stroke="var(--bg-s)" stroke-width="18"/>
                <circle data-seg="fem" cx="59" cy="59" r="42" fill="none" stroke="var(--trust)" stroke-width="18" stroke-dasharray="0 263.9" stroke-dashoffset="0" transform="rotate(-90 59 59)"/>
                <circle data-seg="mas" cx="59" cy="59" r="42" fill="none" stroke="var(--joy)" stroke-width="18" stroke-dasharray="263.9 0" stroke-dashoffset="0" transform="rotate(-90 59 59)"/>
                <text x="59" y="54" text-anchor="middle" font-family="Cormorant Garamond,serif" font-size="17" font-weight="700" fill="var(--ink)" id="donut-pct">—</text>
                <text x="59" y="68" text-anchor="middle" font-family="DM Sans,sans-serif" font-size="7.5" fill="var(--ink-mu)">Femenino</text>
              </svg>
              <div class="leg-wrap">
                <div class="leg-r"><div class="leg-dot" style="background:var(--trust)"></div><div><div class="leg-v">Femenino</div><div class="leg-p" id="leg-fem">—</div></div></div>
                <div class="leg-r"><div class="leg-dot" style="background:var(--joy)"></div><div><div class="leg-v">Masculino</div><div class="leg-p" id="leg-mas">—</div></div></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-hd"><div class="card-title">Veces Asistidas por Alumno</div></div>
        <div class="tw"><table id="tabla-asist"><thead><tr><th>Alumno</th><th>Matrícula</th><th>Sexo</th><th>Carrera</th><th>Sesiones Mes</th><th>Total Histórico</th><th>Estado</th></tr></thead><tbody><tr class="empty-row"><td colspan="7">Cargando...</td></tr></tbody></table></div>
      </div>
    </section>

  </div>
</main>

<!-- ════ MODALES ════ -->
<div class="overlay" id="ov-nueva-cita">
  <div class="modal">
    <div class="mhd"><div class="m-title">Agendar Nueva Cita</div><button class="m-close" onclick="closeM('nueva-cita')">✕</button></div>
    <div class="mbody">
      <form id="form-nueva-cita">
        <div class="fg">
          <div class="fgr full"><label>Alumno *</label>
            <select name="idUsuario" class="sel-alumno" required><option value="">— Seleccionar alumno —</option></select>
          </div>
          <div class="fgr"><label>Fecha *</label><input type="date" name="Fecha" required></div>
          <div class="fgr"><label>Hora *</label>
            <select name="Hora" id="sel-hora-cita" required>
              <option value="">— Seleccionar hora —</option>
            </select>
          </div>
          <div class="fgr"><label>Estado</label>
            <select name="Estado">
              <option value="Programada">Programada</option>
              <option value="Confirmada">Confirmada</option>
            </select>
          </div>
        </div>
        <p id="horas-info" style="font-size:.72rem;color:var(--ink-mu);margin-top:8px;display:none;">
          Mostrando horarios disponibles del calendario para esa fecha.
        </p>
      </form>
      <div class="f-act">
        <button class="btn btn-ghost" onclick="closeM('nueva-cita')">Cancelar</button>
        <button class="btn btn-primary" onclick="guardarCita()">Guardar Cita</button>
      </div>
    </div>
  </div>
</div>

<div class="overlay" id="ov-reagendar">
  <div class="modal">
    <div class="mhd"><div class="m-title">Reagendar Cita</div><button class="m-close" onclick="closeM('reagendar')">✕</button></div>
    <div class="mbody">
      <input type="hidden" id="reagendar-folio">
      <div class="info-chip" id="reagendar-info">—</div>
      <form id="form-reagendar">
        <div class="fg">
          <div class="fgr"><label>Nueva fecha *</label><input type="date" name="Fecha" required></div>
          <div class="fgr"><label>Nueva hora *</label>
            <select name="Hora" id="sel-hora-reagendar" required>
              <option value="">— Seleccionar hora —</option>
            </select>
          </div>
        </div>
      </form>
      <div class="f-act">
        <button class="btn btn-ghost" onclick="closeM('reagendar')">Cancelar</button>
        <button class="btn btn-accent" onclick="guardarReagendar()">Confirmar</button>
      </div>
    </div>
  </div>
</div>

<div class="overlay" id="ov-reg-sesion">
  <div class="modal modal-lg">
    <div class="mhd"><div class="m-title">Registrar Sesión</div><button class="m-close" onclick="closeM('reg-sesion')">✕</button></div>
    <div class="mbody">
      <form id="form-reg-sesion">
        <div class="fg">
          <div class="fgr full"><label>Alumno *</label><select name="idUsuario" class="sel-alumno" required><option value="">— Seleccionar —</option></select></div>
          <div class="fgr"><label>Fecha *</label><input type="date" name="Fecha" required></div>
          <div class="fgr"><label>Estado asistencia</label><select name="Estado"><option value="Asistió">Asistió</option><option value="Faltó">Faltó</option><option value="Reprogramada">Reprogramada</option></select></div>
          <div class="fgr full"><label>Diagnóstico / Motivo</label><input type="text" name="Diagnostico" placeholder="Ej. F41.1 Ansiedad..."></div>
          <div class="fgr full"><label>Notas clínicas</label><textarea name="Notas" rows="3" placeholder="Observaciones, técnicas aplicadas, avances..."></textarea></div>
        </div>
      </form>
      <div class="f-act"><button class="btn btn-ghost" onclick="closeM('reg-sesion')">Cancelar</button><button class="btn btn-primary" onclick="guardarSesion()">Guardar Sesión</button></div>
    </div>
  </div>
</div>

<div class="overlay" id="ov-nuevo-alumno">
  <div class="modal modal-lg">
    <div class="mhd"><div class="m-title">Nuevo Alumno + Expediente</div><button class="m-close" onclick="closeM('nuevo-alumno')">✕</button></div>
    <div class="mbody">
      <div class="info-chip">Se registrará en <code>usuarios</code> y se creará su <code>expediente</code> automáticamente.</div>
      <form id="form-nuevo-alumno">
        <div class="fg">
          <div class="fgr full"><label>Nombre completo *</label><input type="text" name="Nombre" required placeholder="Nombre(s) Apellido Paterno Materno"></div>
          <div class="fgr"><label>Matrícula *</label><input type="text" name="Matricula" required placeholder="Ej. 2024001"></div>
          <div class="fgr"><label>Contraseña inicial</label><input type="password" name="Contrasena" placeholder="Se usará para ingresar al sistema"></div>
          <div class="fgr"><label>Sexo *</label><select name="Sexo" required><option value="">—</option><option>Femenino</option><option>Masculino</option><option>Otro</option></select></div>
          <div class="fgr"><label>Edad</label><input type="number" name="Edad" min="15" max="60"></div>
          <div class="fgr"><label>Carrera</label>
            <select name="Carrera">
              <option value="">— Seleccionar —</option>
              <option>ISC - Ing. en Sistemas Computacionales</option>
              <option>LAE - Lic. en Administración de Empresas</option>
              <option>ENF - Enfermería</option>
              <option>GAS - Gastronomía</option>
              <option>DES - Desarrollo Empresarial Sustentable</option>
              <option>IND - Ing. Industrial</option>
              <option>MEC - Mecatrónica</option>
              <option>ARQ - Arquitectura</option>
              <option>DER - Derecho</option>
              <option>PSI - Psicología</option>
              <option>Otra</option>
            </select>
          </div>
          <div class="fgr"><label>Cuatrimestre</label>
            <select name="Cuatrimestre">
              <option value="">—</option>
              <option value="1">1°</option><option value="2">2°</option>
              <option value="3">3°</option><option value="4">4°</option>
              <option value="5">5°</option><option value="6">6°</option>
              <option value="7">7°</option><option value="8">8°</option>
              <option value="9">9°</option>
            </select>
          </div>
          <div class="fgr"><label>Grupo</label><input type="text" name="Grupo" placeholder="3A"></div>
          <div class="fgr"><label>Turno</label><select name="Turno"><option value="">—</option><option>Matutino</option><option>Vespertino</option><option>Mixto</option></select></div>
          <div class="fgr"><label>Teléfono</label><input type="tel" name="Num_Tel" placeholder="477 100 0000"></div>
          <div class="fgr"><label>Correo</label><input type="email" name="Correo" placeholder="alumno@utn.edu.mx"></div>
          <div class="fgr"><label>Estado Civil</label><select name="Estado_Civil"><option value="">—</option><option>Soltero</option><option>Casado</option><option>Divorciado</option><option>Viudo</option><option>Unión Libre</option></select></div>
          <div class="fgr"><label>Integrantes familia</label><input type="number" name="Num_Integrantes" placeholder="4"></div>
        </div>
      </form>
      <div class="f-act"><button class="btn btn-ghost" onclick="closeM('nuevo-alumno')">Cancelar</button><button class="btn btn-primary" onclick="guardarAlumno()">Registrar y Crear Expediente</button></div>
    </div>
  </div>
</div>

<div class="overlay" id="ov-canalizar">
  <div class="modal">
    <div class="mhd"><div class="m-title">Nueva Canalización</div><button class="m-close" onclick="closeM('canalizar')">✕</button></div>
    <div class="mbody">
      <form id="form-canalizar">
        <div class="fg">
          <div class="fgr full"><label>Alumno *</label><select name="idUsuario" class="sel-alumno" required><option value="">— Seleccionar —</option></select></div>
          <div class="fgr"><label>Institución destino *</label><select name="Institucion_Destino" required><option value="">— Seleccionar —</option><option>Instituto de la Mujer</option><option>Centro de Integración Juvenil (CIJ)</option><option>Fundación Daniela Guzmán</option><option>UNABIA</option><option>Otra</option></select></div>
          <div class="fgr"><label>Fecha *</label><input type="date" name="Fecha" required></div>
          <div class="fgr full"><label>Motivo *</label><textarea name="Motivo" required placeholder="Motivo de la canalización..."></textarea></div>
        </div>
      </form>
      <div class="f-act"><button class="btn btn-ghost" onclick="closeM('canalizar')">Cancelar</button><button class="btn btn-primary" onclick="guardarCanalizar()">Registrar</button></div>
    </div>
  </div>
</div>


<!-- ════ MODAL EDITAR EXPEDIENTE ════ -->
<div class="overlay" id="ov-editar-exp">
  <div class="modal modal-lg">
    <div class="mhd"><div class="m-title">Editar Expediente</div><button class="m-close" onclick="closeM('editar-exp')">✕</button></div>
    <div class="mbody">
      <form id="form-editar-exp">
        <div class="fg">
          <div class="fgr"><label>Edad</label><input type="number" name="Edad" min="15" max="60"></div>
          <div class="fgr"><label>Carrera</label>
            <select name="Carrera">
              <option value="">— Seleccionar —</option>
              <option>ISC - Ing. en Sistemas Computacionales</option>
              <option>LAE - Lic. en Administración de Empresas</option>
              <option>ENF - Enfermería</option>
              <option>GAS - Gastronomía</option>
              <option>DES - Desarrollo Empresarial Sustentable</option>
              <option>IND - Ing. Industrial</option>
              <option>MEC - Mecatrónica</option>
              <option>ARQ - Arquitectura</option>
              <option>DER - Derecho</option>
              <option>PSI - Psicología</option>
              <option>Otra</option>
            </select>
          </div>
          <div class="fgr"><label>Cuatrimestre</label>
            <select name="Cuatrimestre">
              <option value="">—</option>
              <option value="1">1°</option><option value="2">2°</option>
              <option value="3">3°</option><option value="4">4°</option>
              <option value="5">5°</option><option value="6">6°</option>
              <option value="7">7°</option><option value="8">8°</option>
              <option value="9">9°</option>
            </select>
          </div>
          <div class="fgr"><label>Grupo</label><input type="text" name="Grupo" placeholder="3A"></div>
          <div class="fgr"><label>Turno</label>
            <select name="Turno">
              <option value="">—</option>
              <option>Matutino</option><option>Vespertino</option><option>Mixto</option>
            </select>
          </div>
          <div class="fgr"><label>Teléfono</label><input type="tel" name="Num_Tel" placeholder="477 100 0000"></div>
          <div class="fgr"><label>Correo</label><input type="email" name="Correo" placeholder="alumno@utn.edu.mx"></div>
          <div class="fgr"><label>Estado Civil</label>
            <select name="Estado_Civil">
              <option value="">— Seleccionar —</option>
              <option>Soltero</option><option>Casado</option>
              <option>Divorciado</option><option>Viudo</option><option>Unión Libre</option>
            </select>
          </div>
          <div class="fgr"><label>Ocupación</label><input type="text" name="Ocupacion" placeholder="Estudiante"></div>
          <div class="fgr"><label>Integrantes en familia</label><input type="number" name="Num_Integrantes_Familia" min="1" max="20"></div>
        </div>
      </form>
      <div class="f-act">
        <button class="btn btn-ghost" onclick="closeM('editar-exp')">Cancelar</button>
        <button class="btn btn-primary" onclick="guardarExpediente()">Guardar cambios</button>
      </div>
    </div>
  </div>
</div>

<!-- ════ MODAL CONFIRMACIÓN ════ -->
<div class="overlay" id="ov-confirm">
  <div class="modal" style="max-width:400px;">
    <div class="mhd">
      <div style="display:flex;align-items:center;gap:10px;">
        <div id="confirm-icon" style="width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:1rem;"></div>
        <div class="m-title" id="confirm-title">Confirmar</div>
      </div>
      <button class="m-close" onclick="closeConfirm()">✕</button>
    </div>
    <div class="mbody" style="padding:20px 22px 22px;">
      <p id="confirm-msg" style="font-size:.88rem;color:var(--ink-m);line-height:1.65;margin-bottom:20px;"></p>
      <div style="display:flex;gap:9px;justify-content:flex-end;">
        <button class="btn btn-ghost" onclick="closeConfirm()" id="confirm-cancel-btn">Cancelar</button>
        <button class="btn" id="confirm-ok-btn" onclick="resolveConfirm(true)">Confirmar</button>
      </div>
    </div>
  </div>
</div>

<div class="toast" id="toast-ok">✓ Operación exitosa</div>
<div class="toast" id="toast-error">⚠ Error</div>

<script src="assets/js/api.js"></script>
<script>
const SESSION={id:<?= json_encode($usuarioId) ?>,nombre:<?= json_encode($usuarioNombre) ?>,rol:<?= json_encode($usuarioRol) ?>,identificador:<?= json_encode($usuarioIdentificador) ?>};

async function cerrarSesion(){if(!confirm('¿Cerrar sesión?'))return;try{await fetch('api/auth.php',{method:'DELETE',headers:{'Content-Type':'application/json'}});}catch(e){}window.location.replace('login.php');}

const PAGES={dashboard:['Dashboard','Inicio del sistema'],usuarios:['Alumnos','Gestión de usuarios'],citas:['Agenda de Citas','Gestión de citas y horarios'],sesiones:['Registro de Sesiones','Historial clínico'],expedientes:['Expedientes Clínicos','Un expediente por alumno'],canalizaciones:['Canalizaciones','Derivaciones a instituciones'],reportes:['Reporte Mensual','Estadísticas del mes']};

function nav(sec){
  document.querySelectorAll('.section').forEach(s=>s.classList.remove('active'));
  document.querySelectorAll('.nav-btn').forEach(b=>b.classList.remove('active'));
  document.getElementById('s-'+sec)?.classList.add('active');
  document.querySelector(`.nav-btn[data-sec="${sec}"]`)?.classList.add('active');
  if(PAGES[sec]){document.getElementById('tb-title').textContent=PAGES[sec][0];document.getElementById('tb-crumb').textContent=PAGES[sec][1];}
  initSection(sec);
}
document.querySelectorAll('.nav-btn[data-sec]').forEach(b=>b.addEventListener('click',()=>nav(b.dataset.sec)));

function openM(id){document.getElementById('ov-'+id)?.classList.add('open');}
function closeM(id){document.getElementById('ov-'+id)?.classList.remove('open');}
document.querySelectorAll('.overlay').forEach(o=>o.addEventListener('click',e=>{if(e.target===o){if(o.id==='ov-confirm')resolveConfirm(false);else o.classList.remove('open');}}));
document.querySelectorAll('.pills').forEach(g=>g.querySelectorAll('.pill').forEach(p=>p.addEventListener('click',()=>{g.querySelectorAll('.pill').forEach(x=>x.classList.remove('active'));p.classList.add('active');})));
function showTab(id,el){document.querySelectorAll('.etab-body').forEach(b=>b.classList.remove('active'));document.querySelectorAll('.etab').forEach(t=>t.classList.remove('active'));document.getElementById('tab-'+id)?.classList.add('active');el.classList.add('active');}

const HORAS=['08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00'];
function buildWeek(){
  const body=document.getElementById('wk-body');if(!body)return;
  const hoy=new Date();
  // Set headers with real dates
  const lun=new Date(hoy);lun.setDate(hoy.getDate()-(hoy.getDay()||7)+1);
  ['wk-d0','wk-d1','wk-d2','wk-d3','wk-d4'].forEach((id,i)=>{
    const d=new Date(lun);d.setDate(lun.getDate()+i);
    const el=document.getElementById(id);if(!el)return;
    const names=['Lun','Mar','Mié','Jue','Vie'];
    const esHoy=d.toDateString()===hoy.toDateString();
    el.className='wk-dl'+(esHoy?' hoy':'');
    el.innerHTML=names[i]+'<span class="dn">'+d.getDate()+'</span>';
  });
  HORAS.forEach(h=>{
    const tc=document.createElement('div');tc.className='tc';
    const c=document.createElement('div');c.className='tcc';c.textContent=h;
    tc.appendChild(c);body.appendChild(tc);
    for(let d=0;d<5;d++){const dc=document.createElement('div');dc.className='dc';const sc=document.createElement('div');sc.className='sc';sc.addEventListener('click',()=>openM('nueva-cita'));dc.appendChild(sc);body.appendChild(dc);}
  });
}
function buildDateSelect(){
  const sel=document.getElementById('hs-date');if(!sel)return;
  const hoy=new Date();
  for(let i=0;i<7;i++){const d=new Date(hoy);d.setDate(hoy.getDate()+i);const v=d.toISOString().split('T')[0];const l=i===0?'Hoy, '+d.toLocaleDateString('es-MX',{day:'2-digit',month:'short'}):d.toLocaleDateString('es-MX',{weekday:'short',day:'2-digit',month:'short'});const o=document.createElement('option');o.value=v;o.textContent=l;sel.appendChild(o);}
}
function setFecha(){
  const ahora=new Date();const f=ahora.toLocaleDateString('es-MX',{weekday:'long',year:'numeric',month:'long',day:'numeric'});
  document.getElementById('dash-fecha').textContent=f[0].toUpperCase()+f.slice(1);
  const mr=document.getElementById('mes-rep');if(mr)mr.value=ahora.toISOString().substring(0,7);
}

let _expIdActual = null;
let _todosAlumnos = [];

// Buscador de alumnos en tiempo real
document.addEventListener('DOMContentLoaded', () => {
    const bus = document.getElementById('bus-alumnos');
    if (bus) {
        bus.addEventListener('input', () => {
            const turnoActivo = document.querySelector('#pills-alumnos .pill.active')?.textContent?.trim();
            const turno = (turnoActivo === 'Todos' || !turnoActivo) ? '' : turnoActivo;
            _renderAlumnos(turno, bus.value);
        });
    }
});
function generarExpediente(){if(!_expIdActual){mostrarError('Selecciona un alumno primero');return;}window.open(`api/expediente_view.php?idUsuario=${_expIdActual}`,'_blank');}
function descargarExcel(){const mes=document.getElementById('mes-rep')?.value||'';const a=document.createElement('a');a.href=mes?`api/control_excel.php?mes=${mes}`:'api/control_excel.php';a.download='';document.body.appendChild(a);a.click();document.body.removeChild(a);mostrarOK('Generando Excel...');}
function imprimirReporte() {
    const sec = document.getElementById('s-reportes');
    if (!sec) { mostrarError('Ve a la sección Reportes primero'); return; }

    // Construir HTML limpio solo con el contenido del reporte
    const titulo = document.querySelector('#s-reportes h2')?.textContent || 'Reporte Mensual';
    const mes    = document.getElementById('mes-rep')?.value || mesActualLocal();

    const w = window.open('', '_blank', 'width=900,height=700');
    w.document.write(`<!DOCTYPE html><html lang="es"><head>
    <meta charset="UTF-8">
    <title>Reporte Mensual — ${mes}</title>
    <style>
      *{margin:0;padding:0;box-sizing:border-box;}
      body{font-family:Arial,sans-serif;font-size:10pt;padding:15mm;background:white;color:#111;}
      h1{font-size:14pt;margin-bottom:4px;color:#5D336D;}
      .sub{font-size:9pt;color:#666;margin-bottom:16px;}
      .stats{display:flex;gap:12px;margin-bottom:16px;flex-wrap:wrap;}
      .stat{border:1px solid #ccc;border-radius:6px;padding:8px 14px;min-width:110px;}
      .stat-lbl{font-size:8pt;color:#666;text-transform:uppercase;letter-spacing:.5px;}
      .stat-val{font-size:18pt;font-weight:bold;color:#5D336D;line-height:1.2;}
      h2{font-size:11pt;margin:16px 0 6px;color:#333;border-bottom:1px solid #ddd;padding-bottom:4px;}
      table{width:100%;border-collapse:collapse;margin-bottom:14px;font-size:9pt;}
      th{background:#5D336D;color:white;padding:5px 8px;text-align:left;}
      td{border:1px solid #ddd;padding:4px 8px;}
      tr:nth-child(even) td{background:#f9f9f9;}
      .donut-wrap{display:flex;align-items:center;gap:20px;padding:8px;}
      .leg{font-size:9pt;}
      .leg div{margin:4px 0;}
      .dot{display:inline-block;width:10px;height:10px;border-radius:50%;margin-right:5px;}
      @page{margin:1.5cm;}
    </style></head><body>
    <h1>${titulo}</h1>
    <div class="sub">Período: ${mes}</div>`);

    // Stats
    const tot = document.getElementById('rep-tot')?.textContent || '0';
    const nue = document.getElementById('rep-nue')?.textContent || '0';
    const fem = document.getElementById('rep-fem')?.textContent || '0';
    const mas = document.getElementById('rep-mas')?.textContent || '0';
    w.document.write(`<div class="stats">
      <div class="stat"><div class="stat-lbl">Total Sesiones</div><div class="stat-val">${tot}</div></div>
      <div class="stat"><div class="stat-lbl">Nuevos Alumnos</div><div class="stat-val">${nue}</div></div>
      <div class="stat"><div class="stat-lbl">Femenino</div><div class="stat-val">${fem}</div></div>
      <div class="stat"><div class="stat-lbl">Masculino</div><div class="stat-val">${mas}</div></div>
    </div>`);

    // Tabla alumnos nuevos
    w.document.write('<h2>Alumnos Nuevos del Mes</h2>');
    const tNuevos = document.getElementById('tabla-nuevos');
    if (tNuevos) w.document.write(tNuevos.outerHTML);

    // Distribución por sexo
    const pctFem  = tot > 0 ? Math.round((parseInt(fem) / (parseInt(fem)+parseInt(mas))) * 100) : 0;
    const legFem  = document.getElementById('leg-fem')?.textContent || '';
    const legMas  = document.getElementById('leg-mas')?.textContent || '';
    w.document.write(`<h2>Distribución por Sexo</h2>
    <div class="donut-wrap">
      <div class="leg">
        <div><span class="dot" style="background:#9C27B0"></span>Femenino — ${legFem}</div>
        <div><span class="dot" style="background:#F9A825"></span>Masculino — ${legMas}</div>
      </div>
    </div>`);

    // Tabla asistencias
    w.document.write('<h2>Veces Asistidas por Alumno</h2>');
    const tAsist = document.getElementById('tabla-asist');
    if (tAsist) w.document.write(tAsist.outerHTML);

    w.document.write('</body></html>');
    w.document.close();
    setTimeout(() => w.print(), 600);
}

document.addEventListener('DOMContentLoaded',async()=>{
  setFecha();
  await Promise.allSettled([cargarDashboard(), cargarTimeline()]);
  try{
    const alumnos=await api('usuarios.php');
    window._todosAlumnos = alumnos;
    llenarSelectsAlumnos(alumnos);
    const el=document.getElementById('stat-alumnos');if(el)el.textContent=alumnos.length;
  }catch(e){console.warn('Error cargando alumnos:',e.message);}
});
</script>

<div class="dots-bg" id="dots-bg"></div>
<script>
(function(){
  const DC=['#F9A825','#E91E8C','#9C27B0','#1976D2','#00897B','#43A047','#E53935','#7B1FA2'];
  const DS=[4,6,8,9,5,7];
  const container=document.getElementById('dots-bg');
  function mkD(){
    const el=document.createElement('div');el.className='fd';
    const s=DS[Math.floor(Math.random()*DS.length)];
    const c=DC[Math.floor(Math.random()*DC.length)];
    const d=15+Math.random()*12;
    el.style.cssText=`width:${s}px;height:${s}px;background:${c};left:${Math.random()*100}vw;filter:blur(${Math.random()*.5}px);animation-duration:${d}s;animation-delay:${Math.random()*d}s;`;
    container.appendChild(el);
    setTimeout(()=>el.remove(),(d+5)*1000);
  }
  for(let i=0;i<16;i++)mkD();
  setInterval(mkD,1000);
})();


// ── CITAS: funciones corregidas para nueva BD (sin idHorario en citas) ──
async function guardarCita() {
    const form = document.getElementById('form-nueva-cita');
    if (!form) return;
    const datos = {
        idUsuario: parseInt(form.querySelector('[name=idUsuario]')?.value),
        Fecha:     form.querySelector('[name=Fecha]')?.value,
        Hora:      form.querySelector('[name=Hora]')?.value,
        Estado:    form.querySelector('[name=Estado]')?.value || 'Programada',
    };
    if (!datos.idUsuario) { mostrarError('Selecciona un alumno'); return; }
    if (!datos.Fecha)     { mostrarError('La fecha es obligatoria'); return; }
    if (!datos.Hora)      { mostrarError('La hora es obligatoria'); return; }
    await api('citas.php', 'POST', datos);
    mostrarOK('Cita agendada correctamente');
    closeM('nueva-cita'); form.reset();
    resetearSelectHoras('sel-hora-cita');
    cargarCitas(); cargarCalendario(new Date().toISOString().split('T')[0]); cargarDashboard();
}

async function guardarReagendar() {
    const folio = parseInt(document.getElementById('reagendar-folio')?.value);
    if (!folio) { mostrarError('No se encontró el folio'); return; }
    const form = document.getElementById('form-reagendar');
    const datos = {
        Fecha:  form.querySelector('[name=Fecha]')?.value,
        Hora:   form.querySelector('[name=Hora]')?.value,
        Estado: 'Programada',
    };
    if (!datos.Fecha) { mostrarError('Selecciona una nueva fecha'); return; }
    if (!datos.Hora)  { mostrarError('Selecciona una nueva hora'); return; }
    await api(`citas.php?id=${folio}`, 'PUT', datos);
    mostrarOK('Cita reagendada correctamente');
    closeM('reagendar'); form.reset();
    resetearSelectHoras('sel-hora-reagendar');
    cargarCitas(); cargarCalendario(new Date().toISOString().split('T')[0]);
}

// ── Cargar horas disponibles del calendario para una fecha ──
async function cargarHorasParaFecha(fecha, selectId) {
    const sel = document.getElementById(selectId);
    if (!sel) return;
    sel.innerHTML = '<option value="">Cargando...</option>';

    try {
        const slots = await api(`calendario.php?fecha=${fecha}&disponible=1`);
        sel.innerHTML = '';

        if (slots.length === 0) {
            // Si no hay horarios en calendario, mostrar horas estándar
            const horasEstandar = ['08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00'];
            sel.insertAdjacentHTML('beforeend', '<option value="">— Elige una hora —</option>');
            horasEstandar.forEach(h => {
                sel.insertAdjacentHTML('beforeend', `<option value="${h}:00">${h}</option>`);
            });
            const info = document.getElementById('horas-info');
            if (info) { info.textContent = 'No hay horarios definidos en el calendario para este día. Puedes elegir cualquier hora estándar.'; info.style.display='block'; }
        } else {
            sel.insertAdjacentHTML('beforeend', '<option value="">— Elige una hora disponible —</option>');
            slots.forEach(s => {
                const h = s.hora.substring(0,5);
                sel.insertAdjacentHTML('beforeend', `<option value="${s.hora}">${h}</option>`);
            });
            const info = document.getElementById('horas-info');
            if (info) { info.textContent = `${slots.length} horario(s) disponible(s) para este día.`; info.style.display='block'; }
        }
    } catch(e) {
        sel.innerHTML = '<option value="">Error al cargar horarios</option>';
    }
}

function resetearSelectHoras(selectId) {
    const sel = document.getElementById(selectId);
    if (sel) sel.innerHTML = '<option value="">— Seleccionar hora —</option>';
    const info = document.getElementById('horas-info');
    if (info) info.style.display = 'none';
}

// Escuchar cambio de fecha en modal nueva-cita
document.addEventListener('DOMContentLoaded', () => {
    const formCita = document.getElementById('form-nueva-cita');
    if (formCita) {
        const fechaInput = formCita.querySelector('[name=Fecha]');
        if (fechaInput) {
            fechaInput.addEventListener('change', function() {
                if (this.value) cargarHorasParaFecha(this.value, 'sel-hora-cita');
                else resetearSelectHoras('sel-hora-cita');
            });
        }
    }
    const formReag = document.getElementById('form-reagendar');
    if (formReag) {
        const fechaInput = formReag.querySelector('[name=Fecha]');
        if (fechaInput) {
            fechaInput.addEventListener('change', function() {
                if (this.value) cargarHorasParaFecha(this.value, 'sel-hora-reagendar');
                else resetearSelectHoras('sel-hora-reagendar');
            });
        }
    }
});


// Portal fix: move modals to direct body children so position:fixed works correctly
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.overlay').forEach(function(el) {
        if (el.parentElement !== document.body) {
            document.body.appendChild(el);
        }
    });
});


// ═══════════════════════════════════════════════
//  GESTIÓN DE HORARIOS — grilla semanal SIN recarga
// ═══════════════════════════════════════════════
let _horSemanaOffset    = 0;
let _horasColumnas      = ['08:00','09:00','10:00','11:00','12:00','14:00','15:00'];
let _slotsExistentes    = {};   // key "YYYY-MM-DD_HH:MM" → {idHorario, disponible}
let _slotsSeleccionados = new Set();
let _horGrillaCargada   = false;

function getLunesDeSemana(offset = 0) {
    const hoy = new Date();
    const dow = hoy.getDay() === 0 ? 7 : hoy.getDay();
    const lun = new Date(hoy);
    lun.setDate(hoy.getDate() - dow + 1 + offset * 7);
    lun.setHours(0,0,0,0);
    return lun;
}
function semanaAnterior()  { _horSemanaOffset--; renderHorariosSemana(); }
function semanaSiguiente() { _horSemanaOffset++; renderHorariosSemana(); }
function irHoy()           { _horSemanaOffset = 0; renderHorariosSemana(); }

function agregarHoraColumna() {
    const inp = document.getElementById('hora-nueva-input');
    if (!inp || !inp.value) { mostrarError('Escribe una hora válida'); return; }
    const h = inp.value.substring(0,5);
    if (!_horasColumnas.includes(h)) {
        _horasColumnas.push(h);
        _horasColumnas.sort();
    }
    inp.value = '';
    renderHorariosSemana();
}

// ── Render de la grilla completa ──────────────────────────────
async function renderHorariosSemana() {
    const grid = document.getElementById('hor-week-grid');
    if (!grid) return;

    // Solo mostrar spinner en primera carga
    if (!_horGrillaCargada) {
        grid.innerHTML = '<div class="loading"><div class="spinner"></div>Cargando...</div>';
    }

    const lun  = getLunesDeSemana(_horSemanaOffset);
    const vier = new Date(lun); vier.setDate(lun.getDate() + 4);
    const fmt  = d => d.toISOString().split('T')[0];
    const hoy  = new Date(); hoy.setHours(0,0,0,0);

    // Label semana
    const labelSem = document.getElementById('hor-semana-label');
    if (labelSem) {
        const o = {day:'2-digit',month:'short'};
        labelSem.textContent = `${lun.toLocaleDateString('es-MX',o)} — ${vier.toLocaleDateString('es-MX',o)}`;
    }

    // Cargar datos del servidor
    try {
        const data = await api(`calendario.php?desde=${fmt(lun)}&hasta=${fmt(vier)}`);
        _slotsExistentes = {};
        data.forEach(s => {
            const hora = s.hora.substring(0,5);
            _slotsExistentes[`${s.fecha}_${hora}`] = { idHorario: s.idHorario, disponible: parseInt(s.disponible) };
            if (!_horasColumnas.includes(hora)) {
                _horasColumnas.push(hora);
                _horasColumnas.sort();
            }
        });
    } catch(e) { _slotsExistentes = {}; }

    _buildTabla(lun, hoy);
    _horGrillaCargada = true;
}

function _buildTabla(lun, hoy) {
    const grid  = document.getElementById('hor-week-grid');
    const fmt   = d => d.toISOString().split('T')[0];
    const dias  = ['Lun','Mar','Mié','Jue','Vie'];
    const fechas = dias.map((_,i) => { const d = new Date(lun); d.setDate(lun.getDate()+i); return d; });

    let html = `<table class="hor-table"><thead><tr><th>Hora</th>`;
    fechas.forEach((d,i) => {
        const esHoy = d.getTime() === hoy.getTime();
        html += `<th class="${esHoy?'hoy-col':''}" data-fecha="${fmt(d)}">
            ${dias[i]}<span class="hor-dn">${d.getDate()}</span></th>`;
    });
    html += `</tr></thead><tbody>`;

    _horasColumnas.forEach(hora => {
        html += `<tr data-hora="${hora}">
          <td class="hora-col">${hora}
            <button class="del-hora" onclick="eliminarHoraColumna('${hora}')" title="Quitar fila">✕</button>
          </td>`;
        fechas.forEach(d => {
            const f   = fmt(d);
            const key = `${f}_${hora}`;
            const ex  = _slotsExistentes[key];
            const sel = _slotsSeleccionados.has(key);
            const pasado = d < hoy;

            let cls = 'vacio', label = '', onclick = '', title = 'Clic para agregar horario';

            if (ex) {
                cls   = ex.disponible === 1 ? 'libre' : 'ocupado';
                label = ex.disponible === 1 ? '✓' : '●';
                title = ex.disponible === 1 ? 'Clic para eliminar este horario' : 'Ocupado — tiene cita agendada';
                onclick = ex.disponible === 1 ? `toggleSlot('${key}','${f}','${hora}')` : '';
            } else if (sel) {
                cls = 'sel'; label = '+'; title = 'Clic para deseleccionar';
                onclick = `toggleSlot('${key}','${f}','${hora}')`;
            } else if (!pasado) {
                onclick = `toggleSlot('${key}','${f}','${hora}')`;
                title = 'Clic para agregar horario';
            } else {
                title = 'Fecha pasada';
            }

            html += `<td class="slot-cel" data-key="${key}">
                <div class="slot-chip ${cls}" ${onclick ? `onclick="${onclick}"` : ''} title="${title}">${label}</div>
              </td>`;
        });
        html += `</tr>`;
    });

    html += `</tbody></table>`;
    grid.innerHTML = html;
}

// ── Toggle slot — SIN re-render completo ──────────────────────
async function toggleSlot(key, fecha, hora) {
    const ex = _slotsExistentes[key];

    if (ex && ex.disponible === 1) {
        // Confirmar eliminación con modal elegante
        const ok = await showConfirm({
            title: 'Eliminar horario',
            msg:   `¿Eliminar el horario de atención ${hora} del ${_formatFechaCorta(fecha)}?`,
            tipo:  'danger',
            okLabel: 'Sí, eliminar'
        });
        if (!ok) return;

        try {
            await api(`calendario.php?id=${ex.idHorario}`, 'DELETE');
            delete _slotsExistentes[key];
            mostrarOK('Horario eliminado');
            // ✅ Solo actualizar la celda, sin re-render completo
            _actualizarCelda(key);
        } catch(e) { mostrarError('Error al eliminar'); }
        return;
    }

    // Celda vacía → toggle selección
    if (_slotsSeleccionados.has(key)) {
        _slotsSeleccionados.delete(key);
    } else {
        _slotsSeleccionados.add(key);
    }
    // ✅ Solo actualizar la celda
    _actualizarCelda(key);
}

// ── Actualizar UNA celda sin tocar el resto ──────────────────
function _actualizarCelda(key) {
    const cel  = document.querySelector(`.slot-cel[data-key="${key}"]`);
    if (!cel) return;

    const ex   = _slotsExistentes[key];
    const sel  = _slotsSeleccionados.has(key);
    const chip = cel.querySelector('.slot-chip');
    if (!chip) return;

    let cls = 'vacio', label = '', onclick = '', title = '';

    if (ex) {
        cls    = ex.disponible === 1 ? 'libre' : 'ocupado';
        label  = ex.disponible === 1 ? '✓' : '●';
        title  = ex.disponible === 1 ? 'Clic para eliminar este horario' : 'Ocupado — tiene cita';
        onclick = ex.disponible === 1 ? `toggleSlot('${key}','${key.split('_')[0]}','${key.split('_')[1]}')` : '';
    } else if (sel) {
        cls = 'sel'; label = '+'; title = 'Clic para deseleccionar';
        onclick = `toggleSlot('${key}','${key.split('_')[0]}','${key.split('_')[1]}')`;
    } else {
        title = 'Clic para agregar horario';
        onclick = `toggleSlot('${key}','${key.split('_')[0]}','${key.split('_')[1]}')`;
    }

    chip.className   = `slot-chip ${cls}`;
    chip.textContent = label;
    chip.title       = title;
    chip.onclick     = onclick ? new Function(onclick) : null;
}

function _formatFechaCorta(fecha) {
    const d = new Date(fecha + 'T00:00:00');
    return d.toLocaleDateString('es-MX', {weekday:'short', day:'2-digit', month:'short'});
}

function eliminarHoraColumna(hora) {
    _horasColumnas = _horasColumnas.filter(h => h !== hora);
    _slotsSeleccionados.forEach(k => { if (k.endsWith('_'+hora)) _slotsSeleccionados.delete(k); });
    renderHorariosSemana();
}

// ── Guardar seleccionados en lote ─────────────────────────────
async function guardarHorariosSemana() {
    if (_slotsSeleccionados.size === 0) {
        mostrarError('Selecciona al menos un horario (clic en celdas vacías)');
        return;
    }

    const byFechaHora = {};
    _slotsSeleccionados.forEach(key => {
        const [f, h] = key.split('_');
        if (!byFechaHora[f]) byFechaHora[f] = [];
        byFechaHora[f].push(h + ':00');
    });

    const fechas = Object.keys(byFechaHora);
    const horas  = [...new Set(Object.values(byFechaHora).flat())];

    try {
        const res = await api('calendario.php', 'POST', { fechas, horas });
        mostrarOK(`${res.insertados} horario(s) guardado(s)${res.omitidos > 0 ? `, ${res.omitidos} ya existían` : ''}`);
        _slotsSeleccionados.clear();
        // ✅ Re-render solo para obtener los nuevos idHorario del servidor
        await renderHorariosSemana();
    } catch(e) { mostrarError('Error al guardar horarios'); }
}

// ── Tabs ──────────────────────────────────────────────────────
function switchAgendaTab(tab, btn) {
    document.querySelectorAll('.atab').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('tab-horarios').style.display    = tab === 'horarios' ? 'block' : 'none';
    document.getElementById('tab-citas-lista').style.display = tab === 'citas'    ? 'block' : 'none';
    if (tab === 'citas')    cargarCitas();
    if (tab === 'horarios') renderHorariosSemana();
}

function filtrarCitas(estado, btn) {
    document.querySelectorAll('#tab-citas-lista .pill').forEach(b => b.classList.remove('active'));
    if (btn) btn.classList.add('active');
    cargarCitas(estado);
}

function filtrarSesiones(estado, btn) {
    document.querySelectorAll('#s-sesiones .pill').forEach(b => b.classList.remove('active'));
    if (btn) btn.classList.add('active');
    cargarSesiones(estado);
}

// ── Filtro + búsqueda de alumnos (cliente-side) ──────────────
function filtrarAlumnos(turno, btn) {
    document.querySelectorAll('#pills-alumnos .pill').forEach(b => b.classList.remove('active'));
    if (btn) btn.classList.add('active');
    _renderAlumnos(turno, document.getElementById('bus-alumnos')?.value || '');
}

function _renderAlumnos(turno, busqueda) {
    const tbody = document.querySelector('#tabla-alumnos tbody');
    if (!tbody) return;
    let lista = window._todosAlumnos || [];
    if (turno)    lista = lista.filter(a => a.Turno === turno);
    if (busqueda) {
        const q = busqueda.toLowerCase();
        lista = lista.filter(a =>
            (a.Nombre    || '').toLowerCase().includes(q) ||
            (a.Matricula || '').toLowerCase().includes(q)
        );
    }
    tbody.innerHTML = '';
    if (lista.length === 0) {
        tbody.innerHTML = '<tr class="empty-row"><td colspan="9">Sin resultados</td></tr>';
        return;
    }
    lista.forEach((alumno, indice) => {
        const ini     = iniciales(alumno.Nombre);
        const colorAv = colorAvatar(indice);
        const badge   = alumno.total_sesiones == 0
            ? '<span class="badge b-warn">Nuevo</span>'
            : '<span class="badge b-green">Activo</span>';
        tbody.insertAdjacentHTML('beforeend', `
            <tr data-id="${alumno.idUsuario_a}">
                <td>
                    <div class="pc">
                        <div class="av ${colorAv}">${ini}</div>
                        <div class="pi">
                            <div class="n">${alumno.Nombre}</div>
                            <div class="s">${alumno.Correo || ''}</div>
                        </div>
                    </div>
                </td>
                <td>${alumno.Matricula || '—'}</td>
                <td>${alumno.Sexo || '—'}</td>
                <td>${alumno.Carrera || '—'}</td>
                <td>${alumno.Cuatrimestre ? alumno.Cuatrimestre + '°' : '—'}</td>
                <td>${alumno.Grupo || '—'}</td>
                <td><span class="badge b-lila">${alumno.Turno || '—'}</span></td>
                <td><strong>${alumno.total_sesiones}</strong></td>
                <td>${badge}</td>
                <td>
                    <div style="display:flex;gap:5px">
                        <button class="btn btn-ghost btn-xs"
                            onclick="nav('expedientes');verExpediente(${alumno.idUsuario_a})">Exp.</button>
                        <button class="btn btn-ghost btn-xs"
                            onclick="abrirNuevaCita(${alumno.idUsuario_a})">+Cita</button>
                    </div>
                </td>
            </tr>
        `);
    });
}

// ── Editar expediente + datos del alumno ─────────────────────
function abrirEditarExpediente() {
    if (!_expIdActual) { mostrarError('Selecciona un alumno primero'); return; }
    const f = document.getElementById('form-editar-exp');
    if (!f) return;
    const get = id => document.getElementById(id)?.value || '';
    const set = (name, val) => { const el = f.querySelector(`[name="${name}"]`); if (el) el.value = val; };
    set('Edad',                    get('exp-edad'));
    set('Carrera',                 get('exp-car'));
    set('Cuatrimestre',            get('exp-cuat'));
    set('Grupo',                   get('exp-gru'));
    set('Turno',                   get('exp-tur'));
    set('Num_Tel',                 get('exp-tel'));
    set('Correo',                  get('exp-cor'));
    set('Estado_Civil',            get('exp-ec'));
    set('Ocupacion',               get('exp-oc'));
    set('Num_Integrantes_Familia', get('exp-nif'));
    openM('editar-exp');
}

async function guardarExpediente() {
    if (!_expIdActual) return;
    const f = document.getElementById('form-editar-exp');
    if (!f) return;
    const q = n => f.querySelector(`[name="${n}"]`)?.value || null;

    await Promise.all([
        // Actualizar tabla usuarios
        api(`usuarios.php?idUsuario=${_expIdActual}`, 'PUT', {
            Edad:         parseInt(q('Edad'))         || null,
            Carrera:      q('Carrera'),
            Cuatrimestre: parseInt(q('Cuatrimestre')) || null,
            Grupo:        q('Grupo'),
            Turno:        q('Turno'),
            Num_Tel:      q('Num_Tel'),
            Correo:       q('Correo'),
        }),
        // Actualizar tabla expedientes
        api(`expedientes.php?idUsuario=${_expIdActual}`, 'PUT', {
            Estado_Civil:            q('Estado_Civil'),
            Ocupacion:               q('Ocupacion'),
            Num_Integrantes_Familia: parseInt(q('Num_Integrantes_Familia')) || null,
        }),
    ]);

    mostrarOK('Expediente actualizado correctamente');
    closeM('editar-exp');
    cargarExpedientes();
}
function initHorFechas() {}



// ═══════════════════════════════════════════════
//  SISTEMA DE CONFIRMACIÓN ELEGANTE
//  Reemplaza confirm() del browser
// ═══════════════════════════════════════════════
let _confirmResolve = null;

function showConfirm({ title = 'Confirmar', msg, tipo = 'warn', okLabel = 'Confirmar', cancelLabel = 'Cancelar' }) {
    return new Promise(resolve => {
        _confirmResolve = resolve;

        const iconMap = {
            warn:    { bg: 'rgba(249,168,37,.15)',  color: '#E65100', emoji: '⚠️' },
            danger:  { bg: 'rgba(229,57,53,.12)',   color: '#C62828', emoji: '🗑' },
            info:    { bg: 'rgba(25,118,210,.12)',  color: '#0D47A1', emoji: 'ℹ️' },
            success: { bg: 'rgba(67,160,71,.12)',   color: '#2E7D32', emoji: '✓'  },
        };
        const ic = iconMap[tipo] || iconMap.warn;

        const iconEl   = document.getElementById('confirm-icon');
        const titleEl  = document.getElementById('confirm-title');
        const msgEl    = document.getElementById('confirm-msg');
        const okBtn    = document.getElementById('confirm-ok-btn');
        const cancelBtn= document.getElementById('confirm-cancel-btn');

        if (iconEl)   { iconEl.textContent = ic.emoji; iconEl.style.background = ic.bg; iconEl.style.color = ic.color; }
        if (titleEl)  titleEl.textContent  = title;
        if (msgEl)    msgEl.textContent    = msg;
        if (okBtn)    {
            okBtn.textContent = okLabel;
            // Color del botón ok según tipo
            okBtn.className = 'btn ' + (tipo === 'danger' ? 'btn-danger' : tipo === 'success' ? 'btn-accent' : 'btn-primary');
        }
        if (cancelBtn) cancelBtn.textContent = cancelLabel;

        document.getElementById('ov-confirm').classList.add('open');
    });
}

function resolveConfirm(val) {
    // Guardar referencia ANTES de limpiar, para resolver con el valor correcto
    const fn = _confirmResolve;
    _confirmResolve = null;
    document.getElementById('ov-confirm')?.classList.remove('open');
    if (fn) fn(val);
}

function closeConfirm() {
    const fn = _confirmResolve;
    _confirmResolve = null;
    document.getElementById('ov-confirm')?.classList.remove('open');
    if (fn) fn(false);
}

// Cerrar con ESC
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeConfirm();
});

</script>
</body>
</html>