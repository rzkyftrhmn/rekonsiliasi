<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>

/* ═══════════════════════════════
   FILTER BAR
═══════════════════════════════ */
.filter-bar {
    background: #fff;
    border-radius: 14px;
    padding: 13px 20px;
    box-shadow: 0 4px 18px rgba(41,82,227,.09);
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

.filter-icon-wrap {
    width: 34px; height: 34px;
    background: #EEF2FF;
    border-radius: 9px;
    display: grid; place-items: center;
    flex-shrink: 0;
}
.filter-icon-wrap svg {
    width: 16px; height: 16px;
    stroke: #2952E3; fill: none; stroke-width: 2;
}

.filter-title {
    font-size: 12px; font-weight: 700;
    letter-spacing: .09em; text-transform: uppercase;
    color: #6B7A99; white-space: nowrap;
}

.filter-select {
    height: 38px;
    border: 1.5px solid #E0E8FF;
    border-radius: 9px;
    padding: 0 14px;
    font-size: 13px; font-weight: 500;
    color: #1A2340;
    background: #F5F8FF;
    outline: none; cursor: pointer;
    transition: border-color .2s, box-shadow .2s;
    min-width: 155px;
}
.filter-select:focus {
    border-color: #2952E3;
    box-shadow: 0 0 0 3px rgba(41,82,227,.11);
    background: #fff;
}
.filter-select.active {
    border-color: #2952E3;
    background: #EEF2FF;
    color: #2952E3;
    font-weight: 600;
}

.filter-badge {
    display: inline-flex; align-items: center; gap: 6px;
    background: #EEF2FF;
    border: 1px solid #C7D4FF;
    border-radius: 20px;
    padding: 5px 12px;
    font-size: 12px; font-weight: 600;
    color: #2952E3;
}
.filter-badge svg { width: 12px; height: 12px; stroke: #2952E3; fill: none; stroke-width: 2.5; }

.filter-reset {
    height: 38px; padding: 0 15px;
    border-radius: 9px;
    border: 1.5px solid #E0E8FF;
    background: #fff;
    font-size: 12px; font-weight: 600;
    color: #6B7A99; cursor: pointer;
    display: inline-flex; align-items: center; gap: 6px;
    text-decoration: none;
    transition: all .2s;
}
.filter-reset:hover { border-color: #dc2626; color: #dc2626; background: #fff5f5; }
.filter-reset svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2.2; }

.filter-divider {
    width: 1px; height: 28px;
    background: #E0E8FF; flex-shrink: 0;
}

/* ═══════════════════════════════
   STAT CARDS
═══════════════════════════════ */
.stat-card {
    position: relative;
    border-radius: 16px;
    padding: 22px 20px 18px;
    overflow: hidden;
    transition: transform .28s cubic-bezier(.34,1.56,.64,1), box-shadow .25s ease;
    cursor: default; height: 100%;
}
.stat-card:hover { transform: translateY(-4px); }
.stat-card::after {
    content: '';
    position: absolute; right: -30px; top: -30px;
    width: 120px; height: 120px; border-radius: 50%;
    pointer-events: none; z-index: 0;
}
.stat-card > * { position: relative; z-index: 1; }

.card-blue   { background: linear-gradient(135deg,#1A3EC7,#0e2480); box-shadow: 0 10px 28px rgba(26,62,199,.28); }
.card-blue::after   { background: rgba(255,255,255,.1); }
.card-blue:hover    { box-shadow: 0 18px 40px rgba(26,62,199,.38); }

.card-teal   { background: linear-gradient(135deg,#0f766e,#065f55); box-shadow: 0 10px 28px rgba(15,118,110,.26); }
.card-teal::after   { background: rgba(255,255,255,.1); }
.card-teal:hover    { box-shadow: 0 18px 40px rgba(15,118,110,.36); }

.card-green  { background: linear-gradient(135deg,#16a34a,#15803d); box-shadow: 0 10px 28px rgba(22,163,74,.30); }
.card-green::after  { background: rgba(255,255,255,.1); }
.card-green:hover   { box-shadow: 0 18px 40px rgba(22,163,74,.40); }

.card-red    { background: linear-gradient(135deg,#dc2626,#b91c1c); box-shadow: 0 10px 28px rgba(220,38,38,.28); }
.card-red::after    { background: rgba(255,255,255,.1); }
.card-red:hover     { box-shadow: 0 18px 40px rgba(220,38,38,.38); }

.card-icon {
    width: 44px; height: 44px; border-radius: 12px;
    background: rgba(255,255,255,.18);
    display: grid; place-items: center; margin-bottom: 16px;
    transition: transform .2s;
}
.stat-card:hover .card-icon { transform: scale(1.08); }
.card-icon svg { width: 20px; height: 20px; fill: none; stroke: rgba(255,255,255,.9); stroke-width: 2.1; stroke-linecap: round; stroke-linejoin: round; }

.card-label {
    font-size: 10px; font-weight: 700;
    letter-spacing: .12em; text-transform: uppercase;
    color: rgba(255,255,255,.6); margin-bottom: 5px;
}

.card-value {
    font-family: 'DM Mono', monospace;
    font-size: 1.5rem; font-weight: 600;
    color: #fff; line-height: 1.1; margin-bottom: 12px;
    letter-spacing: -.01em; word-break: break-all;
}
.card-value .prefix { font-size: .75em; font-weight: 400; opacity: .7; margin-right: 2px; }

.card-divider { height: 1px; background: rgba(255,255,255,.15); margin-bottom: 12px; }

.card-sub {
    display: inline-flex; align-items: center; gap: 5px;
    background: rgba(255,255,255,.15);
    color: rgba(255,255,255,.8);
    font-size: 11px; font-weight: 600;
    padding: 3px 10px; border-radius: 20px;
}
.card-sub svg { width: 11px; height: 11px; stroke: currentColor; fill: none; stroke-width: 2.5; }

/* entry animation */
.stat-card { animation: cardIn .5s cubic-bezier(.34,1.56,.64,1) both; }
.a1{animation-delay:.04s} .a2{animation-delay:.10s} .a3{animation-delay:.16s} .a4{animation-delay:.22s}
@keyframes cardIn {
    from { opacity:0; transform:translateY(20px) scale(.97); }
    to   { opacity:1; transform:translateY(0) scale(1); }
}

/* ═══════════════════════════════
   TABLE CARDS
═══════════════════════════════ */
.section-card {
    border: none; border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,.07); overflow: hidden;
}
.section-card .card-header {
    background: #fff;
    border-bottom: 1.5px solid #EEF2FF;
    padding: 15px 20px;
    font-size: 14px; font-weight: 700; color: #1A2340;
    display: flex; align-items: center; gap: 8px;
}
.section-card .card-header .dot {
    width: 8px; height: 8px; border-radius: 50%; background: #2952E3;
}
.section-card .table thead th {
    background: #1A3EC7; color: #fff;
    font-size: 11px; font-weight: 700;
    letter-spacing: .07em; text-transform: uppercase;
    padding: 11px 15px; border: none;
}
.section-card .table tbody td {
    font-size: 13.5px; color: #374151;
    padding: 10px 15px; vertical-align: middle;
    border-color: #F3F6FF;
}
.section-card .table tbody tr:hover td { background: #F8FAFF; }

.bs { font-size: 10.5px; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; padding: 3px 10px; border-radius: 20px; display: inline-block; }
.bs-valid   { background:#d1fae5; color:#15803d; }
.bs-selisih { background:#fee2e2; color:#b91c1c; }
.bs-proses  { background:#fef3c7; color:#b45309; }

.page-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:22px; font-weight:800; color:#1A2340; }
</style>