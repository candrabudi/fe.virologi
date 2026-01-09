<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>VIROLOGI - LIVE CYBER THREAT MAP</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- D3 & Datamaps Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.17/d3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/topojson/1.6.9/topojson.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datamaps/0.5.9/datamaps.world.min.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&family=JetBrains+Mono:wght@400;700&display=swap');

        :root {
            --bg: #03060b;
            --neon: #00b4ff;
            --red: #ff1e6d;
            --cyan: #00e5ff;
            --grid: rgba(0, 180, 255, .03);
        }

        body {
            background-color: var(--bg);
            color: #ffffff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow: hidden;
            margin: 0;
            height: 100vh;
            width: 100vw;
        }

        /* Latar belakang grid futuristik */
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(to right, var(--grid) 1px, transparent 1px),
                linear-gradient(to bottom, var(--grid) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
            z-index: 1;
        }

        #map-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            cursor: grab;
            background: radial-gradient(circle at center, #0a1322 0%, #03060b 100%);
        }

        #map-container:active {
            cursor: grabbing;
        }

        .datamaps-subunit {
            fill: rgba(15, 25, 45, 0.7) !important;
            stroke: rgba(0, 180, 255, 0.2) !important;
            stroke-width: 0.8px !important;
        }

        /* Panel Header Kiri Atas */
        #header-panel {
            position: fixed;
            top: 85px; /* Shifted down for breathing room */
            left: 15px;
            z-index: 100;
            background: rgba(8, 12, 20, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 180, 255, 0.15);
            padding: 12px;
            border-radius: 6px;
            width: 260px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.6);
            transition: all 0.3s ease;
        }

        .header-title {
            font-weight: 700;
            font-size: 11px;
            color: var(--neon);
            letter-spacing: 0.5px;
            margin-bottom: 2px;
            text-transform: uppercase;
        }

        .header-subtitle {
            font-size: 9px;
            color: #64748b;
            margin-bottom: 8px;
            line-height: 1.2;
        }

        .header-metric-row {
            display: flex;
            align-items: baseline;
            gap: 6px;
            margin-bottom: 8px;
        }

        .header-metric-value {
            font-family: 'JetBrains Mono', monospace;
            font-size: 24px;
            font-weight: 700;
            color: #ffffff;
            line-height: 1;
        }

        .header-metric-label {
            font-size: 9px;
            color: #94a3b8;
            text-transform: uppercase;
        }

        .header-breakdown {
            display: flex;
            gap: 8px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            padding-top: 8px;
        }

        .header-pill {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 9px;
            font-weight: 600;
        }

        .header-pill-dot {
            width: 4px;
            height: 4px;
            border-radius: 50%;
        }

        .header-pill-high {
            color: var(--red);
        }

        .header-pill-high .header-pill-dot {
            background: var(--red);
            box-shadow: 0 0 4px var(--red);
        }

        .header-pill-low {
            color: #10b981;
        }

        .header-pill-low .header-pill-dot {
            background: #10b981;
            box-shadow: 0 0 4px #10b981;
        }

        /* Tombol Toggle Flow Detail */
        .toggle-flow-btn {
            position: fixed;
            top: 15px;
            right: 15px;
            z-index: 102;
            width: 32px;
            height: 32px;
            background: rgba(8, 12, 20, 0.9);
            border: 1px solid rgba(0, 180, 255, 0.4);
            border-radius: 4px;
            color: var(--neon);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 0 10px rgba(0, 180, 255, 0.2);
        }

        .toggle-flow-btn.active {
            right: 310px;
        }

        /* Tampilan Flow Detail */
        #flowdetail {
            position: fixed;
            top: 15px;
            right: 15px;
            width: 280px;
            background: rgba(8, 12, 20, 0.9);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(0, 180, 255, 0.2);
            border-radius: 6px;
            z-index: 101;
            font-size: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            max-height: calc(100vh - 150px);
            display: flex;
            flex-direction: column;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease;
            transform: translateX(320px);
            opacity: 0;
            pointer-events: none;
        }

        #flowdetail.visible {
            transform: translateX(0);
            opacity: 1;
            pointer-events: auto;
        }

        .flowdetail-title {
            padding: 10px 12px;
            background: rgba(0, 180, 255, 0.1);
            border-bottom: 1px solid rgba(0, 180, 255, 0.2);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--neon);
            display: flex;
            justify-content: space-between;
            flex-shrink: 0;
        }

        .flowdetail-content {
            padding: 12px;
            overflow-y: auto;
            flex-grow: 1;
        }

        .flowdetail-metrics {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 6px;
            margin-bottom: 12px;
        }

        .flowdetail-metric-chip {
            background: rgba(255, 255, 255, 0.03);
            padding: 6px;
            border-radius: 4px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .flowdetail-metric-label {
            font-size: 7px;
            color: #64748b;
            margin-bottom: 2px;
            text-transform: uppercase;
        }

        .flowdetail-metric-value {
            font-family: 'JetBrains Mono';
            font-weight: 700;
            font-size: 12px;
        }

        .flowdetail-section {
            margin-bottom: 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            padding-top: 8px;
        }

        .flowdetail-section-title {
            font-size: 8px;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 6px;
            font-weight: 700;
        }

        .flowdetail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
            gap: 8px;
        }

        .flowdetail-label {
            color: #94a3b8;
            flex-shrink: 0;
        }

        .flowdetail-value {
            text-align: right;
            color: #f1f5f9;
            word-break: break-all;
            font-size: 9px;
        }

        /* Log Serangan Baru di Kiri Bawah */
        .attack-wrapper {
            position: fixed;
            bottom: 15px;
            left: 15px;
            width: 580px;
            z-index: 100;
            mask-image: linear-gradient(to top, black 85%, transparent 100%);
        }

        #attackdiv {
            max-height: 250px;
            overflow-y: hidden;
            display: flex;
            flex-direction: column-reverse;
            gap: 6px;
            font-family: 'JetBrains Mono', monospace;
        }

        .log-entry {
            background: rgba(8, 12, 20, 0.85);
            backdrop-filter: blur(4px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 8px 12px;
            font-size: 9px;
            border-left: 3px solid var(--neon);
            animation: slideInLeft 0.3s ease-out forwards;
        }

        @keyframes slideInLeft {
            from {
                transform: translateX(-20px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .log-main {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 4px;
            color: #cbd5e1;
        }

        .log-time {
            color: #64748b;
        }

        .attack-source {
            color: #ffffff;
            font-weight: 700;
        }

        .log-ip {
            color: #94a3b8;
            opacity: 0.8;
        }

        .attack-target {
            color: var(--cyan);
            font-weight: 700;
        }

        .attack-type {
            color: #f1f5f9;
            font-weight: 700;
            padding: 1px 4px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 2px;
        }

        .log-meta {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 8px;
            border-top: 1px solid rgba(255, 255, 255, 0.03);
            padding-top: 4px;
        }

        .log-severity {
            font-weight: 800;
            text-transform: uppercase;
            padding: 1px 6px;
            border-radius: 2px;
        }

        .log-severity--high {
            color: #ffffff;
            background: var(--red);
        }

        .log-severity--low {
            color: #ffffff;
            background: #10b981;
        }

        /* KONTROL NAVIGASI (Kanan Bawah) */
        .map-controls {
            position: fixed;
            bottom: 30px;
            right: 30px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            z-index: 200;
        }

        .ctrl-btn {
            width: 44px;
            height: 44px;
            background: rgba(8, 12, 20, 0.9);
            border: 1px solid rgba(0, 180, 255, 0.4);
            border-radius: 8px;
            color: var(--neon);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(8px);
        }

        .ctrl-btn:hover {
            background: var(--neon);
            color: #000;
            box-shadow: 0 0 15px rgba(0, 180, 255, 0.6);
            transform: translateY(-2px);
        }

        .ctrl-btn:active {
            transform: scale(0.9);
        }

        .ctrl-btn svg {
            width: 22px;
            height: 22px;
            stroke-width: 2.5px;
        }

        /* Tooltip simple */
        .ctrl-btn::after {
            content: attr(data-label);
            position: absolute;
            right: 60px;
            background: rgba(0, 180, 255, 0.9);
            color: #000;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s;
        }

        .ctrl-btn:hover::after {
            opacity: 1;
        }

        /* Animasi Arc Serangan */
        .custom-arc {
            fill: none;
            stroke-dasharray: 1000;
            stroke-dashoffset: 1000;
            animation: arcPathAnim 2s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            pointer-events: none;
        }

        @keyframes arcPathAnim {
            0% {
                stroke-dashoffset: 1000;
                opacity: 0;
            }

            20% {
                opacity: 1;
            }

            80% {
                opacity: 1;
            }

            100% {
                stroke-dashoffset: 0;
                opacity: 0;
            }
        }

        .impact-circle {
            fill: none;
            stroke-width: 2;
            animation: pulseImpact 1.2s ease-out forwards;
        }

        @keyframes pulseImpact {
            0% {
                r: 0;
                opacity: 1;
                stroke-width: 4;
            }

            100% {
                r: 30;
                opacity: 0;
                stroke-width: 1;
            }
        }

        /* UNIFIED: Bottom Action Buttons */
        .bottom-actions {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 12px;
            z-index: 200;
            padding: 8px;
            background: rgba(8, 12, 20, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 180, 255, 0.15);
            border-radius: 8px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
        }

        .action-btn {
            background: rgba(15, 23, 42, 0.4);
            border: 1px solid rgba(0, 180, 255, 0.3);
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            white-space: nowrap;
            /* Glossy effect */
            background-image: linear-gradient(180deg, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
        }

        .action-btn i {
            font-size: 18px;
            color: var(--neon);
            filter: drop-shadow(0 0 5px rgba(0, 180, 255, 0.3));
        }

        .action-btn:hover {
            background-color: rgba(0, 180, 255, 0.15);
            border-color: var(--neon);
            box-shadow: 0 0 20px rgba(0, 180, 255, 0.3);
            transform: translateY(-2px);
        }

        .action-btn:active {
            transform: translateY(0) scale(0.98);
        }

        /* HIGH-TECH: Home Button (Standalone) */
        .home-btn {
            position: fixed;
            top: 20px;
            left: 15px;
            z-index: 201;
            padding: 0 16px;
            height: 48px;
            background: rgba(8, 12, 20, 0.6);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(0, 180, 255, 0.3);
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            overflow: hidden;
        }

        .home-btn::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.05),
                transparent
            );
            transition: 0.5s;
        }

        .home-btn:hover::before {
            left: 100%;
        }

        .home-btn i {
            color: var(--neon);
            font-size: 22px;
            filter: drop-shadow(0 0 8px rgba(0, 180, 255, 0.6));
            transition: all 0.3s ease;
        }

        .home-btn span {
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            white-space: nowrap;
        }

        .home-btn:hover {
            border-color: var(--neon);
            background: rgba(0, 180, 255, 0.1);
            transform: translateX(5px);
            box-shadow: 0 0 20px rgba(0, 180, 255, 0.3);
        }

        .home-btn:hover i {
            transform: scale(1.1);
        }

        /* ============================================================ 
           COMPREHENSIVE MOBILE RESPONSIVE OVERHAUL 
           ============================================================ */
        @media (max-width: 640px) {
            /* 1. Global Scale */
            body { font-size: 14px; }

            /* 2. Top Elements (Stacked Layout) */
            .home-btn {
                top: 10px;
                left: 10px;
                right: 10px;
                height: 42px;
                width: calc(100% - 20px);
                justify-content: center;
                background: rgba(8, 12, 20, 0.9);
                border-radius: 6px;
                z-index: 205;
                padding: 0 10px;
            }

            #header-panel {
                top: 60px; /* Below home-btn */
                left: 10px;
                right: 10px;
                width: calc(100% - 20px);
                padding: 12px;
                background: rgba(8, 12, 20, 0.85);
                backdrop-filter: blur(8px);
                z-index: 200;
            }

            .header-title { font-size: 10px; }
            .header-metric-value { font-size: 20px; }
            .header-metric-row { margin-bottom: 4px; }
            .header-subtitle, .header-breakdown { display: none; } /* Space saver */

            /* 3. Side Panels (Flow Detail) */
            #flowdetail {
                top: 10px;
                right: 10px;
                left: 10px;
                width: calc(100% - 20px);
                max-height: 45vh;
                z-index: 300;
            }

            .toggle-flow-btn {
                top: auto !important;
                bottom: 85px !important; /* Above bottom buttons */
                right: 15px !important;
                left: auto !important;
                width: 44px;
                height: 44px;
                background: var(--neon);
                color: #000;
                border: none;
                border-radius: 50%;
                box-shadow: 0 4px 15px rgba(0, 180, 255, 0.4);
                z-index: 250;
            }

            /* 4. Attack Logs (Floating Above Actions) */
            .attack-wrapper {
                bottom: 140px !important;
                left: 10px !important;
                width: calc(100% - 20px) !important;
                max-height: 90px;
                mask-image: linear-gradient(to top, black 70%, transparent 100%) !important;
                pointer-events: none;
                z-index: 150;
            }

            .log-entry { font-size: 8px; padding: 6px 10px; }
            .log-meta { display: none; } /* Simplify logs */

            /* 5. Bottom Action Buttons */
            .bottom-actions {
                bottom: 15px;
                left: 10px;
                right: 10px;
                width: calc(100% - 20px);
                transform: none;
                padding: 6px;
                gap: 8px;
                border-radius: 10px;
                z-index: 210;
            }

            .action-btn {
                padding: 12px 5px;
                font-size: 10px;
                flex: 1;
                justify-content: center;
                border-radius: 6px;
                letter-spacing: 0.5px;
            }

            /* 6. Hide Controls */
            .map-controls { display: none !important; }
        }
    </style>

</head>

<body>

    <div id="map-container"></div>

    <!-- Header Stats -->
    <!-- Pastikan Remix Icon sudah di-load -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">

    <!-- Tombol Back to Home (Standalone) -->
    <a href="/" class="home-btn" title="Back to Homepage">
        <i class="ri-arrow-left-up-line"></i>
        <span>Back to Portal</span>
    </a>

    <div id="header-panel">
        <div class="header-title">VIROLOGI CYBER THREAT MONITOR</div>
        <div class="header-subtitle">Total serangan terdeteksi secara real-time</div>
        <div class="header-metric-row">
            <span id="total-attacks" class="header-metric-value">0</span>
            <span class="header-metric-label">serangan</span>
        </div>
        <div class="header-breakdown">
            <span class="header-pill header-pill-high"><span class="header-pill-dot"></span>High: <span
                    id="total-high">0</span></span>
            <span class="header-pill header-pill-low"><span class="header-pill-dot"></span>Low: <span
                    id="total-low">0</span></span>
        </div>
    </div>


    <!-- Toggle Flow Detail -->
    <button id="toggle-flow-btn" class="toggle-flow-btn" onclick="toggleFlowPanel()">
        <svg id="toggle-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
            <path d="M15 18l-6-6 6-6" />
        </svg>
    </button>

    <!-- Panel Flow Detail -->
    <div id="flowdetail">
        <div class="flowdetail-title"><span>Flow Detail</span><span style="font-size: 8px; opacity: 0.6;">LIVE
                FEED</span></div>
        <div id="flowdetail-content" class="flowdetail-content">
            <div class="flowdetail-metrics">
                <div class="flowdetail-metric-chip">
                    <div class="flowdetail-metric-label">Total</div>
                    <div id="fd-total" class="flowdetail-metric-value">0</div>
                </div>
                <div class="flowdetail-metric-chip">
                    <div class="flowdetail-metric-label">High</div>
                    <div id="fd-high" class="flowdetail-metric-value text-pink-500">0</div>
                </div>
                <div class="flowdetail-metric-chip">
                    <div class="flowdetail-metric-label">Low</div>
                    <div id="fd-low" class="flowdetail-metric-value text-emerald-400">0</div>
                </div>
            </div>
            <div class="flowdetail-section">
                <div class="flowdetail-section-title">Summary</div>
                <div class="flowdetail-row"><span class="flowdetail-label">Type</span><span id="fd-type"
                        class="flowdetail-value text-cyan-400 font-bold">-</span></div>
                <div class="flowdetail-row"><span class="flowdetail-label">Severity</span><span id="fd-severity"
                        class="flowdetail-value">-</span></div>
                <div class="flowdetail-row"><span class="flowdetail-label">Timestamp</span><span id="fd-time"
                        class="flowdetail-value">-</span></div>
            </div>
            <div class="flowdetail-section">
                <div class="flowdetail-section-title">Nodes</div>
                <div class="flowdetail-row"><span class="flowdetail-label">SRC</span><span id="fd-src"
                        class="flowdetail-value">-</span></div>
                <div class="flowdetail-row"><span class="flowdetail-label">DST</span><span id="fd-dst"
                        class="flowdetail-value">-</span></div>
            </div>
            <div class="flowdetail-section">
                <div class="flowdetail-section-title">Technical</div>
                <div class="flowdetail-row"><span class="flowdetail-label">Protocol</span><span id="fd-proto"
                        class="flowdetail-value">-</span></div>
                <div class="flowdetail-row"><span class="flowdetail-label">Size</span><span id="fd-size"
                        class="flowdetail-value">-</span></div>
            </div>
        </div>
    </div>

    <!-- Log Serangan (Kiri Bawah) -->
    <div class="attack-wrapper">
        <div id="attackdiv"></div>
    </div>

    <!-- KONTROL NAVIGASI -->
    <div class="map-controls">
        <button class="ctrl-btn" data-label="Zoom In" onclick="zoomManual(1.2)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round"
                stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
        </button>
        <button class="ctrl-btn" data-label="Zoom Out" onclick="zoomManual(0.8)">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round"
                stroke-linejoin="round">
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
        </button>
        <button class="ctrl-btn" data-label="Reset Map" onclick="resetMap()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"></path>
                <path d="M21 3v5h-5"></path>
                <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"></path>
                <path d="M3 21v-5h5"></path>
            </svg>
        </button>
    </div>

    <!-- Bottom Action Buttons -->
    <div class="bottom-actions">
        <a href="/underattacks" class="action-btn">
            <i class="ri-shield-flash-line"></i>
            <span>Underattacks</span>
        </a>
        <a href="/about-us" class="action-btn">
            <i class="ri-customer-service-2-line"></i>
            <span>Contact Us</span>
        </a>
    </div>

    <script>
        const ATTACK_COLORS = [
            '#ef4444', // merah
            '#22c55e', // hijau
            '#eab308' // kuning
        ];

        function getAttackColor(severity = '') {
            if (severity && severity.includes('HIGH')) {
                return '#ef4444'; // HIGH selalu merah
            }
            return ATTACK_COLORS[Math.floor(Math.random() * ATTACK_COLORS.length)];
        }


        let nodes = [];

        let map, svg, mainG;
        let currentScale = 1;
        let currentTranslate = [0, 0];

        let stats = {
            total: 0,
            high: 0,
            low: 0
        };

        let isFlowVisible = false;

        /* =======================
         * LOAD MASTER NODES
         * ======================= */
        async function loadNodes() {
            try {
                const res = await fetch('/attack/nodes');
                const json = await res.json();
                nodes = json.nodes || [];
            } catch (e) {
                console.error('Failed load nodes', e);
            }
        }

        /* =======================
         * FLOW PANEL TOGGLE
         * ======================= */
        function toggleFlowPanel() {
            const panel = document.getElementById('flowdetail');
            const btn = document.getElementById('toggle-flow-btn');
            const icon = document.getElementById('toggle-icon');

            isFlowVisible = !isFlowVisible;

            if (isFlowVisible) {
                panel.classList.add('visible');
                btn.classList.add('active');
                icon.innerHTML = '<path d="M9 18l6-6-6-6"/>';
            } else {
                panel.classList.remove('visible');
                btn.classList.remove('active');
                icon.innerHTML = '<path d="M15 18l-6-6 6-6"/>';
            }
        }

        /* =======================
         * MAP INIT
         * ======================= */
        function initMap() {
            const container = document.getElementById('map-container');
            container.innerHTML = '';

            map = new Datamap({
                element: container,
                projection: 'mercator',
                fills: {
                    defaultFill: 'rgba(15, 25, 45, 0.7)'
                },
                geographyConfig: {
                    borderWidth: 0.5,
                    borderColor: 'rgba(0,180,255,0.15)',
                    highlightFillColor: 'rgba(0,180,255,0.05)',
                    highlightBorderColor: 'rgba(0,180,255,0.3)',
                    popupOnHover: false
                }
            });

            svg = d3.select('#map-container svg');
            mainG = svg.select('g');

            if (mainG.select('.custom-layer').empty()) {
                mainG.append('g').attr('class', 'custom-layer');
            }

            svg.call(
                d3.behavior.drag().on('drag', function() {
                    currentTranslate[0] += d3.event.dx;
                    currentTranslate[1] += d3.event.dy;
                    applyTransform();
                })
            );

            svg.on('wheel.zoom', function() {
                d3.event.preventDefault();
                zoomManual(d3.event.deltaY > 0 ? 0.9 : 1.1);
            });
        }

        function zoomManual(factor) {
            currentScale *= factor;
            currentScale = Math.max(0.6, Math.min(currentScale, 12));
            applyTransform(true);
        }

        function applyTransform(animate = false) {
            const target = animate ?
                mainG.transition().duration(400).ease('cubic-out') :
                mainG;

            target.attr(
                'transform',
                `translate(${currentTranslate[0]}, ${currentTranslate[1]}) scale(${currentScale})`
            );
        }

        /* =======================
         * DRAW ARC
         * ======================= */
        function drawManualArc(src, dst, color) {
            const layer = mainG.select('.custom-layer');

            const start = map.projection([src.lng, src.lat]);
            const end = map.projection([dst.lng, dst.lat]);
            if (!start || !end) return;

            const dx = end[0] - start[0];
            const dy = end[1] - start[1];
            const cpX = (start[0] + end[0]) / 2 - dy * 0.15;
            const cpY = (start[1] + end[1]) / 2 + dx * 0.15;

            layer.append('path')
                .attr('d', `M${start[0]},${start[1]} Q${cpX},${cpY} ${end[0]},${end[1]}`)
                .attr('class', 'custom-arc')
                .style('stroke', color)
                .style('stroke-width', 2 / currentScale);

            setTimeout(() => {
                const c = layer.append('circle')
                    .attr('cx', end[0])
                    .attr('cy', end[1])
                    .attr('r', 0)
                    .attr('class', 'impact-circle')
                    .attr('stroke', color);

                setTimeout(() => c.remove(), 1500);
            }, 1800);
        }

        /* =======================
         * FIRE ATTACK (DB)
         * ======================= */
        async function createAttackBurst() {
            if (!map || nodes.length === 0) return;

            try {
                const res = await fetch('/attack/fire');
                const json = await res.json();
                if (!json.success) return;

                let delay = 0;

                json.attacks.forEach(a => {
                    setTimeout(() => {
                        const severity = a.severity || 'LOW';
                        const color = getAttackColor(severity);

                        stats.total++;
                        if (severity.includes('HIGH')) stats.high++;
                        else stats.low++;

                        updateUI(a, a.src);
                        drawManualArc(a.src, a.dst, color);
                    }, delay);

                    delay += Math.floor(Math.random() * 300) + 100;
                });


            } catch (e) {
                console.error('Attack fetch failed', e);
            }
        }

        /* =======================
         * UI UPDATE
         * ======================= */
        function updateUI(info, src, color) {
            document.getElementById('total-attacks').innerText = stats.total;
            document.getElementById('total-high').innerText = stats.high;
            document.getElementById('total-low').innerText = stats.low;

            document.getElementById('fd-total').innerText = stats.total;
            document.getElementById('fd-high').innerText = stats.high;
            document.getElementById('fd-low').innerText = stats.low;

            updateLog(src, info, color); // <-- pass color
            updateFlow(src, info);
        }

        function updateLog(src, info, color) {
            const div = document.getElementById('attackdiv');

            const entry = document.createElement('div');
            entry.className = 'log-entry';
            entry.innerHTML = `
        <div class="log-main">
            <span class="log-time">[${info.time}]</span>
            <span class="attack-source" style="color:${color}">${src.name}</span>
            <span class="log-ip">(${info.ip_src})</span>
            <span class="attack-target">→</span>
            <span class="attack-target" style="color:${color}">${info.dst.name}</span>
            <span class="log-ip">(${info.ip_dst})</span>
            <span class="log-type">[${info.type}]</span>
        </div>
        <div class="log-meta">
            <span class="log-severity" style="color:${color}">${info.severity}</span>
            <span class="log-proto">${info.proto}</span>
            <span class="log-size">${info.size}</span>
            <span class="log-action">${info.action}</span>
        </div>
    `;

            div.appendChild(entry);
            if (div.children.length > 8) div.removeChild(div.firstChild);
        }


        function updateFlow(src, info) {
            document.getElementById('fd-type').innerText = info.type;
            document.getElementById('fd-severity').innerText = info.severity;
            document.getElementById('fd-time').innerText = info.time;
            document.getElementById('fd-src').innerText = src.name;
            document.getElementById('fd-dst').innerText = info.dst.name;
            document.getElementById('fd-proto').innerText = info.proto;
            document.getElementById('fd-size').innerText = info.size;
        }

        /* =======================
         * INIT
         * ======================= */
        window.onload = async function() {
            await loadNodes();
            initMap();

            setInterval(createAttackBurst, 1500);

            setTimeout(() => {
                if (!isFlowVisible) toggleFlowPanel();
            }, 1000);
        };

        window.onresize = () => initMap();
    </script>


</body>

</html>
