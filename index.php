<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DILG Project Monitoring &amp; Public View System — Sapian, Capiz</title>
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  :root {
    --bg: #f4f6f9; --blue: #1861bf; --white: #ffffff;
    --red: #dd584c; --green: #0baa41; --gray: #545d68;
    --orange: #e67e22; --sidebar-w: 270px;
  }
  body { font-family: Arial, Helvetica, sans-serif; background: var(--bg); min-height: 100vh; color: #1a2530; font-size: 15px; line-height: 1.6; }

  /* GATEWAY */
  #gatewayPage { display: flex; min-height: 100vh; overflow: hidden; position: relative; }
  #gatewayPage.hidden { display: none; }
  .bg-pattern { position: fixed; inset: 0; background: radial-gradient(ellipse at 20% 50%, rgba(24,97,191,0.08) 0%, transparent 60%), var(--bg); z-index: 0; }
  .bg-grid { position: fixed; inset: 0; background-image: linear-gradient(rgba(24,97,191,0.04) 1px, transparent 1px), linear-gradient(90deg, rgba(24,97,191,0.04) 1px, transparent 1px); background-size: 50px 50px; z-index: 0; animation: gridShift 20s linear infinite; }
  @keyframes gridShift { 0% { transform: translateY(0); } 100% { transform: translateY(50px); } }

  .left-panel { position: relative; z-index: 1; width: 50%; display: flex; flex-direction: column; justify-content: center; align-items: flex-start; padding: 60px 80px; border-right: 1px solid rgba(84,93,104,0.2); }
  .seal-wrap { display: flex; align-items: center; gap: 20px; margin-bottom: 40px; animation: fadeUp 0.8s ease both; }
  .seal { width: 90px; height: 90px; background: var(--blue); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 42px; box-shadow: 0 4px 15px rgba(24,97,191,0.2); flex-shrink: 0; position: relative; }
  .seal::after { content: ''; position: absolute; inset: 4px; border-radius: 50%; border: 2px dashed rgba(255,255,255,0.4); }
  .seal-text h2 { font-size: 16px; color: var(--blue); letter-spacing: 1px; text-transform: uppercase; font-weight: bold; }
  .seal-text p { font-size: 14px; color: var(--gray); }
  .main-title { animation: fadeUp 0.8s 0.2s ease both; }
  .main-title h1 { font-size: clamp(30px,3.5vw,44px); color: #111822; line-height: 1.2; margin-bottom: 20px; font-weight: bold; }
  .main-title h1 span { color: var(--blue); }
  .main-title p { font-size: 15px; color: var(--gray); line-height: 1.7; max-width: 480px; }
  .gateway-options { margin-top: 35px; display: flex; flex-direction: column; gap: 15px; width: 100%; max-width: 440px; animation: fadeUp 0.8s 0.4s ease both; }
  .gate-btn { width: 100%; padding: 18px 24px; border-radius: 12px; font-family: Arial, sans-serif; font-size: 16px; font-weight: bold; cursor: pointer; display: flex; align-items: center; justify-content: space-between; transition: all 0.25s ease; }
  .gate-btn.primary { background: var(--blue); color: var(--white); border: none; box-shadow: 0 4px 15px rgba(24,97,191,0.3); }
  .gate-btn.primary:hover { transform: translateX(5px); background: #134ea0; }
  .gate-btn.secondary { background: var(--white); color: #111822; border: 2px solid var(--blue); }
  .gate-btn.secondary:hover { background: #f0f5fa; transform: translateX(5px); }
  .version-badge { margin-top: 40px; display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; border: 1px solid rgba(84,93,104,0.3); border-radius: 20px; font-size: 13px; color: var(--gray); letter-spacing: 1px; font-weight: bold; animation: fadeUp 0.8s 0.6s ease both; }
  .version-dot { width: 8px; height: 8px; background: var(--blue); border-radius: 50%; animation: pulse 2s infinite; }

  .right-panel { position: relative; z-index: 1; width: 50%; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 60px 70px; background: rgba(255,255,255,0.6); backdrop-filter: blur(10px); }
  .auth-card { width: 100%; max-width: 440px; display: none; background: var(--white); padding: 30px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid rgba(84,93,104,0.1); }
  .auth-card.active { display: block; animation: fadeUp 0.5s ease both; }
  .auth-header { margin-bottom: 30px; text-align: center; }
  .auth-header h2 { font-size: 26px; color: #111822; margin-bottom: 8px; font-weight: bold; }
  .auth-header p { font-size: 14px; color: var(--gray); }
  .divider { display: flex; align-items: center; gap: 12px; margin-bottom: 24px; }
  .divider-line { flex: 1; height: 1px; background: rgba(84,93,104,0.2); }
  .divider-icon { font-size: 20px; color: var(--blue); }
  .form-group { margin-bottom: 20px; position: relative; }
  .form-label { display: block; font-size: 13px; font-weight: bold; color: var(--gray); letter-spacing: 0.5px; text-transform: uppercase; margin-bottom: 8px; }
  .form-input { width: 100%; padding: 14px 16px 14px 45px; background: var(--bg); border: 2px solid rgba(84,93,104,0.2); border-radius: 10px; color: #111822; font-size: 15px; font-family: Arial, sans-serif; outline: none; transition: all 0.25s ease; }
  .form-input:focus { border-color: var(--blue); background: var(--white); box-shadow: 0 0 0 3px rgba(24,97,191,0.1); }
  .input-icon { position: absolute; left: 16px; top: 38px; font-size: 18px; color: var(--blue); pointer-events: none; }
  .toggle-pass { position: absolute; right: 14px; top: 38px; cursor: pointer; background: none; border: none; color: var(--gray); font-size: 18px; }
  .login-btn { width: 100%; padding: 16px; background: var(--blue); border: none; border-radius: 10px; color: var(--white); font-size: 16px; font-weight: bold; letter-spacing: 0.5px; text-transform: uppercase; cursor: pointer; transition: all 0.25s ease; }
  .login-btn:hover { background: #134ea0; transform: translateY(-2px); box-shadow: 0 4px 15px rgba(24,97,191,0.2); }
  .btn-cancel { background: #e1e5eb; color: var(--gray); padding: 14px; border-radius: 10px; cursor: pointer; transition: all 0.2s; font-family: inherit; font-size: 14px; font-weight: bold; border: none; }
  .btn-cancel:hover { background: rgba(221,88,76,0.15); color: var(--red); }
  .btn-submit { background: var(--blue); color: var(--white); padding: 12px 24px; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; transition: all 0.2s; font-family: inherit; font-size: 14px; }
  .btn-submit:hover { background: #134ea0; transform: translateY(-1px); }
  .error-msg { display: none; background: rgba(221,88,76,0.1); border: 2px solid var(--red); border-radius: 8px; padding: 12px; font-size: 14px; color: var(--red); margin-bottom: 18px; text-align: center; font-weight: bold; }
  .error-msg.show { display: block; animation: shake 0.3s ease; }
  .loader { display: none; width: 22px; height: 22px; border: 3px solid rgba(255,255,255,0.3); border-top-color: var(--white); border-radius: 50%; animation: spin 0.6s linear infinite; margin: 0 auto; }

  @keyframes shake { 0%,100%{transform:translateX(0)} 25%{transform:translateX(-4px)} 75%{transform:translateX(4px)} }
  @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.3} }
  @keyframes fadeUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
  @keyframes spin { to{transform:rotate(360deg)} }

  /* DASHBOARD */
  #dashboardPage { display: none; min-height: 100vh; }
  #dashboardPage.active { display: flex; }
  .sidebar { width: var(--sidebar-w); min-height: 100vh; background: var(--white); border-right: 2px solid rgba(84,93,104,0.15); display: flex; flex-direction: column; position: fixed; left: 0; top: 0; bottom: 0; z-index: 100; }
  .sidebar-logo { padding: 24px 20px; border-bottom: 2px solid rgba(84,93,104,0.1); display: flex; align-items: center; gap: 12px; }
  .logo-icon { width: 46px; height: 46px; background: var(--blue); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 24px; flex-shrink: 0; color: var(--white); }
  .logo-text h3 { font-size: 14px; color: #111822; line-height: 1.2; font-weight: bold; }
  .logo-text p { font-size: 11px; color: var(--blue); letter-spacing: 0.5px; text-transform: uppercase; font-weight: bold; }
  .nav-section { padding: 20px 12px 4px; }
  .nav-label { font-size: 11px; color: var(--gray); letter-spacing: 1px; text-transform: uppercase; padding: 0 8px; margin-bottom: 8px; font-weight: bold; }
  .nav-item { display: flex; align-items: center; gap: 12px; padding: 12px 14px; border-radius: 10px; cursor: pointer; transition: all 0.2s; margin-bottom: 4px; color: var(--gray); font-size: 15px; font-weight: bold; text-decoration: none; border: 2px solid transparent; }
  .nav-item:hover { background: var(--bg); color: var(--blue); border-color: rgba(24,97,191,0.1); }
  .nav-item.active { background: rgba(24,97,191,0.1); color: var(--blue); border-color: rgba(24,97,191,0.2); }
  .nav-item .icon { font-size: 18px; width: 22px; text-align: center; }
  .sidebar-footer { margin-top: auto; padding: 16px 12px; border-top: 2px solid rgba(84,93,104,0.1); }
  .user-info { display: flex; align-items: center; gap: 10px; padding: 12px; border-radius: 10px; background: var(--bg); border: 1px solid rgba(84,93,104,0.15); }
  .user-avatar { width: 36px; height: 36px; background: var(--blue); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; color: var(--white); }
  .user-details h4 { font-size: 13px; color: #111822; width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; font-weight: bold; }
  .user-details p { font-size: 11px; color: var(--gray); }
  .logout-btn { margin-left: auto; background: none; border: none; color: var(--gray); cursor: pointer; font-size: 18px; transition: color 0.2s; }
  .logout-btn:hover { color: var(--red); }
  .main { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; }
  .topbar { display: flex; align-items: center; justify-content: space-between; padding: 16px 32px; border-bottom: 2px solid rgba(84,93,104,0.1); background: rgba(255,255,255,0.9); backdrop-filter: blur(10px); position: sticky; top: 0; z-index: 50; }
  .topbar-left h1 { font-size: 22px; color: #111822; font-weight: bold; }
  .topbar-left p { font-size: 13px; color: var(--gray); }
  .topbar-right { display: flex; align-items: center; gap: 12px; }
  .top-btn { padding: 10px 18px; background: var(--white); border: 2px solid var(--blue); border-radius: 8px; color: var(--blue); font-size: 14px; font-weight: bold; cursor: pointer; transition: all 0.2s; font-family: Arial, sans-serif; display: flex; align-items: center; gap: 6px; }
  .top-btn:hover { background: rgba(24,97,191,0.05); }
  .top-btn.primary { background: var(--blue); color: var(--white); border: none; }
  .top-btn.primary:hover { background: #134ea0; }
  .content { padding: 32px; }
  .page-section { display: none; }
  .page-section.active { display: block; }

  /* STAT CARDS */
  .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 28px; }
  .stat-card { background: var(--white); border: 1px solid rgba(84,93,104,0.15); border-radius: 14px; padding: 20px; position: relative; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.01); transition: transform 0.2s, box-shadow 0.2s; }
  .stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: var(--accent, var(--blue)); }
  .stat-card.clickable { cursor: pointer; }
  .stat-card.clickable:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(24,97,191,0.12); border-color: var(--blue); }
  .stat-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; }
  .stat-icon { font-size: 26px; }
  .stat-trend { font-size: 12px; color: var(--green); background: rgba(11,170,65,0.1); padding: 4px 10px; border-radius: 10px; font-weight: bold; }
  .stat-value { font-size: 32px; color: #111822; line-height: 1; margin-bottom: 6px; font-weight: bold; }
  .stat-label { font-size: 13px; color: var(--gray); font-weight: bold; }
  .stat-hint { font-size: 11px; color: var(--blue); margin-top: 4px; font-style: italic; }

  .grid-2 { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 28px; }
  .grid-custom-public { display: grid; grid-template-columns: 1fr 3fr; gap: 24px; }  .card { background: var(--white); border: 1px solid rgba(84,93,104,0.15); border-radius: 14px; overflow: hidden; margin-bottom: 24px; box-shadow: 0 4px 10px rgba(0,0,0,0.02); }
  .card-header { display: flex; align-items: center; justify-content: space-between; padding: 18px 22px; border-bottom: 2px solid rgba(84,93,104,0.1); background: #fafbfc; }
  .card-title { font-size: 15px; font-weight: bold; color: #111822; display: flex; align-items: center; gap: 8px; }
  .card-action { font-size: 13px; color: var(--blue); cursor: pointer; text-transform: uppercase; font-weight: bold; letter-spacing: 0.5px; }
  .card-body { padding: 22px; }

  /* NOTIFICATIONS */
  .notification-list { display: flex; flex-direction: column; gap: 10px; max-height: 280px; overflow-y: auto; padding-right: 5px; }
  .notification-item { background: var(--bg); border-left: 4px solid var(--blue); padding: 12px 14px; border-radius: 6px; font-size: 14px; line-height: 1.5; color: #223040; }
  .notification-time { font-size: 12px; color: var(--gray); margin-top: 6px; display: block; }
  .no-notifications { font-size: 14px; color: var(--gray); text-align: center; padding: 20px 0; }

  /* BARANGAY FOLDERS */
  .brgy-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(190px, 1fr)); gap: 14px; }
  .brgy-folder-card { background: var(--bg); border: 2px solid rgba(84,93,104,0.1); border-radius: 12px; padding: 18px; cursor: pointer; transition: all 0.2s ease; display: flex; flex-direction: column; gap: 6px; }
  .brgy-folder-card:hover { background: #f0f4fa; border-color: var(--blue); transform: translateY(-2px); }
  .brgy-folder-card.active-folder { background: rgba(24,97,191,0.08); border-color: var(--blue); box-shadow: 0 4px 12px rgba(24,97,191,0.15); }
  .folder-icon { font-size: 32px; color: var(--blue); }
  .folder-name { font-weight: bold; font-size: 15px; color: #111822; }
  .folder-meta { font-size: 13px; color: var(--gray); }

  /* FORMS */
  .dash-form-group { margin-bottom: 18px; position: relative; }
  .dash-form-label { display: block; font-size: 13px; color: var(--gray); letter-spacing: 0.5px; text-transform: uppercase; margin-bottom: 8px; font-weight: bold; }
  .dash-form-input, .dash-form-select, .dash-form-textarea { width: 100%; padding: 12px 14px; background: var(--white); border: 2px solid rgba(84,93,104,0.2); border-radius: 8px; color: #111822; font-size: 14px; font-family: Arial, sans-serif; outline: none; transition: border-color 0.2s; }
  .dash-form-input:focus, .dash-form-select:focus, .dash-form-textarea:focus { border-color: var(--blue); }
  .dash-form-textarea { resize: vertical; min-height: 80px; }
  .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
  .file-input-wrapper { display: flex; gap: 12px; align-items: center; width: 100%; }
  .custom-file-upload { flex: 1; display: flex; align-items: center; justify-content: center; gap: 8px; padding: 12px; background: var(--bg); border: 2px dashed rgba(24,97,191,0.3); border-radius: 8px; color: var(--gray); font-size: 14px; cursor: pointer; transition: all 0.2s; font-weight: bold; }
  .custom-file-upload:hover { background: rgba(24,97,191,0.05); border-color: var(--blue); color: #111822; }
  .file-preview-thumbnail { width: 54px; height: 54px; background: var(--white); border: 2px solid rgba(84,93,104,0.15); border-radius: 8px; display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0; }
  .file-preview-thumbnail img { width: 100%; height: 100%; object-fit: cover; }
  .file-preview-thumbnail span { font-size: 22px; }

  /* PROJECT TABLE */
  .project-table { width: 100%; border-collapse: collapse; }
  .project-table th { font-size: 12px; color: var(--gray); letter-spacing: 0.5px; text-transform: uppercase; padding: 14px 12px; text-align: left; border-bottom: 2px solid rgba(84,93,104,0.15); background: #fafbfc; font-weight: bold; }
  .project-table td { padding: 14px 12px; font-size: 14px; border-bottom: 1px solid rgba(84,93,104,0.1); vertical-align: middle; color: #223040; }
  .project-table tr:hover td { background: rgba(24,97,191,0.03); }
  .project-inline-card { display: flex; align-items: center; gap: 12px; background: var(--bg); border: 1px solid rgba(84,93,104,0.1); padding: 12px; border-radius: 8px; margin-bottom: 8px; }
  .project-img-placeholder { width: 54px; height: 54px; border-radius: 6px; background: #e2e8f0; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1px solid rgba(84,93,104,0.2); flex-shrink: 0; }
  .project-img-placeholder img { width: 100%; height: 100%; object-fit: cover; }
  .project-img-placeholder span { font-size: 24px; }
  .project-info-mini h5 { font-size: 14px; color: #111822; font-weight: bold; }
  .project-info-mini p { font-size: 12px; color: var(--gray); }
  .status-badge { padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: bold; letter-spacing: 0.5px; display: inline-block; text-transform: uppercase; }
  .status-completed { background: rgba(11,170,65,0.12); color: var(--green); border: 1px solid rgba(11,170,65,0.3); }
  .status-ongoing { background: rgba(230,126,34,0.12); color: var(--orange); border: 1px solid rgba(230,126,34,0.3); }
  .status-notstarted { background: rgba(221,88,76,0.12); color: var(--red); border: 1px solid rgba(221,88,76,0.3); }
  .status-pending { background: rgba(84,93,104,0.12); color: var(--gray); border: 1px solid rgba(84,93,104,0.3); }
  .quick-stat { display: flex; justify-content: space-between; align-items: center; padding: 14px 0; border-bottom: 1px solid rgba(84,93,104,0.1); }
  .quick-stat:last-child { border-bottom: none; }
  .qs-label { font-size: 13px; color: var(--gray); font-weight: bold; }
  .qs-val { font-size: 14px; font-weight: bold; color: #111822; }

  /* SEARCH BAR */
  .search-bar-row { display: flex; gap: 10px; align-items: center; margin-bottom: 18px; }
  .search-input { flex: 1; padding: 10px 16px 10px 40px; border: 2px solid rgba(84,93,104,0.2); border-radius: 8px; font-size: 14px; font-family: Arial, sans-serif; outline: none; background: var(--white); color: #111822; transition: border-color 0.2s; }
  .search-input:focus { border-color: var(--blue); }
  .search-input-wrap { position: relative; flex: 1; }
  .search-input-wrap::before { content: '🔍'; position: absolute; left: 12px; top: 50%; transform: translateY(-50%); font-size: 15px; pointer-events: none; }
  .search-btn { padding: 10px 20px; background: var(--blue); color: var(--white); border: none; border-radius: 8px; font-size: 14px; font-weight: bold; cursor: pointer; font-family: Arial, sans-serif; transition: background 0.2s; }
  .search-btn:hover { background: #134ea0; }

  /* PUBLIC VIEW */
  .public-window-layout { min-height: 100vh; background: var(--bg); display: flex; flex-direction: column; }
  .public-header { background: var(--white); padding: 20px 40px; border-bottom: 2px solid rgba(24,97,191,0.15); display: flex; justify-content: space-between; align-items: center; }
  .public-container { padding: 40px; max-width: 1400px; margin: 0 auto; width: 100%; flex: 1; }

  .dash-kanban { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
  .dash-kanban-col { background: #fafbfc; border: 1px solid rgba(84,93,104,0.15); border-radius: 12px; overflow: hidden; display: flex; flex-direction: column; }
  .dash-kanban-col-header { display: flex; align-items: center; justify-content: space-between; gap: 8px; padding: 12px 16px; font-size: 13px; font-weight: bold; color: var(--accent, var(--blue)); background: var(--white); border-bottom: 3px solid var(--accent, var(--blue)); text-transform: uppercase; letter-spacing: 0.5px; }
  .dash-kanban-count { background: var(--accent, var(--blue)); color: #fff; font-size: 11px; font-weight: bold; padding: 2px 10px; border-radius: 10px; }
  .dash-kanban-col-body { padding: 12px; display: flex; flex-direction: column; gap: 10px; max-height: 620px; overflow-y: auto; }
  .dash-kanban-empty { text-align: center; color: var(--gray); font-size: 13px; padding: 26px 10px; font-style: italic; }
  .dash-kanban-card { background: var(--white); border: 1px solid rgba(84,93,104,0.15); border-left: 3px solid var(--accent, var(--blue)); border-radius: 10px; padding: 12px 14px; box-shadow: 0 2px 5px rgba(0,0,0,0.02); }
  .dash-kanban-card-title { font-weight: bold; color: #111822; font-size: 14px; margin-bottom: 2px; }
  .dash-kanban-card-code { font-size: 11px; color: var(--gray); margin-bottom: 8px; }
  .dash-kanban-card-code b { font-family: monospace; font-weight: bold; color: var(--blue); }
  .dash-kanban-card-row { display: flex; align-items: center; justify-content: space-between; gap: 8px; font-size: 12px; color: #223040; margin-bottom: 6px; }
  .dash-kanban-card-dates { display: flex; flex-direction: column; gap: 3px; font-size: 11px; color: var(--gray); background: rgba(24,97,191,0.04); border-radius: 6px; padding: 6px 8px; margin-bottom: 8px; }
  .dash-kanban-card-actions { margin-top: 6px; padding-top: 8px; border-top: 1px dashed rgba(84,93,104,0.2); }
  @media (max-width: 900px) { .dash-kanban { grid-template-columns: 1fr; } }

  /* PUBLIC FILTERS */
  .public-filters { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; margin-bottom: 20px; }
  .public-filters input, .public-filters select { padding: 10px 14px; border: 2px solid rgba(84,93,104,0.2); border-radius: 8px; font-size: 13px; font-family: Arial, sans-serif; outline: none; background: var(--white); color: #111822; transition: border-color 0.2s; }
  .public-filters input:focus, .public-filters select:focus { border-color: var(--blue); }
  .public-filters input[type="text"] { flex: 1; min-width: 180px; }
  .public-filters select { min-width: 160px; cursor: pointer; }

  /* THREE-COLUMN STATUS LAYOUT */
  .status-columns { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; }
  .status-column { background: #fff; border-radius: 10px; padding: 12px; border: 1px solid rgba(84,93,104,0.12); }
  .status-header { font-size: 15px; font-weight: bold; margin-bottom: 10px; padding-bottom: 8px; border-bottom: 2px solid rgba(84,93,104,0.1); }
  .status-header.completed { color: #28a745; }
  .status-header.ongoing { color: #007bff; }
  .status-header.notstarted { color: #dc3545; }
  .status-column-empty { font-size: 12px; color: var(--gray); text-align: center; padding: 20px 8px; }

  /* PROJECT-CARD DESIGN (applied to the project-mini-card component) */
  .project-mini-card { background: var(--white); border: 1px solid rgba(84,93,104,0.15); border-radius: 14px; overflow: hidden; margin-bottom: 12px; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 4px 10px rgba(0,0,0,0.02); }
  .project-mini-card:hover { transform: translateY(-4px); border-color: var(--blue); box-shadow: 0 8px 20px rgba(24,97,191,0.1); }
  .project-mini-img-frame { height: 150px; background: #e2e8f0; position: relative; display: flex; align-items: center; justify-content: center; border-bottom: 1px solid rgba(84,93,104,0.1); overflow: hidden; }
  .project-mini-img-frame img { width: 100%; height: 100%; object-fit: cover; }
  .project-mini-img-frame span { font-size: 36px; }
  .project-mini-badge { position: absolute; top: 10px; right: 10px; z-index: 5; }
  .project-mini-body { padding: 14px 16px; display: flex; flex-direction: column; gap: 6px; }
  .project-mini-code { font-size: 11px; font-weight: bold; color: var(--blue); letter-spacing: 0.5px; }
  .project-name { font-size: 15px; color: #111822; font-weight: bold; }
  .project-mini-desc { font-size: 12px; color: var(--gray); line-height: 1.45; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 2px; }
  .project-mini-finance { display: flex; flex-direction: column; gap: 5px; margin-bottom: 4px; }
  .project-mini-finance-row { display: flex; align-items: center; gap: 6px; background: #f4f6f9; border: 1px solid rgba(84,93,104,0.15); border-radius: 8px; padding: 6px 10px; }
  .project-mini-finance-row .fin-label { font-size: 10px; font-weight: bold; color: var(--gray); text-transform: uppercase; letter-spacing: 0.5px; flex: 1; }
  .project-mini-finance-row .fin-value { font-size: 11px; font-weight: bold; color: var(--blue); background: rgba(24,97,191,0.08); border: 1px solid rgba(24,97,191,0.2); border-radius: 6px; padding: 3px 8px; }
  .project-brgy, .project-contractor { font-size: 12px; color: #666; }
  .project-mini-meta { display: flex; justify-content: space-between; align-items: center; font-size: 12px; border-top: 1px solid rgba(84,93,104,0.1); padding-top: 8px; margin-top: 2px; }
  .project-mini-hint { font-size: 10px; color: var(--blue); font-weight: bold; text-align: center; padding-top: 4px; }

  @media (max-width: 900px) { .status-columns { grid-template-columns: 1fr; } }

  /* NOTIFICATION BELL */
  .notif-bell-wrap { position: relative; }
  .notif-bell-btn { position: relative; font-size: 17px; padding: 9px 13px; line-height: 1; }
  .notif-bell-badge { position: absolute; top: -6px; right: -6px; background: var(--red); color: #fff; font-size: 10px; font-weight: bold; min-width: 18px; height: 18px; border-radius: 9px; display: none; align-items: center; justify-content: center; padding: 0 4px; border: 2px solid #fff; }
  .notif-panel { position: absolute; top: calc(100% + 10px); right: 0; width: 320px; background: var(--white); border-radius: 12px; box-shadow: 0 15px 40px rgba(0,0,0,0.18); border: 1px solid rgba(84,93,104,0.15); z-index: 400; overflow: hidden; animation: fadeUp 0.2s ease; display: none; }
  .notif-panel.open { display: block; }
  .notif-panel-header { padding: 14px 16px; font-weight: bold; font-size: 14px; background: #fafbfc; border-bottom: 1px solid rgba(84,93,104,0.1); color: #111822; }
  .notif-panel-body { max-height: 300px; overflow-y: auto; }
  .notif-item { padding: 12px 16px; border-bottom: 1px solid rgba(84,93,104,0.08); cursor: pointer; transition: background 0.15s; }
  .notif-item:hover { background: rgba(24,97,191,0.05); }
  .notif-item-title { font-weight: bold; font-size: 13px; color: #111822; }
  .notif-item-sub { font-size: 12px; color: var(--gray); margin-top: 2px; }
  .notif-empty { padding: 26px 16px; text-align: center; color: var(--gray); font-size: 13px; }
  .notif-panel-footer { padding: 12px 16px; text-align: center; font-size: 13px; font-weight: bold; color: var(--blue); cursor: pointer; background: #fafbfc; border-top: 1px solid rgba(84,93,104,0.1); }
  .notif-panel-footer:hover { background: rgba(24,97,191,0.08); }


  /* PRINTABLE RECEIPT */
  @media print {
    body.printing-receipt > *:not(#publicReceiptModal) { display: none !important; }
    body.printing-receipt #publicReceiptModal { position: static !important; display: block !important; background: none !important; backdrop-filter: none !important; padding: 0 !important; }
    body.printing-receipt .receipt-box { box-shadow: none !important; max-width: 100% !important; width: 100% !important; margin: 0 auto; animation: none !important; border: 1px solid #999; }
    body.printing-receipt .receipt-body { max-height: none !important; overflow: visible !important; }
    body.printing-receipt .receipt-actions { display: none !important; }
    body.printing-receipt .receipt-print-note { display: block !important; font-size: 10px; color: #555; }
    body.printing-receipt * { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    @page { margin: 14mm; }
  }

  /* MODAL */
  .modal-overlay { position: fixed; inset: 0; background: rgba(26,37,48,0.4); backdrop-filter: blur(4px); z-index: 200; display: none; align-items: center; justify-content: center; padding: 20px; }
  .modal-box { background: var(--white); width: 100%; max-width: 520px; border-radius: 16px; overflow: hidden; box-shadow: 0 15px 40px rgba(0,0,0,0.1); animation: fadeUp 0.3s ease; border: 1px solid rgba(84,93,104,0.2); }
  .modal-box-header { background: var(--blue); color: var(--white); padding: 18px 22px; font-size: 16px; font-weight: bold; }
  .modal-box-body { padding: 24px; }
  .modal-box-footer { padding: 16px 24px; background: #fafbfc; border-top: 1px solid rgba(84,93,104,0.1); display: flex; justify-content: flex-end; gap: 10px; }

  /* PUBLIC PROJECT RECEIPT */
  .showcase-card { cursor: pointer; }
  .showcase-click-hint { font-size: 11px; color: var(--blue); font-weight: bold; text-align: center; padding-top: 4px; }
  .receipt-box { background: var(--white); width: 100%; max-width: 380px; border-radius: 6px; box-shadow: 0 24px 60px rgba(0,0,0,0.28); font-family: 'Courier New', Courier, monospace; animation: fadeUp 0.25s ease; }
  .receipt-header { text-align: center; padding: 24px 20px 16px; }
  .receipt-seal { font-size: 30px; margin-bottom: 6px; }
  .receipt-header-title { font-weight: bold; font-size: 15px; letter-spacing: 1px; color: #111822; }
  .receipt-header-sub { font-size: 11px; color: var(--gray); text-transform: uppercase; letter-spacing: 1px; margin-top: 3px; }
  .receipt-divider { border-top: 1.5px dashed rgba(84,93,104,0.4); margin: 0 20px; }
  .receipt-body { max-height: 60vh; overflow-y: auto; padding: 18px 20px; display: flex; flex-direction: column; gap: 13px; }
  .receipt-project-name { font-size: 15px; font-weight: bold; color: #111822; text-align: center; padding-bottom: 2px; }
  .receipt-row { display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; font-size: 12.5px; }
  .receipt-label { color: var(--gray); text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px; flex-shrink: 0; }
  .receipt-value { font-weight: bold; text-align: right; color: #111822; }
  .receipt-section-title { font-size: 11px; color: var(--gray); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 4px; padding-top: 12px; border-top: 1.5px dashed rgba(84,93,104,0.4); }
  .receipt-expense-list { display: flex; flex-direction: column; gap: 7px; }
  .receipt-expense-row { display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; font-size: 12px; color: #111822; }
  .receipt-expense-row .exp-label { flex: 1; word-break: break-word; }
  .receipt-expense-row .exp-amt { font-weight: bold; white-space: nowrap; }
  .receipt-expense-total { display: flex; justify-content: space-between; gap: 12px; font-size: 12.5px; font-weight: bold; padding-top: 8px; border-top: 1px solid rgba(84,93,104,0.3); }
  .receipt-expense-empty { font-size: 11.5px; color: var(--gray); font-style: italic; text-align: center; }
  .receipt-status-line { text-align: center; margin-top: 2px; }
  .receipt-footer { padding: 16px 20px 22px; text-align: center; display: flex; flex-direction: column; gap: 12px; align-items: center; }
  .receipt-footer-note { font-size: 10px; color: var(--gray); font-style: italic; }

  /* STATUS MODAL */
  .status-modal-overlay { position: fixed; inset: 0; background: rgba(26,37,48,0.5); backdrop-filter: blur(4px); z-index: 300; display: none; align-items: flex-start; justify-content: center; padding: 40px 20px; overflow-y: auto; }
  .status-modal-box { background: var(--white); width: 100%; max-width: 900px; border-radius: 16px; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.15); animation: fadeUp 0.3s ease; }
  .status-modal-header { padding: 20px 24px; color: var(--white); font-size: 18px; font-weight: bold; display: flex; justify-content: space-between; align-items: center; }
  .status-modal-body { padding: 24px; }
  .close-modal-btn { background: rgba(255,255,255,0.2); border: none; color: var(--white); font-size: 20px; cursor: pointer; border-radius: 6px; padding: 4px 10px; font-weight: bold; }
  .close-modal-btn:hover { background: rgba(255,255,255,0.35); }

  /* PRINT MODAL */
  #printModal { position: fixed; inset: 0; background: rgba(10,18,28,0.6); backdrop-filter: blur(6px); z-index: 900; display: none; align-items: flex-start; justify-content: center; padding: 24px 16px; overflow-y: auto; }
  #printModal.open { display: flex; }
  .print-modal-shell { background: #f0f2f5; width: 100%; max-width: 1180px; border-radius: 18px; overflow: hidden; box-shadow: 0 24px 60px rgba(0,0,0,0.25); animation: fadeUp 0.3s ease; display: flex; flex-direction: column; }
  .print-modal-topbar { background: var(--blue); color: #fff; padding: 16px 24px; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; }
  .print-modal-topbar h2 { font-size: 17px; font-weight: bold; display: flex; align-items: center; gap: 10px; }
  .print-modal-topbar-actions { display: flex; gap: 10px; align-items: center; }
  .pm-top-btn { padding: 8px 18px; border-radius: 8px; font-size: 14px; font-weight: bold; cursor: pointer; border: 2px solid rgba(255,255,255,0.4); background: rgba(255,255,255,0.12); color: #fff; transition: all 0.2s; font-family: Arial,sans-serif; }
  .pm-top-btn:hover { background: rgba(255,255,255,0.25); }
  .pm-top-btn.print-go { background: #fff; color: var(--blue); border-color: #fff; }
  .pm-top-btn.print-go:hover { background: #e8f0fc; }
  .pm-close-btn { background: rgba(255,255,255,0.15); border: none; color: #fff; font-size: 22px; cursor: pointer; border-radius: 8px; padding: 4px 12px; font-weight: bold; line-height: 1; }
  .pm-close-btn:hover { background: rgba(221,88,76,0.5); }
  .print-modal-body { display: flex; gap: 0; flex: 1; min-height: 0; }
  /* Controls panel */
  .pm-controls { width: 280px; flex-shrink: 0; background: #fff; border-right: 2px solid rgba(84,93,104,0.12); padding: 20px 18px; overflow-y: auto; display: flex; flex-direction: column; gap: 18px; }
  .pm-ctrl-section { border: 1.5px solid rgba(84,93,104,0.15); border-radius: 10px; overflow: hidden; }
  .pm-ctrl-section-hd { background: #f4f6f9; padding: 10px 14px; font-size: 12px; font-weight: bold; color: var(--blue); letter-spacing: 0.8px; text-transform: uppercase; border-bottom: 1.5px solid rgba(84,93,104,0.12); }
  .pm-ctrl-section-body { padding: 14px; display: flex; flex-direction: column; gap: 12px; }
  .pm-ctrl-label { font-size: 12px; color: var(--gray); font-weight: bold; text-transform: uppercase; letter-spacing: 0.4px; margin-bottom: 5px; display: block; }
  .pm-ctrl-select, .pm-ctrl-input { width: 100%; padding: 9px 11px; border: 2px solid rgba(84,93,104,0.2); border-radius: 7px; font-size: 14px; font-family: Arial,sans-serif; color: #111822; background: #fff; outline: none; transition: border-color 0.2s; }
  .pm-ctrl-select:focus, .pm-ctrl-input:focus { border-color: var(--blue); }
  .pm-paper-btns { display: flex; gap: 6px; }
  .pm-paper-btn { flex: 1; padding: 8px 4px; border: 2px solid rgba(84,93,104,0.2); border-radius: 7px; font-size: 12px; font-weight: bold; cursor: pointer; background: #f4f6f9; color: var(--gray); transition: all 0.18s; text-align: center; font-family: Arial,sans-serif; }
  .pm-paper-btn.active { background: var(--blue); color: #fff; border-color: var(--blue); }
  .pm-margin-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
  .pm-margin-item label { font-size: 11px; color: var(--gray); font-weight: bold; display: block; margin-bottom: 3px; }
  .pm-margin-item input { width: 100%; padding: 7px 9px; border: 2px solid rgba(84,93,104,0.2); border-radius: 6px; font-size: 13px; font-family: Arial,sans-serif; outline: none; }
  .pm-margin-item input:focus { border-color: var(--blue); }
  .pm-photo-upload-area { border: 2px dashed rgba(24,97,191,0.3); border-radius: 8px; padding: 14px; text-align: center; cursor: pointer; transition: all 0.2s; background: #f8fafd; }
  .pm-photo-upload-area:hover { border-color: var(--blue); background: rgba(24,97,191,0.04); }
  .pm-photo-preview { width: 100%; max-height: 120px; object-fit: contain; border-radius: 6px; margin-top: 8px; border: 1px solid rgba(84,93,104,0.15); }
  .pm-remove-photo { font-size: 12px; color: var(--red); cursor: pointer; font-weight: bold; margin-top: 6px; display: inline-block; }
  /* Preview panel */
  .pm-preview-wrap { flex: 1; padding: 28px; overflow-y: auto; display: flex; align-items: flex-start; justify-content: center; background: #e2e6ec; }
  .pm-page { background: #fff; box-shadow: 0 8px 30px rgba(0,0,0,0.18); position: relative; }
  /* Document content */
  .pm-doc-header { display: flex; align-items: center; gap: 16px; margin-bottom: 18px; padding-bottom: 14px; border-bottom: 3px solid var(--blue); }
  .pm-doc-logo { width: 64px; height: 64px; border-radius: 50%; background: var(--blue); display: flex; align-items: center; justify-content: center; font-size: 30px; flex-shrink: 0; }
  .pm-doc-agency h1 { font-size: 15px; font-weight: bold; color: #111822; line-height: 1.3; }
  .pm-doc-agency p { font-size: 12px; color: var(--gray); }
  .pm-doc-photo { width: 100%; max-height: 200px; object-fit: cover; border-radius: 8px; margin-bottom: 16px; border: 1px solid rgba(84,93,104,0.15); }
  .pm-doc-title { font-size: 18px; font-weight: bold; color: var(--blue); margin-bottom: 4px; }
  .pm-doc-subtitle { font-size: 13px; color: var(--gray); margin-bottom: 16px; }
  .pm-doc-table { width: 100%; border-collapse: collapse; margin-bottom: 18px; }
  .pm-doc-table th { background: var(--blue); color: #fff; padding: 9px 10px; font-size: 11px; font-weight: bold; text-align: left; letter-spacing: 0.4px; }
  .pm-doc-table td { padding: 8px 10px; border-bottom: 1px solid #e4e8ef; font-size: 12px; vertical-align: middle; }
  .pm-doc-table tr:nth-child(even) td { background: #f8fafd; }
  .pm-doc-badge { padding: 3px 9px; border-radius: 10px; font-size: 10px; font-weight: bold; letter-spacing: 0.3px; display: inline-block; }
  .pm-doc-badge.completed { background: rgba(11,170,65,0.12); color: #0baa41; }
  .pm-doc-badge.ongoing { background: rgba(230,126,34,0.12); color: #e67e22; }
  .pm-doc-badge.notstarted { background: rgba(221,88,76,0.12); color: #dd584c; }
  .pm-doc-summary { display: grid; grid-template-columns: repeat(3,1fr); gap: 10px; margin-bottom: 18px; }
  .pm-doc-sum-card { border: 1.5px solid #e4e8ef; border-radius: 8px; padding: 12px; text-align: center; }
  .pm-doc-sum-val { font-size: 22px; font-weight: bold; color: var(--blue); }
  .pm-doc-sum-lbl { font-size: 11px; color: var(--gray); font-weight: bold; text-transform: uppercase; letter-spacing: 0.4px; }
  .pm-doc-footer { border-top: 2px solid #e4e8ef; padding-top: 12px; font-size: 11px; color: var(--gray); display: flex; justify-content: space-between; }
  .pm-range-row { display: flex; align-items: center; gap: 8px; }
  .pm-range-row input[type=range] { flex: 1; accent-color: var(--blue); }
  .pm-range-val { font-size: 13px; font-weight: bold; color: var(--blue); width: 36px; text-align: right; flex-shrink: 0; }
  .pm-fmt-btn { padding: 4px 10px; border: 1.5px solid rgba(84,93,104,0.2); border-radius: 6px; background: #f4f6f9; color: #111822; font-size: 13px; cursor: pointer; font-family: Arial,sans-serif; transition: all 0.15s; line-height: 1.4; }
  .pm-fmt-btn:hover { background: var(--blue); color: #fff; border-color: var(--blue); }
  .pm-filter-group-title { font-size: 11px; font-weight: bold; color: var(--gray); text-transform: uppercase; letter-spacing: 0.6px; margin-bottom: 6px; }
  .pm-filter-list { display: flex; flex-direction: column; gap: 2px; max-height: 150px; overflow-y: auto; border: 1.5px solid rgba(84,93,104,0.15); border-radius: 8px; padding: 4px; }
  .pm-filter-row { display: flex; align-items: center; gap: 8px; padding: 6px 8px; border-radius: 6px; cursor: pointer; font-size: 13px; }
  .pm-filter-row:hover { background: rgba(24,97,191,0.06); }
  #pmDocContent:empty::before { content: 'Click here to start typing or editing your report...'; color: #bbb; font-style: italic; pointer-events: none; }

  /* PENDING REVIEW STYLES */
  #pendingNavBadge { animation: pulse 2s infinite; }
  #pendingStatCard:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(124,58,237,0.15); border-color: #7c3aed; }

  /* TOAST NOTIFICATION */
  #toastContainer { position: fixed; bottom: 28px; right: 28px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; pointer-events: none; }
  .toast { display: flex; align-items: center; gap: 12px; background: #1a2530; color: #fff; padding: 14px 20px; border-radius: 12px; font-size: 14px; font-weight: bold; box-shadow: 0 8px 24px rgba(0,0,0,0.2); animation: toastIn 0.3s ease; border-left: 5px solid var(--green); min-width: 280px; max-width: 380px; pointer-events: auto; }
  .toast.toast-error { border-left-color: var(--red); }
  .toast-icon { font-size: 20px; flex-shrink: 0; }
  .toast-text { flex: 1; line-height: 1.4; }
  .toast-close { background: none; border: none; color: rgba(255,255,255,0.5); font-size: 18px; cursor: pointer; padding: 0; line-height: 1; flex-shrink: 0; }
  .toast-close:hover { color: #fff; }
  @keyframes toastIn { from { opacity: 0; transform: translateX(30px); } to { opacity: 1; transform: translateX(0); } }
  @keyframes toastOut { from { opacity: 1; transform: translateX(0); } to { opacity: 0; transform: translateX(30px); } }

  @media print {
    body > *:not(#printOutputFrame) { display: none !important; }
    #printOutputFrame { display: block !important; position: fixed; inset: 0; width: 100%; height: 100%; border: none; }
  }

  @media (max-width: 1024px) { .stats-grid { grid-template-columns: repeat(2,1fr); } .grid-2 { grid-template-columns: 1fr; } }
  @media (max-width: 768px) { #gatewayPage { flex-direction: column; } .left-panel { width: 100%; border-right: none; border-bottom: 1px solid rgba(84,93,104,0.2); padding: 40px 30px; } .right-panel { width: 100%; padding: 40px 30px; } .sidebar { display: none; } .main { margin-left: 0; } }

  /* ===== v2 ADDITIONS ===== */
  /* Full-screen folder modal */
  #folderModal, #statusModal { padding: 0; align-items: stretch; overflow: hidden; }
  #folderModal .status-modal-box, #statusModal .status-modal-box { max-width: none; width: 100%; height: 100%; border-radius: 0; box-shadow: none; animation: none; display: flex; flex-direction: column; }
  #folderModal .status-modal-header, #statusModal .status-modal-header { flex-shrink: 0; }
  #folderModal .status-modal-body, #statusModal .status-modal-body { flex: 1; overflow-y: auto; padding: 24px 32px; }

  /* Table helpers */
  .muted-dash { font-size: 12px; color: var(--gray); font-style: italic; }
  .code-cell { font-family: monospace; font-weight: bold; color: var(--blue); font-size: 13px; white-space: nowrap; }
  .brgy-chip { background: #e8ecf2; padding: 3px 8px; border-radius: 6px; font-size: 12px; font-weight: bold; white-space: nowrap; display: inline-block; }
  .money-cell { font-weight: bold; color: var(--blue); white-space: nowrap; }
  .date-cell { font-size: 13px; font-weight: bold; color: #223040; white-space: nowrap; }
  .table-empty { text-align: center; color: var(--gray); padding: 28px; font-size: 14px; }
  .title-cell strong { color: #111822; display: block; min-width: 170px; }
  .title-cell .tc-sub { font-size: 11px; color: var(--gray); margin-top: 3px; }
  .project-table tr[data-pcode] { cursor: pointer; }
  .project-table tr[data-pcode]:hover td { background: rgba(24,97,191,0.07); }
  .project-table td.remarks-cell { min-width: 200px; max-width: 320px; font-size: 13px; }
  .project-table td.loc-cell { min-width: 150px; font-size: 13px; }

  /* Status + review badges */
  .review-badge { padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: bold; letter-spacing: 0.3px; display: inline-block; white-space: nowrap; }
  .review-confirmed { background: rgba(11,170,65,0.12); color: var(--green); border: 1px solid rgba(11,170,65,0.35); }
  .review-rejected { background: rgba(221,88,76,0.12); color: var(--red); border: 1px solid rgba(221,88,76,0.35); }
  .review-pending { background: rgba(124,58,237,0.1); color: #7c3aed; border: 1px solid rgba(124,58,237,0.3); }
  .pct-wrap { display: flex; align-items: center; gap: 8px; min-width: 130px; }
  .pct-track { flex: 1; height: 8px; background: #e2e8f0; border-radius: 6px; overflow: hidden; }
  .pct-fill { height: 100%; border-radius: 6px; }
  .pct-label { font-size: 12px; font-weight: bold; min-width: 38px; text-align: right; color: #223040; }

  /* Dashboard / public status tables */
  .dash-block { border: 1px solid rgba(84,93,104,0.15); border-radius: 12px; overflow: hidden; margin-bottom: 22px; background: var(--white); }
  .dash-block-header { display: flex; align-items: center; justify-content: space-between; gap: 8px; padding: 12px 18px; font-size: 14px; font-weight: bold; color: var(--accent, var(--blue)); background: #fafbfc; border-bottom: 3px solid var(--accent, var(--blue)); text-transform: uppercase; letter-spacing: 0.5px; }
  .dash-block-scroll { overflow-x: auto; }
  .thumb-box { width: 64px; height: 52px; border-radius: 6px; background: #e2e8f0; border: 1px solid rgba(84,93,104,0.2); display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative; }
  .thumb-box img { width: 100%; height: 100%; object-fit: cover; }
  .thumb-more { position: absolute; right: 2px; bottom: 2px; background: rgba(17,24,34,0.75); color: #fff; font-size: 10px; font-weight: bold; padding: 1px 5px; border-radius: 8px; }
  .rv-btn { padding: 6px 12px; font-size: 12px; font-weight: bold; border-radius: 8px; cursor: pointer; border: 2px solid; font-family: Arial, sans-serif; transition: all 0.15s; white-space: nowrap; }
  .rv-confirm { border-color: var(--green); color: var(--green); background: #f0fdf5; }
  .rv-confirm:hover { background: var(--green); color: #fff; }
  .rv-reject { border-color: var(--red); color: var(--red); background: #fff5f5; }
  .rv-reject:hover { background: var(--red); color: #fff; }

  /* Project form: photos + review banner */
  .photo-drop { display: flex; align-items: center; justify-content: center; gap: 8px; padding: 14px; background: var(--bg); border: 2px dashed rgba(24,97,191,0.3); border-radius: 8px; color: var(--gray); font-size: 14px; cursor: pointer; font-weight: bold; transition: all 0.2s; }
  .photo-drop:hover { background: rgba(24,97,191,0.05); border-color: var(--blue); color: #111822; }
  .photo-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(96px, 1fr)); gap: 10px; margin-top: 12px; }
  .photo-tile { position: relative; aspect-ratio: 1; border-radius: 8px; overflow: hidden; border: 2px solid rgba(84,93,104,0.15); background: #e2e8f0; }
  .photo-tile img { width: 100%; height: 100%; object-fit: cover; }
  .photo-tile button { position: absolute; top: 4px; right: 4px; width: 22px; height: 22px; border-radius: 50%; border: none; background: rgba(221,88,76,0.92); color: #fff; font-size: 12px; font-weight: bold; cursor: pointer; line-height: 1; }
  .review-banner { display: none; align-items: center; gap: 10px; flex-wrap: wrap; margin-bottom: 18px; padding: 12px 16px; border-radius: 10px; background: #fafbfc; border: 1.5px solid rgba(84,93,104,0.18); font-size: 13px; color: var(--gray); }

  /* Project details modal (replaces the old public receipt) */
  /* Full-screen project details (receipt box) */
  #publicReceiptModal { z-index: 700; padding: 0; align-items: stretch; }
  #publicReceiptModal .receipt-box { max-width: none; width: 100%; height: 100%; border-radius: 0; box-shadow: none; display: flex; flex-direction: column; }
  #publicReceiptModal .receipt-header, #publicReceiptModal .receipt-footer { flex-shrink: 0; }
  #publicReceiptModal .receipt-body { flex: 1; max-height: none; padding: 24px 32px; display: block; }
  #publicReceiptModal .receipt-row { font-size: 14px; }
  #publicReceiptModal .receipt-project-name { font-size: 22px; }
  .detail-layout { display: grid; grid-template-columns: minmax(0, 5fr) minmax(0, 6fr); gap: 32px; align-items: start; width: 100%; max-width: 1240px; margin: 0 auto; }
  .detail-photos { position: sticky; top: 0; }
  .detail-info { display: flex; flex-direction: column; gap: 13px; }
  @media (max-width: 900px) { .detail-layout { grid-template-columns: 1fr; } .detail-photos { position: static; } }
  .detail-gallery { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 10px; }
  .detail-gallery img { width: 100%; aspect-ratio: 4/3; object-fit: cover; border-radius: 8px; cursor: zoom-in; border: 1px solid rgba(84,93,104,0.2); }
  .detail-gallery.single { grid-template-columns: 1fr; }
  .detail-photo-note { font-size: 11px; color: var(--gray); text-align: center; margin-top: 6px; }
  .detail-no-photo { text-align: center; font-size: 12px; color: var(--gray); font-style: italic; padding: 14px; background: var(--bg); border-radius: 8px; border: 1px dashed rgba(84,93,104,0.3); }
  .detail-badges { display: flex; gap: 8px; justify-content: center; flex-wrap: wrap; }
  #photoLightbox { z-index: 900; background: rgba(10,18,28,0.88); flex-direction: column; gap: 12px; }
  #photoLightbox img { max-width: 94vw; max-height: 82vh; border-radius: 8px; box-shadow: 0 10px 40px rgba(0,0,0,0.5); }
  .lb-controls { display: flex; gap: 12px; align-items: center; color: #fff; font-weight: bold; font-size: 14px; }
  .lb-controls button { background: rgba(255,255,255,0.18); border: none; color: #fff; font-size: 18px; padding: 6px 16px; border-radius: 8px; cursor: pointer; }
  .lb-controls button:hover { background: rgba(255,255,255,0.32); }
</style>
</head>
<body>

<!-- TOAST CONTAINER -->
<div id="toastContainer"></div>

<!-- GATEWAY PAGE -->
<div id="gatewayPage">
  <div class="bg-pattern"></div>
  <div class="bg-grid"></div>
  <div class="left-panel">
    <div class="seal-wrap">
      <div class="seal">🏛️</div>
      <div class="seal-text">
        <h2>Republic of the Philippines</h2>
        <p>Department of the Interior and Local Government</p>
      </div>
    </div>
    <div class="main-title">
      <h1>DILG Project<br><span>Monitoring &amp; Public</span><br>View System</h1>
      <p>A system for tracking, recording, and sharing public-funded projects across the 10 barangays of <strong>Sapian, Capiz</strong>. Open to all citizens.</p>
    </div>
    <div class="gateway-options">
      <button class="gate-btn primary" onclick="routeGateway('admin')">
        <span>🛡️ Admin Sign In</span><span>→</span>
      </button>
      <button class="gate-btn secondary" onclick="routeGateway('rep')">
        <span>👤 Barangay Rep Sign In</span><span>→</span>
      </button>
      <button class="gate-btn secondary" onclick="routeGateway('public')" style="border-color:var(--gray); color:var(--gray);">
        <span>👁️ View Public Projects</span><span>→</span>
      </button>
    </div>
    <div class="version-badge">
      <div class="version-dot"></div>
      SAPIAN, CAPIZ · 2026
    </div>
  </div>
  <div class="right-panel">
    <div class="auth-card active" id="defaultWelcomeCard" style="text-align:center; max-width:380px;">
      <span style="font-size:54px; display:block; margin-bottom:15px;">📊</span>
      <h3 style="font-size:22px; margin-bottom:10px; font-weight:bold;">Choose Login Type</h3>
      <p style="font-size:14px; color:var(--gray); line-height:1.6;">Pick your account type on the left to log in. Admins and Barangay Reps each have their own login page.</p>
    </div>
    <div class="auth-card" id="adminAuthCard">
      <div class="auth-header">
        <div style="display:inline-flex;align-items:center;justify-content:center;width:56px;height:56px;background:var(--blue);color:var(--white);border-radius:50%;font-size:24px;margin-bottom:12px;">🛡️</div>
        <h2>Admin Sign In</h2>
        <p style="color:var(--blue);font-size:13px;text-transform:uppercase;letter-spacing:0.5px;margin-top:4px;font-weight:bold;">DILG Admin Portal</p>
      </div>
      <div class="divider"><div class="divider-line"></div><div class="divider-icon">🔐</div><div class="divider-line"></div></div>
      <div class="error-msg" id="adminErrorMsg"></div>
      <div class="form-group">
        <label class="form-label">Username</label>
        <span class="input-icon">👤</span>
        <input class="form-input" type="text" id="adminUsername" placeholder="Enter admin username..." autocomplete="off">
      </div>
      <div class="form-group">
        <label class="form-label">Password</label>
        <span class="input-icon">🔒</span>
        <input class="form-input" type="password" id="adminPassword" placeholder="Enter password...">
        <button class="toggle-pass" type="button" onclick="togglePass('adminPassword')">👁️</button>
      </div>
      <button class="login-btn" onclick="handleLogin('admin')">
        <span id="adminBtnText">Sign In as Admin</span>
        <div class="loader" id="adminLoader"></div>
      </button>
      <button class="btn-cancel" style="width:100%;margin-top:12px;" onclick="resetGatewayHome()">← Back</button>
    </div>
    <div class="auth-card" id="repAuthCard">
      <div class="auth-header">
        <div style="display:inline-flex;align-items:center;justify-content:center;width:56px;height:56px;background:var(--blue);color:var(--white);border-radius:50%;font-size:24px;margin-bottom:12px;">👤</div>
        <h2>Rep Sign In</h2>
        <p style="color:var(--blue);font-size:13px;text-transform:uppercase;letter-spacing:0.5px;margin-top:4px;font-weight:bold;">Barangay Rep Portal</p>
      </div>
      <div class="divider"><div class="divider-line"></div><div class="divider-icon">🏘️</div><div class="divider-line"></div></div>
      <div class="error-msg" id="repErrorMsg"></div>
      <div class="form-group">
        <label class="form-label">Username</label>
        <span class="input-icon">👤</span>
        <input class="form-input" type="text" id="repUsername" placeholder="Enter username..." autocomplete="off">
      </div>
      <div class="form-group">
        <label class="form-label">Password</label>
        <span class="input-icon">🔒</span>
        <input class="form-input" type="password" id="repPassword" placeholder="Enter password...">
        <button class="toggle-pass" type="button" onclick="togglePass('repPassword')">👁️</button>
      </div>
      <button class="login-btn" onclick="handleLogin('rep')">
        <span id="repBtnText">Sign In as Rep</span>
        <div class="loader" id="repLoader"></div>
      </button>
      <button class="btn-cancel" style="width:100%;margin-top:12px;" onclick="resetGatewayHome()">← Back</button>
    </div>
  </div>
</div>

<!-- PUBLIC VIEW PAGE -->
<div id="publicViewPage" style="display:none;" class="public-window-layout">
  <header class="public-header">
    <div style="display:flex;align-items:center;gap:15px;">
      <div class="seal" style="width:54px;height:54px;font-size:24px;">🏛️</div>
      <div>
        <h2 style="font-size:18px;color:#111822;font-weight:bold;">PUBLIC PROJECT VIEWER</h2>
        <p style="font-size:12px;color:var(--blue);letter-spacing:0.5px;text-transform:uppercase;font-weight:bold;">Sapian, Capiz — DILG Project Records</p>
      </div>
    </div>
    <button class="top-btn" onclick="exitPublicView()">🚪 Exit</button>
  </header>
  <div class="public-container">
    <div style="margin-bottom:20px;">
      <h3 style="font-size:26px;margin-bottom:6px;font-weight:bold;">Open Project List</h3>
      <p style="font-size:15px;color:var(--gray);">Anyone can view all project records and updates for the year 2026.</p>
      <div style="margin-top:14px;padding:12px 18px;background:rgba(24,97,191,0.06);border:1.5px solid rgba(24,97,191,0.2);border-radius:10px;display:flex;align-items:center;gap:12px;">
        <span style="font-size:22px;">🧾</span>
        <p style="font-size:13px;color:var(--gray);line-height:1.5;"><strong style="color:#111822;">Full project details are public.</strong> Click any project to view its full details and photos.</p>
      </div>
    </div>

    <div class="public-filters">
      <input type="text" id="projectSearch" placeholder="Search by project name, barangay, or status..." oninput="renderPublicShowcase()">
    </div>

    <div style="font-size:13px;color:var(--gray);font-weight:bold;margin-bottom:10px;" id="publicCountLabel">Showing all records</div>

    <div id="publicStatusBoard">
      <div class="dash-block" style="--accent:var(--green);">
        <div class="dash-block-header"><span>✅ Completed</span><span class="dash-kanban-count" id="pubCount_Completed">0</span></div>
        <div class="dash-block-scroll"><table class="project-table"><thead id="pubHead_Completed"></thead><tbody id="pubBody_Completed"></tbody></table></div>
      </div>
      <div class="dash-block" style="--accent:var(--orange);">
        <div class="dash-block-header"><span>⏳ Ongoing</span><span class="dash-kanban-count" id="pubCount_Ongoing">0</span></div>
        <div class="dash-block-scroll"><table class="project-table"><thead id="pubHead_Ongoing"></thead><tbody id="pubBody_Ongoing"></tbody></table></div>
      </div>
      <div class="dash-block" style="--accent:var(--red);">
        <div class="dash-block-header"><span>🕓 Not Yet Started</span><span class="dash-kanban-count" id="pubCount_NotStarted">0</span></div>
        <div class="dash-block-scroll"><table class="project-table"><thead id="pubHead_NotStarted"></thead><tbody id="pubBody_NotStarted"></tbody></table></div>
      </div>
    </div>
  </div>
</div>

<!-- DASHBOARD -->
<div id="dashboardPage">
  <aside class="sidebar">
    <div class="sidebar-logo">
      <div class="logo-icon">📊</div>
      <div class="logo-text">
        <h3>DILG SAPIAN</h3>
        <p>PROJECT MONITOR</p>
      </div>
    </div>
    <div class="nav-section">
      <div class="nav-label">Main Menu</div>
      <div class="nav-item active" id="navDash" onclick="switchTab('dash')"><span class="icon">💻</span> Dashboard</div>
      <div class="nav-item" id="navWorkspace" onclick="switchTab('workspace')"><span class="icon">📁</span> Barangay Files</div>
      <div class="nav-item" id="navIngest" onclick="switchTab('ingest')"><span class="icon">📥</span> Add Project</div>
    </div>
    <div class="nav-section" id="adminOnlyNavSection" style="display:none;">
      <div class="nav-label">Admin Tools</div>
      <div class="nav-item" id="navPending" onclick="switchTab('pending')" style="position:relative;">
        <span class="icon">🕐</span> Pending Reviews
        <span id="pendingNavBadge" style="display:none;position:absolute;right:10px;top:50%;transform:translateY(-50%);background:var(--red);color:#fff;font-size:11px;font-weight:bold;padding:2px 7px;border-radius:10px;min-width:20px;text-align:center;"></span>
      </div>
      <div class="nav-item" id="navAccounts" onclick="switchTab('accounts')"><span class="icon">👥</span> Manage Accounts</div>
    </div>
    <div class="sidebar-footer">
      <div class="user-info">
        <div class="user-avatar" id="currentUserAvatar">?</div>
        <div class="user-details">
          <h4 id="currentUserName">Unknown</h4>
          <p id="currentUserRole">Guest</p>
        </div>
        <button class="logout-btn" onclick="handleLogout()" title="Log Out">❌</button>
      </div>
    </div>
  </aside>

  <main class="main">
    <header class="topbar">
      <div class="topbar-left">
        <h1 id="topbarTitle">Dashboard</h1>
        <p id="topbarSubtitle">Project overview and summary</p>
      </div>
      <div class="topbar-right">
        <div class="notif-bell-wrap" id="notifBellWrap" style="display:none;">
          <button class="top-btn notif-bell-btn" id="notifBellBtn" onclick="toggleNotifPanel(event)" title="Notifications">
            🔔<span class="notif-bell-badge" id="notifBellBadge">0</span>
          </button>
          <div class="notif-panel" id="notifPanel">
            <div class="notif-panel-header">🔔 Notifications</div>
            <div class="notif-panel-body" id="notifPanelBody"></div>
            <div class="notif-panel-footer" onclick="viewAllNotifications()">View all pending reviews →</div>
          </div>
        </div>
        <div style="font-size:14px;color:var(--gray);font-weight:bold;background:var(--bg);padding:8px 14px;border-radius:8px;border:1px solid rgba(84,93,104,0.15);">
          DILG · 2026
        </div>
        <button class="top-btn primary" id="quickActionBtn" onclick="switchTab('ingest')">
          ➕ Add Project
        </button>
        <button class="top-btn" id="printReportBtn" onclick="printProjectReport()" style="display:none;">
          🖨️ Print Report
        </button>
      </div>
    </header>

    <div class="content">

      <!-- DASHBOARD SECTION -->
      <section id="sectionDash" class="page-section active">

        <!-- Barangay Rep banner (hidden for admin) -->
        <div id="repDashBanner" style="display:none;background:linear-gradient(135deg,var(--blue) 0%,#134ea0 100%);border-radius:14px;padding:20px 26px;margin-bottom:22px;align-items:center;justify-content:space-between;gap:16px;">
          <div style="display:flex;align-items:center;gap:14px;">
            <div style="font-size:36px;">🏘️</div>
            <div>
              <div id="repBannerBrgyName" style="font-size:20px;font-weight:bold;color:#fff;"></div>
              <div style="font-size:13px;color:rgba(255,255,255,0.75);margin-top:2px;">Barangay Rep Dashboard — Sapian, Capiz</div>
            </div>
          </div>
          <button class="top-btn" onclick="switchTab('ingest')" style="background:rgba(255,255,255,0.15);border-color:rgba(255,255,255,0.4);color:#fff;font-size:13px;">➕ Submit Project</button>
        </div>

        <div class="stats-grid" style="grid-template-columns:repeat(5,1fr);">
          <div class="stat-card" style="--accent:var(--blue);">
            <div class="stat-top"><span class="stat-icon">📑</span><span class="stat-trend" style="background:rgba(24,97,191,0.1);color:var(--blue);">All</span></div>
            <div class="stat-value" id="statTotalEntries">0</div>
            <div class="stat-label" id="statTotalLabel">Total Projects</div>
          </div>
          <div class="stat-card clickable" style="--accent:var(--green);" onclick="openStatusModal('Completed')" title="Click to see completed projects">
            <div class="stat-top"><span class="stat-icon">✅</span><span class="stat-trend">Done</span></div>
            <div class="stat-value" id="statCompleted">0</div>
            <div class="stat-label">Completed</div>
            <div class="stat-hint">Click to view projects →</div>
          </div>
          <div class="stat-card clickable" style="--accent:var(--orange);" onclick="openStatusModal('Ongoing')" title="Click to see ongoing projects">
            <div class="stat-top"><span class="stat-icon">⏳</span><span class="stat-trend" style="background:rgba(230,126,34,0.1);color:var(--orange);">Active</span></div>
            <div class="stat-value" id="statOngoing">0</div>
            <div class="stat-label">Ongoing</div>
            <div class="stat-hint">Click to view projects →</div>
          </div>
          <div class="stat-card clickable" style="--accent:var(--red);" onclick="openStatusModal('Not Yet Started')" title="Click to see not yet started projects">
            <div class="stat-top"><span class="stat-icon">⚠️</span><span class="stat-trend" style="background:rgba(221,88,76,0.1);color:var(--red);">Queued</span></div>
            <div class="stat-value" id="statNotStarted">0</div>
            <div class="stat-label">Not Yet Started</div>
            <div class="stat-hint">Click to view projects →</div>
          </div>
          <div class="stat-card clickable" id="pendingStatCard" style="--accent:#7c3aed;display:none;" onclick="switchTab('pending')" title="Click to review pending projects">
            <div class="stat-top"><span class="stat-icon">🕐</span><span class="stat-trend" style="background:rgba(124,58,237,0.1);color:#7c3aed;">New</span></div>
            <div class="stat-value" id="statPending" style="color:#7c3aed;">0</div>
            <div class="stat-label" style="color:#7c3aed;">Pending Review</div>
            <div class="stat-hint" style="color:#7c3aed;">Click to review →</div>
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <div class="card-title" id="dashTableTitle">📋 All Projects</div>
            <div class="card-action" id="dashBrowseLink" onclick="switchTab('workspace')">Browse by Barangay</div>
          </div>
          <div class="card-body" style="padding-bottom:8px;">
            <div class="search-bar-row">
              <div class="search-input-wrap">
                <input type="text" class="search-input" id="dashSearchInput" placeholder="Search by project name, code, barangay, location, or status..." onkeydown="if(event.key==='Enter') searchDashProjects()">
              </div>
              <button class="search-btn" onclick="searchDashProjects()">🔍 Search</button>
            </div>
          </div>
          <div class="card-body" style="padding-top:0;">
            <div id="dashTableBoard">
              <div class="dash-block" style="--accent:var(--green);">
                <div class="dash-block-header"><span>✅ Completed</span><span class="dash-kanban-count" id="dashColCount_Completed">0</span></div>
                <div class="dash-block-scroll"><table class="project-table"><thead id="dashHead_Completed"></thead><tbody id="dashBody_Completed"></tbody></table></div>
              </div>
              <div class="dash-block" style="--accent:var(--orange);">
                <div class="dash-block-header"><span>⏳ Ongoing</span><span class="dash-kanban-count" id="dashColCount_Ongoing">0</span></div>
                <div class="dash-block-scroll"><table class="project-table"><thead id="dashHead_Ongoing"></thead><tbody id="dashBody_Ongoing"></tbody></table></div>
              </div>
              <div class="dash-block" style="--accent:var(--red);">
                <div class="dash-block-header"><span>🕓 Not Yet Started</span><span class="dash-kanban-count" id="dashColCount_NotStarted">0</span></div>
                <div class="dash-block-scroll"><table class="project-table"><thead id="dashHead_NotStarted"></thead><tbody id="dashBody_NotStarted"></tbody></table></div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- PENDING REVIEWS SECTION (Admin Only) -->
      <section id="sectionPending" class="page-section">
        <div class="card" style="margin-bottom:20px;border-top:4px solid #7c3aed;">
          <div class="card-header" style="background:linear-gradient(135deg,rgba(124,58,237,0.06) 0%,#fafbfc 100%);">
            <div class="card-title" style="color:#7c3aed;">🕐 Pending Project Reviews <span id="pendingReviewCount" style="background:rgba(124,58,237,0.12);color:#7c3aed;font-size:12px;padding:3px 10px;border-radius:10px;margin-left:8px;font-weight:bold;">0</span></div>
            <div style="font-size:13px;color:var(--gray);font-style:italic;">These projects were submitted by Barangay Reps and are awaiting your review. Confirm or reject each one.</div>
          </div>
          <div class="card-body" style="padding-bottom:8px;">
            <div class="search-bar-row">
              <div class="search-input-wrap">
                <input type="text" class="search-input" id="pendingSearchInput" placeholder="Search pending projects by name, code, or barangay..." onkeydown="if(event.key==='Enter') renderPendingTable()">
              </div>
              <button class="search-btn" onclick="renderPendingTable()">🔍 Search</button>
            </div>
          </div>
          <div class="card-body" style="padding:0;overflow-x:auto;">
            <table class="project-table" id="pendingReviewTable">
              <thead id="pendingReviewHead"></thead>
              <tbody id="pendingReviewBody"></tbody>
            </table>
          </div>
        </div>
      </section>

      <!-- WORKSPACE SECTION -->
      <section id="sectionWorkspace" class="page-section">
        <div class="card" style="margin-bottom:20px;">
          <div class="card-header"><div class="card-title" id="workspaceCardTitle">📂 Barangay Folders</div></div>
          <div class="card-body">
            <div class="brgy-grid" id="workspaceBrgyGrid"></div>
          </div>
        </div>
      </section>

      <!-- ADD/EDIT PROJECT SECTION -->
      <section id="sectionIngest" class="page-section">
        <div style="max-width:800px;margin:0 auto;">
          <div class="card">
            <div class="card-header">
              <div class="card-title" id="ingestFormHeaderTitle">📥 Add New Project</div>
            </div>
            <div class="card-body">
              <input type="hidden" id="ingestEditIndex" value="-1">
              <div class="review-banner" id="ingestReviewBanner"></div>
              <div class="form-row">
                <div class="dash-form-group">
                  <label class="dash-form-label">Project Code</label>
                  <input type="text" class="dash-form-input" id="ingestSerial" placeholder="e.g., PROJ2026-001">
                </div>
                <div class="dash-form-group">
                  <label class="dash-form-label">Barangay</label>
                  <select class="dash-form-select" id="ingestBarangay"></select>
                </div>
              </div>
              <div class="dash-form-group">
                <label class="dash-form-label">Project Name</label>
                <input type="text" class="dash-form-input" id="ingestTitle" placeholder="Enter project name...">
              </div>
              <div class="dash-form-group">
                <label class="dash-form-label">Location</label>
                <input type="text" class="dash-form-input" id="ingestLocation" placeholder="e.g., Sitio, Barangay, Sapian, Capiz">
              </div>
              <div class="dash-form-group">
                <label class="dash-form-label">Project Type</label>
                <select class="dash-form-select" id="ingestCategory">
                  <option value="Infrastructure">Infrastructure</option>
                </select>
              </div>
              <div class="dash-form-group" id="descSimpleGroup">
                <label class="dash-form-label">Project Description</label>
                <textarea class="dash-form-textarea" id="ingestDesc" placeholder="Brief description of the project..."></textarea>
              </div>
              <div class="dash-form-group" id="descExpenseGroup" style="display:none;">
              
                <div style="border:1.5px solid rgba(84,93,104,0.2);border-radius:10px;overflow:hidden;">
                  <table style="width:100%;border-collapse:collapse;">
                    <thead>
                      <tr style="background:var(--bg);">
                        <th style="text-align:left;padding:10px 12px;font-size:12px;color:var(--gray);text-transform:uppercase;letter-spacing:0.5px;">Expense Item / Description</th>
                        <th style="text-align:left;padding:10px 12px;font-size:12px;color:var(--gray);text-transform:uppercase;letter-spacing:0.5px;width:170px;">Amount (₱)</th>
                        <th style="width:40px;"></th>
                      </tr>
                    </thead>
                    <tbody id="expenseItemsBody"></tbody>
                    <tfoot>
                      <tr style="background:rgba(11,170,65,0.05);border-top:2px solid rgba(84,93,104,0.15);">
                        <td style="padding:10px 12px;font-weight:bold;text-align:right;">Total Expenses</td>
                        <td style="padding:10px 12px;font-weight:bold;color:var(--green);" id="expenseTotalDisplay">₱ 0.00</td>
                        <td></td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <button type="button" onclick="addExpenseRow()" style="margin-top:10px;padding:8px 14px;font-size:13px;font-weight:bold;border:2px dashed var(--blue);color:var(--blue);background:#f0f5fa;border-radius:8px;cursor:pointer;">+ Add Expense Item</button>
                <div style="font-size:11px;color:var(--gray);margin-top:6px;">Total Cost above is calculated automatically from this list.</div>
              </div>
              <div style="margin-bottom:18px;padding:16px 18px;background:rgba(11,170,65,0.04);border:1.5px solid rgba(11,170,65,0.18);border-radius:10px;">
                <div style="font-size:12px;font-weight:bold;color:var(--green);letter-spacing:1px;text-transform:uppercase;margin-bottom:14px;">💰 Budget & Implementation</div>
                <div class="form-row" style="margin-bottom:14px;">
                  <div class="dash-form-group" style="margin-bottom:0;">
                    <label class="dash-form-label">Total Cost (₱)</label>
                    <input type="number" class="dash-form-input" id="ingestCost" placeholder="0.00" min="0" step="0.01" oninput="recalcRemainingBalance()">
                  </div>
                  <div class="dash-form-group" style="margin-bottom:0;">
                    <label class="dash-form-label">Allocated Budget (₱)</label>
                    <input type="number" class="dash-form-input" id="ingestAllocatedBudget" placeholder="0.00" min="0" step="0.01" oninput="recalcRemainingBalance()">
                  </div>
                </div>
                <div class="form-row" style="margin-bottom:14px;">
                  <div class="dash-form-group" style="margin-bottom:0;">
                    <label class="dash-form-label">Mode of Implementation</label>
                    <select class="dash-form-select" id="ingestMode">
                      <option value="">Select mode...</option>
                      <option value="Admin">Admin</option>
                      <option value="Contract">Contract</option>
                    </select>
                  </div>
                  <div class="dash-form-group" style="margin-bottom:0;">
                    <label class="dash-form-label">Remaining Balance (₱)</label>
                    <div id="remainingBalanceDisplay" style="padding:12px 14px;background:var(--white);border:2px solid rgba(84,93,104,0.2);border-radius:8px;font-size:14px;font-weight:bold;color:#111822;min-height:46px;display:flex;align-items:center;gap:8px;">
                      <span id="remainingBalanceIcon">—</span>
                      <span id="remainingBalanceValue" style="flex:1;">Enter values above</span>
                    </div>
                  </div>
                </div>
                <div class="form-row" style="margin-top:14px;">
                  <div class="dash-form-group" style="margin-bottom:0;">
                    <label class="dash-form-label">Amount Utilized (₱)</label>
                    <input type="number" class="dash-form-input" id="ingestUtilized" placeholder="0.00" min="0" step="0.01">
                    <div style="font-size:11px;color:var(--gray);margin-top:6px;">Amount spent so far. Cannot be more than the Total Cost.</div>
                  </div>
                </div>
              </div>
              <div style="margin-bottom:18px;padding:16px 18px;background:rgba(24,97,191,0.04);border:1.5px solid rgba(24,97,191,0.15);border-radius:10px;">
                <div style="font-size:12px;font-weight:bold;color:var(--blue);letter-spacing:1px;text-transform:uppercase;margin-bottom:14px;">📈 Status & Timeframe</div>
                <div class="form-row" style="margin-bottom:14px;">
                  <div class="dash-form-group" style="margin-bottom:0;" id="statusFieldGroup">
                    <label class="dash-form-label">Project Status</label>
                    <select class="dash-form-select" id="ingestStatus" onchange="onIngestStatusChange(false)">
                      <option value="Not Yet Started">Not Yet Started</option>
                      <option value="Ongoing">Ongoing</option>
                      <option value="Completed">Completed</option>
                    </select>
                  </div>
                  <div class="dash-form-group" style="margin-bottom:0;">
                    <label class="dash-form-label">Progress (%)</label>
                    <input type="number" class="dash-form-input" id="ingestProgress" min="1" max="99" step="1" placeholder="0 (automatic)">
                  </div>
                </div>
                <div class="form-row" style="margin-bottom:14px;">
                  <div class="dash-form-group" style="margin-bottom:0;">
                    <label class="dash-form-label">Date Started</label>
                    <input type="date" class="dash-form-input" id="ingestStartDate">
                  </div>
                  <div class="dash-form-group" style="margin-bottom:0;">
                    <label class="dash-form-label">Target Date of Completion</label>
                    <input type="date" class="dash-form-input" id="ingestTargetDate">
                  </div>
                </div>
                <div class="form-row">
                  <div class="dash-form-group" style="margin-bottom:0;">
                    <label class="dash-form-label">Date Completed</label>
                    <input type="date" class="dash-form-input" id="ingestDateCompleted">
                  </div>
                  <div class="dash-form-group" style="margin-bottom:0;">
                    <label class="dash-form-label">Remarks</label>
                    <input type="text" class="dash-form-input" id="ingestRemarks" placeholder="e.g., Awaiting procurement">
                  </div>
                </div>
              </div>
              <div class="dash-form-group">
                <label class="dash-form-label">Project Photos (one or more)</label>
                <label class="photo-drop">
                  <input type="file" id="ingestFile" accept="image/*" multiple onchange="handlePhotoSelect(event)" style="display:none;">
                  <span>📸 Choose Photos</span>
                </label>
                <div style="font-size:11px;color:var(--gray);margin-top:6px;" id="ingestPhotoCount">No photos attached yet.</div>
                <div class="photo-grid" id="ingestPhotoGrid"></div>
              </div>
              <div style="display:flex;justify-content:flex-end;gap:12px;margin-top:15px;padding-top:15px;border-top:1px solid rgba(84,93,104,0.15);">
                <button class="btn-cancel" onclick="clearIngestForm()">Clear</button>
                <button class="btn-submit" id="ingestSubmitBtn" onclick="submitProjectForm()">Save Project</button>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ACCOUNTS SECTION (Admin Only) -->
      <section id="sectionAccounts" class="page-section">
        <div class="card">
          <div class="card-header">
            <div class="card-title">👥 Manage Accounts</div>
            <button class="top-btn primary" id="addUserBtn" style="padding:6px 12px;font-size:13px;" onclick="openAddUserModal()">➕ Add New User</button>
          </div>
          <div class="card-body" style="padding-bottom:10px;">
            <div class="search-bar-row">
              <div class="search-input-wrap">
                <input type="text" class="search-input" id="accountSearchInput" placeholder="Search accounts by name or barangay..." onkeydown="if(event.key==='Enter') searchAccounts()">
              </div>
              <button class="search-btn" onclick="searchAccounts()">🔍 Search</button>
            </div>
          </div>
          <div class="card-body" style="padding:0;overflow-x:auto;">
            <table class="project-table" id="accountsTable">
              <thead><tr>
                <th>ID</th>
                <th>Name</th>
                <th>Role</th>
                <th>Barangay</th>
                <th>Date Added</th>
                <th>Status</th>
                <th style="text-align:right;">Actions</th>
              </tr></thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </section>

    </div>
  </main>
</div>

<!-- ADD USER MODAL -->
<div class="modal-overlay" id="addUserModal">
  <div class="modal-box">
    <div class="modal-box-header">➕ Add New User</div>
    <div class="modal-box-body">
      <div class="dash-form-group">
        <label class="dash-form-label">Full Name</label>
        <input type="text" class="dash-form-input" id="newUserName" placeholder="Enter full name...">
      </div>
      <div class="dash-form-group">
        <label class="dash-form-label">Role</label>
        <select class="dash-form-select" id="newUserRole" onchange="handleNewUserRoleChange()">
          <option value="Barangay Reporter">Barangay Rep</option>
          <option value="DILG Admin">DILG Admin</option>
        </select>
      </div>
      <div class="dash-form-group" id="newUserBrgyGroup">
        <label class="dash-form-label">Assigned Barangay</label>
        <input type="text" class="dash-form-input" id="newUserBrgy" list="newUserBrgyList" placeholder="Type the barangay name..." autocomplete="off" maxlength="100">
        <datalist id="newUserBrgyList"></datalist>
        <div style="font-size:12px;color:var(--gray);margin-top:4px;">A barangay folder with this name is created automatically.</div>
      </div>
      <div class="form-row">
        <div class="dash-form-group">
          <label class="dash-form-label">Password</label>
          <input type="password" class="dash-form-input" id="newUserPassword" placeholder="At least 6 characters">
        </div>
        <div class="dash-form-group">
          <label class="dash-form-label">Confirm Password</label>
          <input type="password" class="dash-form-input" id="newUserPasswordConfirm" placeholder="Re-enter password">
        </div>
      </div>
    </div>
    <div class="modal-box-footer">
      <button class="btn-cancel" onclick="document.getElementById('addUserModal').style.display='none'">Cancel</button>
      <button class="btn-submit" onclick="submitNewUser()">Add User</button>
    </div>
  </div>
</div>

<!-- FOLDER CONTENTS MODAL -->
<div class="status-modal-overlay" id="folderModal" onclick="closeFolderModal(event)" style="z-index:500;">
  <div class="status-modal-box">
    <div class="status-modal-header" id="folderModalHeader" style="background:var(--blue);">
      <span id="folderModalTitle">📁 Barangay Projects</span>
      <button class="close-modal-btn" onclick="closeFolderModalBtn()">✕</button>
    </div>
    <div class="status-modal-body">
      <div class="search-bar-row">
        <div class="search-input-wrap">
          <input type="text" class="search-input" id="folderModalSearch" placeholder="Search by project title, code, location, or status..." onkeydown="if(event.key==='Enter') searchFolderModal()">
        </div>
        <button class="search-btn" onclick="searchFolderModal()">🔍 Search</button>
      </div>
      <div id="folderModalCount" style="font-size:13px;color:var(--gray);font-weight:bold;margin-bottom:12px;"></div>
      <div style="overflow-x:auto;">
        <table class="project-table" id="folderModalTable">
          <thead id="folderModalHead"></thead>
          <tbody id="folderModalBody"></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- STATUS MODAL (Clickable dashboard cards) -->
<div class="status-modal-overlay" id="statusModal" style="z-index:500;">
  <div class="status-modal-box">
    <div class="status-modal-header" id="statusModalHeader">
      <span id="statusModalTitle">Projects</span>
      <button class="close-modal-btn" onclick="closeStatusModal()">✕</button>
    </div>
    <div class="status-modal-body">
      <div class="search-bar-row">
        <div class="search-input-wrap">
          <input type="text" class="search-input" id="statusModalSearch" placeholder="Search these projects..." onkeydown="if(event.key==='Enter') filterStatusModal()">
        </div>
        <button class="search-btn" onclick="filterStatusModal()">🔍 Search</button>
      </div>
      <div id="statusModalCount" style="font-size:13px;color:var(--gray);font-weight:bold;margin-bottom:12px;"></div>
      <div style="overflow-x:auto;">
        <table class="project-table" id="statusModalTable">
          <thead id="statusModalHead"></thead>
          <tbody id="statusModalBody"></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- PRINT PREVIEW MODAL -->
<div id="printModal">
  <div class="print-modal-shell">
    <div class="print-modal-topbar">
      <h2>🖨️ Print Report — Preview & Settings</h2>
      <div class="print-modal-topbar-actions">
        <button class="pm-top-btn print-go" onclick="executePrint()">🖨️ Print Now</button>
        <button class="pm-close-btn" onclick="closePrintModal()">✕</button>
      </div>
    </div>
    <div class="print-modal-body">

      <!-- LEFT: CONTROLS -->
      <div class="pm-controls">

        <!-- Paper Size -->
        <div class="pm-ctrl-section">
          <div class="pm-ctrl-section-hd">📄 Paper Size</div>
          <div class="pm-ctrl-section-body">
            <div class="pm-paper-btns">
              <button class="pm-paper-btn active" id="paperA4" onclick="setPaper('A4')">A4</button>
              <button class="pm-paper-btn" id="paperLetter" onclick="setPaper('Letter')">Letter</button>
              <button class="pm-paper-btn" id="paperLegal" onclick="setPaper('Legal')">Legal</button>
            </div>
            <div style="font-size:11px;color:var(--gray);text-align:center;" id="paperDimLabel">A4 — 210 × 297 mm</div>
          </div>
        </div>

        <!-- Print Filters -->
        <div class="pm-ctrl-section">
          <div class="pm-ctrl-section-hd">🧮 Filter What Gets Printed</div>
          <div class="pm-ctrl-section-body" style="gap:16px;">

            <div class="pm-filter-group">
              <div class="pm-filter-group-title">🚦 Status</div>
              <input type="text" class="pm-ctrl-input" id="pmFilterSearch_status" placeholder="Search status..." oninput="filterGroupSearch('status')">
              <div style="display:flex;gap:8px;margin:6px 0;">
                <button type="button" class="pm-fmt-btn" style="flex:1;font-size:11px;" onclick="setAllInGroup('status',true)">Select All</button>
                <button type="button" class="pm-fmt-btn" style="flex:1;font-size:11px;" onclick="setAllInGroup('status',false)">Clear All</button>
              </div>
              <div id="pmFilterList_status" class="pm-filter-list"></div>
            </div>

            <div class="pm-filter-group" id="pmBarangayFilterGroup">
              <div class="pm-filter-group-title">📍 Barangay</div>
              <input type="text" class="pm-ctrl-input" id="pmFilterSearch_barangay" placeholder="Search barangay..." oninput="filterGroupSearch('barangay')">
              <div style="display:flex;gap:8px;margin:6px 0;">
                <button type="button" class="pm-fmt-btn" style="flex:1;font-size:11px;" onclick="setAllInGroup('barangay',true)">Select All</button>
                <button type="button" class="pm-fmt-btn" style="flex:1;font-size:11px;" onclick="setAllInGroup('barangay',false)">Clear All</button>
              </div>
              <div id="pmFilterList_barangay" class="pm-filter-list"></div>
            </div>

            <div class="pm-filter-group">
              <div class="pm-filter-group-title">📅 Target Month</div>
              <input type="text" class="pm-ctrl-input" id="pmFilterSearch_month" placeholder="Search month..." oninput="filterGroupSearch('month')">
              <div style="display:flex;gap:8px;margin:6px 0;">
                <button type="button" class="pm-fmt-btn" style="flex:1;font-size:11px;" onclick="setAllInGroup('month',true)">Select All</button>
                <button type="button" class="pm-fmt-btn" style="flex:1;font-size:11px;" onclick="setAllInGroup('month',false)">Clear All</button>
              </div>
              <div id="pmFilterList_month" class="pm-filter-list"></div>
            </div>

            <div class="pm-filter-group">
              <div class="pm-filter-group-title">📦 Project Type</div>
              <input type="text" class="pm-ctrl-input" id="pmFilterSearch_category" placeholder="Search project type..." oninput="filterGroupSearch('category')">
              <div style="display:flex;gap:8px;margin:6px 0;">
                <button type="button" class="pm-fmt-btn" style="flex:1;font-size:11px;" onclick="setAllInGroup('category',true)">Select All</button>
                <button type="button" class="pm-fmt-btn" style="flex:1;font-size:11px;" onclick="setAllInGroup('category',false)">Clear All</button>
              </div>
              <div id="pmFilterList_category" class="pm-filter-list"></div>
            </div>

            <div style="font-size:11px;color:var(--gray);">Only items matching every checked filter above are included in the printed report.</div>
          </div>
        </div>

        <!-- Font Settings -->
        <div class="pm-ctrl-section">
          <div class="pm-ctrl-section-hd">🔤 Font Settings</div>
          <div class="pm-ctrl-section-body">
            <div>
              <label class="pm-ctrl-label">Font Style</label>
              <select class="pm-ctrl-select" id="pmFontFamily" onchange="updatePreview()">
                <option value="Arial, Helvetica, sans-serif">Arial</option>
                <option value="'Times New Roman', Times, serif">Times New Roman</option>
                <option value="Georgia, serif">Georgia</option>
                <option value="'Courier New', Courier, monospace">Courier New</option>
                <option value="Verdana, Geneva, sans-serif">Verdana</option>
                <option value="Tahoma, Geneva, sans-serif">Tahoma</option>
                <option value="'Trebuchet MS', sans-serif">Trebuchet MS</option>
              </select>
            </div>
            <div>
              <label class="pm-ctrl-label">Body Font Size</label>
              <div class="pm-range-row">
                <input type="range" id="pmFontSize" min="8" max="16" value="11" oninput="updatePreview(); document.getElementById('pmFontSizeVal').textContent=this.value+'pt'">
                <span class="pm-range-val" id="pmFontSizeVal">11pt</span>
              </div>
            </div>
            <div>
              <label class="pm-ctrl-label">Header Font Size</label>
              <div class="pm-range-row">
                <input type="range" id="pmHeaderSize" min="12" max="26" value="18" oninput="updatePreview(); document.getElementById('pmHeaderSizeVal').textContent=this.value+'pt'">
                <span class="pm-range-val" id="pmHeaderSizeVal">18pt</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Margins -->
        <div class="pm-ctrl-section">
          <div class="pm-ctrl-section-hd">📐 Margins (mm)</div>
          <div class="pm-ctrl-section-body">
            <div class="pm-margin-grid">
              <div class="pm-margin-item">
                <label>Top</label>
                <input type="number" id="pmMarginTop" value="20" min="5" max="50" oninput="updatePreview()">
              </div>
              <div class="pm-margin-item">
                <label>Bottom</label>
                <input type="number" id="pmMarginBottom" value="20" min="5" max="50" oninput="updatePreview()">
              </div>
              <div class="pm-margin-item">
                <label>Left</label>
                <input type="number" id="pmMarginLeft" value="20" min="5" max="50" oninput="updatePreview()">
              </div>
              <div class="pm-margin-item">
                <label>Right</label>
                <input type="number" id="pmMarginRight" value="20" min="5" max="50" oninput="updatePreview()">
              </div>
            </div>
          </div>
        </div>

        <!-- Report Photo -->
        <div class="pm-ctrl-section">
          <div class="pm-ctrl-section-hd">🖼️ Report Header Photo</div>
          <div class="pm-ctrl-section-body">
            <label class="pm-photo-upload-area" id="pmPhotoUploadArea">
              <input type="file" accept="image/*" id="pmPhotoInput" style="display:none;" onchange="handlePrintPhoto(event)">
              <div id="pmPhotoPlaceholder">
                <div style="font-size:28px;margin-bottom:6px;">📷</div>
                <div style="font-size:12px;color:var(--gray);font-weight:bold;">Click to upload photo</div>
                <div style="font-size:11px;color:var(--gray);margin-top:2px;">Shown below the header</div>
              </div>
              <img id="pmPhotoPreviewImg" class="pm-photo-preview" style="display:none;" alt="Report photo">
            </label>
            <span class="pm-remove-photo" id="pmRemovePhotoBtn" style="display:none;" onclick="removePrintPhoto()">✕ Remove Photo</span>
          </div>
        </div>

        <!-- Report Title -->
        <div class="pm-ctrl-section">
          <div class="pm-ctrl-section-hd">✏️ Report Title</div>
          <div class="pm-ctrl-section-body">
            <input type="text" class="pm-ctrl-input" id="pmReportTitle" placeholder="e.g., Project Status Report" oninput="updatePreview()">
            <input type="text" class="pm-ctrl-input" id="pmReportSubtitle" placeholder="e.g., Sapian, Capiz — 2026" oninput="updatePreview()">
          </div>
        </div>

      </div><!-- end pm-controls -->

      <!-- RIGHT: EDITABLE DOCUMENT -->
      <div class="pm-preview-wrap">
        <div style="width:100%;display:flex;flex-direction:column;align-items:center;gap:10px;">
          <div style="display:flex;gap:8px;align-items:center;background:#fff;border-radius:10px;padding:8px 14px;border:1.5px solid rgba(84,93,104,0.15);box-shadow:0 2px 8px rgba(0,0,0,0.05);flex-wrap:wrap;">
            <span style="font-size:12px;font-weight:bold;color:var(--gray);letter-spacing:0.5px;text-transform:uppercase;margin-right:4px;">Format:</span>
            <button class="pm-fmt-btn" onclick="fmtDoc('bold')" title="Bold"><b>B</b></button>
            <button class="pm-fmt-btn" onclick="fmtDoc('italic')" title="Italic"><i>I</i></button>
            <button class="pm-fmt-btn" onclick="fmtDoc('underline')" title="Underline"><u>U</u></button>
            <div style="width:1px;height:22px;background:rgba(84,93,104,0.2);margin:0 4px;"></div>
            <button class="pm-fmt-btn" onclick="fmtDoc('justifyLeft')" title="Align Left">⬅</button>
            <button class="pm-fmt-btn" onclick="fmtDoc('justifyCenter')" title="Center">☰</button>
            <button class="pm-fmt-btn" onclick="fmtDoc('justifyRight')" title="Align Right">➡</button>
            <div style="width:1px;height:22px;background:rgba(84,93,104,0.2);margin:0 4px;"></div>
            <button class="pm-fmt-btn" onclick="fmtDoc('insertUnorderedList')" title="Bullet List">• List</button>
            <button class="pm-fmt-btn" onclick="fmtDoc('insertOrderedList')" title="Numbered List">1. List</button>
            <div style="width:1px;height:22px;background:rgba(84,93,104,0.2);margin:0 4px;"></div>
            <button class="pm-fmt-btn" onclick="fmtDoc('undo')" title="Undo">↩</button>
            <button class="pm-fmt-btn" onclick="fmtDoc('redo')" title="Redo">↪</button>
            <div style="width:1px;height:22px;background:rgba(84,93,104,0.2);margin:0 4px;"></div>
            <button class="pm-fmt-btn" style="color:var(--blue);font-size:11px;padding:4px 8px;" onclick="reloadDocContent()" title="Reload from data">🔄 Reload Data</button>
          </div>
          <div class="pm-page" id="pmPageEl">
            <div id="pmDocContent" contenteditable="true" spellcheck="false"
              style="outline:none;min-height:100%;cursor:text;"
              onkeydown="handleDocKeydown(event)">
            </div>
          </div>
          <div style="font-size:11px;color:#888;text-align:center;">Click anywhere on the document to edit freely. Use the toolbar above to format text.</div>
        </div>
      </div>

    </div><!-- end print-modal-body -->
  </div>
</div>

<!-- PROJECT DETAILS MODAL (opens from any project row; includes photos) -->
<div class="modal-overlay" id="publicReceiptModal" onclick="if(event.target===this) closePublicReceipt()">
  <div class="receipt-box">
    <div class="receipt-header">
      <div class="receipt-seal">🏛️</div>
      <div class="receipt-header-title">DILG SAPIAN, CAPIZ</div>
      <div class="receipt-header-sub">Project Details</div>
    </div>
    <div class="receipt-divider"></div>
    <div class="receipt-body" id="receiptBody"></div>
    <div class="receipt-divider"></div>
    <div class="receipt-footer">
      <div class="receipt-footer-note">This is a system-generated project record. · dilg_pms</div>
      <div class="receipt-print-note" style="display:none;">Printed: <span id="receiptPrintDate"></span></div>
      <div class="receipt-actions" style="display:flex;gap:10px;flex-wrap:wrap;justify-content:center;">
        <button class="top-btn primary" id="receiptEditBtn" onclick="editFromDetails()" style="display:none;">✏️ Edit</button>
        <select id="receiptPaper" class="top-btn" title="Paper size for printing" style="padding:8px 10px;"><option value="A4">A4</option><option value="Letter">Letter</option><option value="Legal">Legal</option></select>
        <button class="top-btn" onclick="printPublicReceipt()">🖨️ Print (1 page)</button>
        <button class="top-btn" onclick="closePublicReceipt()">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- PHOTO LIGHTBOX -->
<div class="modal-overlay" id="photoLightbox" onclick="if(event.target===this) closeLightbox()">
  <img id="lightboxImg" alt="Project photo">
  <div class="lb-controls">
    <button class="lb-nav" onclick="stepLightbox(-1)" title="Previous">◀</button>
    <span id="lightboxCounter"></span>
    <button class="lb-nav" onclick="stepLightbox(1)" title="Next">▶</button>
    <button onclick="closeLightbox()" title="Close">✕</button>
  </div>
</div>

<!-- Hidden iframe for clean printing -->
<iframe id="printOutputFrame" style="display:none;position:fixed;inset:0;width:100%;height:100%;border:none;" title="Print Frame"></iframe>

<script>
  /* TOAST */
  function showToast(message, isError = false) {
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.className = 'toast' + (isError ? ' toast-error' : '');
    toast.innerHTML = `<span class="toast-icon">${isError ? '⚠️' : '✅'}</span><span class="toast-text">${message}</span><button class="toast-close" onclick="this.closest('.toast').remove()">×</button>`;
    container.appendChild(toast);
    setTimeout(() => {
      toast.style.animation = 'toastOut 0.3s ease forwards';
      setTimeout(() => toast.remove(), 300);
    }, 4000);
  }

  /* DATA */
  // Barangay folders are not fixed: one is created automatically for every barangay typed in Add New User.
  let barangayFolders = [];

  const DEFAULT_ACCOUNTS = [];

  function apiSync(action, payload = {}) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'api/api.php?action=' + encodeURIComponent(action), false);
    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
    try {
      xhr.send(JSON.stringify(payload));
      const res = JSON.parse(xhr.responseText || '{}');
      if (!res.ok) throw new Error(res.message || 'Request failed');
      return res.data || {};
    } catch (e) {
      console.error(e);
      window.lastApiError = e.message;
      return null;
    }
  }

  function bootstrapData() {
    const data = apiSync('bootstrap');
    if (!data) {
      alert('Cannot connect to the PHP/MySQL backend. Make sure Apache and MySQL are running and schema.sql has been imported.');
      return {accounts:[], projects:[], user:null};
    }
    return data;
  }

  const boot = bootstrapData();
  let registeredAccounts = boot.accounts || [];
  barangayFolders = boot.folders || [];

  // Account changes go to the server one account at a time; the server answers with the fresh lists.
  function applyAccountsResult(res) {
    if (!res) return;
    if (Array.isArray(res.accounts)) registeredAccounts = res.accounts;
    if (Array.isArray(res.folders)) { barangayFolders = res.folders; if (typeof initDropdowns === 'function') initDropdowns(); }
  }

  /* ===== PROJECT HELPERS (v2) ===== */
  const STATUS_LIST = ['Completed', 'Ongoing', 'Not Yet Started'];
  const REVIEW_LIST = ['Pending', 'Confirmed', 'Rejected'];
  const MAX_PHOTOS = 10;
  const DASH_HTML = '<span class="muted-dash">—</span>';

  const esc = s => String(s == null ? '' : s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
  const fmtMoney = v => '₱ ' + (Number(v) || 0).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  function formatDisplayDate(d) {
    if (!d) return '';
    const dt = new Date(d + 'T00:00:00');
    return isNaN(dt) ? d : dt.toLocaleDateString('en-PH', { year: 'numeric', month: 'short', day: 'numeric' });
  }
  const statusClassOf = s => s === 'Completed' ? 'status-completed' : s === 'Not Yet Started' ? 'status-notstarted' : 'status-ongoing';
  const statusColorOf = s => s === 'Completed' ? 'var(--green)' : s === 'Not Yet Started' ? 'var(--red)' : 'var(--orange)';
  const statusBadge = s => `<span class="status-badge ${statusClassOf(s)}">${esc(s)}</span>`;
  const reviewOf = p => REVIEW_LIST.includes(p.reviewStatus) ? p.reviewStatus : 'Pending';
  function reviewBadge(p) {
    const r = reviewOf(p);
    const icon = r === 'Confirmed' ? '✔' : r === 'Rejected' ? '✖' : '🕐';
    return `<span class="review-badge review-${r.toLowerCase()}">${icon} ${r}</span>`;
  }
  function pctOf(p) {
    if (p.status === 'Completed') return 100;
    if (p.status === 'Not Yet Started') return 0;
    return Math.max(0, Math.min(100, Math.round(Number(p.progress) || 0)));
  }
  function pctBar(p) {
    const pct = pctOf(p);
    return `<div class="pct-wrap"><div class="pct-track"><div class="pct-fill" style="width:${pct}%;background:${statusColorOf(p.status)};"></div></div><span class="pct-label">${pct}%</span></div>`;
  }
  const photosOf = p => Array.isArray(p.photos) ? p.photos : [];

  /* Every table in the app is built from these column definitions, so the
     column order on each screen is set in one place (see *ColumnKeys below). */
  const COLUMN_DEFS = {
    brgy:      { label: 'Brgy',                      render: p => `<span class="brgy-chip">📍 ${esc(p.barangay)}</span>` },
    code:      { label: 'Project Code',              render: p => `<span class="code-cell">${esc(p.code)}</span>` },
    title:     { label: 'Project Title',             render: (p, o) => `<div class="title-cell"><strong>${esc(p.title)}</strong>${o.showReview ? `<div class="tc-sub">${reviewBadge(p)}</div>` : ''}${photosOf(p).length ? `<div class="tc-sub">📷 ${photosOf(p).length} photo(s)</div>` : ''}</div>` },
    pubtitle:  { label: 'Project Title',             render: p => `<div class="title-cell"><strong>${esc(p.title)}</strong><div class="tc-sub">📍 Barangay ${esc(p.barangay)} · ${esc(p.code)}</div></div>` },
    photos:    { label: 'Photos',                    render: p => { const ph = photosOf(p); return `<div class="thumb-box">${ph.length ? `<img src="${esc(ph[0])}" alt="">` : '<span style="font-size:22px;">📋</span>'}${ph.length > 1 ? `<span class="thumb-more">+${ph.length - 1}</span>` : ''}</div>`; } },
    started:   { label: 'Date Started',              render: p => p.startDate ? `<span class="date-cell">${esc(formatDisplayDate(p.startDate))}</span>` : DASH_HTML },
    target:    { label: 'Target Date of Completion', render: p => p.targetDate ? `<span class="date-cell">${esc(formatDisplayDate(p.targetDate))}</span>` : DASH_HTML },
    completed: { label: 'Date Completed',            render: p => p.dateCompleted ? `<span class="date-cell">${esc(formatDisplayDate(p.dateCompleted))}</span>` : DASH_HTML },
    cost:      { label: 'Cost',                      render: p => `<span class="money-cell">${fmtMoney(p.cost)}</span>` },
    utilized:  { label: 'Amount Utilized',           render: p => `<span class="money-cell" style="color:var(--green);">${fmtMoney(p.amountUtilized)}</span>` },
    status:    { label: 'Status (Percentage)',       render: p => `<div style="display:flex;flex-direction:column;gap:6px;min-width:140px;">${statusBadge(p.status)}${pctBar(p)}</div>` },
    location:  { label: 'Location',                  render: p => p.location ? `<span class="loc-cell">${esc(p.location)}</span>` : DASH_HTML, cls: 'loc-cell' },
    mode:      { label: 'Mode of Implementation',    render: p => p.modeOfImplementation ? `<span style="font-size:13px;font-weight:bold;">${esc(p.modeOfImplementation)}</span>` : DASH_HTML },
    remarks:   { label: 'Remarks',                   render: p => p.remarks ? esc(p.remarks) : DASH_HTML, cls: 'remarks-cell' }
  };

  function renderProjectTable(headEl, bodyEl, colKeys, list, opts = {}) {
    const cols = colKeys.map(k => COLUMN_DEFS[k]);
    const extra = opts.actions;
    headEl.innerHTML = '<tr>' + cols.map(c => `<th>${c.label}</th>`).join('') + (extra ? `<th style="text-align:right;">${esc(opts.actionsLabel || 'Actions')}</th>` : '') + '</tr>';
    if (!list.length) {
      bodyEl.innerHTML = `<tr><td colspan="${cols.length + (extra ? 1 : 0)}" class="table-empty">${esc(opts.emptyText || 'No projects found.')}</td></tr>`;
      return;
    }
    bodyEl.innerHTML = list.map(p =>
      `<tr data-pcode="${esc(p.code)}" title="Click to view details and photos">` +
      cols.map(c => `<td${c.cls ? ` class="${c.cls}"` : ''}>${c.render(p, opts)}</td>`).join('') +
      (extra ? `<td style="text-align:right;">${extra(p)}</td>` : '') + '</tr>'
    ).join('');
  }

  // One delegated handler makes every project row clickable (dashboard, folders, pending, public).
  document.addEventListener('click', e => {
    const row = e.target.closest('[data-pcode]');
    if (!row || e.target.closest('button, select, input, textarea, a, label')) return;
    openProjectDetails(row.dataset.pcode);
  });

  function loadProjects() { return boot.projects || []; }
  let masterProjectsDatabase = loadProjects();

  // Re-read accounts/projects from the server (what you can see depends on who is logged in).
  function refreshData() {
    const d = apiSync('bootstrap');
    if (d) {
      masterProjectsDatabase = d.projects || [];
      if (d.accounts) registeredAccounts = d.accounts;
      if (d.folders) barangayFolders = d.folders;
      if (typeof initDropdowns === 'function' && document.getElementById('ingestBarangay')) initDropdowns();
    }
  }

  let appState = {
    currentUser: null, activeTab: "dash",
    selectedFolder: null, publicBrgyFilter: "ALL",
    statusModalFilter: "", statusModalStatus: "",
    currentFolderBrgy: null
  };
  let activityLog = [];

  window.addEventListener('DOMContentLoaded', () => {
    if (boot.user) grantSession(boot.user);
    initDropdowns();
    pushLog("System started.", "system");
        renderPublicShowcase();
  });

  // A rep's own barangay must be selectable in the (locked) Barangay field even though reps are not sent the folder list.
  function ensureBrgyOption(v) {
    const sel = document.getElementById('ingestBarangay');
    if (v && ![...sel.options].some(o => o.value === v)) { const o = document.createElement('option'); o.value = v; o.textContent = v; sel.appendChild(o); }
  }

  function initDropdowns() {
    const ingestSel = document.getElementById('ingestBarangay');
    const hints = document.getElementById('newUserBrgyList'); // suggestions = folders that already exist
    const keep = ingestSel.value;
    ingestSel.innerHTML = ""; hints.innerHTML = "";
    barangayFolders.forEach(b => {
      let o = document.createElement('option'); o.value = b; o.textContent = b; ingestSel.appendChild(o);
      let h = document.createElement('option'); h.value = b; hints.appendChild(h);
    });
    if (keep && barangayFolders.includes(keep)) ingestSel.value = keep;
  }

  function pushLog(msg, actor) {
    const t = new Date().toLocaleTimeString();
    activityLog.unshift({ text: msg, actor, time: t });
    renderLogs();
  }

  function renderLogs() {
    // Activity log panel removed from dashboard
  }

  /* GATEWAY */
  function routeGateway(t) {
    ['defaultWelcomeCard','adminAuthCard','repAuthCard'].forEach(id => document.getElementById(id).style.display = 'none');
    if (t === 'admin') document.getElementById('adminAuthCard').style.display = 'block';
    else if (t === 'rep') document.getElementById('repAuthCard').style.display = 'block';
    else if (t === 'public') enterPublicPortal();
  }

  function resetGatewayHome() {
    ['adminAuthCard','repAuthCard'].forEach(id => document.getElementById(id).style.display = 'none');
    document.getElementById('defaultWelcomeCard').style.display = 'block';
    ['adminErrorMsg','repErrorMsg'].forEach(id => document.getElementById(id).classList.remove('show'));
  }

  function togglePass(id) { const i = document.getElementById(id); i.type = i.type === 'password' ? 'text' : 'password'; }

  function handleLogin(role) {
    const isAdmin = role === 'admin';
    const prefix = isAdmin ? 'admin' : 'rep';
    const u = document.getElementById(prefix + 'Username').value.trim();
    const p = document.getElementById(prefix + 'Password').value;
    const err = document.getElementById(prefix + 'ErrorMsg');
    err.classList.remove('show');
    const result = apiSync('login', {
      username: u,
      password: p,
      role: isAdmin ? 'DILG Admin' : 'Barangay Reporter'
    });
    if (result && result.user) {
      refreshData();
      grantSession(result.user);
    } else {
      err.textContent = 'Wrong username or password.';
      err.classList.add('show');
    }
  }

  function grantSession(acc) {
    appState.currentUser = acc;
    pushLog(`${acc.name} logged in.`, acc.role);
    document.getElementById('currentUserName').textContent = acc.name;
    document.getElementById('currentUserRole').textContent = acc.role + (acc.barangay !== '—' ? ` (${acc.barangay})` : '');
    document.getElementById('currentUserAvatar').textContent = acc.role === 'DILG Admin' ? "🛡️" : "👤";

    if (acc.role === 'DILG Admin') {
      document.getElementById('adminOnlyNavSection').style.display = 'block';
      document.getElementById('ingestFormHeaderTitle').textContent = "📥 Add New Project (Admin)";
      document.getElementById('printReportBtn').style.display = 'flex';
      document.getElementById('notifBellWrap').style.display = 'block';
      document.getElementById('navIngest').style.display = 'none';
      document.getElementById('navWorkspace').style.display = 'flex';
      document.getElementById('quickActionBtn').style.display = 'none';
      document.getElementById('repDashBanner').style.display = 'none';
      document.getElementById('dashTableTitle').textContent = '📋 All Projects (Confirmed)';
      document.getElementById('dashBrowseLink').style.display = '';
      document.getElementById('statusFieldGroup').style.display = 'block';
      document.getElementById('descSimpleGroup').style.display = 'block';
      document.getElementById('descExpenseGroup').style.display = 'none';
      document.getElementById('ingestCost').readOnly = false;
      document.getElementById('ingestCost').placeholder = '0.00';
    } else {
      document.getElementById('adminOnlyNavSection').style.display = 'none';
      document.getElementById('ingestFormHeaderTitle').textContent = `📥 Add Project — Barangay ${acc.barangay}`;
      document.getElementById('printReportBtn').style.display = 'flex';
      document.getElementById('notifBellWrap').style.display = 'none';
      closeNotifPanel();
      document.getElementById('navIngest').style.display = 'flex';
      document.getElementById('navWorkspace').style.display = 'flex';
      document.getElementById('quickActionBtn').style.display = 'flex';
      // Rep-specific dashboard customisations
      document.getElementById('repDashBanner').style.display = 'flex';
      document.getElementById('repBannerBrgyName').textContent = `Barangay ${acc.barangay}`;
      document.getElementById('dashTableTitle').textContent = `📋 My Submitted Projects — Barangay ${acc.barangay}`;
      document.getElementById('dashBrowseLink').style.display = 'none';
      document.getElementById('statusFieldGroup').style.display = 'block';
      document.getElementById('descSimpleGroup').style.display = 'none';
      document.getElementById('descExpenseGroup').style.display = 'block';
      document.getElementById('ingestCost').readOnly = true;
      document.getElementById('ingestCost').placeholder = 'Auto-calculated from expense list';
    }

    document.getElementById('gatewayPage').classList.add('hidden');
    document.getElementById('dashboardPage').classList.add('active');
    clearIngestForm();
    switchTab('dash');
    recalcDashboard();
    renderWorkspaceFolders();
  }

  function handleLogout() {
    if (!confirm("Log out now?")) return;
    apiSync("logout");
    refreshData();
    renderPublicShowcase();
    if (appState.currentUser) pushLog(`${appState.currentUser.name} logged out.`, "system");
    appState.currentUser = null;
    document.getElementById('dashboardPage').classList.remove('active');
    document.getElementById('publicViewPage').style.display = 'none';
    document.getElementById('gatewayPage').classList.remove('hidden');
    resetGatewayHome();
  }

  /* TAB SWITCHING */
  function switchTab(tab) {
    appState.activeTab = tab;
    document.querySelectorAll('.nav-item').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.page-section').forEach(el => el.classList.remove('active'));

    const isRep = appState.currentUser?.role === 'Barangay Reporter';
    const repBrgy = appState.currentUser?.barangay || '';
    const map = {
      dash:     { nav: 'navDash',      sec: 'sectionDash',     title: isRep ? `Barangay ${repBrgy} Dashboard` : 'Dashboard',         sub: isRep ? `Your submitted projects in Barangay ${repBrgy}` : 'Project overview and summary' },
      workspace:{ nav: 'navWorkspace', sec: 'sectionWorkspace', title: isRep ? 'My Project Files' : 'Barangay Files',                  sub: isRep ? `Barangay ${repBrgy} project records` : 'Browse projects by barangay' },
      ingest:   { nav: 'navIngest',    sec: 'sectionIngest',    title: 'Add / Edit Project',                                           sub: 'Submit a new project record' },
      pending:  { nav: 'navPending',   sec: 'sectionPending',   title: 'Pending Project Reviews',                                      sub: 'Review and set status for newly submitted projects' },
      accounts: { nav: 'navAccounts',  sec: 'sectionAccounts',  title: 'Manage Accounts',                                              sub: 'Add or manage user accounts' }
    };
    if (!map[tab]) return;
    const m = map[tab];
    document.getElementById(m.nav).classList.add('active');
    document.getElementById(m.sec).classList.add('active');
    document.getElementById('topbarTitle').textContent = m.title;
    document.getElementById('topbarSubtitle').textContent = m.sub;

    if (tab === 'dash') recalcDashboard();
    if (tab === 'workspace') renderWorkspaceFolders();
    if (tab === 'ingest') {
      if (appState.currentUser?.role === 'Barangay Reporter') {
        ensureBrgyOption(appState.currentUser.barangay); document.getElementById('ingestBarangay').value = appState.currentUser.barangay;
        document.getElementById('ingestBarangay').disabled = true;
      } else {
        document.getElementById('ingestBarangay').disabled = false;
      }
    }
    if (tab === 'pending') renderPendingTable();
    if (tab === 'accounts') renderAccountsTable();
  }

  /* DASHBOARD */
  // Projects shown on the dashboard: admin sees Confirmed projects only (new ones wait in
  // Pending Reviews); a barangay rep sees everything from their own barangay, with a review badge.
  function getDashList() {
    const u = appState.currentUser;
    if (!u) return [];
    if (u.role === 'DILG Admin') return masterProjectsDatabase.filter(p => reviewOf(p) === 'Confirmed');
    return masterProjectsDatabase.filter(p => p.barangay === u.barangay);
  }
  function getScopedList() { return getDashList(); }

  function recalcDashboard() {
    const list = getDashList();
    const isAdmin = appState.currentUser?.role === 'DILG Admin';
    const pendingCount = masterProjectsDatabase.filter(p => reviewOf(p) === 'Pending').length;

    document.getElementById('statTotalEntries').textContent = list.length;
    document.getElementById('statCompleted').textContent = list.filter(p => p.status === 'Completed').length;
    document.getElementById('statOngoing').textContent = list.filter(p => p.status === 'Ongoing').length;
    document.getElementById('statNotStarted').textContent = list.filter(p => p.status === 'Not Yet Started').length;

    const pendingCard = document.getElementById('pendingStatCard');
    const pendingBadge = document.getElementById('pendingNavBadge');
    if (isAdmin) {
      document.getElementById('statPending').textContent = pendingCount;
      pendingCard.style.display = 'block';
      if (pendingCount > 0) { pendingBadge.textContent = pendingCount; pendingBadge.style.display = 'inline-block'; }
      else pendingBadge.style.display = 'none';
    } else {
      pendingCard.style.display = 'none';
      if (pendingBadge) pendingBadge.style.display = 'none';
    }

    searchDashProjects();
    updateNotifBell();
  }

  function searchDashProjects() {
    const q = (document.getElementById('dashSearchInput').value || '').toLowerCase().trim();
    let list = getDashList();
    if (q) list = list.filter(p => [p.title, p.category, p.barangay, p.status, p.code, p.location].some(v => (v || '').toLowerCase().includes(q)));
    renderDashTable(list);
  }

  function dashColumnKeys(status, isAdmin) {
    if (status === 'Completed') return ['brgy','code','title','started','target','completed','cost','utilized','location'];
    if (status === 'Ongoing')   return ['brgy','code','title','started','target','cost','utilized','status','location'];
    return ['brgy','code','title','target','cost','utilized','remarks'];
  }

  function renderDashTable(list) {
    const isAdmin = appState.currentUser?.role === 'DILG Admin';
    const isRep = appState.currentUser?.role === 'Barangay Reporter';
    const idKey = { 'Completed': 'Completed', 'Ongoing': 'Ongoing', 'Not Yet Started': 'NotStarted' };
    STATUS_LIST.forEach(status => {
      const k = idKey[status];
      const items = list.filter(p => p.status === status);
      document.getElementById(`dashColCount_${k}`).textContent = items.length;
      renderProjectTable(document.getElementById(`dashHead_${k}`), document.getElementById(`dashBody_${k}`),
        dashColumnKeys(status, isAdmin), items, { showReview: isRep, emptyText: `No ${status.toLowerCase()} projects.` });
    });
  }

  /* NOTIFICATION BELL (Admin only) — surfaces pending Barangay Rep submissions */
  function updateNotifBell() {
    const isAdmin = appState.currentUser?.role === 'DILG Admin';
    const wrap = document.getElementById('notifBellWrap');
    if (!wrap) return;
    if (!isAdmin) { wrap.style.display = 'none'; return; }
    wrap.style.display = 'block';
    const pending = masterProjectsDatabase.filter(p => reviewOf(p) === 'Pending');
    const badge = document.getElementById('notifBellBadge');
    if (pending.length > 0) { badge.textContent = pending.length > 99 ? '99+' : pending.length; badge.style.display = 'flex'; }
    else badge.style.display = 'none';
    const body = document.getElementById('notifPanelBody');
    if (!pending.length) {
      body.innerHTML = `<div class="notif-empty">🎉 No pending submissions.</div>`;
    } else {
      body.innerHTML = pending.slice(0, 6).map(p => `
        <div class="notif-item" onclick="closeNotifPanel();switchTab('pending');">
          <div class="notif-item-title">🕐 ${p.title}</div>
          <div class="notif-item-sub">📍 Barangay ${p.barangay} · By ${p.submittedBy || '—'}</div>
        </div>`).join('');
    }
  }

  function toggleNotifPanel(e) {
    if (e) e.stopPropagation();
    document.getElementById('notifPanel').classList.toggle('open');
  }

  function closeNotifPanel() {
    const panel = document.getElementById('notifPanel');
    if (panel) panel.classList.remove('open');
  }

  function viewAllNotifications() {
    closeNotifPanel();
    switchTab('pending');
  }

  document.addEventListener('click', (e) => {
    const wrap = document.getElementById('notifBellWrap');
    if (wrap && !wrap.contains(e.target)) closeNotifPanel();
  });

  /* PENDING REVIEWS TABLE */
  function renderPendingTable() {
    const q = (document.getElementById('pendingSearchInput')?.value || '').toLowerCase().trim();
    let list = masterProjectsDatabase.filter(p => reviewOf(p) === 'Pending');
    const pendingAll = list.length;
    if (q) list = list.filter(p => [p.title, p.code, p.barangay, p.location, p.submittedBy].some(v => (v || '').toLowerCase().includes(q)));
    document.getElementById('pendingReviewCount').textContent = pendingAll;

    const head = document.getElementById('pendingReviewHead');
    const body = document.getElementById('pendingReviewBody');
    renderProjectTable(head, body, ['brgy','code','title','started','target','cost','utilized','location'], list, {
      actionsLabel: 'Actions (Confirm / Reject)',
      actions: p => {
        const i = masterProjectsDatabase.indexOf(p);
        return `<div style="display:flex;gap:6px;justify-content:flex-end;">
          <button class="rv-btn rv-confirm" onclick="setReview(${i},'Confirmed')">✔ Confirm</button>
          <button class="rv-btn rv-reject" onclick="setReview(${i},'Rejected')">✖ Reject</button>
        </div>`;
      }
    });
    if (!list.length) {
      body.innerHTML = `<tr><td colspan="9" style="text-align:center;color:var(--gray);padding:40px;">
        <div style="font-size:36px;margin-bottom:10px;">✅</div>
        <div style="font-weight:bold;font-size:15px;">${pendingAll ? 'No matching pending projects.' : 'No pending projects!'}</div>
        <div style="font-size:13px;margin-top:4px;">${pendingAll ? 'Try a different search.' : 'All submissions have been reviewed.'}</div>
      </td></tr>`;
    }
  }

  // Admin decision on a submitted project: Confirmed or Rejected (or back to Pending from the folder view).
  function setReview(idx, review) {
    const p = masterProjectsDatabase[idx];
    if (!p || !REVIEW_LIST.includes(review)) return;
    if (review === 'Rejected' && !confirm(`Reject "${p.title}"? The barangay will see it marked as Rejected.`)) {
      if (appState.currentFolderBrgy && document.getElementById('folderModal').style.display === 'flex') searchFolderModal();
      return;
    }
    if (!apiSync('set_review', { code: p.code, reviewStatus: review })) {
      showToast(window.lastApiError || 'Unable to update the review status.', true);
      if (appState.currentFolderBrgy && document.getElementById('folderModal').style.display === 'flex') searchFolderModal();
      return;
    }
    const old = reviewOf(p);
    p.reviewStatus = review;
    pushLog(`Review of [${p.code}] changed from "${old}" to "${review}".`, appState.currentUser.name);
    showToast(`"${p.title}" ${review === 'Pending' ? 'returned to Pending' : review.toLowerCase()}.`);
    recalcDashboard();
    renderPublicShowcase();
    if (appState.activeTab === 'pending') renderPendingTable();
    if (appState.currentFolderBrgy && document.getElementById('folderModal').style.display === 'flex') searchFolderModal();
    renderWorkspaceFolders();
  }

  function openStatusModal(status) {
    appState.statusModalStatus = status;
    appState.statusModalFilter = "";
    document.getElementById('statusModalSearch').value = "";
    const colors = { 'Completed': '#0baa41', 'Ongoing': '#e67e22', 'Not Yet Started': '#dd584c' };
    document.getElementById('statusModalHeader').style.background = colors[status] || '#1861bf';
    document.getElementById('statusModalTitle').textContent = status + ' Projects';
    renderStatusModal();
    document.getElementById('statusModal').style.display = 'flex';
  }

  function closeStatusModal() { document.getElementById('statusModal').style.display = 'none'; }

  /* FOLDER MODAL */
  function openFolderModal(brgy) {
    appState.currentFolderBrgy = brgy;
    document.getElementById('folderModalTitle').textContent = `📁 Barangay ${brgy} — Projects`;
    document.getElementById('folderModalSearch').value = '';
    renderFolderModal(brgy, '');
    document.getElementById('folderModal').style.display = 'flex';
  }

  function closeFolderModalBtn() {
    document.getElementById('folderModal').style.display = 'none';
  }

  function closeFolderModal(e) {
    if (e.target === document.getElementById('folderModal')) closeFolderModalBtn();
  }

  function searchFolderModal() {
    const q = document.getElementById('folderModalSearch').value.toLowerCase();
    if (appState.currentFolderBrgy) renderFolderModal(appState.currentFolderBrgy, q);
  }

  function folderActions(p, brgy) {
    const u = appState.currentUser;
    const i = masterProjectsDatabase.indexOf(p);
    if (u.role === 'DILG Admin') {
      return `<div style="display:flex;align-items:center;gap:4px;flex-wrap:wrap;justify-content:flex-end;">
        <select onchange="setReview(${i},this.value)" style="padding:4px 6px;font-size:11px;border:1px solid rgba(24,97,191,0.4);border-radius:6px;color:var(--blue);font-weight:bold;cursor:pointer;background:var(--white);" title="Review status">
          ${REVIEW_LIST.map(r => `<option value="${r}" ${reviewOf(p) === r ? 'selected' : ''}>${r === 'Confirmed' ? '✔' : r === 'Rejected' ? '✖' : '🕐'} ${r}</option>`).join('')}
        </select>
        <button class="top-btn" onclick="editProjectFromModal(${i})" style="padding:4px 8px;font-size:11px;border-color:var(--blue);color:var(--blue);">✏️ Edit</button>
        <button class="top-btn" onclick="deleteProjectFromModal(${i},'${esc(brgy)}')" style="padding:4px 8px;font-size:11px;border-color:var(--red);color:var(--red);">🗑️ Delete</button>
      </div>`;
    }
    if (u.barangay === brgy) {
      return `<button class="top-btn" onclick="editProjectFromModal(${i})" style="padding:4px 8px;font-size:11px;border-color:var(--blue);color:var(--blue);">✏️ Edit</button> <button class="top-btn" onclick="deleteProjectFromModal(${i},'${esc(brgy)}')" style="padding:4px 8px;font-size:11px;border-color:var(--red);color:var(--red);margin-left:4px;">🗑️ Delete</button>`;
    }
    return `<span style="font-size:12px;color:var(--gray);font-style:italic;">View Only</span>`;
  }

  function renderFolderModal(brgy, searchQuery) {
    const q = (searchQuery || '').toLowerCase().trim();
    let subset = masterProjectsDatabase.filter(p => p.barangay === brgy);
    if (q) subset = subset.filter(p => [p.title, p.code, p.location, p.status, p.submittedBy, reviewOf(p)].some(v => (v || '').toLowerCase().includes(q)));
    document.getElementById('folderModalCount').textContent = `${subset.length} record(s) found`;
    renderProjectTable(document.getElementById('folderModalHead'), document.getElementById('folderModalBody'),
      ['brgy','code','title','started','target','cost','utilized','status','location'], subset,
      { showReview: true, actions: p => folderActions(p, brgy), emptyText: 'No projects found.' });
  }

  function editProjectFromModal(idx) {
    closeFolderModalBtn();
    editProject(idx);
  }

  function deleteProjectFromModal(idx, brgy) {
    const p = masterProjectsDatabase[idx];
    if (!p || !confirm(`Delete project "${p.title}"? This cannot be undone.`)) return;
    if (!apiSync('delete_project', { code: p.code })) { showToast(window.lastApiError || 'Unable to delete the project.', true); return; }
    masterProjectsDatabase.splice(idx, 1);
    pushLog(`Deleted project [${p.code}].`, appState.currentUser.name);
    renderWorkspaceFolders();
    recalcDashboard();
    renderPublicShowcase();
    renderFolderModal(brgy, document.getElementById('folderModalSearch').value);
  }

  function filterStatusModal() {
    appState.statusModalFilter = document.getElementById('statusModalSearch').value.toLowerCase();
    renderStatusModal();
  }

  function renderStatusModal() {
    const q = appState.statusModalFilter;
    let list = getDashList().filter(p => p.status === appState.statusModalStatus);
    if (q) list = list.filter(p => [p.title, p.code, p.barangay, p.location, p.remarks, p.submittedBy].some(v => (v || '').toLowerCase().includes(q)));
    document.getElementById('statusModalCount').textContent = `${list.length} project(s) found`;
    // Column order per status (same for Admin and Barangay Rep).
    const STATUS_MODAL_COLUMNS = {
      'Completed':       ['brgy','code','title','started','target','completed','cost','utilized','location'],
      'Ongoing':         ['brgy','code','title','started','target','cost','utilized','status','location'],
      'Not Yet Started': ['brgy','code','title','target','cost','utilized','remarks']
    };
    const cols = STATUS_MODAL_COLUMNS[appState.statusModalStatus] || STATUS_MODAL_COLUMNS['Ongoing'];
    renderProjectTable(document.getElementById('statusModalHead'), document.getElementById('statusModalBody'),
      cols, list, { emptyText: 'No projects found.' });
  }

  /* WORKSPACE */
  function renderWorkspaceFolders() {
    const grid = document.getElementById('workspaceBrgyGrid');
    const u = appState.currentUser;
    grid.innerHTML = "";
    const folders = u.role === 'DILG Admin' ? barangayFolders : [u.barangay];
    const titleEl = document.getElementById('workspaceCardTitle');
    if (u.role === 'DILG Admin') {
      titleEl.textContent = '📂 Barangay Folders';
    } else {
      titleEl.textContent = `📂 Barangay ${u.barangay} — Project Files`;
    }
    if (!folders.length) {
      grid.innerHTML = `<div style="grid-column:1/-1;text-align:center;color:var(--gray);padding:30px 10px;font-size:14px;">
        <div style="font-size:36px;margin-bottom:8px;">📂</div>No barangay folders yet.<br>A folder is created automatically when you add a Barangay Rep account under Manage Accounts.</div>`;
      return;
    }
    folders.forEach(b => {
      const count = masterProjectsDatabase.filter(p => p.barangay === b).length;
      const div = document.createElement('div');
      div.className = "brgy-folder-card" + (appState.selectedFolder === b ? " active-folder" : "");
      div.id = `folder_${b}`;
      div.onclick = () => selectFolder(b);
      div.innerHTML = `<div class="folder-icon">📁</div><div class="folder-name">${esc(b)}</div><div class="folder-meta">${count} record(s)</div>`;
      grid.appendChild(div);
    });
  }

  function selectFolder(brgy) {
    appState.selectedFolder = brgy;
    appState.currentFolderBrgy = brgy;
    document.querySelectorAll('.brgy-folder-card').forEach(el => el.classList.remove('active-folder'));
    const el = document.getElementById(`folder_${brgy}`);
    if (el) el.classList.add('active-folder');
    openFolderModal(brgy);
  }

  function editProject(idx) {
    const p = masterProjectsDatabase[idx];
    if (!p) return;
    switchTab('ingest');
    const set = (id, v) => { document.getElementById(id).value = v == null ? '' : v; };
    set('ingestEditIndex', idx);
    set('ingestSerial', p.code);
    document.getElementById('ingestSerial').readOnly = true; // the code identifies the record, so it stays fixed while editing
    const brgySel = document.getElementById('ingestBarangay');
    if (![...brgySel.options].some(o => o.value === p.barangay)) { const o = document.createElement('option'); o.value = p.barangay; o.textContent = p.barangay; brgySel.appendChild(o); }
    set('ingestBarangay', p.barangay);
    set('ingestTitle', p.title);
    set('ingestLocation', p.location);
    set('ingestCost', p.cost);
    set('ingestDesc', p.desc);
    set('ingestCategory', 'Infrastructure');
    set('ingestMode', p.modeOfImplementation);
    set('ingestUtilized', p.amountUtilized || '');
    set('ingestAllocatedBudget', p.allocatedBudget || '');
    set('ingestStatus', p.status);
    set('ingestProgress', p.status === 'Ongoing' ? pctOf(p) : '');
    set('ingestStartDate', p.startDate);
    set('ingestTargetDate', p.targetDate);
    set('ingestDateCompleted', p.dateCompleted);
    set('ingestRemarks', p.remarks);
    onIngestStatusChange(true);
    ingestPhotos = photosOf(p).slice();
    renderIngestPhotos();
    document.getElementById('ingestSubmitBtn').textContent = "Save Changes";
    const hdr = document.getElementById('ingestFormHeaderTitle');
    if (!hdr.textContent.startsWith('✏️')) hdr.dataset.addTitle = hdr.textContent;
    hdr.textContent = "✏️ Edit Project — " + p.code;
    resetExpenseRows(p.expenseItems && p.expenseItems.length ? p.expenseItems : null);
    recalcRemainingBalance();
    // Review status banner
    const banner = document.getElementById('ingestReviewBanner');
    const isRep = appState.currentUser?.role === 'Barangay Reporter';
    banner.style.display = 'flex';
    banner.innerHTML = `<span style="font-weight:bold;color:#111822;">Review status:</span> ${reviewBadge(p)}` +
      (isRep ? `<span>Saving changes sends this project back to the admin for review.</span>` : '');
    pushLog(`Editing project [${p.code}].`, "system");
  }

  function deleteProject(idx) {
    const p = masterProjectsDatabase[idx];
    if (!p || !confirm(`Delete project "${p.title}"? This cannot be undone.`)) return;
    if (!apiSync('delete_project', { code: p.code })) { showToast(window.lastApiError || 'Unable to delete the project.', true); return; }
    masterProjectsDatabase.splice(idx, 1);
    pushLog(`Deleted project [${p.code}].`, appState.currentUser.name);
    renderWorkspaceFolders();
    recalcDashboard();
    renderPublicShowcase();
  }

  /* EXPENSE LIST — replaces the free-text Description field for Barangay Reps */
  function addExpenseRow(label = '', amount = '') {
    const tbody = document.getElementById('expenseItemsBody');
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td style="padding:6px 8px;"><input type="text" class="dash-form-input expense-item-desc" placeholder="e.g., Materials" oninput="recalcExpenseTotal()"></td>
      <td style="padding:6px 8px;width:170px;"><input type="number" class="dash-form-input expense-item-amount" placeholder="0.00" min="0" step="0.01" oninput="recalcExpenseTotal()"></td>
      <td style="padding:6px 8px;width:40px;text-align:center;"><button type="button" onclick="removeExpenseRow(this)" title="Remove item" style="background:none;border:none;color:var(--red);font-size:18px;cursor:pointer;">✕</button></td>`;
    tbody.appendChild(tr);
    tr.querySelector('.expense-item-desc').value = label;
    tr.querySelector('.expense-item-amount').value = amount || '';
  }

  function removeExpenseRow(btn) {
    const tbody = document.getElementById('expenseItemsBody');
    if (tbody.rows.length <= 1) { alert("At least one expense item row is required."); return; }
    btn.closest('tr').remove();
    recalcExpenseTotal();
  }

  function resetExpenseRows(items) {
    const tbody = document.getElementById('expenseItemsBody');
    tbody.innerHTML = '';
    if (items && items.length) items.forEach(it => addExpenseRow(it.label, it.amount));
    else addExpenseRow();
    recalcExpenseTotal();
  }

  function getExpenseItems() {
    const items = [];
    document.querySelectorAll('#expenseItemsBody tr').forEach(tr => {
      const label = tr.querySelector('.expense-item-desc').value.trim();
      const amount = parseFloat(tr.querySelector('.expense-item-amount').value) || 0;
      if (label || amount) items.push({ label, amount });
    });
    return items;
  }

  function recalcExpenseTotal() {
    const total = getExpenseItems().reduce((sum, it) => sum + it.amount, 0);
    document.getElementById('expenseTotalDisplay').textContent = '₱ ' + total.toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    if (appState.currentUser?.role === 'Barangay Reporter') {
      document.getElementById('ingestCost').value = total || '';
      recalcRemainingBalance();
    }
  }

  function buildDescFromExpenses(items) {
    return items.filter(it => it.label).map(it => `${it.label} — ₱${it.amount.toLocaleString('en-PH',{minimumFractionDigits:2,maximumFractionDigits:2})}`).join(' • ');
  }

  /* PROJECT PHOTOS — one or many; each is resized in the browser before upload */
  let ingestPhotos = [];

  function resizeImageFile(file, maxDim = 1280, quality = 0.8) {
    return new Promise((resolve, reject) => {
      const reader = new FileReader();
      reader.onerror = () => reject(new Error('read failed'));
      reader.onload = ev => {
        const img = new Image();
        img.onerror = () => reject(new Error('decode failed'));
        img.onload = () => {
          const scale = Math.min(1, maxDim / Math.max(img.width, img.height));
          const w = Math.round(img.width * scale), h = Math.round(img.height * scale);
          const c = document.createElement('canvas');
          c.width = w; c.height = h;
          const ctx = c.getContext('2d');
          ctx.fillStyle = '#fff'; ctx.fillRect(0, 0, w, h);
          ctx.drawImage(img, 0, 0, w, h);
          resolve(c.toDataURL('image/jpeg', quality));
        };
        img.src = ev.target.result;
      };
      reader.readAsDataURL(file);
    });
  }

  async function handlePhotoSelect(e) {
    const files = Array.from(e.target.files || []);
    e.target.value = '';
    if (!files.length) return;
    const room = MAX_PHOTOS - ingestPhotos.length;
    if (room <= 0) { alert(`You can attach up to ${MAX_PHOTOS} photos per project.`); return; }
    let skipped = Math.max(0, files.length - room);
    for (const f of files.slice(0, room)) {
      if (!f.type.startsWith('image/')) { skipped++; continue; }
      try { ingestPhotos.push(await resizeImageFile(f)); } catch (_) { skipped++; }
    }
    renderIngestPhotos();
    if (skipped) showToast(`${skipped} file(s) skipped (not a readable image, or over the ${MAX_PHOTOS}-photo limit).`, true);
  }

  function removeIngestPhoto(i) { ingestPhotos.splice(i, 1); renderIngestPhotos(); }

  function renderIngestPhotos() {
    const grid = document.getElementById('ingestPhotoGrid');
    document.getElementById('ingestPhotoCount').textContent = ingestPhotos.length ? `${ingestPhotos.length} of ${MAX_PHOTOS} photos attached` : 'No photos attached yet.';
    grid.innerHTML = ingestPhotos.map((src, i) =>
      `<div class="photo-tile"><img src="${esc(src)}" alt="Photo ${i + 1}"><button type="button" title="Remove photo" onclick="removeIngestPhoto(${i})">✕</button></div>`).join('');
  }

  /* Status drives which timeframe/progress fields apply */
  function onIngestStatusChange(keepValues) {
    const s = document.getElementById('ingestStatus').value;
    const prog = document.getElementById('ingestProgress');
    const started = document.getElementById('ingestStartDate');
    const done = document.getElementById('ingestDateCompleted');
    prog.disabled = s !== 'Ongoing';
    started.disabled = s === 'Not Yet Started';
    done.disabled = s !== 'Completed';
    if (!keepValues) {
      if (s !== 'Ongoing') prog.value = '';
      if (s === 'Not Yet Started') started.value = '';
      if (s !== 'Completed') done.value = '';
    }
    prog.placeholder = s === 'Completed' ? '100 (automatic)' : s === 'Not Yet Started' ? '0 (automatic)' : '1 – 99';
  }

  function recalcRemainingBalance() {
    const cost = parseFloat(document.getElementById('ingestCost').value) || 0;
    const budget = parseFloat(document.getElementById('ingestAllocatedBudget').value) || 0;
    const balVal = document.getElementById('remainingBalanceValue');
    const balIcon = document.getElementById('remainingBalanceIcon');
    const balDisplay = document.getElementById('remainingBalanceDisplay');
    if (!document.getElementById('ingestCost').value && !document.getElementById('ingestAllocatedBudget').value) {
      balIcon.textContent = '—';
      balVal.textContent = 'Enter values above';
      balDisplay.style.borderColor = 'rgba(84,93,104,0.2)';
      balDisplay.style.color = '#111822';
      return;
    }
    const remaining = budget - cost;
    balVal.textContent = '₱ ' + remaining.toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    if (remaining > 0) {
      balIcon.textContent = '✅';
      balDisplay.style.borderColor = 'rgba(11,170,65,0.4)';
      balDisplay.style.color = 'var(--green)';
    } else if (remaining === 0) {
      balIcon.textContent = '⚖️';
      balDisplay.style.borderColor = 'rgba(84,93,104,0.3)';
      balDisplay.style.color = '#111822';
    } else {
      balIcon.textContent = '⚠️';
      balDisplay.style.borderColor = 'rgba(221,88,76,0.4)';
      balDisplay.style.color = 'var(--red)';
    }
  }

  function clearIngestForm() {
    document.getElementById('ingestEditIndex').value = "-1";
    ['ingestSerial','ingestTitle','ingestLocation','ingestCost','ingestDesc','ingestUtilized','ingestAllocatedBudget','ingestProgress','ingestStartDate','ingestTargetDate','ingestDateCompleted','ingestRemarks']
      .forEach(id => document.getElementById(id).value = "");
    document.getElementById('ingestSerial').readOnly = false;
    document.getElementById('ingestCategory').selectedIndex = 0;
    document.getElementById('ingestMode').selectedIndex = 0;
    document.getElementById('ingestStatus').selectedIndex = 0;
    onIngestStatusChange(false);
    ingestPhotos = [];
    renderIngestPhotos();
    document.getElementById('ingestReviewBanner').style.display = 'none';
    document.getElementById('ingestSubmitBtn').textContent = "Save Project";
    const hdr = document.getElementById('ingestFormHeaderTitle');
    if (hdr.textContent.startsWith('✏️') && hdr.dataset.addTitle) hdr.textContent = hdr.dataset.addTitle;
    resetExpenseRows();
    const balDisplay = document.getElementById('remainingBalanceDisplay');
    document.getElementById('remainingBalanceIcon').textContent = '—';
    document.getElementById('remainingBalanceValue').textContent = 'Enter values above';
    balDisplay.style.borderColor = 'rgba(84,93,104,0.2)';
    balDisplay.style.color = '#111822';
    if (appState.currentUser?.role === 'Barangay Reporter') {
      ensureBrgyOption(appState.currentUser.barangay); document.getElementById('ingestBarangay').value = appState.currentUser.barangay;
    } else {
      document.getElementById('ingestBarangay').selectedIndex = 0;
    }
  }

  function submitProjectForm() {
    const editIdx = parseInt(document.getElementById('ingestEditIndex').value);
    const existing = editIdx !== -1 ? masterProjectsDatabase[editIdx] : null;
    const isRep = appState.currentUser.role === 'Barangay Reporter';
    const val = id => document.getElementById(id).value.trim();
    const code = val('ingestSerial');
    const brgy = document.getElementById('ingestBarangay').value;
    if (!brgy) { alert("There is no barangay folder yet. Add a Barangay Rep account first (Manage Accounts) to create one."); return; }
    const title = val('ingestTitle');
    const location = val('ingestLocation');

    let desc, cost, expenseItems;
    if (isRep) {
      expenseItems = getExpenseItems().filter(it => it.label && it.amount > 0);
      if (!expenseItems.length) { alert("Please list at least one expense item with a description and amount."); return; }
      desc = buildDescFromExpenses(expenseItems);
      cost = expenseItems.reduce((sum, it) => sum + it.amount, 0);
    } else {
      desc = val('ingestDesc');
      cost = parseFloat(document.getElementById('ingestCost').value);
      expenseItems = existing ? (existing.expenseItems || []) : [];
    }

    const status = document.getElementById('ingestStatus').value;
    const mode = document.getElementById('ingestMode').value;
    const allocatedBudget = parseFloat(document.getElementById('ingestAllocatedBudget').value) || 0;
    const amountUtilized = parseFloat(document.getElementById('ingestUtilized').value) || 0;
    const startDate = status === 'Not Yet Started' ? '' : val('ingestStartDate');
    const targetDate = val('ingestTargetDate');
    const dateCompleted = status === 'Completed' ? val('ingestDateCompleted') : '';
    const remarks = val('ingestRemarks');
    let progress = status === 'Completed' ? 100 : status === 'Not Yet Started' ? 0 : parseInt(document.getElementById('ingestProgress').value);

    if (!code || !title) { alert("Please fill in the Project Code and Project Name."); return; }
    if (!location) { alert("Please enter the project Location."); return; }
    if (isNaN(cost) || !desc) { alert("Please fill in all fields."); return; }
    if (!mode) { alert("Please select the Mode of Implementation (Admin or Contract)."); return; }
    if (amountUtilized < 0) { alert("Amount Utilized cannot be negative."); return; }
    if (amountUtilized > cost) { alert("Amount Utilized cannot be more than the Total Cost."); return; }
    if (status === 'Ongoing' && (isNaN(progress) || progress < 1 || progress > 99)) { alert("For an Ongoing project, enter the progress as a percentage from 1 to 99."); return; }
    if (status !== 'Not Yet Started' && !startDate) { alert("Please enter the Date Started."); return; }
    if (status === 'Completed' && !dateCompleted) { alert("Please enter the Date Completed."); return; }
    if (startDate && targetDate && targetDate < startDate) { alert("Target Date of Completion cannot be earlier than the Date Started."); return; }
    if (isRep && brgy !== appState.currentUser.barangay) { alert("You can only submit projects for your own barangay."); return; }
    if (!existing && masterProjectsDatabase.some(p => p.code.toLowerCase() === code.toLowerCase())) { alert("A project with this code already exists."); return; }

    const project = {
      code, title, category: 'Infrastructure', barangay: brgy, location, cost, allocatedBudget, amountUtilized,
      desc, expenseItems, status, progress: isNaN(progress) ? 0 : progress, remarks, modeOfImplementation: mode,
      startDate, targetDate, dateCompleted, photos: ingestPhotos.slice(),
      reviewStatus: isRep ? 'Pending' : (existing ? reviewOf(existing) : 'Confirmed')
    };
    const res = apiSync('save_project', { project, originalCode: existing ? existing.code : '' });
    if (!res || !res.project) { alert(window.lastApiError || 'Unable to save the project to the database.'); return; }

    if (existing) {
      const wasReviewed = reviewOf(existing) !== 'Pending';
      masterProjectsDatabase[editIdx] = res.project;
      pushLog(`Updated project [${existing.code}].`, appState.currentUser.name);
      showToast(isRep && wasReviewed ? `Project "${title}" updated and sent back to the Admin for review.` : `Project "${title}" updated successfully!`);
    } else {
      masterProjectsDatabase.push(res.project);
      pushLog(`Added new project [${code}].`, appState.currentUser.name);
      showToast(isRep ? `Project "${title}" submitted successfully! It is now waiting for Admin review.` : `Project "${title}" added.`);
    }
    recalcDashboard();
    renderPublicShowcase();
    clearIngestForm();
    switchTab('workspace');
    selectFolder(brgy);
  }

  /* ACCOUNTS */
  function renderAccountsTable(filter) {
    const tbody = document.getElementById('accountsTable').getElementsByTagName('tbody')[0];
    tbody.innerHTML = "";
    let list = [...registeredAccounts];
    if (filter) list = list.filter(a => a.name.toLowerCase().includes(filter) || a.barangay.toLowerCase().includes(filter) || a.role.toLowerCase().includes(filter));
    if (!list.length) {
      tbody.innerHTML = `<tr><td colspan="7" style="text-align:center;color:var(--gray);padding:30px;font-size:14px;">No accounts found.</td></tr>`;
      return;
    }
    list.forEach(acc => {
      const isActive = acc.status === 'active';
      const isProtected = Number(acc.id) === 101;
      const isSelf = Number(acc.id) === Number(appState.currentUser && appState.currentUser.id);
      const tr = document.createElement('tr');

      // Highlight inactive rows with a red tint
      if (!isActive) {
        tr.style.cssText = 'background:rgba(221,88,76,0.06);border-left:3px solid var(--red);';
      }

      const statusBadge = isActive
        ? `<span style="display:inline-flex;align-items:center;gap:5px;background:rgba(11,170,65,0.1);color:var(--green);border:1px solid rgba(11,170,65,0.3);padding:5px 12px;border-radius:20px;font-size:12px;font-weight:bold;text-transform:uppercase;letter-spacing:0.5px;">
            <span style="width:7px;height:7px;border-radius:50%;background:var(--green);display:inline-block;"></span> Active
           </span>`
        : `<div style="display:flex;flex-direction:column;gap:4px;">
             <span style="display:inline-flex;align-items:center;gap:5px;background:rgba(221,88,76,0.1);color:var(--red);border:1px solid rgba(221,88,76,0.3);padding:5px 12px;border-radius:20px;font-size:12px;font-weight:bold;text-transform:uppercase;letter-spacing:0.5px;">
               <span style="width:7px;height:7px;border-radius:50%;background:var(--red);display:inline-block;"></span> Inactive
             </span>
             <span style="font-size:11px;color:var(--red);font-style:italic;">⛔ Login is blocked</span>
           </div>`;

      const nameCellContent = isActive
        ? `<strong style="color:#111822;">${esc(acc.name)}</strong>`
        : `<div>
             <strong style="color:var(--red);text-decoration:line-through;opacity:0.7;">${esc(acc.name)}</strong>
             <div style="font-size:11px;color:var(--red);font-weight:bold;margin-top:2px;">Account Deactivated</div>
           </div>`;

      const roleBadge = `<span style="background:rgba(24,97,191,0.08);padding:4px 8px;border-radius:6px;font-size:13px;font-weight:bold;color:${isActive ? 'var(--blue)' : 'var(--gray)'};">${esc(acc.role)}</span>`;

      const actionButtons = (isProtected || isSelf)
        ? `<span style="font-size:12px;color:var(--gray);font-style:italic;">${isSelf && !isProtected ? 'Your account' : 'Protected'}</span>`
        : isActive
          ? `<button class="top-btn" onclick="toggleUserStatus(${acc.id})" style="padding:4px 10px;font-size:12px;border-color:var(--red);color:var(--red);">⛔ Deactivate</button>
             <button class="top-btn" onclick="deleteUser(${acc.id})" style="padding:4px 10px;font-size:12px;border-color:var(--red);color:var(--red);margin-left:4px;">🗑️ Remove</button>`
          : `<button class="top-btn" onclick="toggleUserStatus(${acc.id})" style="padding:4px 10px;font-size:12px;border-color:var(--green);color:var(--green);font-weight:bold;">🔓 Activate</button>
             <button class="top-btn" onclick="deleteUser(${acc.id})" style="padding:4px 10px;font-size:12px;border-color:var(--red);color:var(--red);margin-left:4px;">🗑️ Remove</button>`;

      tr.innerHTML = `
        <td style="font-family:monospace;font-weight:bold;font-size:14px;color:${isActive ? 'var(--gray)' : 'var(--red)'};">${acc.id}</td>
        <td>${nameCellContent}</td>
        <td>${roleBadge}</td>
        <td><span style="background:${isActive ? '#e1e5eb' : 'rgba(221,88,76,0.08)'};padding:4px 8px;border-radius:6px;font-size:13px;font-weight:bold;color:${isActive ? 'var(--gray)' : 'var(--red)'};">📍 ${esc(acc.barangay)}</span></td>
        <td style="color:var(--gray);font-size:13px;">${esc(acc.dateAdded)}</td>
        <td>${statusBadge}</td>
        <td style="text-align:right;">${actionButtons}</td>`;
      tbody.appendChild(tr);
    });
  }

  function searchAccounts() {
    const q = document.getElementById('accountSearchInput').value.toLowerCase();
    renderAccountsTable(q);
  }

  function openAddUserModal() {
    ['newUserName','newUserBrgy','newUserPassword','newUserPasswordConfirm'].forEach(id => document.getElementById(id).value = "");
    document.getElementById('newUserRole').selectedIndex = 0;
    handleNewUserRoleChange();
    document.getElementById('addUserModal').style.display = 'flex';
  }

  function handleNewUserRoleChange() {
    document.getElementById('newUserBrgyGroup').style.display = document.getElementById('newUserRole').value === 'Barangay Reporter' ? 'block' : 'none';
  }

  function submitNewUser() {
    const name = document.getElementById('newUserName').value.trim();
    const pw = document.getElementById('newUserPassword').value;
    const pw2 = document.getElementById('newUserPasswordConfirm').value;
    const role = document.getElementById('newUserRole').value;
    const brgyTyped = document.getElementById('newUserBrgy').value.trim().replace(/\s+/g, ' ');
    if (!name || !pw) { alert('Please fill in all fields.'); return; }
    if (role === 'Barangay Reporter' && !brgyTyped) { alert('Please type the Assigned Barangay.'); return; }
    if (pw.length < 6) { alert('Password must be at least 6 characters.'); return; }
    if (pw !== pw2) { alert('Passwords do not match.'); return; }
    if (registeredAccounts.find(a => a.name.toLowerCase() === name.toLowerCase())) { alert('A user with that name already exists.'); return; }
    const hadFolder = barangayFolders.some(b => b.toLowerCase() === brgyTyped.toLowerCase());
    const res = apiSync('add_account', { name, role, barangay: role === 'Barangay Reporter' ? brgyTyped : '—', password: pw });
    if (!res) { alert(window.lastApiError || 'Unable to add the user.'); return; }
    applyAccountsResult(res);
    document.getElementById('addUserModal').style.display = 'none';
    renderAccountsTable();
    renderWorkspaceFolders();
    showToast(role === 'Barangay Reporter' && !hadFolder ? `User "${name}" added. Folder "${brgyTyped}" created.` : `User "${name}" added.`);
    pushLog(`Added new user [${name}].`, appState.currentUser.name);
  }

  // Deactivate / Activate. The server blocks login at once and ends any session the user already has open.
  function toggleUserStatus(userId) {
    const acc = registeredAccounts.find(a => Number(a.id) === Number(userId));
    if (!acc) return;
    const activating = acc.status !== 'active';
    if (!activating && !confirm(`Deactivate "${acc.name}"?\n\nThey will be signed out and cannot log in until you activate the account again.`)) return;
    const res = apiSync('set_account_status', { id: Number(userId), status: activating ? 'active' : 'inactive' });
    if (!res) { showToast(window.lastApiError || 'Unable to update the account.', true); return; }
    applyAccountsResult(res);
    renderAccountsTable();
    showToast(`"${acc.name}" ${activating ? 'activated' : 'deactivated'}.`);
    pushLog(`${activating ? 'Activated' : 'Deactivated'} user ID ${userId}.`, appState.currentUser.name);
  }

  function deleteUser(userId) {
    const acc = registeredAccounts.find(a => Number(a.id) === Number(userId));
    if (!acc) return;
    if (!confirm(`Remove user "${acc.name}"?\n\nThis permanently deletes the account. Its barangay folder and projects are kept.`)) return;
    const res = apiSync('delete_account', { id: Number(userId) });
    if (!res) { showToast(window.lastApiError || 'Unable to remove the account.', true); return; }
    applyAccountsResult(res);
    renderAccountsTable();
    showToast(`"${acc.name}" removed.`);
    pushLog(`Removed user ID ${userId}.`, appState.currentUser.name);
  }

  /* ── PRINT REPORT MODAL ── */
  const PAPER_SPECS = {
    A4:     { label: 'A4 — 210 × 297 mm',     w: 794,  h: 1123 },
    Letter: { label: 'Letter — 8.5 × 11 in',  w: 816,  h: 1056 },
    Legal:  { label: 'Legal — 8.5 × 14 in',   w: 816,  h: 1344 }
  };
  let pmCurrentPaper = 'A4';
  let pmPhotoDataUrl = null;

  function printProjectReport() {
    const u = appState.currentUser;
    const defaultTitle = u.role === 'DILG Admin' ? 'Project Status Report — All Barangays' : `Project Status Report — Barangay ${u.barangay}`;
    document.getElementById('pmReportTitle').value = defaultTitle;
    document.getElementById('pmReportSubtitle').value = `Sapian, Capiz · ${new Date().toLocaleDateString('en-PH', {year:'numeric',month:'long',day:'numeric'})}`;
    setPaper('A4');
    populatePrintFilters();
    // Load editable document content
    document.getElementById('pmDocContent').innerHTML = buildDocHTML();
    applyPageStyles();
    document.getElementById('printModal').classList.add('open');
  }

  function closePrintModal() {
    document.getElementById('printModal').classList.remove('open');
  }

  function setPaper(size) {
    pmCurrentPaper = size;
    ['A4','Letter','Legal'].forEach(s => {
      document.getElementById('paper'+s).classList.toggle('active', s === size);
    });
    document.getElementById('paperDimLabel').textContent = PAPER_SPECS[size].label;
    applyPageStyles();
  }

  function handlePrintPhoto(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = ev => {
      pmPhotoDataUrl = ev.target.result;
      document.getElementById('pmPhotoPreviewImg').src = pmPhotoDataUrl;
      document.getElementById('pmPhotoPreviewImg').style.display = 'block';
      document.getElementById('pmPhotoPlaceholder').style.display = 'none';
      document.getElementById('pmRemovePhotoBtn').style.display = 'inline-block';
      // Insert photo into the editable doc if not already there
      const doc = document.getElementById('pmDocContent');
      const existing = doc.querySelector('img.pm-report-photo');
      if (existing) { existing.src = pmPhotoDataUrl; }
      else {
        const img = document.createElement('img');
        img.src = pmPhotoDataUrl; img.className = 'pm-report-photo';
        img.style.cssText = 'width:100%;max-height:180px;object-fit:cover;border-radius:8px;margin-bottom:14px;border:1px solid #e4e8ef;display:block;';
        img.alt = 'Report Photo';
        // Insert after the header div (first child)
        const firstChild = doc.firstElementChild;
        if (firstChild) firstChild.insertAdjacentElement('afterend', img);
        else doc.prepend(img);
      }
    };
    reader.readAsDataURL(file);
  }

  function removePrintPhoto() {
    pmPhotoDataUrl = null;
    document.getElementById('pmPhotoInput').value = '';
    document.getElementById('pmPhotoPreviewImg').style.display = 'none';
    document.getElementById('pmPhotoPlaceholder').style.display = 'block';
    document.getElementById('pmRemovePhotoBtn').style.display = 'none';
    const doc = document.getElementById('pmDocContent');
    const existing = doc.querySelector('img.pm-report-photo');
    if (existing) existing.remove();
  }

  function getPrintScopeProjects() {
    const u = appState.currentUser;
    if (!u) return [];
    // The printed report only includes projects the admin has Confirmed.
    const scope = u.role === 'DILG Admin' ? [...masterProjectsDatabase] : masterProjectsDatabase.filter(p => p.barangay === u.barangay);
    return scope.filter(p => reviewOf(p) === 'Confirmed');
  }

  /* PRINT FILTERS — Status, Barangay, Target Month, and Project Type,
     each with its own searchable checkbox list. Only projects matching
     every checked filter are included in the printed report. */
  const PM_STATUS_ORDER = ['Completed', 'Ongoing', 'Not Yet Started'];
  let pmFilterItems = { category: [], status: [], barangay: [], month: [] };
  let pmFilters = { category: new Set(), status: new Set(), barangay: new Set(), month: new Set() };

  function monthKeyOf(p) {
    if (!p.targetDate) return 'none';
    const d = new Date(p.targetDate + 'T00:00:00');
    if (isNaN(d)) return 'none';
    return `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}`;
  }

  function monthLabelOf(key) {
    if (key === 'none') return 'No Target Date Set';
    const [y, m] = key.split('-').map(Number);
    return new Date(y, m - 1, 1).toLocaleDateString('en-PH', { month: 'long', year: 'numeric' });
  }

  function populatePrintFilters() {
    const scope = getPrintScopeProjects();
    const isAdmin = appState.currentUser?.role === 'DILG Admin';

    const categories = [...new Set(scope.map(p => p.category))].sort();
    pmFilterItems.category = categories.map(c => ({ value: c, label: c, count: scope.filter(p => p.category === c).length }));

    const statusesPresent = new Set(scope.map(p => p.status));
    pmFilterItems.status = PM_STATUS_ORDER.filter(s => statusesPresent.has(s)).map(s => ({ value: s, label: s, count: scope.filter(p => p.status === s).length }));

    const barangays = [...new Set(scope.map(p => p.barangay))].sort();
    pmFilterItems.barangay = barangays.map(b => ({ value: b, label: `Barangay ${b}`, count: scope.filter(p => p.barangay === b).length }));

    const monthKeys = [...new Set(scope.map(monthKeyOf))].sort((a, b) => a === 'none' ? 1 : b === 'none' ? -1 : a.localeCompare(b));
    pmFilterItems.month = monthKeys.map(k => ({ value: k, label: monthLabelOf(k), count: scope.filter(p => monthKeyOf(p) === k).length }));

    ['category', 'status', 'barangay', 'month'].forEach(key => {
      pmFilters[key] = new Set(pmFilterItems[key].map(it => it.value));
      renderFilterGroup(key);
    });

    const bGroup = document.getElementById('pmBarangayFilterGroup');
    if (bGroup) bGroup.style.display = isAdmin ? 'block' : 'none';
  }

  function renderFilterGroup(key) {
    const list = document.getElementById(`pmFilterList_${key}`);
    const search = document.getElementById(`pmFilterSearch_${key}`);
    if (search) search.value = '';
    if (!list) return;
    const items = pmFilterItems[key];
    if (!items.length) { list.innerHTML = `<div style="font-size:12px;color:var(--gray);padding:8px;text-align:center;">None available.</div>`; return; }
    list.innerHTML = items.map(it => `
      <label class="pm-filter-row" data-flabel="${it.label.toLowerCase()}">
        <input type="checkbox" class="pm-filter-checkbox" value="${it.value}" checked onchange="onFilterToggle('${key}', this)">
        <span style="flex:1;">${it.label}</span>
        <span style="font-size:11px;color:var(--gray);">${it.count}</span>
      </label>`).join('');
  }

  function filterGroupSearch(key) {
    const q = (document.getElementById(`pmFilterSearch_${key}`).value || '').toLowerCase().trim();
    document.querySelectorAll(`#pmFilterList_${key} .pm-filter-row`).forEach(row => {
      const label = row.getAttribute('data-flabel') || '';
      row.style.display = !q || label.includes(q) ? 'flex' : 'none';
    });
  }

  function setAllInGroup(key, checked) {
    document.querySelectorAll(`#pmFilterList_${key} .pm-filter-row`).forEach(row => {
      if (row.style.display === 'none') return; // only affects rows matching the current search
      const cb = row.querySelector('.pm-filter-checkbox');
      cb.checked = checked;
      if (checked) pmFilters[key].add(cb.value); else pmFilters[key].delete(cb.value);
    });
    rebuildPrintDoc();
  }

  function onFilterToggle(key, cb) {
    if (cb.checked) pmFilters[key].add(cb.value); else pmFilters[key].delete(cb.value);
    rebuildPrintDoc();
  }

  function rebuildPrintDoc() {
    document.getElementById('pmDocContent').innerHTML = buildDocHTML();
    applyPageStyles();
  }

  function getPrintProjects() {
    const scope = getPrintScopeProjects();
    if (!pmFilters.category.size || !pmFilters.status.size || !pmFilters.barangay.size || !pmFilters.month.size) return [];
    return scope.filter(p =>
      pmFilters.category.has(p.category) &&
      pmFilters.status.has(p.status) &&
      pmFilters.barangay.has(p.barangay) &&
      pmFilters.month.has(monthKeyOf(p))
    );
  }

  /* helpers shared by reload + setPaper + font/margin controls */
  function applyPageStyles() {
    const spec     = PAPER_SPECS[pmCurrentPaper];
    const font     = document.getElementById('pmFontFamily').value;
    const fontSize = document.getElementById('pmFontSize').value;
    const mTop     = document.getElementById('pmMarginTop').value;
    const mBot     = document.getElementById('pmMarginBottom').value;
    const mLeft    = document.getElementById('pmMarginLeft').value;
    const mRight   = document.getElementById('pmMarginRight').value;
    const page     = document.getElementById('pmPageEl');
    const avail    = Math.max(300, (document.querySelector('.pm-preview-wrap')?.offsetWidth || 700) - 56);
    const scale    = Math.min(1, avail / spec.w);
    page.style.width        = spec.w + 'px';
    page.style.minHeight    = spec.h + 'px';
    page.style.transform    = `scale(${scale})`;
    page.style.transformOrigin = 'top center';
    page.style.marginBottom = ((spec.h * scale) - spec.h) + 'px';
    page.style.padding      = `${mTop*2.83}px ${mRight*2.83}px ${mBot*2.83}px ${mLeft*2.83}px`;
    page.style.fontFamily   = font;
    page.style.fontSize     = fontSize + 'pt';
  }

  function updatePreview() { applyPageStyles(); }

  /* Build the initial document HTML loaded into the editable area */
  function buildDocHTML() {
    const font     = document.getElementById('pmFontFamily').value;
    const fontSize = document.getElementById('pmFontSize').value;
    const hdrSize  = document.getElementById('pmHeaderSize').value;
    const title    = document.getElementById('pmReportTitle').value || 'Project Status Report';
    const subtitle = document.getElementById('pmReportSubtitle').value || '';
    const projects = getPrintProjects();
    const completed = projects.filter(p => p.status === 'Completed').length;
    const ongoing      = projects.filter(p => p.status === 'Ongoing').length;
    const notStarted   = projects.filter(p => p.status === 'Not Yet Started').length;
    const totalCost    = projects.reduce((s, p) => s + (p.cost || 0), 0);

    const rows = projects.map((p, i) => {
      const bg = i % 2 === 1 ? '#f8fafd' : '#fff';
      const sc = p.status==='Completed' ? 'background:rgba(11,170,65,0.12);color:#0baa41' : p.status==='Not Yet Started' ? 'background:rgba(221,88,76,0.12);color:#dd584c' : 'background:rgba(230,126,34,0.12);color:#e67e22';
      return `<tr style="background:${bg};">
        <td style="font-family:monospace;font-size:9pt;color:#1861bf;font-weight:bold;padding:7px 8px;border-bottom:1px solid #e4e8ef;">${p.code}</td>
        <td style="font-weight:bold;padding:7px 8px;border-bottom:1px solid #e4e8ef;">${p.title}</td>
        <td style="padding:7px 8px;border-bottom:1px solid #e4e8ef;">${p.category}</td>
        <td style="font-weight:bold;padding:7px 8px;border-bottom:1px solid #e4e8ef;">📍 ${p.barangay}</td>
        <td style="font-weight:bold;color:#1861bf;text-align:right;padding:7px 8px;border-bottom:1px solid #e4e8ef;">₱ ${p.cost.toLocaleString()}</td>
        <td style="text-align:right;padding:7px 8px;border-bottom:1px solid #e4e8ef;"><span style="${sc};padding:3px 9px;border-radius:10px;font-size:9pt;font-weight:bold;display:inline-block;">${p.status}</span></td>
      </tr>`;
    }).join('');

    return `<div style="display:flex;align-items:center;gap:14px;margin-bottom:16px;padding-bottom:12px;border-bottom:3px solid #1861bf;">
  <div style="width:56px;height:56px;border-radius:50%;background:#1861bf;display:flex;align-items:center;justify-content:center;font-size:26px;flex-shrink:0;color:#fff;">🏛️</div>
  <div>
    <div style="font-size:${hdrSize}pt;font-weight:bold;color:#111822;line-height:1.2;">${title}</div>
    <div style="font-size:${Math.max(9,parseInt(fontSize))}pt;color:#545d68;">${subtitle}</div>
    <div style="font-size:${Math.max(8,parseInt(fontSize)-1)}pt;color:#1861bf;font-weight:bold;letter-spacing:0.5px;margin-top:2px;">DILG-LGU · SAPIAN, CAPIZ</div>
  </div>
</div>
${pmPhotoDataUrl ? `<img src="${pmPhotoDataUrl}" style="width:100%;max-height:180px;object-fit:cover;border-radius:8px;margin-bottom:14px;border:1px solid #e4e8ef;" alt="Report Photo">` : ''}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-bottom:16px;">
  ${[['Total Projects',projects.length,'#1861bf'],['Completed',completed,'#0baa41'],['Ongoing',ongoing,'#e67e22'],['Not Yet Started',notStarted,'#dd584c']].map(([l,v,c])=>
    `<div style="border:1.5px solid #e4e8ef;border-radius:8px;padding:10px;text-align:center;border-top:3px solid ${c};">
      <div style="font-size:${Math.max(16,parseInt(hdrSize))}pt;font-weight:bold;color:${c};">${v}</div>
      <div style="font-size:${Math.max(8,parseInt(fontSize)-1)}pt;color:#545d68;font-weight:bold;text-transform:uppercase;letter-spacing:0.4px;">${l}</div>
    </div>`).join('')}
</div>
<table style="width:100%;border-collapse:collapse;margin-bottom:16px;">
  <thead><tr style="background:#1861bf;">
    <th style="color:#fff;padding:8px 9px;text-align:left;font-size:${Math.max(8,parseInt(fontSize)-1)}pt;">Code</th>
    <th style="color:#fff;padding:8px 9px;text-align:left;font-size:${Math.max(8,parseInt(fontSize)-1)}pt;">Project Name</th>
    <th style="color:#fff;padding:8px 9px;text-align:left;font-size:${Math.max(8,parseInt(fontSize)-1)}pt;">Type</th>
    <th style="color:#fff;padding:8px 9px;text-align:left;font-size:${Math.max(8,parseInt(fontSize)-1)}pt;">Barangay</th>
    <th style="color:#fff;padding:8px 9px;text-align:right;font-size:${Math.max(8,parseInt(fontSize)-1)}pt;">Total Cost</th>
    <th style="color:#fff;padding:8px 9px;text-align:right;font-size:${Math.max(8,parseInt(fontSize)-1)}pt;">Status</th>
  </tr></thead>
  <tbody>${rows || `<tr><td colspan="6" style="text-align:center;padding:20px;color:#545d68;">No projects to display.</td></tr>`}</tbody>
  <tfoot><tr style="background:#f4f6f9;">
    <td colspan="4" style="padding:9px;font-weight:bold;font-size:${fontSize}pt;">TOTAL</td>
    <td style="padding:9px;font-weight:bold;color:#1861bf;text-align:right;font-size:${fontSize}pt;">₱ ${totalCost.toLocaleString()}</td>
    <td></td>
  </tr></tfoot>
</table>
<div style="border-top:2px solid #e4e8ef;padding-top:10px;font-size:${Math.max(8,parseInt(fontSize)-2)}pt;color:#545d68;display:flex;justify-content:space-between;">
  <span>Generated: ${new Date().toLocaleString('en-PH')}</span>
  <span>Prepared by: ${appState.currentUser?.name||'—'} · ${appState.currentUser?.role||''}</span>
</div>
<p style="margin-top:18px;color:#bbb;font-size:9pt;font-style:italic;">— You may click anywhere above to freely edit this document before printing. —</p>`;
  }

  /* Reload data into the editable doc (replaces all content) */
  function reloadDocContent() {
    if (document.getElementById('pmDocContent').innerHTML.trim() &&
        !confirm('Reload will replace your edits with fresh data from the system. Continue?')) return;
    rebuildPrintDoc();
  }

  /* Rich-text toolbar actions */
  function fmtDoc(cmd) {
    document.getElementById('pmDocContent').focus();
    document.execCommand(cmd, false, null);
  }

  function handleDocKeydown(e) {
    // Tab key inserts spaces instead of leaving the field
    if (e.key === 'Tab') {
      e.preventDefault();
      document.execCommand('insertText', false, '    ');
    }
  }

  function executePrint() {
    const spec     = PAPER_SPECS[pmCurrentPaper];
    const font     = document.getElementById('pmFontFamily').value;
    const fontSize = document.getElementById('pmFontSize').value;
    const mTop     = document.getElementById('pmMarginTop').value;
    const mBot     = document.getElementById('pmMarginBottom').value;
    const mLeft    = document.getElementById('pmMarginLeft').value;
    const mRight   = document.getElementById('pmMarginRight').value;
    const title    = document.getElementById('pmReportTitle').value || 'Project Status Report';

    // Grab the live edited HTML from the contenteditable div
    const editedBody = document.getElementById('pmDocContent').innerHTML;

    const html = `<!DOCTYPE html><html><head><meta charset="UTF-8">
<title>${title}</title>
<style>
  @page { size: ${pmCurrentPaper}; margin: ${mTop}mm ${mRight}mm ${mBot}mm ${mLeft}mm; }
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: ${font}; font-size: ${fontSize}pt; color: #1a2530; background: #fff; line-height: 1.6; }
  img { max-width: 100%; }
  table { width: 100%; border-collapse: collapse; }
  ul, ol { padding-left: 20px; }
</style>
</head><body>${editedBody}</body></html>`;

    const iframe = document.getElementById('printOutputFrame');
    iframe.style.display = 'block';
    const doc = iframe.contentWindow.document;
    doc.open(); doc.write(html); doc.close();
    setTimeout(() => {
      iframe.contentWindow.focus();
      iframe.contentWindow.print();
      setTimeout(() => { iframe.style.display = 'none'; }, 1200);
    }, 400);
  }

  /* PUBLIC VIEW */
  function enterPublicPortal() {
    document.getElementById('gatewayPage').classList.add('hidden');
    document.getElementById('publicViewPage').style.display = 'flex';
    document.getElementById('projectSearch').value = '';
    renderPublicShowcase();
  }

  function exitPublicView() {
    document.getElementById('publicViewPage').style.display = 'none';
    document.getElementById('gatewayPage').classList.remove('hidden');
    resetGatewayHome();
  }

  const PUBLIC_COLUMNS = ['photos','pubtitle','location','cost','utilized','started','target','completed'];

  function renderPublicShowcase() {
    const label = document.getElementById('publicCountLabel');
    if (!label) return;
    // Only projects the admin has Confirmed are public.
    const confirmed = masterProjectsDatabase.filter(p => reviewOf(p) === 'Confirmed');
    // One search box: project name, barangay, or status.
    const q = (document.getElementById('projectSearch').value || '').toLowerCase().trim();
    const list = q ? confirmed.filter(p => [p.title, p.barangay, 'barangay ' + p.barangay, p.status].some(v => (v || '').toLowerCase().includes(q))) : confirmed;
    label.textContent = `Showing ${list.length} project(s) of ${confirmed.length} total`;
    const idKey = { 'Completed': 'Completed', 'Ongoing': 'Ongoing', 'Not Yet Started': 'NotStarted' };
    STATUS_LIST.forEach(status => {
      const k = idKey[status];
      const items = list.filter(p => p.status === status);
      document.getElementById(`pubCount_${k}`).textContent = items.length;
      renderProjectTable(document.getElementById(`pubHead_${k}`), document.getElementById(`pubBody_${k}`),
        PUBLIC_COLUMNS, items, { emptyText: `No ${status.toLowerCase()} projects found.` });
    });
  }

  /* PROJECT DETAILS — opens from any project row, with photos */
  let detailState = { idx: -1, photos: [], lb: 0 };

  function openProjectDetails(code) {
    const p = masterProjectsDatabase.find(x => x.code === code);
    if (!p) return;
    const u = appState.currentUser;
    const photos = photosOf(p);
    detailState = { idx: masterProjectsDatabase.indexOf(p), photos, lb: 0 };
    const row = (l, v) => `<div class="receipt-row"><span class="receipt-label">${l}</span><span class="receipt-value">${v}</span></div>`;
    const txt = v => v ? esc(v) : '—';
    const dt = d => d ? esc(formatDisplayDate(d)) : '—';

    const gallery = photos.length
      ? `<div><div class="detail-gallery ${photos.length === 1 ? 'single' : ''}">${photos.map((src, i) => `<img src="${esc(src)}" alt="Project photo ${i + 1}" onclick="openLightbox(${i})">`).join('')}</div><div class="detail-photo-note">📷 ${photos.length} photo(s) — tap a photo to enlarge</div></div>`
      : `<div class="detail-no-photo">📷 No photos uploaded for this project.</div>`;

    const items = Array.isArray(p.expenseItems) ? p.expenseItems.filter(it => it && (it.label || it.amount)) : [];
    const expenseHtml = items.length ? `
      <div class="receipt-section-title">🧾 Project List of Expenses</div>
      <div class="receipt-expense-list">${items.map(it => `<div class="receipt-expense-row"><span class="exp-label">${esc(it.label)}</span><span class="exp-amt">${fmtMoney(it.amount)}</span></div>`).join('')}</div>
      <div class="receipt-expense-total"><span>TOTAL EXPENSES</span><span>${fmtMoney(items.reduce((s, it) => s + (Number(it.amount) || 0), 0))}</span></div>` : '';

    document.getElementById('receiptBody').innerHTML = `<div class="detail-layout"><div class="detail-photos">${gallery}</div><div class="detail-info">
      <div class="receipt-project-name">${esc(p.title)}</div>
      <div class="detail-badges">${statusBadge(p.status)}${u ? reviewBadge(p) : ''}</div>
      <div>${pctBar(p)}</div>
      ${row('Project Code', esc(p.code))}
      ${row('Barangay', '📍 ' + esc(p.barangay))}
      ${row('Location', txt(p.location))}
      ${row('Project Type', txt(p.category))}
      ${row('Mode of Implementation', txt(p.modeOfImplementation))}
      <div class="receipt-section-title">💰 Budget</div>
      ${row('Project Cost', fmtMoney(p.cost))}
      ${row('Allocated Budget', fmtMoney(p.allocatedBudget))}
      ${row('Amount Utilized', fmtMoney(p.amountUtilized))}
      <div class="receipt-section-title">📅 Project Timeframe</div>
      ${row('Date Started', dt(p.startDate))}
      ${row('Target Date of Completion', dt(p.targetDate))}
      ${row('Date Completed', dt(p.dateCompleted))}
      ${p.remarks ? `<div class="receipt-section-title">📝 Remarks</div><div style="font-size:12.5px;color:#111822;">${esc(p.remarks)}</div>` : ''}
      ${items.length ? expenseHtml : (p.desc ? `<div class="receipt-section-title">📄 Description</div><div style="font-size:12.5px;color:#111822;">${esc(p.desc)}</div>` : '')}
    </div></div>`;
    const canEdit = !!u && (u.role === 'DILG Admin' || (u.role === 'Barangay Reporter' && u.barangay === p.barangay));
    document.getElementById('receiptEditBtn').style.display = canEdit ? 'flex' : 'none';
    document.getElementById('receiptBody').scrollTop = 0;
    document.getElementById('publicReceiptModal').style.display = 'flex';
  }

  function editFromDetails() {
    const idx = detailState.idx;
    closePublicReceipt();
    closeFolderModalBtn();
    closeStatusModal();
    if (idx > -1) editProject(idx);
  }

  /* PRINT — one project, one page. The sheet is rebuilt for print and its text size is
     searched (largest that fits) so the content fills the page; photos stretch into the leftover space. */
  const PRINT_PAPERS = { A4: { w: 210, h: 297 }, Letter: { w: 215.9, h: 279.4 }, Legal: { w: 215.9, h: 355.6 } };

  function buildReceiptPrintHTML(p, spec, margin) {
    const u = appState.currentUser;
    const photos = photosOf(p);
    const cols = photos.length <= 1 ? 1 : photos.length <= 4 ? 2 : 3;
    const rows = Math.max(1, Math.ceil(photos.length / cols));
    const txt = v => v ? esc(v) : '—';
    const dt = d => d ? esc(formatDisplayDate(d)) : '—';
    const r = (l, v) => `<div class="r"><span class="l">${l}</span><span class="v">${v}</span></div>`;
    const items = Array.isArray(p.expenseItems) ? p.expenseItems.filter(it => it && (it.label || it.amount)) : [];
    const pct = pctOf(p);
    const color = p.status === 'Completed' ? '#0baa41' : p.status === 'Not Yet Started' ? '#dd584c' : '#e67e22';
    const review = reviewOf(p);
    const reviewColor = review === 'Confirmed' ? '#0baa41' : review === 'Rejected' ? '#dd584c' : '#7c3aed';
    return `<!DOCTYPE html><html><head><meta charset="UTF-8"><title>${esc(p.code)} — Project Details</title><style>
@page { size: ${spec.w}mm ${spec.h}mm; margin: 0; }
* { box-sizing: border-box; margin: 0; padding: 0; }
html { font-size: 12px; width: ${spec.w}mm; height: ${spec.h - 1}mm; overflow: hidden; background: #fff; }
body { width: ${spec.w}mm; height: ${spec.h - 1}mm; overflow: hidden; font-family: Arial, Helvetica, sans-serif; color: #1a2530; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
.page { width: ${spec.w}mm; height: ${spec.h - 1}mm; padding: ${margin}mm; overflow: hidden; }
#sheet { width: 100%; display: flex; flex-direction: column; gap: .7rem; font-size: 1rem; line-height: 1.35; }
.hd { display: flex; align-items: center; gap: .9rem; padding-bottom: .6rem; border-bottom: .22rem solid #1861bf; }
.seal { width: 3.2rem; height: 3.2rem; border-radius: 50%; background: #1861bf; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; flex-shrink: 0; }
.hd h2 { font-size: 1.15rem; color: #111822; } .hd p { font-size: .8rem; color: #545d68; text-transform: uppercase; letter-spacing: .05rem; }
.hd .code { margin-left: auto; text-align: right; font-family: monospace; font-weight: bold; color: #1861bf; font-size: 1rem; }
h1 { font-size: 1.75rem; line-height: 1.15; color: #111822; }
.badges { display: flex; gap: .5rem; align-items: center; flex-wrap: wrap; }
.b { padding: .15rem .7rem; border-radius: 1rem; font-size: .8rem; font-weight: bold; color: #fff; text-transform: uppercase; letter-spacing: .03rem; }
.bar { flex: 1; min-width: 8rem; height: .7rem; background: #e2e8f0; border-radius: .4rem; overflow: hidden; }
.bar i { display: block; height: 100%; }
.pct { font-weight: bold; font-size: .95rem; }
.photos { flex: 1 1 auto; min-height: ${photos.length <= 1 ? 14 : rows * 6}rem; display: grid; grid-template-columns: repeat(${cols}, 1fr); grid-template-rows: repeat(${rows}, 1fr); gap: .5rem; }
.photos div { position: relative; overflow: hidden; border-radius: .4rem; border: 1px solid #cdd3dc; background: #e2e8f0; }
.photos img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
.grid { display: grid; grid-template-columns: 1fr 1fr; gap: .6rem 1.8rem; }
.box h3 { font-size: .75rem; text-transform: uppercase; letter-spacing: .05rem; color: #1861bf; border-bottom: 1px solid #cdd3dc; padding-bottom: .15rem; margin-bottom: .3rem; }
.r { display: flex; justify-content: space-between; gap: .8rem; padding: .12rem 0; font-size: .95rem; }
.l { color: #545d68; font-size: .78rem; text-transform: uppercase; letter-spacing: .02rem; flex-shrink: 0; align-self: center; }
.v { font-weight: bold; text-align: right; }
.note { font-size: .92rem; }
.ex { display: flex; justify-content: space-between; gap: 1rem; font-size: .9rem; padding: .08rem 0; }
.ex.t { border-top: 1px solid #1a2530; margin-top: .2rem; padding-top: .25rem; font-weight: bold; }
.ft { margin-top: auto; border-top: 1px solid #cdd3dc; padding-top: .35rem; font-size: .75rem; color: #545d68; display: flex; justify-content: space-between; gap: 1rem; }
</style></head><body><div class="page"><div id="sheet">
<div class="hd"><div class="seal">🏛</div><div><h2>DILG SAPIAN, CAPIZ</h2><p>Project Details</p></div><div class="code">${esc(p.code)}</div></div>
<div><h1>${esc(p.title)}</h1></div>
<div class="badges"><span class="b" style="background:${color}">${esc(p.status)}</span>${u ? `<span class="b" style="background:${reviewColor}">${review}</span>` : ''}<div class="bar"><i style="width:${pct}%;background:${color}"></i></div><span class="pct">${pct}%</span></div>
${photos.length ? `<div class="photos">${photos.map(s => `<div><img src="${esc(s)}" alt=""></div>`).join('')}</div>` : ''}
<div class="grid">
  <div class="box"><h3>Project</h3>${r('Barangay', esc(p.barangay))}${r('Location', txt(p.location))}${r('Project Type', txt(p.category))}${r('Mode of Implementation', txt(p.modeOfImplementation))}</div>
  <div class="box"><h3>Budget</h3>${r('Project Cost', fmtMoney(p.cost))}${r('Allocated Budget', fmtMoney(p.allocatedBudget))}${r('Amount Utilized', fmtMoney(p.amountUtilized))}</div>
  <div class="box" style="grid-column:1 / -1;"><h3>Project Timeframe</h3><div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.2rem;">${r('Date Started', dt(p.startDate))}${r('Target Completion', dt(p.targetDate))}${r('Date Completed', dt(p.dateCompleted))}</div></div>
</div>
${p.remarks ? `<div class="box"><h3>Remarks</h3><div class="note">${esc(p.remarks)}</div></div>` : ''}
${items.length ? `<div class="box"><h3>Project List of Expenses</h3>${items.map(it => `<div class="ex"><span>${esc(it.label)}</span><span>${fmtMoney(it.amount)}</span></div>`).join('')}<div class="ex t"><span>TOTAL EXPENSES</span><span>${fmtMoney(items.reduce((s, it) => s + (Number(it.amount) || 0), 0))}</span></div></div>` : (p.desc ? `<div class="box"><h3>Description</h3><div class="note">${esc(p.desc)}</div></div>` : '')}
<div class="ft"><span>Printed: ${esc(new Date().toLocaleString('en-PH'))}${u ? ' · ' + esc(u.name) : ''}</span><span>System-generated record · dilg_pms</span></div>
</div></div></body></html>`;
  }

  // Largest root font size at which the whole sheet still fits inside the page; photos then grow to fill what is left.
  function fitPrintSheet(doc, spec, margin) {
    const availH = (spec.h - 1 - margin * 2) * (96 / 25.4) - 2;
    const sheet = doc.getElementById('sheet'), root = doc.documentElement;
    sheet.style.height = 'auto';
    let lo = 6, hi = 18;
    for (let i = 0; i < 14; i++) {
      const mid = (lo + hi) / 2;
      root.style.fontSize = mid + 'px';
      if (sheet.scrollHeight <= availH) lo = mid; else hi = mid;
    }
    root.style.fontSize = lo + 'px';
    sheet.style.height = availH + 'px';
  }

  async function printPublicReceipt() {
    const p = masterProjectsDatabase[detailState.idx];
    if (!p) return;
    const spec = PRINT_PAPERS[document.getElementById('receiptPaper').value] || PRINT_PAPERS.A4;
    const margin = 10;
    const iframe = document.getElementById('printOutputFrame');
    const idleStyle = 'display:none;position:fixed;inset:0;width:100%;height:100%;border:none;';
    iframe.style.cssText = `display:block;position:fixed;left:-10000px;top:0;width:${spec.w}mm;height:${spec.h}mm;border:none;`;
    const doc = iframe.contentWindow.document;
    doc.open(); doc.write(buildReceiptPrintHTML(p, spec, margin)); doc.close();
    await new Promise(r => setTimeout(r, 60));
    await Promise.all(Array.from(doc.images).map(im => im.decode ? im.decode().catch(() => {}) : Promise.resolve()));
    fitPrintSheet(doc, spec, margin);
    iframe.contentWindow.focus();
    iframe.contentWindow.print();
    setTimeout(() => { iframe.style.cssText = idleStyle; }, 1500);
  }

  function closePublicReceipt() {
    document.getElementById('publicReceiptModal').style.display = 'none';
  }

  /* PHOTO LIGHTBOX */
  function openLightbox(i) {
    detailState.lb = i;
    updateLightbox();
    document.getElementById('photoLightbox').style.display = 'flex';
  }
  function updateLightbox() {
    const n = detailState.photos.length;
    if (!n) return;
    detailState.lb = (detailState.lb + n) % n;
    document.getElementById('lightboxImg').src = detailState.photos[detailState.lb];
    document.getElementById('lightboxCounter').textContent = `${detailState.lb + 1} / ${n}`;
    document.querySelectorAll('#photoLightbox .lb-nav').forEach(b => b.style.display = n > 1 ? '' : 'none');
  }
  function stepLightbox(d) { detailState.lb += d; updateLightbox(); }
  function closeLightbox() { document.getElementById('photoLightbox').style.display = 'none'; }
  document.addEventListener('keydown', e => {
    if (document.getElementById('photoLightbox').style.display !== 'flex') return;
    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowRight') stepLightbox(1);
    if (e.key === 'ArrowLeft') stepLightbox(-1);
  });
</script>
</body>
</html>
