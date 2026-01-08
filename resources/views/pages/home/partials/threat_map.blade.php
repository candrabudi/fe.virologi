<!-- Leaflet Map CDN (Cloudflare) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js" referrerpolicy="no-referrer"></script>

<!-- 4. Global Threat Monitor (Holographic Glass) -->
<section id="threat-map-section" class="py-24 lg:py-32 bg-transparent relative overflow-hidden"
    x-data="{
        map: null,
        attackLayer: null,
        logs: [],
        cities: [
            { name: 'Singapore', coords: [1.3521, 103.8198] },
            { name: 'New York', coords: [40.7128, -74.0060] },
            { name: 'London', coords: [51.5074, -0.1278] },
            { name: 'Jakarta', coords: [-6.2088, 106.8456] },
            { name: 'Sydney', coords: [-33.8688, 151.2093] },
            { name: 'Tokyo', coords: [35.6762, 139.6503] },
            { name: 'Berlin', coords: [52.5200, 13.4050] },
            { name: 'Dubai', coords: [25.2048, 55.2708] },
            { name: 'Moscow', coords: [55.7558, 37.6173] },
            { name: 'San Francisco', coords: [37.7749, -122.4194] },
            { name: 'Sao Paulo', coords: [-23.5505, -46.6333] }
        ],
        initMap() {
            // Check frequently for Leaflet
            if (typeof L === 'undefined') {
                setTimeout(() => this.initMap(), 50);
                return;
            }
            
            // Initialize Map
            this.map = L.map('threat-map', {
                zoomControl: false,
                scrollWheelZoom: false,
                doubleClickZoom: false,
                dragging: false, 
                attributionControl: false,
                center: [20, 0], 
                zoom: window.innerWidth < 768 ? 0.8 : 1.6, // Adjusted zoom for mobile
                zoomSnap: 0.1,
                renderer: L.svg({ padding: 1 })
            });
            
            // Fix for partial map loading: Force resize calculation multiple times
            setTimeout(() => { this.map.invalidateSize(); }, 100);
            setTimeout(() => { this.map.invalidateSize(); }, 1000);
            
            // Watch for resize
            window.addEventListener('resize', () => { 
                if(this.map) {
                    this.map.invalidateSize();
                    this.map.setZoom(window.innerWidth < 768 ? 0.8 : 1.6);
                }
            });
            
            this.attackLayer = L.layerGroup().addTo(this.map);

            // Light Canvas with Blue Tint via CSS
            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                maxZoom: 16,
                attribution: 'CartoDB'
            }).addTo(this.map);

            // Add City Markers
            this.cities.forEach(city => {
                L.circleMarker(city.coords, {
                    radius: 3,
                    fillColor: '#0284c7', // Sky 700
                    color: '#0284c7',
                    weight: 1,
                    opacity: 0.8,
                    fillOpacity: 1
                }).addTo(this.map);
            });

            // Initial logs
            this.addLog('Glass-Link Established.', 'info');
            
            // Start Attack Simulation
            setInterval(() => this.generateAttack(), 2200);
        },
        generateAttack() {
            if (!this.map) return;
            // ... (rest of logic same) ...
            
            const startCity = this.cities[Math.floor(Math.random() * this.cities.length)];
            const endCity = this.cities[Math.floor(Math.random() * this.cities.length)];
            
            if (startCity.name === endCity.name) return;

            // Generate Curve Points (Quadratic Bezier on Lat/Lng)
            const latlngs = [];
            const p0 = { x: startCity.coords[0], y: startCity.coords[1] };
            const p2 = { x: endCity.coords[0], y: endCity.coords[1] };
            
            // Control point: midpoint + offset
            // We offset latitude (y) to create an arc
            const midX = (p0.x + p2.x) / 2;
            const midY = (p0.y + p2.y) / 2;
            const dist = Math.sqrt(Math.pow(p2.x - p0.x, 2) + Math.pow(p2.y - p0.y, 2));
            
            // The 'arch' height - offset latitude based on longitude distance
            // Simple curve logic for map
            const offset = dist * 0.3; 
            const p1 = { x: midX + offset, y: midY + offset }; // Offset both to make it interesting

            for (let t = 0; t <= 1; t += 0.05) {
                const x = (1 - t) * (1 - t) * p0.x + 2 * (1 - t) * t * p1.x + t * t * p2.x;
                const y = (1 - t) * (1 - t) * p0.y + 2 * (1 - t) * t * p1.y + t * t * p2.y;
                latlngs.push([x, y]);
            }

            // Create Polyline (The Beam)
            const polyline = L.polyline(latlngs, {
                color: '#0ea5e9', // Sky Blue for clean look
                weight: 2,
                opacity: 0.6,
                className: 'animate-comet-path', // We will reuse this class
                lineCap: 'round'
            }).addTo(this.attackLayer);

            // Create Impact Marker
            const impact = L.circleMarker(endCity.coords, { radius: 0, color: '#ef4444', fillColor: '#ef4444', fillOpacity: 0.4 }).addTo(this.attackLayer);
            
            this.addLog(`Threat neutralized: ${startCity.name} -> ${endCity.name}`, 'warning');

            // Cleanup
            setTimeout(() => {
                this.attackLayer.removeLayer(polyline);
                this.attackLayer.removeLayer(impact);
            }, 3000); 
        },
        addLog(message, type = 'info') {
            const time = new Date().toLocaleTimeString([], { hour12: false, hour: '2-digit', minute: '2-digit', second: '2-digit' });
            this.logs.unshift({ time, message, type });
            if (this.logs.length > 7) this.logs.pop();
        }
    }" 
    x-init="initMap()">
    
    <!-- Clean Background Accents -->
    <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-slate-200 to-transparent"></div>
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_0%_0%,rgba(14,165,233,0.03)_0%,transparent_50%)]"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col lg:flex-row items-stretch gap-12 lg:gap-16">
            
            <!-- Monitor Frame (Holographic) -->
            <div class="flex-1 w-full" data-aos="fade-right">
                <div class="glossy-card h-full rounded-[2.5rem] overflow-hidden relative group">
                    <!-- Reflection Shine -->
                    <div class="absolute inset-0 bg-gradient-to-tr from-white/40 via-transparent to-transparent pointer-events-none z-20"></div>
                    
                    <!-- Top Bar UI -->
                    <div class="absolute top-0 inset-x-0 h-16 bg-white/60 backdrop-blur-md border-b border-white/40 flex items-center justify-between px-8 z-20">
                        <div class="flex items-center space-x-3">
                            <div class="flex space-x-1.5">
                                <span class="w-3 h-3 rounded-full bg-red-400/80 shadow-sm"></span>
                                <span class="w-3 h-3 rounded-full bg-amber-400/80 shadow-sm"></span>
                                <span class="w-3 h-3 rounded-full bg-emerald-400/80 shadow-sm"></span>
                            </div>
                        </div>
                        <div class="px-3 py-1 bg-slate-100/50 rounded-lg border border-white/60 text-[10px] font-mono text-slate-500 font-bold tracking-widest">Global_Grid_v9.0</div>
                    </div>

                    <!-- Map Container -->
                    <div class="relative pt-16 pb-12 w-full h-full min-h-[450px] flex items-center justify-center bg-sky-50/30">
                        <!-- Leaflet Map Div -->
                        <div id="threat-map" class="w-full h-full min-h-[300px] z-0 opacity-80 mix-blend-multiply contrast-100 saturate-150"></div>
                        
                        <!-- Animated Scanner Line -->
                        <div class="absolute top-0 left-0 w-full h-1 bg-sky-400/30 shadow-[0_0_20px_rgba(56,189,248,0.5)] animate-[scan_4s_linear_infinite] z-10 pointer-events-none"></div>
                    </div>

                    <!-- Bottom Bar -->
                    <div class="absolute bottom-0 inset-x-0 h-16 bg-white/60 backdrop-blur-md border-t border-white/40 flex items-center justify-between px-8 z-20">
                         <div class="flex items-center space-x-2">
                             <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                             <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">System Active</span>
                         </div>
                         <div class="text-[10px] font-mono text-slate-400">
                             Vectors: <span class="text-slate-700" x-text="Math.floor(Math.random()*200+50)"></span>
                         </div>
                    </div>
                </div>
            </div>

            <!-- Terminal & Content -->
            <div class="flex-1 flex flex-col justify-center" data-aos="fade-left" x-show="sections.threatmap">
                <div>
                    <div class="inline-flex items-center px-4 py-1.5 rounded-full border border-sky-200 bg-white/50 backdrop-blur-sm shadow-sm mb-8">
                        <span class="text-[10px] font-bold text-sky-600 uppercase tracking-[0.2em]" x-text="sections.threatmap?.badge_text || 'Threat Intelligence'"></span>
                    </div>
                    
                    <h2 class="text-4xl lg:text-5xl font-bold heading-font text-slate-900 mb-6 leading-tight tracking-tight">
                        <span x-html="sections.threatmap?.title ? sections.threatmap.title.replace('Shield.', '<span class=\'text-sky-600\'>Shield.</span>') : 'Global <br/><span class=\'text-sky-600\'>Cyber Shield.</span>'"></span>
                    </h2>
                    
                    <p class="text-slate-600 mb-10 text-sm leading-relaxed max-w-md font-light" x-text="sections.threatmap?.description">
                    </p>

                    <!-- Log Output (Glass Terminal) -->
                    <div class="glossy-card rounded-2xl p-6 font-mono text-[11px] h-56 overflow-hidden relative">
                        <div class="absolute top-3 right-4 text-[9px] text-slate-400 uppercase font-bold tracking-widest opacity-70">/var/log/secure</div>
                        <div class="space-y-2 mt-2">
                            <template x-for="log in logs" :key="log.time + log.message">
                                <div class="flex space-x-3 items-start animate-fade-in border-b border-slate-200/50 pb-1 last:border-0">
                                    <span class="text-slate-400 w-16" x-text="log.time"></span>
                                    <span :class="{
                                        'text-emerald-600': log.type === 'info',
                                        'text-amber-600': log.type === 'warning',
                                        'text-red-600': log.type === 'error'
                                    }" class="font-bold">>></span>
                                    <span class="text-slate-700 font-medium" x-text="log.message"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="mt-10">
                <!-- CTA Button -->
                <template x-if="sections.threatmap?.primary_button_text">
                    <button @click="window.location.href = sections.threatmap.primary_button_url" class="group relative px-8 py-4 bg-red-500/10 border border-red-500/50 text-red-500 rounded-xl font-bold text-xs uppercase tracking-[0.2em] hover:bg-red-500 hover:text-white transition-all overflow-hidden">
                        <span class="relative z-10 flex items-center justify-center gap-3">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 group-hover:bg-white animate-pulse"></span>
                            <span x-text="sections.threatmap.primary_button_text"></span>
                        </span>
                        <!-- Hover Glitch Effect -->
                        <div class="absolute inset-0 bg-red-600 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300 z-0"></div>
                    </button>
                </template>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Leaflet overrides for dark mode */
    .leaflet-container {
        background: transparent !important;
    }
    
    @keyframes scan {
        0% { transform: translateY(-500%); opacity: 0; }
        50% { opacity: 0.5; }
        100% { transform: translateY(500%); opacity: 0; }
    }
    
    .animate-comet-path {
        stroke-dasharray: 0 500;
        animation: comet-draw 3s ease-out forwards;
    }
    
    @keyframes comet-draw {
        0% { stroke-dasharray: 0 500; stroke-dashoffset: 0; opacity: 1; }
        10% { opacity: 1; }
        90% { opacity: 1; }
        100% { stroke-dasharray: 500 0; stroke-dashoffset: -500; opacity: 0; }
    }

    .animate-fade-in {
        animation: log-fade 0.4s ease-out forwards;
    }

    @keyframes log-fade {
        from { transform: translateX(-10px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
</style>
