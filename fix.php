<?php
$content = file_get_contents('c:\laragon\www\PROVIL HIMPUNAN\resources\views\struktur-organisasi.blade.php');
$lines = explode("\n", $content);
$newLines = array_slice($lines, 0, 564);
$modalCode = <<<EOT
                                <a href="#" class="card-footer-link" style="font-size:0.78rem;" onclick="openDetailModal('Biro Ekonomi Kreatif', 'Mengembangkan usaha, kemandirian, dan potensi ekonomi organisasi.', 'https://ui-avatars.com/api/?name=Biro+Ekonomi+Kreatif&background=155C57&color=fff&size=200', 9)">Lihat &rarr;</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<!-- MODAL DETAIL -->
<div id="detailModal" class="modal-overlay">
    <div class="modal-content">
        <button class="modal-close" onclick="closeDetailModal()"><i class="fas fa-times"></i></button>
        <span class="modal-label">DETAIL JABATAN</span>
        <h2 id="modalPosition" class="modal-title"></h2>
        <p id="modalDesc" class="modal-desc"></p>
        
        <div class="modal-body-content">
            <!-- Ini slider anggota yang hardcoded sesuai gambar -->
            <div style="width: 100%; display: flex; flex-direction: column; align-items: center; gap: 20px;">
                <div style="width: 100%; height: 300px; background: #e2e8f0; border-radius: 12px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                    <img id="modalPhoto" src="" alt="Photo" style="width: 100%; height: 100%; object-fit: cover; border-radius: 12px;">
                </div>
                
                <div style="text-align: center;">
                    <h3 id="modalName" style="color: #114232; font-size: 20px; font-weight: 600; margin-bottom: 4px;"></h3>
                    <div id="modalDivision" style="color: #155C57; font-size: 12px; font-weight: 700; text-transform: uppercase;"></div>
                </div>

                <!-- Slider Controls (Tampilan Statis) -->
                <div style="display: flex; flex-direction: column; align-items: center; gap: 12px; margin-top: 10px;">
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <button style="width: 32px; height: 32px; border-radius: 50%; border: 1px solid rgba(0,0,0,0.1); background: white; color: #ccc; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                            <i class="fas fa-arrow-left" style="font-size: 12px;"></i>
                        </button>
                        <span style="color: #666; font-size: 13px; font-weight: 600;">1 / 6</span>
                        <button style="width: 32px; height: 32px; border-radius: 50%; border: 1px solid rgba(0,0,0,0.1); background: white; color: #8fa89b; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                            <i class="fas fa-arrow-right" style="font-size: 12px;"></i>
                        </button>
                    </div>
                    <div style="display: flex; gap: 6px;">
                        <span style="width: 24px; height: 4px; background: #d6af3d; border-radius: 2px;"></span>
                        <span style="width: 6px; height: 6px; background: #cbd5e1; border-radius: 50%; align-self: center;"></span>
                        <span style="width: 6px; height: 6px; background: #cbd5e1; border-radius: 50%; align-self: center;"></span>
                        <span style="width: 6px; height: 6px; background: #cbd5e1; border-radius: 50%; align-self: center;"></span>
                        <span style="width: 6px; height: 6px; background: #cbd5e1; border-radius: 50%; align-self: center;"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer" style="justify-content: flex-start; border-top: none; padding-top: 0;">
            <a href="#" id="modalDetailLink" class="btn btn-primary-custom" style="padding: 10px 20px; font-size: 13px;">Lihat Detail Jabatan</a>
        </div>
    </div>
</div>

<style>
/* CSS Modal (Disembunyikan agar tidak panjang, asumsikan sudah ada style nya di atas) */
.modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 1000; display: none; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.3s ease; }
.modal-overlay.show { display: flex; opacity: 1; }
.modal-content { background: #fdfbf7; width: 90%; max-width: 500px; border-radius: 16px; padding: 32px; position: relative; transform: translateY(20px); transition: transform 0.3s ease; max-height: 90vh; overflow-y: auto; }
.modal-overlay.show .modal-content { transform: translateY(0); }
.modal-close { position: absolute; top: 20px; right: 20px; background: none; border: 1px solid rgba(0,0,0,0.1); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #666; transition: all 0.2s; }
.modal-close:hover { background: rgba(0,0,0,0.05); }
.modal-label { display: block; font-size: 10px; font-weight: 700; letter-spacing: 2px; color: #155C57; margin-bottom: 12px; }
.modal-title { font-size: 28px; font-weight: 600; color: #114232; margin-bottom: 12px; line-height: 1.2; }
.modal-desc { font-size: 14px; color: #666; line-height: 1.6; margin-bottom: 24px; padding-bottom: 24px; border-bottom: 1px solid rgba(0,0,0,0.05); }
.modal-body-content { margin-bottom: 32px; }
.btn-primary-custom { background-color: #114232; color: #fff; border: none; font-weight: 600; transition: all 0.3s; border-radius: 8px; text-decoration: none; }
.btn-primary-custom:hover { background-color: #155C57; color: #fff; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(17,66,50,0.2); }
</style>

<script>
function openDetailModal(title, desc, photo, structId) {
    document.getElementById('modalPosition').textContent = title;
    document.getElementById('modalDesc').textContent = desc;
    
    // Karena desain gambar dari user statis nama "Anggita Nur Pratiwi", saya hardcode saja
    document.getElementById('modalName').textContent = 'Anggita Nur Pratiwi';
    document.getElementById('modalDivision').textContent = 'Kepala Biro';
    document.getElementById('modalPhoto').src = photo ? photo : 'https://ui-avatars.com/api/?name='+encodeURIComponent(title)+'&background=155C57&color=fff&size=120';
    
    let baseUrl = "{{ route('struktur-organisasi.show', ':id') }}";
    document.getElementById('modalDetailLink').href = baseUrl.replace(':id', structId || 1);

    document.getElementById('detailModal').classList.add('show');
}
function closeDetailModal() {
    document.getElementById('detailModal').classList.remove('show');
}
</script>
@endsection
EOT;
array_push($newLines, $modalCode);
file_put_contents('c:\laragon\www\PROVIL HIMPUNAN\resources\views\struktur-organisasi.blade.php', implode("\n", $newLines));
