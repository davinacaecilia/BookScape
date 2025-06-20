<div id="addressModalOverlay" class="modal-overlay">
    <form id="addressForm" class="address-modal" action="{{ route('alamats.store') }}"
        onsubmit="event.preventDefault(); saveAddress();">
        @csrf

        <div class="modal-header">
            <h3>Alamat Pengiriman</h3>
            <button type="button" class="close-modal-btn">&times;</button>
        </div>

        <div class="modal-body">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" value="{{ auth()->user()->name }}" readonly>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" value="{{ auth()->user()->email }}" readonly>
            </div>

            <div class="form-group">
                <label for="noTelp">No. Telp</label>
                <input type="tel" id="noTelp" name="phone" placeholder="+62" required>
            </div>
            <div class="form-group">
                <label for="alamatLengkap">Alamat Pengiriman</label>
                <textarea id="alamatLengkap" name="address" rows="4"
                    placeholder="Detail alamat, nama jalan, nomor rumah, RT/RW" required></textarea>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn-save-address">Simpan Alamat</button>
        </div>
    </form>
</div>