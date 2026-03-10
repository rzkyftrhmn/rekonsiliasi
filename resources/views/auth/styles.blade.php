<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
*, *::before, *::after {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

:root {
    --navy: #0B1F3A;
    --navy-mid: #12284E;
    --navy-light: #1A3563;
    --gold: #C9A84C;
    --gold-light: #E2C47A;
    --gold-pale: #F5E8C7;
    --cream: #FAF6EF;
    --white: #FFFFFF;
    --text-muted: #8A9BB5;
    --error: #E05252;
}

html, body {
    height: 100%;
    font-family: 'DM Sans', sans-serif;
}

body {
    display: flex;
    min-height: 100vh;
    background-color: var(--navy);
    overflow: hidden;
}

/* ── LEFT PANEL ── */
.panel-image {
    position: relative;
    flex: 1.1;
    overflow: hidden;
}

.panel-image img.bg-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    filter: brightness(0.45) saturate(0.8);
    transform: scale(1.03);
    transition: transform 12s ease;
}

.panel-image:hover img.bg-img {
    transform: scale(1.07);
}

.panel-image::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(
        135deg,
        rgba(11, 31, 58, 0.55) 0%,
        rgba(201, 168, 76, 0.18) 60%,
        rgba(11, 31, 58, 0.75) 100%
    );
}

.panel-image-content {
    position: absolute;
    inset: 0;
    z-index: 2;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 52px 48px;
}

.badge-app {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(201, 168, 76, 0.18);
    border: 1px solid rgba(201, 168, 76, 0.45);
    border-radius: 40px;
    padding: 7px 18px;
    margin-bottom: 28px;
    width: fit-content;
    backdrop-filter: blur(8px);
}

.badge-app span {
    font-size: 11px;
    font-weight: 500;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--gold-light);
}

.badge-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: var(--gold);
    animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50%       { opacity: 0.5; transform: scale(0.75); }
}

.panel-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(30px, 3.2vw, 44px);
    font-weight: 700;
    color: var(--white);
    line-height: 1.25;
    margin-bottom: 16px;
}

.panel-title em {
    font-style: normal;
    color: var(--gold-light);
}

.panel-desc {
    font-size: 14.5px;
    color: rgba(255,255,255,0.6);
    line-height: 1.75;
    max-width: 360px;
}

.panel-divider {
    width: 48px;
    height: 2px;
    background: linear-gradient(90deg, var(--gold), transparent);
    margin: 22px 0;
}

/* ── RIGHT PANEL ── */
.panel-form {
    flex: 0 0 480px;
    background: var(--white);
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 60px 56px;
    position: relative;
    overflow: hidden;
}

.panel-form::before {
    content: '';
    position: absolute;
    top: -100px; right: -100px;
    width: 300px; height: 300px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(201,168,76,0.12) 0%, transparent 70%);
    pointer-events: none;
}

.panel-form::after {
    content: '';
    position: absolute;
    bottom: -80px; left: -80px;
    width: 240px; height: 240px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(11,31,58,0.07) 0%, transparent 70%);
    pointer-events: none;
}

/* ── LOGO ── */
.logo-wrap {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 14px;
    margin-bottom: 36px;
}

.logo-icon {
    width: 110px;
    height: 110px;
    background: var(--navy);
    border-radius: 24px;
    display: grid;
    place-items: center;
    flex-shrink: 0;
    overflow: hidden;
    box-shadow: 0 10px 32px rgba(11,31,58,0.25);
}

/* Logo gambar — ganti src dengan path logo Anda */
.logo-icon .logo-img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 12px;
}

.logo-text {
    font-family: 'Playfair Display', serif;
    font-size: 20px;
    font-weight: 700;
    color: var(--navy);
    line-height: 1.2;
    text-align: center;
}

.logo-sub {
    font-size: 11px;
    font-weight: 400;
    color: var(--text-muted);
    letter-spacing: 0.1em;
    text-transform: uppercase;
    text-align: center;
    margin-top: 2px;
}

/* heading */
.form-heading { margin-bottom: 8px; }

.form-heading h1 {
    font-family: 'Playfair Display', serif;
    font-size: 30px;
    font-weight: 700;
    color: var(--navy);
    line-height: 1.2;
}

.form-heading p {
    font-size: 14px;
    color: var(--text-muted);
    margin-top: 8px;
    font-weight: 300;
}

.gold-rule {
    display: block;
    width: 36px;
    height: 3px;
    border-radius: 2px;
    background: var(--gold);
    margin: 18px 0 32px;
}

/* error */
.alert-error {
    background: rgba(224,82,82,0.08);
    border-left: 3px solid var(--error);
    border-radius: 8px;
    padding: 12px 16px;
    margin-bottom: 24px;
    font-size: 13.5px;
    color: var(--error);
    display: flex;
    align-items: center;
    gap: 9px;
}

.alert-error svg {
    flex-shrink: 0;
    width: 16px; height: 16px;
    stroke: var(--error);
}

/* fields */
.field { margin-bottom: 20px; }

.field label {
    display: block;
    font-size: 12px;
    font-weight: 500;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--navy-light);
    margin-bottom: 8px;
}

.input-wrap { position: relative; }

.input-wrap .icon-field {
    position: absolute;
    left: 16px; top: 50%;
    transform: translateY(-50%);
    width: 16px; height: 16px;
    stroke: var(--text-muted);
    fill: none; stroke-width: 1.8;
    pointer-events: none;
    transition: stroke 0.2s;
}

.input-wrap input {
    width: 100%;
    height: 50px;
    background: var(--white);
    border: 1.5px solid #DDE3EC;
    border-radius: 10px;
    padding: 0 16px 0 46px;
    font-size: 14.5px;
    font-family: 'DM Sans', sans-serif;
    color: var(--navy);
    outline: none;
    transition: border-color 0.25s, box-shadow 0.25s;
}

.input-wrap input.has-eye {
    padding-right: 46px;
}

.input-wrap input::placeholder { color: #B4BFCE; }

.input-wrap input:focus {
    border-color: var(--gold);
    box-shadow: 0 0 0 4px rgba(201, 168, 76, 0.14);
}

.input-wrap:focus-within .icon-field { stroke: var(--gold); }

.btn-eye {
    position: absolute;
    right: 14px; top: 50%;
    transform: translateY(-50%);
    background: none; border: none;
    cursor: pointer; padding: 4px;
    display: grid; place-items: center;
    color: var(--text-muted);
    transition: color 0.2s;
}

.btn-eye:hover { color: var(--navy); }
.btn-eye svg { width: 17px; height: 17px; stroke: currentColor; fill: none; stroke-width: 1.8; }

.form-footer-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 28px;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    font-size: 13.5px;
    color: var(--navy-light);
    user-select: none;
}

.checkbox-label input[type="checkbox"] {
    appearance: none;
    width: 17px; height: 17px;
    border: 1.5px solid #C4CEDD;
    border-radius: 4px;
    cursor: pointer;
    transition: background 0.2s, border-color 0.2s;
    position: relative;
}

.checkbox-label input[type="checkbox"]:checked {
    background: var(--navy);
    border-color: var(--navy);
}

.checkbox-label input[type="checkbox"]:checked::after {
    content: '';
    position: absolute;
    top: 2px; left: 5px;
    width: 5px; height: 9px;
    border: 2px solid var(--gold-light);
    border-top: none; border-left: none;
    transform: rotate(45deg);
}

.link-forgot {
    font-size: 13px;
    color: var(--gold);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s;
}

.link-forgot:hover { color: var(--navy); }

.btn-login {
    width: 100%; height: 52px;
    background: var(--navy);
    color: var(--white);
    border: none;
    border-radius: 10px;
    font-family: 'DM Sans', sans-serif;
    font-size: 15px; font-weight: 500;
    cursor: pointer;
    position: relative; overflow: hidden;
    transition: transform 0.18s, box-shadow 0.18s;
    display: flex; align-items: center; justify-content: center;
    gap: 10px;
}

.btn-login::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, var(--navy-light), var(--navy));
    opacity: 0;
    transition: opacity 0.25s;
}

.btn-login:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(11,31,58,0.28); }
.btn-login:hover::before { opacity: 1; }
.btn-login:active { transform: translateY(0); }
.btn-login span, .btn-login svg { position: relative; z-index: 1; }
.btn-login svg { width: 18px; height: 18px; stroke: var(--gold-light); fill: none; stroke-width: 2; }

.form-note {
    margin-top: 28px;
    text-align: center;
    font-size: 12.5px;
    color: var(--text-muted);
}

.form-note strong { color: var(--navy); font-weight: 500; }

@media (max-width: 860px) {
    .panel-image { display: none; }
    .panel-form { flex: 1; padding: 48px 36px; }
}

@media (max-width: 480px) {
    .panel-form { padding: 40px 24px; }
}

.panel-form > * { animation: fadeUp 0.5s ease both; }
.panel-form > *:nth-child(1) { animation-delay: 0.05s; }
.panel-form > *:nth-child(2) { animation-delay: 0.12s; }
.panel-form > *:nth-child(3) { animation-delay: 0.16s; }
.panel-form > *:nth-child(4) { animation-delay: 0.20s; }
.panel-form > *:nth-child(5) { animation-delay: 0.24s; }

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}
</style>