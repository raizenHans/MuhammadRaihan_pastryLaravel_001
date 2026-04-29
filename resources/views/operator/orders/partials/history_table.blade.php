<div style="overflow-x:auto;">
<table style="width:100%; border-collapse:collapse; font-family:'Lato',sans-serif;">
    <thead>
        <tr style="background:linear-gradient(135deg,#0D0D0D,#1C1C17);">
            <th style="padding:13px 16px 13px 20px; font-size:0.68rem; font-weight:700; letter-spacing:0.12em; text-transform:uppercase; color:rgba(201,168,76,0.85); border:none;">Tanggal</th>
            <th style="padding:13px 16px; font-size:0.68rem; font-weight:700; letter-spacing:0.12em; text-transform:uppercase; color:rgba(201,168,76,0.85);">Pelanggan</th>
            <th style="padding:13px 16px; font-size:0.68rem; font-weight:700; letter-spacing:0.12em; text-transform:uppercase; color:rgba(201,168,76,0.85);">Total</th>
            <th style="padding:13px 16px; font-size:0.68rem; font-weight:700; letter-spacing:0.12em; text-transform:uppercase; color:rgba(201,168,76,0.85);">Status Pesanan</th>
            <th style="padding:13px 16px; font-size:0.68rem; font-weight:700; letter-spacing:0.12em; text-transform:uppercase; color:rgba(201,168,76,0.85);">Status Bayar</th>
            <th style="padding:13px 16px; font-size:0.68rem; font-weight:700; letter-spacing:0.12em; text-transform:uppercase; color:rgba(201,168,76,0.85); text-align:center;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($orders as $o)
        <tr id="order-row-{{ $o->id }}" style="border-bottom:1px solid #F0EAE0; transition:background 0.2s;" onmouseover="this.style.background='#F5EDD8'" onmouseout="this.style.background='transparent'">
            <td style="padding:13px 16px 13px 20px; vertical-align:middle;">
                <div style="font-weight:700; font-size:0.85rem; color:#0D0D0D;">{{ $o->created_at->format('d M Y') }}</div>
                <div style="font-size:0.72rem; color:#6B6560;">{{ $o->created_at->format('H:i') }} WIB</div>
            </td>
            <td style="padding:13px 16px; vertical-align:middle;">
                <div style="font-family:'Playfair Display',serif; font-size:0.9rem; font-weight:600; color:#0D0D0D; margin-bottom:3px;">{{ $o->customer_name }}</div>
                @if($o->member)
                    <span style="background:rgba(201,168,76,0.15); color:#8B6914; border:1px solid rgba(201,168,76,0.3); font-size:0.65rem; font-weight:700; padding:2px 8px; border-radius:2px; letter-spacing:0.08em;"><i class="fa-solid fa-crown"></i> Member</span>
                @else
                    <span style="background:rgba(107,101,96,0.1); color:#6B6560; font-size:0.65rem; font-weight:700; padding:2px 8px; border-radius:2px; letter-spacing:0.06em;">Non-Member</span>
                @endif
            </td>
            <td style="padding:13px 16px; vertical-align:middle;">
                <div style="font-family:'Playfair Display',serif; font-size:0.95rem; font-weight:700; color:#8B6914;">Rp {{ number_format($o->final_total, 0, ',', '.') }}</div>
                <div style="font-size:0.72rem; color:#6B6560;">{{ $o->details->sum('quantity') }} item</div>
                @if($o->claimed_reward_name)
                <div style="font-size:0.68rem; color:#1C7C54; margin-top:4px; font-weight:700;"><i class="fa-solid fa-gift"></i> {{ $o->claimed_reward_name }}</div>
                @endif
            </td>
            <td style="padding:13px 16px; vertical-align:middle;">
                <select class="select-order-status" data-id="{{ $o->id }}"
                        style="border:1px solid #E2D9CC; border-radius:3px; padding:6px 10px; font-family:'Lato',sans-serif; font-size:0.78rem; font-weight:700; outline:none; background:#fff; cursor:pointer; transition:border-color 0.3s;"
                        onfocus="this.style.borderColor='#C9A84C';" onblur="this.style.borderColor='#E2D9CC';">
                    <option value="pending"    {{ $o->order_status=='pending'    ?'selected':'' }}>Pending</option>
                    <option value="diproses"   {{ $o->order_status=='diproses'   ?'selected':'' }}>Diproses</option>
                    <option value="selesai"    {{ $o->order_status=='selesai'    ?'selected':'' }}>Selesai</option>
                    <option value="dibatalkan" {{ $o->order_status=='dibatalkan' ?'selected':'' }}>Dibatalkan</option>
                </select>
            </td>
            <td style="padding:13px 16px; vertical-align:middle;">
                <select class="select-payment-status" data-id="{{ $o->id }}" data-total="{{ $o->final_total }}"
                        style="border:1px solid #E2D9CC; border-radius:3px; padding:6px 10px; font-family:'Lato',sans-serif; font-size:0.78rem; font-weight:700; outline:none; background:#fff; cursor:pointer; transition:border-color 0.3s;"
                        onfocus="this.style.borderColor='#C9A84C';" onblur="this.style.borderColor='#E2D9CC';">
                    <option value="pending" {{ $o->payment_status=='pending' ?'selected':'' }}>Pending</option>
                    <option value="lunas"   {{ $o->payment_status=='lunas'   ?'selected':'' }}>Lunas</option>
                    <option value="gagal"   {{ $o->payment_status=='gagal'   ?'selected':'' }}>Gagal</option>
                </select>
            </td>
            <td style="padding:13px 16px; vertical-align:middle; text-align:center; white-space:nowrap;">
                <!-- Detail -->
                <button data-bs-toggle="modal" data-bs-target="#detailModal{{ $o->id }}"
                        style="border:1.5px solid rgba(26,70,136,0.35); color:#1A4688; background:transparent; padding:5px 10px; border-radius:3px; cursor:pointer; font-size:0.82rem; transition:all 0.25s; margin-right:4px;"
                        onmouseover="this.style.background='rgba(26,70,136,0.1)';" onmouseout="this.style.background='transparent';" title="Lihat Detail">
                    <i class="fa-solid fa-eye"></i>
                </button>
                <!-- Hapus -->
                <button class="btn-delete-order" data-id="{{ $o->id }}"
                        style="border:1.5px solid rgba(107,45,62,0.35); color:#6B2D3E; background:transparent; padding:5px 10px; border-radius:3px; cursor:pointer; font-size:0.82rem; transition:all 0.25s;"
                        onmouseover="this.style.background='rgba(107,45,62,0.1)';" onmouseout="this.style.background='transparent';" title="Hapus">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </td>
        </tr>

        <!-- Detail Modal -->
        <div class="modal fade" id="detailModal{{ $o->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered" style="max-width:480px;">
                <div class="modal-content" style="border:none; border-radius:6px; overflow:hidden; box-shadow:0 24px 60px rgba(0,0,0,0.35);">
                    <div style="background:linear-gradient(135deg,#0D0D0D,#1C1C17); padding:18px 24px; position:relative;">
                        <div style="position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,#C9A84C,#8B6914,#C9A84C);"></div>
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <div>
                                <div style="font-family:'Lato',sans-serif; font-size:0.6rem; letter-spacing:0.2em; text-transform:uppercase; color:rgba(201,168,76,0.6); margin-bottom:4px;">Detail Transaksi</div>
                                <h5 style="font-family:'Playfair Display',serif; color:#fff; margin:0; font-size:1rem;">{{ $o->transaction_code }}</h5>
                                <div style="font-family:'Lato',sans-serif; font-size:0.75rem; color:rgba(255,255,255,0.5); margin-top:3px;">{{ $o->customer_name }}</div>
                            </div>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                    </div>
                    <div style="background:#fff; padding:20px 24px;">
                        @foreach($o->details as $d)
                        <div style="display:flex; justify-content:space-between; padding:9px 0; border-bottom:1px solid #F0EAE0;">
                            <div>
                                <div style="font-family:'Playfair Display',serif; color:#0D0D0D; font-size:0.9rem; font-weight:600;">{{ $d->product_name }}</div>
                                <div style="font-family:'Lato',sans-serif; font-size:0.72rem; color:#6B6560;">{{ $d->quantity }} × Rp {{ number_format($d->unit_price, 0, ',', '.') }}</div>
                            </div>
                            <div style="font-family:'Lato',sans-serif; font-size:0.85rem; font-weight:700; color:#8B6914;">Rp {{ number_format($d->final_subtotal, 0, ',', '.') }}</div>
                        </div>
                        @endforeach
                        <div style="margin-top:14px; padding-top:10px; border-top:2px solid #E2D9CC;">
                            @if($o->discount > 0)
                            <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
                                <span style="font-family:'Lato',sans-serif; font-size:0.82rem; color:#1C7C54;"><i class="fa-solid fa-tag"></i> Diskon Member</span>
                                <span style="font-family:'Lato',sans-serif; font-size:0.85rem; color:#1C7C54; font-weight:700;">- Rp {{ number_format($o->discount, 0, ',', '.') }}</span>
                            </div>
                            @endif
                            @if($o->claimed_reward_name)
                            <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
                                <span style="font-family:'Lato',sans-serif; font-size:0.82rem; color:#1C7C54;"><i class="fa-solid fa-gift"></i> Hadiah Ditukar</span>
                                <span style="font-family:'Lato',sans-serif; font-size:0.85rem; color:#1C7C54; font-weight:700;">{{ $o->claimed_reward_name }}</span>
                            </div>
                            @endif
                            <div style="display:flex; justify-content:space-between; align-items:center;">
                                <span style="font-family:'Lato',sans-serif; font-size:0.78rem; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:#6B6560;">Total Akhir</span>
                                <div>
                                    <span style="font-family:'Lato',sans-serif; font-size:0.72rem; color:#8B6914; font-weight:700;">Rp</span>
                                    <span style="font-family:'Playfair Display',serif; font-size:1.3rem; font-weight:700; color:#8B6914;">{{ number_format($o->final_total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <tr>
            <td colspan="6" style="padding:60px 20px; text-align:center;">
                <i class="fa-solid fa-receipt" style="font-size:3rem; color:#E2D9CC; display:block; margin-bottom:12px;"></i>
                <div style="font-family:'Playfair Display',serif; font-size:1.1rem; color:#6B6560;">Tidak ditemukan transaksi</div>
                <div style="font-family:'Lato',sans-serif; font-size:0.8rem; color:#9E9690; margin-top:4px;">Coba ubah filter pencarian Anda.</div>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
</div>
