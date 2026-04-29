<div class="modal fade" id="modalClaimGift" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:500px;">
        <div class="modal-content" style="background:#fff; border:1px solid #E2D9CC; border-radius:4px; box-shadow:0 12px 40px rgba(13,13,13,0.15);">
            <div class="modal-header" style="background:linear-gradient(135deg,#0D0D0D,#1C1C17); border-bottom:1px solid #E2D9CC; position:relative; padding:16px 24px;">
                <div style="position:absolute; top:0; left:0; right:0; height:2px; background:linear-gradient(90deg,#C9A84C,#8B6914,#C9A84C);"></div>
                <div>
                    <div style="font-size:0.62rem; letter-spacing:0.2em; text-transform:uppercase; color:rgba(201,168,76,0.8); font-family:'Lato',sans-serif; margin-bottom:4px;">Eksklusif Member</div>
                    <h5 class="modal-title" style="font-family:'Playfair Display',serif; color:#fff; font-size:1.3rem;">Katalog Reward Anda</h5>
                </div>
                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body" style="padding:24px; max-height:60vh; overflow-y:auto; background:#FAF7F2;">
                <!-- Jika kosong -->
                <div x-show="availableRewards.length === 0" style="text-align:center; padding:30px 20px; color:#6B6560;">
                    <i class="fa-solid fa-gift" style="font-size:3rem; color:#E2D9CC; margin-bottom:16px;"></i>
                    <div style="font-family:'Playfair Display',serif; font-size:1.1rem; color:#0D0D0D;">Belum ada reward yang dapat ditukar</div>
                    <p style="font-family:'Lato',sans-serif; font-size:0.85rem; margin-top:8px;">Kumpulkan poin lebih banyak untuk menukar hadiah eksklusif.</p>
                </div>

                <!-- Loop hadiah -->
                <div class="reward-list" style="display:flex; flex-direction:column; gap:16px;">
                    <template x-for="reward in availableRewards" :key="reward.id">
                        <div class="reward-card" style="
                            background:#fff; border:1px solid #E2D9CC; border-radius:4px;
                            display:flex; gap:16px; padding:16px; align-items:center;
                            transition:all 0.3s;
                        " onmouseover="this.style.borderColor='#C9A84C'; this.style.transform='translateY(-2px)';" 
                           onmouseout="this.style.borderColor='#E2D9CC'; this.style.transform='translateY(0)';">
                            
                            <img :src="reward.image_url" x-show="reward.image_url" style="width:70px; height:70px; object-fit:cover; border-radius:3px; border:1px solid #F0EAE0;">
                            <div x-show="!reward.image_url" style="width:70px; height:70px; background:#F5EDD8; display:flex; align-items:center; justify-content:center; border-radius:3px; color:#C9A84C;">
                                <i class="fa-solid fa-gift fa-2x"></i>
                            </div>
                            
                            <div style="flex:1;">
                                <h6 style="font-family:'Playfair Display',serif; color:#0D0D0D; font-size:1.05rem; font-weight:700; margin:0 0 4px;" x-text="reward.name"></h6>
                                <p style="font-family:'Lato',sans-serif; color:#6B6560; font-size:0.75rem; margin:0 0 8px;" x-text="reward.description"></p>
                                <span style="display:inline-block; background:#F5EDD8; color:#8B6914; padding:2px 8px; border-radius:12px; font-family:'Lato',sans-serif; font-size:0.7rem; font-weight:700;">
                                    <i class="fa-solid fa-star" style="font-size:0.6rem; margin-right:4px;"></i><span x-text="reward.points_required + ' Poin'"></span>
                                </span>
                            </div>

                            <button type="button" @click="selectReward(reward)" style="
                                background:linear-gradient(135deg,#C9A84C,#8B6914); color:#fff;
                                border:none; padding:8px 16px; border-radius:3px;
                                font-family:'Lato',sans-serif; font-size:0.78rem; font-weight:700;
                                cursor:pointer; transition:all 0.3s; align-self:center;
                            " onmouseover="this.style.boxShadow='0 4px 12px rgba(201,168,76,0.4)'" onmouseout="this.style.boxShadow='none'">
                                Tukar
                            </button>
                        </div>
                    </template>
                </div>
            </div>
            
            <div class="modal-footer" style="padding:16px 24px; border-top:1px solid #E2D9CC; background:#fff;">
                <button type="button" style="background:transparent; border:1px solid #E2D9CC; color:#6B6560; padding:8px 24px; border-radius:3px; font-family:'Lato',sans-serif; font-size:0.8rem; font-weight:700;" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
