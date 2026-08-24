<!-- ===== GLOBAL TOUCH LIGHTBOX & CAROUSEL COMPONENT ===== -->
<div 
    id="global-lightbox" 
    class="fixed inset-0 hidden flex-col items-center justify-between p-3 sm:p-5 select-none transition-opacity duration-300 opacity-0"
    style="z-index: 99999999 !important; background: rgba(4, 7, 13, 0.97); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); touch-action: none; overscroll-behavior: contain;"
>
    <!-- Top Minimalist Header Bar -->
    <div class="w-full flex items-center justify-between gap-3 shrink-0 z-20 max-w-5xl mx-auto pt-1">
        <!-- Title & Category Badge -->
        <div class="flex items-center gap-2 overflow-hidden">
            <span id="gl-title" class="text-xs sm:text-sm font-extrabold text-white tracking-tight truncate max-w-[200px] sm:max-w-md">
                Evidencia Fotográfica
            </span>
            <span id="gl-counter" class="hidden px-2.5 py-0.5 rounded-full text-[10px] font-black tracking-widest bg-blue-500/20 text-blue-300 border border-blue-500/30">
                1 / 1
            </span>
        </div>

        <!-- Close Button -->
        <button 
            type="button"
            onclick="closeGlobalLightbox()" 
            class="w-10 h-10 rounded-2xl bg-gray-900/80 border border-gray-700/80 text-gray-300 hover:text-white hover:bg-gray-800 hover:border-gray-600 active:scale-95 transition-all duration-200 flex items-center justify-center shadow-lg shrink-0 cursor-pointer"
            aria-label="Cerrar modal"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Centered Main Image Viewport with Nav Arrows -->
    <div 
        id="gl-viewport" 
        class="relative flex-1 w-full flex items-center justify-center overflow-hidden mx-auto my-auto p-2 sm:p-4 cursor-grab active:cursor-grabbing"
    >
        <!-- Desktop Previous Button (Anchored to far left of viewport) -->
        <button 
            id="gl-btn-prev"
            type="button"
            onclick="glPrevImage(event)" 
            class="fixed left-3 md:left-8 top-1/2 -translate-y-1/2 z-40 w-12 h-12 rounded-2xl bg-gray-900/90 border border-gray-700/90 text-white hover:text-white hover:bg-blue-600 hover:border-blue-500 active:scale-90 transition-all duration-200 hidden md:flex items-center justify-center shadow-2xl backdrop-blur-md cursor-pointer"
            aria-label="Foto anterior"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>

        <!-- Image Container for Scale & Pan Transforms -->
        <div id="gl-img-wrapper" class="relative max-w-full max-h-full flex items-center justify-center transition-transform duration-150 ease-out">
            <img 
                id="global-lightbox-img" 
                src="" 
                alt="Imagen ampliada"
                class="w-auto h-auto object-contain rounded-none border border-white/20 shadow-[0_25px_60px_-15px_rgba(0,0,0,0.9)] select-none"
                style="max-width: min(94vw, 1450px); max-height: min(85vh, 900px); object-fit: contain;"
                draggable="false"
            />
        </div>

        <!-- Desktop Next Button (Anchored to far right of viewport) -->
        <button 
            id="gl-btn-next"
            type="button"
            onclick="glNextImage(event)" 
            class="fixed right-3 md:right-8 top-1/2 -translate-y-1/2 z-40 w-12 h-12 rounded-2xl bg-gray-900/90 border border-gray-700/90 text-white hover:text-white hover:bg-blue-600 hover:border-blue-500 active:scale-90 transition-all duration-200 hidden md:flex items-center justify-center shadow-2xl backdrop-blur-md cursor-pointer"
            aria-label="Siguiente foto"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>
    </div>

    <!-- Minimalist Bottom Title & Description Overlay -->
    <div id="gl-info-card" class="w-full max-w-xl mx-auto shrink-0 z-20 transition-opacity duration-200 hidden pb-2">
        <div class="p-3 sm:p-4 rounded-2xl bg-gray-950/90 border border-gray-700/50 backdrop-blur-xl shadow-2xl flex flex-col items-center text-center gap-1.5">
            <h4 id="gl-info-title" class="text-xs sm:text-sm font-black text-white leading-tight"></h4>
            <p id="gl-info-desc" class="text-[11px] sm:text-xs text-gray-300 font-medium leading-relaxed max-h-20 overflow-y-auto custom-scrollbar"></p>
        </div>
    </div>
</div>

<script>
    // ===== GLOBAL TOUCH LIGHTBOX & CAROUSEL ENGINE =====
    var _glState = {
        images: [],
        index: 0,
        zoom: 1,
        panX: 0,
        panY: 0,
        title: '',
        // Touch tracking
        startX: 0,
        startY: 0,
        currentX: 0,
        currentY: 0,
        isDragging: false,
        pinchDist: 0,
        lastTap: 0
    };

    function openGlobalLightbox(input, startIndex, title) {
        if (!input) return;
        
        // Handle input formats: string or array of strings/objects
        if (typeof input === 'string') {
            _glState.images = [{ src: input, title: title || '', description: '' }];
        } else if (Array.isArray(input)) {
            _glState.images = input.map(item => {
                if (typeof item === 'string') return { src: item, title: '', description: '' };
                return { 
                    src: item.src || item.url || item.image_path || '', 
                    title: item.title || item.caption || '', 
                    description: item.description || item.notes || '' 
                };
            }).filter(i => i.src);
        }

        if (_glState.images.length === 0) return;

        _glState.index = typeof startIndex === 'number' && startIndex >= 0 && startIndex < _glState.images.length ? startIndex : 0;
        _glState.title = title || 'Evidencia Fotográfica';

        _glResetZoom();
        _glUpdateDOM();

        var lb = document.getElementById('global-lightbox');
        if (!lb) return;

        // Force move lightbox to document.body root so NO parent modal or stacking context can obscure it
        if (lb.parentElement !== document.body) {
            document.body.appendChild(lb);
        }
        lb.style.zIndex = '99999999';

        lb.classList.remove('hidden');
        lb.style.display = 'flex'; // Force flex layout for proper centering on desktop
        // Trigger smooth fade in
        requestAnimationFrame(() => {
            lb.classList.remove('opacity-0');
            lb.classList.add('opacity-100');
        });

        // Strict background scroll lock
        document.body.style.overflow = 'hidden';
        document.documentElement.style.overflow = 'hidden';
        document.body.style.touchAction = 'none';

        // Add keyboard listener
        document.addEventListener('keydown', _glHandleKeyDown);
    }

    // Alias for backwards compatibility
    function openImageModal(src, title) {
        openGlobalLightbox(src, 0, title);
    }

    function closeGlobalLightbox() {
        var lb = document.getElementById('global-lightbox');
        lb.classList.remove('opacity-100');
        lb.classList.add('opacity-0');
        
        setTimeout(() => {
            lb.classList.add('hidden');
            lb.style.display = ''; // Reset display
            document.getElementById('global-lightbox-img').src = '';
            document.body.style.overflow = '';
            document.documentElement.style.overflow = '';
            document.body.style.touchAction = '';
            document.removeEventListener('keydown', _glHandleKeyDown);
            _glResetZoom();
        }, 200);
    }

    function glNextImage(e) {
        if (e) e.stopPropagation();
        if (_glState.images.length <= 1) return;
        _glState.index = (_glState.index + 1) % _glState.images.length;
        _glResetZoom();
        _glUpdateDOM();
    }

    function glPrevImage(e) {
        if (e) e.stopPropagation();
        if (_glState.images.length <= 1) return;
        _glState.index = (_glState.index - 1 + _glState.images.length) % _glState.images.length;
        _glResetZoom();
        _glUpdateDOM();
    }

    function _glResetZoom() {
        _glState.zoom = 1;
        _glState.panX = 0;
        _glState.panY = 0;
        _glApplyTransforms();
    }

    function _glApplyTransforms() {
        var wrapper = document.getElementById('gl-img-wrapper');
        if (wrapper) {
            wrapper.style.transform = `translate3d(${_glState.panX}px, ${_glState.panY}px, 0) scale(${_glState.zoom})`;
        }
    }

    function _glUpdateDOM() {
        var current = _glState.images[_glState.index];
        if (!current) return;

        var img = document.getElementById('global-lightbox-img');
        img.src = current.src;

        // Title
        document.getElementById('gl-title').textContent = _glState.title;

        // Counter
        var counter = document.getElementById('gl-counter');
        if (_glState.images.length > 1) {
            counter.textContent = `${_glState.index + 1} / ${_glState.images.length}`;
            counter.classList.remove('hidden');
        } else {
            counter.classList.add('hidden');
        }

        // Nav Buttons (Hidden on mobile touch screens, subtle on desktop)
        var prevBtn = document.getElementById('gl-btn-prev');
        var nextBtn = document.getElementById('gl-btn-next');
        if (_glState.images.length > 1 && window.innerWidth >= 768) {
            prevBtn.style.display = 'flex';
            nextBtn.style.display = 'flex';
        } else {
            prevBtn.style.display = 'none';
            nextBtn.style.display = 'none';
        }

        // Title & Description Info Card
        var infoCard = document.getElementById('gl-info-card');
        var infoTitle = document.getElementById('gl-info-title');
        var infoDesc = document.getElementById('gl-info-desc');

        var itemTitle = current.title || current.caption || '';
        var itemDesc = current.description || current.notes || '';

        if (itemTitle || itemDesc) {
            infoTitle.textContent = itemTitle;
            infoDesc.textContent = itemDesc;
            if (itemDesc) {
                infoDesc.classList.remove('hidden');
            } else {
                infoDesc.classList.add('hidden');
            }
            infoCard.classList.remove('hidden');
        } else {
            infoCard.classList.add('hidden');
        }
    }

    function _glHandleKeyDown(e) {
        if (e.key === 'Escape') {
            closeGlobalLightbox();
        } else if (e.key === 'ArrowRight') {
            glNextImage();
        } else if (e.key === 'ArrowLeft') {
            glPrevImage();
        }
    }

    // ===== TOUCH GESTURE RECOGNIZER & INTERACTION ENGINE =====
    document.addEventListener('DOMContentLoaded', function() {
        var viewport = document.getElementById('gl-viewport');
        var lightbox = document.getElementById('global-lightbox');
        if (!viewport || !lightbox) return;

        // Prevent scrolling background bleed when touchmoving inside lightbox
        lightbox.addEventListener('touchmove', function(e) {
            e.preventDefault();
        }, { passive: false });

        // Touch start
        viewport.addEventListener('touchstart', function(e) {
            if (e.touches.length === 1) {
                // Single touch: start drag / swipe
                _glState.startX = e.touches[0].clientX;
                _glState.startY = e.touches[0].clientY;
                _glState.currentX = _glState.startX;
                _glState.currentY = _glState.startY;
                _glState.isDragging = true;

                // Double tap detection
                var now = new Date().getTime();
                var timesince = now - _glState.lastTap;
                if (timesince < 300 && timesince > 0) {
                    // Double tap triggered
                    if (_glState.zoom > 1) {
                        _glResetZoom();
                    } else {
                        _glState.zoom = 2.5;
                        _glApplyTransforms();
                    }
                    _glState.isDragging = false;
                }
                _glState.lastTap = now;
            } else if (e.touches.length === 2) {
                // Pinch zoom start
                _glState.isDragging = false;
                _glState.pinchDist = Math.hypot(
                    e.touches[0].clientX - e.touches[1].clientX,
                    e.touches[0].clientY - e.touches[1].clientY
                );
            }
        }, { passive: true });

        // Touch move
        viewport.addEventListener('touchmove', function(e) {
            if (e.touches.length === 1 && _glState.isDragging) {
                var deltaX = e.touches[0].clientX - _glState.currentX;
                var deltaY = e.touches[0].clientY - _glState.currentY;
                _glState.currentX = e.touches[0].clientX;
                _glState.currentY = e.touches[0].clientY;

                if (_glState.zoom > 1) {
                    // Pan image when zoomed in
                    _glState.panX += deltaX;
                    _glState.panY += deltaY;
                    _glApplyTransforms();
                }
            } else if (e.touches.length === 2 && _glState.pinchDist > 0) {
                // Pinch zooming
                var newDist = Math.hypot(
                    e.touches[0].clientX - e.touches[1].clientX,
                    e.touches[0].clientY - e.touches[1].clientY
                );
                var scaleRatio = newDist / _glState.pinchDist;
                _glState.zoom = Math.min(4, Math.max(1, _glState.zoom * scaleRatio));
                _glState.pinchDist = newDist;
                _glApplyTransforms();
            }
        }, { passive: true });

        // Touch end
        viewport.addEventListener('touchend', function(e) {
            if (!_glState.isDragging) return;
            _glState.isDragging = false;

            var totalDeltaX = _glState.currentX - _glState.startX;
            var totalDeltaY = _glState.currentY - _glState.startY;

            if (_glState.zoom === 1) {
                // Swipe Left / Right to cycle photos
                if (Math.abs(totalDeltaX) > 45 && Math.abs(totalDeltaX) > Math.abs(totalDeltaY)) {
                    if (totalDeltaX < 0) {
                        glNextImage();
                    } else {
                        glPrevImage();
                    }
                }
                // Swipe Down / Up to close modal
                else if (Math.abs(totalDeltaY) > 80 && Math.abs(totalDeltaY) > Math.abs(totalDeltaX)) {
                    closeGlobalLightbox();
                }
            }
        }, { passive: true });

        // Backdrop click to close (if target is viewport or wrapper area when not zoomed)
        viewport.addEventListener('click', function(e) {
            if (e.target === viewport || e.target === document.getElementById('gl-img-wrapper')) {
                if (_glState.zoom > 1) {
                    _glResetZoom();
                } else {
                    closeGlobalLightbox();
                }
            }
        });
    });
</script>
