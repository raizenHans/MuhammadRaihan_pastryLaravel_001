@extends('layouts.app')
@section('title', 'Checkout — Artorious Pastry')

@section('content')
<div x-data="checkoutProcess()">
    <!-- Header -->
    <div style="margin-bottom:28px;">
        <div style="font-family:'Lato',sans-serif; font-size:0.65rem; letter-spacing:0.25em; text-transform:uppercase; color:#C9A84C; margin-bottom:6px;">✦ &nbsp; Konfirmasi Pesanan</div>
        <h1 style="font-family:'Playfair Display',serif; font-size:1.9rem; color:#0D0D0D; margin:0;">Checkout</h1>
    </div>

    <div class="row g-4">
        <!-- Order Items -->
        <div class="col-md-7">
            <div style="background:#fff; border:1px solid #E2D9CC; border-radius:4px; overflow:hidden; margin-bottom:20px;">
                <div style="background:linear-gradient(135deg,#0D0D0D,#1C1C17); padding:14px 20px; position:relative;">
                    <div style="position:absolute; top:0; left:0; right:0; height:2px; background:linear-gradient(90deg,#C9A84C,#8B6914,#C9A84C);"></div>
                    <span style="font-family:'Lato',sans-serif; font-weight:700; color:#fff; font-size:0.82rem; letter-spacing:0.08em; text-transform:uppercase;"><i class="fa-solid fa-list-check" style="color:#C9A84C; margin-right:8px;"></i>Rincian Pesanan</span>
                </div>
                <div style="padding:0;">
                    @foreach($cartItems as $cart)
                    <div style="display:flex; justify-content:space-between; align-items:center; padding:14px 20px; border-bottom:1px solid #F0EAE0; transition:background 0.2s;" onmouseover="this.style.background='#FAF7F2'" onmouseout="this.style.background='transparent'">
                        <div>
                            <div style="font-family:'Playfair Display',serif; font-size:0.95rem; font-weight:600; color:#0D0D0D; margin-bottom:2px;">{{ $cart->product_name }}</div>
                            <div style="font-family:'Lato',sans-serif; font-size:0.78rem; color:#6B6560;">{{ $cart->quantity }} × Rp {{ number_format($cart->price, 0, ',', '.') }}</div>
                        </div>
                        <div style="font-family:'Playfair Display',serif; font-size:0.95rem; font-weight:600; color:#8B6914;">Rp {{ number_format($cart->subtotal, 0, ',', '.') }}</div>
                    </div>
                    @endforeach
                    <!-- Total row -->
                    <div style="display:flex; justify-content:space-between; align-items:center; padding:14px 20px; background:#FAF7F2;">
                        <span style="font-family:'Lato',sans-serif; font-size:0.82rem; font-weight:700; color:#6B6560; text-transform:uppercase; letter-spacing:0.06em;">Total Belanja</span>
                        <span style="font-family:'Playfair Display',serif; font-size:1.25rem; font-weight:700; color:#8B6914;">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Checkout Form -->
        <div class="col-md-5">
            <div style="background:#fff; border:1px solid #E2D9CC; border-radius:4px; overflow:hidden; position:sticky; top:20px;">
                <div style="background:linear-gradient(135deg,#0D0D0D,#1C1C17); padding:14px 20px; position:relative;">
                    <div style="position:absolute; top:0; left:0; right:0; height:2px; background:linear-gradient(90deg,#C9A84C,#8B6914,#C9A84C);"></div>
                    <span style="font-family:'Lato',sans-serif; font-weight:700; color:#fff; font-size:0.82rem; letter-spacing:0.08em; text-transform:uppercase;"><i class="fa-solid fa-pen-to-square" style="color:#C9A84C; margin-right:8px;"></i>Informasi Pemesan</span>
                </div>
                <div style="padding:24px;">
                    <form action="{{ route('checkout.process') }}" method="POST">
                        @csrf

                        <!-- Customer Name -->
                        <div style="margin-bottom:18px;">
                            <label style="font-family:'Lato',sans-serif; font-size:0.72rem; font-weight:700; letter-spacing:0.1em; text-transform:uppercase; color:#6B6560; display:block; margin-bottom:6px;">
                                Nama Pelanggan <span style="color:#6B2D3E;">*</span>
                            </label>
                            <input type="text" name="customer_name"
                                   style="width:100%; border:1px solid #E2D9CC; border-radius:3px; padding:11px 14px; font-family:'Lato',sans-serif; font-size:0.9rem; color:#0D0D0D; transition:all 0.3s; outline:none;"
                                   placeholder="Nama untuk pesanan ini"
                                   onfocus="this.style.borderColor='#C9A84C'; this.style.boxShadow='0 0 0 3px rgba(201,168,76,0.15)';"
                                   onblur="this.style.borderColor='#E2D9CC'; this.style.boxShadow='none';"
                                   required>
                        </div>

                        <!-- Member Code -->
                        <div style="margin-bottom:18px;">
                            <label style="font-family:'Lato',sans-serif; font-size:0.72rem; font-weight:700; letter-spacing:0.1em; text-transform:uppercase; color:#6B6560; display:block; margin-bottom:6px;">
                                Kode Member <span style="color:rgba(107,101,96,0.6); font-weight:400;">(Opsional)</span>
                            </label>
                            <div style="display:flex; gap:0;">
                                <input type="text" name="member_code" x-model="memberCode"
                                       style="flex:1; border:1px solid #E2D9CC; border-right:none; border-radius:3px 0 0 3px; padding:11px 14px; font-family:'Lato',sans-serif; font-size:0.9rem; outline:none; transition:all 0.3s;"
                                       placeholder="CS-XXXXXXX"
                                       onfocus="this.style.borderColor='#C9A84C'; this.style.boxShadow='0 0 0 3px rgba(201,168,76,0.15)';"
                                       onblur="this.style.borderColor='#E2D9CC'; this.style.boxShadow='none';">
                                <button type="button" @click="checkMemberInfo" style="
                                    background:linear-gradient(135deg,#C9A84C,#8B6914); color:#fff;
                                    border:none; padding:0 16px;
                                    border-radius:0 3px 3px 0;
                                    font-family:'Lato',sans-serif; font-size:0.78rem; font-weight:700;
                                    cursor:pointer; white-space:nowrap; letter-spacing:0.05em;
                                    transition:all 0.3s;
                                ">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                            <div style="font-family:'Lato',sans-serif; font-size:0.72rem; color:#6B6560; margin-top:5px;">
                                <i class="fa-solid fa-circle-info" style="color:#C9A84C;"></i> Diskon otomatis untuk belanja ≥ Rp 100.000
                            </div>
                        </div>

                        <!-- Member Info Box -->
                        <div x-show="showMemberInfo" x-transition style="background:#F0F7F4; border:1px solid #1D4D30; border-left:4px solid #2D7A4F; border-radius:3px; padding:12px 16px; margin-bottom:18px;">
                            <div style="font-family:'Lato',sans-serif; font-size:0.82rem; font-weight:700; color:#2D7A4F; margin-bottom:4px;">
                                <i class="fa-solid fa-check-circle"></i> Member Valid!
                            </div>
                            <div style="font-family:'Lato',sans-serif; font-size:0.78rem; color:#0D0D0D; margin-bottom: 2px;" x-text="memberName"></div>
                            <div style="font-family:'Lato',sans-serif; font-size:0.78rem; color:#0D0D0D;">Poin Anda: <strong x-text="memberPoints + ' pts'"></strong></div>
                            
                            <!-- Reward Claim Info -->
                            <div x-show="claimedRewardName" style="margin-top:8px; padding-top:8px; border-top:1px dashed #2D7A4F;">
                                <div style="font-family:'Lato',sans-serif; font-size:0.75rem; color:#2D7A4F;">Hadiah Dipilih:</div>
                                <div style="font-family:'Playfair Display',serif; font-size:0.9rem; font-weight:700; color:#1D4D30;" x-text="claimedRewardName"></div>
                                <button type="button" @click="cancelReward" style="background:none; border:none; color:#6B2D3E; font-size:0.7rem; padding:0; cursor:pointer; text-decoration:underline; font-family:'Lato',sans-serif;">Batalkan Hadiah</button>
                            </div>

                            <button type="button" x-show="availableRewards.length > 0 && !claimedRewardId" style="
                                margin-top:10px; width:100%;
                                background:transparent; border:1px solid #C9A84C; color:#8B6914;
                                padding:7px; border-radius:3px;
                                font-family:'Lato',sans-serif; font-size:0.78rem; font-weight:700;
                                cursor:pointer; transition:all 0.3s;
                            " data-bs-toggle="modal" data-bs-target="#modalClaimGift">
                                <i class="fa-solid fa-gift"></i> Tukar Poin (<span x-text="availableRewards.length"></span> Hadiah)
                            </button>
                        </div>

                        <input type="hidden" name="claimed_reward_id" x-model="claimedRewardId">

                        <!-- Gold Divider -->
                        <div style="height:1px; background:linear-gradient(90deg,transparent,#E2D9CC,transparent); margin:16px 0;"></div>

                        <!-- Total -->
                        <div style="background:#F5EDD8; border:1px solid #E2D9CC; border-radius:3px; padding:12px 16px; display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
                            <span style="font-family:'Lato',sans-serif; font-size:0.75rem; font-weight:700; letter-spacing:0.08em; text-transform:uppercase; color:#6B6560;">Total Tagihan</span>
                            <div>
                                <span style="font-family:'Lato',sans-serif; font-size:0.72rem; color:#8B6914; font-weight:700;">Rp</span>
                                <span style="font-family:'Playfair Display',serif; font-size:1.3rem; color:#8B6914; font-weight:700;">{{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <button type="submit" style="
                            width:100%;
                            background:linear-gradient(135deg,#C9A84C,#8B6914);
                            color:#fff; border:none; padding:13px;
                            border-radius:3px;
                            font-family:'Lato',sans-serif; font-size:0.85rem; font-weight:700;
                            letter-spacing:0.08em; text-transform:uppercase; cursor:pointer;
                            display:flex; align-items:center; justify-content:center; gap:8px;
                            transition:all 0.3s;
                        "
                        onmouseover="this.style.background='linear-gradient(135deg,#8B6914,#5A4008)'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 20px rgba(201,168,76,0.4)';"
                        onmouseout="this.style.background='linear-gradient(135deg,#C9A84C,#8B6914)'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                            <i class="fa-solid fa-check-double"></i> Konfirmasi Pesanan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('components.modal-claim-gift')
</div>
@endsection

@push('scripts')
<script>
function checkoutProcess() {
    return {
        memberCode: '',
        showMemberInfo: false,
        loadingMember: false,
        memberName: '',
        memberPoints: 0,
        availableRewards: [],
        claimedRewardId: null,
        claimedRewardName: null,

        async checkMemberInfo() {
            if (this.memberCode.trim() === '') return;
            this.loadingMember = true;
            this.showMemberInfo = false;
            this.claimedRewardId = null;
            this.claimedRewardName = null;

            try {
                const res = await fetch(`{{ route('checkout.member.info') }}?code=${this.memberCode.trim()}`);
                const data = await res.json();
                
                if (data.success) {
                    this.memberName = data.member_name;
                    this.memberPoints = data.points;
                    this.availableRewards = data.available_rewards;
                    this.showMemberInfo = true;
                } else {
                    alert(data.message || 'Member tidak ditemukan.');
                }
            } catch(e) {
                console.error(e);
                alert('Terjadi kesalahan saat memeriksa kode member.');
            }
            this.loadingMember = false;
        },

        selectReward(reward) {
            this.claimedRewardId = reward.id;
            this.claimedRewardName = reward.name;
            const modalEl = document.getElementById('modalClaimGift');
            if (modalEl) {
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();
            }
        },

        cancelReward() {
            this.claimedRewardId = null;
            this.claimedRewardName = null;
        }
    }
}
</script>
@endpush
