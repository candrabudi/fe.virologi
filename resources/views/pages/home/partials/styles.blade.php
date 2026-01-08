<style>
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    @keyframes data-stream {
        0% { stroke-dashoffset: 400; opacity: 0; }
        20% { opacity: 0.8; }
        80% { opacity: 0.8; }
        100% { stroke-dashoffset: -400; opacity: 0; }
    }
    .animate-data-stream { animation: data-stream 8s linear infinite; }
    [x-cloak] { display: none !important; }
    @keyframes scan-line {
        0% { top: 0%; opacity: 0; }
        50% { opacity: 1; }
        100% { top: 100%; opacity: 0; }
    }
    @keyframes waveform {
        0%, 100% { d: path('M0 20 Q 10 5, 20 20 T 40 20 T 60 20 T 80 20 T 100 20'); }
        50% { d: path('M0 20 Q 10 35, 20 20 T 40 20 T 60 20 T 80 20 T 100 20'); }
    }
    .animate-waveform { animation: waveform 2s ease-in-out infinite; }
    .animate-waveform-slow { animation: waveform 4s ease-in-out infinite; opacity: 0.2; }

    @keyframes animate-comet {
        0% { stroke-dasharray: 0 100; stroke-dashoffset: 0; opacity: 1; }
        50% { stroke-dasharray: 20 80; stroke-dashoffset: -40; opacity: 1; }
        100% { stroke-dasharray: 0 100; stroke-dashoffset: -100; opacity: 0; }
    }
    .animate-comet {
        stroke-dasharray: 0 100;
        animation: animate-comet 3s ease-in-out infinite;
    }
    .path-trajectory { stroke-dasharray: 2 4; opacity: 0.2; }

    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
    .animate-blob { animation: blob 7s infinite; }
    .animation-delay-2000 { animation-delay: 2s; }
    .animation-delay-4000 { animation-delay: 4s; }
</style>
