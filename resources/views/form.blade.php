<form action="{{ route('mikrotik-vpn.generate') }}" method="POST">
    @csrf

    <div class="form-group">
        <label for="server">Server</label>
        <input type="text" name="server" id="server" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="port">Port</label>
        <input type="number" name="port" id="port" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="protocol">Protocol</label>
        <select name="protocol" id="protocol" class="form-control" required>
            <option value="udp">UDP</option>
            <option value="tcp">TCP</option>
        </select>
    </div>

    <div class="form-group">
        <label for="dev">Device</label>
        <input type="text" name="dev" id="dev" class="form-control" value="tun" required>
    </div>

    <div class="form-group">
        <label for="cipher">Cipher</label>
        <select name="cipher" id="cipher" class="form-control" required>
            <option value="AES-256-CBC">AES-256-CBC</option>
            <option value="AES-128-CBC">AES-128-CBC</option>
            <option value="DES-EDE3-CBC">DES-EDE3-CBC</option>
        </select>
    </div>

    <div class="form-group">
        <label for="auth">Authentication</label>
        <select name="auth" id="auth" class="form-control" required>
            <option value="SHA256">SHA256</option>
            <option value="SHA1">SHA1</option>
            <option value="MD5">MD5</option>
        </select>
    </div>

    <div class="form-group">
        <label for="dh">Diffie-Hellman parameters</label>
        <input type="text" name="dh" id="dh" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="ca">CA certificate</label>
        <textarea name="ca" id="ca" class="form-control" rows="5" required></textarea>
    </div>

    <div class="form-group">
        <label for="cert">Client certificate</label>
        <textarea name="cert" id="cert" class="form-control" rows="5" required></textarea>
    </div>

    <div class="form-group">
        <label for="key">Client key</label>
        <textarea name="key" id="key" class="form-control" rows="5" required></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Generate Configuration</button>
</form>
