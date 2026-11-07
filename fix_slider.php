<?php
$file = 'c:\laragon\www\PROVIL HIMPUNAN\resources\views\struktur-organisasi.blade.php';
$content = file_get_contents($file);

// Replace the script tag at the bottom
$newScript = <<<'EOT'
<script>
// Serialize members from PHP
const allMembers = @json($members ?? []);
let currentModalMembers = [];
let currentSlideIndex = 0;
let currentStructId = 1;

function updateModalView() {
    if(currentModalMembers.length === 0) return;
    
    const member = currentModalMembers[currentSlideIndex];
    document.getElementById('modalName').textContent = member.name;
    document.getElementById('modalDivision').textContent = member.position; // Kepala Biro, etc.
    document.getElementById('modalPhoto').src = member.photo ? '/storage/' + member.photo : 'https://ui-avatars.com/api/?name='+encodeURIComponent(member.name)+'&background=155C57&color=fff&size=120';
    
    document.getElementById('slideCounter').textContent = (currentSlideIndex + 1) + ' / ' + currentModalMembers.length;
    
    // Render dots
    const dotsContainer = document.getElementById('slideDots');
    dotsContainer.innerHTML = '';
    for(let i=0; i<currentModalMembers.length; i++) {
        let dot = document.createElement('span');
        if(i === currentSlideIndex) {
            dot.style.cssText = "width: 24px; height: 4px; background: #d6af3d; border-radius: 2px;";
        } else {
            dot.style.cssText = "width: 6px; height: 6px; background: #cbd5e1; border-radius: 50%; align-self: center; cursor: pointer;";
            dot.onclick = () => { currentSlideIndex = i; updateModalView(); };
        }
        dotsContainer.appendChild(dot);
    }
}

function slidePrev() {
    if(currentModalMembers.length <= 1) return;
    currentSlideIndex--;
    if(currentSlideIndex < 0) currentSlideIndex = currentModalMembers.length - 1;
    updateModalView();
}

function slideNext() {
    if(currentModalMembers.length <= 1) return;
    currentSlideIndex++;
    if(currentSlideIndex >= currentModalMembers.length) currentSlideIndex = 0;
    updateModalView();
}

function openDetailModal(title, desc, photo, structId) {
    document.getElementById('modalPosition').textContent = title;
    document.getElementById('modalDesc').textContent = desc;
    
    currentStructId = structId || 1;
    
    // Find members for this division/title
    currentModalMembers = allMembers.filter(m => m.division === title || m.position === title);
    
    // Fallback if no members found
    if(currentModalMembers.length === 0) {
        currentModalMembers = [{
            name: 'Belum ada data',
            position: '-',
            photo: null
        }];
    }
    
    currentSlideIndex = 0;
    updateModalView();
    
    let baseUrl = "{{ route('struktur-organisasi.show', ':id') }}";
    document.getElementById('modalDetailLink').href = baseUrl.replace(':id', currentStructId);

    document.getElementById('detailModal').classList.add('show');
}

function closeDetailModal() {
    document.getElementById('detailModal').classList.remove('show');
}
</script>
EOT;

$htmlFix = <<<'EOT'
                <!-- Slider Controls (Tampilan Statis) -->
                <div style="display: flex; flex-direction: column; align-items: center; gap: 12px; margin-top: 10px;">
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <button onclick="slidePrev()" style="width: 32px; height: 32px; border-radius: 50%; border: 1px solid rgba(0,0,0,0.1); background: white; color: #ccc; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                            <i class="fas fa-arrow-left" style="font-size: 12px;"></i>
                        </button>
                        <span id="slideCounter" style="color: #666; font-size: 13px; font-weight: 600;">1 / 6</span>
                        <button onclick="slideNext()" style="width: 32px; height: 32px; border-radius: 50%; border: 1px solid rgba(0,0,0,0.1); background: white; color: #8fa89b; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                            <i class="fas fa-arrow-right" style="font-size: 12px;"></i>
                        </button>
                    </div>
                    <div id="slideDots" style="display: flex; gap: 6px;">
                        <span style="width: 24px; height: 4px; background: #d6af3d; border-radius: 2px;"></span>
                        <span style="width: 6px; height: 6px; background: #cbd5e1; border-radius: 50%; align-self: center;"></span>
                    </div>
                </div>
EOT;

$content = preg_replace('/<script>\s*function openDetailModal.*?<\/script>/s', $newScript, $content);
$content = preg_replace('/<!-- Slider Controls.*?<\/div>\s*<\/div>/s', $htmlFix, $content);

file_put_contents($file, $content);
echo "Done";
