<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $title ?? 'Sointech MVP' }}</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* Premium Dark Mode Colors */
            --bg-color: #0b0f19;
            --card-bg: rgba(30, 41, 59, 0.6);
            --card-border: rgba(255, 255, 255, 0.05);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --accent-indigo: #6366f1;
            --accent-indigo-hover: #4f46e5;
            --accent-amber: #f59e0b;
            --success: #10b981;
            --danger: #ef4444;
            --glass-blur: blur(12px);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            min-height: 100vh;
            padding-bottom: 80px; /* Space for bottom navbar */
            overflow-x: hidden;
        }

        /* Top Header */
        header {
            background: rgba(11, 15, 25, 0.8);
            backdrop-filter: var(--glass-blur);
            padding: 1rem;
            position: sticky;
            top: 0;
            z-index: 40;
            border-bottom: 1px solid var(--card-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--accent-indigo);
            margin: 0;
        }

        /* Main Container */
        main {
            padding: 1rem;
            max-width: 800px;
            margin: 0 auto;
        }

        /* Bottom Navbar */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 70px;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: var(--glass-blur);
            border-top: 1px solid var(--card-border);
            display: flex;
            justify-content: space-around;
            align-items: center;
            z-index: 50;
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.75rem;
            transition: all 0.2s ease;
        }

        .nav-item.active {
            color: var(--accent-indigo);
        }

        .nav-item svg {
            width: 24px;
            height: 24px;
            margin-bottom: 4px;
        }

        .nav-item:active {
            transform: scale(0.95);
        }

        /* Premium Forms and Buttons */
        .card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            backdrop-filter: var(--glass-blur);
        }

        .card-header {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: white;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            font-size: 0.875rem;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        input[type="text"], input[type="number"], input[type="email"], select, textarea, input[type="file"] {
            width: 100%;
            background: rgba(15, 23, 42, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 0.875rem 1rem;
            color: var(--text-main);
            font-size: 1rem;
            transition: border-color 0.2s;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--accent-indigo);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent-indigo), var(--accent-indigo-hover));
            color: white;
            border: none;
            border-radius: 12px;
            padding: 1rem;
            font-size: 1rem;
            font-weight: 600;
            width: 100%;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
            transition: all 0.2s;
        }

        .btn-primary:active {
            transform: translateY(2px);
            box-shadow: 0 2px 6px rgba(99, 102, 241, 0.3);
        }

        /* Checkbox Buttons */
        .btn-group {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .btn-check {
            flex: 1;
            padding: 0.75rem 0.25rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            background: transparent;
            color: var(--text-muted);
            cursor: pointer;
            text-align: center;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .btn-check.selected-ok { background: rgba(16, 185, 129, 0.15); color: var(--success); border-color: var(--success); }
        .btn-check.selected-fail { background: rgba(239, 68, 68, 0.15); color: var(--danger); border-color: var(--danger); }
        .btn-check.selected-na { background: rgba(245, 158, 11, 0.15); color: var(--accent-amber); border-color: var(--accent-amber); }

        /* Canvas */
        .signature-pad {
            border: 2px dashed rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.02);
            width: 100%;
            height: 200px;
            touch-action: none;
        }

        .legal-text {
            font-size: 0.75rem;
            color: var(--text-muted);
            line-height: 1.4;
            margin-top: 0.5rem;
            text-align: justify;
        }
        
        .flex-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
    @livewireStyles
</head>
<body>
    <header>
        <h1>Sointech</h1>
        <div style="width:32px; height:32px; border-radius:50%; background:var(--accent-indigo); display:flex; align-items:center; justify-content:center; font-weight:bold;">
            T
        </div>
    </header>

    <main>
        {{ $slot }}
    </main>

    <nav class="bottom-nav">
        <a href="/" class="nav-item">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            Inicio
        </a>
        <a href="/nueva-orden" class="nav-item active">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Crear OT
        </a>
        <a href="/inventario" class="nav-item">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            Stock
        </a>
        <a href="/clientes" class="nav-item">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            Clientes
        </a>
    <script>
        window.compressAndUploadPhoto = function(event, wireProperty, wireComponent) {
            const input = event.target;
            if (!input.files || !input.files[0]) return;
            const file = input.files[0];

            const uploadFile = (fileToUpload) => {
                if (!wireComponent) return;
                wireComponent.upload(wireProperty, fileToUpload,
                    () => { input.value = ''; },
                    (error) => { console.error('Upload error:', error); }
                );
            };

            if (file.type.startsWith('image/') || file.name.match(/\.(heic|heif|jpg|jpeg|png|webp)$/i)) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = new Image();
                    img.onload = function() {
                        const maxDim = 1600;
                        let w = img.width, h = img.height;
                        if (w > maxDim || h > maxDim) {
                            if (w > h) { h = Math.round((h * maxDim) / w); w = maxDim; }
                            else { w = Math.round((w * maxDim) / h); h = maxDim; }
                        }
                        const canvas = document.createElement('canvas');
                        canvas.width = w; canvas.height = h;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0, w, h);
                        canvas.toBlob(function(blob) {
                            if (!blob) { uploadFile(file); return; }
                            const newName = (file.name || 'foto').replace(/\.[^/.]+$/, '') + '.jpg';
                            const compressedFile = new File([blob], newName, { type: 'image/jpeg' });
                            uploadFile(compressedFile);
                        }, 'image/jpeg', 0.82);
                    };
                    img.onerror = function() { uploadFile(file); };
                    img.src = e.target.result;
                };
                reader.onerror = function() { uploadFile(file); };
                reader.readAsDataURL(file);
            } else {
                uploadFile(file);
            }
        };

        window.compressAndUploadMultiplePhotos = function(event, wireProperty, wireComponent) {
            const input = event.target;
            if (!input.files || input.files.length === 0) return;

            const files = Array.from(input.files);
            const compressedFiles = [];
            let processed = 0;

            const uploadAll = () => {
                if (!wireComponent) return;
                wireComponent.uploadMultiple(wireProperty, compressedFiles,
                    () => { input.value = ''; },
                    (error) => { console.error('Multiple upload error:', error); }
                );
            };

            files.forEach((file, index) => {
                if (file.type.startsWith('image/') || file.name.match(/\.(heic|heif|jpg|jpeg|png|webp)$/i)) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = new Image();
                        img.onload = function() {
                            const maxDim = 1600;
                            let w = img.width, h = img.height;
                            if (w > maxDim || h > maxDim) {
                                if (w > h) { h = Math.round((h * maxDim) / w); w = maxDim; }
                                else { w = Math.round((w * maxDim) / h); h = maxDim; }
                            }
                            const canvas = document.createElement('canvas');
                            canvas.width = w; canvas.height = h;
                            const ctx = canvas.getContext('2d');
                            ctx.drawImage(img, 0, 0, w, h);
                            canvas.toBlob(function(blob) {
                                if (!blob) {
                                    compressedFiles.push(file);
                                } else {
                                    const newName = (file.name || `foto_${index}`).replace(/\.[^/.]+$/, '') + '.jpg';
                                    compressedFiles.push(new File([blob], newName, { type: 'image/jpeg' }));
                                }
                                processed++;
                                if (processed === files.length) uploadAll();
                            }, 'image/jpeg', 0.82);
                        };
                        img.onerror = function() {
                            compressedFiles.push(file);
                            processed++;
                            if (processed === files.length) uploadAll();
                        };
                        img.src = e.target.result;
                    };
                    reader.onerror = function() {
                        compressedFiles.push(file);
                        processed++;
                        if (processed === files.length) uploadAll();
                    };
                    reader.readAsDataURL(file);
                } else {
                    compressedFiles.push(file);
                    processed++;
                    if (processed === files.length) uploadAll();
                }
            });
        };
    </script>
    @livewireScripts
</body>
</html>
